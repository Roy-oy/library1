@extends('pperpus.layouts.app')

@section('title', 'Laporan Denda Keterlambatan')
@section('page-title', 'Laporan Denda Keterlambatan')

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

    .btn-danger {
        background: #dc2626;
    }
    .btn-danger:hover { background: #b91c1c; color: #fff; }

    /* Card */
    .card {
        background: var(--surface); border-radius: var(--radius);
        box-shadow: var(--shadow); overflow: hidden; margin-bottom: 1.5rem;
    }
    .card-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.4rem; border-bottom: 1px solid var(--border);
        flex-wrap: wrap; gap: .7rem;
    }
    .total-label { font-size: .83rem; color: var(--text-muted); }
    .total-label strong { color: var(--text); }

    .filter-box {
        display: flex; align-items: center; gap: .8rem; flex-wrap: wrap;
    }

    .search-box {
        display: flex; align-items: center; gap: .5rem;
        background: var(--bg); border: 1px solid var(--border);
        border-radius: 8px; padding: .4rem .8rem;
    }
    .search-box i { color: var(--text-muted); font-size: .85rem; }
    .search-box input, .search-box select {
        border: none; background: transparent; outline: none;
        font-family: inherit; font-size: .85rem; color: var(--text);
    }
    .search-box input[type="date"] { width: 130px; }

    /* Table */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc;
        font-size: .73rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .5px; color: var(--text-muted);
        padding: .75rem 1.1rem; border-bottom: 1px solid var(--border);
        white-space: nowrap; text-align: left;
    }
    tbody td {
        padding: .75rem 1.1rem; font-size: .86rem;
        border-bottom: 1px solid #f0f4f8; color: var(--text); vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #f8fafc; }

    .code-badge {
        font-family: 'JetBrains Mono', monospace; font-size: .78rem;
        background: #f0f4f8; color: var(--primary);
        padding: .2rem .45rem; border-radius: 6px; font-weight: 600;
    }
    
    .pill {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .22rem .65rem; border-radius: 20px; font-size: .74rem; font-weight: 600;
    }
    .pill-warning { background: #fef9ec; color: #b45309; }
    .pill-success { background: #eafaf1; color: var(--success); }
    .pill-danger  { background: #fef2f2; color: #dc2626; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1><i class="fas fa-file-invoice-dollar" style="color:var(--primary);margin-right:.45rem"></i>Laporan Denda</h1>
        <p>Rekapitulasi denda keterlambatan pengembalian buku</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('pperpus.report.denda.export-pdf', request()->all()) }}" class="btn-primary" style="background: #065f46">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>
</div>

<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Total: <strong>{{ $reports->count() }} transaksi denda</strong></span>
        
        <form action="{{ route('pperpus.report.denda.index') }}" method="GET" class="filter-box">
            <div class="search-box">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" name="start_date" value="{{ request('start_date') }}" title="Tanggal Mulai">
                <span style="color:var(--border)">|</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}" title="Tanggal Selesai">
            </div>
            
            <div class="search-box">
                <i class="fas fa-filter"></i>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="belum_lunas" {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>

            <button type="submit" class="btn-primary" style="padding: .4rem .8rem; border-radius: 8px;">
                <i class="fas fa-search"></i>
            </button>
            
            @if(request()->anyFilled(['start_date', 'end_date', 'status']))
                <a href="{{ route('pperpus.report.denda.index') }}" class="btn-primary btn-danger" style="padding: .4rem .8rem; border-radius: 8px;">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Peminjam</th>
                    <th>Buku</th>
                    <th>Tgl Kembali</th>
                    <th>Terlambat</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div style="font-weight:700">{{ $report->peminjaman->siswa->nama_siswa }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted)">{{ $report->peminjaman->kode_peminjaman }}</div>
                    </td>
                    <td>
                        <div style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $report->buku->judul_buku }}">
                            {{ $report->buku->judul_buku }}
                        </div>
                    </td>
                    <td>{{ $report->tanggal_kembali ? $report->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                    <td>
                        <span class="pill pill-warning">
                            {{ $report->jumlah_hari_terlambat }} Hari
                        </span>
                    </td>
                    <td>
                        <div style="font-weight: 700; color: #dc2626">
                            Rp{{ number_format($report->jumlah_denda, 0, ',', '.') }}
                        </div>
                    </td>
                    <td>
                        @if($report->status_denda == 'lunas')
                            <span class="pill pill-success">Lunas</span>
                        @else
                            <span class="pill pill-danger">Belum Lunas</span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">{{ $report->keterangan ?? '-' }}</small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:3rem; color:var(--text-muted)">
                        <i class="fas fa-file-invoice-dollar" style="font-size:2rem; opacity:.2; display:block; margin-bottom:.5rem"></i>
                        Belum ada data denda ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
