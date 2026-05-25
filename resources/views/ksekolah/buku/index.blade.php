@extends('ksekolah.layouts.app')

@section('title', 'Koleksi Buku Perpustakaan')
@section('page-title', 'Koleksi Buku')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: .8rem;
    }
    .page-header h1 { font-size: 1.25rem; font-weight: 800; color: var(--text); }
    .page-header p { font-size: .84rem; color: var(--text-muted); margin-top: .2rem; }

    .card {
        background: var(--surface); border-radius: var(--radius);
        box-shadow: var(--shadow); overflow: hidden;
    }
    
    .card-toolbar {
        padding: 1rem 1.4rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        background: #f8fafc; flex-wrap: wrap; gap: 1rem;
    }

    .search-box {
        display: flex; align-items: center; gap: .5rem;
        background: #fff; border: 1px solid var(--border);
        border-radius: 8px; padding: .45rem .9rem;
    }
    .search-box input { border: none; outline: none; font-size: .85rem; width: 220px; }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc;
        font-size: .73rem; font-weight: 700; text-transform: uppercase;
        padding: .85rem 1.1rem; border-bottom: 1px solid var(--border);
        color: var(--text-muted); text-align: left;
    }
    tbody td {
        padding: .85rem 1.1rem; font-size: .88rem;
        border-bottom: 1px solid #f0f4f8; color: var(--text);
    }

    .book-title { font-weight: 700; color: var(--text); }
    .book-meta { font-size: .75rem; color: var(--text-muted); margin-top: .2rem; }

    .badge-sumber {
        font-size: .68rem; font-weight: 800; padding: .2rem .5rem; border-radius: 4px;
        text-transform: uppercase;
    }
    .sumber-perpus { background: #eef2ff; color: #4338ca; }
    .sumber-bos    { background: #fff7ed; color: #c2410c; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1><i class="fas fa-book" style="color:var(--primary);margin-right:.45rem"></i>Koleksi Buku</h1>
        <p>Pantauan seluruh judul buku yang tersedia di perpustakaan</p>
    </div>
</div>

<div class="card">
    <div class="card-toolbar">
        <form action="{{ route('ksekolah.buku.index') }}" method="GET" class="d-flex gap-2">
            <div class="search-box">
                <i class="fas fa-search" style="color: var(--text-muted)"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Judul, Kode, atau Penulis...">
            </div>
            <select name="sumber" class="form-select" style="border-radius: 8px; border-color: var(--border); font-size: .85rem;" onchange="this.form.submit()">
                <option value="">Semua Sumber</option>
                <option value="buku perpus" {{ request('sumber') == 'buku perpus' ? 'selected' : '' }}>Buku Perpus</option>
                <option value="bos" {{ request('sumber') == 'bos' ? 'selected' : '' }}>Buku BOS</option>
            </select>
        </form>
        <div style="font-size: .82rem; color: var(--text-muted)">
            Menampilkan <strong>{{ $books->total() }}</strong> Judul Buku
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Judul & Informasi</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Sumber</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td><code style="background: #f1f5f9; padding: .2rem .4rem; border-radius: 4px; color: var(--primary); font-weight: 700;">{{ $book->kode_buku }}</code></td>
                    <td>
                        <div class="book-title">{{ $book->judul_buku }}</div>
                        <div class="book-meta">Penulis: {{ $book->penulis ?? '-' }} | Penerbit: {{ $book->penerbit ?? '-' }}</div>
                    </td>
                    <td>{{ $book->kategori->nama_kategori ?? '-' }}</td>
                    <td>
                        <div style="font-weight: 700">{{ $book->stok }}</div>
                        <div style="font-size: .75rem; color: var(--text-muted)">Eksemplar</div>
                    </td>
                    <td>
                        @if($book->sumber_buku === 'buku perpus')
                            <span class="badge-sumber sumber-perpus">Perpus</span>
                        @else
                            <span class="badge-sumber sumber-bos">BOS</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted)">Tidak ada koleksi buku ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($books->hasPages())
    <div style="padding: 1rem 1.4rem; border-top: 1px solid var(--border)">
        {{ $books->links() }}
    </div>
    @endif
</div>

@endsection
