<script>
    let alertModalInstance = null;
    let alertModalTimeout = null;

    /**
     * Tampilkan modal alert.
     * @param {string} message - Isi pesan modal
     * @param {string} title - Judul modal
     * @param {number} duration - Waktu auto-close (ms). 0 = manual close
     * @param {object} options - { confirmText: string, onConfirm: function }
     */
    function showAlertModal(message, title = 'Peringatan', duration = 3000, options = {}) {
        const modalEl = document.getElementById('globalAlertModal');
        const modalHeader = document.getElementById('globalAlertModalHeader');
        const modalTitle = document.getElementById('globalAlertModalLabel');
        const modalBody = document.getElementById('globalAlertModalBody');
        const modalFooter = document.getElementById('globalAlertModalFooter');
        const confirmBtn = document.getElementById('globalAlertModalConfirmBtn');

        modalTitle.textContent = title;
        modalBody.innerHTML = message;

        // Reset header background class
        modalHeader.classList.remove('bg-warning', 'bg-info', 'bg-primary', 'bg-success', 'bg-danger', 'bg-secondary');

        // Set background sesuai jenis pesan
        switch (title.toLowerCase()) {
            case 'warning':
                modalHeader.classList.add('bg-warning');
                break;
            case 'info', 'confirm':
                modalHeader.classList.add('bg-primary');
                break;
            case 'success':
                modalHeader.classList.add('bg-success');
                break;
            case 'error':
                modalHeader.classList.add('bg-danger');
                break;
            default:
                modalHeader.classList.add('bg-secondary');
                break;
        }

        // Buat instance modal jika belum ada
        if (!alertModalInstance) {
            alertModalInstance = new bootstrap.Modal(modalEl);
        }

        // Tampilkan modal
        alertModalInstance.show();

        // Clear timeout lama jika ada
        if (alertModalTimeout) {
            clearTimeout(alertModalTimeout);
        }

        // Tampilkan atau sembunyikan footer tergantung ada tidaknya konfirmasi
        if (options.confirmText || typeof options.onConfirm === 'function') {
            modalFooter.style.display = 'flex';
            confirmBtn.innerHTML = options.confirmText || 'Ya';
            confirmBtn.onclick = () => {
                if (typeof options.onConfirm === 'function') {
                    options.onConfirm();
                }
                alertModalInstance.hide();
            };
        } else {
            modalFooter.style.display = 'none';
        }

        // Auto hide jika duration > 0
        if (duration > 0) {
            alertModalTimeout = setTimeout(() => {
                alertModalInstance.hide();
            }, duration);
        }
    }
</script>
