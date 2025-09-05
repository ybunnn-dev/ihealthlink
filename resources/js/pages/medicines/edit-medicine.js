// resources/js/pages/medicines/edit-medicine.js

// This assumes your Blade view passes the medicine data to a global JS variable
const initialMedicineData = window.medicineData; 

// --- Get only the top-level elements that always exist ---
const confirmEditMedicineModal = document.getElementById('confirm-edit-medicine-modal');
const editMedicineModal = document.getElementById('edit-medicine-modal');

// --- State Management ---
let editMedPayload = null;
let listenersAttached = false; // A flag to prevent attaching listeners multiple times



const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');


// --- Main Event Listener for the Edit Button ---
document.addEventListener('click', function(event) {
    const editButton = event.target.closest('.edit-medicine-btn');
    if (editButton) {
        
        // --- Get all form elements *after* the button is clicked ---
        const editMedicineIdInput = document.getElementById('edit-medicine-id');
        const editMedicineNameInput = document.getElementById('edit-medicine-name');
        const editGenericNameInput = document.getElementById('edit-generic-name');
        const editDescriptionTextarea = document.getElementById('edit-medicine-description');
        const editCategoryMenu = document.getElementById('edit-category-dropdown-menu'); // Corrected ID
        const editCategorySelectedText = document.getElementById('edit-category-selected-text');
        const editCategoryValueInput = document.getElementById('edit-category-value');
        const editFormMenu = document.getElementById('edit-form-dropdown-menu'); // Corrected ID
        const editFormSelectedText = document.getElementById('edit-form-selected-text');
        const editFormValueInput = document.getElementById('edit-form-value');
        const updateMedicineSubmitBtn = document.getElementById('update-medicine-submit-btn');

        // --- Pre-fill the form fields ---
        editMedicineIdInput.value = initialMedicineData.id;
        editMedicineNameInput.value = initialMedicineData.medicine_name;
        editGenericNameInput.value = initialMedicineData.generic_name;
        editDescriptionTextarea.value = initialMedicineData.description;
        editCategorySelectedText.textContent = initialMedicineData.category;
        editCategoryValueInput.value = initialMedicineData.category;
        editFormSelectedText.textContent = initialMedicineData.form;
        editFormValueInput.value = initialMedicineData.form;
        
        // --- Validation Logic ---
        function validateEditForm() {
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

        // --- Attach Event Listeners (only once) ---
        if (!listenersAttached) {
            function setupEditDropdown(menuElement, textElement, inputElement) {
                menuElement.addEventListener('click', function(event) {
                    if (event.target.tagName === 'BUTTON') {
                        textElement.textContent = event.target.textContent;
                        inputElement.value = event.target.dataset.value;
                        validateEditForm();
                    }
                });
            }

            setupEditDropdown(editCategoryMenu, editCategorySelectedText, editCategoryValueInput);
            setupEditDropdown(editFormMenu, editFormSelectedText, editFormValueInput);
            editMedicineNameInput.addEventListener('input', validateEditForm);
            editGenericNameInput.addEventListener('input', validateEditForm);
            editDescriptionTextarea.addEventListener('input', validateEditForm);
            
            listenersAttached = true;
        }

        // Run validation immediately to set the initial button state
        validateEditForm();
    }
});


// --- Listeners for the Confirmation Modals ---
const confirmEditMedicineCheckbox = document.getElementById('confirm-edit-medicine-checkbox');
const confirmUpdateMedicineBtn = document.getElementById('confirm-update-medicine-btn');
const cancelConfirmEditMedicineBtn = document.getElementById('cancel-confirm-edit-medicine');
const updateMedicineSubmitBtn = document.getElementById('update-medicine-submit-btn');

updateMedicineSubmitBtn.addEventListener('click', function(event) {
    event.preventDefault();
    if (editMedPayload) {
        const editModal = new Modal(editMedicineModal);
        const confirmModal = new Modal(confirmEditMedicineModal);
        const editMedicineNameToConfirm = document.getElementById('edit-medicine-name-to-confirm');

        editMedicineNameToConfirm.textContent = editMedPayload.medicine_name;
        editModal.hide();
        confirmModal.show();
    }
});

confirmEditMedicineCheckbox.addEventListener('change', function() {
    confirmUpdateMedicineBtn.disabled = !this.checked;
});

confirmUpdateMedicineBtn.addEventListener('click', function() {
    console.log('Final payload to submit:', editMedPayload);

    const confirmEditMedModal = new Modal(confirmEditMedicineModal);
    const successMedModal = new Modal(successModalEl);
    
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

        if(data.result == 'success'){
            if(confirmEditMedModal && successMedModal){
                confirmEditMedModal.hide();
                successMesageHeader.textContent = 'Medicine Updated';
                successMessage.textContent = 'Midwife details has been updated';
                successMedModal.show();
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

cancelConfirmEditMedicineBtn.addEventListener('click', function() {
    const editModal = new Modal(editMedicineModal);
    const confirmModal = new Modal(confirmEditMedicineModal);
    
    confirmModal.hide();
    editModal.show();
    
    confirmEditMedicineCheckbox.checked = false;
    confirmUpdateMedicineBtn.disabled = true;
});


closeSuccessModalButton.addEventListener('click', function() {
    window.location.reload();
});