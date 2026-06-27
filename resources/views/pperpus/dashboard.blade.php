@extends('pperpus.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'DASHBOARD PENJAGA PERPUSTAKAAN')

@push('styles')
<style>
    
    :root {
        --slate-50:   #f8fafc;
        --slate-100:  #f1f5f9;
        --slate-200:  #e2e8f0;
        --teal-50:    #f0fdfa;
        --teal-100:   #ccfbf1;
        --teal-200:   #99f6e4;
        --teal-600:   #0d9488;
        --teal-700:   #0f766e;
        --indigo-50:  #f5f3ff;
        --indigo-100: #e0e7ff;
        --indigo-600: #4f46e5;
        --rose-50:    #fff1f2;
        --rose-100:   #ffe4e6;
        --rose-600:   #e11d48;
        --green-50:   #f0fdf4;
        --green-100:  #dcfce7;
        --green-600:  #16a34a;
        --green-700:  #15803d;
    }

    
    .section-label {
        font-size: .68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.6px;
        color: var(--text-light);
        margin-bottom: 1.1rem;
        display: flex; align-items: center; gap: .5rem;
    }
    .section-label i { color: var(--teal-600); font-size: .75rem; }
    .section-label::after {
        content: ''; flex: 1; height: 1px;
        background: var(--border);
    }

    
    .welcome-banner {
        background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #14b8a6 100%);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        color: #fff;
        margin-bottom: 2rem;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 10px 32px rgba(13,148,136,.15);
        position: relative; overflow: hidden;
    }
    .welcome-banner::before {
        content: ''; position: absolute;
        width: 240px; height: 240px; border-radius: 50%;
        background: rgba(255,255,255,.04);
        right: -70px; top: -90px;
    }
    .welcome-banner::after {
        content: ''; position: absolute;
        width: 150px; height: 150px; border-radius: 50%;
        background: rgba(255,255,255,.06);
        right: 130px; bottom: -65px;
    }
    .welcome-banner > div { z-index: 1; }
    .welcome-banner h2 {
        font-size: 1.5rem; font-weight: 800;
        margin-bottom: .35rem; letter-spacing: -.5px;
    }
    .welcome-banner p { font-size: .88rem; opacity: .85; font-weight: 500; }

    .banner-buttons { display: flex; gap: 1rem; flex-shrink: 0; z-index: 1; align-items: center; }

    .alert-card {
        background: var(--danger);
        color: white;
        border-radius: 13px;
        padding: .8rem 1.2rem;
        display: flex;
        align-items: center;
        gap: .8rem;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(239,68,68,.3);
        animation: pulse 2s infinite;
        backdrop-filter: blur(6px);
    }
    @keyframes pulse {
        0%   { transform: scale(1);    box-shadow: 0 0 0 0 rgba(239,68,68,.4); }
        70%  { transform: scale(1.03); box-shadow: 0 0 0 10px rgba(239,68,68,0); }
        100% { transform: scale(1);    box-shadow: 0 0 0 0 rgba(239,68,68,0); }
    }

    .banner-bg-icon {
        position: absolute; right: -30px; bottom: -35px;
        font-size: 11rem; color: rgba(255,255,255,.03);
        transform: rotate(-18deg); pointer-events: none; z-index: 0;
    }

    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem; margin-bottom: 2rem;
    }
    .stat-card {
        background: var(--surface);
        border-radius: 18px;
        padding: 1.4rem;
        box-shadow: var(--shadow-sm);
        display: flex; flex-direction: column; gap: .9rem;
        border: 1px solid var(--border);
        transition: all .22s ease;
        position: relative; overflow: hidden;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: rgba(13,148,136,.2);
    }
    .stat-card::before {
        content: ''; position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        border-radius: 18px 18px 0 0;
    }
    .stat-card.teal::before   { background: linear-gradient(90deg, #0d9488, #2dd4bf); }
    .stat-card.indigo::before { background: linear-gradient(90deg, #4f46e5, #818cf8); }
    .stat-card.slate::before  { background: linear-gradient(90deg, #475569, #94a3b8); }
    .stat-card.rose::before   { background: linear-gradient(90deg, #e11d48, #fb7185); }

    .stat-card-top {
        display: flex; align-items: flex-start; justify-content: space-between;
    }
    .stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .stat-card.teal   .stat-icon { background: var(--teal-50);   color: var(--teal-600); }
    .stat-card.indigo .stat-icon { background: var(--indigo-50); color: var(--indigo-600); }
    .stat-card.slate  .stat-icon { background: var(--slate-100);  color: var(--slate-700); }
    .stat-card.rose   .stat-icon { background: var(--rose-50);   color: var(--rose-600); }

    .stat-tag {
        font-size: .63rem; font-weight: 700;
        padding: .22rem .55rem; border-radius: 20px; letter-spacing: .2px;
    }
    .tag-teal   { background: var(--teal-100);   color: var(--teal-700); }
    .tag-indigo { background: var(--indigo-100); color: var(--indigo-600); }
    .tag-slate  { background: var(--slate-200);  color: var(--slate-700); }
    .tag-rose   { background: var(--rose-100);   color: var(--rose-600); }

    .stat-val { font-size: 2rem; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-lbl { font-size: .83rem; font-weight: 700; color: var(--text-muted); margin-top: .3rem; }
    .stat-sub { font-size: .71rem; color: var(--text-light); font-weight: 500; margin-top: .1rem; }

    
    .panel {
        background: var(--surface);
        border-radius: 18px;
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
        font-size: .87rem; font-weight: 700; color: var(--text);
        display: flex; align-items: center; gap: .65rem;
        margin: 0;
    }
    .ph-icon {
        width: 28px; height: 28px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .8rem; flex-shrink: 0;
    }
    .panel-badge {
        font-size: .63rem; font-weight: 700;
        padding: .22rem .65rem; border-radius: 20px;
    }
    .pb-teal   { background: var(--teal-100);   color: var(--teal-700); }
    .pb-indigo { background: var(--indigo-100); color: var(--indigo-600); }
    .pb-green  { background: var(--green-100);  color: var(--green-700); }
    .pb-rose   { background: var(--rose-100);   color: var(--rose-600); }

    
    .chart-denda-layout {
        display: grid; grid-template-columns: 1.65fr 1fr;
        gap: 1.25rem; margin-bottom: 2rem;
    }
    .monitoring-row {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 1.25rem; margin-bottom: 2rem;
    }

    
    .denda-body { padding: 1.25rem 1.4rem; display: flex; flex-direction: column; gap: 1rem; }

    .denda-grand {
        border-radius: 14px;
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        padding: 1.1rem 1.4rem;
        display: flex; align-items: center; gap: 1rem;
        position: relative; overflow: hidden;
    }
    .denda-grand-icon {
        width: 44px; height: 44px; border-radius: 11px;
        background: rgba(255,255,255,.1);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; color: var(--teal-400); flex-shrink: 0; z-index: 1;
    }
    .denda-grand-info { z-index: 1; }
    .denda-grand-info .dg-label {
        font-size: .68rem; text-transform: uppercase;
        letter-spacing: 1.3px; font-weight: 700;
        color: rgba(255,255,255,.7); margin-bottom: .2rem;
    }
    .denda-grand-info .dg-value {
        font-size: 1.5rem; font-weight: 900;
        color: #fff; letter-spacing: -.5px; line-height: 1;
    }

    .denda-split { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; }
    .denda-split-card {
        border-radius: 13px; padding: 1rem 1.1rem;
        border: 1.5px solid; display: flex; flex-direction: column; gap: .5rem;
    }
    .denda-split-card.lunas { background: var(--green-50); border-color: #bbf7d0; }
    .denda-split-card.belum { background: var(--rose-50);  border-color: #fecaca; }

    .dsc-header { display: flex; align-items: center; gap: .55rem; }
    .dsc-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .lunas .dsc-dot   { background: var(--green-600); }
    .belum .dsc-dot   { background: var(--rose-600); }
    .dsc-label { font-size: .72rem; font-weight: 700; }
    .lunas .dsc-label { color: var(--green-700); }
    .belum .dsc-label { color: var(--rose-600); }
    .dsc-val { font-size: 1.1rem; font-weight: 800; color: var(--text); letter-spacing: -.3px; line-height: 1; }
    .dsc-sub { font-size: .7rem; font-weight: 500; color: var(--text-light); }

    .dp-header {
        display: flex; justify-content: space-between;
        align-items: center; margin-bottom: .45rem;
    }
    .dp-header .dp-lbl { font-size: .74rem; font-weight: 600; color: var(--text-muted); }
    .dp-header .dp-pct { font-size: .74rem; font-weight: 800; color: var(--green-700); }
    .dp-track {
        height: 9px; background: var(--border);
        border-radius: 99px; overflow: hidden;
    }
    .dp-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--green-600), #34d399);
        border-radius: 99px; transition: width 1s ease;
    }
    .dp-footer {
        display: flex; justify-content: space-between; margin-top: .4rem;
    }
    .dp-footer span { font-size: .68rem; color: var(--text-light); font-weight: 500; }

    
    .table-responsive { overflow-x: auto; }
    .table { width: 100%; border-collapse: collapse; }
    .table th {
        text-align: left; padding: .55rem .6rem;
        border-bottom: 1px solid var(--border-soft);
        font-size: .68rem; text-transform: uppercase;
        letter-spacing: .8px; color: var(--text-light); font-weight: 700;
    }
    .table td { padding: .8rem .6rem; border-bottom: 1px solid var(--border-soft); }
    .table tr:last-child td { border-bottom: none; }
    .table tbody tr:hover td { background: var(--surface-2); }
    .badge { padding: .25rem .65rem; font-size: .69rem; font-weight: 700; border-radius: 4px; }
    .bg-primary { background-color: var(--primary); color: white; }
    .rounded-pill { border-radius: 50rem; }

    .code-badge {
        font-family: 'JetBrains Mono', monospace; font-size: .78rem;
        background: var(--slate-100); color: var(--teal-700);
        padding: .2rem .45rem; border-radius: 6px; font-weight: 700;
        border: 1px solid var(--slate-200);
        text-decoration: none; display: inline-block;
    }
    .pill { display: inline-flex; align-items: center; gap: .3rem; padding: .25rem .7rem; border-radius: 20px; font-size: .7rem; font-weight: 700; }
    .pill-success { background: #dcfce7; color: #15803d; }
    .pill-danger  { background: #fee2e2; color: #b91c1c; }

    
    .rank-num {
        width: 28px; height: 28px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .78rem; font-weight: 800;
    }
    .rank-1 { background: #ccfbf1; color: #0f766e; }
    .rank-2 { background: #e0e7ff; color: #4f46e5; }
    .rank-3 { background: #f1f5f9; color: #475569; }
    .rank-n { background: var(--border-soft); color: var(--text-muted); }

    
    .books-showcase {
        display: flex; gap: 1.1rem; overflow-x: auto;
        padding: 1.25rem 1.2rem 1.75rem;
        scroll-snap-type: x mandatory;
        scrollbar-width: thin; scrollbar-color: var(--teal-200) transparent;
        -webkit-overflow-scrolling: touch;
    }
    .books-showcase::-webkit-scrollbar { height: 5px; }
    .books-showcase::-webkit-scrollbar-thumb { background: var(--teal-200); border-radius: 10px; }

    .book-card-sleek {
        min-width: 130px; max-width: 130px; flex-shrink: 0;
        scroll-snap-align: start; display: flex; flex-direction: column;
        transition: transform .3s cubic-bezier(.34, 1.56, .64, 1);
        cursor: pointer;
    }
    .book-card-sleek:hover { transform: translateY(-8px); }

    .book-card-sleek .cover-box {
        width: 100%; aspect-ratio: 2/3; border-radius: 12px;
        overflow: hidden; position: relative;
        box-shadow: 0 6px 14px rgba(15,23,42,.05);
        background: linear-gradient(135deg, var(--slate-50), var(--slate-100));
        border: 1px solid rgba(255,255,255,.4);
    }
    .book-card-sleek .cover-box img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .45s ease;
    }
    .book-card-sleek:hover .cover-box img { transform: scale(1.07); }

    .book-card-sleek .rank-badge {
        position: absolute; top: 0; left: 0;
        background: linear-gradient(135deg, var(--teal-600), #1e293b);
        color: white; font-size: .72rem; font-weight: 800;
        padding: .28rem .55rem; border-bottom-right-radius: 11px;
        z-index: 2;
    }

    .book-card-sleek .borrow-stat {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: rgba(15,23,42,.9); backdrop-filter: blur(8px);
        color: #fff; font-size: .68rem; font-weight: 600;
        padding: .38rem; text-align: center;
        transform: translateY(100%); transition: transform .25s ease;
    }
    .book-card-sleek:hover .borrow-stat { transform: translateY(0); }

    .book-card-sleek .info-box { padding: .7rem .1rem 0; text-align: center; }
    .book-card-sleek .info-box h4 {
        font-size: .82rem; font-weight: 800; color: var(--text);
        margin: 0 0 .18rem; line-height: 1.3;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .book-card-sleek .info-box p {
        font-size: .68rem; color: var(--text-muted); margin: 0;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .empty-state {
        padding: 2.5rem; text-align: center;
        color: var(--text-light); font-size: .84rem;
    }
    .empty-state i { font-size: 2rem; display: block; margin-bottom: .6rem; opacity: .35; }

    .mt-4 { margin-top: 1.5rem; }
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

    <div class="stat-card teal">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <span class="stat-tag tag-teal">Anggota</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_siswa'], 0, ',', '.') }}</div>
            <div class="stat-lbl">Total Siswa</div>
            <div class="stat-sub"><span style="color: var(--success); font-weight: 700;">{{ number_format($stats['siswa_aktif'], 0, ',', '.') }}</span> Siswa Aktif</div>
        </div>
    </div>

    <div class="stat-card indigo">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-book"></i></div>
            <span class="stat-tag tag-indigo">Koleksi</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_buku'], 0, ',', '.') }}</div>
            <div class="stat-lbl">Judul Buku</div>
            <div class="stat-sub">Stok Fisik: <span style="font-weight: 700;">{{ number_format($stats['total_stok'], 0, ',', '.') }}</span> Eks.</div>
        </div>
    </div>

    <div class="stat-card slate">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
            <span class="stat-tag tag-slate">Hari Ini</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['peminjaman_hari_ini'], 0, ',', '.') }}</div>
            <div class="stat-lbl">PJM Hari Ini</div>
            <div class="stat-sub">Detail: <span style="font-weight: 700;">{{ number_format($stats['buku_dipinjam_hari_ini'], 0, ',', '.') }}</span> Buku Dipinjam</div>
        </div>
    </div>

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

    
    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:var(--teal-50);">
                    <i class="fas fa-chart-line" style="color:var(--teal-600);"></i>
                </span>
                Grafik Peminjaman — 7 Hari Terakhir
            </h3>
            <span class="panel-badge pb-teal">Tren Harian</span>
        </div>
        <div style="padding: 1.4rem 1.4rem 1.2rem; flex-grow: 1; min-height: 280px; display: flex; flex-direction: column;">
            <div style="flex-grow: 1; position: relative;">
                <canvas id="borrowingsChart"></canvas>
            </div>
        </div>
    </div>

    
    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:var(--indigo-50);">
                    <i class="fas fa-coins" style="color:var(--indigo-600);"></i>
                </span>
                Ringkasan Denda
            </h3>
            <span class="panel-badge pb-indigo">Status Keuangan</span>
        </div>

        <div class="denda-body">
            <div class="denda-grand">
                <div class="denda-grand-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="denda-grand-info">
                    <div class="dg-label">Total Akumulasi Denda</div>
                    <div class="dg-value">Rp {{ number_format($stats['total_denda_grand'] ?? 0, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="denda-split">
                <div class="denda-split-card lunas">
                    <div class="dsc-header">
                        <div class="dsc-dot"></div>
                        <div class="dsc-label"><i class="fas fa-check-circle" style="margin-right:.25rem;"></i> Lunas</div>
                    </div>
                    <div class="dsc-val">Rp {{ number_format($stats['denda_lunas'] ?? 0, 0, ',', '.') }}</div>
                    @php
                        $grandTotal = $stats['total_denda_grand'] ?? 0;
                        $lunas = $stats['denda_lunas'] ?? 0;
                        $belum = $stats['denda_belum_lunas'] ?? 0;
                        $pctLunas = $grandTotal > 0 ? round(($lunas / $grandTotal) * 100) : 0;
                        $pctBelum = $grandTotal > 0 ? round(($belum / $grandTotal) * 100) : 0;
                    @endphp
                    <div class="dsc-sub">{{ $pctLunas }}% dari total</div>
                </div>
                <div class="denda-split-card belum">
                    <div class="dsc-header">
                        <div class="dsc-dot"></div>
                        <div class="dsc-label"><i class="fas fa-clock" style="margin-right:.25rem;"></i> Belum Lunas</div>
                    </div>
                    <div class="dsc-val">Rp {{ number_format($stats['denda_belum_lunas'] ?? 0, 0, ',', '.') }}</div>
                    <div class="dsc-sub">{{ $pctBelum }}% dari total</div>
                </div>
            </div>

            <div>
                <div class="dp-header">
                    <span class="dp-lbl">Tingkat Pelunasan</span>
                    <span class="dp-pct">{{ $pctLunas }}%</span>
                </div>
                <div class="dp-track">
                    <div class="dp-fill" style="width: {{ $pctLunas }}%;"></div>
                </div>
                <div class="dp-footer">
                    <span>0%</span>
                    <span>Target 100%</span>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="panel" style="margin-bottom: 1.8rem;" id="denda-section">
    <div class="panel-header">
        <h3>
            <span class="ph-icon" style="background:var(--slate-100); border: 1px solid var(--border);">
                <i class="fas fa-file-invoice-dollar" style="color:var(--text-muted);"></i>
            </span>
            Daftar Denda Peminjaman (Lunas &amp; Belum Lunas)
        </h3>
        <span class="panel-badge pb-indigo">Total: {{ $fines->total() }} Denda</span>
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
                        <span class="code-badge">{{ $fine->peminjaman->kode_peminjaman }}</span>
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


<div class="section-label mt-4">
    <i class="fas fa-history"></i> Aktivitas Terbaru Perpustakaan
</div>
<div class="panel" style="margin-bottom: 1.8rem;">
    <div class="panel-header">
        <h3>
            <span class="ph-icon" style="background:var(--indigo-50);">
                <i class="fas fa-history" style="color:var(--indigo-600);"></i>
            </span>
            Aktivitas Terbaru
        </h3>
        <a href="{{ route('pperpus.report.aktivitas.index') }}" class="panel-badge pb-indigo" style="text-decoration: none;">
            Semua Laporan <i class="fas fa-arrow-right" style="font-size: .65rem; margin-left: 2px;"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Siswa</th>
                    <th>Status</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_activities as $activity)
                <tr>
                    <td>
                        <span class="code-badge">{{ $activity->peminjaman->kode_peminjaman }}</span>
                    </td>
                    <td>
                        <div style="font-weight: 700; font-size: .82rem;">{{ $activity->peminjaman->siswa->nama_siswa ?? '-' }}</div>
                        <div style="font-size: .7rem; color: var(--text-light)">{{ $activity->peminjaman->siswa->kelas ?? '-' }}</div>
                    </td>
                    <td>
                        @if($activity->status_detail === 'dipinjam')
                            <span class="pill pill-info" style="background: #eff6ff; color: #1e40af;"><i class="fas fa-book-reader"></i> Dipinjam</span>
                        @elseif($activity->status_detail === 'dikembalikan')
                            <span class="pill pill-success" style="background: #dcfce7; color: #15803d;"><i class="fas fa-check"></i> Kembali</span>
                        @elseif($activity->status_detail === 'terlambat')
                            <span class="pill pill-danger" style="background: #fee2e2; color: #b91c1c;"><i class="fas fa-exclamation-triangle"></i> Lambat</span>
                        @elseif($activity->status_detail === 'hilang')
                            <span class="pill pill-warning" style="background: #fef3c7; color: #b45309;"><i class="fas fa-times-circle"></i> Hilang</span>
                        @else
                            <span class="pill pill-info">{{ ucfirst($activity->status_detail) }}</span>
                        @endif
                    </td>
                    <td style="font-size: .72rem; color: var(--text-muted);">
                        {{ $activity->updated_at->diffForHumans() }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            Belum ada aktivitas terbaru terdeteksi.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<div class="section-label mt-4">
    <i class="fas fa-star"></i> Peringkat Siswa &amp; Buku Populer
</div>
<div class="monitoring-row">

    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:var(--green-100);">
                    <i class="fas fa-medal" style="color:var(--green-700);"></i>
                </span>
                Siswa Rajin Meminjam
            </h3>
            <span class="panel-badge pb-green">Top 5</span>
        </div>
        <div class="table-responsive" style="padding: 1rem 1.2rem;">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th style="width: 18%;">Rank</th>
                        <th>Siswa</th>
                        <th style="text-align: right;">Pinjaman</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topStudents as $index => $siswa)
                    <tr>
                        <td>
                            <span class="rank-num {{ $index === 0 ? 'rank-1' : ($index === 1 ? 'rank-2' : ($index === 2 ? 'rank-3' : 'rank-n')) }}">
                                #{{ $index + 1 }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 700; font-size: .85rem; color: var(--text);">{{ $siswa->nama_siswa }}</div>
                            <div style="font-size: .7rem; color: var(--text-light); margin-top: .1rem;">NIS: {{ $siswa->nis }} &bull; Kelas: {{ $siswa->kelas }}</div>
                        </td>
                        <td style="text-align: right;">
                            <span class="badge bg-primary rounded-pill">{{ $siswa->total_buku_dipinjam }} Buku</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel" style="overflow: hidden;">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:var(--teal-100);">
                    <i class="fas fa-fire" style="color:var(--teal-700);"></i>
                </span>
                Buku Terpopuler
            </h3>
            <span class="panel-badge pb-teal">Top 10</span>
        </div>
        <div class="books-showcase">
            @foreach($topBooks as $index => $buku)
            <div class="book-card-sleek" title="{{ $buku->judul_buku }}">
                <div class="cover-box">
                    <div class="rank-badge">#{{ $index + 1 }}</div>
                    @if($buku->gambar)
                        <img src="{{ asset('storage/' . $buku->gambar) }}" alt="{{ $buku->judul_buku }}">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-light);font-size:2.8rem;">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif
                    <div class="borrow-stat">
                        <i class="fas fa-fire" style="color:#2dd4bf;margin-right:.25rem;"></i>Dipinjam {{ $buku->total_dipinjam }}x
                    </div>
                </div>
                <div class="info-box">
                    <h4>{{ $buku->judul_buku }}</h4>
                    <p>{{ $buku->pengarang ?: 'Penulis tidak diketahui' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('borrowingsChart').getContext('2d');

    const chartData  = @json(array_values($borrowingsLast7Days));
    const labels     = chartData.map(item => item.label);
    const dataValues = chartData.map(item => item.count);

    
    const gradTeal = ctx.createLinearGradient(0, 0, 0, 280);
    gradTeal.addColorStop(0, 'rgba(13, 148, 136, 0.2)');
    gradTeal.addColorStop(1, 'rgba(13, 148, 136, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Peminjaman',
                data: dataValues,
                borderColor: '#0d9488',
                borderWidth: 2.5,
                backgroundColor: gradTeal,
                fill: true,
                tension: 0.42,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#0d9488',
                pointBorderWidth: 2.5,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#0d9488',
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
                    backgroundColor: '#1e293b',
                    titleColor: '#94a3b8',
                    bodyColor: '#f1f5f9',
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
                    ticks: { color: '#94a3b8', font: { size: 11, weight: '600' } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(226,232,240,.6)', drawTicks: false },
                    border: { dash: [4, 4] },
                    ticks: {
                        precision: 0,
                        color: '#94a3b8',
                        font: { size: 11, weight: '600' },
                        stepSize: 5
                    }
                }
            }
        }
    });
});
</script>
@endpush