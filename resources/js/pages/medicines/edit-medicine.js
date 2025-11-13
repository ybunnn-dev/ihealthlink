// resources/js/pages/medicines/edit-medicine.js

// --- Modal Options Factory ---
const createModalOptions = (modalEl) => ({
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            modalEl.classList.remove('opacity-0');
            modalEl.classList.add('opacity-100');
            
            const modalContent = modalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        modalEl.classList.add('opacity-0');
        modalEl.classList.remove('opacity-100');
        
        const modalContent = modalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
});

// --- Modal Element References ---
const editMedicineModalEl = document.getElementById('edit-medicine-modal');
const confirmEditMedicineModalEl = document.getElementById('confirm-edit-medicine-modal');
const successModalEl = document.getElementById('success-modal');

const cancelEdit = document.getElementById('cancel-edit-medicine-btn');
// --- Initialize Modal Instances ---
const editMedicineModal = new Modal(editMedicineModalEl, createModalOptions(editMedicineModalEl));
const confirmEditMedicineModal = new Modal(confirmEditMedicineModalEl, createModalOptions(confirmEditMedicineModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

const editMedBtn = document.getElementById('edit-med-btn');
// --- Initial Data ---
const initialMedicineData = window.medicineData;

// --- State Management ---
let editMedPayload = null;
let listenersAttached = false;

// --- DOM Element References ---
const confirmEditMedicineCheckbox = document.getElementById('confirm-edit-medicine-checkbox');
const confirmUpdateMedicineBtn = document.getElementById('confirm-update-medicine-btn');
const cancelConfirmEditMedicineBtn = document.getElementById('cancel-confirm-edit-medicine');
const updateMedicineSubmitBtn = document.getElementById('update-medicine-submit-btn');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

// --- Validation Function ---
function validateEditForm() {
    const editMedicineNameInput = document.getElementById('edit-medicine-name');
    const editGenericNameInput = document.getElementById('edit-generic-name');
    const editDescriptionTextarea = document.getElementById('edit-medicine-description');
    const editCategoryValueInput = document.getElementById('edit-category-value');
    const editFormValueInput = document.getElementById('edit-form-value');
    const editMedicineIdInput = document.getElementById('edit-medicine-id');

    const isNameValid = editMedicineNameInput.value.trim() !== '';
    const isCategoryValid = editCategoryValueInput.value !== '';
    const isFormValid = editFormValueInput.value !== '';
    const isFormComplete = isNameValid && isCategoryValid && isFormValid;

    let hasChanged = false;
    if (isFormComplete) {
        if (editMedicineNameInput.value.trim() !== initialMedicineData.medicine_name ||
            editGenericNameInput.value.trim() !== initialMedicineData.generic_name ||
            editCategoryValueInput.value !== initialMedicineData.category ||
            editFormValueInput.value !== initialMedicineData.form ||
            editDescriptionTextarea.value.trim() !== initialMedicineData.description) 
        {
            hasChanged = true;
        }
    }
    updateMedicineSubmitBtn.disabled = !(isFormComplete && hasChanged);

    if (isFormComplete && hasChanged) {
        editMedPayload = {
            id: editMedicineIdInput.value,
            medicine_name: editMedicineNameInput.value.trim(),
            generic_name: editGenericNameInput.value.trim(),
            category: editCategoryValueInput.value,
            form: editFormValueInput.value,
            description: editDescriptionTextarea.value.trim()
        };
    } else {
        editMedPayload = null;
    }
}

// --- Dropdown Setup Function ---
function setupEditDropdown(menuElement, textElement, inputElement) {
    menuElement.addEventListener('click', function(event) {
        if (event.target.tagName === 'BUTTON') {
            textElement.textContent = event.target.textContent;
            inputElement.value = event.target.dataset.value;
            validateEditForm();
        }
    });
}

// --- Main Edit Button Handler ---
editMedBtn.addEventListener('click', function() {
    // --- Get form elements ---
    const editMedicineIdInput = document.getElementById('edit-medicine-id');
    const editMedicineNameInput = document.getElementById('edit-medicine-name');
    const editGenericNameInput = document.getElementById('edit-generic-name');
    const editDescriptionTextarea = document.getElementById('edit-medicine-description');
    const editCategoryMenu = document.getElementById('edit-category-dropdown-menu');
    const editCategorySelectedText = document.getElementById('edit-category-selected-text');
    const editCategoryValueInput = document.getElementById('edit-category-value');
    const editFormMenu = document.getElementById('edit-form-dropdown-menu');
    const editFormSelectedText = document.getElementById('edit-form-selected-text');
    const editFormValueInput = document.getElementById('edit-form-value');

    // --- Pre-fill form fields ---
    editMedicineIdInput.value = initialMedicineData.id;
    editMedicineNameInput.value = initialMedicineData.medicine_name;
    editGenericNameInput.value = initialMedicineData.generic_name;
    editDescriptionTextarea.value = initialMedicineData.description;
    editCategorySelectedText.textContent = initialMedicineData.category;
    editCategoryValueInput.value = initialMedicineData.category;
    editFormSelectedText.textContent = initialMedicineData.form;
    editFormValueInput.value = initialMedicineData.form;

    // --- Attach event listeners once ---
    if (!listenersAttached) {
        setupEditDropdown(editCategoryMenu, editCategorySelectedText, editCategoryValueInput);
        setupEditDropdown(editFormMenu, editFormSelectedText, editFormValueInput);
        editMedicineNameInput.addEventListener('input', validateEditForm);
        editGenericNameInput.addEventListener('input', validateEditForm);
        editDescriptionTextarea.addEventListener('input', validateEditForm);
        listenersAttached = true;
    }

    validateEditForm();
    editMedicineModal.show();
});

cancelEdit.addEventListener('click', function(){
    editMedicineModal.hide();
});
// --- Update Medicine Submit Handler ---
updateMedicineSubmitBtn.addEventListener('click', function(event) {
    event.preventDefault();
    if (!editMedPayload) return;

    const editMedicineNameToConfirm = document.getElementById('edit-medicine-name-to-confirm');
    editMedicineNameToConfirm.textContent = editMedPayload.medicine_name;
    
    editMedicineModal.hide();
    confirmEditMedicineModal.show();
});

// --- Confirmation Checkbox Handler ---
confirmEditMedicineCheckbox.addEventListener('change', function() {
    confirmUpdateMedicineBtn.disabled = !this.checked;
});

// --- Confirm Update Handler ---
confirmUpdateMedicineBtn.addEventListener('click', function() {
    console.log('Final payload to submit:', editMedPayload);
    
    // Save original button text
    const originalButtonText = confirmUpdateMedicineBtn.textContent;
    
    // Disable both buttons and show loading state
    confirmUpdateMedicineBtn.disabled = true;
    cancelConfirmEditMedicineBtn.disabled = true;
    confirmUpdateMedicineBtn.textContent = 'Saving...';
    
    fetch(`/midwife/update-med/${editMedPayload.id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(editMedPayload)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Server response:', data);

        // Wait 2 seconds before showing success or error
        setTimeout(() => {
            if (data.result === 'success') {
                confirmEditMedicineModal.hide();
                successMesageHeader.textContent = 'Medicine Updated';
                successMessage.textContent = 'Medicine details have been updated';
                successModal.show();
                
                // Reset button states
                confirmUpdateMedicineBtn.textContent = originalButtonText;
                confirmUpdateMedicineBtn.disabled = false;
                cancelConfirmEditMedicineBtn.disabled = false;
            } else {
                // Handle error case
                alert('Error: ' + (data.message || 'Failed to update medicine'));
                
                // Re-enable buttons on error
                confirmUpdateMedicineBtn.textContent = originalButtonText;
                confirmUpdateMedicineBtn.disabled = false;
                cancelConfirmEditMedicineBtn.disabled = false;
            }
        }, 2000);
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Wait 2 seconds before showing error
        setTimeout(() => {
            alert('An error occurred while updating the medicine. Please try again.');
            
            // Re-enable buttons on error
            confirmUpdateMedicineBtn.textContent = originalButtonText;
            confirmUpdateMedicineBtn.disabled = false;
            cancelConfirmEditMedicineBtn.disabled = false;
        }, 2000);
    });
});
// --- Cancel Confirmation Handler ---
cancelConfirmEditMedicineBtn.addEventListener('click', function() {
    confirmEditMedicineModal.hide();
    editMedicineModal.show();
    
    confirmEditMedicineCheckbox.checked = false;
    confirmUpdateMedicineBtn.disabled = true;
});

// --- Success Modal Close Handler ---
closeSuccessModalButton.addEventListener('click', function() {
    window.location.reload();
});


