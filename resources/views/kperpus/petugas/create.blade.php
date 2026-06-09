@extends('kperpus.layouts.app')

@section('title', 'Tambah Petugas')

@push('styles')
<style>
    :root {
        --theme-primary: #2563eb;
        --card-radius: 16px;
        --transition-speed: 0.2s;
    }
    .page-header {
        margin-bottom: 2rem;
    }
    .page-header h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .form-card {
        max-width: 600px; 
        margin: 0 auto;
        background: var(--surface); 
        border-radius: var(--card-radius);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); 
        padding: 2rem;
        border: 1px solid var(--border);
    }
    .form-group { 
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        margin-bottom: 1.5rem; 
    }
    .form-group label { 
        font-size: .82rem; 
        font-weight: 700; 
        color: #475569; 
        text-transform: uppercase; 
        letter-spacing: 0.5px;
    }
    .form-group label .req {
        color: #ef4444;
    }
    .form-control-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .form-control-wrap i.input-icon {
        position: absolute;
        left: 1rem;
        color: #94a3b8;
        font-size: 0.88rem;
        pointer-events: none;
    }
    .form-control {
        width: 100%; 
        padding: .75rem 1rem; 
        padding-left: 2.5rem;
        border: 1.5px solid var(--border); 
        border-radius: 8px;
        font-family: inherit; 
        font-size: .9rem;
        color: var(--text);
        outline: none;
        transition: border-color var(--transition-speed);
    }
    .form-control:focus {
        border-color: var(--theme-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .btn-submit {
        width: 100%; 
        padding: .8rem; 
        background: var(--theme-primary); 
        color: #fff;
        border: none; 
        border-radius: 8px; 
        font-weight: 700; 
        font-size: 0.95rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: background-color var(--transition-speed);
    }
    .btn-submit:hover {
        background: #1d4ed8;
    }
    small.error-msg {
        color: #ef4444;
        font-size: 0.8rem;
        font-weight: 500;
        margin-top: 0.2rem;
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1><i class="fas fa-user-plus" style="color:var(--primary)"></i> Tambah Petugas Baru</h1>
</div>

<div class="form-card">
    <form action="{{ route('kperpus.petugas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap <span class="req">*</span></label>
            <div class="form-control-wrap">
                <i class="fas fa-user input-icon"></i>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap petugas..." required value="{{ old('name') }}">
            </div>
            @error('name') <small class="error-msg">{{ $message }}</small> @enderror
        </div>
        
        <div class="form-group">
            <label>Username <span class="req">*</span></label>
            <div class="form-control-wrap">
                <i class="fas fa-user-circle input-icon"></i>
                <input type="text" name="username" class="form-control" placeholder="Username untuk login..." required value="{{ old('username') }}">
            </div>
            @error('username') <small class="error-msg">{{ $message }}</small> @enderror
        </div>
        
        <div class="form-group">
            <label>Password <span class="req">*</span></label>
            <div class="form-control-wrap">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter..." required minlength="8">
            </div>
            @error('password') <small class="error-msg">{{ $message }}</small> @enderror
        </div>
        
        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Petugas</button>
    </form>
</div>

@endsection