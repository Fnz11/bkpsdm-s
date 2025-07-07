@extends('layouts.akpkLayouts.akpk')

<style>
    thead.bg-primary th {
        background-color: #C1D6F7 !important;
    }

    .table-bordered {
        border: none;
    }

    .rounded .table-bordered thead th:first-child {
        border-top-left-radius: 0.25rem;
    }

    .rounded .table-bordered thead th:last-child {
        border-top-right-radius: 0.25rem;
    }
</style>

@section('content')
    <section class="container">
        <div class="d-flex align-items-center mb-4">
            <img src="images/iconJudul.svg" alt="Icon" class="me-2" style="width: 24px; height: 24px;">
            <h2 class="mb-0">FORMULIR SELF ASSESSMENT KOMPETENSI ASN</h2>
        </div>

        <!-- Form Data Diri -->
        <div class="card mb-4">

            <div class="card-body">
                <form>
                    <div class="row mb-2">
                        <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nama" value="{{ $userInfo['nama'] }}"
                                readonly>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="nip" class="col-sm-3 col-form-label">NIP</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nip" value="{{ $userInfo['nip'] }}"
                                readonly>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="jabatan" value="{{ $userInfo['jabatan'] }}"
                                readonly>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label for="unit_kerja" class="col-sm-3 col-form-label">Unit Kerja</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="unit_kerja" value="{{ $userInfo['unit_kerja'] }}"
                                readonly>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <form method="POST" action="{{ route('self-assessment.simpan') }}">
            @csrf
            <!-- Assessment Dinamis -->
            <!-- Satu Tabel untuk Semua Pertanyaan -->
            <div class="card mb-4">
                <div class="table-responsive rounded overflow-hidden">
                    <table class="table table-bordered mb-0">
                        <thead class="bg-primary text-white">
                            <tr class="text-center">
                                <th style="vertical-align: middle;">No</th>
                                <th style="vertical-align: middle;">Kompetensi</th>
                                <th style="vertical-align: middle;">Deskripsi</th>
                                <th style="vertical-align: middle;">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pertanyaan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->kategori->kategori ?? '-' }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-4">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div class="d-flex flex-column align-items-center" style="width: 30px">
                                                    <input class="form-check-input mx-auto" type="radio"
                                                        name="nilai_{{ $item->id }}"
                                                        id="nilai_{{ $item->id }}_{{ $i }}"
                                                        value="{{ $i }}">
                                                    <span class="mt-1">{{ $i }}</span>
                                                </div>
                                            @endfor
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer" style="background-color: #C1D6F7"></div>
            </div>


            <!-- Form Assessment Kompetensi Kepribadian -->
            <div class="card mb-4">
                <div class="card-header fw-bold" style="background-color: #C1D6F7">Identifikasi Kebutuhan
                </div>

                <div class="card mb-4">
                    @foreach ($pertanyaanEssay as $index => $item)
                        <div class="mb-2 p-3">
                            <label for="essay_{{ $index }}" class="form-label">
                                {{ $index + 1 }}. {{ $item->pertanyaan }}
                            </label>
                            <textarea class="form-control" name="jawaban_essay[{{ $item->id }}]" id="essay_{{ $index }}"
                                rows="3"></textarea>
                        </div>
                    @endforeach

                    <div class="card-footer" style="background-color: #C1D6F7"></div>
                </div>
            </div>
        <!-- Button Simpan Data -->
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary" onclick="simpanData()">Simpan
                Data</button>
        </div>
    </form>
    </section>

    <script>
        function simpanData() {
            let tanggal = document.getElementById('tanggal_pengisian').value;
            Swal.fire({
                title: 'Hasil Tersimpan',
                text: 'Data telah berhasil disimpan.',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        }
    </script>
@endsection
