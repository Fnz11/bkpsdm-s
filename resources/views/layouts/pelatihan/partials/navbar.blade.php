<style>
    .dropdown {
        position: relative;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    .dropdown-menu {
        background: var(--header-bg);
        border: 1px solid var(--border-light);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        padding: 0.5rem 0;
    }

    .dropdown-item {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-color);
        text-decoration: none;
        padding: 0.5rem 1.25rem;
        display: block;
        transition: background-color 0.2s ease;
    }

    .dropdown-item:hover {
        background: var(--border-light);
        color: var(--accent-color);
    }

    .dropdown-menu li {
        list-style: none;
    }

    /* Profile Popup Styles */
    .profile-trigger {
        position: relative;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .profile-trigger img {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        border: 2px solid var(--border-light);
        transition: all 0.3s ease;
        object-fit: cover;
    }

    .profile-trigger:hover img {
        border-color: var(--accent-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
    }

    #profile-popup {
        position: absolute;
        right: 0;
        top: calc(100% - .75rem);
        width: 280px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        border: 1px solid var(--border-light);
        box-shadow:
            0 4px 6px -1px rgba(0, 0, 0, 0.1),
            0 2px 4px -1px rgba(0, 0, 0, 0.06),
            0 0 0 1px rgba(255, 255, 255, 0.1);
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px) scale(0.98);
        transition: all 0.2s ease;
        padding: 1.25rem;
    }

    #profile-popup.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    .profile-header {
        text-align: center;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--border-light);
        /* margin-bottom: 1.25rem; */
    }

    .profile-avatar {
        width: 80p !important;
        height: 80px !important;
        aspect-ratio: 1/1;
        border-radius: 24px;
        margin-bottom: 1rem;
        border: 3px solid var(--accent-color);
        padding: 3px;
        background: var(--bg-white);
    }

    .profile-name {
        font-family: 'Familjen Grotesk', sans-serif;
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-color);
        margin: 0;
        line-height: 1.4;
    }

    .profile-position {
        font-size: 0.875rem;
        color: var(--text-light);
        margin-top: 0.25rem;
    }

    .profile-actions {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .profile-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        width: 100%;
        text-align: left;
        text-decoration: none;
    }

    .profile-btn i {
        font-size: 1.125rem;
    }


    .btn-dashboard {
        background: var(--gradient-accent);
        color: var(--bg-white);
    }

    .btn-dashboard:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);
    }

    .btn-profile {
        background: var(--bg-secondary);
        color: var(--text-color);
    }

    .btn-profile:hover {
        background: var(--border-light);
        transform: translateY(-2px);
    }

    .btn-logout {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .btn-logout:hover {
        background: rgba(239, 68, 68, 0.15);
        transform: translateY(-2px);
    }

    .profile-menu {
        display: flex;
        gap: 0.75rem;
        margin-top: 0.75rem;
    }

    .profile-menu .profile-btn {
        flex: 1;
    }

    .main-header {
        background: var(--header-bg);
        height: var(--header-height);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        padding: 0 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: background-color 0.3s ease;
    }

    .main-header.scrolled {
        background: var(--bg-white);
        border-bottom: 1px solid var(--border-light);
        box-shadow: var(--shadow-sm);
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .logo-img {
        height: 2.75rem;
        width: auto;
    }

    .logo-text {
        height: 1.75rem;
        width: auto;
    }

    .main-nav {
        display: flex;
        gap: 2.5rem;
        list-style: none;
    }

    .nav-link {
        color: var(--text-color);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.5rem 0;
        position: relative;
        transition: var(--transition-fast);
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gradient-accent);
        transition: var(--transition-normal);
        border-radius: 2px;
    }

    .nav-link:hover {
        color: var(--secondary-color);
    }

    .nav-link:hover::after,
    .nav-link.active::after {
        width: 100%;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.5rem;
        background: var(--bg-secondary);
        border-radius: 1rem;
        transition: var(--transition-normal);
    }

    .user-profile:hover {
        background: var(--border-light);
        transform: translateY(-1px);
    }

    .user-img {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        object-fit: cover;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .user-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-color);
    }

    .user-position {
        font-size: 0.8rem;
        color: var(--text-light);
    }


    @media (max-width: 768px) {
        .main-header {
            padding: 0 1rem;
        }

        .main-nav {
            display: none;
        }

        .hero-title {
            font-size: 3rem;
        }
    }

    .login-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 500;
        background: var(--gradient-accent);
        color: var(--bg-white);
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);
    }

    .login-btn i {
        font-size: 1.125rem;
    }
</style>

