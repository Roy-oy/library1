@extends('pperpus.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Penjaga Perpustakaan')

@push('styles')
<style>
    .section-label {
        font-size: .68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.5px;
        color: var(--text-light);
        margin-bottom: 1rem;
        display: flex; align-items: center; gap: .5rem;
    }
    .section-label i { color: var(--purple-400); }
    .section-label::after {
        content: ''; flex: 1; height: 1px;
        background: var(--border);
    }

    .welcome-banner {
        background: linear-gradient(130deg, #4c1d95 0%, #7c3aed 55%, #a78bfa 100%);
        border-radius: 18px;
        padding: 1.8rem 2rem;
        color: #ffffff;
        margin-bottom: 1.8rem;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 8px 28px rgba(76,29,149,.22);
        position: relative; overflow: hidden;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        width: 220px; height: 220px; border-radius: 50%;
        background: rgba(255,255,255,.05);
        right: -60px; top: -80px;
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        width: 140px; height: 140px; border-radius: 50%;
        background: rgba(167,139,250,.12);
        right: 120px; bottom: -60px;
    }
    .welcome-banner > div { z-index: 1; }
    .welcome-banner h2 {
        font-size: 1.45rem; font-weight: 800;
        margin-bottom: .4rem; letter-spacing: -.4px;
    }
    .welcome-banner p {
        font-size: .88rem; opacity: .88;
        font-weight: 500; line-height: 1.5;
    }
    .welcome-banner .banner-buttons { display: flex; gap: 1rem; flex-shrink: 0; align-items: center; }
    .welcome-banner .banner-access {
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 13px;
        padding: .9rem 1.4rem;
        text-align: center;
        backdrop-filter: blur(6px);
    }
    .banner-access .access-label {
        font-size: .68rem; text-transform: uppercase;
        letter-spacing: 1.4px; opacity: .8; font-weight: 700; margin-bottom: .25rem;
        display: flex; align-items: center; justify-content: center; gap: .3rem;
    }
    .banner-access .access-role { font-size: 1rem; font-weight: 800; color: #f1c40f; }
    .banner-bg-icon {
        position: absolute; right: -40px; bottom: -40px;
        font-size: 12rem; color: rgba(255,255,255,.04);
        transform: rotate(-15deg); pointer-events: none; z-index: 0;
    }

    .alert-card {
        background: var(--danger);
        color: white;
        border-radius: 13px;
        padding: .8rem 1.2rem;
        display: flex;
        align-items: center;
        gap: .8rem;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
        animation: pulse 2s infinite;
        backdrop-filter: blur(6px);
    }
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem; margin-bottom: 1.8rem;
    }
    .stat-card {
        background: var(--surface);
        border-radius: 16px;
        padding: 1.3rem;
        box-shadow: var(--shadow-sm);
        display: flex; flex-direction: column; gap: .8rem;
        border: 1px solid var(--border);
        transition: all .25s ease;
        position: relative; overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: rgba(124,58,237,.15);
    }
    .stat-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 3px; border-radius: 16px 16px 0 0;
    }
    .stat-card.purple::before   { background: linear-gradient(90deg, #7c3aed, #a78bfa); }
    .stat-card.teal::before   { background: linear-gradient(90deg, #0d9488, #2dd4bf); }
    .stat-card.rose::before   { background: linear-gradient(90deg, #e11d48, #fb7185); }
    .stat-card.amber::before  { background: linear-gradient(90deg, #d97706, #fbbf24); }

    .stat-card-top {
        display: flex; align-items: center; justify-content: space-between;
    }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .stat-card.purple .stat-icon { background: #f5f3ff; color: #7c3aed; }
    .stat-card.teal   .stat-icon { background: #f0fdfa; color: #0d9488; }
    .stat-card.rose   .stat-icon { background: #fff1f2; color: #e11d48; }
    .stat-card.amber  .stat-icon { background: #fffbeb; color: #d97706; }

    .stat-tag {
        font-size: .64rem; font-weight: 700;
        padding: .2rem .5rem; border-radius: 20px; letter-spacing: .3px;
    }
    .tag-purple { background: #ede9fe; color: #6d28d9; }
    .tag-teal   { background: #ccfbf1; color: #0f766e; }
    .tag-rose   { background: #ffe4e6; color: #be123c; }
    .tag-amber  { background: #fef3c7; color: #b45309; }

    .stat-val { font-size: 1.9rem; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-lbl { font-size: .82rem; font-weight: 600; color: var(--text-muted); }
    .stat-sub { font-size: .72rem; color: var(--text-light); font-weight: 500; margin-top: .08rem; }

    .monitoring-row {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 1.2rem; margin-bottom: 1.8rem;
    }

    .panel {
        background: var(--surface);
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border);
        overflow: hidden; display: flex; flex-direction: column;
    }
    .panel-header {
        padding: 1rem 1.4rem;
        border-bottom: 1px solid var(--border-soft);
        display: flex; align-items: center; justify-content: space-between;
        background: var(--surface-2);
    }
    .panel-header h3 {
        font-size: .86rem; font-weight: 700; color: var(--text);
        display: flex; align-items: center; gap: .6rem;
    }
    .ph-icon {
        width: 27px; height: 27px; border-radius: 7px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .78rem;
    }
    .panel-badge {
        font-size: .64rem; font-weight: 700;
        padding: .22rem .6rem; border-radius: 20px;
    }
    .pb-purple { background: #ede9fe; color: #6d28d9; }
    .pb-green  { background: #dcfce7; color: #15803d; }
    .pb-orange { background: #ffedd5; color: #c2410c; }
    .pb-rose   { background: #ffe4e6; color: #be123c; }

    .chart-denda-layout {
        display: grid; grid-template-columns: 1.6fr 1fr;
        gap: 1.2rem; margin-bottom: 1.8rem;
    }

    .denda-total-card {
        background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 60%, #a78bfa 100%);
        border-radius: 13px;
        padding: 1.2rem 1.4rem;
        color: white; text-align: center;
        position: relative; overflow: hidden;
        margin: 1rem 1rem .75rem;
        box-shadow: 0 6px 20px rgba(76,29,149,.22);
    }
    .denda-total-card::before {
        content: '';
        position: absolute;
        width: 100px; height: 100px; border-radius: 50%;
        background: rgba(255,255,255,.07);
        top: -40px; right: -30px;
    }
    .denda-total-lbl { font-size: .68rem; font-weight: 700; opacity: .85; text-transform: uppercase; letter-spacing: 1.1px; }
    .denda-total-val { font-size: 1.6rem; font-weight: 900; margin-top: .25rem; letter-spacing: -.5px; }

    .denda-row {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: .75rem; padding: 0 1rem; margin-bottom: .85rem;
    }
    .denda-box {
        border-radius: 11px; padding: .85rem 1rem; border: 1px solid;
    }
    .denda-box.green { background: #f0fdf4; border-color: #bbf7d0; }
    .denda-box.red   { background: #fef2f2; border-color: #fecaca; }
    .denda-box .db-lbl { font-size: .7rem; font-weight: 600; color: var(--text-muted); margin-bottom: .25rem; display: flex; align-items: center; gap: .3rem; }
    .denda-box.green .db-lbl i { color: var(--success); }
    .denda-box.red   .db-lbl i { color: var(--danger); }
    .denda-box .db-val { font-size: 1.05rem; font-weight: 800; color: var(--text); }

    .progress-section { padding: 0 1rem 1rem; }
    .progress-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: .45rem; }
    .progress-header span { font-size: .75rem; font-weight: 600; color: var(--text-muted); }
    .progress-header .pct { font-weight: 800; color: var(--primary); }
    .progress-track { height: 8px; background: var(--border); border-radius: 99px; overflow: hidden; }
    .progress-fill  { height: 100%; background: linear-gradient(90deg, #7c3aed, #a78bfa); border-radius: 99px; transition: width 1s ease; }

    .table-responsive { overflow-x: auto; padding: 1rem; }
    .table { width: 100%; border-collapse: collapse; }
    .table th { text-align: left; padding: .6rem .5rem; border-bottom: 1px solid var(--border-soft); font-size: .75rem; color: var(--text-muted); text-transform: uppercase; }
    .table td { padding: .75rem .5rem; border-bottom: 1px solid var(--border-soft); font-size: .85rem; }
    .table tr:last-child td { border-bottom: none; }

    .code-badge {
        font-family: 'JetBrains Mono', monospace; font-size: .78rem;
        background: var(--surface-2); color: var(--primary);
        padding: .2rem .45rem; border-radius: 6px; font-weight: 700;
        border: 1px solid var(--border);
        text-decoration: none; display: inline-block;
    }
    .pill { display: inline-flex; align-items: center; gap: .3rem; padding: .25rem .7rem; border-radius: 20px; font-size: .7rem; font-weight: 700; }
    .pill-success { background: #dcfce7; color: #15803d; }
    .pill-danger  { background: #fee2e2; color: #b91c1c; }

    .empty-state {
        padding: 2.5rem; text-align: center;
        color: var(--text-light); font-size: .84rem;
    }
    .empty-state i { font-size: 2rem; display: block; margin-bottom: .6rem; opacity: .35; }

    /* Stunning Horizontal Scroll for Popular Books */
    .books-showcase {
        display: flex; gap: 1.25rem; overflow-x: auto;
        padding: 1.5rem 1rem 2rem 1rem; scroll-snap-type: x mandatory;
        scrollbar-width: thin; scrollbar-color: var(--purple-300) transparent;
        -webkit-overflow-scrolling: touch;
    }
    .books-showcase::-webkit-scrollbar { height: 6px; }
    .books-showcase::-webkit-scrollbar-thumb { background: var(--purple-300); border-radius: 10px; }
    
    .book-card-sleek {
        min-width: 140px; max-width: 140px; flex-shrink: 0;
        scroll-snap-align: start; display: flex; flex-direction: column;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        cursor: pointer;
    }
    .book-card-sleek:hover { transform: translateY(-8px); }
    
    .book-card-sleek .cover-box {
        width: 100%; aspect-ratio: 2/3; border-radius: 12px;
        overflow: hidden; position: relative;
        box-shadow: 0 8px 16px rgba(109, 40, 217, 0.15);
        background: linear-gradient(135deg, var(--purple-50), var(--purple-100));
        border: 1px solid rgba(255,255,255,0.4);
    }
    .book-card-sleek .cover-box img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.5s ease;
    }
    .book-card-sleek:hover .cover-box img { transform: scale(1.08); }
    
    .book-card-sleek .rank-badge {
        position: absolute; top: 0; left: 0;
        background: linear-gradient(135deg, var(--purple-600), var(--purple-800));
        color: white; font-size: 0.75rem; font-weight: 800;
        padding: 0.3rem 0.6rem; border-bottom-right-radius: 12px;
        box-shadow: 2px 2px 8px rgba(0,0,0,0.2); z-index: 2;
    }
    
    .book-card-sleek .borrow-stat {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(8px);
        color: #fff; font-size: 0.7rem; font-weight: 600;
        padding: 0.4rem; text-align: center;
        transform: translateY(100%); transition: transform 0.3s ease;
    }
    .book-card-sleek:hover .borrow-stat { transform: translateY(0); }
    
    .book-card-sleek .info-box { padding: 0.8rem 0.2rem 0; text-align: center; }
    .book-card-sleek .info-box h4 {
        font-size: 0.85rem; font-weight: 800; color: var(--text);
        margin: 0 0 0.2rem 0; line-height: 1.3;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .book-card-sleek .info-box p {
        font-size: 0.7rem; color: var(--text-muted); margin: 0;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    @media (max-width: 1300px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 1100px) {
        .chart-denda-layout { grid-template-columns: 1fr; }
        .monitoring-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px)  { .stats-grid { grid-template-columns: 1fr; } }
    @media (max-width: 600px)  { .welcome-banner { flex-direction: column; gap: 1rem; align-items: flex-start; } .welcome-banner .banner-buttons { width: 100%; flex-direction: column; align-items: stretch; } }
</style>
@endpush

@section('content')

<div class="welcome-banner">
    <div class="banner-bg-icon"><i class="fas fa-book-reader"></i></div>
    <div>
        <h2>Halo, {{ auth()->user()->name ?? 'Penjaga Perpustakaan' }}! 👋</h2>
        <p>Selamat bertugas &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
    <div class="banner-buttons">
        @if($stats['buku_terlambat'] > 0)
        <a href="#denda-section" class="alert-card">
            <div style="font-size: 1.5rem;"><i class="fas fa-bell"></i></div>
            <div>
                <div style="font-weight: 800; font-size: 1rem; line-height: 1.2;">{{ $stats['buku_terlambat'] }} Buku Terlambat!</div>
                <div style="font-size: 0.7rem; opacity: 0.9;">Perlu ditindaklanjuti.</div>
            </div>
        </a>
        @endif
    </div>
</div>

<div class="section-label">
    <i class="fas fa-layer-group"></i> Statistik Hari Ini &amp; Pengelolaan
</div>
<div class="stats-grid">
    <!-- Siswa Card -->
    <div class="stat-card purple">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <span class="stat-tag tag-purple">Anggota</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_siswa'], 0, ',', '.') }}</div>
            <div class="stat-lbl">Total Siswa</div>
            <div class="stat-sub"><span style="color: var(--success); font-weight: 700;">{{ number_format($stats['siswa_aktif'], 0, ',', '.') }}</span> Siswa Aktif</div>
        </div>
    </div>
    <!-- Buku Card -->
    <div class="stat-card teal">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-book"></i></div>
            <span class="stat-tag tag-teal">Koleksi</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_buku'], 0, ',', '.') }}</div>
            <div class="stat-lbl">Judul Buku</div>
            <div class="stat-sub">Stok Fisik: <span style="font-weight: 700;">{{ number_format($stats['total_stok'], 0, ',', '.') }}</span> Eks.</div>
        </div>
    </div>
    <!-- Pinjaman Hari Ini Card -->
    <div class="stat-card amber">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
            <span class="stat-tag tag-amber">Hari Ini</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['peminjaman_hari_ini'], 0, ',', '.') }}</div>
            <div class="stat-lbl">PJM Hari Ini</div>
            <div class="stat-sub">Detail: <span style="font-weight: 700;">{{ number_format($stats['buku_dipinjam_hari_ini'], 0, ',', '.') }}</span> Buku Dipinjam</div>
        </div>
    </div>
    <!-- Buku Terlambat Card -->
    <div class="stat-card rose">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <span class="stat-tag tag-rose">Alert</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['buku_terlambat'], 0, ',', '.') }}</div>
            <div class="stat-lbl">Buku Terlambat</div>
            <div class="stat-sub">Perlu ditindaklanjuti segera</div>
        </div>
    </div>
</div>

<div class="section-label">
    <i class="fas fa-chart-bar"></i> Analitik Peminjaman &amp; Laporan Keuangan
</div>
<div class="chart-denda-layout">
    <!-- Left Column: Chart -->
    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:#f5f3ff;">
                    <i class="fas fa-chart-line" style="color:#7c3aed;"></i>
                </span>
                Grafik Peminjaman — 7 Hari Terakhir
            </h3>
            <span class="panel-badge pb-purple">Tren Harian</span>
        </div>
        <div style="padding: 1.4rem; position: relative; min-height: 320px; display: flex; flex-direction: column;">
            <div style="flex-grow: 1; position: relative;">
                <canvas id="borrowingsChart" style="width: 100%; height: 100%;"></canvas>
            </div>
        </div>
    </div>

    <!-- Right Column: Fine Breakdown Panel -->
    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:#ffedd5;">
                    <i class="fas fa-coins" style="color:#c2410c;"></i>
                </span>
                Ringkasan Denda
            </h3>
            <span class="panel-badge pb-orange">Status Keuangan</span>
        </div>
        <div class="denda-total-card">
            <div class="denda-total-lbl"><i class="fas fa-coins" style="margin-right:5px;"></i>Total Akumulasi Denda</div>
            <div class="denda-total-val">Rp {{ number_format($stats['total_denda_grand'] ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="denda-row">
            <div class="denda-box green">
                <div class="db-lbl"><i class="fas fa-check-circle"></i> Lunas</div>
                <div class="db-val">Rp {{ number_format($stats['denda_lunas'] ?? 0, 0, ',', '.') }}</div>
            </div>
            <div class="denda-box red">
                <div class="db-lbl"><i class="fas fa-clock"></i> Belum Lunas</div>
                <div class="db-val">Rp {{ number_format($stats['denda_belum_lunas'] ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
        
        <!-- Progress Bar -->
        @php
            $percentLunas = ($stats['total_denda_grand'] > 0) 
                ? round(($stats['denda_lunas'] / $stats['total_denda_grand']) * 100, 1) 
                : 0;
        @endphp
        <div class="progress-section">
            <div class="progress-header">
                <span>Persentase Denda Lunas</span>
                <span class="pct">{{ $percentLunas }}%</span>
            </div>
            <div class="progress-track">
                <div class="progress-fill" style="width: {{ $percentLunas }}%;"></div>
            </div>
            <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.4rem; text-align: center;">
                Denda lunas membantu operasional & perawatan buku perpustakaan.
            </div>
        </div>
    </div>
</div>

<div class="panel" style="margin-bottom: 1.8rem;" id="denda-section">
    <div class="panel-header">
        <h3>
            <span class="ph-icon" style="background:#fef3c7;">
                <i class="fas fa-file-invoice-dollar" style="color:#b45309;"></i>
            </span>
            Daftar Denda Peminjaman (Lunas & Belum Lunas)
        </h3>
        <span class="panel-badge pb-orange">Total: {{ $fines->total() }} Denda</span>
    </div>
    
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Kode</th>
                    <th>Nama Siswa</th>
                    <th>Judul Buku</th>
                    <th>Jumlah Denda</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fines as $index => $fine)
                <tr>
                    <td>{{ ($fines->currentPage() - 1) * $fines->perPage() + $index + 1 }}</td>
                    <td>
                        <span class="code-badge">
                            {{ $fine->peminjaman->kode_peminjaman }}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight: 700;">{{ $fine->peminjaman->siswa->nama_siswa }}</div>
                        <div style="font-size: 0.72rem; color: var(--text-muted)">NIS: {{ $fine->peminjaman->siswa->nis }} — {{ $fine->peminjaman->siswa->kelas }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $fine->buku->judul_buku }}">
                            {{ $fine->buku->judul_buku }}
                        </div>
                        <div style="font-size: 0.72rem; color: var(--text-muted);">Sumber: {{ ucfirst($fine->sumber_buku) }}</div>
                    </td>
                    <td style="font-weight: 700; color: var(--text);">
                        Rp {{ number_format($fine->jumlah_denda, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($fine->status_denda === 'lunas')
                            <span class="pill pill-success"><i class="fas fa-check-circle"></i> Lunas</span>
                        @else
                            <span class="pill pill-danger"><i class="fas fa-exclamation-circle"></i> Belum Lunas</span>
                        @endif
                    </td>
                    <td>
                        @if($fine->tanggal_kembali)
                            <div style="font-size: 0.8rem;">Kembali: {{ $fine->tanggal_kembali->format('d/m/Y') }}</div>
                        @endif
                        @if($fine->keterangan)
                            <div style="font-size: 0.72rem; color: var(--text-muted); font-style: italic;">"{{ $fine->keterangan }}"</div>
                        @else
                            <div style="font-size: 0.72rem; color: var(--text-muted);">-</div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-shield-alt" style="font-size: 2.2rem; color: var(--success); opacity: 0.7;"></i>
                            <div style="font-weight: 700; color: var(--text); margin-top: 0.5rem;">Tidak Ada Denda Aktif</div>
                            <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 0.2rem;">Luar biasa! Semua denda telah diselesaikan dengan baik.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($fines->hasPages())
    <div style="padding: 1.1rem; border-top: 1px solid var(--border-soft)">
        {{ $fines->links() }}
    </div>
    @endif
</div>

<div class="section-label" style="margin-top: 1.5rem;">
    <i class="fas fa-star"></i> Peringkat Siswa &amp; Buku Populer
</div>
<div class="monitoring-row">

    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:#dcfce7;">
                    <i class="fas fa-medal" style="color:#15803d;"></i>
                </span>
                Siswa Rajin Meminjam
            </h3>
            <span class="panel-badge pb-green">Top 5</span>
        </div>
        <div class="table-responsive" style="padding: 1rem;">
            <table class="table align-middle">
                <thead class="text-muted" style="font-size: .7rem; text-transform: uppercase;">
                    <tr>
                        <th style="width: 20%;">Peringkat</th>
                        <th>Siswa</th>
                        <th style="text-align: right;">Total Pinjam</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topStudents as $index => $siswa)
                    <tr>
                        <td style="font-weight: 800; color: var(--text-muted); font-size: .9rem;">#{{ $index + 1 }}</td>
                        <td>
                            <div style="font-weight: 700; font-size: .85rem; color: var(--text);">{{ $siswa->nama_siswa }}</div>
                            <div style="font-size: .7rem; color: var(--text-light);">NIS: {{ $siswa->nis }} &bull; Kelas: {{ $siswa->kelas }}</div>
                        </td>
                        <td style="text-align: right;">
                            <span class="pill pill-success">{{ $siswa->total_buku_dipinjam }} Buku</span>
                        </td>
                    </tr>
                    @endforeach
                    @if($topStudents->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted" style="text-align: center; font-size: .8rem;">
                            <i class="fas fa-inbox" style="font-size: 1.5rem; display: block; margin-bottom: .5rem; opacity: .4;"></i>
                            Belum ada data peminjaman
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel" style="overflow: hidden;">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:#ede9fe;">
                    <i class="fas fa-fire" style="color:#6d28d9;"></i>
                </span>
                Buku Terpopuler
            </h3>
            <span class="panel-badge pb-purple">Top 10</span>
        </div>
        <div class="books-showcase">
            @foreach($topBooks as $index => $buku)
            <div class="book-card-sleek" title="{{ $buku->judul_buku }}">
                <div class="cover-box">
                    <div class="rank-badge">#{{ $index + 1 }}</div>
                    @if($buku->gambar)
                        <img src="{{ asset('storage/' . $buku->gambar) }}" alt="{{ $buku->judul_buku }}">
                    @else
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:var(--purple-300); font-size:3rem;"><i class="fas fa-book"></i></div>
                    @endif
                    <div class="borrow-stat">
                        <i class="fas fa-fire" style="color: #fbbf24;"></i> Dipinjam {{ $buku->total_dipinjam }}x
                    </div>
                </div>
                <div class="info-box">
                    <h4>{{ $buku->judul_buku }}</h4>
                    <p>{{ $buku->pengarang ?: 'Penulis tidak diketahui' }}</p>
                </div>
            </div>
            @endforeach
            @if($topBooks->isEmpty())
                <div style="width: 100%; text-align: center; padding: 3rem 0; color: var(--text-muted);">
                    <i class="fas fa-book-open" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1rem; display:block;"></i>
                    <p style="font-weight: 600; font-size: 0.9rem;">Belum ada buku yang populer</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('borrowingsChart').getContext('2d');
        
        // Extract chart data from Blade variables
        const chartData = @json(array_values($borrowingsLast7Days));
        const labels = chartData.map(item => item.label);
        const dataValues = chartData.map(item => item.count);

        // Gradient color for dataset (Purple theme)
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(124, 58, 237, 0.45)'); // purple-600
        gradient.addColorStop(1, 'rgba(124, 58, 237, 0.01)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Buku Dipinjam',
                    data: dataValues,
                    borderColor: '#7c3aed', // purple-600
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#7c3aed',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#6d28d9',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#2c3e50',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        cornerRadius: 8,
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return ` ${context.parsed.y} Buku Dipinjam`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#7f8c8d',
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                size: 11,
                                weight: 600
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0',
                            drawTicks: false
                        },
                        ticks: {
                            precision: 0,
                            color: '#7f8c8d',
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                size: 11,
                                weight: 600
                            },
                            stepSize: 1
                        }
                    }
                }
            }
        });


    });
</script>
@endpush