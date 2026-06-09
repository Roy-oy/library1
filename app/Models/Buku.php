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
     * Dapatkan prefix kode buku berdasarkan sumber dan kategori.
     */
    public static function getPrefix(string $sumber, $id_kategori = null): string
    {
        $prefix = 'BP-'; // Default
        if ($sumber === 'bos') {
            $prefix = 'BOS-';
        } else if ($sumber === 'buku perpus' && $id_kategori) {
            $kategori = KategoriBuku::find($id_kategori);
            if ($kategori) {
                $name = strtoupper(trim($kategori->nama_kategori));
                if ($name === 'CERPEN') {
                    $prefix = 'BCP-';
                } else if ($name === 'KAMUS') {
                    $prefix = 'BKM-';
                } else {
                    $words = explode(' ', $name);
                    if (count($words) > 1) {
                        $prefix = 'B' . substr($words[0], 0, 1) . substr($words[1], 0, 1) . '-';
                    } else {
                        $consonants = preg_replace('/[^A-Z]/', '', $name);
                        $consonants = preg_replace('/[AEIOU]/', '', substr($consonants, 1));
                        $prefix = 'B' . substr($name, 0, 1) . (strlen($consonants) > 0 ? substr($consonants, 0, 1) : substr($name, 1, 1)) . '-';
                    }
                }
            }
        }
        return $prefix;
    }

    /**
     * Generate kode buku otomatis secara berurutan berdasarkan sumber buku dan kategori.
     */
    public static function generateKode(string $sumber, $id_kategori = null): string
    {
        $prefix = self::getPrefix($sumber, $id_kategori);

        // Ambil kode terakhir yang berawalan sesuai prefix
        $last = static::where('kode_buku', 'like', "{$prefix}%")
            ->orderBy('kode_buku', 'desc')
            ->value('kode_buku');

        if ($last) {
            // Ekstrak angka dari kode buku (misal: BCP-0001 -> 1)
            $num = (int) substr($last, strlen($prefix));
            $next = $num + 1;
        } else {
            $next = 1;
        }

        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}