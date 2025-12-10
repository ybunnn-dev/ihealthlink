// --- 1. Get HTML elements ---
const editBarangayModalEl = document.getElementById('edit-barangay-modal');
const confirmEditModalEl = document.getElementById('confirm-edit-barangay-modal');
const removeModalEl = document.getElementById('remove-barangay-modal');
const mainTriggerBtn = document.getElementById('edit-brgy-button');
const removeTrigger = document.getElementById('remove-brgy-button');

// --- 2. Success modal elements ---
const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

// --- 3. Create separate options for each modal with fade animations ---
const editBarangayModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            editBarangayModalEl.classList.remove('opacity-0');
            editBarangayModalEl.classList.add('opacity-100');
            
            const modalContent = editBarangayModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        editBarangayModalEl.classList.add('opacity-0');
        editBarangayModalEl.classList.remove('opacity-100');
        
        const modalContent = editBarangayModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

const confirmEditModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            confirmEditModalEl.classList.remove('opacity-0');
            confirmEditModalEl.classList.add('opacity-100');
            
            const modalContent = confirmEditModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        confirmEditModalEl.classList.add('opacity-0');
        confirmEditModalEl.classList.remove('opacity-100');
        
        const modalContent = confirmEditModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

const removeModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            removeModalEl.classList.remove('opacity-0');
            removeModalEl.classList.add('opacity-100');
            
            const modalContent = removeModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        removeModalEl.classList.add('opacity-0');
        removeModalEl.classList.remove('opacity-100');
        
        const modalContent = removeModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

const successModalOptions = {
    onShow: () => {
        setTimeout(() => {
            successModalEl.classList.remove('opacity-0');
            successModalEl.classList.add('opacity-100');
            
            const modalContent = successModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        successModalEl.classList.add('opacity-0');
        successModalEl.classList.remove('opacity-100');
        
        const modalContent = successModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

// --- 4. Create Flowbite Modal Instances with their own options ---
const editBarangayModal = new Modal(editBarangayModalEl, editBarangayModalOptions);
const confirmEditModal = new Modal(confirmEditModalEl, confirmEditModalOptions);
const removeModal = new Modal(removeModalEl, removeModalOptions);
const successModal = new Modal(successModalEl, successModalOptions);

// --- 5. Get other elements ---
const barangayNameInput = document.getElementById('barangay-name-input');
const openConfirmBtn = document.getElementById('open-confirmation-modal-button');
const confirmCheckbox = document.getElementById('confirm-barangay-checkbox');
const removeCheckBox = document.getElementById('remove-barangay-checkbox');
const confirmProceedBtn = document.getElementById('confirm-proceed-button');
const brgyName = window.brgy_name || [];
const cancelConfirmBtn = confirmEditModalEl.querySelector('[data-modal-hide="confirm-edit-barangay-modal"]');
const cancelEdit = document.getElementById('cancel-edit-barangay');
const cancelRemove = document.getElementById('remove-cancel');
const proceedRemove = document.getElementById('confirm-remove-button');

// --- 6. Add Event Listener to Open the First Modal ---
mainTriggerBtn.addEventListener('click', function () {
    barangayNameInput.value = brgyName;
    editBarangayModal.show();
});

removeTrigger.addEventListener('click', function () {
    document.getElementById('barangay-name-to-remove').textContent = brgyName;
    removeModal.show();
});

cancelRemove.addEventListener('click', function () {
    removeModal.hide();
});

// --- 7. Open the confirmation modal ---
openConfirmBtn.addEventListener('click', function () {
    const barangayName = barangayNameInput.value.trim();
    if (barangayName === '') {
        alert('Please enter a barangay name.');
        return;
    }
    const namePlaceholder = document.getElementById('barangay-name-to-confirm');
    namePlaceholder.textContent = barangayName;

    editBarangayModal.hide();
    confirmEditModal.show();
});

// --- 8. Handle checkbox logic ---
confirmCheckbox.addEventListener('change', function () {
    confirmProceedBtn.disabled = !this.checked;
});

removeCheckBox.addEventListener('change', function () {
    proceedRemove.disabled = !this.checked;
});

// --- 9. Handle the final confirmation for REMOVE ---
proceedRemove.addEventListener('click', async function () {
    const barangayId = this.getAttribute('data-id');

    this.disabled = true;
    this.textContent = 'Deactivating...';

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch(`/barangays/${barangayId}/deactivate`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Failed to deactivate barangay.');
        }

        // Hide remove modal and show success modal
        removeModal.hide();
        successMesageHeader.textContent = 'Barangay Removed';
        successMessage.textContent = 'The barangay has been successfully deactivated.';
        successModal.show();

        // Redirect after showing success modal
        setTimeout(() => {
            window.location.href = '/mho/barangays';
        }, 2000);

    } catch (error) {
        console.error('Deactivate Error:', error);
        alert('An error occurred while deactivating the barangay.');
        this.disabled = false;
        this.textContent = 'Confirm Remove';
    }
});

// --- 10. Handle the final confirmation for EDIT ---
confirmProceedBtn.addEventListener('click', async function () {
    const barangayId = this.getAttribute('data-id');
    const barangayNameToInsert = barangayNameInput.value.trim();

    this.disabled = true;
    this.textContent = 'Saving...';

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch(`/barangays/${barangayId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                name: barangayNameToInsert
            })
        });

        const result = await response.json();

        if (!response.ok) {
            if (response.status === 422) {
                const errors = Object.values(result.errors).map(e => e.join('\n')).join('\n');
                alert('Validation Error:\n' + errors);
                window.location.reload();
            } else {
                throw new Error(result.message || 'An unknown error occurred.');
            }
            this.disabled = false;
            this.textContent = 'Confirm & Proceed';
        } else {
            // Hide confirmation modal and show success modal
            confirmEditModal.hide();
            successMesageHeader.textContent = 'Barangay Updated';
            successMessage.textContent = `Barangay has been successfully updated to "${barangayNameToInsert}".`;
            successModal.show();

            // Reload after showing success modal
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        }

    } catch (error) {
        console.error('Submission Error:', error);
        alert('An error occurred while saving the barangay. Please check the console.');
        this.disabled = false;
        this.textContent = 'Confirm & Proceed';
    }
});

// --- 11. Handle cancellation of the confirmation ---
if (cancelConfirmBtn) {
    cancelConfirmBtn.addEventListener('click', function () {
        confirmEditModal.hide();
        editBarangayModal.show();
    });
}

if (cancelEdit) {
    cancelEdit.addEventListener('click', function () {
        barangayNameInput.value = brgyName;
        editBarangayModal.hide();
    });
}

// --- 12. Handle closing success modal ---
if (closeSuccessModalButton) {
    closeSuccessModalButton.addEventListener('click', function () {
        successModal.hide();
    });
}
