<div class="sidebar">
    <img src="{{ asset('images/logoBkpsdm.svg') }}" class="mb-2 " width="200" alt="Logo BKPSDM">
    <ul class="nav flex-column list-unstyled">
        <li><a href="{{ route('dashboard.pelatihan.dashboard') }}" class="nav-link">
            <i class="bi bi-grid-fill nav-icon"></i> Dashboard
        </a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-link-45deg nav-icon"></i> Link Drive Kegiatan</a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-bar-chart-line nav-icon"></i> IP ASN <i
                    class="bi bi-chevron-down"></i></a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-people nav-icon"></i> Solo Wasis <i
                    class="bi bi-chevron-down"></i></a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-file-earmark-text nav-icon"></i> Brosur <i
                    class="bi bi-chevron-down"></i></a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-book nav-icon"></i> E-Katalog <i
                    class="bi bi-chevron-down"></i></a></li>

        <!-- AKPK Section -->
        <li>
            <a href="javascript:void(0);" class="nav-link" onclick="toggleSubmenu('akpk', 'icon-akpk')">
                <i class="bi bi-graph-up-arrow nav-icon"></i> 1.AKPK
                <i id="icon-akpk" class="bi bi-chevron-up"></i>
            </a>
            <ul id="akpk" class="submenu list-unstyled show">
                <li><a href="#" class="nav-link"><i class="bi bi-graph-up-arrow nav-icon"></i> Informasi AKPK</a>
                </li>

                <!-- Data Assesment -->
                <li>
                    <a href="javascript:void(0);" class="nav-link active-parent"
                        onclick="toggleSubmenu('dataAssesment', 'icon-assesment')">
                        <i class="bi bi-graph-up-arrow nav-icon"></i>Data Assesment
                        <i id="icon-assesment" class="bi bi-chevron-up"></i>
                    </a>
                    <ul id="dataAssesment" class="submenu list-unstyled show">
                        <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i> Self
                                Assesment</a></li>
                        <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i> Assesment
                                Atasan</a></li>
                        <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i> Evaluasi
                                Atasan</a></li>
                    </ul>
                </li>

                <!-- Data Usulan -->
                <li>
                    <a href="javascript:void(0);" class="nav-link active-parent"
                        onclick="toggleSubmenu('dataUsulan', 'icon-usulan')">
                        <i class="bi bi-graph-up-arrow nav-icon"></i> Data Usulan
                        <i id="icon-usulan" class="bi bi-chevron-up"></i>
                    </a>
                    <ul id="dataUsulan" class="submenu list-unstyled show">
                        <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Usul Pelatihan
                                Solowasis</a></li>
                        <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Usul Kebutuhan
                                Pelatihan</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="nav-link active-parent"
                        onclick="toggleSubmenu('manajemenData', 'icon-manajemen')">
                        <i class="bi bi-graph-up-arrow nav-icon"></i> Manajemen Data
                        <i id="icon-manajemen" class="bi bi-chevron-down"></i>
                    </a>
                    <ul id="manajemenData" class="submenu list-unstyled">
                        <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Pegawai</a>
                        </li>
                        <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Pertanyaan</a>
                        </li>
                        <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Jawaban</a>
                        </li>
                        <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Komentar</a>
                        </li>
                        <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Galeri</a></li>
                    </ul>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0);" class="nav-link active-parent" onclick="toggleSubmenu('pelatihan', 'icon-pelatihan')">
                <i class="bi bi-award-fill nav-icon"></i> 2.Pelatihan 
                <i id="icon-pelatihan" class="bi bi-chevron-up"></i>
            </a>
            <ul id="pelatihan" class="submenu list-unstyled show">
                <li>
                    <a href="{{ route('dashboard.pelatihan.info') }}" class="nav-link">
                        <i class="bi bi-list-check nav-icon"></i> Informasi Pelatihan
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.pelatihan.referensi') }}" class="nav-link">
                        <i class="bi bi-journal-bookmark nav-icon"></i> Referensi
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.pelatihan.nomenklatur') }}" class="nav-link">
                        <i class="bi bi-journal-bookmark nav-icon"></i> Nomenklatur
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.pelatihan.usulan') }}" class="nav-link">
                        <i class="bi bi-list-check nav-icon"></i> Usulan Pelatihan
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.pelatihan.usul-pelatihan') }}" class="nav-link">
                        <i class="bi bi-file-earmark-plus nav-icon"></i> Pendaftaran Pelatihan
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.pelatihan.laporan-pelatihan') }}" class="nav-link">
                        <i class="bi bi-file-text nav-icon"></i> Laporan Pelatihan
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ route('dashboard.pelatihan.proses-laporan') }}" class="nav-link">
                        <i class="bi bi-gear nav-icon"></i> Proses Laporan
                    </a>
                </li> --}}
            </ul>
        </li>

        <li>
            <a href="{{ route('dashboard.pelatihan.kepegawaian.index') }}" class="nav-link">
                <i class="bi bi-people-fill nav-icon"></i> Kepegawaian
            </a>
        </li>

        <li><a href="#" class="nav-link"><i class="bi bi-people-fill nav-icon"></i> 3.Alumni Pelatihan <i
                    class="bi bi-chevron-down"></i></a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-journal-richtext nav-icon"></i> Directory Pelatihan <i
                    class="bi bi-chevron-down"></i></a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-check2-square nav-icon"></i> Evaluasi Pasca Pelatihan
                <i class="bi bi-chevron-down"></i></a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-table nav-icon"></i> Pengaturan Tabel <i
                    class="bi bi-chevron-down"></i></a></li>
    </ul>

    <!-- User Profile -->
    {{-- <div class="user-profile d-flex align-items-center p-2" style="position: absolute; bottom: 0; width: 100%;">
        <div class="user-avatar me-2">
            <img src="{{ asset('images/Roket.png') }}" alt="User Avatar" class="img-fluid rounded-circle"
                width="20">
        </div>
        <div>
            <div class="user-name fw-bold">Naufal Dwi Saputro</div>
            <div class="user-role">Super Admin</div>
        </div>
        <div class="ms-auto user-actions">
            <a href="#" style="color: red;"><i class="bi bi-box-arrow-right" style="cursor: pointer;"></i></a>
        </div>
    </div> --}}
