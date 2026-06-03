<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Ksekolah\DashboardController as KsekolahDashboard;
use App\Http\Controllers\Ksekolah\OfficerController as KsekolahOfficer;
use App\Http\Controllers\Ksekolah\BukuController as KsekolahBuku;
use App\Http\Controllers\Ksekolah\ProfileController as KsekolahProfile;
use App\Http\Controllers\Kperpus\DashboardController as KperpusDashboard;
use App\Http\Controllers\Pperpus\DashboardController as PperpusDashboard;
use App\Http\Controllers\Pperpus\BukuController as PperpusBuku;
use App\Http\Controllers\Kperpus\KategoriBukuController;
use App\Http\Controllers\Kperpus\BukuController;
use App\Http\Controllers\Kperpus\SiswaController;
use App\Http\Controllers\Kperpus\OfficerController as KperpusOfficer;
use App\Http\Controllers\Kperpus\ProfileController as KperpusProfile;
use App\Http\Controllers\Pperpus\ProfileController as PperpusProfile;
use App\Http\Controllers\Kperpus\TransactionController as KperpusTransaction;
use App\Http\Controllers\Pperpus\PeminjamanController;
use App\Http\Controllers\Pperpus\DetailPeminjamanController;
use App\Http\Controllers\Pperpus\ReportDendaController;
use App\Http\Controllers\ReportAktivitasController;

// ─── Homepage ─────────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ─── Auth ────────────────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Kepala Sekolah ───────────────────────────────────────────────────────────
Route::prefix('kepala-sekolah')
    ->middleware(['auth', 'role:kepala_sekolah'])
    ->name('ksekolah.')
    ->group(function () {
        Route::get('/dashboard', [KsekolahDashboard::class, 'index'])->name('dashboard');

        // Laporan Aktivitas (Akses Lihat Saja)
        Route::get('report/aktivitas',              [ReportAktivitasController::class, 'index'])->name('report.aktivitas.index');

        // Pantauan
        Route::get('petugas',   [KsekolahOfficer::class, 'index'])->name('petugas.index');
        Route::get('buku',      [KsekolahBuku::class, 'index'])->name('buku.index');

        // Akun
        Route::get('profile',   [KsekolahProfile::class, 'index'])->name('profile.index');
        Route::put('profile',   [KsekolahProfile::class, 'update'])->name('profile.update');
    });

// ─── Kepala Perpustakaan ──────────────────────────────────────────────────────
Route::prefix('kepala-perpustakaan')
    ->middleware(['auth', 'role:kepala_perpustakaan'])
    ->name('kperpus.')
    ->group(function () {
        Route::get('/dashboard', [KperpusDashboard::class, 'index'])->name('dashboard');

        // Kategori Buku
        Route::resource('kategori', KategoriBukuController::class);

        // Buku AJAX helper
        Route::get('buku/api/generate-kode', [BukuController::class, 'getGeneratedKode'])->name('buku.generate-kode');

        // Buku
        Route::resource('buku', BukuController::class);

        // Siswa
        Route::resource('siswa', SiswaController::class);

        // Transaksi (Pantauan)
        Route::get('peminjaman',    [KperpusTransaction::class, 'peminjaman'])->name('peminjaman.index');
        Route::get('pengembalian',  [KperpusTransaction::class, 'pengembalian'])->name('pengembalian.index');

        // Manajemen Petugas
        Route::resource('petugas',  KperpusOfficer::class);

        // Laporan Aktivitas
        Route::get('report/aktivitas',              [ReportAktivitasController::class, 'index'])->name('report.aktivitas.index');
        Route::get('report/aktivitas/export-pdf',   [ReportAktivitasController::class, 'exportPdf'])->name('report.aktivitas.export-pdf');
        Route::get('report/aktivitas/export-excel', [ReportAktivitasController::class, 'exportExcel'])->name('report.aktivitas.export-excel');

        // Akun
        Route::get('profile',   [KperpusProfile::class, 'index'])->name('profile.index');
        Route::put('profile',   [KperpusProfile::class, 'update'])->name('profile.update');
    });

