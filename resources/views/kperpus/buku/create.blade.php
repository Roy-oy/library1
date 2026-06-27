@extends('kperpus.layouts.app')

@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku Baru')

@push('styles')
<style>
    
    .simple-container {
        max-width: 850px;
        margin: 2rem auto 4rem auto;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-top: 5px solid #1e3a8a; 
        border-radius: 16px;
        padding: 0;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        box-shadow: 0 10px 30px -5px rgba(30, 58, 138, 0.05), 0 8px 15px -6px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    
    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(to right, #eff6ff, #ffffff); 
        padding: 2rem 3rem;
        border-bottom: 1px solid #dbeafe;
    }

    .form-header-title {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .form-header-icon {
        background: #dbeafe;
        color: #172554;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .form-header h2 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e3a8a;
        letter-spacing: -0.02em;
    }

    .form-header p {
        margin: 0.25rem 0 0 0;
        font-size: 0.875rem;
        opacity: 0.8;
    }

    
    .btn-kembali {
        text-decoration: none;
        color: #172554;
        background: #ffffff;
        border: 1px solid #bfdbfe;
        padding: 0.6rem 1.1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }

    .btn-kembali:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #172554;
    }

    
    .form-body {
        padding: 3rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.75rem;
    }

    .full-width {
        grid-column: span 2;
    }

    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.55rem;
    }

    .form-group label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    
    .form-group label i {
        color: #1e3a8a; 
        font-size: 0.95rem;
    }

    .form-group label span {
        color: #ef4444;
        font-weight: bold;
    }

    
    .form-input {
        padding: 0.8rem 1.1rem;
        font-size: 0.925rem;
        font-family: inherit;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #0f172a;
        background-color: #f8fafc;
        outline: none;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        background-color: #ffffff;
        border-color: #1e3a8a; 
        box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.15);
    }

    .form-input::placeholder {
        color: #94a3b8;
    }

    
    select.form-input {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%231e3a8a' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 0.9rem;
        padding-right: 2.75rem;
    }

    
    .file-upload-zone {
        border: 2px dashed #bfdbfe;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background: #f0f5ff;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.6rem;
    }

    .file-upload-zone:hover {
        border-color: #1e3a8a;
        background: #dbeafe;
    }

    .file-upload-zone i {
        font-size: 2rem;
        color: #1e3a8a;
    }

    .file-upload-zone input[type="file"] {
        display: none;
    }

    .info-bantuan {
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.4;
    }

    .preview-container {
        display: none;
        margin-top: 1rem;
        max-width: 130px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #1e3a8a;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .preview-container img {
        width: 100%;
        height: auto;
        display: block;
    }

    
    .form-actions {
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn {
        padding: 0.8rem 2.2rem;
        font-size: 0.925rem;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        transition: all 0.2s ease;
    }

    .btn-batal {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
    }

    .btn-batal:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .btn-simpan {
        background: #1e3a8a; 
        color: #ffffff;
        border: 1px solid #1e3a8a;
        box-shadow: 0 4px 14px rgba(30, 58, 138, 0.2);
    }

    .btn-simpan:hover {
        background: #172554;
        border-color: #172554;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(23, 37, 84, 0.25);
    }
    
    .btn-simpan:active {
        transform: translateY(0);
    }

    
    @media (max-width: 640px) {
        .form-header { padding: 1.5rem; flex-direction: column; align-items: flex-start; gap: 1.25rem; }
        .btn-kembali { width: 100%; justify-content: center; }
        .form-body { padding: 1.5rem; }
        .form-grid { grid-template-columns: 1fr; gap: 1.25rem; }
        .full-width { grid-column: span 1; }
        .form-actions { flex-direction: column-reverse; gap: 0.75rem; }
        .btn { width: 100%; justify-content: center; padding: 0.9rem; }
    }
</style>
@endpush

@section('content')
<div class="simple-container">
    
    
    <div class="form-header">
        <div class="form-header-title">
            <div class="form-header-icon">
                <i class="fas fa-book-medical"></i>
            </div>
            <div>
                <h2>Form Tambah Buku</h2>
                <p>Isi formulir di bawah secara lengkap untuk menambah koleksi perpustakaan.</p>
            </div>
        </div>
        <a href="{{ route('kperpus.buku.index') }}" class="btn-kembali">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    
    <div class="form-body">
        <form action="{{ route('kperpus.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                
                
                <div class="form-group">
                    <label for="sumber_buku"><i class="fas fa-wallet"></i> Sumber Buku <span>*</span></label>
                    <select name="sumber_buku" id="sumber_buku" class="form-input" onchange="pilihJenisBuku(this.value)">
                        <option value="buku perpus" {{ old('sumber_buku', request('sumber_buku')) !== 'bos' ? 'selected' : '' }}>Buku Perpustakaan</option>
                        <option value="bos" {{ old('sumber_buku', request('sumber_buku')) === 'bos' ? 'selected' : '' }}>Buku Dana BOS</option>
                    </select>
                </div>

                
                <div class="form-group" id="input-kategori">
                    <label for="id_kategori"><i class="fas fa-tags"></i> Kategori Buku <span>*</span></label>
                    <select name="id_kategori" id="id_kategori" class="form-input">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori ?? [] as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                
                <div class="form-group" id="input-kelas" style="display: none;">
                    <label for="kelas"><i class="fas fa-graduation-cap"></i> Untuk Siswa Kelas <span>*</span></label>
                    <select name="kelas" id="kelas" class="form-input">
                        <option value="">-- Pilih Tingkatan Kelas --</option>
                        <option value="VII" {{ old('kelas') == 'VII' ? 'selected' : '' }}>Kelas VII</option>
                        <option value="VIII" {{ old('kelas') == 'VIII' ? 'selected' : '' }}>Kelas VIII</option>
                        <option value="IX" {{ old('kelas') == 'IX' ? 'selected' : '' }}>Kelas IX</option>
                    </select>
                </div>

                
                <div class="form-group">
                    <label for="kode_buku"><i class="fas fa-barcode"></i> Kode Buku <span>*</span></label>
                    <input type="text" name="kode_buku" id="kode_buku" class="form-input" placeholder="Contoh: BKP-001" required value="{{ old('kode_buku') }}">
                </div>

                
                <div class="form-group">
                    <label for="isbn"><i class="fas fa-book-open"></i> Nomor ISBN</label>
                    <input type="text" name="isbn" id="isbn" class="form-input" placeholder="Boleh dikosongkan jika tidak ada" value="{{ old('isbn') }}">
                </div>

                
                <div class="form-group full-width">
                    <label for="judul_buku"><i class="fas fa-book"></i> Judul Buku <span>*</span></label>
                    <input type="text" name="judul_buku" id="judul_buku" class="form-input" placeholder="Masukkan judul lengkap buku secara jelas" required value="{{ old('judul_buku') }}">
                </div>

                
                <div class="form-group full-width">
                    <label for="pengarang"><i class="fas fa-user-edit"></i> Nama Pengarang / Penulis <span>*</span></label>
                    <input type="text" name="pengarang" id="pengarang" class="form-input" placeholder="Nama penulis asli atau instansi penerbit resmi" required value="{{ old('pengarang') }}">
                </div>

                
                <div class="form-group">
                    <label for="tahun_terbit"><i class="fas fa-calendar-alt"></i> Tahun Terbit <span>*</span></label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-input" placeholder="Contoh: 2024" required min="1800" max="{{ date('Y') }}" value="{{ old('tahun_terbit') }}">
                </div>

                
                <div class="form-group">
                    <label for="stok"><i class="fas fa-layer-group"></i> Jumlah Stok Fisik <span>*</span></label>
                    <input type="number" name="stok" id="stok" class="form-input" required min="0" value="{{ old('stok', 1) }}">
                </div>

                
                <div class="form-group">
                    <label for="rak"><i class="fas fa-archive"></i> Lokasi Rak</label>
                    <input type="text" name="rak" id="rak" class="form-input" placeholder="Contoh: R-01, A-1" value="{{ old('rak') }}">
                </div>

                
                <div class="form-group full-width">
                    <label><i class="fas fa-image"></i> Foto Sampul Buku</label>
                    <div class="file-upload-zone" onclick="document.getElementById('gambar').click()">
                        <i class="fas fa-cloud-upload-alt" id="upload-icon"></i>
                        <span class="font-medium text-sm text-slate-700" id="upload-text">Klik atau seret gambar ke sini untuk mengunggah</span>
                        <span class="info-bantuan">Format gambar wajib: JPG, JPEG, atau PNG (Maksimal file 2MB)</span>
                        <input type="file" name="gambar" id="gambar" accept="image/*" onchange="previewImage(this)">
                        <div class="preview-container" id="image-preview-wrapper">
                            <img id="image-preview" src="#" alt="Preview Sampul">
                        </div>
                    </div>
                </div>

            </div>

            
            <div class="form-actions">
                <a href="{{ route('kperpus.buku.index') }}" class="btn btn-batal">Batal</a>
                <button type="submit" class="btn btn-simpan">
                    <i class="fas fa-save"></i> Simpan Buku
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const previewWrapper = document.getElementById('image-preview-wrapper');
        const previewImg = document.getElementById('image-preview');
        const uploadText = document.getElementById('upload-text');
        const uploadIcon = document.getElementById('upload-icon');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewWrapper.style.display = 'block';
                uploadText.textContent = `File dipilih: ${input.files[0].name}`;
                uploadText.style.color = '#1e3a8a';
                uploadIcon.className = 'fas fa-check-circle';
                uploadIcon.style.color = '#1e3a8a';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            previewWrapper.style.display = 'none';
            uploadText.textContent = 'Klik atau seret gambar ke sini untuk mengunggah';
            uploadText.style.color = '#334155';
            uploadIcon.className = 'fas fa-cloud-upload-alt';
            uploadIcon.style.color = '#1e3a8a';
        }
    }

    
    function pilihJenisBuku(nilai) {
        const divKategori = document.getElementById('input-kategori');
        const divKelas = document.getElementById('input-kelas');
        const selectKategori = document.getElementById('id_kategori');
        const selectKelas = document.getElementById('kelas');

        if (nilai === 'bos') {
            divKelas.style.display = 'flex';
            selectKelas.setAttribute('required', 'required');
            divKategori.style.display = 'none';
            selectKategori.removeAttribute('required');
            selectKategori.value = '';
        } else {
            divKategori.style.display = 'flex';
            selectKategori.setAttribute('required', 'required');
            divKelas.style.display = 'none';
            selectKelas.removeAttribute('required');
            selectKelas.value = '';
        }
        
        generateKodeBuku();
    }

    let currentPrefix = '';

    function generateKodeBuku() {
        const sumber = document.getElementById('sumber_buku').value;
        const id_kategori = document.getElementById('id_kategori').value;
        
        if (sumber === 'buku perpus' && !id_kategori) {
            document.getElementById('kode_buku').value = '';
            currentPrefix = '';
            return;
        }

        const url = `{{ route('kperpus.buku.generate-kode') }}?sumber=${encodeURIComponent(sumber)}&id_kategori=${encodeURIComponent(id_kategori)}`;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if(data.code) {
                    document.getElementById('kode_buku').value = data.code;
                    currentPrefix = data.prefix;
                }
            })
            .catch(error => console.error('Error fetching kode buku:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const jenisBukuAwal = document.getElementById('sumber_buku').value;
        pilihJenisBuku(jenisBukuAwal);
        
        document.getElementById('id_kategori').addEventListener('change', generateKodeBuku);

        const kodeInput = document.getElementById('kode_buku');
        kodeInput.addEventListener('keydown', function(e) {
            if (!currentPrefix) return;
            
            const start = this.selectionStart;
            const end = this.selectionEnd;
            
            if (e.ctrlKey || e.metaKey) return;
            if (['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 'Home', 'End', 'Tab'].includes(e.key)) return;

            if (e.key === 'Backspace' && start <= currentPrefix.length && start === end) {
                e.preventDefault();
            }
            if (e.key === 'Delete' && start < currentPrefix.length && start === end) {
                e.preventDefault();
            }
            if (start < currentPrefix.length && end > 0 && e.key.length === 1) {
                e.preventDefault();
            }
        });

        kodeInput.addEventListener('input', function(e) {
            if (!currentPrefix) return;
            if (!this.value.startsWith(currentPrefix)) {
                this.value = currentPrefix;
            }
        });
    });
</script>
@endpush
