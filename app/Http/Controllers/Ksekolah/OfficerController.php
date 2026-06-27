<?php

namespace App\Http\Controllers\Ksekolah;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OfficerController extends Controller
{
    
    public function index()
    {
        $officers = User::whereIn('role', ['penjaga_perpustakaan', 'kepala_perpustakaan'])
            ->orderBy('role')
            ->paginate(15);

        return view('ksekolah.petugas.index', compact('officers'));
    }
}
