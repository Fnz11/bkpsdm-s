<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mengaktifkan Pelatihan Dashboard</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Public+Sans:wght@400;500&display=swap"
    rel="stylesheet" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Inter", -apple-system, Roboto, Helvetica, sans-serif;
      background-color: #e9ecef;
      overflow-x: hidden;
    }

    .dashboard-container {
      display: flex;
      gap: 20px;
    }

    .sidebar {
      display: flex;
      flex-direction: column;
      width: 16%;
      margin-left: 0;
    }

    .sidebar-content {
      background-color: #000;
      box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.25);
      flex-grow: 1;
      padding-bottom: 594px;
      overflow: hidden;
      width: 100%;
    }

    .logo-container {
      display: flex;
      width: 100%;
      padding: 39px;
      flex-direction: column;
      align-items: stretch;
      justify-content: center;
    }

    .logo-image {
      aspect-ratio: 3.24;
      object-fit: contain;
      object-position: center;
      width: 236px;
    }

    .sidebar-menu {
      min-height: 580px;
      width: 100%;
    }

    .menu-item,
    .menu-item-column,
    .menu-item-between,
    .menu-item-with-dropdown,
    .menu-item-with-gap {
      border-color: rgba(110, 117, 135, 0.2);
      border-bottom-width: 2px;
      display: flex;
      width: 100%;
      padding: 17px 24px;
      font-size: 16px;
      color: #fff;
      font-weight: 600;
      white-space: nowrap;
      line-height: 28px;
    }

    .menu-item {
      min-height: 61px;
      align-items: center;
      gap: 10px;
      justify-content: start;
    }

    .menu-item-column {
      flex-direction: column;
      align-items: start;
      justify-content: center;
    }

    .menu-item-between {
      align-items: center;
      justify-content: space-between;
      width: 100%;
      padding-left: 24px;
      padding-right: 24px;
    }

    .menu-item-with-dropdown {
      align-items: center;
      gap: 40px 59px;
      justify-content: space-between;
    }

    .menu-item-with-gap {
      align-items: center;
      gap: 18px;
      justify-content: space-between;
    }

    .menu-icon {
      aspect-ratio: 1;
      object-fit: contain;
      object-position: center;
      width: 24px;
      align-self: stretch;
      margin-top: auto;
      margin-bottom: auto;
      flex-shrink: 0;
    }

    .menu-text,
    .menu-text-settings {
      align-self: stretch;
      margin-top: auto;
      margin-bottom: auto;
    }

    .menu-text-settings {
      color: #fff;
      font-size: 16px;
      font-weight: 600;
      line-height: 28px;
    }

    .menu-item-inner,
    .menu-item-inner-stretch {
      display: flex;
      align-items: center;
      gap: 10px;
      justify-content: start;
    }

    .menu-item-inner-stretch {
      align-self: stretch;
      margin-top: auto;
      margin-bottom: auto;
      width: 100%;
    }

    .dropdown-icon-container {
      transform: rotate(6.123234262925839e-17rad);
      border-radius: 16px;
      align-self: stretch;
      display: flex;
      margin-top: auto;
      margin-bottom: auto;
      align-items: center;
      overflow: hidden;
      justify-content: center;
      width: 24px;
    }

    .dropdown-icon {
      aspect-ratio: 1;
      object-fit: contain;
      object-position: center;
      width: 24px;
      align-self: stretch;
      margin-top: auto;
      margin-bottom: auto;
    }

    .icon-container {
      align-self: stretch;
      display: flex;
      margin-top: auto;
      margin-bottom: auto;
      align-items: center;
      gap: 10px;
      justify-content: start;
      width: 24px;
    }

    .main-content {
      display: flex;
      flex-direction: column;
      width: 84%;
      margin-left: 20px;
    }

    .content-wrapper {
      display: flex;
      width: 100%;
      flex-direction: column;
      align-items: stretch;
    }

    .admin-header {
      display: flex;
      width: 100%;
      padding: 16px 32px;
      flex-direction: column;
      align-items: stretch;
      font-weight: 400;
      justify-content: center;
    }

    .header-content {
      display: flex;
      width: 100%;
      align-items: center;
      justify-content: flex-end;
    }

    .header-right {
      align-self: stretch;
      display: flex;
      min-width: 240px;
      margin-top: auto;
      margin-bottom: auto;
      align-items: center;
      gap: 16px;
      justify-content: flex-end;
    }

    .notification-button {
      align-self: stretch;
      display: flex;
      margin-top: auto;
      margin-bottom: auto;
      padding: 12px;
      align-items: start;
      font-family: "Public Sans", -apple-system, Roboto, Helvetica,
        sans-serif;
      font-size: 12px;
      color: #fff;
      white-space: nowrap;
      text-align: center;
      line-height: 2;
      justify-content: flex-end;
    }

    .notification-icon {
      display: flex;
      min-height: 20px;
      gap: 10px;
    }

    .badge-wrapper {
      width: 0;
    }

    .notification-badge {
      font-variant-numeric: lining-nums tabular-nums;
      border-radius: 10px;
      background-color: #ff4069;
      z-index: 10;
      margin-top: -8px;
      height: 16px;
      padding: 0 4px;
      overflow: hidden;
      width: 16px;
    }

    .user-profile {
      align-self: stretch;
      display: flex;
      margin-top: auto;
      margin-bottom: auto;
      align-items: center;
      gap: 16px;
      overflow: hidden;
      font-family: "Inter", -apple-system, Roboto, Helvetica, sans-serif;
      justify-content: center;
    }

    .user-info-container {
      align-self: stretch;
      display: flex;
      margin-top: auto;
      margin-bottom: auto;
      align-items: center;
      gap: 16px;
      overflow: hidden;
      justify-content: center;
    }

    .user-avatar {
      aspect-ratio: 1;
      object-fit: contain;
      object-position: center;
      width: 45px;
      border-radius: 30px;
      align-self: stretch;
      margin-top: auto;
      margin-bottom: auto;
      flex-shrink: 0;
    }

    .user-details {
      align-self: stretch;
      margin-top: auto;
      margin-bottom: auto;
    }

    .user-name {
      color: #fff;
      font-size: 16px;
      line-height: 28px;
    }

    .user-role {
      color: #dedede;
      font-size: 13px;
      line-height: 1.3;
    }

    .title-section {
      background-color: #fff;
      display: flex;
      width: 100%;
      padding: 27px 44px;
      align-items: center;
      justify-content: space-between;
      gap: 40px 100px;
      flex-wrap: nowrap;
    }
    .search-bar {
      flex-grow: 1;
      max-width: 600px;
      margin: 0 20px;
    }

    .page-title {
      color: #000;
      font-size: 40px;
      font-weight: 700;
      margin-top: auto;
      margin-bottom: auto;
      flex-grow: 1;
      flex-shrink: 1;
      width: 147px;
    }

    .search-filter-container {
      display: flex;
      align-items: center;
      gap: 20px 40px;
      font-size: 16px;
      color: #6c757d;
      font-weight: 500;
      line-height: 28px;
      flex-wrap: nowrap;
      padding-right: 10px;
      justify-content: center; /* Center horizontally */
      width: 100%;
      max-width: 900px; /* Limit max width of container */
      margin: 0 auto; /* Center container horizontally */
    }

    .search-bar {
      flex-grow: 1;
      flex-shrink: 1;
      flex-basis: auto;
      width: 100%;
      max-width: 900px; /* Increased max width */
    }

    .search-input-container {
      border-radius: 5px;
      background-color: #f8f9fa;
      display: flex;
      padding: 8px 16px;
      align-items: center;
      gap: 12px;
      flex-wrap: nowrap;
      justify-content: flex-start;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .search-placeholder {
      margin-top: auto;
      margin-bottom: auto;
      color: #6c757d;
      font-size: 14px;
      user-select: none;
    }

    .search-icon {
      aspect-ratio: 1;
      object-fit: contain;
      object-position: center;
      width: 24px;
      flex-shrink: 0;
      filter: grayscale(50%);
    }

    .filter-container {
      margin-top: auto;
      margin-bottom: auto;
      flex-grow: 0;
      flex-shrink: 0;
      flex-basis: auto;
      width: auto;
    }

    .filter-dropdown {
      border-radius: 5px;
      border: 1px solid #ced4da;
      display: flex;
      padding: 10px 20px;
      align-items: center;
      gap: 10px;
      justify-content: space-between;
      background-color: #fff;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      cursor: pointer;
      user-select: none;
    }

    .dropdown-arrow {
      aspect-ratio: 1.18;
      object-fit: contain;
      object-position: center;
      width: 16px;
      align-self: center;
      flex-shrink: 0;
      filter: grayscale(50%);
    }

    .controls-section {
      align-self: center;
      display: flex;
      margin-top: 65px;
      width: 100%;
      max-width: 1471px;
      align-items: stretch;
      gap: 35px;
      flex-wrap: wrap;
    }

    .show-controls {
      display: flex;
      align-items: stretch;
      gap: 13px;
      font-size: 16px;
      color: #000;
      font-weight: 400;
      white-space: nowrap;
    }

    .show-text {
      margin-top: auto;
      margin-bottom: auto;
      flex-grow: 1;
    }

    .show-dropdown {
      aspect-ratio: 2.89;
      object-fit: contain;
      object-position: center;
      width: 104px;
      border-radius: 5px;
      flex-shrink: 0;
      max-width: 100%;
    }

    .action-controls {
      display: flex;
      align-items: stretch;
      gap: 40px 100px;
      font-size: 14px;
      flex-wrap: wrap;
      flex-grow: 1;
      flex-shrink: 1;
      flex-basis: auto;
    }

    .search-control {
      display: flex;
      margin-top: auto;
      margin-bottom: auto;
      align-items: stretch;
      gap: 12px;
      color: #000;
      font-weight: 400;
    }

    .search-small-icon {
      aspect-ratio: 1;
      object-fit: contain;
      object-position: center;
      width: 18px;
      flex-shrink: 0;
    }

    .add-button-container {
      border-radius: 8px;
      color: #fff;
      font-weight: 500;
      white-space: nowrap;
      letter-spacing: 0.28px;
      line-height: 1;
    }

    .add-button {
      border-radius: 4px;
      background-color: #1b6ae0;
      box-shadow: 0 1px 1px rgba(0, 0, 0, 0.14);
      display: flex;
      min-height: 36px;
      width: 100%;
      padding: 8px 10px;
      align-items: center;
      gap: 4px;
      overflow: hidden;
      justify-content: start;
    }

    .add-icon {
      aspect-ratio: 1;
      object-fit: contain;
      object-position: center;
      width: 20px;
      align-self: stretch;
      margin-top: auto;
      margin-bottom: auto;
      flex-shrink: 0;
    }

    .add-text {
      align-self: stretch;
      margin-top: auto;
      margin-bottom: auto;
    }

    /* New table styles */
    .table-wrapper {
      width: 100%;
      overflow-x: auto;
      margin-top: 43px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
      border-radius: 8px;
    }

    table.training-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 16px;
      color: #000;
      font-weight: 400;
      border-radius: 8px;
      table-layout: fixed;
      white-space: nowrap;
    }

    table.training-table thead {
      background-color: #369bff;
      color: #fff;
    }

    table.training-table thead th {
      padding: 14px 12px;
      text-align: left;
      font-weight: 700;
      white-space: nowrap;
      border-bottom: 3px solid rgba(0, 0, 0, 0.3);
    }

    /* Ukuran Kolom */
    table.training-table thead th:nth-child(1) {
      width: 3%;
      min-width: 40px;
    }

    table.training-table thead th:nth-child(2) {
      width: 12%;
      min-width: 120px;
    }

    table.training-table thead th:nth-child(3) {
      width: 12%;
      min-width: 100px;
    }

    table.training-table thead th:nth-child(4) {
      width: 14%;
      min-width: 110px;
    }

    table.training-table thead th:nth-child(5) {
      width: 10%;
      min-width: 90px;
    }

    table.training-table thead th:nth-child(6),
    table.training-table thead th:nth-child(7),
    table.training-table thead th:nth-child(8) {
      width: 13%;
      min-width: 90px;
    }

    table.training-table thead th:nth-child(9) {
      width: 8%;
      min-width: 80px;
    }

    table.training-table thead th:nth-child(10) {
      width: 7%;
      min-width: 70px;
    }

    table.training-table thead th:nth-child(11) {
      width: 8%;
      min-width: 50px;
    }

    table.training-table tbody tr {
      background-color: #fff;
      border-bottom: 1px solid #ccc;
    }

    table.training-table tbody tr:last-child {
      border-bottom: none;
    }

    table.training-table tbody td {
      padding: 12px 12px;
      vertical-align: middle;
      white-space: normal;
      word-wrap: break-word;
      color: #000;
      overflow-wrap: break-word;
      max-width: 180px;
      border-right: 1px solid #ddd;
    }

    table.training-table tbody td:last-child {
      border-right: none;
    }

    table.training-table tbody td.status-cell p {
      margin: 0;
      padding: 6px 14px;
      border-radius: 12px;
      background-color: #3a57e8;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      white-space: nowrap;
      font-weight: 600;
      font-size: 15px;
      text-align: center;
      width: 100%;
    }

    table.training-table tbody td.actions-cell img.action-icon {
      width: 45px;
      height: auto;
      object-fit: contain;
    }

    table.training-table tbody td img.training-image {
      width: 40px;
      height: 40px;
      object-fit: contain;
      border-radius: 6px;
    }

    @media (max-width: 991px) {
      .dashboard-container {
        flex-direction: column;
        align-items: stretch;
        gap: 0;
      }

      .sidebar {
        width: 100%;
      }

      .sidebar-content {
        padding-bottom: 100px;
      }

      .logo-container {
        padding-left: 20px;
        padding-right: 20px;
      }

      .menu-item,
      .menu-item-column,
      .menu-item-between,
      .menu-item-with-dropdown,
      .menu-item-with-gap {
        padding-left: 20px;
        padding-right: 20px;
        white-space: initial;
      }

      .menu-item-inner,
      .menu-item-inner-stretch,
      .badge-wrapper,
      .notification-badge,
      .notification-button,
      .training-actions,
      .status-open,
      .status-closed,
      .status-completed {
        white-space: initial;
      }

      .main-content {
        width: 100%;
      }

      .admin-header {
        max-width: 100%;
        padding-left: 20px;
        padding-right: 20px;
      }

      .header-content {
        max-width: 100%;
      }

      .title-section {
        max-width: 100%;
        padding-left: 20px;
        padding-right: 20px;
      }

      .search-filter-container {
        max-width: 100%;
      }

      .search-bar {
        max-width: 100%;
      }

      .search-input-container {
        max-width: 100%;
        padding-left: 20px;
      }

      .filter-dropdown {
        padding-right: 20px;
      }

      .controls-section {
        max-width: 100%;
        margin-top: 40px;
      }

      .show-controls {
        white-space: initial;
      }

      .action-controls {
        max-width: 100%;
      }

      .add-button-container {
        white-space: initial;
      }

      .add-button {
        white-space: initial;
      }

      /* Responsive table */
      .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }

      table.training-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 16px;
        color: #000;
        font-weight: 400;
        border-radius: 8px;
        table-layout: fixed;
        white-space: nowrap;
      }

      table.training-table thead,
      table.training-table tbody,
      table.training-table tbody tr,
      table.training-table thead th,
      table.training-table tbody td {
        display: table-cell;
        width: auto;
        box-sizing: border-box;
      }

      table.training-table thead tr {
        display: table-row;
      }

      table.training-table tbody tr {
        margin-bottom: 15px;
        border-bottom: 2px solid #ddd;
        display: table-row;
      }

      table.training-table tbody td {
        text-align: left;
        padding-left: 12px;
        position: relative;
        white-space: normal;
        word-wrap: break-word;
        max-width: 180px;
        overflow-wrap: break-word;
        border: 1px solid #eee;
        border-right: 1px solid #ddd;
        border-bottom: none;
      }

      table.training-table tbody td::before {
        content: none;
        position: static;
        left: auto;
        top: auto;
        font-weight: normal;
        white-space: normal;
        color: inherit;
      }

      table.training-table tbody td.status-cell p {
        white-space: normal;
        padding: 5px 8px;
        border-radius: 6px;
        font-size: 14px;
      }

      table.training-table tbody td.actions-cell img.action-icon {
        width: 30px;
      }

      table.training-table tbody td img.training-image {
        width: 25px;
        height: 25px;
      }
    }
  </style>
