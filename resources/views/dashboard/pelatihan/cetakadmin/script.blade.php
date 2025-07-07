<script>
    $(document).ready(function() {
        let currentStep = 1;
        const totalSteps = 4;

        // Initialize steps
        updateStepNavigation();

        // Navigation between steps
        $('#btn-next-step').on('click', function() {
            if (currentStep < totalSteps) {
                if (validateStep(currentStep)) {
                    currentStep++;
                    updateStepNavigation();
                }
            }
        });

        $('#btn-prev-step').on('click', function() {
            if (currentStep > 1) {
                currentStep--;
                updateStepNavigation();
            }
        });

        function updateStepNavigation() {
            // Update step dots and titles
            $('.step-item').each(function() {
                const step = parseInt($(this).data('step'));
                const dot = $(this).find('.step-dot');

                if (step < currentStep) {
                    $(this).addClass('completed').removeClass('active');
                    dot.addClass('completed').removeClass('active');
                } else if (step === currentStep) {
                    $(this).addClass('active').removeClass('completed');
                    dot.addClass('active').removeClass('completed');
                } else {
                    $(this).removeClass('active completed');
                    dot.removeClass('active completed');
                }
            });

            // Update progress line
            // $('.progress-line').removeClass('active');
            // In your updateStepNavigation function, add this at the beginning:
            $('.step-progress').attr('data-step', currentStep);

            // Remove the old line activation code since we're now using CSS for the progress line

            // Show active step content
            $('.step-content').removeClass('active').addClass('d-none');
            $(`.step-content[data-step="${currentStep}"]`).addClass('active').removeClass('d-none');

            // Update buttons
            $('#btn-prev-step, #btn-next-step, #btn-submit-cetak').addClass('d-none');
            if (currentStep === 1) {
                // $('#btn-batal').removeClass('d-none');
                $('#btn-next-step').removeClass('d-none');
            } else if (currentStep === 2 || currentStep === 3) {
                $('#btn-prev-step').removeClass('d-none');
                $('#btn-next-step').removeClass('d-none');
            } else if (currentStep === 4) {
                $('#btn-prev-step').removeClass('d-none');
                $('#btn-submit-cetak').removeClass('d-none');
                updateSummaryData();
            }
        }

        function validateStep(step) {
            if (step === 1) {
                if ($('#preview-data-wrapper').hasClass('d-none')) {
                    showAlertModal('Silakan tunggu data termuat terlebih dahulu sebelum melanjutkan',
                        'Warning');
                    return false;
                }
                return true;
            }
            if (step === 2) {
                if ($('#penanggung-manual').is(':checked')) {
                    const nama = $('input[name="penanggungjawab_nama"]').val();
                    const nip = $('input[name="penanggungjawab_nip"]').val();
                    const jabatan = $('input[name="penanggungjawab_jabatan"]').val();
                    const pangkat = $('input[name="penanggungjawab_pangkat"]').val();

                    if (!nama || !nip || !jabatan || !pangkat) {
                        showAlertModal('Silakan isi kolom yang diperlukan', 'Warning');
                        return false;
                    }
                }
                return true;
            }
            return true;
        }

        function updateSummaryData() {
            // Update filter summary
            $('#summary-search').text($('#filter-search').val() || '-');
            $('#summary-unit').text($('#filter-unit option:selected').text() || 'Semua');

            const startDate = $('#filter-start-date').val();
            const endDate = $('#filter-end-date').val();
            $('#summary-date').text(startDate && endDate ? `${startDate} s/d ${endDate}` : '-');

            $('#summary-count').text($('#preview-data-body tr').length);

            // Update penanggung jawab summary
            $('#summary-pj-nama').text($('#penanggungjawab_nama').val());
            $('#summary-pj-nip').text($('#penanggungjawab_nip').val());
            $('#summary-pj-jabatan').text($('#penanggungjawab_jabatan').val());
            $('#summary-pj-pangkat').text($('#penanggungjawab_pangkat').val());

            // Update PDF settings summary
            $('#summary-paper-size').text($('select[name="paper_size"]').val().toUpperCase());
            $('#summary-orientation').text($('select[name="orientation"] option:selected').text());

            const margins = [
                $('input[name="margin_top"]').val() + 'inci (atas)',
                $('input[name="margin_right"]').val() + 'inci (kanan)',
                $('input[name="margin_bottom"]').val() + 'inci (bawah)',
                $('input[name="margin_left"]').val() + 'inci (kiri)'
            ];
            $('#summary-margins').text(margins.join(', '));
        }

        // Handle penanggung jawab mode toggle
        $('input[name="mode_penanggung"]').on('change', function() {
            const isManual = $('#penanggung-manual').is(':checked');
            $('#penanggungjawab_nama').prop('readonly', !isManual);
            $('#penanggungjawab_nip').prop('readonly', !isManual);
            $('#penanggungjawab_jabatan').prop('readonly', !isManual);
            $('#penanggungjawab_pangkat').prop('readonly', !isManual);

            if (!isManual) {
                @if ($user)
                    $('#penanggungjawab_nama').val(@json($user->refPegawai->name ?? ''));
                    $('#penanggungjawab_nip').val(@json($user->nip ?? ''));
                    $('#penanggungjawab_jabatan').val(@json($user->latestUserPivot->jabatan->jabatan ?? ''));
                    $('#penanggungjawab_pangkat').val(@json($user->latestUserPivot->golongan->pangkat_golongan ?? ''));
                @endif
            } else {
                $('#penanggungjawab_nama').val('');
                $('#penanggungjawab_nip').val('');
                $('#penanggungjawab_jabatan').val('');
                $('#penanggungjawab_pangkat').val('');
            }
        });

        // Handle confirmation checkbox
        $('#confirm-check').on('change', function() {
            $('#btn-submit-cetak').prop('disabled', !$(this).is(':checked'));
        });

        // Fetch data for preview
        function fetchData() {
            let search = $('#filter-search').val();
            let unit = $('#filter-unit').val();
            let start = $('#filter-start-date').val();
            let end = $('#filter-end-date').val();

            $.ajax({
                url: "{{ route('dashboard.pelatihan.pendaftaran.preview-admin') }}",
                type: "GET",
                data: {
                    search: search,
                    unit_id: unit,
                    start: start,
                    end: end
                },
                success: function(response) {
                    const tbody = $('#preview-data-body');
                    tbody.empty();

                    if (response.data.length > 0) {
                        response.data.forEach(item => {
                            tbody.append(`
                                <tr>
                                    <td>${item.user_nip ?? '-'}</td>
                                    <td>${item.user?.ref_pegawai?.name ?? '-'}</td>
                                    <td>${item.tersedia?.nama_pelatihan ?? item.usulan?.nama_pelatihan ?? '-'}</td>
                                    <td>${item.user?.latest_user_pivot?.unit_kerja?.unitkerja?.unitkerja ?? '-'}</td>
                                    <td>${item.tersedia ? 'Pelatihan Umum' : (item.usulan ? 'Pelatihan Khusus' : '-')}</td>
                                </tr>
                            `);
                        });

                        $('#count-total').text(response.data.length);
                        $('#preview-data-count').removeClass('d-none');
                        $('#input-search').val(search);
                        $('#input-unit').val(unit);
                        $('#input-start-date').val(start);
                        $('#input-end-date').val(end);
                        $('#preview-data-wrapper').removeClass('d-none');
                        $('#preview-empty').addClass('d-none');
                    } else {
                        $('#preview-data-body').empty();
                        $('#preview-data-wrapper').addClass('d-none');
                        $('#preview-data-count').addClass('d-none');
                        $('#preview-empty').removeClass('d-none');
                        showAlertModal('Tidak ada data yang cocok.', 'Warning');
                    }
                },
                error: function() {
                    $('#preview-data-body').empty();
                    $('#preview-data-wrapper').addClass('d-none');
                    $('#preview-data-count').addClass('d-none');
                    $('#preview-empty').removeClass('d-none');
                    showAlertModal('Gagal memuat data.', 'Error');
                }
            });
        }

        // Initialize data
        fetchData();
        @if ($user)
            $('#penanggungjawab_nama').val(@json($user->refPegawai->name ?? ''));
            $('#penanggungjawab_nip').val(@json($user->nip ?? ''));
            $('#penanggungjawab_jabatan').val(@json($user->latestUserPivot->jabatan->jabatan ?? ''));
            $('#penanggungjawab_pangkat').val(@json($user->latestUserPivot->golongan->pangkat_golongan ?? ''));
        @endif

        // Event listeners for filters
        let delayTimer;
        $('#filter-search').on('input', function() {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                fetchData();
            }, 300);
        });

        $('#filter-unit, #filter-start-date, #filter-end-date').on('change', function() {
            fetchData();
        });
    });
</script>
