<?php

namespace App\Http\Controllers\Kperpus;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $kelas = $request->query('kelas', 'all');
        $search = $request->query('search');

        $query = Siswa::latest();

        if ($kelas !== 'all') {
            $query->where('kelas', $kelas);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                  ->orWhere('nama_siswa', 'like', "%{$search}%");
            });
        }
        
        $siswa = $query->paginate(30)->withQueryString();
        return view('kperpus.siswa.index', compact('siswa', 'kelas', 'search'));
    }

    public function create()
    {
        return view('kperpus.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'           => 'required|unique:siswa,nis|digits_between:1,10',
            'nama_siswa'    => 'required|string|max:255',
            'kelas'         => 'required|in:VII-A,VII-B,VIII-A,VIII-B,IX-A,IX-B',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'nullable|string',
            'status'        => 'required|in:aktif,nonaktif'
        ]);

        Siswa::create($request->all());

        return redirect()->route('kperpus.siswa.index', ['kelas' => $request->kelas])
                         ->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit(Siswa $siswa)
    {
        return view('kperpus.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis'           => 'required|digits_between:1,10|unique:siswa,nis,' . $siswa->id_siswa . ',id_siswa',
            'nama_siswa'    => 'required|string|max:255',
            'kelas'         => 'required|in:VII-A,VII-B,VIII-A,VIII-B,IX-A,IX-B',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'nullable|string',
            'status'        => 'required|in:aktif,nonaktif'
        ]);

        $siswa->update($request->all());

        return redirect()->route('kperpus.siswa.index', ['kelas' => $request->kelas])
                         ->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroy(Siswa $siswa)
    {
        $kelas = $siswa->kelas;
        $siswa->delete();
        return redirect()->route('kperpus.siswa.index', ['kelas' => $kelas])
                         ->with('success', 'Data siswa berhasil dihapus');
    }
}
