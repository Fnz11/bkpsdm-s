@extends('layouts.Pelatihan.pelatihan-dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <ol class="breadcrumb mt-2">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
@endsection

@section('content')
    <!-- Stats Cards Row -->
    <div class="row g-4 mb-5 mt-4 p-3">
        <!-- Total Pelatihan Tersedia Card -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="symbol bg-light-primary rounded-3 me-3 p-3">
                        <i class="bi bi-mortarboard fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="fs-7 text-muted mb-1">Pelatihan Tersedia</div>
                        <div class="d-flex align-items-end gap-2">
                            <div class="fs-4 fw-bold">{{ $countPelatihanTersedia }}</div>
                            <div class="fs-7 text-{{ $pelatihanTrendColor }} mb-1">
                                <i class="bi bi-arrow-{{ $pelatihanTrendDirection }}"></i>
                                {{ $percentagePelatihanTersedia }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Usulan Pelatihan -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
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
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="symbol bg-light-warning rounded-3 me-3 p-3">
                        <i class="bi bi-people fs-3 text-warning"></i>
                    </div>
                    <div>
                        <div class="fs-7 text-muted mb-1">Total Peserta</div>
                        <div class="d-flex align-items-end gap-2">
                            <div class="fs-4 fw-bold">{{ $countTotalPeserta }}</div>
                            <div class="fs-7 text-{{ $pesertaTrendColor }} mb-1">
                                <i class="bi bi-arrow-{{ $pesertaTrendDirection }}"></i> {{ $percentagePeserta }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pelatihan Berjalan -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
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

    <div class="row g-4 mb-5 p-3">
        <!-- Main Chart Card -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 bg-transparent py-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0">Statistik Pelatihan</h5>
                        <div class="d-flex gap-2">
                            <select id="chartType" class="form-select form-select-sm">
                                <option value="monthly">Bulanan</option>
                                <option value="jenispelatihan">Per Jenis</option>
                                <option value="metodepelatihan">Per Metode</option>
                                <option value="pelaksanaanpelatihan">Per Pelaksanaan</option>
                            </select>
                            <select id="yearFilter" class="form-select form-select-sm">
                                @foreach (range(date('Y') - 5, date('Y')) as $year)
                                    <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            </select>
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
            <div class="card border-0 shadow-sm h-100">
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

                        <!-- Jenis Pelatihan Distribution -->
                        <div class="mt-3">
                            <h6 class="fw-bold mb-3">Distribusi Jenis Pelatihan</h6>
                            <div id="jenisPelatihanChart" style="height: 200px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="row g-4 p-3">
        <!-- Recent Activities -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 bg-transparent py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Aktivitas Terbaru</h5>
                        <a href="#" class="btn btn-light-primary btn-sm">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="timeline px-4 py-3">
                        @forelse ($recentActivities as $activity)
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
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-info-circle fs-4 text-muted"></i>
                                <p class="text-muted mt-2">Tidak ada aktivitas terbaru</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Trainings & Deadline -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 bg-transparent py-4">
                    <ul class="nav nav-tabs nav-line-tabs mb-0" id="upcomingTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pelatihan-tab" data-bs-toggle="tab"
                                data-bs-target="#pelatihan-tab-pane" type="button" role="tab">
                                Pelatihan Mendatang
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="deadline-tab" data-bs-toggle="tab"
                                data-bs-target="#deadline-tab-pane" type="button" role="tab">
                                Tenggat Waktu
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content" id="upcomingTabsContent">
                        <!-- Pelatihan Mendatang Tab -->
                        <div class="tab-pane fade show active" id="pelatihan-tab-pane" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <tbody>
                                        @forelse ($upcomingTrainings as $training)
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
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-4">
                                                    <i class="bi bi-info-circle fs-4 text-muted"></i>
                                                    <p class="text-muted mt-2">Tidak ada pelatihan mendatang</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Deadline Tab -->
                        <div class="tab-pane fade" id="deadline-tab-pane" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <tbody>
                                        @forelse ($upcomingDeadlines as $deadline)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div
                                                            class="symbol symbol-40px bg-light-{{ $deadline['color'] }} rounded-3">
                                                            <i
                                                                class="bi bi-{{ $deadline['icon'] }} text-{{ $deadline['color'] }}"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $deadline['judul'] }}</div>
                                                            <div class="text-muted fs-7">
                                                                {{ $deadline['jenis'] }} - {{ $deadline['pelatihan'] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="fw-bold">{{ $deadline['tanggal_deadline'] }}</div>
                                                    <div class="text-muted fs-7">{{ $deadline['sisa_waktu'] }}</div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center py-4">
                                                    <i class="bi bi-info-circle fs-4 text-muted"></i>
                                                    <p class="text-muted mt-2">Tidak ada tenggat waktu mendatang</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-css')
    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .spinner {
            animation: spin 1s linear infinite;
        }

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

        .nav-line-tabs .nav-link.active {
            border-bottom: 3px solid #009ef7;
            color: #009ef7;
        }

        .nav-line-tabs .nav-link {
            color: #5e6278;
            border-bottom: 3px solid transparent;
            padding: 0.5rem 1rem;
        }
    </style>
@endsection

@section('scripts')
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts with default data
            let pelatihanChart, jenisPelatihanChart;

            // Function to update charts based on filters
            // Function to update charts based on filters
            function updateCharts() {
                const chartType = document.getElementById('chartType').value;
                const year = document.getElementById('yearFilter').value;

                // Show loading state
                document.querySelector('#pelatihanChart').innerHTML =
                    '<div class="text-center py-4"><i class="bi bi-arrow-repeat fs-4 text-muted spinner"></i><p class="text-muted mt-2">Memuat data...</p></div>';

                // Fetch data based on selected filters
                fetch(`/dashboard/pelatihan/chart-data?type=${chartType}&year=${year}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Chart data received:', data); // Debugging

                        // Update main chart
                        if (chartType === 'monthly') {
                            updateMonthlyChart(data);
                        } else {
                            updateCategoryChart(data, chartType);
                        }

                        // Update jenis pelatihan chart
                        if (data.jenis_pelatihan) {
                            updateJenisPelatihanChart(data.jenis_pelatihan);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching chart data:', error);
                        document.querySelector('#pelatihanChart').innerHTML =
                            '<div class="text-center py-4"><i class="bi bi-exclamation-triangle fs-4 text-danger"></i><p class="text-danger mt-2">Gagal memuat data chart</p></div>';
                    });
            }

            // Function to update monthly chart
            function updateMonthlyChart(data) {
                if (pelatihanChart) {
                    pelatihanChart.updateOptions({
                        series: data.series,
                        xaxis: {
                            categories: data.categories
                        },
                        chart: {
                            type: 'bar'
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '45%',
                                endingShape: 'rounded'
                            }
                        }
                    });
                } else {
                    pelatihanChart = new ApexCharts(document.querySelector("#pelatihanChart"), {
                        series: data.series,
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
                            categories: data.categories
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
                    });
                    pelatihanChart.render();
                }
            }

            // Function to update category chart
            function updateCategoryChart(data, chartType) {
                let title = '';
                switch (chartType) {
                    case 'jenis':
                        title = 'Per Jenis Pelatihan';
                        break;
                    case 'metode':
                        title = 'Per Metode Pelatihan';
                        break;
                    case 'pelaksanaan':
                        title = 'Per Pelaksanaan Pelatihan';
                        break;
                }

                if (pelatihanChart) {
                    pelatihanChart.updateOptions({
                        series: [{
                            data: data.series[0].data
                        }],
                        xaxis: {
                            categories: data.categories
                        },
                        chart: {
                            type: 'bar'
                        },
                        plotOptions: {
                            bar: {
                                columnWidth: '70%'
                            }
                        },
                        title: {
                            text: title,
                            align: 'center'
                        }
                    });
                } else {
                    pelatihanChart = new ApexCharts(document.querySelector("#pelatihanChart"), {
                        series: [{
                            name: 'Jumlah',
                            data: data.series[0].data
                        }],
                        chart: {
                            height: 350,
                            type: 'bar',
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#009ef7'],
                        plotOptions: {
                            bar: {
                                columnWidth: '70%',
                                endingShape: 'rounded'
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            width: 0
                        },
                        xaxis: {
                            categories: data.categories
                        },
                        yaxis: {
                            title: {
                                text: 'Jumlah'
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        title: {
                            text: title,
                            align: 'center',
                            style: {
                                fontSize: '16px',
                                fontWeight: 'bold'
                            }
                        }
                    });
                    pelatihanChart.render();
                }
            }

            // Function to update jenis pelatihan chart
            function updateJenisPelatihanChart(data) {
                if (jenisPelatihanChart) {
                    jenisPelatihanChart.updateSeries(data.series);
                } else {
                    jenisPelatihanChart = new ApexCharts(document.querySelector("#jenisPelatihanChart"), {
                        series: data.series,
                        chart: {
                            type: 'donut',
                            height: 200
                        },
                        labels: data.labels,
                        colors: ['#009ef7', '#50cd89', '#ffc700', '#7239ea', '#f1416c'],
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center'
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '65%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Total',
                                            formatter: function(w) {
                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    });
                    jenisPelatihanChart.render();
                }
            }

            // Pendaftaran Progress
            const pendaftaranOptions = {
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

            // Initialize with default data
            updateCharts();

            // Add event listeners for filters
            document.getElementById('chartType').addEventListener('change', updateCharts);
            document.getElementById('yearFilter').addEventListener('change', updateCharts);
        });
    </script>
@endsection
