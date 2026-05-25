<?php

namespace App\Http\Controllers\Ksekolah;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Lihat daftar koleksi buku perpustakaan.
     */
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('judul_buku', 'like', "%$q%")
                    ->orWhere('kode_buku', 'like', "%$q%")
                    ->orWhere('penulis', 'like', "%$q%")
                    ->orWhere('penerbit', 'like', "%$q%");
            });
        }

        if ($request->filled('sumber')) {
            $query->where('sumber_buku', $request->sumber);
        }

        $books = $query->latest()->paginate(15);

        return view('ksekolah.buku.index', compact('books'));
    }
}
