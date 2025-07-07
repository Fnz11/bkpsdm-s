@extends('layouts.pelatihan.pengaturandasar')

@section('title', 'Edit Pegawai')

@section('additional-css-pengaturandasar')
    <style>
        .form-control-solid {
            background-color: #f4f6f9;
            border: 1px solid #e4e6ef;
            transition: all 0.2s ease;
        }

        .form-control-solid:focus {
            background-color: #fff;
            border-color: #009ef7;
            box-shadow: 0 0 0 0.2rem rgba(0, 158, 247, 0.25);
        }

        .wizard-step {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .wizard-step.active {
            display: block;
            opacity: 1;
        }

        .step-btn {
            position: relative;
            background-color: #f8f9fa;
            color: #6c757d;
            border: 1px solid #dee2e6;
            font-weight: 600;
            border-radius: 2rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
        }

        .step-btn.active {
            background-color: #009ef7;
            color: #fff;
            border-color: #009ef7;
            box-shadow: 0 0 0.25rem rgba(0, 158, 247, 0.5);
        }

        .step-btn.complete {
            background-color: #28a745 !important;
            color: white !important;
            border-color: #28a745 !important;
        }

        .step-btn.complete::after {
            content: '✓';
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #28a745;
            color: white;
            font-size: 0.75rem;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #28a745;
        }

        .step-btn.active {
            background-color: #009ef7 !important;
            color: #fff !important;
            border-color: #009ef7 !important;
            box-shadow: 0 0 0.25rem rgba(0, 158, 247, 0.5);
        }

        .step-btn.complete:not(.active) {
            background-color: #28a745 !important;
            color: white !important;
            border-color: #28a745 !important;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>
@endsection

@section('pengaturandasar-content')
    <div class="card border-0 shadow-sm p-3">
        <div class="card-header border-0 pt-6 bg-transparent">
            <div class="d-flex flex-column">
                <h4 class="fw-bold mb-1">Edit Data Pegawai</h4>
                <p class="text-muted mb-0">Perbarui data pegawai melalui formulir berikut</p>
            </div>
        </div>

        <div class="card-body">
            <!-- Wizard Progress -->
            <div class="d-flex justify-content-center mb-5">
                <div class="w-100 d-flex flex-wrap gap-3 justify-content-between">
                    <button class="btn step-btn flex-fill active complete" data-step="1">
                        <i class="bi bi-person-circle me-1"></i> Data Pribadi
                    </button>
                    <button class="btn step-btn flex-fill complete" data-step="2">
                        <i class="bi bi-briefcase-fill me-1"></i> Data Kepegawaian
                    </button>
                    <button class="btn step-btn flex-fill complete" data-step="3">
                        <i class="bi bi-lock-fill me-1"></i> Akun & Akses
                    </button>
                    <button class="btn step-btn flex-fill" data-step="4">
                        <i class="bi bi-check2-circle me-1"></i> Review
                    </button>
                </div>
            </div>

            <form id="wizardForm" action="{{ route('dashboard.pelatihan.pegawai.update', $pegawai->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Step 1: Data Pribadi -->
                <div class="wizard-step active" data-step="1">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold position-relative required-label">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-solid" name="name"
                                value="{{ old('name', $pegawai->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold position-relative required-label">NIP</label>
                            <input type="text" class="form-control form-control-solid" name="nip"
                                value="{{ old('nip', $pegawai->nip) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold position-relative required-label">Tempat Lahir</label>
                            <input type="text" class="form-control form-control-solid" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $pegawai->tempat_lahir) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold position-relative required-label">Tanggal Lahir</label>
                            <input type="date" class="form-control form-control-solid" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->format('Y-m-d') : '') }}"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold position-relative required-label">Alamat</label>
                            <input type="text" class="form-control form-control-solid" name="alamat"
                                value="{{ old('alamat', $pegawai->alamat) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold position-relative required-label">Nomor HP</label>
                            <input type="text" class="form-control form-control-solid" name="no_hp"
                                value="{{ old('no_hp', $pegawai->no_hp) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Atasan</label>
                            <select class="form-select form-select-solid select2" id="atasan" name="nip_atasan">
                                <option value="">Pilih Atasan</option>
                                @foreach ($atasans as $ats)
                                    <option value="{{ $ats->nip }}"
                                        {{ old('nip_atasan', $pegawai->nip_atasan) == $ats->nip ? 'selected' : '' }}>
                                        {{ $ats->nip }} - {{ $ats->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Foto</label>
                            <input type="file" class="form-control form-control-solid" name="foto" accept="image/*">
                            @if ($pegawai->foto)
                                <img src="{{ asset('storage/' . $pegawai->foto) }}" class="img-thumbnail mt-2"
                                    width="100">
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Step 2: Data Kepegawaian -->
                <div class="wizard-step" data-step="2">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold position-relative required-label">Unit Kerja</label>
                            <select class="form-select form-select-solid select2" id="unitkerja-select" name="id_unitkerja"
                                required>
                                @foreach ($unitkerjas as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ old('id_unitkerja', $pivot->unitKerja->unitkerja_id) == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->unitkerja }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold position-relative required-label">Sub Unit Kerja</label>
                            <select class="form-select form-select-solid" id="subunitkerja-select" name="id_subunitkerja"
                                required>
                                @foreach ($subunitkerjas as $sub)
                                    <option value="{{ $sub->id }}" data-parent="{{ $sub->unitkerja_id }}"
                                        {{ old('id_subunitkerja', $pivot->id_unitkerja) == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->sub_unitkerja }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold position-relative required-label">Jabatan</label>
                            <select class="form-select form-select-solid select2" id="jabatan" name="id_jabatan" required>
                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}"
                                        {{ old('id_jabatan', $pivot->id_jabatan) == $jabatan->id ? 'selected' : '' }}>
                                        {{ $jabatan->jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold position-relative required-label">Golongan</label>
                            <select class="form-select form-select-solid select2" id="golongan" name="id_golongan"
                                required>
                                @foreach ($golongans as $golongan)
                                    <option value="{{ $golongan->id }}"
                                        {{ old('id_golongan', $pivot->id_golongan) == $golongan->id ? 'selected' : '' }}>
                                        {{ $golongan->pangkat_golongan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold position-relative required-label">Tanggal Mulai</label>
                            <input type="date" class="form-control form-control-solid" name="tgl_mulai"
                                value="{{ old('tgl_mulai', $pivot->tgl_mulai ? \Carbon\Carbon::parse($pivot->tgl_mulai)->format('Y-m-d') : '') }}"
                                required>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Akun & Akses -->
                <div class="wizard-step" data-step="3">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold position-relative required-label">Email</label>
                            <input type="email" class="form-control form-control-solid" name="email"
                                value="{{ old('email', $pegawai->user->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold position-relative required-label">Level Akses</label>
                            <select class="form-select form-select-solid" name="role" required>
                                <option value="admin"
                                    {{ old('role', $pegawai->user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="asn" {{ old('role', $pegawai->user->role) == 'asn' ? 'selected' : '' }}>
                                    User</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Password Baru <small>(kosongkan jika tidak
                                    ganti)</small></label>
                            <input type="password" class="form-control form-control-solid" name="password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" class="form-control form-control-solid" name="password_confirmation">
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
                <div class="d-flex justify-content-between align-items-center mt-5 gap-2">
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.pelatihan.pegawai') }}" class="btn btn-secondary cancel-btn">
                            <i class="bi bi-arrow-left me-2"></i>Batal
                        </a>
                        <button type="button" class="btn btn-secondary prev-step" style="display: none;">
                            <i class="bi bi-arrow-left me-2"></i>Sebelumnya
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary next-step">
                            Selanjutnya<i class="bi bi-arrow-right ms-2"></i>
                        </button>
                        <button type="submit" class="btn btn-success submit-form" style="display: none;">
                            <i class="bi bi-check-circle me-2"></i>Update Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts-pengaturandasar')
    <script>
        $(document).ready(function() {
            // Select2 setup
            $('#unitkerja-select, #jabatan, #golongan, #atasan').select2({
                theme: 'bootstrap4',
                placeholder: function() {
                    return $(this).attr('placeholder');
                },
                allowClear: true,
                width: '100%'
            });

            // Dependent Dropdown
            $('#unitkerja-select').on('change', function() {
                const selectedUnit = $(this).val();
                $('#subunitkerja-select option').each(function() {
                    const parent = $(this).data('parent');
                    $(this).toggle(!selectedUnit || parent == selectedUnit);
                });
                $('#subunitkerja-select').val(null).trigger('change');
            });

            // Initialize with current unit kerja
            const currentUnit = $('#unitkerja-select').val();
            if (currentUnit) {
                $('#subunitkerja-select option').each(function() {
                    const parent = $(this).data('parent');
                    $(this).toggle(!currentUnit || parent == currentUnit);
                });
            }

            const form = $('#wizardForm');
            const steps = $('.wizard-step');
            const stepBtns = $('.step-btn');
            const cancelBtn = $('.cancel-btn');
            const nextBtn = $('.next-step');
            const prevBtn = $('.prev-step');
            const submitBtn = $('.submit-form');
            let currentStep = 1;
            const totalSteps = steps.length;

            // Mark all steps as complete except current step
            stepBtns.addClass('complete');
            $(`.step-btn[data-step="${currentStep}"]`).removeClass('complete').addClass('active');

            function showStep(step) {
                steps.removeClass('active');
                stepBtns.removeClass('active');

                $(`.wizard-step[data-step="${step}"]`).addClass('active');

                // Set active tab and ensure it's blue
                const activeTab = $(`.step-btn[data-step="${step}"]`);
                activeTab.addClass('active').removeClass('complete');

                // Set other complete tabs to green
                stepBtns.not(activeTab).addClass('complete');

                cancelBtn.toggle(step === 1);
                prevBtn.toggle(step > 1);
                nextBtn.toggle(step < totalSteps);
                submitBtn.toggle(step === totalSteps);

                if (step === totalSteps) updateReview();
            }

            function validateStep(step) {
                let valid = true;
                const fields = $(`.wizard-step[data-step="${step}"]`).find(
                    'input[required], select[required], textarea[required]');

                fields.each(function() {
                    if (!$(this).val()) {
                        $(this).addClass('is-invalid');
                        valid = false;
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                return valid;
            }

            function updateReview() {
                const formData = new FormData(form[0]);
                let reviewHtml = '<table class="table table-bordered"><tbody>';
                formData.forEach((value, key) => {
                    if (!['_token', '_method', 'password', 'password_confirmation'].includes(key)) {
                        reviewHtml +=
                            `<tr><th>${key.replace(/_/g, ' ').toUpperCase()}</th><td>${value || '-'}</td></tr>`;
                    }
                });
                reviewHtml += '</tbody></table>';
                $('#reviewData').html(reviewHtml);
            }

            stepBtns.on('click', function(e) {
                const targetStep = parseInt($(this).data('step'));

                // Cegah loncat ke step selanjutnya jika belum valid
                if (targetStep > currentStep) {
                    if (!validateStep(currentStep)) {
                        showAlertModal("Harap lengkapi semua kolom wajib sebelum melanjutkan.");
                        e.preventDefault();
                        return;
                    }
                }

                currentStep = targetStep;
                showStep(currentStep);
            });

            nextBtn.on('click', function() {
                if (validateStep(currentStep)) {
                    if (currentStep < totalSteps) currentStep++;
                    showStep(currentStep);
                } else {
                    showAlertModal("Harap lengkapi semua kolom wajib sebelum melanjutkan.");
                }
            });

            prevBtn.on('click', function() {
                if (currentStep > 1) currentStep--;
                showStep(currentStep);
            });

            submitBtn.on('click', function(e) {
                let valid = true;
                form.find('input[required], select[required], textarea[required]').each(function() {
                    if (!$(this).val()) {
                        valid = false;
                        $(this).addClass('is-invalid');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    showAlertModal("Harap lengkapi semua kolom yang bertanda * sebelum menyimpan data.");
                } else {
                    form.submit();
                }
            });

            // Initialize first step
            showStep(currentStep);
        });
    </script>
@endsection
