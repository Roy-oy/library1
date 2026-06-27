@extends('pperpus.layouts.app')

@section('title', 'Catat Peminjaman Buku BOS')

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
        display: flex; align-items: center; gap: .6rem;
    }
    .card-header h2 { font-size: .95rem; font-weight: 700; }
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

    .btn-submit {
        width: 100%; padding: .8rem; background: var(--primary); color: #fff;
        border: none; border-radius: 8px; font-weight: 700; cursor: pointer;
        margin-top: 1rem; transition: background .2s;
    }
    .btn-submit:hover { background: var(--primary-dark); }

    
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

    .empty-books {
        text-align: center; color: var(--text-muted); font-size: .85rem; 
        padding: 2.5rem 1.5rem; background: var(--surface); border-radius: 12px; 
        border: 2px dashed var(--border);
        display: flex; flex-direction: column; gap: .8rem; align-items: center;
    }
    .empty-books i { font-size: 2.5rem; color: #cbd5e1; }
    
</style>
@endpush

@section('content')

<div style="max-width: 850px; margin: 0 auto;">
<div class="page-header">
    <a href="{{ route('pperpus.peminjaman.bos.index') }}"><i class="fas fa-arrow-left"></i></a>
    <h1>Catat Peminjaman Buku BOS</h1>
</div>

<form action="{{ route('pperpus.peminjaman.bos.store') }}" method="POST" id="form-peminjaman">
    @csrf
    <input type="hidden" name="id_siswa" id="hidden-id-siswa" required>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit" style="color:var(--primary)"></i>
            <h2>Form Peminjaman</h2>
        </div>
        <div class="card-body">
            
            <div class="form-row">
                <div class="form-group" style="flex: 0.8">
                    <label>Kode Peminjaman</label>
                    <input type="text" class="form-control" value="{{ $kodePeminjaman }}" disabled style="background:#f8fafc; font-weight:800; color:var(--primary); border: 1px dashed var(--primary)">
                </div>
                <div class="form-group" style="flex: 2">
                    <label>Tanggal Pinjam <span style="color:var(--danger)">*</span></label>
                    <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" readonly required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 0.8">
                    <label>Pilih Kelas <span style="color:var(--danger)">*</span></label>
                    <select id="select-kelas" class="form-control" required style="background: #fff;">
                        <option value="">— Pilih Kelas —</option>
                        <option value="VII-A">VII-A</option>
                        <option value="VII-B">VII-B</option>
                        <option value="VIII-A">VIII-A</option>
                        <option value="VIII-B">VIII-B</option>
                        <option value="IX-A">IX-A</option>
                        <option value="IX-B">IX-B</option>
                    </select>
                </div>
                <div class="form-group" style="flex: 2">
                    <label>Nama Siswa <span style="color:var(--danger)">*</span></label>
                    <select id="select-siswa" name="id_siswa" class="form-control" required disabled style="width: 100%;">
                        <option value="">— Pilih Kelas Terlebih Dahulu —</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan Tambahan</label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional..."></textarea>
            </div>

            <hr style="border:0; border-top:1px solid var(--border); margin:1.5rem 0">
            
            <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:1rem;">
                <div>
                    <label style="margin:0; font-size:.9rem; font-weight:800; color:var(--text)">Pilih Koleksi Buku BOS <span style="color:var(--danger)">*</span></label>
                    <div style="font-size:.75rem; color:var(--text-muted); margin-top:.2rem">Centang buku-buku paket yang ingin dipinjamkan.</div>
                </div>
                <span style="font-size:.85rem; font-weight:800; color:var(--primary); background:#eef4fc; padding:.4rem .8rem; border-radius:20px;">Terpilih: <span id="book-count">0</span> Buku</span>
            </div>
            <div id="buku-container">
                <div class="empty-books">
                    <i class="fas fa-user-graduate"></i>
                    <span>Silakan masukkan <b>Nama Siswa</b> terlebih dahulu<br>untuk melihat daftar Buku BOS sesuai kelasnya.</span>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="btn-submit">
                <i class="fas fa-save" style="margin-right:.4rem"></i>Simpan Peminjaman
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
    const bukuContainer = document.getElementById('buku-container');

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
            bukuContainer.innerHTML = `
                <div class="empty-books">
                    <i class="fas fa-user-graduate"></i>
                    <span>Silakan pilih <b>Kelas</b> terlebih dahulu<br>untuk memuat daftar Siswa dan Buku BOS.</span>
                </div>
            `;
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

        fetchBooks(kelas);
    });

    selectSiswa.on('change', function() {
        if (this.value) {
            hiddenIdSiswa.value = this.value;
        } else {
            hiddenIdSiswa.value = '';
        }
    });

    async function fetchBooks(kelas) {
        bukuContainer.innerHTML = '<div style="text-align:center; padding:1rem;"><i class="fas fa-spinner fa-spin"></i> Memuat buku...</div>';
        try {
            const baseClass = kelas.split('-')[0];
            const resBuku = await fetch(`{{ route('pperpus.peminjaman.getBuku') }}?kelas=${baseClass}&sumber=bos`);
            const bukus = await resBuku.json();

            if (bukus.length === 0) {
                bukuContainer.innerHTML = `
                    <div class="empty-books">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Tidak ada Buku BOS tersedia untuk Kelas ${baseClass}.</span>
                    </div>
                `;
            } else {
                let html = `
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.8rem; padding: 0.5rem; background: #f8fafc; border: 1px solid var(--border); border-radius: 8px;">
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; margin:0; font-size:.9rem; font-weight:700;">
                        <input type="checkbox" id="check-all-bos" style="width: 1.1rem; height: 1.1rem; accent-color: var(--primary); cursor: pointer;">
                        Pilih Semua Buku BOS Kelas ${baseClass}
                    </label>
                </div>
                <div class="buku-list">
                `;
                bukus.forEach(b => {
                    const disabled = b.stok <= 0 ? 'disabled' : '';
                    const stokBadge = b.stok > 0 ? `<div class="stok-badge stok-tersedia"><span>Stok: ${b.stok}</span></div>` : `<div class="stok-badge stok-habis"><span>Habis</span></div>`;
                    
                    html += `
                        <label class="buku-list-item ${disabled}">
                            <input type="checkbox" name="buku_bos[]" value="${b.id_buku}" class="buku-checkbox" ${disabled}>
                            <span class="buku-text">
                                <strong>${b.judul_buku}</strong>, Cipt Oleh ${b.pengarang || 'Tanpa Pengarang'} ${b.tahun_terbit ? '('+b.tahun_terbit+')' : ''}
                            </span>
                            ${stokBadge}
                        </label>
                    `;
                });
                html += `</div>`;
                bukuContainer.innerHTML = html;
                
                const checkAll = document.getElementById('check-all-bos');
                const checkboxes = document.querySelectorAll('.buku-checkbox');
                if (checkAll) {
                    checkAll.addEventListener('change', function() {
                        checkboxes.forEach(cb => {
                            if (!cb.disabled) {
                                cb.checked = this.checked;
                                const item = cb.closest('.buku-list-item');
                                if (this.checked) item.classList.add('selected');
                                else item.classList.remove('selected');
                            }
                        });
                        updateSelectedBosBooks();
                    });
                }
                
                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        const item = this.closest('.buku-list-item');
                        if (this.checked) item.classList.add('selected');
                        else item.classList.remove('selected');
                        updateSelectedBosBooks();
                    });
                });
            }
            updateSelectedBosBooks();

        } catch (e) {
            console.error('Error fetching buku:', e);
            bukuContainer.innerHTML = '<div style="color:red; text-align:center;">Terjadi kesalahan saat memuat buku.</div>';
            updateSelectedBosBooks();
        }
    }

    const bookCount = document.getElementById('book-count');

    function updateSelectedBosBooks() {
        const checkedBoxes = document.querySelectorAll('.buku-checkbox:checked');
        if (bookCount) bookCount.textContent = checkedBoxes.length;
        
        const allBoxes = document.querySelectorAll('.buku-checkbox:not(:disabled)');
        const checkAll = document.getElementById('check-all-bos');
        if (checkAll && allBoxes.length > 0) {
            checkAll.checked = (checkedBoxes.length === allBoxes.length);
        }
    }

    document.getElementById('form-peminjaman').addEventListener('submit', function(e) {
        if (!hiddenIdSiswa.value) {
            e.preventDefault();
            alert('Pilih nama siswa dari daftar yang valid!');
            return;
        }

        const checked = document.querySelectorAll('.buku-checkbox:checked');
        if (checked.length === 0) {
            e.preventDefault();
            alert('Silakan pilih minimal satu buku BOS!');
        }
    });
</script>
@endpush
