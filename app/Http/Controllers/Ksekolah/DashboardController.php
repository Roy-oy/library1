<?php

namespace App\Http\Controllers\Ksekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data statistik untuk kepala sekolah (summary/laporan)
        $stats = [
            'total_buku'        => \App\Models\Buku::count(),
            'total_siswa'       => \App\Models\Siswa::count(),
            'peminjaman_aktif'  => \App\Models\Peminjaman::where('status_peminjaman', 'dipinjam')->count(),
            'terlambat'         => \App\Models\DetailPeminjaman::where('status_detail', 'terlambat')->count(),
            'peminjaman_bulan'  => \App\Models\Peminjaman::whereMonth('tanggal_pinjam', now()->month)->count(),
        ];

        return view('ksekolah.dashboard', compact('stats'));
    }
}