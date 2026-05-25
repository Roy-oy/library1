<?php

namespace App\Http\Controllers\Pperpus;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $kategoriId = $request->input('kategori');
        $sumber = $request->input('sumber');

        $query = Buku::with('kategoriBuku');

        if ($q) {
            $query->where(function($query) use ($q) {
                $query->where('judul_buku', 'LIKE', "%{$q}%")
                      ->orWhere('pengarang', 'LIKE', "%{$q}%")
                      ->orWhere('kode_buku', 'LIKE', "%{$q}%")
                      ->orWhere('isbn', 'LIKE', "%{$q}%");
            });
        }

        if ($kategoriId) {
            $query->where('id_kategori', $kategoriId);
        }

        if ($sumber) {
            $query->where('sumber_buku', $sumber);
        }

        $buku = $query->paginate(12)->withQueryString();
        $categories = KategoriBuku::orderBy('nama_kategori')->get();

        return view('pperpus.buku.index', compact('buku', 'categories'));
    }
}
