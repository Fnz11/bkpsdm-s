<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DatabaseEkatalog\PelatihanController;
use App\Http\Controllers\Admin\Brosur\BrosurAdminController;
use App\Http\Controllers\Admin\DatabaseEkatalog\EkatalogController;
use App\Http\Controllers\Admin\Akpk\AkpkAdminController;

use App\Http\Controllers\ExportUsulanController;

use App\Http\Controllers\Admin\Laporan\LaporanController;
use App\Http\Controllers\ImportUsulanController;
use App\Http\Controllers\ExportEkatalogController;
use App\Http\Controllers\ImportArsipController;
use App\Http\Controllers\ImportPelatihanController;
use App\Http\Controllers\ImportDiklatController;
use App\Http\Controllers\Admin\Laporan\RekapController;
use App\Http\Controllers\Umum\EkatalogPelatihan\EkatalogUmumController;
use App\Http\Controllers\Umum\EvaluasiPasca\EvaluasiAlumniController;
use App\Http\Controllers\Umum\DirektoriPelatihan\DirektoriUmumController;
use App\Http\Controllers\Umum\UsulanBrosur\BrosurUmumController;
use App\Http\Controllers\Auth\UserEvaluasiController;
use App\Http\Controllers\Admin\Evaluasi\AlumniAdminController;
use App\Http\Controllers\Admin\Evaluasi\AtasanAdminController;
use App\Http\Controllers\Admin\Evaluasi\PertanyaanController;
use App\Http\Controllers\Admin\Pelatihan\AlumniPelatihanController;
use App\Http\Controllers\Admin\Pelatihan\DashboardPelatihan;
use App\Http\Controllers\Admin\Pelatihan\DeepwarePelatihanLaporanController;
use App\Http\Controllers\Admin\Pelatihan\DeepwarePelatihanRegistrasiController;
use App\Http\Controllers\Admin\Pelatihan\DeepwarePelatihanController;
use App\Http\Controllers\Admin\PengaturanDasar\RefNomenklaturController;
use App\Http\Controllers\Admin\PengaturanDasar\RefPegawaiController;
use App\Http\Controllers\Admin\Pelatihan\PelatihanDokumenController;
use App\Http\Controllers\Admin\Pelatihan\PelatihanLaporanController;
use App\Http\Controllers\Admin\Pelatihan\PelatihanUsulanController;
use App\Http\Controllers\Admin\Pelatihan\PelatihanPendaftaranController;
use App\Http\Controllers\Admin\Pelatihan\PelatihanTersediaController;
use App\Http\Controllers\Admin\Pelatihan\RekapitulasiUsulanController;
use App\Http\Controllers\Admin\Pelatihan\UserPivotController;
use App\Http\Controllers\Admin\PengaturanDasar\PelatihanTenggatUploadController;
use App\Http\Controllers\Admin\PengaturanDasar\RefGolonganController;
use App\Http\Controllers\Admin\PengaturanDasar\RefJabatanController;
use App\Http\Controllers\Admin\PengaturanDasar\RefJenisAsnController;
use App\Http\Controllers\Admin\PengaturanDasar\RefJenisPelatihanController;
use App\Http\Controllers\Admin\PengaturanDasar\RefKategoriJabatanController;
use App\Http\Controllers\Admin\PengaturanDasar\RefMetodePelatihanController;
use App\Http\Controllers\Admin\PengaturanDasar\RefPelaksanaanPelatihanController;
use App\Http\Controllers\Admin\PengaturanDasar\RefUnitKerjaController;
use App\Http\Controllers\Admin\PengaturanDasar\RefSubUnitKerjaController;
use App\Http\Controllers\Umum\Akpk\AkpkController;
use App\Http\Controllers\Auth\LoginAkpkController;
use App\Http\Controllers\AkpkPertanyaanDiriController;
use App\Http\Controllers\AkpkPertanyaanAtasanController;
use App\Http\Controllers\AkpkHasilEvaluasiDiriController;
use App\Http\Controllers\AkpkHasilEvaluasiAtasanController;
use App\Http\Controllers\DeepwareKepegawaianController;
use App\Http\Controllers\DeepwarePelatihanInfoController;
use App\Http\Controllers\Umum\Pelatihan\DeepwareAuthController;
use App\Http\Controllers\Umum\Pelatihan\DeepwarePelatihanRegistrasiUserController;
use App\Http\Controllers\Umum\Pelatihan\DeepwarePelatihanUserController;
use App\Http\Controllers\Umum\Pelatihan\PelatihanTersediaUserController;
use App\Http\Controllers\Umum\Pelatihan\PelatihanPendaftaranUserController;
use App\Http\Controllers\Umum\Pelatihan\PelatihanUsulanUserController;
use App\Http\Controllers\Umum\Pelatihan\PelatihanLaporanUserController;

Route::get('/', function () {
    return view('FrontPage.index');
})->name('frontpage.index');

// #################### DEEPWARE - PELATIHAN🌟 ####################

