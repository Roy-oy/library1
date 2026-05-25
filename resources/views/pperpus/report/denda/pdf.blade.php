<!DOCTYPE html>
<html>

<head>
    <title>Laporan Denda Keterlambatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin-bottom: 5px;
        }

        .header p {
            margin-top: 0;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .summary {
            margin-top: 20px;
        }

        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9pt;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN DENDA KETERLAMBATAN</h2>
        <p>Perpustakaan (Sesuaikan nanti)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Buku</th>
                <th>Tgl Kembali</th>
                <th>Hari Terlambat</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Total Denda</th>
            </tr>
        </thead>
        <tbody>
            @php $totalDenda = 0; @endphp
            @forelse($reports as $report)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $report->peminjaman->siswa->nama_siswa }}</td>
                    <td>{{ $report->buku->judul_buku }}</td>
                    <td>{{ $report->tanggal_kembali ? $report->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                    <td>{{ $report->jumlah_hari_terlambat }} Hari</td>
                    <td>{{ $report->status_denda == 'lunas' ? 'Lunas' : 'Belum Lunas' }}</td>
                    <td>{{ $report->keterangan ?? '-' }}</td>
                    <td>Rp{{ number_format($report->jumlah_denda, 0, ',', '.') }}</td>
                </tr>
                @php $totalDenda += $report->jumlah_denda; @endphp
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" style="text-align: right;">TOTAL</th>
                <th>Rp{{ number_format($totalDenda, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Oleh: {{ auth()->user()->name }}</p>
        <br><br><br>
        <p>( ____________________ )</p>
        <p>Petugas Perpustakaan</p>
    </div>
</body>

</html>