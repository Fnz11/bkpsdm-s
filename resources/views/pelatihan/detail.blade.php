@extends('layouts.pelatihan.app')

@section('title', $pelatihan->nama_pelatihan)

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <i class="bi bi-mortarboard-fill me-3"></i>
                        Detail Pelatihan
                    </h1>
                    <p class="hero-subtitle">Informasi lengkap tentang program pelatihan yang tersedia</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.index') }}" class="btn btn-elegant btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Training Information Card -->
        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <div class="info-content">
                <h6 class="info-title">Informasi Pelatihan</h6>
                <p class="info-text">
                    Pastikan Anda membaca seluruh informasi pelatihan dengan teliti sebelum mendaftar. 
                    Pendaftaran yang telah dikonfirmasi tidak dapat dibatalkan.
                </p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Training Image and Description -->
            <div class="training-details-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-image me-2"></i>
                        {{ $pelatihan->nama_pelatihan ?? 'Informasi Pelatihan' }}
                    </h3>
                </div>
                
                <div class="training-image-container">
                    @if ($pelatihan->gambar)
                        <img src="{{ asset('storage/' . $pelatihan->gambar) }}" 
                             class="training-detail-image" 
                             alt="{{ $pelatihan->nama_pelatihan }}"
                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'; this.alt='Default Training Image';" />
                    @else
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                             class="training-detail-image" 
                             alt="Default Training Image" />
                    @endif
                    <div class="image-overlay">
                        <div class="training-badge">
                            <i class="bi bi-star-fill me-1"></i>
                            Program Unggulan
                        </div>
                    </div>
                </div>

                <div class="training-description">
                    <h4 class="description-title">Deskripsi Pelatihan</h4>
                    <p class="description-text">
                        {{ $pelatihan->info_pelatihan ?? 'Informasi pelatihan tidak tersedia.' }}
                    </p>

                    @if ($pelatihan->link_pelatihan)
                        <div class="external-link-card">
                            <div class="link-icon">
                                <i class="bi bi-link-45deg"></i>
                            </div>
                            <div class="link-content">
                                <h6 class="link-title">Link Pelatihan External</h6>
                                <p class="link-description">Akses materi dan informasi tambahan</p>
                                <a href="{{ $pelatihan->link_pelatihan }}" 
                                   class="btn btn-elegant btn-outline-primary btn-sm" 
                                   target="_blank" 
                                   rel="noopener noreferrer">
                                    <i class="bi bi-box-arrow-up-right me-1"></i>
                                    Buka Link Pelatihan
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Training Information -->
            <div class="training-info-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-clipboard-data me-2"></i>
                        Informasi Detail
                    </h3>
                </div>

                <div class="info-list">
                    @if(isset($pelatihan->penyelenggara_pelatihan))
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-building"></i>
                                <span>Penyelenggara</span>
                            </div>
                            <div class="info-value">{{ $pelatihan->penyelenggara_pelatihan }}</div>
                        </div>
                    @endif

                    @if(isset($pelatihan->jenispelatihan->jenis_pelatihan))
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-tag"></i>
                                <span>Jenis Pelatihan</span>
                            </div>
                            <div class="info-value">{{ $pelatihan->jenispelatihan->jenis_pelatihan }}</div>
                        </div>
                    @endif

                    @if(isset($pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan))
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-gear"></i>
                                <span>Metode Pelaksanaan</span>
                            </div>
                            <div class="info-value">{{ $pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan }}</div>
                        </div>
                    @endif

                    @if(isset($pelatihan->tempat_pelatihan))
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-geo-alt"></i>
                                <span>Lokasi</span>
                            </div>
                            <div class="info-value">{{ $pelatihan->tempat_pelatihan }}</div>
                        </div>
                    @endif

                    @if(isset($pelatihan->tanggal_mulai) && isset($pelatihan->tanggal_selesai))
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-calendar-range"></i>
                                <span>Periode Pelatihan</span>
                            </div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->isoFormat('D MMMM Y') }} - 
                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->isoFormat('D MMMM Y') }}
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-clock"></i>
                                <span>Durasi</span>
                            </div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->diffInDays($pelatihan->tanggal_selesai) + 1 }} Hari
                            </div>
                        </div>
                    @endif

                    @if(isset($pelatihan->tutup_pendaftaran))
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-calendar-x"></i>
                                <span>Batas Pendaftaran</span>
                            </div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($pelatihan->tutup_pendaftaran)->isoFormat('D MMMM Y') }}
                            </div>
                        </div>
                    @endif

                    @if(isset($pelatihan->biaya))
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-currency-dollar"></i>
                                <span>Biaya</span>
                            </div>
                            <div class="info-value">
                                @if($pelatihan->biaya == 0)
                                    <span class="badge badge-success">Gratis</span>
                                @else
                                    Rp {{ number_format($pelatihan->biaya, 0, ',', '.') }}
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="action-section">
                    <div class="action-header">
                        <h4 class="action-title">
                            <i class="bi bi-hand-index me-2"></i>
                            Tindakan
                        </h4>
                        <p class="action-subtitle">Pilih tindakan yang ingin Anda lakukan</p>
                    </div>

                    <div class="action-buttons">
                        <a href="/pelatihan/daftar-pelatihan" class="btn btn-elegant btn-primary btn-lg">
                            <i class="bi bi-person-plus me-2"></i>
                            <span>Daftar Pelatihan</span>
                        </a>
                        
                        @if ($pelatihan->link_pelatihan)
                            <a href="{{ $pelatihan->link_pelatihan }}" 
                               class="btn btn-elegant btn-outline-primary btn-lg" 
                               target="_blank" 
                               rel="noopener noreferrer">
                                <i class="bi bi-box-arrow-up-right me-2"></i>
                                <span>Akses Link Pelatihan</span>
                            </a>
                        @endif
                        
                        <button onclick="sharePelatihan()" class="btn btn-elegant btn-outline-secondary btn-lg">
                            <i class="bi bi-share me-2"></i>
                            <span>Bagikan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-css')
    <style>
        /* Modern Container */
        .modern-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Hero Header */
        .hero-header {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(139, 92, 246, 0.05) 100%);
            border-radius: 1.5rem;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(59, 130, 246, 0.1);
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .hero-text {
            flex: 1;
        }

        .hero-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: var(--text-light);
            margin: 0;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Info Card */
        .info-card {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 1.25rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .info-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-icon i {
            font-size: 1.25rem;
            color: #059669;
        }

        .info-content {
            flex: 1;
        }

        .info-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .info-text {
            color: var(--text-light);
            margin: 0;
            line-height: 1.6;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        /* Training Details Card */
        .training-details-card,
        .training-info-card {
            background: var(--bg-white);
            border-radius: 1.25rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-light);
            background: rgba(59, 130, 246, 0.03);
        }

        .card-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
            display: flex;
            align-items: center;
        }

        /* Training Image */
        .training-image-container {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .training-detail-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-normal);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.7), rgba(59, 130, 246, 0.5));
            opacity: 0;
            transition: var(--transition-normal);
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }

        .training-details-card:hover .image-overlay {
            opacity: 1;
        }

        .training-badge {
            background: rgba(255, 255, 255, 0.95);
            color: var(--secondary-color);
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        /* Training Description */
        .training-description {
            padding: 2rem;
        }

        .description-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .description-text {
            color: var(--text-light);
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        /* External Link Card */
        .external-link-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(139, 92, 246, 0.03) 100%);
            border: 1px solid rgba(59, 130, 246, 0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .link-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .link-icon i {
            font-size: 1.25rem;
            color: var(--secondary-color);
        }

        .link-content {
            flex: 1;
        }

        .link-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }

        .link-description {
            color: var(--text-light);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        /* Info List */
        .info-list {
            padding: 1.5rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-light);
            gap: 1rem;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            color: var(--text-color);
            flex-shrink: 0;
            min-width: 140px;
        }

        .info-label i {
            font-size: 1rem;
            color: var(--secondary-color);
            width: 16px;
            text-align: center;
        }

        .info-value {
            color: var(--text-light);
            text-align: right;
            flex: 1;
        }

        /* Badge */
        .badge {
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        /* Action Section */
        .action-section {
            padding: 2rem 1.5rem;
            background: rgba(59, 130, 246, 0.02);
            border-top: 1px solid var(--border-light);
        }

        .action-header {
            margin-bottom: 1.5rem;
        }

        .action-title {
            font-family: 'Familjen Grotesk', sans-serif;
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .action-subtitle {
            color: var(--text-light);
            font-size: 0.875rem;
            margin: 0;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Elegant Button Styles */
        .btn-elegant {
            padding: 0.875rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition-normal);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: 1px solid transparent;
            font-size: 0.95rem;
        }

        .btn-elegant.btn-lg {
            padding: 1rem 2rem;
            font-size: 1rem;
        }

        .btn-elegant.btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-elegant.btn-primary {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--accent-color) 100%);
            color: var(--bg-white);
            border-color: var(--secondary-color);
        }

        .btn-elegant.btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
            color: var(--bg-white);
        }

        .btn-elegant.btn-outline-primary {
            background: var(--bg-white);
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-elegant.btn-outline-primary:hover {
            background: var(--secondary-color);
            color: var(--bg-white);
            transform: translateY(-2px);
        }

        .btn-elegant.btn-outline-secondary {
            background: var(--bg-white);
            color: var(--text-color);
            border-color: var(--border-light);
        }

        .btn-elegant.btn-outline-secondary:hover {
            background: rgba(59, 130, 246, 0.05);
            border-color: var(--secondary-color);
            color: var(--secondary-color);
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .hero-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .hero-title {
                font-size: 2.25rem;
            }
        }

        @media (max-width: 768px) {
            .modern-container {
                padding: 1rem;
            }

            .hero-header {
                padding: 2rem 1.5rem;
            }

            .hero-title {
                font-size: 2rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .hero-actions {
                width: 100%;
                justify-content: stretch;
            }

            .hero-actions .btn-elegant {
                flex: 1;
            }

            .training-image-container {
                height: 250px;
            }

            .training-description {
                padding: 1.5rem;
            }

            .info-list {
                padding: 1rem;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .info-label {
                min-width: auto;
            }

            .info-value {
                text-align: left;
            }

            .action-section {
                padding: 1.5rem 1rem;
            }

            .action-buttons {
                gap: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.75rem;
            }

            .external-link-card {
                flex-direction: column;
                text-align: center;
            }

            .link-icon {
                align-self: center;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-up {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection

@section('additional-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation classes to elements
            const elements = document.querySelectorAll('.hero-header, .info-card, .training-details-card, .training-info-card');
            elements.forEach((el, index) => {
                setTimeout(() => {
                    el.classList.add('fade-in');
                }, index * 100);
            });

            // Image fallback enhancement
            const trainingImage = document.querySelector('.training-detail-image');
            if (trainingImage) {
                trainingImage.addEventListener('load', function() {
                    this.style.opacity = '1';
                });
                
                trainingImage.addEventListener('error', function() {
                    console.log('Image failed to load, using fallback');
                });
            }

            // Enhanced button interactions
            const buttons = document.querySelectorAll('.btn-elegant');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Add loading state for navigation
                    if (this.href && !this.href.includes('#') && !this.target) {
                        this.style.opacity = '0.7';
                        this.style.pointerEvents = 'none';
                        
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Loading...';
                        
                        // Reset after a delay if page doesn't change
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.style.opacity = '1';
                            this.style.pointerEvents = 'auto';
                        }, 2000);
                    }
                });

                // Add hover sound effect (optional)
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Smooth scroll for internal links
            const internalLinks = document.querySelectorAll('a[href^="#"]');
            internalLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Share functionality
        function sharePelatihan() {
            const title = document.querySelector('.hero-title').textContent.trim();
            const url = window.location.href;
            
            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url,
                    text: 'Lihat detail pelatihan ini!'
                }).then(() => {
                    showToast('Berhasil dibagikan!', 'success');
                }).catch(err => {
                    console.log('Error sharing:', err);
                    fallbackShare(url);
                });
            } else {
                fallbackShare(url);
            }
        }

        // Fallback share method
        function fallbackShare(url) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    showToast('Link telah disalin ke clipboard!', 'success');
                }).catch(() => {
                    showShareDialog(url);
                });
            } else {
                showShareDialog(url);
            }
        }

        // Show share dialog
        function showShareDialog(url) {
            Swal.fire({
                title: 'Bagikan Pelatihan',
                html: `
                    <div class="share-options">
                        <p class="mb-3">Bagikan link pelatihan ini:</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="${url}" id="shareUrl" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyShareUrl()">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="https://wa.me/?text=${encodeURIComponent(url)}" target="_blank" class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                            <a href="https://t.me/share/url?url=${encodeURIComponent(url)}" target="_blank" class="btn btn-info btn-sm">
                                <i class="bi bi-telegram"></i> Telegram
                            </a>
                            <a href="mailto:?subject=Detail Pelatihan&body=${encodeURIComponent(url)}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-envelope"></i> Email
                            </a>
                        </div>
                    </div>
                `,
                showConfirmButton: false,
                showCloseButton: true,
                width: 500
            });
        }

        // Copy share URL
        function copyShareUrl() {
            const input = document.getElementById('shareUrl');
            input.select();
            document.execCommand('copy');
            showToast('Link berhasil disalin!', 'success');
        }

        // Toast notification
        function showToast(message, type = 'success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }

        // Registration function (commented out the original buggy one)
        function daftarPelatihan(pelatihanId) {
            Swal.fire({
                title: 'Yakin ingin daftar?',
                text: "Anda tidak bisa membatalkan setelah ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Daftar',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Mendaftarkan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/pelatihan/pendaftaran/${pelatihanId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire({
                            title: data.status === 'success' ? 'Berhasil!' : 'Gagal!',
                            text: data.message,
                            icon: data.status === 'success' ? 'success' : 'error',
                            confirmButtonColor: '#3b82f6'
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.',
                            icon: 'error',
                            confirmButtonColor: '#3b82f6'
                        });
                    });
                }
            });
        }
    </script>
@endsection
