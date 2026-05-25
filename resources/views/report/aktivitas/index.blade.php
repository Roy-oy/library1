@extends($layout)

@section('title', 'Laporan Aktivitas Perpustakaan')
@section('page-title', 'Laporan Aktivitas')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: .8rem;
    }
    .page-header h1 { font-size: 1.25rem; font-weight: 800; color: var(--text); }
    .page-header p { font-size: .84rem; color: var(--text-muted); margin-top: .2rem; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .55rem 1.1rem;
        background: var(--primary); color: #fff;
        border: none; border-radius: 8px;
        font-family: inherit; font-size: .85rem; font-weight: 600;
        cursor: pointer; text-decoration: none;
        transition: background .2s, transform .15s;
    }
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); color: #fff; }

    .stats-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.2rem; margin-bottom: 1.5rem;
    }
    .stat-card {
        background: var(--surface); padding: 1.2rem; border-radius: var(--radius);
        box-shadow: var(--shadow); border-left: 4px solid var(--primary);
    }
    .stat-card.kembali { border-left-color: var(--success); }
    .stat-card.denda   { border-left-color: #dc2626; }
    
    .stat-card .label { font-size: .72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
    .stat-card .value { font-size: 1.3rem; font-weight: 800; color: var(--text); margin-top: .3rem; }

    /* Card */
    .card {
        background: var(--surface); border-radius: var(--radius);
        box-shadow: var(--shadow); overflow: hidden; margin-bottom: 1.5rem;
    }
    .card-header-tab {
        padding: 0 1.4rem; border-bottom: 1px solid var(--border);
        display: flex; gap: 1.5rem;
    }
    .tab-link {
        padding: 1rem 0; font-size: .85rem; font-weight: 600; color: var(--text-muted);
        text-decoration: none; border-bottom: 2px solid transparent;
        cursor: pointer;
    }
    .tab-link.active { color: var(--primary); border-bottom-color: var(--primary); }

    .filter-box {
        display: flex; align-items: center; gap: .8rem; flex-wrap: wrap; padding: 1rem 1.4rem; background: #f8fafc;
    }
    .search-box {
        display: flex; align-items: center; gap: .5rem;
        background: #fff; border: 1px solid var(--border);
        border-radius: 8px; padding: .4rem .8rem;
    }
    .search-box input { border: none; outline: none; font-size: .85rem; }

    /* Table */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc;
        font-size: .73rem; font-weight: 700; text-transform: uppercase;
        padding: .75rem 1.1rem; border-bottom: 1px solid var(--border);
        color: var(--text-muted); text-align: left;
    }
    tbody td {
        padding: .75rem 1.1rem; font-size: .86rem;
        border-bottom: 1px solid #f0f4f8; color: var(--text);
    }
    
    .pill {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .22rem .65rem; border-radius: 20px; font-size: .74rem; font-weight: 600;
    }
    .pill-info { background: #ebf5fb; color: #2980b9; }
    .pill-success { background: #eafaf1; color: #27ae60; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1><i class="fas fa-history" style="color:var(--primary);margin-right:.45rem"></i>Laporan Aktivitas</h1>
        <p>Ringkasan transaksi peminjaman dan pengembalian buku</p>
    </div>
    <a href="{{ route(auth()->user()->role === 'penjaga_perpustakaan' ? 'pperpus.report.aktivitas.export-pdf' : 'kperpus.report.aktivitas.export-pdf', request()->all()) }}" class="btn-primary" style="background: #065f46">
        <i class="fas fa-file-pdf"></i> Export PDF
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total Peminjaman</div>
        <div class="value">{{ $stats['total_pinjam'] }} Transaksi</div>
        <div style="font-size: .75rem; color: var(--text-muted)">{{ $stats['total_buku_pinjam'] }} Total Buku</div>
    </div>
    <div class="stat-card kembali">
        <div class="label">Total Pengembalian</div>
        <div class="value">{{ $stats['total_kembali'] }} Buku</div>
    </div>
    <div class="stat-card denda">
        <div class="label">Denda Diterima (Lunas)</div>
        <div class="value">Rp{{ number_format($stats['total_denda_masuk'], 0, ',', '.') }}</div>
    </div>
</div>

<div class="card">
    <div class="filter-box">
        <form action="{{ route(auth()->user()->role === 'penjaga_perpustakaan' ? 'pperpus.report.aktivitas.index' : 'kperpus.report.aktivitas.index') }}" method="GET" class="d-flex gap-2 align-items-center w-100 flex-wrap">
            <span class="total-label" style="font-size: .85rem">Periode:</span>
            <div class="search-box">
                <input type="date" name="start_date" value="{{ $startDate }}">
                <span style="color:var(--border)">s/d</span>
                <input type="date" name="end_date" value="{{ $endDate }}">
            </div>
            <button type="submit" class="btn-primary" style="padding: .45rem 1rem">
                <i class="fas fa-sync"></i> Update Laporan
            </button>
        </form>
    </div>

    <div class="card-header-tab">
        <div class="tab-link active" onclick="switchTab('peminjaman', this)">Peminjaman ({{ $peminjamans->count() }})</div>
        <div class="tab-link" onclick="switchTab('pengembalian', this)">Pengembalian ({{ $pengembalians->count() }})</div>
    </div>

    <div id="peminjaman-tab" class="tab-content">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tgl Pinjam</th>
                        <th>Kode</th>
                        <th>Siswa</th>
                        <th>Jumlah Buku</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $pjm)
                    <tr>
                        <td>{{ $pjm->tanggal_pinjam->format('d/m/Y') }}</td>
                        <td><span style="font-weight: 700; color: var(--primary)">{{ $pjm->kode_peminjaman }}</span></td>
                        <td>
                            <div style="font-weight: 600">{{ $pjm->siswa->nama_siswa }}</div>
                            <div style="font-size: .75rem; color: var(--text-muted)">{{ $pjm->siswa->kelas }}</div>
                        </td>
                        <td><span class="pill pill-info">{{ $pjm->details->count() }} Buku</span></td>
                        <td>{{ $pjm->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 2rem; color: var(--text-muted)">Tidak ada data peminjaman di periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="pengembalian-tab" class="tab-content" style="display: none;">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tgl Kembali</th>
                        <th>Siswa</th>
                        <th>Judul Buku</th>
                        <th>Denda</th>
                        <th>Status Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $pkb)
                    <tr>
                        <td>{{ $pkb->tanggal_kembali->format('d/m/Y') }}</td>
                        <td>
                            <div style="font-weight: 600">{{ $pkb->peminjaman->siswa->nama_siswa }}</div>
                            <div style="font-size: .75rem; color: var(--text-muted)">{{ $pkb->peminjaman->kode_peminjaman }}</div>
                        </td>
                        <td>{{ $pkb->buku->judul_buku }}</td>
                        <td>Rp{{ number_format($pkb->jumlah_denda, 0, ',', '.') }}</td>
                        <td>
                            @if($pkb->status_denda === 'lunas')
                                <span class="pill pill-success">Lunas</span>
                            @elseif($pkb->status_denda === 'belum_lunas')
                                <span class="pill pill-danger" style="background: #fef2f2; color: #dc2626">Belum Lunas</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 2rem; color: var(--text-muted)">Tidak ada data pengembalian di periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function switchTab(tab, el) {
        document.querySelectorAll('.tab-link').forEach(t => t.classList.remove('active'));
        el.classList.add('active');
        
        document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
        document.getElementById(tab + '-tab').style.display = 'block';
    }
</script>

@endsection
