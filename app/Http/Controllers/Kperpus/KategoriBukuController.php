<?php

namespace App\Http\Controllers\Kperpus;

use App\Http\Controllers\Controller;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriBukuController extends Controller
{
    public function index()
    {
        $kategori = KategoriBuku::with('bukus')->latest()->paginate(10);

        foreach ($kategori as $item) {
            $bukuIds = $item->bukus->pluck('id_buku')->toArray();
            $item->total_buku = count($bukuIds);
            
            if (!empty($bukuIds)) {
                $item->jumlah_dipinjam = \App\Models\DetailPeminjaman::whereIn('id_buku', $bukuIds)
                    ->whereIn('status_detail', ['dipinjam', 'terlambat'])
                    ->count();
            } else {
                $item->jumlah_dipinjam = 0;
            }
        }

        return view('kperpus.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kperpus.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        KategoriBuku::create($request->only('nama_kategori'));

        return redirect()->route('kperpus.kategori.index')
                         ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(KategoriBuku $kategori)
    {
        return view('kperpus.kategori.edit', [
            'kategoriBuku' => $kategori
        ]);
    }

    public function update(Request $request, KategoriBuku $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        $kategori->update($request->only('nama_kategori'));

        return redirect()->route('kperpus.kategori.index')
                         ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(KategoriBuku $kategori)
    {
        $kategori->delete();

        return redirect()->route('kperpus.kategori.index')
                         ->with('success', 'Kategori berhasil dihapus');
    }
}