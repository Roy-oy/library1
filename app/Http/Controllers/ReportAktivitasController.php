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

        // Data Peminjaman dalam periode
        $peminjamans = Peminjaman::with(['siswa', 'details.buku'])
            ->whereBetween('tanggal_pinjam', [$startDate, $endDate])
            ->latest('tanggal_pinjam')
            ->get();

        // Data Pengembalian dalam periode
        $pengembalians = DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->whereBetween('tanggal_kembali', [$startDate, $endDate])
            ->latest('tanggal_kembali')
            ->get();

        // Statistik Ringkas
        $stats = [
            'total_pinjam'       => $peminjamans->count(),
            'total_buku_pinjam'  => $peminjamans->sum(fn($p) => $p->details->count()),
            'total_kembali'      => $pengembalians->count(),
            'total_denda_masuk'  => $pengembalians->where('status_denda', 'lunas')->sum('jumlah_denda'),
            'total_denda_tagihan'=> $pengembalians->where('status_denda', 'belum_lunas')->sum('jumlah_denda'),
        ];

        // Tentukan layout berdasarkan role user yang login
        $layout = match (auth()->user()->role) {
            'penjaga_perpustakaan' => 'pperpus.layouts.app',
            'kepala_perpustakaan'  => 'kperpus.layouts.app',
            'kepala_sekolah'       => 'ksekolah.layouts.app',
            default                => 'layouts.app',
        };

        return view('report.aktivitas.index', compact(
            'peminjamans', 
            'pengembalians', 
            'stats', 
            'startDate', 
            'endDate',
            'layout'
        ));
    }

    /**
     * Export laporan aktivitas ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $peminjamans = Peminjaman::with(['siswa', 'details.buku'])
            ->whereBetween('tanggal_pinjam', [$startDate, $endDate])
            ->latest('tanggal_pinjam')
            ->get();

        $pengembalians = DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->whereBetween('tanggal_kembali', [$startDate, $endDate])
            ->latest('tanggal_kembali')
            ->get();

        $pdf = Pdf::loadView('report.aktivitas.pdf', [
            'peminjamans'   => $peminjamans,
            'pengembalians' => $pengembalians,
            'startDate'     => $startDate,
            'endDate'       => $endDate,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-aktivitas-perpus-' . $startDate . '-sd-' . $endDate . '.pdf');
    }
}
