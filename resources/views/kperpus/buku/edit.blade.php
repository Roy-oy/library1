@extends('kperpus.layouts.app')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Data Buku')

@push('styles')
<style>
    /* Desain Modern, Bersih, dan Tenang (Selaras dengan Create) */
    .simple-container {
        max-width: 800px;
        margin: 1rem auto 2.5rem auto;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 2.5rem;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 1.25rem;
        margin-bottom: 2rem;
    }

    .form-header h2 {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 700;
        color: #1e293b;
    }

    .form-header p {
        margin: 0.35rem 0 0 0;
        font-size: 0.88rem;
        color: #64748b;
    }

    .btn-kembali {
        text-decoration: none;
        color: #475569;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        padding: 0.5rem 0.9rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s ease;
    }

    .btn-kembali:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
    }

    /* Form Grid Standar */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .full-width {
        grid-column: span 2;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group label span {
        color: #ef4444;
        margin-left: 2px;
    }

    /* Input Modern Ringan */
    .form-input {
        padding: 0.65rem 0.85rem;
        font-size: 0.9rem;
        font-family: inherit;
        border: 1.5px solid #cbd5e1;
        border-radius: 6px;
        color: #1e293b;
        background-color: #fff;
        outline: none;
        transition: all 0.15s ease;
    }

    .form-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
    }

    .form-input.is-invalid {
        border-color: #ef4444;
    }

    .form-input.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
    }

    /* Custom select styling */
    select.form-input {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
        padding-right: 2.5rem;
    }

    /* Locked state on edit */
    .form-input:disabled {
        background-color: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
        border-color: #cbd5e1;
    }

    .invalid-feedback {
        font-size: 0.78rem;
        color: #ef4444;
        font-weight: 600;
        margin-top: 0.1rem;
    }

    .info-bantuan {
        font-size: 0.78rem;
        color: #64748b;
        margin-top: 0.1rem;
    }

    /* Preview Cover Wrap */
    .current-cover-wrap {
        background: #f8fafc;
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1.2rem;
        border: 1.5px solid #e2e8f0;
    }

    .current-cover-wrap img {
        width: 55px;
        height: 75px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
    }

    .current-cover-wrap .placeholder-cover {
        width: 55px;
        height: 75px;
        border-radius: 6px;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 1.2rem;
    }

    .cover-info strong {
        font-size: 0.88rem;
        color: #1e293b;
        display: block;
        margin-bottom: 0.15rem;
    }

    .cover-info p {
        font-size: 0.78rem;
        color: #64748b;
        margin: 0;
    }

    /* Tombol Aksi */
    .form-actions {
        margin-top: 2.5rem;
        padding-top: 1.25rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 0.85rem;
    }

    .btn {
        padding: 0.65rem 1.5rem;
        font-size: 0.9rem;
        font-weight: 700;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.15s ease;
    }

    .btn-batal {
        background: #ffffff;
        color: #475569;
        border: 1.5px solid #cbd5e1;
    }

    .btn-batal:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .btn-simpan {
        background: #2563eb;
        color: #ffffff;
        border: 1px solid #2563eb;
    }

    .btn-simpan:hover {
        background: #1d4ed8;
        opacity: 0.95;
    }

    @media (max-width: 600px) {
        .simple-container { padding: 1.5rem; margin: 1rem; }
        .form-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
        .btn-kembali { width: 100%; justify-content: center; }
        .form-grid { grid-template-columns: 1fr; gap: 1.1rem; }
        .full-width { grid-column: span 1; }
        .form-actions { flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="simple-container">
    
    <div class="form-header">
        <div>
            <h2>Formulir Edit Buku</h2>
            <p style="margin-top: 4px;">Perbarui data koleksi perpustakaan. Tanda (<span>*</span>) wajib diisi.</p>
        </div>
        <a href="{{ route('kperpus.buku.index') }}" class="btn-kembali">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('kperpus.buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data" id="form-buku">
        @csrf
        @method('PUT')

        <div class="form-grid">
            
            {{-- Sumber Buku (Locked/Disabled on Edit view) --}}
            <div class="form-group full-width">
                <label>Sumber Anggaran / Jenis Buku <span>*</span></label>
                <select class="form-input" disabled>
                    <option value="buku perpus" {{ $buku->sumber_buku === 'buku perpus' ? 'selected' : '' }}>Buku Reguler (Perpustakaan)</option>
                    <option value="bos" {{ $buku->sumber_buku === 'bos' ? 'selected' : '' }}>Buku Paket (Dana BOS)</option>
                </select>
                <input type="hidden" name="sumber_buku" id="sumber_buku_hidden" value="{{ $buku->sumber_buku }}">
                <span class="info-bantuan" style="color: #3b82f6;"><i class="fas fa-info-circle"></i> Jenis anggaran terkunci untuk menjaga riwayat prefix kode serial.</span>
            </div>

            {{-- Input Dinamis: Kategori (Hanya tampil jika buku perpus) --}}
            <div class="form-group" id="kategori-group">
                <label for="id_kategori">Kategori Rak Buku <span>*</span></label>
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

            {{-- Input Dinamis: Kelas (Hanya tampil jika dana BOS) --}}
            <div class="form-group" id="kelas-group" style="display: none;">
                <label for="kelas">Untuk Siswa Kelas <span>*</span></label>
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

            {{-- Kode Buku --}}
            <div class="form-group">
                <label for="kode_buku">Kode Registrasi Buku <span>*</span></label>
                <input type="text" name="kode_buku" id="kode_buku" class="form-input @error('kode_buku') is-invalid @enderror" placeholder="Contoh: BKP-001" required value="{{ old('kode_buku', $buku->kode_buku) }}">
                @error('kode_buku')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- ISBN --}}
            <div class="form-group">
                <label for="isbn">Nomor ISBN</label>
                <input type="text" name="isbn" id="isbn" class="form-input @error('isbn') is-invalid @enderror" placeholder="Boleh dikosongkan" maxlength="13" value="{{ old('isbn', $buku->isbn) }}">
                @error('isbn')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Judul Buku --}}
            <div class="form-group full-width">
                <label for="judul_buku">Judul Buku <span>*</span></label>
                <input type="text" name="judul_buku" id="judul_buku" class="form-input @error('judul_buku') is-invalid @enderror" placeholder="Masukkan judul lengkap" required value="{{ old('judul_buku', $buku->judul_buku) }}">
                @error('judul_buku')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Pengarang --}}
            <div class="form-group full-width">
                <label for="pengarang">Nama Pengarang / Penulis <span>*</span></label>
                <input type="text" name="pengarang" id="pengarang" class="form-input @error('pengarang') is-invalid @enderror" placeholder="Nama penulis" required value="{{ old('pengarang', $buku->pengarang) }}">
                @error('pengarang')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tahun Terbit --}}
            <div class="form-group">
                <label for="tahun_terbit">Tahun Terbit <span>*</span></label>
                <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-input @error('tahun_terbit') is-invalid @enderror" placeholder="Contoh: 2024" required min="1800" max="{{ date('Y') }}" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                @error('tahun_terbit')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Stok Buku --}}
            <div class="form-group">
                <label for="stok">Jumlah Stok Fisik <span>*</span></label>
                <input type="number" name="stok" id="stok" class="form-input @error('stok') is-invalid @enderror" required min="0" value="{{ old('stok', $buku->stok) }}">
                @error('stok')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            {{-- Preview Cover Aktif Saat Ini --}}
            <div class="full-width">
                <div class="current-cover-wrap">
                    @if($buku->gambar)
                        <img src="{{ Storage::url($buku->gambar) }}" alt="Cover Buku">
                        <div class="cover-info">
                            <strong>Cover Buku Aktif Saat Ini</strong>
                            <p>File cover terunggah di sistem. Biarkan kosong jika tidak ingin merubahnya.</p>
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

            {{-- File Sampul Baru --}}
            <div class="form-group full-width">
                <label for="gambar">Ganti / Upload Cover Baru</label>
                <input type="file" name="gambar" id="gambar" class="form-input @error('gambar') is-invalid @enderror" accept="image/*" style="padding: 0.45rem 0.75rem;">
                <span class="info-bantuan">Format gambar wajib: JPG atau PNG (Ukuran maksimal file 2MB).</span>
                @error('gambar')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>

        {{-- Navigasi Bawah --}}
        <div class="form-actions">
            <a href="{{ route('kperpus.buku.index') }}" class="btn btn-batal">Batal</a>
            <button type="submit" class="btn btn-simpan">
                <i class="fas fa-save" style="font-size: 0.85rem;"></i> Simpan Perubahan
            </button>
        </div>

    </form>
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
        
        // Allow copy, select all, etc.
        if (e.ctrlKey || e.metaKey) return;
        
        // Allow navigation keys
        if (['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 'Home', 'End', 'Tab'].includes(e.key)) return;

        // Prevent deleting within prefix
        if (e.key === 'Backspace' && start <= currentPrefix.length && start === end) {
            e.preventDefault();
        }
        if (e.key === 'Delete' && start < currentPrefix.length && start === end) {
            e.preventDefault();
        }
        // Prevent selection/replacement that touches the prefix
        if (start < currentPrefix.length && end > 0 && e.key.length === 1) {
            e.preventDefault();
        }
    });

    kodeBukuInput.addEventListener('input', function(e) {
        if (!currentPrefix) return;
        if (!this.value.startsWith(currentPrefix)) {
            // A safer fallback to prevent prefix loss
            this.value = currentPrefix;
        }
    });

    // Inisialisasi awal saat dimuat
    toggleFields();
</script>
@endpush