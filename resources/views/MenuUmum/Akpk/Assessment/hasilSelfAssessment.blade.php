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
            <h2 class="mb-0">Hasil Self Assessment</h2>
        </div>

        <!-- Form Assessment Kompetensi Manajerial -->
        <div class="card mb-4">
            <div class="table-responsive rounded overflow-hidden">
                <table class="table table-bordered mb-0">
                    <thead class="bg-primary text-white">
                        <tr class="text-center">
                            <th style="vertical-align: middle;">No</th>
                            <th style="vertical-align: middle;">Kompetensi</th>
                            <th style="vertical-align: middle;">Deskripsi</th>
                            <th style="vertical-align: middle;">Nilai</th>
                            <th style="vertical-align: middle;">Komentar</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($evaluasiDiri as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->pertanyaan->kategori->kategori ?? '-' }}</td>
                        <td>{{ $item->pertanyaan->deskripsi ?? '-' }}</td>
                        <td>{{ $item->jawaban->skor ?? '-' }}</td>
                        <td>{{ $item->jawaban->komentar ?? '-' }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer" style="background-color: #C1D6F7"></div>
        </div>

        <!-- Form Assessment Kompetensi Kepribadian -->
        @foreach ($evaluasiEssay as $item)
        <div class="card mb-1 p-3">
            <label class="form-label">{{ $item->pertanyaanEssay->pertanyaan }}</label>
            <textarea class="form-control" rows="3" readonly>{{ $item->jawaban }}</textarea>
        </div>
    @endforeach
    </section>
@endsection
