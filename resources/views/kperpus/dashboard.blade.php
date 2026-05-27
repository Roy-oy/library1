@extends('kperpus.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Kepala Perpustakaan')

@push('styles')
<style>
    /* ── Stat Cards ─── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(41, 128, 185, 0.05);
        display: flex; align-items: center; gap: 1.2rem;
        border: 1px solid rgba(41, 128, 185, 0.08);
        transition: all .3s ease;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute; top: 0; left: 0; width: 100%; height: 4px;
        background: linear-gradient(90deg, #3498db, #2980b9);
        opacity: 0; transition: opacity .3s ease;
    }
    .stat-card:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 12px 30px rgba(41, 128, 185, 0.12); 
        border-color: rgba(41, 128, 185, 0.2); 
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

    .stat-body .value { font-size: 1.8rem; font-weight: 800; color: #1e293b; line-height: 1; margin-bottom: .3rem;}
    .stat-body .label { font-size: .85rem; font-weight: 500; color: #64748b; }

    .dashboard-layout {
        display: grid;
        grid-template-columns: 1.5fr 1fr; /* Chart takes more, denda summary takes less space */
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        align-items: stretch; /* Make both panels equal height */
    }
    .panel {
        background: var(--surface);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(41, 128, 185, 0.05);
        border: 1px solid rgba(41, 128, 185, 0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .panel-header {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid rgba(41, 128, 185, 0.08);
        display: flex; align-items: center; justify-content: space-between;
        background: #fafcff;
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

    @media (max-width: 1024px) {
        .dashboard-layout { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-book-open"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['total_buku'] ?? 0) }}</div>
            <div class="label">Total Koleksi Buku</div>
        </div>
    </div>
    <div class="stat-card indigo">
        <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['total_siswa'] ?? 0) }}</div>
            <div class="label">Total Siswa Terdaftar</div>
        </div>
    </div>
    <div class="stat-card cyan">
        <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['peminjaman_aktif'] ?? 0) }}</div>
            <div class="label">Peminjaman Aktif</div>
        </div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['terlambat'] ?? 0) }}</div>
            <div class="label">Buku Terlambat</div>
        </div>
    </div>
</div>

