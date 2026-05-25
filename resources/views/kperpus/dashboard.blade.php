@extends('kperpus.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Kepala Perpustakaan')

@push('styles')
<style>
    /* ── Stat Cards ─── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.1rem;
        margin-bottom: 1.8rem;
    }
    .stat-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 1.3rem 1.4rem;
        box-shadow: var(--shadow);
        display: flex; align-items: center; gap: 1rem;
        border-left: 4px solid transparent;
        transition: transform .2s, box-shadow .2s;
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,.1); }
    .stat-card.blue   { border-left-color: var(--primary); }
    .stat-card.gold   { border-left-color: var(--accent); }
    .stat-card.green  { border-left-color: var(--success); }
    .stat-card.red    { border-left-color: var(--danger); }
    .stat-card.orange { border-left-color: var(--warning); }
    .stat-card.teal   { border-left-color: #16a085; }

    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; flex-shrink: 0;
    }
    .stat-card.blue   .stat-icon { background: #eaf0f8; color: var(--primary); }
    .stat-card.gold   .stat-icon { background: var(--accent-light); color: #a07840; }
    .stat-card.green  .stat-icon { background: #eafaf1; color: var(--success); }
    .stat-card.red    .stat-icon { background: #fdf0ef; color: var(--danger); }
    .stat-card.orange .stat-icon { background: #fef9ec; color: var(--warning); }
    .stat-card.teal   .stat-icon { background: #e8f8f5; color: #16a085; }

    .stat-body .value { font-size: 1.7rem; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-body .label { font-size: .8rem; color: var(--text-muted); margin-top: .3rem; }

    /* ── Panels ─── */
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
        padding: 1.1rem 1.4rem;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .panel-header h3 { font-size: .92rem; font-weight: 700; color: var(--text); }
    .panel-header .badge {
        font-size: .72rem; font-weight: 700;
        padding: .25rem .65rem;
        border-radius: 20px;
    }
    .badge-blue   { background: #eaf0f8; color: var(--primary); }
    .badge-red    { background: #fdf0ef; color: var(--danger); }
    .badge-green  { background: #eafaf1; color: var(--success); }
    .badge-orange { background: #fef9ec; color: var(--warning); }

    /* Table */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th {
        font-size: .75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .5px;
        color: var(--text-muted);
        padding: .7rem 1.4rem;
        background: #f8fafc;
        border-bottom: 1px solid var(--border);
        text-align: left;
    }
    .data-table td {
        padding: .75rem 1.4rem;
        font-size: .86rem;
        border-bottom: 1px solid #f0f4f8;
        color: var(--text);
    }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover td { background: #f8fafc; }

    .pill {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .25rem .7rem;
        border-radius: 20px;
        font-size: .75rem; font-weight: 600;
    }
    .pill-success { background: #eafaf1; color: var(--success); }
    .pill-danger  { background: #fdf0ef; color: var(--danger); }
    .pill-warning { background: #fef9ec; color: var(--warning); }
    .pill-info    { background: #ebf5fb; color: var(--info); }

    .empty-state {
        padding: 2.5rem;
        text-align: center;
        color: var(--text-muted);
        font-size: .88rem;
    }
    .empty-state i { font-size: 2rem; display: block; margin-bottom: .6rem; opacity: .4; }

    /* Welcome bar */
    .welcome-bar {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        border-radius: var(--radius);
        padding: 1.5rem 2rem;
        color: #fff;
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.8rem;
        overflow: hidden;
        position: relative;
    }
    .welcome-bar::after {
        content: '\f02d';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute; right: 1.5rem;
        font-size: 5rem; opacity: .07;
        color: #fff;
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

{{-- Welcome bar --}}
<div class="welcome-bar">
    <div>
        <h2>Halo, {{ auth()->user()->name }}!</h2>
        <p>Selamat datang di panel Kepala Perpustakaan &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
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
    <div class="stat-card teal">
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
        <div class="stat-icon"><i class="fas fa-user-shield"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['total_penjaga']) }}</div>
            <div class="label">Petugas Aktif</div>
        </div>
    </div>
</div>

<div class="panels-row">
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-chart-line" style="margin-right: 8px;"></i>Aktivitas Hari Ini</h3>
        </div>
        <div class="card-body p-4">
            <div style="display: flex; justify-content: space-around; text-align: center; padding: 1rem 0;">
                <div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary)">{{ $stats['peminjaman_hari'] }}</div>
                    <div style="font-size: .75rem; color: var(--text-muted); text-transform: uppercase;">Peminjaman</div>
                </div>
                <div style="width: 1px; background: var(--border);"></div>
                <div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--success)">{{ $stats['pengembalian_hari'] }}</div>
                    <div style="font-size: .75rem; color: var(--text-muted); text-transform: uppercase;">Pengembalian</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-bullhorn" style="margin-right: 8px;"></i>Akses Cepat</h3>
        </div>
        <div class="card-body p-4 d-flex gap-2 justify-content-center">
            <a href="{{ route('kperpus.report.aktivitas.index') }}" class="btn-primary" style="padding: .5rem 1rem; font-size: .8rem; text-decoration: none;">
                <i class="fas fa-file-invoice" style="margin-right: 4px;"></i> Laporan Aktivitas
            </a>
            <a href="{{ route('kperpus.buku.index') }}" class="btn-primary" style="padding: .5rem 1rem; font-size: .8rem; background: var(--secondary); color: var(--text); text-decoration: none;">
                <i class="fas fa-book" style="margin-right: 4px;"></i> Kelola Koleksi
            </a>
            <a href="{{ route('kperpus.peminjaman.index') }}" class="btn-primary" style="padding: .5rem 1rem; font-size: .8rem; background: var(--secondary); color: var(--text); text-decoration: none;">
                <i class="fas fa-exchange-alt" style="margin-right: 4px;"></i> Kelola Peminjaman
            </a>
        </div>
    </div>
</div>
@endsection