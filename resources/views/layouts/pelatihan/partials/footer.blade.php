<footer class="modern-footer">
    <!-- Wave Background -->
    <div class="footer-wave">
        <svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,200L1392,200C1344,200,1248,200,1152,200C1056,200,960,200,864,200C768,200,672,200,576,200C480,200,384,200,288,200C192,200,96,200,48,200L0,200Z"
                fill="var(--gradient-primary)"></path>
        </svg>
    </div>

    <!-- Main Footer Content -->
    <div class="footer-content">
        <div class="container">
            <div class="row g-5">
                <!-- Brand Section -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <div class="brand-logo">
                            <div class="logo-icon">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <div class="brand-text">
                                <h3 class="brand-title">BKPSDM</h3>
                                <span class="brand-subtitle">Pelatihan Berkualitas</span>
                            </div>
                        </div>
                        <p class="brand-description">
                            Badan Kepegawaian dan Pengembangan Sumber Daya Manusia berkomitmen untuk meningkatkan
                            kualitas ASN melalui pelatihan berkualitas dan inovasi berkelanjutan.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link" data-bs-toggle="tooltip" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-link" data-bs-toggle="tooltip" title="Twitter">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="social-link" data-bs-toggle="tooltip" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="social-link" data-bs-toggle="tooltip" title="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="social-link" data-bs-toggle="tooltip" title="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section">
                        <h5 class="section-title">
                            <i class="bi bi-link-45deg me-2"></i>
                            Quick Links
                        </h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('pelatihan.usulan.index') }}">
                                    <i class="bi bi-chevron-right"></i>
                                    Usulan Pelatihan
                                </a></li>
                            <li><a href="{{ route('pelatihan.pendaftaran') }}">
                                    <i class="bi bi-chevron-right"></i>
                                    Pendaftaran
                                </a></li>
                            <li><a href="{{ route('pelatihan.laporan') }}">
                                    <i class="bi bi-chevron-right"></i>
                                    Laporan
                                </a></li>
                            <li><a href="{{ route('profile.pelatihan') }}">
                                    <i class="bi bi-chevron-right"></i>
                                    Profil Saya
                                </a></li>
                            <li><a href="#">
                                    <i class="bi bi-chevron-right"></i>
                                    Bantuan
                                </a></li>
                        </ul>
                    </div>
                </div>

                <!-- Services -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h5 class="section-title">
                            <i class="bi bi-gear-fill me-2"></i>
                            Layanan Kami
                        </h5>
                        <ul class="footer-links">
                            <li><a href="#">
                                    <i class="bi bi-chevron-right"></i>
                                    Pelatihan Daring
                                </a></li>
                            <li><a href="#">
                                    <i class="bi bi-chevron-right"></i>
                                    Pelatihan Tatap Muka
                                </a></li>
                            <li><a href="#">
                                    <i class="bi bi-chevron-right"></i>
                                    Sertifikasi
                                </a></li>
                            <li><a href="#">
                                    <i class="bi bi-chevron-right"></i>
                                    Konsultasi
                                </a></li>
                            <li><a href="#">
                                    <i class="bi bi-chevron-right"></i>
                                    Evaluasi Kinerja
                                </a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact & Newsletter -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h5 class="section-title">
                            <i class="bi bi-envelope-heart me-2"></i>
                            Hubungi Kami
                        </h5>
                        <div class="contact-info">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div class="contact-text">
                                    <span class="contact-label">Alamat</span>
                                    <span class="contact-value">Jl. Jend. Sudirman No.2, Kp. Baru, Kec. Ps. Kliwon, Kota
                                        Surakarta, Jawa Tengah 57111</span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div class="contact-text">
                                    <span class="contact-label">Telepon</span>
                                    <span class="contact-value">(0271) 638088</span>
                                </div>
                            </div>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                                <div class="contact-text">
                                    <span class="contact-label">Email</span>
                                    <span class="contact-value">info@bkpsdm.go.id</span>
                                </div>
                            </div>
                        </div>

                        <!-- Newsletter Subscription -->
                        <div class="newsletter-section">
                            <h6 class="newsletter-title">
                                <i class="bi bi-bell-fill me-2"></i>
                                Newsletter
                            </h6>
                            <p class="newsletter-desc">Dapatkan informasi pelatihan terbaru</p>
                            <form class="newsletter-form">
                                <div class="newsletter-input-group">
                                    <input type="email" class="newsletter-input" placeholder="Masukkan email Anda"
                                        required>
                                    <button type="submit" class="newsletter-btn">
                                        <i class="bi bi-send-fill"></i>
                                    </button>
                                </div>
                                <small class="newsletter-privacy">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Kami menghormati privasi Anda
                                </small>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <div class="footer-bottom-left">
                    <p class="copyright">
                        &copy; {{ date('Y') }} <strong>BKPSDM</strong>. Seluruh hak cipta dilindungi.
                    </p>
                </div>
                <div class="footer-bottom-right">
                    <div class="footer-bottom-links">
                        <a href="#" class="footer-bottom-link">Kebijakan Privasi</a>
                        <span class="footer-separator">|</span>
                        <a href="#" class="footer-bottom-link">Syarat & Ketentuan</a>
                        <span class="footer-separator">|</span>
                        <a href="#" class="footer-bottom-link">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .modern-footer {
        position: relative;
        background: var(--gradient-primary);
        color: white;
        overflow: hidden;
    }

    /* Wave Background */
    .footer-wave {
        position: absolute;
        top: -50px;
        left: 0;
        width: 100%;
        z-index: 1;
    }

    .footer-wave svg {
        width: 100%;
        height: 120px;
        fill: var(--bg-secondary);
    }

    /* Footer Content */
    .footer-content {
        position: relative;
        z-index: 2;
        padding: 4rem 0 2rem;
        background: linear-gradient(135deg, rgba(139, 157, 195, 0.95), rgba(107, 154, 161, 0.95));
    }

    /* Brand Section */
    .footer-brand {
        margin-bottom: 2rem;
    }

    .brand-logo {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .logo-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        border: 3px solid rgba(255, 255, 255, 0.3);
    }

    .brand-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .brand-subtitle {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
    }

    .brand-description {
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.6;
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }

    /* Social Links */
    .social-links {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .social-link {
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: var(--transition);
        font-size: 1.1rem;
    }

    .social-link:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.4);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Footer Sections */
    .footer-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .section-title i {
        color: rgba(255, 255, 255, 0.8);
    }

    /* Footer Links */
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0;
        transition: var(--transition);
        font-weight: 500;
    }

    .footer-links a:hover {
        color: white;
        padding-left: 0.5rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .footer-links a i {
        font-size: 0.75rem;
        opacity: 0.7;
        transition: var(--transition);
    }

    .footer-links a:hover i {
        opacity: 1;
        transform: translateX(2px);
    }

    /* Contact Info */
    .contact-info {
        margin-bottom: 2rem;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.25rem;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .contact-text {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .contact-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.7);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.05em;
    }

    .contact-value {
        color: white;
        font-weight: 500;
        line-height: 1.4;
    }

    /* Newsletter */
    .newsletter-section {
        background: rgba(255, 255, 255, 0.1);
        padding: 1.5rem;
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .newsletter-title {
        font-size: 1rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .newsletter-desc {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .newsletter-input-group {
        position: relative;
        margin-bottom: 0.75rem;
    }

    .newsletter-input {
        width: 100%;
        padding: 0.75rem 3.5rem 0.75rem 1rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 2rem;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-weight: 500;
        transition: var(--transition);
    }

    .newsletter-input::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .newsletter-input:focus {
        outline: none;
        border-color: rgba(255, 255, 255, 0.6);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
    }

    .newsletter-btn {
        position: absolute;
        right: 4px;
        top: 50%;
        transform: translateY(-50%);
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .newsletter-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-50%) scale(1.1);
    }

    .newsletter-privacy {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
    }

    /* Footer Bottom */
    .footer-bottom {
        background: rgba(44, 62, 80, 0.9);
        padding: 1.5rem 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .copyright {
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
        font-size: 0.875rem;
    }

    .footer-bottom-links {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .footer-bottom-link {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .footer-bottom-link:hover {
        color: white;
    }

    .footer-separator {
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.75rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .footer-content {
            padding: 3rem 0 1.5rem;
        }

        .brand-logo {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }
    }

    @media (max-width: 768px) {
        .footer-wave {
            top: -30px;
        }

        .footer-wave svg {
            height: 80px;
        }

        .footer-content {
            padding: 2.5rem 0 1rem;
        }

        .brand-logo {
            margin-bottom: 1rem;
        }

        .social-links {
            justify-content: center;
        }

        .footer-bottom-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .contact-item {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }

        .newsletter-section {
            padding: 1rem;
        }
    }

    @media (max-width: 480px) {
        .footer-content {
            padding: 2rem 0 1rem;
        }

        .brand-title {
            font-size: 1.5rem;
        }

        .section-title {
            font-size: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .footer-bottom-links {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
