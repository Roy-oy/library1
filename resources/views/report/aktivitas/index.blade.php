@extends($layout)

@section('title', 'Laporan Aktivitas Perpustakaan')
@section('page-title', 'Laporan Aktivitas')

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

    .stats-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.2rem; margin-bottom: 1.5rem;
    }
    .stat-card {
        background: var(--surface); padding: 1.2rem; border-radius: var(--radius);
        box-shadow: var(--shadow); border-left: 4px solid var(--primary);
    }
    .stat-card.kembali { border-left-color: var(--success); }
    .stat-card.denda   { border-left-color: #dc2626; }
    
    .stat-card .label { font-size: .72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
    .stat-card .value { font-size: 1.3rem; font-weight: 800; color: var(--text); margin-top: .3rem; }

    /* Card */
    .card {
        background: var(--surface); border-radius: var(--radius);
        box-shadow: var(--shadow); overflow: hidden; margin-bottom: 1.5rem;
    }
    .card-header-tab {
        padding: 0 1.4rem; border-bottom: 1px solid var(--border);
        display: flex; gap: 1.5rem;
    }
    .tab-link {
        padding: 1rem 0; font-size: .85rem; font-weight: 600; color: var(--text-muted);
        text-decoration: none; border-bottom: 2px solid transparent;
        cursor: pointer;
    }
    .tab-link.active { color: var(--primary); border-bottom-color: var(--primary); }

    .card-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border);
        flex-wrap: wrap; gap: 1rem; background: #fafbfc;
    }
    .card-toolbar .total-label { font-size: 0.88rem; color: var(--text-muted); }
    .card-toolbar .total-label strong { color: var(--primary); font-size: 1rem; font-weight: 800; }

    /* Table */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc;
        font-size: .73rem; font-weight: 700; text-transform: uppercase;
        padding: .75rem 1.1rem; border-bottom: 1px solid var(--border);
        color: var(--text-muted); text-align: left;
    }
    tbody td {
        padding: .75rem 1.1rem; font-size: .86rem;
        border-bottom: 1px solid #f0f4f8; color: var(--text);
    }
    
    .pill {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .22rem .65rem; border-radius: 20px; font-size: .74rem; font-weight: 600;
    }
    .pill-info { background: #ebf5fb; color: #2980b9; }
    .pill-success { background: #eafaf1; color: #27ae60; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h1><i class="fas fa-history" style="color:var(--primary);margin-right:.45rem"></i>Laporan Aktivitas</h1>
        <p>Ringkasan transaksi peminjaman dan pengembalian buku</p>
    </div>
    @php
        $prefix = match(auth()->user()->role ?? '') {
            'kepala_sekolah' => 'ksekolah.',
            'kepala_perpustakaan' => 'kperpus.',
            'penjaga_perpustakaan' => 'pperpus.',
            default => ''
        };
    @endphp
    <div style="display: flex; gap: 0.5rem;">
        @if(auth()->user()->role !== 'kepala_sekolah')
        <a href="{{ route($prefix . 'report.aktivitas.export-pdf', request()->all()) }}" target="_blank" class="btn-primary" style="background: #dc2626">
            <i class="fas fa-file-pdf"></i> Preview PDF
        </a>
        <a href="{{ route($prefix . 'report.aktivitas.export-excel', request()->all()) }}" class="btn-primary" style="background: #10b981">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-toolbar">
        <span class="total-label">Total aktivitas: <strong>{{ count($aktivitas) }} data</strong></span>
        
        <form action="{{ route($prefix . 'report.aktivitas.index') }}" method="GET" style="display: flex; gap: 1rem; align-items: center; margin: 0; flex-wrap: wrap;">
            
            <select name="sumber_buku" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem 1rem; border-radius: 8px; border: 1.5px solid var(--border); outline: none; background: #fff; color: var(--text); font-family: inherit; font-size: 0.88rem; font-weight: 600; cursor: pointer;">
                <option value="buku perpus" {{ (request('sumber_buku') ?? 'buku perpus') === 'buku perpus' ? 'selected' : '' }}>Buku Perpustakaan</option>
                <option value="bos" {{ request('sumber_buku') === 'bos' ? 'selected' : '' }}>Buku BOS</option>
            </select>

            <div style="display: flex; align-items: center; gap: 0.5rem; padding: 0.4rem 0.8rem; border-radius: 8px; border: 1.5px solid var(--border); background: #fff; font-size: 0.88rem;">
                <input type="date" name="start_date" value="{{ $startDate }}" style="border: none; background: transparent; outline: none; color: var(--text); font-family: inherit; font-weight: 600; cursor: pointer;" onchange="this.form.submit()">
                <span style="color: var(--border); font-size: 0.8rem; font-weight: 600;">s/d</span>
                <input type="date" name="end_date" value="{{ $endDate }}" style="border: none; background: transparent; outline: none; color: var(--text); font-family: inherit; font-weight: 600; cursor: pointer;" onchange="this.form.submit()">
            </div>
            
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">No</th>
                    <th>Kode Peminjaman</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Tgl Pinjam</th>
                    <th>Harus Kembali</th>
                    <th>Tgl Kembali</th>
                    <th>Judul Buku</th>
                    <th style="text-align: center;">Telat (Hari)</th>
                    <th style="text-align: right;">Denda (Rp)</th>
                    <th style="text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aktivitas as $index => $item)
                <tr>
                    <td style="text-align: center; color: var(--text-muted); font-weight: 600;">{{ $index + 1 }}</td>
                    <td><span style="font-weight: 700; color: var(--text-muted)">{{ $item->kode }}</span></td>
                    <td>{{ $item->nis }}</td>
                    <td style="font-weight: 700; color: var(--text)">{{ $item->siswa }}</td>
                    <td>{{ $item->kelas }}</td>
                    <td>
                        {{ $item->tanggal_pinjam !== '-' ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        {{ $item->tanggal_jatuh_tempo !== '-' ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        {{ $item->tanggal_kembali !== '-' ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}
                    </td>
                    <td style="max-width: 150px; font-weight: 600; color: var(--text); line-height: 1.4;">{{ $item->buku }}</td>
                    <td style="text-align: center;">
                        @if($item->telat > 0)
                            <span style="color: #dc2626; font-weight: 700;">{{ $item->telat }}</span>
                        @else
                            <span style="color: var(--text-muted);">-</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if($item->denda > 0)
                            <span style="color: #dc2626; font-weight: 700;">{{ number_format($item->denda, 0, ',', '.') }}</span>
                        @else
                            <span style="color: var(--text-muted);">-</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if(in_array(strtolower($item->status), ['sedang dipinjam', 'dipinjam']))
                            <span class="pill pill-info"><i class="fas fa-clock" style="font-size: 0.6rem;"></i> Dipinjam</span>
                        @elseif(in_array(strtolower($item->status), ['terlambat']))
                            <span class="pill" style="background: #fef2f2; color: #dc2626;"><i class="fas fa-exclamation-triangle" style="font-size: 0.6rem;"></i> Terlambat</span>
                        @elseif(in_array(strtolower($item->status), ['hilang', 'rusak']))
                            <span class="pill" style="background: #fef2f2; color: #dc2626;"><i class="fas fa-times" style="font-size: 0.6rem;"></i> {{ ucfirst($item->status) }}</span>
                        @else
                            <span class="pill pill-success"><i class="fas fa-check" style="font-size: 0.6rem;"></i> Kembali</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" class="text-center" style="padding: 3rem 2rem; color: var(--text-muted)">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: var(--border); margin-bottom: 1rem; display: block;"></i>
                        <div style="font-weight: 600; font-size: 1.1rem;">Belum Ada Aktivitas</div>
                        <p style="margin-top: 0.5rem; font-size: 0.9rem;">Tidak ada data aktivitas untuk periode dan kategori ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="10" style="text-align: right; background: #f8fafc; font-weight: 800; font-size: 0.9rem; padding: 1rem;">TOTAL DENDA:</th>
                    <th style="text-align: right; background: #f8fafc; font-weight: 800; font-size: 0.9rem; padding: 1rem; color: #dc2626;">
                        Rp{{ number_format($aktivitas->sum('denda'), 0, ',', '.') }}
                    </th>
                    <th style="background: #f8fafc;"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection
