@extends('pperpus.layouts.app')

@section('title', 'Detail Peminjaman BOS')
@section('page-title', 'Detail Peminjaman BOS')

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
        --accent: #0369a1;
        --accent-hover: #0284c7;
        --accent-light: #f0f9ff;
        --accent-mid: #bae6fd;
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
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap;
    }
    .pg-head-left { display: flex; align-items: center; gap: 1.1rem; }
    .back-btn {
        width: 46px; height: 46px; border-radius: 12px; border: 1.5px solid var(--border);
        background: var(--surface); display: flex; align-items: center; justify-content: center;
        color: var(--muted); text-decoration: none; font-size: 1rem; flex-shrink: 0;
        transition: all .2s ease;
    }
    .back-btn:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); transform: translateX(-2px); }
    .pg-title { font-size: 1.65rem; font-weight: 900; color: var(--ink); line-height: 1.15; }
    .pg-meta { display: flex; align-items: center; gap: .75rem; margin-top: .4rem; flex-wrap: wrap; }
    .kode-chip {
        font-family: 'JetBrains Mono', monospace; font-size: .85rem; font-weight: 700;
        background: var(--accent-light); color: var(--accent);
        padding: .25rem .7rem; border-radius: 7px; border: 1px solid var(--accent-mid);
    }
    .meta-sep { color: var(--border-strong); font-size: .9rem; }
    .meta-date { font-size: .875rem; color: var(--muted); font-weight: 600; }
    .bos-tag {
        font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .5px;
        background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd;
        padding: .22rem .65rem; border-radius: 20px;
    }
    .btn-print {
        display: inline-flex; align-items: center; gap: .55rem;
        background: var(--accent); color: #fff; border: none;
        padding: .75rem 1.5rem; border-radius: var(--radius); font-weight: 800; font-size: .9rem;
        cursor: pointer; transition: all .2s ease; font-family: inherit;
        box-shadow: 0 4px 14px rgba(3,105,161,.25);
    }
    .btn-print:hover { background: var(--accent-hover); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(3,105,161,.35); }

    /* ── Section Grid ── */
    .section-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem; }
    @media (max-width: 768px) { .section-row { grid-template-columns: 1fr; } }

    /* ── Card Base ── */
    .card {
        background: var(--surface); border-radius: var(--radius);
        border: 1px solid var(--border); box-shadow: var(--shadow-sm);
        overflow: hidden; transition: box-shadow .2s ease;
    }
    .card:hover { box-shadow: var(--shadow); }
    .card-hd {
        padding: 1.1rem 1.4rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        background: var(--surface-2);
    }
    .card-hd-title {
        font-size: .875rem; font-weight: 800; color: var(--ink-light);
        display: flex; align-items: center; gap: .6rem; text-transform: uppercase; letter-spacing: .5px;
    }
    .card-hd-icon {
        width: 30px; height: 30px; border-radius: 8px;
        background: var(--accent-light); color: var(--accent);
        display: flex; align-items: center; justify-content: center; font-size: .8rem;
    }
    .card-body { padding: 1.4rem; }

    /* ── Fields ── */
    .fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem 1.5rem; }
    .field-full { grid-column: 1 / -1; }
    .field-label { font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .6px; color: var(--subtle); margin-bottom: .3rem; }
    .field-val { font-size: 1rem; font-weight: 700; color: var(--ink); line-height: 1.4; }
    .field-val.muted { font-size: .875rem; font-weight: 500; color: var(--muted); }

    /* ── Badge ── */
    .badge {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .28rem .85rem; border-radius: 20px; font-size: .78rem; font-weight: 800;
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

    /* ── Denda Alert ── */
    .denda-banner {
        background: var(--danger-light); border: 1px solid #fecaca;
        border-radius: var(--radius); margin-bottom: 1.25rem;
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.25rem 1.5rem; gap: 1rem; flex-wrap: wrap;
    }
    .denda-left { display: flex; align-items: center; gap: 1rem; }
    .denda-icon-wrap {
        width: 48px; height: 48px; border-radius: 50%; background: var(--danger); color: #fff;
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;
    }
    .denda-info-text .denda-label { font-size: .78rem; font-weight: 800; text-transform: uppercase; letter-spacing: .5px; color: var(--danger); }
    .denda-info-text .denda-amount { font-size: 1.3rem; font-weight: 900; color: #7f1d1d; margin-top: .1rem; }
    .denda-info-text .denda-note { font-size: .8rem; color: #991b1b; font-weight: 500; margin-top: .1rem; }
    .btn-lunas {
        background: var(--danger); color: #fff; border: none;
        padding: .7rem 1.5rem; border-radius: 10px; font-weight: 800; font-size: .875rem;
        cursor: pointer; font-family: inherit; transition: all .2s ease;
        display: inline-flex; align-items: center; gap: .5rem;
        box-shadow: 0 4px 12px rgba(220,38,38,.3);
    }
    .btn-lunas:hover { background: #b91c1c; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(220,38,38,.4); }

    /* ── Table ── */
    .table-card { background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 1.25rem; }
    .table-hd {
        padding: 1.1rem 1.4rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        background: var(--surface-2);
    }
    .table-hd-title { font-size: .875rem; font-weight: 800; color: var(--ink-light); display: flex; align-items: center; gap: .6rem; text-transform: uppercase; letter-spacing: .5px; }
    .count-chip { background: var(--accent); color: #fff; font-size: .75rem; font-weight: 800; padding: .18rem .65rem; border-radius: 20px; }
    .tbl-wrap { overflow-x: auto; }
    .tbl { width: 100%; border-collapse: collapse; font-family: 'Plus Jakarta Sans', sans-serif; }
    .tbl thead th {
        padding: .85rem 1.2rem; font-size: .72rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: .7px; color: var(--subtle);
        background: var(--surface-2); border-bottom: 1px solid var(--border);
        text-align: left; white-space: nowrap;
    }
    .tbl tbody tr { transition: background .15s; }
    .tbl tbody tr:hover td { background: var(--surface-2); }
    .tbl tbody td {
        padding: 1rem 1.2rem; font-size: .9rem; color: var(--ink-light);
        border-bottom: 1px solid var(--border); vertical-align: middle;
    }
    .tbl tbody tr:last-child td { border-bottom: none; }
    .book-title-main { font-size: .95rem; font-weight: 800; color: var(--ink); line-height: 1.3; }
    .book-chips { display: flex; align-items: center; gap: .5rem; margin-top: .35rem; flex-wrap: wrap; }
    .chip-code { font-family: 'JetBrains Mono', monospace; font-size: .72rem; font-weight: 700; background: var(--accent-light); color: var(--accent); padding: .15rem .5rem; border-radius: 5px; }
    .chip-bos { font-size: .7rem; font-weight: 800; text-transform: uppercase; letter-spacing: .3px; background: #f0fdfa; color: #0f766e; padding: .15rem .5rem; border-radius: 5px; border: 1px solid #99f6e4; }
    .date-main { font-size: .875rem; font-weight: 700; color: var(--ink); }
    .late-note { font-size: .72rem; font-weight: 800; color: var(--danger); margin-top: .2rem; display: flex; align-items: center; gap: .25rem; }
    .denda-val { font-size: .9rem; font-weight: 800; color: var(--danger); }
    .denda-status { font-size: .68rem; font-weight: 800; text-transform: uppercase; letter-spacing: .3px; margin-top: .15rem; }
    .denda-status.lunas { color: var(--success); }
    .denda-status.belum { color: var(--warning); }

    /* ── Print ── */
    .print-only { display: none; }
    @media print {
        @page { margin: 1.5cm; size: A4; }
        body { background: #fff !important; font-family: 'Plus Jakarta Sans', sans-serif !important; }
        .sidebar, .header, .back-btn, .btn-print, .btn-lunas { display: none !important; }
        .main-wrapper { margin-left: 0 !important; padding: 0 !important; }
        .content { padding: 0 !important; }
        .detail-wrap { max-width: 100% !important; animation: none !important; }
        .card, .table-card, .denda-banner { box-shadow: none !important; border: 1px solid #cbd5e1 !important; }
        .section-row { grid-template-columns: 1fr 1fr; }
        .tbl tbody tr:hover td { background: transparent !important; }
        .print-only { display: block !important; text-align: center; margin-bottom: 2rem; padding-bottom: 1.2rem; border-bottom: 2px solid #000; }
        .print-header { display: flex; align-items: center; justify-content: center; gap: 1rem; }
        .print-logo { font-size: 2.2rem; }
        .print-title h1 { font-size: 1.3rem; font-weight: 900; margin: 0; text-transform: uppercase; }
        .print-title p { font-size: .75rem; margin: .15rem 0; color: #555; }
        .pg-head { margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e2e8f0; }
        .print-footer { display: flex !important; justify-content: space-between; margin-top: 3.5rem; }
        .sig-box { text-align: center; }
        .sig-space { height: 65px; }
        .sig-name { font-weight: 800; text-decoration: underline; font-size: .9rem; }
    }
</style>
@endpush

@section('content')

{{-- PRINT HEADER --}}
<div class="print-only">
    <div class="print-header">
        <div class="print-logo"><i class="fas fa-book-reader"></i></div>
        <div class="print-title">
            <h1>Bukti Transaksi Peminjaman Buku BOS</h1>
            <p>Sistem Informasi Perpustakaan (SIP) Sekolah</p>
            <p>Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</p>
        </div>
    </div>
</div>

<div class="detail-wrap">

    {{-- Page Header --}}
    <div class="pg-head">
        <div class="pg-head-left">
            <a href="{{ route('pperpus.peminjaman.bos.index') }}" class="back-btn" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <div class="pg-title">Detail Peminjaman BOS</div>
                <div class="pg-meta">
                    <span class="kode-chip">{{ $peminjaman->kode_peminjaman }}</span>
                    <span class="meta-sep">·</span>
                    <span class="bos-tag">Buku BOS</span>
                    <span class="meta-sep">·</span>
                    <span class="meta-date"><i class="far fa-calendar-alt"></i>&nbsp;{{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Bukti
        </button>
    </div>

    {{-- Denda Alert --}}
    @if($peminjaman->total_denda > 0 && $peminjaman->status_peminjaman !== 'selesai')
    <div class="denda-banner">
        <div class="denda-left">
            <div class="denda-icon-wrap"><i class="fas fa-hand-holding-usd"></i></div>
            <div class="denda-info-text">
                <div class="denda-label">Tunggakan Denda BOS</div>
                <div class="denda-amount">Rp {{ number_format($peminjaman->total_denda, 0, ',', '.') }}</div>
                <div class="denda-note">Siswa masih memiliki tunggakan denda buku BOS.</div>
            </div>
        </div>
        <form action="{{ route('pperpus.peminjaman.bos.lunasSemuaDenda', $peminjaman->id_peminjaman) }}" method="POST" onsubmit="return confirm('Lunaskan semua denda untuk peminjaman BOS ini?')">
            @csrf
            <button type="submit" class="btn-lunas">
                <i class="fas fa-check-circle"></i> Lunaskan Sekarang
            </button>
        </form>
    </div>
    @endif

    {{-- Info Cards --}}
    <div class="section-row">
        {{-- Data Siswa --}}
        <div class="card">
            <div class="card-hd">
                <div class="card-hd-title">
                    <span class="card-hd-icon"><i class="fas fa-user-circle"></i></span>
                    Data Siswa
                </div>
            </div>
            <div class="card-body">
                <div class="fields-grid">
                    <div class="field-full">
                        <div class="field-label">Nama Siswa</div>
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

        {{-- Status & Denda --}}
        <div class="card">
            <div class="card-hd">
                <div class="card-hd-title">
                    <span class="card-hd-icon"><i class="fas fa-info-circle"></i></span>
                    Status Peminjaman
                </div>
                @php
                    $s = match($peminjaman->status_peminjaman) {
                        'dipinjam'     => ['Sedang Dipinjam', 'badge-warning'],
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
                        <div class="field-label">Tgl Pinjam</div>
                        <div class="field-val">{{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}</div>
                    </div>
                    <div>
                        <div class="field-label">Total Denda</div>
                        <div class="field-val" style="color: var(--danger)">
                            Rp {{ number_format($peminjaman->total_denda, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="field-full">
                        <div class="field-label">Keterangan</div>
                        <div class="field-val muted">{{ $peminjaman->keterangan ?? 'Tidak ada catatan.' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Books Table --}}
    <div class="table-card">
        <div class="table-hd">
            <div class="table-hd-title">
                <span class="card-hd-icon"><i class="fas fa-book-open"></i></span>
                Koleksi Buku BOS Dipinjam
            </div>
            <span class="count-chip">{{ $peminjaman->details->count() }} Buku</span>
        </div>
        <div class="tbl-wrap">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Informasi Buku</th>
                        <th>Jatuh Tempo</th>
                        <th>Tgl Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman->details as $detail)
                    <tr>
                        <td>
                            <div class="book-title-main">{{ $detail->buku->judul_buku }}</div>
                            <div class="book-chips">
                                <span class="chip-code">{{ $detail->buku->kode_buku }}</span>
                                <span class="chip-bos">Buku BOS</span>
                            </div>
                        </td>
                        <td>
                            @if($detail->tanggal_jatuh_tempo)
                                <div class="date-main">{{ $detail->tanggal_jatuh_tempo->format('d/m/Y') }}</div>
                                @if($detail->status_detail === 'terlambat' && !$detail->tanggal_kembali)
                                    <div class="late-note"><i class="fas fa-exclamation-circle"></i> Terlambat {{ $detail->hari_terlambat_realtime }} hari</div>
                                @endif
                            @else
                                <span style="color: var(--subtle); font-size: .85rem">Akhir Semester</span>
                            @endif
                        </td>
                        <td>
                            @if($detail->tanggal_kembali)
                                <div class="date-main">{{ $detail->tanggal_kembali->format('d/m/Y') }}</div>
                            @else
                                <span style="color: var(--subtle); font-size: .85rem; font-style: italic">Belum Kembali</span>
                            @endif
                        </td>
                        <td>
                            @if($detail->jumlah_denda > 0)
                                <div class="denda-val">Rp {{ number_format($detail->jumlah_denda, 0, ',', '.') }}</div>
                                <div class="denda-status {{ $detail->status_denda === 'lunas' ? 'lunas' : 'belum' }}">
                                    {{ str_replace('_', ' ', $detail->status_denda) }}
                                </div>
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
                                    'hilang', 'rusak' => 'badge-danger',
                                    default        => 'badge-default',
                                };
                            @endphp
                            <span class="badge {{ $sc }}">{{ $detail->label_status }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Print Footer --}}
    <div class="print-footer" style="display: none;">
        <div class="sig-box">
            <p>Peminjam,</p>
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

@endsection