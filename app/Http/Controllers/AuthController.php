<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('username', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Akun Anda tidak aktif. Hubungi administrator.'], 401);
                }
                return back()->withErrors(['username' => 'Akun Anda tidak aktif. Hubungi administrator.']);
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'redirect' => route($user->getDashboardRoute())]);
            }
            return redirect()->route($user->getDashboardRoute())
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Username atau password yang Anda masukkan salah.'], 401);
        }
        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}