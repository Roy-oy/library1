<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
        'is_active',
        'foto_profile',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password'  => 'hashed',
        'is_active' => 'boolean',
    ];

    
    public function isKepalaSekolah(): bool
    {
        return $this->role === 'kepala_sekolah';
    }

    public function isKepalaP(): bool
    {
        return $this->role === 'kepala_perpustakaan';
    }

    public function isPenjaga(): bool
    {
        return $this->role === 'penjaga_perpustakaan';
    }

    public function getRoleLabel(): string
    {
        return match ($this->role) {
            'kepala_sekolah'       => 'Kepala Sekolah',
            'kepala_perpustakaan'  => 'Kepala Perpustakaan',
            'penjaga_perpustakaan' => 'Penjaga Perpustakaan',
            default                => 'Unknown',
        };
    }

    public function getDashboardRoute(): string
    {
        return match ($this->role) {
            'kepala_sekolah'       => 'ksekolah.dashboard',
            'kepala_perpustakaan'  => 'kperpus.dashboard',
            'penjaga_perpustakaan' => 'pperpus.dashboard',
            default                => 'login',
        };
    }
}