</head>

<body>
  <main class="dashboard-container">
    <aside class="sidebar">
      <nav class="sidebar-content">
        <div>
          <div class="logo-container">
            <img
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/b454cab2b776d9f1ec8f8572b9beaecbf5583cd4?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
              alt="BKPSDM Logo" class="logo-image" />
          </div>
          <div class="sidebar-menu">
            <a href="#" class="menu-item">
              <img
                src="https://cdn.builder.io/api/v1/image/assets/TEMP/611788ddd66dc3aa1c3121c8da11ceb0a49b0c06?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                alt="Home Icon" class="menu-icon" />
              <span class="menu-text">Home</span>
            </a>
            <div class="menu-item-column">
              <div class="menu-item-inner">
                <img
                  src="https://cdn.builder.io/api/v1/image/assets/TEMP/02609284d30e79cdb5f5faadcc1e00618b697717?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                  alt="Kepegawaian Icon" class="menu-icon" />
                <span class="menu-text">Kepegawaian</span>
              </div>
            </div>
            <div class="menu-item-between">
              <div class="menu-item-inner-stretch">
                <img
                  src="https://cdn.builder.io/api/v1/image/assets/TEMP/d253cd252863d48e1cc936a9ae12997b65921071?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                  alt="Pelatihan Icon" class="menu-icon" />
                <span class="menu-text">Pelatihan</span>
              </div>
            </div>
            <div class="menu-item-with-dropdown">
              <div class="menu-item-inner">
                <img
                  src="https://cdn.builder.io/api/v1/image/assets/TEMP/6b5350d32526b647d2ec3d5a66d9ccac00d7797b?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                  alt="Alumni Icon" class="menu-icon" />
                <span class="menu-text">Alumni Pelatihan</span>
              </div>
            </div>
            <div class="menu-item-with-dropdown">
              <div class="menu-item-inner-stretch">
                <img
                  src="https://cdn.builder.io/api/v1/image/assets/TEMP/aac0efc01407fe20a214505d1749cf9d30f3a1dd?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                  alt="Directory Icon" class="menu-icon" />
                <span class="menu-text">Directory Pelatihan</span>
              </div>
              <div class="dropdown-icon-container">
                <img
                  src="https://cdn.builder.io/api/v1/image/assets/TEMP/96d1cd27d761317bc4ef0e86c3445e9e4263756a?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                  alt="Dropdown Icon" class="dropdown-icon" />
              </div>
            </div>
            <div class="menu-item-with-gap">
              <div class="menu-item-inner-stretch">
                <img
                  src="https://cdn.builder.io/api/v1/image/assets/TEMP/cd1ba056064ad350a6b8d55d912f6904ad72d088?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                  alt="Evaluation Icon" class="menu-icon" />
                <span class="menu-text">Evaluasi Pasca Pelatihan</span>
              </div>
              <div class="dropdown-icon-container">
                <img
                  src="https://cdn.builder.io/api/v1/image/assets/TEMP/96d1cd27d761317bc4ef0e86c3445e9e4263756a?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                  alt="Dropdown Icon" class="dropdown-icon" />
              </div>
            </div>
            <div class="menu-item-column">
              <div class="menu-item-inner">
                <div class="icon-container">
                  <img
                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/52c32d0a977d282298f93e06dc605adae3a3cb0e?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                    alt="Settings Icon" class="menu-icon" />
                </div>
                <span class="menu-text-settings">Pengaturan Tabel</span>
              </div>
            </div>
          </div>
      </nav>
    </aside>

    <section class="main-content">
      <div class="content-wrapper">
        <header class="admin-header">
          <div class="header-content">
            <div class="header-right">
              <div class="notification-button">
                <div class="notification-icon"></div>
                <div class="badge-wrapper">
                  <div class="notification-badge">92</div>
                </div>
              </div>
              <div class="user-profile">
                <div class="user-info-container">
                  <img
                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/dd2219da8ac5b216974ee669fc8a603a6e59bbd9?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                    alt="User Avatar" class="user-avatar" />
                  <div class="user-details">
                    <h3 class="user-name">Austin Robertson</h3>
                    <p class="user-role">Super Admin</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </header>

        <section class="title-section">
          <h1 class="page-title">Pelatihan</h1>
          <div class="search-bar">
            <div class="search-input-container">
              <p class="search-placeholder">Cari pelatihan atau penulis</p>
              <img
                src="https://cdn.builder.io/api/v1/image/assets/TEMP/a11d20fbaf243193adc97c9431a7565ee3a180f2?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                alt="Search Icon" class="search-icon" />
            </div>
          </div>
          <div class="filter-container">
            <div class="filter-dropdown">
              <p>Pilih Pelatihan</p>
              <img
                src="https://cdn.builder.io/api/v1/image/assets/TEMP/8873b4a115ee5801a2c5b5266f30f5e23684da01?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                alt="Dropdown Arrow" class="dropdown-arrow" />
            </div>
          </div>
        </section>

        <section class="controls-section">
          <div class="show-controls">
            <p class="show-text">Show</p>
            <img
              src="https://cdn.builder.io/api/v1/image/assets/TEMP/8df64ae07835e660921e542b8c6a9e58dc1822ba?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
              alt="Show Dropdown" class="show-dropdown" />
          </div>
          <div class="action-controls">
            <div class="add-button-container">
              <button class="add-button">
                <img
                  src="https://cdn.builder.io/api/v1/image/assets/TEMP/f2f8b45290eee1065e6fa7a51ea66c216f13d5cf?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                  alt="Add Icon" class="add-icon" />
                <span class="add-text">Tambah</span>
              </button>
            </div>
          </div>
        </section>

        <!-- Table -->
        <div class="table-wrapper">
          <table class="training-table" role="table" aria-label="Daftar Pelatihan">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pelatihan</th>
                <th>Diskripsi</th>
                <th>Tanggal Pelaksanaan</th>
                <th>Kategori</th>
                <th>Kuota Peserta</th>
                <th>Tanggal Buka</th>
                <th>Tanggal Penutupan</th>
                <th>Image</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1.</td>
                <td>Pelatihan SPBE</td>
                <td>Pelatihan ..</td>
                <td>25-29 Oktober 2025</td>
                <td>Teknologi</td>
                <td>5 Orang</td>
                <td>17 Agustus 2025</td>
                <td>31 Agustus 2025</td>
                <td>
                  <img
                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/cca5c46822f8ef1c898d55b8e23726e72c24c9d4?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                    alt="Training Image" class="training-image" />
                </td>
                <td class="status-cell">
                  <p class="status-open">Buka</p>
                </td>
                <td class="actions-cell">
                  <img
                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/54bbbe9ae1334e3c23536ffd85bd1d1352b24fc2?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                    alt="Action Icon" class="action-icon" />
                </td>
              </tr>
              <tr>
                <td>2.</td>
                <td>Pelatihan SPBE</td>
                <td>Pelatihan ..</td>
                <td>25-29 Oktober 2025</td>
                <td>Teknologi</td>
                <td>5 Orang</td>
                <td>17 Agustus 2025</td>
                <td>31 Agustus 2025</td>
                <td>
                  <img
                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/cca5c46822f8ef1c898d55b8e23726e72c24c9d4?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                    alt="Training Image" class="training-image" />
                </td>
                <td class="status-cell">
                  <p class="status-closed">Tutup</p>
                </td>
                <td class="actions-cell">
                  <img
                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/54bbbe9ae1334e3c23536ffd85bd1d1352b24fc2?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                    alt="Action Icon" class="action-icon" />
                </td>
              </tr>
              <tr>
                <td>3.</td>
                <td>Pelatihan SPBE</td>
                <td>Pelatihan ..</td>
                <td>25-29 Oktober 2025</td>
                <td>Teknologi</td>
                <td>5 Orang</td>
                <td>17 Agustus 2025</td>
                <td>31 Agustus 2025</td>
                <td>
                  <img
                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/cca5c46822f8ef1c898d55b8e23726e72c24c9d4?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                    alt="Training Image" class="training-image" />
                </td>
                <td class="status-cell" style="align-items: center;">
                  <p class="status-completed">Selesai</p>
                </td>
                <td class="actions-cell">
                  <img
                    src="https://cdn.builder.io/api/v1/image/assets/TEMP/54bbbe9ae1334e3c23536ffd85bd1d1352b24fc2?placeholderIfAbsent=true&apiKey=5d0eaf89769d4096a24fb2df3abfafd0"
                    alt="Action Icon" class="action-icon" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </main>

  <script>
    (() => {
      const state = {};
      let nodesToDestroy = [];
      let pendingUpdate = false;

      function destroyAnyNodes() {
        nodesToDestroy.forEach((el) => el.remove());
        nodesToDestroy = [];
      }

      function update() {
        if (pendingUpdate === true) {
          return;
        }
        pendingUpdate = true;

        document
          .querySelectorAll("[data-el='mengaktifkan-pelatihan']")
          .forEach((el) => {
            el.setAttribute("space", 0);
          });

        destroyAnyNodes();
        pendingUpdate = false;
      }

      update();
    })();
  </script>
</body>

</html>