<div class="dashboard-layout">
    <!-- Chart Panel -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-chart-area" style="margin-right: 8px; color: #3498db;"></i>Grafik Peminjaman Buku</h3>
        </div>
        <div class="card-body" style="padding: 1.5rem; background: #ffffff; flex-grow: 1; min-height: 300px; display: flex; flex-direction: column;">
            <div style="flex-grow: 1; position: relative;">
                <canvas id="peminjamanChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Fines Summary Panel -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-wallet" style="margin-right: 8px; color: #f39c12;"></i>Ringkasan Keuangan Denda</h3>
            <span class="badge" style="background: rgba(243, 156, 18, 0.1); color: #f39c12; padding: .4rem .8rem; font-size: .75rem;">Status Denda</span>
        </div>
        <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; flex-grow: 1;">
            
            <div style="background: linear-gradient(135deg, #6baed6, #3182bd); border-radius: 12px; padding: 1.5rem; text-align: center; color: white; position: relative; overflow: hidden; box-shadow: 0 4px 15px rgba(49, 130, 189, 0.3);">
                <i class="fas fa-coins" style="position: absolute; right: -10px; bottom: -10px; font-size: 5rem; opacity: 0.1;"></i>
                <div style="font-size: 0.85rem; font-weight: 600; opacity: 0.9; text-transform: uppercase; letter-spacing: 1px;">Total Akumulasi Denda</div>
                <div style="font-size: 2.2rem; font-weight: 800; margin-top: 0.5rem;">Rp {{ number_format($stats['total_denda_grand'], 0, ',', '.') }}</div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; flex-grow: 1;">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.2rem; display: flex; flex-direction: column; justify-content: center;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #64748b; margin-bottom: 0.3rem;"><i class="fas fa-check-circle" style="color: #2ecc71; margin-right: 5px;"></i>Lunas</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #1e293b;">Rp {{ number_format($stats['denda_lunas'], 0, ',', '.') }}</div>
                </div>
                <div style="background: #fff5f5; border: 1px solid #fee2e2; border-radius: 12px; padding: 1.2rem; display: flex; flex-direction: column; justify-content: center;">
                    <div style="font-size: 0.8rem; font-weight: 600; color: #ef4444; margin-bottom: 0.3rem;"><i class="fas fa-clock" style="color: #ef4444; margin-right: 5px;"></i>Belum Lunas</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #1e293b;">Rp {{ number_format($stats['denda_belum_lunas'], 0, ',', '.') }}</div>
                </div>
            </div>

            @php
                $percentLunas = ($stats['total_denda_grand'] > 0) ? round(($stats['denda_lunas'] / $stats['total_denda_grand']) * 100, 1) : 0;
            @endphp
            <div style="margin-top: 0.5rem;">
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem; color: #475569;">
                    <span>Persentase Denda Dilunasi</span>
                    <span style="color: #3b82f6;">{{ $percentLunas }}%</span>
                </div>
                <div style="height: 10px; background: #f1f5f9; border-radius: 5px; overflow: hidden;">
                    <div style="height: 100%; width: {{ $percentLunas }}%; background: linear-gradient(90deg, #3498db, #2ecc71); border-radius: 5px; transition: width 1s ease;"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="dashboard-layout" style="margin-top: 1.5rem;">
    <!-- Top Books Panel -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-trophy" style="margin-right: 8px; color: #f1c40f;"></i>Buku Terpopuler (Top 5)</h3>
            <span class="badge badge-blue">Paling Sering Dipinjam</span>
        </div>
        <div style="padding: 1rem; flex-grow: 1;">
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 60px; text-align: center;">Rank</th>
                            <th>Judul Buku</th>
                            <th style="text-align: center; width: 120px;">Total Dipinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topBooks as $index => $item)
                            @if($item->buku)
                            <tr>
                                <td style="text-align: center; font-weight: 800; color: {{ $index == 0 ? '#f1c40f' : ($index == 1 ? '#95a5a6' : ($index == 2 ? '#d35400' : '#64748b')) }}; font-size: 1.1rem;">
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--text);">{{ $item->buku->judul_buku }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">ISBN: {{ $item->buku->isbn ?? '-' }}</div>
                                </td>
                                <td style="text-align: center; font-weight: 800; color: var(--primary);">
                                    {{ $item->total }}x
                                </td>
                            </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="empty-state">
                                        <i class="fas fa-book-reader"></i>
                                        Belum ada data peminjaman buku
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Students Panel -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-award" style="margin-right: 8px; color: #2ecc71;"></i>Siswa Teraktif (Top 5)</h3>
            <span class="badge badge-green">Peminjam Terbanyak</span>
        </div>
        <div style="padding: 1rem; flex-grow: 1;">
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 60px; text-align: center;">Rank</th>
                            <th>Nama Siswa</th>
                            <th style="text-align: center; width: 120px;">Total Pinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topStudents as $index => $item)
                            @if($item->siswa)
                            <tr>
                                <td style="text-align: center; font-weight: 800; color: {{ $index == 0 ? '#f1c40f' : ($index == 1 ? '#95a5a6' : ($index == 2 ? '#d35400' : '#64748b')) }}; font-size: 1.1rem;">
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: var(--text);">{{ $item->siswa->nama_siswa }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">NIS: {{ $item->siswa->nis }} &bull; Kelas {{ $item->siswa->kelas }}</div>
                                </td>
                                <td style="text-align: center; font-weight: 800; color: var(--success);">
                                    {{ $item->total }}x
                                </td>
                            </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        Belum ada data aktivitas siswa
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('peminjamanChart').getContext('2d');
    
    // Extract chart data from Blade variables
    const chartData = @json(array_values($borrowingsLast7Days));
    const labels = chartData.map(item => item.label);
    const dataValues = chartData.map(item => item.count);

    // Gradient for Peminjaman
    let gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
    gradientBlue.addColorStop(0, 'rgba(52, 152, 219, 0.5)');
    gradientBlue.addColorStop(1, 'rgba(52, 152, 219, 0.05)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Peminjaman',
                    data: dataValues, // Dynamic data
                    borderColor: '#3498db',
                    borderWidth: 3,
                    backgroundColor: gradientBlue,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#3498db',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#2980b9',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 2,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e293b',
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
                        color: '#94a3b8',
                        font: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 11,
                            weight: 500
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(226, 232, 240, 0.6)',
                        drawTicks: false
                    },
                    ticks: {
                        precision: 0,
                        color: '#94a3b8',
                        font: {
                            family: "'Plus Jakarta Sans', sans-serif",
                            size: 11,
                            weight: 500
                        },
                        stepSize: 5
                    }
                }
            }
        }
    });
});
</script>
@endpush