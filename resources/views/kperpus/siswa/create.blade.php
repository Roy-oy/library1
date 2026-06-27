<div class="modal-overlay form-overlay-modal" id="create-modal">
    <div class="modal-box">
        <div class="form-card">
            <div class="form-card-header">
                <div class="hdr-icon"><i class="fas fa-user-plus"></i></div>
                <div>
                    <h2>Formulir Tambah Siswa Baru</h2>
                    <p>Daftarkan profil data siswa untuk keanggotaan perpustakaan.</p>
                </div>
            </div>

            <form action="{{ route('kperpus.siswa.store') }}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="form-grid">
                        
                        
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
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel-modal" onclick="closeCreateModal()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Simpan Data Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>