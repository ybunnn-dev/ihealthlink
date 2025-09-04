const editMidwifeModalEl = document.getElementById('edit-midwife-modal');
const confirmEditMidwifeModalEl = document.getElementById('confirm-edit-midwife-modal');

const barangayData = window.emptyBarangay;
const currentMidwifeData = window.midwifeData;


const editMidwifeFirstName = document.getElementById('editMidwifeFirstName');
const editMidwifeLastName = document.getElementById('editMidwifeLastName');
const editMidwifeMiddleName = document.getElementById('editMidwifeMiddleName');
const editContactNo = document.getElementById('editContactNo');
const editMidwifeEmail = document.getElementById('editMidwifeEmail');
const editMidwifeBdate = document.getElementById('editMidwifeBdate');
const editMidwifeAge = document.getElementById('editMidwifeAge');
const editPrefixDropdown = document.getElementById('editPrefixDropdown');
const editBarangayDropdown = document.getElementById('editBarangayDropdown');
const editSexDropdown = document.getElementById('editSexDropdown');
const editCivilStatusDropdown = document.getElementById('editCivilStatusDropdown');
const editReligionDropdown = document.getElementById('editReligionDropdown');
const updateMidwifeSubmitBtn = document.getElementById('updateMidwifeSubmitBtn');
const editMidwifeBtn = document.getElementById('edit-midwife-btn');
const cancelEditMidwifeBtn = document.getElementById('cancel-edit-midwife');
const midwifeNameToEditConfirm = document.getElementById('midwife-name-to-edit-confirm');

// The checkbox to confirm the review
const confirmEditMidwifeCheckbox = document.getElementById('confirm-edit-midwife-checkbox');
const closeConfirmEditMidwifeBtn = document.getElementById('close-confirm-edit-midwife');
const confirmEditMidwifeBtn = document.getElementById('confirm-edit-midwife-button');


const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');


let editMidwifePayload = null;

const options = {
    // This prevents the modal from closing when the backdrop is clicked
    backdrop: 'static', 
};
function populateBarangayDropdown(barangays) {
    const barangayMenu = document.querySelector('#editBarangayDropdownMenu ul');
    if (!barangayMenu || !editBarangayDropdown) return;
    
    barangayMenu.innerHTML = ''; // Clear existing items
    console.log(barangays);

    // Add "Reset" item first
    const resetItem = document.createElement('li');
    const resetButton = document.createElement('button');
    resetButton.type = 'button';
    resetButton.textContent = 'Reset';
    resetButton.className = 'w-full text-left px-4 py-2 hover:bg-gray-100';
    resetButton.addEventListener('click', () => {
        editBarangayDropdown.childNodes[0].textContent = currentMidwifeData.barangay_name;
        validateForm();
    });
    resetItem.appendChild(resetButton);
    barangayMenu.appendChild(resetItem);

    // Add the rest of the barangays
    barangays.forEach(barangay => {
        const listItem = document.createElement('li');
        const button = document.createElement('button');
        button.type = 'button';
        button.textContent = barangay.name;
        button.className = 'w-full text-left px-4 py-2 hover:bg-gray-100';

        button.addEventListener('click', () => {
            editBarangayDropdown.childNodes[0].textContent = barangay.name;
            validateForm();
        });

        listItem.appendChild(button);
        barangayMenu.appendChild(listItem);
    });
}


populateBarangayDropdown(barangayData);

/**
 * Populates the form fields with the midwife's current data.
 */
function populateEditMidwifeForm(data) {
    if (!data) {
        console.error("Midwife data is missing!");
        return;
    }
    editMidwifeFirstName.value = data.firstName || '';
    editMidwifeLastName.value = data.lastName || '';
    editMidwifeMiddleName.value = data.middleName || '';
    editContactNo.value = data.contact_no || '';
    editMidwifeEmail.value = data.email || '';
    editMidwifeBdate.value = data.birthdate || '';
    editMidwifeAge.value = data.age || '';
    editPrefixDropdown.childNodes[0].textContent = data.suffix || 'Select Prefix';
    editBarangayDropdown.childNodes[0].textContent = data.barangay_name || 'Select Barangay';
    editSexDropdown.childNodes[0].textContent = data.sex || 'Select Sex';
    editCivilStatusDropdown.childNodes[0].textContent = data.civil_status || 'Select';
    editReligionDropdown.childNodes[0].textContent = data.religion || 'Select';
}

