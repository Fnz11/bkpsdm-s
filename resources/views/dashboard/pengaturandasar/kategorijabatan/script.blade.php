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
        $('#kategorijabatan-table').addClass('d-none');
        $('#loading-spinner').removeClass('d-none');
        $('.pagination a').addClass('disabled');

        $.ajax({
            url: "{{ route('dashboard.pelatihan.kategorijabatan') }}",
            type: "GET",
            data: {
                search: $('#filter-search').val(),
                page: page,
            },
            success: function(response) {
                $('#kategorijabatan-table').html($(response).find('#kategorijabatan-table').html());
                $('#pagination-wrapper').html($(response).find('#pagination-wrapper').html());
                applyColumnToggles();
            },
            complete: function() {
                $('#kategorijabatan-table').removeClass('d-none');
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
</script>
