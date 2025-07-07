<script>
    let delayTimer;
    let lastQuery = '';
    let currentView = 'aktif'; // Tambahkan variabel untuk melacak view aktif

    $(document).ready(function() {
        initEvents();

        function initEvents() {
            // Toggle between views
            $('input[name="viewType"]').change(function() {
                if ($(this).attr('id') === 'view-aktif') {
                    $('#aktif-container').removeClass('d-none');
                    $('#usulan-container').addClass('d-none');
                    $('#pagination-wrapper-usulan').addClass('d-none');
                    $('#print-buttons').removeClass('d-none'); 
                    currentView = 'aktif';
                } else {
                    $('#aktif-container').addClass('d-none');
                    $('#usulan-container').removeClass('d-none');
                    $('#pagination-wrapper-aktif').addClass('d-none');
                    $('#print-buttons').addClass('d-none');
                    currentView = 'usulan';
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

            // Handle date filter changes
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
            const startDate = $('#filter-start-date').val();
            const endDate = $('#filter-end-date').val();

            // Gunakan currentView untuk menentukan tabel mana yang akan diupdate
            const targetContainer = currentView === 'aktif' ? '#aktif-table' : '#usulan-table';
            const targetPagination = currentView === 'aktif' ? '#pagination-wrapper-aktif' :
                '#pagination-wrapper-usulan';
            const loadingSpinner = currentView === 'aktif' ? '#loading-spinner-aktif' :
                '#loading-spinner-usulan';

            // Show loading spinner
            $(loadingSpinner).removeClass('d-none');
            $(targetContainer).addClass('d-none');

            $.ajax({
                url: "{{ route('dashboard.pelatihan.user') }}",
                type: "GET",
                data: {
                    search: search,
                    start_date: startDate,
                    end_date: endDate,
                    view: currentView, // Kirim view aktif ke server
                    page: page
                },
                success: function(response) {
                    // Update tabel dan pagination sesuai view aktif
                    if (currentView === 'aktif') {
                        $('#aktif-table').html($(response).find('#aktif-table').html());
                        $('#pagination-wrapper-aktif').html($(response).find(
                            '#pagination-wrapper-aktif').html());
                    } else {
                        $('#usulan-table').html($(response).find('#usulan-table').html());
                        $('#pagination-wrapper-usulan').html($(response).find(
                            '#pagination-wrapper-usulan').html());
                    }
                },
                complete: function() {
                    $(loadingSpinner).addClass('d-none');
                    $(targetContainer).removeClass('d-none');
                },
                error: function() {
                    $(targetContainer).html(
                        '<tr><td colspan="8" class="text-center text-danger p-5">Gagal memuat data.</td></tr>'
                    );
                }
            });
        }
    });

    $(document).ready(function() {
        // PDF Modal Script
        let currentStepPdf = 1;
        const totalStepsPdf = 3;

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
            $('.step-progress-pdf .step-item').each(function() {
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

            $('.step-progress-pdf').attr('data-step', currentStepPdf);

            // Show active step content
            $('.step-content[data-step]').removeClass('active').addClass('d-none');
            $(`.step-content[data-step="${currentStepPdf}"]`).addClass('active').removeClass('d-none');

            // Update buttons
            $('#btn-batal-pdf, #btn-prev-step-pdf, #btn-next-step-pdf, #btn-submit-cetak-pdf').addClass('d-none');
            if (currentStepPdf === 1) {
                $('#btn-batal-pdf').removeClass('d-none');
                $('#btn-next-step-pdf').removeClass('d-none');
            } else if (currentStepPdf === 2) {
                $('#btn-prev-step-pdf').removeClass('d-none');
                $('#btn-next-step-pdf').removeClass('d-none');
            } else if (currentStepPdf === 3) {
                $('#btn-prev-step-pdf').removeClass('d-none');
                $('#btn-submit-cetak-pdf').removeClass('d-none');
                updateSummaryDataPdf();
            }
        }

        function validateStepPdf(step) {
            if (step === 1) {
                if ($('#preview-data-wrapper-pdf').hasClass('d-none')) {
                    showAlertModal('Silakan tunggu data termuat terlebih dahulu sebelum melanjutkan', 'Warning');
                    return false;
                }
                return true;
            }
            return true;
        }

        function updateSummaryDataPdf() {
            // Update filter summary
            $('#summary-search-pdf').text($('#filter-modal-search-pdf').val() || '-');
            $('#summary-unit-kerja').text($('#filter-modal-unit-kerja option:selected').text() || 'Semua');
            $('#summary-jenis-asn').text($('#filter-modal-jenis-asn option:selected').text() || 'Semua');

            const startDate = $('#filter-modal-start-date-pdf').val();
            const endDate = $('#filter-modal-end-date-pdf').val();
            $('#summary-date-pdf').text(startDate && endDate ? `${startDate} s/d ${endDate}` : '-');

            $('#summary-count-pdf').text($('#preview-data-body-pdf tr').length);

            // Update PDF settings summary
            $('#summary-paper-size-pdf').text($('select[name="paper_size"]').val().toUpperCase());
            $('#summary-orientation-pdf').text($('select[name="orientation"] option:selected').text());

            const margins = [
                $('input[name="margin_top"]').val() + 'in (atas)',
                $('input[name="margin_right"]').val() + 'in (kanan)',
                $('input[name="margin_bottom"]').val() + 'in (bawah)',
                $('input[name="margin_left"]').val() + 'in (kiri)'
            ];
            $('#summary-margins-pdf').text(margins.join(', '));
            $('#summary-header-pdf').text($('#show_header').is(':checked') ? 'Aktif' : 'Nonaktif');
            $('#summary-footer-pdf').text($('#show_footer').is(':checked') ? 'Aktif' : 'Nonaktif');
        }

        $('#confirm-check-pdf').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#btn-submit-cetak-pdf').prop('disabled', !isChecked);

            if (currentStepPdf === 3) {
                const lastStepItem = $('.step-progress-pdf .step-item[data-step="3"]');
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

        function fetchDataModalPdf() {
            let search = $('#filter-modal-search-pdf').val();
            let unitKerja = $('#filter-modal-unit-kerja').val();
            let jenisAsn = $('#filter-modal-jenis-asn').val();
            let start = $('#filter-modal-start-date-pdf').val();
            let end = $('#filter-modal-end-date-pdf').val();

            $.ajax({
                url: "{{ route('dashboard.pelatihan.user.preview') }}",
                type: "GET",
                data: {
                    search: search,
                    unit_kerja: unitKerja,
                    jenis_asn: jenisAsn,
                    start: start,
                    end: end,
                    view: currentView // Menggunakan currentView dari script utama
                },
                success: function(response) {
                    const tbody = $('#preview-data-body-pdf');
                    tbody.empty();

                    if (response.data.length > 0) {
                        response.data.forEach(item => {
                            tbody.append(`
                                <tr>
                                    <td>${item.user?.ref_pegawai?.name || '-'}</td>
                                    <td>${item.unit_kerja?.unitkerja?.unitkerja || '-'}</td>
                                    <td>${item.jabatan?.jabatan || '-'}</td>
                                    <td>${item.golongan?.golongan || '-'}</td>
                                    <td>${item.golongan?.jenisasn?.jenis_asn || '-'}</td>
                                    <td>${item.tgl_mulai ? new Date(item.tgl_mulai).toLocaleDateString('id-ID') : '-'}</td>
                                </tr>
                            `);
                        });

                        $('#count-total-pdf').text(response.data.length);
                        $('#preview-data-count-pdf').removeClass('d-none');
                        $('#input-search-pdf').val(search);
                        $('#input-unit-kerja').val(unitKerja);
                        $('#input-jenis-asn').val(jenisAsn);
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

        const modalPdf = document.getElementById('modalPdf');
        modalPdf.addEventListener('shown.bs.modal', function() {
            fetchDataModalPdf();
        });

        $('#filter-modal-search-pdf').on('input', function() {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                fetchDataModalPdf();
            }, 300);
        });

        $('#filter-modal-unit-kerja, #filter-modal-jenis-asn, #filter-modal-start-date-pdf, #filter-modal-end-date-pdf')
            .on('change', function() {
                fetchDataModalPdf();
            });

        modalPdf.addEventListener('hidden.bs.modal', function() {
            currentStepPdf = 1;
            updateStepNavigationPdf();

            $('#filter-modal-search-pdf').val('');
            $('#filter-modal-unit-kerja').val('');
            $('#filter-modal-jenis-asn').val('');
            $('#filter-modal-start-date-pdf').val('');
            $('#filter-modal-end-date-pdf').val('');

            $('#preview-data-body-pdf').empty();
            $('#preview-data-wrapper-pdf').addClass('d-none');
            $('#preview-data-count-pdf').addClass('d-none');
            $('#preview-empty-pdf').removeClass('d-none');

            $('#confirm-check-pdf').prop('checked', false);
        });

        // Excel Modal Script
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
            $('.step-progress-excel .step-item').each(function() {
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

            $('.step-content[data-step]').removeClass('active').addClass('d-none');
            $(`.step-content[data-step="${currentStepExcel}"]`).addClass('active').removeClass('d-none');

            $('#btn-batal-excel, #btn-prev-step-excel, #btn-next-step-excel, #btn-submit-excel').addClass('d-none');
            if (currentStepExcel === 1) {
                $('#btn-batal-excel').removeClass('d-none');
                $('#btn-next-step-excel').removeClass('d-none');
            } else if (currentStepExcel === 2) {
                $('#btn-prev-step-excel').removeClass('d-none');
                $('#btn-next-step-excel').removeClass('d-none');
            } else if (currentStepExcel === 3) {
                $('#btn-prev-step-excel').removeClass('d-none');
                $('#btn-submit-excel').removeClass('d-none');
                updateSummaryDataExcel();
            }
        }

        function validateStepExcel(step) {
            if (step === 1) {
                if ($('#preview-data-wrapper-excel').hasClass('d-none')) {
                    showAlertModal('Silakan tunggu data termuat terlebih dahulu sebelum melanjutkan', 'Warning');
                    return false;
                }
                return true;
            }
            return true;
        }

        function updateSummaryDataExcel() {
            $('#summary-search-excel').text($('#filter-modal-search-excel').val() || '-');
            $('#summary-unit-kerja-excel').text($('#filter-modal-unit-kerja-excel option:selected').text() || 'Semua');
            $('#summary-jenis-asn-excel').text($('#filter-modal-jenis-asn-excel option:selected').text() || 'Semua');

            const startDate = $('#filter-modal-start-date-excel').val();
            const endDate = $('#filter-modal-end-date-excel').val();
            $('#summary-date-excel').text(startDate && endDate ? `${startDate} s/d ${endDate}` : '-');

            $('#summary-count-excel').text($('#preview-data-body-excel tr').length);

            $('#summary-format').text($('select[name="file_format"] option:selected').text());
            $('#summary-header-excel').text($('#include_header').is(':checked') ? 'Ya' : 'Tidak');

            const selectedColumns = $('input[name="columns[]"]:checked').length;
            $('#summary-columns').text(`${selectedColumns} kolom`);
        }

        $('#confirm-check-excel').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('#btn-submit-excel').prop('disabled', !isChecked);

            if (currentStepExcel === 3) {
                const lastStepItem = $('.step-progress-excel .step-item[data-step="3"]');
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
            let unitKerja = $('#filter-modal-unit-kerja-excel').val();
            let jenisAsn = $('#filter-modal-jenis-asn-excel').val();
            let start = $('#filter-modal-start-date-excel').val();
            let end = $('#filter-modal-end-date-excel').val();

            $.ajax({
                url: "{{ route('dashboard.pelatihan.user.preview') }}",
                type: "GET",
                data: {
                    search: search,
                    unit_kerja: unitKerja,
                    jenis_asn: jenisAsn,
                    start: start,
                    end: end,
                    view: currentView // Menggunakan currentView dari script utama
                },
                success: function(response) {
                    const tbody = $('#preview-data-body-excel');
                    tbody.empty();

                    if (response.data.length > 0) {
                        response.data.forEach(item => {
                            tbody.append(`
                                <tr>
                                    <td>${item.user?.ref_pegawai?.name || '-'}</td>
                                    <td>${item.unit_kerja?.unitkerja?.unitkerja || '-'}</td>
                                    <td>${item.jabatan?.jabatan || '-'}</td>
                                    <td>${item.golongan?.golongan || '-'}</td>
                                    <td>${item.golongan?.jenisasn?.jenis_asn || '-'}</td>
                                    <td>${item.tgl_mulai ? new Date(item.tgl_mulai).toLocaleDateString('id-ID') : '-'}</td>
                                </tr>
                            `);
                        });

                        $('#count-total-excel').text(response.data.length);
                        $('#preview-data-count-excel').removeClass('d-none');
                        $('#input-search-excel').val(search);
                        $('#input-unit-kerja-excel').val(unitKerja);
                        $('#input-jenis-asn-excel').val(jenisAsn);
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

        const modalExcel = document.getElementById('modalExcel');
        modalExcel.addEventListener('shown.bs.modal', function() {
            fetchDataModalExcel();
        });

        $('#filter-modal-search-excel').on('input', function() {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(function() {
                fetchDataModalExcel();
            }, 300);
        });

        $('#filter-modal-unit-kerja-excel, #filter-modal-jenis-asn-excel, #filter-modal-start-date-excel, #filter-modal-end-date-excel')
            .on('change', function() {
                fetchDataModalExcel();
            });

        modalExcel.addEventListener('hidden.bs.modal', function() {
            currentStepExcel = 1;
            updateStepNavigationExcel();

            $('#filter-modal-search-excel').val('');
            $('#filter-modal-unit-kerja-excel').val('');
            $('#filter-modal-jenis-asn-excel').val('');
            $('#filter-modal-start-date-excel').val('');
            $('#filter-modal-end-date-excel').val('');

            $('#preview-data-body-excel').empty();
            $('#preview-data-wrapper-excel').addClass('d-none');
            $('#preview-data-count-excel').addClass('d-none');
            $('#preview-empty-excel').removeClass('d-none');

            $('#confirm-check-excel').prop('checked', false);
        });
    });
</script>
