@extends('pperpus.layouts.app')

@section('title', 'Riwayat Peminjaman Buku BOS')
@section('page-title', 'Peminjaman Buku BOS')

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

    .btn-action {
        display: inline-flex; align-items: center; gap: .35rem; padding: .45rem .9rem;
        background: var(--primary-soft); color: var(--primary);
        border-radius: 8px; font-size: .8rem; font-weight: 700;
        text-decoration: none; transition: all .2s;
    }
    .btn-action:hover { background: var(--primary); color: #fff; transform: translateY(-1px); }

    .kelas-header {
        background: #f8fafc; padding: 1rem 1.25rem; font-weight: 800;
        color: var(--text); font-size: 0.95rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 0.6rem;
    }
    .kelas-header span {
        background: var(--primary); color: white; padding: 0.2rem 0.6rem;
        font-size: 0.8rem; border-radius: 6px; text-transform: uppercase;
    }

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
        <h1><i class="fas fa-exchange-alt" style="color:var(--primary)"></i> Peminjaman Buku BOS</h1>
        <p>Riwayat transaksi peminjaman khusus buku BOS sekolah</p>
    </div>
    <a href="{{ route('pperpus.peminjaman.bos.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Catat Peminjaman
    </a>
</div>

<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Total ditemukan: <strong>{{ $peminjamans->total() }} transaksi</strong></span>
        
        <form action="{{ route('pperpus.peminjaman.bos.index') }}" method="GET" class="filter-search-group">
            <select name="kelas" class="filter-select" onchange="this.form.submit()">
                <option value="">Semua Kelas</option>
                @if(isset($kelasList))
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>Kelas {{ $kelas }}</option>
                    @endforeach
                @endif
            </select>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="q" placeholder="Cari NIS, nama, atau kode..." value="{{ request('q') }}">
            </div>
        </form>
    </div>

    <div class="table-wrap">
        <table class="kperpus-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th>Kode Transaksi</th>
                    <th>Informasi Siswa</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jumlah Buku</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $groupedData = $peminjamans->groupBy(function($item) {
                        return $item->siswa->kelas;
                    });
                    $counter = $peminjamans->firstItem() ?? 1;
                @endphp
                
                @forelse($groupedData as $kelas => $items)
                    <tr>
                        <td colspan="7" class="kelas-header">
                            <i class="fas fa-users" style="color: var(--text-light)"></i> Grup Data: <span>Kelas {{ $kelas }}</span>
                        </td>
                    </tr>
                    @foreach($items as $pjm)
                    <tr>
                        <td style="text-align: center; color: var(--text-muted); font-weight: 600;">{{ $counter++ }}</td>
                        <td><span class="code-badge">{{ $pjm->kode_peminjaman }}</span></td>
                        <td>
                            <div style="font-weight: 800; color: var(--text)">{{ strtoupper($pjm->siswa->nama_siswa) }}</div>
                            <div style="font-size: .75rem; color: var(--text-muted); margin-top: 2px;">NIS: {{ $pjm->siswa->nis }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600;"><i class="far fa-calendar-alt" style="color: var(--primary); margin-right: .25rem;"></i> {{ $pjm->tanggal_pinjam->format('d/m/Y') }}</div>
                        </td>
                        <td>
                            <span class="pill pill-info">
                                <i class="fas fa-book"></i>
                                {{ $pjm->details->count() }} Buku
                            </span>
                        </td>
                        <td>
                            @if($pjm->status_peminjaman === 'dipinjam')
                                <span class="pill pill-warning"><i class="fas fa-clock"></i> Sedang Dipinjam</span>
                            @elseif($pjm->status_peminjaman === 'dikembalikan')
                                <span class="pill pill-danger"><i class="fas fa-exclamation-triangle"></i> Denda (Belum Lunas)</span>
                            @else
                                @if($pjm->total_denda > 0)
                                    <span class="pill pill-success"><i class="fas fa-check-circle"></i> Denda (Lunas)</span>
                                @else
                                    <span class="pill pill-success"><i class="fas fa-check-circle"></i> Selesai</span>
                                @endif
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('pperpus.peminjaman.bos.show', $pjm->id_peminjaman) }}" class="btn-action">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Data Tidak Ditemukan</p>
                            <span>Belum ada rekaman transaksi peminjaman BOS atau kata kunci pencarian Anda salah.</span>
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
        {{ $peminjamans->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

@endsection
