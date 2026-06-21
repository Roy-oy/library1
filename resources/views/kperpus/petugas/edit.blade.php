<div class="modal-overlay form-overlay-modal" id="edit-modal">
    <div class="modal-box">
        <div class="form-card">
            <div class="form-card-header edit-mode">
                <div class="hdr-icon"><i class="fas fa-user-edit"></i></div>
                <div>
                    <h2>Edit Data Petugas</h2>
                    <p>Perbarui informasi akun petugas perpustakaan.</p>
                </div>
            </div>

            <form action="" method="POST" id="edit-form-action">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <div class="form-group">
                        <label for="edit_name">Nama Lengkap <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="name" id="edit_name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Masukkan nama lengkap petugas..." required value="{{ old('name') }}">
                        </div>
                        @error('name')
                            <span class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="edit_username">Username <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-circle input-icon"></i>
                            <input type="text" name="username" id="edit_username" class="form-control @error('username') is-invalid @enderror" 
                                   placeholder="Username untuk login..." required value="{{ old('username') }}">
                        </div>
                        @error('username')
                            <span class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="edit_role">Role (Peran) <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-user-tag input-icon"></i>
                            <select name="role" id="edit_role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="penjaga_perpustakaan">Penjaga Perpustakaan</option>
                                <option value="kepala_sekolah">Kepala Sekolah</option>
                            </select>
                        </div>
                        @error('role')
                            <span class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="edit_is_active">Status Akun <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-power-off input-icon"></i>
                            <select name="is_active" id="edit_is_active" class="form-control @error('is_active') is-invalid @enderror" required>
                                <option value="1">Aktif (Dapat Login)</option>
                                <option value="0">Non-Aktif (Akses Diblokir)</option>
                            </select>
                        </div>
                        @error('is_active')
                            <span class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="edit_password">Password Baru</label>
                        <div class="form-control-wrap">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" id="edit_password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Minimal 8 karakter...">
                        </div>
                        <p class="form-hint">
                            *Kosongkan jika tidak ingin mengganti password petugas.
                        </p>
                        @error('password')
                            <span class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel-modal" onclick="closeModal('edit-modal')">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-sync-alt"></i> Update Petugas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>