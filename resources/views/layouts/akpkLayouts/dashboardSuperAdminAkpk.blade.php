<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AKPK Sidebar Layout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .layout {
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      background-color: #0f0f0f;
      color: #6E7587;
      width: 255px;
      padding: 0; /* Remove padding to allow full-width background */
      margin: 0;
      box-sizing: border-box;
      text-align: left; /* Ensure text is left-aligned */
      position: relative; /* Ensure positioning for user profile */
    }

    .sidebar img {
      display: block; 
      margin: 10px; 
    }

    .content {
      flex-grow: 1;
      padding: 2rem;
      background-color: #ffffff;
    }

    .nav-link {
      color: #6E7587;
      font-weight: 600; /* Set font weight to semi-bold */
      padding: 10px 15px;
      border-radius: 0; /* Remove border-radius for full-width background */
      display: flex;
      justify-content: flex-start;
      align-items: center;
      text-decoration: none;
      gap: 10px;
      width: 100%; /* Ensure full width */
      box-sizing: border-box; /* Include padding in width calculation */
      text-align: left; /* Ensure nav links are left-aligned */
    }

    .nav-link:focus {
      border: 1px solid #6E758733; /* Add border only when clicked */
      outline: none; /* Remove default outline */
    }

    .nav-link .bi-chevron-down,
    .nav-link .bi-chevron-up {
      margin-left: auto;
    }

    .nav-link:hover {
      background-color: #1976f2;
      color: #fff !important;
    }

    .nav-link.active-parent {
      background-color: #1976f2;
      color: #fff !important;
      border: 1px solid #6E758733; /* Add border when menu is active */
    }

    /* Fix for submenu item background */
    .submenu {
      display: none;
      padding: 0; /* Remove any padding in the submenu */
      margin: 0; /* Remove any margin in the submenu */
      width: 100%; /* Ensure submenu takes full width */
    }

    .submenu.show {
      display: block;
    }

    .submenu .nav-link {
      padding-left: 45px; /* Indent for submenu items */
      margin: 0; /* Remove any margin to ensure full background */
      font-size: 14px;
      font-weight: 600; /* Set font weight to semi-bold for submenu items */
    }

    .submenu .nav-link:focus {
      border: 1px solid #6E758733; /* Add border only when submenu item is clicked */
      outline: none; /* Remove default outline */
    }

    /* Adjust padding for deeper nested items */
    .submenu .submenu .nav-link {
      padding-left: 60px; /* More indent for nested submenu items */
    }

    .submenu .nav-link.active-submenu {
      background-color: #DEEBFF;
      color: #6E7587 !important;
      font-weight: 600;
      border: 10px solid #6E758733; /* Add border when submenu is active */
    }

    .submenu .nav-link:not(.active-submenu) {
      background-color: #1976f2;
      color: #fff !important;
    }

    .submenu .nav-link:hover {
      background-color: #DEEBFF !important;
      color: #6E7587 !important;
    }

    .submenu .nav-link.active-submenu::before {
      content: "• ";
      color: #6E7587;
    }

    /* Ensure no left margin/padding on list items */
    .sidebar ul {
      padding: 0;
      margin: 0;
      width: 100%;
    }

    .sidebar li {
      width: 100%;
      padding: 0;
      margin: 0;
    }

    .nav-icon {
      margin-right: 10px;
    }

    .user-profile {
      font-size: 14px; /* Default font size for user profile */
      background-color: #0f0f0f; /* Match sidebar background color */
      user-select: none; /* Prevent text selection */
    }

    .user-profile .user-name {
      font-size: 14px; /* Font size for user name */
      color: #1752D5; /* Optional: Add color for better visibility */
      user-select: none; /* Prevent text selection */
    }

    .user-profile .user-role {
      font-size: 10px; /* Font size for user role */
      color: #1752D5; /* Optional: Add color for better visibility */
      user-select: none; /* Prevent text selection */
    }

    .user-profile .user-actions i {
      margin-right: 10px; /* Add consistent spacing to match dropdown icons */
    }

  </style>
</head>
<body>