// User
Route::middleware('auth')->group(function () {
    // Profil
    Route::get('/profile', [DeepwareAuthController::class, 'profile'])->name('profile.pelatihan');
    Route::get('/profile/edit', [DeepwareAuthController::class, 'editProfile'])->name('pelatihan.profile.edit');
    Route::put('/profile/update', [DeepwareAuthController::class, 'updateProfile'])->name('pelatihan.profile.update');
    // Route::post('/profile/update', [DeepwareAuthController::class, 'updateProfile'])->name('pelatihan.profile.update');
    // Pendaftaran
    Route::get('/pelatihan/hasil-pendaftaran', [PelatihanPendaftaranUserController::class, 'index'])->name('pelatihan.pendaftaran');
    Route::post('/pelatihan/pelatihan-pendaftaran', [PelatihanPendaftaranUserController::class, 'store'])->name('pelatihan.pendaftaran.store');
    Route::get('/pelatihan/hasil-pendaftaran/detail/{id}', [PelatihanPendaftaranUserController::class, 'show'])->name('pelatihan.pendaftaran.show');
    Route::get('/api/search-pelatihan-register', [DeepwarePelatihanRegistrasiUserController::class, 'search']);

    // Laporan
    Route::get('/pelatihan/laporan', [PelatihanLaporanUserController::class, 'index'])->name('pelatihan.laporan');
    Route::get('/pelatihan/laporan/{id}', [PelatihanLaporanUserController::class, 'show'])->name('pelatihan.laporan-show');
    Route::put('/pelatihan/laporan/{id}/upload', [PelatihanLaporanUserController::class, 'update'])->name('pelatihan.laporan.update');
    Route::get('/pelatihan/tambah-laporan-pelatihan/{pendaftaran}', [PelatihanLaporanUserController::class, 'create'])->name('pelatihan.laporan.create');
    // Usulan Pelatihan
    Route::get('/pelatihan/usulan-pelatihan', [PelatihanUsulanUserController::class, 'indexUsulan'])->name('pelatihan.usulan.index');
    Route::get('/pelatihan/tambah-usulan-pelatihan', [PelatihanUsulanUserController::class, 'createUsulan'])->name('pelatihan.usulan.create');
    Route::post('/pelatihan/tambah-usulan-pelatihan', [PelatihanUsulanUserController::class, 'storeUsulan'])->name('pelatihan.usulan.store');
    Route::delete('/pelatihan/usulan-pelatihan/{id}', [PelatihanUsulanUserController::class, 'destroy'])->name('pelatihan.usulan.destroy');
    Route::get('/pelatihan/usulan-pelatihan/detail/{id}', [PelatihanUsulanUserController::class, 'show'])->name('pelatihan.usulan.show');
    Route::get('/pelatihan/usulan-pelatihan/edit/{id}', [PelatihanUsulanUserController::class, 'editUsulan'])->name('pelatihan.usulan.edit');
    Route::put('/pelatihan/usulan-pelatihan/update/{id}', [PelatihanUsulanUserController::class, 'updateUsulan'])->name('pelatihan.usulan.update');

    // Nomenklatur
    Route::get('/pelatihan/nomenklatur', [PelatihanUsulanUserController::class, 'index'])->name('pelatihan.nomenklatur');
    Route::get('/pelatihan/tambah-nomenklatur', [PelatihanUsulanUserController::class, 'create'])->name('pelatihan.create-nomenklatur');
    Route::post('/pelatihan/tambah-nomenklatur', [PelatihanUsulanUserController::class, 'store'])->name('pelatihan.store-nomenklatur');
});

// Public routes
Route::get('/pelatihan/login', [DeepwareAuthController::class, 'showLoginForm'])->name('login.pelatihan');
Route::post('/pelatihan/login', [DeepwareAuthController::class, 'login'])->name('login.pelatihan.post');
Route::post('/pelatihan/logout', [DeepwareAuthController::class, 'logout'])->name('logout.pelatihan');
Route::get('/pelatihan', [DeepwarePelatihanUserController::class, 'index'])->name('pelatihan.index');
Route::get('/pelatihan/daftar-pelatihan', [PelatihanTersediaUserController::class, 'index'])->name('pelatihan.tersedia');
Route::get('/pelatihan/daftar-pelatihan/{pelatihan}', [PelatihanTersediaUserController::class, 'show'])->name('pelatihan.tersedia.show');
Route::get('/pelatihan/{pelatihan}', [DeepwarePelatihanUserController::class, 'show'])->name('pelatihan.show');
// Route::get('/autocomplete', [DeepwarePelatihanUserController::class, 'autocomplete'])->name('autocomplete');

