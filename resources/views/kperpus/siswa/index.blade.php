@extends('kperpus.layouts.app')

@section('title', 'Siswa')
@section('page-title', 'Manajemen Data Siswa')

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
        --transition-speed: 0.2s;
    }

    
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
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
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    
    .card-toolbar-integrated {
        background: #fafbfc;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .toolbar-upper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .toolbar-upper .total-label {
        font-size: 0.88rem;
        color: var(--text-muted);
    }
    .toolbar-upper .total-label strong {
        color: var(--primary);
        font-size: 1rem;
        font-weight: 800;
    }

    
    .filter-inline-group {
        display: flex;
        gap: 0.35rem;
        overflow-x: auto;
        padding-bottom: 2px;
    }
    .btn-filter-pill {
        padding: 0.45rem 0.9rem;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--text-muted);
        cursor: pointer;
        transition: all var(--transition-speed) ease;
        white-space: nowrap;
    }
    .btn-filter-pill:hover {
        background: var(--theme-primary-light);
        color: var(--primary);
        border-color: var(--primary);
    }
    .btn-filter-pill.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    
    .search-box {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        background: #fff;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 0.5rem 1rem;
        transition: all var(--transition-speed) ease;
        width: 300px;
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
        width: 100%;
    }

    .address-col {
        max-width: 280px;
        color: var(--text-muted);
        line-height: 1.5;
        font-size: 0.88rem;
    }

    .kelas-badge {
        display: inline-block;
        background: var(--theme-warning-light);
        color: #b45309;
        font-size: 0.8rem;
        font-weight: 800;
        padding: 0.3rem 0.7rem;
        border-radius: 8px;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .gender-badge {
        display: inline-flex;
        align-items: center;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-muted);
    }
    


    
    .modal-overlay {
        display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(4px); z-index: 200; align-items: center; justify-content: center;
        opacity: 0; transition: opacity var(--transition-speed) ease;
    }
    .modal-overlay.show { display: flex; opacity: 1; }
    .modal-box {
        background: var(--surface); border-radius: var(--card-radius); padding: 0;
        width: 90%; max-width: 650px; box-shadow: 0 20px 50px rgba(15, 23, 42, 0.15);
        transform: scale(0.9); transition: transform var(--transition-speed) ease; overflow: hidden;
    }
    .modal-overlay.show .modal-box { transform: scale(1); }
    .form-card { background: transparent; border: none; }
    .form-card-header {
        padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 1rem; background: #fafbfc;
    }
    .form-card-header .hdr-icon {
        width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, var(--theme-primary), #1d4ed8);
        display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.1rem; flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }
    .form-card-header h2 { font-size: 1.1rem; font-weight: 800; color: var(--text); }
    .form-card-header p { font-size: 0.85rem; color: var(--text-muted); margin-top: 0.15rem; }
    .form-body { padding: 1.8rem; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
    .form-group { display: flex; flex-direction: column; gap: 0.45rem; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label { font-size: 0.82rem; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 0.3rem; }
    .form-group label .req { color: var(--danger); }
    .form-control-wrap { position: relative; display: flex; align-items: center; }
    .form-control-wrap i.input-icon { position: absolute; left: 1rem; color: var(--text-muted); font-size: 0.9rem; pointer-events: none; }
    .form-control {
        width: 100%; padding: 0.75rem 1rem; border: 1.5px solid var(--border); border-radius: 10px;
        font-family: inherit; font-size: 0.9rem; color: var(--text); background: #fff; transition: all var(--transition-speed) ease; outline: none;
    }
    .form-control-wrap i.input-icon + .form-control { padding-left: 2.5rem; }
    .form-control:focus { border-color: var(--theme-primary); box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15); }
    .form-control.is-invalid { border-color: var(--theme-danger); }
    .invalid-feedback { font-size: 0.78rem; color: var(--theme-danger); display: flex; align-items: center; gap: 0.3rem; margin-top: 0.2rem; font-weight: 700; }
    .form-actions { display: flex; align-items: center; justify-content: flex-end; gap: 0.8rem; padding: 1.25rem 1.8rem; border-top: 1px solid var(--border); background: #fafbfc; }
    .btn-submit {
        display: inline-flex; align-items: center; gap: 0.6rem; padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--theme-primary), #1d4ed8); color: #fff; border: none; border-radius: 10px;
        font-family: inherit; font-size: 0.9rem; font-weight: 700; cursor: pointer; transition: all var(--transition-speed) ease; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    .btn-submit:hover { transform: translateY(-2px); }
    .btn-cancel-modal {
        display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.2rem; background: var(--bg); color: var(--text-muted);
        border: 1.5px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.9rem; font-weight: 700; cursor: pointer; transition: all var(--transition-speed) ease;
    }
    .btn-cancel-modal:hover { background: #e2e8f0; color: var(--text); }

    
    .modal-box-del { max-width: 420px; padding: 2rem; }
    .modal-box-del .modal-icon {
        width: 60px; height: 60px; border-radius: 50%; background: var(--theme-danger-light); color: var(--theme-danger);
        display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin: 0 auto 1.25rem; box-shadow: inset 0 0 0 1px rgba(239, 68, 68, 0.1);
    }
    .modal-box-del h3 { font-size: 1.2rem; font-weight: 800; text-align: center; color: var(--text); }
    .modal-box-del p { font-size: 0.88rem; color: var(--text-muted); text-align: center; margin-top: 0.6rem; line-height: 1.5; }
    .modal-box-del .modal-actions { display: flex; gap: 0.75rem; margin-top: 1.75rem; padding: 0; background: transparent; border: none; justify-content: center; }
    .modal-box-del .modal-actions .btn-cancel {
        flex: 1; padding: 0.75rem; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.88rem; font-weight: 700; color: var(--text-muted); cursor: pointer; transition: all var(--transition-speed) ease;
    }
    .modal-box-del .modal-actions .btn-cancel:hover { background: #e2e8f0; color: var(--text); }
    .modal-box-del .modal-actions .btn-confirm {
        flex: 1; padding: 0.75rem; background: var(--theme-danger); border: none; border-radius: 10px; font-family: inherit; font-size: 0.88rem; font-weight: 700; color: #fff; cursor: pointer; transition: background var(--transition-speed) ease; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }
    .modal-box-del .modal-actions .btn-confirm:hover { background: #dc2626; }
    
    @media (max-width: 600px) {
        .form-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 992px) {
        .toolbar-upper { flex-direction: column; align-items: stretch; }
        .search-box { width: 100%; }
    }
</style>
@endpush

@section('content')


<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas fa-users" style="color:var(--primary)"></i> Data Siswa</h1>
        <p>Kelola profil data siswa dan status keanggotaan perpustakaan langsung dalam satu tabel terpadu</p>
    </div>
    <button type="button" class="btn-primary" id="btn-tambah-siswa" onclick="openCreateModal()">
        <i class="fas fa-user-plus"></i> Tambah Siswa Baru
    </button>
</div>


<div class="card">
    
    
    <div class="card-toolbar-integrated">
        <div class="toolbar-upper">
            
            <div class="filter-inline-group">
                <a href="{{ route('kperpus.siswa.index', ['kelas' => 'all', 'search' => request('search')]) }}" class="btn-filter-pill {{ $kelas === 'all' ? 'active' : '' }}" style="text-decoration: none;">
                    Semua
                </a>
                @foreach(['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'] as $kls)
                    <a href="{{ route('kperpus.siswa.index', ['kelas' => $kls, 'search' => request('search')]) }}" class="btn-filter-pill {{ $kelas === $kls ? 'active' : '' }}" style="text-decoration: none;">
                        Kelas {{ $kls }}
                    </a>
                @endforeach
            </div>

            
            <form action="{{ route('kperpus.siswa.index') }}" method="GET" class="search-box">
                <input type="hidden" name="kelas" value="{{ $kelas }}">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIS atau Nama siswa…">
            </form>
        </div>
        
        
        <div class="total-label" style="display: flex; justify-content: space-between; align-items: center;">
            <span>Total data {{ $kelas === 'all' ? 'seluruh siswa' : 'pada kelas ' . $kelas }}: <strong>{{ $siswa->total() }} siswa</strong></span>
            @if(request('search'))
                <a href="{{ route('kperpus.siswa.index', ['kelas' => $kelas]) }}" class="btn-cancel-modal" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; text-decoration: none;"><i class="fas fa-times"></i> Reset Pencarian</a>
            @endif
        </div>
    </div>

    
    <div class="table-wrap">
        <table class="kperpus-table" id="siswa-table-main">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th style="width: 120px; text-align: left;">NIS</th>
                    <th style="text-align: left;">Nama Lengkap</th>
                    <th style="width: 110px; text-align: center;">Kelas</th>
                    <th style="width: 120px; text-align: center;">L/P</th>
                    <th style="text-align: left;">Alamat Lengkap</th>
                    <th style="width: 120px; text-align: center;">Status</th>
                    <th style="width: 100px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswa as $index => $item)
                <tr>
                    <td style="color: #94a3b8; font-weight: 500; text-align: center;">{{ $siswa->firstItem() + $index }}</td>
                    <td style="text-align: left;"><span class="code-badge">{{ $item->nis }}</span></td>
                    <td style="text-align: left;"><span style="font-weight: 700; color: var(--text); font-size: 0.95rem;">{{ $item->nama_siswa }}</span></td>
                    <td style="text-align: center;"><span class="kelas-badge">{{ $item->kelas }}</span></td>
                    <td style="text-align: center;">
                        <span class="gender-badge">
                            {{ $item->jenis_kelamin === 'Laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </td>
                    <td style="text-align: left;"><div class="address-col">{{ $item->alamat }}</div></td>
                    <td style="text-align: center;">
                        @if($item->status === 'aktif')
                            <span class="pill pill-success">Aktif</span>
                        @else
                            <span class="pill pill-accent">Nonaktif</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
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
                <tr id="empty-state-row">
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-users-slash"></i>
                            <p>Belum ada data siswa dalam database keanggotaan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
    @if($siswa->hasPages())
    <div class="pagination-wrap">
        <span class="info">
            Menampilkan {{ $siswa->firstItem() }}–{{ $siswa->lastItem() }} dari {{ $siswa->total() }} data
        </span>
        {{ $siswa->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>


<div class="modal-overlay" id="delete-modal">
    <div class="modal-box modal-box-del">
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

@include('kperpus.siswa.create')
@include('kperpus.siswa.edit')

@endsection

@push('scripts')
<script>

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

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {


            openCreateModal();
        });
    @endif
</script>
@endpush