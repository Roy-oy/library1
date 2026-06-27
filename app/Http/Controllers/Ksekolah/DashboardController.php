<?php

namespace App\Http\Controllers\Ksekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        
        $stats = [
            'total_buku'        => \App\Models\Buku::count(),
            'total_siswa'       => \App\Models\Siswa::count(),
            'total_buku_perpus' => \App\Models\Buku::where('sumber_buku', 'buku perpus')->count(),
            'total_buku_bos'    => \App\Models\Buku::where('sumber_buku', 'bos')->count(),
        ];

        
        $borrowingsLast7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i)->format('Y-m-d');
            $label = \Carbon\Carbon::today()->subDays($i)->translatedFormat('d M');
            $borrowingsLast7Days[$date] = [
                'label' => $label,
                'count' => 0
            ];
        }

        $rawChart = \App\Models\DetailPeminjaman::join('peminjaman', 'detail_peminjaman.id_peminjaman', '=', 'peminjaman.id_peminjaman')
            ->selectRaw('peminjaman.tanggal_pinjam, count(detail_peminjaman.id_detail) as total')
            ->where('peminjaman.tanggal_pinjam', '>=', \Carbon\Carbon::today()->subDays(6)->toDateString())
            ->groupBy('peminjaman.tanggal_pinjam')
            ->get();

        foreach ($rawChart as $row) {
            $dateStr = \Carbon\Carbon::parse($row->tanggal_pinjam)->format('Y-m-d');
            if (isset($borrowingsLast7Days[$dateStr])) {
                $borrowingsLast7Days[$dateStr]['count'] = $row->total;
            }
        }

        
        $recent_activities = \App\Models\DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        
        $stats['total_denda_grand'] = \App\Models\DetailPeminjaman::whereIn('status_denda', ['lunas', 'belum_lunas'])->sum('jumlah_denda');

        
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

        return view('ksekolah.dashboard', compact('stats', 'borrowingsLast7Days', 'recent_activities', 'topStudents', 'topBooks'));
    }
}