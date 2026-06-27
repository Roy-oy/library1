@extends('pperpus.layouts.app')

@section('title', 'Riwayat Pengembalian Perpustakaan')
@section('page-title', 'Pengembalian Perpustakaan')

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

    
    table.kperpus-table { width: 100%; border-collapse: separate; border-spacing: 0; min-width: 1000px; }
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
    .search-box input { border: none; background: transparent; outline: none; font-family: inherit; font-size: .85rem; color: var(--text); width: 220px; }

    .btn-action {
        display: inline-flex; align-items: center; gap: .35rem; padding: .45rem .9rem;
        background: var(--primary-soft); color: var(--primary);
        border-radius: 8px; font-size: .8rem; font-weight: 700;
        text-decoration: none; transition: all .2s;
    }
    .btn-action:hover { background: var(--primary); color: #fff; transform: translateY(-1px); }

    
    .filter-select {
        padding: 0.55rem 1rem;
        border-radius: 10px;
        border: 1.5px solid var(--border);
        background: #fff;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text);
        outline: none;
        cursor: pointer;
        transition: all var(--transition-speed);
        font-family: inherit;
    }
    .filter-select:hover { border-color: var(--primary); }
    .filter-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1); }

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
        .search-box input { width: 100%; }
        .pagination-wrap { flex-direction: column; gap: 1rem; text-align: center; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas fa-undo-alt" style="color:var(--primary)"></i> Pengembalian Perpustakaan</h1>
        <p>Proses pengembalian buku yang dipinjam dari perpustakaan umum</p>
    </div>
</div>

<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Total ditemukan: <strong>{{ $peminjamans->total() }} transaksi</strong></span>
        
        <form action="{{ route('pperpus.pengembalian.perpustakaan.index') }}" method="GET" class="filter-search-group">
            
            <div class="search-box">
                <i class="fas fa-filter"></i>
                <select name="status" style="border:none; outline:none; background:transparent; font-size:0.85rem; color:var(--text); cursor:pointer;">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam / Belum Selesai</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            
            <div class="search-box">
                <i class="far fa-calendar-alt"></i>
                <input type="date" name="dari" value="{{ request('dari') }}" title="Dari Tanggal" style="border:none; outline:none; background:transparent; font-size:0.85rem; color:var(--text); width: auto;">
                <span style="color:var(--border); margin: 0 0.25rem;">—</span>
                <input type="date" name="sampai" value="{{ request('sampai') }}" title="Sampai Tanggal" style="border:none; outline:none; background:transparent; font-size:0.85rem; color:var(--text); width: auto;">
            </div>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="q" placeholder="Cari NIS / Nama / Kode..." value="{{ request('q') }}">
            </div>

            <button type="submit" class="btn-action" style="border:none; cursor:pointer;">
                <i class="fas fa-filter"></i> Filter
            </button>

            @if(request()->anyFilled(['status', 'dari', 'sampai', 'q']))
                <a href="{{ route('pperpus.pengembalian.perpustakaan.index') }}" class="btn-action" style="background:var(--danger-bg); color:var(--danger)">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </form>
    </div>

    <div class="table-wrap">
        <table class="kperpus-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th>Kode Transaksi</th>
                    <th>Informasi Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jumlah Buku</th>
                    <th style="text-align: center">Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $index => $pjm)
                <tr>
                    <td style="text-align: center; color: var(--text-muted); font-weight: 600;">{{ $peminjamans->firstItem() + $index }}</td>
                    <td><span class="code-badge">{{ $pjm->kode_peminjaman }}</span></td>
                    <td>
                        <div style="font-weight: 800; color: var(--text)">{{ strtoupper($pjm->siswa->nama_siswa) }}</div>
                        <div style="font-size: .75rem; color: var(--text-muted); margin-top: 2px;">NIS: {{ $pjm->siswa->nis }} — {{ $pjm->siswa->kelas }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 600;"><i class="far fa-calendar-alt" style="color: var(--primary); margin-right: 0.3rem;"></i> {{ $pjm->tanggal_pinjam->format('d/m/Y') }}</div>
                    </td>
                    <td>
                        <span class="pill pill-info">
                            <i class="fas fa-book"></i>
                            {{ $pjm->details->count() }} Buku
                        </span>
                    </td>
                    <td style="text-align: center;">
                        @if($pjm->status_peminjaman === 'dipinjam')
                            <span class="pill pill-warning"><i class="fas fa-clock"></i> Sedang Dipinjam</span>
                        @elseif($pjm->status_peminjaman === 'dikembalikan')
                            <span class="pill pill-danger"><i class="fas fa-exclamation-triangle"></i> Belum Selesai (Denda)</span>
                        @else
                            @if($pjm->ada_denda_belum_lunas)
                                <span class="pill pill-danger"><i class="fas fa-exclamation-triangle"></i> Belum Selesai (Denda)</span>
                            @elseif($pjm->total_denda > 0)
                                <span class="pill pill-success"><i class="fas fa-check-circle"></i> Selesai (Denda)</span>
                            @else
                                <span class="pill pill-success"><i class="fas fa-check-circle"></i> Selesai</span>
                            @endif
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($pjm->status_peminjaman === 'dipinjam')
                            <a href="{{ route('pperpus.pengembalian.perpustakaan.formKembali', $pjm->id_peminjaman) }}" class="btn-action">
                                <i class="fas fa-reply"></i> Proses Kembali
                            </a>
                        @else
                            <a href="{{ route('pperpus.peminjaman.perpustakaan.show', $pjm->id_peminjaman) }}" class="btn-action" style="background: #e0f2fe; color: #0369a1;">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada data peminjaman aktif.</p>
                            <span>Semua buku telah dikembalikan atau belum ada transaksi.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($peminjamans->hasPages())
    <div class="pagination-wrap">
        <span class="info">
            Menampilkan {{ $peminjamans->firstItem() }}–{{ $peminjamans->lastItem() }} dari {{ $peminjamans->total() }} data
        </span>
        {{ $peminjamans->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

@endsection
