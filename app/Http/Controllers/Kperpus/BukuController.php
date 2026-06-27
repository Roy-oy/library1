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
        $kategori_filter = $request->query('kategori');
        $kelas_filter = $request->query('kelas');
        $search = $request->query('search');

        $query = Buku::with('kategoriBuku')->latest();

        if ($type === 'bos') {
            $query->where('sumber_buku', 'bos');
            if ($kelas_filter) {
                $query->where('kelas', $kelas_filter);
            }
            $pageTitle = 'Data Buku BOS';
        } else {
            $query->where('sumber_buku', 'buku perpus');
            if ($kategori_filter) {
                $query->where('id_kategori', $kategori_filter);
            }
            $pageTitle = 'Data Buku Perpus';
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul_buku', 'LIKE', "%{$search}%")
                  ->orWhere('pengarang', 'LIKE', "%{$search}%")
                  ->orWhere('kode_buku', 'LIKE', "%{$search}%")
                  ->orWhere('isbn', 'LIKE', "%{$search}%")
                  ->orWhere('rak', 'LIKE', "%{$search}%");
            });
        }

        $buku = $query->paginate(10)->withQueryString();
        $kategori_list = KategoriBuku::all();
        
        return view('kperpus.buku.index', compact('buku', 'type', 'pageTitle', 'kategori_list', 'kategori_filter', 'kelas_filter'));
    }

    public function create(Request $request)
    {
        $kategori = KategoriBuku::all();
        $preSelectedSource = $request->query('sumber_buku', 'buku perpus');
        return view('kperpus.buku.create', compact('kategori', 'preSelectedSource'));
    }

    
    public function getGeneratedKode(Request $request)
    {
        $sumber = $request->query('sumber', 'buku perpus');
        $id_kategori = $request->query('id_kategori');
        $code = Buku::generateKode($sumber, $id_kategori);
        $prefix = Buku::getPrefix($sumber, $id_kategori);
        return response()->json(['code' => $code, 'prefix' => $prefix]);
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
            'rak'           => 'nullable|string',
            'sumber_buku'   => 'required|in:bos,buku perpus',
            'id_kategori'   => 'nullable|exists:kategori_buku,id_kategori',
            'kelas'         => 'nullable|in:VII,VIII,IX',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        
        if ($request->sumber_buku === 'bos' && empty($request->kelas)) {
            return back()->withErrors(['kelas' => 'Kelas wajib diisi untuk Buku BOS'])->withInput();
        }
        
        if ($request->sumber_buku === 'buku perpus' && empty($request->id_kategori)) {
            return back()->withErrors(['id_kategori' => 'Kategori wajib diisi untuk Buku Perpus'])->withInput();
        }

        
        $expectedPrefix = Buku::getPrefix($request->sumber_buku, $request->id_kategori);
        if (!str_starts_with($request->kode_buku, $expectedPrefix)) {
            return back()->withErrors([
                'kode_buku' => "Kode Buku harus diawali dengan '{$expectedPrefix}' berdasarkan kategori yang dipilih."
            ])->withInput();
        }

        $data = $request->except('gambar');

        
        if ($request->sumber_buku === 'bos') {
            $data['id_kategori'] = null;
        } else {
            $data['kelas'] = null;
        }

        
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
            'rak'           => 'nullable|string',
            'sumber_buku'   => 'required|in:bos,buku perpus',
            'id_kategori'   => 'nullable|exists:kategori_buku,id_kategori',
            'kelas'         => 'nullable|in:VII,VIII,IX',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        
        if ($request->sumber_buku !== $buku->sumber_buku) {
            return back()->withErrors(['sumber_buku' => 'Sumber buku tidak dapat diubah setelah buku dibuat.'])->withInput();
        }

        
        if ($request->sumber_buku === 'bos' && empty($request->kelas)) {
            return back()->withErrors(['kelas' => 'Kelas wajib diisi untuk Buku BOS'])->withInput();
        }
        if ($request->sumber_buku === 'buku perpus' && empty($request->id_kategori)) {
            return back()->withErrors(['id_kategori' => 'Kategori wajib diisi untuk Buku Perpus'])->withInput();
        }

        
        $expectedPrefix = Buku::getPrefix($buku->sumber_buku, $request->id_kategori);
        if (!str_starts_with($request->kode_buku, $expectedPrefix)) {
            return back()->withErrors([
                'kode_buku' => "Prefix kode buku harus '{$expectedPrefix}' sesuai kategori, dan tidak boleh dihapus."
            ])->withInput();
        }

        $data = $request->except('gambar');

        
        if ($request->sumber_buku === 'bos') {
            $data['id_kategori'] = null;
        } else {
            $data['kelas'] = null;
        }

        if ($request->hasFile('gambar')) {
            
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
        
        if ($buku->gambar) {
            Storage::disk('public')->delete($buku->gambar);
        }

        $buku->delete();

        return redirect()->route('kperpus.buku.index')
                         ->with('success', 'Buku berhasil dihapus');
    }
}