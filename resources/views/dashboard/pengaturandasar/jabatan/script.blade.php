<script>
    let delayTimer;
    let lastQuery = '';
    let currentJenis = '';

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

    // $('#filter-jenis, #filter-status, #filter-start-date, #filter-end-date').on('change',
    //     function() {
    //         fetchData();
    //     });

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
        $('#jabatan-table').addClass('d-none');
        $('#loading-spinner').removeClass('d-none');
        $('.pagination a').addClass('disabled');

        $.ajax({
            url: "{{ route('dashboard.pelatihan.jabatan') }}",
            type: "GET",
            data: {
                search: $('#filter-search').val(),
                // jenis: $('#filter-jenis').val(),
                // status: $('#filter-status').val(),
                // start_date: $('#filter-start-date').val(),
                // end_date: $('#filter-end-date').val(),
                page: page,
            },
            success: function(response) {
                $('#jabatan-table').html($(response).find('#jabatan-table').html());
                $('#pagination-wrapper').html($(response).find('#pagination-wrapper').html());
                applyColumnToggles();
            },
            complete: function() {
                $('#jabatan-table').removeClass('d-none');
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

    $(document).on('click', '.btn-delete', function() {
        const form = $(this).closest('form');

        if (form.length) {
            showAlertModal('Apakah Anda yakin ingin menghapus data ini?', 'Warning', 0, {
                confirmText: '<i class="bi bi-check-circle me-1"></i>Hapus',
                onConfirm: () => {
                    form.submit();
                }
            });
        }
    });

    // document.getElementById('btn-reset-filter').addEventListener('click', function() {
    //     if ($('#filter-search').val().length > 0 ||
    //         $('#filter-jenis').val() !== '' ||
    //         $('#filter-status').val() !== '' ||
    //         $('#filter-start-date').val() !== '' ||
    //         $('#filter-end-date').val() !== '') {

    //         // Reset semua input dan select
    //         document.getElementById('filter-search').value = '';
    //         document.getElementById('filter-jenis').value = '';
    //         document.getElementById('filter-status').value = '';
    //         // Reset tanggal
    //         document.getElementById('filter-start-date').value = '';
    //         document.getElementById('filter-end-date').value = '';

    //         // Sembunyikan tombol clear
    //         $('#clear-search').hide();

    //         fetchData();
    //     }
    // });
</script>
