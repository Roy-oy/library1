@extends('kperpus.layouts.app')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Data Buku')

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

    .form-input.is-invalid {
        border-color: #ef4444;
    }

    .form-input.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
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

    
    .form-input:disabled {
        background-color: #e2e8f0;
        color: #64748b;
        cursor: not-allowed;
        border-color: #cbd5e1;
    }

    .invalid-feedback {
        font-size: 0.8rem;
        color: #ef4444;
        font-weight: 600;
        margin-top: 0.1rem;
    }

    .info-bantuan {
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.4;
    }

    
    .current-cover-wrap {
        background: #f0f5ff;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        border: 1.5px dashed #bfdbfe;
    }

    .current-cover-wrap img {
        width: 65px;
        height: 90px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #1e3a8a;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    .current-cover-wrap .placeholder-cover {
        width: 65px;
        height: 90px;
        border-radius: 8px;
        background: #dbeafe;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #172554;
        font-size: 1.5rem;
        border: 1px solid #bfdbfe;
    }

    .cover-info strong {
        font-size: 0.925rem;
        color: #1e3a8a;
        display: block;
        margin-bottom: 0.25rem;
    }

    .cover-info p {
        font-size: 0.8rem;
        color: #172554;
        margin: 0;
        opacity: 0.8;
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
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h2>Formulir Edit Buku</h2>
                <p>Perbarui data koleksi perpustakaan secara lengkap. Tanda (<span>*</span>) wajib diisi.</p>
            </div>
        </div>
        <a href="{{ route('kperpus.buku.index') }}" class="btn-kembali">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    
    <div class="form-body">
        <form action="{{ route('kperpus.buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data" id="form-buku">
            @csrf
            @method('PUT')

            <div class="form-grid">
                
                
                <div class="form-group full-width">
                    <label><i class="fas fa-wallet"></i> Sumber Anggaran / Jenis Buku <span>*</span></label>
                    <select class="form-input" disabled>
                        <option value="buku perpus" {{ $buku->sumber_buku === 'buku perpus' ? 'selected' : '' }}>Buku Reguler (Perpustakaan)</option>
                        <option value="bos" {{ $buku->sumber_buku === 'bos' ? 'selected' : '' }}>Buku Paket (Dana BOS)</option>
                    </select>
                    <input type="hidden" name="sumber_buku" id="sumber_buku_hidden" value="{{ $buku->sumber_buku }}">
                    <span class="info-bantuan" style="color: #1e3a8a;"><i class="fas fa-info-circle"></i> Jenis anggaran terkunci untuk menjaga riwayat prefix kode serial.</span>
                </div>

                
                <div class="form-group" id="kategori-group">
                    <label for="id_kategori"><i class="fas fa-tags"></i> Kategori Rak Buku <span>*</span></label>
                    <select name="id_kategori" id="id_kategori" class="form-input @error('id_kategori') is-invalid @enderror" onchange="updateKodeBuku()">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ old('id_kategori', $buku->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                
                <div class="form-group" id="kelas-group" style="display: none;">
                    <label for="kelas"><i class="fas fa-graduation-cap"></i> Untuk Siswa Kelas <span>*</span></label>
                    <select name="kelas" id="kelas" class="form-input @error('kelas') is-invalid @enderror">
                        <option value="">-- Pilih Tingkatan Kelas --</option>
                        <option value="VII" {{ old('kelas', $buku->kelas) === 'VII' ? 'selected' : '' }}>Kelas VII</option>
                        <option value="VIII" {{ old('kelas', $buku->kelas) === 'VIII' ? 'selected' : '' }}>Kelas VIII</option>
                        <option value="IX" {{ old('kelas', $buku->kelas) === 'IX' ? 'selected' : '' }}>Kelas IX</option>
                    </select>
                    @error('kelas')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                
                <div class="form-group">
                    <label for="kode_buku"><i class="fas fa-barcode"></i> Kode Registrasi Buku <span>*</span></label>
                    <input type="text" name="kode_buku" id="kode_buku" class="form-input @error('kode_buku') is-invalid @enderror" placeholder="Contoh: BKP-001" required value="{{ old('kode_buku', $buku->kode_buku) }}">
                    @error('kode_buku')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                
                <div class="form-group">
                    <label for="isbn"><i class="fas fa-book-open"></i> Nomor ISBN</label>
                    <input type="text" name="isbn" id="isbn" class="form-input @error('isbn') is-invalid @enderror" placeholder="Boleh dikosongkan jika tidak ada" maxlength="13" value="{{ old('isbn', $buku->isbn) }}">
                    @error('isbn')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                
                <div class="form-group full-width">
                    <label for="judul_buku"><i class="fas fa-book"></i> Judul Buku <span>*</span></label>
                    <input type="text" name="judul_buku" id="judul_buku" class="form-input @error('judul_buku') is-invalid @enderror" placeholder="Masukkan judul lengkap" required value="{{ old('judul_buku', $buku->judul_buku) }}">
                    @error('judul_buku')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                
                <div class="form-group full-width">
                    <label for="pengarang"><i class="fas fa-user-edit"></i> Nama Pengarang / Penulis <span>*</span></label>
                    <input type="text" name="pengarang" id="pengarang" class="form-input @error('pengarang') is-invalid @enderror" placeholder="Nama penulis" required value="{{ old('pengarang', $buku->pengarang) }}">
                    @error('pengarang')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                
                <div class="form-group">
                    <label for="tahun_terbit"><i class="fas fa-calendar-alt"></i> Tahun Terbit <span>*</span></label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-input @error('tahun_terbit') is-invalid @enderror" placeholder="Contoh: 2024" required min="1800" max="{{ date('Y') }}" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                    @error('tahun_terbit')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                
                <div class="form-group">
                    <label for="stok"><i class="fas fa-layer-group"></i> Jumlah Stok Fisik <span>*</span></label>
                    <input type="number" name="stok" id="stok" class="form-input @error('stok') is-invalid @enderror" required min="0" value="{{ old('stok', $buku->stok) }}">
                    @error('stok')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                
                <div class="form-group">
                    <label for="rak"><i class="fas fa-archive"></i> Lokasi Rak</label>
                    <input type="text" name="rak" id="rak" class="form-input @error('rak') is-invalid @enderror" placeholder="Contoh: R-01, A-1" value="{{ old('rak', $buku->rak) }}">
                    @error('rak')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                
                <div class="full-width">
                    <div class="current-cover-wrap">
                        @if($buku->gambar)
                            <img src="{{ Storage::url($buku->gambar) }}" alt="Cover Buku">
                            <div class="cover-info">
                                <strong>Cover Buku Aktif Saat Ini</strong>
                                <p>File cover terunggah di sistem. Biarkan kosong jika tidak ingin mengubahnya.</p>
                            </div>
                        @else
                            <div class="placeholder-cover"><i class="fas fa-image"></i></div>
                            <div class="cover-info">
                                <strong>Belum Ada Sampul</strong>
                                <p>Gunakan form di bawah apabila ingin menambahkan foto sampul baru.</p>
                            </div>
                        @endif
                    </div>
                </div>

                
                <div class="form-group full-width">
                    <label for="gambar"><i class="fas fa-image"></i> Ganti / Upload Cover Baru</label>
                    <input type="file" name="gambar" id="gambar" class="form-input @error('gambar') is-invalid @enderror" accept="image/*">
                    <span class="info-bantuan">Format gambar wajib: JPG, JPEG, atau PNG (Ukuran maksimal file 2MB).</span>
                    @error('gambar')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            
            <div class="form-actions">
                <a href="{{ route('kperpus.buku.index') }}" class="btn btn-batal">Batal</a>
                <button type="submit" class="btn btn-simpan">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const isBos = '{{ $buku->sumber_buku === "bos" ? "true" : "false" }}' === 'true';
    const kelasGroup  = document.getElementById('kelas-group');
    const katGroup    = document.getElementById('kategori-group');

    function toggleFields() {
        if (isBos) {
            kelasGroup.style.display = 'flex';
            katGroup.style.display   = 'none';
        } else {
            kelasGroup.style.display = 'none';
            katGroup.style.display   = 'flex';
        }
    }

    let currentPrefix = '{{ App\Models\Buku::getPrefix($buku->sumber_buku, $buku->id_kategori) }}';

    function updateKodeBuku() {
        if (isBos) return;
        const sumber = 'buku perpus';
        const kategoriId = document.getElementById('id_kategori').value;
        
        fetch(`{{ route('kperpus.buku.generate-kode') }}?sumber=${encodeURIComponent(sumber)}&id_kategori=${encodeURIComponent(kategoriId)}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.code) {
                    currentPrefix = data.prefix;
                    document.getElementById('kode_buku').value = data.code;
                }
            })
            .catch(err => console.error('Error fetching generated code:', err));
    }

    const kodeBukuInput = document.getElementById('kode_buku');
    
    kodeBukuInput.addEventListener('keydown', function(e) {
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

    kodeBukuInput.addEventListener('input', function(e) {
        if (!currentPrefix) return;
        if (!this.value.startsWith(currentPrefix)) {
            this.value = currentPrefix;
        }
    });

    toggleFields();
</script>
@endpush