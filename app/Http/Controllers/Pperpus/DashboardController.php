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
        // ── 1. Statistik Siswa ───────────────────────────────────
        $stats['total_siswa'] = Siswa::count();
        $stats['siswa_aktif'] = Siswa::where('status', 'aktif')->count();

        // ── 2. Statistik Buku ────────────────────────────────────
        $stats['total_buku'] = Buku::count();
        $stats['total_stok'] = Buku::sum('stok');

        // ── 3. Statistik Peminjaman & Keterlambatan ───────────────
        $stats['peminjaman_hari_ini'] = Peminjaman::whereDate('tanggal_pinjam', Carbon::today())->count();
        $stats['buku_dipinjam_hari_ini'] = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->whereDate('tanggal_pinjam', Carbon::today());
        })->count();
        $stats['peminjaman_aktif'] = Peminjaman::where('status_peminjaman', 'dipinjam')->count();
        $stats['buku_terlambat']   = DetailPeminjaman::where('status_detail', 'terlambat')->count();

        // ── 4. Statistik Denda ───────────────────────────────────
        $stats['denda_belum_lunas'] = DetailPeminjaman::where('status_denda', 'belum_lunas')->sum('jumlah_denda');
        $stats['denda_lunas']       = DetailPeminjaman::where('status_denda', 'lunas')->sum('jumlah_denda');
        $stats['total_denda_grand'] = DetailPeminjaman::whereIn('status_denda', ['lunas', 'belum_lunas'])->sum('jumlah_denda');

        // ── 5. Data Chart Peminjaman Buku (7 Hari Terakhir) ───────
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

        // ── 6. Tabel Denda Lunas & Belum Lunas ────────────────────
        $fines = DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->where('jumlah_denda', '>', 0)
            ->latest('updated_at')
            ->paginate(10, ['*'], 'fines_page')
            ->withQueryString();

        return view('pperpus.dashboard', compact('stats', 'borrowingsLast7Days', 'fines'));
    }
}