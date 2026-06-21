<div class="modal-overlay form-overlay-modal" id="create-modal">
    <div class="modal-box">
        <div class="form-card">
            <div class="form-card-header">
                <div class="hdr-icon"><i class="fas fa-user-plus"></i></div>
                <div>
                    <h2>Tambah Petugas Baru</h2>
                    <p>Daftarkan petugas perpustakaan baru untuk mengelola operasional.</p>
                </div>
            </div>

            <form action="{{ route('kperpus.petugas.store') }}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="form-group">
                        <label for="create_name">Nama Lengkap <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="name" id="create_name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Masukkan nama lengkap petugas..." required value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <span class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="create_username">Username <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-circle input-icon"></i>
                            <input type="text" name="username" id="create_username" class="form-control @error('username') is-invalid @enderror" 
                                   placeholder="Username untuk login..." required value="{{ old('username') }}">
                        </div>
                        @error('username')
                            <span class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="create_role">Role (Peran) <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-tag input-icon"></i>
                            <select name="role" id="create_role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Peran --</option>
                                <option value="penjaga_perpustakaan" {{ old('role') == 'penjaga_perpustakaan' ? 'selected' : '' }}>Penjaga Perpustakaan</option>
                                <option value="kepala_sekolah" {{ old('role') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                            </select>
                        </div>
                        @error('role')
                            <span class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="create_password">Password <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" id="create_password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Minimal 8 karakter..." required minlength="8">
                        </div>
                        @error('password')
                            <span class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel-modal" onclick="closeModal('create-modal')">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Simpan Petugas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>