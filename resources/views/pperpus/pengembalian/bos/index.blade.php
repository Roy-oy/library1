@extends('pperpus.layouts.app')

@section('title', 'Pengembalian Buku BOS Akhir Tahun')
@section('page-title', 'Pengembalian Massal')

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
        transition: transform .3s ease;
    }
    
    .card-header {
        padding: 1.3rem 1.6rem; border-bottom: 1px solid var(--border);
        background: #fcfdfe; display: flex; align-items: center; justify-content: space-between;
    }
    .card-header h2 { font-size: 1.15rem; font-weight: 800; color: var(--primary); display: flex; align-items: center; gap: .6rem; }
    
    .badge-count {
        background: var(--accent-light); color: var(--primary);
        padding: .3rem .8rem; border-radius: 30px; font-size: .78rem; font-weight: 800;
    }

    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
        background: #f8fafc; font-size: .72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted);
        padding: 1.1rem 1.4rem; border-bottom: 1px solid var(--border);
        text-align: left;
    }
    
    tbody tr { transition: all .2s; }
    tbody td {
        padding: 1.1rem 1.4rem; font-size: .92rem;
        border-bottom: 1px solid #f1f5f9; vertical-align: middle;
    }
    
    tbody tr.selected { background: #f0fdf4 !important; }
    tbody tr:hover { background: #fbfcfd; }

    .form-control {
        padding: .6rem .9rem; border: 1.5px solid var(--border);
        border-radius: 10px; font-size: .88rem; outline: none; width: 100%;
        transition: all .2s; background: #fff;
    }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(20, 90, 50, 0.08); }
    .form-control:disabled { background: #f8fafc; cursor: not-allowed; opacity: .6; border-style: dashed; }

    .checkbox-custom {
        width: 22px; height: 22px; cursor: pointer; border-radius: 6px;
        accent-color: var(--primary); transition: transform .1s;
    }
    .checkbox-custom:active { transform: scale(0.9); }

    .empty-state {
        text-align: center; padding: 6rem 2rem; color: var(--text-muted);
        background: var(--surface); border-radius: 24px; border: 2px dashed var(--border);
    }
    .empty-state i { font-size: 5rem; color: var(--primary); opacity: .1; margin-bottom: 1.5rem; display: block; }
    .empty-state h3 { font-size: 1.3rem; font-weight: 800; color: var(--text); margin-bottom: .5rem; }

    .floating-bar {
        position: fixed; bottom: 2rem; right: 2rem;
        width: calc(100% - var(--sidebar-w) - 4rem); max-width: 800px;
        background: rgba(20, 90, 50, 0.95); backdrop-filter: blur(12px);
        padding: 1.2rem 2.2rem; border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
        display: flex; justify-content: space-between; align-items: center;
        border: 1px solid rgba(255,255,255,0.1); z-index: 1000;
        color: #fff; transition: all .3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateY(100px); opacity: 0;
    }
    .floating-bar.active { transform: translateY(0); opacity: 1; }
    
    @media (max-width: 900px) {
        .floating-bar { width: calc(100% - 3rem); right: 1.5rem; bottom: 1.5rem; }
    }

    .btn-submit {
        padding: .9rem 2.5rem; background: #fff; color: var(--primary);
        border: none; border-radius: 14px; font-weight: 800; cursor: pointer;
        transition: all .2s; font-size: .95rem;
        display: flex; align-items: center; gap: .6rem;
    }
    .btn-submit:hover { background: var(--accent); color: var(--primary-dark); transform: scale(1.03); }

    .book-info { display: flex; flex-direction: column; gap: .2rem; }
    .book-title { font-weight: 800; color: var(--text); line-height: 1.3; }
    .book-code { font-family: monospace; font-size: .75rem; color: var(--primary); font-weight: 700; text-transform: uppercase; }

    .siswa-info { display: flex; flex-direction: column; gap: .2rem; }
    .siswa-nama { font-weight: 700; color: var(--text); }
    .siswa-nis { font-size: .75rem; color: var(--text-muted); font-weight: 600; }

    .filter-bar {
        display: flex; align-items: center; gap: .8rem; margin-bottom: 2rem;
        padding: 1rem; background: var(--surface); border-radius: 16px;
        border: 1px solid var(--border); overflow-x: auto;
    }
    .filter-btn {
        padding: .5rem 1.2rem; border-radius: 10px; border: 1.5px solid var(--border);
        background: #fff; color: var(--text-muted); font-size: .85rem; font-weight: 700;
        cursor: pointer; transition: all .2s; white-space: nowrap;
    }
    .filter-btn:hover { border-color: var(--primary); color: var(--primary); }
    .filter-btn.active { background: var(--primary); color: #fff; border-color: var(--primary); }

    .btn-outline {
        padding: .5rem 1rem; border-radius: 8px; border: 1.5px solid var(--border);
        background: transparent; color: var(--text); font-size: .8rem; font-weight: 700;
        cursor: pointer; display: inline-flex; align-items: center; gap: .5rem;
    }
    .btn-outline:hover { border-color: var(--primary); color: var(--primary); }

    @media print {
        .sidebar, .header, .floating-bar, .filter-bar, .btn-primary, .btn-outline, .check-all, .card-header label, .nav-section-label, .sidebar-footer { display: none !important; }
        .main-wrapper { margin-left: 0 !important; padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #000 !important; border-radius: 0 !important; margin-bottom: 1rem !important; }
        .card-header { background: #eee !important; -webkit-print-color-adjust: exact; }
        table { border-collapse: collapse !important; }
        th, td { border: 1px solid #000 !important; font-size: 10pt !important; }
        .checkbox-custom { display: none !important; }
    }
</style>
@endpush

@section('content')

<div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-end;">
    <div>
        <h1><i class="fas fa-graduation-cap" style="color:var(--primary)"></i> Pengembalian BOS Massal</h1>
        <p>Halaman khusus untuk memproses pengembalian buku paket BOS secara massal saat kenaikan kelas atau akhir tahun ajaran.</p>
    </div>
    <div style="display: flex; gap: .8rem;">
        <button type="button" class="btn-outline" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Daftar
        </button>
        <button type="button" class="btn-primary" style="background: var(--primary); color: #fff; border: none; padding: .6rem 1.2rem; border-radius: 10px; font-weight: 700; cursor: pointer;" onclick="toggleAllGlobal(true)">
            <i class="fas fa-check-double"></i> Pilih Semua Baris
        </button>
    </div>
</div>

@if($data->isNotEmpty())
<div class="filter-bar">
    <span style="font-size: .8rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-right: .5rem;">Filter Kelas:</span>
    <button type="button" class="filter-btn active" onclick="filterByKelas('all', this)">Semua Kelas</button>
    @foreach($data as $kelas => $details)
        <button type="button" class="filter-btn" onclick="filterByKelas('{{ Str::slug($kelas) }}', this)">{{ $kelas }}</button>
    @endforeach
</div>
@endif

<form action="{{ route('pperpus.pengembalian.bos.proses') }}" method="POST" id="form-massal">
    @csrf

    @forelse($data as $kelas => $details)
    <div class="card" id="card-kelas-{{ Str::slug($kelas) }}">
        <div class="card-header">
            <h2><i class="fas fa-users"></i> Kelas {{ $kelas }}</h2>
            <div style="display:flex; align-items:center; gap:1.2rem">
                <label style="font-size:.8rem; font-weight:700; color:var(--text-muted); cursor:pointer; display:flex; align-items:center; gap:.5rem">
                    <input type="checkbox" class="check-all" data-target="{{ Str::slug($kelas) }}" style="width:16px; height:16px"> Pilih Semua
                </label>
                <span class="badge-count">{{ $details->count() }} Transaksi Aktif</span>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:60px; text-align:center">Pilih</th>
                        <th>Siswa</th>
                        <th>Buku Paket</th>
                        <th style="width:180px">Kondisi</th>
                        <th style="width:160px">Denda Ganti (Rp)</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody class="group-{{ Str::slug($kelas) }}">
                    @foreach($details as $index => $detail)
                    @php $rowId = $detail->id_detail; @endphp
                    <tr id="row-{{ $rowId }}">
                        <td style="text-align:center">
                            <input type="checkbox" name="detail[{{ $rowId }}][id_detail]" value="{{ $rowId }}" class="checkbox-custom row-check" data-id="{{ $rowId }}">
                        </td>
                        <td>
                            <div class="siswa-info">
                                <span class="siswa-nama">{{ $detail->peminjaman->siswa->nama_siswa }}</span>
                                <span class="siswa-nis">NIS: {{ $detail->peminjaman->siswa->nis }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="book-info">
                                <span class="book-title">{{ $detail->buku->judul_buku }}</span>
                                <span class="book-code">{{ $detail->buku->kode_buku }}</span>
                            </div>
                        </td>
                        <td>
                            <select name="detail[{{ $rowId }}][kondisi]" class="form-control row-input" data-id="{{ $rowId }}" disabled onchange="toggleDendaField(this, '{{ $rowId }}')">
                                <option value="baik">Kondisi Baik</option>
                                <option value="rusak">Buku Rusak</option>
                                <option value="hilang">Buku Hilang</option>
                            </select>
                        </td>
                        <td>
                            <div style="position:relative">
                                <span style="position:absolute; left:.7rem; top:50%; transform:translateY(-50%); font-size:.75rem; color:var(--text-muted); font-weight:800">Rp</span>
                                <input type="number" name="detail[{{ $rowId }}][denda_ganti]" id="denda-{{ $rowId }}" class="form-control row-input" style="padding-left:2.4rem" placeholder="0" disabled>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="detail[{{ $rowId }}][keterangan]" class="form-control row-input" data-id="{{ $rowId }}" placeholder="..." disabled>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="fas fa-check-double"></i>
        <h3>Tidak Ada Peminjaman Aktif</h3>
        <p>Semua buku BOS telah dikembalikan atau tidak ada data peminjaman untuk kelas manapun.</p>
    </div>
    @endforelse

    <div class="floating-bar" id="floating-bar">
        <div>
            <div style="font-size: 1.1rem; font-weight: 800; letter-spacing: -0.2px">Proses <span id="selected-count">0</span> Buku</div>
            <div style="font-size: .8rem; opacity: .8; font-weight: 500">Pastikan kondisi setiap buku telah diperiksa dengan benar.</div>
        </div>
        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i> Simpan Pengembalian
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const floatingBar = document.getElementById('floating-bar');
        const selectedCount = document.getElementById('selected-count');
        const rowChecks = document.querySelectorAll('.row-check');
        const checkAlls = document.querySelectorAll('.check-all');

        function updateCounter() {
            const count = document.querySelectorAll('.row-check:checked').length;
            selectedCount.textContent = count;
            
            if (count > 0) {
                floatingBar.classList.add('active');
            } else {
                floatingBar.classList.remove('active');
            }
        }

        function toggleRowInputs(id, isChecked) {
            const row = document.getElementById('row-' + id);
            const inputs = row.querySelectorAll('.row-input');
            const kondisiSelect = row.querySelector('select.row-input');
            const dendaInput = document.getElementById('denda-' + id);

            if (isChecked) {
                row.classList.add('selected');
                inputs.forEach(input => {
                    if (input.id !== 'denda-' + id) {
                        input.disabled = false;
                    }
                });
                // Re-check denda field based on kondisi
                if (kondisiSelect.value !== 'baik') {
                    dendaInput.disabled = false;
                }
            } else {
                row.classList.remove('selected');
                inputs.forEach(input => input.disabled = true);
            }
            updateCounter();
        }

        // Row individual checkbox
        rowChecks.forEach(check => {
            check.addEventListener('change', function() {
                toggleRowInputs(this.dataset.id, this.checked);
            });
        });

        // Select All per Class
        checkAlls.forEach(checkAll => {
            checkAll.addEventListener('change', function() {
                const targetClass = this.dataset.target;
                const checkboxes = document.querySelectorAll(`.group-${targetClass} .row-check`);
                
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                    toggleRowInputs(cb.dataset.id, this.checked);
                });
            });
        });
    });

    function toggleDendaField(select, id) {
        const dendaInput = document.getElementById('denda-' + id);
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

    function filterByKelas(slug, btn) {
        // Toggle active button
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Toggle cards
        if (slug === 'all') {
            document.querySelectorAll('.card').forEach(c => c.style.display = 'block');
        } else {
            document.querySelectorAll('.card').forEach(c => {
                if (c.id === 'card-kelas-' + slug) {
                    c.style.display = 'block';
                } else {
                    c.style.display = 'none';
                }
            });
        }
    }

    function toggleAllGlobal(status) {
        const checkboxes = document.querySelectorAll('.row-check');
        checkboxes.forEach(cb => {
            cb.checked = status;
            const id = cb.dataset.id;
            const row = document.getElementById('row-' + id);
            const inputs = row.querySelectorAll('.row-input');
            const kondisiSelect = row.querySelector('select.row-input');
            const dendaInput = document.getElementById('denda-' + id);

            if (status) {
                row.classList.add('selected');
                inputs.forEach(input => {
                    if (input.id !== 'denda-' + id) {
                        input.disabled = false;
                    }
                });
                if (kondisiSelect.value !== 'baik') dendaInput.disabled = false;
            } else {
                row.classList.remove('selected');
                inputs.forEach(input => input.disabled = true);
            }
        });
        
        // Update all "check-all" per class
        document.querySelectorAll('.check-all').forEach(ca => ca.checked = status);
        
        // Trigger counter update
        const selectedCount = document.getElementById('selected-count');
        const floatingBar = document.getElementById('floating-bar');
        const count = document.querySelectorAll('.row-check:checked').length;
        selectedCount.textContent = count;
        if (count > 0) floatingBar.classList.add('active');
        else floatingBar.classList.remove('active');
    }

    // Handle form submit to show loading
    document.getElementById('form-massal').onsubmit = function() {
        const btn = this.querySelector('.btn-submit');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    };
</script>
@endpush
