@extends('kperpus.layouts.app')

@section('title', 'Manajemen Petugas')
@section('page-title', 'Manajemen Petugas')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: .8rem;
    }
    .page-header h1 { font-size: 1.25rem; font-weight: 800; color: var(--text); }
    .page-header p { font-size: .84rem; color: var(--text-muted); margin-top: .2rem; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .55rem 1.1rem;
        background: var(--primary); color: #fff;
        border: none; border-radius: 8px;
        font-family: inherit; font-size: .85rem; font-weight: 600;
        cursor: pointer; text-decoration: none;
        transition: background .2s, transform .15s;
    }
    .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); color: #fff; }

    .card {
        background: var(--surface); border-radius: var(--radius);
        box-shadow: var(--shadow); overflow: hidden;
    }
    
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc;
        font-size: .73rem; font-weight: 700; text-transform: uppercase;
        padding: .85rem 1.1rem; border-bottom: 1px solid var(--border);
        color: var(--text-muted); text-align: left;
    }
    tbody td {
        padding: 1rem 1.1rem; font-size: .88rem;
        border-bottom: 1px solid #f0f4f8; color: var(--text);
        vertical-align: middle;
    }

    .userpage-info { display: flex; align-items: center; gap: .8rem; }
    .userpage-avatar {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .9rem;
    }

    .btn-action {
        width: 32px; height: 32px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        text-decoration: none; font-size: .85rem; border: none; cursor: pointer;
    }
    .btn-edit { background: #ebf5fb; color: #2980b9; }
    .btn-delete { background: #fdf0ef; color: #e74c3c; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1><i class="fas fa-user-shield" style="color:var(--primary);margin-right:.45rem"></i>Manajemen Petugas</h1>
        <p>Kelola data penjaga perpustakaan (staff operasional)</p>
    </div>
    <a href="{{ route('kperpus.petugas.create') }}" class="btn-primary">
        <i class="fas fa-plus"></i> Tambah Petugas
    </a>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Petugas</th>
                    <th>Username</th>
                    <th>Terdaftar Sejak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($officers as $officer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="userpage-info">
                            <div class="userpage-avatar">{{ substr($officer->name, 0, 1) }}</div>
                            <div style="font-weight: 700">{{ $officer->name }}</div>
                        </div>
                    </td>
                    <td>{{ $officer->username }}</td>
                    <td>{{ $officer->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display: flex; gap: .5rem;">
                            <a href="{{ route('kperpus.petugas.edit', $officer->id) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('kperpus.petugas.destroy', $officer->id) }}" method="POST" onsubmit="return confirm('Hapus petugas ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 3rem; color: var(--text-muted)">Belum ada data petugas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
