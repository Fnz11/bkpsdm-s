@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0 fw-bold">Input Draft Diklat</h4>
                    </div>

                    <div class="card-body bg-light">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.ekatalog.storediklat') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="nama_pelatihan" class="form-label">Nama Pelatihan</label>
                                <input type="text" name="nama_pelatihan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="rumpun_pelatihan" class="form-label">Rumpun Pelatihan</label>
                                <input type="text" name="rumpun_pelatihan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="jenis_pelatihan" class="form-label">Jenis Pelatihan</label>
                                <input type="text" name="jenis_pelatihan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="metode_pelatihan" class="form-label">Metode Pelatihan</label>
                                <input type="text" name="metode_pelatihan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="pelaksanaan_pelatihan" class="form-label">Pelaksanaan Pelatihan</label>
                                <input type="text" name="pelaksanaan_pelatihan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama_penyelenggara" class="form-label">Nama Penyelenggara</label>
                                <input type="text" name="nama_penyelenggara" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama_CP" class="form-label">Nama Contact Person</label>
                                <input type="text" name="nama_CP" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="no_HP" class="form-label">No. HP</label>
                                <input type="text" name="no_HP" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="estimasi_biaya" class="form-label">Estimasi Biaya</label>
                                <input type="number" name="estimasi_biaya" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="file_pelatihan" class="form-label">File Pelatihan (PDF)</label>
                                <input type="file" name="file_pelatihan" class="form-control" accept="application/pdf">
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="hide">Hide</option>
                                    <option value="visible">Visible</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('admin.ekatalog.diklat') }}" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
                </div>
                </div>
@endsection