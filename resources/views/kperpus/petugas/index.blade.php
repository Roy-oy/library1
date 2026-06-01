@extends('kperpus.layouts.app')

@section('title', 'Manajemen Petugas')
@section('page-title', 'Manajemen Petugas')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: .8rem;
    }
    .page-header h1 { font-size: 1.25rem; font-weight: 800; color: var(--text); }
    .page-header p { font-size: .84rem; color: var(--text-muted); margin-top: .2rem; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .55rem 1.1rem;
        background: var(--primary); color: #fff;
        border: none; border-radius: 8px;
        font-family: inherit; font-size: .85rem; font-weight: 600;
        cursor: pointer; text-decoration: none;
        transition: background .2s, transform .15s;
    }
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); color: #fff; }

    .card {
        background: var(--surface); border-radius: var(--radius);
        box-shadow: var(--shadow); overflow: hidden;
    }
    
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc;
        font-size: .73rem; font-weight: 700; text-transform: uppercase;
        padding: .85rem 1.1rem; border-bottom: 1px solid var(--border);
        color: var(--text-muted); text-align: left;
    }
    tbody td {
        padding: 1rem 1.1rem; font-size: .88rem;
        border-bottom: 1px solid #f0f4f8; color: var(--text);
        vertical-align: middle;
    }

    .userpage-info { display: flex; align-items: center; gap: .8rem; }
    .userpage-avatar {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .9rem;
    }

    .btn-action {
        width: 32px; height: 32px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        text-decoration: none; font-size: .85rem; border: none; cursor: pointer;
    }
    .btn-edit { background: #ebf5fb; color: #2980b9; }
    .btn-delete { background: #fdf0ef; color: #e74c3c; }

    /* Modals */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(4px);
        z-index: 200; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.25s ease;
    }
    .modal-overlay.show { display: flex; opacity: 1; }
    
    .form-modal-box {
        background: var(--surface); border-radius: 16px; padding: 0;
        width: 90%; max-width: 500px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15);
        transform: scale(0.9); transition: transform 0.25s ease;
        overflow: hidden; max-height: 90vh; display: flex; flex-direction: column;
    }
    .modal-overlay.show .form-modal-box { transform: scale(1); }
    
    .form-modal-header {
        padding: 1.5rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        background: #fafbfc;
    }
    .form-modal-header h3 { font-size: 1.2rem; font-weight: 800; color: var(--text); margin: 0; }
    .form-modal-close {
        background: transparent; border: none; font-size: 1.2rem;
        color: var(--text-muted); cursor: pointer; transition: color 0.2s ease;
    }
    .form-modal-close:hover { color: var(--theme-danger); }
    
    .form-modal-body { padding: 1.5rem; overflow-y: auto; }
    .form-modal-footer {
        padding: 1.25rem 1.5rem; border-top: 1px solid var(--border);
        background: #fafbfc; display: flex; justify-content: flex-end; gap: 0.8rem;
    }

    .form-group { display: flex; flex-direction: column; gap: 0.45rem; margin-bottom: 1rem; }
    .form-group label { font-size: 0.82rem; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 0.3rem; }
    .form-group label i { color: var(--primary); font-size: 0.85rem; }
    .form-group label .req { color: var(--theme-danger); }
    
    .form-control-wrap { position: relative; display: flex; align-items: center; }
    .form-control-wrap i.input-icon { position: absolute; left: 1rem; color: var(--text-muted); font-size: 0.9rem; pointer-events: none; }
    .form-control {
        width: 100%; padding: 0.75rem 1rem; padding-left: 2.5rem;
        border: 1.5px solid var(--border); border-radius: 10px;
        font-family: inherit; font-size: 0.9rem; color: var(--text);
        background: #fff; transition: all 0.2s ease; outline: none;
    }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3.5px rgba(74, 144, 226, 0.15); }

    .btn-submit {
        display: inline-flex; align-items: center; gap: 0.6rem;
        padding: 0.75rem 1.5rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff; border: none; border-radius: 10px;
        font-family: inherit; font-size: 0.9rem; font-weight: 700;
        cursor: pointer; transition: all 0.2s ease;
    }
    .btn-submit:hover { transform: translateY(-2px); }

    /* Confirm Delete Modal */
    .modal-box {
        background: var(--surface); border-radius: 16px; padding: 2rem;
        width: 90%; max-width: 420px; text-align: center;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15);
        transform: scale(0.9); transition: transform 0.2s ease;
    }
    .modal-overlay.show .modal-box { transform: scale(1); }
    .modal-box .modal-icon {
        width: 60px; height: 60px; border-radius: 50%;
        background: #fef2f2; color: #ef4444;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem; margin: 0 auto 1.25rem;
    }
    .modal-box h3 { font-size: 1.2rem; font-weight: 800; color: var(--text); margin-bottom: 0.6rem; }
    .modal-box p { font-size: 0.88rem; color: var(--text-muted); line-height: 1.5; }
    .modal-actions { display: flex; gap: 0.75rem; margin-top: 1.75rem; }
    .modal-actions .btn-cancel {
        flex: 1; padding: 0.75rem; background: var(--bg); border: 1.5px solid var(--border);
        border-radius: 10px; font-weight: 700; color: var(--text-muted); cursor: pointer;
    }
    .modal-actions .btn-confirm {
        flex: 1; padding: 0.75rem; background: #ef4444; border: none;
        border-radius: 10px; font-weight: 700; color: #fff; cursor: pointer;
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1><i class="fas fa-user-shield" style="color:var(--primary);margin-right:.45rem"></i>Manajemen Petugas</h1>
        <p>Kelola data penjaga perpustakaan (staff operasional)</p>
    </div>
    <button type="button" class="btn-primary" onclick="openCreateModal()">
        <i class="fas fa-plus"></i> Tambah Petugas
    </button>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Petugas</th>
                    <th>Username</th>
                    <th>Terdaftar Sejak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($officers as $officer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="userpage-info">
                            <div style="font-weight: 700; color: var(--text);">{{ $officer->name }}</div>
                        </div>
                    </td>
                    <td>{{ $officer->username }}</td>
                    <td>{{ $officer->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display: flex; gap: .5rem;">
                            <button type="button" class="btn-action btn-edit" title="Edit" onclick="openEditModal('{{ $officer->id }}', '{{ addslashes($officer->name) }}', '{{ addslashes($officer->username) }}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn-action btn-delete" title="Hapus" onclick="confirmDelete('{{ route('kperpus.petugas.destroy', $officer->id) }}', '{{ addslashes($officer->name) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted)">Belum ada data petugas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Form Create/Edit Petugas -->
<div id="formModal" class="modal-overlay">
    <div class="form-modal-box">
        <div class="form-modal-header">
            <h3 id="formModalTitle"><i class="fas fa-user-plus" style="color:var(--primary);margin-right:.5rem;"></i> Tambah Petugas Baru</h3>
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
                    <div id="passwordHelp" style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.2rem; display: none;">
                        *Kosongkan jika tidak ingin mengubah password
                    </div>
                </div>

            </div>
            <div class="form-modal-footer">
                <button type="button" style="padding: .75rem 1.5rem; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; font-weight: 700; color: var(--text-muted); cursor: pointer;" onclick="closeFormModal()">Batal</button>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Petugas</button>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Hapus Petugas</h3>
        <p>Apakah Anda yakin ingin menghapus petugas <strong id="deleteTargetName"></strong>? Data yang dihapus tidak dapat dikembalikan.</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST" style="margin:0; flex:1; display:flex;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-confirm" style="width:100%;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const formModal = document.getElementById('formModal');
    const deleteModal = document.getElementById('deleteModal');
    const petugasForm = document.getElementById('petugasForm');
    const formMethod = document.getElementById('formMethod');
    const formTitle = document.getElementById('formModalTitle');
    
    function openCreateModal() {
        formTitle.innerHTML = '<i class="fas fa-user-plus" style="color:var(--primary);margin-right:.5rem;"></i> Tambah Petugas Baru';
        petugasForm.action = "{{ route('kperpus.petugas.store') }}";
        formMethod.value = "POST";
        
        document.getElementById('name').value = '';
        document.getElementById('username').value = '';
        document.getElementById('password').value = '';
        document.getElementById('password').required = true;
        document.getElementById('passwordReq').style.display = 'inline';
        document.getElementById('passwordHelp').style.display = 'none';
        
        formModal.classList.add('show');
    }

    function openEditModal(id, name, username) {
        formTitle.innerHTML = '<i class="fas fa-user-edit" style="color:var(--primary);margin-right:.5rem;"></i> Edit Petugas';
        petugasForm.action = `/kepala-perpustakaan/petugas/${id}`;
        formMethod.value = "PUT";
        
        document.getElementById('name').value = name;
        document.getElementById('username').value = username;
        document.getElementById('password').value = '';
        document.getElementById('password').required = false;
        document.getElementById('passwordReq').style.display = 'none';
        document.getElementById('passwordHelp').style.display = 'block';
        
        formModal.classList.add('show');
    }

    function closeFormModal() {
        formModal.classList.remove('show');
    }

    function confirmDelete(url, name) {
        document.getElementById('deleteTargetName').textContent = name;
        document.getElementById('deleteForm').action = url;
        deleteModal.classList.add('show');
    }

    function closeDeleteModal() {
        deleteModal.classList.remove('show');
    }

    window.onclick = function(event) {
        if (event.target == formModal) closeFormModal();
        if (event.target == deleteModal) closeDeleteModal();
    }
</script>
@endpush
@endsection
