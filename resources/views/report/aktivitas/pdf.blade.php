<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Aktivitas Perpustakaan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            color: #1a1a1a;
            background: #fff;
            padding: 28px 36px;
        }

        /* ─── KOP SURAT (Dibuat Presisi & Sejajar Tengah) ─── */
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
            padding-right: 90px; /* Menyeimbangkan posisi teks akibat adanya logo di sisi kiri agar sentral */
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

        /* ─── JUDUL LAPORAN (Perbaikan Jarak & Struktur Meta Data) ─── */
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

        /* ─── TABEL DATA ────────────────────────────── */
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

        .status-kembali   { color: #1a6b2f; font-weight: bold; }
        .status-dipinjam  { color: #b45309; font-weight: bold; }
        .status-terlambat { color: #b91c1c; font-weight: bold; }
        .status-hilang    { color: #7c3aed; font-weight: bold; }

        /* ─── TANDA TANGAN ───────────────────────────── */
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

    {{-- ── KOP SURAT ── --}}
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

    {{-- ── JUDUL LAPORAN ── --}}
    <div class="judul-laporan">
        <div class="judul-utama">Laporan Peminjaman dan Pengembalian Buku</div>
        <div class="sub-judul">Perpustakaan SMP Negeri 8 Percut Sei Tuan</div>
        <div class="meta-info">
            <table>
                <tr>
                    <td style="width: 110px;">Kategori Buku</td>
                    <td style="width: 10px;">:</td>
                    <td><strong>{{ strtoupper($sumberBuku) }}</strong></td>
                </tr>
                <tr>
                    <td style="width: 110px;">Periode Laporan</td>
                    <td style="width: 10px;">:</td>
                    <td>
                        <strong>
                            {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }}
                            s/d
                            {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
                        </strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ── TABEL DATA ── --}}
    <div class="tabel-wrapper">
        <table class="tabel-data">
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th style="width: 9%;">Kode Peminjaman</th>
                    <th style="width: 6%;">NIS</th>
                    <th style="width: 12%;">Nama Siswa</th>
                    <th style="width: 5%;">Kelas</th>
                    <th style="width: 8%;">Tgl Pinjam</th>
                    <th style="width: 8%;">Harus Kembali</th>
                    <th style="width: 8%;">Tgl Kembali</th>
                    <th style="width: 8%;">Kode Buku</th>
                    <th style="width: 14%;">Judul Buku</th>
                    <th style="width: 5%;">Telat</th>
                    <th style="width: 7%;">Denda</th>
                    <th style="width: 7%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aktivitas as $index => $item)
                @php
                    $statusLower = strtolower($item->status);
                    if (in_array($statusLower, ['sedang dipinjam', 'dipinjam'])) {
                        $statusLabel = 'Dipinjam';
                        $statusClass = 'status-dipinjam';
                    } elseif ($statusLower === 'terlambat') {
                        $statusLabel = 'Terlambat';
                        $statusClass = 'status-terlambat';
                    } elseif (in_array($statusLower, ['hilang', 'rusak'])) {
                        $statusLabel = ucfirst($item->status);
                        $statusClass = 'status-hilang';
                    } else {
                        $statusLabel = 'Sudah Dikembalikan';
                        $statusClass = 'status-kembali';
                    }
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center;">{{ $item->kode }}</td>
                    <td style="text-align: center;">{{ $item->nis }}</td>
                    <td>{{ $item->siswa }}</td>
                    <td style="text-align: center;">{{ $item->kelas }}</td>
                    <td style="text-align: center;">
                        {{ $item->tanggal_pinjam !== '-' ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') : '-' }}
                    </td>
                    <td style="text-align: center;">
                        {{ $item->tanggal_jatuh_tempo !== '-' ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') : '-' }}
                    </td>
                    <td style="text-align: center;">
                        {{ $item->tanggal_kembali !== '-' ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') : '-' }}
                    </td>
                    <td style="text-align: center;">{{ $item->kode_buku }}</td>
                    <td>
                        @if($item->sumber_buku === 'bos')
                            <strong>Buku BOS:</strong> {{ $item->buku }}
                        @else
                            {{ $item->buku }}
                        @endif
                        <br>
                        <small style="color: #2563eb;">({{ $item->sumber_buku === 'bos' ? 'BOS' : $item->kategori }})</small>
                    </td>
                    <td style="text-align: center;">{{ $item->telat > 0 ? $item->telat : '0' }}</td>
                    <td style="text-align: right;">
                        {{ $item->denda > 0 ? number_format($item->denda, 0, ',', '.') : '0' }}
                    </td>
                    <td style="text-align: center;" class="{{ $statusClass }}">{{ $statusLabel }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="12" style="text-align: center; padding: 20px; font-style: italic; color: #555;">
                        Tidak ada data aktivitas pada periode ini.
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
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- ── TANDA TANGAN ── --}}
    <div class="ttd-section">
        <table class="ttd-table">
            <tr>
                <td></td>
                <td style="width: 250px;">
                    <div class="ttd-kanan-box">
                        <div class="ttd-info-cetak">
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