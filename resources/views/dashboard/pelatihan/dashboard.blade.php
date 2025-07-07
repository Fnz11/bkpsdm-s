@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
@endsection

@section('content')
    <!-- Stats Cards Row -->
    <div class="row g-4 mb-3 mt-4 p-3 pb-0">
        <!-- Total Pelatihan Tersedia Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="symbol bg-light-primary rounded-3 me-3 p-3">
                        <i class="bi bi-mortarboard fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="fs-7 text-muted mb-1">Pelatihan Tersedia</div>
                        <div class="d-flex align-items-end gap-2">
                            <div class="fs-4 fw-bold">{{ $countPelatihanTersedia }}</div>
                            <div class="fs-7 text-success mb-1">
                                <i class="bi bi-arrow-up"></i> {{ $percentagePelatihanTersedia }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Usulan Pelatihan -->
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="symbol bg-light-success rounded-3 me-3 p-3">
                        <i class="bi bi-file-earmark-text fs-3 text-success"></i>
                    </div>
                    <div>
                        <div class="fs-7 text-muted mb-1">Usulan Pelatihan</div>
                        <div class="d-flex align-items-end gap-2">
                            <div class="fs-4 fw-bold">{{ $countUsulanPelatihan }}</div>
                            <div class="fs-7 text-{{ $usulanTrendColor }} mb-1">
                                <i class="bi bi-arrow-{{ $usulanTrendDirection }}"></i> {{ $percentageUsulanPelatihan }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Peserta -->
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="symbol bg-light-warning rounded-3 me-3 p-3">
                        <i class="bi bi-people fs-3 text-warning"></i>
                    </div>
                    <div>
                        <div class="fs-7 text-muted mb-1">Total Peserta</div>
                        <div class="fs-4 fw-bold">{{ $countTotalPeserta }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pelatihan Berjalan -->
        <div class="col-md-3">
            <div class="card border-0 shadow rounded-3 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="symbol bg-light-info rounded-3 me-3 p-3">
                        <i class="bi bi-calendar2-check fs-3 text-info"></i>
                    </div>
                    <div>
                        <div class="fs-7 text-muted mb-1">Pelatihan Berjalan</div>
                        <div class="fs-4 fw-bold">{{ $countPelatihanBerjalan }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-3 px-3">
        <!-- Main Chart Card -->
        <div class="col-md-8">
            <div class="card border-0 shadow rounded-3">
                <div class="card-header border-0 bg-transparent py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0">Statistik Pelatihan Tahun Ini</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-light-primary btn-sm active">Bulanan</button>
                            <button class="btn btn-light-primary btn-sm">Per Jenis</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="pelatihanChart" style="height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Progress & Stats -->
        <div class="col-md-4">
            <div class="card border-0 shadow rounded-3">
                <div class="card-header border-0 bg-transparent py-4">
                    <h5 class="fw-bold mb-0">Status Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-4">
                        <!-- Circular Progress -->
                        <div class="text-center mb-3">
                            <div id="pendaftaranProgress"></div>
                        </div>

                        <!-- Stats List -->
                        <div class="d-flex justify-content-between p-3 bg-light-primary rounded-3">
                            <div>
                                <div class="fs-7 text-muted">Terverifikasi</div>
                                <div class="fs-5 fw-bold">{{ $countPendaftaranTerverifikasi }}</div>
                            </div>
                            <div>
                                <div class="fs-7 text-muted">Menunggu</div>
                                <div class="fs-5 fw-bold">{{ $countPendaftaranMenunggu }}</div>
                            </div>
                            <div>
                                <div class="fs-7 text-muted">Ditolak</div>
                                <div class="fs-5 fw-bold">{{ $countPendaftaranDitolak }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="row g-4 p-3 pt-0">
        <!-- Recent Activities -->
        <div class="col-md-6">
            <div class="card border-0 shadow rounded-3">
                <div class="card-header border-0 bg-transparent py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Aktivitas Terbaru</h5>
                        <button class="btn btn-light-primary btn-sm">Lihat Semua</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="timeline px-4 py-3">
                        @foreach ($recentActivities as $activity)
                            <div class="timeline-item pb-4">
                                <div class="timeline-line w-40px"></div>
                                <div class="timeline-icon symbol symbol-40px">
                                    <div class="symbol-label bg-light">
                                        <i class="bi bi-{{ $activity['icon'] }} fs-4 text-{{ $activity['color'] }}"></i>
                                    </div>
                                </div>
                                <div class="timeline-content ps-4">
                                    <div class="fw-bold">{{ $activity['title'] }}</div>
                                    <div class="text-muted fs-7 mb-2">{{ $activity['time'] }}</div>
                                    <div class="p-3 bg-light-{{ $activity['color'] }} rounded-3 fs-7">
                                        {{ $activity['description'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Trainings -->
        <div class="col-md-6">
            <div class="card border-0 shadow rounded-3">
                <div class="card-header border-0 bg-transparent py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Pelatihan Mendatang</h5>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm form-select-solid w-100px">
                                <option value="all">Semua</option>
                                <option value="week">Minggu Ini</option>
                                <option value="month">Bulan Ini</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <tbody>
                                @foreach ($upcomingTrainings as $training)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="symbol symbol-40px bg-light-primary rounded-3">
                                                    <i class="bi bi-calendar-event text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $training['nama_pelatihan'] }}</div>
                                                    <div class="text-muted fs-7">
                                                        {{ $training['jenis_pelatihan'] }} -
                                                        {{ $training['peserta_count'] }} Peserta
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="fw-bold">{{ $training['tanggal_mulai'] }}</div>
                                            <div class="text-muted fs-7">{{ $training['tempat_pelatihan'] }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-css')
    <style>
        .symbol {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .bg-light-primary {
            background-color: #f1faff !important;
        }

        .bg-light-success {
            background-color: #e8fff3 !important;
        }

        .bg-light-warning {
            background-color: #fff8dd !important;
        }

        .bg-light-info {
            background-color: #f8f5ff !important;
        }

        .bg-light-danger {
            background-color: #fff5f8 !important;
        }

        .text-primary {
            color: #009ef7 !important;
        }

        .text-success {
            color: #50cd89 !important;
        }

        .text-warning {
            color: #ffc700 !important;
        }

        .text-info {
            color: #7239ea !important;
        }

        .text-danger {
            color: #f1416c !important;
        }

        .progress-ring {
            padding: 2rem;
        }

        .timeline {
            position: relative;
        }

        .timeline-item {
            position: relative;
        }

        .timeline-line {
            position: absolute;
            left: 19px;
            width: 2px;
            bottom: 0;
            top: 40px;
            background-color: #f5f8fa;
        }

        .timeline-icon {
            position: relative;
            z-index: 1;
        }

        .symbol-40px {
            width: 40px;
            height: 40px;
        }
    </style>
@endsection

@section('scripts')
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pelatihan Chart
            var pelatihanOptions = {
                series: [{
                        name: 'Pelatihan Tersedia',
                        data: {!! json_encode($chartData['pelatihan_tersedia']) !!}
                    },
                    {
                        name: 'Pendaftar',
                        data: {!! json_encode($chartData['pendaftar']) !!}
                    },
                    {
                        name: 'Usulan',
                        data: {!! json_encode($chartData['usulan']) !!}
                    }
                ],
                chart: {
                    height: 350,
                    type: 'bar',
                    stacked: false,
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#009ef7', '#50cd89', '#ffc700'],
                plotOptions: {
                    bar: {
                        columnWidth: '45%',
                        endingShape: 'rounded'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: [0, 0, 0]
                },
                xaxis: {
                    categories: {!! json_encode($chartData['months']) !!},
                },
                yaxis: {
                    title: {
                        text: 'Jumlah'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " pelatihan"
                        }
                    }
                }
            };
            new ApexCharts(document.querySelector("#pelatihanChart"), pelatihanOptions).render();

            // Pendaftaran Progress
            var pendaftaranOptions = {
                series: [{{ $pendaftaranProgress }}],
                chart: {
                    height: 250,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '70%',
                        },
                        dataLabels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '16px',
                                offsetY: -10
                            },
                            value: {
                                fontSize: '30px',
                                show: true,
                                formatter: function(val) {
                                    return val + '%';
                                }
                            },
                            total: {
                                show: true,
                                label: 'Verifikasi',
                                formatter: function(w) {
                                    return '{{ $countPendaftaranTerverifikasi }}/{{ $countTotalPendaftaran }}';
                                }
                            }
                        }
                    },
                },
                labels: ['Progress'],
                colors: ['#50cd89']
            };
            new ApexCharts(document.querySelector("#pendaftaranProgress"), pendaftaranOptions).render();
        });
    </script>
@endsection
