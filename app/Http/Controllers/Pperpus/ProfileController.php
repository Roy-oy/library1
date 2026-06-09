<?php

namespace App\Http\Controllers\Pperpus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil penjaga perpustakaan.
     */
    public function index()
    {
        $user = auth()->user();
        return view('pperpus.profile.index', compact('user'));
    }

    /**
     * Perbarui data profil.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;

        if ($request->hasFile('foto_profile')) {
            if ($user->foto_profile) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profile);
            }
            $user->foto_profile = $request->file('foto_profile')->store('profiles', 'public');
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
