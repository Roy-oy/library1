@extends('kperpus.layouts.app')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Data Buku')

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
        background: linear-gradient(135deg, #1a6b3c, var(--success));
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: .9rem; flex-shrink: 0;
    }
    .form-card-header h2 { font-size: .95rem; font-weight: 700; color: var(--text); }
    .form-card-header p  { font-size: .78rem; color: var(--text-muted); margin-top: .1rem; }

    /* ── Current cover panel ── */
    .current-cover-wrap {
        background: var(--bg); border-radius: 10px;
        padding: 1rem; display: flex; align-items: center; gap: 1rem;
        margin-bottom: 1rem; border: 1px solid var(--border);
    }
    .current-cover-wrap img {
        width: 60px; height: 80px;
        object-fit: cover; border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,.1);
    }
    .current-cover-wrap .placeholder-cover {
        width: 60px; height: 80px; border-radius: 8px;
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        display: flex; align-items: center; justify-content: center;
        color: rgba(255,255,255,.6); font-size: 1.3rem;
    }
    .current-cover-wrap .cover-info { flex: 1; }
    .current-cover-wrap .cover-info strong { font-size: .85rem; color: var(--text); }
    .current-cover-wrap .cover-info p     { font-size: .77rem; color: var(--text-muted); margin-top: .15rem; }

    .form-body { padding: 1.6rem; }

    /* ── Grid ── */
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
        border-color: var(--success);
        box-shadow: 0 0 0 3px rgba(39,174,96,.1);
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

    /* ── Action Buttons ── */
    .form-actions {
        display: flex; align-items: center; gap: .8rem;
        padding: 1.2rem 1.6rem;
        border-top: 1px solid var(--border);
        background: #fafbfc;
    }
    .btn-submit {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.4rem;
        background: var(--success); color: #fff;
        border: none; border-radius: 8px;
        font-family: inherit; font-size: .88rem; font-weight: 700;
        cursor: pointer; transition: background .2s, transform .15s;
    }
    .btn-submit:hover { background: #1e8449; transform: translateY(-1px); }
    .btn-cancel-link {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.1rem;
        background: var(--bg); color: var(--text-muted);
        border: 1px solid var(--border); border-radius: 8px;
        font-family: inherit; font-size: .88rem; font-weight: 600;
        cursor: pointer; text-decoration: none;
        transition: background .15s;
    }
    .btn-cancel-link:hover { background: #e8edf2; }

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
    <h1>Edit Buku — <em style="font-weight:400;color:var(--text-muted)">{{ $buku->judul_buku }}</em></h1>
</div>

<div class="form-card">
    <div class="form-card-header">
        <div class="hdr-icon"><i class="fas fa-book-open"></i></div>
        <div>
            <h2>Formulir Edit Buku</h2>
            <p>Perbarui data buku sesuai kebutuhan. Field bertanda (<span style="color:var(--danger)">*</span>) wajib diisi.</p>
        </div>
    </div>

    <form action="{{ route('kperpus.buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data" id="form-buku">
        @csrf
        @method('PUT')

        <div class="form-body">
            <div class="form-grid">

                {{-- ── Identitas Buku ─────────────────── --}}
                <div class="section-title">Identitas Buku</div>

                {{-- Kode Buku --}}
                <div class="form-group">
                    <label for="kode_buku">Kode Buku <span class="req">*</span></label>
                    <input type="text" id="kode_buku" name="kode_buku"
                           class="form-control @error('kode_buku') is-invalid @enderror"
                           value="{{ old('kode_buku', $buku->kode_buku) }}" placeholder="Contoh: BK-0001" required>
                    @error('kode_buku')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- ISBN --}}
                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn"
                           class="form-control @error('isbn') is-invalid @enderror"
                           value="{{ old('isbn', $buku->isbn) }}" placeholder="Opsional, maks 13 karakter" maxlength="13">
                    @error('isbn')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Judul Buku --}}
                <div class="form-group full">
                    <label for="judul_buku">Judul Buku <span class="req">*</span></label>
                    <input type="text" id="judul_buku" name="judul_buku"
                           class="form-control @error('judul_buku') is-invalid @enderror"
                           value="{{ old('judul_buku', $buku->judul_buku) }}" placeholder="Masukkan judul buku" required>
                    @error('judul_buku')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Pengarang --}}
                <div class="form-group">
                    <label for="pengarang">Pengarang <span class="req">*</span></label>
                    <input type="text" id="pengarang" name="pengarang"
                           class="form-control @error('pengarang') is-invalid @enderror"
                           value="{{ old('pengarang', $buku->pengarang) }}" placeholder="Nama pengarang" required>
                    @error('pengarang')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Tahun Terbit --}}
                <div class="form-group">
                    <label for="tahun_terbit">Tahun Terbit <span class="req">*</span></label>
                    <input type="number" id="tahun_terbit" name="tahun_terbit"
                           class="form-control @error('tahun_terbit') is-invalid @enderror"
                           value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                           placeholder="Contoh: 2023" min="1900" max="{{ date('Y') }}" required>
                    @error('tahun_terbit')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- ── Sumber & Klasifikasi ─────────────────── --}}
                <hr class="section-divider">
                <div class="section-title">Sumber & Klasifikasi</div>

                {{-- Sumber Buku (Locked on Edit) --}}
                <div class="form-group full">
                    <label>Sumber Buku <span class="req">*</span></label>
                    <div style="display:flex; gap: 1.5rem; margin-top: .2rem;">
                        <label style="display:flex; align-items:center; gap:.5rem; font-weight:600; cursor:not-allowed; opacity: 0.7;">
                            <input type="radio" name="sumber_buku_disabled" value="bos" 
                                   {{ $buku->sumber_buku === 'bos' ? 'checked' : '' }} disabled>
                            Buku BOS (Bantuan Operasional Sekolah)
                        </label>
                        <label style="display:flex; align-items:center; gap:.5rem; font-weight:600; cursor:not-allowed; opacity: 0.7;">
                            <input type="radio" name="sumber_buku_disabled" value="buku perpus" 
                                   {{ $buku->sumber_buku === 'buku perpus' ? 'checked' : '' }} disabled>
                            Buku Perpus (Koleksi Umum)
                        </label>
                    </div>
                    <input type="hidden" name="sumber_buku" value="{{ $buku->sumber_buku }}">
                    <span class="form-hint" style="margin-top: 0.25rem;">
                        <i class="fas fa-info-circle" style="color: var(--primary);"></i> Sumber buku tidak dapat diubah setelah buku dibuat untuk menjaga konsistensi kode prefix.
                    </span>
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
                                    {{ old('id_kategori', $buku->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
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
                        <option value="VII"  {{ old('kelas', $buku->kelas) === 'VII'  ? 'selected' : '' }}>Kelas VII</option>
                        <option value="VIII" {{ old('kelas', $buku->kelas) === 'VIII' ? 'selected' : '' }}>Kelas VIII</option>
                        <option value="IX"   {{ old('kelas', $buku->kelas) === 'IX'   ? 'selected' : '' }}>Kelas IX</option>
                    </select>
                    @error('kelas')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Stok --}}
                <div class="form-group">
                    <label for="stok">Stok <span class="req">*</span></label>
                    <input type="number" id="stok" name="stok"
                           class="form-control @error('stok') is-invalid @enderror"
                           value="{{ old('stok', $buku->stok) }}" min="1" required>
                    @error('stok')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <hr class="section-divider">
                <div class="section-title">Cover Buku</div>

                {{-- Cover saat ini --}}
                <div class="full">
                    <div class="current-cover-wrap">
                        @if($buku->gambar)
                            <img src="{{ Storage::url($buku->gambar) }}" alt="Cover saat ini">
                            <div class="cover-info">
                                <strong>Cover Saat Ini</strong>
                                <p>Unggah gambar baru untuk mengganti cover. Biarkan kosong untuk mempertahankan.</p>
                            </div>
                        @else
                            <div class="placeholder-cover"><i class="fas fa-image"></i></div>
                            <div class="cover-info">
                                <strong>Belum ada cover</strong>
                                <p>Unggah gambar cover buku (JPG, JPEG, PNG, maks. 2 MB).</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Gambar baru --}}
                <div class="form-group full img-preview-wrap">
                    <label for="gambar">Ganti Cover / Gambar</label>
                    <input type="file" id="gambar" name="gambar" accept="image/jpg,image/jpeg,image/png"
                           class="form-control @error('gambar') is-invalid @enderror"
                           onchange="previewImage(this)">
                    <span class="form-hint">Format: JPG, JPEG, PNG. Maks. 2 MB</span>
                    @error('gambar')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                    <img id="img-preview" class="img-preview" src="#" alt="Preview cover baru">
                </div>

            </div>{{-- .form-grid --}}
        </div>{{-- .form-body --}}

        <div class="form-actions">
            <button type="submit" class="btn-submit" id="btn-update">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('kperpus.buku.index') }}" class="btn-cancel-link">
                <i class="fas fa-times"></i> Batal
            </a>
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

    // Init on load
    toggleFields();

    // Enforce immutable prefix for kode_buku (BOS- or BP-)
    const prefix = isBos ? 'BOS-' : 'BP-';
    const kodeBukuInput = document.getElementById('kode_buku');
    
    kodeBukuInput.addEventListener('input', function() {
        if (!this.value.startsWith(prefix)) {
            let valWithoutPrefix = this.value.replace(/^(BOS-|BP-)/, '');
            valWithoutPrefix = valWithoutPrefix.replaceAll('BOS-', '').replaceAll('BP-', '');
            this.value = prefix + valWithoutPrefix;
        }
    });

    kodeBukuInput.addEventListener('keydown', function(e) {
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
</script>
@endpush
