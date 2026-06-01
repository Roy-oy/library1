@extends('pperpus.layouts.app')

@section('title', 'Catat Peminjaman Buku BOS')

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

    /* Books Selection UI */
    .buku-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: .8rem;
    }
    .buku-item {
        border: 1.5px solid var(--border); border-radius: 10px; padding: .8rem;
        transition: all .2s; position: relative; background: #fff;
        display: flex; align-items: flex-start; gap: 10px;
    }
    .buku-item:hover { border-color: var(--primary); background: #f4f8fd; }
    
    .buku-checkbox {
        width: 18px; height: 18px; margin-top: 3px; cursor: pointer;
    }
    .buku-info { flex: 1; }
    .buku-item .judul { font-weight: 700; font-size: .85rem; margin-bottom: .2rem; color: var(--text); }
    .buku-item .meta  { font-size: .75rem; color: var(--text-muted); }

    .empty-books {
        text-align: center; color: var(--text-muted); font-size: .85rem; 
        padding: 2.5rem 1.5rem; background: var(--surface); border-radius: 12px; 
        border: 2px dashed var(--border);
        display: flex; flex-direction: column; gap: .8rem; align-items: center;
    }
    .empty-books i { font-size: 2.5rem; color: var(--border); }
    
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
                    <input type="date" name="tanggal_pinjam" class="form-control" value="{{ date('Y-m-d') }}" required>
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
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional..."></textarea>
            </div>

            <hr style="border:0; border-top:1px solid var(--border); margin:1.5rem 0">
            
            <div style="display:flex; flex-direction:column; margin-bottom:1rem;">
                <label style="margin:0; font-size:.9rem; font-weight:800; color:var(--text)">Pilih Koleksi Buku BOS <span style="color:var(--danger)">*</span></label>
                <div style="font-size:.75rem; color:var(--text-muted); margin-top:.2rem">Centang buku-buku paket yang ingin dipinjamkan.</div>
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
<script>
    const selectKelas = document.getElementById('select-kelas');
    const selectSiswa = document.getElementById('select-siswa');
    
    const hiddenIdSiswa = document.getElementById('hidden-id-siswa');
    const inputNis = document.getElementById('input-nis');
    const inputKelas = document.getElementById('input-kelas');
    const bukuContainer = document.getElementById('buku-container');

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
            bukuContainer.innerHTML = `
                <div class="empty-books">
                    <i class="fas fa-user-graduate"></i>
                    <span>Silakan pilih <b>Kelas</b> terlebih dahulu<br>untuk memuat daftar Siswa dan Buku BOS.</span>
                </div>
            `;
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

        // Automatically fetch books for this class
        fetchBooks(kelas);
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

    async function fetchBooks(kelas) {
        bukuContainer.innerHTML = '<div style="text-align:center; padding:1rem;"><i class="fas fa-spinner fa-spin"></i> Memuat buku...</div>';
        try {
            const baseClass = kelas.split('-')[0]; // Handle VII-A -> VII if books are just marked as VII
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
                let html = '<div class="buku-grid">';
                bukus.forEach(b => {
                    html += `
                        <label class="buku-item">
                            <input type="checkbox" name="buku_bos[]" value="${b.id_buku}" class="buku-checkbox">
                            <div class="buku-info">
                                <div class="judul">${b.judul_buku}</div>
                                <div class="meta">${b.pengarang || 'Tanpa Pengarang'}</div>
                                <div class="meta" style="color:${b.stok > 0 ? 'inherit' : 'red'}">Stok: ${b.stok}</div>
                            </div>
                        </label>
                    `;
                });
                html += '</div>';
                bukuContainer.innerHTML = html;
            }

        } catch (e) {
            console.error('Error fetching buku:', e);
            bukuContainer.innerHTML = '<div style="color:red; text-align:center;">Terjadi kesalahan saat memuat buku.</div>';
        }
    }

    document.getElementById('form-peminjaman').addEventListener('submit', function(e) {
        if (!hiddenIdSiswa.value) {
            e.preventDefault();
            alert('Pilih nama siswa dari daftar yang valid!');
            return;
        }

        const checked = document.querySelectorAll('input[name="buku_bos[]"]:checked');
        if (checked.length === 0) {
            e.preventDefault();
            alert('Silakan pilih minimal satu buku BOS!');
        }
    });
</script>
@endpush
