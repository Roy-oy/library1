<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'kode_buku',
        'judul_buku',
        'pengarang',
        'tahun_terbit',
        'isbn',
        'stok',
        'gambar',
        'status_buku',
        'id_kategori',
        'kelas',
        'sumber_buku',
    ];

    // Relasi ke Kategori Buku
    public function kategoriBuku()
    {
        return $this->belongsTo(KategoriBuku::class, 'id_kategori', 'id_kategori');
    }

    /** Alias untuk kategoriBuku */
    public function kategori()
    {
        return $this->kategoriBuku();
    }

    // Scope untuk sumber buku
    public function scopeBos($query)
    {
        return $query->where('sumber_buku', 'bos');
    }

    public function scopePerpus($query)
    {
        return $query->where('sumber_buku', 'buku perpus');
    }

    /**
     * Generate kode buku otomatis secara berurutan berdasarkan sumber buku.
     * Prefix: BP- untuk 'buku perpus', BOS- untuk 'bos'.
     * Contoh: BP-0001, BOS-0001.
     */
    public static function generateKode(string $sumber): string
    {
        $prefix = ($sumber === 'bos') ? 'BOS-' : 'BP-';

        // Ambil kode terakhir yang berawalan sesuai prefix
        $last = static::where('kode_buku', 'like', "{$prefix}%")
            ->orderBy('kode_buku', 'desc')
            ->value('kode_buku');

        if ($last) {
            // Ekstrak angka dari kode buku (misal: BP-0001 -> 1)
            $num = (int) substr($last, strlen($prefix));
            $next = $num + 1;
        } else {
            $next = 1;
        }

        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}