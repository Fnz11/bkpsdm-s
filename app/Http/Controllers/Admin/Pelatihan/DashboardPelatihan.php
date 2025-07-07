<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan2Tersedia;
use App\Models\Pelatihan2Usulan;
use App\Models\Pelatihan3Pendaftaran;
use App\Models\PelatihanTenggatUpload;
use App\Models\ref_jenispelatihans;
use App\Models\ref_metodepelatihans;
use App\Models\ref_pelaksanaanpelatihans;
use App\Models\RefJenispelatihan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardPelatihan extends Controller
{
    public function index()
    {
        // Hitung statistik
        $countPelatihanTersedia = Pelatihan2Tersedia::count();
        $countUsulanPelatihan = Pelatihan2Usulan::count();
        $countTotalPeserta = Pelatihan3Pendaftaran::count();
        $countPelatihanBerjalan = Pelatihan2Tersedia::where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->count();

        // Hitung persentase perubahan
        $lastMonthPelatihan = Pelatihan2Tersedia::whereMonth('created_at', now()->subMonth()->month)->count();
        $percentagePelatihanTersedia = $lastMonthPelatihan > 0 ?
            round(($countPelatihanTersedia - $lastMonthPelatihan) / $lastMonthPelatihan * 100, 1) : 100;
        $pelatihanTrendDirection = $countPelatihanTersedia >= $lastMonthPelatihan ? 'up' : 'down';
        $pelatihanTrendColor = $countPelatihanTersedia >= $lastMonthPelatihan ? 'success' : 'danger';

        $lastMonthUsulan = Pelatihan2Usulan::whereMonth('created_at', now()->subMonth()->month)->count();
        $percentageUsulanPelatihan = $lastMonthUsulan > 0 ?
            round(($countUsulanPelatihan - $lastMonthUsulan) / $lastMonthUsulan * 100, 1) : 100;
        $usulanTrendDirection = $countUsulanPelatihan >= $lastMonthUsulan ? 'up' : 'down';
        $usulanTrendColor = $countUsulanPelatihan >= $lastMonthUsulan ? 'success' : 'danger';

        $lastMonthPeserta = Pelatihan3Pendaftaran::whereMonth('created_at', now()->subMonth()->month)->count();
        $percentagePeserta = $lastMonthPeserta > 0 ?
            round(($countTotalPeserta - $lastMonthPeserta) / $lastMonthPeserta * 100, 1) : 100;
        $pesertaTrendDirection = $countTotalPeserta >= $lastMonthPeserta ? 'up' : 'down';
        $pesertaTrendColor = $countTotalPeserta >= $lastMonthPeserta ? 'success' : 'danger';

        // Status pendaftaran
        $countPendaftaranTerverifikasi = Pelatihan3Pendaftaran::where('status_verifikasi', 'diterima')->count();
        $countPendaftaranMenunggu = Pelatihan3Pendaftaran::whereIn('status_verifikasi', ['tersimpan', 'tercetak', 'terkirim'])->count();
        $countPendaftaranDitolak = Pelatihan3Pendaftaran::where('status_verifikasi', 'ditolak')->count();
        $countTotalPendaftaran = $countPendaftaranTerverifikasi + $countPendaftaranMenunggu + $countPendaftaranDitolak;
        $pendaftaranProgress = $countTotalPendaftaran > 0 ?
            round(($countPendaftaranTerverifikasi / $countTotalPendaftaran) * 100) : 0;

        // Data chart default (bulanan)
        $chartData = $this->getMonthlyChartData();

        // Distribusi jenis pelatihan
        $jenisPelatihanData = $this->getJenisPelatihanDistribution();

        // Aktivitas terbaru
        $recentActivities = $this->getRecentActivities();

        // Pelatihan mendatang
        $upcomingTrainings = Pelatihan2Tersedia::withCount(['pendaftaran as peserta_count' => function ($query) {
            $query->where('status_verifikasi', 'diterima');
        }])
            ->with('jenispelatihan')
            ->where('tanggal_mulai', '>=', now())
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'nama_pelatihan' => $item->nama_pelatihan,
                    'jenis_pelatihan' => $item->jenispelatihan->jenis_pelatihan ?? '-',
                    'peserta_count' => $item->peserta_count,
                    'tanggal_mulai' => Carbon::parse($item->tanggal_mulai)->format('d M Y'),
                    'tempat_pelatihan' => $item->tempat_pelatihan
                ];
            });

        // Tenggat waktu mendatang
        $upcomingDeadlines = PelatihanTenggatUpload::with(['tersedia', 'pendaftaran'])
            ->where('tanggal_deadline', '>=', now())
            ->orderBy('tanggal_deadline', 'asc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                $jenis = $item->jenis_deadline == 'laporan_user' ? 'Laporan Peserta' : 'Dokumen Admin';
                $pelatihan = $item->tersedia ? $item->tersedia->nama_pelatihan : ($item->pendaftaran ? $item->pendaftaran->kode_pendaftaran : 'Tidak Diketahui');

                $color = $item->tanggal_deadline <= now()->addDays(3) ? 'danger' : 'warning';
                $icon = $item->tanggal_deadline <= now()->addDays(3) ? 'exclamation-triangle' : 'clock';

                return [
                    'judul' => 'Tenggat ' . $jenis,
                    'jenis' => $jenis,
                    'pelatihan' => $pelatihan,
                    'tanggal_deadline' => Carbon::parse($item->tanggal_deadline)->format('d M Y'),
                    'sisa_waktu' => Carbon::now()->diffForHumans($item->tanggal_deadline, ['syntax' => Carbon::DIFF_RELATIVE_TO_NOW]),
                    'color' => $color,
                    'icon' => $icon
                ];
            });

        return view('dashboard.pelatihan.dashboard', compact(
            'countPelatihanTersedia',
            'percentagePelatihanTersedia',
            'pelatihanTrendDirection',
            'pelatihanTrendColor',
            'countUsulanPelatihan',
            'percentageUsulanPelatihan',
            'usulanTrendDirection',
            'usulanTrendColor',
            'countTotalPeserta',
            'percentagePeserta',
            'pesertaTrendDirection',
            'pesertaTrendColor',
            'countPelatihanBerjalan',
            'countPendaftaranTerverifikasi',
            'countPendaftaranMenunggu',
            'countPendaftaranDitolak',
            'countTotalPendaftaran',
            'pendaftaranProgress',
            'chartData',
            'jenisPelatihanData',
            'recentActivities',
            'upcomingTrainings',
            'upcomingDeadlines'
        ));
    }

    public function getChartData()
    {
        $type = request('type', 'monthly');
        $year = request('year', date('Y'));

        if ($type === 'monthly') {
            $data = $this->getMonthlyChartData($year);
        } else {
            $data = $this->getCategoryChartData($type, $year);
        }

        // Tambahkan data distribusi jenis pelatihan
        $data['jenis_pelatihan'] = $this->getJenisPelatihanDistribution();

        return response()->json([
            'series' => $data['series'],
            'categories' => $data['categories'],
            'jenis_pelatihan' => $data['jenis_pelatihan']
        ]);
    }

    private function getMonthlyChartData($year = null)
    {
        $year = $year ?? date('Y');
        $months = [];
        $pelatihanTersedia = [];
        $pendaftar = [];
        $usulan = [];

        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::create($year, $i + 1, 1);
            $months[] = $month->format('M');

            $pelatihanTersedia[] = Pelatihan2Tersedia::whereYear('created_at', $year)
                ->whereMonth('created_at', $i + 1)
                ->count();

            $pendaftar[] = Pelatihan3Pendaftaran::whereYear('created_at', $year)
                ->whereMonth('created_at', $i + 1)
                ->count();

            $usulan[] = Pelatihan2Usulan::whereYear('created_at', $year)
                ->whereMonth('created_at', $i + 1)
                ->count();
        }

        return [
            'months' => $months,
            'series' => [
                ['name' => 'Pelatihan Tersedia', 'data' => $pelatihanTersedia],
                ['name' => 'Pendaftar', 'data' => $pendaftar],
                ['name' => 'Usulan', 'data' => $usulan]
            ],
            'categories' => $months
        ];
    }

    private function getCategoryChartData($type, $year = null)
    {
        $year = $year ?? date('Y');
        $model = null;
        $relation = null;
        $labelField = '';

        switch ($type) {
            case 'jenispelatihan':
                $model = new ref_jenispelatihans();
                $labelField = 'jenis_pelatihan';
                break;
            case 'metodepelatihan':
                $model = new ref_metodepelatihans();
                $labelField = 'metode_pelatihan';
                break;
            case 'pelaksanaanpelatihan':
                $model = new ref_pelaksanaanpelatihans();
                $labelField = 'pelaksanaan_pelatihan';
                break;
        }

        $categories = [];
        $data = [];

        $items = $model->get();

        foreach ($items as $item) {
            $categories[] = $item->{$labelField};

            $count = Pelatihan2Tersedia::whereYear('created_at', $year)
                ->whereHas($type, function ($q) use ($item) {
                    $q->where('id', $item->id);
                })
                ->count();

            $data[] = $count;
        }

        return [
            'categories' => $categories,
            'series' => [
                ['name' => 'Jumlah', 'data' => $data]
            ]
        ];
    }

    private function getJenisPelatihanDistribution()
    {
        $jenisPelatihans = ref_jenispelatihans::withCount(['tersedia as jumlah_pelatihan'])
            ->orderBy('jumlah_pelatihan', 'desc')
            ->get();

        $labels = [];
        $series = [];

        foreach ($jenisPelatihans as $jenis) {
            $labels[] = $jenis->jenis_pelatihan;
            $series[] = $jenis->jumlah_pelatihan;
        }

        return [
            'labels' => $labels,
            'series' => $series
        ];
    }

    private function getRecentActivities()
    {
        // Anda bisa mengganti ini dengan data aktual dari database
        return [
            [
                'icon' => 'mortarboard',
                'color' => 'primary',
                'title' => 'Pelatihan Baru Ditambahkan',
                'time' => '10 menit yang lalu',
                'description' => 'Pelatihan "Manajemen ASN Modern" telah ditambahkan ke sistem'
            ],
            [
                'icon' => 'file-earmark-text',
                'color' => 'success',
                'title' => 'Usulan Pelatihan Baru',
                'time' => '1 jam yang lalu',
                'description' => 'Usulan pelatihan "Kepemimpinan Digital" diajukan oleh Budi Santoso'
            ],
            [
                'icon' => 'check-circle',
                'color' => 'info',
                'title' => 'Pendaftaran Diverifikasi',
                'time' => '2 jam yang lalu',
                'description' => 'Pendaftaran pelatihan "Public Speaking" oleh Ani Wijaya telah diverifikasi'
            ],
            [
                'icon' => 'people',
                'color' => 'warning',
                'title' => 'Pelatihan Dimulai',
                'time' => '1 hari yang lalu',
                'description' => 'Pelatihan "Manajemen Waktu" telah dimulai dengan 25 peserta'
            ]
        ];
    }
}
