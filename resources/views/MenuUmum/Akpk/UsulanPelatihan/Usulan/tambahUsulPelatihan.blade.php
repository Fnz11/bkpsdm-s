<div class="modal fade" id="modalTambahUsulan" tabindex="-1" aria-labelledby="modalTambahUsulanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahUsulanLabel">Tambah Usulan Pelatihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahUsulan">
                    <div class="mb-3">
                        <label for="tahunPelatihan" class="form-label">Tahun</label>
                        <select class="form-select" id="tahunPelatihan">
                            <option selected disabled>Pilih Tahun</option>
                            @for ($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rumpun" class="form-label">Rumpun</label>
                        <select class="form-select" id="rumpun">
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
                        <select class="form-select" id="rumpun">
                            <option selected disabled>Nama Pelatihan</option>
                            <option value="PKA">Pelatihan Kepemimpinan Administrator</option>
                            <option value="PMSDM">Pelatihan Manajemen SDM</option>
                        </select>
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
