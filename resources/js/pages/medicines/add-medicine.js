// The modal container itself
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


const addMedicineModal = document.getElementById('add-medicine-modal');

// The form element
const addMedicineForm = document.getElementById('add-medicine-form');

// Input and select fields
const medicineNameInput = document.getElementById('medicine_name');
const genericNameInput = document.getElementById('generic_name');
const descriptionTextarea = document.getElementById('medicine-description');

const addMedBtn = document.getElementById('add-med-btn');
// Form buttons
const submitButton = document.getElementById('add-medicine-submit-btn');
const cancelButton = document.getElementById('close-submit-med')

// Get elements for the Category dropdown
const categoryMenu = document.getElementById('medCategoryDropdownMenu');
const categorySelectedText = document.getElementById('med-category-selected-text');
const categoryValueInput = document.getElementById('med_category_value');

// Get elements for the Form dropdown
const formMenu = document.getElementById('formDropdownMenu');
const formSelectedText = document.getElementById('form-selected-text');
const formValueInput = document.getElementById('form_value');


// The confirmation modal container
const confirmAddMedicineModal = document.getElementById('confirm-add-medicine-modal');
const medicineNameToConfirm = document.getElementById('medicine-name-to-confirm');
const confirmMedicineCheckbox = document.getElementById('confirm-medicine-checkbox');
const confirmAddMedicineBtn = document.getElementById('confirm-add-medicine-btn');
const cancelConfirmAddMedicineBtn = document.getElementById('cancel-confirm-add-medicine');


const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');


const addMedModal = new Modal(addMedicineModal, createModalOptions(addMedicineModal));
const confirmAddMedModal = new Modal(confirmAddMedicineModal, createModalOptions(confirmAddMedicineModal));
const successMedModal = new Modal(successModalEl, createModalOptions(successModalEl));

// --- NEW: FORM VALIDATION LOGIC ---
let addMedPayload = null;
// 1. Disable the submit button by default
submitButton.disabled = true;

function validateForm() {
    // Define validation conditions for required fields
    const isMedicineNameValid = medicineNameInput.value.trim() !== '';
    const isCategoryValid = categoryValueInput.value !== '';
    const isFormValid = formValueInput.value !== '';

    // Determine overall form validity
    const isFormCompletelyValid = isMedicineNameValid && isCategoryValid && isFormValid;

    // Update the submit button's state
    submitButton.disabled = !isFormCompletelyValid;

    // Conditionally build or clear the payload
    if (isFormCompletelyValid) {
        // If the form is valid, create the payload object
        addMedPayload = {
            medicine_name: medicineNameInput.value.trim(),
            generic_name: genericNameInput.value.trim(),
            category: categoryValueInput.value,
            form: formValueInput.value,
            description: descriptionTextarea.value.trim()
        };
    } else {
        // If the form is invalid, reset the payload to null
        addMedPayload = null;
    }
}
// 2. Add event listeners to call the validation function on input changes
medicineNameInput.addEventListener('input', validateForm);


function setupDropdown(menuElement, textElement, inputElement) {
    menuElement.addEventListener('click', function (event) {
        if (event.target.tagName === 'BUTTON') {
            const selectedValue = event.target.dataset.value;
            const selectedText = event.target.textContent;

            textElement.textContent = selectedText;
            inputElement.value = selectedValue;

            // 3. MODIFIED: Run validation after a dropdown selection is made
            validateForm();
        }
    });
}

// Initialize both dropdowns
setupDropdown(categoryMenu, categorySelectedText, categoryValueInput);
setupDropdown(formMenu, formSelectedText, formValueInput);


// --- EXISTING MODAL AND SUBMIT LOGIC ---

addMedBtn.addEventListener('click', function () {

    if (addMedModal) {
        addMedModal.show();
    }
    // MODIFIED: Also validate the form when the modal opens
    validateForm();
});

cancelButton.addEventListener('click', function () {
    if (addMedModal) {
        // Clear standard text inputs
        medicineNameInput.value = '';
        genericNameInput.value = '';
        descriptionTextarea.value = '';

        // --- NEW: Reset Dropdowns ---
        // Reset the Category dropdown to its default state
        categorySelectedText.textContent = 'Select Category';
        categoryValueInput.value = '';

        // Reset the Form dropdown to its default state
        formSelectedText.textContent = 'Select Form';
        formValueInput.value = '';

        addMedModal.hide();
    }

    // Validate the form, which will now be invalid and disable the submit button
    validateForm();
});

submitButton.addEventListener('click', function (event) {
    event.preventDefault();



    if (addMedModal && confirmAddMedModal && addMedPayload) {
        // 1. Get the medicine name from the payload
        medicineNameToConfirm.textContent = addMedPayload.medicine_name;

        // 2. Hide the form modal
        addMedModal.hide();

        // 3. Show the confirmation modal
        confirmAddMedModal.show();
    }
});

confirmMedicineCheckbox.addEventListener('change', function () {
    confirmAddMedicineBtn.disabled = !this.checked;
});

confirmAddMedicineBtn.addEventListener('click', function () {
    // Disable the button to prevent multiple clicks
    confirmAddMedicineBtn.disabled = true;
    confirmAddMedicineBtn.textContent = 'Saving...';

    // Get the CSRF token from the meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    const finalDescriptionTextarea = document.getElementById('medicine-description');
    if (finalDescriptionTextarea) {
        // Add the trimmed description value to the payload.
        addMedPayload.description = finalDescriptionTextarea.value.trim();
    }

    // Use the Fetch API to send the data
    fetch('/midwife/add-medicines', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(addMedPayload)
    })
        .then(response => {
            // Check if the response was successful
            if (!response.ok) {
                // If not, throw an error to be caught by the .catch block
                throw new Error('Network response was not ok.');
            }
            return response.json(); // Parse the JSON response from the server
        })
        .then(data => {
            // SUCCESS: The data was saved successfully
            console.log('Success:', data); // Log the success response from Laravel

            // Now, show the success modal
            if (successMedModal && confirmAddMedModal) {
                confirmAddMedModal.hide();
                successMesageHeader.textContent = 'Medicine Added';
                successMessage.textContent = `${addMedPayload.medicine_name ?? ''} has been successfully added.`;
                successMedModal.show();
            }
        })
        .catch(error => {
            // ERROR: Something went wrong
            console.error('Error:', error);
            alert('An error occurred while adding the medicine. Please try again.');

            // Re-enable the button so the user can try again
            confirmAddMedicineBtn.disabled = false;
            confirmAddMedicineBtn.textContent = 'Confirm & Add';
        });
});

closeSuccessModalButton.addEventListener('click', function () {
    window.location.reload();
});

cancelConfirmAddMedicineBtn.addEventListener('click', function () {
    const addMedModal = new Modal(addMedicineModal);
    const confirmAddMedModal = new Modal(confirmAddMedicineModal);

    if (addMedModal && confirmAddMedModal) {

        confirmAddMedModal.hide();
        addMedModal.show();
    }
});