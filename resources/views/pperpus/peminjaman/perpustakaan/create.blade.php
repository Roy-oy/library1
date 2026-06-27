@extends('pperpus.layouts.app')

@section('title', 'Catat Peminjaman Buku Perpustakaan')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    
    .select2-container .select2-selection--single {
        height: 42px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--text);
        font-size: .9rem;
        line-height: normal;
        padding-left: 1rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        right: 10px;
    }
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.15);
    }

    .container-peminjaman {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    
    .page-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .page-header a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--surface);
        border: 1px solid var(--border);
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .page-header a:hover {
        color: var(--primary);
        border-color: var(--primary);
        transform: translateX(-2px);
    }
    .page-header h1 { 
        font-size: 1.5rem; 
        font-weight: 800; 
        color: var(--text); 
        margin: 0;
    }

    
    .card {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        background: linear-gradient(to right, #ffffff, #f8fafc);
    }
    .card-header-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .card-header h2 { 
        font-size: 1.1rem; 
        font-weight: 700; 
        margin: 0; 
        color: var(--text);
    }
    .card-body { 
        padding: 1.75rem; 
    }

    
    .form-row { 
        display: flex; 
        gap: 1.25rem; 
        flex-wrap: wrap;
        margin-bottom: 0.5rem;
    }
    .form-group { 
        flex: 1;
        min-width: 200px;
        margin-bottom: 1.25rem; 
    }
    .form-group.flex-sm { flex: 0.8; }
    .form-group.flex-lg { flex: 2; }
    
    .form-group label { 
        display: block; 
        font-size: .85rem; 
        font-weight: 700; 
        margin-bottom: .5rem; 
        color: var(--text);
    }
    .form-control {
        width: 100%; 
        padding: .75rem 1rem; 
        border: 1.5px solid var(--border);
        border-radius: 8px; 
        font-family: inherit; 
        font-size: .9rem; 
        outline: none;
        color: var(--text);
        background-color: #fff;
        transition: all 0.2s ease;
    }
    .form-control:focus { 
        border-color: var(--primary); 
        box-shadow: 0 0 0 4px rgba(155, 89, 182, 0.15); 
    }
    .form-control:disabled {
        background-color: #f1f5f9 !important;
        color: var(--text-muted);
        cursor: not-allowed;
    }
    .form-control.code-peminjaman {
        background: #fdf4ff !important; 
        font-weight: 800; 
        color: var(--primary); 
        border: 1.5px dashed var(--primary);
    }
    .required-star {
        color: var(--danger);
    }

    
    .section-divider {
        border: 0; 
        border-top: 1px solid var(--border); 
        margin: 2rem 0;
    }

    
    .books-selection-header {
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }
    .books-selection-title {
        font-size: .95rem; 
        font-weight: 800; 
        color: var(--text);
        margin: 0;
    }
    .books-selection-subtitle {
        font-size: .8rem; 
        color: var(--text-muted); 
        margin-top: .25rem;
    }
    .counter-badge {
        font-size: .85rem; 
        font-weight: 800; 
        color: var(--primary); 
        background: #f0fdfa; 
        padding: .5rem 1rem; 
        border-radius: 30px;
        border: 1px solid rgba(13, 148, 136, 0.1);
    }

    
    .accordion-item { 
        border: 1px solid var(--border); 
        border-radius: 10px; 
        margin-bottom: .75rem; 
        overflow: hidden; 
        background: var(--surface);
        transition: box-shadow 0.2s ease;
    }
    .accordion-item:hover {
        box-sizing: border-box;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .accordion-header {
        background: #f8fafc; 
        padding: 1rem 1.25rem; 
        cursor: pointer;
        display: flex; 
        align-items: center; 
        justify-content: space-between;
        font-weight: 700; 
        font-size: .9rem;
        color: var(--text);
        user-select: none;
    }
    .accordion-header i {
        transition: transform 0.3s ease;
        color: var(--text-muted);
    }
    .accordion-body { 
        padding: 1.25rem; 
        display: none; 
        background: #fff;
        border-top: 1px solid var(--border);
    }
    .accordion-item.open .accordion-body { 
        display: block; 
    }
    .accordion-item.open .accordion-header i {
        transform: rotate(180deg);
        color: var(--primary);
    }

    
    .buku-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .buku-list-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0.8rem;
        border: 1px solid var(--border);
        border-radius: 8px;
        cursor: pointer;
        background: #fff;
        transition: all 0.2s;
    }
    .buku-list-item:hover {
        background: #f8fafc;
        border-color: var(--primary);
    }
    .buku-list-item.selected {
        background: #f0fdfa;
        border-color: var(--primary);
    }
    .buku-list-item.disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background: #f1f5f9;
        pointer-events: none;
    }
    .buku-checkbox {
        width: 1.1rem;
        height: 1.1rem;
        accent-color: var(--primary);
        cursor: pointer;
    }
    .buku-text {
        font-size: 0.9rem;
        color: var(--text);
    }
    .buku-text strong {
        font-weight: 700;
    }
    .stok-badge {
        display: inline-flex; 
        align-items: center;
        padding: 0.2rem 0.5rem; 
        border-radius: 20px;
        font-size: 0.75rem; 
        font-weight: 700; 
        margin-left: auto;
    }
    .stok-tersedia { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .stok-habis { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    
    
    .selected-list { 
        margin-top: 1.5rem; 
        background: #f8fafc; 
        border-radius: 12px; 
        border: 2px dashed var(--border); 
        padding: 1.25rem;
        display: flex; 
        flex-direction: column; 
        gap: .75rem;
    }
    .selected-book {
        display: flex; 
        align-items: center; 
        justify-content: space-between;
        padding: .8rem 1.25rem; 
        background: #fff; 
        border: 1px solid var(--border);
        border-left: 4px solid var(--primary);
        border-radius: 8px; 
        font-size: .9rem; 
        font-weight: 600; 
        color: var(--text);
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .selected-book .remove { 
        color: var(--text-muted); 
        cursor: pointer; 
        padding: .25rem; 
        transition: all .2s; 
    }
    .selected-book .remove:hover { 
        color: var(--danger);
        transform: scale(1.15); 
    }

    .empty-books-wrapper {
        padding: 2rem; 
        text-align: center; 
        color: var(--text-muted); 
        font-size: .9rem; 
        display: flex; 
        flex-direction: column; 
        gap: .5rem; 
        align-items: center;
    }
    .empty-books-wrapper i {
        font-size: 2.5rem; 
        color: #cbd5e1;
    }

    
    .btn-submit {
        width: 100%; 
        padding: .9rem; 
        background: var(--primary); 
        color: #fff;
        border: none; 
        border-radius: 8px; 
        font-weight: 700; 
        font-size: 1rem;
        cursor: pointer;
        margin-top: 1.5rem; 
        transition: all .2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 6px rgba(13, 148, 136, 0.2);
    }
    .btn-submit:hover { 
        background: var(--primary-dark); 
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(13, 148, 136, 0.3);
    }
    .btn-submit:active {
        transform: translateY(0);
    }
</style>
@endpush

@section('content')

<div class="container-peminjaman">
    <div class="page-header">
        <a href="{{ route('pperpus.peminjaman.perpustakaan.index') }}" title="Kembali ke Daftar">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>Catat Peminjaman Buku Perpustakaan</h1>
    </div>

    <form action="{{ route('pperpus.peminjaman.perpustakaan.store') }}" method="POST" id="form-peminjaman">
        @csrf
        <input type="hidden" name="id_siswa" id="hidden-id-siswa" required>
        
        <div class="card">
            <div class="card-header">
                <div class="card-header-content">
                    <i class="fas fa-edit" style="color: var(--primary); font-size: 1.1rem;"></i>
                    <h2>Form Informasi Peminjaman</h2>
                </div>
            </div>
            
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group flex-sm">
                        <label>Kode Peminjaman</label>
                        <input type="text" class="form-control code-peminjaman" value="{{ $kodePeminjaman }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pinjam <span class="required-star">*</span></label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" readonly required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Kembali / Batas Waktu <span class="required-star">*</span></label>
                        <input type="date" name="tanggal_kembali" class="form-control" value="{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group flex-sm">
                        <label>Pilih Kelas <span class="required-star">*</span></label>
                        <select id="select-kelas" class="form-control" required>
                            <option value="">— Pilih Kelas —</option>
                            <option value="VII-A">VII-A</option>
                            <option value="VII-B">VII-B</option>
                            <option value="VIII-A">VIII-A</option>
                            <option value="VIII-B">VIII-B</option>
                            <option value="IX-A">IX-A</option>
                            <option value="IX-B">IX-B</option>
                        </select>
                    </div>
                    <div class="form-group flex-lg">
                        <label>Nama Siswa <span class="required-star">*</span></label>
                        <select id="select-siswa" class="form-control" required disabled style="width: 100%;">
                            <option value="">— Pilih Kelas Terlebih Dahulu —</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional: masukkan catatan tambahan jika diperlukan..."></textarea>
                </div>

                <hr class="section-divider">
                
                <div class="books-selection-header">
                    <div>
                        <h3 class="books-selection-title">Pilih Koleksi Buku Perpustakaan <span class="required-star">*</span></h3>
                        <div class="books-selection-subtitle">Silakan klik satu atau beberapa kartu buku di bawah ini.</div>
                    </div>
                    <div class="counter-badge">
                        Terpilih: <span id="book-count">0</span> Buku
                    </div>
                </div>

                <div id="section-perpus">
                    @foreach($bukuPerpusPerKategori as $kat => $books)
                    <div class="accordion-item {{ $loop->first ? 'open' : '' }}">
                        <div class="accordion-header" onclick="this.parentElement.classList.toggle('open')">
                            <span>{{ $kat }} ({{ $books->count() }} Buku)</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="accordion-body">
                            <div class="buku-list">
                                @foreach($books as $b)
                                <label class="buku-list-item {{ $b->stok <= 0 ? 'disabled' : '' }}" data-id="{{ $b->id_buku }}" data-judul="{{ $b->judul_buku }}">
                                    <input type="checkbox" class="buku-checkbox" value="{{ $b->id_buku }}" {{ $b->stok <= 0 ? 'disabled' : '' }}>
                                    <span class="buku-text">
                                        <strong>{{ $b->judul_buku }}</strong>, Cipt Oleh {{ $b->pengarang ?? 'Tanpa Pengarang' }} {{ $b->tahun_terbit ? '('.$b->tahun_terbit.')' : '' }}
                                    </span>
                                    <div class="stok-badge {{ $b->stok > 0 ? 'stok-tersedia' : 'stok-habis' }}">
                                        <span>{{ $b->stok > 0 ? 'Stok: '.$b->stok : 'Habis' }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div id="selected-books-list" class="selected-list">
                    <div class="empty-books-wrapper">
                        <i class="fas fa-book-open"></i>
                        <span>Belum ada buku dipilih.<br>Silakan pilih beberapa buku di atas.</span>
                    </div>
                </div>

                <div id="hidden-inputs"></div>

                <button type="submit" class="btn-submit" id="btn-submit">
                    <i class="fas fa-save"></i>Simpan Data Peminjaman
                </button>

            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#select-siswa').select2({
            placeholder: "— Pilih Kelas Terlebih Dahulu —",
            allowClear: true
        });
    });

    const selectKelas = document.getElementById('select-kelas');
    const selectSiswa = $('#select-siswa');
    
    const hiddenIdSiswa = document.getElementById('hidden-id-siswa');

    const allSiswas = @json($siswas);

    selectKelas.addEventListener('change', function() {
        const kelas = this.value;
        
        selectSiswa.empty();
        selectSiswa.append(new Option("— Pilih Siswa —", "", false, false));
        hiddenIdSiswa.value = '';

        if (!kelas) {
            selectSiswa.prop('disabled', true);
            selectSiswa.empty().append(new Option("— Pilih Kelas Terlebih Dahulu —", "", false, false));
            selectSiswa.trigger('change');
            return;
        }

        selectSiswa.prop('disabled', false);
        
        const filteredSiswas = allSiswas.filter(s => {
            return s.kelas === kelas;
        });
        
        filteredSiswas.forEach(s => {
            selectSiswa.append(new Option(`${s.nama_siswa} (NIS: ${s.nis})`, s.id_siswa, false, false));
        });
        
        selectSiswa.trigger('change');
    });

    selectSiswa.on('change', function() {
        if (this.value) {
            hiddenIdSiswa.value = this.value;
        } else {
            hiddenIdSiswa.value = '';
        }
    });

    const selectedBooks = new Map();

    document.querySelectorAll('.buku-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const item = this.closest('.buku-list-item');
            const id = item.dataset.id;
            const judul = item.dataset.judul;
            
            if (this.checked) {
                selectedBooks.set(id, judul);
                item.classList.add('selected');
            } else {
                selectedBooks.delete(id);
                item.classList.remove('selected');
            }
            renderSelectedList();
        });
    });

    function renderSelectedList() {
        const list = document.getElementById('selected-books-list');
        const inputs = document.getElementById('hidden-inputs');
        const count = document.getElementById('book-count');
        
        list.innerHTML = '';
        inputs.innerHTML = '';
        count.textContent = selectedBooks.size;

        if (selectedBooks.size === 0) {
            list.innerHTML = `
                <div class="empty-books-wrapper">
                    <i class="fas fa-book-open"></i>
                    <span>Belum ada buku dipilih.<br>Silakan pilih beberapa buku di atas.</span>
                </div>
            `;
            list.style.borderStyle = 'dashed';
            return;
        }

        list.style.borderStyle = 'solid';

        let i = 0;
        selectedBooks.forEach((judul, id) => {

            const div = document.createElement('div');
            div.className = 'selected-book';
            div.innerHTML = `
                <span style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:85%">${judul}</span>
                <i class="fas fa-times remove" onclick="removeBook('${id}')" title="Hapus Buku"></i>
            `;
            list.appendChild(div);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `buku[${i}][id_buku]`;
            input.value = id;
            inputs.appendChild(input);
            i++;
        });
    }

    window.removeBook = function(id) {
        selectedBooks.delete(id);
        const el = document.querySelector(`.buku-list-item[data-id="${id}"]`);
        if (el) {
            el.classList.remove('selected');
            const checkbox = el.querySelector('.buku-checkbox');
            if (checkbox) checkbox.checked = false;
        }
        renderSelectedList();
    }

    document.getElementById('form-peminjaman').addEventListener('submit', function(e) {
        if (!hiddenIdSiswa.value) {
            e.preventDefault();
            alert('Silakan pilih nama siswa yang valid!');
            return;
        }

        if (selectedBooks.size === 0) {
            e.preventDefault();
            alert('Gagal menyimpan! Anda harus memilih minimal 1 buku.');
        }
    });
</script>
@endpush