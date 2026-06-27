@extends('kperpus.layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@push('styles')
<style>
    
    :root {
        --theme-primary: #1e3a8a;
        --theme-primary-light: #eff6ff;
        --theme-primary-hover: #172554;
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

    
    .officer-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 1rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .officer-badge i {
        font-size: 0.75rem;
    }

    
    .username-pill {
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
    .username-pill i {
        color: var(--primary);
    }

    
    .date-text {
        font-size: 0.88rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    
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
        padding: 0;
        width: 90%;
        max-width: 550px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15);
        transform: scale(0.9);
        transition: transform var(--transition-speed) ease;
        overflow: hidden;
    }
    .modal-overlay.show .modal-box {
        transform: scale(1);
    }
    .form-card {
        background: transparent;
        border: none;
    }
    .form-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #fafbfc;
    }
    .form-card-header .hdr-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--theme-primary), #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.1rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }
    .form-card-header h2 {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--text);
    }
    .form-card-header p {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-top: 0.15rem;
    }
    .form-body {
        padding: 1.8rem;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        margin-bottom: 1rem;
    }
    .form-group:last-child {
        margin-bottom: 0;
    }
    .form-group label {
        font-size: 0.82rem;
        font-weight: 800;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .form-group label .req {
        color: var(--danger);
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
        border-color: var(--theme-primary);
        box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15);
    }
    .form-control.is-invalid {
        border-color: var(--theme-danger);
    }
    .invalid-feedback {
        font-size: 0.78rem;
        color: var(--theme-danger);
        display: flex;
        align-items: center;
        gap: 0.3rem;
        margin-top: 0.2rem;
        font-weight: 700;
    }
    .form-hint {
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-top: 0.4rem;
        line-height: 1.4;
    }
    .form-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.8rem;
        padding: 1.25rem 1.8rem;
        border-top: 1px solid var(--border);
        background: #fafbfc;
    }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--theme-primary), #1d4ed8);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--transition-speed) ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    .btn-submit:hover {
        transform: translateY(-2px);
    }
    .btn-cancel-modal {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.2rem;
        background: var(--bg);
        color: var(--text-muted);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--transition-speed) ease;
    }
    .btn-cancel-modal:hover {
        background: #e2e8f0;
        color: var(--text);
    }

    
    .modal-box-del {
        max-width: 420px;
        padding: 2rem;
    }
    .modal-box-del .modal-icon {
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
    .modal-box-del h3 {
        font-size: 1.2rem;
        font-weight: 800;
        text-align: center;
        color: var(--text);
    }
    .modal-box-del p {
        font-size: 0.88rem;
        color: var(--text-muted);
        text-align: center;
        margin-top: 0.6rem;
        line-height: 1.5;
    }
    .modal-box-del .modal-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.75rem;
        padding: 0;
        background: transparent;
        border: none;
    }
    .modal-box-del .modal-actions .btn-cancel {
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
    .modal-box-del .modal-actions .btn-cancel:hover {
        background: #e2e8f0;
        color: var(--text);
    }
    .modal-box-del .modal-actions .btn-confirm {
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
    .modal-box-del .modal-actions .btn-confirm:hover {
        background: #dc2626;
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


<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas fa-users-cog" style="color:var(--primary)"></i> Manajemen Pengguna</h1>
        <p>Kelola data pengguna: Penjaga Perpustakaan & Kepala Sekolah</p>
    </div>
    <button type="button" onclick="openCreateModal()" class="btn-primary" style="border:none; cursor:pointer; display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.2rem; border-radius:10px; font-weight:700;">
        <i class="fas fa-plus"></i> Tambah Pengguna
    </button>
</div>


<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Total pengguna: <strong>{{ $officers->count() }} orang</strong></span>
    </div>

    <div class="table-wrap">
        <table class="kperpus-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th style="text-align: left;">Nama Pengguna</th>
                    <th style="width: 180px; text-align: left;">Role</th>
                    <th style="width: 150px; text-align: left;">Username</th>
                    <th style="width: 100px; text-align: center;">Status</th>
                    <th style="width: 120px; text-align: left;">Terdaftar Sejak</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($officers as $officer)
                @php
                    $colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4'];
                    $color = $colors[$officer->id % count($colors)];
                @endphp
                <tr>
                    <td style="text-align: center; color: #94a3b8; font-weight: 500;">{{ $loop->iteration }}</td>
                    <td style="text-align: left;">
                        <span class="officer-badge" style="color: {{ $color }}; background: {{ $color }}1a; border-color: {{ $color }}40;">
                            <i class="fas fa-user"></i>
                            {{ strtoupper($officer->name) }}
                        </span>
                    </td>
                    <td style="text-align: left;">
                        <span style="font-size: 0.82rem; font-weight: 700; color: var(--text); background: #e2e8f0; padding: 0.25rem 0.6rem; border-radius: 6px; text-transform: uppercase;">
                            {{ $officer->role === 'kepala_sekolah' ? 'Kepala Sekolah' : 'Penjaga Perpustakaan' }}
                        </span>
                    </td>
                    <td style="text-align: left;">
                        <span class="username-pill">
                            <i class="fas fa-at"></i>
                            {{ $officer->username }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <span style="font-size: 0.75rem; font-weight: 800; padding: 0.3rem 0.7rem; border-radius: 20px; text-transform: uppercase; {{ $officer->is_active ? 'color: var(--theme-success); background: var(--theme-success-light); border: 1px solid #6ee7b7;' : 'color: var(--theme-danger); background: var(--theme-danger-light); border: 1px solid #fca5a5;' }}">
                            {{ $officer->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td style="text-align: left;">
                        <span class="date-text">
                            <i class="far fa-calendar-alt" style="margin-right: 0.3rem; color: var(--primary)"></i>
                            {{ $officer->created_at->format('d M Y') }}
                        </span>
                    </td>
                    <td>
                        <div class="actions" style="justify-content: center;">
                            <button type="button" class="btn-icon btn-edit" title="Edit Pengguna" 
                                    onclick="openEditModal('{{ $officer->id }}', '{{ addslashes($officer->name) }}', '{{ addslashes($officer->username) }}', '{{ $officer->role }}', {{ $officer->is_active ? 1 : 0 }})">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button type="button" class="btn-icon btn-del" title="Hapus Pengguna"
                                onclick="confirmDelete(
                                    '{{ route('kperpus.petugas.destroy', $officer->id) }}',
                                    '{{ addslashes(strtoupper($officer->name)) }}'
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
                            <i class="fas fa-user-slash"></i>
                            <p>Belum ada data petugas.</p>
                            <span style="font-size: 0.82rem; color: var(--text-muted)">Gunakan tombol di atas untuk mendaftarkan petugas baru.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<div class="modal-overlay" id="delete-modal">
    <div class="modal-box modal-box-del">
        <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Hapus Petugas?</h3>
        <p id="delete-modal-msg">Apakah Anda yakin ingin menghapus petugas ini?</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <form id="delete-form" method="POST" style="flex: 1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm" style="width: 100%;">Ya, Hapus Permanen</button>
            </form>
        </div>
    </div>
</div>


@include('kperpus.petugas.create')
@include('kperpus.petugas.edit')

@endsection

@push('scripts')
<script>
    const updateUrlBase = "{{ url('kepala-perpustakaan/petugas') }}"; 

    
    function openCreateModal() {
        const modal = document.getElementById('create-modal');
        modal.style.display = 'flex';
        setTimeout(() => { 
            modal.classList.add('show'); 
            document.getElementById('create_name').focus();
        }, 10);
    }

    
    function openEditModal(id, name, username, role, is_active) {
        const modal = document.getElementById('edit-modal');
        const form = document.getElementById('edit-form-action');
        const inputName = document.getElementById('edit_name');
        const inputUsername = document.getElementById('edit_username');
        const selectRole = document.getElementById('edit_role');
        const selectStatus = document.getElementById('edit_is_active');

        form.action = updateUrlBase + '/' + id;
        inputName.value = name;
        inputUsername.value = username;
        if(selectRole) selectRole.value = role;
        if(selectStatus) selectStatus.value = is_active;

        modal.style.display = 'flex';
        setTimeout(() => { 
            modal.classList.add('show'); 
            inputName.focus();
        }, 10);
    }

    
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
        setTimeout(() => { modal.style.display = 'none'; }, 200);
    }

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('modal-overlay')) {
            closeModal(e.target.id);
        }
    });

    
    function confirmDelete(url, name) {
        document.getElementById('delete-form').action = url;
        document.getElementById('delete-modal-msg').innerHTML = 'Apakah Anda yakin ingin menghapus pengguna <strong style="color: var(--text)">"' + name + '"</strong>? Data yang dihapus tidak dapat dikembalikan.';
        const modal = document.getElementById('delete-modal');
        modal.style.display = 'flex';
        setTimeout(() => { modal.classList.add('show'); }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.remove('show');
        setTimeout(() => { modal.style.display = 'none'; }, 200);
    }

    @if($errors->any())
        @if(old('_method') == 'PUT')



            openCreateModal(); 
        @else
            openCreateModal();
        @endif
    @endif
</script>
@endpush