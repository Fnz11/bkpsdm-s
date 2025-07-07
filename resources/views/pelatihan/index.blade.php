@extends('layouts.pelatihan.app')

@section('title', 'Pelatihan')

@section('content')
    <section class="hero-section">
        <div class="hero-background"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="hero-badge">Platform Pelatihan ASN</span>
            <h1 class="hero-title">Tingkatkan Kompetensi<br />Raih Prestasi</h1>
            <p class="hero-subtitle">
                Temukan peluang pengembangan diri melalui program pelatihan berkualitas untuk ASN yang lebih profesional
            </p>
            {{-- <div class="search-container">
                <div class="search-bar">
                    <input type="text" class="search-input" placeholder="Cari program pelatihan yang tersedia..." />
                    <i class="ti ti-search search-icon"></i>
                </div>
            </div> --}}
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Program Pelatihan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Alumni</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Bidang Keahlian</div>
                </div>
            </div>
        </div>
    </section>

    <main class="main-content">
        <section class="training-section">
            <div class="training-container">
                <div class="training-header">
                    <span class="training-badge">Program Unggulan</span>
                    <h2 class="section-title">Pelatihan Tersedia</h2>
                    <p class="training-subtitle">
                        Temukan berbagai program pelatihan yang dirancang khusus untuk meningkatkan kompetensi dan
                        keterampilan ASN
                    </p>
                </div>

                @if ($pelatihan && $pelatihan->count() > 0)
                    <div class="training-list-single-column">
                        @foreach ($pelatihan as $index => $item)
                            <article class="training-card-horizontal" data-aos="fade-up"
                                data-aos-delay="{{ $index * 100 }}">
                                <div class="training-image-wrapper">
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_pelatihan }}"
                                            class="training-img-horizontal" loading="lazy"
                                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'; this.alt='Default Training Image';" />
                                    @else
                                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                                            alt="Default Training Image" class="training-img-horizontal" loading="lazy" />
                                    @endif
                                    <div class="training-overlay">
                                        <div class="training-category">
                                            <i class="bi bi-mortarboard-fill me-1"></i>
                                            {{ $item->jenis_pelatihan ?? 'Pelatihan' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="training-details-horizontal">
                                    <div class="training-meta">
                                        <span class="training-type">
                                            <i class="bi bi-bookmark-fill me-1"></i>
                                            {{ $item->jenis_pelatihan ?? 'Umum' }}
                                        </span>
                                        <span class="training-method">
                                            <i class="bi bi-laptop me-1"></i>
                                            {{ $item->metode_pelatihan ?? 'Online' }}
                                        </span>
                                    </div>

                                    <h3 class="training-title">
                                        {{ Str::limit($item->info_pelatihan ?? $item->nama_pelatihan, 60) }}</h3>

                                    @if ($item->deskripsi_pelatihan)
                                        <p class="training-description">
                                            {{ Str::limit($item->deskripsi_pelatihan, 120) }}
                                        </p>
                                    @endif

                                    <div class="training-info-horizontal">
                                        @if ($item->penyelenggara)
                                            <div class="info-item">
                                                <i class="bi bi-building"></i>
                                                <span>{{ $item->penyelenggara }}</span>
                                            </div>
                                        @endif

                                        @if ($item->tanggal_mulai && $item->tanggal_selesai)
                                            <div class="info-item">
                                                <i class="bi bi-calendar-event"></i>
                                                <span>{{ date('d M Y', strtotime($item->tanggal_mulai)) }} -
                                                    {{ date('d M Y', strtotime($item->tanggal_selesai)) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="training-actions-horizontal">
                                        <a href="{{ route('pelatihan.show', $item->id) }}" class="action-button details">
                                            <i class="bi bi-eye"></i>
                                            <span>Detail</span>
                                        </a>
                                        @if ($item->link_pelatihan)
                                            <a href="{{ $item->link_pelatihan }}" target="_blank"
                                                class="action-button register" rel="noopener noreferrer">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                                <span>Lihat</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Load More Button -->
                    {{-- @if ($pelatihan->hasPages())
                        <div class="training-pagination">
                            <div class="pagination-info">
                                <span class="pagination-text">
                                    Menampilkan {{ $pelatihan->firstItem() }} - {{ $pelatihan->lastItem() }} dari {{ $pelatihan->total() }} pelatihan
                                </span>
                            </div>
                            <div class="pagination-links">
                                {{ $pelatihan->links() }}
                            </div>
                        </div>
                    @endif --}}
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <h3 class="empty-title">Belum Ada Pelatihan Tersedia</h3>
                        <p class="empty-description">
                            Saat ini belum ada program pelatihan yang tersedia. Silakan cek kembali nanti atau hubungi
                            administrator.
                        </p>
                        <a href="{{ route('pelatihan.usulan.index') }}" class="btn btn-elegant btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>
                            Ajukan Usulan Pelatihan
                        </a>
                    </div>
                @endif
            </div>
        </section>
        <section class="training-basis">
            <h2 class="section-title">Dasar Pelatihan</h2>
            <div class="basis-grid">
                <div class="basis-card">
                    <div class="basis-icon">
                        <i class="ti ti-book"></i>
                    </div>
                    <h3 class="basis-title">Undang-Undang Nomor 5 Tahun 2014</h3>
                    <p class="basis-text">
                        Pasal 70: ASN berhak mendapatkan pengembangan kompetensi sekurang-kurangnya 20 jam pelajaran
                        dalam satu tahun.
                    </p>
                </div>
                <div class="basis-card">
                    <div class="basis-icon">
                        <i class="ti ti-certificate"></i>
                    </div>
                    <h3 class="basis-title">Pengembangan Kompetensi ASN</h3>
                    <p class="basis-text">
                        Pasal 71: Pemerintah wajib memberikan kesempatan kepada ASN untuk mengikuti pendidikan dan
                        pelatihan dalam rangka pengembangan kompetensi.
                    </p>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="features-container">
                <div class="features-header">
                    <span class="features-badge">Keunggulan Platform</span>
                    <h2 class="features-title">Pengembangan Tanpa Batas</h2>
                    <p class="features-subtitle">
                        Nikmati pengalaman pembelajaran terbaik dengan fitur-fitur unggulan yang mendukung pengembangan
                        kompetensi ASN
                    </p>
                </div>

                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="feature-title">Tersertifikasi Resmi</h3>
                        <p class="feature-description">
                            Semua program pelatihan telah tersertifikasi dan diakui secara resmi sesuai standar kompetensi
                            ASN
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3 class="feature-title">Instruktur Berpengalaman</h3>
                        <p class="feature-description">
                            Dibimbing langsung oleh para ahli dan praktisi berpengalaman di bidangnya masing-masing
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-laptop"></i>
                        </div>
                        <h3 class="feature-title">Fleksibel & Online</h3>
                        <p class="feature-description">
                            Akses materi pelatihan kapan saja dan dimana saja dengan platform pembelajaran yang responsif
                        </p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <h3 class="feature-title">Sertifikat Digital</h3>
                        <p class="feature-description">
                            Dapatkan sertifikat digital yang dapat diverifikasi dan digunakan untuk pengembangan karir
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="cta-section">
            <div class="cta-container">
                <div class="cta-content">
                    <div class="cta-text">
                        <h2 class="cta-title">Siap Mengembangkan Kompetensi Anda?</h2>
                        <p class="cta-description">
                            Bergabunglah dengan ribuan ASN lainnya yang telah merasakan manfaat program pelatihan kami.
                            Mulai perjalanan pengembangan profesional Anda hari ini.
                        </p>
                    </div>
                    <div class="cta-actions">
                        <a href="{{ route('pelatihan.tersedia') }}" class="cta-button primary">
                            <i class="bi bi-rocket-takeoff me-2"></i>
                            Lihat Pelatihan Tersedia
                        </a>
                        <a href="{{ route('pelatihan.usulan.index') }}" class="cta-button secondary">
                            <i class="bi bi-lightbulb me-2"></i>
                            Ajukan Usulan Pelatihan
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Process Section -->
        <section class="process-section">
            <div class="process-container">
                <div class="process-header">
                    <h2 class="process-title">Cara Mengikuti Pelatihan</h2>
                    <p class="process-subtitle">
                        Proses yang mudah dan transparan untuk mengikuti program pelatihan
                    </p>
                </div>

                <div class="process-steps">
                    <div class="step-item">
                        <div class="step-number">01</div>
                        <div class="step-content">
                            <h3 class="step-title">Pilih Program</h3>
                            <p class="step-description">
                                Jelajahi dan pilih program pelatihan yang sesuai dengan kebutuhan pengembangan kompetensi
                                Anda
                            </p>
                        </div>
                    </div>

                    <div class="step-connector"></div>

                    <div class="step-item">
                        <div class="step-number">02</div>
                        <div class="step-content">
                            <h3 class="step-title">Daftar & Verifikasi</h3>
                            <p class="step-description">
                                Lengkapi formulir pendaftaran dan menunggu proses verifikasi dari tim penyelenggara
                            </p>
                        </div>
                    </div>

                    <div class="step-connector"></div>

                    <div class="step-item">
                        <div class="step-number">03</div>
                        <div class="step-content">
                            <h3 class="step-title">Ikuti Pelatihan</h3>
                            <p class="step-description">
                                Berpartisipasi aktif dalam seluruh rangkaian program pelatihan sesuai jadwal yang telah
                                ditentukan
                            </p>
                        </div>
                    </div>

                    <div class="step-connector"></div>

                    <div class="step-item">
                        <div class="step-number">04</div>
                        <div class="step-content">
                            <h3 class="step-title">Terima Sertifikat</h3>
                            <p class="step-description">
                                Selesaikan evaluasi dan terima sertifikat digital sebagai bukti penyelesaian pelatihan
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Statistics Section -->
        <section class="statistics-section">
            <div class="statistics-overlay"></div>
            <div class="statistics-container">
                <div class="statistics-header">
                    <h2 class="statistics-title">Pencapaian Platform Pelatihan</h2>
                    <p class="statistics-subtitle">
                        Data dan statistik yang menunjukkan dampak positif platform pelatihan kami
                    </p>
                </div>

                <div class="statistics-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">50+</div>
                            <div class="stat-label">Program Pelatihan</div>
                            <div class="stat-sublabel">Tersedia setiap tahun</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">1,000+</div>
                            <div class="stat-label">Alumni Pelatihan</div>
                            <div class="stat-sublabel">ASN yang telah terlatih</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">95%</div>
                            <div class="stat-label">Tingkat Kepuasan</div>
                            <div class="stat-sublabel">Feedback peserta</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">85%</div>
                            <div class="stat-label">Peningkatan Kinerja</div>
                            <div class="stat-sublabel">Pasca pelatihan</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('additional-css')
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            50% {
                transform: translate(30px, 20px) rotate(5deg);
            }
        }

        /* Training Basis Section */
        .training-basis {
            padding: 5rem 2rem;
            background: var(--bg-white);
        }

        .basis-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            max-width: var(--container-width);
            margin: 0 auto;
        }

        .basis-card {
            background: var(--bg-white);
            border-radius: 1.25rem;
            padding: 2.5rem;
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            border: 1px solid var(--border-light);
        }

        .basis-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .basis-icon {
            width: 3.5rem;
            height: 3.5rem;
            background: var(--gradient-accent);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .basis-icon i {
            font-size: 1.75rem;
            color: var(--bg-white);
        }

        .basis-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .basis-text {
            color: var(--text-light);
            line-height: 1.75;
        }

        /* Training Section */
        .training-section {
            padding: 6rem 2rem;
            background: var(--bg-primary);
        }

        .training-container {
            max-width: var(--container-width);
            margin: 0 auto;
        }

        .training-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .training-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background: rgba(59, 130, 246, 0.1);
            color: var(--secondary-color);
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
        }

        .training-subtitle {
            font-size: 1.25rem;
            color: var(--text-light);
            max-width: 700px;
            margin: 1.5rem auto 0;
            line-height: 1.6;
        }

        .section-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 3rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0;
        }

        /* Single Column Training List */
        .training-list-single-column {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Enhanced Horizontal Training Card */
        .training-card-horizontal {
            background: var(--bg-white);
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            border: 1px solid var(--border-light);
            display: flex;
            flex-direction: row;
            align-items: stretch;
            min-height: 240px;
            position: relative;
        }

        .training-card-horizontal:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .training-image-wrapper {
            position: relative;
            width: 320px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .training-img-horizontal {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-normal);
        }

        .training-card-horizontal:hover .training-img-horizontal {
            transform: scale(1.05);
        }

        .training-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.8), rgba(59, 130, 246, 0.6));
            opacity: 0;
            transition: var(--transition-normal);
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }

        .training-card-horizontal:hover .training-overlay {
            opacity: 1;
        }

        .training-category {
            background: rgba(255, 255, 255, 0.95);
            color: var(--secondary-color);
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        .training-details-horizontal {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            flex: 1;
            gap: 1rem;
        }

        .training-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .training-type,
        .training-method {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.375rem 0.875rem;
            border-radius: 0.75rem;
            background: rgba(37, 99, 235, 0.1);
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .training-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            line-height: 1.4;
            margin: 0;
        }

        .training-description {
            color: var(--text-light);
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0;
        }

        .training-info-horizontal {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: auto;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .info-item i {
            font-size: 1rem;
            color: var(--accent-color);
            flex-shrink: 0;
        }

        .training-link {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition-normal);
            display: flex;
            align-items: center;
        }

        .training-link:hover {
            color: var(--accent-color);
            text-decoration: none;
        }

        .training-actions-horizontal {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            justify-content: flex-start;
        }

        .action-button {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: var(--transition-normal);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 100px;
            justify-content: center;
        }

        .action-button i {
            font-size: 1rem;
        }

        .action-button.register {
            background: var(--gradient-accent);
            color: var(--bg-white);
            border: none;
        }

        .action-button.register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
            color: var(--bg-white);
        }

        .action-button.details {
            background: var(--bg-white);
            color: var(--secondary-color);
            border: 1px solid var(--border-light);
        }

        .action-button.details:hover {
            background: rgba(37, 99, 235, 0.05);
            transform: translateY(-2px);
            color: var(--secondary-color);
        }

        /* Training Pagination */
        .training-pagination {
            margin-top: 4rem;
            text-align: center;
        }

        .pagination-info {
            margin-bottom: 1.5rem;
        }

        .pagination-text {
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .pagination-links .pagination {
            justify-content: center;
            margin: 0;
        }

        .pagination-links .page-link {
            color: var(--secondary-color);
            border: 1px solid var(--border-light);
            padding: 0.75rem 1rem;
            margin: 0 0.25rem;
            border-radius: 0.5rem;
            transition: var(--transition-normal);
        }

        .pagination-links .page-link:hover {
            background: var(--secondary-color);
            color: var(--bg-white);
            border-color: var(--secondary-color);
        }

        .pagination-links .page-item.active .page-link {
            background: var(--gradient-accent);
            border-color: var(--secondary-color);
            color: var(--bg-white);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--bg-white);
            border-radius: 1.5rem;
            box-shadow: var(--shadow-md);
        }

        .empty-icon {
            width: 5rem;
            height: 5rem;
            background: rgba(37, 99, 235, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }

        .empty-icon i {
            font-size: 2.5rem;
            color: var(--secondary-color);
        }

        .empty-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .empty-description {
            color: var(--text-light);
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-elegant {
            padding: 0.875rem 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: var(--transition-normal);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .btn-elegant.btn-primary {
            background: var(--gradient-accent);
            color: var(--bg-white);
            border: none;
        }

        .btn-elegant.btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: var(--bg-white);
        }

        /* Responsive Adjustments */
        @media (max-width: 1024px) {
            .training-image-wrapper {
                width: 280px;
            }
        }

        @media (max-width: 768px) {
            .training-section {
                padding: 4rem 1rem;
            }

            .section-title {
                font-size: 2.5rem;
            }

            .training-subtitle {
                font-size: 1rem;
            }

            .training-card-horizontal {
                flex-direction: column;
                min-height: auto;
            }

            .training-image-wrapper {
                width: 100%;
                height: 200px;
            }

            .training-actions-horizontal {
                justify-content: center;
            }

            .action-button {
                flex: 1;
                max-width: 150px;
            }
        }

        @media (max-width: 480px) {
            .training-meta {
                justify-content: center;
                gap: 0.5rem;
            }

            .training-type,
            .training-method {
                font-size: 0.625rem;
                padding: 0.25rem 0.625rem;
            }

            .training-title {
                font-size: 1.25rem;
                text-align: center;
            }

            .training-actions-horizontal {
                flex-direction: column;
                gap: 0.75rem;
            }

            .action-button {
                width: 100%;
                max-width: none;
            }
        }

        .category-list {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 4rem;
            flex-wrap: wrap;
        }

        .category-item {
            padding: 0.75rem 2rem;
            border: 1px solid var(--border-light);
            border-radius: 0.75rem;
            font-size: 0.95rem;
            font-weight: 500;
            background: var(--bg-white);
            color: var(--text-color);
            cursor: pointer;
            transition: var(--transition-normal);
        }

        .category-item:hover {
            border-color: var(--accent-color);
            color: var(--accent-color);
            transform: translateY(-2px);
        }

        .category-item.active {
            background: var(--gradient-accent);
            color: var(--bg-white);
            border: none;
        }

        .training-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            max-width: var(--container-width);
            margin: 0 auto;
        }

        .training-card {
            background: var(--bg-white);
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            border: 1px solid var(--border-light);
            display: flex;
            flex-direction: column;
        }

        .training-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .training-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .training-details {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            flex: 1;
        }

        .training-meta {
            display: flex;
            gap: 0.75rem;
        }

        .training-type,
        .training-method {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            background: rgba(37, 99, 235, 0.1);
            color: var(--secondary-color);
        }

        .training-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            line-height: 1.4;
        }

        .training-description {
            color: var(--text-light);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .training-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: auto;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-light);
        }

        .info-item i {
            font-size: 1.125rem;
            color: var(--accent-color);
        }

        .training-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .action-button {
            flex: 1;
            padding: 0.75rem 1.25rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: var(--transition-normal);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .action-button i {
            font-size: 1.125rem;
        }

        .action-button.register {
            background: var(--gradient-accent);
            color: var(--bg-white);
            border: none;
        }

        .action-button.register:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .action-button.details {
            background: var(--bg-white);
            color: var(--secondary-color);
            border: 1px solid var(--border-light);
        }

        .action-button.details:hover {
            background: rgba(37, 99, 235, 0.05);
            transform: translateY(-2px);
        }

        @media (max-width: 1280px) {
            .training-list {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {

            .hero-title {
                font-size: 2.5rem;
            }

            .basis-grid {
                grid-template-columns: 1fr;
            }

            .training-list {
                grid-template-columns: 1fr;
            }
        }

        /* Enhanced Hero Section */
        .hero-section {
            margin-top: 0;
            min-height: var(--hero-height);
            padding: 4rem 5rem;
            background: none;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('/images/balkot.jpg');
            background-size: cover;
            background-position: center;
            z-index: 0;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--overlay-dark);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 1rem;
            text-align: center;
            margin-top: var(--header-height);
        }

        .hero-badge {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 3rem;
            font-size: 0.875rem;
            color: #fff;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            transform: translateY(30px);
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }

        .hero-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 4rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transform: translateY(30px);
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards 0.2s;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            transform: translateY(30px);
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards 0.4s;
        }

        .search-container {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
            transform: translateY(30px);
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards 0.6s;
        }

        .search-bar {
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            padding-right: 4rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .search-bar:focus-within {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
        }

        .search-input {
            width: 100%;
            border: none;
            outline: none;
            font-size: 1.125rem;
            background: transparent;
            color: var(--text-color);
        }

        .search-input::placeholder {
            color: var(--text-light);
        }

        .search-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.5rem;
            color: var(--accent-color);
            cursor: pointer;
            transition: var(--transition-normal);
        }

        .search-icon:hover {
            color: var(--secondary-color);
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 4rem;
            margin-top: 1rem;
            transform: translateY(30px);
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards 0.8s;
        }

        .stat-item {
            text-align: center;
            color: #fff;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-family: 'Familjen Grotesk', sans-serif;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 1024px) {
            .hero-title {
                font-size: 3.5rem;
            }

            .hero-stats {
                gap: 2rem;
            }

            .stat-number {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {

            .hero-stats {
                flex-wrap: wrap;
                gap: 2rem;
            }

            .stat-item {
                flex: 1;
                min-width: 140px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-badge {
                font-size: 0.75rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .search-bar {
                padding: 1rem;
            }

            .stat-number {
                font-size: 1.75rem;
            }
        }

        /* Features Section */
        .features-section {
            padding: 6rem 2rem;
            background: var(--bg-primary);
            position: relative;
        }

        .features-container {
            max-width: var(--container-width);
            margin: 0 auto;
        }

        .features-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .features-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background: rgba(59, 130, 246, 0.1);
            color: var(--secondary-color);
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1.5rem;
        }

        .features-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .features-subtitle {
            font-size: 1.25rem;
            color: var(--text-light);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2.5rem;
        }

        .feature-card {
            background: var(--bg-white);
            padding: 2.5rem;
            border-radius: 1.25rem;
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: var(--transition-normal);
            border: 1px solid var(--border-light);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-accent);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .feature-icon {
            width: 4rem;
            height: 4rem;
            background: var(--gradient-accent);
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            position: relative;
        }

        .feature-icon::after {
            content: '';
            position: absolute;
            inset: -4px;
            background: var(--gradient-accent);
            border-radius: 1.5rem;
            opacity: 0.2;
            z-index: -1;
        }

        .feature-icon i {
            font-size: 2rem;
            color: var(--bg-white);
        }

        .feature-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .feature-description {
            color: var(--text-light);
            line-height: 1.7;
        }

        /* Process Section */
        .process-section {
            padding: 6rem 2rem;
            background: var(--bg-white);
        }

        .process-container {
            max-width: var(--container-width);
            margin: 0 auto;
        }

        .process-header {
            text-align: center;
            margin-bottom: 5rem;
        }

        .process-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .process-subtitle {
            font-size: 1.25rem;
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        .process-steps {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            position: relative;
        }

        .step-item {
            flex: 1;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .step-number {
            width: 4rem;
            height: 4rem;
            background: var(--gradient-accent);
            color: var(--bg-white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 auto 2rem;
            position: relative;
            box-shadow: var(--shadow-md);
        }

        .step-number::after {
            content: '';
            position: absolute;
            inset: -8px;
            background: var(--gradient-accent);
            border-radius: 50%;
            opacity: 0.2;
            z-index: -1;
        }

        .step-content {
            max-width: 250px;
            margin: 0 auto;
        }

        .step-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .step-description {
            color: var(--text-light);
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .step-connector {
            flex: 1;
            height: 2px;
            background: var(--gradient-accent);
            margin-top: 2rem;
            position: relative;
        }

        .step-connector::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 8px solid var(--secondary-color);
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
        }

        /* Statistics Section */
        .statistics-section {
            padding: 6rem 2rem;
            background-image: url('images/balkot.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
        }

        .statistics-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.85);
            z-index: 1;
        }

        .statistics-container {
            max-width: var(--container-width);
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .statistics-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .statistics-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--bg-white);
            margin-bottom: 1.5rem;
        }

        .statistics-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 600px;
            margin: 0 auto;
        }

        .statistics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2.5rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1.25rem;
            padding: 2.5rem;
            text-align: center;
            transition: var(--transition-normal);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.15);
        }

        .stat-icon {
            width: 3.5rem;
            height: 3.5rem;
            background: var(--gradient-accent);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .stat-icon i {
            font-size: 1.75rem;
            color: var(--bg-white);
        }

        .stat-value {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--bg-white);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--bg-white);
            margin-bottom: 0.25rem;
        }

        .stat-sublabel {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Call to Action Section */
        .cta-section {
            padding: 6rem 2rem;
            background: var(--gradient-accent);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 6s ease-in-out infinite;
        }

        .cta-container {
            max-width: var(--container-width);
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .cta-content {
            text-align: center;
            color: var(--bg-white);
        }

        .cta-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .cta-description {
            font-size: 1.25rem;
            margin-bottom: 3rem;
            opacity: 0.95;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .cta-actions {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-button {
            padding: 1rem 2.5rem;
            border-radius: 0.75rem;
            font-size: 1.125rem;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition-normal);
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            min-width: 200px;
            justify-content: center;
        }

        .cta-button.primary {
            background: var(--bg-white);
            color: var(--secondary-color);
            box-shadow: var(--shadow-lg);
        }

        .cta-button.primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
            color: var(--secondary-color);
        }

        .cta-button.secondary {
            background: transparent;
            color: var(--bg-white);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .cta-button.secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--bg-white);
            transform: translateY(-3px);
            color: var(--bg-white);
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.05;
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {

            .features-title,
            .process-title,
            .statistics-title,
            .cta-title {
                font-size: 2.5rem;
            }

            .process-steps {
                flex-direction: column;
                gap: 3rem;
            }

            .step-connector {
                display: none;
            }
        }

        @media (max-width: 768px) {

            .features-section,
            .process-section,
            .statistics-section,
            .cta-section {
                padding: 4rem 1rem;
            }

            .features-title,
            .process-title,
            .statistics-title,
            .cta-title {
                font-size: 2rem;
            }

            .features-subtitle,
            .process-subtitle,
            .statistics-subtitle,
            .cta-description {
                font-size: 1rem;
            }

            .cta-actions {
                flex-direction: column;
                align-items: center;
            }

            .cta-button {
                width: 100%;
                max-width: 300px;
            }

            .stat-value {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 480px) {

            .features-title,
            .process-title,
            .statistics-title,
            .cta-title {
                font-size: 1.75rem;
            }

            .feature-card,
            .stat-card {
                padding: 2rem;
            }

            .stat-value {
                font-size: 2rem;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-badge {
                font-size: 0.75rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .search-bar {
                padding: 1rem;
            }

            .stat-number {
                font-size: 1.75rem;
            }
        }
    </style>
@endsection

@section('additional-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate statistics on scroll
            const animateStats = () => {
                const statValues = document.querySelectorAll('.stat-value');
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const target = entry.target;
                            const finalValue = target.textContent;
                            const numericValue = parseInt(finalValue.replace(/\D/g, ''));
                            const suffix = finalValue.replace(/[\d,]/g, '');

                            if (numericValue) {
                                animateCounter(target, 0, numericValue, suffix, 2000);
                                observer.unobserve(target);
                            }
                        }
                    });
                }, {
                    threshold: 0.5
                });

                statValues.forEach(stat => observer.observe(stat));
            };

            // Counter animation function
            const animateCounter = (element, start, end, suffix, duration) => {
                const startTime = performance.now();
                const animate = (currentTime) => {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const easeOut = 1 - Math.pow(1 - progress, 3);

                    const current = Math.floor(start + (end - start) * easeOut);
                    element.textContent = current.toLocaleString() + suffix;

                    if (progress < 1) {
                        requestAnimationFrame(animate);
                    }
                };
                requestAnimationFrame(animate);
            };

            // Smooth reveal animations for cards
            const observeCards = () => {
                const cards = document.querySelectorAll('.feature-card, .step-item, .training-card-horizontal');
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry, index) => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                            }, index * 100);
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                });

                cards.forEach(card => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    observer.observe(card);
                });
            };

            // Parallax effect for hero section
            const initParallax = () => {
                const heroBackground = document.querySelector('.hero-background');
                if (heroBackground) {
                    window.addEventListener('scroll', () => {
                        const scrolled = window.pageYOffset;
                        const parallax = scrolled * 0.5;
                        heroBackground.style.transform = `translateY(${parallax}px)`;
                    });
                }
            };

            // Image fallback with retry mechanism
            const setupImageFallbacks = () => {
                const images = document.querySelectorAll('.training-img-horizontal');
                images.forEach(img => {
                    img.addEventListener('error', function() {
                        if (this.retryCount < 2) {
                            this.retryCount = (this.retryCount || 0) + 1;
                            setTimeout(() => {
                                this.src = this.src;
                            }, 1000 * this.retryCount);
                        } else {
                            this.src =
                                'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80';
                            this.alt = 'Default Training Image';
                        }
                    });
                });
            };

            // Enhanced hover effects for cards
            const enhanceCardHovers = () => {
                const cards = document.querySelectorAll('.feature-card, .training-card-horizontal, .stat-card');
                cards.forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                    });

                    card.addEventListener('mouseleave', function() {
                        this.style.transition = 'all 0.3s ease';
                    });
                });
            };

            // Add loading state to action buttons
            const enhanceButtons = () => {
                const buttons = document.querySelectorAll('.action-button, .cta-button');
                buttons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        if (this.href && !this.href.includes('#')) {
                            this.style.opacity = '0.7';
                            this.style.pointerEvents = 'none';

                            const originalText = this.innerHTML;
                            this.innerHTML =
                                '<i class="bi bi-hourglass-split me-2"></i>Loading...';

                            setTimeout(() => {
                                this.innerHTML = originalText;
                                this.style.opacity = '1';
                                this.style.pointerEvents = 'auto';
                            }, 1500);
                        }
                    });
                });
            };

            // Initialize all features
            animateStats();
            observeCards();
            initParallax();
            setupImageFallbacks();
            enhanceCardHovers();
            enhanceButtons();

            // Performance optimization - debounce scroll events
            let scrollTimeout;
            window.addEventListener('scroll', () => {
                if (scrollTimeout) clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    // Any scroll-dependent code here
                }, 10);
            });
        });
    </script>
@endsection
