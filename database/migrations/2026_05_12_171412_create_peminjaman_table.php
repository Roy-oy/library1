<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');

            $table->foreignId('id_siswa')
                ->constrained('siswa', 'id_siswa')
                ->onDelete('restrict');

            // Format: PJM-20260511-001
            $table->string('kode_peminjaman', 20)->unique();

            $table->date('tanggal_pinjam');

            /*
            |----------------------------------------------------------
            | STATUS PEMINJAMAN
            |----------------------------------------------------------
            | dipinjam      = ada buku yang masih dipinjam
            | dikembalikan  = semua buku sudah kembali
            | selesai       = semua buku kembali + semua denda lunas
            */
            $table->enum('status_peminjaman', [
                'dipinjam',
                'dikembalikan',
                'selesai',
            ])->default('dipinjam');

            // id_petugas dihapus sesuai permintaan

            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Untuk keamanan data, tidak dihapus permanen
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};