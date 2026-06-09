{{-- Create Modal Overlay Box --}}
<div class="modal-overlay" id="create-modal">
    <div class="form-modal-box">
        <div class="form-modal-header">
            <h3><i class="fas fa-user-plus" style="color:var(--primary)"></i> Tambah Siswa Baru</h3>
            <button type="button" class="form-modal-close" onclick="closeCreateModal()"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="{{ route('kperpus.siswa.store') }}" method="POST">
            @csrf
            <div class="form-modal-body">
                <div class="form-grid">
                    
                    {{-- NIS --}}
                    <div class="form-group">
                        <label for="create_nis">Nomor Induk Siswa (NIS) <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-barcode input-icon"></i>
                            <input type="text" id="create_nis" name="nis" 
                                   class="form-control @error('nis') is-invalid @enderror" 
                                   value="{{ old('nis') }}" placeholder="Contoh: 12345" required>
                        </div>
                        @error('nis')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nama Siswa --}}
                    <div class="form-group">
                        <label for="create_nama">Nama Lengkap Siswa <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-tag input-icon"></i>
                            <input type="text" id="create_nama" name="nama_siswa" 
                                   class="form-control @error('nama_siswa') is-invalid @enderror" 
                                   value="{{ old('nama_siswa') }}" placeholder="Masukkan nama lengkap siswa" required>
                        </div>
                        @error('nama_siswa')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="form-group">
                        <label for="create_kelas">Kelas <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-layer-group input-icon"></i>
                            <select id="create_kelas" name="kelas" 
                                    class="form-control @error('kelas') is-invalid @enderror" required>
                                <option value="">— Pilih Kelas —</option>
                                @foreach(['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'] as $kls)
                                    <option value="{{ $kls }}" {{ old('kelas') == $kls ? 'selected' : '' }}>{{ $kls }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('kelas')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="form-group">
                        <label for="create_jk">Jenis Kelamin <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-venus-mars input-icon"></i>
                            <select id="create_jk" name="jenis_kelamin" 
                                    class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="">— Pilih Jenis Kelamin —</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        @error('jenis_kelamin')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group full">
                        <label for="create_status">Status Anggota Perpustakaan <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-shield input-icon"></i>
                            <select id="create_status" name="status" 
                                    class="form-control @error('status') is-invalid @enderror" required>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Siswa Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif / Pindah</option>
                            </select>
                        </div>
                        @error('status')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group full">
                        <label for="create_alamat">Alamat Lengkap Rumah <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-map-marked-alt input-icon" style="top: 1.1rem;"></i>
                            <textarea id="create_alamat" name="alamat" rows="3" 
                                      class="form-control @error('alamat') is-invalid @enderror" 
                                      placeholder="Masukkan alamat lengkap tempat tinggal siswa" required style="padding-left: 2.5rem;">{{ old('alamat') }}</textarea>
                        </div>
                        @error('alamat')
                            <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
            
            <div class="form-modal-footer">
                <button type="button" class="btn-cancel" onclick="closeCreateModal()" style="padding: 0.75rem 1.2rem; background: var(--bg); border: 1.5px solid var(--border); border-radius: 10px; font-weight: 700; cursor: pointer; color: var(--text-muted);">Batal</button>
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Data Siswa</button>
            </div>
        </form>
    </div>
</div>