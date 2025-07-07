<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalUpdateBulk = new bootstrap.Modal('#modalUpdateBulk');
        const searchBoxBulk = document.getElementById('search-box-bulk');
        const checkboxItemsBulk = document.querySelectorAll('#checkbox-list-bulk .checkbox-item');
        const selectAllBulk = document.getElementById('select-all-bulk');
        const selectedCountBulk = document.getElementById('selected-count-bulk');
        const formUpdateBulk = document.getElementById('form-update-bulk');
        const statusVerifikasiSelect = formUpdateBulk.querySelector('select[name="status_verifikasi"]');
        const statusPesertaSelect = formUpdateBulk.querySelector('select[name="status_peserta"]');
        const btnSubmitBulk = document.getElementById('btn-submit-bulk');

        // Reset form ketika modal ditutup
        modalUpdateBulk._element.addEventListener('hidden.bs.modal', function() {
            formUpdateBulk.reset();
            searchBoxBulk.value = '';
            selectedCountBulk.textContent = '0 pendaftaran dipilih';
            selectAllBulk.checked = false;
            checkboxItemsBulk.forEach(item => item.style.display = 'block');
        });

        // Filter pencarian
        searchBoxBulk.addEventListener('input', debounce(function() {
            const query = this.value.toLowerCase().trim();
            checkboxItemsBulk.forEach(item => {
                const text = item.getAttribute('data-nama');
                item.style.display = text.includes(query) ? 'block' : 'none';
            });
            selectAllBulk.checked = false;
            updateSelectedCountBulk();
        }, 300));

        // Pilih Semua
        selectAllBulk.addEventListener('change', function() {
            const isChecked = this.checked;
            checkboxItemsBulk.forEach(item => {
                if (item.style.display !== 'none') {
                    const checkbox = item.querySelector('input[type="checkbox"]');
                    checkbox.checked = isChecked;
                }
            });
            updateSelectedCountBulk();
        });

        // Update count ketika checkbox diklik
        checkboxItemsBulk.forEach(item => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAllBulk.checked = false;
                } else {
                    // Cek apakah semua checkbox yang terlihat sudah tercentang
                    const allVisibleChecked = [...checkboxItemsBulk]
                        .filter(item => item.style.display !== 'none')
                        .every(item => item.querySelector('input[type="checkbox"]').checked);
                    selectAllBulk.checked = allVisibleChecked;
                }
                updateSelectedCountBulk();
            });
        });

        // Validasi form sebelum submit
        formUpdateBulk.addEventListener('submit', function(e) {
            const checkedCount = document.querySelectorAll(
                '#checkbox-list-bulk input[type="checkbox"]:checked').length;
            if (checkedCount === 0) {
                e.preventDefault();
                showAlertModal('Pilih minimal satu pendaftaran untuk diperbarui.', 'Warning');
                return;
            }

            if (!statusVerifikasiSelect.value && !statusPesertaSelect.value) {
                e.preventDefault();
                showAlertModal('Pilih minimal satu status untuk diperbarui.', 'Warning');
                return;
            }
        });

        // Fungsi untuk update count
        function updateSelectedCountBulk() {
            const checkedCount = document.querySelectorAll('#checkbox-list-bulk input[type="checkbox"]:checked')
                .length;
            selectedCountBulk.textContent = `${checkedCount} pendaftaran dipilih`;
            btnSubmitBulk.disabled = checkedCount === 0;
        }

        // Fungsi debounce untuk search
        function debounce(func, wait) {
            let timeout;
            return function() {
                const context = this,
                    args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), wait);
            };
        }

        updateSelectedCountBulk();
    });
</script>