</div>

<script>
    function toggleSubmenu(id, iconId) {
        const submenu = document.getElementById(id);
        const icon = document.getElementById(iconId);
        const parentLink = icon.closest('.nav-link');

        submenu.classList.toggle('show');

        if (submenu.classList.contains('show')) {
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
            parentLink.classList.add('active-parent'); // Add active class to parent link
        } else {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
            parentLink.classList.remove('active-parent'); // Remove active class from parent link
        }
    }

    // Ensure all dropdowns are closed by default on page load
    document.addEventListener('DOMContentLoaded', () => {
        const submenus = document.querySelectorAll('.submenu');
        const icons = document.querySelectorAll('.nav-link i.bi-chevron-up, .nav-link i.bi-chevron-down');

        submenus.forEach(submenu => submenu.classList.remove('show'));
        icons.forEach(icon => {
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        });
    });
</script>

<style>
    .sidebar {
        background: linear-gradient(165deg, #1e1e2d 0%, #1b1b28 100%);
        color: #92929f;
        width: 280px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.075);
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #2d3748 #1e1e2d;
        z-index: 1500;
    }

    .sidebar img {
        padding: 1.25rem;
        width: 100%;
        max-width: 180px;
        margin: 0 auto;
        display: block;
        opacity: 0.95;
    }

    .nav-link {
        color: #92929f;
        padding: 0.675rem 1.5rem;
        display: flex;
        align-items: center;
        font-weight: 500;
        font-size: 0.875rem;
        letter-spacing: 0.01em;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.03);
        color: #fff;
        border-left: 3px solid #009ef7;
    }

    .nav-link.active-parent {
        background: rgba(0, 158, 247, 0.05);
        color: #fff;
        border-left: 3px solid #009ef7;
    }

    .nav-icon {
        font-size: 1.25rem;
        width: 24px;
        margin-right: 0.875rem;
        color: #565674;
        transition: color 0.2s ease;
    }

    .nav-link:hover .nav-icon,
    .nav-link.active-parent .nav-icon {
        color: #009ef7;
    }

    .submenu {
        background: rgba(0, 0, 0, 0.15);
        overflow: hidden;
        max-height: 0;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .submenu.show {
        max-height: 1000px;
        border-left: 1px solid rgba(255, 255, 255, 0.05);
        margin-left: 3px;
    }

    .submenu .nav-link {
        padding: 0.5rem 1rem 0.5rem 3.75rem;
        font-size: 0.813rem;
        position: relative;
    }

    .submenu .nav-link::before {
        content: '';
        position: absolute;
        left: 2.5rem;
        top: 50%;
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #565674;
        transform: translateY(-50%);
        transition: background 0.2s ease;
    }

    .submenu .nav-link:hover::before,
    .submenu .nav-link.active::before {
        background: #009ef7;
    }

    .bi-chevron-down,
    .bi-chevron-up {
        margin-left: auto;
        font-size: 0.875rem;
        opacity: 0.5;
        transition: all 0.3s ease;
    }

    .nav-link:hover .bi-chevron-down,
    .nav-link:hover .bi-chevron-up,
    .nav-link.active-parent .bi-chevron-down,
    .nav-link.active-parent .bi-chevron-up {
        opacity: 1;
        color: #009ef7;
    }

    /* Scrollbar Styling */
    .sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: #1e1e2d;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background-color: rgba(255, 255, 255, 0.15);
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.show {
            transform: translateX(0);
        }
    }
</style>
