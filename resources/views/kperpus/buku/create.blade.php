@extends('kperpus.layouts.app')

@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku Baru')

@push('styles')
<style>
    /* Desain Modern, Bersih, dan Tenang */
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

    .form-input::placeholder {
        color: #94a3b8;
    }

    /* Custom styling khusus select box agar serasi */
    select.form-input {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
        padding-right: 2.5rem;
    }

    .info-bantuan {
        font-size: 0.78rem;
        color: #64748b;
        margin-top: 0.1rem;
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
            <h2>Form Tambah Buku</h2>
            <p style="margin-top: 4px;">Isi formulir di bawah secara lengkap untuk menambah koleksi perpustakaan.</p>
        </div>
        <a href="{{ route('kperpus.buku.index') }}" class="btn-kembali">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('kperpus.buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            
            {{-- Jenis Anggaran --}}
            <div class="form-group">
                <label for="sumber_buku">Sumber Anggaran / Jenis Buku <span>*</span></label>
                <select name="sumber_buku" id="sumber_buku" class="form-input" onchange="pilihJenisBuku(this.value)">
                    <option value="buku perpus" {{ old('sumber_buku', request('sumber_buku')) !== 'bos' ? 'selected' : '' }}>Buku Reguler (Perpustakaan)</option>
                    <option value="bos" {{ old('sumber_buku', request('sumber_buku')) === 'bos' ? 'selected' : '' }}>Buku Paket (Dana BOS)</option>
                </select>
            </div>

            {{-- Input Dinamis: Kategori --}}
            <div class="form-group" id="input-kategori">
                <label for="id_kategori">Kategori Rak Buku <span>*</span></label>
                <select name="id_kategori" id="id_kategori" class="form-input">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori ?? [] as $kat)
                        <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Input Dinamis: Kelas (Sembunyi Default) --}}
            <div class="form-group" id="input-kelas" style="display: none;">
                <label for="kelas">Untuk Siswa Kelas <span>*</span></label>
                <select name="kelas" id="kelas" class="form-input">
                    <option value="">-- Pilih Tingkatan Kelas --</option>
                    <option value="VII" {{ old('kelas') == 'VII' ? 'selected' : '' }}>Kelas VII</option>
                    <option value="VIII" {{ old('kelas') == 'VIII' ? 'selected' : '' }}>Kelas VIII</option>
                    <option value="IX" {{ old('kelas') == 'IX' ? 'selected' : '' }}>Kelas IX</option>
                </select>
            </div>

            {{-- Kode Buku --}}
            <div class="form-group">
                <label for="kode_buku">Kode Registrasi Buku <span>*</span></label>
                <input type="text" name="kode_buku" id="kode_buku" class="form-input" placeholder="Contoh: BKP-001" required value="{{ old('kode_buku') }}">
            </div>

            {{-- ISBN --}}
            <div class="form-group">
                <label for="isbn">Nomor ISBN</label>
                <input type="text" name="isbn" id="isbn" class="form-input" placeholder="Boleh dikosongkan jika tidak ada" value="{{ old('isbn') }}">
            </div>

            {{-- Judul Buku --}}
            <div class="form-group full-width">
                <label for="judul_buku">Judul Buku <span>*</span></label>
                <input type="text" name="judul_buku" id="judul_buku" class="form-input" placeholder="Masukkan judul lengkap buku secara jelas" required value="{{ old('judul_buku') }}">
            </div>

            {{-- Pengarang --}}
            <div class="form-group full-width">
                <label for="pengarang">Nama Pengarang / Penulis <span>*</span></label>
                <input type="text" name="pengarang" id="pengarang" class="form-input" placeholder="Nama penulis asli atau instansi penerbit resmi" required value="{{ old('pengarang') }}">
            </div>

            {{-- Tahun Terbit --}}
            <div class="form-group">
                <label for="tahun_terbit">Tahun Terbit <span>*</span></label>
                <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-input" placeholder="Contoh: 2024" required min="1800" max="{{ date('Y') }}" value="{{ old('tahun_terbit') }}">
            </div>

            {{-- Stok Buku --}}
            <div class="form-group">
                <label for="stok">Jumlah Stok Fisik <span>*</span></label>
                <input type="number" name="stok" id="stok" class="form-input" required min="0" value="{{ old('stok', 1) }}">
            </div>

            {{-- File Sampul --}}
            <div class="form-group full-width">
                <label for="gambar">Foto Sampul Buku</label>
                <input type="file" name="gambar" id="gambar" class="form-input" accept="image/*" style="padding: 0.45rem 0.75rem;">
                <span class="info-bantuan">Format gambar wajib: JPG atau PNG (Ukuran maksimal file 2MB).</span>
            </div>

        </div>

        {{-- Navigasi Bawah --}}
        <div class="form-actions">
            <a href="{{ route('kperpus.buku.index') }}" class="btn btn-batal">Batal</a>
            <button type="submit" class="btn btn-simpan">
                <i class="fas fa-save" style="font-size: 0.85rem;"></i> Simpan Data Buku
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
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
        
        // Cek jika buku perpus belum pilih kategori, kosongkan kode
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
        
        // Pasang event listener untuk kategori
        document.getElementById('id_kategori').addEventListener('change', generateKodeBuku);

        // Mencegah penghapusan prefix pada kode buku
        const kodeInput = document.getElementById('kode_buku');
        kodeInput.addEventListener('keydown', function(e) {
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

        kodeInput.addEventListener('input', function(e) {
            if (!currentPrefix) return;
            if (!this.value.startsWith(currentPrefix)) {
                // If prefix is modified, restore prefix and keep the rest of the string if possible
                let suffix = this.value.substring(this.value.length - (this.value.length - currentPrefix.length + 1)); 
                // A safer fallback:
                this.value = currentPrefix;
            }
        });
    });
</script>
@endpush