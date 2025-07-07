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
            <h4 class="fw-bold mb-2">Galeri Website</h4>
            <p class="mb-0 opacity-75">Data Galeri pada landing page website AKPK.</p>
        </div>
    </div>

        <!-- Konten utama -->
        <div class="container mt-4">
            <!-- Filter dan Aksi -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control border-start-0" placeholder="Search">
                </div>
                <div class="d-flex gap-2 mt-2 mt-md-0">
                    <button class="btn btn-outline-secondary">
                        <i class="bi bi-upload me-1"></i> Import
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalTambahGaleri">
                        <i class="bi bi-plus-lg me-2"></i>Tambah
                    </button>
                </div>
            </div>
    
            <!-- Tabel Galeri -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Unggah</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Jenis File</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = [
                                ['10 Maret 2025', 'Profil Instansi', 'Gambar', 'PNG', 'Pengenalan instansi dan visi misi.'],
                                ['10 Maret 2025', 'Tutorial Pengisian AKPK', 'Tutorial', 'PDF', 'Panduan langkah-langkah pengisian self-assessment AKPK.'],
                                ['10 Maret 2025', 'Pelatihan ASN 2025', 'Banner', 'JPG', 'Dokumentasi kegiatan pelatihan ASN tahun 2024.'],
                                ['10 Maret 2025', 'Webinar Transformasi Digital', 'Banner', 'SVG', 'Rekaman webinar tentang transformasi digital di instansi.'],
                                ['10 Maret 2025', 'Upacara Hari Jadi ASN', 'Tutorial', 'PDF', 'Dokumentasi upacara peringatan hari jadi ASN.'],
                                ['10 Maret 2025', 'Pembentukan AKPK', 'Gambar', 'JPEG', 'Informasi mengenai latar belakang pembentukan AKPK.'],
                                ['10 Maret 2025', 'Sosialisasi Kebijakan Baru', 'Gambar', 'JPG', 'Dokumentasi acara sosialisasi kebijakan baru untuk ASN.'],
                            ];
                        @endphp
                        @foreach ($data as $index => $item)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $item[0] }}</td>
                                <td>{{ $item[1] }}</td>
                                <td class="text-center">{{ $item[2] }}</td>
                                <td class="text-center">{{ $item[3] }}</td>
                                <td>{{ $item[4] }}</td>
                                <td class="d-flex align-items-center justify-content-center" style="position: sticky; right: 0; z-index: 1; background-color: white;">
                                    <button class="btn btn-sm btn-outline-primary me-1" title="Lihat" data-bs-toggle="modal" data-bs-target="#modalLihatGaleri"><i class="bi bi-eye-fill"></i></button>
                                    <button class="btn btn-sm btn-outline-danger me-1" title="Hapus"><i class="bi bi-trash-fill"></i></button>
                                    <button class="btn btn-sm btn-outline-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#modalEditGaleri"><i class="bi bi-pencil-fill"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('Admin.Akpk.ManajemenData.Galeri.tambahGaleri')
    @include('Admin.Akpk.ManajemenData.Galeri.editGaleri')
    @include('Admin.Akpk.ManajemenData.Galeri.lihatGaleri')
    @endsection