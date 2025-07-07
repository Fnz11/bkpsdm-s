@extends('layouts.pelatihan.app')

@section('title', 'Edit Profil')

@section('content')
    <main class="profile-container">
                <form action="{{ route('pelatihan.profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-card">
                    @csrf
                    @method('PUT')

                    <div class="profile-header">
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil" class="profile-avatar">
                        <div class="profile-info">
                            <h1>Edit Profil</h1>
                            <span class="profile-badge">{{ $user->role }}</span>
                        </div>
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <label class="form-label fw-bold">NIP</label>
                            <input type="text" class="form-control form-control-solid" value="{{ $user->nip }}" readonly>
                        </div>
                        <div class="info-item">
                            <label class="form-label fw-bold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control form-control-solid" value="{{ $user->refPegawai->tempat_lahir }}">
                        </div>
                        <div class="info-item">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control form-control-solid" value="{{ $user->refPegawai->tanggal_lahir }}">
                        </div>
                        <div class="info-item">
                            <label class="form-label fw-bold">Pangkat / Golongan</label>
                            <input type="text" name="pangkat" class="form-control form-control-solid" value="{{ $user->latestUserPivot->golongan->pangkat }} / {{ $user->latestUserPivot->golongan->golongan }}" readonly>
                        </div>
                        <div class="info-item">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control form-control-solid" value="{{ $user->latestUserPivot->jabatan->jabatan }}" readonly>
                        </div>
                        <div class="info-item">
                            <label class="form-label fw-bold">Unit Kerja</label>
                            <input type="text" name="unitkerja" class="form-control form-control-solid" value="{{ $user->latestUserPivot->unitKerja->unitkerja->unitkerja }}" readonly>
                        </div>
                        <div class="info-item">
                            <label class="form-label fw-bold">No. WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control form-control-solid" value="{{ $user->refPegawai->no_hp }}">
                        </div>
                        <div class="info-item">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control form-control-solid" value="{{ $user->email }}">
                        </div>
                        <div class="info-item" style="grid-column: span 2;">
                            <label class="form-label fw-bold">Alamat</label>
                            <textarea name="alamat" class="form-control form-control-solid" rows="3">{{ $user->refPegawai->alamat }}</textarea>
                        </div>
                        <div class="info-item" style="grid-column: span 2;">
                            <label class="form-label fw-bold">Foto Baru (Opsional)</label>
                            <input type="file" name="foto" accept="image/*">
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light" onclick="window.history.back()">
                                <i class="bi bi-arrow-left me-2"></i>Batal
                            </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>
                        Simpan Perubahan
                    </button>
                    </div>
                </form>
    </main>
@endsection


@section('additional-css')
    <style>
        :root {
            --primary-color: #001f4d;
            --secondary-color: #3b67e9;
            --text-color: #2d3748;
            --light-text: #718096;
            --background-color: #f7fafc;
            --border-color: #e2e8f0;
            --hover-color: #2d4ed8;
            --transition: all 0.3s ease;
        }

        .profile-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .profile-header {
            background: #fff;
            border-radius: 1.5rem;
            padding: 3rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 31, 77, 0.05);
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .profile-avatar {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 31, 77, 0.1);
        }

        .profile-info h1 {
            font-family: "Kanit", sans-serif;
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .profile-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--secondary-color);
            color: #fff;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-card {
            background: #fff;
            border-radius: 1.5rem;
            padding: 3rem;
            box-shadow: 0 4px 20px rgba(0, 31, 77, 0.05);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .edit-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: var(--secondary-color);
            color: #fff;
            border: none;
            border-radius: 0.75rem;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
            margin-top: 2rem;
        }

        .edit-button:hover {
            background-color: var(--hover-color);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {

            .profile-header {
                flex-direction: column;
                text-align: center;
                padding: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .profile-card {
                padding: 2rem;
            }
        }
    </style>
@endsection

