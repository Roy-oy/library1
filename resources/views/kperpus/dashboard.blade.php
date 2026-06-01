@extends('kperpus.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Kepala Perpustakaan')

@push('styles')
<style>
    /* ── Section Label ─── */
    .section-label {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.4px;
        color: #94a3b8;
        margin-bottom: .9rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    /* ── Stat Cards ─── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.8rem;
    }
    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.4rem;
        box-shadow: 0 2px 12px rgba(41, 128, 185, 0.05);
        display: flex;
        flex-direction: column;
        gap: .85rem;
        border: 1px solid rgba(41, 128, 185, 0.07);
        transition: all .25s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card::after {
        content: '';
        position: absolute;
        width: 90px; height: 90px;
        border-radius: 50%;
        right: -20px; top: -25px;
        opacity: .045;
    }
    .stat-card.blue   ::after { background: #3b82f6; }
    .stat-card.teal   ::after { background: #14b8a6; }
    .stat-card.sky    ::after { background: #0ea5e9; }
    .stat-card.indigo ::after { background: #6366f1; }
    .stat-card.violet ::after { background: #8b5cf6; }
    .stat-card.cyan   ::after { background: #06b6d4; }
    .stat-card.rose   ::after { background: #f43f5e; }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 28px rgba(41, 128, 185, 0.11);
        border-color: rgba(41, 128, 185, 0.18);
    }
    .stat-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .stat-icon {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .stat-card.blue   .stat-icon { background: #eff6ff; color: #3b82f6; }
    .stat-card.teal   .stat-icon { background: #f0fdfa; color: #14b8a6; }
    .stat-card.sky    .stat-icon { background: #f0f9ff; color: #0ea5e9; }
    .stat-card.indigo .stat-icon { background: #eef2ff; color: #6366f1; }
    .stat-card.violet .stat-icon { background: #f5f3ff; color: #8b5cf6; }
    .stat-card.cyan   .stat-icon { background: #ecfeff; color: #06b6d4; }
    .stat-card.rose   .stat-icon { background: #fff1f2; color: #f43f5e; }

    .stat-tag {
        font-size: .68rem;
        font-weight: 700;
        padding: .22rem .55rem;
        border-radius: 20px;
        letter-spacing: .3px;
    }
    .tag-blue   { background: #eff6ff; color: #3b82f6; }
    .tag-teal   { background: #f0fdfa; color: #14b8a6; }
    .tag-sky    { background: #f0f9ff; color: #0ea5e9; }
    .tag-indigo { background: #eef2ff; color: #6366f1; }
    .tag-violet { background: #f5f3ff; color: #8b5cf6; }
    .tag-cyan   { background: #ecfeff; color: #06b6d4; }
    .tag-rose   { background: #fff1f2; color: #f43f5e; }

    .stat-val { font-size: 2rem; font-weight: 800; color: #0f172a; line-height: 1; }
    .stat-lbl { font-size: .83rem; font-weight: 500; color: #64748b; }
    .stat-sub { font-size: .73rem; color: #b0bec5; font-weight: 500; margin-top: .1rem; }

    /* ── Monitoring Row ─── */
    .monitoring-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
        margin-bottom: 1.8rem;
    }

    /* ── Panel ─── */
    .panel {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(41, 128, 185, 0.05);
        border: 1px solid rgba(41, 128, 185, 0.07);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .panel-header {
        padding: 1.05rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; justify-content: space-between;
        background: #fafcff;
    }
    .panel-header h3 {
        font-size: .88rem;
        font-weight: 700;
        color: #1e293b;
        display: flex; align-items: center; gap: .6rem;
    }
    .ph-icon {
        width: 28px; height: 28px;
        border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .8rem;
    }
    .panel-badge {
        font-size: .68rem; font-weight: 700;
        padding: .25rem .65rem;
        border-radius: 20px;
    }
    .pb-blue   { background: #eff6ff; color: #3b82f6; }
    .pb-violet { background: #f5f3ff; color: #7c3aed; }
    .pb-green  { background: #f0fdf4; color: #16a34a; }
    .pb-orange { background: #fff7ed; color: #ea580c; }
    .pb-rose   { background: #fff1f2; color: #f43f5e; }

    /* ── Chart bottom layout ─── */
    .chart-denda-layout {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 1.2rem;
        margin-bottom: 1.8rem;
    }

    /* ── Denda Panel internals ─── */
    .denda-total-card {
        background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 60%, #60a5fa 100%);
        border-radius: 14px;
        padding: 1.3rem 1.5rem;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
        margin: 1.1rem 1.1rem .8rem;
        box-shadow: 0 8px 24px rgba(59, 130, 246, 0.28);
    }
    .denda-total-card::before {
        content: '';
        position: absolute;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,.06);
        top: -45px; right: -35px;
    }
    .denda-total-lbl { font-size: .72rem; font-weight: 700; opacity: .85; text-transform: uppercase; letter-spacing: 1.1px; }
    .denda-total-val { font-size: 1.75rem; font-weight: 900; margin-top: .3rem; letter-spacing: -.5px; }

    .denda-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .8rem;
        padding: 0 1.1rem;
        margin-bottom: .9rem;
    }
    .denda-box {
        border-radius: 12px;
        padding: .95rem 1rem;
        border: 1px solid;
    }
    .denda-box.green { background: #f0fdf4; border-color: #bbf7d0; }
    .denda-box.red   { background: #fef2f2; border-color: #fecaca; }
    .denda-box .db-lbl { font-size: .73rem; font-weight: 600; color: #64748b; margin-bottom: .3rem; display: flex; align-items: center; gap: .35rem; }
    .denda-box.green .db-lbl i { color: #16a34a; }
    .denda-box.red   .db-lbl i { color: #dc2626; }
    .denda-box .db-val { font-size: 1.1rem; font-weight: 800; color: #0f172a; }

    .progress-section { padding: 0 1.1rem 1.1rem; }
    .progress-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: .5rem; }
    .progress-header span { font-size: .78rem; font-weight: 600; color: #475569; }
    .progress-header .pct { font-weight: 800; color: #3b82f6; }
    .progress-track { height: 9px; background: #f1f5f9; border-radius: 99px; overflow: hidden; }
    .progress-fill  { height: 100%; background: linear-gradient(90deg, #3b82f6, #10b981); border-radius: 99px; transition: width 1s ease; }

    /* ── Petugas cards ─── */
    .petugas-list { padding: .8rem 1rem; display: flex; flex-direction: column; gap: .6rem; }
    .petugas-item {
        display: flex;
        align-items: center;
        gap: .9rem;
        padding: .75rem 1rem;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e8edf3;
    }
    .petugas-avatar {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
        display: flex; align-items: center; justify-content: center;
        font-size: .85rem; font-weight: 800; color: #4f46e5;
        flex-shrink: 0;
    }
    .petugas-name { font-size: .83rem; font-weight: 700; color: #1e293b; }
    .petugas-role { font-size: .72rem; color: #94a3b8; font-weight: 500; }
    .petugas-status {
        margin-left: auto;
        font-size: .68rem; font-weight: 700;
        padding: .2rem .55rem;
        border-radius: 20px;
    }
    .ps-active   { background: #f0fdf4; color: #16a34a; }

    /* ── Activity log ─── */
    .activity-list { padding: .8rem 1rem; display: flex; flex-direction: column; gap: 0; }
    .activity-item {
        display: flex;
        gap: 1rem;
        padding: .75rem 0;
        border-bottom: 1px solid #f1f5f9;
        position: relative;
    }
    .activity-item:last-child { border-bottom: none; }
    .act-line {
        position: absolute;
        left: 15px; top: 36px; bottom: -10px;
        width: 2px;
        background: #f1f5f9;
    }
    .activity-item:last-child .act-line { display: none; }
    .act-dot {
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: .75rem;
        flex-shrink: 0;
        z-index: 1;
    }
    .act-dot.blue   { background: #eff6ff; color: #3b82f6; }
    .act-dot.green  { background: #f0fdf4; color: #16a34a; }
    .act-dot.violet { background: #f5f3ff; color: #7c3aed; }
    .act-dot.orange { background: #fff7ed; color: #ea580c; }
    .act-dot.rose   { background: #fff1f2; color: #f43f5e; }
    .act-body .act-title { font-size: .83rem; font-weight: 600; color: #1e293b; }
    .act-body .act-time  { font-size: .72rem; color: #94a3b8; font-weight: 500; margin-top: .15rem; }

    /* ── Empty state ─── */
    .empty-state {
        padding: 2.5rem;
        text-align: center;
        color: #b0bec5;
        font-size: .85rem;
    }
    .empty-state i { font-size: 2rem; display: block; margin-bottom: .6rem; opacity: .4; }

    @media (max-width: 1300px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 1100px) {
        .chart-denda-layout { grid-template-columns: 1fr; }
        .monitoring-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
    }

    /* ── Welcome Banner ─── */
    .welcome-banner {
        background: linear-gradient(135deg, #4a90e2, #357abd);
        border-radius: 16px;
        padding: 2rem;
        color: #ffffff;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 25px rgba(74, 144, 226, 0.25);
        position: relative;
        overflow: hidden;
    }
    .welcome-banner > div:first-child {
        z-index: 1;
    }
    .welcome-banner h2 {
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }
    .welcome-banner p {
        font-size: 0.95rem;
        opacity: 0.9;
        font-weight: 500;
        max-width: 600px;
        line-height: 1.5;
    }
    .welcome-banner .banner-buttons {
        display: flex;
        gap: 1rem;
        z-index: 1;
    }
    .welcome-banner .banner-btn {
        background: var(--danger);
        color: white;
        border-radius: 12px;
        padding: 0.8rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
        animation: pulse 2s infinite;
        font-size: 0.85rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .welcome-banner .banner-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(231, 76, 60, 0.5);
    }
    .welcome-banner .banner-btn i {
        font-size: 1.3rem;
    }
    .welcome-banner .banner-btn-text-main {
        display: block;
        font-weight: 800;
        font-size: 0.95rem;
        line-height: 1.2;
    }
    .welcome-banner .banner-btn-text-sub {
        display: block;
        font-size: 0.7rem;
        opacity: 0.9;
    }
    .welcome-banner .banner-access {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        text-align: center;
        backdrop-filter: blur(10px);
        flex-shrink: 0;
        z-index: 1;
    }
    .welcome-banner .banner-access .access-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        opacity: 0.8;
        font-weight: 700;
        margin-bottom: 0.3rem;
    }
    .welcome-banner .banner-access .access-role {
        font-size: 1.05rem;
        font-weight: 800;
        color: #f1c40f;
    }
    .welcome-banner .banner-bg-icon {
        position: absolute;
        right: -50px;
        bottom: -50px;
        font-size: 15rem;
        color: rgba(255, 255, 255, 0.05);
        transform: rotate(-15deg);
        pointer-events: none;
    }

    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.7); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(231, 76, 60, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(231, 76, 60, 0); }
    }
</style>
@endpush

@section('content')

{{-- ── Welcome Banner ───────────────────────────────────── --}}
<div class="welcome-banner">
    <div class="banner-bg-icon">
        <i class="fas fa-chart-line"></i>
    </div>
    <div>
        <h2>Halo, {{ auth()->user()->name ?? 'Kepala Perpustakaan' }}! 👋</h2>
        <p>Selamat bertugas &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
    <div class="banner-buttons">
        <div class="banner-access">
            <div class="access-label"><i class="fas fa-shield-alt"></i> Hak Akses</div>
            <div class="access-role">{{ auth()->user()->getRoleLabel() ?? 'Administrator' }}</div>
        </div>
    </div>
</div>

{{-- ── Statistik Koleksi & Pengelolaan ───────────────────── --}}
<div class="section-label">
    <i class="fas fa-layer-group" style="color:#94a3b8;"></i> Statistik Koleksi & Pengelolaan
</div>
<div class="stats-grid" style="margin-bottom:1.8rem;">

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



{{-- ── Grafik + Denda ──────────────────────────────────────── --}}
<div class="section-label">
    <i class="fas fa-chart-bar" style="color:#94a3b8;"></i> Analitik Peminjaman & Laporan Keuangan
</div>
<div class="chart-denda-layout">

    {{-- Chart Panel --}}
    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:#eff6ff;">
                    <i class="fas fa-chart-area" style="color:#3b82f6;font-size:.8rem;"></i>
                </span>
                Grafik Peminjaman — 7 Hari Terakhir
            </h3>
            <span class="panel-badge pb-blue">Live Data</span>
        </div>
        <div style="padding: 1.4rem; flex-grow: 1; min-height: 300px; display: flex; flex-direction: column;">
            <div style="flex-grow: 1; position: relative;">
                <canvas id="peminjamanChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Denda Panel --}}
    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:#fff7ed;">
                    <i class="fas fa-wallet" style="color:#ea580c;font-size:.8rem;"></i>
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

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('peminjamanChart').getContext('2d');

    const chartData  = @json(array_values($borrowingsLast7Days));
    const labels     = chartData.map(item => item.label);
    const dataValues = chartData.map(item => item.count);

    const gradBlue = ctx.createLinearGradient(0, 0, 0, 300);
    gradBlue.addColorStop(0, 'rgba(59, 130, 246, 0.30)');
    gradBlue.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Peminjaman',
                data: dataValues,
                borderColor: '#3b82f6',
                borderWidth: 2.5,
                backgroundColor: gradBlue,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2.5,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointHoverBackgroundColor: '#3b82f6',
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
                    ticks: { color: '#94a3b8', font: { family: 'Nunito', size: 11, weight: 600 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(226,232,240,0.5)', drawTicks: false },
                    border: { dash: [4, 4] },
                    ticks: { precision: 0, color: '#94a3b8', font: { family: 'Nunito', size: 11, weight: 600 }, stepSize: 5 }
                }
            }
        }
    });
});
</script>
@endpush