// Superadmin
Route::middleware(['role:superadmin'])->group(function () {
    Route::prefix('/dashboard/pelatihan')->group(function () {
        // Dashboard utama
        Route::get('/', [DeepwarePelatihanController::class, 'dashboard'])->name('dashboard.pelatihan');
        Route::get('/chart-data', [DashboardPelatihan::class, 'getChartData'])
            ->name('dashboard.pelatihan.chart-data');

        /**
         * ================================
         * User Pivot (History Pegawai)
         * ================================
         */
        Route::prefix('/histroy-pegawai')->name('dashboard.pelatihan.user')->controller(UserPivotController::class)->group(function () {
            Route::get('/', 'index')->name('');
            Route::post('/approve/{id}', 'approve')->name('.approve');
            Route::delete('/reject/{id}', 'reject')->name('.reject');
            Route::post('/store', 'store')->name('.store');
            Route::get('/edit/{id}', 'edit')->name('.edit');
            Route::put('/update/{id}', 'update')->name('.update');
            Route::delete('/delete/{id}', 'destroy')->name('.destroy');

            // Ekspor
            Route::get('/export/excel', 'cetakExcel')->name('.cetak-excel');
            Route::get('/export/pdf', 'cetakPdf')->name('.cetak-pdf');
            Route::get('/preview', 'preview')->name('.preview');
        });

        /**
         * ================================
         * PENGATURAN DASAR
         * ================================
         */
        Route::redirect('/pengaturandasar', 'pengaturandasar/jenis-pelatihan')
            ->name('dashboard.pelatihan.pengaturandasar');

        Route::prefix('/pengaturandasar')->group(function () {
            // Format: [route, controller, name prefix]
            $pengaturanDasar = [
                ['jenis-pelatihan', RefJenisPelatihanController::class, 'jenispelatihan'],
                ['metode-pelatihan', RefMetodePelatihanController::class, 'metodepelatihan'],
                ['pelaksanaan-pelatihan', RefPelaksanaanPelatihanController::class, 'pelaksanaanpelatihan'],
                ['nomenklatur', RefNomenklaturController::class, 'nomenklatur'],
                ['jenis-asn', RefJenisAsnController::class, 'jenisasn'],
                ['golongan', RefGolonganController::class, 'golongan'],
                ['kategori-jabatan', RefKategoriJabatanController::class, 'kategorijabatan'],
                ['jabatan', RefJabatanController::class, 'jabatan'],
                ['unit-kerja', RefUnitKerjaController::class, 'unitkerja'],
                ['sub-unit-kerja', RefSubUnitKerjaController::class, 'subunitkerja'],
                ['penjadwalan',  PelatihanTenggatUploadController::class, 'tenggat'],
            ];

            foreach ($pengaturanDasar as [$uri, $controller, $name]) {
                Route::get("/{$uri}", [$controller, 'index'])->name("dashboard.pelatihan.{$name}");
                Route::get("/{$uri}/tambah", [$controller, 'create'])->name("dashboard.pelatihan.{$name}.create");
                Route::post("/{$uri}/tambah", [$controller, 'store'])->name("dashboard.pelatihan.{$name}.store");
                Route::get("/{$uri}/edit/{id}", [$controller, 'edit'])->name("dashboard.pelatihan.{$name}.edit");
                Route::put("/{$uri}/update/{id}", [$controller, 'update'])->name("dashboard.pelatihan.{$name}.update");
                Route::delete("/{$uri}/delete/{id}", [$controller, 'destroy'])->name("dashboard.pelatihan.{$name}.destroy");
            }

            // Tambahan khusus Pegawai
            Route::get('/pegawai', [RefPegawaiController::class, 'index'])->name('dashboard.pelatihan.pegawai');
            Route::get('/pegawai/detail/{id}', [RefPegawaiController::class, 'show'])->name('dashboard.pelatihan.pegawai.show');
            Route::get('/pegawai/create', [RefPegawaiController::class, 'create'])->name('dashboard.pelatihan.pegawai.create');
            Route::post('/pegawai/store', [RefPegawaiController::class, 'store'])->name('dashboard.pelatihan.pegawai.store');
            Route::get('/pegawai/edit/{id}', [RefPegawaiController::class, 'edit'])->name('dashboard.pelatihan.pegawai.edit');
            Route::put('/pegawai/update/{id}', [RefPegawaiController::class, 'update'])->name('dashboard.pelatihan.pegawai.update');
            Route::delete('/pegawai/delete/{id}', [RefPegawaiController::class, 'destroy'])->name('dashboard.pelatihan.pegawai.destroy');
        });

        /**
         * ================================
         * INFO PELATIHAN
         * ================================
         */
        Route::prefix('/info')->name('dashboard.pelatihan.info')->controller(DeepwarePelatihanInfoController::class)->group(function () {
            Route::get('/', 'index')->name(''); // dashboard.pelatihan.info
            Route::get('/create', 'create')->name('.create');
            Route::post('/store', 'store')->name('.store');
            Route::get('/edit/{id}', 'edit')->name('.edit');
            Route::put('/update/{id}', 'update')->name('.update');
            Route::delete('/delete/{id}', 'destroy')->name('.destroy');
        });

        /**
         * ================================
         * PELATIHAN TERSEDIA
         * ================================
         */
        Route::prefix('/tersedia')->name('dashboard.pelatihan.tersedia')->controller(PelatihanTersediaController::class)->group(function () {
            Route::get('/', 'index')->name('');
            Route::get('/detail/{id}', 'show')->name('.show');
            Route::get('/tambah', 'create')->name('.create');
            Route::post('/tambah', 'store')->name('.store');
            Route::get('/edit/{id}', 'edit')->name('.edit');
            Route::put('/update/{id}', 'update')->name('.update');
            Route::post('/update-status', 'updateStatus')->name('.updateStatus');
            Route::delete('/delete/{id}', 'destroy')->name('.destroy');

            // Ekspor
            Route::get('/export/excel', 'exportExcel')->name('.cetak-excel');
            Route::get('/export/pdf', 'exportPdf')->name('.cetak-pdf');
            Route::get('/preview', 'preview')->name('.preview');
        });

        /**
         * ================================
         * USULAN PELATIHAN
         * ================================
         */
        Route::prefix('/usulan')->name('dashboard.pelatihan.usulan')->controller(PelatihanUsulanController::class)->group(function () {
            // Route::get('/', 'index')->name('');
            // Route::get('/detail/{id}', 'show')->name('.show');
            // Route::get('/tambah', 'create')->name('.create');
            // Route::post('/tambah', 'store')->name('.store');
            Route::get('/edit/{id}', 'edit')->name('.edit');
            Route::put('/update/{id}', 'update')->name('.update');
            Route::delete('/delete/{id}', 'destroy')->name('.destroy');

            // Ekspor
            Route::get('/export/excel', 'exportExcel')->name('.cetak-excel');
            Route::get('/export/pdf', 'exportPdf')->name('.cetak-pdf');
            Route::get('/preview', 'preview')->name('.preview');
        });

        /**
         * ================================
         * PENDAFTARAN PELATIHAN
         * ================================
         */
        Route::prefix('/pendaftaran')->name('dashboard.pelatihan.pendaftaran')->controller(PelatihanPendaftaranController::class)->group(function () {
            Route::get('/', 'index')->name('');
            Route::get('/detail/{id}', 'show')->name('.show');
            Route::get('/create', 'create')->name('.create');
            Route::post('/store', 'store')->name('.store');
            Route::get('/edit/{id}', 'edit')->name('.edit');
            Route::put('/update/{id}', 'update')->name('.update');
            Route::put('/update-bulk', 'updateBulk')->name('.update-bulk');
            Route::delete('/delete/{id}', 'destroy')->name('.destroy');

            // Ekspor
            Route::get('/export/excel', 'cetakExcel')->name('.cetak-excel');
            Route::get('/export/pdf', 'cetakPdf')->name('.cetak-pdf');
            Route::get('/preview', 'preview')->name('.preview');
        });

        /**
         * ================================
         * ALUMNI PELATIHAN
         * ================================
         */
        Route::prefix('/alumni')->name('dashboard.pelatihan.alumni')->controller(AlumniPelatihanController::class)->group(function () {
            Route::get('/', 'index')->name('');
            Route::get('/detail/{id}', 'show')->name('.show');
            Route::get('/create', 'create')->name('.create');
            Route::post('/store', 'store')->name('.store');
            Route::get('/edit/{id}', 'edit')->name('.edit');
            Route::put('/update/{id}', 'update')->name('.update');
            Route::put('/update-bulk', 'update')->name('.update-bulk');
            Route::delete('/delete/{id}', 'destroy')->name('.destroy');

            // Ekspor
            Route::get('/export/excel', 'cetakExcel')->name('.cetak-excel');
            Route::get('/export/pdf', 'cetakPdf')->name('.cetak-pdf');
            Route::get('/preview', 'preview')->name('.preview');
        });
    });
});

