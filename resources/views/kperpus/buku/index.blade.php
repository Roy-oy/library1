@extends('kperpus.layouts.app')

@section('title', 'Data Buku')
@section('page-title', 'Data Buku Perpustakaan')

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
        margin-top: 2rem;
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

    /* ── Tab Navigation ── */
    .tab-nav {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
        padding-bottom: 2px;
    }
    .tab-item {
        padding: 0.75rem 1.4rem;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-muted);
        text-decoration: none;
        border-radius: 8px 8px 0 0;
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all var(--transition-speed) ease;
    }
    .tab-item i {
        font-size: 0.95rem;
    }
    .tab-item:hover {
        color: var(--primary);
        background: rgba(74, 144, 226, 0.06);
    }
    .tab-item.active {
        color: var(--primary);
    }
    .tab-item.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--primary);
        border-radius: 3px 3px 0 0;
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
    tbody tr:last-child td {
        border-bottom: none;
    }
    tbody tr {
        transition: background var(--transition-speed) ease;
    }
    tbody tr:hover td {
        background: var(--theme-primary-light) !important;
    }

    /* ── Book Cover ── */
    .book-cover-container {
        position: relative;
        width: 48px;
        height: 66px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        transition: transform var(--transition-speed) ease;
    }
    .book-cover-container:hover {
        transform: scale(1.1) translateY(-2px);
    }
    .book-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .book-cover-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .book-cover-placeholder i {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.1rem;
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
    .pill-warning {
        background: var(--theme-warning-light);
        color: var(--theme-warning);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }
    .pill-info {
        background: var(--theme-info-light);
        color: var(--theme-info);
        border: 1px solid rgba(14, 165, 233, 0.2);
    }

    .kelas-badge {
        display: inline-block;
        background: var(--accent-light);
        color: #b45309;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        border: 1px solid rgba(245, 158, 11, 0.15);
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

    /* ── Modals ── */
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
        max-width: 800px;
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

    /* ── Radio Styling ── */
    .radio-group {
        display: flex;
        gap: 1.25rem;
        margin-top: 0.25rem;
    }
    .radio-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text);
        cursor: pointer;
        background: #f8fafc;
        padding: 0.75rem 1.2rem;
        border-radius: 10px;
        border: 1.5px solid var(--border);
        flex: 1;
        transition: all var(--transition-speed) ease;
    }
    .radio-label:hover {
        background: var(--theme-primary-light);
        border-color: var(--primary);
    }
    .radio-label input[type="radio"] {
        accent-color: var(--primary);
        width: 17px;
        height: 17px;
    }
    .radio-label.checked {
        background: var(--theme-primary-light);
        border-color: var(--primary);
        color: var(--primary);
    }
    .section-divider {
        grid-column: 1 / -1;
        border: none;
        border-top: 1.5px dashed var(--border);
        margin: 0.5rem 0;
    }
    .section-title {
        grid-column: 1 / -1;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-title::after {
        content: '';
        flex: 1;
        height: 1.5px;
        background: var(--border);
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
    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-grid .full {
            grid-column: 1;
        }
        .radio-group {
            flex-direction: column;
            gap: 0.6rem;
        }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas {{ $type === 'bos' ? 'fa-graduation-cap' : 'fa-book' }}" style="color:var(--primary)"></i> {{ $pageTitle }}</h1>
        <p>Kelola koleksi {{ strtolower($pageTitle) }} perpustakaan sekolah</p>
    </div>
    <button type="button" class="btn-primary" id="btn-tambah-buku" onclick="openCreateModal()">
        <i class="fas fa-plus"></i> Tambah Buku Baru
    </button>
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
        <span class="total-label">Daftar koleksi: <strong>{{ $buku->total() }} buku</strong></span>
        <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <form action="{{ route('kperpus.buku.index') }}" method="GET" style="display: flex; gap: 0.5rem; margin: 0;">
                <input type="hidden" name="type" value="{{ $type }}">
                @if($type === 'bos')
                    <select name="kelas" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border); outline: none; background: var(--surface); color: var(--text); font-family: inherit; font-size: 0.88rem;">
                        <option value="">Semua Kelas</option>
                        @foreach(['VII', 'VIII', 'IX'] as $kls)
                            <option value="{{ $kls }}" {{ request('kelas') == $kls ? 'selected' : '' }}>Kelas {{ $kls }}</option>
                        @endforeach
                    </select>
                @else
                    <select name="kategori" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem; border-radius: 8px; border: 1px solid var(--border); outline: none; background: var(--surface); color: var(--text); font-family: inherit; font-size: 0.88rem;">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori_list as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                @endif
            </form>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="search-input" placeholder="Cari berdasarkan judul, kode atau pengarang…">
            </div>
        </div>
    </div>

    <div class="table-wrap">
        <table id="buku-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="width: 70px;">Cover</th>
                    <th style="width: 130px;">Kode</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th style="width: 90px;">Tahun</th>
                    <th style="width: 140px;">ISBN</th>
                    <th style="width: 90px;">Stok</th>
                    @if($type !== 'bos')
                        <th>Kategori</th>
                    @else
                        <th>Kelas</th>
                    @endif
                    <th style="width: 120px;">Status</th>
                    <th style="width: 110px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $buku->firstItem() + $index }}</td>
                    <td style="text-align: center;">
                        <div class="book-cover-container">
                            @if($item->gambar)
                                <img src="{{ Storage::url($item->gambar) }}"
                                     alt="{{ $item->judul_buku }}"
                                     class="book-cover">
                            @else
                                <div class="book-cover-placeholder">
                                    <i class="fas fa-book"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <code style="font-size:0.8rem; background: var(--theme-primary-light); color: var(--primary); padding: 0.25rem 0.5rem; border-radius: 6px; font-weight: 700; border: 1px solid rgba(37, 99, 235, 0.1);">{{ $item->kode_buku }}</code>
                    </td>
                    <td style="font-weight: 700; max-width: 240px; line-height: 1.4;">{{ $item->judul_buku }}</td>
                    <td style="font-weight: 600; color: #475569;">{{ $item->pengarang }}</td>
                    <td style="text-align: center;"><span style="font-weight: 700; color: #475569;">{{ $item->tahun_terbit }}</span></td>
                    <td style="color: #64748b; text-align: center;">{{ $item->isbn ?? '—' }}</td>
                    <td style="text-align: center;">
                        <span class="pill {{ $item->stok > 0 ? 'pill-success' : 'pill-warning' }}">
                            {{ $item->stok }} eks
                        </span>
                    </td>
                    @if($type !== 'bos')
                        @php
                            $catColors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4'];
                            $catColor = $item->id_kategori ? $catColors[$item->id_kategori % count($catColors)] : '#64748b';
                        @endphp
                        <td>
                            @if($item->kategoriBuku)
                                <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.9rem; border-radius: 30px; font-size: 0.8rem; font-weight: 700; color: {{ $catColor }}; background: {{ $catColor }}1a; border: 1px solid {{ $catColor }}40;">
                                    <i class="fas fa-tag" style="font-size: 0.7rem;"></i>
                                    {{ $item->kategoriBuku->nama_kategori }}
                                </span>
                            @else
                                <span style="color:var(--text-muted)">—</span>
                            @endif
                        </td>
                    @else
                        <td style="text-align: center;">
                            @if($item->kelas)
                                <span class="kelas-badge">Kls {{ $item->kelas }}</span>
                            @else
                                <span style="color:var(--text-muted)">—</span>
                            @endif
                        </td>
                    @endif
                    <td style="text-align: center;">
                        @if($item->status_buku === 'tersedia')
                            <span class="pill pill-success"><i class="fas fa-circle" style="font-size: 0.45rem;"></i> Tersedia</span>
                        @else
                            <span class="pill pill-warning"><i class="fas fa-circle" style="font-size: 0.45rem;"></i> Dipinjam</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions" style="justify-content: center;">
                            <button type="button" class="btn-icon btn-edit" title="Edit Buku"
                                onclick="openEditModal({{ json_encode([
                                    'id' => $item->id_buku,
                                    'kode' => $item->kode_buku,
                                    'isbn' => $item->isbn,
                                    'judul' => $item->judul_buku,
                                    'pengarang' => $item->pengarang,
                                    'tahun' => $item->tahun_terbit,
                                    'sumber' => $item->sumber_buku,
                                    'kategori' => $item->id_kategori,
                                    'kelas' => $item->kelas,
                                    'stok' => $item->stok,
                                ]) }})">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button type="button" class="btn-icon btn-del" title="Hapus Buku"
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
                            <p>Belum ada data buku dalam kategori ini.</p>
                            <span style="font-size: 0.82rem; color: var(--text-muted)">Gunakan tombol di atas untuk menambah koleksi buku baru.</span>
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
        {{ $buku->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Hapus Buku?</h3>
        <p id="delete-modal-msg">Apakah Anda yakin ingin menghapus buku ini? Tindakan ini tidak dapat dibatalkan.</p>
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
    <div class="form-modal-box" style="max-width: 900px;">
        <div class="form-modal-header">
            <h3><i class="fas fa-plus" style="color:var(--primary)"></i> Tambah Buku Baru</h3>
            <button class="form-modal-close" onclick="closeCreateModal()"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('kperpus.buku.store') }}" method="POST" enctype="multipart/form-data" id="form-buku">
            @csrf
            <div class="form-modal-body">
                <div class="form-grid">
                    {{-- ── Identitas Buku ─────────────────── --}}
                    <div class="section-title">Identitas Buku</div>
                    <div class="form-group">
                        <label for="create_kode_buku">Kode Buku <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-barcode input-icon"></i>
                            <input type="text" id="create_kode_buku" name="kode_buku" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="create_isbn">ISBN</label>
                        <div class="form-control-wrap">
                            <i class="fas fa-fingerprint input-icon"></i>
                            <input type="text" id="create_isbn" name="isbn" class="form-control" placeholder="Maksimal 13 karakter" maxlength="13">
                        </div>
                    </div>
                    <div class="form-group full">
                        <label for="create_judul_buku">Judul Buku <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-heading input-icon"></i>
                            <input type="text" id="create_judul_buku" name="judul_buku" class="form-control" placeholder="Masukkan judul lengkap buku" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="create_pengarang">Nama Pengarang <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-edit input-icon"></i>
                            <input type="text" id="create_pengarang" name="pengarang" class="form-control" placeholder="Nama pengarang / penulis" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="create_tahun_terbit">Tahun Terbit <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-calendar-alt input-icon"></i>
                            <input type="number" id="create_tahun_terbit" name="tahun_terbit" class="form-control" placeholder="Contoh: 2024" min="1900" max="{{ date('Y') }}" required>
                        </div>
                    </div>

                    {{-- ── Sumber & Klasifikasi ─────────────────── --}}
                    <hr class="section-divider">
                    <div class="section-title">Sumber & Klasifikasi</div>
                    <div class="form-group full">
                        <label>Sumber Anggaran Buku <span class="req">*</span></label>
                        <div class="radio-group">
                            <label class="radio-label" id="create-radio-label-bos">
                                <input type="radio" name="sumber_buku" value="bos" required>
                                Buku BOS (Operasional Sekolah)
                            </label>
                            <label class="radio-label checked" id="create-radio-label-perpus">
                                <input type="radio" name="sumber_buku" value="buku perpus" checked required>
                                Buku Perpus (Koleksi Umum)
                            </label>
                        </div>
                    </div>
                    <div class="form-group" id="create-kategori-group">
                        <label for="create_id_kategori">Kategori Buku <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-bookmark input-icon"></i>
                            <select id="create_id_kategori" name="id_kategori" class="form-control">
                                <option value="">— Pilih Kategori —</option>
                                @foreach($kategori_list as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="create-kelas-group" style="display: none;">
                        <label for="create_kelas">Kelas Peruntukan <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-layer-group input-icon"></i>
                            <select id="create_kelas" name="kelas" class="form-control">
                                <option value="">— Pilih Kelas —</option>
                                <option value="VII">Kelas VII</option>
                                <option value="VIII">Kelas VIII</option>
                                <option value="IX">Kelas IX</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="create_stok">Stok Awal <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-boxes input-icon"></i>
                            <input type="number" id="create_stok" name="stok" class="form-control" value="1" min="1" required>
                        </div>
                    </div>

                    <hr class="section-divider">
                    <div class="section-title">Cover Buku</div>
                    <div class="form-group full">
                        <label for="create_gambar">Upload Cover Buku</label>
                        <div class="form-control-wrap">
                            <i class="fas fa-image input-icon" style="top: 1.1rem;"></i>
                            <input type="file" id="create_gambar" name="gambar" accept="image/jpg,image/jpeg,image/png" class="form-control" style="padding-top: 0.6rem; padding-bottom: 0.6rem;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeCreateModal()" style="padding: 0.75rem 1.2rem; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; font-weight: 700; cursor: pointer; color: var(--text-muted);">Batal</button>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Buku</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal-overlay" id="edit-modal">
    <div class="form-modal-box" style="max-width: 900px;">
        <div class="form-modal-header">
            <h3><i class="fas fa-pen" style="color:var(--primary)"></i> Edit Buku</h3>
            <button class="form-modal-close" onclick="closeEditModal()"><i class="fas fa-times"></i></button>
        </div>
        <form id="edit-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-modal-body">
                <div class="form-grid">
                    <div class="section-title">Identitas Buku</div>
                    <div class="form-group">
                        <label for="edit_kode_buku">Kode Buku <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-barcode input-icon"></i>
                            <input type="text" id="edit_kode_buku" name="kode_buku" class="form-control" required readonly style="background: #f1f5f9;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_isbn">ISBN</label>
                        <div class="form-control-wrap">
                            <i class="fas fa-fingerprint input-icon"></i>
                            <input type="text" id="edit_isbn" name="isbn" class="form-control" placeholder="Maksimal 13 karakter" maxlength="13">
                        </div>
                    </div>
                    <div class="form-group full">
                        <label for="edit_judul_buku">Judul Buku <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-heading input-icon"></i>
                            <input type="text" id="edit_judul_buku" name="judul_buku" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_pengarang">Nama Pengarang <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-edit input-icon"></i>
                            <input type="text" id="edit_pengarang" name="pengarang" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_tahun_terbit">Tahun Terbit <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-calendar-alt input-icon"></i>
                            <input type="number" id="edit_tahun_terbit" name="tahun_terbit" class="form-control" min="1900" required>
                        </div>
                    </div>

                    <hr class="section-divider">
                    <div class="section-title">Sumber & Klasifikasi</div>
                    <div class="form-group full">
                        <label>Sumber Anggaran Buku <span class="req">*</span></label>
                        <div class="radio-group">
                            <label class="radio-label" id="edit-radio-label-bos">
                                <input type="radio" name="sumber_buku" value="bos" required>
                                Buku BOS (Operasional Sekolah)
                            </label>
                            <label class="radio-label" id="edit-radio-label-perpus">
                                <input type="radio" name="sumber_buku" value="buku perpus" required>
                                Buku Perpus (Koleksi Umum)
                            </label>
                        </div>
                    </div>
                    <div class="form-group" id="edit-kategori-group">
                        <label for="edit_id_kategori">Kategori Buku <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-bookmark input-icon"></i>
                            <select id="edit_id_kategori" name="id_kategori" class="form-control">
                                <option value="">— Pilih Kategori —</option>
                                @foreach($kategori_list as $kat)
                                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="edit-kelas-group">
                        <label for="edit_kelas">Kelas Peruntukan <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-layer-group input-icon"></i>
                            <select id="edit_kelas" name="kelas" class="form-control">
                                <option value="">— Pilih Kelas —</option>
                                <option value="VII">Kelas VII</option>
                                <option value="VIII">Kelas VIII</option>
                                <option value="IX">Kelas IX</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_stok">Stok <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-boxes input-icon"></i>
                            <input type="number" id="edit_stok" name="stok" class="form-control" min="0" required>
                        </div>
                    </div>

                    <hr class="section-divider">
                    <div class="section-title">Cover Buku</div>
                    <div class="form-group full">
                        <label for="edit_gambar">Upload Cover Baru (Opsional)</label>
                        <div class="form-control-wrap">
                            <i class="fas fa-image input-icon" style="top: 1.1rem;"></i>
                            <input type="file" id="edit_gambar" name="gambar" accept="image/jpg,image/jpeg,image/png" class="form-control" style="padding-top: 0.6rem; padding-bottom: 0.6rem;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeEditModal()" style="padding: 0.75rem 1.2rem; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; font-weight: 700; cursor: pointer; color: var(--text-muted);">Batal</button>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Perbarui Buku</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // ── Live search client-side ──
    document.getElementById('search-input').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#buku-table tbody tr').forEach(row => {
            if (row.querySelector('.empty-state')) return;
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });

    // ── Modals Logic ──
    function closeAllModals() {
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.classList.remove('show');
            setTimeout(() => { modal.style.display = 'none'; }, 200);
        });
    }

    // Delete Modal
    function confirmDelete(url, judul) {
        document.getElementById('delete-form').action = url;
        document.getElementById('delete-modal-msg').innerHTML =
            'Apakah Anda yakin ingin menghapus buku <strong style="color: var(--text)">"' + judul + '"</strong>? Tindakan ini tidak dapat dibatalkan.';
        
        const modal = document.getElementById('delete-modal');
        modal.style.display = 'flex';
        setTimeout(() => { modal.classList.add('show'); }, 10);
    }
    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('show');
        setTimeout(() => { modal.style.display = 'none'; }, 200);
    }
    
    // Create Modal
    function openCreateModal() {
        const modal = document.getElementById('create-modal');
        modal.style.display = 'flex';
        setTimeout(() => { modal.classList.add('show'); }, 10);
        updateCreateKodeBuku();
    }
    function closeCreateModal() {
        const modal = document.getElementById('create-modal');
        modal.classList.remove('show');
        setTimeout(() => { modal.style.display = 'none'; }, 200);
    }

    // Edit Modal
    function openEditModal(data) {
        document.getElementById('edit-form').action = "{{ url('kepala-perpustakaan/buku') }}/" + data.id;
        document.getElementById('edit_kode_buku').value = data.kode;
        document.getElementById('edit_isbn').value = data.isbn || '';
        document.getElementById('edit_judul_buku').value = data.judul;
        document.getElementById('edit_pengarang').value = data.pengarang;
        document.getElementById('edit_tahun_terbit').value = data.tahun;
        document.getElementById('edit_stok').value = data.stok;

        const radios = document.querySelectorAll('input[name="sumber_buku"][form="edit-form"], #edit-modal input[name="sumber_buku"]');
        radios.forEach(r => {
            if (r.value === data.sumber) r.checked = true;
        });
        document.getElementById('edit_id_kategori').value = data.kategori || '';
        document.getElementById('edit_kelas').value = data.kelas || '';
        toggleEditFields();

        const modal = document.getElementById('edit-modal');
        modal.style.display = 'flex';
        setTimeout(() => { modal.classList.add('show'); }, 10);
    }
    function closeEditModal() {
        const modal = document.getElementById('edit-modal');
        modal.classList.remove('show');
        setTimeout(() => { modal.style.display = 'none'; }, 200);
    }

    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === this) closeAllModals();
        });
    });

    // ── Create Modal Dynamic Logic ──
    const createRadioBos = document.querySelector('#create-modal input[name="sumber_buku"][value="bos"]');
    const createRadioPerpus = document.querySelector('#create-modal input[name="sumber_buku"][value="buku perpus"]');
    const createLabelBos = document.getElementById('create-radio-label-bos');
    const createLabelPerpus = document.getElementById('create-radio-label-perpus');
    const createKelasGroup = document.getElementById('create-kelas-group');
    const createKatGroup = document.getElementById('create-kategori-group');

    function toggleCreateFields() {
        if (createRadioBos.checked) {
            createKelasGroup.style.display = 'flex';
            createKatGroup.style.display = 'none';
            document.getElementById('create_id_kategori').value = '';
            createLabelBos.classList.add('checked');
            createLabelPerpus.classList.remove('checked');
        } else {
            createKelasGroup.style.display = 'none';
            createKatGroup.style.display = 'flex';
            document.getElementById('create_kelas').value = '';
            createLabelPerpus.classList.add('checked');
            createLabelBos.classList.remove('checked');
        }
    }
    function updateCreateKodeBuku() {
        const checkedRadio = document.querySelector('#create-modal input[name="sumber_buku"]:checked');
        if (!checkedRadio) return;
        const sumber = checkedRadio.value;
        fetch(`{{ route('kperpus.buku.generate-kode') }}?sumber=${encodeURIComponent(sumber)}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.code) document.getElementById('create_kode_buku').value = data.code;
            });
    }
    createRadioBos.addEventListener('change', () => { toggleCreateFields(); updateCreateKodeBuku(); });
    createRadioPerpus.addEventListener('change', () => { toggleCreateFields(); updateCreateKodeBuku(); });

    // ── Edit Modal Dynamic Logic ──
    const editRadioBos = document.querySelector('#edit-modal input[name="sumber_buku"][value="bos"]');
    const editRadioPerpus = document.querySelector('#edit-modal input[name="sumber_buku"][value="buku perpus"]');
    const editLabelBos = document.getElementById('edit-radio-label-bos');
    const editLabelPerpus = document.getElementById('edit-radio-label-perpus');
    const editKelasGroup = document.getElementById('edit-kelas-group');
    const editKatGroup = document.getElementById('edit-kategori-group');

    function toggleEditFields() {
        if (editRadioBos.checked) {
            editKelasGroup.style.display = 'flex';
            editKatGroup.style.display = 'none';
            document.getElementById('edit_id_kategori').value = '';
            editLabelBos.classList.add('checked');
            editLabelPerpus.classList.remove('checked');
        } else {
            editKelasGroup.style.display = 'none';
            editKatGroup.style.display = 'flex';
            document.getElementById('edit_kelas').value = '';
            editLabelPerpus.classList.add('checked');
            editLabelBos.classList.remove('checked');
        }
    }
    editRadioBos.addEventListener('change', toggleEditFields);
    editRadioPerpus.addEventListener('change', toggleEditFields);

</script>
@endpush
