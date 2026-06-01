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
    .stok-badge {
        display: inline-block; padding: 0.2rem 0.6rem; border-radius: 20px;
        font-size: 0.7rem; font-weight: 700; width: max-content;
    }
    .stok-tersedia { background: #eafaf1; color: var(--success); border: 1px solid #a9dfbf; }
    .stok-habis { background: #fdf0ef; color: var(--danger); border: 1px solid #f5c6c2; }
    
    #buku-container table tbody tr:hover { background: #fdfefe; }
    #buku-container table tbody tr:has(input:checked) { background: rgba(155, 89, 182, 0.06); }
    
    .stok-badge {
        display: inline-block; padding: 0.2rem 0.6rem; border-radius: 20px;
        font-size: 0.7rem; font-weight: 700; margin-top: 0.4rem; width: max-content;
    }
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
                let html = `
                <div class="table-responsive" style="border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.02);">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: .88rem;">
                        <thead style="background: #f8fafc; border-bottom: 1.5px solid var(--border);">
                            <tr>
                                <th style="padding: 1rem; width: 60px; text-align: center;">
                                    <input type="checkbox" id="check-all-bos" style="width: 18px; height: 18px; cursor: pointer; accent-color: var(--primary);">
                                </th>
                                <th style="padding: 1rem; font-weight: 800; color: var(--text-muted); font-size: .75rem; text-transform: uppercase;">Judul Buku</th>
                                <th style="padding: 1rem; font-weight: 800; color: var(--text-muted); font-size: .75rem; text-transform: uppercase;">Pengarang & Tahun</th>
                                <th style="padding: 1rem; font-weight: 800; color: var(--text-muted); font-size: .75rem; text-transform: uppercase;">Stok</th>
                            </tr>
                        </thead>
                        <tbody id="buku-tbody">
                `;
                bukus.forEach(b => {
                    html += `
                        <tr style="border-bottom: 1px solid var(--border); transition: background .2s;">
                            <td style="padding: 1rem; text-align: center;">
                                <input type="checkbox" name="buku_bos[]" value="${b.id_buku}" class="buku-checkbox" style="width: 18px; height: 18px; cursor: pointer; accent-color: var(--primary);">
                            </td>
                            <td style="padding: 1rem; font-weight: 700; color: var(--text);">${b.judul_buku}</td>
                            <td style="padding: 1rem; color: var(--text-muted); font-size: .8rem;">
                                <i class="fas fa-user-edit"></i> ${b.pengarang || 'Tanpa Pengarang'}, ${b.tahun_terbit || '-'}
                            </td>
                            <td style="padding: 1rem;">
                                <div class="stok-badge ${b.stok > 0 ? 'stok-tersedia' : 'stok-habis'}" style="margin:0;">
                                    <i class="fas fa-layer-group"></i> Stok: ${b.stok}
                                </div>
                            </td>
                        </tr>
                    `;
                });
                html += `
                        </tbody>
                    </table>
                </div>
                `;
                bukuContainer.innerHTML = html;
                
                const checkAll = document.getElementById('check-all-bos');
                const checkboxes = document.querySelectorAll('.buku-checkbox');
                if (checkAll) {
                    checkAll.addEventListener('change', function() {
                        checkboxes.forEach(cb => cb.checked = this.checked);
                        updateSelectedBosBooks();
                    });
                }
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
        const checkedBoxes = document.querySelectorAll('input[name="buku_bos[]"]:checked');
        if (bookCount) bookCount.textContent = checkedBoxes.length;
        
        const allBoxes = document.querySelectorAll('input[name="buku_bos[]"]');
        const checkAll = document.getElementById('check-all-bos');
        if (checkAll && allBoxes.length > 0) {
            checkAll.checked = (checkedBoxes.length === allBoxes.length);
        }
    }

    bukuContainer.addEventListener('change', function(e) {
        if(e.target && e.target.classList.contains('buku-checkbox')) {
            updateSelectedBosBooks();
        }
    });

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
