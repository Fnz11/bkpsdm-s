<script>
    let delayTimer;
    let lastQuery = '';
    let currentJenis = '';

    $('#modalCetak, #modalExcel').on('shown.bs.modal', function() {
        $(this).find('.select2').select2({
            dropdownParent: $(this),
            theme: 'bootstrap4',
            width: '100%',
            placeholder: 'Cari & Pilih Unit Kerja',
            allowClear: true
        });
    });

    // Clear Search
    $('#filter-search').on('input', function() {
        if ($(this).val().length > 0) {
            $('#clear-search').show();
        } else {
            $('#clear-search').hide();
        }
    });

    $('#clear-search').on('click', function() {
        $('#filter-search').val('').trigger('keyup');
        $(this).hide();
    });

    // Live search
    $('#filter-search').on('keyup', function(e) {
        const ignoredKeys = ['Shift', 'Control', 'Alt', 'Meta', 'ArrowLeft', 'ArrowRight', 'ArrowUp',
            'ArrowDown'
        ];
        if (ignoredKeys.includes(e.key)) {
            return;
        }

        clearTimeout(delayTimer);
        let query = $(this).val().trim();

        // Toggle visibility clear button
        $('#clear-search').toggle(query.length > 0);

        delayTimer = setTimeout(function() {
            if (query !== lastQuery) {
                lastQuery = query;
                fetchData();
            }
        }, 300);
    });

    $('#filter-unit, #filter-status-verif, #filter-status-peserta, #filter-start-date, #filter-end-date').on('change',
        function() {
            fetchData();
        });

    // Pagination AJAX
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        fetchData(page);
    });

    // Toggle Column
    $('.toggle-col').on('change', function() {
        applyColumnToggles();
    });

    // Fetch Data
    function fetchData(page = 1) {
        $('#pendaftaran-table').addClass('d-none');
        $('#loading-spinner').removeClass('d-none');
        $('.pagination a').addClass('disabled');

        $.ajax({
            url: "{{ route('dashboard.pelatihan.pendaftaran') }}",
            type: "GET",
            data: {
                search: $('#filter-search').val(),
                unit_id: $('#filter-unit').val(),
                verif: $('#filter-status-verif').val(),
                peserta: $('#filter-status-peserta').val(),
                start_date: $('#filter-start-date').val(),
                end_date: $('#filter-end-date').val(),
                page: page,
            },
            success: function(response) {
                $('#pendaftaran-table').html($(response).find('#pendaftaran-table').html());
                $('#pagination-wrapper').html($(response).find('#pagination-wrapper').html());
                applyColumnToggles();
            },
            complete: function() {
                $('#pendaftaran-table').removeClass('d-none');
                $('#loading-spinner').addClass('d-none');
                $('.pagination a').removeClass('disabled');
            }
        });
    }

    // Toggle Column Visibility
    function applyColumnToggles() {
        $('.toggle-col').each(function() {
            const target = $(this).data('target');
            const selector = '.col-' + target;

            if (!$(this).is(':checked')) {
                $(selector).hide();
            } else {
                $(selector).show();
            }
        });
    }

    document.getElementById('btn-reset-filter').addEventListener('click', function() {
        if ($('#filter-search').val().length > 0 ||
            $('#filter-unit').val() !== '' ||
            $('#filter-status-verif').val() !== '' ||
            $('#filter-status-peserta').val() !== '' ||
            $('#filter-start-date').val() !== '' ||
            $('#filter-end-date').val() !== '') {

            // Reset semua input dan select
            document.getElementById('filter-search').value = '';
            document.getElementById('filter-unit').value = '';
            document.getElementById('filter-status-verif').value = '';
            document.getElementById('filter-status-peserta').value = '';
            // Reset tanggal
            document.getElementById('filter-start-date').value = '';
            document.getElementById('filter-end-date').value = '';

            // Sembunyikan tombol clear
            $('#clear-search').hide();

            fetchData();
        }
    });

    // PDF
    $(document).ready(function() {
        let currentStep = 1;
        const totalSteps = 4;

        // Initialize steps
        updateStepNavigation();

        // Navigation between steps
        $('#btn-next-step').on('click', function() {
            if (currentStep < totalSteps) {
                // Validate current step before proceeding
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

            // Update connecting lines
            // $('.progress-line').removeClass('active');
            // if (currentStep > 0) $('.line-1').addClass('active');
            // if (currentStep > 1) $('.line-2').addClass('active');
            // if (currentStep > 2) $('.line-3').addClass('active');
            // if (currentStep > 3) $('.line-4').addClass('active');
            $('.step-progress-pdf').attr('data-step', currentStep);

            // Show active step content
            $('.step-content').removeClass('active').addClass('d-none');
            $(`.step-content[data-step="${currentStep}"]`).addClass('active').removeClass('d-none');

            // Update buttons
            $('#btn-batal, #btn-prev-step, #btn-next-step, #btn-submit-cetak').addClass('d-none');
            if (currentStep === 1) {
                $('#btn-batal').removeClass('d-none');
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
                // Validate filter step
                if ($('#preview-data-wrapper').hasClass('d-none')) {
                    showAlertModal('Silakan tunggu data termuat terlebih dahulu sebelum melanjutkan',
                        'Warning');
                    return false;
                }
                return true;
            }
            if (step === 2) {
                // Validate penanggung jawab step
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
            $('#summary-search').text($('#filter-modal-search').val() || '-');
            $('#summary-unit').text($('#filter-modal-unit option:selected').text() || 'Semua');
            $('#summary-verif').text($('#filter-modal-verif option:selected').text() || 'Semua');
            $('#summary-peserta').text($('#filter-modal-peserta option:selected').text() || 'Semua');

            const startDate = $('#filter-modal-start-date').val();
            const endDate = $('#filter-modal-end-date').val();
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
                $('input[name="margin_top"]').val() + 'in (atas)',
                $('input[name="margin_right"]').val() + 'in (kanan)',
                $('input[name="margin_bottom"]').val() + 'in (bawah)',
                $('input[name="margin_left"]').val() + 'in (kiri)'
            ];
            $('#summary-margins').text(margins.join(', '));
            $('#summary-header').text($('#show_header').is(':checked') ? 'Aktif' : 'Nonaktif');
            $('#summary-footer').text($('#show_footer').is(':checked') ? 'Aktif' : 'Nonaktif');
            $('#summary-signature').text($('#show_signature').is(':checked') ? 'Aktif' : 'Nonaktif');
        }

        // Modified confirmation checkbox handler
        $('#confirm-check').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#btn-submit-cetak').prop('disabled', !isChecked);

            // When on the last step (step 4) and checkbox is checked, mark the step as completed
            if (currentStep === 4) {
                const lastStepItem = $('.step-item[data-step="4"]');
                const lastStepDot = lastStepItem.find('.step-dot');

                if (isChecked) {
                    lastStepItem.addClass('completed active');
                    lastStepDot.addClass('completed active');
                } else {
                    lastStepItem.removeClass('completed').addClass('active');
                    lastStepDot.removeClass('completed').addClass('active');
                }
            }
        });

        // Existing code for penanggung jawab mode toggle
        $('input[name="mode_penanggung"]').on('change', function() {
            const isManual = $('#penanggung-manual').is(':checked');
            $('#penanggungjawab_nama').prop('readonly', !isManual);
            $('#penanggungjawab_nip').prop('readonly', !isManual);
            $('#penanggungjawab_jabatan').prop('readonly', !isManual);
            $('#penanggungjawab_pangkat').prop('readonly', !isManual);

            if (isManual) {
                $('#penanggungjawab_nama').val('');
                $('#penanggungjawab_nip').val('');
                $('#penanggungjawab_jabatan').val('');
                $('#penanggungjawab_pangkat').val('');
            } else {
                @if ($user)
                    $('#penanggungjawab_nama').val(@json($user->refPegawai->name ?? ''));
                    $('#penanggungjawab_nip').val(@json($user->nip ?? ''));
                    $('#penanggungjawab_jabatan').val(@json($user->latestUserPivot->jabatan->jabatan ?? ''));
                    $('#penanggungjawab_pangkat').val(@json($user->latestUserPivot->golongan->pangkat_golongan ?? ''));
                @endif
            }
        });

        $('#filter-modal-search, #penanggungjawab_nama, #penanggungjawab_nip, #penanggungjawab_jabatan, #penanggungjawab_pangkat')
            .on('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); // Cegah submit atau pindah field
                    return false;
                }
            });

        function fetchDataModal() {
            // Ambil nilai filter saat ini
            let search = $('#filter-modal-search').val();
            let unit = $('#filter-modal-unit').val();
            let verif = $('#filter-modal-verif').val();
            let peserta = $('#filter-modal-peserta').val();
            let start = $('#filter-modal-start-date').val();
            let end = $('#filter-modal-end-date').val();

            // Jalankan preview otomatis
            $.ajax({
                url: "{{ route('dashboard.pelatihan.pendaftaran.preview') }}",
                type: "GET",
                data: {
                    search: search,
                    unit_id: unit,
                    verif: verif,
                    peserta: peserta,
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
                        $('#input-verif').val(verif);
                        $('#input-peserta').val(peserta);
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
                    // Kosongkan dan sembunyikan tabel preview
                    $('#preview-data-body').empty();
                    $('#preview-data-wrapper').addClass('d-none');
                    $('#preview-data-count').addClass('d-none');
                    $('#preview-empty').removeClass('d-none');
                    showAlertModal('Gagal memuat data.', 'Error');
                }
            });
        }

        const modal = document.getElementById('modalCetak');
        modal.addEventListener('shown.bs.modal', function() {
            // Simulasikan pengisian otomatis dari backend
            @if ($user)
                $('#penanggungjawab_nama').val(@json($user->refPegawai->name ?? ''));
                $('#penanggungjawab_nip').val(@json($user->nip ?? ''));
                $('#penanggungjawab_jabatan').val(@json($user->latestUserPivot->jabatan->jabatan ?? ''));
                $('#penanggungjawab_pangkat').val(@json($user->latestUserPivot->golongan->pangkat_golongan ?? ''));
            @endif

            fetchDataModal();
        });

        $('#filter-modal-search').on('input', function() {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                fetchDataModal();
            }, 300);
        });

        $('#filter-modal-unit, #filter-modal-verif, #filter-modal-peserta, #filter-modal-start-date, #filter-modal-end-date')
            .on('change',
                function() {
                    fetchDataModal();
                });

        modal.addEventListener('hidden.bs.modal', function() {
            // Reset all steps
            currentStep = 1;
            updateStepNavigation();

            // Reset input pencarian dan filter
            $('#filter-modal-search').val('');
            // $('#filter-modal-unit').val('');
            $('#filter-modal-verif').val('');
            $('#filter-modal-peserta').val('');
            $('#filter-modal-start-date').val('');
            $('#filter-modal-end-date').val('');

            // Kosongkan dan sembunyikan tabel preview
            $('#preview-data-body').empty();
            $('#preview-data-wrapper').addClass('d-none');
            $('#preview-data-count').addClass('d-none');
            $('#preview-empty').removeClass('d-none');

            // Reset form penanggung jawab
            $('#penanggung-manual').prop('checked', false);
            $('#penanggung-otomatis').prop('checked', true);
            $('#penanggung-manual-fields').addClass('d-none');
            $('input[name="penanggungjawab_nama"]').val('');
            $('input[name="penanggungjawab_nip"]').val('');
            $('input[name="penanggungjawab_jabatan"]').val('');
            $('input[name="penanggungjawab_pangkat"]').val('');

            // Reset hidden inputs
            $('#input-search').val('');
            $('#input-unit').val('');

            // Reset summary
            $('#summary-data').empty();
        });
    });

    // Excel
    $(document).ready(function() {
        // Initialize Excel modal
        const modalExcel = document.getElementById('modalExcel');
        if (modalExcel) {
            let currentStepExcel = 1;
            const totalStepsExcel = 3;

            // Initialize steps
            updateStepNavigationExcel();

            // Navigation between steps
            $('#btn-next-step-excel').on('click', function() {
                if (currentStepExcel < totalStepsExcel) {
                    if (validateStepExcel(currentStepExcel)) {
                        currentStepExcel++;
                        updateStepNavigationExcel();
                    }
                }
            });

            $('#btn-prev-step-excel').on('click', function() {
                if (currentStepExcel > 1) {
                    currentStepExcel--;
                    updateStepNavigationExcel();
                }
            });

            function updateStepNavigationExcel() {
                // Update step dots and titles
                $('.step-item', modalExcel).each(function() {
                    const step = parseInt($(this).data('step'));
                    const dot = $(this).find('.step-dot');

                    if (step < currentStepExcel) {
                        $(this).addClass('completed').removeClass('active');
                        dot.addClass('completed').removeClass('active');
                    } else if (step === currentStepExcel) {
                        $(this).addClass('active').removeClass('completed');
                        dot.addClass('active').removeClass('completed');
                    } else {
                        $(this).removeClass('active completed');
                        dot.removeClass('active completed');
                    }
                });

                // Update connecting lines
                // $('.progress-line', modalExcel).removeClass('active');
                // if (currentStepExcel > 0) $('.line-2-1', modalExcel).addClass('active');
                // if (currentStepExcel > 1) $('.line-2-2', modalExcel).addClass('active');
                // if (currentStepExcel > 2) $('.line-2-3', modalExcel).addClass('active');
                $('.step-progress-excel').attr('data-step', currentStepExcel);

                // Show active step content
                $('.step-content', modalExcel).removeClass('active').addClass('d-none');
                $(`.step-content[data-step="${currentStepExcel}"]`, modalExcel).addClass('active').removeClass(
                    'd-none');

                // Update buttons
                $('#btn-batal-excel, #btn-prev-step-excel, #btn-next-step-excel, #btn-submit-excel', modalExcel)
                    .addClass('d-none');
                if (currentStepExcel === 1) {
                    $('#btn-batal-excel', modalExcel).removeClass('d-none');
                    $('#btn-next-step-excel', modalExcel).removeClass('d-none');
                } else if (currentStepExcel === 2) {
                    $('#btn-prev-step-excel', modalExcel).removeClass('d-none');
                    $('#btn-next-step-excel', modalExcel).removeClass('d-none');
                } else if (currentStepExcel === 3) {
                    $('#btn-prev-step-excel', modalExcel).removeClass('d-none');
                    $('#btn-submit-excel', modalExcel).removeClass('d-none');
                    updateSummaryDataExcel();
                }
            }

            function validateStepExcel(step) {
                if (step === 1) {
                    if ($('#preview-data-wrapper-excel').hasClass('d-none')) {
                        showAlertModal('Silakan tunggu data termuat terlebih dahulu sebelum melanjutkan',
                            'Warning');
                        return false;
                    }
                    return true;
                }
                return true;
            }

            function updateSummaryDataExcel() {
                // Update filter summary
                $('#summary-search-excel').text($('#filter-modal-search-excel').val() || '-');
                $('#summary-unit-excel').text($('#filter-modal-unit-excel option:selected').text() || 'Semua');
                $('#summary-verif-excel').text($('#filter-modal-verif-excel option:selected').text() ||
                    'Semua');
                $('#summary-peserta-excel').text($('#filter-modal-peserta-excel option:selected').text() ||
                    'Semua');

                const startDate = $('#filter-modal-start-date-excel').val();
                const endDate = $('#filter-modal-end-date-excel').val();
                $('#summary-date-excel').text(startDate && endDate ? `${startDate} s/d ${endDate}` : '-');

                $('#summary-count-excel').text($('#preview-data-body-excel tr').length);

                // Update excel settings summary
                $('#summary-format').text($('select[name="file_format"] option:selected').text());
                $('#summary-header').text($('#include_header').is(':checked') ? 'Ya' : 'Tidak');

                const selectedColumns = $('input[name="columns[]"]:checked').length;
                $('#summary-columns').text(`${selectedColumns} kolom`);
            }

            // Handle column selection change
            $('input[name="columns[]"]').on('change', function() {
                if ($(this).is(':checked') && $(this).val() === 'nip') {
                    // Ensure NIP is always included if checked
                    $('#col_nip').prop('checked', true);
                }
            });

            // Modified confirmation checkbox handler
            $('#confirm-check-excel').on('change', function() {
                const isChecked = $(this).is(':checked');
                $('#btn-submit-excel').prop('disabled', !isChecked);

                // When on the last step (step 4) and checkbox is checked, mark the step as completed
                if (currentStepExcel === 3) {
                    const lastStepItem = $('.step-item[data-step="3"]');
                    const lastStepDot = lastStepItem.find('.step-dot');

                    if (isChecked) {
                        lastStepItem.addClass('completed active');
                        lastStepDot.addClass('completed active');
                    } else {
                        lastStepItem.removeClass('completed').addClass('active');
                        lastStepDot.removeClass('completed').addClass('active');
                    }
                }
            });

            // Filter functionality
            function fetchDataModalExcel() {
                let search = $('#filter-modal-search-excel').val();
                let unit = $('#filter-modal-unit-excel').val();
                let verif = $('#filter-modal-verif-excel').val();
                let peserta = $('#filter-modal-peserta-excel').val();
                let start = $('#filter-modal-start-date-excel').val();
                let end = $('#filter-modal-end-date-excel').val();

                $.ajax({
                    url: "{{ route('dashboard.pelatihan.pendaftaran.preview') }}",
                    type: "GET",
                    data: {
                        search: search,
                        unit_id: unit,
                        verif: verif,
                        peserta: peserta,
                        start: start,
                        end: end
                    },
                    success: function(response) {
                        const tbody = $('#preview-data-body-excel');
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

                            $('#count-total-excel').text(response.data.length);
                            $('#preview-data-count-excel').removeClass('d-none');
                            $('#input-search-excel').val(search);
                            $('#input-unit-excel').val(unit);
                            $('#input-verif-excel').val(verif);
                            $('#input-peserta-excel').val(peserta);
                            $('#input-start-date-excel').val(start);
                            $('#input-end-date-excel').val(end);
                            $('#preview-data-wrapper-excel').removeClass('d-none');
                            $('#preview-empty-excel').addClass('d-none');
                        } else {
                            $('#preview-data-body-excel').empty();
                            $('#preview-data-wrapper-excel').addClass('d-none');
                            $('#preview-data-count-excel').addClass('d-none');
                            $('#preview-empty-excel').removeClass('d-none');
                            showAlertModal('Tidak ada data yang cocok.', 'Warning');
                        }
                    },
                    error: function() {
                        $('#preview-data-body-excel').empty();
                        $('#preview-data-wrapper-excel').addClass('d-none');
                        $('#preview-data-count-excel').addClass('d-none');
                        $('#preview-empty-excel').removeClass('d-none');
                        showAlertModal('Gagal memuat data.', 'Error');
                    }
                });
            }

            // Event listeners for filters
            $('#filter-modal-search-excel').on('input', function() {
                clearTimeout(delayTimer);
                delayTimer = setTimeout(function() {
                    fetchDataModalExcel();
                }, 300);
            });

            $('#filter-modal-unit-excel, #filter-modal-verif-excel, #filter-modal-peserta-excel, #filter-modal-start-date-excel, #filter-modal-end-date-excel')
                .on(
                    'change',
                    function() {
                        fetchDataModalExcel();
                    });

            // Initialize modal
            modalExcel.addEventListener('shown.bs.modal', function() {
                fetchDataModalExcel();
            });

            // Reset modal when closed
            modalExcel.addEventListener('hidden.bs.modal', function() {
                currentStepExcel = 1;
                const lastStepItem = $('.step-item[data-step="3"]');
                const lastStepDot = lastStepItem.find('.step-dot');
                lastStepItem.removeClass('completed active');
                lastStepDot.removeClass('completed active');
                updateStepNavigationExcel();

                $('#filter-modal-search-excel').val('');
                $('#filter-modal-verif-excel').val('');
                $('#filter-modal-peserta-excel').val('');
                $('#filter-modal-start-date-excel').val('');
                $('#filter-modal-end-date-excel').val('');

                $('#preview-data-body-excel').empty();
                $('#preview-data-wrapper-excel').addClass('d-none');
                $('#preview-data-count-excel').addClass('d-none');
                $('#preview-empty-excel').removeClass('d-none');

                $('#input-search-excel').val('');
                $('#input-unit-excel').val('');

                $('#confirm-check-excel').prop('checked', false);
            });
        }
    });
</script>
