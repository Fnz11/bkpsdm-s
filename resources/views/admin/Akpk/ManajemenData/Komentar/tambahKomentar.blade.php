<div class="modal fade" id="modalTambahKomentar" tabindex="-1" aria-labelledby="modalTambahKomentarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header border-0 pt-4 pb-1 px-4">
          <h5 class="modal-title fw-bold d-flex align-items-center">
            <img src="{{ asset('images/iconHitamBiru.png') }}" alt="Icon" width="24" height="24" class="me-2" />
            TAMBAH DATA KOMENTAR
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
  
        <div class="modal-body px-4 pt-2 pb-0">
          <form id="formTambahPertanyaan">
            @csrf
            <div class="mb-3">
              <select class="form-select" id="kategori" name="kategori" required>
                <option selected disabled>Pilih Kategori</option>
                <option value="Eselon 2">Eselon 2</option>
                <option value="Eselon 3">Eselon 3</option>
                <option value="Eselon 4">Eselon 4</option>
                <option value="Pratama">Pratama</option>
              </select>
            </div>
  
            <div class="mb-3">
              <label class="form-label small fw-semibold">KOMPETENSI</label>
              <input type="text" class="form-control" id="kompetensi" name="kompetensi" placeholder="Masukkan kompetensi" required />
            </div>
  
            <div class="mb-3">
              <label class="form-label small fw-semibold">DESKRIPSI</label>
              <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2" placeholder="Write a message..." required></textarea>
            </div>
  
            <div class="mb-3">
              <label class="form-label small fw-semibold">SKOR SELF ASSESSMENT</label>
              <input type="number" class="form-control" id="skorSelfAssessment" name="skorSelfAssessment" value="5" min="0" max="5" required />
            </div>
  
            <div class="mb-3">
              <label class="form-label small fw-semibold">SKOR WAWANCARA ATASAN</label>
              <input type="number" class="form-control" id="skorWawancaraAtasan" name="skorWawancaraAtasan" value="5" min="0" max="5" required />
            </div>
  
            <div class="mb-4">
              <label class="form-label small fw-semibold">KOMENTAR</label>
              <textarea class="form-control" id="komentar" name="komentar" rows="2" placeholder="Write a message..." required></textarea>
            </div>
  
            <div class="text-end pb-4">
              <button type="submit" class="btn btn-primary px-4 py-2">Tambah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  