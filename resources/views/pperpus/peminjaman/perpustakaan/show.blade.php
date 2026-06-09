@extends('pperpus.layouts.app')

@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap');

    :root {
        --ink: #0f172a;
        --ink-light: #334155;
        --muted: #64748b;
        --subtle: #94a3b8;
        --border: #e2e8f0;
        --border-strong: #cbd5e1;
        --surface: #ffffff;
        --surface-2: #f8fafc;
        --surface-3: #f1f5f9;
        --accent: #1e40af;
        --accent-hover: #1d3fa0;
        --accent-light: #eff6ff;
        --accent-mid: #bfdbfe;
        --success: #059669;
        --success-light: #ecfdf5;
        --warning: #d97706;
        --warning-light: #fffbeb;
        --danger: #dc2626;
        --danger-light: #fef2f2;
        --radius: 14px;
        --shadow-sm: 0 1px 3px rgba(15,23,42,.06), 0 1px 2px rgba(15,23,42,.04);
        --shadow: 0 4px 16px rgba(15,23,42,.07), 0 2px 6px rgba(15,23,42,.04);
        --shadow-lg: 0 12px 32px rgba(15,23,42,.10), 0 4px 12px rgba(15,23,42,.06);
    }

    .detail-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        max-width: 1120px;
        margin: 0 auto;
        animation: rise .45s cubic-bezier(.16,1,.3,1) both;
    }
    @keyframes rise { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }

    /* ── Page Header ── */
    .pg-head {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap;
    }
    .pg-head-left { display: flex; align-items: center; gap: 1.1rem; }
    .back-btn {
        width: 44px; height: 44px; border-radius: 12px; border: 1.5px solid var(--border);
        background: var(--surface); display: flex; align-items: center; justify-content: center;
        color: var(--muted); text-decoration: none; font-size: 1rem; flex-shrink: 0;
        transition: all .2s ease;
    }
    .back-btn:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); transform: translateX(-2px); }
    .pg-title { font-size: 1.65rem; font-weight: 900; color: var(--ink); line-height: 1.15; margin: 0; }
    .pg-meta { display: flex; align-items: center; gap: .75rem; margin-top: .4rem; flex-wrap: wrap; }
    .kode-chip {
        font-family: 'JetBrains Mono', monospace; font-size: .85rem; font-weight: 700;
        background: var(--accent-light); color: var(--accent);
        padding: .25rem .7rem; border-radius: 7px; border: 1px solid var(--accent-mid);
    }
    .meta-sep { color: var(--border-strong); font-size: .9rem; }
    .meta-date { font-size: .875rem; color: var(--muted); font-weight: 600; }
    
    .btn-print {
        display: inline-flex; align-items: center; gap: .55rem;
        background: var(--accent); color: #fff; border: none;
        padding: .75rem 1.5rem; border-radius: var(--radius); font-weight: 800; font-size: .9rem;
        cursor: pointer; transition: all .2s ease; font-family: inherit;
        box-shadow: 0 4px 14px rgba(30,64,175,.25);
    }
    .btn-print:hover { background: var(--accent-hover); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(30,64,175,.35); }

    /* ── Section Layout Grid ── */
    .section-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
    @media (max-width: 768px) { .section-row { grid-template-columns: 1fr; } }

    /* ── Card Base ── */
    .card {
        background: var(--surface); border-radius: var(--radius);
        border: 1px solid var(--border); box-shadow: var(--shadow-sm);
        overflow: hidden; transition: box-shadow .2s ease;
    }
    .card:hover { box-shadow: var(--shadow); }
    .card-hd {
        padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        background: var(--surface-2);
    }
    .card-hd-title {
        font-size: .85rem; font-weight: 800; color: var(--ink-light);
        display: flex; align-items: center; gap: .6rem; text-transform: uppercase; letter-spacing: .5px;
    }
    .card-hd-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: var(--accent-light); color: var(--accent);
        display: flex; align-items: center; justify-content: center; font-size: .85rem;
    }
    .card-body { padding: 1.5rem; }

    /* ── Data Fields ── */
    .fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem 1.5rem; }
    .field-full { grid-column: 1 / -1; }
    .field-label { font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .6px; color: var(--subtle); margin-bottom: .35rem; }
    .field-val { font-size: 1rem; font-weight: 700; color: var(--ink); line-height: 1.4; }
    .field-val.muted { font-size: .9rem; font-weight: 500; color: var(--muted); }
    .field-val.danger { color: var(--danger); font-weight: 800; }

    /* ── Status Badge ── */
    .badge {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .3rem .9rem; border-radius: 20px; font-size: .78rem; font-weight: 800;
    }
    .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; display: block; }
    .badge-warning { background: var(--warning-light); color: var(--warning); border: 1px solid #fde68a; }
    .badge-warning::before { background: var(--warning); }
    .badge-success { background: var(--success-light); color: var(--success); border: 1px solid #a7f3d0; }
    .badge-success::before { background: var(--success); }
    .badge-danger  { background: var(--danger-light); color: var(--danger); border: 1px solid #fecaca; }
    .badge-danger::before { background: var(--danger); }
    .badge-default { background: var(--surface-3); color: var(--muted); border: 1px solid var(--border); }
    .badge-default::before { background: var(--subtle); }

    /* ── Denda Alert Banner ── */
    .denda-banner {
        background: var(--danger-light); border: 1px solid #fecaca;
        border-radius: var(--radius); margin-bottom: 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.25rem 1.5rem; gap: 1rem; flex-wrap: wrap;
        box-shadow: var(--shadow-sm);
    }
    .denda-left { display: flex; align-items: center; gap: 1rem; }
    .denda-icon-wrap {
        width: 48px; height: 48px; border-radius: 50%; background: var(--danger); color: #fff;
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;
    }
    .denda-info-text .denda-label { font-size: .75rem; font-weight: 800; text-transform: uppercase; letter-spacing: .5px; color: var(--danger); }
    .denda-info-text .denda-amount { font-size: 1.35rem; font-weight: 900; color: #7f1d1d; margin-top: .1rem; }
    .denda-info-text .denda-note { font-size: .85rem; color: #991b1b; font-weight: 500; margin-top: .1rem; }
    
    .btn-lunas {
        background: var(--danger); color: #fff; border: none;
        padding: .75rem 1.5rem; border-radius: 10px; font-weight: 800; font-size: .875rem;
        cursor: pointer; font-family: inherit; transition: all .2s ease;
        display: inline-flex; align-items: center; gap: .5rem;
        box-shadow: 0 4px 12px rgba(220,38,38,.25);
    }
    .btn-lunas:hover { background: #b91c1c; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(220,38,38,.35); }

    /* ── Books Table UI ── */
    .table-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow-sm); margin-bottom: 1.5rem; overflow: hidden; }
    .table-hd {
        padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        background: var(--surface-2);
    }
    .table-hd-title { font-size: .85rem; font-weight: 800; color: var(--ink-light); display: flex; align-items: center; gap: .6rem; text-transform: uppercase; letter-spacing: .5px; }
    .count-chip {
        background: var(--accent); color: #fff;
        font-size: .75rem; font-weight: 800; padding: .2rem .65rem; border-radius: 20px;
    }
    .tbl-wrap { overflow-x: auto; }
    .tbl { width: 100%; border-collapse: collapse; font-family: 'Plus Jakarta Sans', sans-serif; }
    .tbl thead th {
        padding: 1rem 1.2rem; font-size: .72rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: .7px; color: var(--muted);
        background: var(--surface-2); border-bottom: 1px solid var(--border);
        text-align: left; white-space: nowrap;
    }
    .tbl tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
    .tbl tbody tr:hover td { background: var(--surface-2); }
    .tbl tbody tr:last-child { border-bottom: none; }
    .tbl tbody td { padding: 1.1rem 1.2rem; font-size: .9rem; color: var(--ink-light); vertical-align: middle; }
    
    .book-title-main { font-size: .95rem; font-weight: 800; color: var(--ink); line-height: 1.4; }
    .book-chips { display: flex; align-items: center; gap: .5rem; margin-top: .4rem; flex-wrap: wrap; }
    .chip-code {
        font-family: 'JetBrains Mono', monospace; font-size: .72rem; font-weight: 700;
        background: var(--accent-light); color: var(--accent); padding: .15rem .5rem; border-radius: 5px; border: 1px solid rgba(30,64,175,0.1);
    }
    .chip-cat {
        font-size: .7rem; font-weight: 800; text-transform: uppercase; letter-spacing: .3px;
        background: var(--surface-3); color: var(--muted); padding: .15rem .5rem; border-radius: 5px;
    }
    .date-main { font-size: .875rem; font-weight: 700; color: var(--ink); }
    .late-note { font-size: .75rem; font-weight: 800; color: var(--danger); margin-top: .25rem; display: flex; align-items: center; gap: .25rem; }
    .denda-val { font-size: .9rem; font-weight: 800; color: var(--danger); }
    .denda-status { font-size: .7rem; font-weight: 800; text-transform: uppercase; letter-spacing: .4px; margin-top: .2rem; width: max-content; }
    .denda-status.lunas { color: var(--success); }
    .denda-status.belum { color: var(--warning); }

    /* Action Buttons in Table Row */
    .actions-cell { display: flex; flex-direction: column; gap: .4rem; max-width: 150px; }
    .btn-kembali {
        display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
        padding: .5rem 1rem; border-radius: 8px; font-size: .78rem; font-weight: 800;
        cursor: pointer; border: 1.5px solid var(--accent); background: var(--accent-light);
        color: var(--accent); transition: all .2s; text-decoration: none; font-family: inherit;
        white-space: nowrap;
    }
    .btn-kembali:hover { background: var(--accent); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(30,64,175,.15); }
    
    .btn-extend {
        background: var(--surface-3); border: 1.5px solid var(--border); color: var(--ink-light); 
        display: inline-flex; align-items: center; justify-content: center; gap: .4rem; 
        padding: .5rem 1rem; border-radius: 8px; font-size: .78rem; font-weight: 800; 
        cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
        white-space: nowrap;
    }
    .btn-extend:hover { background: var(--border); color: var(--ink); border-color: var(--border-strong); transform: translateY(-1px); }

    /* ── Modal Design ── */
    .modal-backdrop {
        display: none; position: fixed; inset: 0; background: rgba(15,23,42,.55);
        z-index: 1000; align-items: center; justify-content: center; padding: 1rem;
        backdrop-filter: blur(4px);
    }
    .modal-backdrop.open { display: flex; }
    .modal-box {
        background: var(--surface); border-radius: 18px; width: 100%; max-width: 460px;
        box-shadow: var(--shadow-lg); animation: popIn .25s cubic-bezier(.16,1,.3,1);
        border: 1px solid var(--border); font-family: 'Plus Jakarta Sans', sans-serif;
        overflow: hidden;
    }
    @keyframes popIn { from { opacity:0; transform:scale(.95) translateY(8px); } to { opacity:1; transform:scale(1) translateY(0); } }
    .modal-mhd { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; background: var(--surface-2); }
    .modal-mhd h3 { font-size: 1rem; font-weight: 800; color: var(--ink); margin: 0; display: flex; align-items: center; gap: .6rem; }
    .modal-body { padding: 1.5rem; }
    .modal-foot { padding: 1rem 1.5rem; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: .7rem; background: var(--surface-2); }
    .modal-close-btn { background: none; border: none; cursor: pointer; color: var(--muted); font-size: 1.1rem; padding: .2rem; transition: color .2s; display: flex; align-items: center; }
    .modal-close-btn:hover { color: var(--ink); }
    
    .form-grp { margin-bottom: 1.1rem; }
    .form-grp label { display: block; font-size: .75rem; font-weight: 800; text-transform: uppercase; letter-spacing: .5px; color: var(--subtle); margin-bottom: .45rem; }
    .form-input {
        width: 100%; padding: .75rem 1rem; border: 1.5px solid var(--border); border-radius: 10px;
        font-family: inherit; font-size: .95rem; outline: none; transition: all .2s; color: var(--ink);
        box-sizing: border-box; background: #fff;
    }
    .form-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(30,64,175,.15); }
    
    .btn-cancel { padding: .65rem 1.2rem; border-radius: 9px; border: 1.5px solid var(--border); background: var(--surface); color: var(--muted); font-weight: 700; font-size: .875rem; cursor: pointer; font-family: inherit; transition: all .2s; }
    .btn-cancel:hover { border-color: var(--border-strong); color: var(--ink); }
    .btn-submit { padding: .65rem 1.4rem; border-radius: 9px; border: none; background: var(--success); color: #fff; font-weight: 800; font-size: .875rem; cursor: pointer; font-family: inherit; transition: all .2s; display: inline-flex; align-items: center; gap: .4rem; box-shadow: 0 2px 6px rgba(5,150,105,0.2); }
    .btn-submit:hover { background: #047857; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(5,150,105,0.3); }

    /* ── Print Styles Custom ── */
    .print-only { display: none; }
    @media print {
        @page { margin: 1.5cm; size: A4; }
        body { background: #fff !important; font-family: 'Plus Jakarta Sans', sans-serif !important; }
        .sidebar, .header, .back-btn, .btn-print, .btn-lunas, .btn-kembali, .btn-extend, .modal-backdrop { display: none !important; }
        .main-wrapper { margin-left: 0 !important; padding: 0 !important; }
        .content { padding: 0 !important; }
        .detail-wrap { max-width: 100% !important; animation: none !important; }
        .card, .table-card, .denda-banner { box-shadow: none !important; border: 1px solid #cbd5e1 !important; margin-bottom: 1.5rem !important; }
        .section-row { grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        .tbl tbody tr:hover td { background: transparent !important; }
        .print-only { display: block !important; text-align: center; margin-bottom: 2rem; padding-bottom: 1.2rem; border-bottom: 2px solid #000; }
        .print-header { display: flex; align-items: center; justify-content: center; gap: 1rem; }
        .print-logo { font-size: 2.2rem; color: #000; }
        .print-title h1 { font-size: 1.4rem; font-weight: 900; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; }
        .print-title p { font-size: .8rem; margin: .2rem 0; color: #444; }
        .pg-head { margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #e2e8f0; }
        .print-footer { display: flex !important; justify-content: space-between; margin-top: 4rem; }
        .sig-box { text-align: center; width: 200px; }
        .sig-space { height: 70px; }
        .sig-name { font-weight: 800; text-decoration: underline; font-size: .9rem; }
    }
</style>
@endpush

@section('content')

{{-- PRINT HEADER --}}
@php
    $realtime_total_denda = $peminjaman->details->sum(function($d) {
        if ($d->status_denda === 'lunas') return 0;
        return $d->jumlah_denda > 0 ? $d->jumlah_denda : ($d->denda_realtime ?? 0);
    });
@endphp
<div class="print-only">
    <div class="print-header">
        <div class="print-logo"><i class="fas fa-book-reader"></i></div>
        <div class="print-title">
            <h1>Bukti Transaksi Peminjaman Perpustakaan</h1>
            <p>Sistem Informasi Perpustakaan (SIP) Sekolah</p>
            <p>Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>
    </div>
</div>

<div class="detail-wrap">

    {{-- Page Header --}}
    <div class="pg-head">
        <div class="pg-head-left">
            <a href="{{ route('pperpus.peminjaman.perpustakaan.index') }}" class="back-btn" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="pg-title">Detail Peminjaman</h1>
                <div class="pg-meta">
                    <span class="kode-chip">{{ $peminjaman->kode_peminjaman }}</span>
                    <span class="meta-sep">·</span>
                    <span class="meta-date"><i class="far fa-calendar-alt"></i>&nbsp;{{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Bukti
        </button>
    </div>

    {{-- Denda Alert Banner --}}
    @if($realtime_total_denda > 0 && $peminjaman->status_peminjaman !== 'selesai')
    <div class="denda-banner">
        <div class="denda-left">
            <div class="denda-icon-wrap"><i class="fas fa-hand-holding-usd"></i></div>
            <div class="denda-info-text">
                <div class="denda-label">Tunggakan Denda</div>
                <div class="denda-amount">Rp {{ number_format($realtime_total_denda, 0, ',', '.') }}</div>
                <div class="denda-note">Siswa belum melunasi seluruh denda dari peminjaman ini.</div>
            </div>
        </div>
        <form action="{{ route('pperpus.pengembalian.perpustakaan.lunasSemuaDenda', $peminjaman->id_peminjaman) }}" method="POST" onsubmit="return confirm('Lunaskan semua denda untuk peminjaman ini?')">
            @csrf
            <button type="submit" class="btn-lunas">
                <i class="fas fa-check-circle"></i> Lunaskan Semua
            </button>
        </form>
    </div>
    @endif

    {{-- Info Cards Segment --}}
    <div class="section-row">
        {{-- Card: Data Siswa --}}
        <div class="card">
            <div class="card-hd">
                <div class="card-hd-title">
                    <span class="card-hd-icon"><i class="fas fa-user-graduate"></i></span>
                    Data Siswa Peminjam
                </div>
            </div>
            <div class="card-body">
                <div class="fields-grid">
                    <div class="field-full">
                        <div class="field-label">Nama Lengkap</div>
                        <div class="field-val">{{ $peminjaman->siswa->nama_siswa }}</div>
                    </div>
                    <div>
                        <div class="field-label">NIS</div>
                        <div class="field-val">{{ $peminjaman->siswa->nis }}</div>
                    </div>
                    <div>
                        <div class="field-label">Kelas</div>
                        <div class="field-val">{{ $peminjaman->siswa->kelas }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Status & Info Utama --}}
        <div class="card">
            <div class="card-hd">
                <div class="card-hd-title">
                    <span class="card-hd-icon"><i class="fas fa-info-circle"></i></span>
                    Status Peminjaman
                </div>
                @php
                    $s = match($peminjaman->status_peminjaman) {
                        'dipinjam'     => ['Sedang Dipinjam', 'badge-warning'],
                        'terlambat'    => ['Terlambat', 'badge-danger'],
                        'dikembalikan' => ['Dikembalikan', 'badge-success'],
                        'selesai'      => ['Selesai', 'badge-success'],
                        default        => [$peminjaman->status_peminjaman, 'badge-default'],
                    };
                @endphp
                <span class="badge {{ $s[1] }}">{{ $s[0] }}</span>
            </div>
            <div class="card-body">
                <div class="fields-grid">
                    <div>
                        <div class="field-label">Tanggal Pinjam</div>
                        <div class="field-val">{{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}</div>
                    </div>
                    <div>
                        <div class="field-label">Total Nominal Denda</div>
                        <div class="field-val danger">
                            Rp {{ number_format($realtime_total_denda, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="field-full">
                        <div class="field-label">Keterangan / Catatan</div>
                        <div class="field-val muted">{{ $peminjaman->keterangan ?? 'Tidak ada catatan khusus.' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Books Table Card --}}
    <div class="table-card">
        <div class="table-hd">
            <div class="table-hd-title">
                <span class="card-hd-icon"><i class="fas fa-book-open"></i></span>
                Daftar Buku Dipinjam
            </div>
            <span class="count-chip">{{ $peminjaman->details->count() }} Koleksi Buku</span>
        </div>
        <div class="tbl-wrap">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Jatuh Tempo</th>
                        <th>Tgl Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                        <th class="print-none">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman->details as $detail)
                    <tr>
                        <td>
                            <div class="book-title-main">{{ $detail->buku->judul_buku }}</div>
                            <div class="book-chips">
                                <span class="chip-code">{{ $detail->buku->kode_buku }}</span>
                                <span class="chip-cat">Perpustakaan</span>
                            </div>
                        </td>
                        <td>
                            @if($detail->tanggal_jatuh_tempo)
                                <div class="date-main">{{ $detail->tanggal_jatuh_tempo->format('d/m/Y') }}</div>
                                @if($detail->status_detail === 'terlambat' && !$detail->tanggal_kembali)
                                    <div class="late-note"><i class="fas fa-exclamation-circle"></i> Terlambat {{ $detail->hari_terlambat_realtime }} hari</div>
                                @endif
                            @else
                                <span style="color: var(--subtle); font-size: .85rem">—</span>
                            @endif
                        </td>
                        <td>
                            @if($detail->tanggal_kembali)
                                <div class="date-main">{{ $detail->tanggal_kembali->format('d/m/Y') }}</div>
                            @else
                                <span style="color: var(--muted); font-size: .85rem; font-style: italic">Belum Kembali</span>
                            @endif
                        </td>
                        <td>
                            @if($detail->jumlah_denda > 0)
                                <div class="denda-val">Rp {{ number_format($detail->jumlah_denda, 0, ',', '.') }}</div>
                                <div class="denda-status {{ $detail->status_denda === 'lunas' ? 'lunas' : 'belum' }}">
                                    {{ str_replace('_', ' ', $detail->status_denda) }}
                                </div>
                            @elseif($detail->status_detail === 'terlambat' && !$detail->tanggal_kembali)
                                <div class="denda-val">Rp {{ number_format($detail->denda_realtime ?? 0, 0, ',', '.') }}</div>
                                <div class="denda-status belum">Belum Lunas</div>
                            @else
                                <span style="color: var(--subtle)">—</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $sc = match($detail->status_detail) {
                                    'dipinjam'     => 'badge-warning',
                                    'terlambat'    => 'badge-danger',
                                    'dikembalikan' => 'badge-success',
                                    default        => 'badge-default',
                                };
                            @endphp
                            <span class="badge {{ $sc }}">{{ $detail->label_status }}</span>
                        </td>
                        <td class="print-none">
                            @if(in_array($detail->status_detail, ['dipinjam', 'terlambat']))
                                <div class="actions-cell">

                                    <button class="btn-extend" onclick="openPerpanjangModal({{ $detail->id_detail }}, '{{ addslashes($detail->buku->judul_buku) }}', '{{ $detail->tanggal_jatuh_tempo ? $detail->tanggal_jatuh_tempo->format('Y-m-d') : '' }}')">
                                        <i class="fas fa-calendar-plus"></i> Perpanjang
                                    </button>
                                </div>
                            @else
                                <span style="color: var(--subtle); font-size: .8rem">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Print Footer Signature --}}
    <div class="print-footer" style="display: none;">
        <div class="sig-box">
            <p>Siswa Peminjam,</p>
            <div class="sig-space"></div>
            <p class="sig-name">{{ $peminjaman->siswa->nama_siswa }}</p>
        </div>
        <div class="sig-box">
            <p>Petugas Perpustakaan,</p>
            <div class="sig-space"></div>
            <p class="sig-name">{{ auth()->user()->name }}</p>
        </div>
    </div>

</div>

{{-- MODAL PERPANJANG --}}
<div class="modal-backdrop" id="perpanjangModal">
    <div class="modal-box">
        <div class="modal-mhd">
            <h3><i class="fas fa-calendar-plus" style="color: var(--accent)"></i> Perpanjang Masa Pinjam</h3>
            <button class="modal-close-btn" onclick="closePerpanjangModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <p style="font-size: .875rem; color: var(--muted); margin-bottom: 1.2rem; font-weight: 600;" id="modal-perpanjang-book"></p>
            <form id="formPerpanjang" method="POST">
                @csrf
                <div class="form-grp">
                    <label>Tanggal Perpanjangan (Jatuh Tempo Baru)</label>
                    <input type="date" name="tanggal_perpanjangan" id="tanggal_perpanjangan" class="form-input" required>
                </div>
            </form>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn-cancel" onclick="closePerpanjangModal()">Batal</button>
            <button type="submit" class="btn-submit" form="formPerpanjang">
                <i class="fas fa-check"></i> Konfirmasi Perpanjang
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>

function openPerpanjangModal(idDetail, title, currentJatuhTempo) {
    document.getElementById('modal-perpanjang-book').textContent = 'Buku: ' + title;
    document.getElementById('formPerpanjang').action = '{{ url("/penjaga-perpustakaan/peminjaman") }}/{{ $peminjaman->id_peminjaman }}/detail/' + idDetail + '/perpanjang';
    
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const minDate = tomorrow.toISOString().split('T')[0];
    document.getElementById('tanggal_perpanjangan').min = minDate;
    
    let target = new Date();
    if (currentJatuhTempo) {
        let jt = new Date(currentJatuhTempo);
        if (jt > target) target = jt;
    }
    target.setDate(target.getDate() + 3);
    document.getElementById('tanggal_perpanjangan').value = target.toISOString().split('T')[0];
    
    document.getElementById('perpanjangModal').classList.add('open');
}
function closePerpanjangModal() {
    document.getElementById('perpanjangModal').classList.remove('open');
}

window.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-backdrop')) {
        e.target.classList.remove('open');
    }
});
</script>
@endpush

@endsection