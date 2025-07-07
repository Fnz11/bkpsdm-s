<div class="modal fade" id="modalEditGaleri" tabindex="-1" aria-labelledby="modalEditGaleriLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header border-0 pt-4 pb-1 px-4">
          <h5 class="modal-title fw-bold d-flex align-items-center">
            <img src="{{ asset('images/iconHitamBiru.png') }}" alt="Icon" width="24" height="24" class="me-2" />
            EDIT DATA GALERI
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
  
        <div class="modal-body px-4 pt-2 pb-0">
          <form id="formEditGaleri" enctype="multipart/form-data">
            @csrf
            
            <!-- Upload Box -->
            <div class="mb-4">
              <div class="border border-2 border-primary rounded-3 text-center p-5 bg-light" style="border-style: dashed !important;">
                <div class="mb-2">
                  <i class="bi bi-upload fs-1 text-primary"></i>
                </div>
                <div>
                  <label for="fileUpload" class="text-primary fw-bold" style="cursor:pointer;">Click to upload</label>
                  <input type="file" name="file" id="fileUpload" class="d-none">
                  <p class="text-muted small mb-0">SVG, PNG, JPG, XLS, CSV or PDF (max. 5MB)</p>
                </div>
              </div>
            </div>
  
            <!-- Judul -->
            <div class="mb-3">
              <label for="judul" class="form-label small text-muted">JUDUL</label>
              <input type="text" class="form-control rounded-3" id="judul" name="judul" placeholder="Masukkan Judul">
            </div>
  
            <!-- Kategori (Dropdown) -->
            <div class="mb-3">
              <label for="kategori" class="form-label small text-muted">KATEGORI</label>
              <select class="form-select rounded-3" id="kategori" name="kategori">
                <option value="">Pilih Kategori</option>
                <option value="Tutorial">Tutorial</option>
                <option value="Banner">Banner</option>
                <option value="Gambar">Gambar</option>
              </select>
            </div>
  
            <!-- Deskripsi -->
            <div class="mb-4">
              <label for="deskripsi" class="form-label small text-muted">DESKRIPSI</label>
              <textarea class="form-control rounded-3" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan Deskripsi"></textarea>
            </div>
  
            <!-- Tombol Simpan -->
            <div class="text-end pb-4">
              <button type="submit" class="btn btn-success px-4 py-2">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  