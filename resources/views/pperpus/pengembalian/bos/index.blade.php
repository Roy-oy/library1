@extends('pperpus.layouts.app')

@section('title', 'Pengembalian Buku BOS Akhir Tahun')
@section('page-title', 'Pengembalian Per Siswa')

@push('styles')
<style>
    
    :root {
        --theme-primary: #0d9488;
        --theme-primary-light: #f0fdfa;
        --theme-primary-hover: #0f766e;
        --theme-info: #0ea5e9;
        --theme-info-light: #f0f9ff;
        --theme-success: #10b981;
        --theme-success-light: #ecfdf5;
        --theme-warning: #f59e0b;
        --theme-warning-light: #fffbeb;
        --theme-danger: #ef4444;
        --theme-danger-light: #fef2f2;
        --card-radius: 16px;
        --transition-speed: 0.25s;
    }

    
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-header-title h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .page-header-title p {
        font-size: 0.88rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    
    .filter-panel {
        background: var(--surface);
        border-radius: var(--card-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        margin-bottom: 1.5rem;
    }
    .filter-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 1.5rem;
    }
    .form-group label {
        display: block;
        font-size: .75rem;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        margin-bottom: .5rem;
        letter-spacing: .5px;
    }
    .form-control {
        width: 100%;
        padding: .75rem 1rem;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-family: inherit;
        font-size: .95rem;
        color: var(--text);
        background: #fff;
        transition: all var(--transition-speed);
        outline: none;
    }
    .form-control:focus {
        border-color: var(--theme-primary);
        box-shadow: 0 0 0 3.5px rgba(13, 148, 136, 0.1);
    }
    .form-control:disabled { background: #f8fafc; cursor: not-allowed; }
    .form-control:disabled:hover { background: #f8fafc; }
    
    
    .denda-input {
        transition: all var(--transition-speed);
    }
    .denda-input:disabled {
        background: #f0f4f8;
        color: #cbd5e1;
    }
    .denda-input:not(:disabled) {
        background: #fff;
        color: var(--text);
        border-color: var(--theme-warning) !important;
        box-shadow: 0 0 0 3.5px rgba(245, 158, 11, 0.1);
    }

    
    .card {
        background: var(--surface);
        border-radius: var(--card-radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(228, 233, 240, 0.6);
        overflow: hidden;
    }
    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        background: #fafbfc;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .card-header h2 { font-size: 1.1rem; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: .6rem; }

    
    .table-wrap { overflow-x: auto; width: 100%; }

    
    table.kperpus-table { width: 100%; border-collapse: separate; border-spacing: 0; min-width: 900px; }
    table.kperpus-table thead th {
        background: var(--primary);
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #ffffff;
        padding: 1.1rem 1.25rem;
        border-bottom: 2px solid var(--primary-dark);
        white-space: nowrap;
    }
    table.kperpus-table tbody td {
        padding: 1rem 1.25rem;
        font-size: 0.9rem;
        border-bottom: 1px solid var(--border);
        color: var(--text);
        vertical-align: middle;
    }
    table.kperpus-table tbody tr:nth-child(even) td { background: #f8fafc; }
    table.kperpus-table tbody tr:last-child td { border-bottom: none; }
    table.kperpus-table tbody tr { transition: background-color .2s ease; }
    table.kperpus-table tbody tr:hover td { background-color: var(--primary-soft) !important; }

    .book-title { font-weight: 800; color: var(--text); font-size: 0.95rem; }
    .book-code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.78rem; color: var(--primary); font-weight: 700; background: var(--primary-soft); padding: 0.15rem 0.4rem; border-radius: 4px; display: inline-block; margin-top: 0.2rem; }

    .btn-submit {
        display: inline-flex; align-items: center; gap: .6rem; padding: .75rem 1.5rem;
        background: linear-gradient(135deg, var(--theme-primary), var(--theme-primary-hover));
        color: #fff; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;
        transition: all var(--transition-speed); box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(13, 148, 136, 0.3); }

    .empty-state {
        text-align: center; padding: 4rem 2rem; color: var(--text-muted);
        background: #fff; border-radius: var(--card-radius); border: 2px dashed var(--border);
    }
    .empty-state i { font-size: 3rem; color: var(--primary); opacity: .2; margin-bottom: 1rem; display: block; }
    .empty-state h3 { font-size: 1.2rem; font-weight: 800; color: var(--text); margin-bottom: .5rem; }

    @media (max-width: 768px) {
        .filter-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="page-header-title">
        <h1><i class="fas fa-user-check" style="color:var(--primary)"></i> Pengembalian BOS Per Siswa</h1>
        <p>Pilih kelas dan siswa untuk memproses pengembalian buku BOS.</p>
    </div>
</div>

<div class="filter-panel">
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
                        <h2><i class="fas fa-user-graduate" style="color:var(--primary)"></i> Data Pengembalian: ${siswa.nama_siswa}</h2>
                        <span style="background:var(--primary); color:#fff; padding:.35rem .9rem; border-radius:30px; font-size:.78rem; font-weight:800; box-shadow: 0 4px 10px rgba(13, 148, 136, 0.2);">${siswa.buku.length} BUKU TANGGUNGAN</span>
                    </div>
                    <div class="table-wrap">
                        <table class="kperpus-table">
                            <thead>
                                <tr>
                                    <th style="width: 60px; text-align: center;">No</th>
                                    <th>Informasi Buku</th>
                                    <th style="width: 220px;">Kondisi Buku</th>
                                    <th style="width: 200px;">Denda Ganti (Rp)</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
        `;
        
        siswa.buku.forEach((b, index) => {
            html += `
                <tr>
                    <td style="text-align: center; font-weight:700; color:var(--text-muted)">${index + 1}</td>
                    <td>
                        <div class="book-title">${b.judul_buku}</div>
                        <div class="book-code">${b.kode_buku}</div>
                        <input type="hidden" name="detail[${index}][id_detail]" value="${b.id_detail}">
                    </td>
                    <td>
                        <select name="detail[${index}][kondisi]" class="form-control" style="font-weight: 700;" onchange="toggleDendaField(this, ${index})">
                            <option value="baik">✅ Kondisi Baik</option>
                            <option value="rusak">⚠️ Buku Rusak</option>
                            <option value="hilang">❌ Buku Hilang</option>
                        </select>
                    </td>
                    <td>
                        <div style="position: relative; display: flex; align-items: center;">
                            <span style="position: absolute; left: 0.75rem; font-weight: 800; color: var(--text-muted); font-size: 0.85rem;">Rp</span>
                            <input type="number" name="detail[${index}][denda_ganti]" id="denda-${index}" class="form-control denda-input" style="padding-left: 2.5rem; font-weight: 800;" placeholder="0" value="0" data-index="${index}">
                            <input type="hidden" id="denda-enabled-${index}" name="denda_enabled[${index}]" value="0">
                        </div>
                    </td>
                    <td>
                        <input type="text" name="detail[${index}][keterangan]" class="form-control" placeholder="Tambahkan catatan jika perlu...">
                    </td>
                </tr>
            `;
        });
        
        html += `
                            </tbody>
                        </table>
                    </div>
                    <div style="padding: 1.5rem; background: #fafbfc; border-top: 1px solid var(--border); display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-check-double"></i> Selesaikan Pengembalian
                        </button>
                    </div>
                </div>
            </form>
        `;
        
        container.innerHTML = html;

        const kondisiSelects = form.querySelectorAll('select[name*="[kondisi]"]');
        kondisiSelects.forEach(select => {
            const index = select.name.match(/detail\[(\d+)\]/)[1];

            select.value = 'baik';
            toggleDendaField(select, index);
        });

        const form = document.getElementById('form-kembali');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let isValid = true;
            let errorMsg = '';
            
            const kondisiSelects = form.querySelectorAll('select[name*="[kondisi]"]');
            kondisiSelects.forEach((select, idx) => {
                const index = select.name.match(/detail\[(\d+)\]/)[1];
                const dendaInput = document.getElementById('denda-' + index);
                const kondisi = select.value;
                
                if (!select.value) {
                    isValid = false;
                    errorMsg = 'Silakan pilih kondisi buku untuk semua buku!';
                    select.focus();
                    return;
                }
                
                if ((kondisi === 'rusak' || kondisi === 'hilang') && (!dendaInput.value || dendaInput.value === '0')) {
                    isValid = false;
                    errorMsg = 'Denda ganti harus diisi jika buku rusak atau hilang!';
                    dendaInput.focus();
                    return;
                }
            });
            
            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: errorMsg,
                    confirmButtonColor: '#0d9488'
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Pengembalian',
                text: `Proses pengembalian ${siswa.buku.length} buku untuk ${siswa.nama_siswa}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d9488',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Proses Sekarang',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {

                    const kondisiSelects = form.querySelectorAll('select[name*="[kondisi]"]');
                    kondisiSelects.forEach(select => {
                        const index = select.name.match(/detail\[(\d+)\]/)[1];
                        const dendaInput = document.getElementById('denda-' + index);

                        if (select.value === 'baik') {
                            dendaInput.value = '0';
                        }

                        dendaInput.disabled = false;
                    });
                    
                    this.submit();
                }
            });
        });
    }

    window.toggleDendaField = function(select, index) {
        const dendaInput = document.getElementById('denda-' + index);
        const dendaEnabled = document.getElementById('denda-enabled-' + index);
        const tr = select.closest('tr');
        
        if (select.value === 'rusak' || select.value === 'hilang') {

            dendaInput.disabled = false;
            dendaInput.style.opacity = '1';
            dendaInput.style.cursor = 'pointer';
            dendaEnabled.value = '1';

            if (!dendaInput.value || dendaInput.value === '0') {
                dendaInput.value = '50000';
            }
            dendaInput.focus();
            dendaInput.select();

            tr.style.backgroundColor = 'var(--theme-warning-light)';
        } else {

            dendaInput.disabled = true;
            dendaInput.style.opacity = '0.6';
            dendaInput.style.cursor = 'not-allowed';
            dendaInput.value = '0';
            dendaEnabled.value = '0';

            tr.style.backgroundColor = '';
        }
    }
</script>
@endpush
