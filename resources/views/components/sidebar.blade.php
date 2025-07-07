<aside class="sidebar dark-theme" id="sidebar">
    <!-- Brand Logo + Toggle Button -->
    <div class="sidebar-header d-flex align-items-center justify-content-between px-3 py-3">
        <div class="logo-container">
            <img src="{{ asset('images/logoBkpsdm.svg') }}" class="sidebar-logo" alt="Logo BKPSDM">
        </div>
        {{-- <button id="sidebarToggle" class="btn btn-sidebar-toggle" aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button> --}}
    </div>

    <!-- Sidebar Menu -->
    <nav class="sidebar-nav">
        <ul class="nav flex-column list-unstyled">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ request()->routeIs('dashboard.pelatihan') ? '#' : route('dashboard.pelatihan') }}"
                    class="nav-link {{ request()->routeIs('dashboard.pelatihan') ? 'active' : '' }}"
                    data-tooltip="Dashboard">
                    <i class="bi bi-speedometer2 nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            @if (auth()->user()->hasRole('admin'))
                <!-- Admin Section -->
                <li class="nav-section">
                    <span class="nav-section-title">Manajemen Admin</span>
                </li>

                <li class="nav-item">
                    <a href="{{ request()->routeIs('dashboard.pelatihan.nomenklaturadmin') ? '#' : route('dashboard.pelatihan.nomenklaturadmin') }}"
                        class="nav-link {{ request()->routeIs('dashboard.pelatihan.nomenklaturadmin.*') ||
                        request()->routeIs('dashboard.pelatihan.nomenklaturadmin')
                            ? 'active'
                            : '' }}"
                        data-tooltip="Usulan Nomenklatur">
                        <i class="bi bi-list-ul nav-icon"></i>
                        <span class="nav-text">Usulan Nomenklatur</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ request()->routeIs('dashboard.pelatihan.usulan') ? '#' : route('dashboard.pelatihan.usulan') }}"
                        class="nav-link {{ request()->routeIs('dashboard.pelatihan.usulan.*') || request()->routeIs('dashboard.pelatihan.usulan')
                            ? 'active'
                            : '' }}"
                        data-tooltip="Usulan Pelatihan">
                        <i class="bi bi-lightbulb nav-icon"></i>
                        <span class="nav-text">Usulan Pelatihan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ request()->routeIs('dashboard.pelatihan.pendaftaran.cetak-usulan') ? '#' : route('dashboard.pelatihan.pendaftaran.cetak-usulan') }}"
                        class="nav-link {{ request()->routeIs('dashboard.pelatihan.pendaftaran.cetak-usulan') ? 'active' : '' }}"
                        data-tooltip="Cetak Usulan Pelatihan">
                        <i class="bi bi-printer nav-icon"></i>
                        <span class="nav-text">Cetak Usulan Pelatihan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ request()->routeIs('dashboard.pelatihan.dokumen') ? '#' : route('dashboard.pelatihan.dokumen') }}"
                        class="nav-link {{ request()->routeIs('dashboard.pelatihan.dokumen.*') || request()->routeIs('dashboard.pelatihan.dokumen')
                            ? 'active'
                            : '' }}"
                        data-tooltip="Upload Dokumen Usulan Pelatihan">
                        <i class="bi bi-upload nav-icon"></i>
                        <span class="nav-text">Upload Dokumen Usulan Pelatihan</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole('superadmin'))
                <!-- Super Admin Section -->
                <li class="nav-section">
                    <span class="nav-section-title">Super Admin</span>
                </li>

                <li class="nav-item">
                    <a href="{{ request()->is('dashboard/pelatihan/pengaturandasar/*') ? '#' : route('dashboard.pelatihan.pengaturandasar') }}"
                        class="nav-link {{ request()->is('dashboard/pelatihan/pengaturandasar/*') ? 'active' : '' }}"
                        data-tooltip="Pengaturan Dasar">
                        <i class="bi bi-gear nav-icon"></i>
                        <span class="nav-text">Pengaturan Dasar</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ request()->routeIs('dashboard.pelatihan.user') ? '#' : route('dashboard.pelatihan.user') }}"
                        class="nav-link {{ request()->routeIs('dashboard.pelatihan.user.*') ? 'active' : '' }}"
                        data-tooltip="History Pegawai">
                        <i class="bi bi-clock-history nav-icon"></i>
                        <span class="nav-text">History Pegawai</span>
                    </a>
                </li>

                <!-- Pengaturan Pelatihan -->
                <li class="nav-item has-submenu">
                    <a href="javascript:void(0);"
                        class="nav-link {{ ((request()->routeIs('dashboard.pelatihan.info')
                                    ? 'active-parent'
                                    : '' || request()->routeIs('dashboard.pelatihan.tersedia'))
                                ? 'active-parent'
                                : '' || request()->routeIs('dashboard.pelatihan.usulan'))
                            ? 'active-parent'
                            : '' }}"
                        onclick="toggleSubmenu('pengaturan-pelatihan', 'icon-pengaturan-pelatihan')"
                        data-tooltip="Pengaturan Pelatihan">
                        <i class="bi bi-gear nav-icon"></i>
                        <span class="nav-text">Pengaturan Pelatihan</span>
                        <i id="icon-pengaturan-pelatihan" class="bi bi-chevron-down submenu-arrow"></i>
                    </a>
                    <ul id="pengaturan-pelatihan"
                        class="submenu list-unstyled {{ ((request()->routeIs('dashboard.pelatihan.info')
                                    ? 'show'
                                    : '' || request()->routeIs('dashboard.pelatihan.tersedia'))
                                ? 'show'
                                : '' || request()->routeIs('dashboard.pelatihan.usulan'))
                            ? 'show'
                            : '' }}">
                        <li class="nav-item">
                            <a href="{{ request()->routeIs('dashboard.pelatihan.info') ? '#' : route('dashboard.pelatihan.info') }}"
                                class="nav-link {{ request()->routeIs('dashboard.pelatihan.info.*') ? 'active' : '' }}"
                                data-tooltip="Pelatihan Info">
                                <i class="bi bi-info-circle nav-icon"></i>
                                <span class="nav-text">Pelatihan Info</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ request()->routeIs('dashboard.pelatihan.tersedia') ? '#' : route('dashboard.pelatihan.tersedia') }}"
                                class="nav-link {{ request()->routeIs('dashboard.pelatihan.tersedia.*') ? 'active' : '' }}"
                                data-tooltip="Pelatihan Tersedia">
                                <i class="bi bi-calendar-check nav-icon"></i>
                                <span class="nav-text">Pelatihan Tersedia</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ request()->routeIs('dashboard.pelatihan.usulan') ? '#' : route('dashboard.pelatihan.usulan') }}"
                                class="nav-link {{ request()->routeIs('dashboard.pelatihan.usulan.*') ? 'active' : '' }}"
                                data-tooltip="Pelatihan Khusus">
                                <i class="bi bi-lightbulb nav-icon"></i>
                                <span class="nav-text">Pelatihan Khusus</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Usulan Pelatihan -->
                <li class="nav-item has-submenu">
                    <a href="javascript:void(0);"
                        class="nav-link {{ ((request()->routeIs('dashboard.pelatihan.pendaftaran')
                                    ? 'active-parent'
                                    : '' || request()->routeIs('dashboard.pelatihan.dokumen'))
                                ? 'active-parent'
                                : '' || request()->routeIs('dashboard.pelatihan.rekapitulasi'))
                            ? 'active-parent'
                            : '' }}"
                        onclick="toggleSubmenu('pelatihan', 'icon-pelatihan')" data-tooltip="Usulan Pelatihan">
                        <i class="bi bi-award nav-icon"></i>
                        <span class="nav-text">Usulan Pelatihan</span>
                        <i id="icon-pelatihan" class="bi bi-chevron-down submenu-arrow"></i>
                    </a>
                    <ul id="pelatihan"
                        class="submenu list-unstyled {{ ((request()->routeIs('dashboard.pelatihan.pendaftaran')
                                    ? 'show'
                                    : '' || request()->routeIs('dashboard.pelatihan.dokumen'))
                                ? 'show'
                                : '' || request()->routeIs('dashboard.pelatihan.rekapitulasi'))
                            ? 'show'
                            : '' }}">
                        <li class="nav-item">
                            <a href="{{ request()->routeIs('dashboard.pelatihan.pendaftaran') ? '#' : route('dashboard.pelatihan.pendaftaran') }}"
                                class="nav-link {{ request()->routeIs('dashboard.pelatihan.pendaftaran.*') ? 'active' : '' }}"
                                data-tooltip="Data Usulan">
                                <i class="bi bi-journal-plus nav-icon"></i>
                                <span class="nav-text">Data Usulan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ request()->routeIs('dashboard.pelatihan.dokumen') ? '#' : route('dashboard.pelatihan.dokumen') }}"
                                class="nav-link {{ request()->routeIs('dashboard.pelatihan.dokumen.*') ? 'active' : '' }}"
                                data-tooltip="Dokumen Usulan Pelatihan">
                                <i class="bi bi-file-earmark-text nav-icon"></i>
                                <span class="nav-text">Dokumen Usulan Pelatihan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ request()->routeIs('dashboard.pelatihan.rekapitulasi') ? '#' : route('dashboard.pelatihan.rekapitulasi') }}"
                                class="nav-link {{ request()->routeIs('dashboard.pelatihan.rekapitulasi.*') ? 'active' : '' }}"
                                data-tooltip="Rekapitulasi Usulan Pelatihan">
                                <i class="bi bi-file-earmark-text nav-icon"></i>
                                <span class="nav-text">Rekapitulasi Usulan Pelatihan</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Directory Laporan -->
                <li class="nav-item has-submenu">
                    <a href="javascript:void(0);"
                        class="nav-link {{ ((request()->routeIs('dashboard.pelatihan.laporan')
                                    ? 'active-parent'
                                    : '' || request()->routeIs('dashboard.pelatihan.laporan'))
                                ? 'active-parent'
                                : '' || request()->routeIs('dashboard.pelatihan.laporan'))
                            ? 'active-parent'
                            : '' }}"
                        onclick="toggleSubmenu('directory', 'icon-directory')" data-tooltip="Directory Laporan">
                        <i class="bi bi-journal-richtext nav-icon"></i>
                        <span class="nav-text">Directory Laporan</span>
                        <i id="icon-directory" class="bi bi-chevron-down submenu-arrow"></i>
                    </a>
                    <ul id="directory"
                        class="submenu list-unstyled {{ ((request()->routeIs('dashboard.pelatihan.laporan')
                                    ? 'show'
                                    : '' || request()->routeIs('dashboard.pelatihan.laporan'))
                                ? 'show'
                                : '' || request()->routeIs('dashboard.pelatihan.laporan'))
                            ? 'show'
                            : '' }}">
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-tooltip="Informasi Directory">
                                <i class="bi bi-folder2-open nav-icon"></i>
                                <span class="nav-text">Informasi Directory</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ request()->routeIs('dashboard.pelatihan.laporan') ? '#' : route('dashboard.pelatihan.laporan') }}"
                                class="nav-link {{ request()->routeIs('dashboard.pelatihan.laporan.*') ? 'active' : '' }}"
                                data-tooltip="Data Directory Laporan">
                                <i class="bi bi-archive-fill nav-icon"></i>
                                <span class="nav-text">Data Directory Lap.</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Alumni Pelatihan -->
                <li class="nav-item has-submenu">
                    <a href="javascript:void(0);"
                        class="nav-link {{ ((request()->routeIs('dashboard.pelatihan.alumni.*')
                                    ? 'active-parent'
                                    : '' || request()->routeIs('dashboard.pelatihan.alumni'))
                                ? 'active-parent'
                                : '' || request()->routeIs('dashboard.pelatihan.alumni'))
                            ? 'active-parent'
                            : '' }}"
                        onclick="toggleSubmenu('alumni', 'icon-alumni')" data-tooltip="Alumni Pelatihan">
                        <i class="bi bi-person-lines-fill nav-icon"></i>
                        <span class="nav-text">Alumni Pelatihan</span>
                        <i id="icon-alumni" class="bi bi-chevron-down submenu-arrow"></i>
                    </a>
                    <ul id="alumni"
                        class="submenu list-unstyled {{ ((request()->routeIs('dashboard.pelatihan.alumni')
                                    ? 'show'
                                    : '' || request()->routeIs('dashboard.pelatihan.alumni'))
                                ? 'show'
                                : '' || request()->routeIs('dashboard.pelatihan.alumni'))
                            ? 'show'
                            : '' }}">
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-tooltip="Informasi Alumni">
                                <i class="bi bi-person-vcard-fill nav-icon"></i>
                                <span class="nav-text">Informasi Alumni</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ request()->routeIs('dashboard.pelatihan.alumni.*') ? '#' : route('dashboard.pelatihan.alumni') }}"
                                class="nav-link {{ request()->routeIs('dashboard.pelatihan.alumni.*') ? 'active' : '' }}"
                                data-tooltip="Data Alumni">
                                <i class="bi bi-people-fill nav-icon"></i>
                                <span class="nav-text">Data Alumni</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>

    <!-- Footer -->
    <div class="sidebar-footer px-3 py-2">
        <div class="d-flex align-items-center justify-between w-full">
            <div class="footer-content">
                <div class="user-avatar">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="user-role">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Enhanced sidebar functionality
        function toggleSubmenu(id, iconId) {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('collapsed')) return; // Don't allow submenu toggle when collapsed

            const submenu = document.getElementById(id);
            const icon = document.getElementById(iconId);
            const parentLink = icon.closest('.nav-link');

            if (!submenu || !icon || !parentLink) return;

            submenu.classList.toggle('show');

            if (submenu.classList.contains('show')) {
                icon.classList.remove('bi-chevron-down');
                icon.classList.add('bi-chevron-up');
                parentLink.classList.add('active-parent');

                // Animate submenu opening
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
            } else {
                icon.classList.remove('bi-chevron-up');
                icon.classList.add('bi-chevron-down');
                parentLink.classList.remove('active-parent');

                // Animate submenu closing
                submenu.style.maxHeight = '0px';
            }
        }

        // Tooltip functionality for collapsed sidebar
        function initTooltips() {
            const navLinks = document.querySelectorAll('.nav-link[data-tooltip]');

            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function(e) {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar.classList.contains('collapsed')) {
                        const tooltip = e.target.getAttribute('data-tooltip');
                        if (tooltip) {
                            showTooltip(e.target.closest('.nav-link'), tooltip);
                        }
                    }
                });

                link.addEventListener('mouseleave', function() {
                    hideTooltip();
                });
            });
        }

        function showTooltip(element, text) {
            // Remove existing tooltip
            hideTooltip();

            const tooltip = document.createElement('div');
            tooltip.className = 'sidebar-tooltip';
            tooltip.textContent = text;
            tooltip.setAttribute('data-tooltip-active', 'true');
            document.body.appendChild(tooltip);

            const rect = element.getBoundingClientRect();
            const tooltipRect = tooltip.getBoundingClientRect();

            // Position tooltip to the right of the element
            let left = rect.right + 15;
            let top = rect.top + (rect.height / 2) - (tooltipRect.height / 2);

            // Ensure tooltip doesn't go off screen
            if (left + tooltipRect.width > window.innerWidth) {
                left = rect.left - tooltipRect.width - 15;
            }
            if (top < 10) top = 10;
            if (top + tooltipRect.height > window.innerHeight - 10) {
                top = window.innerHeight - tooltipRect.height - 10;
            }

            tooltip.style.left = left + 'px';
            tooltip.style.top = top + 'px';

            // Show tooltip with animation
            requestAnimationFrame(() => {
                tooltip.classList.add('show');
            });
        }

        function hideTooltip() {
            const tooltip = document.querySelector('.sidebar-tooltip[data-tooltip-active]');
            if (tooltip) {
                tooltip.classList.remove('show');
                setTimeout(() => {
                    if (tooltip.parentNode) {
                        tooltip.parentNode.removeChild(tooltip);
                    }
                }, 200);
            }
        }

        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            // Restore sidebar state
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            const theme = localStorage.getItem('theme') || 'dark';

            // Apply theme
            document.body.classList.add(theme + '-theme');
            const themeIcon = document.querySelector('.footer-actions i');
            if (themeIcon) {
                themeIcon.classList.remove('bi-sun');
                themeIcon.classList.add('bi-moon');
            }

            // Apply collapsed state
            if (isCollapsed) {
                const sidebar = document.getElementById('sidebar');

                sidebar.classList.add('collapsed');
                document.body.classList.add('sidebar-collapsed');
            }

            // Setup event listeners
            const toggleBtn = document.getElementById('sidebarToggle');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', toggleSidebar);
            }

            // Initialize tooltips
            initTooltips();

            // Auto-expand active submenus only if not collapsed
            if (!isCollapsed) {
                document.querySelectorAll('.submenu.show').forEach(submenu => {
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';

                    const parentLink = document.querySelector(`[onclick*="${submenu.id}"]`);
                    if (parentLink) {
                        const match = parentLink.getAttribute('onclick').match(/'([^']+)'/g);
                        if (match && match[1]) {
                            const iconId = match[1].replace(/'/g, '');
                            const icon = document.getElementById(iconId);

                            if (icon) {
                                parentLink.classList.add('active-parent');
                                icon.classList.remove('bi-chevron-down');
                                icon.classList.add('bi-chevron-up');
                            }
                        }
                    }
                });
            }

            // Add ripple effect to nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Don't add ripple to submenu toggles
                    if (this.getAttribute('onclick') && this.getAttribute('onclick').includes(
                            'toggleSubmenu')) {
                        return;
                    }

                    const ripple = document.createElement('span');
                    ripple.className = 'ripple';
                    this.appendChild(ripple);

                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';

                    setTimeout(() => {
                        if (ripple.parentNode) {
                            ripple.parentNode.removeChild(ripple);
                        }
                    }, 600);
                });
            });

            // Handle mobile responsiveness
            function handleResize() {
                const sidebar = document.getElementById('sidebar');
                const isMobile = window.innerWidth <= 768;

                if (isMobile) {
                    sidebar.classList.add('mobile');
                    document.body.classList.remove('sidebar-collapsed');
                } else {
                    sidebar.classList.remove('mobile');
                    if (isCollapsed) {
                        document.body.classList.add('sidebar-collapsed');
                    }
                }
            }

            // Initial resize check
            handleResize();

            // Listen for resize events
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(handleResize, 100);
            });
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            if (window.innerWidth <= 768 &&
                sidebar &&
                sidebar.classList.contains('show') &&
                !sidebar.contains(e.target) &&
                !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('show');
                document.body.classList.remove('sidebar-open');
            }
        });

        // Mobile sidebar toggle
        function toggleMobileSidebar() {
            if (window.innerWidth <= 768) {
                const sidebar = document.getElementById('sidebar');
                const body = document.body;

                sidebar.classList.toggle('show');
                body.classList.toggle('sidebar-open');
            } else {
                toggleSidebar();
            }
        }

        // Update the mobile toggle function
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('sidebarToggle');
            if (toggleBtn) {
                toggleBtn.removeEventListener('click', toggleSidebar);
                toggleBtn.addEventListener('click', toggleMobileSidebar);
            }
        });
    </script>

    <style>
        /* CSS Custom Properties for theming */
        :root {
            /* --sidebar-width: 280px; */
            --sidebar-collapsed-width: 70px;
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --sidebar-transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Dark theme variables */
        .dark-theme {
            --sidebar-bg: linear-gradient(165deg, #1e1e2d 0%, #1b1b28 100%);
            --sidebar-text: #e5e7eb;
            --sidebar-text-secondary: #9ca3af;
            --sidebar-hover-bg: rgba(59, 130, 246, 0.1);
            --sidebar-active-bg: rgba(59, 130, 246, 0.15);
            --sidebar-border: rgba(255, 255, 255, 0.1);
            --sidebar-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Light theme variables */
        .light-theme {
            --sidebar-bg: linear-gradient(165deg, #ffffff 0%, #f8fafc 100%);
            --sidebar-text: #374151;
            --sidebar-text-secondary: #6b7280;
            --sidebar-hover-bg: rgba(59, 130, 246, 0.05);
            --sidebar-active-bg: rgba(59, 130, 246, 0.1);
            --sidebar-border: rgba(0, 0, 0, 0.1);
            --sidebar-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Base Sidebar Styles */
        .sidebar {
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: var(--sidebar-transition);
            box-shadow: var(--sidebar-shadow);
            overflow: hidden;
            z-index: 1500;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
            border-right: 1px solid var(--sidebar-border);
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        /* Header Section */
        .sidebar-header {
            border-bottom: 1px solid var(--sidebar-border);
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
            min-height: 80px;
            max-height: 80px;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            min-width: 0;
        }

        .sidebar-logo {
            width: 200px;
            height: 50px;
            object-fit: contain;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .sidebar.collapsed .sidebar-logo {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        .btn-sidebar-toggle {
            width: 40px;
            height: 40px;
            border: 1px solid var(--sidebar-border);
            background: rgba(255, 255, 255, 0.05);
            color: var(--sidebar-text);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            flex-shrink: 0;
        }

        .btn-sidebar-toggle:hover {
            background: var(--sidebar-hover-bg);
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: scale(1.05);
        }

        .btn-sidebar-toggle:active {
            transform: scale(0.95);
        }

        /* User Profile Section */
        .user-profile {
            border-bottom: 1px solid var(--sidebar-border);
            background: rgba(255, 255, 255, 0.02);
            transition: all 0.3s ease;
            flex-shrink: 0;
            overflow: hidden;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            flex-shrink: 0;
        }

        .user-avatar i {
            font-size: 1.5rem;
            color: white;
        }

        .user-info {
            flex: 1;
            transition: all 0.3s ease;
            min-width: 0;
            overflow: hidden;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--sidebar-text);
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--sidebar-text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar.collapsed .user-info {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        /* Navigation */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(59, 130, 246, 0.3) transparent;
            width: 100%;
        }

        .sidebar.collapsed .sidebar-nav {
            overflow-y: auto;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.3);
            border-radius: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.5);
        }

        /* Hide scrollbar when collapsed */
        .sidebar.collapsed .sidebar-nav::-webkit-scrollbar {
            display: none;
        }

        .sidebar.collapsed .sidebar-nav {
            scrollbar-width: none;
        }

        /* Navigation Sections */
        .nav-section {
            margin: 20px 0 8px 0;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--sidebar-text-secondary);
            padding: 0 24px;
            position: relative;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
        }

        .nav-section-title::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 24px;
            right: 24px;
            height: 1px;
            background: linear-gradient(90deg, var(--primary-color), transparent);
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .nav-section {
            display: none;
        }

        /* Navigation Items */
        .nav-item {
            transition: all 0.3s ease;
            width: 90%;
            margin: 2px 8px;
        }

        .sidebar.collapsed .nav-item {
            margin: 4px 8px;
        }

        .nav-link {
            color: var(--sidebar-text);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
            min-height: 48px;
            white-space: nowrap;
        }

        .sidebar.collapsed .nav-link {
            padding: 12px;
            justify-content: center;
            min-height: 44px;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            opacity: 0;
            transition: all 0.3s ease;
            z-index: -1;
        }

        .nav-link:hover {
            background: var(--sidebar-hover-bg);
            color: var(--primary-color);
            transform: translateX(4px);
            border-color: rgba(59, 130, 246, 0.3);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        .sidebar.collapsed .nav-link:hover {
            transform: scale(1.05);
        }

        .nav-link.active,
        .nav-link.active-parent {
            background: var(--sidebar-active-bg);
            color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.25);
            font-weight: 600;
        }

        .nav-link.active::before {
            opacity: 0.1;
        }

        /* Navigation Icons */
        .nav-icon {
            font-size: 1.25rem;
            width: 24px;
            min-width: 24px;
            margin-right: 12px;
            color: currentColor;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar.collapsed .nav-icon {
            margin-right: 0;
        }

        .nav-text {
            flex: 1;
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
        }

        /* Submenu Arrow */
        .submenu-arrow {
            margin-left: auto;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            color: var(--sidebar-text-secondary);
            flex-shrink: 0;
        }

        .nav-link:hover .submenu-arrow,
        .nav-link.active-parent .submenu-arrow {
            color: var(--primary-color);
            transform: scale(1.1);
        }

        .sidebar.collapsed .submenu-arrow {
            display: none;
        }

        /* Submenus */
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            /* background: rgba(0, 0, 0, 0.1); */
            margin: 4px 0;
            /* border-radius: 8px; */
            /* border-left: 2px solid var(--primary-color); */
        }

        .submenu.show {
            max-height: 500px;
        }

        .submenu .nav-item {
            margin: 0;
        }

        .submenu .nav-link {
            padding: 10px 16px 10px 40px;
            font-size: 0.813rem;
            min-height: 40px;
            border-radius: 8px;
            margin: 2px 8px;
            position: relative;
        }

        .submenu .nav-link::after {
            content: '';
            position: absolute;
            left: 20px;
            top: 50%;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--sidebar-text-secondary);
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }

        .submenu .nav-link:hover::after,
        .submenu .nav-link.active::after {
            background: var(--primary-color);
            transform: translateY(-50%) scale(1.3);
        }

        .sidebar.collapsed .submenu {
            display: none;
        }

        /* Hide submenus for collapsed items */
        .sidebar.collapsed .has-submenu {
            position: relative;
        }

        /* Ripple Effect */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.3);
            transform: scale(0);
            animation: ripple-animation 0.6s ease-out;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Footer */
        .sidebar-footer {
            border-top: 1px solid var(--sidebar-border);
            background: rgba(255, 255, 255, 0.02);
            padding: 16px 20px;
            margin-top: auto;
            flex-shrink: 0;
            overflow: hidden;
        }

        .sidebar.collapsed .sidebar-footer {
            padding: 16px 8px;
        }

        .footer-content {
            display: flex;
            width: fit-content;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }

        .footer-content small {
            color: var(--sidebar-text-secondary);
            font-size: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .footer-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .footer-actions .btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--sidebar-border);
            background: rgba(255, 255, 255, 0.05);
            color: var(--sidebar-text-secondary);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-actions .btn:hover {
            background: var(--sidebar-hover-bg);
            color: var(--primary-color);
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        .sidebar.collapsed .footer-content {
            flex-direction: column;
            gap: 8px;
        }

        .sidebar.collapsed .footer-content small {
            display: none;
        }

        /* Tooltips for collapsed sidebar */
        .sidebar-tooltip {
            position: fixed;
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            white-space: nowrap;
            z-index: 2000;
            opacity: 0;
            transform: translateY(-50%);
            transition: opacity 0.2s ease;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            max-width: 200px;
            word-wrap: break-word;
        }

        .sidebar-tooltip.show {
            opacity: 1;
        }

        .sidebar-tooltip::before {
            content: '';
            position: absolute;
            left: -4px;
            top: 50%;
            transform: translateY(-50%);
            border: 4px solid transparent;
            border-right-color: rgba(0, 0, 0, 0.9);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar.mobile {
                position: fixed;
                z-index: 9999;
            }

            body.sidebar-open::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1400;
                backdrop-filter: blur(4px);
            }

            /* Force expanded state on mobile */
            .sidebar.mobile .nav-text,
            .sidebar.mobile .logo-text,
            .sidebar.mobile .user-info,
            .sidebar.mobile .nav-section-title,
            .sidebar.mobile .footer-content small {
                opacity: 1 !important;
                width: auto !important;
                overflow: visible !important;
            }

            .sidebar.mobile .nav-icon {
                margin-right: 12px !important;
            }

            .sidebar.mobile .submenu-arrow {
                display: block !important;
            }
        }

        /* Body adjustments for collapsed sidebar */
        body.sidebar-collapsed {
            padding-left: var(--sidebar-collapsed-width);
        }

        body:not(.sidebar-collapsed) {
            padding-left: var(--sidebar-width);
        }

        @media (max-width: 768px) {

            body.sidebar-collapsed,
            body:not(.sidebar-collapsed) {
                padding-left: 0;
            }
        }

        /* Animations */
        @keyframes slideInFromLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .nav-item {
            animation: slideInFromLeft 0.3s ease forwards;
        }

        .nav-item:nth-child(1) {
            animation-delay: 0.05s;
        }

        .nav-item:nth-child(2) {
            animation-delay: 0.1s;
        }

        .nav-item:nth-child(3) {
            animation-delay: 0.15s;
        }

        .nav-item:nth-child(4) {
            animation-delay: 0.2s;
        }

        .nav-item:nth-child(5) {
            animation-delay: 0.25s;
        }

        /* Focus states for accessibility */
        .nav-link:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        .btn-sidebar-toggle:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .sidebar {
                border-right: 2px solid currentColor;
            }

            .nav-link {
                border: 1px solid transparent;
            }

            .nav-link:hover,
            .nav-link.active {
                border-color: currentColor;
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation: none !important;
                transition: none !important;
            }

            .sidebar {
                transition: width 0.1s ease !important;
            }
        }

        /* Prevent text selection on interactive elements */
        .nav-link,
        .btn-sidebar-toggle {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        /* Ensure proper layering */
        .sidebar {
            will-change: width;
        }

        .nav-link {
            will-change: transform;
        }
    </style>
</aside>
