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
                        {{ $pelatihan->nama_pelatihan }}
                    </h1>
                    <p class="hero-subtitle">{{ $pelatihan->penyelenggara_pelatihan }}</p>
                </div>
                <div class="hero-actions">
                    <a href="{{ route('pelatihan.tersedia') }}" class="btn btn-elegant btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Information Card -->
        <div class="info-card">
            <div class="info-icon">
                @if ($pelatihan->status_pelatihan == 'buka')
                    <i class="bi bi-check-circle-fill text-success"></i>
                @else
                    <i class="bi bi-lock-fill text-warning"></i>
                @endif
            </div>
            <div class="info-content">
                <h6 class="info-title">Status Pendaftaran</h6>
                <p class="info-text">
                    @if ($pelatihan->status_pelatihan == 'buka')
                        <span class="status-highlight status-saved">Pendaftaran Dibuka</span> - Anda dapat mendaftar
                        pelatihan ini sekarang.
                    @else
                        <span class="status-highlight status-processed">Pendaftaran Ditutup</span> - Periode pendaftaran
                        telah berakhir.
                    @endif
                </p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Training Image & Description -->
            <div class="col-lg-8">
                <div class="main-card">
                    <!-- Training Image -->
                    @if ($pelatihan->gambar)
                        <div class="training-image-container">
                            <img src="{{ asset('storage/' . $pelatihan->gambar) }}" class="training-image"
                                alt="{{ $pelatihan->nama_pelatihan }}"
                                onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIzMDAiIGZpbGw9IiNmMWY1ZjkiLz48cGF0aCBkPSJNMTk1IDE0MEMxOTUgMTQ4Ljg0IDIwMi4xNiAxNTYgMjExIDE1NkMyMTkuODQgMTU2IDIyNyAxNDguODQgMjI3IDE0MEMyMjcgMTMxLjE2IDIxOS44NCAxMjQgMjExIDEyNEMyMDIuMTYgMTI0IDE5NSAxMzEuMTYgMTk1IDE0MFoiIGZpbGw9IiM5NGEzYjgiLz48cGF0aCBkPSJNMTc1IDE2MEgyNDdMMjM1IDE4MEgxODdMMTc1IDE2MFoiIGZpbGw9IiM5NGEzYjgiLz48L3N2Zz4='; this.alt='Training Image';">
                        </div>
                    @endif

                    <!-- Description Section -->
                    <div class="description-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="bi bi-file-text me-2"></i>
                                Deskripsi Pelatihan
                            </h3>
                        </div>
                        <div class="description-content">
                            <p class="description-text">
                                {{ $pelatihan->deskripsi ?: 'Tidak ada deskripsi tersedia untuk pelatihan ini.' }}</p>

                            @if ($pelatihan->link_pelatihan)
                                <div class="external-link-section">
                                    <a href="{{ $pelatihan->link_pelatihan }}" class="btn btn-elegant btn-outline-primary"
                                        target="_blank" rel="noopener">
                                        <i class="bi bi-box-arrow-up-right me-2"></i>
                                        Buka Link Pelatihan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Training Information Sidebar -->
            <div class="col-lg-4">
                 <!-- Action Section -->
                <div class="main-card">
                    <div class="action-section">
                        @if ($pelatihan->status_pelatihan == 'buka')
                            <button data-bs-toggle="modal" 
                                    data-bs-target="#konfirmasiModal" 
                                    onclick="setPelatihanId({{ $pelatihan->id }})" 
                                    class="btn btn-action btn-primary">
                                <i class="bi bi-person-plus me-2"></i>
                                <span>Daftar Pelatihan</span>
                            </button>
                        @else
                            <div class="alert alert-warning text-center">
                                <i class="bi bi-lock-fill me-2"></i>
                                Pendaftaran Ditutup
                            </div>
                        @endif
                        
                        <a href="{{ route('pelatihan.tersedia') }}" class="btn btn-action btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            <span>Kembali ke Daftar</span>
                        </a>
                    </div>
                </div>

                <div class="main-card mt-4">
                    <div class="info-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="bi bi-info-circle me-2"></i>
                                Informasi Pelatihan
                            </h3>
                        </div>

                        <div class="info-grid">
                            <!-- Penyelenggara -->
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-building text-primary"></i>
                                    <span>Penyelenggara</span>
                                </div>
                                <div class="info-value">{{ $pelatihan->penyelenggara_pelatihan }}</div>
                            </div>

                            <!-- Jenis Pelatihan -->
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-bookmark text-primary"></i>
                                    <span>Jenis Pelatihan</span>
                                </div>
                                <div class="info-value">{{ $pelatihan->jenispelatihan->jenis_pelatihan ?? '-' }}</div>
                            </div>

                            <!-- Pelaksanaan -->
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-gear text-primary"></i>
                                    <span>Pelaksanaan</span>
                                </div>
                                <div class="info-value">{{ $pelatihan->pelaksanaanpelatihan->pelaksanaan_pelatihan ?? '-' }}
                                </div>
                            </div>

                            <!-- Lokasi -->
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-geo-alt text-primary"></i>
                                    <span>Lokasi</span>
                                </div>
                                <div class="info-value">{{ $pelatihan->tempat_pelatihan }}</div>
                            </div>

                            <!-- Kuota -->
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-people text-primary"></i>
                                    <span>Kuota Peserta</span>
                                </div>
                                <div class="info-value">
                                    <span class="highlight-number">{{ $pelatihan->kuota }}</span> Peserta
                                </div>
                            </div>

                            <!-- Periode Pelatihan -->
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-calendar-range text-primary"></i>
                                    <span>Periode Pelatihan</span>
                                </div>
                                <div class="info-value">
                                    <div class="date-range">
                                        <span
                                            class="start-date">{{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->isoFormat('D MMM Y') }}</span>
                                        <i class="bi bi-arrow-right mx-2 text-muted"></i>
                                        <span
                                            class="end-date">{{ \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->isoFormat('D MMM Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Durasi -->
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-clock text-primary"></i>
                                    <span>Durasi</span>
                                </div>
                                <div class="info-value">
                                    <span
                                        class="highlight-number">{{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->diffInDays($pelatihan->tanggal_selesai) + 1 }}</span>
                                    Hari
                                </div>
                            </div>

                            <!-- Batas Pendaftaran -->
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-calendar-x text-primary"></i>
                                    <span>Batas Pendaftaran</span>
                                </div>
                                <div class="info-value">
                                    <span
                                        class="deadline-date">{{ \Carbon\Carbon::parse($pelatihan->tutup_pendaftaran)->isoFormat('D MMM Y') }}</span>
                                </div>
                            </div>

                            <!-- Biaya -->
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-currency-dollar text-primary"></i>
                                    <span>Biaya</span>
                                </div>
                                <div class="info-value">
                                    <span class="currency">Rp {{ number_format($pelatihan->biaya, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="formPendaftaran" method="POST" action="{{ route('pelatihan.pendaftaran.store') }}">
                @csrf
                <input type="hidden" name="pelatihan_id" id="inputPelatihanId">

                <div class="modal-content modern-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-clipboard-check me-2"></i>Konfirmasi Pendaftaran
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="confirmation-content">
                            <div class="confirmation-icon">
                                <i class="bi bi-question-circle text-warning"></i>
                            </div>
                            <h6 class="confirmation-title">Apakah Anda yakin ingin mendaftar pelatihan ini?</h6>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Setelah mendaftar, pendaftaran tidak dapat dibatalkan. Pastikan jadwal Anda kosong pada
                                periode pelatihan.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-elegant btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-elegant btn-primary">
                            <i class="bi bi-check me-1"></i>Ya, Daftar Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hasil Pendaftaran -->
    <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modern-modal">
                <!-- Success Modal -->
                @if (session('success'))
                    <div class="modal-header modal-header-success">
                        <h5 class="modal-title" id="resultModalLabel">
                            <i class="bi bi-check-circle me-2"></i>Pendaftaran Berhasil!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="result-content">
                            <div class="result-icon">
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                            <h6 class="result-title text-success">Selamat! Pendaftaran Anda berhasil</h6>
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-elegant btn-success" data-bs-dismiss="modal">
                            <i class="bi bi-check me-1"></i>Mengerti
                        </button>
                    </div>
                @endif

                <!-- Error Modal -->
                @if (session('error'))
                    <div class="modal-header modal-header-danger">
                        <h5 class="modal-title" id="resultModalLabel">
                            <i class="bi bi-x-circle me-2"></i>Pendaftaran Gagal!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="result-content">
                            <div class="result-icon">
                                <i class="bi bi-x-circle text-danger"></i>
                            </div>
                            <h6 class="result-title text-danger">Oops! Terjadi kesalahan</h6>
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                            @if (str_contains(session('error'), 'sudah terdaftar') || str_contains(session('error'), 'already registered'))
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Anda sudah terdaftar pada pelatihan ini sebelumnya. Silakan cek status pendaftaran Anda.
                                </small>
                            @else
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Silakan coba lagi atau hubungi administrator jika masalah berlanjut.
                                </small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-elegant btn-danger" data-bs-dismiss="modal">
                            <i class="bi bi-x me-1"></i>Tutup
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </main>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Auto-show dan auto-hide modal hasil pendaftaran
            @if (session('success') || session('error'))
                var resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
                resultModal.show();

                // Auto-hide after 5 seconds
                setTimeout(function() {
                    resultModal.hide();
                }, 5000);

                // Clean up when modal is manually closed
                document.getElementById('resultModal').addEventListener('hidden.bs.modal', function() {
                    // Optional: reload page or perform other actions
                });
            @endif

            // Enhanced form submission with loading state
            const submitBtn = document.querySelector('#formPendaftaran button[type="submit"]');
            const formPendaftaran = document.getElementById('formPendaftaran');

            if (formPendaftaran && submitBtn) {
                formPendaftaran.addEventListener('submit', function(e) {
                    // Add loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1 spin"></i>Memproses...';
                });
            }

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
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

            // Image loading states
            const trainingImage = document.querySelector('.training-image');
            if (trainingImage) {
                trainingImage.addEventListener('load', function() {
                    this.style.opacity = '1';
                });

                trainingImage.addEventListener('error', function() {
                    console.log('Image failed to load, fallback applied');
                });
            }
        });

        function setPelatihanId(pelatihanId) {
            document.getElementById('inputPelatihanId').value = pelatihanId;
        }
    </script>

    <style>
        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('additional-css')
@section('additional-css')
    <style>
        :root {
            /* Global soft color palette - matching hasil-registrasi.blade.php */
            --primary-color: #8b9dc3;
            --primary-light: #dfe3ee;
            --primary-hover: #748dc9;
            --secondary-color: #64748b;
            --accent-color: #6366f1;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --shadow-sm: 0 2px 4px rgba(148, 163, 184, 0.1);
            --shadow-md: 0 4px 12px rgba(148, 163, 184, 0.15);
            --shadow-lg: 0 8px 24px rgba(148, 163, 184, 0.2);
            --border-radius: 12px;
            --border-radius-sm: 8px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            --gradient-secondary: linear-gradient(135deg, var(--bg-secondary) 0%, #e2e8f0 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
        }

        .modern-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Hero Header */
        .hero-header {
            background: var(--gradient-primary);
            border-radius: var(--border-radius);
            padding: 2.5rem;
            margin-bottom: 2rem;
            color: white;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .hero-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: rotate(45deg);
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            margin: 0;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        /* Info Card */
        .info-card {
            background: linear-gradient(135deg, #e3f2fd 0%, #e8eaf6 100%);
            border: 1px solid var(--primary-color);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .info-icon {
            flex-shrink: 0;
            width: 48px;
            height: 48px;
            background: var(--primary-color);
            border-radius: var(--border-radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .info-content h6 {
            color: var(--primary-hover);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .info-text {
            color: var(--text-secondary);
            margin: 0;
        }

        .status-highlight {
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            margin: 0 0.25rem;
        }

        .status-highlight.status-saved {
            background: rgba(16, 185, 129, 0.15);
            color: #059669;
        }

        .status-highlight.status-processed {
            background: rgba(245, 158, 11, 0.15);
            color: #d97706;
        }

        /* Main Card */
        .main-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: var(--transition);
        }

        .main-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        /* Training Image */
        .training-image-container {
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .training-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: var(--transition);
            opacity: 0;
        }

        .training-image:hover {
            transform: scale(1.05);
        }

        /* Description Section */
        .description-section {
            padding: 2rem;
        }

        .section-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .section-title {
            font-size: 1.375rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .description-content {
            margin-top: 1rem;
        }

        .description-text {
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .external-link-section {
            margin-top: 1.5rem;
        }

        /* Info Section */
        .info-section {
            padding: 2rem;
        }

        .info-grid {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 1rem;
            background: var(--bg-secondary);
            border-radius: var(--border-radius-sm);
            border: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .info-item:hover {
            background: #f1f5f9;
            border-color: var(--primary-color);
            transform: translateY(-1px);
        }

        .info-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-primary);
            line-height: 1.5;
        }

        .highlight-number {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.125rem;
        }

        .date-range {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .start-date,
        .end-date {
            padding: 0.25rem 0.5rem;
            background: var(--primary-light);
            color: var(--primary-hover);
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .deadline-date {
            color: var(--warning-color);
            font-weight: 600;
        }

        .currency {
            font-family: 'Familjen Grotesk', sans-serif;
            font-weight: 700;
            color: var(--success-color);
            font-size: 1.125rem;
        }

        /* Action Section */
        .action-section {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn-action {
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: 2px solid transparent;
        }

        .btn-action.btn-primary {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-action.btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-action.btn-outline-secondary {
            background: var(--bg-primary);
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        .btn-action.btn-outline-secondary:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border-color: var(--text-secondary);
            transform: translateY(-2px);
        }

        /* Buttons */
        .btn-elegant {
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius-sm);
            border: 2px solid transparent;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .btn-elegant.btn-outline-light {
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-elegant.btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        .btn-elegant.btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            background: var(--bg-primary);
        }

        .btn-elegant.btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-elegant.btn-outline-secondary {
            color: var(--text-secondary);
            border-color: var(--border-color);
            background: var(--bg-primary);
        }

        .btn-elegant.btn-outline-secondary:hover {
            background: var(--bg-secondary);
            border-color: var(--text-secondary);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        .btn-elegant.btn-primary {
            background: var(--gradient-primary);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-elegant.btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-elegant.btn-success {
            background: var(--success-color);
            color: white;
            border-color: var(--success-color);
        }

        .btn-elegant.btn-danger {
            background: var(--danger-color);
            color: white;
            border-color: var(--danger-color);
        }

        /* Modals */
        .modern-modal {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .modern-modal .modal-header {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 1.5rem;
        }

        .modern-modal .modal-header.modal-header-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
        }

        .modern-modal .modal-header.modal-header-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
        }

        .modern-modal .modal-body {
            padding: 2rem;
        }

        .modern-modal .modal-footer {
            background: var(--bg-secondary);
            border: none;
            padding: 1.5rem;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .confirmation-content,
        .result-content {
            text-align: center;
        }

        .confirmation-icon,
        .result-icon {
            margin-bottom: 1rem;
        }

        .confirmation-icon i,
        .result-icon i {
            font-size: 3rem;
        }

        .confirmation-title,
        .result-title {
            margin-bottom: 1rem;
            font-weight: 600;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: var(--border-radius-sm);
            padding: 1rem;
            margin: 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-info {
            background: rgba(99, 102, 241, 0.1);
            color: #4c1d95;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #7f1d1d;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            color: #78350f;
            border: 1px solid rgba(245, 158, 11, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
                gap: 2rem;
            }

            .hero-title {
                font-size: 2rem;
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
                font-size: 1.75rem;
                flex-direction: column;
                gap: 0.5rem;
            }

            .info-card {
                flex-direction: column;
                text-align: center;
            }

            .description-section,
            .info-section,
            .action-section {
                padding: 1.5rem;
            }

            .date-range {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-action {
                padding: 0.875rem 1.25rem;
            }

            .modern-modal .modal-body,
            .modern-modal .modal-footer {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.5rem;
            }

            .training-image {
                height: 200px;
            }

            .info-item {
                padding: 0.75rem;
            }

            .btn-elegant {
                padding: 0.625rem 1rem;
                font-size: 0.8125rem;
            }
        }

        /* Loading and Animation States */
        .training-image {
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

        /* Focus states for accessibility */
        .btn-elegant:focus,
        .btn-action:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
    </style>
@endsection
