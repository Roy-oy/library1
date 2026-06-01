@extends('kperpus.layouts.app')

@section('title', 'Kategori Buku')
@section('page-title', 'Manajemen Kategori Buku')

@push('styles')
<style>
    /* ── Theme variables for this view ── */
    :root {
        --theme-primary: #2563eb;
        --theme-primary-light: #eff6ff;
        --theme-primary-hover: #1d4ed8;
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

    /* ── Page Header ── */
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

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1.4rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(74, 144, 226, 0.3);
        transition: all var(--transition-speed) ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
    }
    .btn-primary:active {
        transform: translateY(0);
    }

    /* ── Card Container ── */
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

    /* ── Table Styling ── */
    .table-wrap {
        overflow-x: auto;
        padding: 0;
    }
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    thead th {
        background: #f1f5f9;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #475569;
        padding: 0.85rem 1rem;
        border-bottom: 2px solid var(--border);
        white-space: nowrap;
        text-align: left;
    }
    tbody td {
        padding: 0.85rem 1rem;
        font-size: 0.88rem;
        border-bottom: 1px solid var(--border);
        color: var(--text);
        vertical-align: middle;
    }
    tbody tr:nth-child(even) td {
        background: #f8fafc;
    }
    tbody tr:last-child td {
        border-bottom: none;
    }
    tbody tr {
        transition: background var(--transition-speed) ease;
    }
    tbody tr:hover td {
        background: var(--theme-primary-light) !important;
    }

    /* ── Category Badge ── */
    .cat-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: capitalize;
    }
    .cat-badge i {
        font-size: 0.75rem;
    }

    /* ── Buku count pill ── */
    .buku-count {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #f1f5f9;
        color: #475569;
        padding: 0.3rem 0.8rem;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 700;
        border: 1px solid var(--border);
    }
    .buku-count i {
        color: var(--primary);
    }

    /* ── Action Buttons ── */
    .actions {
        display: flex;
        gap: 0.5rem;
    }
    .btn-icon {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all var(--transition-speed) ease;
    }
    .btn-edit {
        background: var(--theme-primary-light);
        color: var(--primary);
    }
    .btn-edit:hover {
        background: var(--primary);
        color: #fff;
        transform: translateY(-2px);
    }
    .btn-del {
        background: var(--theme-danger-light);
        color: var(--theme-danger);
    }
    .btn-del:hover {
        background: var(--theme-danger);
        color: #fff;
        transform: translateY(-2px);
    }

    /* ── Pagination ── */
    .pagination-wrap {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        background: #fafbfc;
    }
    .pagination-wrap .info {
        font-size: 0.88rem;
        color: var(--text-muted);
    }

    /* ── Empty state ── */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 3rem;
        color: var(--primary);
        opacity: 0.35;
        margin-bottom: 1rem;
        display: block;
    }
    .empty-state p {
        font-size: 0.95rem;
        font-weight: 600;
    }

    /* ── Delete Modal ── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(4px);
        z-index: 200;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity var(--transition-speed) ease;
    }
    .modal-overlay.show {
        display: flex;
        opacity: 1;
    }
    .modal-box {
        background: var(--surface);
        border-radius: var(--card-radius);
        padding: 2rem;
        width: 90%;
        max-width: 420px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15);
        transform: scale(0.9);
        transition: transform var(--transition-speed) ease;
    }
    .modal-overlay.show .modal-box {
        transform: scale(1);
    }
    .modal-box .modal-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--theme-danger-light);
        color: var(--theme-danger);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin: 0 auto 1.25rem;
        box-shadow: inset 0 0 0 1px rgba(239, 68, 68, 0.1);
    }
    .modal-box h3 {
        font-size: 1.2rem;
        font-weight: 800;
        text-align: center;
        color: var(--text);
    }
    .modal-box p {
        font-size: 0.88rem;
        color: var(--text-muted);
        text-align: center;
        margin-top: 0.6rem;
        line-height: 1.5;
    }
    .modal-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.75rem;
    }
    .modal-actions .btn-cancel {
        flex: 1;
        padding: 0.75rem;
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text-muted);
        cursor: pointer;
        transition: all var(--transition-speed) ease;
    }
    .modal-actions .btn-cancel:hover {
        background: #e2e8f0;
        color: var(--text);
    }
    .modal-actions .btn-confirm {
        flex: 1;
        padding: 0.75rem;
        background: var(--theme-danger);
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        transition: background var(--transition-speed) ease;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }
    .modal-actions .btn-confirm:hover {
        background: #dc2626;
    }

    /* ── Form Modals (Create & Edit) ── */
    .form-modal-box {
        background: var(--surface);
        border-radius: var(--card-radius);
        padding: 0;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15);
        transform: scale(0.9);
        transition: transform var(--transition-speed) ease;
        overflow: hidden;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
    }
    .modal-overlay.show .form-modal-box {
        transform: scale(1);
    }
    .form-modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fafbfc;
    }
    .form-modal-header h3 {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--text);
        margin: 0;
    }
    .form-modal-close {
        background: transparent;
        border: none;
        font-size: 1.2rem;
        color: var(--text-muted);
        cursor: pointer;
        transition: color var(--transition-speed) ease;
    }
    .form-modal-close:hover {
        color: var(--theme-danger);
    }
    .form-modal-body {
        padding: 1.5rem;
        overflow-y: auto;
    }
    .form-modal-footer {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid var(--border);
        background: #fafbfc;
        display: flex;
        justify-content: flex-end;
        gap: 0.8rem;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        margin-bottom: 1rem;
    }
    .form-group label {
        font-size: 0.82rem;
        font-weight: 800;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .form-group label i {
        color: var(--primary);
        font-size: 0.85rem;
    }
    .form-group label .req {
        color: var(--theme-danger);
    }
    .form-control-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .form-control-wrap i.input-icon {
        position: absolute;
        left: 1rem;
        color: var(--text-muted);
        font-size: 0.9rem;
        pointer-events: none;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.9rem;
        color: var(--text);
        background: #fff;
        transition: all var(--transition-speed) ease;
        outline: none;
    }
    .form-control-wrap i.input-icon + .form-control {
        padding-left: 2.5rem;
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3.5px rgba(74, 144, 226, 0.15);
    }
    
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--transition-speed) ease;
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(74, 144, 226, 0.3);
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .btn-primary {
            width: 100%;
            justify-content: center;
        }
        .card-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas fa-tags" style="color:var(--primary)"></i> Kategori Buku</h1>
        <p>Kelola kategori klasifikasi untuk koleksi buku perpustakaan</p>
    </div>
    <button type="button" class="btn-primary" id="btn-tambah-kategori" onclick="openCreateModal()">
        <i class="fas fa-plus"></i> Tambah Kategori
    </button>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Daftar kategori aktif: <strong>{{ $kategori->total() }} data</strong></span>
    </div>

    <div class="table-wrap">
        <table id="kategori-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">#</th>
                    <th>Nama Kategori</th>
                    <th style="width: 200px; text-align: center;">Jumlah Buku Terkait</th>
                    <th style="width: 180px; text-align: center;">Tanggal Dibuat</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategori as $index => $item)
                @php
                    $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4'];
                    $color = $colors[$item->id_kategori % count($colors)];
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $kategori->firstItem() + $index }}</td>
                    <td>
                        <span class="cat-badge" style="color: {{ $color }}; background: {{ $color }}1a; border-color: {{ $color }}40;">
                            <i class="fas fa-tag"></i>
                            {{ ucwords($item->nama_kategori) }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <span class="buku-count">
                            <i class="fas fa-book"></i>
                            {{ $item->bukus->count() }} buku
                        </span>
                    </td>
                    <td style="text-align: center; color: var(--text-muted); font-weight: 600;">
                        {{ $item->created_at->translatedFormat('d M Y') }}
                    </td>
                    <td>
                        <div class="actions" style="justify-content: center;">
                            <button type="button" class="btn-icon btn-edit" title="Edit Kategori"
                                onclick="openEditModal({
                                    id: '{{ $item->id_kategori }}',
                                    nama: '{{ addslashes($item->nama_kategori) }}'
                                })">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button type="button" class="btn-icon btn-del" title="Hapus Kategori"
                                onclick="confirmDelete(
                                    '{{ route('kperpus.kategori.destroy', $item->id_kategori) }}',
                                    '{{ addslashes(ucwords($item->nama_kategori)) }}',
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
                            <p>Belum ada kategori buku perpustakaan.</p>
                            <span style="font-size: 0.82rem; color: var(--text-muted)">Gunakan tombol di atas untuk membuat kategori baru.</span>
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
        {{ $kategori->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Hapus Kategori?</h3>
        <p id="delete-modal-msg">Apakah Anda yakin ingin menghapus kategori ini?</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <form id="delete-form" method="POST" style="flex: 1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm" style="width: 100%;">Hapus Permanen</button>
            </form>
        </div>
    </div>
</div>

@endsection

{{-- Create Modal --}}
<div class="modal-overlay" id="create-modal">
    <div class="form-modal-box">
        <div class="form-modal-header">
            <h3><i class="fas fa-plus" style="color:var(--primary)"></i> Tambah Kategori Baru</h3>
            <button class="form-modal-close" onclick="closeCreateModal()"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('kperpus.kategori.store') }}" method="POST">
            @csrf
            <div class="form-modal-body">
                <div class="form-group">
                    <label for="create_nama">Nama Kategori <span class="req">*</span></label>
                    <div class="form-control-wrap">
                        <i class="fas fa-tags input-icon"></i>
                        <input type="text" id="create_nama" name="nama_kategori" class="form-control" placeholder="Contoh: Novel, Sains..." required>
                    </div>
                </div>
            </div>
            <div class="form-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeCreateModal()" style="padding: 0.75rem 1.2rem; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; font-weight: 700; cursor: pointer; color: var(--text-muted);">Batal</button>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal-overlay" id="edit-modal">
    <div class="form-modal-box">
        <div class="form-modal-header">
            <h3><i class="fas fa-pen" style="color:var(--primary)"></i> Edit Kategori</h3>
            <button class="form-modal-close" onclick="closeEditModal()"><i class="fas fa-times"></i></button>
        </div>
        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <div class="form-modal-body">
                <div class="form-group">
                    <label for="edit_nama">Nama Kategori <span class="req">*</span></label>
                    <div class="form-control-wrap">
                        <i class="fas fa-tags input-icon"></i>
                        <input type="text" id="edit_nama" name="nama_kategori" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="form-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeEditModal()" style="padding: 0.75rem 1.2rem; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; font-weight: 700; cursor: pointer; color: var(--text-muted);">Batal</button>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Perbarui</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(url, nama, jumlahBuku) {
        document.getElementById('delete-form').action = url;

        let msg = 'Apakah Anda yakin ingin menghapus kategori <strong style="color: var(--text)">"' + nama + '"</strong>?';
        if (jumlahBuku > 0) {
            msg += '<br><br><span style="color: var(--theme-danger); font-weight: 700;"><i class="fas fa-exclamation-circle"></i> PERINGATAN:</span> Kategori ini memiliki <strong>' + jumlahBuku + ' buku</strong> terkait yang akan ikut terhapus secara otomatis (cascade).';
        }
        
        document.getElementById('delete-modal-msg').innerHTML = msg;
        
        const modal = document.getElementById('delete-modal');
        modal.style.display = 'flex';
        setTimeout(() => { modal.classList.add('show'); }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('show');
        setTimeout(() => { modal.style.display = 'none'; }, 200);
    }

    document.getElementById('delete-modal').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });

    // ── Create Modal ──
    function openCreateModal() {
        const modal = document.getElementById('create-modal');
        modal.style.display = 'flex';
        setTimeout(() => { modal.classList.add('show'); }, 10);
    }
    function closeCreateModal() {
        const modal = document.getElementById('create-modal');
        modal.classList.remove('show');
        setTimeout(() => { modal.style.display = 'none'; }, 200);
    }
    document.getElementById('create-modal').addEventListener('click', function (e) {
        if (e.target === this) closeCreateModal();
    });

    // ── Edit Modal ──
    function openEditModal(data) {
        document.getElementById('edit-form').action = "{{ url('kepala-perpustakaan/kategori') }}/" + data.id;
        document.getElementById('edit_nama').value = data.nama;

        const modal = document.getElementById('edit-modal');
        modal.style.display = 'flex';
        setTimeout(() => { modal.classList.add('show'); }, 10);
    }
    function closeEditModal() {
        const modal = document.getElementById('edit-modal');
        modal.classList.remove('show');
        setTimeout(() => { modal.style.display = 'none'; }, 200);
    }
    document.getElementById('edit-modal').addEventListener('click', function (e) {
        if (e.target === this) closeEditModal();
    });
</script>
@endpush
