@extends('pperpus.layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman')

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

    /* Stats Grid */
    .stats-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.2rem; margin-bottom: 1.5rem;
    }
    .stat-card {
        background: var(--surface); padding: 1.2rem; border-radius: var(--radius);
        box-shadow: var(--shadow); border-left: 4px solid var(--primary);
    }
    .stat-card.terlambat { border-left-color: var(--danger); }
    .stat-card.denda { border-left-color: var(--warning); }
    .stat-card.hari-ini { border-left-color: var(--success); }
    
    .stat-card .label { font-size: .75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
    .stat-card .value { font-size: 1.4rem; font-weight: 800; color: var(--text); margin-top: .3rem; }

    /* Card */
    .card {
        background: var(--surface); border-radius: var(--radius);
        box-shadow: var(--shadow); overflow: hidden;
    }
    .card-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.4rem; border-bottom: 1px solid var(--border);
        flex-wrap: wrap; gap: .7rem;
    }
    .total-label { font-size: .83rem; color: var(--text-muted); }
    .total-label strong { color: var(--text); }

    .search-box {
        display: flex; align-items: center; gap: .5rem;
        background: var(--bg); border: 1px solid var(--border);
        border-radius: 8px; padding: .4rem .8rem;
    }
    .search-box i { color: var(--text-muted); font-size: .85rem; }
    .search-box input {
        border: none; background: transparent; outline: none;
        font-family: inherit; font-size: .85rem; color: var(--text); width: 200px;
    }

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
    .pill-info    { background: #ebf5fb; color: var(--info); }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1><i class="fas fa-exchange-alt" style="color:var(--primary);margin-right:.45rem"></i>Peminjaman Buku Perpustakaan</h1>
        <p>Riwayat transaksi Peminjaman Buku Perpustakaan perpustakaan</p>
    </div>
    <a href="{{ route('pperpus.peminjaman.perpustakaan.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Catat Peminjaman
    </a>
</div>

<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Total: <strong>{{ $peminjamans->total() }} transaksi</strong></span>
        <form action="{{ route('pperpus.peminjaman.perpustakaan.index') }}" method="GET" class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" name="q" placeholder="Cari NIS / Nama / Kode…" value="{{ request('q') }}">
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Peminjam</th>
                    <th>Tgl Pinjam</th>
                    <th>Jml. Buku</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $index => $pjm)
                <tr>
                    <td>{{ $peminjamans->firstItem() + $index }}</td>
                    <td><span class="code-badge">{{ $pjm->kode_peminjaman }}</span></td>
                    <td>
                        <div style="font-weight:700">{{ $pjm->siswa->nama_siswa }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted)">NIS: {{ $pjm->siswa->nis }} — {{ $pjm->siswa->kelas }}</div>
                    </td>
                    <td>{{ $pjm->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td>
                        <span class="pill pill-info">
                            <i class="fas fa-book" style="font-size:.6rem"></i>
                            {{ $pjm->details->count() }} Buku
                        </span>
                    </td>
                    <td>
                        @if($pjm->status_peminjaman === 'dipinjam')
                            <span class="pill pill-warning">Sedang Dipinjam</span>
                        @elseif($pjm->status_peminjaman === 'dikembalikan')
                            <span class="pill pill-danger">Denda (Belum Lunas)</span>
                        @else
                            @if($pjm->total_denda > 0)
                                <span class="pill pill-success">Denda (Lunas)</span>
                            @else
                                <span class="pill pill-success">Selesai</span>
                            @endif
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('pperpus.peminjaman.perpustakaan.show', $pjm->id_peminjaman) }}" class="btn-primary" style="padding:.3rem .7rem; font-size:.75rem">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:3rem; color:var(--text-muted)">
                        <i class="fas fa-inbox" style="font-size:2rem; opacity:.2; display:block; margin-bottom:.5rem"></i>
                        Belum ada data peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($peminjamans->hasPages())
    <div style="padding:1.2rem; border-top:1px solid var(--border)">
        {{ $peminjamans->links() }}
    </div>
    @endif
</div>

@endsection