/**
 * Validates the form to enable/disable the update button.
 */
function validateForm() {
    const originalData = currentMidwifeData;

    // Get current values from the form
    const currentFormValues = {
        firstName: editMidwifeFirstName.value.trim(),
        lastName: editMidwifeLastName.value.trim(),
        middleName: editMidwifeMiddleName.value.trim(),
        contact_no: editContactNo.value.trim(),
        email: editMidwifeEmail.value.trim(),
        birthdate: editMidwifeBdate.value.trim(),
        age: editMidwifeAge.value.trim(),
        suffix: editPrefixDropdown.childNodes[0].textContent.trim(),
        barangay_name: editBarangayDropdown.childNodes[0].textContent.trim(),
        sex: editSexDropdown.childNodes[0].textContent.trim(),
        civil_status: editCivilStatusDropdown.childNodes[0].textContent.trim(),
        religion: editReligionDropdown.childNodes[0].textContent.trim(),
    };

    // --- Condition 1: Check if all forms are filled ---
    let isFormComplete = true;
    for (const key in currentFormValues) {
        if (key === 'suffix') continue;
        const value = currentFormValues[key];
        if (!value || value.startsWith('Select')) {
            isFormComplete = false;
            break;
        }
    }

    // --- Condition 2: Check if there's at least one change ---
    let hasChanges = false;
    if (currentFormValues.firstName !== (originalData.firstName || '') ||
        currentFormValues.lastName !== (originalData.lastName || '') ||
        currentFormValues.middleName !== (originalData.middleName || '') ||
        currentFormValues.contact_no !== (originalData.contact_no || '') ||
        currentFormValues.email !== (originalData.email || '') ||
        currentFormValues.birthdate !== (originalData.birthdate || '') ||
        currentFormValues.age !== String(originalData.age || '') ||
        currentFormValues.suffix !== (originalData.suffix || 'Select Prefix') ||
        currentFormValues.barangay_name !== (originalData.barangay_name || 'Select Barangay') ||
        currentFormValues.sex !== (originalData.sex || 'Select Sex') ||
        currentFormValues.civil_status !== (originalData.civil_status || 'Select') ||
        currentFormValues.religion !== (originalData.religion || 'Select')) {
        hasChanges = true;
    }
    
    // --- Determine if the form is valid and enable/disable the button ---
    const isFormValid = isFormComplete && hasChanges;
    updateMidwifeSubmitBtn.disabled = !isFormValid;

    if(currentFormValues.suffix == 'Select Prefix'){
        currentFormValues.suffix = '';
    }
    // --- NEW: Update the global payload only if the form is valid ---
    if (isFormValid) {
        // Assign the clean form data to the global variable
        editMidwifePayload = currentFormValues;
        console.log("Payload updated:", editMidwifePayload); // You can see it in the console
    } else {
        // If the form becomes invalid, clear the payload
        editMidwifePayload= null;
    }
}

// --- ATTACH EVENT LISTENERS ---
// All text/date inputs
const allInputs = [
    editMidwifeFirstName, editMidwifeLastName, editMidwifeMiddleName,
    editContactNo, editMidwifeEmail, editMidwifeBdate, editMidwifeAge
];

// Trigger validateForm on input changes
allInputs.forEach(input => input.addEventListener('input', validateForm));

// Helper function to attach validation to custom dropdowns
function setupDropdownValidation(dropdown, menuSelector) {
    const menuButtons = document.querySelectorAll(menuSelector + ' button');

    menuButtons.forEach(item => {
        item.addEventListener('click', () => {
            // Update the visible dropdown text
            dropdown.childNodes[0].textContent = item.textContent;
            // Trigger validation after a small delay
            setTimeout(validateForm, 50);
        });
    });
}

