@extends('ksekolah.layouts.app')

@section('title', 'Data Petugas Perpustakaan')
@section('page-title', 'Data Petugas')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: .8rem;
    }
    .page-header h1 { font-size: 1.25rem; font-weight: 800; color: var(--text); }
    .page-header p { font-size: .84rem; color: var(--text-muted); margin-top: .2rem; }

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

    .user-info { display: flex; align-items: center; gap: .8rem; }
    .user-avatar {
        width: 38px; height: 38px; border-radius: 10px;
        background: var(--primary-light); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .9rem;
    }

    .role-badge {
        font-size: .72rem; font-weight: 700; padding: .25rem .7rem; border-radius: 20px;
        text-transform: uppercase; letter-spacing: .3px;
    }
    .role-kperpus { background: #ebf5fb; color: #2980b9; }
    .role-pperpus { background: #eafaf1; color: #27ae60; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1><i class="fas fa-users-cog" style="color:var(--primary);margin-right:.45rem"></i>Data Petugas</h1>
        <p>Daftar penanggung jawab dan petugas operasional perpustakaan</p>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Petugas</th>
                    <th>Jabatan / Role</th>
                    <th>Terdaftar Sejak</th>
                </tr>
            </thead>
            <tbody>
                @foreach($officers as $officer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="user-info">
                            <div style="font-weight: 700">{{ $officer->name }}</div>
                        </div>
                    </td>
                    <td>
                        @if($officer->role === 'kepala_perpustakaan')
                            <span class="role-badge role-kperpus">Kepala Perpustakaan</span>
                        @else
                            <span class="role-badge role-pperpus">Penjaga Perpustakaan</span>
                        @endif
                    </td>
                    <td>{{ $officer->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    
    @if($officers->hasPages())
    <div class="pagination-wrap">
        <span class="info">
            Menampilkan {{ $officers->firstItem() }}–{{ $officers->lastItem() }} dari {{ $officers->total() }} data
        </span>
        {{ $officers->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

@endsection
