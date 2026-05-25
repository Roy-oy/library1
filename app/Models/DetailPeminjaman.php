<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_peminjaman',
        'id_buku',
        'sumber_buku',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'status_detail',
        'denda_harian',
        'jumlah_hari_terlambat',
        'jumlah_denda',
        'status_denda',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_kembali'     => 'date',
        'denda_harian'        => 'integer',
        'jumlah_hari_terlambat' => 'integer',
        'jumlah_denda'        => 'integer',
    ];

    // ─────────────────────────────────────────────
    // KONSTANTA
    // ─────────────────────────────────────────────

    const DENDA_HARIAN_PERPUS = 1000; // Rp1.000/hari
    const DENDA_HARIAN_BOS    = 0;    // tidak ada denda keterlambatan
    const MASA_PINJAM_PERPUS  = 7;    // hari

    // ─────────────────────────────────────────────
    // RELASI
    // ─────────────────────────────────────────────

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    // ─────────────────────────────────────────────
    // ACCESSOR
    // ─────────────────────────────────────────────

    /** Apakah buku sudah melewati jatuh tempo (hanya berlaku untuk buku perpus) */
    public function getIsTerlambatAttribute(): bool
    {
        if ($this->sumber_buku !== 'buku perpus') {
            return false;
        }

        if ($this->tanggal_kembali !== null) {
            return false; // sudah dikembalikan
        }

        return $this->tanggal_jatuh_tempo !== null
            && now()->startOfDay()->gt($this->tanggal_jatuh_tempo);
    }

    /** Hitung jumlah hari terlambat (real-time, belum disimpan) */
    public function getHariTerlambatRealtimeAttribute(): int
    {
        if ($this->sumber_buku !== 'buku perpus' || $this->tanggal_jatuh_tempo === null) {
            return 0;
        }

        $acuan = $this->tanggal_kembali ?? now();

        return max(0, (int) $this->tanggal_jatuh_tempo->diffInDays($acuan, false));
    }

    /** Denda realtime (belum tersimpan ke DB) */
    public function getDendaRealtimeAttribute(): int
    {
        return $this->hari_terlambat_realtime * $this->denda_harian;
    }

    /** Label status yang lebih ramah */
    public function getLabelStatusAttribute(): string
    {
        return match ($this->status_detail) {
            'dipinjam'     => 'Sedang Dipinjam',
            'terlambat'    => 'Terlambat',
            'dikembalikan' => 'Sudah Dikembalikan',
            'hilang'       => 'Hilang',
            'rusak'        => 'Rusak',
            default        => ucfirst($this->status_detail),
        };
    }

    // ─────────────────────────────────────────────
    // LOGIKA PENGEMBALIAN
    // ─────────────────────────────────────────────

    /**
     * Proses pengembalian buku normal (kondisi baik).
     * Menghitung denda otomatis jika buku perpus terlambat.
     */
    public function prosesPengembalian(?Carbon $tanggalKembali = null, ?string $keterangan = null): void
    {
        $tanggalKembali ??= now();

        $this->tanggal_kembali = $tanggalKembali;
        $this->status_detail   = 'dikembalikan';
        $this->keterangan      = $keterangan;

        if ($this->sumber_buku === 'buku perpus' && $this->tanggal_jatuh_tempo) {
            $hari = max(0, (int) $this->tanggal_jatuh_tempo->diffInDays($tanggalKembali, false));
            $denda = $hari * $this->denda_harian;

            $this->jumlah_hari_terlambat = $hari;
            $this->jumlah_denda          = $denda;
            $this->status_denda          = $denda > 0 ? 'belum_lunas' : 'tidak_ada_denda';

            if ($hari > 0) {
                $this->status_detail = 'terlambat'; // tetap 'terlambat' sampai lunas
            }
        } else {
            // Buku BOS: tidak ada denda keterlambatan
            $this->jumlah_hari_terlambat = 0;
            $this->jumlah_denda          = 0;
            $this->status_denda          = 'tidak_ada_denda';
        }

        $this->save();
    }

    /**
     * Tandai buku hilang/rusak dengan denda manual (harga ganti buku).
     */
    public function prosesHilangAtauRusak(string $kondisi, int $dendaGanti, ?string $keterangan = null): void
    {
        if (!in_array($kondisi, ['hilang', 'rusak'])) {
            throw new \InvalidArgumentException("Kondisi harus 'hilang' atau 'rusak'.");
        }

        $this->tanggal_kembali       = now();
        $this->status_detail         = $kondisi;
        $this->jumlah_denda          = $dendaGanti;
        $this->status_denda          = $dendaGanti > 0 ? 'belum_lunas' : 'tidak_ada_denda';
        $this->jumlah_hari_terlambat = 0;
        $this->keterangan            = $keterangan ?? "Buku {$kondisi}, wajib ganti Rp" . number_format($dendaGanti, 0, ',', '.');

        $this->save();
    }

    /**
     * Tandai denda sudah lunas.
     * Jika semua denda di transaksi lunas → sync status peminjaman.
     */
    public function lunaskanDenda(): void
    {
        $this->status_denda = 'lunas';

        // Jika buku sudah kembali, set status jadi dikembalikan
        if (in_array($this->status_detail, ['terlambat'])) {
            $this->status_detail = 'dikembalikan';
        }

        $this->save();

        // Sinkronisasi status peminjaman induk
        $this->peminjaman->syncStatus();
    }

    // ─────────────────────────────────────────────
    // SCOPE QUERY
    // ─────────────────────────────────────────────

    public function scopeTerlambat($query)
    {
        return $query->where('status_detail', 'terlambat');
    }

    public function scopeDipinjam($query)
    {
        return $query->whereIn('status_detail', ['dipinjam', 'terlambat']);
    }

    public function scopeBukuPerpus($query)
    {
        return $query->where('sumber_buku', 'buku perpus');
    }

    public function scopeBukuBos($query)
    {
        return $query->where('sumber_buku', 'bos');
    }

    public function scopeBelumLunas($query)
    {
        return $query->where('status_denda', 'belum_lunas');
    }
}