// Admin Superadmin
Route::middleware(['role:admin|superadmin'])->group(function () {
    // Route::get('/pelatihan', [DeepwarePelatihanController::class, 'index'])->name('pelatihan.index');
    Route::prefix('/dashboard/pelatihan')->group(function () {
        Route::get('/', [DashboardPelatihan::class, 'index'])->name('dashboard.pelatihan');

        /**
         * ================================
         * PENDAFTARAN PELATIHAN
         * ================================
         */
        Route::prefix('/pendaftaran')->name('dashboard.pelatihan.pendaftaran')->controller(PelatihanPendaftaranController::class)->group(function () {
            Route::get('/cetak-usulan', 'cetakPdfPage')->name('.cetak-usulan');
            Route::get('/cetak-pdf-admin', 'cetakPdfAdmin')->name('.cetak-pdf-admin');
            Route::get('/preview-admin', 'previewAdmin')->name('.preview-admin');
        });

        /**
         * ================================
         * USULAN PELATIHAN
         * ================================
         */
        Route::prefix('/usulan')->name('dashboard.pelatihan.usulan')->controller(PelatihanUsulanController::class)->group(function () {
            Route::get('/', 'index')->name('');
            Route::get('/detail/{id}', 'show')->name('.show');
            Route::get('/tambah', 'create')->name('.create');
            Route::post('/tambah', 'store')->name('.store');
        });

        /**
         * ================================
         * NAMA PELATIHAN
         * ================================
         */
        Route::prefix('/nomenklatur')->name('dashboard.pelatihan.nomenklaturadmin')->controller(RefNomenklaturController::class)->group(function () {
            Route::get('/', 'indexAdmin')->name('');
            Route::get('/tambah', 'create')->name('.create');
            Route::post('/tambah', 'storeAdmin')->name('.store');
        });

        // Tambahan khusus
        Route::get('/get-pegawai-by-nip', [PelatihanUsulanController::class, 'getPegawaiByNip'])->name('get.pegawai.by.nip');

        // Dokumen Pendaftaran
        Route::get('/dokumen', [PelatihanDokumenController::class, 'index'])->name('dashboard.pelatihan.dokumen');
        Route::get('/dokumen/detail/{id}', [PelatihanDokumenController::class, 'show'])->name('dashboard.pelatihan.dokumen.show');
        Route::get('/dokumen/create', [PelatihanDokumenController::class, 'create'])->name('dashboard.pelatihan.dokumen.create');
        Route::post('/dokumen/store', [PelatihanDokumenController::class, 'store'])->name('dashboard.pelatihan.dokumen.store');
        Route::get('/dokumen/edit/{id}', [PelatihanDokumenController::class, 'edit'])->name('dashboard.pelatihan.dokumen.edit');
        Route::put('/dokumen/update/{id}', [PelatihanDokumenController::class, 'update'])->name('dashboard.pelatihan.dokumen.update');

        Route::prefix('/rekapitulasi-usulan')->name('dashboard.pelatihan.rekapitulasi')->controller(RekapitulasiUsulanController::class)->group(function () {
            Route::get('/', 'index')->name('');
            Route::get('/detail/{id}', 'show')->name('.show');
            Route::get('/tambah', 'create')->name('.create');
            Route::post('/tambah', 'store')->name('.store');
            Route::get('/edit/{id}', 'edit')->name('.edit');
            Route::put('/update/{id}', 'update')->name('.update');
            Route::delete('/delete/{id}', 'destroy')->name('.destroy');

            // Ekspor
            Route::get('/export/excel', 'cetakExcel')->name('.cetak-excel');
            Route::get('/export/pdf', 'cetakPdf')->name('.cetak-pdf');
            Route::get('/preview', 'preview')->name('.preview');
        });

        // Laporan Pelatihan
        Route::prefix('/laporan')->name('dashboard.pelatihan.laporan')->controller(PelatihanLaporanController::class)->group(function () {
            Route::get('/', 'index')->name('');
            Route::get('/detail/{id}', 'show')->name('.show');
            Route::get('/tambah', 'create')->name('.create');
            Route::post('/tambah', 'store')->name('.store');
            Route::get('/edit/{id}', 'edit')->name('.edit');
            Route::put('/update/{id}', 'update')->name('.update');
            Route::put('/update-bulk', 'updateBulk')->name('.update-bulk');
            Route::delete('/delete/{id}', 'destroy')->name('.destroy');

            // Ekspor
            Route::get('/export/excel', 'cetakExcel')->name('.cetak-excel');
            Route::get('/export/pdf', 'cetakPdf')->name('.cetak-pdf');
            Route::get('/preview', 'preview')->name('.preview');
        });

        Route::get('/daftar-pelatihan', [DeepwarePelatihanController::class, 'index'])->name('dashboard.pelatihan.index');
        Route::get('/referensi', [DeepwarePelatihanController::class, 'referensi'])->name('dashboard.pelatihan.referensi');
        Route::get('/edit-pelatihan/{id}', [DeepwarePelatihanController::class, 'edit'])->name('dashboard.pelatihan.edit');
        Route::get('/tambah-pelatihan', [DeepwarePelatihanController::class, 'create'])->name('dashboard.pelatihan.create');
        Route::post('/tambah-pelatihan', [DeepwarePelatihanController::class, 'store'])->name('dashboard.pelatihan.store');
        Route::put('/update-pelatihan/{id}', [DeepwarePelatihanController::class, 'update'])->name('dashboard.pelatihan.update');
        Route::delete('/delete-pelatihan/{id}', [DeepwarePelatihanController::class, 'destroy'])->name('dashboard.pelatihan.destroy');
    });
});
// #################### DEEPWARE - PELATIHAN🌟 ####################

