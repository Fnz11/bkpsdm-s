<div class="modal fade" id="modalFormDinamis" tabindex="-1" aria-labelledby="modalFormDinamisLabel" aria-hidden="true"
     style="z-index: 1501;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <form id="dynamicModalForm" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h5 class="modal-title fw-semibold" id="modalFormDinamisLabel">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Data
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                </div>
                <div class="modal-body bg-light rounded-bottom">
                    <div class="row g-3 py-2 px-1" id="modalFormFields"></div>
                </div>
                <div class="modal-footer bg-white border-top-0 rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="modalSubmitButton">
                        <i class="bi bi-check-circle me-1"></i> <span id="modalSubmitText">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
