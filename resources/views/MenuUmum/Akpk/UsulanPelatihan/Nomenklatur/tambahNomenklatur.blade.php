<div class="modal fade" id="modalTambahNomenklatur" tabindex="-1" aria-labelledby="modalTambahNomenklaturLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Nomenklatur Pelatihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahNomenklatur">
                    @csrf
                    <div class="mb-3">
                        <label for="rumpunPelatihan" class="form-label">Rumpun</label>
                        <select class="form-select" id="rumpunPelatihan" name="rumpun" required>
                            <option selected disabled>Pilih Rumpun</option>
                            <option value="Kepemimpinan">Kepemimpinan</option>
                            <option value="Manajerial">Manajerial</option>
                            <option value="Teknis">Teknis</option>
                            <option value="Fungsional">Fungsional</option>
                            <option value="Sosial Kultural">Sosial Kultural</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="namaPelatihan" class="form-label">Nama Pelatihan</label>
                        <input type="text" class="form-control" id="namaPelatihan" name="nama_pelatihan" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
