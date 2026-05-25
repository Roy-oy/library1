@extends('pperpus.layouts.app')

@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;
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
    
    .detail-grid {
        display: grid; grid-template-columns: 320px 1fr; gap: 1.5rem; align-items: start;
    }
    @media (max-width: 1100px) { .detail-grid { grid-template-columns: 1fr; } }

    .detail-sidebar {
        display: flex; flex-direction: column; gap: 1.5rem;
    }

    .card {
        background: var(--surface); border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        overflow: hidden; border: 1px solid var(--border);
    }
    .card-header {
        padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between;
        background: #fcfdfe;
    }
    .card-header h2 { font-size: 1rem; font-weight: 800; display: flex; align-items: center; gap: .7rem; color: var(--text); }
    .card-body { padding: 1.5rem; }

    .info-list { list-style: none; padding: 0; margin: 0; }
    .info-item {
        display: flex; flex-direction: column; gap: .2rem; padding: .8rem 0;
        border-bottom: 1px solid #f8fafc;
    }
    .info-item:last-child { border-bottom: none; }
    .info-label { font-size: .75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
    .info-value { font-size: .95rem; font-weight: 800; color: var(--text); }

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
        background: #f8fafc; font-size: .72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .8px; color: var(--text-muted);
        padding: 1rem 1.2rem; border-bottom: 1px solid var(--border);
        text-align: left;
    }
    tbody td {
        padding: 1rem 1.2rem; font-size: .9rem;
        border-bottom: 1px solid #f1f5f9; vertical-align: middle;
    }

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

    /* Print Header - Hidden by default */
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

        .detail-grid { display: block !important; }
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
        <a href="{{ route('pperpus.peminjaman.bos.index') }}" class="back-btn"><i class="fas fa-arrow-left"></i></a>
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

