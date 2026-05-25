@extends('ksekolah.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Kepala Sekolah')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.1rem;
        margin-bottom: 1.8rem;
    }
    .stat-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        display: flex; align-items: center; gap: 1.2rem;
        border-left: 4px solid transparent;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,.1); }
    .stat-card.orange { border-left-color: var(--accent); }
    .stat-card.blue   { border-left-color: #2980b9; }
    .stat-card.green  { border-left-color: var(--success); }
    .stat-card.red    { border-left-color: var(--danger); }
    .stat-card.gray   { border-left-color: #7f8c8d; }
    .stat-card.teal   { border-left-color: #16a085; }
    .stat-card.purple { border-left-color: #8e44ad; }

    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; flex-shrink: 0;
    }
    .stat-card.orange .stat-icon { background: #fef3e5; color: var(--accent); }
    .stat-card.blue   .stat-icon { background: #ebf5fb; color: #2980b9; }
    .stat-card.green  .stat-icon { background: #eafaf1; color: var(--success); }
    .stat-card.red    .stat-icon { background: #fdf0ef; color: var(--danger); }
    .stat-card.gray   .stat-icon { background: #f2f3f4; color: #7f8c8d; }
    .stat-card.teal   .stat-icon { background: #e8f8f5; color: #16a085; }
    .stat-card.purple .stat-icon { background: #f5eef8; color: #8e44ad; }

    .stat-body .value { font-size: 1.7rem; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-body .label { font-size: .8rem; color: var(--text-muted); margin-top: .3rem; }

    .panels-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
        margin-bottom: 1.4rem;
    }
    .panel {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    .panel-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .panel-header h3 { font-size: .92rem; font-weight: 700; color: var(--text); }
    .badge {
        font-size: .72rem; font-weight: 700;
        padding: .25rem .65rem;
        border-radius: 20px;
    }
    .badge-blue   { background: #ebf5fb; color: #2980b9; }
    .badge-orange { background: #fef3e5; color: var(--accent); }
    .badge-green  { background: #eafaf1; color: var(--success); }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th {
        font-size: .75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .5px;
        color: var(--text-muted); padding: .7rem 1.4rem;
        background: #f8fafc; border-bottom: 1px solid var(--border);
        text-align: left;
    }
    .data-table td {
        padding: .75rem 1.4rem; font-size: .86rem;
        border-bottom: 1px solid #f0f4f8; color: var(--text);
    }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover td { background: #f8fafc; }

    .pill { display: inline-flex; align-items: center; gap: .3rem; padding: .25rem .7rem; border-radius: 20px; font-size: .75rem; font-weight: 600; }
    .pill-success { background: #eafaf1; color: var(--success); }
    .pill-danger  { background: #fdf0ef; color: var(--danger); }
    .pill-info    { background: #ebf5fb; color: #2980b9; }
    .pill-warning { background: #fef9ec; color: var(--warning); }

    .empty-state { padding: 2.5rem; text-align: center; color: var(--text-muted); font-size: .88rem; }
    .empty-state i { font-size: 2rem; display: block; margin-bottom: .6rem; opacity: .4; }

    .welcome-bar {
        background: linear-gradient(135deg, #141e2b, #1f2d3d);
        border-radius: var(--radius);
        padding: 1.5rem 2rem;
        color: #fff;
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.8rem;
        position: relative; overflow: hidden;
    }
    .welcome-bar::after {
        content: '\f19c';
        font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 1.5rem;
        font-size: 5rem; opacity: .07; color: #fff;
    }
    .welcome-bar h2 { font-size: 1.2rem; font-weight: 700; }
    .welcome-bar p  { font-size: .85rem; opacity: .75; margin-top: .2rem; }

    @media (max-width: 768px) {
        .panels-row { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')

<div class="welcome-bar">
    <div>
        <h2>Halo, {{ auth()->user()->name }}!</h2>
        <p>Ringkasan laporan perpustakaan sekolah &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
</div>
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-book"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['total_buku']) }}</div>
            <div class="label">Total Koleksi Buku</div>
        </div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['total_siswa']) }}</div>
            <div class="label">Total Siswa Terdaftar</div>
        </div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-exchange-alt"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['peminjaman_aktif']) }}</div>
            <div class="label">Peminjaman Aktif</div>
        </div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['terlambat']) }}</div>
            <div class="label">Buku Terlambat</div>
        </div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['peminjaman_bulan']) }}</div>
            <div class="label">Peminjaman Bulan Ini</div>
        </div>
    </div>
</div>

<div class="panels-row">
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-chart-area" style="margin-right: 8px;"></i>Aktivitas Terbaru</h3>
            <a href="{{ route('ksekolah.report.aktivitas.index') }}" class="badge badge-blue">Lihat Laporan Lengkap</a>
        </div>
        <div class="card-body" style="padding: 12px; text-align: center; color: var(--text-muted)">
            <p>Silakan buka menu <strong>Laporan Aktivitas</strong> untuk melihat rincian riwayat peminjaman dan pengembalian buku secara lengkap dan mendalam.</p>
        </div>
    </div>
    
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-info-circle" style="margin-right: 8px;"></i>Ringkasan Status</h3>
        </div>
        <div class="card-body" style="padding: 12px">
            <ul style="list-style: none; padding: 0; font-size: .88rem; color: var(--text)">
                <li style="margin-bottom: 1rem; display: flex; justify-content: space-between">
                    <span>Peminjaman Aktif Saat Ini</span>
                    <span class="pill pill-info">{{ $stats['peminjaman_aktif'] }} Transaksi</span>
                </li>
                <li style="margin-bottom: 1rem; display: flex; justify-content: space-between">
                    <span>Buku Melewati Batas Waktu</span>
                    <span class="pill pill-danger">{{ $stats['terlambat'] }} Buku</span>
                </li>
                <li style="display: flex; justify-content: space-between">
                    <span>Total Siswa Terdaftar</span>
                    <span class="pill pill-success">{{ $stats['total_siswa'] }} Orang</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection