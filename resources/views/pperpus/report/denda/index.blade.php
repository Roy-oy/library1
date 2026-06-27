@extends('pperpus.layouts.app')

@section('title', 'Laporan Denda Keterlambatan')
@section('page-title', 'Laporan Denda')

@push('styles')
<style>
    
    :root {
        --theme-primary: #0d9488;
        --theme-primary-light: #f0fdfa;
        --theme-primary-hover: #0f766e;
        --theme-info: #0ea5e9;
        --theme-info-light: #f0f9ff;
        --theme-success: #10b981;
        --theme-success-light: #ecfdf5;
        --theme-warning: #f59e0b;
        --theme-warning-light: #fffbeb;
        --theme-danger: #ef4444;
        --theme-danger-light: #fef2f2;
        --card-radius: 16px;
        --transition-speed: 0.25s;
    }

    
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-header-title h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .page-header-title p {
        font-size: 0.88rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    
    .card {
        background: var(--surface);
        border-radius: var(--card-radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(228, 233, 240, 0.6);
        overflow: hidden;
    }
    .card-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        flex-wrap: wrap;
        gap: 1rem;
        background: #fafbfc;
    }
    .card-toolbar .total-label {
        font-size: 0.88rem;
        color: var(--text-muted);
    }
    .card-toolbar .total-label strong {
        color: var(--primary);
        font-size: 1rem;
        font-weight: 800;
    }

    
    .table-wrap { overflow-x: auto; width: 100%; }

    
    table.kperpus-table { width: 100%; border-collapse: separate; border-spacing: 0; min-width: 1500px; }
    table.kperpus-table thead th {
        background: var(--primary);
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #ffffff;
        padding: 1.1rem 1.25rem;
        border-bottom: 2px solid var(--primary-dark);
        white-space: nowrap;
    }
    table.kperpus-table tbody td {
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
        border-bottom: 1px solid var(--border);
        color: var(--text);
        vertical-align: middle;
    }
    table.kperpus-table tbody tr:nth-child(even) td { background: #f8fafc; }
    table.kperpus-table tbody tr:last-child td { border-bottom: none; }
    table.kperpus-table tbody tr { transition: background-color .2s ease; }
    table.kperpus-table tbody tr:hover td { background-color: var(--primary-soft) !important; }

    
    .code-badge { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.82rem; background: var(--primary-soft); color: var(--primary); padding: 0.35rem 0.6rem; border-radius: 8px; font-weight: 800; border: 1px solid rgba(13, 148, 136, 0.15); display: inline-block; }
    .pill { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.8rem; border-radius: 30px; font-size: 0.78rem; font-weight: 700; white-space: nowrap; }
    .pill-success { background: var(--success-bg); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2); }
    .pill-danger { background: var(--danger-bg); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }
    .pill-warning { background: var(--warning-bg); color: var(--warning); border: 1px solid rgba(245, 158, 11, 0.2); }
    .pill-info { background: var(--info-bg); color: var(--info); border: 1px solid rgba(14, 165, 233, 0.2); }

    
    .filter-search-group { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; }
    .search-box {
        display: flex; align-items: center; gap: .5rem;
        background: #fff; border: 1.5px solid var(--border);
        border-radius: 10px; padding: .5rem .85rem;
        transition: all var(--transition-speed);
    }
    .search-box:focus-within { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1); }
    .search-box i { color: var(--text-muted); font-size: .875rem; }
    .search-box input, .search-box select { border: none; background: transparent; outline: none; font-family: inherit; font-size: .85rem; color: var(--text); }

    .filter-select {
        padding: .55rem 2.25rem .55rem 1rem;
        font-family: inherit; font-size: .85rem; font-weight: 700;
        color: var(--text); background: #fff;
        border: 1.5px solid var(--border); border-radius: 10px;
        outline: none; cursor: pointer; transition: all var(--transition-speed);
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat; background-position: right .75rem center; background-size: 1rem;
    }
    .filter-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1); }

    .btn-reset {
        background: var(--bg); color: var(--text-muted); border: 1.5px solid var(--border);
        padding: .5rem 1rem; border-radius: 10px; font-weight: 700; font-size: .85rem;
        transition: all .2s;
    }
    .btn-reset:hover { background: #e2e8f0; color: var(--text); }

    .empty-state {
        text-align: center; padding: 3rem 1.5rem; color: var(--text-light);
    }
    .empty-state i { font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.4; display: block; }
    .empty-state p { font-size: 0.95rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.25rem; }
    .empty-state span { font-size: 0.8rem; }

    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .card-toolbar { flex-direction: column; align-items: stretch; }
        .filter-search-group { flex-direction: column; align-items: stretch; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas fa-file-invoice-dollar" style="color:var(--primary)"></i> Laporan Denda</h1>
        <p>Rekapitulasi denda keterlambatan pengembalian buku</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('pperpus.report.denda.export-pdf', request()->all()) }}" target="_blank" class="btn-primary" style="background: #065f46">
            <i class="fas fa-file-pdf"></i> Preview PDF
        </a>
    </div>
</div>

