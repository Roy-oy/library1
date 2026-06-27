<?php

namespace App\Http\Controllers\Ksekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
        return view('ksekolah.profile.index', compact('user'));
    }

    
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'foto_profile' => ['nullable', 'image', 'max:2048'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        if ($request->hasFile('foto_profile')) {
            
            if ($user->foto_profile && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->foto_profile)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profile);
            }
            $path = $request->file('foto_profile')->store('profile_photos', 'public');
            $user->foto_profile = $path;
        }

        $user->name = $request->name;
        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
