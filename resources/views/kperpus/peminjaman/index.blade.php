@extends('kperpus.layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman')

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
    .pill { padding: .25rem .7rem; border-radius: 20px; font-size: .75rem; font-weight: 600; }
    .pill-warning { background: #fef9ec; color: #b45309; }
    .pill-success { background: #eafaf1; color: #27ae60; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1><i class="fas fa-hand-holding-heart" style="color:var(--primary);margin-right:.4rem"></i>Pantauan Peminjaman</h1>
        <p>Semua transaksi peminjaman buku perpustakaan</p>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Siswa</th>
                    <th>Tgl Pinjam</th>
                    <th>Buku</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $trx)
                <tr>
                    <td><strong style="color:var(--primary)">{{ $trx->kode_peminjaman }}</strong></td>
                    <td>{{ $trx->siswa->nama_siswa }}</td>
                    <td>{{ $trx->tanggal_pinjam->format('d/m/Y') }}</td>
                    <td>{{ $trx->details->count() }} Buku</td>
                    <td>
                        @if($trx->status_peminjaman === 'dipinjam')
                            <span class="pill pill-warning">Sedang Dipinjam</span>
                        @else
                            <span class="pill pill-success">Selesai</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="padding: 1rem;">{{ $transactions->links() }}</div>
</div>

@endsection