//Route untuk halaman publik
// Route::get('/', function () {
//     return view('FrontPage.index');
// })->name('frontpage.index');

Route::middleware('auth')->group(function () {
    Route::get('/selfAssessment', [AkpkPertanyaanDiriController::class, 'index']);
    Route::post('/self-assessment/simpan', [AkpkPertanyaanDiriController::class, 'store'])->name('self-assessment.simpan');

    Route::get('/assessmentBawahan', function () {
        return view('MenuUmum.Akpk.Assessment.assessmentBawahan');
    });

    Route::get('/assessmentBawahan', [AkpkPertanyaanAtasanController::class, 'index'])->name('assessment.bawahan');

    Route::post('/assessment-atasan', [AkpkPertanyaanAtasanController::class, 'store'])->name('assessment-atasan.simpan');

    Route::get('/hasilSelfAssessment',  [AkpkHasilEvaluasiDiriController::class, 'index'])->name('hasilSelfAssessment');

    Route::get('/hasilAssessmentBawahan', [AkpkHasilEvaluasiAtasanController::class, 'index'])->name('hasilAssessmentBawahan');

    Route::get('/usulan', function () {
        return view('MenuUmum.Akpk.UsulanPelatihan.Usulan.usulPelatihan');
    });

    Route::get('/hasilUsulan', function () {
        return view('MenuUmum.Akpk.UsulanPelatihan.Usulan.hasilUsulan');
    });

    Route::get('/solowasis', function () {
        return view('MenuUmum.Akpk.UsulanPelatihan.Solowasis.solowasis');
    });

    Route::get('/hasilSolowasis', function () {
        return view('MenuUmum.Akpk.UsulanPelatihan.Solowasis.hasilSolowasis');
    });

    Route::get('/dashboardSuperAdminAKpk', function () {
        return view('SuperAdmin.Akpk.dashboardSuperAdminAkpk');
    })->name('superadmin.akpk.dashboard');

    Route::post('/usulan/store', [AkpkController::class, 'storeUsulan'])->name('usulan.store');
    Route::put('/usulan/update/{id}', [AkpkController::class, 'updateUsulan'])->name('usulan.update');

    Route::get('/nomenklatur', function () {
        return view('MenuUmum.Akpk.UsulanPelatihan.Nomenklatur.nomenklatur');
    });

    Route::get('/profilAKPK', function () {
        return view('MenuUmum.Akpk.profil');
    });
});

