<div class="modal fade" id="modalLihatGaleri" tabindex="-1" aria-labelledby="modalLihatGaleriLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        
        <div class="modal-header border-0 pt-4 pb-2 px-4">
          <h5 class="modal-title fw-bold d-flex align-items-center">
            <img src="{{ asset('images/iconHitamBiru.png') }}" alt="Icon" width="24" height="24" class="me-2" />
            DATA GALERI
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
  
        <div class="modal-body px-5 pt-3">
          
          <!-- Image Preview -->
          <div class="text-center mb-4">
            <img id="previewImageLihat" src="{{ asset('images/default.jpg') }}" alt="Preview" class="rounded-3" style="max-width: 250px; max-height: 250px; object-fit: cover;">
          </div>
  
          <!-- Data Galeri -->
          <div class="mb-3">
            <label class="form-label fw-bold">Judul</label>
            <input type="text" class="form-control rounded-3" id="judulLihat" readonly>
          </div>
  
          <div class="mb-3">
            <label class="form-label fw-bold">Kategori</label>
            <div class="border p-2 rounded-3 bg-light">
              <span id="kategoriLihat">-</span>
            </div>
          </div>
  
          <div class="mb-4">
            <label class="form-label fw-bold">Deskripsi</label>
            <div class="border p-2 rounded-3 bg-light" style="min-height: 100px;">
              <span id="deskripsiLihat">-</span>
            </div>
          </div>
  
          <!-- Tombol Aksi -->
          <div class="d-flex justify-content-between pb-4">
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
              ← Kembali
            </button>
            <button type="button" class="btn btn-warning" id="btnEditGaleri">
              Edit
            </button>
          </div>
  
        </div>
        
      </div>
    </div>
  </div>
  