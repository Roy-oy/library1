
<div class="modal-overlay form-overlay-modal edit-active" id="edit-modal">
    <div class="modal-box">
        <div class="form-card">
            <div class="form-card-header edit-mode">
                <div class="hdr-icon"><i class="fas fa-edit"></i></div>
                <div>
                    <h2>Formulir Edit Kategori</h2>
                    <p>Ubah nama kategori buku perpustakaan untuk koleksi umum.</p>
                </div>
            </div>

            <form action="" method="POST" id="edit-form-action">
                @csrf
                @method('PUT')

                <div class="form-body">
                    <div class="form-group">
                        <label for="edit_nama_kategori">Nama Kategori <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-tags input-icon"></i>
                            <input type="text" id="edit_nama_kategori" name="nama_kategori" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror"
                                   value="{{ old('nama_kategori') }}" placeholder="Contoh: Novel, Sains, Teknologi, Sejarah..." required>
                        </div>
                        <p class="form-hint">
                            Perbarui nama kategori buku untuk koleksi umum perpustakaan. Nama kategori yang rapi memudahkan pencarian buku oleh siswa.
                        </p>
                        @error('nama_kategori')
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
                        <i class="fas fa-save"></i> Perbarui Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>