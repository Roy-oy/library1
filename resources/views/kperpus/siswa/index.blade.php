@extends('kperpus.layouts.app')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

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

    .search-box {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 0.5rem 1rem;
        transition: all var(--transition-speed) ease;
    }
    .search-box:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.15);
    }
    .search-box i {
        color: var(--text-muted);
        font-size: 0.9rem;
    }
    .search-box input {
        border: none;
        background: transparent;
        outline: none;
        font-family: inherit;
        font-size: 0.88rem;
        color: var(--text);
        width: 240px;
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
    tbody td.student-name-col {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .name-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--theme-primary-light);
        color: var(--primary);
        font-weight: 800;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(37, 99, 235, 0.15);
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

    /* ── Badges / Pills ── */
    .pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.3rem 0.8rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.2px;
    }
    .pill-success {
        background: var(--theme-success-light);
        color: var(--theme-success);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    .pill-accent {
        background: var(--theme-danger-light);
        color: var(--theme-danger);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .kelas-badge {
        display: inline-block;
        background: var(--theme-primary-light);
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 800;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        border: 1px solid rgba(37, 99, 235, 0.15);
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
    .pagination {
        display: flex;
        gap: 0.3rem;
        list-style: none;
    }
    .pagination .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text-muted);
        text-decoration: none;
        border: 1.5px solid var(--border);
        transition: all var(--transition-speed) ease;
    }
    .pagination .page-item.active .page-link {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        box-shadow: 0 4px 10px rgba(74, 144, 226, 0.25);
    }
    .pagination .page-item.disabled .page-link {
        opacity: 0.45;
        pointer-events: none;
    }
    .pagination .page-item .page-link:hover:not(.active) {
        background: var(--theme-primary-light);
        color: var(--primary);
        border-color: var(--primary);
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
        max-width: 600px;
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

    /* ── Form Elements ── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }
    .form-grid .full {
        grid-column: 1 / -1;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
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
        .search-box input {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas fa-users" style="color:var(--primary)"></i> Data Siswa</h1>
        <p>Kelola profil data siswa dan status keanggotaan perpustakaan</p>
    </div>
    <button type="button" class="btn-primary" id="btn-tambah-siswa" onclick="openCreateModal()">
        <i class="fas fa-user-plus"></i> Tambah Siswa Baru
    </button>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Daftar siswa aktif: <strong>{{ $siswa->total() }} siswa</strong></span>
        <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <form action="{{ route('kperpus.siswa.index') }}" method="GET" style="display: flex; gap: 0.5rem; margin: 0;">
                <select name="kelas" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border); outline: none; background: var(--surface); color: var(--text); font-family: inherit; font-size: 0.88rem;">
                    <option value="">Semua Kelas</option>
                    @foreach(['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'] as $kls)
                        <option value="{{ $kls }}" {{ request('kelas') == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                    @endforeach
                </select>
            </form>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="search-input" placeholder="Cari NIS atau Nama siswa…">
            </div>
        </div>
    </div>

    <div class="table-wrap">
        <table id="siswa-table">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">#</th>
                    <th style="width: 100px;">NIS</th>
                    <th>Nama Lengkap</th>
                    <th style="width: 100px;">Kelas</th>
                    <th style="width: 80px; text-align: center;">L/P</th>
                    <th>Alamat</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 100px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswa as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $siswa->firstItem() + $index }}</td>
                    <td>
                        <code style="font-size: 0.8rem; background: var(--theme-primary-light); color: var(--primary); padding: 0.25rem 0.5rem; border-radius: 6px; font-weight: 700; border: 1px solid rgba(37, 99, 235, 0.1);">{{ $item->nis }}</code>
                    </td>
                    <td class="student-name-col">
                        <span style="font-weight: 700; color: var(--text);">{{ $item->nama_siswa }}</span>
                    </td>
                    <td><span class="kelas-badge">{{ $item->kelas }}</span></td>
                    <td style="text-align: center; font-weight: 700; color: #475569;">
                        {{ $item->jenis_kelamin === 'Laki-laki' ? 'L' : 'P' }}
                    </td>
                    <td style="max-width: 250px; color: #475569; line-height: 1.4;">
                        {{ $item->alamat }}
                    </td>
                    <td style="text-align: center;">
                        @if($item->status === 'aktif')
                            <span class="pill pill-success"><i class="fas fa-check-circle" style="font-size: 0.75rem;"></i> Aktif</span>
                        @else
                            <span class="pill pill-accent"><i class="fas fa-times-circle" style="font-size: 0.75rem;"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions" style="justify-content: center;">
                            <button type="button" class="btn-icon btn-edit" title="Edit Data Siswa"
                                onclick="openEditModal({
                                    id: '{{ $item->id_siswa }}',
                                    nis: '{{ addslashes($item->nis) }}',
                                    nama: '{{ addslashes($item->nama_siswa) }}',
                                    kelas: '{{ addslashes($item->kelas) }}',
                                    jenis_kelamin: '{{ addslashes($item->jenis_kelamin) }}',
                                    status: '{{ addslashes($item->status) }}',
                                    alamat: '{{ addslashes($item->alamat) }}'
                                })">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button type="button" class="btn-icon btn-del" title="Hapus Data Siswa"
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
                            <p>Belum ada data siswa dalam keanggotaan.</p>
                            <span style="font-size: 0.82rem; color: var(--text-muted)">Gunakan tombol di atas untuk mendaftarkan siswa baru.</span>
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
        {{ $siswa->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Hapus Data Siswa?</h3>
        <p id="delete-modal-msg">Apakah Anda yakin ingin menghapus data siswa ini? Tindakan ini tidak dapat dibatalkan.</p>
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

{{-- Create Modal --}}
<div class="modal-overlay" id="create-modal">
    <div class="form-modal-box">
        <div class="form-modal-header">
            <h3><i class="fas fa-user-plus" style="color:var(--primary)"></i> Tambah Siswa Baru</h3>
            <button class="form-modal-close" onclick="closeCreateModal()"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('kperpus.siswa.store') }}" method="POST">
            @csrf
            <div class="form-modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="create_nis">NIS <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-barcode input-icon"></i>
                            <input type="text" id="create_nis" name="nis" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="create_nama">Nama Lengkap <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-tag input-icon"></i>
                            <input type="text" id="create_nama" name="nama_siswa" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="create_kelas">Kelas <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-layer-group input-icon"></i>
                            <select id="create_kelas" name="kelas" class="form-control" required>
                                <option value="">— Pilih Kelas —</option>
                                @foreach(['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'] as $kls)
                                    <option value="{{ $kls }}">{{ $kls }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="create_jk">Jenis Kelamin <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-venus-mars input-icon"></i>
                            <select id="create_jk" name="jenis_kelamin" class="form-control" required>
                                <option value="">— Pilih JK —</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group full">
                        <label for="create_status">Status <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-shield input-icon"></i>
                            <select id="create_status" name="status" class="form-control" required>
                                <option value="aktif">Siswa Aktif</option>
                                <option value="nonaktif">Nonaktif / Pindah</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group full">
                        <label for="create_alamat">Alamat Lengkap <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-map-marked-alt input-icon" style="top: 1.1rem;"></i>
                            <textarea id="create_alamat" name="alamat" rows="3" class="form-control" required style="padding-left: 2.5rem;"></textarea>
                        </div>
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
            <h3><i class="fas fa-pen" style="color:var(--primary)"></i> Edit Data Siswa</h3>
            <button class="form-modal-close" onclick="closeEditModal()"><i class="fas fa-times"></i></button>
        </div>
        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <div class="form-modal-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit_nis">NIS <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-barcode input-icon"></i>
                            <input type="text" id="edit_nis" name="nis" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama">Nama Lengkap <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-tag input-icon"></i>
                            <input type="text" id="edit_nama" name="nama_siswa" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_kelas">Kelas <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-layer-group input-icon"></i>
                            <select id="edit_kelas" name="kelas" class="form-control" required>
                                <option value="">— Pilih Kelas —</option>
                                @foreach(['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'] as $kls)
                                    <option value="{{ $kls }}">{{ $kls }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_jk">Jenis Kelamin <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-venus-mars input-icon"></i>
                            <select id="edit_jk" name="jenis_kelamin" class="form-control" required>
                                <option value="">— Pilih JK —</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group full">
                        <label for="edit_status">Status <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-shield input-icon"></i>
                            <select id="edit_status" name="status" class="form-control" required>
                                <option value="aktif">Siswa Aktif</option>
                                <option value="nonaktif">Nonaktif / Pindah</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group full">
                        <label for="edit_alamat">Alamat Lengkap <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-map-marked-alt input-icon" style="top: 1.1rem;"></i>
                            <textarea id="edit_alamat" name="alamat" rows="3" class="form-control" required style="padding-left: 2.5rem;"></textarea>
                        </div>
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

@endsection

@push('scripts')
<script>
    // ── Live search client-side ──
    document.getElementById('search-input').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#siswa-table tbody tr').forEach(row => {
            if (row.querySelector('.empty-state')) return;
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });

    // ── Delete modal ──
    function confirmDelete(url, nama) {
        document.getElementById('delete-form').action = url;
        document.getElementById('delete-modal-msg').innerHTML =
            'Apakah Anda yakin ingin menghapus data siswa <strong style="color: var(--text)">"' + nama + '"</strong>? Semua riwayat pinjam akan disesuaikan. Tindakan ini tidak dapat dibatalkan.';
        
        const modal = document.getElementById('delete-modal');
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
        }, 200);
    }
    
    // Close on backdrop click
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
        document.getElementById('edit-form').action = "{{ url('kepala-perpustakaan/siswa') }}/" + data.id;
        document.getElementById('edit_nis').value = data.nis;
        document.getElementById('edit_nama').value = data.nama;
        document.getElementById('edit_kelas').value = data.kelas;
        document.getElementById('edit_jk').value = data.jenis_kelamin;
        document.getElementById('edit_status').value = data.status;
        document.getElementById('edit_alamat').value = data.alamat;

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
