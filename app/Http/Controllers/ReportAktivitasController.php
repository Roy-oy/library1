<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportAktivitasController extends Controller
{
    /**
     * Tampilkan halaman laporan aktivitas perpustakaan.
     */
    public function index(Request $request)
    {
        // Default: bulan ini
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));
        $sumberBuku = $request->input('sumber_buku', 'buku perpus'); // 'buku perpus' atau 'bos'

        $detailPeminjaman = DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->where('sumber_buku', $sumberBuku)
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereHas('peminjaman', function($q2) use ($startDate, $endDate) {
                    $q2->whereBetween('tanggal_pinjam', [$startDate, $endDate]);
                })->orWhereBetween('tanggal_kembali', [$startDate, $endDate]);
            })
            ->get();

        $aktivitas = $detailPeminjaman->map(function($d) {
            return (object)[
                'kode' => $d->peminjaman->kode_peminjaman ?? '-',
                'nis' => $d->peminjaman->siswa->nis ?? '-',
                'siswa' => $d->peminjaman->siswa->nama_siswa ?? '-',
                'kelas' => $d->peminjaman->siswa->kelas ?? '-',
                'tanggal_pinjam' => optional($d->peminjaman->tanggal_pinjam)->format('Y-m-d') ?? '-',
                'tanggal_jatuh_tempo' => optional($d->tanggal_jatuh_tempo)->format('Y-m-d') ?? '-',
                'tanggal_kembali' => optional($d->tanggal_kembali)->format('Y-m-d') ?? '-',
                'buku' => $d->buku->judul_buku ?? '-',
                'telat' => $d->tanggal_kembali ? max(0, $d->jumlah_hari_terlambat) : $d->hari_terlambat_realtime,
                'denda' => $d->jumlah_denda > 0 ? $d->jumlah_denda : ($d->denda_realtime ?? 0),
                'status' => $d->label_status
            ];
        });

        // Sort by tanggal pinjam descending
        $aktivitas = $aktivitas->sortByDesc('tanggal_pinjam')->values();

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

        $detailPeminjaman = DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->where('sumber_buku', $sumberBuku)
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereHas('peminjaman', function($q2) use ($startDate, $endDate) {
                    $q2->whereBetween('tanggal_pinjam', [$startDate, $endDate]);
                })->orWhereBetween('tanggal_kembali', [$startDate, $endDate]);
            })
            ->get();

        $aktivitas = $detailPeminjaman->map(function($d) {
            return (object)[
                'kode' => $d->peminjaman->kode_peminjaman ?? '-',
                'nis' => $d->peminjaman->siswa->nis ?? '-',
                'siswa' => $d->peminjaman->siswa->nama_siswa ?? '-',
                'kelas' => $d->peminjaman->siswa->kelas ?? '-',
                'tanggal_pinjam' => optional($d->peminjaman->tanggal_pinjam)->format('Y-m-d') ?? '-',
                'tanggal_jatuh_tempo' => optional($d->tanggal_jatuh_tempo)->format('Y-m-d') ?? '-',
                'tanggal_kembali' => optional($d->tanggal_kembali)->format('Y-m-d') ?? '-',
                'buku' => $d->buku->judul_buku ?? '-',
                'telat' => $d->tanggal_kembali ? max(0, $d->jumlah_hari_terlambat) : $d->hari_terlambat_realtime,
                'denda' => $d->jumlah_denda > 0 ? $d->jumlah_denda : ($d->denda_realtime ?? 0),
                'status' => $d->label_status
            ];
        });

        // Sort by tanggal pinjam descending
        $aktivitas = $aktivitas->sortByDesc('tanggal_pinjam')->values();

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

        $detailPeminjaman = DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->where('sumber_buku', $sumberBuku)
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereHas('peminjaman', function($q2) use ($startDate, $endDate) {
                    $q2->whereBetween('tanggal_pinjam', [$startDate, $endDate]);
                })->orWhereBetween('tanggal_kembali', [$startDate, $endDate]);
            })
            ->get();

        $aktivitas = $detailPeminjaman->map(function($d) {
            return (object)[
                'kode' => $d->peminjaman->kode_peminjaman ?? '-',
                'nis' => $d->peminjaman->siswa->nis ?? '-',
                'siswa' => $d->peminjaman->siswa->nama_siswa ?? '-',
                'kelas' => $d->peminjaman->siswa->kelas ?? '-',
                'tanggal_pinjam' => optional($d->peminjaman->tanggal_pinjam)->format('Y-m-d') ?? '-',
                'tanggal_jatuh_tempo' => optional($d->tanggal_jatuh_tempo)->format('Y-m-d') ?? '-',
                'tanggal_kembali' => optional($d->tanggal_kembali)->format('Y-m-d') ?? '-',
                'buku' => $d->buku->judul_buku ?? '-',
                'telat' => $d->tanggal_kembali ? max(0, $d->jumlah_hari_terlambat) : $d->hari_terlambat_realtime,
                'denda' => $d->jumlah_denda > 0 ? $d->jumlah_denda : ($d->denda_realtime ?? 0),
                'status' => $d->label_status
            ];
        });

        // Sort by tanggal pinjam descending
        $aktivitas = $aktivitas->sortByDesc('tanggal_pinjam')->values();

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
