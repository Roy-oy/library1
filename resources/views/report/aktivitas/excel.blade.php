<table border="1">
    <thead>
        <tr>
            <th colspan="12" style="text-align:center; font-size:14pt; font-weight:bold;">
                Laporan Peminjaman dan Pengembalian Buku
            </th>
        </tr>
        <tr>
            <th colspan="12" style="text-align:center;">
                Kategori: {{ strtoupper($sumberBuku) }} | Periode: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}
            </th>
        </tr>
        <tr>
            <th colspan="12"></th>
        </tr>
        <tr style="background-color: #1e3a5f; color: #ffffff;">
            <th>No</th>
            <th>Kode Peminjaman</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Harus Kembali</th>
            <th>Tanggal Kembali</th>
            <th>Kode Buku</th>
            <th>Judul Buku</th>
            <th>Telat(Hari)</th>
            <th>Denda(Rp)</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($aktivitas as $index => $item)
        @php
            $statusLower = strtolower($item->status);
            if (in_array($statusLower, ['sedang dipinjam', 'dipinjam'])) {
                $statusLabel = 'Dipinjam';
            } elseif ($statusLower === 'terlambat') {
                $statusLabel = 'Terlambat';
            } elseif (in_array($statusLower, ['hilang', 'rusak'])) {
                $statusLabel = ucfirst($item->status);
            } else {
                $statusLabel = 'Sudah Dikembalikan';
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
                    Buku BOS: {{ $item->buku }} (BOS)
                @else
                    {{ $item->buku }} ({{ $item->kategori }})
                @endif
            </td>
            <td style="text-align: center;">{{ $item->telat > 0 ? $item->telat : '0' }}</td>
            <td style="text-align: right;">{{ $item->denda > 0 ? $item->denda : '0' }}</td>
            <td style="text-align: center;">{{ $statusLabel }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="12" style="text-align: center;">
                Tidak ada data aktivitas pada periode ini.
            </td>
        </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <th colspan="10" style="text-align: right; font-weight: bold;">TOTAL DENDA :</th>
            <th style="text-align: right; font-weight: bold;">{{ $totalDenda }}</th>
            <th></th>
        </tr>
    </tfoot>
</table>
