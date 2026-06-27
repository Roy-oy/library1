<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Denda Keterlambatan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            color: #1a1a1a;
            background: #fff;
            padding: 28px 36px;
        }

        
        .kop-surat {
            width: 100%;
            border-bottom: 4px double #1a1a1a;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .kop-inner {
            display: table;
            width: 100%;
        }
        .kop-logo {
            display: table-cell;
            width: 90px;
            vertical-align: middle;
            text-align: center;
        }
        .kop-logo img {
            width: 80px;
            height: auto;
        }
        .kop-teks {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding-right: 90px; 
        }
        .kop-teks .nama-instansi {
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            line-height: 1.2;
        }
        .kop-teks .alamat {
            font-size: 10pt;
            margin-top: 4px;
            line-height: 1.3;
        }
        .kop-teks .telp {
            font-size: 10pt;
            margin-top: 3px;
        }

        
        .judul-laporan {
            text-align: center;
            margin: 20px 0 15px;
        }
        .judul-laporan .judul-utama {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .judul-laporan .sub-judul {
            font-size: 11pt;
            font-weight: bold;
            margin-top: 3px;
        }
        .judul-laporan .meta-info {
            margin-top: 12px;
            width: 100%;
        }
        .judul-laporan .meta-info table {
            margin: 0 auto;
            border: none;
            border-collapse: collapse;
        }
        .judul-laporan .meta-info td {
            border: none !important;
            padding: 2px 4px;
            font-size: 10pt;
            text-align: left;
            vertical-align: middle;
        }

        
        .tabel-wrapper {
            margin-top: 10px;
        }

        table.tabel-data {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8.5pt;
        }

        table.tabel-data thead tr th {
            background-color: #1e3a5f;
            color: #ffffff;
            text-align: center;
            padding: 6px 4px;
            border: 1px solid #1e3a5f;
            font-weight: bold;
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        table.tabel-data tbody tr td {
            border: 1px solid #b0b0b0;
            padding: 5px 4px;
            vertical-align: middle;
            color: #1a1a1a;
        }

        table.tabel-data tbody tr:nth-child(even) td {
            background-color: #f0f4fa;
        }

        table.tabel-data tfoot tr th {
            background-color: #1e3a5f;
            color: #ffffff;
            padding: 6px 8px;
            border: 1px solid #1e3a5f;
            font-size: 9pt;
        }

        .pill-success { color: #1a6b2f; font-weight: bold; }
        .pill-danger { color: #b91c1c; font-weight: bold; }

        
        .ttd-section {
            margin-top: 35px;
            width: 100%;
        }
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }
        .ttd-table td {
            border: none !important;
            vertical-align: top;
        }
        .ttd-kanan-box {
            width: 250px;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
        }
        .ttd-info-cetak {
            text-align: center;
            margin-bottom: 45px;
        }
        .ttd-garis-nama {
            text-align: center;
            margin-bottom: 4px;
        }
        .ttd-nama {
            text-align: center;
        }
    </style>
</head>
<body>

    
    <div class="kop-surat">
        <div class="kop-inner">
            <div class="kop-logo">
                @php
                    $imagePath = public_path('images/utama.png');
                    $src = '';
                    if (file_exists($imagePath)) {
                        $imageData = base64_encode(file_get_contents($imagePath));
                        $src = 'data:image/jpeg;base64,' . $imageData;
                    }
                @endphp
                @if($src)
                    <img src="{{ $src }}" alt="Logo Sekolah">
                @endif
            </div>
            <div class="kop-teks">
                <div class="nama-instansi">SMP Negeri 8 Percut Sei Tuan</div>
                <div class="alamat">Jalan Mesjid Desa Percut, Kecamatan Percut Sei Tuan, Kabupaten Deli Serdang</div>
                <div class="telp">Telp. (0831) 31163831 &nbsp;|&nbsp; Kode Pos 20371 &nbsp;|&nbsp; Sei Rotan</div>
            </div>
        </div>
    </div>

    
    <div class="judul-laporan">
        <div class="judul-utama">Laporan Denda Keterlambatan</div>
        <div class="sub-judul">Perpustakaan SMP Negeri 8 Percut Sei Tuan</div>
        <div class="meta-info">
            <table>
                <tr>
                    <td style="width: 110px;">Status Denda</td>
                    <td style="width: 10px;">:</td>
                    <td>
                        <strong>
                            @if($status == 'lunas')
                                LUNAS
                            @elseif($status == 'belum_lunas')
                                BELUM LUNAS
                            @else
                                SEMUA STATUS
                            @endif
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td style="width: 110px;">Periode</td>
                    <td style="width: 10px;">:</td>
                    <td>
                        <strong>
                            @if($start_date && $end_date)
                                {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d F Y') }}
                            @elseif($start_date)
                                Mulai {{ \Carbon\Carbon::parse($start_date)->translatedFormat('d F Y') }}
                            @elseif($end_date)
                                Sampai {{ \Carbon\Carbon::parse($end_date)->translatedFormat('d F Y') }}
                            @else
                                Semua Waktu
                            @endif
                        </strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    
    <div class="tabel-wrapper">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 8%;">Kode Peminjaman</th>
                    <th style="width: 5%;">NIS</th>
                    <th style="width: 11%;">Nama Siswa</th>
                    <th style="width: 4%;">Kelas</th>
                    <th style="width: 7%;">Tgl Pinjam</th>
                    <th style="width: 7%;">Harus Kembali</th>
                    <th style="width: 7%;">Tgl Kembali</th>
                    <th style="width: 7%;">Kode Buku</th>
                    <th style="width: 12%;">Judul Buku (Kategori)</th>
                    <th style="width: 4%;">Telat(Hr)</th>
                    <th style="width: 8%;">Denda(Rp)</th>
                    <th style="width: 6%;">Status</th>
                    <th style="width: 11%;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $totalDenda = 0; @endphp
                @forelse($reports as $report)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td style="text-align: center;">{{ $report->peminjaman->kode_peminjaman ?? '-' }}</td>
                        <td style="text-align: center;">{{ $report->peminjaman->siswa->nis ?? '-' }}</td>
                        <td>{{ $report->peminjaman->siswa->nama_siswa ?? '-' }}</td>
                        <td style="text-align: center;">{{ $report->peminjaman->siswa->kelas ?? '-' }}</td>
                        <td style="text-align: center;">
                            {{ $report->peminjaman->tanggal_pinjam ? $report->peminjaman->tanggal_pinjam->format('d/m/Y') : '-' }}
                        </td>
                        <td style="text-align: center;">
                            {{ $report->tanggal_jatuh_tempo ? $report->tanggal_jatuh_tempo->format('d/m/Y') : '-' }}
                        </td>
                        <td style="text-align: center;">
                            {{ $report->tanggal_kembali ? $report->tanggal_kembali->format('d/m/Y') : '-' }}
                        </td>
                        <td style="text-align: center;">{{ $report->buku->kode_buku ?? '-' }}</td>
                        <td>
                            @if($report->sumber_buku === 'bos')
                                <strong>Buku BOS:</strong> {{ $report->buku->judul_buku ?? '-' }}
                            @else
                                {{ $report->buku->judul_buku ?? '-' }}
                            @endif
                            <br>
                            <small style="color: #2563eb;">({{ $report->sumber_buku === 'bos' ? 'BOS' : (optional($report->buku->kategoriBuku)->nama_kategori ?? 'Tanpa Kategori') }})</small>
                        </td>
                        <td style="text-align: center;">{{ $report->jumlah_hari_terlambat }}</td>
                        <td style="text-align: right;">
                            {{ number_format($report->jumlah_denda, 0, ',', '.') }}
                        </td>
                        <td style="text-align: center;" class="{{ $report->status_denda == 'lunas' ? 'pill-success' : 'pill-danger' }}">
                            {{ $report->status_denda == 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                        </td>
                        <td>{{ $report->keterangan ?? '-' }}</td>
                    </tr>
                    @php $totalDenda += $report->jumlah_denda; @endphp
                @empty
                    <tr>
                        <td colspan="14" style="text-align: center; padding: 20px; font-style: italic; color: #555;">
                            Tidak ada data denda pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="11" style="text-align: right; letter-spacing: 0.3px;">TOTAL DENDA :</th>
                    <th style="text-align: right; color: #ffd700; font-size: 10pt;">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </div>

    
    <div class="ttd-section">
        <table class="ttd-table">
            <tr>
                <td></td>
                <td style="width: 250px;">
                    <div class="ttd-kanan-box">
                        <div class="ttd-info-cetak">
                            <span style="font-size: 8pt; color: #666; display: block; text-align: right; margin-bottom: 20px;">
                                Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
                            </span>
                            Sei Rotan, {{ now()->translatedFormat('d F Y') }}<br>
                            Kepala Perpustakaan
                        </div>
                        <div class="ttd-garis-nama">
                            (&nbsp;___________________________&nbsp;)
                        </div>
                        <div class="ttd-nama">
                            {{ auth()->user()->name ?? 'RAHMA RITONGA S.PD' }}
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>