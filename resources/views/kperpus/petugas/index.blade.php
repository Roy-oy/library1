@extends('kperpus.layouts.app')

@section('title', 'Manajemen Petugas')
@section('page-title', 'Manajemen Petugas')

@push('styles')
<style>
    /* ── Theme variables for this view ── */
    :root {
        --theme-primary: #2563eb;
        --theme-primary-light: #eff6ff;
        --theme-primary-hover: #1d4ed8;
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

    /* ── Card Container ── */
    .card {
        background: var(--surface);
        border-radius: var(--card-radius);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border);
        overflow: hidden;
        margin-top: 1rem;
    }

    /* ── MODERN TABLE DESIGN (ALL LEFT ALIGNED) ── */
    .table-wrap {
        overflow-x: auto;
    }
    table.petugas-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }
    table.petugas-table thead th {
        background: #f8fafc;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
        text-align: left;
    }
    table.petugas-table tbody td {
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
        text-align: left;
    }
    table.petugas-table tbody tr:last-child td {
        border-bottom: none;
    }
    table.petugas-table tbody tr {
        transition: background-color var(--transition-speed) ease;
    }
    table.petugas-table tbody tr:hover td {
        background-color: #f8fafc !important;
    }

    /* Username Monospace Utility */
    .username-code {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 0.82rem;
        background: #f1f5f9;
        color: #475569;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 600;
        border: 1px solid #e2e8f0;
    }

    /* Nama Petugas */
    .officer-name {
        font-weight: 600;
        color: #1e293b;
    }

    /* Date col style */
    .date-col {
        color: #64748b;
        font-size: 0.88rem;
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
        background: var(--surface); border-radius: var(--card-radius); padding: 0; width: 90%; max-width: 500px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15); transform: scale(0.9); transition: transform var(--transition-speed) ease;
        overflow: hidden; max-height: 90vh; display: flex; flex-direction: column;
    }
    .modal-overlay.show .form-modal-box { transform: scale(1); }
    .form-modal-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; background: #fafbfc; }
    .form-modal-header h3 { font-size: 1.15rem; font-weight: 800; color: var(--text); margin: 0; }
    .form-modal-close { background: transparent; border: none; font-size: 1.1rem; color: var(--text-muted); cursor: pointer; }
    .form-modal-close:hover { color: var(--theme-danger); }
    .form-modal-body { padding: 1.5rem; overflow-y: auto; }
    .form-modal-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); background: #fafbfc; display: flex; justify-content: flex-end; gap: 0.75rem; }

    /* Form Controls */
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1.25rem; }
    .form-group label { font-size: 0.82rem; font-weight: 700; color: #475569; display: flex; align-items: center; gap: 0.3rem; }
    .form-group label i { color: var(--primary); font-size: 0.85rem; }
    .form-group label .req { color: var(--theme-danger); }
    
    .form-control-wrap { position: relative; display: flex; align-items: center; }
    .form-control-wrap i.input-icon { position: absolute; left: 1rem; color: #94a3b8; font-size: 0.88rem; pointer-events: none; }
    .form-control { width: 100%; padding: 0.65rem 1rem; padding-left: 2.5rem; border: 1.5px solid var(--border); border-radius: 8px; font-family: inherit; font-size: 0.88rem; color: var(--text); outline: none; transition: border-color var(--transition-speed); }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
    .btn-submit { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.25rem; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-family: inherit; font-size: 0.88rem; font-weight: 700; cursor: pointer; }

    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .btn-primary { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas fa-user-shield" style="color:var(--primary)"></i> Manajemen Petugas</h1>
        <p>Kelola data penjaga perpustakaan (staff operasional)</p>
    </div>
    <button type="button" class="btn-primary" onclick="openCreateModal()">
        <i class="fas fa-plus"></i> Tambah Petugas
    </button>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="table-wrap">
        <table class="petugas-table">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Nama Petugas</th>
                    <th style="width: 180px;">Username</th>
                    <th style="width: 180px;">Terdaftar Sejak</th>
                    <th style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($officers as $officer)
                <tr>
                    <td style="color: #94a3b8; font-weight: 500;">{{ $loop->iteration }}</td>
                    <td>
                        <span class="officer-name">{{ $officer->name }}</span>
                    </td>
                    <td>
                        <span class="username-code">{{ $officer->username }}</span>
                    </td>
                    <td>
                        <span class="date-col">{{ $officer->created_at->format('d M Y') }}</span>
                    </td>
                    <td>
                        <div class="actions">
                            <button type="button" class="btn-icon btn-edit" title="Edit Petugas" 
                                onclick="openEditModal('{{ $officer->id }}', '{{ addslashes($officer->name) }}', '{{ addslashes($officer->username) }}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn-icon btn-del" title="Hapus Petugas" 
                                onclick="confirmDelete('{{ route('kperpus.petugas.destroy', $officer->id) }}', '{{ addslashes($officer->name) }}')">
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
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="formModal" class="modal-overlay">
    <div class="form-modal-box">
        <div class="form-modal-header">
            <h3 id="formModalTitle"><i class="fas fa-user-plus" style="color:var(--primary)"></i> Tambah Petugas Baru</h3>
            <button class="form-modal-close" onclick="closeFormModal()"><i class="fas fa-times"></i></button>
        </div>
        <form id="petugasForm" action="{{ route('kperpus.petugas.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="form-modal-body">
                
                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> Nama Lengkap <span class="req">*</span></label>
                    <div class="form-control-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama lengkap petugas..." required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-at"></i> Username <span class="req">*</span></label>
                    <div class="form-control-wrap">
                        <i class="fas fa-user-circle input-icon"></i>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username untuk login..." required>
                    </div>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-key"></i> Password <span id="passwordReq" class="req">*</span></label>
                    <div class="form-control-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter..." required minlength="8">
                    </div>
                    <div id="passwordHelp" style="font-size: 0.75rem; color: #64748b; margin-top: 0.3rem; display: none;">
                        *Kosongkan jika tidak ingin mengubah password
                    </div>
                </div>

            </div>
            <div class="form-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeFormModal()">Batal</button>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Petugas</button>
            </div>
        </form>
    </div>
</div>

<div id="deleteModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Hapus Petugas?</h3>
        <p>Apakah Anda yakin ingin menghapus petugas <strong id="deleteTargetName" style="color: var(--text)"></strong>? Data yang dihapus tidak dapat dikembalikan.</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST" style="margin:0; flex:1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm" style="width:100%;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const formModal = document.getElementById('formModal');
    const deleteModal = document.getElementById('deleteModal');
    const petugasForm = document.getElementById('petugasForm');
    const formMethod = document.getElementById('formMethod');
    const formTitle = document.getElementById('formModalTitle');
    
    function openCreateModal() {
        formTitle.innerHTML = '<i class="fas fa-user-plus" style="color:var(--primary)"></i> Tambah Petugas Baru';
        petugasForm.action = "{{ route('kperpus.petugas.store') }}";
        formMethod.value = "POST";
        
        document.getElementById('name').value = '';
        document.getElementById('username').value = '';
        document.getElementById('password').value = '';
        document.getElementById('password').required = true;
        document.getElementById('passwordReq').style.display = 'inline';
        document.getElementById('passwordHelp').style.display = 'none';
        
        formModal.style.display = 'flex';
        setTimeout(() => { formModal.classList.add('show'); }, 10);
    }

    function openEditModal(id, name, username) {
        formTitle.innerHTML = '<i class="fas fa-user-edit" style="color:var(--primary)"></i> Edit Petugas';
        petugasForm.action = `/kepala-perpustakaan/petugas/${id}`;
        formMethod.value = "PUT";
        
        document.getElementById('name').value = name;
        document.getElementById('username').value = username;
        document.getElementById('password').value = '';
        document.getElementById('password').required = false;
        document.getElementById('passwordReq').style.display = 'none';
        document.getElementById('passwordHelp').style.display = 'block';
        
        formModal.style.display = 'flex';
        setTimeout(() => { formModal.classList.add('show'); }, 10);
    }

    function closeFormModal() {
        formModal.classList.remove('show');
        setTimeout(() => { formModal.style.display = 'none'; }, 200);
    }

    function confirmDelete(url, name) {
        document.getElementById('deleteTargetName').textContent = `"${name}"`;
        document.getElementById('deleteForm').action = url;
        deleteModal.style.display = 'flex';
        setTimeout(() => { deleteModal.classList.add('show'); }, 10);
    }

    function closeDeleteModal() {
        deleteModal.classList.remove('show');
        setTimeout(() => { deleteModal.style.display = 'none'; }, 200);
    }

    window.onclick = function(event) {
        if (event.target == formModal) closeFormModal();
        if (event.target == deleteModal) closeDeleteModal();
    }
</script>
@endpush