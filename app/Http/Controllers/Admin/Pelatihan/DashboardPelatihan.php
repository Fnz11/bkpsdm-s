<?php

namespace App\Http\Controllers\Admin\Pelatihan;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan2Tersedia;
use App\Models\Pelatihan2Usulan;
use App\Models\Pelatihan3Pendaftaran;
use Carbon\Carbon;

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

        $lastMonthUsulan = Pelatihan2Usulan::whereMonth('created_at', now()->subMonth()->month)->count();
        $percentageUsulanPelatihan = $lastMonthUsulan > 0 ?
            round(($countUsulanPelatihan - $lastMonthUsulan) / $lastMonthUsulan * 100, 1) : 100;
        $usulanTrendDirection = $countUsulanPelatihan >= $lastMonthUsulan ? 'up' : 'down';
        $usulanTrendColor = $countUsulanPelatihan >= $lastMonthUsulan ? 'success' : 'danger';

        // Status pendaftaran
        $countPendaftaranTerverifikasi = Pelatihan3Pendaftaran::where('status_verifikasi', 'terverifikasi')->count();
        $countPendaftaranMenunggu = Pelatihan3Pendaftaran::where('status_verifikasi', 'menunggu')->count();
        $countPendaftaranDitolak = Pelatihan3Pendaftaran::where('status_verifikasi', 'ditolak')->count();
        $countTotalPendaftaran = $countPendaftaranTerverifikasi + $countPendaftaranMenunggu + $countPendaftaranDitolak;
        $pendaftaranProgress = $countTotalPendaftaran > 0 ?
            round(($countPendaftaranTerverifikasi / $countTotalPendaftaran) * 100) : 0;

        // Data chart
        $chartData = [
            'months' => [],
            'pelatihan_tersedia' => [],
            'pendaftar' => [],
            'usulan' => []
        ];

        for ($i = 0; $i < 12; $i++) {
            $month = now()->subMonths(11 - $i);
            $chartData['months'][] = $month->format('M');

            $chartData['pelatihan_tersedia'][] = Pelatihan2Tersedia::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $chartData['pendaftar'][] = Pelatihan3Pendaftaran::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $chartData['usulan'][] = Pelatihan2Usulan::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // Aktivitas terbaru
        $recentActivities = [
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

        // Pelatihan mendatang
        $upcomingTrainings = Pelatihan2Tersedia::withCount(['pendaftaran as peserta_count' => function ($query) {
            $query->where('status_verifikasi', 'terverifikasi');
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

        return view('dashboard.pelatihan.dashboard', compact(
            'countPelatihanTersedia',
            'percentagePelatihanTersedia',
            'countUsulanPelatihan',
            'percentageUsulanPelatihan',
            'usulanTrendDirection',
            'usulanTrendColor',
            'countTotalPeserta',
            'countPelatihanBerjalan',
            'countPendaftaranTerverifikasi',
            'countPendaftaranMenunggu',
            'countPendaftaranDitolak',
            'countTotalPendaftaran',
            'pendaftaranProgress',
            'chartData',
            'recentActivities',
            'upcomingTrainings'
        ));
    }
}
