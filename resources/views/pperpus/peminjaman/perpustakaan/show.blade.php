@extends('pperpus.layouts.app')

@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap');

    
    :root {
        --local-primary: #0d9488;
        --local-primary-dark: #0f766e;
        --local-primary-light: #f0fdfa;
        --local-primary-border: #ccfbf1;
    }

    
    .detail-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        max-width: 1240px;
        margin: 0 auto;
        color: #334155;
        padding: 0.5rem;
        animation: rise .45s cubic-bezier(.16,1,.3,1) both;
    }
    @keyframes rise { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }

    
    .pg-head {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 1.75rem; gap: 1rem; flex-wrap: wrap;
    }
    .pg-head-left { display: flex; align-items: center; gap: 1.1rem; }
    .back-btn {
        width: 42px; height: 42px; border-radius: 10px; border: 1px solid #e2e8f0;
        background: #ffffff; display: flex; align-items: center; justify-content: center;
        color: #64748b; text-decoration: none; font-size: 0.95rem; flex-shrink: 0;
        transition: all .2s ease;
    }
    .back-btn:hover { border-color: var(--local-primary); color: var(--local-primary); background: var(--local-primary-light); transform: translateX(-2px); }
    .pg-title { font-size: 1.6rem; font-weight: 800; color: #0f172a; line-height: 1.15; margin: 0; }
    
    .btn-print {
        display: inline-flex; align-items: center; gap: .55rem;
        background: var(--local-primary); color: #ffffff; border: none;
        padding: 0.65rem 1.25rem; border-radius: 8px; font-weight: 700; font-size: .88rem;
        cursor: pointer; transition: all .2s ease; font-family: inherit;
        box-shadow: 0 1px 3px rgba(13, 148, 136, 0.2);
    }
    .btn-print:hover { background: var(--local-primary-dark); transform: translateY(-1px); box-shadow: 0 4px 6px rgba(13, 148, 136, 0.3); }

    
    .section-card {
        background: #ffffff; border-radius: 16px;
        border: 1px solid #e2e8f0; box-shadow: 0 4px 12px -1px rgba(0, 0, 0, 0.03);
        overflow: hidden; margin-bottom: 1.75rem;
    }
    .card-title-header {
        padding: 1.25rem 1.75rem;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.9rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        padding: 1.75rem;
    }
    .info-block { display: flex; flex-direction: column; gap: 0.45rem; }
    .info-label { font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px; color: #64748b; }
    .info-value { font-size: 0.98rem; font-weight: 700; color: #1e293b; }

    
    .badge {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .3rem .85rem; border-radius: 20px; font-size: .75rem; font-weight: 800;
        width: max-content;
    }
    .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; display: block; }
    .badge-warning { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    .badge-warning::before { background: #d97706; }
    .badge-success { background: #ccfbf1; color: #0f766e; border: 1px solid #99f6e4; }
    .badge-success::before { background: #0d9488; }
    .badge-danger  { background: #ffe4e6; color: #b91c1c; border: 1px solid #fecaca; }
    .badge-danger::before { background: #e11d48; }
    .badge-default { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .badge-default::before { background: #94a3b8; }

    
    .denda-banner {
        background: #fff1f2; border: 1px solid #ffe4e6;
        border-radius: 12px; margin: 0 1.75rem 1.5rem 1.75rem;
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.25rem; gap: 1rem; flex-wrap: wrap;
    }
    .denda-left { display: flex; align-items: center; gap: 1rem; }
    .denda-icon-wrap {
        width: 44px; height: 44px; border-radius: 50%; background: #e11d48; color: #fff;
        display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;
    }
    .denda-info-text .denda-label { font-size: .75rem; font-weight: 800; text-transform: uppercase; letter-spacing: .5px; color: #be123c; }
    .denda-amount { font-size: 1.35rem; font-weight: 800; color: #9f1239; margin: 0.1rem 0; }
    .denda-note { font-size: .82rem; color: #e11d48; font-weight: 500; }
    .btn-lunas {
        background: #e11d48; color: #fff; border: none; padding: .6rem 1.25rem; border-radius: 8px; font-weight: 700;
        font-size: .85rem; cursor: pointer; font-family: inherit; transition: all .2s ease; display: inline-flex; align-items: center; gap: .4rem;
        box-shadow: 0 4px 10px rgba(225,29,72,.2);
    }
    .btn-lunas:hover { background: #be123c; transform: translateY(-1px); }

    
    .tbl-wrap { overflow-x: auto; padding: 0 0 0.5rem 0; }
    .tbl { width: 100%; border-collapse: collapse; }
    .tbl thead th {
        padding: 1rem 1.25rem; font-size: .75rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: .7px; color: #64748b;
        background: #f8fafc; border-bottom: 1px solid #e2e8f0; text-align: left; white-space: nowrap;
    }
    .tbl tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .15s; }
    .tbl tbody tr:hover td { background: #f8fafc; }
    .tbl tbody tr:last-child { border-bottom: none; }
    .tbl tbody td { padding: 1.1rem 1.25rem; font-size: .9rem; color: #334155; vertical-align: middle; }
    
    .code-txt { font-family: 'JetBrains Mono', monospace; font-size: .82rem; font-weight: 700; color: var(--local-primary); }
    .book-title { font-size: .92rem; font-weight: 700; color: #0f172a; line-height: 1.4; }
    .chip-badge { font-size: .72rem; font-weight: 700; text-transform: uppercase; padding: .15rem .5rem; border-radius: 5px; background: #e2e8f0; color: #475569; display: inline-block; }
    .chip-badge.src { background: #e0f2fe; color: #0369a1; }
    .date-txt { font-size: .88rem; font-weight: 600; color: #1e293b; white-space: nowrap; }
    .late-txt { font-size: .75rem; font-weight: 700; color: #e11d48; margin-top: .2rem; display: block; }
    
    .denda-val { font-size: .88rem; font-weight: 700; color: #e11d48; }
    .denda-status { font-size: .68rem; font-weight: 800; text-transform: uppercase; letter-spacing: .4px; margin-top: .25rem; width: max-content; padding: 0.1rem 0.4rem; border-radius: 4px; }
    .denda-status.lunas { color: #0d9488; background: #ccfbf1; }
    .denda-status.belum { color: #b45309; background: #fef3c7; }

    .btn-extend {
        background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; display: inline-flex; align-items: center; justify-content: center; gap: .35rem; 
        padding: .45rem .8rem; border-radius: 6px; font-size: .78rem; font-weight: 700; cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
        white-space: nowrap; box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .btn-extend:hover { border-color: var(--local-primary); color: var(--local-primary); background: var(--local-primary-light); transform: translateY(-1px); }

    
    .modal-backdrop {
        display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); z-index: 1000; align-items: center; justify-content: center; padding: 1rem; backdrop-filter: blur(4px);
    }
    .modal-backdrop.open { display: flex; }
    .modal-box {
        background: #ffffff; border-radius: 16px; width: 100%; max-width: 440px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; overflow: hidden; animation: popIn .25s cubic-bezier(.16,1,.3,1);
    }
    @keyframes popIn { from { opacity:0; transform:scale(.95) translateY(8px); } to { opacity:1; transform:scale(1) translateY(0); } }
    .modal-mhd { padding: 1.1rem 1.25rem; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; background: #f8fafc; }
    .modal-mhd h3 { font-size: 0.95rem; font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: .5rem; }
    .modal-body { padding: 1.25rem; }
    .modal-foot { padding: 1rem 1.25rem; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: .6rem; background: #f8fafc; }
    .modal-close-btn { background: none; border: none; cursor: pointer; color: #94a3b8; font-size: 1.1rem; padding: .2rem; display: flex; align-items: center; }
    
    .form-grp { margin-bottom: 1rem; }
    .form-grp label { display: block; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: .45rem; }
    .form-input { width: 100%; padding: .65rem .9rem; border: 1.5px solid #e2e8f0; border-radius: 8px; font-family: inherit; font-size: .92rem; outline: none; transition: all .2s; color: #334155; box-sizing: border-box; background: #ffffff; }
    .form-input:focus { border-color: var(--local-primary); box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15); }
    .btn-cancel { padding: .55rem 1.1rem; border-radius: 6px; border: 1.5px solid #e2e8f0; background: #ffffff; color: #64748b; font-weight: 600; font-size: .84rem; cursor: pointer; transition: all .2s; }
    .btn-cancel:hover { border-color: #94a3b8; color: #334155; }
    .btn-submit { padding: .55rem 1.25rem; border-radius: 6px; border: none; background: var(--local-primary); color: #ffffff; font-weight: 700; font-size: .84rem; cursor: pointer; transition: all .2s; display: inline-flex; align-items: center; gap: .4rem; }
    .btn-submit:hover { background: var(--local-primary-dark); transform: translateY(-1px); box-shadow: 0 4px 6px rgba(13, 148, 136, 0.2); }

    
    .print-document { display: none; }
    @media print {
        @page { margin: 0; size: A4; }
        body { margin: 1.5cm !important; background: #ffffff !important; color: #000000 !important; font-family: 'Times New Roman', Times, serif; }
        .sidebar, .header, .detail-wrap, footer { display: none !important; }
        .main-wrapper { margin-left: 0 !important; padding: 0 !important; }
        .content { padding: 0 !important; }
        
        .print-document { display: block; width: 100%; font-size: 11pt; }
        
        
        .kop-surat { width: 100%; border-bottom: 4px double #000; padding-bottom: 10px; margin-bottom: 15px; }
        .kop-inner { display: table; width: 100%; }
        .kop-logo { display: table-cell; width: 90px; vertical-align: middle; text-align: center; }
        .kop-logo img { width: 80px; height: auto; }
        .kop-teks { display: table-cell; vertical-align: middle; text-align: center; padding-right: 90px; }
        .kop-teks .nama-instansi { font-size: 16pt; font-weight: bold; text-transform: uppercase; line-height: 1.2; }
        .kop-teks .alamat, .kop-teks .telp { font-size: 10pt; line-height: 1.3; }

        
        .judul-laporan { text-align: center; margin: 20px 0 20px 0; }
        .judul-laporan .judul-utama { font-size: 13pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
        .judul-laporan .sub-judul { font-size: 11pt; font-weight: bold; margin-top: 3px; }

        
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 10pt; }
        .meta-table td { padding: 4px; vertical-align: top; border: none !important; color: #000 !important; }

        
        .section-title { font-size: 10pt; font-weight: bold; margin-bottom: 6px; text-transform: uppercase; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 9.5pt; font-family: Arial, Helvetica, sans-serif; }
        .data-table th { background: #f0f0f0 !important; border: 1px solid #000; padding: 6px; text-align: center; font-weight: bold; -webkit-print-color-adjust: exact; color: #000 !important; text-transform: uppercase; }
        .data-table td { border: 1px solid #000; padding: 6px; color: #000 !important; }

        
        .ttd-section { margin-top: 40px; width: 100%; page-break-inside: avoid; }
        .ttd-table { width: 100%; border-collapse: collapse; }
        .ttd-table td { border: none !important; color: #000 !important; }
    }
</style>
@endpush

@section('content')


  @php
      $denda_resmi = $peminjaman->details->where('status_denda', 'belum_lunas')->sum('jumlah_denda');
      $denda_estimasi = $peminjaman->details->filter(function($d) {
          return $d->status_denda !== 'lunas' && $d->status_denda !== 'belum_lunas';
      })->sum(function($d) {
          return $d->denda_realtime ?? 0;
      });
      $realtime_total_denda = $denda_resmi + $denda_estimasi;
  @endphp

<div class="print-document">
    <div class="kop-surat">
        <div class="kop-inner">
            <div class="kop-logo">
                <img src="{{ asset('images/utama.png') }}" alt="Logo Sekolah">
            </div>
            <div class="kop-teks">
                <div class="nama-instansi">SMP Negeri 8 Percut Sei Tuan</div>
                <div class="alamat">Jalan Mesjid Desa Percut, Kecamatan Percut Sei Tuan, Kabupaten Deli Serdang</div>
                <div class="telp">Telp. (0831) 31163831 &nbsp;|&nbsp; Kode Pos 20371 &nbsp;|&nbsp; Sei Rotan</div>
            </div>
        </div>
    </div>

    <div class="judul-laporan">
        <div class="judul-utama">BUKTI TRANSAKSI PEMINJAMAN BUKU PERPUSTAKAAN</div>
        <div class="sub-judul">Sistem Informasi Perpustakaan (SIP)</div>
    </div>

    <table class="meta-table">
        <tr>
            <td width="130">Kode Peminjaman</td>
            <td width="10">:</td>
            <td width="260"><strong>{{ $peminjaman->kode_peminjaman }}</strong></td>
            <td width="130">Tanggal Pinjam</td>
            <td width="10">:</td>
            <td>{{ $peminjaman->tanggal_pinjam->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Nama Siswa</td>
            <td>:</td>
            <td><strong>{{ $peminjaman->siswa->nama_siswa }}</strong></td>
            <td>Status Transaksi</td>
            <td>:</td>
            <td><strong>{{ strtoupper($peminjaman->status_peminjaman) }}</strong></td>
        </tr>
        <tr>
            <td>NIS / Kelas</td>
            <td>:</td>
            <td>{{ $peminjaman->siswa->nis }} / {{ $peminjaman->siswa->kelas }}</td>
            <td>Keterangan</td>
            <td>:</td>
            <td>{{ $peminjaman->keterangan ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">DAFTAR BUKU YANG DIPINJAM</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Kode Buku</th>
                <th width="23%">Judul Buku</th>
                <th width="10%">Sumber</th>
                <th width="10%">Kategori</th>
                <th width="10%">Jatuh Tempo</th>
                <th width="10%">Tgl Kembali</th>
                <th width="10%">Denda</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman->details as $index => $detail)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ $detail->buku->kode_buku }}</td>
                <td>{{ $detail->buku->judul_buku }}</td>
                <td style="text-align: center;">{{ $detail->buku->sumber_buku ?? 'Perpustakaan' }}</td>
                <td style="text-align: center;">{{ $detail->buku->kategori->nama_kategori ?? 'Umum' }}</td>
                <td style="text-align: center;">{{ $detail->tanggal_jatuh_tempo ? $detail->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}</td>
                <td style="text-align: center;">{{ $detail->tanggal_kembali ? $detail->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                <td style="text-align: right;">{{ $detail->jumlah_denda > 0 ? 'Rp '.number_format($detail->jumlah_denda, 0, ',', '.') : '-' }}</td>
                <td style="text-align: center;">{{ ucwords(str_replace('_', ' ', $detail->status_detail)) }}</td>
            </tr>
            @endforeach
        </tbody>
        @if($realtime_total_denda > 0)
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right; font-weight: bold;">TOTAL TUNGGAKAN DENDA:</td>
                <td colspan="2" style="text-align: left; font-weight: bold;">Rp {{ number_format($realtime_total_denda, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="ttd-section">
        <table class="ttd-table">
            <tr>
                <td style="width: 50%; text-align: center;">
                    <br>
                    Siswa Peminjam
                    <br><br><br><br>
                    <strong><u>{{ $peminjaman->siswa->nama_siswa }}</u></strong><br>
                    NIS: {{ $peminjaman->siswa->nis }}
                </td>
                <td style="width: 50%; text-align: center;">
                    Sei Rotan, {{ now()->translatedFormat('d F Y') }}<br>
                    Petugas Perpustakaan
                    <br><br><br><br>
                    <strong><u>{{ auth()->user()->name }}</u></strong>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="detail-wrap">

    
    <div class="pg-head">
        <div class="pg-head-left">
            <a href="{{ route('pperpus.peminjaman.perpustakaan.index') }}" class="back-btn" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="pg-title">Detail Sirkulasi Peminjaman</h1>
            </div>
        </div>
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Dokumen
        </button>
    </div>

    
    <div class="section-card">
        <div class="card-title-header">
            <span><i class="fas fa-user-graduate" style="color: var(--local-primary); margin-right: 6px;"></i> Detail Identitas Peminjam</span>
        </div>
        <div class="info-grid">
            
            <div class="info-block">
                <span class="info-label">Nomor Induk Siswa (NIS)</span>
                <span class="info-value" style="font-family: 'JetBrains Mono', monospace; color: var(--local-primary);">{{ $peminjaman->siswa->nis }}</span>
            </div>
            
            <div class="info-block">
                <span class="info-label">Nama Siswa</span>
                <span class="info-value">{{ $peminjaman->siswa->nama_siswa }}</span>
            </div>
            
            <div class="info-block">
                <span class="info-label">Kelas</span>
                <span class="info-value">Kelas {{ $peminjaman->siswa->kelas }}</span>
            </div>
            
            <div class="info-block">
                <span class="info-label">Status Utama</span>
                <div>
                    @php
                        $statusMaster = match($peminjaman->status_peminjaman) {
                            'dipinjam'     => ['Sedang Dipinjam', 'badge-warning'],
                            'terlambat'    => ['Terlambat', 'badge-danger'],
                            'dikembalikan' => ['Dikembalikan', 'badge-success'],
                            'selesai'      => ['Selesai', 'badge-success'],
                            default        => [$peminjaman->status_peminjaman, 'badge-default'],
                        };
                    @endphp
                    <span class="badge {{ $statusMaster[1] }}">{{ $statusMaster[0] }}</span>
                </div>
            </div>
        </div>
    </div>


    
    <div class="section-card">
        <div class="card-title-header">
            <span><i class="fas fa-book" style="color: var(--local-primary); margin-right: 6px;"></i> Informasi Transaksi & Item Buku</span>
        </div>

        
        <div class="info-grid" style="border-bottom: 1px solid #e2e8f0; background: #fafafa; padding: 1.25rem 1.75rem;">
            <div class="info-block">
                <span class="info-label">Kode Peminjaman</span>
                <span class="info-value" style="font-family: 'JetBrains Mono', monospace; font-size: 1.05rem;">{{ $peminjaman->kode_peminjaman }}</span>
            </div>
            <div class="info-block">
                <span class="info-label">Tanggal Pinjam</span>
                <span class="info-value"><i class="far fa-calendar-alt" style="color: #64748b; margin-right: 4px;"></i> {{ $peminjaman->tanggal_pinjam->translatedFormat('d M Y') }}</span>
            </div>
            <div class="info-block" style="grid-column: span 2;">
                <span class="info-label">Total Item</span>
                <span class="info-value" style="font-size: 0.95rem; color: #475569;">{{ $peminjaman->details->count() }} Buku Terdaftar</span>
            </div>
        </div>

        
        @if($realtime_total_denda > 0 && $peminjaman->status_peminjaman !== 'selesai')
        <div class="denda-banner" style="margin-top: 1.5rem;">
              <div class="denda-left">
                  <div class="denda-icon-wrap"><i class="fas fa-hand-holding-usd"></i></div>
                  <div class="denda-info-text">
                      <div class="denda-label">Tunggakan Denda Aktif</div>
                      <div class="denda-amount">Rp {{ number_format($realtime_total_denda, 0, ',', '.') }}</div>
                      <div class="denda-note"><i class="fas fa-info-circle"></i> Terdeteksi total denda sirkulasi yang belum dilunasi.</div>
                  </div>
              </div>
              @if($denda_resmi > 0)
              <form action="{{ route('pperpus.pengembalian.perpustakaan.lunasSemuaDenda', $peminjaman->id_peminjaman) }}" method="POST" onsubmit="return confirm('Lunaskan semua denda untuk peminjaman ini?')" class="print-none">
                  @csrf
                  <button type="submit" class="btn-lunas">
                      <i class="fas fa-check-circle"></i> Lunaskan Denda
                  </button>
              </form>
              @else
              <div class="denda-note print-none" style="margin-left: auto; color: #e11d48; font-size: 0.85rem; font-weight: 700; background: rgba(255,255,255,0.7); padding: 0.5rem 1rem; border-radius: 8px;">
                  <i class="fas fa-exclamation-triangle"></i> Buku harus dikembalikan untuk melunasi denda.
              </div>
              @endif
          </div>
        @endif

        
        <div class="tbl-wrap">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Kode Buku</th>
                        <th>Judul Buku</th>
                        <th>Sumber Buku</th>
                        <th>Kategori Buku</th>
                        <th>Jatuh Tempo</th>
                        <th>Tanggal Kembali</th>
                        <th>Denda</th>
                        <th>Status Buku</th>
                        <th class="print-none">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman->details as $detail)
                    <tr>
                        
                        <td class="code-txt">{{ $detail->buku->kode_buku }}</td>
                        
                        
                        <td class="book-title">{{ $detail->buku->judul_buku }}</td>
                        
                        
                        <td>
                            <span class="chip-badge src">{{ $detail->buku->sumber_buku ?? 'Perpustakaan' }}</span>
                        </td>
                        
                        
                        <td>
                            <span class="chip-badge">{{ $detail->buku->kategori->nama_kategori ?? 'Umum' }}</span>
                        </td>
                        
                        
                        <td>
                            @if($detail->tanggal_jatuh_tempo)
                                <span class="date-txt">{{ $detail->tanggal_jatuh_tempo->translatedFormat('d/m/Y') }}</span>
                                @if($detail->status_detail === 'terlambat' && !$detail->tanggal_kembali)
                                    <span class="late-txt"><i class="fas fa-clock"></i> Terlambat {{ $detail->hari_terlambat_realtime }} Hari</span>
                                @endif
                            @else
                                <span style="color: #94a3b8;">—</span>
                            @endif
                        </td>
                        
                        
                        <td>
                            @if($detail->tanggal_kembali)
                                <span class="date-txt" style="color: #0d9488;">{{ $detail->tanggal_kembali->translatedFormat('d/m/Y') }}</span>
                            @else
                                <span style="color: #94a3b8; font-size: .85rem; font-style: italic;">Belum Kembali</span>
                            @endif
                        </td>
                        
                        
                        <td>
                            @if($detail->jumlah_denda > 0)
                                <div class="denda-val">Rp {{ number_format($detail->jumlah_denda, 0, ',', '.') }}</div>
                                <div class="denda-status {{ $detail->status_denda === 'lunas' ? 'lunas' : 'belum' }}">
                                    {{ ucwords(str_replace('_', ' ', $detail->status_denda)) }}
                                </div>
                            @elseif($detail->status_detail === 'terlambat' && !$detail->tanggal_kembali)
                                <div class="denda-val">Rp {{ number_format($detail->denda_realtime ?? 0, 0, ',', '.') }}</div>
                                <div class="denda-status belum">Estimasi (Belum Kembali)</div>
                            @else
                                <span style="color: #94a3b8;">—</span>
                            @endif
                        </td>
                        
                        
                        <td>
                            @php
                                $statusBuku = match($detail->status_detail) {
                                    'dipinjam'     => 'badge-warning',
                                    'terlambat'    => 'badge-danger',
                                    'dikembalikan' => 'badge-success',
                                    default        => 'badge-default',
                                };
                            @endphp
                            <span class="badge {{ $statusBuku }}">{{ $detail->label_status }}</span>
                        </td>
                        
                        
                        <td class="print-none">
                            @if(in_array($detail->status_detail, ['dipinjam', 'terlambat']))
                                <button class="btn-extend" onclick="openPerpanjangModal({{ $detail->id_detail }}, '{{ addslashes($detail->buku->judul_buku) }}', '{{ $detail->tanggal_jatuh_tempo ? $detail->tanggal_jatuh_tempo->format('Y-m-d') : '' }}')">
                                    <i class="fas fa-calendar-plus"></i> Perpanjang
                                </button>
                            @else
                                <span style="color: #94a3b8;">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    

</div>


<div class="modal-backdrop" id="perpanjangModal">
    <div class="modal-box">
        <div class="modal-mhd">
            <h3><i class="fas fa-calendar-plus" style="color: var(--local-primary)"></i> Perpanjang Masa Pinjam</h3>
            <button class="modal-close-btn" onclick="closePerpanjangModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <p style="font-size: .88rem; color: #1e293b; margin-bottom: 1.2rem; font-weight: 600;" id="modal-perpanjang-book"></p>
            <form id="formPerpanjang" method="POST">
                @csrf
                <div class="form-grp">
                    <label>Jatuh Tempo Baru</label>
                    <input type="date" name="tanggal_perpanjangan" id="tanggal_perpanjangan" class="form-input" required>
                </div>
            </form>
        </div>
        <div class="modal-foot">
            <button type="button" class="btn-cancel" onclick="closePerpanjangModal()">Batal</button>
            <button type="submit" class="btn-submit" form="formPerpanjang">
                <i class="fas fa-check"></i> Konfirmasi
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openPerpanjangModal(idDetail, title, currentJatuhTempo) {
    document.getElementById('modal-perpanjang-book').innerHTML = '<i class="fas fa-book" style="color:#64748b; margin-right:4px;"></i> <span style="color:#0f172a">' + title + '</span>';
    document.getElementById('formPerpanjang').action = '{{ url("/penjaga-perpustakaan/peminjaman") }}/{{ $peminjaman->id_peminjaman }}/detail/' + idDetail + '/perpanjang';
    
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    document.getElementById('tanggal_perpanjangan').min = tomorrow.toISOString().split('T')[0];
    
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