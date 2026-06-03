@extends('kperpus.layouts.app')

@section('title', 'Tambah Petugas')

@push('styles')
<style>
    .form-card {
        max-width: 600px; margin: 0 auto;
        background: var(--surface); border-radius: var(--radius);
        box-shadow: var(--shadow); padding: 2rem;
    }
    .form-group { margin-bottom: 1.5rem; }
    .form-group label { display: block; font-size: .82rem; font-weight: 700; color: var(--text-muted); margin-bottom: .6rem; text-transform: uppercase; }
    .form-control {
        width: 100%; padding: .75rem 1rem; border: 1px solid var(--border); border-radius: 10px;
        font-family: inherit; font-size: .9rem;
    }
    .btn-submit {
        width: 100%; padding: .8rem; background: var(--primary); color: #fff;
        border: none; border-radius: 10px; font-weight: 700; cursor: pointer;
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1><i class="fas fa-user-plus mr-2"></i>Tambah Petugas Baru</h1>
</div>

<div class="form-card">
    <form action="{{ route('kperpus.petugas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            @error('name') <small style="color:red">{{ $message }}</small> @enderror
        </div>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required value="{{ old('username') }}">
            @error('username') <small style="color:red">{{ $message }}</small> @enderror
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password') <small style="color:red">{{ $message }}</small> @enderror
        </div>
        <button type="submit" class="btn-submit">Simpan Petugas</button>
    </form>
</div>

@endsection