<div class="detail-grid">
    {{-- Left: Transaction Summary --}}
    <div class="detail-sidebar">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-user-circle"></i> Data Peminjam</h2>
                @php
                    $pjmStatus = match($peminjaman->status_peminjaman) {
                        'dipinjam'     => ['Sedang Dipinjam', 'pill-warning'],
                        'dikembalikan' => ['Belum Lunas', 'pill-danger'],
                        'selesai'      => ['Selesai', 'pill-success'],
                        default        => [$peminjaman->status_peminjaman, 'pill-info']
                    };
                @endphp
                <span class="pill {{ $pjmStatus[1] }}">{{ $pjmStatus[0] }}</span>
            </div>
            <div class="card-body">
                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-label">Nama Siswa</span>
                        <span class="info-value">{{ $peminjaman->siswa->nama_siswa }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">NIS / Kelas</span>
                        <span class="info-value">{{ $peminjaman->siswa->nis }} • {{ $peminjaman->siswa->kelas }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Total Denda</span>
                        <span class="info-value" style="color:var(--danger)">Rp {{ number_format($peminjaman->total_denda, 0, ',', '.') }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Catatan</span>
                        <div style="font-size: .88rem; line-height: 1.5; color: var(--text); margin-top: .2rem">
                            {{ $peminjaman->keterangan ?? '—' }}
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        @if($peminjaman->total_denda > 0 && $peminjaman->status_peminjaman !== 'selesai')
        <div class="card" style="border: 1px solid #f5c6c2; background: #fffaf9">
            <div class="card-body" style="text-align:center; padding: 1.8rem">
                <div style="width:50px; height:50px; background:#fdf0ef; color:var(--danger); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; font-size:1.5rem">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <h3 style="font-size:1rem; font-weight:800; margin-bottom:.5rem">Tunggakan Denda</h3>
                <p style="font-size:.82rem; color:var(--text-muted); margin-bottom:1.5rem">Siswa masih memiliki tunggakan sebesar <strong style="color:var(--danger)">Rp {{ number_format($peminjaman->total_denda, 0, ',', '.') }}</strong></p>
                <form action="{{ route('pperpus.peminjaman.lunasSemuaDenda', $peminjaman->id_peminjaman) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-success" style="width:100%; padding:.85rem; border-radius:12px; font-weight:800">
                        Lunaskan Sekarang
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    {{-- Right: Books List --}}
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-book-open"></i> Koleksi Buku Dipinjam</h2>
                <div style="font-size: .85rem; font-weight: 700; color: var(--text-muted)">{{ $peminjaman->details->count() }} Item</div>
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
                            <th style="text-align:right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjaman->details as $detail)
                        <tr>
                            <td>
                                <div style="font-weight:800; color: var(--text)">{{ $detail->buku->judul_buku }}</div>
                                <div style="display:flex; align-items:center; gap:.5rem; margin-top:.2rem">
                                    <span style="font-size:.7rem; background:#f1f5f9; padding:.1rem .4rem; border-radius:4px; font-weight:700; color:var(--text-muted)">{{ strtoupper($detail->sumber_buku) }}</span>
                                    <span style="font-size:.75rem; color:var(--primary); font-weight:700">{{ $detail->buku->kode_buku }}</span>
                                </div>
                                @if($detail->keterangan)
                                    <div style="font-size: .75rem; color: var(--text-muted); margin-top: .4rem; padding-top: .4rem; border-top: 1px dashed #eee; font-style: italic">
                                        <i class="fas fa-comment-alt" style="font-size: .65rem"></i> {{ $detail->keterangan }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($detail->tanggal_jatuh_tempo)
                                    <div style="font-weight:700">{{ $detail->tanggal_jatuh_tempo->format('d/m/Y') }}</div>
                                    @if($detail->status_detail === 'terlambat' && !$detail->tanggal_kembali)
                                        <div style="font-size:.7rem; color:var(--danger); font-weight:800; margin-top:.1rem"><i class="fas fa-exclamation-circle"></i> TERLAMBAT {{ $detail->hari_terlambat_realtime }} HARI</div>
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
                            <td style="text-align:right; white-space:nowrap">
                                <div style="display:flex; justify-content:flex-end; gap:.4rem">
                                    @if(in_array($detail->status_detail, ['dipinjam', 'terlambat']))
                                        <button class="btn-action btn-success" onclick="openReturnModal('{{ $detail->id_detail }}', '{{ addslashes($detail->buku->judul_buku) }}')">
                                            <i class="fas fa-undo"></i> Kembali
                                        </button>
                                    @endif

                                    @if($detail->status_denda === 'belum_lunas')
                                        <form action="{{ route('pperpus.peminjaman.lunasDenda', [$peminjaman->id_peminjaman, $detail->id_detail]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-action" style="color:var(--success); border-color:var(--success)">
                                                <i class="fas fa-check"></i> Lunas
                                            </button>
                                        </form>
                                    @endif

                                    <div style="display:flex; gap:.3rem">
                                        @if($detail->sumber_buku === 'buku perpus' && $detail->status_detail === 'dipinjam')
                                            <form action="{{ route('pperpus.peminjaman.detail.perpanjang', [$peminjaman->id_peminjaman, $detail->id_detail]) }}" method="POST" style="display:inline">
                                                @csrf
                                                <input type="hidden" name="tambah_hari" value="7">
                                                <button type="submit" class="btn-action" title="Perpanjang" onclick="return confirm('Perpanjang 7 hari?')">
                                                    <i class="fas fa-history"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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

{{-- Modal Pengembalian --}}
<div class="modal" id="modal-kembali">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-book-reader" style="color:var(--primary); margin-right:.5rem"></i> Proses Kembali</h3>
            <i class="fas fa-times" style="cursor:pointer; color:var(--text-muted)" onclick="closeModal()"></i>
        </div>
        <form id="form-kembali" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div id="modal-book-title" style="font-size:1.1rem; font-weight:800; color:var(--primary); margin-bottom:1.5rem; padding-bottom:1rem; border-bottom:1px dashed var(--border)"></div>
                
                <div class="form-group">
                    <label>Tanggal Kembali</label>
                    <input type="date" name="tanggal_pengembalian" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label>Kondisi Buku</label>
                    <select name="status_buku" class="form-control" required onchange="toggleDendaField(this.value)">
                        <option value="kembali">Kondisi Baik</option>
                        <option value="rusak">Rusak / Sobek</option>
                        <option value="hilang">Hilang</option>
                    </select>
                </div>

                <div id="denda-ganti-group" class="form-group" style="display:none">
                    <label>Denda Ganti (Rp)</label>
                    <input type="number" name="denda_ganti" class="form-control" placeholder="Nominal ganti rugi...">
                </div>

                <div class="form-group">
                    <label>Catatan Petugas</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan tambahan..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-action" style="padding:.7rem 1.5rem" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-success" style="padding:.7rem 2rem; border-radius:12px; font-weight:800">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openReturnModal(id, judul) {
        const modal = document.getElementById('modal-kembali');
        const form = document.getElementById('form-kembali');
        const title = document.getElementById('modal-book-title');
        
        title.textContent = judul;
        form.action = `/penjaga-perpustakaan/peminjaman/kembalikan/${id}`;
        modal.classList.add('show');
    }

    function closeModal() {
        document.getElementById('modal-kembali').classList.remove('show');
    }

    function toggleDendaField(val) {
        const group = document.getElementById('denda-ganti-group');
        group.style.display = (val === 'rusak' || val === 'hilang') ? 'block' : 'none';
    }

    window.onclick = function(e) {
        if (e.target.classList.contains('modal')) closeModal();
    }
</script>
@endpush
