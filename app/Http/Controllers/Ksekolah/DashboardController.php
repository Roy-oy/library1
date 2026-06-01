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
            'total_buku_perpus' => \App\Models\Buku::where('sumber_buku', 'buku perpus')->count(),
            'total_buku_bos'    => \App\Models\Buku::where('sumber_buku', 'bos')->count(),
        ];

        // ── Data Chart Peminjaman Buku (7 Hari Terakhir) ───────
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

        // Laporan Aktivitas Terbaru (tidak lengkap, 5 teratas)
        $recent_activities = \App\Models\DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('ksekolah.dashboard', compact('stats', 'borrowingsLast7Days', 'recent_activities'));
    }
}