@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header" style="background-color: #D1B28B; color: black;">
                    <h3 class="mb-0 text-center fw-bold">INPUT NAMA PELATIHAN</h3>
                </div>

                <div class="card-body" style="background-color: #f8f5f1;">
                    <div class="form-container mx-auto"
                        style="max-width: 900px; padding: 40px; background-color: #ffffff; border-radius: 10px; border: 1px solid #ccc; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);">
                        <form action="{{ route('admin.ekatalog.storepelatihan') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="jenis_pelatihan" class="form-label">Jenis Pelatihan</label>
                                <input type="text" class="form-control" id="jenis_pelatihan" name="jenis_pelatihan"
                                    placeholder="Masukkan jenis pelatihan" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama_lembaga" class="form-label">Nama Lembaga</label>
                                <input type="text" class="form-control" id="nama_lembaga" name="nama_lembaga"
                                    placeholder="Masukkan nama Lembaga" required>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('ekatalog.pelatihan') }}" class="btn btn-danger">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Add your CSS styles here */
</style>
@endsection