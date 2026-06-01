@extends('pperpus.layouts.app')

@section('title', 'Catat Peminjaman Buku Perpustakaan')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; gap: .8rem; margin-bottom: 1.5rem;
    }
    .page-header a {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 8px;
        background: var(--surface); border: 1px solid var(--border);
        color: var(--text-muted); text-decoration: none;
    }
    .page-header h1 { font-size: 1.25rem; font-weight: 800; color: var(--text); }

    .card {
        background: var(--surface); border-radius: var(--radius);
        box-shadow: var(--shadow); margin-bottom: 1.5rem;
    }
    .card-header {
        padding: 1rem 1.4rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: .6rem; justify-content: space-between;
    }
    .card-header h2 { font-size: .95rem; font-weight: 700; margin: 0; }
    .card-body { padding: 1.4rem; }

    .form-group { margin-bottom: 1.2rem; }
    .form-group label { display: block; font-size: .8rem; font-weight: 700; margin-bottom: .4rem; }
    .form-control {
        width: 100%; padding: .65rem .85rem; border: 1.5px solid var(--border);
        border-radius: 8px; font-family: inherit; font-size: .88rem; outline: none;
    }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,60,94,.1); }

    .form-row { display: flex; gap: 1rem; }
    .form-row > .form-group { flex: 1; }

    /* Books Selection UI */
    .accordion-item { border: 1px solid var(--border); border-radius: 8px; margin-bottom: .6rem; overflow: hidden; }
    .accordion-header {
        background: #f8fafc; padding: .75rem 1rem; cursor: pointer;
        display: flex; align-items: center; justify-content: space-between;
        font-weight: 700; font-size: .85rem;
    }
    .accordion-body { padding: 1rem; display: none; }
    .accordion-item.open .accordion-body { display: block; }

    .buku-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: .8rem;
    }
    .buku-item {
        border: 1.5px solid var(--border); border-radius: 10px; padding: .8rem;
        cursor: pointer; transition: all .2s; position: relative;
    }
    .buku-item:hover { border-color: var(--primary); background: #f4f8fd; }
    .buku-item.selected { border-color: var(--primary); background: #eef4fc; box-shadow: 0 0 0 2px var(--primary); }
    
    .buku-item .check-mark {
        position: absolute; top: .5rem; right: .5rem; color: var(--primary); display: none;
    }
    .buku-item.selected .check-mark { display: block; }

    .buku-item .judul { font-weight: 700; font-size: .82rem; margin-bottom: .2rem; }
    .buku-item .meta  { font-size: .75rem; color: var(--text-muted); }
    
    .selected-list { 
        margin-top: 1rem; background: var(--surface); border-radius: 12px; 
        border: 2px dashed var(--border); padding: 1rem;
        display: flex; flex-direction: column; gap: .5rem;
    }
    .selected-book {
        display: flex; align-items: center; justify-content: space-between;
        padding: .8rem 1rem; background: #f0fdf4; border: 1px solid #bbf7d0;
        border-radius: 8px; font-size: .85rem; font-weight: 700; color: var(--primary-dark);
    }
    .selected-book .remove { color: var(--danger); cursor: pointer; padding: .2rem; transition: transform .2s; }
    .selected-book .remove:hover { transform: scale(1.1); }
    
    .empty-books {
        text-align: center; color: var(--text-muted); font-size: .85rem; 
        padding: 1.5rem; display: flex; flex-direction: column; gap: .5rem; align-items: center;
    }
    .empty-books i { font-size: 2rem; color: var(--border); }

    .btn-submit {
        width: 100%; padding: .8rem; background: var(--primary); color: #fff;
        border: none; border-radius: 8px; font-weight: 700; cursor: pointer;
        margin-top: 1rem; transition: background .2s;
    }
    .btn-submit:hover { background: var(--primary-dark); }
</style>
@endpush

@section('content')

<div style="max-width: 850px; margin: 0 auto;">
<div class="page-header">
    <a href="{{ route('pperpus.peminjaman.perpustakaan.index') }}"><i class="fas fa-arrow-left"></i></a>
    <h1>Catat Peminjaman Buku Perpustakaan</h1>
</div>

<form action="{{ route('pperpus.peminjaman.perpustakaan.store') }}" method="POST" id="form-peminjaman">
    @csrf
    <input type="hidden" name="id_siswa" id="hidden-id-siswa" required>
    
    <div class="card">
        <div class="card-header">
            <div style="display:flex; align-items:center; gap:.6rem;">
                <i class="fas fa-edit" style="color:var(--primary)"></i>
                <h2>Form Peminjaman</h2>
            </div>
        </div>
        <div class="card-body">
            
            <div class="form-row">
                <div class="form-group" style="flex: 0.8">
                    <label>Kode Peminjaman</label>
                    <input type="text" class="form-control" value="{{ $kodePeminjaman }}" disabled style="background:#f8fafc; font-weight:800; color:var(--primary); border: 1px dashed var(--primary)">
                </div>
                <div class="form-group">
                    <label>Tanggal Pinjam <span style="color:var(--danger)">*</span></label>
                    <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Batas Waktu / Tanggal Kembali <span style="color:var(--danger)">*</span></label>
                    <input type="date" name="tanggal_kembali" class="form-control" value="{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 0.8">
                    <label>Pilih Kelas <span style="color:var(--danger)">*</span></label>
                    <select id="select-kelas" class="form-control" required style="background: #fff;">
                        <option value="">— Pilih Kelas —</option>
                        <option value="VII">VII</option>
                        <option value="VIII">VIII</option>
                        <option value="IX">IX</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 2">
                    <label>Nama Siswa <span style="color:var(--danger)">*</span></label>
                    <select id="select-siswa" class="form-control" required disabled>
                        <option value="">— Pilih Kelas Terlebih Dahulu —</option>
                    </select>
                </div>
            </div>

            <div class="form-row" style="margin-top: -0.5rem; margin-bottom: 1rem;">
                <div class="form-group" style="flex: 1">
                    <input type="text" id="input-nis" class="form-control" placeholder="NIS" disabled style="background:#f8fafc; font-size:.8rem;">
                </div>
                <div class="form-group" style="flex: 1">
                    <input type="text" id="input-kelas" class="form-control" placeholder="Kelas" disabled style="background:#f8fafc; font-size:.8rem;">
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan Tambahan</label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional: catatan untuk peminjaman ini..."></textarea>
            </div>

            <hr style="border:0; border-top:1px solid var(--border); margin:1.5rem 0">
            
            <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:1rem;">
                <div>
                    <label style="margin:0; font-size:.9rem; font-weight:800; color:var(--text)">Pilih Koleksi Buku Perpustakaan <span style="color:var(--danger)">*</span></label>
                    <div style="font-size:.75rem; color:var(--text-muted); margin-top:.2rem">Klik pada buku yang ingin dipinjam.</div>
                </div>
                <span style="font-size:.85rem; font-weight:800; color:var(--primary); background:#eef4fc; padding:.4rem .8rem; border-radius:20px;">Terpilih: <span id="book-count">0</span> Buku</span>
            </div>

            <div id="section-perpus">
                @foreach($bukuPerpusPerKategori as $kat => $books)
                <div class="accordion-item {{ $loop->first ? 'open' : '' }}">
                    <div class="accordion-header" onclick="this.parentElement.classList.toggle('open')">
                        <span>{{ $kat }} ({{ $books->count() }} Buku)</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="accordion-body">
                        <div class="buku-grid">
                            @foreach($books as $b)
                            <div class="buku-item" data-id="{{ $b->id_buku }}" data-judul="{{ $b->judul_buku }}">
                                <i class="fas fa-check-circle check-mark"></i>
                                <div class="judul">{{ $b->judul_buku }}</div>
                                <div class="meta">{{ $b->pengarang ?? 'Tanpa Pengarang' }}</div>
                                <div class="meta" style="color:{{ $b->stok > 0 ? 'inherit' : 'red' }}">Stok: {{ $b->stok }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div id="selected-books-list" class="selected-list">
                <div class="empty-books">
                    <i class="fas fa-book-open"></i>
                    <span>Belum ada buku dipilih.<br>Silakan pilih buku dari daftar di atas.</span>
                </div>
            </div>

            {{-- Hidden inputs for books --}}
            <div id="hidden-inputs"></div>

            <button type="submit" class="btn-submit" id="btn-submit">
                <i class="fas fa-save" style="margin-right:.4rem"></i>Simpan Peminjaman
            </button>

        </div>
    </div>
</form>
</div>

@endsection

@push('scripts')
<script>
    const selectKelas = document.getElementById('select-kelas');
    const selectSiswa = document.getElementById('select-siswa');
    
    const hiddenIdSiswa = document.getElementById('hidden-id-siswa');
    const inputNis = document.getElementById('input-nis');
    const inputKelas = document.getElementById('input-kelas');

    const allSiswas = @json($siswas);

    selectKelas.addEventListener('change', function() {
        const kelas = this.value;
        
        selectSiswa.innerHTML = '<option value="">— Pilih Siswa —</option>';
        hiddenIdSiswa.value = '';
        inputNis.value = '';
        inputKelas.value = '';

        if (!kelas) {
            selectSiswa.disabled = true;
            selectSiswa.innerHTML = '<option value="">— Pilih Kelas Terlebih Dahulu —</option>';
            return;
        }

        selectSiswa.disabled = false;
        
        const filteredSiswas = allSiswas.filter(s => {
            const baseClass = s.kelas.split(/[- .]/)[0];
            return baseClass === kelas;
        });
        
        filteredSiswas.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.id_siswa;
            opt.dataset.nis = s.nis;
            opt.dataset.kelas = s.kelas;
            opt.textContent = `${s.nama_siswa} (NIS: ${s.nis})`;
            selectSiswa.appendChild(opt);
        });
    });

    selectSiswa.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            hiddenIdSiswa.value = this.value;
            inputNis.value = selectedOption.dataset.nis;
            inputKelas.value = selectedOption.dataset.kelas;
        } else {
            hiddenIdSiswa.value = '';
            inputNis.value = '';
            inputKelas.value = '';
        }
    });

    // Books Selection Logic
    const selectedBooks = new Map();

    document.querySelectorAll('.buku-item').forEach(item => {
        item.addEventListener('click', function() {
            const id = this.dataset.id;
            const judul = this.dataset.judul;

            if (selectedBooks.has(id)) {
                selectedBooks.delete(id);
                this.classList.remove('selected');
            } else {
                selectedBooks.set(id, judul);
                this.classList.add('selected');
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
                <div class="empty-books">
                    <i class="fas fa-book-open"></i>
                    <span>Belum ada buku dipilih.<br>Silakan pilih buku dari daftar di atas.</span>
                </div>
            `;
            list.style.borderStyle = 'dashed';
            return;
        }

        list.style.borderStyle = 'solid';

        let i = 0;
        selectedBooks.forEach((judul, id) => {
            // List UI
            const div = document.createElement('div');
            div.className = 'selected-book';
            div.innerHTML = `
                <span style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:90%">${judul}</span>
                <i class="fas fa-times remove" onclick="removeBook('${id}')"></i>
            `;
            list.appendChild(div);

            // Hidden input for form
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
        const el = document.querySelector(`.buku-item[data-id="${id}"]`);
        if (el) el.classList.remove('selected');
        renderSelectedList();
    }

    // Form validation
    document.getElementById('form-peminjaman').addEventListener('submit', function(e) {
        if (!hiddenIdSiswa.value) {
            e.preventDefault();
            alert('Pilih nama siswa dari daftar yang valid!');
            return;
        }

        if (selectedBooks.size === 0) {
            e.preventDefault();
            alert('Silakan pilih minimal satu buku!');
        }
    });
</script>
@endpush
