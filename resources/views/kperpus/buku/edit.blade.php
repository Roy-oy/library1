@extends('kperpus.layouts.app')

@section('title', 'Edit Buku')
@section('page-title', 'Edit Data Buku')

@push('styles')
<style>
    /* ── Theme variables for this view ── */
    :root {
        --theme-primary: #2563eb;
        --theme-primary-light: #eff6ff;
        --theme-primary-hover: #1d4ed8;
        --theme-info: #0ea5e9;
        --theme-info-light: #f0f9ff;
        --theme-success: #10b981;
        --theme-success-light: #ecfdf5;
        --theme-warning: #f59e0b;
        --theme-warning-light: #fffbeb;
        --theme-danger: #ef4444;
        --card-radius: 16px;
        --transition-speed: 0.25s;
    }

    .page-header {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 2rem;
    }
    .page-header a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--surface);
        border: 1.5px solid var(--border);
        color: var(--text-muted);
        text-decoration: none;
        transition: all var(--transition-speed) ease;
    }
    .page-header a:hover {
        background: var(--theme-primary-light);
        color: var(--primary);
        border-color: var(--primary);
        transform: translateX(-2px);
    }
    .page-header h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.5px;
    }

    /* ── Single Column Layout ── */
    .layout-grid {
        max-width: 800px;
        margin: 0 auto;
    }

    /* ── Form Card ── */
    .form-card {
        background: var(--surface);
        border-radius: var(--card-radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(228, 233, 240, 0.6);
        overflow: hidden;
    }
    .form-card-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #fafbfc;
    }
    .form-card-header .hdr-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--theme-success), #059669);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.1rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
    }
    .form-card-header h2 {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--text);
    }
    .form-card-header p {
        font-size: 0.82rem;
        color: var(--text-muted);
        margin-top: 0.15rem;
    }

    /* ── Current cover info ── */
    .current-cover-wrap {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.2rem;
        display: flex;
        align-items: center;
        gap: 1.2rem;
        margin-bottom: 0.5rem;
        border: 1.5px solid var(--border);
    }
    .current-cover-wrap img {
        width: 60px;
        height: 82px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: 1px solid var(--border);
    }
    .current-cover-wrap .placeholder-cover {
        width: 60px;
        height: 82px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,0.7);
        font-size: 1.4rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .current-cover-wrap .cover-info {
        flex: 1;
    }
    .current-cover-wrap .cover-info strong {
        font-size: 0.88rem;
        color: var(--text);
        display: block;
        margin-bottom: 0.2rem;
    }
    .current-cover-wrap .cover-info p {
        font-size: 0.78rem;
        color: var(--text-muted);
        line-height: 1.4;
    }

    .form-body {
        padding: 1.8rem;
    }

    /* ── Form elements ── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }
    .form-grid .full {
        grid-column: 1 / -1;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
    }
    .form-group label {
        font-size: 0.82rem;
        font-weight: 800;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .form-group label i {
        color: var(--primary);
        font-size: 0.85rem;
    }
    .form-group label .req {
        color: var(--danger);
    }

    .form-control-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .form-control-wrap i.input-icon {
        position: absolute;
        left: 1rem;
        color: var(--text-muted);
        font-size: 0.9rem;
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.9rem;
        color: var(--text);
        background: #fff;
        transition: all var(--transition-speed) ease;
        outline: none;
    }
    .form-control-wrap i.input-icon + .form-control {
        padding-left: 2.5rem;
    }
    .form-control:focus {
        border-color: var(--theme-success);
        box-shadow: 0 0 0 3.5px rgba(16, 185, 129, 0.15);
    }
    .form-control.is-invalid {
        border-color: var(--theme-danger);
    }
    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3.5px rgba(239, 68, 68, 0.15);
    }

    .invalid-feedback {
        font-size: 0.78rem;
        color: var(--theme-danger);
        display: flex;
        align-items: center;
        gap: 0.3rem;
        margin-top: 0.2rem;
        font-weight: 700;
    }
    .form-hint {
        font-size: 0.76rem;
        color: var(--text-muted);
        margin-top: 0.15rem;
    }

    /* ── Radio disabled styling ── */
    .radio-group {
        display: flex;
        gap: 1.25rem;
        margin-top: 0.25rem;
    }
    .radio-label-disabled {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--text-muted);
        background: #f1f5f9;
        padding: 0.75rem 1.2rem;
        border-radius: 10px;
        border: 1.5px solid var(--border);
        flex: 1;
        cursor: not-allowed;
        opacity: 0.75;
    }
    .radio-label-disabled input[type="radio"] {
        width: 17px;
        height: 17px;
        cursor: not-allowed;
    }
    .radio-label-disabled.checked {
        border-color: var(--primary);
        background: var(--theme-primary-light);
        color: var(--primary);
    }

    /* ── Divider ── */
    .section-divider {
        grid-column: 1 / -1;
        border: none;
        border-top: 1.5px dashed var(--border);
        margin: 0.5rem 0;
    }
    .section-title {
        grid-column: 1 / -1;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-title::after {
        content: '';
        flex: 1;
        height: 1.5px;
        background: var(--border);
    }

    /* ── Action buttons ── */
    .form-actions {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 1.25rem 1.8rem;
        border-top: 1px solid var(--border);
        background: #fafbfc;
    }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--theme-success), #059669);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: all var(--transition-speed) ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.3);
    }
    .btn-cancel-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.2rem;
        background: var(--bg);
        color: var(--text-muted);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        text-decoration: none;
        transition: all var(--transition-speed) ease;
    }
    .btn-cancel-link:hover {
        background: #e2e8f0;
        color: var(--text);
    }

    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-grid .full {
            grid-column: 1;
        }
        .radio-group {
            flex-direction: column;
            gap: 0.6rem;
        }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <a href="{{ route('kperpus.buku.index') }}" title="Kembali ke Daftar Buku">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1>Edit Data Buku</h1>
