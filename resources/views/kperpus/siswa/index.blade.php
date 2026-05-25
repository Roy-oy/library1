@extends('kperpus.layouts.app')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa / Anggota')

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

    /* ── Badges / Pills ── */
    .pill {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .22rem .65rem; border-radius: 20px;
        font-size: .74rem; font-weight: 600;
    }
    .pill-success { background: #eafaf1; color: var(--success); }
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
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1><i class="fas fa-users" style="color:var(--primary);margin-right:.4rem"></i>Data Siswa</h1>
        <p>Kelola data siswa dan anggota perpustakaan</p>
    </div>
    <a href="{{ route('kperpus.siswa.create') }}" class="btn-primary" id="btn-tambah-siswa">
        <i class="fas fa-user-plus"></i> Tambah Siswa
    </a>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Total: <strong>{{ $siswa->total() }} siswa</strong></span>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="search-input" placeholder="Cari NIS / Nama…">
        </div>
    </div>

    <div class="table-wrap">
        <table id="siswa-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>L/P</th>
                    <th>Alamat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswa as $index => $item)
                <tr>
                    <td>{{ $siswa->firstItem() + $index }}</td>
                    <td><code style="font-size:.8rem;background:#f0f4f8;padding:.2rem .45rem;border-radius:5px;">{{ $item->nis }}</code></td>
                    <td style="font-weight:600;">{{ $item->nama_siswa }}</td>
                    <td><span class="kelas-badge">{{ $item->kelas }}</span></td>
                    <td>{{ $item->jenis_kelamin === 'Laki-laki' ? 'L' : 'P' }}</td>
                    <td style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $item->alamat }}">
                        {{ $item->alamat }}
                    </td>
                    <td>
                        @if($item->status === 'aktif')
                            <span class="pill pill-success"><i class="fas fa-check-circle" style="font-size:.7rem"></i> Aktif</span>
                        @else
                            <span class="pill pill-accent"><i class="fas fa-times-circle" style="font-size:.7rem"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('kperpus.siswa.edit', $item->id_siswa) }}"
                               class="btn-icon btn-edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <button type="button" class="btn-icon btn-del" title="Hapus"
                                onclick="confirmDelete('{{ route('kperpus.siswa.destroy', $item->id_siswa) }}', '{{ addslashes($item->nama_siswa) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-users-slash"></i>
                            <p>Belum ada data siswa. Silakan tambah siswa baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($siswa->hasPages())
    <div class="pagination-wrap">
        <span class="info">
            Menampilkan {{ $siswa->firstItem() }}–{{ $siswa->lastItem() }} dari {{ $siswa->total() }} data
        </span>
        {{ $siswa->links() }}
    </div>
    @endif
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash-alt"></i></div>
        <h3>Hapus Data Siswa?</h3>
        <p id="delete-modal-msg">Apakah Anda yakin ingin menghapus data siswa ini? Tindakan ini tidak dapat dibatalkan.</p>
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
        document.querySelectorAll('#siswa-table tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });

    // ── Delete modal ──
    function confirmDelete(url, nama) {
        document.getElementById('delete-form').action = url;
        document.getElementById('delete-modal-msg').textContent =
            'Apakah Anda yakin ingin menghapus data siswa "' + nama + '"? Tindakan ini tidak dapat dibatalkan.';
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
