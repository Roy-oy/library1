<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Kepala Sekolah
        User::create([
            'name'     => 'Erydawaty S.PD',
            'username' => 'kepala_sekolah',
            'password' => Hash::make('ery123'),
            'role'     => 'kepala_sekolah',
            'is_active' => true,
        ]);

        // Kepala Perpustakaan (Admin)
        User::create([
            'name'     => 'RAHMA RITONGA S.PD',
            'username' => 'rahma',
            'password' => Hash::make('rahma123'),
            'role'     => 'kepala_perpustakaan',
            'is_active' => true,
        ]);

        // Penjaga Perpustakaan
        User::create([
            'name'     => 'NURIN SYAFITRI S.PD',
            'username' => 'nurin',
            'password' => Hash::make('nurin123'),
            'role'     => 'penjaga_perpustakaan',
            'is_active' => true,
        ]);
    }
}