</div>

<div class="layout-grid">
    {{-- Left Column: Form --}}
    <div class="form-card">
        <div class="form-card-header">
            <div class="hdr-icon"><i class="fas fa-edit"></i></div>
            <div>
                <h2>Formulir Edit Buku</h2>
                <p>Perbarui informasi buku. Tanda (<span style="color:var(--danger)">*</span>) wajib diisi.</p>
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
                        <div class="form-control-wrap">
                            <i class="fas fa-barcode input-icon"></i>
                            <input type="text" id="kode_buku" name="kode_buku"
                                   class="form-control @error('kode_buku') is-invalid @enderror"
                                   value="{{ old('kode_buku', $buku->kode_buku) }}" placeholder="Contoh: BK-0001" required>
                        </div>
                        @error('kode_buku')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ISBN --}}
                    <div class="form-group">
                        <label for="isbn">ISBN</label>
                        <div class="form-control-wrap">
                            <i class="fas fa-fingerprint input-icon"></i>
                            <input type="text" id="isbn" name="isbn"
                                   class="form-control @error('isbn') is-invalid @enderror"
                                   value="{{ old('isbn', $buku->isbn) }}" placeholder="Maksimal 13 karakter" maxlength="13">
                        </div>
                        @error('isbn')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Judul Buku --}}
                    <div class="form-group full">
                        <label for="judul_buku">Judul Buku <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-heading input-icon"></i>
                            <input type="text" id="judul_buku" name="judul_buku"
                                   class="form-control @error('judul_buku') is-invalid @enderror"
                                   value="{{ old('judul_buku', $buku->judul_buku) }}" placeholder="Masukkan judul lengkap buku" required>
                        </div>
                        @error('judul_buku')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Pengarang --}}
                    <div class="form-group">
                        <label for="pengarang">Nama Pengarang <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-edit input-icon"></i>
                            <input type="text" id="pengarang" name="pengarang"
                                   class="form-control @error('pengarang') is-invalid @enderror"
                                   value="{{ old('pengarang', $buku->pengarang) }}" placeholder="Nama pengarang / penulis" required>
                        </div>
                        @error('pengarang')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tahun Terbit --}}
                    <div class="form-group">
                        <label for="tahun_terbit">Tahun Terbit <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-calendar-alt input-icon"></i>
                            <input type="number" id="tahun_terbit" name="tahun_terbit"
                                   class="form-control @error('tahun_terbit') is-invalid @enderror"
                                   value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                                   placeholder="Contoh: 2024" min="1900" max="{{ date('Y') }}" required>
                        </div>
                        @error('tahun_terbit')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ── Sumber & Klasifikasi ─────────────────── --}}
                    <hr class="section-divider">
                    <div class="section-title">Sumber & Klasifikasi</div>

                    {{-- Sumber Buku (Locked on Edit) --}}
                    <div class="form-group full">
                        <label>Sumber Anggaran Buku <span class="req">*</span></label>
                        <div class="radio-group">
                            <label class="radio-label-disabled {{ $buku->sumber_buku === 'bos' ? 'checked' : '' }}">
                                <input type="radio" name="sumber_buku_disabled" value="bos" 
                                       {{ $buku->sumber_buku === 'bos' ? 'checked' : '' }} disabled>
                                Buku BOS (Operasional Sekolah)
                            </label>
                            <label class="radio-label-disabled {{ $buku->sumber_buku === 'buku perpus' ? 'checked' : '' }}">
                                <input type="radio" name="sumber_buku_disabled" value="buku perpus" 
                                       {{ $buku->sumber_buku === 'buku perpus' ? 'checked' : '' }} disabled>
                                Buku Perpus (Koleksi Umum)
                            </label>
                        </div>
                        <input type="hidden" name="sumber_buku" id="sumber_buku_hidden" value="{{ $buku->sumber_buku }}">
                        <span class="form-hint" style="margin-top: 0.35rem;">
                            <i class="fas fa-info-circle" style="color: var(--primary);"></i> Sumber anggaran tidak dapat diubah setelah buku dibuat untuk menjaga konsistensi kode serial prefix.
                        </span>
                        @error('sumber_buku')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Kategori (only for Buku Perpus) --}}
                    <div class="form-group" id="kategori-group">
                        <label for="id_kategori">Kategori Buku <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-bookmark input-icon"></i>
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
                        </div>
                        @error('id_kategori')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Kelas (only for Buku BOS) --}}
                    <div class="form-group" id="kelas-group">
                        <label for="kelas">Kelas Peruntukan <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-layer-group input-icon"></i>
                            <select id="kelas" name="kelas"
                                    class="form-control @error('kelas') is-invalid @enderror">
                                <option value="">— Pilih Kelas —</option>
                                <option value="VII"  {{ old('kelas', $buku->kelas) === 'VII'  ? 'selected' : '' }}>Kelas VII</option>
                                <option value="VIII" {{ old('kelas', $buku->kelas) === 'VIII' ? 'selected' : '' }}>Kelas VIII</option>
                                <option value="IX"   {{ old('kelas', $buku->kelas) === 'IX'   ? 'selected' : '' }}>Kelas IX</option>
                            </select>
                        </div>
                        @error('kelas')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Stok --}}
                    <div class="form-group">
                        <label for="stok">Stok <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-boxes input-icon"></i>
                            <input type="number" id="stok" name="stok"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', $buku->stok) }}" min="1" required>
                        </div>
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
                                <img src="{{ Storage::url($buku->gambar) }}" alt="Cover saat ini" id="current-cover-img">
                                <div class="cover-info">
                                    <strong>Cover Buku Aktif</strong>
                                    <p>Unggah gambar baru untuk mengganti cover. Biarkan kosong jika tidak ingin mengubah cover.</p>
                                </div>
                            @else
                                <div class="placeholder-cover"><i class="fas fa-image"></i></div>
                                <div class="cover-info">
                                    <strong>Belum Ada Cover</strong>
                                    <p>Unggah file gambar (JPG, JPEG, PNG, maks. 2 MB) jika ingin menambahkan cover.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Gambar baru --}}
                    <div class="form-group full">
                        <label for="gambar">Ganti / Upload Cover Baru</label>
                        <div class="form-control-wrap">
                            <i class="fas fa-image input-icon" style="top: 1.1rem;"></i>
                            <input type="file" id="gambar" name="gambar" accept="image/jpg,image/jpeg,image/png"
                                   class="form-control @error('gambar') is-invalid @enderror"
                                   style="padding-top: 0.6rem; padding-bottom: 0.6rem;">
                        </div>
                        <span class="form-hint">Format file: JPG, JPEG, PNG. Maksimal ukuran 2 MB.</span>
                        @error('gambar')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
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


</div>

@endsection

@push('scripts')
<script>
    const isBos = '{{ $buku->sumber_buku === "bos" ? "true" : "false" }}' === 'true';
    const kelasGroup  = document.getElementById('kelas-group');
    const katGroup    = document.getElementById('kategori-group');

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

    // Init on load
    toggleFields();
</script>
@endpush
