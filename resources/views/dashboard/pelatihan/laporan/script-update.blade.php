<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi modal
        const modalUpdateBulkLaporan = new bootstrap.Modal('#modalUpdateBulkLaporan');
        const searchBoxBulkLaporan = document.getElementById('search-box-bulk-laporan');
        const selectAllBulkLaporan = document.getElementById('select-all-bulk-laporan');
        const selectedCountBulkLaporan = document.getElementById('selected-count-bulk-laporan');
        const formUpdateBulkLaporan = document.getElementById('form-update-bulk-laporan');
        const hasilPelatihanSelect = formUpdateBulkLaporan.querySelector('select[name="hasil_pelatihan"]');
        const btnSubmitBulkLaporan = document.getElementById('btn-submit-bulk-laporan');
        const checkboxListContainer = document.getElementById('checkbox-list-bulk-laporan');

        // Fungsi debounce untuk pencarian
        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

        // Fungsi untuk update jumlah yang dipilih
        function updateSelectedCount() {
            const checkedBoxes = checkboxListContainer.querySelectorAll('input[type="checkbox"]:checked');
            const count = checkedBoxes.length;
            selectedCountBulkLaporan.textContent = `${count} laporan dipilih`;
            btnSubmitBulkLaporan.disabled = count === 0 || !hasilPelatihanSelect.value;

            // Update status "Pilih Semua"
            const visibleCheckboxes = checkboxListContainer.querySelectorAll(
                '.checkbox-item:not([style*="display: none"]) input[type="checkbox"]');
            const allVisibleChecked = visibleCheckboxes.length > 0 &&
                Array.from(visibleCheckboxes).every(checkbox => checkbox.checked);
            selectAllBulkLaporan.checked = allVisibleChecked;
        }

        // Event listener untuk pencarian
        searchBoxBulkLaporan.addEventListener('input', debounce(function() {
            const searchTerm = this.value.toLowerCase().trim();
            const items = checkboxListContainer.querySelectorAll('.checkbox-item');

            items.forEach(item => {
                const searchText = item.getAttribute('data-nama');
                item.style.display = searchText.includes(searchTerm) ? '' : 'none';
            });

            selectAllBulkLaporan.checked = false;
            updateSelectedCount();
        }, 300));

        // Event listener untuk Pilih Semua
        selectAllBulkLaporan.addEventListener('change', function() {
            const isChecked = this.checked;
            const visibleItems = checkboxListContainer.querySelectorAll(
                '.checkbox-item:not([style*="display: none"])');

            visibleItems.forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                checkbox.checked = isChecked;
            });

            updateSelectedCount();
        });

        // Event listener untuk perubahan status hasil pelatihan
        hasilPelatihanSelect.addEventListener('change', function() {
            updateSelectedCount();
        });

        // Event delegation untuk checkbox individual
        checkboxListContainer.addEventListener('change', function(e) {
            if (e.target.matches('input[type="checkbox"]')) {
                updateSelectedCount();
            }
        });

        // Validasi form sebelum submit
        formUpdateBulkLaporan.addEventListener('submit', function(e) {
            const checkedCount = checkboxListContainer.querySelectorAll(
                'input[type="checkbox"]:checked').length;

            if (checkedCount === 0) {
                e.preventDefault();
                showAlertModal('Pilih minimal satu laporan untuk diperbarui.', 'Warning');
                return;
            }

            if (!hasilPelatihanSelect.value) {
                e.preventDefault();
                showAlertModal('Pilih status hasil pelatihan untuk diperbarui.', 'Warning');
                return;
            }
        });

        // Reset form saat modal ditutup
        modalUpdateBulkLaporan._element.addEventListener('hidden.bs.modal', function() {
            formUpdateBulkLaporan.reset();
            searchBoxBulkLaporan.value = '';
            selectAllBulkLaporan.checked = false;

            // Reset tampilan semua item
            const items = checkboxListContainer.querySelectorAll('.checkbox-item');
            items.forEach(item => {
                item.style.display = '';
                item.querySelector('input[type="checkbox"]').checked = false;
            });

            updateSelectedCount();
        });

        // Inisialisasi awal
        updateSelectedCount();
    });
</script>