<div class="layout">
  <!-- Sidebar -->
  <div class="sidebar">
    <img src="{{ asset('images/logoBkpsdm.svg') }}" class="mb-2 " width="200" alt="Logo BKPSDM">
    <ul class="nav flex-column list-unstyled">
      <li><a href="#" class="nav-link"><i class="bi bi-grid-fill nav-icon"></i> Dashboard</a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-link-45deg nav-icon"></i> Link Drive Kegiatan</a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-bar-chart-line nav-icon"></i> IP ASN <i class="bi bi-chevron-down"></i></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-people nav-icon"></i> Solo Wasis <i class="bi bi-chevron-down"></i></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-file-earmark-text nav-icon"></i> Brosur <i class="bi bi-chevron-down"></i></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-book nav-icon"></i> E-Katalog <i class="bi bi-chevron-down"></i></a></li>

      <!-- AKPK Section -->
      <li>
        <a href="javascript:void(0);" class="nav-link" onclick="toggleSubmenu('akpk', 'icon-akpk')">
          <i class="bi bi-graph-up-arrow nav-icon"></i> 1.AKPK
          <i id="icon-akpk" class="bi bi-chevron-up"></i>
        </a>
        <ul id="akpk" class="submenu list-unstyled show">
          <li><a href="#" class="nav-link"><i class="bi bi-graph-up-arrow nav-icon"></i> Informasi AKPK</a></li>

          <!-- Data Assesment -->
          <li>
            <a href="javascript:void(0);" class="nav-link active-parent" onclick="toggleSubmenu('dataAssesment', 'icon-assesment')">
              <i class="bi bi-graph-up-arrow nav-icon"></i>Data Assesment
              <i id="icon-assesment" class="bi bi-chevron-up"></i>
            </a>
            <ul id="dataAssesment" class="submenu list-unstyled show">
              <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i> Self Assesment</a></li>
              <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i> Assesment Atasan</a></li>
              <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i> Evaluasi Atasan</a></li>
            </ul>
          </li> 

          <!-- Data Usulan -->
          <li>
            <a href="javascript:void(0);" class="nav-link active-parent" onclick="toggleSubmenu('dataUsulan', 'icon-usulan')">
              <i class="bi bi-graph-up-arrow nav-icon"></i> Data Usulan
              <i id="icon-usulan" class="bi bi-chevron-up"></i>
            </a>
            <ul id="dataUsulan" class="submenu list-unstyled show">
              <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Usul Pelatihan Solowasis</a></li>
              <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Usul Kebutuhan Pelatihan</a></li>
            </ul>
          </li>

          <li>
            <a href="javascript:void(0);" class="nav-link active-parent" onclick="toggleSubmenu('manajemenData', 'icon-manajemen')">
              <i class="bi bi-graph-up-arrow nav-icon"></i> Manajemen Data
              <i id="icon-manajemen" class="bi bi-chevron-down"></i>
            </a>
            <ul id="manajemenData" class="submenu list-unstyled">
              <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Pegawai</a></li>
              <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Pertanyaan</a></li>
              <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Jawaban</a></li>
              <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Komentar</a></li>
              <li><a href="#" class="nav-link"><i class="bi bi-record-fill nav-icon"></i>Galeri</a></li>
            </ul>
          </li>
        </ul>
      </li>

      <li><a href="#" class="nav-link"><i class="bi bi-award-fill nav-icon"></i> 2.Pelatihan <i class="bi bi-chevron-down"></i></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-people-fill nav-icon"></i> 3.Alumni Pelatihan <i class="bi bi-chevron-down"></i></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-journal-richtext nav-icon"></i> Directory Pelatihan <i class="bi bi-chevron-down"></i></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-check2-square nav-icon"></i> Evaluasi Pasca Pelatihan <i class="bi bi-chevron-down"></i></a></li>
      <li><a href="#" class="nav-link"><i class="bi bi-table nav-icon"></i> Pengaturan Tabel <i class="bi bi-chevron-down"></i></a></li>
    </ul>

    <!-- User Profile -->
    <div class="user-profile d-flex align-items-center p-2" style="position: absolute; bottom: 0; width: 100%;">
      <div class="user-avatar me-2">
        <img src="{{ asset('images/Roket.png') }}" alt="User Avatar" class="img-fluid rounded-circle" width="20">
      </div>
      <div>
        <div class="user-name fw-bold">Naufal Dwi Saputro</div>
        <div class="user-role">Super Admin</div>
      </div>
      <div class="ms-auto user-actions">
        <a href="#" style="color: red;"><i class="bi bi-box-arrow-right" style="cursor: pointer;"></i></a>
      </div>
    </div>
  </div>

  <!-- Page Content -->
  <div class="flex-grow-1 p-4">
    @yield('content')
  </div>
</div>

<!-- Script -->
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

</body>
</html>