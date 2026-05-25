@extends('kperpus.layouts.app')

@section('title', 'Tambah Buku')
@section('page-title', 'Tambah Buku Baru')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; gap: .8rem;
        margin-bottom: 1.5rem;
    }
    .page-header a {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 8px;
        background: var(--surface); border: 1px solid var(--border);
        color: var(--text-muted); text-decoration: none;
        transition: background .15s;
    }
    .page-header a:hover { background: var(--bg); }
    .page-header h1 { font-size: 1.2rem; font-weight: 800; color: var(--text); }

    /* ── Form Card ── */
    .form-card {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        max-width: 860px;
    }
    .form-card-header {
        padding: 1.1rem 1.6rem;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: .7rem;
    }
    .form-card-header .hdr-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: .9rem; flex-shrink: 0;
    }
    .form-card-header h2 { font-size: .95rem; font-weight: 700; color: var(--text); }
    .form-card-header p  { font-size: .78rem; color: var(--text-muted); margin-top: .1rem; }

    .form-body { padding: 1.6rem; }

    /* ── Grid layout ── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.1rem;
    }
    .form-grid .full { grid-column: 1 / -1; }

    .form-group { display: flex; flex-direction: column; gap: .35rem; }
    .form-group label {
        font-size: .8rem; font-weight: 700; color: var(--text);
        display: flex; align-items: center; gap: .3rem;
    }
    .form-group label .req { color: var(--danger); }

    .form-control {
        width: 100%; padding: .6rem .85rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: inherit; font-size: .88rem; color: var(--text);
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(26,60,94,.1);
    }
    .form-control.is-invalid { border-color: var(--danger); }
    .invalid-feedback {
        font-size: .77rem; color: var(--danger);
        display: flex; align-items: center; gap: .3rem;
    }
    .form-hint { font-size: .76rem; color: var(--text-muted); }

    /* ── Image preview ── */
    .img-preview-wrap { position: relative; }
    .img-preview {
        width: 100%; max-height: 180px; object-fit: cover;
        border-radius: 8px; border: 1.5px solid var(--border);
        display: none; margin-top: .5rem;
    }
    .img-preview.show { display: block; }

    /* ── Kelas field (conditional) ── */
    #kelas-group { transition: opacity .25s; }
    #kelas-group.hidden { opacity: .3; pointer-events: none; }

    /* ── Divider ── */
    .section-divider {
        grid-column: 1 / -1;
        border: none; border-top: 1px solid var(--border);
        margin: .4rem 0;
    }
    .section-title {
        grid-column: 1 / -1;
        font-size: .72rem; font-weight: 700; letter-spacing: .8px;
        text-transform: uppercase; color: var(--text-muted);
    }

    /* ── Action buttons ── */
    .form-actions {
        display: flex; align-items: center; gap: .8rem;
        padding: 1.2rem 1.6rem;
        border-top: 1px solid var(--border);
        background: #fafbfc;
    }
    .btn-submit {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.4rem;
        background: var(--primary); color: #fff;
        border: none; border-radius: 8px;
        font-family: inherit; font-size: .88rem; font-weight: 700;
        cursor: pointer; transition: background .2s, transform .15s;
    }
    .btn-submit:hover { background: var(--primary-dark); transform: translateY(-1px); }
    .btn-reset {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.1rem;
        background: var(--bg); color: var(--text-muted);
        border: 1px solid var(--border); border-radius: 8px;
        font-family: inherit; font-size: .88rem; font-weight: 600;
        cursor: pointer; transition: background .15s;
    }
    .btn-reset:hover { background: #e8edf2; }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-grid .full { grid-column: 1; }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <a href="{{ route('kperpus.buku.index') }}" title="Kembali">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1>Tambah Buku Baru</h1>
</div>

<div class="form-card">
    <div class="form-card-header">
        <div class="hdr-icon"><i class="fas fa-book-medical"></i></div>
        <div>
            <h2>Formulir Tambah Buku</h2>
            <p>Isi seluruh field yang wajib diisi (<span style="color:var(--danger)">*</span>)</p>
        </div>
    </div>

    <form action="{{ route('kperpus.buku.store') }}" method="POST" enctype="multipart/form-data" id="form-buku">
        @csrf

        <div class="form-body">
            <div class="form-grid">

                {{-- ── Identitas Buku ─────────────────── --}}
                <div class="section-title">Identitas Buku</div>

                {{-- Kode Buku --}}
                <div class="form-group">
                    <label for="kode_buku">Kode Buku <span class="req">*</span></label>
                    <input type="text" id="kode_buku" name="kode_buku"
                           class="form-control @error('kode_buku') is-invalid @enderror"
                           value="{{ old('kode_buku') }}" placeholder="Contoh: BK-0001" required>
                    @error('kode_buku')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- ISBN --}}
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn"
                           class="form-control @error('isbn') is-invalid @enderror"
                           value="{{ old('isbn') }}" placeholder="Opsional, maks 13 karakter" maxlength="13">
                    @error('isbn')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Judul Buku --}}
                <div class="form-group full">
                    <label for="judul_buku">Judul Buku <span class="req">*</span></label>
                    <input type="text" id="judul_buku" name="judul_buku"
                           class="form-control @error('judul_buku') is-invalid @enderror"
                           value="{{ old('judul_buku') }}" placeholder="Masukkan judul buku" required>
                    @error('judul_buku')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Pengarang --}}
                <div class="form-group">
                    <label for="pengarang">Pengarang <span class="req">*</span></label>
                    <input type="text" id="pengarang" name="pengarang"
                           class="form-control @error('pengarang') is-invalid @enderror"
                           value="{{ old('pengarang') }}" placeholder="Nama pengarang" required>
                    @error('pengarang')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Tahun Terbit --}}
                <div class="form-group">
                    <label for="tahun_terbit">Tahun Terbit <span class="req">*</span></label>
                    <input type="number" id="tahun_terbit" name="tahun_terbit"
                           class="form-control @error('tahun_terbit') is-invalid @enderror"
                           value="{{ old('tahun_terbit') }}"
                           placeholder="Contoh: 2023" min="1900" max="{{ date('Y') }}" required>
                    @error('tahun_terbit')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- ── Sumber & Klasifikasi ─────────────────── --}}
                <hr class="section-divider">
                <div class="section-title">Sumber & Klasifikasi</div>

                {{-- Sumber Buku --}}
                <div class="form-group full">
                    <label>Sumber Buku <span class="req">*</span></label>
                    <div style="display:flex; gap: 1.5rem; margin-top: .2rem;">
                        <label style="display:flex; align-items:center; gap:.5rem; font-weight:600; cursor:pointer;">
                            <input type="radio" name="sumber_buku" value="bos" 
                                   {{ old('sumber_buku', $preSelectedSource) === 'bos' ? 'checked' : '' }} required>
                            Buku BOS (Bantuan Operasional Sekolah)
                        </label>
                        <label style="display:flex; align-items:center; gap:.5rem; font-weight:600; cursor:pointer;">
                            <input type="radio" name="sumber_buku" value="buku perpus" 
                                   {{ old('sumber_buku', $preSelectedSource ?? 'buku perpus') === 'buku perpus' ? 'checked' : '' }} required>
                            Buku Perpus (Koleksi Umum)
                        </label>
                    </div>
                    @error('sumber_buku')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Kategori (only for Buku Perpus) --}}
                <div class="form-group" id="kategori-group">
                    <label for="id_kategori">Kategori <span class="req">*</span></label>
                    <select id="id_kategori" name="id_kategori"
                            class="form-control @error('id_kategori') is-invalid @enderror">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}"
                                    {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Kelas (only for Buku BOS) --}}
                <div class="form-group" id="kelas-group">
                    <label for="kelas">Kelas <span class="req">*</span></label>
                    <select id="kelas" name="kelas"
                            class="form-control @error('kelas') is-invalid @enderror">
                        <option value="">— Pilih Kelas —</option>
                        <option value="VII"  {{ old('kelas') === 'VII'  ? 'selected' : '' }}>Kelas VII</option>
                        <option value="VIII" {{ old('kelas') === 'VIII' ? 'selected' : '' }}>Kelas VIII</option>
                        <option value="IX"   {{ old('kelas') === 'IX'   ? 'selected' : '' }}>Kelas IX</option>
                    </select>
                    @error('kelas')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Stok --}}
                <div class="form-group">
                    <label for="stok">Stok Awal <span class="req">*</span></label>
                    <input type="number" id="stok" name="stok"
                           class="form-control @error('stok') is-invalid @enderror"
                           value="{{ old('stok', 1) }}" min="1" required>
                    @error('stok')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <hr class="section-divider">
                <div class="section-title">Cover Buku</div>

                {{-- Gambar --}}
                <div class="form-group full img-preview-wrap">
                    <label for="gambar">Cover / Gambar Buku</label>
                    <input type="file" id="gambar" name="gambar" accept="image/jpg,image/jpeg,image/png"
                           class="form-control @error('gambar') is-invalid @enderror"
                           onchange="previewImage(this)">
                    <span class="form-hint">Format: JPG, JPEG, PNG. Maks. 2 MB</span>
                    @error('gambar')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                    <img id="img-preview" class="img-preview" src="#" alt="Preview cover">
                </div>

            </div>{{-- .form-grid --}}
        </div>{{-- .form-body --}}

        <div class="form-actions">
            <button type="submit" class="btn-submit" id="btn-simpan">
                <i class="fas fa-save"></i> Simpan Buku
            </button>
            <button type="reset" class="btn-reset" onclick="resetPreview()">
                <i class="fas fa-undo"></i> Reset
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    const radioBos    = document.querySelector('input[name="sumber_buku"][value="bos"]');
    const radioPerpus = document.querySelector('input[name="sumber_buku"][value="buku perpus"]');
    const kelasGroup  = document.getElementById('kelas-group');
    const katGroup    = document.getElementById('kategori-group');

    function toggleFields() {
        if (radioBos.checked) {
            kelasGroup.style.display = 'flex';
            katGroup.style.display   = 'none';
            document.getElementById('id_kategori').value = '';
        } else {
            kelasGroup.style.display = 'none';
            katGroup.style.display   = 'flex';
            document.getElementById('kelas').value = '';
        }
    }

    function updateKodeBuku() {
        const checkedRadio = document.querySelector('input[name="sumber_buku"]:checked');
        if (!checkedRadio) return;
        const sumber = checkedRadio.value;
        
        fetch(`{{ route('kperpus.buku.generate-kode') }}?sumber=${encodeURIComponent(sumber)}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.code) {
                    document.getElementById('kode_buku').value = data.code;
                }
            })
            .catch(err => console.error('Error fetching generated code:', err));
    }

    radioBos.addEventListener('change', () => {
        toggleFields();
        updateKodeBuku();
    });
    radioPerpus.addEventListener('change', () => {
        toggleFields();
        updateKodeBuku();
    });

    // Init on load
    toggleFields();
    if (!document.getElementById('kode_buku').value) {
        updateKodeBuku();
    }

    // Enforce dynamic immutable prefix for kode_buku (BOS- or BP-) based on active source selection
    function getPrefix() {
        const checkedRadio = document.querySelector('input[name="sumber_buku"]:checked');
        return checkedRadio && checkedRadio.value === 'bos' ? 'BOS-' : 'BP-';
    }

    const kodeBukuInput = document.getElementById('kode_buku');
    
    kodeBukuInput.addEventListener('input', function() {
        const prefix = getPrefix();
        if (!this.value.startsWith(prefix)) {
            let valWithoutPrefix = this.value.replace(/^(BOS-|BP-)/, '');
            valWithoutPrefix = valWithoutPrefix.replaceAll('BOS-', '').replaceAll('BP-', '');
            this.value = prefix + valWithoutPrefix;
        }
    });

    kodeBukuInput.addEventListener('keydown', function(e) {
        const prefix = getPrefix();
        const start = this.selectionStart;
        const end = this.selectionEnd;
        
        if (e.key === 'Backspace' && start <= prefix.length && end === start) {
            e.preventDefault();
        }
        if (e.key === 'Delete' && start < prefix.length) {
            e.preventDefault();
        }
    });

    function previewImage(input) {
        const preview = document.getElementById('img-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.add('show');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetPreview() {
        const preview = document.getElementById('img-preview');
        preview.src = '#';
        preview.classList.remove('show');
        setTimeout(toggleFields, 10);
    }
</script>
@endpush
