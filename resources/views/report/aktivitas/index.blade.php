@extends($layout)

@section('title', 'Laporan Aktivitas Perpustakaan')
@section('page-title', 'Laporan Aktivitas')

@push('styles')
<style>
    /* ── Theme & Layout Variables ── */
    :root {
        --theme-primary: #2563eb;
        --theme-primary-light: #eff6ff;
        --theme-primary-hover: #1d4ed8;
        --theme-success: #10b981;
        --theme-success-light: #ecfdf5;
        --theme-danger: #ef4444;
        --theme-danger-light: #fef2f2;
        --theme-info: #0ea5e9;
        --theme-info-light: #f0f9ff;
        --card-radius: 12px;
        --transition-speed: 0.2s;
    }

    /* ── Page Header ── */
    .page-header {
        display: flex; 
        align-items: center; 
        justify-content: space-between;
        margin-bottom: 1.5rem; 
        flex-wrap: wrap; 
        gap: 1rem;
    }
    .page-header h1 { 
        font-size: 1.5rem; 
        font-weight: 800; 
        color: var(--text); 
        letter-spacing: -0.5px;
    }
    .page-header p { 
        font-size: .88rem; 
        color: var(--text-muted); 
        margin-top: .25rem; 
    }

    /* ── Buttons ── */
    .btn-primary {
        display: inline-flex; 
        align-items: center; 
        gap: .5rem;
        padding: .6rem 1.2rem;
        background: var(--primary); 
        color: #fff;
        border: none; 
        border-radius: 8px;
        font-family: inherit; 
        font-size: .85rem; 
        font-weight: 600;
        cursor: pointer; 
        text-decoration: none;
        transition: all var(--transition-speed);
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
    }
    .btn-primary:hover { 
        background: var(--primary-dark); 
        transform: translateY(-1px); 
        color: #fff; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.08);
    }

    /* ── Card Styles ── */
    .card {
        background: var(--surface); 
        border-radius: var(--card-radius);
        box-shadow: var(--shadow); 
        overflow: hidden; 
        margin-bottom: 1.5rem;
        border: 1px solid var(--border);
    }

    /* ── ENHANCED FILTER PANEL (MODERN & CLEAR) ── */
    .filter-wrapper {
        background: #fafbfc;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
    }
    .filter-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: flex-end;
    }
    .filter-item {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        flex: 1;
        min-width: 200px;
    }
    .filter-item.date-range {
        min-width: 280px;
        flex: 1.2;
    }
    .filter-item.actions-filter {
        min-width: auto;
        flex: none;
        flex-direction: row;
        gap: 0.5rem;
    }
    .filter-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Input & Select Controls inside Filter */
    .filter-control-wrap {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }
    .filter-control-wrap i.input-icon {
        position: absolute;
        left: 0.85rem;
        color: #94a3b8;
        font-size: 0.88rem;
        pointer-events: none;
    }
    .filter-control {
        width: 100%;
        padding: 0.55rem 1rem 0.55rem 2.25rem;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        outline: none;
        background: #fff;
        color: var(--text);
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: all var(--transition-speed);
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
    select.filter-control {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.85rem center;
        background-size: 1rem;
        padding-right: 2.25rem;
    }
    .filter-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    /* Date Multi-input Container */
    .date-range-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.8rem;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        background: #fff;
        transition: all var(--transition-speed);
        width: 100%;
    }
    .date-range-box:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .date-range-box input[type="date"] {
        border: none;
        background: transparent;
        outline: none;
        color: var(--text);
        font-family: inherit;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        flex: 1;
    }
    .date-separator {
        color: #94a3b8;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    
    /* Reset Filter Button */
    .btn-reset-filter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.6rem 1rem;
        background: #f1f5f9;
        color: #475569;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        font-family: inherit;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all var(--transition-speed);
        height: 38px;
    }
    .btn-reset-filter:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    /* Info Toolbar */
    .info-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.85rem 1.5rem;
        background: #fff;
        border-bottom: 1px solid var(--border);
    }
    .total-label { font-size: 0.88rem; color: var(--text-muted); }
    .total-label strong { color: var(--primary); font-size: 1rem; font-weight: 800; }



    /* Empty state */
    .empty-state-box {
        padding: 4rem 2rem; 
        text-align: center; 
        color: var(--text-muted);
    }
    .empty-state-box i {
        font-size: 3rem; 
        color: #cbd5e1; 
        margin-bottom: 1rem; 
        display: block;
    }

    /* ── UNIVERSAL PREMIUM TABLE ── */
    .table-wrap { overflow-x: auto; width: 100%; border-radius: 0 0 var(--card-radius) var(--card-radius); }
    table.kperpus-table { width: 100%; border-collapse: separate; border-spacing: 0; min-width: 1400px; }
    table.kperpus-table thead th {
        background: var(--primary);
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #ffffff;
        padding: 1.1rem 1.25rem;
        border-bottom: 2px solid var(--primary-dark);
        white-space: nowrap;
    }
    table.kperpus-table tbody td {
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
        border-bottom: 1px solid var(--border);
        color: var(--text);
        vertical-align: middle;
    }
    table.kperpus-table tbody tr:nth-child(even) td { background: #f8fafc; }
    table.kperpus-table tbody tr:last-child td { border-bottom: none; }
    table.kperpus-table tbody tr { transition: background-color .2s ease; }
    table.kperpus-table tbody tr:hover td { background-color: var(--primary-soft) !important; }

    /* ── UNIVERSAL BADGES ── */
    .code-badge { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.82rem; background: var(--primary-soft); color: var(--primary); padding: 0.35rem 0.6rem; border-radius: 8px; font-weight: 800; border: 1px solid rgba(37, 99, 235, 0.15); display: inline-block; }
    .pill { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.8rem; border-radius: 30px; font-size: 0.78rem; font-weight: 700; white-space: nowrap; }
    .pill-success { background: var(--success-bg); color: var(--success); border: 1px solid rgba(16, 185, 129, 0.2); }
    .pill-danger { background: var(--danger-bg); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }
    .pill-warning { background: var(--warning-bg); color: var(--warning); border: 1px solid rgba(245, 158, 11, 0.2); }
    .pill-info { background: var(--info-bg); color: var(--info); border: 1px solid rgba(14, 165, 233, 0.2); }

    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .page-header div:last-child { width: 100%; }
        .btn-primary { width: 100%; justify-content: center; }
        .filter-item { min-width: 100%; }
    }
