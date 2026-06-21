<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'RAHMA RITONGA S.PD',
            'username' => 'rahma',
            'password' => Hash::make('rahma123'),
            'role'     => 'kepala_perpustakaan',
            'is_active' => true,
        ]);
    }
}