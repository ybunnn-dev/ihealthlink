// The main "edit bhw" modal container
const bhwData = window.bhwData;

const editBhwModalEl = document.getElementById('edit-bhw-modal');

// The form element
const editBhwForm = document.getElementById('editBhwForm');

// The hidden input holding the BHW's unique ID
const editBhwIdInput = document.getElementById('editBhwId');

// Text inputs for the BHW's name
const editBhwFirstNameInput = document.getElementById('editBhwFirstName');
const editBhwLastNameInput = document.getElementById('editBhwLastName');
const editBhwMiddleNameInput = document.getElementById('editBhwMiddleName');

// Date and age inputs
const editBhwBirthdateInput = document.getElementById('editBhwBirthdate');
const editBhwAgeInput = document.getElementById('editBhwAge');

// Contact information inputs
const editBhwEmailInput = document.getElementById('editBhwEmail');
const editBhwContactNoInput = document.getElementById('editBhwContactNo');

const editSuffixDropdownButton = document.getElementById('editSuffixDropdownButton');
const editSexDropdownButton = document.getElementById('editSexDropdownButton');
const editPrivilegeDropdownButton = document.getElementById('editPrivilegeDropdownButton');
const editCivilStatusDropdownButton = document.getElementById('editCivilStatusDropdownButton');
const editReligionDropdownButton = document.getElementById('editReligionDropdownButton');

console.log(bhwData);
// The "Cancel" or "Close" button
const editBhwCloseButton = document.getElementById('editBhwCloseButton');
const editBhwTrigger = document.getElementById('open-edit-bhw');
// The "Save Changes" submit button

const editBhwSubmitButton = document.getElementById('editBhwSubmitButton');

// The main "confirm edit" modal element
const confirmEditBhwModalEl = document.getElementById('confirm-edit-bhw-modal');

// The <strong> element where the BHW's name will be shown for confirmation
const editBhwNameToConfirm = document.getElementById('edit-bhw-name-to-confirm');

// The checkbox the user must tick to confirm the changes
const confirmEditBhwCheckbox = document.getElementById('confirm-edit-bhw-checkbox');

// The "Cancel" button in the confirmation modal
const confirmEditBhwCancelButton = document.getElementById('confirm-edit-bhw-cancel');

// The final "Confirm & Save" button
const confirmEditProceedButton = document.getElementById('confirm-edit-proceed-button');

const editBhwModal = new Modal(editBhwModalEl);
const confirmEditBhw = new Modal(confirmEditBhwModalEl);


/**
 * Calculates age based on a birthdate string (YYYY-MM-DD).
 * @param {string} birthdateString - The birthdate in "YYYY-MM-DD" format.
 * @returns {number} The calculated age.
 */
function calculateAge(birthdateString) {
    if (!birthdateString) return '';
    const birthDate = new Date(birthdateString);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDifference = today.getMonth() - birthDate.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

/**
 * Updates a custom dropdown's text and stored data value.
 * @param {HTMLElement} buttonElement - The dropdown button element.
 * @param {string} value - The value to set.
 * @param {string} [displayText] - Optional text to display on the button. If not provided, value is used.
 */
function updateDropdown(buttonElement, value, displayText = null) {
    const textToShow = displayText || value;
    const displayElement = buttonElement.querySelector('span');
    
    if (textToShow) {
        displayElement.textContent = textToShow;
        buttonElement.dataset.selectedValue = value;
    } else {
        // Reset to default if value is empty/null
        displayElement.textContent = `Select ${buttonElement.id.replace('DropdownButton', '').replace('edit', '')}`;
        buttonElement.dataset.selectedValue = '';
    }
}


// --- Main Autofill Function ---

/**
 * Populates the edit form with data from a BHW object.
 * @param {object} bhwData - The BHW data object from your server.
 */
function populateEditForm(bhwData) {
    const userData = bhwData.users;

    // 1. Populate standard text and hidden inputs
    editBhwIdInput.value = bhwData.id;
    editBhwFirstNameInput.value = userData.firstName || '';
    editBhwLastNameInput.value = userData.lastName || '';
    editBhwMiddleNameInput.value = userData.middleName || '';
    editBhwBirthdateInput.value = userData.birthdate || '';
    editBhwEmailInput.value = userData.email || '';
    editBhwContactNoInput.value = userData.contact_no || '';

    // 2. Calculate and populate the age field
    editBhwAgeInput.value = calculateAge(userData.birthdate);

    // 3. Populate custom dropdowns
    updateDropdown(editSuffixDropdownButton, userData.suffix);
    updateDropdown(editSexDropdownButton, userData.sex);
    updateDropdown(editCivilStatusDropdownButton, userData.civil_status);
    updateDropdown(editReligionDropdownButton, userData.religion);

    // 4. Handle special case for Privilege/Role dropdown
    let privilegeText = 'Select Privilege';
    if (bhwData.role_id === 3) {
        privilegeText = 'Regular Access';
    } else if (bhwData.role_id === 4) {
        privilegeText = 'Web Access';
    }
    updateDropdown(editPrivilegeDropdownButton, bhwData.role_id, privilegeText);
}

// Corrected event listener using your declared variable
editBhwTrigger.addEventListener('click', function() {
    // Check if bhwData exists and is not empty before proceeding
    if (bhwData) {
        populateEditForm(bhwData); 
        editBhwModal.show();
    } else {
        console.error('BHW data is not available.');
        // Optionally, show an error message to the user
    }
});

editBhwCloseButton.addEventListener('click', function() {
    editBhwModal.hide();
});