<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Ditemukan: <strong>{{ $reports->total() }} transaksi denda</strong></span>
        
        <form action="{{ route('pperpus.report.denda.index') }}" method="GET" class="filter-search-group">
            <div class="search-box">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" name="start_date" value="{{ request('start_date') }}" title="Tanggal Mulai">
                <span style="color:var(--border)">|</span>
                <input type="date" name="end_date" value="{{ request('end_date') }}" title="Tanggal Selesai">
            </div>
            
            <select name="status" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="belum_lunas" {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
            </select>

            <button type="submit" class="btn-primary" style="padding: .55rem 1rem;">
                <i class="fas fa-filter"></i> Filter
            </button>
            
            @if(request()->anyFilled(['start_date', 'end_date', 'status']))
                <a href="{{ route('pperpus.report.denda.index') }}" class="btn-reset" title="Bersihkan Filter">
                    <i class="fas fa-undo"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="table-wrap">
        <table class="kperpus-table">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">No</th>
                    <th>Kode Peminjaman</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Tgl Pinjam</th>
                    <th>Harus Kembali</th>
                    <th>Tgl Kembali</th>
                    <th>Kode Buku</th>
                    <th>Judul Buku (Kategori)</th>
                    <th style="text-align: center;">Telat</th>
                    <th style="text-align: right;">Denda</th>
                    <th style="text-align: center;">Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr>
                    <td style="text-align: center; color: var(--text-muted); font-weight: 600;">{{ $loop->iteration }}</td>
                    <td><span class="code-badge">{{ $report->peminjaman->kode_peminjaman ?? '-' }}</span></td>
                    <td>{{ $report->peminjaman->siswa->nis ?? '-' }}</td>
                    <td><div style="font-weight: 800; color: var(--text)">{{ strtoupper($report->peminjaman->siswa->nama_siswa ?? '-') }}</div></td>
                    <td><span style="font-weight: 600;">{{ $report->peminjaman->siswa->kelas ?? '-' }}</span></td>
                    <td>{{ $report->peminjaman->tanggal_pinjam ? $report->peminjaman->tanggal_pinjam->format('d/m/Y') : '-' }}</td>
                    <td>{{ $report->tanggal_jatuh_tempo ? $report->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}</td>
                    <td>{{ $report->tanggal_kembali ? $report->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                    <td><span class="code-badge">{{ $report->buku->kode_buku ?? '-' }}</span></td>
                    <td style="max-width: 240px; font-weight: 500; color: var(--text); line-height: 1.4; white-space: normal; word-wrap: break-word;">
                        <div>{{ $report->buku->judul_buku ?? '-' }}</div>
                        @if($report->sumber_buku === 'bos')
                            <div style="font-size: .75rem; color: #fff; background: var(--theme-primary); padding: 0.15rem 0.4rem; border-radius: 4px; display: inline-block; margin-top: 0.2rem; font-weight: 600; text-transform: uppercase;">
                                <i class="fas fa-graduation-cap" style="font-size: 0.7rem;"></i> BOS
                            </div>
                        @else
                            <div style="font-size: .75rem; color: var(--primary); background: var(--theme-primary-light); padding: 0.15rem 0.4rem; border-radius: 4px; display: inline-block; margin-top: 0.2rem; font-weight: 600;">
                                <i class="fas fa-tag" style="font-size: 0.7rem;"></i> {{ optional($report->buku->kategoriBuku)->nama_kategori ?? 'Tanpa Kategori' }}
                            </div>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <span class="pill pill-warning">
                            {{ $report->jumlah_hari_terlambat }} Hari
                        </span>
                    </td>
                    <td style="text-align: right; font-weight: 800; color: var(--theme-danger);">
                        Rp{{ number_format($report->jumlah_denda, 0, ',', '.') }}
                    </td>
                    <td style="text-align: center;">
                        @if($report->status_denda == 'lunas')
                            <span class="pill pill-success"><i class="fas fa-check-circle"></i> Lunas</span>
                        @else
                            <span class="pill pill-danger"><i class="fas fa-times-circle"></i> Belum Lunas</span>
                        @endif
                    </td>
                    <td>
                        <small style="color: var(--text-muted); font-style: italic;">{{ $report->keterangan ?? '-' }}</small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="14">
                        <div class="empty-state">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <p>Belum ada data denda ditemukan.</p>
                            <span>Data denda akan muncul secara otomatis saat pengembalian terlambat dilakukan.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($reports->count() > 0)
            <tfoot>
                <tr>
                    <th colspan="11" style="text-align: right; background: #f8fafc; font-weight: 800; font-size: 0.88rem; padding: 1.1rem;">TOTAL KESELURUHAN DENDA:</th>
                    <th style="text-align: right; background: #f8fafc; font-weight: 800; font-size: 0.95rem; padding: 1.1rem; color: var(--theme-danger); border-left: 1px solid var(--border);">
                        Rp{{ number_format($reports->sum('jumlah_denda'), 0, ',', '.') }}
                    </th>
                    <th colspan="2" style="background: #f8fafc;"></th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    
    @if($reports->hasPages())
    <div class="pagination-wrap">
        <span class="info">
            Menampilkan {{ $reports->firstItem() }}–{{ $reports->lastItem() }} dari {{ $reports->total() }} data
        </span>
        {{ $reports->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

@endsection
