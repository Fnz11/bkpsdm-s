<script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        const modalElement = document.getElementById('modalFormDinamis');
        if (modalElement) {
            modalElement.addEventListener('hidden.bs.modal', function() {
                const form = document.getElementById('dynamicModalForm');
                form.classList.remove('was-validated');
                form.reset();
                document.getElementById('modalFormFields').innerHTML = '';

                const methodInput = form.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();
            });
        }
    })();

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, "&amp;")
            .replace(/"/g, "&quot;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");
    }

    function openDynamicModal(config) {
        const form = document.getElementById('dynamicModalForm');
        const fieldsContainer = document.getElementById('modalFormFields');
        const modalTitle = document.getElementById('modalFormDinamisLabel');
        const submitTextElement = document.getElementById('modalSubmitText');

        form.reset();
        form.classList.remove('was-validated');
        fieldsContainer.innerHTML = '';

        form.action = config.action;
        form.method = 'POST';

        const existingMethodInput = form.querySelector('input[name="_method"]');
        if (existingMethodInput) existingMethodInput.remove();

        const actualMethod = (config.method || 'POST').toUpperCase();
        if (actualMethod !== 'POST') {
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = actualMethod;
            form.prepend(methodInput);
        }

        submitTextElement.textContent = actualMethod === 'PUT' ? 'Perbarui' : 'Simpan';

        modalTitle.innerHTML =
            `<i class="bi ${config.icon || (config.data ? 'bi-pencil-square' : 'bi-plus-circle')} me-2"></i> ${config.title || (config.data ? 'Edit Data' : 'Tambah Data')}`;

        const errors = config.errors || {};

        config.fields.forEach(field => {
            const col = document.createElement('div');
            col.classList.add('col-md-' + (field.col || 12));

            const fieldName = field.name;
            const value = config.data?.[fieldName] ?? '';
            const safeValue = escapeHtml(value);
            const hasError = errors.hasOwnProperty(fieldName);
            const errorFeedback = hasError ?
                `<div class="invalid-feedback d-block">${escapeHtml(errors[fieldName][0])}</div>` : '';

            let input = '';
            switch (field.type) {
                case 'text':
                case 'number':
                case 'date':
                    input = `
                        <label for="${fieldName}" class="form-label">${field.label}</label>
                        <input type="${field.type}" name="${fieldName}" id="${fieldName}" 
                            class="form-control ${hasError ? 'is-invalid' : ''}" 
                            value="${safeValue}" ${field.required ? 'required' : ''} 
                            placeholder="${field.placeholder || 'Masukkan ' + field.label}">
                        ${errorFeedback}
                    `;
                    break;
                case 'select':
                    const placeholderText = field.placeholder || 'Pilih ' + field.label;
                    console.log(placeholderText);
                    

                    const hasEmptyOption = field.options.some(opt => opt.value === '');
                    const optionsHtml = (field.select2 && !hasEmptyOption ?
                            `<option value=""></option>` : '') +
                        field.options.map(opt =>
                            `<option value="${escapeHtml(opt.value)}" ${opt.disabled ? 'disabled' : ''}
                                ${opt.value == value ? 'selected' : ''}>${escapeHtml(opt.label)}</option>`
                        ).join('');

                    input = `
                    <div>
                        <label for="${fieldName}" class="form-label">${field.label}</label>
                        <select name="${fieldName}" id="${fieldName}" 
                            class="form-select ${hasError ? 'is-invalid' : ''} ${field.select2 ? 'select2' : ''}" 
                            data-placeholder="${escapeHtml(placeholderText)}"
                            style="width: 100%;" ${field.required ? 'required' : ''}>
                            ${optionsHtml}
                        </select>
                        ${errorFeedback}
                    </div>
                    `;
                    break;
                case 'textarea':
                    input = `
                        <label for="${fieldName}" class="form-label">${field.label}</label>
                        <textarea name="${fieldName}" id="${fieldName}" rows="3" 
                            class="form-control ${hasError ? 'is-invalid' : ''}"
                            ${field.required ? 'required' : ''}>${safeValue}</textarea>
                        ${errorFeedback}
                    `;
                    break;
            }

            col.innerHTML = input;
            fieldsContainer.appendChild(col);
        });

        // Apply select2 with dynamic placeholder
        setTimeout(() => {
            $('.select2').each(function() {
                const $select = $(this);
                $select.select2({
                    dropdownParent: $('#modalFormDinamis'),
                    theme: 'bootstrap4',
                    placeholder: $select.data('placeholder') || '',
                    allowClear: true
                });
            });
        }, 10);

        const modal = new bootstrap.Modal(document.getElementById('modalFormDinamis'));
        modal.show();
    }
</script>
