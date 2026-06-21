<?php

namespace App\Http\Controllers\Kperpus;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OfficerController extends Controller
{
    /**
     * Tampilkan daftar petugas (Penjaga Perpustakaan).
     */
    public function index()
    {
        $officers = User::whereIn('role', ['penjaga_perpustakaan', 'kepala_sekolah'])->latest()->get();
        return view('kperpus.petugas.index', compact('officers'));
    }

    /**
     * Form tambah petugas.
     */
    public function create()
    {
        return view('kperpus.petugas.create');
    }

    /**
     * Simpan petugas baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:penjaga_perpustakaan,kepala_sekolah',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        return redirect()->route('kperpus.petugas.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Form edit petugas.
     */
    public function edit(User $petuga)
    {
        return view('kperpus.petugas.edit', ['officer' => $petuga]);
    }

    /**
     * Update data petugas.
     */
    public function update(Request $request, User $petuga)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $petuga->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:penjaga_perpustakaan,kepala_sekolah',
            'is_active' => 'required|boolean',
        ]);

        $petuga->name = $request->name;
        $petuga->username = $request->username;
        $petuga->role = $request->role;
        $petuga->is_active = $request->is_active;

        if ($request->filled('password')) {
            $petuga->password = Hash::make($request->password);
        }

        $petuga->save();

        return redirect()->route('kperpus.petugas.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Hapus petugas.
     */
    public function destroy(User $petuga)
    {
        $petuga->delete();
        return redirect()->route('kperpus.petugas.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
