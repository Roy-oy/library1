<?php

namespace App\Http\Controllers\Pperpus;

use App\Http\Controllers\Controller;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportDendaController extends Controller
{
    /**
     * Tampilkan halaman laporan denda dengan filter.
     */
    public function index(Request $request)
    {
        $query = DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->where('jumlah_denda', '>', 0);

        // Filter Rentang Tanggal (berdasarkan tanggal kembali/transaksi denda muncul)
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_kembali', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_kembali', '<=', $request->end_date);
        }

        // Filter Status Denda
        if ($request->filled('status')) {
            $query->where('status_denda', $request->status);
        }

        $reports = $query->latest('tanggal_kembali')->get();

        return view('pperpus.report.denda.index', compact('reports'));
    }

    /**
     * Export laporan denda ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->where('jumlah_denda', '>', 0);

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_kembali', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_kembali', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status_denda', $request->status);
        }

        $reports = $query->latest('tanggal_kembali')->get();
        
        $pdf = Pdf::loadView('pperpus.report.denda.pdf', [
            'reports'    => $reports,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'status'     => $request->status,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-denda-' . now()->format('YmdHis') . '.pdf');
    }
}