// Setup dropdowns
setupDropdownValidation(editPrefixDropdown, '#editPrefixDropdownMenu');
setupDropdownValidation(editSexDropdown, '#editSexDropdownMenu');
setupDropdownValidation(editCivilStatusDropdown, '#editCivilStatusMenu');
setupDropdownValidation(editReligionDropdown, '#editReligionMenu');
setupDropdownValidation(editBarangayDropdown, '#editBarangayDropdownMenu');


// --- MODAL EVENT LISTENERS ---
// --- 1. INITIALIZE MODALS AND OPTIONS ONCE ---

// Keep track of the element that opened the last modal
let activeTriggerElement = null;

// Define options for all modals to manage focus correctly (fixes aria-hidden warning)
const modalOptions = {
    onHide: () => {
        if (activeTriggerElement) {
            activeTriggerElement.focus();
        }
    }
};

// Create the modal objects one time, using the options
const editMidwifeModal = new Modal(editMidwifeModalEl, modalOptions);
const confirmEditMidwifeModal = new Modal(confirmEditMidwifeModalEl, modalOptions);
// --- 2. REFACTORED EVENT LISTENERS ---

// When the main "Edit Midwife" button is clicked
editMidwifeBtn.addEventListener('click', function() {
    // Keep track of this button to return focus to it later
    activeTriggerElement = this;

    populateEditMidwifeForm(currentMidwifeData);
    validateForm();
    editMidwifeModal.show();
});

// When the "Close" button inside the edit form is clicked
cancelEditMidwifeBtn.addEventListener('click', function() {
    editMidwifeModal.hide();
});

// When the "Save Changes" button is clicked
updateMidwifeSubmitBtn.addEventListener('click', function() {
    if (editMidwifePayload) {
        // Prepare the confirmation modal
        midwifeNameToEditConfirm.textContent = editMidwifePayload.firstName + ' ' +editMidwifePayload.lastName;
        confirmEditMidwifeCheckbox.checked = false;
        confirmEditMidwifeBtn.disabled = true;

        // Keep track of this button as the trigger
        activeTriggerElement = this;
        
        // Swap the modals
        editMidwifeModal.hide();
        confirmEditMidwifeModal.show();
    }
});

// When the "Cancel" button inside the confirmation modal is clicked
closeConfirmEditMidwifeBtn.addEventListener('click', function() {
    // Set the trigger back to the "Save Changes" button for when this modal re-opens
    activeTriggerElement = updateMidwifeSubmitBtn;

    // Swap back to the previous modal
    confirmEditMidwifeModal.hide();
    editMidwifeModal.show();
});

// Add a 'change' event listener to the checkbox
confirmEditMidwifeCheckbox.addEventListener('change', function() {
    // Enable the button if the checkbox is checked, disable it if not.
    confirmEditMidwifeBtn.disabled = !this.checked;
});

function formatBirthdate(dateStr) {
    const date = new Date(dateStr);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function getBrgyId(brgyName) {
    const brgy = barangayData.find(b => b.name === brgyName);
    return brgy ? brgy.id : currentMidwifeData.barangay_id;
}

confirmEditMidwifeBtn.addEventListener('click', async function () {
    editMidwifePayload.user_id = currentMidwifeData.user_id;
    editMidwifePayload.midwife_id = currentMidwifeData.midwife_id;
    editMidwifePayload.birthdate = formatBirthdate(editMidwifePayload.birthdate);

    editMidwifePayload.brgy_id = getBrgyId(editMidwifePayload.barangay_name);
    try {
        const userId = editMidwifePayload.user_id; // make sure this exists
        const response = await fetch(`/mho/midwife/${userId}/update`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(editMidwifePayload)
        });

        const result = await response.json();
        
        // Optional: reload or close modal on success
        if (result.status === 'success') {
            const successModal = new Modal(successModalEl, options);
            const confirmEditMidwifeModal = new Modal(confirmEditMidwifeModalEl);

            if(successModal && editMidwifeModal){
                successMesageHeader.textContent = 'Midwife Updated';
                successMessage.textContent = 'Midwife details has been updated';
                confirmEditMidwifeModal.hide();
                successModal.show();
            }
        }

    } catch (err) {
        console.error('Error sending payload:', err);
    }
});

closeSuccessModalButton.addEventListener('click', function(){
     window.location.reload();
});
