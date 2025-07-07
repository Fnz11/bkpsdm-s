<!-- tambahPertanyaan.blade.php -->
<div class="modal fade" id="modalTambahPertanyaan" tabindex="-1" aria-labelledby="modalTambahPertanyaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header border-0 pt-4 pb-1 px-4">
                <h5 class="modal-title fw-bold d-flex align-items-center">
                    <img src="{{ asset('images/iconHitamBiru.png') }}" alt="Icon" width="24" height="24" class="me-2" />
                    TAMBAH DATA PERTANYAAN AKPK
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPertanyaan" method="POST" action="{{ route('adminpertanyaandiri.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="tipeSoal" class="form-label">Tipe Soal</label>
                        <select class="form-select" id="tipeSoal" name="tipe_soal" required onchange="toggleFields()">
                            <option selected disabled>Pilih Tipe Soal</option>
                            <option value="Skala">Skala</option>
                            <option value="Essai">Essai</option>
                        </select>
                    </div>

                    <div class="mb-3" id="pertanyaanField">
                        <label for="pertanyaan" class="form-label">Pertanyaan</label>
                        <textarea class="form-control" id="pertanyaan" name="pertanyaan" rows="3"></textarea>
                    </div>

                    <div id="skalaFields">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori (Jabatan)</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option selected disabled>Pilih Jabatan</option>
                                @foreach ($jabatan as $jabatan)
                                    <option value="{{ $jabatan->jabatan }}">{{ $jabatan->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kompetensi" class="form-label">Kompetensi</label>
                            <select class="form-select" id="kompetensi" name="kompetensi">
                                <option selected disabled>Pilih Kompetensi</option>
                                @foreach ($kategori as $kategori)
                                    <option value="{{ $kategori->kategori }}">{{ $kategori->kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="standarMinimum" class="form-label">Standar Minimum</label>
                            <input type="number" class="form-control" id="standarMinimum" name="standar_minimum" min="0" max="5">
                        </div>
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