<!-- NAVBAR -->
<header class="main-header">
    <div class="logo-container">
        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/3d7d95f3e27be9563e72c788b4df012492ef3a2d?placeholderIfAbsent=true"
            alt="Logo" class="logo-img" />
        <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/46c39b9ec5d6cd17eabe5758e7a497e0601c1f79?placeholderIfAbsent=true"
            alt="Logo Text" class="logo-text" />
    </div>
    <nav class="main-nav">
        <li class="nav-item">
            @if (request()->routeIs('pelatihan.index'))
                <span class="nav-link active text-primary" style="cursor: default;">Home</span>
            @else
                <a class="nav-link" href="{{ route('pelatihan.index') }}">Home</a>
            @endif
        </li>
        <li class="nav-item dropdown">
            <div
                class="nav-link dropdown-toggle {{ request()->routeIs('pelatihan.daftar-pelatihan') || request()->routeIs('pelatihan.usulan.index') ? 'active text-primary' : '' }}">
                Pelatihan
            </div>
            <ul class="dropdown-menu" id="pelatihanDropdownMenu">
                <li>
                    <a class="dropdown-item {{ request()->routeIs('pelatihan.tersedia') ? 'text-primary fw-bold' : '' }}"
                        href="{{ route('pelatihan.tersedia') }}">
                        Pelatihan Tersedia
                    </a>
                </li>
                <li>
                    <a class="dropdown-item {{ request()->routeIs('pelatihan.usulan.index') ? 'text-primary fw-bold' : '' }}"
                        href="{{ route('pelatihan.usulan.index') }}">
                        Usulan Pelatihan Mandiri
                    </a>
                </li>
            </ul>
        </li>
        @auth
            <li class="nav-item">
                @if (request()->routeIs('pelatihan.pendaftaran'))
                    <span class="nav-link active text-primary" style="cursor: default;">Hasil Pendaftaran</span>
                @else
                    <a class="nav-link" href="{{ route('pelatihan.pendaftaran') }}">Hasil Pendaftaran</a>
                @endif
            </li>
            <li class="nav-item">
                @if (request()->is('pelatihan/laporan*'))
                    <span class="nav-link active text-primary" style="cursor: default;">Laporan Pelatihan</span>
                @else
                    <a class="nav-link" href="{{ route('pelatihan.laporan') }}">Laporan Pelatihan</a>
                @endif
            </li>
        @endauth
    </nav>

    @auth
        <div class="position-relative profile-trigger">
            <img src="{{ asset('storage/' . Auth::user()->refPegawai->foto) }}" alt="Foto Profil" class="profile-avatar"
                style="width: 3rem !important; height: 3rem !important; border-radius: 100%" id="avatar"
                onerror="this.src='{{ asset('images/guest.png') }}'">
            {{-- <img src="{{ asset('storage/' . Auth::user()->refPegawai->foto) }}" alt="Profile" id="avatar"> --}}
            <div id="profile-popup">
                <div class="profile-header">
                    <img src="{{ asset('storage/' . Auth::user()->refPegawai->foto) }}" alt="Foto Profil" class="profile-avatar"
                        style="width: 7rem !important; height: 7rem !important; border-radius: 100%" id="avatar"
                        onerror="this.src='{{ asset('images/guest.png') }}'">
                    <h3 class="profile-name">{{ Auth::user()->refPegawai->name }}</h3>
                    <p class="profile-position">
                        {{ Auth::user()->latestUserPivot->jabatan->jabatan ?? 'Jabatan Tidak Ada' }}
                    </p>
                </div>
                <div class="profile-actions">
                    @if (in_array(auth()->user()->role, ['superadmin', 'admin']))
                        <a href="{{ route('dashboard.pelatihan') }}" class="profile-btn btn-dashboard">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                    @endif
                    <div class="profile-menu">
                        <a href="{{ route('profile.pelatihan') }}" class="profile-btn btn-profile">
                            <i class="bi bi-person-circle"></i>
                            <span>Profile</span>
                        </a>
                        <form method="POST" action="{{ route('logout.pelatihan') }}">
                            @csrf
                            <button type="submit" class="profile-btn btn-logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <a href="{{ route('login.pelatihan') }}" class="login-btn">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Login</span>
        </a>
    @endauth
</header>

<!-- Profile Popup Script -->
<script>
    const avatar = document.getElementById('avatar');
    const popup = document.getElementById('profile-popup');
    let timeoutId;

    function showPopup() {
        clearTimeout(timeoutId);
        popup.classList.add('show');
    }

    function hidePopup() {
        timeoutId = setTimeout(() => {
            if (!popup.matches(':hover')) {
                popup.classList.remove('show');
            }
        }, 200);
    }

    avatar.addEventListener('mouseenter', showPopup);
    avatar.addEventListener('mouseleave', hidePopup);
    popup.addEventListener('mouseenter', showPopup);
    popup.addEventListener('mouseleave', hidePopup);
</script>
