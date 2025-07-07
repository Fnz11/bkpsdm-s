@extends('layouts.app')
@section('head')
@endsection
@section('content')
<div class="">
    <!-- Header dengan background biru -->
    <div class="bg-primary text-white p-4 position-relative overflow-hidden bg-primary-section">
        <!-- Elemen dekoratif (seperti roket) di pojok kanan -->
        <div class="position-absolute end-0 top-0 opacity-25">
            <img src="{{ asset('images/roketDashboard.png') }}" alt="Illustration" height="150">
        </div>
        <!-- Background pattern dots -->
        <div class="position-absolute w-100 h-100 top-0 start-0" style="background-image: radial-gradient(rgba(255,255,255,0.2) 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="container position-relative">
            <h4 class="fw-bold mb-2">Data Komentar</h4>
            <p class="mb-0 opacity-75">Data Komentar otomatis berdasarkan hasil perhitungan GAP Kompetensi dari ASN Kota Surakarta.</p>
        </div>
    </div>
        <!-- Konten utama -->
        <div class="row mb-3 align-items-center">
            <div class="col-md-2 mt-2">
                <select class="form-select" id="rumpun" style="box-shadow: 0 0 10px rgba(0, 0, 0, 25%);">
                    <option selected disabled>Pilih Kategori</option>
                    <option value="Eselon II">Eselon II</option>
                    <option value="Eselon III">Eselon III</option>
                    <option value="Eselon IV">Eselon IV</option>
                    <option value="Pratama">Pratama</option>
                </select>
            </div>
            <div class="col-md-4 mt-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari..." id="searchInput">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </div>
                <div class="col-md-6 text-end mt-2">
                    <button type="button" class="btn me-2" style="box-shadow: 0 0 10px rgba(0, 0, 0, 25%);">
                        <i class="bi bi-cloud-download me-2"></i>Import
                    </button>
                    <button type="button" class="btn btn-outline-success me-2">
                        <i class="fas fa-file-excel me-2"></i>Excel
                    </button>
                    <button type="button" class="btn btn-outline-danger me-2" onclick="cetakPDF()">
                        <i class="fas fa-file-pdf me-2"></i>Cetak PDF
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalTambahKomentar">
                        <i class="bi bi-plus-lg me-2"></i>Tambah
                    </button>
                </div>
            </div>
    
            <!-- Tabel Komentar -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Kompetensi</th>
                            <th>Skor Self-Assessment</th>
                            <th>Skor Wawancara Atasan</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = [
                                ['Eselon II', 'Integritas', 5, 5, 'ASN menunjukkan komitmen yang kuat terhadap nilai dan etika organisasi.'],
                                ['Eselon II', 'Kerjasama', 5, 4, 'ASN perlu meningkatkan kolaborasi antar tim lintas unit.'],
                                ['Eselon II', 'Komunikasi', 5, 3, 'ASN memiliki kemampuan komunikasi yang baik, namun perlu memperbaiki keterampilan komunikasi tertulis.'],
                                ['Eselon II', 'Orientasi pada Hasil', 5, 2, 'ASN sangat fokus pada pencapaian target dan hasil kerja.'],
                                ['Eselon II', 'Pelayanan Publik', 5, 1, 'ASN memiliki komitmen tinggi terhadap pelayanan publik, namun perlu meningkatkan kecepatan respon terhadap pengaduan.'],
                                ['Eselon II', 'Pengembangan Diri dan Orang Lain', 4, 4, 'ASN perlu lebih aktif dalam mengikuti pelatihan dan mengembangkan tim di bawahnya.'],
                                ['Eselon II', 'Mengelola Perubahan', 4, 4, 'ASN mulai beradaptasi dengan perubahan, tetapi masih memerlukan peningkatan dalam mengelola resistensi terhadap perubahan.'],
                            ];
                        @endphp
                        @foreach ($data as $index => $row)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $row[0] }}</td>
                                <td>{{ $row[1] }}</td>
                                <td class="text-center text-nowrap">{{ $row[2] }}</td>
                                <td class="text-center text-nowrap">{{ $row[3] }}</td>
                                <td>{{ $row[4] }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-sm btn-outline-primary" title="Lihat" data-bs-toggle="modal" data-bs-target="#modalLihatKomentar"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                                        <button class="btn btn-sm btn-outline-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEditKomentar"><i class="bi bi-pencil-fill"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('Admin.Akpk.ManajemenData.Komentar.tambahKomentar')
    @include('Admin.Akpk.ManajemenData.Komentar.editKomentar')
    @include('Admin.Akpk.ManajemenData.Komentar.lihatKomentar')
    @endsection