<div class="modal fade" id="modalLihatKomentar" tabindex="-1" aria-labelledby="modalLihatKomentarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header border-0 pt-4 pb-1 px-4">
          <h5 class="modal-title fw-bold d-flex align-items-center">
            <img src="{{ asset('images/iconHitamBiru.png') }}" alt="Icon" width="24" height="24" class="me-2" />
            DATA KOMENTAR
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
  
        <div class="modal-body px-4 pt-2 pb-0">
          <form id="formLihatKomentar">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Kategori :</label>
                <div class="form-control bg-light">Eselon II</div>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Tipe :</label>
                <div class="form-control bg-light">Esai</div>
              </div>
            </div>
  
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Kompetensi :</label>
                <div class="form-control bg-light">Integritas</div>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Status :</label>
                <div class="form-control bg-light">Active</div>
              </div>
            </div>
  
            <div class="mb-3">
              <label class="form-label fw-semibold">Deskripsi :</label>
              <div class="form-control bg-light" style="min-height: 80px;">Mematuhi dan menegakkan nilai-nilai dan etika organisasi pada tingkat yang sangat tinggi.</div>
            </div>
  
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Skor Self Assessment :</label>
                <div class="form-control bg-light">5</div>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Skor Wawancara Atasan :</label>
                <div class="form-control bg-light">5</div>
              </div>
            </div>
  
            <div class="mb-3">
              <label class="form-label fw-semibold">Jawaban :</label>
              <div class="form-control bg-light" style="min-height: 50px;"></div>
            </div>
  
            <div class="d-flex justify-content-between pb-4">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                ← Kembali
              </button>
              <button type="button" class="btn btn-warning text-white" style="width: 120px;" data-bs-toggle="modal" data-bs-target="#modalEditKomentar">
                Edit
            </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  