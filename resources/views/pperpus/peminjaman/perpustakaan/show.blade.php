@extends('pperpus.layouts.app')

@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;
    }
    .page-header .back-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 42px; height: 42px; border-radius: 12px;
        background: var(--surface); border: 1.5px solid var(--border);
        color: var(--text-muted); text-decoration: none; margin-right: .5rem;
        transition: all .2s;
    }
    .page-header .back-btn:hover { border-color: var(--primary); color: var(--primary); transform: translateX(-3px); }
    .page-header h1 { font-size: 1.5rem; font-weight: 800; color: var(--text); }
    
    .card {
        background: var(--surface); border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        overflow: hidden; border: 1px solid var(--border); margin-bottom: 1.5rem;
    }
    .card-header {
        padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        background: #fcfdfe;
    }
    .card-header h2 { font-size: 1rem; font-weight: 800; display: flex; align-items: center; gap: .7rem; color: var(--text); }
    .card-body { padding: 1.5rem; }

    .summary-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;
    }
    .summary-item {
        display: flex; flex-direction: column; gap: .3rem;
    }
    .summary-label { font-size: .75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
    .summary-value { font-size: 1rem; font-weight: 800; color: var(--text); }

    .pill {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .3rem .8rem; border-radius: 20px; font-size: .78rem; font-weight: 700;
    }
    .pill-warning { background: #fef9ec; color: #b45309; }
    .pill-success { background: #eafaf1; color: var(--success); }
    .pill-info    { background: #ebf5fb; color: var(--info); }
    .pill-danger  { background: #fdf2f2; color: var(--danger); }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc; font-size: .75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .8px; color: var(--text-muted);
        padding: 1rem 1.2rem; border-bottom: 1px solid var(--border); text-align: left;
    }
    tbody td {
        padding: 1rem 1.2rem; font-size: .9rem;
        border-bottom: 1px solid #f1f5f9; vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }

    .btn-action {
        padding: .5rem 1rem; border-radius: 8px; font-size: .8rem; font-weight: 700;
        cursor: pointer; border: 1.5px solid var(--border); background: #fff;
        transition: all .2s; display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    }
    .btn-action:hover { border-color: var(--primary); color: var(--primary); background: #f4f8fd; }
    .btn-success { background: var(--success); color: #fff; border: none; }
    .btn-success:hover { background: #059669; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2); color: #fff; }

    /* Modal Styling */
    .modal {
        display: none; position: fixed; inset: 0; background: rgba(11, 61, 34, 0.6);
        z-index: 2000; align-items: center; justify-content: center; padding: 1rem;
        backdrop-filter: blur(4px);
    }
    .modal.show { display: flex; }
    .modal-content {
        background: #fff; border-radius: 20px; width: 100%; max-width: 500px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden;
        animation: modalScale .3s ease-out;
    }
    @keyframes modalScale { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    
    .modal-header { padding: 1.5rem; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .modal-header h3 { font-size: 1.1rem; font-weight: 800; color: var(--text); }
    .modal-body { padding: 1.5rem; }
    .modal-footer { padding: 1.2rem 1.5rem; background: #f8fafc; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: .8rem; }

    .form-group { margin-bottom: 1.2rem; }
    .form-group label { display: block; font-size: .8rem; font-weight: 700; margin-bottom: .4rem; color: var(--text-muted); text-transform: uppercase; }
    .form-control {
        width: 100%; padding: .7rem .9rem; border: 1.5px solid var(--border);
        border-radius: 10px; font-family: inherit; font-size: .92rem; outline: none;
    }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(20, 90, 50, 0.08); }

    .print-only { display: none; }

    /* PRINT STYLES */
    @media print {
        @page { margin: 1.5cm; }
        body { background: #fff !important; color: #000 !important; font-size: 11pt !important; }
        .sidebar, .header, .back-btn, .btn-action, .btn-success, .sidebar-footer, .card-header button, .modal, hr { display: none !important; }
        .main-wrapper { margin-left: 0 !important; padding: 0 !important; }
        .content { padding: 0 !important; }
        .page-header { margin-bottom: 1.5rem !important; border-bottom: 2px solid #000; padding-bottom: 1rem; }
        .page-header h1 { font-size: 1.6rem !important; margin: 0 !important; text-align: center; width: 100%; }
        .page-header div { width: 100%; }
        .page-header div div { text-align: center; }
        
        .print-only { 
            display: block !important; 
            text-align: center; 
            margin-bottom: 2rem;
            border-bottom: 2px solid #000;
            padding-bottom: 1rem;
        }
        .print-header { display: flex; align-items: center; justify-content: center; gap: 1.5rem; margin-bottom: 1rem; }
        .print-logo { font-size: 2.5rem; color: #000; }
        .print-title h1 { font-size: 1.4rem; margin: 0; font-weight: 800; text-transform: uppercase; }
        .print-title p { font-size: .8rem; margin: .2rem 0; }

        .card { box-shadow: none !important; border: 1px solid #000 !important; margin-bottom: 1.5rem !important; border-radius: 0 !important; }
        .card-header { background: #eee !important; border-bottom: 1px solid #000 !important; -webkit-print-color-adjust: exact; }
        .card-header h2 { font-size: 1rem !important; color: #000 !important; }
        .pill { border: 1px solid #000 !important; background: transparent !important; color: #000 !important; }
        
        table { border: 1px solid #000 !important; }
        thead th { background: #eee !important; border-bottom: 1px solid #000 !important; color: #000 !important; -webkit-print-color-adjust: exact; }
        tbody td { border-bottom: 1px solid #000 !important; color: #000 !important; }
        
        .print-footer {
            display: block !important;
            margin-top: 3rem;
            display: flex !important;
            justify-content: space-between;
        }
        .signature-box { text-align: center; width: 200px; }
        .signature-space { height: 70px; }
        .signature-name { font-weight: 800; text-decoration: underline; }
        thead th:last-child, tbody td:last-child { display: none !important; }
    }
</style>
@endpush

@section('content')

{{-- Header khusus cetak --}}
<div class="print-only">
    <div class="print-header">
        <div class="print-logo"><i class="fas fa-book-reader"></i></div>
        <div class="print-title">
            <h1>BUKTI TRANSAKSI PERPUSTAKAAN</h1>
            <p>Sistem Informasi Perpustakaan (SIP) Sekolah</p>
            <p style="font-size: 0.7rem; color: #555;">Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}</p>
        </div>
    </div>
</div>

<div class="page-header">
    <div style="display:flex; align-items:center">
        <a href="{{ route('pperpus.peminjaman.perpustakaan.index') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
        <div>
            <h1>Detail Peminjaman</h1>
            <div style="display:flex; align-items:center; gap:.5rem; margin-top:.3rem">
                <span style="font-family: monospace; font-weight: 800; background: var(--bg); padding: .2rem .5rem; border-radius: 6px; color: var(--primary)">{{ $peminjaman->kode_peminjaman }}</span>
                <span style="color: var(--text-muted); font-size: .85rem">•</span>
                <span style="font-size: .85rem; color: var(--text-muted)">{{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}</span>
            </div>
        </div>
    </div>
    <div style="display:flex; gap:.7rem">
        <button class="btn-action" style="background:var(--primary); color:#fff; border:none; padding: .6rem 1.2rem" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Bukti
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-user-circle"></i> Informasi Peminjam</h2>
        @php
            $pjmStatus = match($peminjaman->status_peminjaman) {
                'dipinjam'     => ['Sedang Dipinjam', 'pill-warning'],
                'dikembalikan' => ['Selesai', 'pill-success'],
                'selesai'      => ['Selesai', 'pill-success'],
                default        => [$peminjaman->status_peminjaman, 'pill-info']
            };
        @endphp
        <span class="pill {{ $pjmStatus[1] }}">{{ $pjmStatus[0] }}</span>
    </div>
    <div class="card-body">
        <div class="summary-grid">
            <div class="summary-item">
                <span class="summary-label">NIS</span>
                <span class="summary-value">{{ $peminjaman->siswa->nis }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Nama Siswa</span>
                <span class="summary-value">{{ $peminjaman->siswa->nama_siswa }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Kelas</span>
                <span class="summary-value">{{ $peminjaman->siswa->kelas }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Total Denda Tunggakan</span>
                <span class="summary-value" style="color:var(--danger)">Rp {{ number_format($peminjaman->total_denda, 0, ',', '.') }}</span>
            </div>
            <div class="summary-item" style="grid-column: 1 / -1;">
                <span class="summary-label">Keterangan / Catatan</span>
                <span class="summary-value" style="font-weight: 500;">{{ $peminjaman->keterangan ?? 'Tidak ada catatan.' }}</span>
            </div>
        </div>
    </div>
</div>

@if($peminjaman->total_denda > 0 && $peminjaman->status_peminjaman !== 'selesai')
<div class="card" style="border: 1px solid #f5c6c2; background: #fffaf9">
    <div class="card-body" style="text-align:center; padding: 1.8rem">
        <div style="width:50px; height:50px; background:#fdf0ef; color:var(--danger); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; font-size:1.5rem">
            <i class="fas fa-hand-holding-usd"></i>
        </div>
        <h3 style="font-size:1rem; font-weight:800; margin-bottom:.5rem">Tunggakan Denda Perpustakaan</h3>
        <p style="font-size:.82rem; color:var(--text-muted); margin-bottom:1.5rem">Siswa masih memiliki tunggakan sebesar <strong style="color:var(--danger)">Rp {{ number_format($peminjaman->total_denda, 0, ',', '.') }}</strong></p>
        <form action="{{ route('pperpus.pengembalian.perpustakaan.lunasSemuaDenda', $peminjaman->id_peminjaman) }}" method="POST" onsubmit="return confirm('Lunaskan semua denda untuk peminjaman Perpustakaan ini?')">
            @csrf
            <button type="submit" class="btn-success" style="padding:.85rem 2rem; border-radius:12px; font-weight:800; cursor:pointer;">
                <i class="fas fa-check-circle"></i> Lunaskan Sekarang
            </button>
        </form>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-book-open"></i> Koleksi Buku Dipinjam</h2>
        <div style="font-size: .85rem; font-weight: 700; color: var(--text-muted)">{{ $peminjaman->details->count() }} Buku</div>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Informasi Buku</th>
                    <th>Jatuh Tempo</th>
                    <th>Tgl Kembali</th>
                    <th>Denda</th>
                    <th>Status</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjaman->details as $detail)
                <tr>
                    <td>
                        <div style="font-weight:800; color: var(--text)">{{ $detail->buku->judul_buku }}</div>
                        <div style="display:flex; align-items:center; gap:.5rem; margin-top:.3rem">
                            <span style="font-size:.7rem; background:#f1f5f9; padding:.1rem .4rem; border-radius:4px; font-weight:700; color:var(--text-muted)">{{ strtoupper($detail->buku->kategoriBuku->nama_kategori ?? 'BUKU PERPUS') }}</span>
                            <span style="font-size:.75rem; color:var(--primary); font-weight:700">{{ $detail->buku->kode_buku }}</span>
                        </div>
                    </td>
                    <td>
                        @if($detail->tanggal_jatuh_tempo)
                            <div style="font-weight:700">{{ $detail->tanggal_jatuh_tempo->format('d/m/Y') }}</div>
                            @if($detail->status_detail === 'terlambat' && !$detail->tanggal_kembali)
                                <div style="font-size:.7rem; color:var(--danger); font-weight:800; margin-top:.2rem"><i class="fas fa-exclamation-circle"></i> TERLAMBAT {{ $detail->hari_terlambat_realtime }} HARI</div>
                            @endif
                        @else
                            <span style="color:var(--text-muted)">—</span>
                        @endif
                    </td>
                    <td>
                        @if($detail->tanggal_kembali)
                            <div style="font-weight:700">{{ $detail->tanggal_kembali->format('d/m/Y') }}</div>
                        @else
                            <span style="font-size:.8rem; color:var(--text-muted); font-style:italic">Belum Kembali</span>
                        @endif
                    </td>
                    <td>
                        @if($detail->jumlah_denda > 0)
                            <div style="color:var(--danger); font-weight:800">Rp {{ number_format($detail->jumlah_denda, 0, ',', '.') }}</div>
                            <div style="font-size:.68rem; font-weight:800; text-transform:uppercase; margin-top:.1rem; color:{{ $detail->status_denda === 'lunas' ? 'var(--success)' : 'var(--warning)' }}">
                                {{ str_replace('_',' ',$detail->status_denda) }}
                            </div>
                        @else
                            <span style="color:var(--text-muted)">—</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $sClass = match($detail->status_detail) {
                                'dipinjam'     => 'pill-warning',
                                'terlambat'    => 'pill-danger',
                                'dikembalikan' => 'pill-success',
                                'hilang', 'rusak' => 'pill-danger',
                                default        => 'pill-info'
                            };
                        @endphp
                        <span class="pill {{ $sClass }}">{{ $detail->label_status }}</span>
                    </td>
                    <td style="text-align:right;">
                        @if($detail->sumber_buku === 'buku perpus' && in_array($detail->status_detail, ['dipinjam', 'terlambat']))
                            @php
                                $diff = \Carbon\Carbon::now()->startOfDay()->diffInDays($detail->tanggal_jatuh_tempo ? $detail->tanggal_jatuh_tempo->startOfDay() : \Carbon\Carbon::now()->startOfDay(), false);
                            @endphp
                            @if($diff <= 1)
                            <button type="button" class="btn-action" style="color:var(--info); border-color:var(--info); padding:.4rem .8rem" title="Perpanjang Masa Pinjam" onclick="openPerpanjangModal('{{ $detail->id_detail }}', '{{ addslashes($detail->buku->judul_buku) }}', '{{ $detail->tanggal_jatuh_tempo ? $detail->tanggal_jatuh_tempo->format('Y-m-d') : date('Y-m-d') }}')">
                                <i class="fas fa-calendar-plus"></i> Perpanjang
                            </button>
                            @else
                            <span style="font-size: .75rem; color: var(--text-muted); font-style: italic;">Hanya opsi perpanjang</span>
                            @endif
                        @else
                            <span style="color:var(--text-muted); font-size:.8rem">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="print-footer" style="display: none;">
    <div class="signature-box">
        <p>Peminjam,</p>
        <div class="signature-space"></div>
        <p class="signature-name">{{ $peminjaman->siswa->nama_siswa }}</p>
    </div>
    <div class="signature-box">
        <p>Petugas Perpustakaan,</p>
        <div class="signature-space"></div>
        <p class="signature-name">{{ auth()->user()->name }}</p>
    </div>
</div>

{{-- Modal Perpanjangan --}}
<div class="modal" id="modal-perpanjang">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-calendar-plus" style="color:var(--info); margin-right:.5rem"></i> Perpanjang Pinjaman</h3>
            <i class="fas fa-times" style="cursor:pointer; color:var(--text-muted)" onclick="closePerpanjangModal()"></i>
        </div>
        <form id="form-perpanjang" method="POST">
            @csrf
            <div class="modal-body">
                <div id="modal-perpanjang-title" style="font-size:1.1rem; font-weight:800; color:var(--info); margin-bottom:1.5rem; padding-bottom:1rem; border-bottom:1px dashed var(--border)"></div>
                
                <div class="form-group">
                    <label>Batas Waktu Baru (Tanggal Kembali)</label>
                    <input type="date" name="tanggal_perpanjangan" id="input-tanggal-perpanjangan" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="padding:.7rem 1.5rem" onclick="closePerpanjangModal()">Batal</button>
                <button type="submit" class="btn-success" style="padding:.7rem 2rem; border-radius:12px; font-weight:800; background:var(--info)">Simpan Perpanjangan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openPerpanjangModal(idDetail, judul, currentTempo) {
        const modal = document.getElementById('modal-perpanjang');
        const form = document.getElementById('form-perpanjang');
        const title = document.getElementById('modal-perpanjang-title');
        const inputDate = document.getElementById('input-tanggal-perpanjangan');
        
        title.textContent = judul;
        
        let baseUrl = "{{ route('pperpus.peminjaman.detail.perpanjang', ['__pjm__', '__dtl__']) }}";
        baseUrl = baseUrl.replace('__pjm__', '{{ $peminjaman->id_peminjaman }}').replace('__dtl__', idDetail);
        form.action = baseUrl;
        
        // set min date to current tempo + 1 day
        let minDate = new Date(currentTempo);
        minDate.setDate(minDate.getDate() + 1);
        inputDate.min = minDate.toISOString().split('T')[0];
        
        // default value to current tempo + 7 days
        let defaultDate = new Date(currentTempo);
        defaultDate.setDate(defaultDate.getDate() + 7);
        inputDate.value = defaultDate.toISOString().split('T')[0];
        
        modal.classList.add('show');
    }

    function closePerpanjangModal() {
        document.getElementById('modal-perpanjang').classList.remove('show');
    }

    window.onclick = function(e) {
        if (e.target.classList.contains('modal')) {
            closePerpanjangModal();
        }
    }
</script>
@endpush
