@extends('kperpus.layouts.app')

@section('title', 'Kategori Buku')
@section('page-title', 'Manajemen Kategori Buku')

@push('styles')
<style>
    /* ── Page Header ── */
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: .8rem;
    }
    .page-header h1 { font-size: 1.25rem; font-weight: 800; color: var(--text); }
    .page-header p  { font-size: .84rem; color: var(--text-muted); margin-top: .2rem; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .55rem 1.1rem;
        background: var(--primary); color: #fff;
        border: none; border-radius: 8px;
        font-family: inherit; font-size: .85rem; font-weight: 600;
        cursor: pointer; text-decoration: none;
        transition: background .2s, transform .15s;
    }
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }



    /* ── Card ── */
    .card {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    .card-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.4rem; border-bottom: 1px solid var(--border);
        flex-wrap: wrap; gap: .6rem;
    }
    .card-toolbar .total-label { font-size: .83rem; color: var(--text-muted); }
    .card-toolbar .total-label strong { color: var(--text); }

    /* ── Table ── */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc;
        font-size: .73rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .5px;
        color: var(--text-muted);
        padding: .75rem 1.2rem;
        border-bottom: 1px solid var(--border);
        text-align: left; white-space: nowrap;
    }
    tbody td {
        padding: .85rem 1.2rem;
        font-size: .87rem;
        border-bottom: 1px solid #f0f4f8;
        color: var(--text);
        vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #f8fafc; }

    /* ── Category Badge ── */
    .cat-badge {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .35rem .85rem;
        border-radius: 20px;
        font-size: .82rem; font-weight: 700;
        text-transform: capitalize;
    }
    .cat-badge.bos {
        background: var(--accent-light); color: #7d5a2b;
        border: 1px solid #e8c98a;
    }
    .cat-badge.perpus {
        background: #eaf0f8; color: var(--primary);
        border: 1px solid #bcd2ec;
    }
    .cat-badge i { font-size: .75rem; }

    /* ── Buku count pill ── */
    .buku-count {
        display: inline-flex; align-items: center; gap: .3rem;
        background: #f0f4f8; color: var(--text-muted);
        padding: .22rem .7rem; border-radius: 20px;
        font-size: .78rem; font-weight: 600;
    }

    /* ── Actions ── */
    .actions { display: flex; gap: .4rem; }
    .btn-icon {
        width: 32px; height: 32px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 7px; border: none; cursor: pointer;
        font-size: .8rem; text-decoration: none;
        transition: filter .15s, transform .15s;
    }
    .btn-edit { background: #eaf0f8; color: var(--info); }
    .btn-del  { background: #fdf0ef; color: var(--danger); }
    .btn-icon:hover { filter: brightness(.9); transform: scale(1.08); }

    /* ── Pagination ── */
    .pagination-wrap {
        padding: 1rem 1.4rem;
        border-top: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: .6rem;
    }
    .pagination-wrap .info { font-size: .82rem; color: var(--text-muted); }

    /* ── Empty state ── */
    .empty-state {
        padding: 3rem; text-align: center; color: var(--text-muted);
    }
    .empty-state i { font-size: 2.5rem; opacity: .3; margin-bottom: .8rem; display: block; }
    .empty-state p { font-size: .9rem; }

    /* ── Delete Modal ── */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,.45); z-index: 200;
        align-items: center; justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: var(--surface); border-radius: var(--radius);
        padding: 2rem; width: 100%; max-width: 390px;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
        animation: popIn .2s ease;
    }
    @keyframes popIn {
        from { transform: scale(.92); opacity: 0; }
        to   { transform: scale(1);  opacity: 1; }
    }
    .modal-box .modal-icon {
        width: 56px; height: 56px; border-radius: 50%;
        background: #fdf0ef; color: var(--danger);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; margin: 0 auto 1rem;
    }
    .modal-box h3 { font-size: 1rem; font-weight: 700; text-align: center; color: var(--text); }
    .modal-box p  { font-size: .84rem; color: var(--text-muted); text-align: center; margin-top: .4rem; }
    .modal-actions { display: flex; gap: .6rem; margin-top: 1.4rem; }
    .modal-actions .btn-cancel {
        flex: 1; padding: .6rem; background: var(--bg);
        border: 1px solid var(--border); border-radius: 8px;
        font-family: inherit; font-size: .85rem; font-weight: 600;
        color: var(--text-muted); cursor: pointer;
    }
    .modal-actions .btn-confirm {
        flex: 1; padding: .6rem; background: var(--danger);
        border: none; border-radius: 8px;
        font-family: inherit; font-size: .85rem; font-weight: 600;
        color: #fff; cursor: pointer; transition: background .15s;
    }
    .modal-actions .btn-confirm:hover { background: #c0392b; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1><i class="fas fa-tags" style="color:var(--accent);margin-right:.4rem"></i>Kategori Buku</h1>
        <p>Kelola kategori koleksi buku perpustakaan</p>
    </div>
    <a href="{{ route('kperpus.kategori.create') }}" class="btn-primary" id="btn-tambah-kategori">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>
</div>



{{-- Table Card --}}
<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Total: <strong>{{ $kategori->total() }} kategori</strong></span>
    </div>

    <div class="table-wrap">
        <table id="kategori-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Buku</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategori as $index => $item)
                <tr>
                    <td>{{ $kategori->firstItem() + $index }}</td>
                    <td>
                        <span class="cat-badge perpus">
                            <i class="fas fa-tag"></i>
                            {{ ucwords($item->nama_kategori) }}
                        </span>
                    </td>
                    <td>
                        <span class="buku-count">
                            <i class="fas fa-book"></i>
                            {{ $item->bukus->count() }} buku
                        </span>
                    </td>
                    <td style="color:var(--text-muted);font-size:.82rem;">
                        {{ $item->created_at->translatedFormat('d M Y') }}
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('kperpus.kategori.edit', $item->id_kategori) }}"
                               class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button type="button" class="btn-icon btn-del" title="Hapus"
                                onclick="confirmDelete(
                                    '{{ route('kperpus.kategori.destroy', $item->id_kategori) }}',
                                    '{{ ucwords($item->nama_kategori) }}',
                                    {{ $item->bukus->count() }}
                                )">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="fas fa-tags"></i>
                            <p>Belum ada kategori. Silakan tambah kategori baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($kategori->hasPages())
    <div class="pagination-wrap">
        <span class="info">
            Menampilkan {{ $kategori->firstItem() }}–{{ $kategori->lastItem() }} dari {{ $kategori->total() }} data
        </span>
        {{ $kategori->links() }}
    </div>
    @endif
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash-alt"></i></div>
        <h3>Hapus Kategori?</h3>
        <p id="delete-modal-msg">Apakah Anda yakin ingin menghapus kategori ini?</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <form id="delete-form" method="POST" style="flex:1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm" style="width:100%">Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(url, nama, jumlahBuku) {
        document.getElementById('delete-form').action = url;

        let msg = 'Apakah Anda yakin ingin menghapus kategori "' + nama + '"?';
        if (jumlahBuku > 0) {
            msg += ' Kategori ini memiliki ' + jumlahBuku + ' buku terkait yang juga akan terhapus (cascade).';
        }
        document.getElementById('delete-modal-msg').textContent = msg;
        document.getElementById('delete-modal').classList.add('show');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.remove('show');
    }

    document.getElementById('delete-modal').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
@endpush
