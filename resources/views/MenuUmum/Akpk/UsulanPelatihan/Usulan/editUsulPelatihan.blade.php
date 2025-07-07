<div class="modal fade" id="modalEditUsulan" tabindex="-1" aria-labelledby="modalEditUsulanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditUsulanLabel">Edit Usulan Pelatihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditUsulan" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editTahunPelatihan" class="form-label">Tahun</label>
                        <select class="form-select" id="editTahunPelatihan" name="tahun">
                            @for ($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editNamaPelatihan" class="form-label">Nama Pelatihan</label>
                        <input type="text" class="form-control" id="editNamaPelatihan" name="nama_pelatihan">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
