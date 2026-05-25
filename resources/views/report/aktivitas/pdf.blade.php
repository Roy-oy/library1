<!DOCTYPE html>
<html>
<head>
    <title>Laporan Aktivitas Perpustakaan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #666; }
        
        .section-title { background: #f4f4f4; padding: 5px 10px; font-weight: bold; margin-top: 20px; border: 1px solid #ddd; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f8fafc; font-size: 9pt; text-transform: uppercase; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 9pt; }
        .page-break { page-break-after: always; }
        
        .summary-box { margin-bottom: 20px; }
        .summary-item { display: inline-block; width: 23%; padding: 10px; border: 1px solid #ddd; background: #fafafa; text-align: center; }
        .summary-item .val { font-size: 14pt; font-weight: bold; display: block; margin-top: 5px; }
        .summary-item .lab { font-size: 8pt; color: #666; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN AKTIVITAS PERPUSTAKAAN</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
    </div>

    <div class="summary-box">
        <div class="summary-item">
            <span class="lab">Total Pinjam</span>
            <span class="val">{{ $peminjamans->count() }}</span>
        </div>
        <div class="summary-item">
            <span class="lab">Buku Dipinjam</span>
            <span class="val">{{ $peminjamans->sum(fn($p) => $p->details->count()) }}</span>
        </div>
        <div class="summary-item">
            <span class="lab">Total Kembali</span>
            <span class="val">{{ $pengembalians->count() }}</span>
        </div>
        <div class="summary-item">
            <span class="lab">Denda (Lunas)</span>
            <span class="val">Rp{{ number_format($pengembalians->where('status_denda', 'lunas')->sum('jumlah_denda'), 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="section-title">DAFTAR PEMINJAMAN</div>
    <table>
        <thead>
            <tr>
                <th width="15%">Tgl Pinjam</th>
                <th width="15%">Kode</th>
                <th width="25%">Siswa</th>
                <th width="10%">Buku</th>
                <th width="35%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $pjm)
            <tr>
                <td>{{ $pjm->tanggal_pinjam->format('d/m/Y') }}</td>
                <td>{{ $pjm->kode_peminjaman }}</td>
                <td>{{ $pjm->siswa->nama_siswa }} ({{ $pjm->siswa->kelas }})</td>
                <td>{{ $pjm->details->count() }} Eks</td>
                <td>{{ $pjm->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" align="center">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="page-break"></div>

    <div class="section-title">DAFTAR PENGEMBALIAN & DENDA</div>
    <table>
        <thead>
            <tr>
                <th width="15%">Tgl Kembali</th>
                <th width="20%">Siswa</th>
                <th width="30%">Judul Buku</th>
                <th width="15%">Denda</th>
                <th width="20%">Status Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengembalians as $pkb)
            <tr>
                <td>{{ $pkb->tanggal_kembali->format('d/m/Y') }}</td>
                <td>{{ $pkb->peminjaman->siswa->nama_siswa }}</td>
                <td>{{ $pkb->buku->judul_buku }}</td>
                <td>Rp{{ number_format($pkb->jumlah_denda, 0, ',', '.') }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $pkb->status_denda)) }}</td>
            </tr>
            @empty
            <tr><td colspan="5" align="center">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
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
