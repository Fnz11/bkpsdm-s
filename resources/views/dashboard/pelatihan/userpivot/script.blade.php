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
                    currentView = 'aktif';
                } else {
                    $('#aktif-container').addClass('d-none');
                    $('#usulan-container').removeClass('d-none');
                    $('#pagination-wrapper-aktif').addClass('d-none');
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
</script>
