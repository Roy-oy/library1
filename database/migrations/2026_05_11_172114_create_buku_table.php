<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string('kode_buku', 10)->unique();
            $table->string('judul_buku');
            $table->string('pengarang');
            $table->year('tahun_terbit')->nullable();
            $table->string('isbn', 13)->unique()->nullable();
            $table->integer('stok')->default(1);
            $table->string('gambar')->nullable();
            $table->string('rak')->nullable();
            
            // Penentu utama: Buku BOS atau Buku Perpus
            $table->enum('sumber_buku', ['bos', 'buku perpus'])->default('buku perpus');

            // Hubungkan ke kategori jika memilih buku perpus
            $table->foreignId('id_kategori')->nullable()->constrained('kategori_buku', 'id_kategori')->onDelete('set null');
            // Kolom khusus Buku BOS (Hanya diisi jika sumber_buku = bos)
            $table->enum('kelas', ['VII', 'VIII', 'IX'])->nullable();

            $table->enum('status_buku', ['tersedia', 'habis'])->default('tersedia');
            $table->timestamps();
            $table->softDeletes(); // Untuk keamanan data, tidak dihapus permanen
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};