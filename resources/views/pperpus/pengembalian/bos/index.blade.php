@extends('pperpus.layouts.app')

@section('title', 'Pengembalian Buku BOS Akhir Tahun')
@section('page-title', 'Pengembalian Per Siswa')

@push('styles')
<style>
    .page-header {
        margin-bottom: 2rem;
    }
    .page-header h1 { font-size: 1.6rem; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: .8rem; }
    .page-header p { font-size: .95rem; color: var(--text-muted); margin-top: .4rem; line-height: 1.5; max-width: 700px; }

    .card {
        background: var(--surface); border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        overflow: hidden; margin-bottom: 2rem; border: 1px solid var(--border);
    }
    
    .card-header {
        padding: 1.3rem 1.6rem; border-bottom: 1px solid var(--border);
        background: #fcfdfe; display: flex; align-items: center; justify-content: space-between;
    }
    .card-header h2 { font-size: 1.15rem; font-weight: 800; color: var(--primary); display: flex; align-items: center; gap: .6rem; }

    .filter-section {
        background: var(--surface); border-radius: 16px; padding: 1.5rem;
        margin-bottom: 2rem; border: 1px solid var(--border);
        box-shadow: var(--shadow);
    }
    
    .filter-grid {
        display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;
    }

    .form-group { margin-bottom: 0; }
    .form-group label { display: block; font-size: .8rem; font-weight: 700; margin-bottom: .4rem; color: var(--text-muted); text-transform: uppercase; }
    
    .form-control {
        width: 100%; padding: .7rem .9rem; border: 1.5px solid var(--border);
        border-radius: 10px; font-family: inherit; font-size: .95rem; outline: none;
        transition: all .2s; background: #fff; color: var(--text);
    }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(20, 90, 50, 0.08); }
    .form-control:disabled { background: #f8fafc; cursor: not-allowed; opacity: .7; }

    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc; font-size: .75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted);
        padding: 1.1rem 1.4rem; border-bottom: 1px solid var(--border); text-align: left;
    }
    tbody td {
        padding: 1.1rem 1.4rem; font-size: .92rem;
        border-bottom: 1px solid #f1f5f9; vertical-align: middle;
    }
    tbody tr:hover { background: #fbfcfd; }

    .book-title { font-weight: 800; color: var(--text); }
    .book-code { font-family: monospace; font-size: .75rem; color: var(--primary); font-weight: 700; text-transform: uppercase; margin-top: .2rem; display: block; }

    .btn-submit {
        padding: .7rem 1.4rem; background: var(--primary); color: #fff;
        border: none; border-radius: 8px; font-weight: 700; cursor: pointer;
        transition: all .2s; font-size: .9rem;
        display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
    }
    .btn-submit:hover { background: var(--primary-dark); transform: translateY(-1px); }
    
    .empty-state {
        text-align: center; padding: 4rem 2rem; color: var(--text-muted);
        background: #f8fafc; border-radius: 16px; border: 2px dashed var(--border);
    }
    .empty-state i { font-size: 4rem; color: var(--primary); opacity: .1; margin-bottom: 1rem; display: block; }
    .empty-state h3 { font-size: 1.2rem; font-weight: 800; color: var(--text); margin-bottom: .5rem; }
</style>
@endpush

@section('content')

<div class="page-header">
    <h1><i class="fas fa-user-check" style="color:var(--primary)"></i> Pengembalian BOS Per Siswa</h1>
    <p>Pilih kelas lalu panggil siswa satu persatu untuk mengecek dan memproses pengembalian buku BOS yang dipinjamnya.</p>
</div>

<div class="filter-section">
    <div class="filter-grid">
        <div class="form-group">
            <label>1. Pilih Kelas</label>
            <select id="select-kelas" class="form-control">
                <option value="">— Pilih Kelas —</option>
                @foreach(array_keys($structuredData) as $kelas)
                    <option value="{{ $kelas }}">{{ $kelas }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>2. Panggil Siswa (Yang Belum Mengembalikan)</label>
            <select id="select-siswa" class="form-control" disabled>
                <option value="">— Pilih Kelas Terlebih Dahulu —</option>
            </select>
        </div>
    </div>
</div>

<div id="student-books-container">
    <div class="empty-state">
        <i class="fas fa-book-reader"></i>
        <h3>Belum Ada Siswa Dipilih</h3>
        <p>Silakan pilih kelas dan siswa di atas untuk melihat tanggungan buku BOS-nya.</p>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const data = @json($structuredData);
    
    const selectKelas = document.getElementById('select-kelas');
    const selectSiswa = document.getElementById('select-siswa');
    const container = document.getElementById('student-books-container');
    
    let currentSiswaId = null;

    selectKelas.addEventListener('change', function() {
        const kelas = this.value;
        selectSiswa.innerHTML = '<option value="">— Pilih Siswa —</option>';
        
        if (!kelas) {
            selectSiswa.disabled = true;
            renderEmptyState();
            return;
        }

        const siswas = data[kelas] || [];
        if (siswas.length === 0) {
            selectSiswa.innerHTML = '<option value="">— Tidak ada tanggungan di kelas ini —</option>';
            selectSiswa.disabled = true;
            renderEmptyState();
            return;
        }

        selectSiswa.disabled = false;
        siswas.forEach(s => {
            const opt = document.createElement('option');
            opt.value = s.id_siswa;
            opt.textContent = `${s.nama_siswa} (NIS: ${s.nis}) - ${s.buku.length} Buku`;
            selectSiswa.appendChild(opt);
        });
        
        renderEmptyState();
    });

    selectSiswa.addEventListener('change', function() {
        const idSiswa = this.value;
        const kelas = selectKelas.value;
        
        if (!idSiswa) {
            renderEmptyState();
            return;
        }

        const siswas = data[kelas] || [];
        const siswa = siswas.find(s => s.id_siswa == idSiswa);
        
        if (siswa) {
            renderStudentForm(siswa);
        }
    });

    function renderEmptyState() {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-book-reader"></i>
                <h3>Belum Ada Siswa Dipilih</h3>
                <p>Silakan pilih siswa untuk melihat dan memproses tanggungan buku BOS-nya.</p>
            </div>
        `;
    }

    function renderStudentForm(siswa) {
        let html = `
            <form action="{{ route('pperpus.pengembalian.bos.proses') }}" method="POST" id="form-kembali">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-user-graduate"></i> Data Pengembalian: ${siswa.nama_siswa}</h2>
                        <span style="background:var(--primary); color:#fff; padding:.3rem .8rem; border-radius:20px; font-size:.8rem; font-weight:800">${siswa.buku.length} Buku</span>
                    </div>
                    <div style="overflow-x: auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Informasi Buku</th>
                                    <th style="width: 200px;">Kondisi Buku</th>
                                    <th style="width: 200px;">Denda Ganti (Rp)</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
        `;
        
        siswa.buku.forEach((b, index) => {
            html += `
                <tr>
                    <td style="font-weight:700; color:var(--text-muted)">${index + 1}</td>
                    <td>
                        <div class="book-title">${b.judul_buku}</div>
                        <div class="book-code">${b.kode_buku}</div>
                        <input type="hidden" name="detail[${index}][id_detail]" value="${b.id_detail}">
                    </td>
                    <td>
                        <select name="detail[${index}][kondisi]" class="form-control" onchange="toggleDendaField(this, ${index})">
                            <option value="baik">Kondisi Baik</option>
                            <option value="rusak">Buku Rusak</option>
                            <option value="hilang">Buku Hilang</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="detail[${index}][denda_ganti]" id="denda-${index}" class="form-control" placeholder="Rp 0" disabled>
                    </td>
                    <td>
                        <input type="text" name="detail[${index}][keterangan]" class="form-control" placeholder="...">
                    </td>
                </tr>
            `;
        });
        
        html += `
                            </tbody>
                        </table>
                    </div>
                    <div style="padding: 1.2rem 1.5rem; background: #f8fafc; border-top: 1px solid var(--border); display: flex; justify-content: flex-end;">
                        <button type="button" class="btn-submit" onclick="confirmProses(this, '${siswa.nama_siswa}', ${siswa.buku.length})">
                            <i class="fas fa-save"></i> Proses Pengembalian
                        </button>
                    </div>
                </div>
            </form>
        `;
        
        container.innerHTML = html;
    }

    window.confirmProses = function(btn, namaSiswa, jmlBuku) {
        const form = btn.closest('form');
        if (!form.reportValidity()) {
            return; // Let browser show validation errors
        }

        Swal.fire({
            title: 'Konfirmasi Pengembalian',
            text: `Proses pengembalian ${jmlBuku} buku untuk ${namaSiswa}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#4a90e2',
            cancelButtonColor: '#e74c3c',
            confirmButtonText: 'Ya, Proses Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        })
    }

    window.toggleDendaField = function(select, index) {
        const dendaInput = document.getElementById('denda-' + index);
        if (select.value === 'rusak' || select.value === 'hilang') {
            dendaInput.disabled = false;
            dendaInput.focus();
            dendaInput.required = true;
        } else {
            dendaInput.disabled = true;
            dendaInput.value = '';
            dendaInput.required = false;
        }
    }
</script>
@endpush
