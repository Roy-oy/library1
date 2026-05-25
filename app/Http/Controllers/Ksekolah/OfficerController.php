<?php

namespace App\Http\Controllers\Ksekolah;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    /**
     * Lihat daftar petugas perpustakaan.
     */
    public function index()
    {
        $officers = User::whereIn('role', ['penjaga_perpustakaan', 'kepala_perpustakaan'])
            ->orderBy('role')
            ->get();

        return view('ksekolah.petugas.index', compact('officers'));
    }
}
