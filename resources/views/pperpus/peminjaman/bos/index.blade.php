@extends('pperpus.layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman')

@push('styles')
<style>
    /* Global Layout & Typography */
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: .8rem;
    }
    .page-header h1 { font-size: 1.25rem; font-weight: 800; color: var(--text); margin: 0; }
    .page-header p { font-size: .84rem; color: var(--text-muted); margin-top: .25rem; margin-bottom: 0; }

    /* Button Variants */
    .btn-primary {
        display: inline-flex; 
        align-items: center; 
        gap: .5rem;
        padding: .6rem 1.2rem;
        background: var(--primary); 
        color: #fff;
        border: none; 
        border-radius: 8px;
        font-family: inherit; 
        font-size: .875rem; 
        font-weight: 600;
        cursor: pointer; 
        text-decoration: none;
        transition: all .2s ease;
    }
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); color: #fff; opacity: 0.95; }
    
    .btn-action {
        display: inline-flex; 
        align-items: center; 
        gap: .35rem;
        padding: .4rem .8rem;
        background: #f1f5f9; 
        color: var(--text);
        border: 1px solid var(--border); 
        border-radius: 6px;
        font-size: .75rem; 
        font-weight: 600;
        text-decoration: none;
        transition: all .2s;
    }
    .btn-action:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

    /* Card Layout dengan Toolbar Terintegrasi */
    .card {
        background: var(--surface); 
        border-radius: 12px;
        box-shadow: var(--shadow); 
        overflow: hidden;
        border: 1px solid var(--border);
    }
    
    /* Toolbar Terpadu (Menyatukan Total, Filter & Search) */
    .card-toolbar-combined {
        display: flex; 
        align-items: center; 
        justify-content: space-between;
        padding: 1.25rem; 
        border-bottom: 1px solid var(--border);
        flex-wrap: wrap; 
        gap: 1.25rem;
        background: #fafafa;
    }
    .total-label { font-size: .875rem; color: var(--text-muted); white-space: nowrap; }
    .total-label strong { color: var(--text); font-weight: 700; }

    /* Wrapper untuk Filter + Search di sisi kanan */
    .filter-search-group {
        display: flex;
        align-items: center;
        gap: .75rem;
        flex-wrap: wrap;
        flex-grow: 1;
        justify-content: flex-end;
    }

    /* Dropdown Filter Kelas yang Bersih */
    .filter-select {
        padding: .5rem 2rem .5rem .75rem;
        font-family: inherit;
        font-size: .85rem;
        font-weight: 600;
        color: var(--text);
        background-color: #fff;
        border: 1px solid var(--border);
        border-radius: 8px;
        outline: none;
        cursor: pointer;
        transition: border-color .2s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right .5rem center;
        background-size: 1.25em;
    }
    .filter-select:focus { border-color: var(--primary); }

    /* Search Box */
    .search-box {
        display: flex; 
        align-items: center; 
        gap: .5rem;
        background: #fff; 
        border: 1px solid var(--border);
        border-radius: 8px; 
        padding: .5rem .75rem;
        width: 100%;
        max-width: 280px;
        transition: border-color .2s;
    }
    .search-box:focus-within { border-color: var(--primary); }
    .search-box i { color: var(--text-muted); font-size: .875rem; }
    .search-box input {
        border: none; 
        background: transparent; 
        outline: none;
        font-family: inherit; 
        font-size: .85rem; 
        color: var(--text); 
        width: 100%;
    }

    /* Table Styles */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc;
        font-size: .75rem; 
        font-weight: 700; 
        text-transform: uppercase;
        letter-spacing: .5px; 
        color: var(--text-muted);
        padding: 1rem 1.25rem; 
        border-bottom: 1px solid var(--border);
        white-space: nowrap; 
        text-align: left;
    }
    tbody td {
        padding: 1rem 1.25rem; 
        font-size: .875rem;
        border-bottom: 1px solid #f1f5f9; 
        color: var(--text); 
        vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #f8fafc; }

    /* Badges & Pills */
    .code-badge {
        font-family: 'JetBrains Mono', monospace; 
        font-size: .8rem;
        background: #f1f5f9; 
        color: var(--primary);
        padding: .25rem .5rem; 
        border-radius: 6px; 
        font-weight: 600;
        border: 1px solid var(--border);
    }
    
    .pill {
        display: inline-flex; 
        align-items: center; 
        gap: .35rem;
        padding: .25rem .75rem; 
        border-radius: 50px; 
        font-size: .75rem; 
        font-weight: 700;
        white-space: nowrap;
    }
    .pill-warning { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .pill-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .pill-danger  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .pill-info    { background: #f0f9ff; color: #0284c7; border: 1px solid #bae6fd; }
    
    .kelas-header {
        background: #f8fafc; 
        padding: .75rem 1.25rem; 
        font-weight: 700;
        color: var(--text); 
        font-size: .875rem; 
        border-bottom: 1px solid var(--border);
        display: flex; 
        align-items: center; 
        gap: .5rem;
    }
    .kelas-header span {
        background: var(--primary);
        color: white;
        padding: .15rem .5rem;
        font-size: .75rem;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1><i class="fas fa-exchange-alt" style="color:var(--primary);margin-right:.5rem"></i>Peminjaman Buku BOS</h1>
        <p>Riwayat transaksi peminjaman khusus buku BOS sekolah</p>
    </div>
    <a href="{{ route('pperpus.peminjaman.bos.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Catat Peminjaman Baru
    </a>
</div>

<div class="card">
    
    <div class="card-toolbar-combined">
        <span class="total-label">Total Ditemukan: <strong>{{ $peminjamans->total() }} Transaksi</strong></span>
        
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
            
            <button type="submit" style="display: none;"></button>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Kode Transaksi</th>
                    <th>Informasi Siswa</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jumlah Buku</th>
                    <th>Status</th>
                    <th style="width: 100px; text-align: center;">Aksi</th>
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
                            <i class="fas fa-users text-muted"></i> Grup Data: <span>Kelas {{ $kelas }}</span>
                        </td>
                    </tr>
                    @foreach($items as $pjm)
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td><span class="code-badge">{{ $pjm->kode_peminjaman }}</span></td>
                        <td>
                            <div style="font-weight: 700; color: var(--text)">{{ $pjm->siswa->nama_siswa }}</div>
                            <div style="font-size: .75rem; color: var(--text-muted); margin-top: 2px;">NIS: {{ $pjm->siswa->nis }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 500;"><i class="far fa-calendar-alt text-muted" style="margin-right: .25rem;"></i> {{ $pjm->tanggal_pinjam->format('d/m/Y') }}</div>
                        </td>
                        <td>
                            <span class="pill pill-info">
                                <i class="fas fa-book" style="font-size: .7rem"></i>
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
                    <td colspan="7" style="text-align: center; padding: 4rem 2rem; color: var(--text-muted)">
                        <i class="fas fa-inbox" style="font-size: 2.5rem; opacity: .25; display: block; margin-bottom: 1rem"></i>
                        <span style="font-weight: 600; font-size: .95rem; display: block;">Data Tidak Ditemukan</span>
                        <span style="font-size: .8rem; opacity: .7">Belum ada rekaman transaksi peminjaman BOS atau kata kunci pencarian Anda salah.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($peminjamans->hasPages())
    <div style="padding: 1.25rem; border-top: 1px solid var(--border); background: #fafafa;">
        {{ $peminjamans->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection