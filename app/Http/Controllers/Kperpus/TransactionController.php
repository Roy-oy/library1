<?php

namespace App\Http\Controllers\Kperpus;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    
    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with(['siswa', 'details.buku']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('siswa', function($s) use ($q) {
                $s->where('nama_siswa', 'like', "%$q%")->orWhere('nis', 'like', "%$q%");
            })->orWhere('kode_peminjaman', 'like', "%$q%");
        }

        $transactions = $query->latest()->paginate(15);
        return view('kperpus.peminjaman.index', compact('transactions'));
    }

    
    public function pengembalian(Request $request)
    {
        $query = DetailPeminjaman::with(['peminjaman.siswa', 'buku'])
            ->whereNotNull('tanggal_kembali');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->whereHas('peminjaman.siswa', function($s) use ($q) {
                $s->where('nama_siswa', 'like', "%$q%")->orWhere('nis', 'like', "%$q%");
            })->orWhereHas('buku', function($b) use ($q) {
                $b->where('judul_buku', 'like', "%$q%");
            });
        }

        $returns = $query->latest('tanggal_kembali')->paginate(15);
        return view('kperpus.pengembalian.index', compact('returns'));
    }
}
