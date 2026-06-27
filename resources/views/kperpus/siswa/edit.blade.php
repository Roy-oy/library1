<div class="modal-overlay form-overlay-modal" id="edit-modal">
    <div class="modal-box">
        <div class="form-card">
            <div class="form-card-header">
                <div class="hdr-icon"><i class="fas fa-user-edit"></i></div>
                <div>
                    <h2>Formulir Edit Data Siswa</h2>
                    <p>Perbarui profil dan status keanggotaan siswa.</p>
                </div>
            </div>

            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <div class="form-grid">
                        
                        
                        <div class="form-group">
                            <label for="edit_nis">Nomor Induk Siswa (NIS) <span class="req">*</span></label>
                            <div class="form-control-wrap">
                                <i class="fas fa-barcode input-icon"></i>
                                <input type="text" id="edit_nis" name="nis" 
                                       class="form-control @error('nis') is-invalid @enderror" required>
                            </div>
                            @error('nis')
                                <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        
                        <div class="form-group">
                            <label for="edit_nama">Nama Lengkap Siswa <span class="req">*</span></label>
                            <div class="form-control-wrap">
                                <i class="fas fa-user-tag input-icon"></i>
                                <input type="text" id="edit_nama" name="nama_siswa" 
                                       class="form-control @error('nama_siswa') is-invalid @enderror" required>
                            </div>
                            @error('nama_siswa')
                                <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        
                        <div class="form-group">
                            <label for="edit_kelas">Kelas <span class="req">*</span></label>
                            <div class="form-control-wrap">
                                <i class="fas fa-layer-group input-icon"></i>
                                <select id="edit_kelas" name="kelas" 
                                        class="form-control @error('kelas') is-invalid @enderror" required>
                                    <option value="">— Pilih Kelas —</option>
                                    @foreach(['VII-A', 'VII-B', 'VIII-A', 'VIII-B', 'IX-A', 'IX-B'] as $kls)
                                        <option value="{{ $kls }}">{{ $kls }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('kelas')
                                <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        
                        <div class="form-group">
                            <label for="edit_jk">Jenis Kelamin <span class="req">*</span></label>
                            <div class="form-control-wrap">
                                <i class="fas fa-venus-mars input-icon"></i>
                                <select id="edit_jk" name="jenis_kelamin" 
                                        class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="">— Pilih Jenis Kelamin —</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            @error('jenis_kelamin')
                                <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        
                        <div class="form-group full">
                            <label for="edit_status">Status Anggota Perpustakaan <span class="req">*</span></label>
                            <div class="form-control-wrap">
                                <i class="fas fa-user-shield input-icon"></i>
                                <select id="edit_status" name="status" 
                                        class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="aktif">Siswa Aktif</option>
                                    <option value="nonaktif">Nonaktif / Pindah</option>
                                </select>
                            </div>
                            @error('status')
                                <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        
                        <div class="form-group full">
                            <label for="edit_alamat">Alamat Lengkap Rumah <span class="req">*</span></label>
                            <div class="form-control-wrap">
                                <i class="fas fa-map-marked-alt input-icon" style="top: 1.1rem;"></i>
                                <textarea id="edit_alamat" name="alamat" rows="3" 
                                          class="form-control @error('alamat') is-invalid @enderror" 
                                          required style="padding-left: 2.5rem;"></textarea>
                            </div>
                            @error('alamat')
                                <span class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel-modal" onclick="closeEditModal()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>