//route untuk menu umum usulan brosur
Route::get('/BrosurPelatihan', [BrosurUmumController::class, 'index'])->name('BrosurPelatihan.usulan');
Route::get('BrosurPelatihan/create', [BrosurUmumController::class, 'create'])->name('BrosurPelatihan.createusulan');
Route::post('BrosurPelatihan/store', [BrosurUmumController::class, 'store'])->name('BrosurPelatihan.storeusulan');

//route untuk menu umum e-katalog pelatihan
Route::get('/EkatalogPelatihan', [EkatalogUmumController::class, 'index'])->name('EkatalogPelatihan.ekatalog');
Route::get('/EkatalogPelatihan/view/{id}', [EkatalogUmumController::class, 'view'])->name('EkatalogPelatihan.viewekatalog');

//route untuk menu umum direktori laporan
Route::get('/DirektoriPelatihan', [DirektoriUmumController::class, 'index'])->name('DirektoriPelatihan.direktori');
Route::get('DirektoriPelatihan/create', [DirektoriUmumController::class, 'create'])->name('DirektoriPelatihan.createdirektori');
Route::post('DirektoriPelatihan/store', [DirektoriUmumController::class, 'store'])->name('DirektoriPelatihan.storedirektori');
Route::get('/DirektoriPelatihan/view/{id}', [DirektoriUmumController::class, 'view'])->name('DirektoriPelatihan.viewdirektori');


