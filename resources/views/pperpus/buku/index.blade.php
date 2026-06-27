@extends('pperpus.layouts.app')

@section('title', 'Cari Koleksi Buku')
@section('page-title', 'Pencarian Buku')

@push('styles')
<style>
    .search-wrapper {
        background: var(--surface);
        padding: 2rem;
        border-radius: 20px;
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
        border: 1px solid var(--border);
    }
    .search-grid {
        display: grid;
        grid-template-columns: 1fr 160px 160px 140px 120px;
        gap: 1rem;
    }
    @media (max-width: 900px) {
        .search-grid { grid-template-columns: 1fr; }
    }
    .form-group label {
        display: block; font-size: .75rem; font-weight: 700; color: var(--text-muted);
        text-transform: uppercase; margin-bottom: .5rem; letter-spacing: .5px;
    }
    .form-input {
        width: 100%; padding: .75rem 1rem; border: 1.5px solid var(--border);
        border-radius: 12px; font-family: inherit; font-size: .9rem; transition: all .2s;
    }
    .form-input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(20, 90, 50, 0.08); }

    .btn-search {
        background: var(--primary); color: #fff; border: none; border-radius: 12px;
        font-weight: 700; cursor: pointer; transition: all .2s;
        display: flex; align-items: center; justify-content: center; gap: .5rem;
    }
    .btn-search:hover { background: var(--primary-dark); transform: translateY(-2px); }

    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .book-card {
        background: var(--surface); border-radius: 20px; overflow: hidden;
        border: 1px solid var(--border); transition: all .3s ease;
        display: flex; flex-direction: column;
        cursor: pointer;
    }
    .book-card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.1); border-color: var(--primary); }
    
    .book-cover {
        height: 180px; background: #f8fafc; display: flex; align-items: center; justify-content: center;
        position: relative; overflow: hidden;
    }
    .book-cover img { width: 100%; height: 100%; object-fit: cover; }
    .book-cover .no-img { font-size: 3rem; color: #cbd5e1; }
    
    .book-badge {
        position: absolute; top: 1rem; right: 1rem;
        padding: .3rem .7rem; border-radius: 20px; font-size: .7rem; font-weight: 800;
        text-transform: uppercase; backdrop-filter: blur(4px);
    }
    .badge-bos { background: rgba(20, 90, 50, 0.9); color: #fff; }
    .badge-perpus { background: rgba(41, 128, 185, 0.9); color: #fff; }

    .book-info { padding: 1.2rem; flex: 1; display: flex; flex-direction: column; }
    .book-cat { font-size: .72rem; font-weight: 700; color: var(--primary); text-transform: uppercase; margin-bottom: .4rem; }
    .book-title { font-size: 1rem; font-weight: 800; color: var(--text); line-height: 1.4; margin-bottom: .5rem; }
    .book-author { font-size: .85rem; color: var(--text-muted); margin-bottom: 1rem; }
    
    .book-footer {
        padding: 1rem 1.2rem; background: #fcfdfe; border-top: 1px solid var(--border);
        display: flex; justify-content: space-between; align-items: center;
    }
    .stok-info { display: flex; flex-direction: column; }
    .stok-label { font-size: .65rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; }
    .stok-value { font-size: .95rem; font-weight: 800; color: var(--text); }
    .stok-low { color: var(--danger); }

    
    .modal-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.5);
        display: none; align-items: center; justify-content: center;
        z-index: 1000; backdrop-filter: blur(4px); padding: 1.5rem;
    }
    .modal-content {
        background: #fff; width: 100%; max-width: 800px;
        border-radius: 24px; overflow: hidden; position: relative;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        display: flex; flex-direction: column; max-height: 90vh;
    }
    .modal-header {
        padding: 1.5rem 2rem; border-bottom: 1px solid var(--border);
        display: flex; justify-content: space-between; align-items: center;
    }
    .modal-body { padding: 2rem; overflow-y: auto; }
    .modal-close {
        background: var(--surface-2); border: none; width: 36px; height: 36px;
        border-radius: 50%; cursor: pointer; color: var(--text-muted);
        display: flex; align-items: center; justify-content: center; transition: all .2s;
    }
    .modal-close:hover { background: var(--danger-bg); color: var(--danger); }

    .detail-grid { display: grid; grid-template-columns: 280px 1fr; gap: 2.5rem; }
    @media (max-width: 700px) {
        .detail-grid { grid-template-columns: 1fr; }
        .detail-cover { max-width: 200px; margin: 0 auto; }
    }
    .detail-cover {
        border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-md);
        aspect-ratio: 3/4; background: #f8fafc; display: flex; align-items: center; justify-content: center;
    }
    .detail-cover img { width: 100%; height: 100%; object-fit: cover; }
    .detail-cover i { font-size: 5rem; color: #e2e8f0; }

    .detail-info h2 { font-size: 1.8rem; font-weight: 800; color: var(--text); line-height: 1.2; margin-bottom: .5rem; }
    .detail-author { font-size: 1.1rem; color: var(--primary); font-weight: 600; margin-bottom: 2rem; }
    
    .detail-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }
    .meta-item { display: flex; flex-direction: column; gap: .3rem; }
    .meta-label { font-size: .7rem; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: .5px; }
    .meta-value { font-size: .95rem; font-weight: 700; color: var(--text); }
    
    .detail-badge {
        display: inline-block; padding: .5rem 1rem; border-radius: 12px;
        font-size: .75rem; font-weight: 800; text-transform: uppercase; margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')

<div class="search-wrapper">
    <form action="{{ route('pperpus.buku.index') }}" method="GET" class="search-grid">
        <div class="form-group">
            <label>Cari Judul / Pengarang / Kode</label>
            <input type="text" name="q" class="form-input" placeholder="Masukkan kata kunci..." value="{{ request('q') }}">
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori" class="form-input">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id_kategori }}" {{ request('kategori') == $cat->id_kategori ? 'selected' : '' }}>
                        {{ $cat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Sumber Buku</label>
            <select name="sumber" class="form-input">
                <option value="">Semua Sumber</option>
                <option value="buku perpus" {{ request('sumber') == 'buku perpus' ? 'selected' : '' }}>Buku Perpus</option>
                <option value="bos" {{ request('sumber') == 'bos' ? 'selected' : '' }}>Buku BOS</option>
            </select>
        </div>
        <div class="form-group">
            <label>Rak</label>
            <select name="rak" class="form-input">
                <option value="">Semua Rak</option>
                @if(isset($raks))
                    @foreach($raks as $r)
                        <option value="{{ $r }}" {{ request('rak') == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="form-group" style="display: flex; align-items: flex-end;">
            <button type="submit" class="btn-search" style="width: 100%; height: 42px;">
                <i class="fas fa-search"></i> Cari
            </button>
        </div>
    </form>
</div>

@if($buku->isEmpty())
    <div style="text-align: center; padding: 5rem 2rem; background: #fff; border-radius: 20px; border: 1px solid var(--border);">
        <div style="font-size: 4rem; color: #e2e8f0; margin-bottom: 1.5rem;"><i class="fas fa-book-open"></i></div>
        <h3 style="font-weight: 800; color: var(--text);">Buku Tidak Ditemukan</h3>
        <p style="color: var(--text-muted); margin-top: .5rem;">Coba gunakan kata kunci lain atau filter yang berbeda.</p>
        <a href="{{ route('pperpus.buku.index') }}" style="display: inline-block; margin-top: 1.5rem; color: var(--primary); font-weight: 700; text-decoration: none;">
            <i class="fas fa-sync-alt"></i> Reset Pencarian
        </a>
    </div>
@else
    <div class="books-grid">
        @foreach($buku as $b)
        
        <div class="book-card" 
             data-book="{{ json_encode($b) }}" 
             data-kategori="{{ $b->kategoriBuku->nama_kategori ?? ($b->kelas ? 'Kelas '.$b->kelas : 'Umum') }}"
             onclick="showDetail(this)">
            
            <div class="book-cover">
                @if($b->gambar)
                    <img src="{{ asset('storage/'.$b->gambar) }}" alt="{{ $b->judul_buku }}">
                @else
                    <div class="no-img"><i class="fas fa-book"></i></div>
                @endif
                <span class="book-badge {{ $b->sumber_buku == 'bos' ? 'badge-bos' : 'badge-perpus' }}">
                    {{ $b->sumber_buku == 'bos' ? 'BOS' : 'PERPUS' }}
                </span>
            </div>
            <div class="book-info">
                <div class="book-cat">{{ $b->kategoriBuku->nama_kategori ?? ($b->kelas ? 'Kelas '.$b->kelas : 'Umum') }}</div>
                <div class="book-title">{{ $b->judul_buku }}</div>
                <div class="book-author">oleh {{ $b->pengarang }}</div>
                <div style="margin-top: auto; font-family: monospace; font-size: .75rem; color: var(--primary); font-weight: 700;">
                    {{ $b->kode_buku }}
                </div>
            </div>
            <div class="book-footer">
                <div class="stok-info">
                    <span class="stok-label">Tersedia</span>
                    <span class="stok-value {{ $b->stok <= 2 ? 'stok-low' : '' }}">{{ $b->stok }} Eks.</span>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: .75rem; font-weight: 800; color: var(--primary);">Rak: {{ $b->rak ?? '-' }}</div>
                    <div style="font-size: .8rem; font-weight: 700; color: var(--text-muted);">{{ $b->tahun_terbit }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    
    @if($buku->hasPages())
    <div class="pagination-wrap" style="margin-top: 2rem; border-radius: 20px; overflow: hidden; border: 1px solid var(--border);">
        <span class="info">
            Menampilkan {{ $buku->firstItem() }}–{{ $buku->lastItem() }} dari {{ $buku->total() }} data
        </span>
        {{ $buku->links('pagination::bootstrap-4') }}
    </div>
    @endif
@endif

<div id="bookModal" class="modal-overlay" onclick="closeModal()">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3 style="font-weight: 800; color: var(--text);">Detail Informasi Buku</h3>
            <button class="modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="detail-grid">
                <div class="detail-cover" id="modalCover">
                    </div>
                <div class="detail-info">
                    <div id="modalBadge" class="detail-badge"></div>
                    <h2 id="modalTitle"></h2>
                    <div class="detail-author" id="modalAuthor"></div>
                    
                    <div class="detail-meta">
                        <div class="meta-item">
                            <span class="meta-label">Kode Buku</span>
                            <span class="meta-value" id="modalKode"></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">ISBN</span>
                            <span class="meta-value" id="modalISBN"></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Kategori</span>
                            <span class="meta-value" id="modalKategori"></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Tahun Terbit</span>
                            <span class="meta-value" id="modalTahun"></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Stok Tersedia</span>
                            <span class="meta-value" id="modalStok"></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Sumber Buku</span>
                            <span class="meta-value" id="modalSumber" style="text-transform: uppercase;"></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Rak</span>
                            <span class="meta-value" id="modalRak"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function showDetail(element) {

        const buku = JSON.parse(element.getAttribute('data-book'));
        const kategoriName = element.getAttribute('data-kategori');
        
        const modal = document.getElementById('bookModal');
        const cover = document.getElementById('modalCover');
        const badge = document.getElementById('modalBadge');

        if(buku.gambar) {
            cover.innerHTML = `<img src="{{ asset('storage') }}/${buku.gambar}" alt="${buku.judul_buku}">`;
        } else {
            cover.innerHTML = `<i class="fas fa-book"></i>`;
        }

        badge.innerText = buku.sumber_buku === 'bos' ? 'Buku BOS' : 'Buku Perpustakaan';
        badge.className = 'detail-badge ' + (buku.sumber_buku === 'bos' ? 'badge-bos' : 'badge-perpus');

        document.getElementById('modalTitle').innerText = buku.judul_buku;
        document.getElementById('modalAuthor').innerText = 'oleh ' + (buku.pengarang ?? '-');
        document.getElementById('modalKode').innerText = buku.kode_buku ?? '-';
        document.getElementById('modalISBN').innerText = buku.isbn || '-';
        document.getElementById('modalKategori').innerText = kategoriName;
        document.getElementById('modalTahun').innerText = buku.tahun_terbit ?? '-';
        document.getElementById('modalStok').innerText = (buku.stok ?? 0) + ' Eksemplar';
        document.getElementById('modalSumber').innerText = buku.sumber_buku ?? '-';
        document.getElementById('modalRak').innerText = buku.rak ?? '-';

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('bookModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
</script>
@endpush
