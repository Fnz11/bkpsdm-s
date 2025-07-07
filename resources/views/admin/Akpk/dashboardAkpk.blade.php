@extends('layouts.app')
<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .progress {
        height: 8px;
    }

    .trend-badge {
        position: absolute;
        top: 20px;
        right: 20px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .bg-primary-section {
        height: 180px;
        border-radius: 0 0 10px 10px;
    }

    .user-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-bottom: none;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        margin-right: 12px;
        border-radius: 50%;
        overflow: hidden;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.95rem;
        color: #333;
        line-height: 1.2;
    }

    .user-title {
        color: #6c757d;
        font-size: 0.8rem;
        line-height: 1.2;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .btn-outline-primary {
        border-color: #e0e0e0;
        color: #5c6bc0;
    }

    .btn-outline-primary:hover {
        background-color: #5c6bc0;
        border-color: #5c6bc0;
    }

    .component-container {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
    }

    .component-container:hover {
        border-color: #d1d5db;
    }
</style>

@section('content')
    <div class="">
        <!-- Container untuk konten -->
        <div class="row g-4">
            @php
                $statCards = [
                    [
                        'icon' => 'fas fa-users',
                        'iconBg' => 'primary',
                        'trend' => 'up',
                        'trendValue' => '3.2',
                        'title' => 'Total Pegawai',
                        'value' => '2,589',
                        'progress' => 75
                    ],
                    [
                        'icon' => 'fas fa-clipboard-check',
                        'iconBg' => 'success',
                        'trend' => 'up',
                        'trendValue' => '7.8',
                        'title' => 'Total Assessment',
                        'value' => '1,467',
                        'progress' => 65
                    ],
                    [
                        'icon' => 'fas fa-graduation-cap',
                        'iconBg' => 'warning',
                        'trend' => 'up',
                        'trendValue' => '5.4',
                        'title' => 'Usulan Pelatihan Umum',
                        'value' => '856',
                        'progress' => 85
                    ],
                    [
                        'icon' => 'fas fa-laptop-code',
                        'iconBg' => 'info',
                        'trend' => 'up',
                        'trendValue' => '12.3',
                        'title' => 'Usulan Solowasis',
                        'value' => '324',
                        'progress' => 90
                    ]
                ];
            @endphp

            @foreach($statCards as $card)
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card stat-card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon bg-{{ $card['iconBg'] }} bg-opacity-10 text-{{ $card['iconBg'] }}">
                                    <i class="{{ $card['icon'] }}"></i>
                                </div>
                                <span class="badge bg-{{ $card['trend'] === 'up' ? 'success' : 'danger' }} trend-badge">
                                    <i class="fas fa-arrow-{{ $card['trend'] }} me-1"></i>{{ $card['trendValue'] }}%
                                </span>
                            </div>
                            <h6 class="text-muted mb-2">{{ $card['title'] }}</h6>
                            <h4 class="mb-3">{{ $card['value'] }}</h4>
                            <div class="progress">
                                <div class="progress-bar bg-{{ $card['iconBg'] }}" style="width: {{ $card['progress'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Ganti bagian chart dan analisis -->
        <div class="row mt-4">
            <!-- Chart Section -->
            <div class="col-lg-8">
                <div class="component-container p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="mb-0 fw-bold">Evaluasi Kompetensi Pegawai</h6>
                            <small class="text-muted">Seluruh ASN Kota Surakarta</small>
                        </div>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" id="chartPeriod">
                                <option value="1">1 Hari</option>
                                <option value="7">7 Hari</option>
                                <option value="30">30 Hari</option>
                                <option value="365" selected>1 Tahun</option>
                            </select>
                        </div>
                    </div>
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="kompetensiChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Analisis Section -->
            <div class="col-lg-4">
                <div class="component-container p-4">
                    <h6 class="fw-bold mb-4">Analisis Pelatihan Solowasis</h6>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small">PELATIHAN</span>
                        <span class="text-muted small">PEMINAT</span>
                    </div>

                    <!-- Training List -->
                    <div class="training-list">
                        @php
                            $trainings = [
                                [
                                    'name' => 'Public Speaking',
                                    'participants' => 85,
                                    'percentage' => 85,
                                ],
                                [
                                    'name' => 'Leadership',
                                    'participants' => 46,
                                    'percentage' => 46,
                                ],
                                [
                                    'name' => 'Digital Marketing',
                                    'participants' => 38,
                                    'percentage' => 38,
                                ],
                                [
                                    'name' => 'Cyber Security',
                                    'participants' => 27,
                                    'percentage' => 27,
                                ],
                                [
                                    'name' => 'Data Science',
                                    'participants' => 17,
                                    'percentage' => 17,
                                ],
                                [
                                    'name' => 'Bahasa Inggris',
                                    'participants' => 3,
                                    'percentage' => 3,
                                ],
                            ];
                        @endphp

                        @foreach ($trainings as $training)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="progress flex-grow-1 me-3" style="height: 35px; background-color: #F5F6FA;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $training['percentage'] }}%; background-color: #DDE7FF;"
                                        aria-valuenow="{{ $training['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                        <span class="ms-2 text-dark">{{ $training['name'] }}</span>
                                    </div>
                                </div>
                                <span class="fw-medium" style="min-width: 30px;">{{ $training['participants'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('kompetensiChart').getContext('2d');
        let kompetensiChart;

        const mockData = {
            1: {
                atasan: [85, 82, 88, 84, 86, 83, 89],
                assessment: [75, 72, 83, 73, 72, 74, 79]
            },
            7: {
                atasan: [87, 84, 90, 86, 88, 85, 91],
                assessment: [77, 74, 85, 75, 74, 76, 81]
            },
            30: {
                atasan: [89, 86, 91, 88, 89, 87, 92],
                assessment: [79, 75, 86, 76, 75, 77, 82]
            },
            365: {
                atasan: [90, 87, 92, 89, 90, 88, 93],
                assessment: [80, 76, 87, 77, 76, 78, 83]
            }
        };

        const createChart = (period) => {
            if (kompetensiChart) {
                kompetensiChart.destroy();
            }

            const data = mockData[period] || mockData[365]; // Default to 1 year if period not found

            kompetensiChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Integrasi', 'Kerjasama', 'Komunikasi', 'Orientasi Hasil', 'Pelayanan Publik',
                        'Pengembangan diri', 'Toleransi'
                    ],
                    datasets: [{
                        label: 'Self Atasan',
                        data: data.atasan,
                        borderColor: '#3A58F2',
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Self Assessment',
                        data: data.assessment,
                        borderColor: '#53D1EF',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            min: 70,
                            max: 100,
                            ticks: {
                                stepSize: 5
                            }
                        }
                    }
                }
            });
        };

        // Handle period change
        document.getElementById('chartPeriod').addEventListener('change', function(e) {
            createChart(parseInt(e.target.value));
        });

        // Initial chart creation with 1 year data
        createChart(365);
    </script>
@endsection
