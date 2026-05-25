@extends('pperpus.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Penjaga Perpustakaan')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.2rem;
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
    .stat-card.green  { border-left-color: var(--success); }
    .stat-card.teal   { border-left-color: #16a085; }
    .stat-card.orange { border-left-color: var(--warning); }
    .stat-card.red    { border-left-color: var(--danger); }
    .stat-card.blue   { border-left-color: var(--info); }
    .stat-card.lime   { border-left-color: #2ecc71; }

    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.25rem; flex-shrink: 0;
    }
    .stat-card.green  .stat-icon { background: #eafaf1; color: var(--success); }
    .stat-card.teal   .stat-icon { background: #e8f8f5; color: #16a085; }
    .stat-card.orange .stat-icon { background: #fef9ec; color: var(--warning); }
    .stat-card.red    .stat-icon { background: #fdf0ef; color: var(--danger); }
    .stat-card.blue   .stat-icon { background: #ebf5fb; color: var(--info); }
    .stat-card.lime   .stat-icon { background: #e9f7ef; color: #2ecc71; }

    .stat-body { width: 100%; }
    .stat-body .value { font-size: 1.7rem; font-weight: 800; color: var(--text); line-height: 1.1; }
    .stat-body .label { font-size: .8rem; font-weight: 600; color: var(--text-muted); margin-top: .3rem; }

    .dashboard-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.8rem;
    }
    @media (max-width: 992px) {
        .dashboard-row {
            grid-template-columns: 1fr;
        }
    }

    .panel { background: var(--surface); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; }
    .panel-header {
        padding: 1.1rem 1.4rem;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
    }
    .panel-header h3 { font-size: .92rem; font-weight: 700; color: var(--text); }
    .badge { font-size: .72rem; font-weight: 700; padding: .25rem .65rem; border-radius: 20px; }
    .badge-green  { background: #eafaf1; color: var(--success); }
    .badge-orange { background: #fef9ec; color: var(--warning); }
    .badge-red    { background: #fdf0ef; color: var(--danger); }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th {
        font-size: .75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .5px;
        color: var(--text-muted); padding: .8rem 1.4rem;
        background: #f8fafc; border-bottom: 1px solid var(--border); text-align: left;
    }
    .data-table td {
        padding: .85rem 1.4rem; font-size: .86rem;
        border-bottom: 1px solid #f0f4f8; color: var(--text);
        vertical-align: middle;
    }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover td { background: #f8fafc; }

    .code-badge {
        font-family: 'JetBrains Mono', monospace; font-size: .78rem;
        background: #f0f4f8; color: var(--primary);
        padding: .2rem .45rem; border-radius: 6px; font-weight: 600;
        border: 1px solid var(--border);
    }
    .code-badge:hover {
        background: var(--accent-light);
        color: var(--primary-dark);
    }

    .pill { display: inline-flex; align-items: center; gap: .3rem; padding: .25rem .7rem; border-radius: 20px; font-size: .75rem; font-weight: 600; }
    .pill-success { background: #eafaf1; color: var(--success); }
    .pill-danger  { background: #fdf0ef; color: var(--danger); }
    .pill-warning { background: #fef9ec; color: var(--warning); }
    .pill-info    { background: #ebf5fb; color: var(--info); }

    .empty-state { padding: 3rem 2rem; text-align: center; color: var(--text-muted); font-size: .88rem; }
    .empty-state i { font-size: 2.2rem; display: block; margin-bottom: .8rem; opacity: .4; }

    .welcome-bar {
        background: linear-gradient(135deg, #0b3d22, #145a32);
        border-radius: var(--radius);
        padding: 1.5rem 2rem;
        color: #fff;
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.8rem;
        position: relative; overflow: hidden;
    }
    .welcome-bar::after {
        content: '\f543';
        font-family: 'Font Awesome 6 Free'; font-weight: 900;
        position: absolute; right: 1.5rem;
        font-size: 5rem; opacity: .07; color: #fff;
    }
    .welcome-bar h2 { font-size: 1.2rem; font-weight: 700; }
    .welcome-bar p  { font-size: .85rem; opacity: .75; margin-top: .2rem; }

    /* Fine summary specific styles */
    .fine-summary-card {
        background: var(--bg);
        border-radius: var(--radius);
        padding: 1.1rem;
        margin-bottom: 1rem;
        text-align: center;
        border: 1px solid var(--border);
    }
    .fine-summary-card .fine-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .fine-summary-card .fine-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text);
        margin-top: 0.3rem;
    }
    .fine-sub-card {
        border-radius: 8px;
        padding: 0.8rem;
        border: 1px solid var(--border);
    }
    .fine-sub-card.lunas {
        background: #eafaf1;
        border-color: #a9dfbf;
    }
    .fine-sub-card.belum-lunas {
        background: #fdf0ef;
        border-color: #f5c6c2;
    }
    .fine-sub-card .sub-label {
        font-size: 0.75rem;
        font-weight: 600;
    }
    .fine-sub-card.lunas .sub-label { color: var(--success); }
    .fine-sub-card.belum-lunas .sub-label { color: var(--danger); }
    
    .fine-sub-card .sub-value {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text);
        margin-top: 0.2rem;
    }

    .progress-wrap { margin-top: 1.1rem; }
    .progress-info {
        display: flex; justify-content: space-between;
        font-size: 0.78rem; font-weight: 600;
        margin-bottom: 0.4rem; color: var(--text);
    }
    .progress-bar-bg {
        height: 8px; background: #e2e8f0;
        border-radius: 4px; overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%; background: var(--success);
        border-radius: 4px; transition: width 0.5s ease-in-out;
    }
</style>
@endpush

@section('content')

<div class="welcome-bar">
    <div>
        <h2>Halo, {{ auth()->user()->name }}!</h2>
        <p>Selamat bertugas &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
</div>

<div class="stats-grid">
    <!-- Siswa Card -->
    <div class="stat-card blue">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['total_siswa'], 0, ',', '.') }}</div>
            <div class="label">Total Siswa</div>
            <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.15rem;">
                <span style="color: var(--success); font-weight: 700;">{{ number_format($stats['siswa_aktif'], 0, ',', '.') }}</span> Siswa Aktif
            </div>
        </div>
    </div>
    <!-- Buku Card -->
    <div class="stat-card teal">
        <div class="stat-icon"><i class="fas fa-book"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['total_buku'], 0, ',', '.') }}</div>
            <div class="label">Judul Buku</div>
            <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.15rem;">
                Stok Fisik: <span style="font-weight: 700;">{{ number_format($stats['total_stok'], 0, ',', '.') }}</span> Eks.
            </div>
        </div>
    </div>
    <!-- Pinjaman Hari Ini Card -->
    <div class="stat-card green">
        <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['peminjaman_hari_ini'], 0, ',', '.') }}</div>
            <div class="label">PJM Hari Ini</div>
            <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.15rem;">
                Detail: <span style="font-weight: 700;">{{ number_format($stats['buku_dipinjam_hari_ini'], 0, ',', '.') }}</span> Buku Dipinjam
            </div>
        </div>
    </div>
    <!-- Buku Terlambat Card -->
    <div class="stat-card red">
        <div class="stat-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="stat-body">
            <div class="value">{{ number_format($stats['buku_terlambat'], 0, ',', '.') }}</div>
            <div class="label">Buku Terlambat</div>
            <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.15rem;">
                Perlu ditindaklanjuti segera
            </div>
        </div>
    </div>
</div>

<div class="dashboard-row">
    <!-- Left Column: Chart -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-chart-line" style="color:var(--primary);margin-right:.45rem"></i>Grafik Peminjaman Buku (7 Hari Terakhir)</h3>
            <span class="badge badge-green">Tren Harian</span>
        </div>
        <div style="padding: 1.4rem; position: relative; height: 320px;">
            <canvas id="borrowingsChart" style="width: 100%; height: 100%;"></canvas>
        </div>
    </div>

    <!-- Right Column: Fine Breakdown Panel -->
    <div class="panel">
        <div class="panel-header">
            <h3><i class="fas fa-coins" style="color:var(--warning);margin-right:.45rem"></i>Ringkasan Keuangan Denda</h3>
            <span class="badge badge-orange">Status Keuangan</span>
        </div>
        <div style="padding: 1.4rem;">
            <!-- Grand Total -->
            <div class="fine-summary-card">
                <div class="fine-label">Total Akumulasi Denda</div>
                <div class="fine-value">Rp {{ number_format($stats['total_denda_grand'], 0, ',', '.') }}</div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; margin-bottom: 1.2rem;">
                <!-- Paid -->
                <div class="fine-sub-card lunas">
                    <div class="sub-label"><i class="fas fa-check-circle"></i> Lunas</div>
                    <div class="sub-value">Rp {{ number_format($stats['denda_lunas'], 0, ',', '.') }}</div>
                </div>
                <!-- Unpaid -->
                <div class="fine-sub-card belum-lunas">
                    <div class="sub-label"><i class="fas fa-clock"></i> Belum Lunas</div>
                    <div class="sub-value">Rp {{ number_format($stats['denda_belum_lunas'], 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Progress Bar -->
            @php
                $percentLunas = ($stats['total_denda_grand'] > 0) 
                    ? round(($stats['denda_lunas'] / $stats['total_denda_grand']) * 100, 1) 
                    : 0;
            @endphp
            <div class="progress-wrap">
                <div class="progress-info">
                    <span>Persentase Denda Lunas</span>
                    <span style="font-weight: 700;">{{ $percentLunas }}%</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ $percentLunas }}%"></div>
                </div>
                <div style="font-size: 0.72rem; color: var(--text-muted); margin-top: 0.4rem; text-align: center;">
                    Denda lunas membantu operasional & perawatan buku perpustakaan.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel" style="margin-bottom: 1.8rem;">
    <div class="panel-header">
        <h3><i class="fas fa-coins" style="color:var(--primary);margin-right:.45rem"></i>Daftar Denda Peminjaman (Lunas & Belum Lunas)</h3>
        <span class="badge badge-green">Total: {{ $fines->total() }} Denda</span>
    </div>
    
    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Kode</th>
                    <th>Nama Siswa</th>
                    <th>Judul Buku</th>
                    <th>Jumlah Denda</th>
                    <th>Status</th>
                    <th>Tanggal Kembali / Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fines as $index => $fine)
                <tr>
                    <td>{{ ($fines->currentPage() - 1) * $fines->perPage() + $index + 1 }}</td>
                    <td>
                        <a href="{{ route('pperpus.peminjaman.show', $fine->id_peminjaman) }}" class="code-badge" style="text-decoration: none; display: inline-block;">
                            {{ $fine->peminjaman->kode_peminjaman }}
                        </a>
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
    <div style="padding: 1.1rem; border-top: 1px solid var(--border)">
        {{ $fines->links() }}
    </div>
    @endif
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
        gradient.addColorStop(0, 'rgba(39, 174, 96, 0.45)'); // success color
        gradient.addColorStop(1, 'rgba(39, 174, 96, 0.01)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Buku Dipinjam',
                    data: dataValues,
                    borderColor: '#27ae60', // success color
                    borderWidth: 3,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#27ae60',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#1e8449',
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
                                weight: 500
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
                                weight: 500
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