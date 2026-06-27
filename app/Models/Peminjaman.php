<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Peminjaman extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_siswa',
        'kode_peminjaman',
        'tanggal_pinjam',
        'status_peminjaman',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
    ];

    

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    

    public function details(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    
    public function detailPerpus(): HasMany
    {
        return $this->details()->where('sumber_buku', 'buku perpus');
    }

    
    public function detailBos(): HasMany
    {
        return $this->details()->where('sumber_buku', 'bos');
    }

    

    
    public function getTotalDendaAttribute(): int
    {
        return $this->details()->sum('jumlah_denda');
    }

    
    public function getJumlahDipinjamAttribute(): int
    {
        return $this->details()->whereIn('status_detail', ['dipinjam', 'terlambat'])->count();
    }

    
    public function getAdaTerlambatAttribute(): bool
    {
        return $this->details()->where(function ($query) {
            $query->where('status_detail', 'terlambat')
                  ->orWhere(function ($q) {
                      $q->where('status_detail', 'dipinjam')
                        ->where('sumber_buku', 'buku perpus')
                        ->whereNotNull('tanggal_jatuh_tempo')
                        ->whereDate('tanggal_jatuh_tempo', '<', now()->startOfDay());
                  });
        })->exists();
    }

    
    public function getAdaDendaBelumLunasAttribute(): bool
    {
        return $this->details()->where('status_denda', 'belum_lunas')->exists();
    }

    public static function generateKode(): string
    {
        $tanggal = now()->format('Ymd');
        $prefix  = "PJM-{$tanggal}-";

        
        $last = static::withTrashed()
            ->where('kode_peminjaman', 'like', "{$prefix}%")
            ->orderByDesc('kode_peminjaman')
            ->value('kode_peminjaman');

        $urut = $last ? ((int) substr($last, -3)) + 1 : 1;

        return $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);
    }

    public function syncStatus(): void
    {
        $this->load('details');

        $adaDipinjam  = $this->details->whereIn('status_detail', ['dipinjam', 'terlambat'])->count();
        $adaBelumLunas = $this->details->where('status_denda', 'belum_lunas')->count();

        if ($adaDipinjam > 0) {
            $this->status_peminjaman = 'dipinjam';
        } elseif ($adaBelumLunas > 0) {
            $this->status_peminjaman = 'dikembalikan';
        } else {
            $this->status_peminjaman = 'selesai';
        }

        $this->save();
    }

    public function scopeAktif($query)
    {
        return $query->where('status_peminjaman', 'dipinjam');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status_peminjaman', 'selesai');
    }

    public function scopeAdaDenda($query)
    {
        return $query->whereHas('details', fn($q) => $q->where('status_denda', 'belum_lunas'));
    }

    public function scopeByKelas($query, string $kelas)
    {
        return $query->whereHas('siswa', fn($q) => $q->where('kelas', $kelas));
    }
}