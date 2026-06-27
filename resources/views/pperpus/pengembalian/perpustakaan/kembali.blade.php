@extends('pperpus.layouts.app')

@section('title', 'Proses Pengembalian Buku')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center; gap: .8rem; margin-bottom: 2rem;
    }
    .page-header a {
        display: inline-flex; align-items: center; justify-content: center;
        width: 40px; height: 40px; border-radius: 12px;
        background: var(--surface); border: 1px solid var(--border);
        color: var(--text-muted); text-decoration: none; transition: all .2s;
    }
    .page-header a:hover { border-color: var(--primary); color: var(--primary); background: #fff; }
    .page-header h1 { font-size: 1.5rem; font-weight: 800; color: var(--text); }

    .card {
        background: var(--surface); border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden; margin-bottom: 2rem; border: 1px solid var(--border);
    }
    .card-header { 
        padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--border);
        background: #fcfdfe; display: flex; align-items: center; justify-content: space-between;
    }
    .card-header h2 { font-size: 1.1rem; font-weight: 800; color: var(--text); }
    
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc; font-size: .75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .8px; color: var(--text-muted);
        padding: 1rem 1.2rem; border-bottom: 1px solid var(--border);
        text-align: left;
    }
    tbody td {
        padding: 1.2rem; border-bottom: 1px solid #f0f4f8; vertical-align: top;
    }

    .form-control {
        width: 100%; padding: .6rem .8rem; border: 1.5px solid var(--border);
        border-radius: 10px; font-family: inherit; font-size: .88rem; outline: none;
        transition: all .2s; background: #fbfcfd;
    }
    .form-control:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 3px rgba(26,60,94,.05); }
    .form-control:disabled { background: #f1f5f9; cursor: not-allowed; opacity: .7; }

    .btn-submit {
        padding: .7rem 1.4rem; background: var(--primary); color: #fff;
        border: none; border-radius: 8px; font-weight: 700; cursor: pointer;
        transition: all .2s; display: inline-flex; align-items: center; gap: .5rem;
    }
    .btn-submit:hover { background: var(--primary-dark); transform: translateY(-1px); }

    .book-title { font-weight: 800; color: var(--text); margin-bottom: .2rem; }
    .book-meta { font-size: .75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; }

    .checkbox-container {
        display: flex; align-items: center; justify-content: center; height: 100%;
    }
    .checkbox-custom { width: 20px; height: 20px; cursor: pointer; }
</style>
@endpush

@section('content')

<div class="page-header">
    <a href="{{ route('pperpus.peminjaman.perpustakaan.show', $peminjaman->id_peminjaman) }}"><i class="fas fa-arrow-left"></i></a>
    <h1>Pengembalian Buku: <span style="color:var(--primary)">{{ $peminjaman->kode_peminjaman }}</span></h1>
</div>

<form action="{{ route('pperpus.pengembalian.perpustakaan.prosesKembali', $peminjaman->id_peminjaman) }}" method="POST">
    @csrf
    
    <div class="card">
        <div class="card-header">
            <h2>Daftar Buku Belum Kembali</h2>
            <div style="font-size: .85rem; font-weight: 700; color: var(--text-muted)">
                Siswa: <span style="color:var(--text)">{{ $peminjaman->siswa->nama_siswa }}</span>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:60px; text-align:center">Proses</th>
                        <th>Buku & Detail</th>
                        <th>Jatuh Tempo</th>
                        <th style="width:200px">Kondisi Pengembalian</th>
                        <th style="width:160px">Denda Ganti (Rp)</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bukuMasihDipinjam as $index => $detail)
                    <tr>
                        <td style="text-align:center">
                            <div class="checkbox-container">
                                <input type="checkbox" name="detail[{{ $index }}][id_detail]" value="{{ $detail->id_detail }}" checked class="checkbox-custom book-checkbox" data-idx="{{ $index }}" onchange="toggleRow(this, {{ $index }})">
                            </div>
                        </td>
                        <td>
                            <div class="book-title">{{ $detail->buku->judul_buku }}</div>
                            <div class="book-meta">{{ $detail->sumber_buku }} | {{ $detail->buku->kode_buku }}</div>
                        </td>
                        <td>
                            @if($detail->tanggal_jatuh_tempo)
                                <div style="font-weight:700">{{ $detail->tanggal_jatuh_tempo->format('d/m/Y') }}</div>
                                @if($detail->is_terlambat)
                                    <div style="color:var(--danger); font-size:.7rem; font-weight:800; margin-top:.2rem"><i class="fas fa-exclamation-triangle"></i> TERLAMBAT</div>
                                @endif
                            @else
                                <span style="color:var(--text-muted)">—</span>
                            @endif
                        </td>
                        <td>
                            <select name="detail[{{ $index }}][kondisi]" id="kondisi-{{ $index }}" class="form-control" onchange="toggleDenda(this, {{ $index }})">
                                <option value="baik">Kondisi Baik (Normal)</option>
                                <option value="rusak">Buku Rusak</option>
                                <option value="hilang">Buku Hilang</option>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="detail[{{ $index }}][denda_ganti]" id="denda-{{ $index }}" class="form-control" placeholder="0" disabled>
                        </td>
                        <td>
                            <input type="text" name="detail[{{ $index }}][keterangan]" id="keterangan-{{ $index }}" class="form-control" placeholder="Tulis catatan jika ada...">
                            <input type="hidden" name="detail[{{ $index }}][tanggal_kembali]" id="tanggal-{{ $index }}" value="{{ date('Y-m-d') }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="background: #f8fafc; padding: 1.2rem 1.5rem; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; align-items: center;">
            <button type="submit" class="btn-submit">
                <i class="fas fa-save"></i> Simpan Pengembalian
            </button>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
    function toggleRow(checkbox, index) {
        const kondisi = document.getElementById('kondisi-' + index);
        const denda = document.getElementById('denda-' + index);
        const keterangan = document.getElementById('keterangan-' + index);
        const tanggal = document.getElementById('tanggal-' + index);

        const isChecked = checkbox.checked;
        kondisi.disabled = !isChecked;
        keterangan.disabled = !isChecked;
        tanggal.disabled = !isChecked;

        if (!isChecked) {
            denda.disabled = true;
        } else {

            if (kondisi.value === 'rusak' || kondisi.value === 'hilang') {
                denda.disabled = false;
                denda.required = true;
            } else {
                denda.disabled = true;
                denda.required = false;
            }
        }
    }

    function toggleDenda(select, index) {
        const input = document.getElementById('denda-' + index);
        const checkbox = document.querySelector(`input[name="detail[${index}][id_detail]"]`);
        
        checkbox.checked = true; // Auto-select if modified

        document.getElementById('kondisi-' + index).disabled = false;
        document.getElementById('keterangan-' + index).disabled = false;
        document.getElementById('tanggal-' + index).disabled = false;

        if (select.value === 'rusak' || select.value === 'hilang') {
            input.disabled = false;
            input.required = true;
            input.focus();
        } else {
            input.disabled = true;
            input.required = false;
            input.value = '';
        }
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const checked = document.querySelectorAll('.book-checkbox:checked');
        if (checked.length === 0) {
            e.preventDefault();
            alert('Silakan pilih minimal satu buku yang akan dikembalikan.');
        }
    });
</script>
@endpush
