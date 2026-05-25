@extends('kperpus.layouts.app')

@section('title', 'Data Buku')
@section('page-title', 'Data Buku Perpustakaan')

@push('styles')
<style>
    /* ── Page Header ── */
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: .8rem;
    }
    .page-header h1 {
        font-size: 1.25rem; font-weight: 800; color: var(--text);
    }
    .page-header p { font-size: .84rem; color: var(--text-muted); margin-top: .2rem; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .55rem 1.1rem;
        background: var(--primary);
        color: #fff;
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
        padding: 1rem 1.4rem;
        border-bottom: 1px solid var(--border);
        flex-wrap: wrap; gap: .7rem;
    }
    .card-toolbar .total-label {
        font-size: .83rem; color: var(--text-muted);
    }
    .card-toolbar .total-label strong { color: var(--text); }

    .search-box {
        display: flex; align-items: center; gap: .5rem;
        background: var(--bg); border: 1px solid var(--border);
        border-radius: 8px; padding: .4rem .8rem;
    }
    .search-box i { color: var(--text-muted); font-size: .85rem; }
    .search-box input {
        border: none; background: transparent; outline: none;
        font-family: inherit; font-size: .85rem; color: var(--text);
        width: 200px;
    }

    /* ── Table ── */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc;
        font-size: .73rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .5px;
        color: var(--text-muted);
        padding: .75rem 1.1rem;
        border-bottom: 1px solid var(--border);
        white-space: nowrap; text-align: left;
    }
    tbody td {
        padding: .75rem 1.1rem;
        font-size: .86rem;
        border-bottom: 1px solid #f0f4f8;
        color: var(--text);
        vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #f8fafc; }

    /* ── Book Cover ── */
    .book-cover {
        width: 44px; height: 60px;
        border-radius: 6px; object-fit: cover;
        box-shadow: 0 2px 8px rgba(0,0,0,.12);
    }
    .book-cover-placeholder {
        width: 44px; height: 60px;
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
    }
    .book-cover-placeholder i { color: rgba(255,255,255,.6); font-size: .9rem; }

    /* ── Badges / Pills ── */
    .pill {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .22rem .65rem; border-radius: 20px;
        font-size: .74rem; font-weight: 600;
    }
    .pill-success { background: #eafaf1; color: var(--success); }
    .pill-warning { background: #fef9ec; color: var(--warning); }
    .pill-info    { background: #ebf5fb; color: var(--info); }
    .pill-accent  { background: var(--accent-light); color: #8a6830; }

    .kelas-badge {
        display: inline-block;
        background: var(--accent-light); color: #8a6830;
        font-size: .72rem; font-weight: 700;
        padding: .18rem .55rem; border-radius: 6px;
    }

    /* ── Action Buttons ── */
    .actions { display: flex; gap: .4rem; }
    .btn-icon {
        width: 32px; height: 32px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 7px; border: none; cursor: pointer;
        font-size: .8rem; text-decoration: none;
        transition: background .15s, transform .15s;
    }
    .btn-edit  { background: #eaf0f8; color: var(--info); }
    .btn-del   { background: #fdf0ef; color: var(--danger); }
    .btn-icon:hover { filter: brightness(.92); transform: scale(1.08); }

    /* ── Pagination ── */
    .pagination-wrap {
        padding: 1rem 1.4rem;
        border-top: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: .6rem;
    }
    .pagination-wrap .info { font-size: .82rem; color: var(--text-muted); }
    .pagination { display: flex; gap: .3rem; list-style: none; }
    .pagination .page-item .page-link {
        display: flex; align-items: center; justify-content: center;
        width: 34px; height: 34px;
        border-radius: 8px;
        font-size: .83rem; font-weight: 600;
        color: var(--text-muted);
        text-decoration: none;
        border: 1px solid var(--border);
        transition: background .15s, color .15s;
    }
    .pagination .page-item.active .page-link {
        background: var(--primary); color: #fff; border-color: var(--primary);
    }
    .pagination .page-item.disabled .page-link { opacity: .45; pointer-events: none; }
    .pagination .page-item .page-link:hover:not(.active) { background: var(--bg); }

    /* ── Empty state ── */
    .empty-state {
        padding: 3rem; text-align: center; color: var(--text-muted);
    }
    .empty-state i { font-size: 2.5rem; opacity: .3; margin-bottom: .8rem; display: block; }
    .empty-state p { font-size: .9rem; }

    /* ── Modal ── */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,.45); z-index: 200;
        align-items: center; justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: var(--surface); border-radius: var(--radius);
        padding: 2rem; width: 100%; max-width: 400px;
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
        color: #fff; cursor: pointer;
        transition: background .15s;
    }
    .modal-actions .btn-confirm:hover { background: #c0392b; }
    /* ── Tabs ── */
    .tab-nav {
        display: flex; gap: .5rem; margin-bottom: 1.2rem;
        border-bottom: 1px solid var(--border); padding-bottom: 2px;
    }
    .tab-item {
        padding: .6rem 1.2rem; font-size: .88rem; font-weight: 700;
        color: var(--text-muted); text-decoration: none;
        border-radius: 8px 8px 0 0; position: relative;
        transition: all .2s;
    }
    .tab-item:hover { color: var(--primary); background: #f0f4f8; }
    .tab-item.active {
        color: var(--primary);
    }
    .tab-item.active::after {
        content: ''; position: absolute; bottom: -2px; left: 0; right: 0;
        height: 3px; background: var(--primary); border-radius: 3px 3px 0 0;
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1>
            @if($type === 'bos')
                <i class="fas fa-graduation-cap" style="color:var(--accent);margin-right:.4rem"></i>
            @else
                <i class="fas fa-book" style="color:var(--primary);margin-right:.4rem"></i>
            @endif
            {{ $pageTitle }}
        </h1>
        <p>Kelola koleksi {{ strtolower($pageTitle) }} perpustakaan sekolah</p>
    </div>
    <a href="{{ route('kperpus.buku.create', ['sumber_buku' => $type === 'bos' ? 'bos' : 'buku perpus']) }}" class="btn-primary" id="btn-tambah-buku">
        <i class="fas fa-plus"></i> Tambah Buku
    </a>
</div>

{{-- Tab Navigation --}}
<nav class="tab-nav">
    <a href="{{ route('kperpus.buku.index', ['type' => 'perpus']) }}" 
       class="tab-item {{ $type !== 'bos' ? 'active' : '' }}">
        <i class="fas fa-book-open"></i> Buku Perpus
    </a>
    <a href="{{ route('kperpus.buku.index', ['type' => 'bos']) }}" 
       class="tab-item {{ $type === 'bos' ? 'active' : '' }}">
        <i class="fas fa-graduation-cap"></i> Buku BOS
    </a>
</nav>

{{-- Table Card --}}
<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Total: <strong>{{ $buku->total() }} buku</strong></span>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="search-input" placeholder="Cari judul / kode…">
        </div>
    </div>

    <div class="table-wrap">
        <table id="buku-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cover</th>
                    <th>Kode</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Tahun</th>
                    <th>ISBN</th>
                    <th>Stok</th>
                    @if($type !== 'bos')
                        <th>Kategori</th>
                    @else
                        <th>Kelas</th>
                    @endif
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $index => $item)
                <tr>
                    <td>{{ $buku->firstItem() + $index }}</td>
                    <td>
                        @if($item->gambar)
                            <img src="{{ Storage::url($item->gambar) }}"
                                 alt="{{ $item->judul_buku }}"
                                 class="book-cover">
                        @else
                            <div class="book-cover-placeholder">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif
                    </td>
                    <td><code style="font-size:.8rem;background:#f0f4f8;padding:.2rem .45rem;border-radius:5px;">{{ $item->kode_buku }}</code></td>
                    <td style="font-weight:600;max-width:200px;">{{ $item->judul_buku }}</td>
                    <td>{{ $item->pengarang }}</td>
                    <td>{{ $item->tahun_terbit }}</td>
                    <td>{{ $item->isbn ?? '—' }}</td>
                    <td>
                        <span class="pill {{ $item->stok > 0 ? 'pill-success' : 'pill-warning' }}">
                            {{ $item->stok }}
                        </span>
                    </td>
                    @if($type !== 'bos')
                        <td>{{ $item->kategoriBuku?->nama_kategori ?? '—' }}</td>
                    @else
                        <td>
                            @if($item->kelas)
                                <span class="kelas-badge">Kls {{ $item->kelas }}</span>
                            @else
                                <span style="color:var(--text-muted)">—</span>
                            @endif
                        </td>
                    @endif
                    <td>
                        @if($item->status_buku === 'tersedia')
                            <span class="pill pill-success"><i class="fas fa-circle" style="font-size:.5rem"></i> Tersedia</span>
                        @else
                            <span class="pill pill-warning"><i class="fas fa-circle" style="font-size:.5rem"></i> Dipinjam</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('kperpus.buku.edit', $item->id_buku) }}"
                               class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button type="button" class="btn-icon btn-del" title="Hapus"
                                onclick="confirmDelete('{{ route('kperpus.buku.destroy', $item->id_buku) }}', '{{ addslashes($item->judul_buku) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12">
                        <div class="empty-state">
                            <i class="fas fa-book-open"></i>
                            <p>Belum ada data buku. Silakan tambah buku baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($buku->hasPages())
    <div class="pagination-wrap">
        <span class="info">
            Menampilkan {{ $buku->firstItem() }}–{{ $buku->lastItem() }} dari {{ $buku->total() }} data
        </span>
        {{ $buku->links() }}
    </div>
    @endif
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash-alt"></i></div>
        <h3>Hapus Buku?</h3>
        <p id="delete-modal-msg">Apakah Anda yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.</p>
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
    // ── Live search (client-side filter on visible rows) ──
    document.getElementById('search-input').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#buku-table tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });

    // ── Delete modal ──
    function confirmDelete(url, judul) {
        document.getElementById('delete-form').action = url;
        document.getElementById('delete-modal-msg').textContent =
            'Apakah Anda yakin ingin menghapus buku "' + judul + '"? Tindakan ini tidak dapat dibatalkan.';
        document.getElementById('delete-modal').classList.add('show');
    }
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.remove('show');
    }
    // Close on backdrop click
    document.getElementById('delete-modal').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
@endpush
