@extends('kperpus.layouts.app')

@section('title', 'Edit Siswa')
@section('page-title', 'Edit Data Siswa')

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
        max-width: 800px;
    }
    .form-card-header {
        padding: 1.1rem 1.6rem;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: .7rem;
    }
    .form-card-header .hdr-icon {
        width: 38px; height: 38px; border-radius: 10px;
        background: linear-gradient(135deg, var(--info), var(--primary));
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
    .btn-cancel {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .6rem 1.1rem;
        background: var(--bg); color: var(--text-muted);
        border: 1px solid var(--border); border-radius: 8px;
        font-family: inherit; font-size: .88rem; font-weight: 600;
        text-decoration: none; cursor: pointer; transition: background .15s;
    }
    .btn-cancel:hover { background: #e8edf2; }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-grid .full { grid-column: 1; }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <a href="{{ route('kperpus.siswa.index') }}" title="Kembali">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1>Edit Data Siswa</h1>
</div>

<div class="form-card">
    <div class="form-card-header">
        <div class="hdr-icon"><i class="fas fa-user-edit"></i></div>
        <div>
            <h2>Perbarui Data Siswa</h2>
            <p>Mengedit informasi untuk: <strong>{{ $siswa->nama_siswa }}</strong></p>
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
                    <input type="text" id="nis" name="nis"
                           class="form-control @error('nis') is-invalid @enderror"
                           value="{{ old('nis', $siswa->nis) }}" placeholder="Contoh: 12345" required>
                    @error('nis')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Nama Siswa --}}
                <div class="form-group">
                    <label for="nama_siswa">Nama Lengkap <span class="req">*</span></label>
                    <input type="text" id="nama_siswa" name="nama_siswa"
                           class="form-control @error('nama_siswa') is-invalid @enderror"
                           value="{{ old('nama_siswa', $siswa->nama_siswa) }}" placeholder="Masukkan nama lengkap" required>
                    @error('nama_siswa')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div class="form-group">
                    <label for="kelas">Kelas <span class="req">*</span></label>
                    <select id="kelas" name="kelas"
                            class="form-control @error('kelas') is-invalid @enderror" required>
                        <option value="">— Pilih Kelas —</option>
                        @foreach(['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'] as $kls)
                            <option value="{{ $kls }}" {{ old('kelas', $siswa->kelas) == $kls ? 'selected' : '' }}>
                                {{ $kls }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span class="req">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin"
                            class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">— Pilih Jenis Kelamin —</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="form-group full">
                    <label for="status">Status Keanggotaan <span class="req">*</span></label>
                    <select id="status" name="status"
                            class="form-control @error('status') is-invalid @enderror" required>
                        <option value="aktif" {{ old('status', $siswa->status) == 'aktif' ? 'selected' : '' }}>Siswa Aktif</option>
                        <option value="nonaktif" {{ old('status', $siswa->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif / Pindah</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="form-group full">
                    <label for="alamat">Alamat Lengkap <span class="req">*</span></label>
                    <textarea id="alamat" name="alamat" rows="3"
                              class="form-control @error('alamat') is-invalid @enderror"
                              placeholder="Masukkan alamat lengkap siswa" required>{{ old('alamat', $siswa->alamat) }}</textarea>
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
            <a href="{{ route('kperpus.siswa.index') }}" class="btn-cancel">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection
