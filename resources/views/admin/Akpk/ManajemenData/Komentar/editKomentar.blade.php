<div class="modal fade" id="modalEditKomentar" tabindex="-1" aria-labelledby="modalEditKomentarLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header border-0 pt-4 pb-1 px-4">
        <h5 class="modal-title fw-bold d-flex align-items-center">
          <img src="{{ asset('images/iconHitamBiru.png') }}" alt="Icon" width="24" height="24" class="me-2" />
          EDIT DATA KOMENTAR
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body px-4 pt-2 pb-0">
        <form id="formEditKomentar">
          @csrf

          <div class="mb-3">
            <label for="eselon" class="form-label small fw-semibold text-muted">ESELON</label>
            <select class="form-select" id="eselon" name="eselon" required>
              <option selected disabled>Pilih Eselon</option>
              <option value="Eselon 2">Eselon II</option>
              <option value="Eselon 3">Eselon III</option>
              <option value="Eselon 4">Eselon IV</option>
              <option value="Pratama">Pratama</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="kompetensi" class="form-label small fw-semibold text-muted">KOMPETENSI</label>
            <input type="text" class="form-control" id="kompetensi" name="kompetensi" placeholder="Kompetensi" required>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label small fw-semibold text-muted">DESKRIPSI</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi" required></textarea>
          </div>

          <div class="mb-3">
            <label for="self_assessment" class="form-label small fw-semibold text-muted">SKOR SELF ASSESSMENT</label>
            <input type="number" class="form-control" id="self_assessment" name="self_assessment" placeholder="Skor Self Assessment" required>
          </div>

          <div class="mb-3">
            <label for="wawancara_atasan" class="form-label small fw-semibold text-muted">SKOR WAWANCARA ATASAN</label>
            <input type="number" class="form-control" id="wawancara_atasan" name="wawancara_atasan" placeholder="Skor Wawancara Atasan" required>
          </div>

          <div class="mb-3">
            <label for="komentar" class="form-label small fw-semibold text-muted">KOMENTAR</label>
            <textarea class="form-control" id="komentar" name="komentar" rows="3" placeholder="Komentar" required></textarea>
          </div>

          <div class="text-end pb-4">
            <button type="submit" class="btn btn-success px-4 py-2">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
