@extends('ksekolah.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'DASHBOARD KEPALA SEKOLAH')

@push('styles')
<style>
    
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

    
    .rank-num {
        width: 28px; height: 28px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: .78rem; font-weight: 800;
    }
    .rank-1 { background: #ccfbf1; color: #0f766e; }
    .rank-2 { background: #e0e7ff; color: #4f46e5; }
    .rank-3 { background: #f1f5f9; color: #475569; }
    .rank-n { background: var(--border-soft); color: var(--text-muted); }

    .monitoring-row {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 1.25rem; margin-bottom: 2rem;
    }

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
        background: linear-gradient(135deg, var(--blue-600), #1e293b);
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
    .mt-4 { margin-top: 1.5rem; }

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


<div class="welcome-banner">
    <div class="banner-bg-icon"><i class="fas fa-school"></i></div>
    <div>
        <h2>Halo, {{ auth()->user()->name ?? 'Kepala Sekolah' }}! 👋</h2>
        <p>Ringkasan laporan perpustakaan sekolah &mdash; {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
</div>


<div class="section-label">
    <i class="fas fa-chart-pie"></i> Statistik Ringkasan Koleksi & Siswa
</div>
<div class="stats-grid" style="grid-template-columns: repeat(5, 1fr);">
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

    <div class="stat-card rose">
        <div class="stat-card-top">
            <div class="stat-icon"><i class="fas fa-coins"></i></div>
            <span class="stat-tag tag-rose">Total</span>
        </div>
        <div>
            <div class="stat-val" style="font-size: 1.2rem; margin-top: 0.5rem; font-weight: 800;">Rp {{ number_format($stats['total_denda_grand'] ?? 0, 0, ',', '.') }}</div>
            <div class="stat-lbl">Total Denda</div>
        </div>
    </div>
</div>


<div class="section-label">
    <i class="fas fa-sync-alt"></i> Analisis Grafik & Aktivitas Terbaru Perpustakaan
</div>
<div class="panels-grid">
    
    
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


<div class="section-label mt-4">
    <i class="fas fa-star"></i> Peringkat Siswa &amp; Buku Populer
</div>
<div class="monitoring-row">

    <div class="panel">
        <div class="panel-header">
            <h3>
                <span class="ph-icon" style="background:var(--blue-100);">
                    <i class="fas fa-medal" style="color:var(--blue-700);"></i>
                </span>
                Siswa Rajin Meminjam
            </h3>
            <span class="panel-badge pb-blue">Top 5</span>
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
                            <span class="badge bg-primary" style="padding: .25rem .65rem; font-size: .69rem; font-weight: 700; border-radius: 50rem; background-color: var(--primary); color: white;">{{ $siswa->total_buku_dipinjam }} Buku</span>
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
                <span class="ph-icon" style="background:var(--indigo-100);">
                    <i class="fas fa-fire" style="color:var(--indigo-600);"></i>
                </span>
                Buku Terpopuler
            </h3>
            <span class="panel-badge pb-indigo">Top 10</span>
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
                        <i class="fas fa-fire" style="color:#fde68a;margin-right:.25rem;"></i>Dipinjam {{ $buku->total_dipinjam }}x
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
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('borrowingsChart').getContext('2d');
        
        const chartData = @json(array_values($borrowingsLast7Days));
        const labels = chartData.map(item => item.label);
        const dataValues = chartData.map(item => item.count);

        
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