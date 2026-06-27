@extends('kperpus.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Kepala Perpustakaan')

@push('styles')
<style>
    
    :root {
        --blue-50:  #eff6ff;
        --blue-100: #dbeafe;
        --blue-200: #bfdbfe;
        --blue-400: #60a5fa;
        --blue-600: #2563eb;
        --blue-700: #1d4ed8;
        --blue-800: #1e40af;
        --blue-900: #1e3a8a;
        --teal-50:  #f0fdfa;
        --teal-100: #ccfbf1;
        --teal-600: #0d9488;
        --sky-50:   #e0f2fe;
        --sky-600:  #0284c7;
        --indigo-50:  #eef2ff;
        --indigo-100: #e0e7ff;
        --indigo-600: #4f46e5;
        --violet-50:  #f5f3ff;
        --violet-100: #ede9fe;
        --violet-600: #7c3aed;
        --rose-50:  #fff1f2;
        --rose-100: #ffe4e6;
        --rose-600: #e11d48;
        --amber-50:  #fffbeb;
        --amber-100: #fef3c7;
        --amber-400: #fbbf24;
        --amber-600: #d97706;
        --green-50:  #f0fdf4;
        --green-100: #dcfce7;
        --green-600: #16a34a;
        --green-700: #15803d;
        --orange-50:  #fff7ed;
        --orange-100: #ffedd5;
        --orange-600: #ea580c;
    }

    
    .section-label {
        font-size: .68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.6px;
        color: var(--text-light);
        margin-bottom: 1.1rem;
        display: flex; align-items: center; gap: .5rem;
    }
    .section-label i { color: var(--blue-600); font-size: .75rem; }
    .section-label::after {
        content: ''; flex: 1; height: 1px;
        background: var(--border);
    }

    
    .welcome-banner {
        background: linear-gradient(125deg, var(--blue-900) 0%, var(--blue-600) 55%, #38bdf8 100%);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        color: #fff;
        margin-bottom: 2rem;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 10px 32px rgba(30,58,138,.2);
        position: relative; overflow: hidden;
    }
    .welcome-banner::before {
        content: ''; position: absolute;
        width: 240px; height: 240px; border-radius: 50%;
        background: rgba(255,255,255,.05);
        right: -70px; top: -90px;
    }
    .welcome-banner::after {
        content: ''; position: absolute;
        width: 150px; height: 150px; border-radius: 50%;
        background: rgba(56,189,248,.1);
        right: 130px; bottom: -65px;
    }
    .welcome-banner > div { z-index: 1; }
    .welcome-banner h2 {
        font-size: 1.5rem; font-weight: 800;
        margin-bottom: .35rem; letter-spacing: -.5px;
    }
    .welcome-banner p { font-size: .88rem; opacity: .85; font-weight: 500; }

    .banner-meta {
        display: flex; gap: .85rem; flex-shrink: 0; z-index: 1;
    }
    .banner-chip {
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.22);
        border-radius: 14px;
        padding: .85rem 1.2rem;
        text-align: center;
        backdrop-filter: blur(6px);
        min-width: 110px;
    }
    .banner-chip .chip-label {
        font-size: .64rem; text-transform: uppercase;
        letter-spacing: 1.4px; opacity: .8; font-weight: 700;
        margin-bottom: .2rem;
        display: flex; align-items: center; justify-content: center; gap: .3rem;
    }
    .banner-chip .chip-val { font-size: .98rem; font-weight: 800; color: #fcd34d; }

    .banner-bg-icon {
        position: absolute; right: -30px; bottom: -35px;
        font-size: 11rem; color: rgba(255,255,255,.04);
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
        border-color: #2563eb2e;
    }
    .stat-card::before {
        content: ''; position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        border-radius: 18px 18px 0 0;
    }
    .stat-card.blue::before   { background: linear-gradient(90deg, #2563eb, #60a5fa); }
    .stat-card.teal::before   { background: linear-gradient(90deg, #0d9488, #2dd4bf); }
    .stat-card.sky::before    { background: linear-gradient(90deg, #0284c7, #38bdf8); }
    .stat-card.indigo::before { background: linear-gradient(90deg, #4f46e5, #818cf8); }
    .stat-card.violet::before { background: linear-gradient(90deg, #7c3aed, #a78bfa); }
    .stat-card.rose::before   { background: linear-gradient(90deg, #e11d48, #fb7185); }
    .stat-card.amber::before  { background: linear-gradient(90deg, #d97706, #fbbf24); }

    .stat-card-top {
        display: flex; align-items: flex-start; justify-content: space-between;
    }
    .stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .stat-card.blue   .stat-icon { background: var(--blue-50);   color: var(--blue-600); }
    .stat-card.teal   .stat-icon { background: var(--teal-50);   color: var(--teal-600); }
    .stat-card.sky    .stat-icon { background: var(--sky-50);    color: var(--sky-600); }
    .stat-card.indigo .stat-icon { background: var(--indigo-50); color: var(--indigo-600); }
    .stat-card.violet .stat-icon { background: var(--violet-50); color: var(--violet-600); }
    .stat-card.rose   .stat-icon { background: var(--rose-50);   color: var(--rose-600); }
    .stat-card.amber  .stat-icon { background: var(--amber-50);  color: var(--amber-600); }

    .stat-tag {
        font-size: .63rem; font-weight: 700;
        padding: .22rem .55rem; border-radius: 20px; letter-spacing: .2px;
    }
    .tag-blue   { background: var(--blue-100);   color: var(--blue-700); }
    .tag-teal   { background: var(--teal-100);   color: var(--teal-600); }
    .tag-sky    { background: var(--sky-50);     color: var(--sky-600); }
    .tag-indigo { background: var(--indigo-100); color: var(--indigo-600); }
    .tag-violet { background: var(--violet-100); color: var(--violet-600); }
    .tag-rose   { background: var(--rose-100);   color: var(--rose-600); }
    .tag-amber  { background: var(--amber-100);  color: var(--amber-600); }

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
    .pb-blue   { background: var(--blue-100);   color: var(--blue-700); }
    .pb-violet { background: var(--violet-100); color: var(--violet-600); }
    .pb-green  { background: var(--green-100);  color: var(--green-700); }
    .pb-orange { background: var(--orange-100); color: var(--orange-600); }
    .pb-rose   { background: var(--rose-100);   color: var(--rose-600); }
    .pb-amber  { background: var(--amber-100);  color: var(--amber-600); }

    
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
        background: linear-gradient(130deg, var(--blue-900) 0%, var(--blue-600) 100%);
        padding: 1.1rem 1.4rem;
        display: flex; align-items: center; gap: 1rem;
        position: relative; overflow: hidden;
    }
    .denda-grand::after {
        content: ''; position: absolute;
        width: 110px; height: 110px; border-radius: 50%;
        background: rgba(255,255,255,.06);
        right: -30px; top: -40px; pointer-events: none;
    }
    .denda-grand-icon {
        width: 44px; height: 44px; border-radius: 11px;
        background: rgba(255,255,255,.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; color: #fcd34d; flex-shrink: 0; z-index: 1;
    }
    .denda-grand-info { z-index: 1; }
    .denda-grand-info .dg-label {
        font-size: .68rem; text-transform: uppercase;
        letter-spacing: 1.3px; font-weight: 700;
        color: rgba(255,255,255,.75); margin-bottom: .2rem;
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
    .denda-split-card.lunas   { background: var(--green-50); border-color: #bbf7d0; }
    .denda-split-card.belum   { background: var(--rose-50);  border-color: #fecaca; }

    .dsc-header { display: flex; align-items: center; gap: .55rem; }
    .dsc-dot {
        width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
    }
    .lunas .dsc-dot   { background: var(--green-600); }
    .belum .dsc-dot   { background: var(--rose-600); }
    .dsc-label {
        font-size: .72rem; font-weight: 700;
    }
    .lunas .dsc-label { color: var(--green-700); }
    .belum .dsc-label { color: var(--rose-600); }

    .dsc-val {
        font-size: 1.1rem; font-weight: 800; color: var(--text);
        letter-spacing: -.3px; line-height: 1;
    }
    .dsc-sub { font-size: .7rem; font-weight: 500; color: var(--text-light); }

    
    .denda-progress { }
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
        display: flex; justify-content: space-between;
        margin-top: .4rem;
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

    
    .rank-num {
        width: 28px; height: 28px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .78rem; font-weight: 800;
    }
    .rank-1 { background: #fef3c7; color: #92400e; }
    .rank-2 { background: #f1f5f9; color: #475569; }
    .rank-3 { background: #fff7ed; color: #9a3412; }
    .rank-n { background: var(--border-soft); color: var(--text-muted); }

    
    .books-showcase {
        display: flex; gap: 1.1rem; overflow-x: auto;
        padding: 1.25rem 1.2rem 1.75rem;
        scroll-snap-type: x mandatory;
        scrollbar-width: thin; scrollbar-color: var(--blue-200) transparent;
        -webkit-overflow-scrolling: touch;
    }
    .books-showcase::-webkit-scrollbar { height: 5px; }
    .books-showcase::-webkit-scrollbar-thumb { background: var(--blue-200); border-radius: 10px; }

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
        box-shadow: 0 6px 14px rgba(37,99,235,.13);
        background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
        border: 1px solid rgba(255,255,255,.4);
    }
    .book-card-sleek .cover-box img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .45s ease;
    }
    .book-card-sleek:hover .cover-box img { transform: scale(1.07); }

    .book-card-sleek .rank-badge {
        position: absolute; top: 0; left: 0;
        background: linear-gradient(135deg, var(--blue-600), var(--blue-900));
        color: white; font-size: .72rem; font-weight: 800;
        padding: .28rem .55rem; border-bottom-right-radius: 11px;
        z-index: 2;
    }

    .book-card-sleek .borrow-stat {
        position: absolute; bottom: 0; left: 0; right: 0;
        background: rgba(15,23,42,.82); backdrop-filter: blur(8px);
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

    .mt-4 { margin-top: 1.5rem; }

    
    @media (max-width: 1280px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 1100px) {
        .chart-denda-layout { grid-template-columns: 1fr; }
        .monitoring-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px)  { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px)  { .stats-grid { grid-template-columns: 1fr; } }
    @media (max-width: 600px)  {
        .welcome-banner { flex-direction: column; gap: 1rem; align-items: flex-start; }
        .denda-split { grid-template-columns: 1fr; }
    }
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
                <span class="ph-icon" style="background:var(--blue-50);">
                    <i class="fas fa-chart-area" style="color:var(--blue-600);"></i>
                </span>
                Grafik Peminjaman — 7 Hari Terakhir
            </h3>
            <span class="panel-badge pb-blue">Live Data</span>
        </div>
        <div style="padding: 1.4rem 1.4rem 1.2rem; flex-grow: 1; min-height: 280px; display: flex; flex-direction: column;">
            <div style="flex-grow: 1; position: relative;">
                <canvas id="peminjamanChart"></canvas>
            </div>
        </div>
    </div>

    
    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:var(--amber-50);">
                    <i class="fas fa-wallet" style="color:var(--amber-600);"></i>
                </span>
                Ringkasan Denda
            </h3>
            <span class="panel-badge pb-amber">Keuangan</span>
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

            
            <div class="denda-progress">
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
                    @if($topStudents->isEmpty())
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 2.5rem 0; color: var(--text-light); font-size: .82rem;">
                            <i class="fas fa-inbox" style="font-size: 1.6rem; display: block; margin-bottom: .5rem; opacity: .3;"></i>
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
                <span class="ph-icon" style="background:var(--violet-100);">
                    <i class="fas fa-fire" style="color:var(--violet-600);"></i>
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
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--blue-200);font-size:2.8rem;">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif
                    <div class="borrow-stat">
                        <i class="fas fa-fire" style="color:#fbbf24;margin-right:.25rem;"></i>Dipinjam {{ $buku->total_dipinjam }}x
                    </div>
                </div>
                <div class="info-box">
                    <h4>{{ $buku->judul_buku }}</h4>
                    <p>{{ $buku->pengarang ?: 'Penulis tidak diketahui' }}</p>
                </div>
            </div>
            @endforeach
            @if($topBooks->isEmpty())
                <div style="width:100%;text-align:center;padding:3rem 0;color:var(--text-muted);">
                    <i class="fas fa-book-open" style="font-size:2.5rem;opacity:.2;display:block;margin-bottom:1rem;"></i>
                    <p style="font-weight:600;font-size:.88rem;">Belum ada buku yang populer</p>
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
    gradBlue.addColorStop(0, 'rgba(37, 99, 235, 0.20)');
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
                tension: 0.42,
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
                    ticks: { color: '#94a3b8', font: { size: 11, weight: '600' } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(226,232,240,.55)', drawTicks: false },
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