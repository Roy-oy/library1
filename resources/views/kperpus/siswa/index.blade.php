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
        --transition-speed: 0.2s;
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

    /* ── Class Tabs Navigation ── */
    .class-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--border);
    }
    .tab-item {
        padding: 0.6rem 1.2rem;
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text-muted);
        cursor: pointer;
        transition: all var(--transition-speed) ease;
        white-space: nowrap;
    }
    .tab-item:hover {
        background: var(--theme-primary-light);
        color: var(--primary);
        border-color: var(--primary);
    }
    .tab-item.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* ── Card Container ── */
    .card {
        background: var(--surface);
        border-radius: var(--card-radius);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border);
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

    /* ── MODERN TABLE DESIGN (ALL LEFT ALIGNED) ── */
    .table-wrap {
        overflow-x: auto;
    }
    table.siswa-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }
    table.siswa-table thead th {
        background: #f8fafc;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
        text-align: left; /* Menjamin semua judul kolom rata kiri */
    }
    table.siswa-table tbody td {
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
        text-align: left; /* Menjamin semua baris data rata kiri */
    }
    table.siswa-table tbody tr:last-child td {
        border-bottom: none;
    }
    table.siswa-table tbody tr {
        transition: background-color var(--transition-speed) ease;
    }
    table.siswa-table tbody tr:hover td {
        background-color: #f8fafc !important;
    }

    /* Kode NIS Monospace Utility */
    .nis-code {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 0.82rem;
        background: #f1f5f9;
        color: #475569;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 600;
        border: 1px solid #e2e8f0;
    }

    /* Nama Siswa */
    .student-name {
        font-weight: 600;
        color: #1e293b;
    }

    /* Alamat text style */
    .address-col {
        max-width: 280px;
        color: #64748b;
        line-height: 1.5;
        font-size: 0.85rem;
    }

    /* ── Class Sections Display ── */
    .class-section {
        display: none;
    }
    .class-section.active {
        display: block;
    }

    /* ── Badges / Pills ── */
    .pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .pill-success {
        background: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .pill-accent {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .kelas-badge {
        display: inline-block;
        background: var(--theme-primary-light);
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        border: 1px solid rgba(37, 99, 235, 0.12);
    }

    .gender-badge {
        display: inline-flex;
        align-items: center;
        font-size: 0.9rem;
        font-weight: 500;
        color: #334155;
    }

    /* ── Action Buttons ── */
    .actions {
        display: flex;
        gap: 0.35rem;
    }
    .btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid transparent;
        cursor: pointer;
        font-size: 0.85rem;
        transition: all var(--transition-speed) ease;
        background: #fff;
    }
    .btn-edit {
        border-color: #cbd5e1;
        color: #475569;
    }
    .btn-edit:hover {
        background: #f1f5f9;
        color: #1e293b;
        border-color: #94a3b8;
    }
    .btn-del {
        border-color: #fee2e2;
        color: #ef4444;
        background: #fff5f5;
    }
    .btn-del:hover {
        background: #ef4444;
        color: #fff;
        border-color: #ef4444;
    }

    /* ── Empty state ── */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 2.5rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
        display: block;
    }
    .empty-state p {
        font-size: 0.9rem;
        font-weight: 600;
        color: #64748b;
    }

    /* Modal & Form styles */
    .modal-overlay {
        display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(4px); z-index: 200; align-items: center; justify-content: center;
        opacity: 0; transition: opacity var(--transition-speed) ease;
    }
    .modal-overlay.show { display: flex; opacity: 1; }
    .modal-box {
        background: var(--surface); border-radius: var(--card-radius); padding: 2rem;
        width: 90%; max-width: 420px; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15);
        transform: scale(0.9); transition: transform var(--transition-speed) ease;
    }
    .modal-overlay.show .modal-box { transform: scale(1); }
    .modal-box .modal-icon {
        width: 56px; height: 56px; border-radius: 50%; background: var(--theme-danger-light); color: var(--theme-danger);
        display: flex; align-items: center; justify-content: center; font-size: 1.4rem; margin: 0 auto 1.25rem;
    }
    .modal-box h3 { font-size: 1.15rem; font-weight: 800; text-align: center; color: var(--text); }
    .modal-box p { font-size: 0.88rem; color: var(--text-muted); text-align: center; margin-top: 0.5rem; line-height: 1.5; }
    .modal-actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; }
    .modal-actions .btn-cancel {
        flex: 1; padding: 0.65rem; background: var(--bg); border: 1.5px solid var(--border);
        border-radius: 10px; font-family: inherit; font-size: 0.88rem; font-weight: 700; color: var(--text-muted); cursor: pointer;
    }
    .modal-actions .btn-confirm {
        flex: 1; padding: 0.65rem; background: var(--theme-danger); border: none;
        border-radius: 10px; font-family: inherit; font-size: 0.88rem; font-weight: 700; color: #fff; cursor: pointer;
    }

    /* Form Modals Layout */
    .form-modal-box {
        background: var(--surface); border-radius: var(--card-radius); padding: 0; width: 90%; max-width: 580px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15); transform: scale(0.9); transition: transform var(--transition-speed) ease;
        overflow: hidden; max-height: 90vh; display: flex; flex-direction: column;
    }
    .modal-overlay.show .form-modal-box { transform: scale(1); }
    .form-modal-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; background: #fafbfc; }
    .form-modal-header h3 { font-size: 1.15rem; font-weight: 800; color: var(--text); margin: 0; }
    .form-modal-close { background: transparent; border: none; font-size: 1.1rem; color: var(--text-muted); cursor: pointer; }
    .form-modal-body { padding: 1.5rem; overflow-y: auto; }
    .form-modal-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); background: #fafbfc; display: flex; justify-content: flex-end; gap: 0.75rem; }

    /* Form Controls */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-grid .full { grid-column: 1 / -1; }
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
    .form-group label { font-size: 0.82rem; font-weight: 700; color: #475569; }
    .form-control-wrap { position: relative; display: flex; align-items: center; }
    .form-control-wrap i.input-icon { position: absolute; left: 1rem; color: #94a3b8; font-size: 0.88rem; pointer-events: none; }
    .form-control { width: 100%; padding: 0.65rem 1rem; border: 1.5px solid var(--border); border-radius: 8px; font-family: inherit; font-size: 0.88rem; color: var(--text); outline: none; transition: border-color var(--transition-speed); }
    .form-control-wrap i.input-icon + .form-control { padding-left: 2.5rem; }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    .btn-submit { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.25rem; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-family: inherit; font-size: 0.88rem; font-weight: 700; cursor: pointer; }

    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .btn-primary { width: 100%; justify-content: center; }
        .card-toolbar { flex-direction: column; align-items: stretch; }
        .search-box input { width: 100%; }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas fa-users" style="color:var(--primary)"></i> Data Siswa</h1>
        <p>Kelola profil data siswa dan status keanggotaan perpustakaan berdasarkan kelas</p>
    </div>
    <button type="button" class="btn-primary" id="btn-tambah-siswa" onclick="openCreateModal()">
        <i class="fas fa-user-plus"></i> Tambah Siswa Baru
    </button>
</div>

{{-- Navigation Tabs Per Kelas --}}
<div class="class-tabs">
    <div class="tab-item active" onclick="switchClass('all')">Semua Siswa ({{ $siswa->count() }})</div>
    @foreach(['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'] as $kls)
        @php
            $countSiswaPerKelas = $siswa->where('kelas', $kls)->count();
        @endphp
        <div class="tab-item" onclick="switchClass('{{ $kls }}')">Kelas {{ $kls }} ({{ $countSiswaPerKelas }})</div>
    @endforeach
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Daftar Siswa Terfilter: <strong id="filter-counter">{{ $siswa->count() }} siswa</strong></span>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="search-input" placeholder="Cari NIS atau Nama siswa…">
        </div>
    </div>

    {{-- Bagian Group Semua Kelas --}}
    <div id="class-all" class="class-section active">
        <div class="table-wrap">
            <table class="siswa-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 120px;">NIS</th>
                        <th>Nama Lengkap</th>
                        <th style="width: 110px;">Kelas</th>
                        <th style="width: 80px;">L/P</th>
                        <th>Alamat Lengkap</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswa as $index => $item)
                    <tr>
                        <td style="color: #94a3b8; font-weight: 500;">{{ $index + 1 }}</td>
                        <td>
                            <span class="nis-code">{{ $item->nis }}</span>
                        </td>
                        <td>
                            <span class="student-name">{{ $item->nama_siswa }}</span>
                        </td>
                        <td><span class="kelas-badge">{{ $item->kelas }}</span></td>
                        <td>
                            <span class="gender-badge" title="{{ $item->jenis_kelamin }}">
                                {{ $item->jenis_kelamin === 'Laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td>
                            <div class="address-col">{{ $item->alamat }}</div>
                        </td>
                        <td>
                            @if($item->status === 'aktif')
                                <span class="pill pill-success">Aktif</span>
                            @else
                                <span class="pill pill-accent">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
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
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Bagian Group Tiap-Tiap Kelas --}}
    @foreach(['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'] as $kls)
    <div id="class-{{ $kls }}" class="class-section">
        <div class="table-wrap">
            <table class="siswa-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 120px;">NIS</th>
                        <th>Nama Lengkap</th>
                        <th style="width: 110px;">Kelas</th>
                        <th style="width: 80px;">L/P</th>
                        <th>Alamat Lengkap</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $rowNum = 1; @endphp
                    @forelse ($siswa->where('kelas', $kls) as $item)
                    <tr>
                        <td style="color: #94a3b8; font-weight: 500;">{{ $rowNum++ }}</td>
                        <td>
                            <span class="nis-code">{{ $item->nis }}</span>
                        </td>
                        <td>
                            <span class="student-name">{{ $item->nama_siswa }}</span>
                        </td>
                        <td><span class="kelas-badge">{{ $item->kelas }}</span></td>
                        <td>
                            <span class="gender-badge" title="{{ $item->jenis_kelamin }}">
                                {{ $item->jenis_kelamin === 'Laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td>
                            <div class="address-col">{{ $item->alamat }}</div>
                        </td>
                        <td>
                            @if($item->status === 'aktif')
                                <span class="pill pill-success">Aktif</span>
                            @else
                                <span class="pill pill-accent">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="actions">
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
                                <p>Belum ada data siswa di Kelas {{ $kls }}.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

</div>

{{-- Modals Overlay Delete --}}
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
                <button type="submit" class="btn-confirm" style="width: 100%; background: var(--theme-danger); border: none; border-radius: 10px; font-family: inherit; font-size: 0.88rem; font-weight: 700; color: #fff; cursor: pointer;">Hapus Permanen</button>
            </form>
        </div>
    </div>
</div>

{{-- Modals Overlay Create --}}
<div class="modal-overlay" id="create-modal">
    <div class="form-modal-box">
        <div class="form-modal-header">
            <h3><i class="fas fa-user-plus" style="color:var(--primary)"></i> Tambah Siswa Baru</h3>
            <button type="button" class="form-modal-close" onclick="closeCreateModal()"><i class="fas fa-times"></i></button>
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
                <button type="button" class="btn-cancel" onclick="closeCreateModal()" style="padding: 0.65rem 1.2rem; background: var(--bg); border: 1.5px solid var(--border); border-radius: 8px; font-weight: 700; cursor: pointer; color: var(--text-muted);">Batal</button>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modals Overlay Edit --}}
<div class="modal-overlay" id="edit-modal">
    <div class="form-modal-box">
        <div class="form-modal-header">
            <h3><i class="fas fa-pen" style="color:var(--primary)"></i> Edit Data Siswa</h3>
            <button type="button" class="form-modal-close" onclick="closeEditModal()"><i class="fas fa-times"></i></button>
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
                <button type="button" class="btn-cancel" onclick="closeEditModal()" style="padding: 0.65rem 1.2rem; background: var(--bg); border: 1.5px solid var(--border); border-radius: 8px; font-weight: 700; cursor: pointer; color: var(--text-muted);">Batal</button>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Perbarui</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let currentClassFilter = 'all';

    function switchClass(className) {
        currentClassFilter = className;
        document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
        event.currentTarget.classList.add('active');

        document.querySelectorAll('.class-section').forEach(sec => sec.classList.remove('active'));
        document.getElementById('class-' + className).classList.add('active');

        document.getElementById('search-input').value = '';
        updateCounter(className);
    }

    function updateCounter(className) {
        let rows = (className === 'all') 
            ? document.querySelectorAll('#class-all tbody tr:not(.empty-state-row)')
            : document.querySelectorAll('#class-' + className + ' tbody tr:not(.empty-state-row)');
        
        let visibleCount = 0;
        rows.forEach(r => { if(r.style.display !== 'none') visibleCount++; });
        document.getElementById('filter-counter').textContent = visibleCount + " siswa";
    }

    document.getElementById('search-input').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        const activeTableBody = document.querySelector('.class-section.active tbody');
        
        activeTableBody.querySelectorAll('tr').forEach(row => {
            if (row.querySelector('.empty-state')) return;
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
        updateCounter(currentClassFilter);
    });

    function confirmDelete(url, nama) {
        document.getElementById('delete-form').action = url;
        document.getElementById('delete-modal-msg').innerHTML =
            'Apakah Anda yakin ingin menghapus data siswa <strong style="color: var(--text)">"' + nama + '"</strong>? Semua riwayat pinjam akan disesuaikan. Tindakan ini tidak dapat dibatalkan.';
        const modal = document.getElementById('delete-modal');
        modal.style.display = 'flex';
        setTimeout(() => { modal.classList.add('show'); }, 10);
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('show');
        setTimeout(() => { modal.style.display = 'none'; }, 200);
    }

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
</script>
@endpush