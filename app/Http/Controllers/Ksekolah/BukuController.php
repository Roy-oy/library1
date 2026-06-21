<?php

namespace App\Http\Controllers\Ksekolah;

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
        $rak = $request->input('rak');

        $query = Buku::with('kategoriBuku');

        if ($q) {
            $query->where(function($query) use ($q) {
                $query->where('judul_buku', 'LIKE', "%{$q}%")
                      ->orWhere('pengarang', 'LIKE', "%{$q}%")
                      ->orWhere('kode_buku', 'LIKE', "%{$q}%")
                      ->orWhere('isbn', 'LIKE', "%{$q}%")
                      ->orWhere('rak', 'LIKE', "%{$q}%");
            });
        }

        if ($kategoriId) {
            $query->where('id_kategori', $kategoriId);
        }

        if ($sumber) {
            $query->where('sumber_buku', $sumber);
        }

        if ($rak) {
            $query->where('rak', $rak);
        }

        $buku = $query->paginate(12)->withQueryString();
        $categories = KategoriBuku::orderBy('nama_kategori')->get();
        $raks = Buku::select('rak')->whereNotNull('rak')->where('rak', '!=', '')->distinct()->orderBy('rak')->pluck('rak');

        return view('ksekolah.buku.index', compact('buku', 'categories', 'raks'));
    }
}
