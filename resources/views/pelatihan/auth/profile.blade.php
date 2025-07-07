@extends('layouts.pelatihan.app')

@section('title', 'Profil')

@section('content')
    <div class="modern-container">
        <!-- Hero Header Section -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">
                        <i class="bi bi-person-circle me-3"></i>
                        Profil Pengguna
                    </h1>
                    <p class="hero-subtitle">Kelola informasi profil dan data kepegawaian Anda</p>
                </div>
                <div class="hero-actions">
                    <button id="edit-button" class="btn btn-elegant btn-outline-light">
                        <i class="bi bi-pencil-square me-2"></i>
                        <span>Edit Profil</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Profile Card -->
        <div class="main-card">
            <div class="profile-header-card">
                <div class="avatar-section">
                    <div class="avatar-container" style="width: 7rem !important; height: 7rem !important;">
                        <img src="{{ asset('storage/' . $user->refPegawai?->foto) }}" alt="Foto Profil"
                            class="profile-avatar" style="width: 7rem !important; height: 7rem !important;" id="profile-avatar"
                            onerror="this.src='{{ asset('images/guest.png') }}'">
                        <div class="avatar-edit-indicator">
                            <i class="bi bi-camera"></i>
                        </div>
                        <div id="file-name-display" class="file-name-display"></div>
                    </div>
                </div>
                <div class="profile-info-section">
                    <h2 class="profile-name">{{ $user->refPegawai?->name }}</h2>
                    <div class="profile-badges">
                        <span class="profile-badge badge-primary">{{ $user->role }}</span>
                        <span class="profile-badge badge-secondary">NIP: {{ $user->nip }}</span>
                    </div>
                    <div class="profile-meta">
                        <div class="meta-item">
                            <i class="bi bi-building"></i>
                            <span>{{ $user->latestUserPivot?->unitKerja?->unitkerja->unitkerja }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-briefcase"></i>
                            <span>{{ $user->latestUserPivot?->jabatan?->jabatan }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <form id="profile-form" method="POST" action="{{ route('pelatihan.profile.update') }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="file" id="avatar-input" name="foto" accept="image/*" style="display: none;">

                <div class="profile-details">
                    <h3 class="section-title">
                        <i class="bi bi-info-circle me-2"></i>
                        Informasi Personal
                    </h3>

                    <div class="info-grid">
                        <!-- Tempat & Tanggal Lahir -->
                        <div class="info-item">
                            <label class="info-label">
                                <i class="bi bi-geo-alt me-2"></i>
                                Tempat, Tanggal Lahir
                            </label>
                            <div class="info-value view-mode">
                                {{ $user->refPegawai?->tempat_lahir }},
                                {{ \Carbon\Carbon::parse($user->refPegawai?->tanggal_lahir)->translatedFormat('d F Y') }}
                            </div>
                            <div class="edit-mode">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control-modern"
                                            value="{{ $user->refPegawai?->tempat_lahir }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control-modern"
                                            value="{{ $user->refPegawai?->tanggal_lahir->format('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- No. WhatsApp -->
                        <div class="info-item">
                            <label class="info-label">
                                <i class="bi bi-whatsapp me-2"></i>
                                No. WhatsApp
                            </label>
                            <div class="info-value view-mode">+{{ $user->refPegawai?->no_hp }}</div>
                            <input type="text" name="no_hp" class="form-control-modern edit-mode"
                                value="{{ $user->refPegawai?->no_hp }}">
                        </div>

                        <!-- Email -->
                        <div class="info-item">
                            <label class="info-label">
                                <i class="bi bi-envelope me-2"></i>
                                Email
                            </label>
                            <div class="info-value view-mode">{{ $user->email }}</div>
                            <input type="email" name="email" class="form-control-modern edit-mode"
                                value="{{ $user->email }}">
                        </div>

                        <!-- Alamat -->
                        <div class="info-item full-width">
                            <label class="info-label">
                                <i class="bi bi-house me-2"></i>
                                Alamat
                            </label>
                            <div class="info-value view-mode">{{ $user->refPegawai?->alamat }}</div>
                            <textarea name="alamat" class="form-control-modern edit-mode" rows="3">{{ $user->refPegawai?->alamat }}</textarea>
                        </div>
                    </div>

                    <h3 class="section-title">
                        <i class="bi bi-briefcase me-2"></i>
                        Informasi Kepegawaian
                    </h3>

                    <div class="info-grid">
                        <!-- Jenis ASN -->
                        <div class="info-item">
                            <label class="info-label">
                                <i class="bi bi-person-badge me-2"></i>
                                Jenis ASN
                            </label>
                            <div class="info-value readonly">{{ $user->latestUserPivot?->golongan?->jenisasn?->jenis_asn }}
                            </div>
                        </div>

                        <!-- Pangkat / Golongan -->
                        <div class="info-item">
                            <label class="info-label">
                                <i class="bi bi-award me-2"></i>
                                Pangkat / Golongan
                            </label>
                            <div class="info-value view-mode">{{ $user->latestUserPivot?->golongan?->pangkat }} /
                                {{ $user->latestUserPivot?->golongan?->golongan }}</div>
                            <select name="golongan_id" class="form-control-modern edit-mode">
                                @foreach ($golongans as $golongan)
                                    <option value="{{ $golongan->id }}"
                                        {{ $user->latestUserPivot?->golongan?->id == $golongan->id ? 'selected' : '' }}>
                                        {{ $golongan->pangkat_golongan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kategori Jabatan -->
                        <div class="info-item">
                            <label class="info-label">
                                <i class="bi bi-diagram-3 me-2"></i>
                                Kategori Jabatan
                            </label>
                            <div class="info-value readonly">
                                {{ $user->latestUserPivot?->jabatan?->kategorijabatan?->kategori_jabatan }}</div>
                        </div>

                        <!-- Jabatan -->
                        <div class="info-item">
                            <label class="info-label">
                                <i class="bi bi-briefcase me-2"></i>
                                Jabatan
                            </label>
                            <div class="info-value view-mode">{{ $user->latestUserPivot?->jabatan?->jabatan }}</div>
                            <select name="jabatan_id" class="form-control-modern edit-mode">
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}"
                                        {{ $user->latestUserPivot?->jabatan?->id == $jabatan->id ? 'selected' : '' }}>
                                        {{ $jabatan->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Unit Kerja -->
                        <div class="info-item">
                            <label class="info-label">
                                <i class="bi bi-building me-2"></i>
                                Unit Kerja
                            </label>
                            <div class="info-value readonly">{{ $user->latestUserPivot?->unitKerja?->unitkerja->unitkerja }}
                            </div>
                        </div>

                        <!-- Sub Unit Kerja -->
                        <div class="info-item">
                            <label class="info-label">
                                <i class="bi bi-diagram-2 me-2"></i>
                                Sub Unit Kerja
                            </label>
                            <div class="info-value view-mode">{{ $user->latestUserPivot?->unitKerja?->sub_unitkerja }}</div>
                            <select name="sub_unitkerja_id" class="form-control-modern edit-mode">
                                @foreach ($subunitkerjas as $subunit)
                                    <option value="{{ $subunit->id }}"
                                        {{ $user->latestUserPivot?->unitKerja?->id == $subunit->id ? 'selected' : '' }}>
                                        {{ $subunit->sub_unitkerja }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Atasan -->
                        <div class="info-item">
                            @php
                                $nip = $user->refPegawai?->atasan->nip;
                                $atasan = \App\Models\RefPegawai::where('nip', $nip)->first();
                            @endphp
                            <label class="info-label">
                                <i class="bi bi-person-up me-2"></i>
                                Atasan
                            </label>
                            <div class="info-value readonly">{{ $atasan->name }}</div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-elegant btn-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Simpan Perubahan
                        </button>
                        <button type="button" class="btn btn-elegant btn-outline-secondary cancel-button">
                            <i class="bi bi-x-circle me-2"></i>
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- History Section -->
        <div class="main-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-clock-history me-2"></i>
                    Riwayat Jabatan
                </h3>
            </div>

            <div class="history-tabs">
                <ul class="nav nav-tabs modern-tabs" id="historyTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="active-tab" data-bs-toggle="tab"
                            data-bs-target="#active-tab-pane" type="button" role="tab">
                            <i class="bi bi-check-circle me-2"></i>
                            Riwayat Aktif
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="proposed-tab" data-bs-toggle="tab"
                            data-bs-target="#proposed-tab-pane" type="button" role="tab">
                            <i class="bi bi-clock me-2"></i>
                            Usulan Perubahan
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="historyTabsContent">
                <!-- Tab Riwayat Aktif -->
                <div class="tab-pane fade show active" id="active-tab-pane" role="tabpanel">
                    <div class="table-section">
                        <div class="modern-table-wrapper">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Unit Kerja</th>
                                        <th>Jabatan</th>
                                        <th>Pangkat/Golongan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Akhir</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($activePivots as $pivot)
                                        <tr class="table-row">
                                            <td>{{ ($activePivots->currentPage() - 1) * $activePivots->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $pivot->unitKerja->unitkerja->unitkerja ?? '-' }}</td>
                                            <td>{{ $pivot->jabatan->jabatan ?? '-' }}</td>
                                            <td>{{ $pivot->golongan->pangkat ?? '-' }} /
                                                {{ $pivot->golongan->golongan ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pivot->tgl_mulai)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>{{ $pivot->tgl_akhir ? \Carbon\Carbon::parse($pivot->tgl_akhir)->translatedFormat('d F Y') : '-' }}
                                            </td>
                                            <td>
                                                <span class="status-badge status-active">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Aktif
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="empty-cell">Tidak ada riwayat jabatan aktif</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($activePivots->hasPages())
                            <div class="pagination-section">
                                <div class="pagination-info">
                                    <span class="result-count">
                                        <i class="bi bi-list-ul me-2"></i>
                                        Menampilkan <strong>{{ $activePivots->firstItem() ?? 0 }}</strong> -
                                        <strong>{{ $activePivots->lastItem() ?? 0 }}</strong> dari
                                        <strong>{{ $activePivots->total() }}</strong> riwayat
                                    </span>
                                </div>
                                <div class="pagination-controls">
                                    {{ $activePivots->onEachSide(1)->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tab Usulan Perubahan -->
                <div class="tab-pane fade" id="proposed-tab-pane" role="tabpanel">
                    <div class="table-section">
                        <div class="modern-table-wrapper">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Unit Kerja</th>
                                        <th>Jabatan</th>
                                        <th>Pangkat/Golongan</th>
                                        <th>Tanggal Diajukan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($proposedPivots as $pivot)
                                        <tr class="table-row">
                                            <td>{{ ($proposedPivots->currentPage() - 1) * $proposedPivots->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $pivot->unitKerja->unitkerja->unitkerja ?? '-' }}</td>
                                            <td>{{ $pivot->jabatan->jabatan ?? '-' }}</td>
                                            <td>{{ $pivot->golongan->pangkat ?? '-' }} /
                                                {{ $pivot->golongan->golongan ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pivot->created_at)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>
                                                <span class="status-badge status-pending">
                                                    <i class="bi bi-clock me-1"></i>
                                                    Menunggu Persetujuan
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="empty-cell">Tidak ada usulan perubahan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($proposedPivots->hasPages())
                            <div class="pagination-section">
                                <div class="pagination-info">
                                    <span class="result-count">
                                        <i class="bi bi-list-ul me-2"></i>
                                        Menampilkan <strong>{{ $proposedPivots->firstItem() ?? 0 }}</strong> -
                                        <strong>{{ $proposedPivots->lastItem() ?? 0 }}</strong> dari
                                        <strong>{{ $proposedPivots->total() }}</strong> usulan
                                    </span>
                                </div>
                                <div class="pagination-controls">
                                    {{ $proposedPivots->onEachSide(1)->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-css')
    <style>
        .file-name-display {
            position: absolute;
            bottom: -16px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.8rem;
            color: var(--light-text);
            background-color: rgba(255, 255, 255, 0.9);
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            max-width: 180px;
            /* height: 32px; */
            margin: 0 auto;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Modern Global Color Palette */
        :root {
            --primary-soft: #8b9dc3;
            --primary-hover: #6b9aa1;
            --secondary-soft: #a8a8a8;
            --success-soft: #a5d6a7;
            --info-soft: #b3e5fc;
            --warning-soft: #ffe082;
            --danger-soft: #ef9a9a;
            --light-soft: #fafafa;
            --dark-soft: #5d5d5d;
            --gradient-primary: linear-gradient(135deg, var(--primary-soft), var(--primary-hover));
            --gradient-secondary: linear-gradient(135deg, var(--secondary-soft), #8e8e8e);
            --gradient-success: linear-gradient(135deg, var(--success-soft), #81c784);
            --gradient-danger: linear-gradient(135deg, var(--danger-soft), #e57373);

            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --text-primary: #2c3e50;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e5e7eb;
            --border-radius: 1rem;
            --border-radius-sm: 0.5rem;
            --border-radius-lg: 1.5rem;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Avatar Section Modern Styling */
        .avatar-edit-indicator {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: var(--gradient-primary);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 3px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-md);
            opacity: 0;
            transition: var(--transition);
            cursor: pointer;
            font-size: 1rem;
        }

        .avatar-edit-indicator:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        .edit-mode-active .avatar-edit-indicator {
            opacity: 1;
        }

        .edit-mode-active .profile-avatar {
            border: 4px solid var(--primary-soft);
            box-shadow: 0 0 0 4px rgba(139, 157, 195, 0.2);
        }

        /* Modern Container Styles */
        .modern-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            min-height: 100vh;
            background: var(--bg-secondary);
        }

        /* Hero Header Section */
        .hero-header {
            background: var(--gradient-primary);
            border-radius: var(--border-radius-lg);
            padding: 3rem 4rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            border-radius: 50%;
            transform: translate(50px, -50px);
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
            margin: 0;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero-subtitle {
            font-size: 1.125rem;
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-weight: 400;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
        }

        /* Main Card Styles */
        .main-card {
            background: var(--bg-primary);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        /* Profile Header Card */
        .profile-header-card {
            background: var(--bg-primary);
            padding: 3rem;
            display: flex;
            align-items: center;
            gap: 3rem;
            border-bottom: 2px solid var(--bg-secondary);
        }

        .avatar-section {
            position: relative;
        }

        .avatar-container {
            position: relative;
            display: inline-block;
        }

        .profile-avatar {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
        }

        .profile-info-section {
            flex: 1;
        }

        .profile-name {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 1rem 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .profile-badges {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-primary {
            background: var(--gradient-primary);
            color: white;
        }

        .badge-secondary {
            background: var(--gradient-secondary);
            color: white;
        }

        .profile-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .meta-item i {
            color: var(--primary-soft);
            font-size: 1.125rem;
        }

        /* File Name Display */
        .file-name-display {
            position: absolute;
            bottom: -45px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gradient-success);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            display: none;
            white-space: nowrap;
            box-shadow: var(--shadow-md);
            z-index: 10;
        }

        /* Profile Details Section */
        .profile-details {
            padding: 3rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 2rem 0;
            display: flex;
            align-items: center;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--bg-secondary);
        }

        .section-title i {
            color: var(--primary-soft);
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .info-item.full-width {
            grid-column: 1 / -1;
        }

        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
        }

        .info-label i {
            color: var(--primary-soft);
        }

        .info-value {
            font-size: 1.125rem;
            color: var(--text-primary);
            font-weight: 500;
            line-height: 1.5;
        }

        .info-value.readonly {
            background: var(--bg-secondary);
            padding: 0.75rem 1rem;
            border-radius: var(--border-radius-sm);
            border: 2px solid var(--border-color);
            color: var(--text-secondary);
        }

        /* Form Controls */
        .form-control-modern {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            font-size: 1rem;
            color: var(--text-primary);
            background: var(--bg-primary);
            transition: var(--transition);
        }

        .form-control-modern:focus {
            outline: none;
            border-color: var(--primary-soft);
            box-shadow: 0 0 0 4px rgba(139, 157, 195, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        /* Edit Mode Toggle */
        .edit-mode {
            display: none;
        }

        /* Form Actions */
        .form-actions {
            display: none;
            justify-content: flex-start;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid var(--bg-secondary);
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
            cursor: pointer;
        }

        .btn-elegant.btn-outline-light {
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-elegant.btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-elegant.btn-success {
            background: var(--gradient-success);
            color: white;
            border-color: var(--success-soft);
        }

        .btn-elegant.btn-success:hover {
            background: linear-gradient(135deg, #81c784, #66bb6a);
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
            box-shadow: var(--shadow-md);
        }

        /* History Section */
        .card-header {
            background: var(--bg-secondary);
            padding: 2rem 3rem;
            border-bottom: 2px solid var(--border-color);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
        }

        .card-title i {
            color: var(--primary-soft);
        }

        .history-tabs {
            background: var(--bg-primary);
            padding: 0 3rem;
            border-bottom: 2px solid var(--bg-secondary);
        }

        .modern-tabs {
            border-bottom: none;
            background: transparent;
            padding: 0;
        }

        .modern-tabs .nav-link {
            padding: 1rem 2rem;
            border: none;
            color: var(--text-secondary);
            font-weight: 600;
            border-bottom: 3px solid transparent;
            background: transparent;
            transition: var(--transition);
            display: flex;
            align-items: center;
        }

        .modern-tabs .nav-link:hover {
            color: var(--primary-soft);
            border-bottom-color: rgba(139, 157, 195, 0.3);
        }

        .modern-tabs .nav-link.active {
            color: var(--primary-soft);
            border-bottom-color: var(--primary-soft);
            background: transparent;
        }

        .modern-tabs .nav-link i {
            margin-right: 0.5rem;
        }

        /* Table Section */
        .table-section {
            background: var(--bg-primary);
        }

        .modern-table-wrapper {
            overflow-x: auto;
            border-radius: 0 0 var(--border-radius-lg) var(--border-radius-lg);
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--bg-primary);
        }

        .modern-table th {
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 1.25rem 1.5rem;
            text-align: left;
            border-bottom: 2px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .modern-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            font-weight: 500;
        }

        .modern-table .table-row {
            transition: var(--transition);
        }

        .modern-table .table-row:hover {
            background: rgba(139, 157, 195, 0.05);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .modern-table .empty-cell {
            text-align: center;
            color: var(--text-muted);
            font-style: italic;
            padding: 3rem;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-badge.status-active {
            background: rgba(165, 214, 167, 0.2);
            color: #2e7d32;
        }

        .status-badge.status-proposed {
            background: rgba(255, 224, 130, 0.2);
            color: #f57c00;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .info-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .modern-container {
                padding: 1rem;
            }

            .hero-content {
                flex-direction: column;
                text-align: center;
                gap: 2rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-actions {
                flex-wrap: wrap;
                justify-content: center;
            }

            .profile-header-card {
                flex-direction: column;
                text-align: center;
                padding: 2rem;
                gap: 2rem;
            }

            .profile-details {
                padding: 2rem;
            }

            .card-header {
                padding: 1.5rem 2rem;
            }

            .history-tabs {
                padding: 0 2rem;
            }

            .modern-tabs .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }

            .modern-table th,
            .modern-table td {
                padding: 1rem;
                font-size: 0.875rem;
            }

            .form-actions {
                flex-direction: column;
                gap: 1rem;
            }

            .btn-elegant {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.75rem;
            }

            .profile-name {
                font-size: 2rem;
            }

            .profile-badges {
                justify-content: center;
            }

            .modern-table {
                font-size: 0.8125rem;
            }

            .modern-table th,
            .modern-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize elements
            const editButton = document.getElementById('edit-button');
            const cancelButton = document.querySelector('.cancel-button');
            const form = document.getElementById('profile-form');
            const viewModeElements = document.querySelectorAll('.view-mode');
            const editModeElements = document.querySelectorAll('.edit-mode');
            const formActions = document.querySelector('.form-actions');
            const profileAvatar = document.getElementById('profile-avatar');
            const avatarInput = document.getElementById('avatar-input');
            const editFoto = document.querySelector('.avatar-edit-indicator');
            const fileNameDisplay = document.getElementById('file-name-display');

            // Toggle edit mode
            editButton.addEventListener('click', function() {
                // Show edit elements
                viewModeElements.forEach(el => el.style.display = 'none');
                editModeElements.forEach(el => el.style.display = 'block');
                formActions.style.display = 'flex';

                // Add edit mode class to avatar container
                document.querySelector('.avatar-container').classList.add('edit-mode-active');

                // Hide edit button
                editButton.style.display = 'none';

                // Add visual feedback
                document.body.classList.add('edit-mode-active');
            });

            // Cancel edit mode
            cancelButton.addEventListener('click', function() {
                // Show view elements
                viewModeElements.forEach(el => el.style.display = 'block');
                editModeElements.forEach(el => el.style.display = 'none');
                formActions.style.display = 'none';

                // Remove edit mode class from avatar container
                document.querySelector('.avatar-container').classList.remove('edit-mode-active');

                // Show edit button
                editButton.style.display = 'inline-flex';

                // Reset avatar and form
                profileAvatar.src = "{{ asset('storage/' . $user->refPegawai?->foto) }}";
                avatarInput.value = '';
                fileNameDisplay.style.display = 'none';
                fileNameDisplay.textContent = '';

                // Remove visual feedback
                document.body.classList.remove('edit-mode-active');

                // Reset form to original values
                form.reset();
            });

            // Avatar edit functionality
            editFoto.addEventListener('click', function() {
                avatarInput.click();
            });

            // Preview avatar when selected
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Please select a valid image file.');
                        return;
                    }

                    // Validate file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size must be less than 2MB.');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        profileAvatar.src = event.target.result;

                        // Show file name with animation
                        fileNameDisplay.textContent = file.name;
                        fileNameDisplay.style.display = 'block';
                        fileNameDisplay.style.transform = 'translateY(10px) translateX(-50%)';
                        fileNameDisplay.style.opacity = '0';

                        setTimeout(() => {
                            fileNameDisplay.style.transform = 'translateY(0) translateX(-50%)';
                            fileNameDisplay.style.opacity = '1';
                        }, 100);
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Reset if no file selected
                    fileNameDisplay.style.display = 'none';
                    fileNameDisplay.textContent = '';
                }
            });

            // Form submission with enhanced UX
            form.addEventListener('submit', function(e) {
                const submitButton = form.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;

                // Show loading state
                submitButton.innerHTML = '<i class="bi bi-arrow-repeat spin me-2"></i>Menyimpan...';
                submitButton.disabled = true;

                // Create FormData for file upload
                const formData = new FormData(form);

                // Add spinner animation
                const style = document.createElement('style');
                style.textContent = `
                    .spin {
                        animation: spin 1s linear infinite;
                    }
                    @keyframes spin {
                        from { transform: rotate(0deg); }
                        to { transform: rotate(360deg); }
                    }
                `;
                document.head.appendChild(style);

                // Clean up file name display
                if (fileNameDisplay) {
                    fileNameDisplay.textContent = '';
                    fileNameDisplay.style.display = 'none';
                }

                // Re-enable button after a delay if form doesn't redirect
                setTimeout(() => {
                    if (submitButton.disabled) {
                        submitButton.innerHTML = originalText;
                        submitButton.disabled = false;
                        if (style.parentNode) {
                            style.parentNode.removeChild(style);
                        }
                    }
                }, 10000);
            });

            // Initialize Bootstrap tabs
            const tabElements = document.querySelectorAll('button[data-bs-toggle="tab"]');
            tabElements.forEach(tabEl => {
                tabEl.addEventListener('click', function(event) {
                    event.preventDefault();

                    // Remove active class from all tabs and panes
                    tabElements.forEach(el => el.classList.remove('active'));
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.remove('show', 'active');
                    });

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Show corresponding pane
                    const targetId = this.getAttribute('data-bs-target');
                    const targetPane = document.querySelector(targetId);
                    if (targetPane) {
                        targetPane.classList.add('show', 'active');
                    }
                });
            });

            // Add smooth scroll to sections
            const sectionLinks = document.querySelectorAll('a[href^="#"]');
            sectionLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add tooltips to status badges and buttons
            const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipElements.forEach(element => {
                new bootstrap.Tooltip(element);
            });

            // Auto-save draft functionality (optional)
            let saveTimeout;
            const formInputs = form.querySelectorAll('input, select, textarea');
            formInputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(saveTimeout);
                    saveTimeout = setTimeout(() => {
                        // Could implement auto-save to localStorage here
                        console.log('Auto-saving draft...');
                    }, 2000);
                });
            });
        });
    </script>
@endsection
