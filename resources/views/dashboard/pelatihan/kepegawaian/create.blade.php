@extends('layouts.pelatihan.pelatihan-dashboard')

@section('title', 'Tambah Pegawai - BKPSDM')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dashboard.pelatihan.kepegawaian.index') }}">Data Kepegawaian</a></li>
        <li class="breadcrumb-item active">Tambah Pegawai</li>
    </ol>
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header border-0 pt-6 bg-transparent">
            <div class="d-flex flex-column">
                <h4 class="fw-bold mb-1">Tambah Pegawai Baru</h4>
                <p class="text-muted mb-0">Lengkapi data pegawai melalui formulir berikut</p>
            </div>
        </div>

        <div class="card-body">
            <!-- Wizard Progress -->
            <div class="d-flex justify-content-between mb-5">
                <div class="w-100 d-flex gap-3">
                    <button class="btn btn-primary flex-grow-1 step-btn active" data-step="1">Data Pribadi</button>
                    <button class="btn btn-light flex-grow-1 step-btn" data-step="2">Data Kepegawaian</button>
                    <button class="btn btn-light flex-grow-1 step-btn" data-step="3">Akun & Akses</button>
                    <button class="btn btn-light flex-grow-1 step-btn" data-step="4">Review</button>
                </div>
            </div>

            <form id="wizardForm" action="#" method="POST">
                @csrf
                <!-- Step 1: Data Pribadi -->
                <div class="wizard-step active" data-step="1">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-solid" name="nama" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">NIP</label>
                            <input type="text" class="form-control form-control-solid" name="nip" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">BIK</label>
                            <input type="text" class="form-control form-control-solid" name="bik" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tempat Lahir</label>
                            <input type="text" class="form-control form-control-solid" name="tempat_lahir" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <input type="date" class="form-control form-control-solid" name="tanggal_lahir" required>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Data Kepegawaian -->
                <div class="wizard-step" data-step="2">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" class="form-control form-control-solid" name="jabatan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Unit Kerja</label>
                            <input type="text" class="form-control form-control-solid" name="unit_kerja" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Esselon</label>
                            <select class="form-select form-select-solid" name="esselon" required>
                                <option value="">Pilih Esselon</option>
                                <option value="II.a">II.a</option>
                                <option value="III.a">III.a</option>
                                <option value="IV.a">IV.a</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Golongan</label>
                            <select class="form-select form-select-solid" name="golongan" required>
                                <option value="">Pilih Golongan</option>
                                <option value="III/a">III/a</option>
                                <option value="III/b">III/b</option>
                                <option value="III/c">III/c</option>
                                <option value="III/d">III/d</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Akun & Akses -->
                <div class="wizard-step" data-step="3">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control form-control-solid" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" class="form-control form-control-solid" name="password_confirmation"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Level Akses</label>
                            <select class="form-select form-select-solid" name="level" required>
                                <option value="">Pilih Level</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Review -->
                <div class="wizard-step" data-step="4">
                    <div class="row g-4">
                        <div class="col-12">
                            <h5 class="fw-bold mb-4">Review Data</h5>
                            <div id="reviewData" class="table-responsive">
                                <!-- Will be filled dynamically -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between mt-5">
                    <button type="button" class="btn btn-light prev-step" style="display: none;">
                        <i class="bi bi-arrow-left me-2"></i>Sebelumnya
                    </button>
                    <button type="button" class="btn btn-primary next-step">
                        Selanjutnya<i class="bi bi-arrow-right ms-2"></i>
                    </button>
                    <button type="submit" class="btn btn-success submit-form" style="display: none;">
                        <i class="bi bi-check-circle me-2"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('additional-css')
    <style>
        .form-label {
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            color: #5e6278;
        }

        .form-control-solid {
            background-color: #f5f8fa;
            border-color: #f5f8fa;
            color: #5e6278;
            transition: color 0.2s ease;
        }

        .form-control-solid:focus {
            background-color: #eef3f7;
            border-color: #009ef7;
            color: #5e6278;
            box-shadow: none;
        }

        .form-select-solid {
            background-color: #f5f8fa;
            border-color: #f5f8fa;
            color: #5e6278;
        }

        .form-select-solid:focus {
            background-color: #eef3f7;
            border-color: #009ef7;
            box-shadow: none;
        }

        .input-group-text {
            border: none;
            font-size: 0.875rem;
        }

        textarea.form-control-solid {
            resize: none;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-radius: 0.475rem;
        }

        .btn-light {
            background-color: #f5f8fa;
            border-color: #f5f8fa;
            color: #7e8299;
        }

        .btn-light:hover {
            background-color: #e4e6ef;
            border-color: #e4e6ef;
            color: #7e8299;
        }

        .wizard-step {
            display: none;
        }

        .wizard-step.active {
            display: block;
        }

        .step-btn {
            position: relative;
            padding: 1rem;
        }

        .step-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -1.5rem;
            width: 1.5rem;
            height: 2px;
            background-color: #e4e6ef;
        }

        .step-btn:last-child::after {
            display: none;
        }

        .step-btn.active {
            background-color: #009ef7;
            color: #fff;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('wizardForm');
            const steps = document.querySelectorAll('.wizard-step');
            const stepBtns = document.querySelectorAll('.step-btn');
            const nextBtn = document.querySelector('.next-step');
            const prevBtn = document.querySelector('.prev-step');
            const submitBtn = document.querySelector('.submit-form');
            let currentStep = 1;

            function showStep(step) {
                steps.forEach(s => s.classList.remove('active'));
                stepBtns.forEach(b => b.classList.remove('active'));

                document.querySelector(`.wizard-step[data-step="${step}"]`).classList.add('active');
                document.querySelector(`.step-btn[data-step="${step}"]`).classList.add('active');

                prevBtn.style.display = step > 1 ? 'block' : 'none';
                nextBtn.style.display = step < 4 ? 'block' : 'none';
                submitBtn.style.display = step === 4 ? 'block' : 'none';

                if (step === 4) {
                    updateReview();
                }
            }

            function updateReview() {
                const formData = new FormData(form);
                let reviewHtml = '<table class="table"><tbody>';

                formData.forEach((value, key) => {
                    if (key !== '_token' && key !== 'password' && key !== 'password_confirmation') {
                        reviewHtml += `
                    <tr>
                        <th class="fw-bold" style="width: 200px">${key.replace('_', ' ').toUpperCase()}</th>
                        <td>${value}</td>
                    </tr>
                `;
                    }
                });

                reviewHtml += '</tbody></table>';
                document.getElementById('reviewData').innerHTML = reviewHtml;
            }

            nextBtn.addEventListener('click', () => {
                currentStep++;
                showStep(currentStep);
            });

            prevBtn.addEventListener('click', () => {
                currentStep--;
                showStep(currentStep);
            });

            form.addEventListener('submit', (e) => {
                e.preventDefault();
                // Handle form submission
            });
        });
    </script>
@endsection
