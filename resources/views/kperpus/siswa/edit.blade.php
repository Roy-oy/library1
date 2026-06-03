@extends('kperpus.layouts.app')

@section('title', 'Edit Siswa')
@section('page-title', 'Edit Data Siswa')

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



    @media (max-width: 900px) {
        .layout-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-grid .full {
            grid-column: 1;
        }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <a href="{{ route('kperpus.siswa.index') }}" title="Kembali ke Daftar Siswa">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1>Edit Data Siswa</h1>
</div>

<div class="layout-grid">
    {{-- Left Column: Form --}}
    <div class="form-card">
        <div class="form-card-header">
            <div class="hdr-icon"><i class="fas fa-user-edit"></i></div>
            <div>
                <h2>Perbarui Data Siswa</h2>
                <p>Ubah profil data untuk: <strong>{{ $siswa->nama_siswa }}</strong>. Field bertanda (<span style="color:var(--danger)">*</span>) wajib diisi.</p>
            </div>
        </div>

        <form action="{{ route('kperpus.siswa.update', $siswa->id_siswa) }}" method="POST" id="form-siswa">
            @csrf
            @method('PUT')

            <div class="form-body">
                <div class="form-grid">

                    {{-- NIS --}}
                    <div class="form-group">
                        <label for="nis">Nomor Induk Siswa (NIS) <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-barcode input-icon"></i>
                            <input type="text" id="nis" name="nis"
                                   class="form-control @error('nis') is-invalid @enderror"
                                   value="{{ old('nis', $siswa->nis) }}" placeholder="Contoh: 12345" required>
                        </div>
                        @error('nis')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nama Siswa --}}
                    <div class="form-group">
                        <label for="nama_siswa">Nama Lengkap Siswa <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-tag input-icon"></i>
                            <input type="text" id="nama_siswa" name="nama_siswa"
                                   class="form-control @error('nama_siswa') is-invalid @enderror"
                                   value="{{ old('nama_siswa', $siswa->nama_siswa) }}" placeholder="Masukkan nama lengkap siswa" required>
                        </div>
                        @error('nama_siswa')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="form-group">
                        <label for="kelas">Kelas <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-layer-group input-icon"></i>
                            <select id="kelas" name="kelas"
                                    class="form-control @error('kelas') is-invalid @enderror" required>
                                <option value="">— Pilih Kelas —</option>
                                @foreach(['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'] as $kls)
                                    <option value="{{ $kls }}" {{ old('kelas', $siswa->kelas) == $kls ? 'selected' : '' }}>
                                        {{ $kls }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('kelas')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-venus-mars input-icon"></i>
                            <select id="jenis_kelamin" name="jenis_kelamin"
                                    class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="">— Pilih Jenis Kelamin —</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        @error('jenis_kelamin')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group full">
                        <label for="status">Status Anggota Perpustakaan <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-shield input-icon"></i>
                            <select id="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                <option value="aktif" {{ old('status', $siswa->status) == 'aktif' ? 'selected' : '' }}>Siswa Aktif</option>
                                <option value="nonaktif" {{ old('status', $siswa->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif / Pindah</option>
                            </select>
                        </div>
                        @error('status')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group full">
                        <label for="alamat">Alamat Lengkap Rumah <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-map-marked-alt input-icon" style="top: 1.1rem;"></i>
                            <textarea id="alamat" name="alamat" rows="3"
                                      class="form-control @error('alamat') is-invalid @enderror"
                                      placeholder="Masukkan alamat lengkap tempat tinggal siswa" required style="padding-left: 2.5rem;">{{ old('alamat', $siswa->alamat) }}</textarea>
                        </div>
                        @error('alamat')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                </div>{{-- .form-grid --}}
            </div>{{-- .form-body --}}

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Perbarui Data
                </button>
                <a href="{{ route('kperpus.siswa.index') }}" class="btn-cancel-link">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>


</div>

@endsection

@push('scripts')

@endpush