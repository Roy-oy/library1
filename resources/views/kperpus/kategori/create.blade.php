@extends('kperpus.layouts.app')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori Buku')

@push('styles')
<style>
    /* ── Page Header ── */
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
        max-width: 560px;
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

    /* ── Form elements ── */
    .form-group { display: flex; flex-direction: column; gap: .4rem; margin-bottom: 1.2rem; }
    .form-group:last-child { margin-bottom: 0; }

    .form-group label {
        font-size: .8rem; font-weight: 700; color: var(--text);
        display: flex; align-items: center; gap: .3rem;
    }
    .form-group label .req { color: var(--danger); }

    .form-control {
        width: 100%; padding: .65rem .9rem;
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
        margin-top: .3rem;
    }

    /* ── Form actions ── */
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
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <a href="{{ route('kperpus.kategori.index') }}" title="Kembali">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1>Tambah Kategori Buku</h1>
</div>

<div class="form-card">
    <div class="form-card-header">
        <div class="hdr-icon"><i class="fas fa-tag"></i></div>
        <div>
            <h2>Formulir Tambah Kategori</h2>
            <p>Pilih salah satu jenis kategori buku yang tersedia</p>
        </div>
    </div>

    <form action="{{ route('kperpus.kategori.store') }}" method="POST" id="form-kategori">
        @csrf

        <div class="form-body">
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori <span class="req">*</span></label>
                <input type="text" id="nama_kategori" name="nama_kategori" 
                       class="form-control @error('nama_kategori') is-invalid @enderror"
                       value="{{ old('nama_kategori') }}" placeholder="Contoh: Novel, Sains, Sejarah..." required>
                <p class="form-hint" style="margin-top: .4rem; font-size: .78rem; color: var(--text-muted);">
                    Masukkan nama kategori buku untuk koleksi umum perpustakaan.
                </p>
                @error('nama_kategori')
                    <span class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit" id="btn-simpan">
                <i class="fas fa-save"></i> Simpan Kategori
            </button>
            <a href="{{ route('kperpus.kategori.index') }}" class="btn-cancel-link">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection

