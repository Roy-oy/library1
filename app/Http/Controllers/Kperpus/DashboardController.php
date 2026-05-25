<?php

namespace App\Http\Controllers\Kperpus;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

        return view('kperpus.dashboard', compact('stats'));
    }
}