</style>
@endpush

@section('content')

{{-- Header Halaman --}}
<div class="page-header">
    <div>
        <h1><i class="fas fa-history" style="color:var(--primary);margin-right:.45rem"></i> Laporan Aktivitas Perpustakaan</h1>
        <p>Ringkasan komprehensif data transaksi peminjaman dan pengembalian buku</p>
    </div>
    
    @php
        $prefix = match(auth()->user()->role ?? '') {
            'kepala_sekolah' => 'ksekolah.',
            'kepala_perpustakaan' => 'kperpus.',
            'penjaga_perpustakaan' => 'pperpus.',
            default => ''
        };
    @endphp
    
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        @if(auth()->user()->role !== 'kepala_sekolah')
        <a href="{{ route($prefix . 'report.aktivitas.export-pdf', request()->all()) }}" target="_blank" class="btn-primary" style="background: var(--theme-danger)">
            <i class="fas fa-file-pdf"></i> Preview PDF
        </a>
        <a href="{{ route($prefix . 'report.aktivitas.export-excel', request()->all()) }}" class="btn-primary" style="background: var(--theme-success)">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
        @endif
    </div>
</div>

{{-- Main Container Card --}}
<div class="card">
    
    {{-- FILTER CONTAINER PANEL --}}
    <div class="filter-wrapper">
        <form id="filterForm" action="{{ route($prefix . 'report.aktivitas.index') }}" method="GET" class="filter-grid">
            
            {{-- Filter 1: Sumber Buku --}}
            <div class="filter-item">
                <label class="filter-label">Sumber Buku</label>
                <div class="filter-control-wrap">
                    <i class="fas fa-book input-icon"></i>
                    <select name="sumber_buku" class="filter-control" onchange="this.form.submit()">
                        <option value="buku perpus" {{ (request('sumber_buku') ?? 'buku perpus') === 'buku perpus' ? 'selected' : '' }}>Buku Perpustakaan</option>
                        <option value="bos" {{ request('sumber_buku') === 'bos' ? 'selected' : '' }}>Buku BOS</option>
                    </select>
                </div>
            </div>

            {{-- Filter Status --}}
            <div class="filter-item">
                <label class="filter-label">Status</label>
                <div class="filter-control-wrap">
                    <i class="fas fa-tasks input-icon"></i>
                    <select name="status" class="filter-control" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Sedang Dipinjam</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai / Kembali</option>
                    </select>
                </div>
            </div>

            {{-- Filter 2: Kondisional Kategori / Kelas --}}
            @if((request('sumber_buku') ?? 'buku perpus') === 'buku perpus')
                <div class="filter-item">
                    <label class="filter-label">Kategori Buku</label>
                    <div class="filter-control-wrap">
                        <i class="fas fa-tags input-icon"></i>
                        <select name="kategori" class="filter-control" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}" {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @elseif(request('sumber_buku') === 'bos')
                <div class="filter-item">
                    <label class="filter-label">Kelas</label>
                    <div class="filter-control-wrap">
                        <i class="fas fa-graduation-cap input-icon"></i>
                        <select name="kelas" class="filter-control" onchange="this.form.submit()">
                            <option value="">Semua Kelas</option>
                            @foreach($kelases as $kls)
                                <option value="{{ $kls }}" {{ request('kelas') == $kls ? 'selected' : '' }}>Kelas {{ $kls }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            {{-- Filter 3: Rentang Tanggal --}}
            <div class="filter-item date-range">
                <label class="filter-label">Periode Tanggal</label>
                <div class="date-range-box">
                    <i class="fas fa-calendar-alt" style="color: #94a3b8; font-size: 0.88rem;"></i>
                    <input type="date" name="start_date" value="{{ $startDate }}" onchange="this.form.submit()" title="Tanggal Mulai">
                    <span class="date-separator">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}" onchange="this.form.submit()" title="Tanggal Akhir">
                </div>
            </div>

            {{-- Action Filter Buttons (Reset) --}}
            @if(request()->filled('sumber_buku') || request()->filled('kategori') || request()->filled('kelas') || request()->filled('status') || request()->filled('start_date') || request()->filled('end_date'))
                <div class="filter-item actions-filter">
                    <a href="{{ route($prefix . 'report.aktivitas.index') }}" class="btn-reset-filter" title="Bersihkan Semua Filter">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </a>
                </div>
            @endif
            
        </form>
    </div>

    {{-- Toolbar Informasi Total Data --}}
    <div class="info-toolbar">
        <span class="total-label">Ditemukan: <strong>{{ count($aktivitas) }}</strong> aktivitas terdata</span>
    </div>

    {{-- Data Table Wrap --}}
    <div class="table-wrap">
        <table class="kperpus-table">
            <thead>
                <tr>
                    <th style="width: 50px; text-align: center;">No</th>
                    <th>Kode Pinjam</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Tgl Pinjam</th>
                    <th>Harus Kembali</th>
                    <th>Tgl Kembali</th>
                    <th>Kode Buku</th>
                    <th>Judul Buku</th>
                    <th style="text-align: center;">Telat</th>
                    <th style="text-align: right;">Denda</th>
                    <th style="text-align: center; width: 120px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aktivitas as $index => $item)
                <tr>
                    <td style="text-align: center; color: var(--text-muted); font-weight: 600;">{{ $index + 1 }}</td>
                    <td><span class="code-badge">{{ $item->kode }}</span></td>
                    <td>{{ $item->nis }}</td>
                    <td style="font-weight: 700; color: var(--text)">{{ $item->siswa }}</td>
                    <td><span style="font-weight: 600; color: #475569;">{{ $item->kelas }}</span></td>
                    <td>
                        {{ $item->tanggal_pinjam !== '-' ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        {{ $item->tanggal_jatuh_tempo !== '-' ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        {{ $item->tanggal_kembali !== '-' ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}
                    </td>
                    <td><span class="code-badge">{{ $item->kode_buku }}</span></td>
                    <td style="max-width: 240px; font-weight: 500; color: var(--text); line-height: 1.4; white-space: normal; word-wrap: break-word;">
                        <div>{{ $item->buku }}</div>
                        @if($item->sumber_buku === 'bos')
                            <div style="font-size: .75rem; color: #fff; background: var(--primary); padding: 0.15rem 0.4rem; border-radius: 4px; display: inline-block; margin-top: 0.2rem; font-weight: 600; text-transform: uppercase;">
                                <i class="fas fa-graduation-cap" style="font-size: 0.7rem;"></i> BOS
                            </div>
                        @else
                            <div style="font-size: .75rem; color: var(--primary); background: var(--theme-primary-light); padding: 0.15rem 0.4rem; border-radius: 4px; display: inline-block; margin-top: 0.2rem; font-weight: 600;">
                                <i class="fas fa-tag" style="font-size: 0.7rem;"></i> {{ $item->kategori }}
                            </div>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($item->telat > 0)
                            <span style="color: var(--theme-danger); font-weight: 800;">{{ $item->telat }} hari</span>
                        @else
                            <span style="color: var(--text-muted); font-size: 1.1rem;">-</span>
                        @endif
                    </td>
                    <td style="text-align: right; font-weight: 700;">
                        @if($item->denda > 0)
                            <span style="color: var(--theme-danger);">Rp{{ number_format($item->denda, 0, ',', '.') }}</span>
                        @else
                            <span style="color: var(--text-muted); font-weight: 500;">-</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if(in_array(strtolower($item->status), ['sedang dipinjam', 'dipinjam']))
                            <span class="pill pill-info"><i class="fas fa-clock" style="font-size: 0.65rem;"></i> Dipinjam</span>
                        @elseif(in_array(strtolower($item->status), ['terlambat']))
                            <span class="pill pill-danger"><i class="fas fa-exclamation-triangle" style="font-size: 0.65rem;"></i> Terlambat</span>
                        @elseif(in_array(strtolower($item->status), ['hilang', 'rusak']))
                            <span class="pill pill-danger"><i class="fas fa-times-circle" style="font-size: 0.65rem;"></i> {{ ucfirst($item->status) }}</span>
                        @else
                            <span class="pill pill-success"><i class="fas fa-check-circle" style="font-size: 0.65rem;"></i> Kembali</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12">
                        <div class="empty-state-box">
                            <i class="fas fa-inbox"></i>
                            <div style="font-weight: 700; font-size: 1.1rem; color: var(--text);">Belum Ada Aktivitas</div>
                            <p style="margin-top: 0.4rem; font-size: 0.88rem; color: var(--text-muted);">Tidak ada rekaman data aktivitas untuk periode dan kategori terpilih.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            
            @if(count($aktivitas) > 0)
            <tfoot>
                <tr>
                    <th colspan="10" style="text-align: right; background: #f8fafc; font-weight: 800; font-size: 0.88rem; padding: 1.1rem;">TOTAL KESELURUHAN DENDA:</th>
                    <th style="text-align: right; background: #f8fafc; font-weight: 800; font-size: 0.95rem; padding: 1.1rem; color: var(--theme-danger); border-left: 1px solid var(--border);">
                        Rp{{ number_format($aktivitas->sum('denda'), 0, ',', '.') }}
                    </th>
                    <th style="background: #f8fafc;"></th>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

@endsection