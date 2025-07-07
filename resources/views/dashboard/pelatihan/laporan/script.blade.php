<script>
    let delayTimer;
    let lastQuery = '';
    let currentJenis = '';

    // Handle clear search button
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

    // Update event handler untuk search
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

    $('#filter-jenis, #filter-status, #filter-start-date, #filter-end-date').on('change',
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

    function fetchData(page = 1) {
        $('#laporan-table').addClass('d-none');
        $('#loading-spinner').removeClass('d-none');
        $('.pagination a').addClass('disabled');

        $.ajax({
            url: "{{ route('dashboard.pelatihan.laporan') }}",
            type: "GET",
            data: {
                page: page,
                search: $('#filter-search').val(),
                jenis: $('#filter-jenis').val(),
                status: $('#filter-status').val(),
                start_date: $('#filter-start-date').val(),
                end_date: $('#filter-end-date').val()
            },
            success: function(response) {
                $('#laporan-table').html($(response).find('#laporan-table').html());
                $('#pagination-wrapper').html($(response).find('#pagination-wrapper').html());
                applyColumnToggles();
            },

            error: function(xhr) {
                console.error(xhr.responseText);
            },
            complete: function() {
                $('#laporan-table').removeClass('d-none');
                $('#loading-spinner').addClass('d-none');
                $('.pagination a').removeClass('disabled')
            }
        });
    }

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
            $('#filter-jenis').val() !== '' ||
            $('#filter-status').val() !== '' ||
            $('#filter-start-date').val() !== '' ||
            $('#filter-end-date').val() !== '') {

            // Reset semua input dan select
            document.getElementById('filter-search').value = '';
            document.getElementById('filter-jenis').value = '';
            document.getElementById('filter-status').value = '';
            // Reset tanggal
            document.getElementById('filter-start-date').value = '';
            document.getElementById('filter-end-date').value = '';

            // Sembunyikan tombol clear
            $('#clear-search').hide();

            fetchData();
        }
    });

    // PDF Modal Script
    $(document).ready(function() {
        let currentStep = 1;
        const totalSteps = 3;

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

            $('.step-progress-pdf').attr('data-step', currentStep);

            // Show active step content
            $('.step-content').removeClass('active').addClass('d-none');
            $(`.step-content[data-step="${currentStep}"]`).addClass('active').removeClass('d-none');

            // Update buttons
            $('#btn-batal, #btn-prev-step, #btn-next-step, #btn-submit-cetak').addClass('d-none');
            if (currentStep === 1) {
                $('#btn-batal').removeClass('d-none');
                $('#btn-next-step').removeClass('d-none');
            } else if (currentStep === 2) {
                $('#btn-prev-step').removeClass('d-none');
                $('#btn-next-step').removeClass('d-none');
            } else if (currentStep === 3) {
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
            return true;
        }

        function updateSummaryData() {
            // Update filter summary
            $('#summary-search').text($('#filter-modal-search').val() || '-');
            $('#summary-jenis').text($('#filter-modal-jenis option:selected').text() || 'Semua');
            $('#summary-status').text($('#filter-modal-status option:selected').text() || 'Semua');

            const startDate = $('#filter-modal-start-date').val();
            const endDate = $('#filter-modal-end-date').val();
            $('#summary-date').text(startDate && endDate ? `${startDate} s/d ${endDate}` : '-');

            $('#summary-count').text($('#preview-data-body tr').length);

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
        }

        $('#confirm-check').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#btn-submit-cetak').prop('disabled', !isChecked);

            if (currentStep === 3) {
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

        function fetchDataModal() {
            let search = $('#filter-modal-search').val();
            let jenis = $('#filter-modal-jenis').val();
            let status = $('#filter-modal-status').val();
            let start = $('#filter-modal-start-date').val();
            let end = $('#filter-modal-end-date').val();

            $.ajax({
                url: "{{ route('dashboard.pelatihan.laporan.preview') }}",
                type: "GET",
                data: {
                    search: search,
                    jenis: jenis,
                    status: status,
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
                                        <td>${item.pendaftaran?.tersedia?.nama_pelatihan ?? item.pendaftaran?.usulan?.nama_pelatihan ?? '-'}</td>
                                        <td>${item.judul_laporan ?? '-'}</td>
                                        <td>${item.latar_belakang ?? '-'}</td>
                                        <td>${item.total_biaya ? 'Rp ' + new Intl.NumberFormat('id-ID').format(item.total_biaya) : '-'}</td>
                                        <td>${item.hasil_pelatihan ? item.hasil_pelatihan.charAt(0).toUpperCase() + item.hasil_pelatihan.slice(1) : '-'}</td>
                                    </tr>
                                `);
                        });

                        $('#count-total').text(response.data.length);
                        $('#preview-data-count').removeClass('d-none');
                        $('#input-search').val(search);
                        $('#input-jenis').val(jenis);
                        $('#input-status').val(status);
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

        const modal = document.getElementById('modalCetak');
        modal.addEventListener('shown.bs.modal', function() {
            fetchDataModal();
        });

        $('#filter-modal-search').on('input', function() {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                fetchDataModal();
            }, 300);
        });

        $('#filter-modal-jenis, #filter-modal-status, #filter-modal-start-date, #filter-modal-end-date')
            .on('change', function() {
                fetchDataModal();
            });

        modal.addEventListener('hidden.bs.modal', function() {
            currentStep = 1;
            updateStepNavigation();

            $('#filter-modal-search').val('');
            $('#filter-modal-jenis').val('');
            $('#filter-modal-status').val('');
            $('#filter-modal-start-date').val('');
            $('#filter-modal-end-date').val('');

            $('#preview-data-body').empty();
            $('#preview-data-wrapper').addClass('d-none');
            $('#preview-data-count').addClass('d-none');
            $('#preview-empty').removeClass('d-none');

            $('#confirm-check').prop('checked', false);
        });
    });

    // Excel Modal Script
    $(document).ready(function() {
        const modalExcel = document.getElementById('modalExcel');
        if (modalExcel) {
            let currentStepExcel = 1;
            const totalStepsExcel = 3;

            updateStepNavigationExcel();

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

                $('.step-progress-excel').attr('data-step', currentStepExcel);

                $('.step-content', modalExcel).removeClass('active').addClass('d-none');
                $(`.step-content[data-step="${currentStepExcel}"]`, modalExcel).addClass('active').removeClass(
                    'd-none');

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
                $('#summary-search-excel').text($('#filter-modal-search-excel').val() || '-');
                $('#summary-jenis-excel').text($('#filter-modal-jenis-excel option:selected').text() ||
                    'Semua');
                $('#summary-status-excel').text($('#filter-modal-status-excel option:selected').text() ||
                    'Semua');

                const startDate = $('#filter-modal-start-date-excel').val();
                const endDate = $('#filter-modal-end-date-excel').val();
                $('#summary-date-excel').text(startDate && endDate ? `${startDate} s/d ${endDate}` : '-');

                $('#summary-count-excel').text($('#preview-data-body-excel tr').length);

                $('#summary-format').text($('select[name="file_format"] option:selected').text());
                $('#summary-header').text($('#include_header').is(':checked') ? 'Ya' : 'Tidak');

                const selectedColumns = $('input[name="columns[]"]:checked').length;
                $('#summary-columns').text(`${selectedColumns} kolom`);
            }

            $('#confirm-check-excel').on('change', function() {
                const isChecked = $(this).is(':checked');
                $('#btn-submit-excel').prop('disabled', !isChecked);

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

            function fetchDataModalExcel() {
                let search = $('#filter-modal-search-excel').val();
                let jenis = $('#filter-modal-jenis-excel').val();
                let status = $('#filter-modal-status-excel').val();
                let start = $('#filter-modal-start-date-excel').val();
                let end = $('#filter-modal-end-date-excel').val();

                $.ajax({
                    url: "{{ route('dashboard.pelatihan.laporan.preview') }}",
                    type: "GET",
                    data: {
                        search: search,
                        jenis: jenis,
                        status: status,
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
                                            <td>${item.pendaftaran?.tersedia?.nama_pelatihan ?? item.pendaftaran?.usulan?.nama_pelatihan ?? '-'}</td>
                                            <td>${item.judul_laporan ?? '-'}</td>
                                            <td>${item.latar_belakang ?? '-'}</td>
                                            <td>${item.total_biaya ? 'Rp ' + new Intl.NumberFormat('id-ID').format(item.total_biaya) : '-'}</td>
                                            <td>${item.hasil_pelatihan ? item.hasil_pelatihan.charAt(0).toUpperCase() + item.hasil_pelatihan.slice(1) : '-'}</td>
                                        </tr>
                                    `);
                            });

                            $('#count-total-excel').text(response.data.length);
                            $('#preview-data-count-excel').removeClass('d-none');
                            $('#input-search-excel').val(search);
                            $('#input-jenis-excel').val(jenis);
                            $('#input-status-excel').val(status);
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

            modalExcel.addEventListener('shown.bs.modal', function() {
                fetchDataModalExcel();
            });

            $('#filter-modal-search-excel').on('input', function() {
                clearTimeout(delayTimer);
                delayTimer = setTimeout(function() {
                    fetchDataModalExcel();
                }, 300);
            });

            $('#filter-modal-jenis-excel, #filter-modal-status-excel, #filter-modal-start-date-excel, #filter-modal-end-date-excel')
                .on('change', function() {
                    fetchDataModalExcel();
                });

            modalExcel.addEventListener('hidden.bs.modal', function() {
                currentStepExcel = 1;
                const lastStepItem = $('.step-item[data-step="3"]');
                const lastStepDot = lastStepItem.find('.step-dot');
                lastStepItem.removeClass('completed active');
                lastStepDot.removeClass('completed active');
                updateStepNavigationExcel();

                $('#filter-modal-search-excel').val('');
                $('#filter-modal-jenis-excel').val('');
                $('#filter-modal-status-excel').val('');
                $('#filter-modal-start-date-excel').val('');
                $('#filter-modal-end-date-excel').val('');

                $('#preview-data-body-excel').empty();
                $('#preview-data-wrapper-excel').addClass('d-none');
                $('#preview-data-count-excel').addClass('d-none');
                $('#preview-empty-excel').removeClass('d-none');

                $('#confirm-check-excel').prop('checked', false);
            });
        }
    });
</script>
