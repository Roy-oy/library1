<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Siswa;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportAktivitasController extends Controller
{
    private function getFilteredAktivitas(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $sumberBuku = $request->input('sumber_buku', 'buku perpus');
        $kelasFilter = $request->input('kelas');
        $kategoriFilter = $request->input('kategori');
        $statusFilter = $request->input('status');

        $query = DetailPeminjaman::with(['peminjaman.siswa', 'buku.kategoriBuku'])
            ->where('sumber_buku', $sumberBuku)
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereHas('peminjaman', function($q2) use ($startDate, $endDate) {
                    $q2->whereBetween('tanggal_pinjam', [$startDate, $endDate]);
                })->orWhereBetween('tanggal_kembali', [$startDate, $endDate]);
            });

        if ($sumberBuku === 'bos' && !empty($kelasFilter)) {
            $query->whereHas('peminjaman.siswa', function($q) use ($kelasFilter) {
                $q->where('kelas', $kelasFilter);
            });
        } elseif ($sumberBuku === 'buku perpus' && !empty($kategoriFilter)) {
            $query->whereHas('buku', function($q) use ($kategoriFilter) {
                $q->where('id_kategori', $kategoriFilter);
            });
        }

        if ($statusFilter === 'dipinjam') {
            $query->whereIn('status_detail', ['dipinjam', 'terlambat']);
        } elseif ($statusFilter === 'selesai') {
            $query->whereNotIn('status_detail', ['dipinjam', 'terlambat']);
        }

        $detailPeminjaman = $query->get();

        $aktivitas = $detailPeminjaman->map(function($d) {
            $kategoriNama = optional($d->buku->kategoriBuku)->nama_kategori ?? '-';
            $judulBuku = $d->buku->judul_buku ?? '-';

            return (object)[
                'kode' => $d->peminjaman->kode_peminjaman ?? '-',
                'nis' => $d->peminjaman->siswa->nis ?? '-',
                'siswa' => $d->peminjaman->siswa->nama_siswa ?? '-',
                'kelas' => $d->peminjaman->siswa->kelas ?? '-',
                'tanggal_pinjam' => optional($d->peminjaman->tanggal_pinjam)->format('Y-m-d') ?? '-',
                'tanggal_jatuh_tempo' => optional($d->tanggal_jatuh_tempo)->format('Y-m-d') ?? '-',
                'tanggal_kembali' => optional($d->tanggal_kembali)->format('Y-m-d') ?? '-',
                'kode_buku' => $d->buku->kode_buku ?? '-',
                'buku' => $judulBuku,
                'kategori' => $kategoriNama,
                'sumber_buku' => $d->sumber_buku,
                'telat' => $d->tanggal_kembali ? max(0, $d->jumlah_hari_terlambat) : $d->hari_terlambat_realtime,
                'denda' => $d->jumlah_denda > 0 ? $d->jumlah_denda : ($d->denda_realtime ?? 0),
                'status' => $d->label_status
            ];
        });

        // Sort by tanggal pinjam descending
        return $aktivitas->sortByDesc('tanggal_pinjam')->values();
    }

    /**
     * Tampilkan halaman laporan aktivitas perpustakaan.
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $sumberBuku = $request->input('sumber_buku', 'buku perpus');
        $kelasFilter = $request->input('kelas');
        $kategoriFilter = $request->input('kategori');
        $statusFilter = $request->input('status');

        $aktivitas = $this->getFilteredAktivitas($request);

        // Options for dynamic filters
        $kelases = Siswa::select('kelas')->whereNotNull('kelas')->where('kelas', '!=', '')->distinct()->orderBy('kelas')->pluck('kelas');
        $kategoris = KategoriBuku::orderBy('nama_kategori')->get();

        // Tentukan layout berdasarkan role user yang login
        $layout = match (auth()->user()->role ?? '') {
            'penjaga_perpustakaan' => 'pperpus.layouts.app',
            'kepala_perpustakaan'  => 'kperpus.layouts.app',
            'kepala_sekolah'       => 'ksekolah.layouts.app',
            default                => 'layouts.app',
        };

        return view('report.aktivitas.index', compact(
            'aktivitas', 
            'startDate', 
            'endDate',
            'sumberBuku',
            'kelasFilter',
            'kategoriFilter',
            'statusFilter',
            'kelases',
            'kategoris',
            'layout'
        ));
    }

    /**
     * Export laporan aktivitas ke PDF.
     */
    public function exportPdf(Request $request)
    {
        abort_if(auth()->user()->role === 'kepala_sekolah', 403, 'Akses ditolak: Kepala Sekolah hanya dapat melihat laporan.');

        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $sumberBuku = $request->input('sumber_buku', 'buku perpus');

        $aktivitas = $this->getFilteredAktivitas($request);
        $totalDenda = $aktivitas->sum('denda');

        $pdf = Pdf::loadView('report.aktivitas.pdf', [
            'aktivitas'     => $aktivitas,
            'startDate'     => $startDate,
            'endDate'       => $endDate,
            'sumberBuku'    => $sumberBuku,
            'totalDenda'    => $totalDenda,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-aktivitas-'.($sumberBuku === 'bos' ? 'buku-bos' : 'buku-perpus').'-' . $startDate . '-sd-' . $endDate . '.pdf');
    }

    /**
     * Export laporan aktivitas ke Excel (CSV).
     */
    public function exportExcel(Request $request)
    {
        abort_if(auth()->user()->role === 'kepala_sekolah', 403, 'Akses ditolak: Kepala Sekolah hanya dapat melihat laporan.');

        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $sumberBuku = $request->input('sumber_buku', 'buku perpus');

        $aktivitas = $this->getFilteredAktivitas($request);
        $totalDenda = $aktivitas->sum('denda');

        $filename = 'laporan-aktivitas-'.($sumberBuku === 'bos' ? 'buku-bos' : 'buku-perpus').'-' . $startDate . '-sd-' . $endDate . '.xls';

        return response()->view('report.aktivitas.excel', [
            'aktivitas'     => $aktivitas,
            'startDate'     => $startDate,
            'endDate'       => $endDate,
            'sumberBuku'    => $sumberBuku,
            'totalDenda'    => $totalDenda,
        ])->withHeaders([
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ]);
    }
}
