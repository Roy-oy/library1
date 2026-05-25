<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_buku', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori'); // Jika memilih buku perpustakaan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_buku');
    }
};