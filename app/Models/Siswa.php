<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'kelas',
        'jenis_kelamin',
        'alamat',
        'status'
    ];

    
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_siswa', 'id_siswa');
    }

    
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}