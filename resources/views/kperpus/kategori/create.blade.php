<div class="modal-overlay form-overlay-modal edit-active" id="create-modal">
    <div class="modal-box">
        <div class="form-card">
            <div class="form-card-header edit-mode">
                <div class="hdr-icon"><i class="fas fa-plus"></i></div>
                <div>
                    <h2>Formulir Tambah Kategori</h2>
                    <p>Tambah kategori buku perpustakaan baru untuk koleksi umum.</p>
                </div>
            </div>

            <form action="{{ route('kperpus.kategori.store') }}" method="POST">
                @csrf
                <div class="form-body">
                    <div class="form-group">
                        <label for="create_nama_kategori">Nama Kategori <span class="req">*</span></label>
                        <div class="form-control-wrap">
                            <i class="fas fa-tags input-icon"></i>
                            <input type="text" id="create_nama_kategori" name="nama_kategori" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror"
                                   value="{{ old('nama_kategori') }}" placeholder="Contoh: Novel, Sains, Teknologi, Sejarah..." required>
                        </div>
                        <p class="form-hint">
                            Masukkan nama kategori buku baru untuk koleksi umum perpustakaan. Nama kategori yang rapi memudahkan pencarian buku oleh siswa.
                        </p>
                        @error('nama_kategori')
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
                        <i class="fas fa-plus"></i> Tambah Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>