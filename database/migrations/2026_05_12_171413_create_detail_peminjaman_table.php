<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id('id_detail');

            $table->foreignId('id_peminjaman')
                ->constrained('peminjaman', 'id_peminjaman')
                ->onDelete('cascade');

            $table->foreignId('id_buku')
                ->constrained('buku', 'id_buku')
                ->onDelete('restrict');

            // Di-cache dari buku agar mudah dibedakan logika BOS vs Perpus
            $table->enum('sumber_buku', ['bos', 'buku perpus']);

            /*
            |----------------------------------------------------------
            | TANGGAL
            |----------------------------------------------------------
            | Buku Perpus : tanggal_jatuh_tempo = tanggal_pinjam + 7 hari
            | Buku BOS    : tanggal_jatuh_tempo = NULL (sampai naik kelas)
            |               diisi manual oleh petugas saat akhir tahun ajaran
            */
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->date('tanggal_kembali')->nullable();

            /*
            |----------------------------------------------------------
            | STATUS PER BUKU
            |----------------------------------------------------------
            | dipinjam     = masih dipinjam, dalam masa pinjam
            | terlambat    = sudah lewat jatuh tempo, belum kembali
            | dikembalikan = buku sudah kembali, kondisi baik
            | hilang       = buku hilang (kena denda ganti buku)
            | rusak        = buku rusak (kena denda ganti buku)
            */
            $table->enum('status_detail', [
                'dipinjam',
                'terlambat',
                'dikembalikan',
                'hilang',
                'rusak',
            ])->default('dipinjam');

            /*
            |----------------------------------------------------------
            | DENDA
            |----------------------------------------------------------
            | Buku Perpus:
            |   - denda_harian = 1000 (Rp1.000/hari keterlambatan)
            |   - jumlah_hari_terlambat dihitung otomatis saat pengembalian
            |   - jumlah_denda = denda_harian * jumlah_hari_terlambat
            |   - jika hilang/rusak, jumlah_denda diisi manual (harga ganti buku)
            |
            | Buku BOS:
            |   - denda_harian = 0 (tidak ada denda keterlambatan)
            |   - jumlah_denda diisi manual jika hilang/rusak (harga ganti buku)
            |----------------------------------------------------------
            */
            $table->integer('denda_harian')->default(1000);
                // Gunakan integer (bukan unsigned) agar fleksibel jika ada koreksi
            $table->integer('jumlah_hari_terlambat')->default(0);
                // Dihitung otomatis saat pengembalian di Controller
            $table->bigInteger('jumlah_denda')->default(0);
                // bigInteger karena nominal rupiah bisa besar (misal harga buku)

            $table->enum('status_denda', [
                'tidak_ada_denda',
                'belum_lunas',
                'lunas',
            ])->default('tidak_ada_denda');

            $table->text('keterangan')->nullable();
                // Contoh: "Buku hilang, wajib ganti Rp85.000"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};