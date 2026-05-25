@extends('kperpus.layouts.app')

@section('title', 'Riwayat Pengembalian')
@section('page-title', 'Riwayat Pengembalian')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: .8rem;
    }
    .page-header h1 {
        font-size: 1.25rem; font-weight: 800; color: var(--text);
    }
    .page-header p { font-size: .84rem; color: var(--text-muted); margin-top: .2rem; }
    .card { background: var(--surface); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th { background: #f8fafc; font-size: .73rem; font-weight: 700; text-transform: uppercase; padding: .85rem 1.1rem; border-bottom: 1px solid var(--border); color: var(--text-muted); text-align: left; }
    tbody td { padding: .85rem 1.1rem; font-size: .88rem; border-bottom: 1px solid #f0f4f8; color: var(--text); }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1><i class="fas fa-undo-alt" style="color:var(--primary);margin-right:.4rem"></i>Pantauan Pengembalian</h1>
        <p>Riwayat pengembalian buku yang telah diproses</p>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Tgl Kembali</th>
                    <th>Siswa</th>
                    <th>Buku</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($returns as $ret)
                <tr>
                    <td>{{ $ret->tanggal_kembali->format('d/m/Y') }}</td>
                    <td>{{ $ret->peminjaman->siswa->nama_siswa }}</td>
                    <td>{{ $ret->buku->judul_buku }}</td>
                    <td>Rp{{ number_format($ret->jumlah_denda, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding: 1rem;">{{ $returns->links() }}</div>
</div>

@endsection
