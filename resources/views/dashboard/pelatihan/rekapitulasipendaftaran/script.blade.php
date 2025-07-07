<script>
    let delayTimer;
    let lastQuery = '';
    let currentView = 'pelatihan'; // Tambahkan variabel untuk melacak view aktif

    $(document).ready(function() {
        initEvents();

        function initEvents() {
            // Toggle between views
            $('input[name="viewType"]').change(function() {
                if ($(this).attr('id') === 'view-pelatihan') {
                    $('#pelatihan-container').removeClass('d-none');
                    $('#opd-container').addClass('d-none');
                    currentView = 'pelatihan';
                } else {
                    $('#pelatihan-container').addClass('d-none');
                    $('#opd-container').removeClass('d-none');
                    currentView = 'opd';
                }
                fetchData(); // Reload data saat ganti view
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
                const ignoredKeys = ['Shift', 'Control', 'Alt', 'Meta', 'ArrowLeft', 'ArrowRight',
                    'ArrowUp', 'ArrowDown'
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

            // Filter events
            $('input[name="filter_unit"]').on('change', function() {
                fetchData();
            });

            $('#filter-start-date, #filter-end-date').on('change', function() {
                fetchData();
            });

            // Pagination AJAX
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetchData(page);
            });
        }

        function fetchData(page = 1) {
            const search = $('#filter-search').val();
            const unit = $('input[name="filter_unit"]:checked').val();
            const startDate = $('#filter-start-date').val();
            const endDate = $('#filter-end-date').val();

            // Gunakan currentView untuk menentukan tabel mana yang akan diupdate
            const targetContainer = currentView === 'pelatihan' ? '#pelatihan-table' : '#opd-table';
            const targetPagination = currentView === 'pelatihan' ? '#pagination-wrapper-pelatihan' :
                '#pagination-wrapper-opd';

            // Show loading spinner
            $(targetContainer).html(
                '<tr><td colspan="4" class="text-center p-5"><div class="spinner-border text-primary"></div></td></tr>'
            );

            $.ajax({
                url: "{{ route('dashboard.pelatihan.rekapitulasi') }}",
                type: "GET",
                data: {
                    search: search,
                    unit_id: unit,
                    start_date: startDate,
                    end_date: endDate,
                    view: currentView, // Kirim view aktif ke server
                    page: page
                },
                success: function(response) {
                    // Update tabel dan pagination sesuai view aktif
                    if (currentView === 'pelatihan') {
                        $('#pelatihan-table').html($(response).find('#pelatihan-table').html());
                        $('#pagination-wrapper-pelatihan').html($(response).find(
                            '#pagination-wrapper-pelatihan').html());
                    } else {
                        $('#opd-table').html($(response).find('#opd-table').html());
                        $('#pagination-wrapper-opd').html($(response).find(
                            '#pagination-wrapper-opd').html());
                    }
                },
                error: function() {
                    $(targetContainer).html(
                        '<tr><td colspan="4" class="text-center text-danger p-5">Gagal memuat data.</td></tr>'
                    );
                }
            });
        }
    });

    $(document).ready(function() {
        // ================ PDF MODAL ================
        let currentStepPdf = 1;
        const totalStepsPdf = 4;

        // Initialize steps
        updateStepNavigationPdf();

        // Navigation between steps
        $('#btn-next-step-pdf').on('click', function() {
            if (currentStepPdf < totalStepsPdf) {
                if (validateStepPdf(currentStepPdf)) {
                    currentStepPdf++;
                    updateStepNavigationPdf();
                }
            }
        });

        $('#btn-prev-step-pdf').on('click', function() {
            if (currentStepPdf > 1) {
                currentStepPdf--;
                updateStepNavigationPdf();
            }
        });

        function updateStepNavigationPdf() {
            // Update step dots and titles
            $('.step-item[data-step]').each(function() {
                const step = parseInt($(this).data('step'));
                const dot = $(this).find('.step-dot');

                if (step < currentStepPdf) {
                    $(this).addClass('completed').removeClass('active');
                    dot.addClass('completed').removeClass('active');
                } else if (step === currentStepPdf) {
                    $(this).addClass('active').removeClass('completed');
                    dot.addClass('active').removeClass('completed');
                } else {
                    $(this).removeClass('active completed');
                    dot.removeClass('active completed');
                }
            });

            // Update connecting lines
            // $('.progress-line').removeClass('active');
            // if (currentStepPdf > 0) $('.line-1').addClass('active');
            // if (currentStepPdf > 1) $('.line-2').addClass('active');
            // if (currentStepPdf > 2) $('.line-3').addClass('active');
            $('.step-progress-pdf').attr('data-step', currentStepPdf);

            // Show active step content
            $('.step-content').removeClass('active').addClass('d-none');
            $(`.step-content[data-step="${currentStepPdf}"]`).addClass('active').removeClass('d-none');

            // Update buttons
            $('#btn-batal-pdf, #btn-prev-step-pdf, #btn-next-step-pdf, #btn-submit-pdf').addClass('d-none');
            if (currentStepPdf === 1) {
                $('#btn-batal-pdf').removeClass('d-none');
                $('#btn-next-step-pdf').removeClass('d-none');
            } else if (currentStepPdf === 2 || currentStepPdf === 3) {
                $('#btn-prev-step-pdf').removeClass('d-none');
                $('#btn-next-step-pdf').removeClass('d-none');
            } else if (currentStepPdf === 4) {
                $('#btn-prev-step-pdf').removeClass('d-none');
                $('#btn-submit-pdf').removeClass('d-none');
                updateSummaryDataPdf();
            }
        }

        function validateStepPdf(step) {
            if (step === 2) {
                if ($('#preview-data-wrapper-pdf').hasClass('d-none')) {
                    showAlertModal('Silakan tunggu data termuat terlebih dahulu sebelum melanjutkan',
                        'Warning');
                    return false;
                }
                return true;
            }
            return true;
        }

        function updateSummaryDataPdf() {
            // Update filter summary
            $('#summary-search-pdf').text($('#filter-modal-search-pdf').val() || '-');

            const startDate = $('#filter-modal-start-date-pdf').val();
            const endDate = $('#filter-modal-end-date-pdf').val();
            $('#summary-date-pdf').text(startDate && endDate ? `${startDate} s/d ${endDate}` : '-');

            $('#summary-count-pdf').text($('#preview-data-body-pdf tr').length);

            // Update jenis rekap
            const jenisRekap = $('input[name="jenis_rekap"]:checked').val() === 'pelatihan' ? 'Per Pelatihan' :
                'Per OPD';
            $('#summary-jenis-rekap').text(jenisRekap);

            // Update PDF settings summary
            $('#summary-paper-size').text($('select[name="paper_size"]').val().toUpperCase());
            $('#summary-orientation').text($('select[name="orientation"] option:selected').text());
        }

        // Handle confirmation checkbox
        $('#confirm-check-pdf').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#btn-submit-pdf').prop('disabled', !isChecked);

            // When on the last step (step 4) and checkbox is checked, mark the step as completed
            if (currentStepPdf === 4) {
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

        // Handle jenis rekap change
        $('input[name="jenis_rekap"]').on('change', function() {
            fetchDataModalPdf();
        });

        // Fetch data for modal preview
        function fetchDataModalPdf() {
            let search = $('#filter-modal-search-pdf').val();
            let start = $('#filter-modal-start-date-pdf').val();
            let end = $('#filter-modal-end-date-pdf').val();
            let jenisRekap = $('input[name="jenis_rekap"]:checked').val();

            $.ajax({
                url: "{{ route('dashboard.pelatihan.rekapitulasi.preview') }}",
                type: "GET",
                data: {
                    search: search,
                    start_date: start,
                    end_date: end,
                    jenis_rekap: jenisRekap
                },
                success: function(response) {
                    const tbody = $('#preview-data-body-pdf');
                    tbody.empty();

                    if (response.data.length > 0) {
                        response.data.forEach(item => {
                            tbody.append(`
                                <tr>
                                    <td>${jenisRekap === 'pelatihan' ? 'Pelatihan' : 'OPD'}</td>
                                    <td>${item.nama || item.opd || '-'}</td>
                                    <td>${item.jumlah_usulan || 0}</td>
                                </tr>
                            `);
                        });

                        $('#count-total-pdf').text(response.data.length);
                        $('#preview-data-count-pdf').removeClass('d-none');
                        $('#input-search-pdf').val(search);
                        $('#input-start-date-pdf').val(start);
                        $('#input-end-date-pdf').val(end);
                        $('#preview-data-wrapper-pdf').removeClass('d-none');
                        $('#preview-empty-pdf').addClass('d-none');
                    } else {
                        $('#preview-data-body-pdf').empty();
                        $('#preview-data-wrapper-pdf').addClass('d-none');
                        $('#preview-data-count-pdf').addClass('d-none');
                        $('#preview-empty-pdf').removeClass('d-none');
                        showAlertModal('Tidak ada data yang cocok.', 'Warning');
                    }
                },
                error: function() {
                    $('#preview-data-body-pdf').empty();
                    $('#preview-data-wrapper-pdf').addClass('d-none');
                    $('#preview-data-count-pdf').addClass('d-none');
                    $('#preview-empty-pdf').removeClass('d-none');
                    showAlertModal('Gagal memuat data.', 'Error');
                }
            });
        }

        // Event listeners for filters
        $('#filter-modal-search-pdf').on('input', function() {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                fetchDataModalPdf();
            }, 300);
        });

        $('#filter-modal-start-date-pdf, #filter-modal-end-date-pdf').on('change', function() {
            fetchDataModalPdf();
        });

        // Initialize modal
        $('#modalPdf').on('shown.bs.modal', function() {
            fetchDataModalPdf();
        });

        // Reset modal when closed
        $('#modalPdf').on('hidden.bs.modal', function() {
            currentStepPdf = 1;
            updateStepNavigationPdf();

            $('#filter-modal-search-pdf').val('');
            $('#filter-modal-start-date-pdf').val('');
            $('#filter-modal-end-date-pdf').val('');

            $('#preview-data-body-pdf').empty();
            $('#preview-data-wrapper-pdf').addClass('d-none');
            $('#preview-data-count-pdf').addClass('d-none');

            $('#input-search-pdf').val('');
            $('#input-start-date-pdf').val('');
            $('#input-end-date-pdf').val('');

            $('#confirm-check-pdf').prop('checked', false);
        });

        // ================ EXCEL MODAL ================
        let currentStepExcel = 1;
        const totalStepsExcel = 4;

        // Initialize steps
        updateStepNavigationExcel();

        // Navigation between steps
        $('#btn-next-step-excel').on('click', function() {
            if (currentStepExcel < totalStepsExcel) {
                if (validateStepExcel(currentStepExcel)) {
                    currentStepExcel++;
                    updateStepNavigationExcel();

                    // Auto fetch data when moving to step 2 (Filter Data)
                    if (currentStepExcel === 2) {
                        fetchDataModalExcel();
                    }
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
            $('.step-item[data-step]', '#modalExcel').each(function() {
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
            // $('.progress-line', '#modalExcel').removeClass('active');
            // if (currentStepExcel > 0) $('.line-2-1', '#modalExcel').addClass('active');
            // if (currentStepExcel > 1) $('.line-2-2', '#modalExcel').addClass('active');
            // if (currentStepExcel > 2) $('.line-2-3', '#modalExcel').addClass('active');
            $('.step-progress-excel').attr('data-step', currentStepExcel);

            // Show active step content
            $('.step-content', '#modalExcel').removeClass('active').addClass('d-none');
            $(`.step-content[data-step="${currentStepExcel}"]`, '#modalExcel').addClass('active').removeClass(
                'd-none');

            // Update buttons
            $('#btn-batal-excel, #btn-prev-step-excel, #btn-next-step-excel, #btn-submit-excel').addClass(
                'd-none');
            if (currentStepExcel === 1) {
                $('#btn-batal-excel').removeClass('d-none');
                $('#btn-next-step-excel').removeClass('d-none');
            } else if (currentStepExcel === 2 || currentStepExcel === 3) {
                $('#btn-prev-step-excel').removeClass('d-none');
                $('#btn-next-step-excel').removeClass('d-none');
            } else if (currentStepExcel === 4) {
                $('#btn-prev-step-excel').removeClass('d-none');
                $('#btn-submit-excel').removeClass('d-none');
                updateSummaryDataExcel();
            }
        }

        function validateStepExcel(step) {
            if (step === 2) {
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
            // Update jenis rekap
            const jenisRekap = $('input[name="jenis_rekap"]:checked').val() === 'pelatihan' ? 'Per Pelatihan' :
                'Per OPD';
            $('#summary-jenis-rekap-excel').text(jenisRekap);
            $('#input-jenis-rekap-excel').val($('input[name="jenis_rekap"]:checked').val());

            // Update filter summary
            $('#summary-search-excel').text($('#filter-modal-search-excel').val() || '-');

            const startDate = $('#filter-modal-start-date-excel').val();
            const endDate = $('#filter-modal-end-date-excel').val();
            $('#summary-date-excel').text(startDate && endDate ? `${startDate} s/d ${endDate}` : '-');

            $('#summary-count-excel').text($('#preview-data-body-excel tr').length);

            // Update Excel settings summary
            $('#summary-format').text($('select[name="file_format"]').val() === 'xlsx' ? 'Excel (.xlsx)' :
                'CSV (.csv)');
            $('#summary-header').text($('#include_header').is(':checked') ? 'Ya' : 'Tidak');

            const selectedColumns = $('input[name="columns[]"]:checked').length;
            $('#summary-columns').text(selectedColumns + ' kolom');
        }

        // Handle confirmation checkbox
        $('#confirm-check-excel').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#btn-submit-excel').prop('disabled', !isChecked);

            // When on the last step (step 4) and checkbox is checked, mark the step as completed
            if (currentStepExcel === 4) {
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

        // Handle jenis rekap change
        $('input[name="jenis_rekap"]', '#modalExcel').on('change', function() {
            if (currentStepExcel === 2) {
                fetchDataModalExcel();
            }
        });

        // Handle column selection change
        $('input[name="columns[]"]').on('change', function() {
            if (currentStepExcel === 4) {
                updateSummaryDataExcel();
            }
        });

        // Handle file format change
        $('select[name="file_format"]').on('change', function() {
            if (currentStepExcel === 4) {
                updateSummaryDataExcel();
            }
        });

        // Handle include header change
        $('#include_header').on('change', function() {
            if (currentStepExcel === 4) {
                updateSummaryDataExcel();
            }
        });

        // Fetch data for modal preview
        function fetchDataModalExcel() {
            let search = $('#filter-modal-search-excel').val();
            let start = $('#filter-modal-start-date-excel').val();
            let end = $('#filter-modal-end-date-excel').val();
            let jenisRekap = $('input[name="jenis_rekap"]:checked', '#modalExcel').val();

            $.ajax({
                url: "{{ route('dashboard.pelatihan.rekapitulasi.preview') }}",
                type: "GET",
                data: {
                    search: search,
                    start_date: start,
                    end_date: end,
                    jenis_rekap: jenisRekap
                },
                success: function(response) {
                    const tbody = $('#preview-data-body-excel');
                    tbody.empty();

                    if (response.data.length > 0) {
                        response.data.forEach(item => {
                            tbody.append(`
                        <tr>
                            <td>${jenisRekap === 'pelatihan' ? 'Pelatihan' : 'OPD'}</td>
                            <td>${item.nama || item.opd || '-'}</td>
                            <td>${item.jumlah_usulan || 0}</td>
                        </tr>
                    `);
                        });

                        $('#count-total-excel').text(response.data.length);
                        $('#preview-data-count-excel').removeClass('d-none');
                        $('#input-search-excel').val(search);
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

        $('#filter-modal-start-date-excel, #filter-modal-end-date-excel').on('change', function() {
            fetchDataModalExcel();
        });

        // Initialize modal
        $('#modalExcel').on('shown.bs.modal', function() {
            currentStepExcel = 1;
            updateStepNavigationExcel();
        });

        // Reset modal when closed
        $('#modalExcel').on('hidden.bs.modal', function() {
            currentStepExcel = 1;
            const lastStepItem = $('.step-item[data-step="4"]');
            const lastStepDot = lastStepItem.find('.step-dot');
            lastStepItem.removeClass('completed active');
            lastStepDot.removeClass('completed active');
            updateStepNavigationExcel();

            $('#filter-modal-search-excel').val('');
            $('#filter-modal-start-date-excel').val('');
            $('#filter-modal-end-date-excel').val('');

            $('#preview-data-body-excel').empty();
            $('#preview-data-wrapper-excel').addClass('d-none');
            $('#preview-data-count-excel').addClass('d-none');

            $('#input-search-excel').val('');
            $('#input-start-date-excel').val('');
            $('#input-end-date-excel').val('');

            $('#confirm-check-excel').prop('checked', false);
        });

        // Form submission handler
        $('#form-cetak-excel').on('submit', function(e) {
            if (!$('#confirm-check-excel').is(':checked')) {
                e.preventDefault();
                showAlertModal('Anda harus mencentang konfirmasi sebelum melakukan export.', 'Warning');
            }
        });
    });
</script>
