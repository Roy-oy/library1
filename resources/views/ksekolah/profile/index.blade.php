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
        position: relative;
    }
    .profile-avatar {
        width: 90px; height: 90px; border-radius: 25px;
        background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);
        margin: 0 auto 1.2rem; display: flex; align-items: center; justify-content: center;
        font-size: 2.5rem; font-weight: 800; border: 2px solid rgba(255,255,255,0.3);
    }
    .profile-info h2 { font-size: 1.3rem; font-weight: 700; margin: 0; }
    .profile-info p { font-size: .85rem; opacity: .8; margin-top: .4rem; }

    .profile-body { padding: 2rem; }
    
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; font-size: .82rem; font-weight: 700; color: var(--text-muted); margin-bottom: .6rem; text-transform: uppercase; letter-spacing: .5px; }
    .form-control {
        width: 100%; padding: .75rem 1rem; border: 1px solid var(--border); border-radius: 10px;
        font-family: inherit; font-size: .9rem; color: var(--text); background: #fcfdfe;
        transition: border-color .2s, box-shadow .2s;
    }
    .form-control:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px var(--primary-light); }

    .btn-save {
        width: 100%; padding: .8rem; background: var(--primary); color: #fff;
        border: none; border-radius: 10px; font-weight: 700; font-size: .95rem;
        cursor: pointer; transition: background .2s, transform .2s;
        display: flex; align-items: center; justify-content: center; gap: .6rem;
    }
    .btn-save:hover { background: var(--primary-dark); transform: translateY(-1px); }

    .alert {
        padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; font-size: .88rem;
        display: flex; align-items: center; gap: .8rem;
    }
    .alert-success { background: #eafaf1; color: #27ae60; border: 1px solid #d4efdf; }
    .alert-danger { background: #fdf0ef; color: #e74c3c; border: 1px solid #fadbd8; }
</style>
@endpush

@section('content')

<div class="profile-card">
    <div class="profile-header">
        <div class="profile-avatar">{{ substr($user->name, 0, 1) }}</div>
        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <p><i class="fas fa-id-badge mr-1"></i> {{ $user->getRoleLabel() }}</p>
        </div>
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

        <form action="{{ route('ksekolah.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                @error('name') <small style="color:red">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                @error('username') <small style="color:red">{{ $message }}</small> @enderror
            </div>

            <hr style="border: 0; border-top: 1px solid var(--border); margin: 2rem 0;">
            <p style="font-size: .8rem; color: var(--text-muted); margin-bottom: 1.5rem;">
                <i class="fas fa-lock mr-1"></i> Kosongkan password jika tidak ingin mengubahnya.
            </p>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password') <small style="color:red">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>

@endsection
