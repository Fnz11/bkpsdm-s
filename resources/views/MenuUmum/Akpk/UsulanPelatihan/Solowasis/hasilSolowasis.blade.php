@extends('layouts.akpkLayouts.akpk')

<style>
    .legend-box {
        display: inline-block;
        width: 16px;
        height: 16px;
        margin-right: 8px;
        border-radius: 4px;
        flex-shrink: 0;
    }

    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 6px;
    }
</style>

@section('content')
    <section class="container">
        <div class="d-flex align-items-center mb-4">
            <img src="{{ asset('images/iconJudul.svg') }}" alt="Icon" class="me-2" style="width: 24px; height: 24px;">
            <h2 class="mb-0">Hasil Solowasis</h2>
        </div>

        <div class="row g-4">
            <!-- KIRI: Card Voting (TIDAK pakai h-100) -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-check">
                            <div class="pelatihan-info">
                                <h5 class="card-title mb-3">Pelatihan Teknis Fungsional Kepegawaian</h5>
                                <p class="card-text">
                                    Tanggal Pelaksanaan:<br>
                                    01 Oct 2023 - 01 Nov 2023
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KANAN: Chart + Legend (tetap card rapi) -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">Poling terisi <br><strong>200 responden</strong></h5>
                        <canvas id="votingChart" width="300" height="300"></canvas>

                        <!-- Custom Legend -->
                        <div class="mt-4 text-start">
                            <ul class="list-unstyled">
                                <li class="legend-item"><span class="legend-box" style="background-color: #A8E6A1;"></span>
                                    Pelatihan 1 - Hijau (50%)</li>
                                <li class="legend-item"><span class="legend-box" style="background-color: #A1D4F0;"></span>
                                    Pelatihan 2 - Biru (5%)</li>
                                <li class="legend-item"><span class="legend-box" style="background-color: #D1B3F0;"></span>
                                    Pelatihan 3 - Ungu (15%)</li>
                                <li class="legend-item"><span class="legend-box" style="background-color: #FFF3B0;"></span>
                                    Pelatihan 4 - Kuning (15%)</li>
                                <li class="legend-item"><span class="legend-box" style="background-color: #FFCCB6;"></span>
                                    Pelatihan 5 - Orange (15%)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const ctx = document.getElementById('votingChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Pelatihan 1', 'Pelatihan 2', 'Pelatihan 3', 'Pelatihan 4', 'Pelatihan 5'],
                datasets: [{
                    data: [50, 5, 15, 15, 15],
                    backgroundColor: [
                        '#A8E6A1', // Hijau muda
                        '#A1D4F0', // Biru muda
                        '#D1B3F0', // Ungu muda
                        '#FFF3B0', // Kuning muda
                        '#FFCCB6' // Orange muda
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection
