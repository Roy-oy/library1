@extends('kperpus.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Kepala Perpustakaan')

@push('styles')
<style>
    .section-label {
        font-size: .68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.5px;
        color: var(--text-light);
        margin-bottom: 1rem;
        display: flex; align-items: center; gap: .5rem;
    }
    .section-label i { color: var(--blue-400); }
    .section-label::after {
        content: ''; flex: 1; height: 1px;
        background: var(--border);
    }

    .welcome-banner {
        background: linear-gradient(130deg, #1e3a8a 0%, #2563eb 55%, #38bdf8 100%);
        border-radius: 18px;
        padding: 1.8rem 2rem;
        color: #ffffff;
        margin-bottom: 1.8rem;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 8px 28px rgba(30,58,138,.22);
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
        background: rgba(56,189,248,.12);
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
    .welcome-banner .banner-buttons { display: flex; gap: 1rem; flex-shrink: 0; }
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
        border-color: rgba(37,99,235,.15);
    }
    /* Subtle top accent line */
    .stat-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 3px; border-radius: 16px 16px 0 0;
    }
    .stat-card.blue::before   { background: linear-gradient(90deg, #2563eb, #60a5fa); }
    .stat-card.teal::before   { background: linear-gradient(90deg, #0d9488, #2dd4bf); }
    .stat-card.sky::before    { background: linear-gradient(90deg, #0284c7, #38bdf8); }
    .stat-card.indigo::before { background: linear-gradient(90deg, #4f46e5, #818cf8); }
    .stat-card.violet::before { background: linear-gradient(90deg, #7c3aed, #a78bfa); }
    .stat-card.cyan::before   { background: linear-gradient(90deg, #0891b2, #22d3ee); }
    .stat-card.rose::before   { background: linear-gradient(90deg, #e11d48, #fb7185); }

    .stat-card-top {
        display: flex; align-items: center; justify-content: space-between;
    }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .stat-card.blue   .stat-icon { background: #eff6ff; color: #2563eb; }
    .stat-card.teal   .stat-icon { background: #f0fdfa; color: #0d9488; }
    .stat-card.sky    .stat-icon { background: #e0f2fe; color: #0284c7; }
    .stat-card.indigo .stat-icon { background: #eef2ff; color: #4f46e5; }
    .stat-card.violet .stat-icon { background: #f5f3ff; color: #7c3aed; }
    .stat-card.cyan   .stat-icon { background: #ecfeff; color: #0891b2; }
    .stat-card.rose   .stat-icon { background: #fff1f2; color: #e11d48; }

    .stat-tag {
        font-size: .64rem; font-weight: 700;
        padding: .2rem .5rem; border-radius: 20px; letter-spacing: .3px;
    }
    .tag-blue   { background: #dbeafe; color: #1d4ed8; }
    .tag-teal   { background: #ccfbf1; color: #0f766e; }
    .tag-sky    { background: #e0f2fe; color: #0369a1; }
    .tag-indigo { background: #e0e7ff; color: #4338ca; }
    .tag-violet { background: #ede9fe; color: #6d28d9; }
    .tag-cyan   { background: #cffafe; color: #0e7490; }
    .tag-rose   { background: #ffe4e6; color: #be123c; }

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
    .pb-blue   { background: #dbeafe; color: #1d4ed8; }
    .pb-violet { background: #ede9fe; color: #6d28d9; }
    .pb-green  { background: #dcfce7; color: #15803d; }
    .pb-orange { background: #ffedd5; color: #c2410c; }
    .pb-rose   { background: #ffe4e6; color: #be123c; }
    .pb-sky    { background: #e0f2fe; color: #0369a1; }

    .chart-denda-layout {
        display: grid; grid-template-columns: 1.6fr 1fr;
        gap: 1.2rem; margin-bottom: 1.8rem;
    }

    .denda-total-card {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 60%, #3b82f6 100%);
        border-radius: 13px;
        padding: 1.2rem 1.4rem;
        color: white; text-align: center;
        position: relative; overflow: hidden;
        margin: 1rem 1rem .75rem;
        box-shadow: 0 6px 20px rgba(30,58,138,.22);
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
    .progress-fill  { height: 100%; background: linear-gradient(90deg, #2563eb, #38bdf8); border-radius: 99px; transition: width 1s ease; }

    .petugas-list { padding: .8rem 1rem; display: flex; flex-direction: column; gap: .5rem; }
    .petugas-item {
        display: flex; align-items: center; gap: .85rem;
        padding: .7rem .9rem; border-radius: 11px;
        background: var(--surface-2); border: 1px solid var(--border-soft);
        transition: border-color .2s;
    }
    .petugas-item:hover { border-color: var(--blue-100); }
    .petugas-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, #93c5fd, #60a5fa);
        display: flex; align-items: center; justify-content: center;
        font-size: .82rem; font-weight: 800; color: #1e3a8a;
        flex-shrink: 0;
    }
    .petugas-name { font-size: .82rem; font-weight: 700; color: var(--text); }
    .petugas-role { font-size: .7rem; color: var(--text-light); font-weight: 500; }
    .petugas-status {
        margin-left: auto; font-size: .64rem; font-weight: 700;
        padding: .18rem .5rem; border-radius: 20px;
    }
    .ps-active { background: #dcfce7; color: #15803d; }

    .activity-list { padding: .8rem 1rem; display: flex; flex-direction: column; gap: 0; }
    .activity-item {
        display: flex; gap: 1rem;
        padding: .7rem 0;
        border-bottom: 1px solid var(--border-soft);
        position: relative;
    }
    .activity-item:last-child { border-bottom: none; }
    .act-line {
        position: absolute;
        left: 15px; top: 36px; bottom: -10px;
        width: 2px; background: var(--border-soft);
    }
    .activity-item:last-child .act-line { display: none; }
    .act-dot {
        width: 31px; height: 31px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: .73rem; flex-shrink: 0; z-index: 1;
    }
    .act-dot.blue   { background: #dbeafe; color: #2563eb; }
    .act-dot.green  { background: #dcfce7; color: #15803d; }
    .act-dot.violet { background: #ede9fe; color: #7c3aed; }
    .act-dot.orange { background: #ffedd5; color: #c2410c; }
    .act-dot.rose   { background: #ffe4e6; color: #e11d48; }
    .act-body .act-title { font-size: .82rem; font-weight: 600; color: var(--text); }
    .act-body .act-time  { font-size: .7rem; color: var(--text-light); font-weight: 500; margin-top: .12rem; }

    .empty-state {
        padding: 2.5rem; text-align: center;
        color: var(--text-light); font-size: .84rem;
    }
    .empty-state i { font-size: 2rem; display: block; margin-bottom: .6rem; opacity: .35; }

    .table-responsive { overflow-x: auto; }
    .table { width: 100%; border-collapse: collapse; }
    .table th { text-align: left; padding: .6rem .5rem; border-bottom: 1px solid var(--border-soft); }
    .table td { padding: .75rem .5rem; border-bottom: 1px solid var(--border-soft); }
    .table tr:last-child td { border-bottom: none; }
    .badge { padding: .25rem .6rem; font-size: .7rem; font-weight: 700; border-radius: 4px; }
    .bg-primary { background-color: var(--primary); color: white; }
    .rounded-pill { border-radius: 50rem; }
    .mt-4 { margin-top: 1.5rem; }

    /* Stunning Horizontal Scroll for Popular Books */
    .books-showcase {
        display: flex; gap: 1.25rem; overflow-x: auto;
        padding: 1.5rem 1rem 2rem 1rem; scroll-snap-type: x mandatory;
        scrollbar-width: thin; scrollbar-color: var(--blue-300) transparent;
        -webkit-overflow-scrolling: touch;
    }
    .books-showcase::-webkit-scrollbar { height: 6px; }
    .books-showcase::-webkit-scrollbar-thumb { background: var(--blue-300); border-radius: 10px; }
    
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
        box-shadow: 0 8px 16px rgba(37, 99, 235, 0.15);
        background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
        border: 1px solid rgba(255,255,255,0.4);
    }
    .book-card-sleek .cover-box img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.5s ease;
    }
    .book-card-sleek:hover .cover-box img { transform: scale(1.08); }
    
    .book-card-sleek .rank-badge {
        position: absolute; top: 0; left: 0;
        background: linear-gradient(135deg, var(--blue-600), var(--blue-800));
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
    @media (max-width: 600px)  { .welcome-banner { flex-direction: column; gap: 1rem; } }
</style>
@endpush

@section('content')

<div class="welcome-banner">
    <div class="banner-bg-icon"><i class="fas fa-chart-line"></i></div>
    <div>
        <h2>Halo, {{ auth()->user()->name ?? 'Kepala Perpustakaan' }}! 👋</h2>
        <p>Selamat bertugas &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
</div>

<div class="section-label">
    <i class="fas fa-layer-group"></i> Statistik Koleksi &amp; Pengelolaan
</div>
<div class="stats-grid">

    <div class="stat-card blue">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-book-open"></i></div>
            <span class="stat-tag tag-blue">Koleksi</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_buku'] ?? 0) }}</div>
            <div class="stat-lbl">Total Koleksi Buku</div>
            <div class="stat-sub">BOS + Perpustakaan</div>
        </div>
    </div>

    <div class="stat-card teal">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-book"></i></div>
            <span class="stat-tag tag-teal">BOS</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['buku_bos'] ?? 0) }}</div>
            <div class="stat-lbl">Buku BOS</div>
            <div class="stat-sub">Dana Operasional Sekolah</div>
        </div>
    </div>

    <div class="stat-card sky">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-book-reader"></i></div>
            <span class="stat-tag tag-sky">Perpus</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['buku_perpustakaan'] ?? 0) }}</div>
            <div class="stat-lbl">Buku Perpustakaan</div>
            <div class="stat-sub">Koleksi mandiri</div>
        </div>
    </div>

    <div class="stat-card indigo">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
            <span class="stat-tag tag-indigo">Siswa</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_siswa'] ?? 0) }}</div>
            <div class="stat-lbl">Total Siswa Terdaftar</div>
            <div class="stat-sub">Anggota aktif perpustakaan</div>
        </div>
    </div>

</div>

<div class="section-label">
    <i class="fas fa-chart-bar"></i> Analitik Peminjaman &amp; Laporan Keuangan
</div>
<div class="chart-denda-layout">

    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:#eff6ff;">
                    <i class="fas fa-chart-area" style="color:#2563eb;"></i>
                </span>
                Grafik Peminjaman — 7 Hari Terakhir
            </h3>
            <span class="panel-badge pb-blue">Live Data</span>
        </div>
        <div style="padding: 1.4rem; flex-grow: 1; min-height: 280px; display: flex; flex-direction: column;">
            <div style="flex-grow: 1; position: relative;">
                <canvas id="peminjamanChart"></canvas>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:#ffedd5;">
                    <i class="fas fa-wallet" style="color:#c2410c;"></i>
                </span>
                Ringkasan Denda
            </h3>
            <span class="panel-badge pb-orange">Keuangan</span>
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
    </div>

</div>

<div class="section-label mt-4">
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
                            <span class="badge bg-primary rounded-pill">{{ $siswa->total_buku_dipinjam }} Buku</span>
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
            <span class="panel-badge pb-violet">Top 10</span>
        </div>
        <div class="books-showcase">
            @foreach($topBooks as $index => $buku)
            <div class="book-card-sleek" title="{{ $buku->judul_buku }}">
                <div class="cover-box">
                    <div class="rank-badge">#{{ $index + 1 }}</div>
                    @if($buku->gambar)
                        <img src="{{ asset('storage/' . $buku->gambar) }}" alt="{{ $buku->judul_buku }}">
                    @else
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:var(--blue-300); font-size:3rem;"><i class="fas fa-book"></i></div>
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
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('peminjamanChart').getContext('2d');

    const chartData  = @json(array_values($borrowingsLast7Days));
    const labels     = chartData.map(item => item.label);
    const dataValues = chartData.map(item => item.count);

    const gradBlue = ctx.createLinearGradient(0, 0, 0, 280);
    gradBlue.addColorStop(0, 'rgba(37, 99, 235, 0.22)');
    gradBlue.addColorStop(1, 'rgba(56, 189, 248, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Peminjaman',
                data: dataValues,
                borderColor: '#2563eb',
                borderWidth: 2.5,
                backgroundColor: gradBlue,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#2563eb',
                pointBorderWidth: 2.5,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#2563eb',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#94a3b8',
                    bodyColor: '#f8fafc',
                    cornerRadius: 10,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} Peminjaman`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { family: 'Plus Jakarta Sans', size: 11, weight: 600 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(226,232,240,0.6)', drawTicks: false },
                    border: { dash: [4, 4] },
                    ticks: { precision: 0, color: '#94a3b8', font: { family: 'Plus Jakarta Sans', size: 11, weight: 600 }, stepSize: 5 }
                }
            }
        }
    });
});
</script>
@endpush