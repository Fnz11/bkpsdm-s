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

    function fetchData(page = 1) {
        $('#tenggat-table').addClass('d-none');
        $('#loading-spinner').removeClass('d-none');
        $('.pagination a').addClass('disabled');

        $.ajax({
            url: "{{ route('dashboard.pelatihan.tenggat') }}",
            type: "GET",
            data: {
                search: $('#filter-search').val(),
                page
            },
            success: function(res) {
                $('#tenggat-table').html($(res).find('#tenggat-table').html());
                $('#pagination-wrapper').html($(res).find('#pagination-wrapper').html());
                applyColumnToggles();
            },
            complete: function() {
                $('#tenggat-table').removeClass('d-none');
                $('#loading-spinner').addClass('d-none');
                $('.pagination a').removeClass('disabled');
            }
        });
    }

    function applyColumnToggles() {
        $('.toggle-col').each(function() {
            const sel = '.col-' + $(this).data('target');
            $(this).is(':checked') ? $(sel).show() : $(sel).hide();
        });
    }

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const formId = $(this).data('form-id');
        console.log('Form ID:', formId);
        console.log('Form ditemukan:', form.length);

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
