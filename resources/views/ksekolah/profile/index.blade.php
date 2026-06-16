@extends('ksekolah.layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@push('styles')
<style>
    .profile-card {
        max-width: 600px; margin: 0 auto;
        background: var(--surface); border-radius: var(--radius);
        box-shadow: var(--shadow); overflow: hidden;
    }
    .profile-header {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        padding: 2.5rem 2rem; color: #fff; text-align: center;
    }
    .profile-avatar {
        width: 80px; height: 80px; border-radius: 20px;
        background: rgba(255,255,255,0.2); margin: 0 auto 1rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; font-weight: 800; border: 2px solid rgba(255,255,255,0.3);
    }
    .profile-body { padding: 2rem; }
    
    .form-group { margin-bottom: 1.5rem; }
    .form-group label {
        display: block; font-size: .82rem; font-weight: 700;
        color: var(--text-muted); margin-bottom: .6rem;
        text-transform: uppercase;
    }
    .form-control {
        width: 100%; padding: .75rem 1rem; border: 1px solid var(--border);
        border-radius: 10px; font-size: .9rem; background: #fcfdfe;
        transition: border-color .2s;
    }
    .form-control:focus { border-color: var(--primary); outline: none; }
    
    .btn-save {
        width: 100%; padding: .8rem; background: var(--primary);
        color: #fff; border: none; border-radius: 10px;
        font-weight: 700; cursor: pointer; transition: background .2s;
        display: flex; align-items: center; justify-content: center; gap: .5rem;
    }
    .btn-save:hover { background: var(--primary-dark); }
    
    .error-text { color: var(--danger); font-size: .75rem; margin-top: .4rem; display: block; }
</style>
@endpush

@section('content')

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar">
            @if($user->foto_profile)
                <img src="{{ asset('storage/' . $user->foto_profile) }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 18px;">
            @else
                {{ substr($user->name, 0, 1) }}
            @endif
        </div>
        <h2>{{ $user->name }}</h2>
        <p>{{ $user->getRoleLabel() }}</p>
    </div>

    <div class="profile-body">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> Ada kesalahan pada input Anda.
            </div>
        @endif

        <form action="{{ route('ksekolah.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="foto_profile">Foto Profil (Opsional)</label>
                <input type="file" name="foto_profile" id="foto_profile" class="form-control" accept="image/*">
                @error('foto_profile') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                @error('username') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <hr style="border: 0; border-top: 1px solid var(--border); margin: 2rem 0;">
            
            <div class="form-group">
                <label for="password">Password Baru (Kosongkan jika tidak ganti)</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password') <span class="error-text">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Simpan Profil
            </button>
        </form>
    </div>
</div>

@endsection
