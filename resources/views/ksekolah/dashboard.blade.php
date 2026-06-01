@extends('ksekolah.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Kepala Sekolah')

@push('styles')
<style>
    /* ── Stat Cards ─── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(32, 201, 151, 0.05);
        display: flex; align-items: center; gap: 1.2rem;
        border: 1px solid rgba(32, 201, 151, 0.08);
        transition: all .3s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute; top: 0; left: 0; width: 100%; height: 4px;
        opacity: 0; transition: opacity .3s ease;
    }
    .stat-card.blue::before   { background: linear-gradient(90deg, #0284c7, #3b82f6); }
    .stat-card.teal::before   { background: linear-gradient(90deg, #0d9488, #10b981); }
    .stat-card.sky::before    { background: linear-gradient(90deg, #0369a1, #0ea5e9); }
    .stat-card.indigo::before { background: linear-gradient(90deg, #4f46e5, #6366f1); }
    .stat-card.cyan::before   { background: linear-gradient(90deg, #0891b2, #06b6d4); }
    .stat-card.red::before    { background: linear-gradient(90deg, #dc2626, #ef4444); }
    .stat-card.orange::before { background: linear-gradient(90deg, #ea580c, #f97316); }
    .stat-card.purple::before { background: linear-gradient(90deg, #7e22ce, #a855f7); }
    .stat-card.green::before  { background: linear-gradient(90deg, #15803d, #22c55e); }

    .stat-card:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 12px 30px rgba(32, 201, 151, 0.12); 
        border-color: rgba(32, 201, 151, 0.2); 
    }
    .stat-card:hover::before { opacity: 1; }

    .stat-icon {
        width: 54px; height: 54px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
    }
    .stat-card.blue   .stat-icon { background: linear-gradient(135deg, #e0f2fe, #bae6fd); color: #0284c7; }
    .stat-card.indigo .stat-icon { background: linear-gradient(135deg, #e0e7ff, #c7d2fe); color: #4f46e5; }
    .stat-card.cyan   .stat-icon { background: linear-gradient(135deg, #cffafe, #a5f3fc); color: #0891b2; }
    .stat-card.teal   .stat-icon { background: linear-gradient(135deg, #ccfbf1, #99f6e4); color: #0d9488; }
    .stat-card.sky    .stat-icon { background: linear-gradient(135deg, #f0f9ff, #e0f2fe); color: #0369a1; }
    .stat-card.red    .stat-icon { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #dc2626; }
    .stat-card.orange .stat-icon { background: linear-gradient(135deg, #ffedd5, #fed7aa); color: #ea580c; }
    .stat-card.purple .stat-icon { background: linear-gradient(135deg, #f3e8ff, #e9d5ff); color: #7e22ce; }
    .stat-card.green  .stat-icon { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #15803d; }

    .stat-body { width: 100%; }
    .stat-body .value { font-size: 1.8rem; font-weight: 800; color: #1e293b; line-height: 1; margin-bottom: .3rem;}
    .stat-body .label { font-size: .85rem; font-weight: 500; color: #64748b; }

    .panels-row {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        align-items: stretch;
    }
    .panel {
        background: var(--surface);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(32, 201, 151, 0.05);
        border: 1px solid rgba(32, 201, 151, 0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .panel-header {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid rgba(32, 201, 151, 0.08);
        display: flex; align-items: center; justify-content: space-between;
        background: #fafcff;
    }
    .panel-header h3 { font-size: .92rem; font-weight: 700; color: var(--text); }
    .badge {
        font-size: .72rem; font-weight: 700;
        padding: .25rem .65rem;
        border-radius: 20px;
    }
    .badge-blue   { background: #eaf0f8; color: var(--primary); }
    .badge-orange { background: #fef9ec; color: var(--warning); }
    .badge-green  { background: #eafaf1; color: var(--success); }

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
    .pill-info    { background: #ebf5fb; color: var(--info); }
    .pill-warning { background: #fef9ec; color: var(--warning); }

    .empty-state {
        padding: 2.5rem;
        text-align: center;
        color: var(--text-muted);
        font-size: .88rem;
    }
    .empty-state i { font-size: 2rem; display: block; margin-bottom: .6rem; opacity: .4; }

    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="welcome-banner" style="background: linear-gradient(135deg, #0f766e, #14b8a6); border-radius: 16px; padding: 2rem; color: #ffffff; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 10px 25px rgba(20, 184, 166, 0.15); position: relative; overflow: hidden;">
    <div style="position: absolute; right: -50px; bottom: -50px; font-size: 15rem; color: rgba(255, 255, 255, 0.05); transform: rotate(-15deg); pointer-events: none;">
        <i class="fas fa-school"></i>
    </div>
    <div style="z-index: 1;">
        <h2 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 0.5rem; letter-spacing: -0.5px;">Halo, {{ auth()->user()->name ?? 'Kepala Sekolah' }}! 👋</h2>
        <p style="font-size: 0.95rem; opacity: 0.9; font-weight: 500; max-width: 600px; line-height: 1.5;">Ringkasan laporan perpustakaan sekolah &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
    <div style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px; padding: 1rem 1.5rem; text-align: center; backdrop-filter: blur(10px); z-index: 1; flex-shrink: 0;">
        <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; opacity: 0.8; font-weight: 700; margin-bottom: 0.3rem;">Hak Akses</div>
        <div style="font-size: 1.05rem; font-weight: 800; color: #f1c40f;"><i class="fas fa-shield-alt" style="margin-right: 5px;"></i>{{ auth()->user()->getRoleLabel() ?? 'Administrator' }}</div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card purple">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['total_siswa']) }}</div>
            <div class="label">Jumlah Siswa</div>
        </div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-book"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['total_buku']) }}</div>
            <div class="label">Total Buku</div>
        </div>
    </div>
    <div class="stat-card sky">
        <div class="stat-icon"><i class="fas fa-book-reader"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['total_buku_perpus']) }}</div>
            <div class="label">Buku Perpustakaan</div>
        </div>
    </div>
    <div class="stat-card orange">
        <div class="stat-icon"><i class="fas fa-gift"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['total_buku_bos']) }}</div>
            <div class="label">Buku BOS</div>
        </div>
    </div>
</div>

<div class="panels-row">
    <!-- Chart Panel -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-chart-line" style="color:var(--primary);margin-right:.45rem"></i>Grafik Peminjaman Buku (7 Hari Terakhir)</h3>
            <span class="badge badge-green">Tren Harian</span>
        </div>
        <div style="padding: 1.4rem; position: relative; height: 320px;">
            <canvas id="borrowingsChart" style="width: 100%; height: 100%;"></canvas>
        </div>
    </div>
    
    <!-- Table Panel -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-list-alt" style="color:var(--primary);margin-right:.45rem"></i>Aktivitas Terbaru</h3>
            <a href="{{ route('ksekolah.report.aktivitas.index') }}" class="badge badge-blue" style="text-decoration: none; display: inline-flex; align-items: center; gap: .3rem;">Lihat Laporan Lengkap <i class="fas fa-arrow-right"></i></a>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode Peminjaman</th>
                        <th>Siswa</th>
                        <th>Buku</th>
                        <th>Status</th>
                        <th>Waktu Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_activities as $activity)
                    <tr>
                        <td style="font-family: monospace; font-weight: 700; color: var(--primary);">
                            {{ $activity->peminjaman->kode_peminjaman }}
                        </td>
                        <td>
                            <div style="font-weight: 700">{{ $activity->peminjaman->siswa->nama_siswa ?? '-' }}</div>
                            <div style="font-size: .75rem; color: var(--text-muted)">{{ $activity->peminjaman->siswa->kelas ?? '-' }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600">{{ $activity->buku->judul_buku ?? '-' }}</div>
                        </td>
                        <td>
                            @if($activity->status_detail === 'dipinjam')
                                <span class="pill pill-info"><i class="fas fa-book-reader"></i> Dipinjam</span>
                            @elseif($activity->status_detail === 'dikembalikan')
                                <span class="pill pill-success"><i class="fas fa-check"></i> Dikembalikan</span>
                            @elseif($activity->status_detail === 'terlambat')
                                <span class="pill pill-danger"><i class="fas fa-exclamation-triangle"></i> Terlambat</span>
                            @elseif($activity->status_detail === 'hilang')
                                <span class="pill pill-warning"><i class="fas fa-times-circle"></i> Hilang</span>
                            @else
                                <span class="pill pill-info">{{ ucfirst($activity->status_detail) }}</span>
                            @endif
                        </td>
                        <td style="font-size: .8rem; color: var(--text-muted);">
                            {{ $activity->updated_at->diffForHumans() }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                Belum ada aktivitas terbaru.
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
        
        // Extract chart data from Blade variables
        const chartData = @json(array_values($borrowingsLast7Days));
        const labels = chartData.map(item => item.label);
        const dataValues = chartData.map(item => item.count);

        // Gradient color for dataset
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(32, 201, 151, 0.45)'); // primary teal color
        gradient.addColorStop(1, 'rgba(32, 201, 151, 0.01)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Aktivitas Peminjaman',
                    data: dataValues,
                    borderColor: '#20c997', // primary teal color
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#20c997',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#1aa179',
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
                                return ` ${context.parsed.y} Peminjaman`;
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
                                family: "'Nunito', sans-serif",
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
                                family: "'Nunito', sans-serif",
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