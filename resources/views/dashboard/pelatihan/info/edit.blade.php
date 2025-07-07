@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Edit Informasi Pelatihan')
@section('page-title', 'Edit Informasi Pelatihan')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.info') }}">Informasi Pelatihan</a></li>
        <li class="breadcrumb-item active">Edit Informasi Pelatihan</li>
    </ol>
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('dashboard.pelatihan.info.update', $pelatihan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label><br>
                    @if ($pelatihan->gambar)
                        <img src="{{ asset('storage/' . $pelatihan->gambar) }}" alt="Gambar Pelatihan" class="img-thumbnail mb-2" width="200">
                    @endif
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="info_pelatihan" class="form-label">Informasi Pelatihan</label>
                    <textarea class="form-control" id="info_pelatihan" name="info_pelatihan" rows="3" required>{{ old('info_pelatihan', $pelatihan->info_pelatihan) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="link" class="form-label">Link</label>
                    <input type="text" class="form-control" id="link" name="link_pelatihan" value="{{ old('link_pelatihan', $pelatihan->link_pelatihan) }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard.pelatihan.info') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Pilih...',
                allowClear: true
            });
        });
    </script>
@endsection
