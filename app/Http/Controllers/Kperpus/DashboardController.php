<?php

namespace App\Http\Controllers\Kperpus;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data statistik untuk kepala perpustakaan (manajemen penuh)
        $stats = [
            'total_buku'        => \App\Models\Buku::count(),
            'total_siswa'       => \App\Models\Siswa::count(),
            'peminjaman_aktif'  => \App\Models\Peminjaman::where('status_peminjaman', 'dipinjam')->count(),
            'terlambat'         => \App\Models\DetailPeminjaman::where('status_detail', 'terlambat')->count(),
            'total_penjaga'     => User::where('role', 'penjaga_perpustakaan')->count(),
            'peminjaman_hari'   => \App\Models\Peminjaman::whereDate('tanggal_pinjam', now())->count(),
            'pengembalian_hari' => \App\Models\DetailPeminjaman::whereDate('tanggal_kembali', now())->count(),
        ];

        // ── Data Chart Peminjaman Buku (7 Hari Terakhir) ───────
        $borrowingsLast7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $label = Carbon::today()->subDays($i)->translatedFormat('d M');
            $borrowingsLast7Days[$date] = [
                'label' => $label,
                'count' => 0
            ];
        }

        $rawChart = DetailPeminjaman::join('peminjaman', 'detail_peminjaman.id_peminjaman', '=', 'peminjaman.id_peminjaman')
            ->selectRaw('peminjaman.tanggal_pinjam, count(detail_peminjaman.id_detail) as total')
            ->where('peminjaman.tanggal_pinjam', '>=', Carbon::today()->subDays(6)->toDateString())
            ->groupBy('peminjaman.tanggal_pinjam')
            ->get();

        foreach ($rawChart as $row) {
            $dateStr = Carbon::parse($row->tanggal_pinjam)->format('Y-m-d');
            if (isset($borrowingsLast7Days[$dateStr])) {
                $borrowingsLast7Days[$dateStr]['count'] = $row->total;
            }
        }

        // ── Statistik Denda ───────────────────────────────────
        $stats['denda_belum_lunas'] = DetailPeminjaman::where('status_denda', 'belum_lunas')->sum('jumlah_denda');
        $stats['denda_lunas']       = DetailPeminjaman::where('status_denda', 'lunas')->sum('jumlah_denda');
        $stats['total_denda_grand'] = DetailPeminjaman::whereIn('status_denda', ['lunas', 'belum_lunas'])->sum('jumlah_denda');

        // ── Top 5 Buku Terpopuler ─────────────────────────────
        $topBooks = DetailPeminjaman::selectRaw('id_buku, count(id_detail) as total')
            ->groupBy('id_buku')
            ->orderByDesc('total')
            ->take(5)
            ->with('buku')
            ->get();

        // ── Top 5 Siswa Peminjam ──────────────────────────────
        $topStudents = \App\Models\Peminjaman::selectRaw('id_siswa, count(id_peminjaman) as total')
            ->groupBy('id_siswa')
            ->orderByDesc('total')
            ->take(5)
            ->with('siswa')
            ->get();

        return view('kperpus.dashboard', compact('stats', 'borrowingsLast7Days', 'topBooks', 'topStudents'));
    }
}