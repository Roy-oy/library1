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

    /* ── Card Container ── */
    .card {
        background: var(--surface);
        border-radius: var(--card-radius);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    /* ── INTEGRATED TOOLBAR (Filter & Search Menjadi Satu) ── */
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

    /* Mini Class Filter di dalam Toolbar */
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

    /* Search Box */
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

    /* ── MODERN TABLE DESIGN ── */
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
        text-align: left;
    }
    table.siswa-table tbody td {
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
        text-align: left;
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

    .student-name {
        font-weight: 600;
        color: #1e293b;
    }

    .address-col {
        max-width: 280px;
        color: #64748b;
        line-height: 1.5;
        font-size: 0.85rem;
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
    .pill-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    .pill-accent { background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; }

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

    /* Action Buttons */
    .actions { display: flex; gap: 0.35rem; }
    .btn-icon {
        width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;
        border-radius: 8px; border: 1px solid transparent; cursor: pointer; font-size: 0.85rem;
        transition: all var(--transition-speed) ease; background: #fff;
    }
    .btn-edit { border-color: #cbd5e1; color: #475569; }
    .btn-edit:hover { background: #f1f5f9; color: #1e293b; border-color: #94a3b8; }
    .btn-del { border-color: #fee2e2; color: #ef4444; background: #fff5f5; }
    .btn-del:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

    .empty-state {
        padding: 4rem 2rem; text-align: center; color: var(--text-muted);
    }
    .empty-state i { font-size: 2.5rem; color: #cbd5e1; margin-bottom: 1rem; display: block; }
    .empty-state p { font-size: 0.9rem; font-weight: 600; color: #64748b; }

    /* Modal styles */
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

    @media (max-width: 992px) {
        .toolbar-upper { flex-direction: column; align-items: stretch; }
        .search-box { width: 100%; }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas fa-users" style="color:var(--primary)"></i> Data Siswa</h1>
        <p>Kelola profil data siswa dan status keanggotaan perpustakaan langsung dalam satu tabel terpadu</p>
    </div>
    <button type="button" class="btn-primary" id="btn-tambah-siswa" onclick="openCreateModal()">
        <i class="fas fa-user-plus"></i> Tambah Siswa Baru
    </button>
</div>

{{-- Main Terpadu Card --}}
<div class="card">
    
    {{-- TOOLBAR GABUNGAN: Filter Kelas + Search Box + Counter Ada di Sini --}}
    <div class="card-toolbar-integrated">
        <div class="toolbar-upper">
            {{-- Bagian Kiri: Filter Kapsul Kelas --}}
            <div class="filter-inline-group">
                <button type="button" class="btn-filter-pill active" onclick="filterClass('all', this)">
                    Semua Kelas ({{ $siswa->count() }})
                </button>
                @foreach(['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'] as $kls)
                    <button type="button" class="btn-filter-pill" onclick="filterClass('{{ $kls }}', this)">
                        {{ $kls }} ({{ $siswa->where('kelas', $kls)->count() }})
                    </button>
                @endforeach
            </div>

            {{-- Bagian Kanan: Search Input Kontrol --}}
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="search-input" placeholder="Cari NIS atau Nama siswa…">
            </div>
        </div>
        
        {{-- Status Filter Saat ini --}}
        <div class="total-label">
            Menampilkan: <strong id="filter-counter">{{ $siswa->count() }} siswa</strong>
        </div>
    </div>

    {{-- Tabel Data Utama Tunggal --}}
    <div class="table-wrap">
        <table class="siswa-table" id="siswa-table-main">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="width: 120px;">NIS</th>
                    <th>Nama Lengkap</th>
                    <th style="width: 110px;">Kelas</th>
                    <th style="width: 120px;">L/P</th>
                    <th>Alamat Lengkap</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswa as $index => $item)
                <tr class="siswa-row" data-kelas="{{ $item->kelas }}">
                    <td class="row-number" style="color: #94a3b8; font-weight: 500;">{{ $index + 1 }}</td>
                    <td><span class="nis-code">{{ $item->nis }}</span></td>
                    <td><span class="student-name">{{ $item->nama_siswa }}</span></td>
                    <td><span class="kelas-badge">{{ $item->kelas }}</span></td>
                    <td>
                        <span class="gender-badge">
                            {{ $item->jenis_kelamin === 'Laki-laki' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </td>
                    <td><div class="address-col">{{ $item->alamat }}</div></td>
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
                <tr id="empty-state-row">
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-users-slash"></i>
                            <p>Belum ada data siswa dalam database keanggotaan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse

                {{-- Baris Not Found ketika pencarian kosong --}}
                <tr id="js-empty-state-row" style="display: none;">
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-search-minus"></i>
                            <p>Tidak ditemukan siswa yang cocok dengan filter atau pencarian tersebut.</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
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

@include('kperpus.siswa.create')
@include('kperpus.siswa.edit')

@endsection

@push('scripts')
<script>
    let activeClassFilter = 'all';

    function filterClass(className, element) {
        activeClassFilter = className;
        
        // Aktifkan style tombol kapsul filter yang diklik
        document.querySelectorAll('.btn-filter-pill').forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');

        // Jalankan sinkronisasi pencarian & filter
        executeCombinedFilter();
    }

    // Input Event Listener untuk Search Box
    document.getElementById('search-input').addEventListener('input', function () {
        executeCombinedFilter();
    });

    function executeCombinedFilter() {
        const keyword = document.getElementById('search-input').value.toLowerCase();
        const rows = document.querySelectorAll('#siswa-table-main tbody .siswa-row');
        let displayedCounter = 0;

        rows.forEach(row => {
            const currentKelas = row.getAttribute('data-kelas');
            const rowContent = row.textContent.toLowerCase();

            // Aturan filter gabungan (Tombol kelas DAN kata kunci pencarian)
            const isClassMatched = (activeClassFilter === 'all' || currentKelas === activeClassFilter);
            const isKeywordMatched = rowContent.includes(keyword);

            if (isClassMatched && isKeywordMatched) {
                row.style.display = '';
                displayedCounter++;
                // Mengurutkan ulang No tabel secara dinamis (1, 2, 3...)
                row.querySelector('.row-number').textContent = displayedCounter;
            } else {
                row.style.display = 'none';
            }
        });

        // Handle visibility dari state kosong (jika filter tidak menemukan hasil apapun)
        const jsEmptyRow = document.getElementById('js-empty-state-row');
        if (jsEmptyRow) {
            jsEmptyRow.style.display = (displayedCounter === 0 && rows.length > 0) ? '' : 'none';
        }

        // Update counter angka siswa terfilter di toolbar
        document.getElementById('filter-counter').textContent = displayedCounter + " siswa";
    }

    // Modal Control Logic
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