// ─── Penjaga Perpustakaan ─────────────────────────────────────────────────────
Route::prefix('penjaga-perpustakaan')
    ->middleware(['auth', 'role:penjaga_perpustakaan'])
    ->name('pperpus.')
    ->group(function () {
        Route::get('/dashboard', [PperpusDashboard::class, 'index'])->name('dashboard');
        Route::get('/buku',      [PperpusBuku::class, 'index'])->name('buku.index');

        // AJAX Helpers
        Route::get('api/buku/get-by-kriteria',      [PeminjamanController::class, 'getBuku'])->name('peminjaman.getBuku');
        Route::patch('peminjaman/kembalikan/{id_detail}', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
        Route::get('api/siswa/get-by-kelas',        [PeminjamanController::class, 'getSiswaByKelas'])->name('peminjaman.getSiswaByKelas');

        // Peminjaman Perpustakaan
        Route::get('peminjaman/perpustakaan',                    [PeminjamanController::class, 'indexPerpustakaan'])->name('peminjaman.perpustakaan.index');
        Route::get('peminjaman/perpustakaan/create',             [PeminjamanController::class, 'createPerpustakaan'])->name('peminjaman.perpustakaan.create');
        Route::post('peminjaman/perpustakaan',                   [PeminjamanController::class, 'storePerpustakaan'])->name('peminjaman.perpustakaan.store');
        Route::get('peminjaman/perpustakaan/{peminjaman}',       [PeminjamanController::class, 'showPerpustakaan'])->name('peminjaman.perpustakaan.show');

        // Peminjaman BOS
        Route::get('peminjaman/bos',                    [PeminjamanController::class, 'indexBos'])->name('peminjaman.bos.index');
        Route::get('peminjaman/bos/create',             [PeminjamanController::class, 'createBos'])->name('peminjaman.bos.create');
        Route::post('peminjaman/bos',                   [PeminjamanController::class, 'storeBos'])->name('peminjaman.bos.store');
        Route::get('peminjaman/bos/{peminjaman}',       [PeminjamanController::class, 'showBos'])->name('peminjaman.bos.show');

        // Pengembalian Perpustakaan
        Route::get('pengembalian/perpustakaan',         [PeminjamanController::class, 'indexPengembalianPerpustakaan'])->name('pengembalian.perpustakaan.index');
        Route::get('pengembalian/perpustakaan/{peminjaman}/kembali',    [PeminjamanController::class, 'formKembaliPerpustakaan'])->name('pengembalian.perpustakaan.formKembali');
        Route::post('pengembalian/perpustakaan/{peminjaman}/kembali',   [PeminjamanController::class, 'prosesKembaliPerpustakaan'])->name('pengembalian.perpustakaan.prosesKembali');
        Route::post('pengembalian/perpustakaan/{peminjaman}/lunas/{detail}', [PeminjamanController::class, 'lunasDendaPerpustakaan'])->name('pengembalian.perpustakaan.lunasDenda');
        Route::post('pengembalian/perpustakaan/{peminjaman}/lunas-semua',    [PeminjamanController::class, 'lunasSemuaDendaPerpustakaan'])->name('pengembalian.perpustakaan.lunasSemuaDenda');

        // Pengembalian Massal Buku BOS (Akhir Tahun Ajaran)
        Route::get('pengembalian/bos',              [PeminjamanController::class, 'formAkhirTahunBos'])->name('pengembalian.bos.index');
        Route::post('pengembalian/bos',             [PeminjamanController::class, 'prosesAkhirTahunBos'])->name('pengembalian.bos.proses');
        Route::post('peminjaman/bos/{peminjaman}/lunas-semua', [PeminjamanController::class, 'lunasSemuaDendaBos'])->name('peminjaman.bos.lunasSemuaDenda');

        // Detail Peminjaman (Operasi per-item)
        Route::post('peminjaman/{peminjaman}/detail/{detail}/perpanjang', [DetailPeminjamanController::class, 'perpanjang'])->name('peminjaman.detail.perpanjang');
        Route::post('peminjaman/{peminjaman}/detail/{detail}/hitung-ulang', [DetailPeminjamanController::class, 'hitungUlangDenda'])->name('peminjaman.detail.hitung-ulang');
        Route::delete('peminjaman/{peminjaman}/detail/{detail}',   [DetailPeminjamanController::class, 'destroy'])->name('peminjaman.detail.destroy');

        // Laporan Denda
        Route::get('report/denda',                  [ReportDendaController::class, 'index'])->name('report.denda.index');
        Route::get('report/denda/export-pdf',       [ReportDendaController::class, 'exportPdf'])->name('report.denda.export-pdf');

        // Laporan Aktivitas
        Route::get('report/aktivitas',              [ReportAktivitasController::class, 'index'])->name('report.aktivitas.index');
        Route::get('report/aktivitas/export-pdf',   [ReportAktivitasController::class, 'exportPdf'])->name('report.aktivitas.export-pdf');
        Route::get('report/aktivitas/export-excel', [ReportAktivitasController::class, 'exportExcel'])->name('report.aktivitas.export-excel');

        // Akun
        Route::get('profile',   [PperpusProfile::class, 'index'])->name('profile.index');
        Route::put('profile',   [PperpusProfile::class, 'update'])->name('profile.update');
    });