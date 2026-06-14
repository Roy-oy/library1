@extends('ksekolah.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Kepala Sekolah')

@push('styles')
<style>
    /* ─── Base Tokens Perbaikan ─────────────────────────── */
    :root {
        --slate-50:   #f8fafc;
        --slate-100:  #f1f5f9;
        --slate-200:  #e2e8f0;
        --blue-50:    #fffbeb;
        --blue-100:   #fef3c7;
        --blue-200:   #fde68a;
        --blue-600:   #d97706;
        --blue-700:   #b45309;
        --indigo-50:  #f8fafc;
        --indigo-100: #e2e8f0;
        --indigo-600: #4b5563;
        --rose-50:    #fff1f2;
        --rose-100:   #ffe4e6;
        --rose-600:   #e11d48;
        --amber-50:   #fffbeb;
        --amber-100:  #fef3c7;
        --amber-600:  #d97706;
    }

    /* ─── Section Label ───────────────────────────────── */
    .section-label {
        font-size: .68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.6px;
        color: var(--text-light);
        margin-bottom: 1.1rem;
        margin-top: 1.5rem;
        display: flex; align-items: center; gap: .5rem;
    }
    .section-label i { color: var(--blue-600); font-size: .75rem; }
    .section-label::after {
        content: ''; flex: 1; height: 1px;
        background: var(--border);
    }

    /* ─── Welcome Banner ──────────────────────────────── */
    .welcome-banner {
        background: linear-gradient(135deg, #b45309 0%, #d97706 50%, #f59e0b 100%);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        color: #fff;
        margin-bottom: 2rem;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 10px 32px rgba(217, 119, 6, 0.15);
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

    .banner-badge-role {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: .7rem 1.2rem;
        text-align: center;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 1; flex-shrink: 0;
    }

    .banner-bg-icon {
        position: absolute; right: -30px; bottom: -35px;
        font-size: 11rem; color: rgba(255,255,255,.03);
        transform: rotate(-18deg); pointer-events: none; z-index: 0;
    }

    /* ─── Stats Grid ──────────────────────────────────── */
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
        border-color: rgba(217, 119, 6, 0.2);
    }
    .stat-card::before {
        content: ''; position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        border-radius: 18px 18px 0 0;
    }
    .stat-card.blue::before   { background: linear-gradient(90deg, #d97706, #fbbf24); }
    .stat-card.indigo::before { background: linear-gradient(90deg, #4b5563, #9ca3af); }
    .stat-card.amber::before  { background: linear-gradient(90deg, #d97706, #fbbf24); }
    .stat-card.rose::before   { background: linear-gradient(90deg, #e11d48, #fb7185); }

    .stat-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .stat-card.blue   .stat-icon { background: var(--blue-50);   color: var(--blue-600); }
    .stat-card.indigo .stat-icon { background: var(--indigo-50); color: var(--indigo-600); }
    .stat-card.amber  .stat-icon { background: var(--amber-50);  color: var(--amber-600); }
    .stat-card.rose   .stat-icon { background: var(--rose-50);   color: var(--rose-600); }

    .stat-card-top {
        display: flex; align-items: flex-start; justify-content: space-between;
    }
    .stat-tag {
        font-size: .63rem; font-weight: 700;
        padding: .22rem .55rem; border-radius: 20px; letter-spacing: .2px;
    }
    .tag-blue   { background: var(--blue-100);   color: var(--blue-700); }
    .tag-indigo { background: var(--indigo-100); color: var(--indigo-600); }
    .tag-amber  { background: var(--amber-100);  color: var(--amber-600); }
    .tag-rose   { background: var(--rose-100);   color: var(--rose-600); }

    .stat-val { font-size: 1.8rem; font-weight: 800; color: var(--text); line-height: 1; }
    .stat-lbl { font-size: .83rem; font-weight: 700; color: var(--text-muted); margin-top: .3rem; }

    /* ─── Panel & Tables ─────────────────────────────── */
    .panels-grid {
        display: grid; grid-template-columns: 1.5fr 1.2fr;
        gap: 1.25rem; margin-bottom: 2rem;
    }
    .panel {
        background: var(--surface); border-radius: 18px;
        box-shadow: var(--shadow-sm); border: 1px solid var(--border);
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
        display: flex; align-items: center; gap: .65rem; margin: 0;
    }
    .ph-icon {
        width: 28px; height: 28px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .8rem; flex-shrink: 0;
    }
    .panel-badge {
        font-size: .63rem; font-weight: 700;
        padding: .22rem .65rem; border-radius: 20px;
        text-decoration: none;
    }
    .pb-blue   { background: var(--blue-100);   color: var(--blue-700); }
    .pb-indigo { background: var(--indigo-100); color: var(--indigo-600); }

    .table-responsive { overflow-x: auto; }
    .table { width: 100%; border-collapse: collapse; }
    .table th {
        text-align: left; padding: .65rem 1rem;
        border-bottom: 1px solid var(--border-soft);
        font-size: .68rem; text-transform: uppercase;
        letter-spacing: .8px; color: var(--text-light); font-weight: 700;
        background: var(--slate-50);
    }
    .table td { padding: .8rem 1rem; border-bottom: 1px solid var(--border-soft); }
    .table tr:last-child td { border-bottom: none; }
    .table tbody tr:hover td { background: var(--slate-50); }

    .code-badge {
        font-family: monospace; font-size: .78rem;
        background: var(--slate-100); color: var(--blue-700);
        padding: .2rem .45rem; border-radius: 6px; font-weight: 700;
        border: 1px solid var(--slate-200);
    }

    .pill { display: inline-flex; align-items: center; gap: .3rem; padding: .25rem .7rem; border-radius: 20px; font-size: .7rem; font-weight: 700; }
    .pill-success { background: #dcfce7; color: #15803d; }
    .pill-danger  { background: #fee2e2; color: #b91c1c; }
    .pill-info    { background: #eff6ff; color: #1e40af; }
    .pill-warning { background: #fef3c7; color: #b45309; }

    .empty-state {
        padding: 2.5rem; text-align: center;
        color: var(--text-light); font-size: .84rem;
    }
    .empty-state i { font-size: 2rem; display: block; margin-bottom: .6rem; opacity: .35; }

    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .panels-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 600px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

{{-- ─────────────────── WELCOME BANNER ─────────────────── --}}
<div class="welcome-banner">
    <div class="banner-bg-icon"><i class="fas fa-school"></i></div>
    <div>
        <h2>Halo, {{ auth()->user()->name ?? 'Kepala Sekolah' }}! 👋</h2>
        <p>Ringkasan laporan perpustakaan sekolah &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
    <div class="banner-badge-role">
        <div style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1.2px; opacity: 0.8; font-weight: 700; margin-bottom: 0.15rem;">Hak Akses</div>
        <div style="font-size: 0.9rem; font-weight: 800; color: #fbbf24;"><i class="fas fa-shield-alt" style="margin-right: 5px;"></i>{{ auth()->user()->getRoleLabel() ?? 'Kepala Sekolah' }}</div>
    </div>
</div>

{{-- ─────────────────── STATS GRID ─────────────────────── --}}
<div class="section-label">
    <i class="fas fa-chart-pie"></i> Statistik Ringkasan Koleksi & Siswa
</div>
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
            <span class="stat-tag tag-blue">Siswa</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_siswa']) }}</div>
            <div class="stat-lbl">Jumlah Siswa</div>
        </div>
    </div>
    
    <div class="stat-card indigo">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-book"></i></div>
            <span class="stat-tag tag-indigo">Semua Buku</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_buku']) }}</div>
            <div class="stat-lbl">Total Judul Buku</div>
        </div>
    </div>

    <div class="stat-card amber">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-university"></i></div>
            <span class="stat-tag tag-amber">Perpus</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_buku_perpus']) }}</div>
            <div class="stat-lbl">Buku Perpustakaan</div>
        </div>
    </div>

    <div class="stat-card rose">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-hand-holding-usd"></i></div>
            <span class="stat-tag tag-rose">BOS</span>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['total_buku_bos']) }}</div>
            <div class="stat-lbl">Koleksi Buku BOS</div>
        </div>
    </div>
</div>

{{-- ─────────────────── CHARTS & TABLES ─────────────────── --}}
<div class="section-label">
    <i class="fas fa-sync-alt"></i> Analisis Grafik & Aktivitas Terbaru Perpustakaan
</div>
<div class="panels-grid">
    
    {{-- Chart Panel --}}
    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:var(--blue-50);">
                    <i class="fas fa-chart-area" style="color:var(--blue-600);"></i>
                </span>
                Grafik Peminjaman Buku (7 Hari Terakhir)
            </h3>
            <span class="panel-badge pb-blue">Tren Real-time</span>
        </div>
        <div style="padding: 1.4rem; flex-grow: 1; min-height: 310px; position: relative;">
            <canvas id="borrowingsChart" style="width:100%; height:100%;"></canvas>
        </div>
    </div>

    {{-- Table Panel --}}
    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:var(--indigo-50);">
                    <i class="fas fa-history" style="color:var(--indigo-600);"></i>
                </span>
                Aktivitas Terbaru
            </h3>
            <a href="{{ route('ksekolah.report.aktivitas.index') }}" class="panel-badge pb-indigo">
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
                                <span class="pill pill-info"><i class="fas fa-book-reader"></i> Dipinjam</span>
                            @elseif($activity->status_detail === 'dikembalikan')
                                <span class="pill pill-success"><i class="fas fa-check"></i> Kembali</span>
                            @elseif($activity->status_detail === 'terlambat')
                                <span class="pill pill-danger"><i class="fas fa-exclamation-triangle"></i> Lambat</span>
                            @elseif($activity->status_detail === 'hilang')
                                <span class="pill pill-warning"><i class="fas fa-times-circle"></i> Hilang</span>
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

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('borrowingsChart').getContext('2d');
        
        const chartData = @json(array_values($borrowingsLast7Days));
        const labels = chartData.map(item => item.label);
        const dataValues = chartData.map(item => item.count);

        /* Gradien Baru Menggunakan Warna Amber Gold Mewah */
        const gradient = ctx.createLinearGradient(0, 0, 0, 260);
        gradient.addColorStop(0, 'rgba(217, 119, 6, 0.25)'); 
        gradient.addColorStop(1, 'rgba(217, 119, 6, 0.01)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Aktivitas Peminjaman',
                    data: dataValues,
                    borderColor: '#d97706', 
                    borderWidth: 2.5,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#d97706',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#b45309',
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
                        backgroundColor: '#111827',
                        titleColor: '#9ca3af',
                        bodyColor: '#ffffff',
                        cornerRadius: 8,
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return ` ${context.parsed.y} Peminjaman`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#4b5563',
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 10, weight: 600 }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9', drawTicks: false },
                        ticks: {
                            precision: 0,
                            color: '#4b5563',
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 10, weight: 600 },
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endpush