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

    // RELASI

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    // public function petugas() dihapus karena id_petugas dihapus

    public function details(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    /** Detail buku perpus saja */
    public function detailPerpus(): HasMany
    {
        return $this->details()->where('sumber_buku', 'buku perpus');
    }

    /** Detail buku BOS saja */
    public function detailBos(): HasMany
    {
        return $this->details()->where('sumber_buku', 'bos');
    }

    // ACCESSOR

    /** Total denda semua buku dalam transaksi ini */
    public function getTotalDendaAttribute(): int
    {
        return $this->details()->sum('jumlah_denda');
    }

    /** Jumlah buku yang masih dipinjam */
    public function getJumlahDipinjamAttribute(): int
    {
        return $this->details()->whereIn('status_detail', ['dipinjam', 'terlambat'])->count();
    }

    /** Cek apakah ada buku terlambat */
    public function getAdaTerlambatAttribute(): bool
    {
        return $this->details()->where('status_detail', 'terlambat')->exists();
    }

    /** Cek apakah ada denda belum lunas */
    public function getAdaDendaBelumLunasAttribute(): bool
    {
        return $this->details()->where('status_denda', 'belum_lunas')->exists();
    }

    // GENERATOR KODE

    /**
     * Generate kode peminjaman otomatis.
     * Format: PJM-YYYYMMDD-XXX
     * Contoh: PJM-20260511-001
     */
    public static function generateKode(): string
    {
        $tanggal = now()->format('Ymd');
        $prefix  = "PJM-{$tanggal}-";

        // Ambil nomor urut terakhir hari ini (termasuk soft-deleted)
        $last = static::withTrashed()
            ->where('kode_peminjaman', 'like', "{$prefix}%")
            ->orderByDesc('kode_peminjaman')
            ->value('kode_peminjaman');

        $urut = $last ? ((int) substr($last, -3)) + 1 : 1;

        return $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);
    }

    // SINKRONISASI STATUS PEMINJAMAN

    /**
     * Hitung ulang & simpan status_peminjaman berdasarkan status semua detail.
     *
     * - dipinjam     : masih ada buku yang belum kembali
     * - dikembalikan : semua buku kembali, tapi masih ada denda belum lunas
     * - selesai      : semua buku kembali + semua denda lunas
     */
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

    // ─────────────────────────────────────────────
    // SCOPE QUERY
    // ─────────────────────────────────────────────

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