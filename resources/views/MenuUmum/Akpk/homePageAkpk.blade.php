@extends('layouts.akpkLayouts.akpk')
 
 <style>
     #homepageCarousel {
         max-width: 100%;
         height: 400px;
         margin: auto;
     }
 
     #homepageCarousel .carousel-inner img {
         height: 100%;
         object-fit: cover;
         border-radius: 10px;
     }
 
     /* Tentang Kami Responsive Styles */
     @media (max-width: 768px) {
         .tentang-kami-wrapper {
             min-height: 600px !important;
         }
 
         .tentang-kami-image {
             width: 80% !important;
             height: 250px !important;
             left: 50% !important;
             top: 0 !important;
             transform: translateX(-50%) !important;
         }
 
         .tentang-kami-content {
             width: 100% !important;
             height: 400px !important;
             top: 200px !important;
             bottom: auto !important;
         }
 
         .tentang-kami-text {
             max-width: 90% !important;
             margin-left: auto !important;
             margin-right: auto !important;
             text-align: center;
         }
     }
 
     .pdf-viewer-container {
         width: 100%;
         max-width: 100%;
         overflow: hidden;
         display: flex;
         justify-content: center;
     }
 
     .pdf-viewer {
         width: 100%;
         max-width: 100%;
         height: 80vh;
     }
 
     @media (max-width: 768px) {
         .pdf-viewer {
             height: 60vh;
         }
     }
 
     @media (max-width: 480px) {
         .pdf-viewer {
             height: 50vh;
         }
     }
 </style>
 
 @section('content')
     <!-- Carousel Section -->
     <section>
         <div class="container">
             <div id="homepageCarousel" class="carousel slide" data-bs-ride="carousel">
                 <div class="carousel-indicators">
                     @php
                         $images = ['/images/diklat1.jpg', '/images/diklat2.jpg', '/images/diklat3.jpg'];
                     @endphp
                     @foreach ($images as $index => $image)
                         <button type="button" data-bs-target="#homepageCarousel" data-bs-slide-to="{{ $index }}"
                             class="{{ $index === 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}">
                         </button>
                     @endforeach
                 </div>
                 <div class="carousel-inner">
                     @foreach ($images as $index => $image)
                         <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                             <img src="{{ $image }}" class="d-block w-100" alt="Slide {{ $index + 1 }}"
                                 style="object-fit: cover; height: 100%; border-radius: 10px;">
                         </div>
                     @endforeach
                 </div>
                 <button class="carousel-control-prev" type="button" data-bs-target="#homepageCarousel"
                     data-bs-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Previous</span>
                 </button>
                 <button class="carousel-control-next" type="button" data-bs-target="#homepageCarousel"
                     data-bs-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Next</span>
                 </button>
             </div>
         </div>
     </section>
 
     <!-- Tentang Kami Section -->
     <section class="my-5">
         <div class="container">
             <div class="position-relative tentang-kami-wrapper" style="min-height: 400px;">
                 <!-- Kotak biru (background) -->
                 <div class="position-absolute bg-primary text-white rounded-4 p-4 p-lg-5 d-flex flex-column justify-content-center tentang-kami-content"
                     style="width: 85%; height: 350px; right: 0; bottom: 0;">
                     <h2 class="fw-bold mb-4 text-center">Tentang Kami</h2>
                     <p class="mb-0 ms-auto tentang-kami-text" style="max-width: 60%; margin-left: 37% !important;">
                         AKPK adalah sistem yang membantu ASN dalam menilai kompetensi diri dan merencanakan pengembangan karier. Di sini, Anda bisa melakukan self-assessment, menerima penilaian dari atasan, serta mengusulkan pelatihan yang dibutuhkan. Semua proses dilakukan secara digital dan terintegrasi, sehingga lebih mudah, cepat, dan transparan.
                     </p>
                 </div>
 
                 <!-- Gambar (overlay) -->
                 <div class="position-absolute shadow-sm tentang-kami-image"
                     style="width: 40%; max-width: 450px; height: 300px; left: 0; top: 53%; transform: translateY(-45%); z-index: 2;">
                     <img src="/images/TentangKami.png" alt="Tentang Kami" class="w-100 h-100"
                         style="object-fit: cover; border-radius: 10px 60px 30px 10px;">
                 </div>

                 {{-- BG Image --}}
                 <div class="position-absolute" style="height: 350px; right: 0; bottom: 0; z-index: 0; overflow: hidden;">
                    <img src="/images/bgTentangKami.png" alt="Background Image" style="width: 100%; height: 100%; object-fit: cover; object-position: right;">
                 </div>
             </div>
         </div>
     </section>
 
     <!-- Visi & Misi Section -->
     <section class="my-5">
         <div class="container">
             <h2 class="text-center mb-5 fw-bold">Visi & Misi</h2>
             <div class="row justify-content-center">
                 @php
                     $visiMisiData = [
                         [
                             'title' => 'Mendukung Penilaian Kompetensi ASN',
                             'description' =>
                                 "Memberikan kemudahan bagi ASN dalam melakukan self-assessment dan menerima penilaian dari atasan secara terstruktur dan digital.",
                             'icon' => 'bi bi-rocket-takeoff',
                         ],
                         [
                             'title' => 'Meningkatkan keterampilan diri yang baik',
                             'description' =>
                                 "Membantu ASN menyusun rencana pengembangan diri melalui usulan pelatihan yang sesuai dengan kebutuhan kompetensi individu dan unit kerja.",
                             'icon' => 'bi bi-rocket-takeoff',
                         ],
                         [
                             'title' => 'Mewujudkan Sistem yang Transparan dan Efisien',
                             'description' =>
                                 "Membantu ASN dalam mengimplementasikan sistem yang lebih transparan dan efisien untuk pengembangan karier.",
                             'icon' => 'bi bi-rocket-takeoff',
                         ],
                     ];
                 @endphp
                 @foreach ($visiMisiData as $item)
                     <div class="col-md-4 col-sm-6 mb-4">
                         <div class="card border-0 shadow-sm text-center h-100"
                             style="border-radius: 12px; background-color: #f5f8ff; min-height: 450px;">
                             <div class="mx-auto mt-3"
                                 style="width: 248px; height: 10.98px; background-color: #0d6efd; border-radius: 10px;">
                             </div>
 
                             <div class="card-body d-flex flex-column justify-content-center p-5">
                                 <div class="mb-3">
                                     <i class="{{ $item['icon'] }}" style="font-size: 73px; color:blue"></i>
                                 </div>
                                 <h5 class="card-title fw-bold">{{ $item['title'] }}</h5>
                                 <p class="card-text medium">{{ $item['description'] }}</p>
                             </div>
 
                             <div class="mx-auto mb-3"
                                 style="width: 248px; height: 10.98px; background-color: #0d6efd; border-radius: 10px;">
                             </div>
                         </div>
                     </div>
                 @endforeach
             </div>
         </div>
     </section>
 
     {{-- Tutorial --}}
     <section id="tutorial" class="py-5 bg-light">
         <div class="container">
             <div class="d-flex align-items-center mb-4">
                 <img src="images/iconJudul.svg" alt="Icon" class="me-2" style="width: 24px; height: 24px;">
                 <h2 class="mb-0">Tutorial</h2>
             </div>
             <div class="row justify-content-center">
                 <div class="col-md-12">
                     <div class="card">
                         <div class="card-body text-center">
                             <p id="pdf-warning" class="text-danger d-none">PDF tidak dapat ditampilkan, silakan <a
                                     href="images/contoh.pdf" download>download di sini</a>.</p>
                             <embed id="pdf-viewer" src="images/contoh.pdf" type="application/pdf" width="100%"
                                 height="600px"
                                 onerror="document.getElementById('pdf-warning').classList.remove('d-none'); this.style.display='none';" />
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
 
     {{-- Galeri --}}
     <section id="galeri" class="py-5" style="background-color: #F3F5F6;">
         <div class="container py-4">
             <!-- Judul Galeri -->
             <div class="d-flex align-items-center mb-4">
                 <img src="images/iconJudul.svg" alt="Icon" width="24" height="24" class="me-2">
                 <h2 class="fw-medium mb-0">Galeri</h2>
             </div>
 
             @php
                 $galleryImages = [
                     '/images/homepage.png',
                     '/images/homepage.png',
                     '/images/homepage.png',
                     '/images/homepage.png',
                     '/images/homepage.png',
                 ];
             @endphp
 
             <!-- Grid Galeri -->
             <div class="row g-3">
                 <!-- Gambar Besar -->
                 <div class="col-lg-6">
                     <img src="{{ $galleryImages[0] }}" alt="Gambar Besar" class="img-fluid shadow rounded">
                 </div>
 
                 <!-- Gambar Kecil -->
                 <div class="col-lg-6">
                     <div class="row g-3">
                         @foreach (array_slice($galleryImages, 1) as $index => $image)
                             <div class="col-6">
                                 <img src="{{ $image }}" alt="Gambar {{ $index + 1 }}"
                                     class="img-fluid shadow rounded">
                             </div>
                         @endforeach
                     </div>
                 </div>
             </div>
         </div>
     </section>
 @endsection