// Route untuk login admin
Route::get('admin0', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('admin0', [LoginController::class, 'logins']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


//Route Untuk AKPK
Route::get('/dashboard-akpk', [AkpkController::class, 'index'])->name('akpk.index');



//Route Untuk AKPK
Route::get('/homepage-akpk', [AkpkController::class, 'index'])->name('akpk.index');

// Login untuk AKPK
Route::get('/login-akpk', [LoginAkpkController::class, 'showLoginForm'])->name('login.akpk');
Route::post('/login-akpk', [LoginAkpkController::class, 'login'])->name('login.akpk.post');
Route::post('/logout-akpk', [LoginAkpkController::class, 'logout'])->name('logout.akpk');

Route::middleware(['role:admin|superadmin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Route untuk halaman usulan brosur

    Route::get('/brosur/usulan', [BrosurAdminController::class, 'index'])->name('Admin.Brosur.usulan');
    Route::get('/brosur/arsip', [BrosurAdminController::class, 'index'])->name('Admin.Brosur.arsip');
    Route::put('/brosur/approve/{id}', [BrosurAdminController::class, 'approve'])->name('brosur.approve');
    Route::get('/brosur/editusulan/{brosur}', [BrosurAdminController::class, 'edit'])->name('Admin.Brosur.editusulan');
    Route::put('/brosur/updateusulan/{brosur}', [BrosurAdminController::class, 'update'])->name('Admin.Brosur.updateusulan');
    Route::delete('/brosur/deleteusulan/{id}', [BrosurAdminController::class, 'deletes'])->name('brosur.deleteusulan');
    Route::get('/brosur/create', [BrosurAdminController::class, 'create'])->name('Admin.Brosur.create');
    Route::post('/brosur/store', [BrosurAdminController::class, 'storebrosur'])->name('brosur.store');
    Route::get('/brosur/edit/{id}', [BrosurAdminController::class, 'edit'])->name('Admin.Brosur.edit');
    Route::put('/brosur/update/{id}', [BrosurAdminController::class, 'update'])->name('brosur.update');



    Route::get('/exportusulan-excel', [ExportUsulanController::class, 'exportusulan'])->name('exportusulan.excel');
    Route::post('/import-usulan', [ImportUsulanController::class, 'importUsulanDiklat'])->name('import.usulan');
    Route::post('/import-arsip', [ImportArsipController::class, 'importArsip'])->name('import.arsip');



    // Route untuk nama ekatalog databse
    Route::get('/ekatalog/database', [PelatihanController::class, 'index'])->name('Admin.ekatalog.database');
    Route::post('/store/{type}', [PelatihanController::class, 'store'])->name('pelatihan.store');
    Route::delete('/deletedatas/{model}/{id}', [PelatihanController::class, 'delete'])->name('deletedata');


    Route::patch('/pelatihan/{id}', [PelatihanController::class, 'update'])->name('pelatihan.update');



    // // route untuk ekatalog diklat
    Route::get('/ekatalog/createpelatihan', [PelatihanController::class, 'create'])->name('ekatalog.createpelatihan');
    Route::post('/ekatalog/storepelatihan', [PelatihanController::class, 'storepelatihan'])->name('ekatalog.storepelatihan');
    Route::post('/import-pelatihan', [ImportPelatihanController::class, 'importPelatihan'])->name('import.pelatihan');
    Route::put('/toggle-status/{id_katalog2}', [EkatalogController::class, 'toggleStatus'])->name('toggle.status');


    // // Route untuk halaman ekatalog diklat
    Route::get('/ekatalog/diklat', [EkatalogController::class, 'index'])->name('admin.ekatalog.diklat');
    Route::get('/ekatalog/creatediklat', [EkatalogController::class, 'create'])->name('admin.ekatalog.creatediklat');
    Route::post('/ekatalog/storediklat', [EkatalogController::class, 'store'])->name('admin.ekatalog.storediklat');
    Route::get('/ekatalog/viewdiklat/{id}', [EkatalogController::class, 'view'])->name('admin.ekatalog.viewdiklat');

    Route::get('/ekatalog/deleteekatalog/{id}', [EkatalogController::class, 'destroy'])->name('deleteekatalog');
    Route::get('/exportekatalog-excel', [ExportEkatalogController::class, 'exportekatalog'])->name('exportekatalog.excel');
    Route::post('/import-diklat', [ImportDiklatController::class, 'importDiklat'])->name('import.diklat');

    // // Route untuk halaman laporan
    Route::get('/laporan/usulan', [LaporanController::class, 'index'])->name('laporan.usulan');
    Route::get('/laporan/arsip', [LaporanController::class, 'index'])->name('laporan.arsip');
    Route::get('/laporan/createusulan', [LaporanController::class, 'create'])->name('laporan.createusulan');
    Route::post('/laporan/storediklat', [LaporanController::class, 'store'])->name('laporan.storeusulan');
    Route::put('/laporan/editarsip/{id}', [LaporanController::class, 'update'])->name('laporan.updateusulan');
    Route::get('/laporan/editarsip/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.editlaporan');
    Route::delete('/laporan/deleteusulanlaporan/{id}', [LaporanController::class, 'destroy'])->name('deleteusulanlaporan');
    Route::get('/laporan/approve/{id}', [LaporanController::class, 'approve'])->name('approvelaporan');



    // // Route untuk halaman rekap pelatihan
    Route::get('/laporan/rekap', [RekapController::class, 'index'])->name('laporan.rekap');

    //route untuk halaman evaluasi alumni
    Route::get('/evaluasi/alumni', [AlumniAdminController::class, 'index'])->name('evaluasi.alumni');
    Route::get('/evaluasi/viewalumni/{id}', [AlumniAdminController::class, 'view'])->name('evaluasi.viewalumni');
    Route::get('/alumni/edit/{id}', [AlumniAdminController::class, 'edit'])->name('evaluasi.editalumni');
    Route::put('/alumni/{id}', [AlumniAdminController::class, 'update'])->name('evaluasi.updatealumni');
    Route::delete('/evaluasi/destroyalumni/{id}', [AlumniAdminController::class, 'destroy'])->name('evaluasi.destroyalumni');

    Route::get('/evaluasi/atasan', [AtasanAdminController::class, 'index'])->name('evaluasi.atasan');
    Route::get('/evaluasi/viewatasan/{id}', [AtasanAdminController::class, 'view'])->name('evaluasi.viewatasan');
    Route::get('/atasan/edit/{id}', [AtasanAdminController::class, 'edit'])->name('evaluasi.editatasan');
    Route::put('/atasan/{id}', [AtasanAdminController::class, 'update'])->name('evaluasi.updateatasan');
    Route::delete('/evaluasi/destroyatasan/{id}', [AtasanAdminController::class, 'destroy'])->name('evaluasi.destroyatasan');


    Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan.index');
    Route::delete('/pertanyaan/{id}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');
    Route::get('/pertanyaan/create', [PertanyaanController::class, 'create'])->name('pertanyaan.create');
    Route::post('/pertanyaan', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
    Route::get('/pertanyaan/{id}/edit', [PertanyaanController::class, 'edit'])->name('pertanyaan.edit');
    Route::put('/pertanyaan/{id}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');

    // Route untuk submenu Dashboard AKPK
    Route::get('/akpk/dashboard', [AkpkAdminController::class, 'dashboard'])->name('Admin.Akpk.dashboard');

    // Route pelatihan

});

Route::middleware(['role:superadmin'])->group(function () {

    // Route untuk submenu SelfASessment
    Route::get('/akpk/selfassessment', [AkpkAdminController::class, 'tabelSelfAssessment'])->name('Admin.Akpk.selfassessment');
    // Route untuk submenu assessment Atasan
    Route::get('/akpk/asessmentatasan', [AkpkAdminController::class, 'tabelAssessmentAtasan'])->name('Admin.Akpk.asessmentatasan');
    // Route untuk submenu Evaluasi Assessment
    Route::get('/akpk/evaluasiassessment', [AkpkAdminController::class, 'tabelEvaluasiAssessment'])->name('Admin.Akpk.evaluasiassessment');


    // Route untuk submenu usul pelatihan solo wasis
    Route::get('/akpk/usulpelatihansolowasis', [AkpkAdminController::class, 'tabelUsulanPelatihanSolowasis'])->name('Admin.Akpk.Usulan.usulpelatihansolowasis');
    // Route untuk submenu usul kebutuhan pelatihan
    Route::get('/akpk/usulkebutuhanpelatihan', [AkpkAdminController::class, 'tabelUsulanKebutuhanPelatihan'])->name('Admin.Akpk.Usulan.usulkebutuhanpelatihan');


    Route::get('/akpk/pertanyaan', [AkpkAdminController::class, 'manajemenPertanyaanDiri'])->name('Admin.Akpk.ManajemenData.manajemenpertanyaan');
    Route::post('/admin/pertanyaanDiri/store', [AkpkAdminController::class, 'simpanPertanyaanDiri'])->name('adminpertanyaandiri.store');
    Route::post('/admin/pertanyaanDiri/update', [AkpkAdminController::class, 'updatePertanyaanDiri'])->name('adminpertanyaandiri.update');
    Route::post('/admin/pertanyaanDiri/hapus', [AkpkAdminController::class, 'hapusPertanyaanDiri'])->name('adminpertanyaandiri.hapus');
    Route::post('/admin/pertanyaanAtasan/store', [AkpkAdminController::class, 'simpanPertanyaanAtasan'])->name('adminpertanyaanatasan.store');
    Route::post('/admin/pertanyaanAtasan/update', [AkpkAdminController::class, 'updatePertanyaanAtasan'])->name('adminpertanyaanatasan.update');
    Route::post('/admin/pertanyaanAtasan/hapus', [AkpkAdminController::class, 'hapusPertanyaanAtasan'])->name('adminpertanyaanatasan.hapus');
    Route::post('/pertanyaan/toggle-status-diri', [AkpkAdminController::class, 'toggleStatusDiri'])->name('pertanyaan.toggleStatusDiri');
    Route::post('/pertanyaan/toggle-status-atasan', [AkpkAdminController::class, 'toggleStatusAtasan'])->name('pertanyaan.toggleStatusAtasan');
    Route::get('/akpk/pertanyaanAtasan', [AkpkAdminController::class, 'manajemenPertanyaanAtasan'])->name('Admin.Akpk.ManajemenData.Atasan.manajemenpertanyaanAtasan');
    Route::get('/akpk/komentar', [AkpkAdminController::class, 'manajemenKomentar'])->name('Admin.Akpk.ManajemenData.manajemenkomentar');
    Route::get('/akpk/galeri', [AkpkAdminController::class, 'manajemenGaleri'])->name('Admin.Akpk.ManajemenData.manajemenGaleri');
    Route::get('/akpk/solowasis', [AkpkAdminController::class, 'manajemenSolowasis'])->name('Admin.Akpk.ManajemenData.manajemenSolowasis');
});

Route::middleware(['role:admin'])->group(function () {

    Route::get('/akpk/rumpun', [AkpkAdminController::class, 'manajemenRumpun'])->name('Admin.Akpk.ManajemenData.manajemenRumpun');
    Route::get('/akpk/usulanPelatihanAdmin', [AkpkAdminController::class, 'tabelUsulanAdmin'])->name('Admin.Akpk.Usulan.Admin.usulkebutuhanpelatihanAdmin');
    Route::get('/akpk/nomenklatur', [AkpkAdminController::class, 'dataNomenklatur'])->name('Admin.Akpk.Usulan.Admin.dataNomenklatur');
});

use App\Http\Middleware\RoleMiddleware;

Route::get('/EvaluasiPasca', [UserEvaluasiController::class, 'index'])->name('EvaluasiPasca.homepage');
Route::post('/login', [UserEvaluasiController::class, 'login'])->name('auth.login');
Route::post('/logout', [UserEvaluasiController::class, 'logout'])->name('logout');

// Middleware untuk masing-masing role
Route::middleware([RoleMiddleware::class . ':alumni'])->group(function () {
    Route::get('/dashboard/alumni', [UserEvaluasiController::class, 'alumni'])->name('dashboard.alumni');
    Route::get('/evaluasi/pertanyaanalumni', [EvaluasiAlumniController::class, 'index'])->name('evaluasi.formalumni');
    Route::post('/evaluasi/simpan-alumni', [EvaluasiAlumniController::class, 'store'])->name('evaluasi.simpanalumni');

    Route::get('/evaluasi/alumni/pertanyaan', [EvaluasiAlumniController::class, 'showPertanyaan'])->name('evaluasi.pertanyaanalumni');
    Route::post('/evaluasi/alumni/simpan-jawaban', [EvaluasiAlumniController::class, 'simpanJawaban'])->name('evaluasi.simpanjawaban');
});


Route::middleware([RoleMiddleware::class . ':atasan'])->group(function () {
    Route::get('/dashboard/atasan', [UserEvaluasiController::class, 'atasan'])->name('dashboard.atasan');
});

Route::middleware([RoleMiddleware::class . ':rekan'])->group(function () {
    Route::get('/dashboard/rekan', [UserEvaluasiController::class, 'rekan'])->name('dashboard.rekan');
});
