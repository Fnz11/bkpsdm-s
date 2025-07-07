@extends('layouts.akpkLayouts.akpk')

@section('content')
    <style>
        .card {
            height: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            height: 100%;
            padding: 1.25rem;
        }

        .pelatihan-info {
            margin-left: 1.5rem;
        }

        .card-text {
            margin-top: 1rem;
        }
    </style>

    <section class="container">
        <div class="d-flex align-items-center mb-4">
            <img src="images/iconJudul.svg" alt="Icon" class="me-2" style="width: 24px; height: 24px;">
            <h2 class="mb-0">Usulan Solowasis</h2>
            
        </div>
        <p class="text-primary">Harap pilih salah satu jenis pelatihan yang tersedia</p>
        @php
            $solowasis = [
                [
                    'nama_pelatihan' => 'Pelatihan Teknis Fungsional Kepegawaian',
                    'tanggal_mulai' => '2023-10-01',
                    'tanggal_selesai' => '2023-11-01',
                ],
                [
                    'nama_pelatihan' => 'Pelatihan Manajerial Dasar',
                    'tanggal_mulai' => '2023-11-01',
                    'tanggal_selesai' => '2023-12-01',
                ],
                [
                    'nama_pelatihan' => 'Pelatihan Kepemimpinan Tingkat II',
                    'tanggal_mulai' => '2023-12-01',
                    'tanggal_selesai' => '2024-01-01',
                ],
            ];
        @endphp

        <form action="" >
            @csrf
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($solowasis as $index => $item)
                    <div class="col">
                        <div class="card h-100" onclick="document.getElementById('pelatihan{{ $index }}').click();">
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="selected_pelatihan"
                                        id="pelatihan{{ $index }}" value="{{ $item['nama_pelatihan'] }}">
                                    <div class="pelatihan-info">
                                        <h5 class="card-title mb-3">{{ $item['nama_pelatihan'] }}</h5>
                                        <p class="card-text">
                                            Tanggal Pelaksanaan:<br>
                                            {{ \Carbon\Carbon::parse($item['tanggal_mulai'])->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($item['tanggal_selesai'])->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-grid gap-2 col-6 mx-auto mt-4">
                <a href="/hasilSolowasis" class="btn btn-primary" type="submit">Submit</a>
            </div>
        </form>
    </section>
@endsection
