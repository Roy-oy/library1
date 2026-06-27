<?php

namespace App\Http\Controllers\Pperpus;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        
        $stats['total_siswa'] = Siswa::count();
        $stats['siswa_aktif'] = Siswa::where('status', 'aktif')->count();

        
        $stats['total_buku'] = Buku::count();
        $stats['total_stok'] = Buku::sum('stok');

        
        $stats['peminjaman_hari_ini'] = Peminjaman::whereDate('tanggal_pinjam', Carbon::today())->count();
        $stats['buku_dipinjam_hari_ini'] = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->whereDate('tanggal_pinjam', Carbon::today());
        })->count();
        $stats['peminjaman_aktif'] = Peminjaman::where('status_peminjaman', 'dipinjam')->count();
        $stats['buku_terlambat']   = DetailPeminjaman::where('status_detail', 'terlambat')->count();

        
        $stats['denda_belum_lunas'] = DetailPeminjaman::where('status_denda', 'belum_lunas')->sum('jumlah_denda');
        $stats['denda_lunas']       = DetailPeminjaman::where('status_denda', 'lunas')->sum('jumlah_denda');
        $stats['total_denda_grand'] = DetailPeminjaman::whereIn('status_denda', ['lunas', 'belum_lunas'])->sum('jumlah_denda');

        
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

        
        $fines = DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->where('jumlah_denda', '>', 0)
            ->latest('updated_at')
            ->paginate(10, ['*'], 'fines_page')
            ->withQueryString();

        
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

        
        $recent_activities = DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('pperpus.dashboard', compact('stats', 'borrowingsLast7Days', 'fines', 'topStudents', 'topBooks', 'recent_activities'));
    }
}