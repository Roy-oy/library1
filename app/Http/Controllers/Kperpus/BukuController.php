<?php

namespace App\Http\Controllers\Kperpus;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'perpus');
        $query = Buku::with('kategoriBuku')->latest();

        if ($type === 'bos') {
            $query->where('sumber_buku', 'bos');
            $pageTitle = 'Data Buku BOS';
        } else {
            $query->where('sumber_buku', 'buku perpus');
            $pageTitle = 'Data Buku Perpus';
        }

        $buku = $query->paginate(10)->withQueryString();
        
        return view('kperpus.buku.index', compact('buku', 'type', 'pageTitle'));
    }

    public function create(Request $request)
    {
        $kategori = KategoriBuku::all();
        $preSelectedSource = $request->query('sumber_buku', 'buku perpus');
        return view('kperpus.buku.create', compact('kategori', 'preSelectedSource'));
    }

    /**
     * Get generated sequential code based on book source.
     */
    public function getGeneratedKode(Request $request)
    {
        $sumber = $request->query('sumber', 'buku perpus');
        $code = Buku::generateKode($sumber);
        return response()->json(['code' => $code]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_buku'     => 'required|unique:buku,kode_buku',
            'judul_buku'    => 'required',
            'pengarang'     => 'required',
            'tahun_terbit'  => 'required|digits:4',
            'isbn'          => 'nullable|unique:buku,isbn',
            'stok'          => 'required|integer|min:1',
            'sumber_buku'   => 'required|in:bos,buku perpus',
            'id_kategori'   => 'nullable|exists:kategori_buku,id_kategori',
            'kelas'         => 'nullable|in:VII,VIII,IX',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Validasi tambahan: Jika sumber_buku bos, kelas wajib diisi
        if ($request->sumber_buku === 'bos' && empty($request->kelas)) {
            return back()->withErrors(['kelas' => 'Kelas wajib diisi untuk Buku BOS'])->withInput();
        }
        // Jika sumber_buku perpus, kategori wajib diisi
        if ($request->sumber_buku === 'buku perpus' && empty($request->id_kategori)) {
            return back()->withErrors(['id_kategori' => 'Kategori wajib diisi untuk Buku Perpus'])->withInput();
        }

        // Validasi format kode_buku: BP- untuk perpus, BOS- untuk BOS
        $prefix = ($request->sumber_buku === 'bos') ? 'BOS-' : 'BP-';
        if (!str_starts_with($request->kode_buku, $prefix)) {
            return back()->withErrors([
                'kode_buku' => "Kode Buku harus diawali dengan '{$prefix}' untuk " . ($request->sumber_buku === 'bos' ? 'Buku BOS' : 'Buku Perpus')
            ])->withInput();
        }

        $data = $request->except('gambar');

        // Bersihkan data berdasarkan sumber
        if ($request->sumber_buku === 'bos') {
            $data['id_kategori'] = null;
        } else {
            $data['kelas'] = null;
        }

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
        }

        Buku::create($data);

        $type = ($request->sumber_buku === 'bos') ? 'bos' : 'perpus';
        return redirect()->route('kperpus.buku.index', ['type' => $type])
                         ->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit(Buku $buku)
    {
        $kategori = KategoriBuku::all();
        return view('kperpus.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'kode_buku'     => 'required|unique:buku,kode_buku,' . $buku->id_buku . ',id_buku',
            'judul_buku'    => 'required',
            'pengarang'     => 'required',
            'tahun_terbit'  => 'required|digits:4',
            'isbn'          => 'nullable|unique:buku,isbn,' . $buku->id_buku . ',id_buku',
            'stok'          => 'required|integer|min:1',
            'sumber_buku'   => 'required|in:bos,buku perpus',
            'id_kategori'   => 'nullable|exists:kategori_buku,id_kategori',
            'kelas'         => 'nullable|in:VII,VIII,IX',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Enforce that sumber_buku cannot be changed
        if ($request->sumber_buku !== $buku->sumber_buku) {
            return back()->withErrors(['sumber_buku' => 'Sumber buku tidak dapat diubah setelah buku dibuat.'])->withInput();
        }

        // Validasi tambahan
        if ($request->sumber_buku === 'bos' && empty($request->kelas)) {
            return back()->withErrors(['kelas' => 'Kelas wajib diisi untuk Buku BOS'])->withInput();
        }
        if ($request->sumber_buku === 'buku perpus' && empty($request->id_kategori)) {
            return back()->withErrors(['id_kategori' => 'Kategori wajib diisi untuk Buku Perpus'])->withInput();
        }

        // Validasi format kode_buku: BP- untuk perpus, BOS- untuk BOS (tidak boleh diubah atau dihapus)
        $prefix = ($buku->sumber_buku === 'bos') ? 'BOS-' : 'BP-';
        if (!str_starts_with($request->kode_buku, $prefix)) {
            return back()->withErrors([
                'kode_buku' => "Prefix kode buku '{$prefix}' tidak boleh diubah atau dihapus."
            ])->withInput();
        }

        $data = $request->except('gambar');

        // Bersihkan data berdasarkan sumber
        if ($request->sumber_buku === 'bos') {
            $data['id_kategori'] = null;
        } else {
            $data['kelas'] = null;
        }

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($buku->gambar) {
                Storage::disk('public')->delete($buku->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('buku', 'public');
        }

        $buku->update($data);

        $type = ($request->sumber_buku === 'bos') ? 'bos' : 'perpus';
        return redirect()->route('kperpus.buku.index', ['type' => $type])
                         ->with('success', 'Data buku berhasil diperbarui');
    }

    public function destroy(Buku $buku)
    {
        // Hapus gambar dari storage
        if ($buku->gambar) {
            Storage::disk('public')->delete($buku->gambar);
        }

        $buku->delete();

        return redirect()->route('kperpus.buku.index')
                         ->with('success', 'Buku berhasil dihapus');
    }
}