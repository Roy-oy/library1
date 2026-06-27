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
        
        $stats = [
            'total_buku'        => \App\Models\Buku::count(),
            'buku_bos'          => \App\Models\Buku::bos()->count(),
            'buku_perpustakaan' => \App\Models\Buku::perpus()->count(),
            'total_siswa'       => \App\Models\Siswa::count(),
            'peminjaman_aktif'  => \App\Models\Peminjaman::where('status_peminjaman', 'dipinjam')->count(),
            'terlambat'         => \App\Models\DetailPeminjaman::where('status_detail', 'terlambat')->count(),
            'total_penjaga'     => User::where('role', 'penjaga_perpustakaan')->count(),
            'peminjaman_hari'   => \App\Models\Peminjaman::whereDate('tanggal_pinjam', now())->count(),
            'pengembalian_hari' => \App\Models\DetailPeminjaman::whereDate('tanggal_kembali', now())->count(),
        ];

        
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

        
        $stats['denda_belum_lunas'] = DetailPeminjaman::where('status_denda', 'belum_lunas')->sum('jumlah_denda');
        $stats['denda_lunas']       = DetailPeminjaman::where('status_denda', 'lunas')->sum('jumlah_denda');
        $stats['total_denda_grand'] = DetailPeminjaman::whereIn('status_denda', ['lunas', 'belum_lunas'])->sum('jumlah_denda');

        
        $topStudents = \App\Models\Siswa::select('siswa.id_siswa', 'siswa.nis', 'siswa.nama_siswa', 'siswa.kelas')
            ->join('peminjaman', 'siswa.id_siswa', '=', 'peminjaman.id_siswa')
            ->join('detail_peminjaman', 'peminjaman.id_peminjaman', '=', 'detail_peminjaman.id_peminjaman')
            ->where('detail_peminjaman.sumber_buku', 'buku perpus')
            ->selectRaw('count(detail_peminjaman.id_detail) as total_buku_dipinjam')
            ->groupBy('siswa.id_siswa', 'siswa.nis', 'siswa.nama_siswa', 'siswa.kelas')
            ->orderByDesc('total_buku_dipinjam')
            ->take(5)
            ->get();

        
        $topBooks = \App\Models\Buku::select('buku.id_buku', 'buku.judul_buku', 'buku.gambar', 'buku.pengarang')
            ->join('detail_peminjaman', 'buku.id_buku', '=', 'detail_peminjaman.id_buku')
            ->where('detail_peminjaman.sumber_buku', 'buku perpus')
            ->selectRaw('count(detail_peminjaman.id_detail) as total_dipinjam')
            ->groupBy('buku.id_buku', 'buku.judul_buku', 'buku.gambar', 'buku.pengarang')
            ->orderByDesc('total_dipinjam')
            ->take(10)
            ->get();

        return view('kperpus.dashboard', compact('stats', 'borrowingsLast7Days', 'topStudents', 'topBooks'));
    }
}