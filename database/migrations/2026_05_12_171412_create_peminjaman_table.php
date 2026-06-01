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

            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->onDelete('restrict');

            $table->string('kode_peminjaman', 20)->unique();

            $table->date('tanggal_pinjam');
            $table->enum('status_peminjaman', [
                'dipinjam',
                'dikembalikan',
                'selesai',
            ])->default('dipinjam');

            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};