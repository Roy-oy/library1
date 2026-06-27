@extends('kperpus.layouts.app')

@section('title', 'Buku')
@section('page-title', 'Manajemen Buku BOS dan Perpustakaan')

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

    
    .book-cover-container {
        position: relative;
        width: 44px;
        height: 60px;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(15, 23, 42, 0.08);
        transition: transform var(--transition-speed) ease;
        margin: 0 auto;
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
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .book-cover-placeholder i {
        color: rgba(255, 255, 255, 0.85);
        font-size: 1rem;
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
    }
</style>
@endpush

@section('content')


<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas {{ $type === 'bos' ? 'fa-graduation-cap' : 'fa-book' }}" style="color:var(--primary)"></i> {{ $pageTitle }}</h1>
        <p>Kelola koleksi {{ strtolower($pageTitle) }} perpustakaan sekolah</p>
    </div>
    <a href="{{ route('kperpus.buku.create', ['sumber_buku' => $type === 'bos' ? 'bos' : 'buku perpus']) }}" class="btn-primary" id="btn-tambah-buku">
        <i class="fas fa-plus"></i> Tambah Buku Baru
    </a>
</div>


<nav class="tab-nav">
    <a href="{{ route('kperpus.buku.index', ['type' => 'perpus']) }}" class="tab-item {{ $type !== 'bos' ? 'active' : '' }}">
        <i class="fas fa-book-open"></i> Buku Perpus
    </a>
    <a href="{{ route('kperpus.buku.index', ['type' => 'bos']) }}" class="tab-item {{ $type === 'bos' ? 'active' : '' }}">
        <i class="fas fa-graduation-cap"></i> Buku BOS
    </a>
</nav>


<div class="card">
    <div class="card-toolbar" style="display: flex; flex-direction: column; gap: 1rem; align-items: flex-start; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <span class="total-label">Daftar koleksi: <strong>{{ $buku->total() }} buku</strong></span>
        </div>
        
        <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; width: 100%; padding-top: 1rem; border-top: 1.5px dashed var(--border);">
            <form action="{{ route('kperpus.buku.index') }}" method="GET" style="display: flex; gap: 1rem; margin: 0; flex-wrap: wrap; flex: 1; align-items: flex-end;">
                <input type="hidden" name="type" value="{{ $type }}">
                
                <div style="flex: 1; min-width: 220px;">
                    <label style="font-size: 0.82rem; font-weight: 800; color: var(--text-muted); margin-bottom: 0.4rem; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Filter {{ $type === 'bos' ? 'Kelas' : 'Kategori' }}</label>
                    @if($type === 'bos')
                        <select name="kelas" class="form-control" onchange="this.form.submit()" style="padding: 0.75rem 1.2rem; border-radius: 10px; border: 1.5px solid var(--border); outline: none; background: #fff; font-weight: 600; width: 100%;">
                            <option value="">— Semua Kelas —</option>
                            @foreach(['VII', 'VIII', 'IX'] as $kls)
                                <option value="{{ $kls }}" {{ request('kelas') == $kls ? 'selected' : '' }}>Kelas {{ $kls }}</option>
                            @endforeach
                        </select>
                    @else
                        <select name="kategori" class="form-control" onchange="this.form.submit()" style="padding: 0.75rem 1.2rem; border-radius: 10px; border: 1.5px solid var(--border); outline: none; background: #fff; font-weight: 600; width: 100%;">
                            <option value="">— Semua Kategori —</option>
                            @foreach($kategori_list as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <div style="flex: 2; min-width: 280px;">
                    <label style="font-size: 0.82rem; font-weight: 800; color: var(--text-muted); margin-bottom: 0.4rem; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Pencarian Buku</label>
                    <div class="search-box" style="width: 100%; border: 1.5px solid var(--border); border-radius: 10px; padding: 0.75rem 1.2rem; background: #fff; display: flex; align-items: center; gap: 0.8rem;">
                        <i class="fas fa-search" style="color: var(--theme-primary); font-size: 1.1rem;"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, kode, atau pengarang…" style="border: none; background: transparent; outline: none; width: 100%; font-size: 0.95rem; font-weight: 600;">
                    </div>
                </div>
                
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 10px; height: 48px; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; cursor: pointer; border: none;">
                        <i class="fas fa-filter"></i> Cari
                    </button>
                    @if(request('kelas') || request('kategori') || request('search'))
                        <a href="{{ route('kperpus.buku.index', ['type' => $type]) }}" class="btn-reset" style="padding: 0.75rem 1.5rem; background: var(--theme-danger-light); color: var(--theme-danger); border: 1.5px solid rgba(239, 68, 68, 0.2); border-radius: 10px; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem; height: 48px;">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="table-wrap">
        <table class="kperpus-table">
            <thead>
                <tr>
                    <th style="width: 60px; text-align: center;">No</th>
                    <th style="width: 80px; text-align: center;">Cover</th>
                    <th style="width: 140px; text-align: left; padding-left: 1.5rem;">Kode Buku</th>
                    <th style="text-align: left;">Judul Buku</th>
                    <th style="width: 200px; text-align: left;">Pengarang</th>
                    <th style="width: 100px; text-align: center;">Tahun</th>
                    <th style="width: 150px; text-align: center;">ISBN</th>
                    <th style="width: 110px; text-align: center;">Stok</th>
                    <th style="width: 100px; text-align: center;">Rak</th>
                    @if($type !== 'bos')
                        <th style="width: 160px; text-align: left;">Kategori</th>
                    @else
                        <th style="width: 110px; text-align: center;">Kelas</th>
                    @endif
                    <th style="width: 120px; text-align: center;">Status</th>
                    <th style="width: 110px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $index => $item)
                <tr>
                    <td style="text-align: center; font-weight: 700; color: var(--text-muted);">{{ $buku->firstItem() + $index }}</td>
                    <td>
                        <div class="book-cover-container">
                            @if($item->gambar)
                                <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul_buku }}" class="book-cover">
                            @else
                                <div class="book-cover-placeholder">
                                    <i class="fas fa-book"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td style="text-align: left; padding-left: 1.5rem;">
                        <span class="code-badge">{{ $item->kode_buku }}</span>
                    </td>
                    <td style="font-weight: 700; color: #1e293b; max-width: 280px; line-height: 1.4;">{{ $item->judul_buku }}</td>
                    <td style="font-weight: 600; color: #4a5568;">{{ $item->pengarang }}</td>
                    <td style="text-align: center; font-weight: 700; color: #4a5568;">{{ $item->tahun_terbit }}</td>
                    <td style="color: #64748b; text-align: center; font-family: monospace; font-size: 0.85rem;">{{ $item->isbn ?? '—' }}</td>
                    <td style="text-align: center;">
                        <span class="pill {{ $item->stok > 0 ? 'pill-success' : 'pill-warning' }}">
                            {{ $item->stok }} Eks
                        </span>
                    </td>
                    <td style="text-align: center; font-weight: 700; color: #1e3a8a;">
                        {{ $item->rak ?? '—' }}
                    </td>
                    @if($type !== 'bos')
                        @php
                            $catColors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'];
                            $catColor = $item->id_kategori ? $catColors[$item->id_kategori % count($catColors)] : '#64748b';
                        @endphp
                        <td>
                            @if($item->kategoriBuku)
                                <span style="display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.3rem 0.75rem; border-radius: 6px; font-size: 0.78rem; font-weight: 700; color: {{ $catColor }}; background: {{ $catColor }}12; border: 1px solid {{ $catColor }}30;">
                                    <i class="fas fa-tag" style="font-size: 0.65rem;"></i>
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
                            <span class="pill pill-success"><i class="fas fa-circle" style="font-size: 0.4rem;"></i> Tersedia</span>
                        @else
                            <span class="pill pill-warning"><i class="fas fa-circle" style="font-size: 0.4rem;"></i> Dipinjam</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('kperpus.buku.edit', $item->id_buku) }}" class="btn-icon btn-edit" title="Edit Buku">
                                <i class="fas fa-pen"></i>
                            </a>
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
                        <div style="padding: 4rem 2rem; text-align: center; color: var(--text-muted);">
                            <i class="fas fa-book-open" style="font-size: 3rem; color: var(--primary); opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                            <p style="font-weight: 600; font-size: 0.95rem;">Belum ada data koleksi buku.</p>
                            <span style="font-size: 0.82rem;">Klik tombol tambah di atas untuk memasukkan buku baru.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
    @if($buku->hasPages())
    <div class="pagination-wrap">
        <span class="info">
            Menampilkan {{ $buku->firstItem() }}–{{ $buku->lastItem() }} dari {{ $buku->total() }} data
        </span>
        {{ $buku->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>


<div class="modal-overlay" id="delete-modal">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-exclamation-triangle"></i></div>
        <h3>Hapus Koleksi Buku?</h3>
        <p id="delete-modal-msg">Tindakan ini tidak dapat dibatalkan.</p>
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

@push('scripts')
<script>
    function confirmDelete(url, title) {
        document.getElementById('delete-form').action = url;
        document.getElementById('delete-modal-msg').innerHTML = `Apakah Anda yakin ingin menghapus buku <br><strong style="color:var(--text)">"${title}"</strong>?<br>Data sirkulasi terkait juga akan terpengaruh.`;
        document.getElementById('delete-modal').classList.add('show');
    }
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.remove('show');
    }
</script>
@endpush