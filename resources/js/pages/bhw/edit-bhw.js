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

let defBhwData = null;


const editBhwCloseButton = document.getElementById('editBhwCloseButton');
const editBhwTrigger = document.getElementById('open-edit-bhw');
const editBhwSubmitButton = document.getElementById('editBhwSubmitButton'); //this is currently disabled


const confirmEditBhwModalEl = document.getElementById('confirm-edit-bhw-modal');
const editBhwNameToConfirm = document.getElementById('edit-bhw-name-to-confirm');
const confirmEditBhwCheckbox = document.getElementById('confirm-edit-bhw-checkbox');
const confirmEditBhwCancelButton = document.getElementById('confirm-edit-bhw-cancel');
const confirmEditProceedButton = document.getElementById('confirm-edit-proceed-button');

const editBhwModal = new Modal(editBhwModalEl);
const confirmEditBhw = new Modal(confirmEditBhwModalEl);


function validateEditForm() {
    // Exit if the initial data isn't loaded yet
    if (!defBhwData || !bhwData) {
        editBhwSubmitButton.disabled = true;
        return;
    }

    // --- Condition 1: Check if all required fields are filled (excluding suffix) ---
    const requiredInputs = [
        editBhwFirstNameInput,
        editBhwLastNameInput,
        editBhwMiddleNameInput,
        editBhwBirthdateInput,
        editBhwEmailInput,
        editBhwContactNoInput
    ];

    const requiredDropdowns = [
        editSexDropdownButton,
        editPrivilegeDropdownButton,
        editCivilStatusDropdownButton,
        editReligionDropdownButton
    ];

    // Check if any required text input or dropdown is empty
    const allFieldsFilled = 
        requiredInputs.every(input => input.value.trim() !== '') &&
        requiredDropdowns.every(dropdown => dropdown.dataset.selectedValue);

    // --- Condition 2: Check if at least one change was made ---
    let isChanged = false;

    const currentData = {
        firstName: editBhwFirstNameInput.value,
        lastName: editBhwLastNameInput.value,
        middleName: editBhwMiddleNameInput.value,
        suffix: editSuffixDropdownButton.dataset.selectedValue || '',
        birthdate: editBhwBirthdateInput.value,
        sex: editSexDropdownButton.dataset.selectedValue,
        civil_status: editCivilStatusDropdownButton.dataset.selectedValue,
        religion: editReligionDropdownButton.dataset.selectedValue,
        email: editBhwEmailInput.value,
        contact_no: editBhwContactNoInput.value,
        role_id: parseInt(editPrivilegeDropdownButton.dataset.selectedValue, 10)
    };

    // Compare current form data with the initial data (defBhwData)
    if (
        currentData.firstName !== (defBhwData.firstName || '') ||
        currentData.lastName !== (defBhwData.lastName || '') ||
        currentData.middleName !== (defBhwData.middleName || '') ||
        currentData.suffix !== (defBhwData.suffix || '') ||
        currentData.birthdate !== (defBhwData.birthdate || '') ||
        currentData.sex !== (defBhwData.sex || '') ||
        currentData.civil_status !== (defBhwData.civil_status || '') ||
        currentData.religion !== (defBhwData.religion || '') ||
        currentData.email !== (defBhwData.email || '') ||
        currentData.contact_no !== (defBhwData.contact_no || '') ||
        currentData.role_id !== bhwData.role_id // role_id is on the parent bhwData object
    ) {
        isChanged = true;
    }

    // --- Final Step: Enable or disable the button ---
    // The button is enabled only if both conditions are true
    editBhwSubmitButton.disabled = !(allFieldsFilled && isChanged);
}


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

function populateEditForm(bhwData) {
    const userData = bhwData.users;
    defBhwData = bhwData.users;

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

// --- Attach Event Listeners to run validation on user input ---

// List of all standard input elements
const allTextInputs = [
    editBhwFirstNameInput,
    editBhwLastNameInput,
    editBhwMiddleNameInput,
    editBhwBirthdateInput,
    editBhwEmailInput,
    editBhwContactNoInput
];


// Add an 'input' listener to each text-based field
allTextInputs.forEach(input => {
    input.addEventListener('input', validateEditForm);
});

/**
 * Sets up a click event listener for a specific dropdown menu.
 * @param {string} menuId The ID of the dropdown menu element (the <div> with the <ul>).
 */
function setupDropdownHandler(menuId) {
    const menuElement = document.getElementById(menuId);

    // Make sure the dropdown menu element exists before proceeding
    if (!menuElement) {
        console.warn(`Dropdown menu with ID "${menuId}" was not found.`);
        return;
    }

    // Attach a click listener directly to this specific menu
    menuElement.addEventListener('click', function(event) {
        // Find the <a> tag that was actually clicked
        const targetLink = event.target.closest('a');
        
        // If the user clicked on padding or something other than a link, do nothing
        if (!targetLink) {
            return;
        }

        // Stop the link from trying to navigate
        event.preventDefault();

        // Find the parent <li> to get its 'data-value'
        const parentLi = targetLink.closest('li[data-value]');
        if (!parentLi) return;

        // Get the value and display text
        const selectedValue = parentLi.dataset.value;
        const selectedText = targetLink.textContent.trim();
        
        // Find the button associated with this menu using the 'aria-labelledby' attribute
        const buttonId = menuElement.querySelector('ul').getAttribute('aria-labelledby');
        const triggerButton = document.getElementById(buttonId);

        if (triggerButton) {
            // 1. Update the button's text and value
            updateDropdown(triggerButton, selectedValue, selectedText);
            
            // 2. Re-run the form validation
            validateEditForm();

            // 3. Flowbite should handle hiding the menu automatically.
        }
    });
}

// --- Initialize the handlers for ALL your dropdowns by ID ---

// An array containing the unique IDs of all your dropdown menus
const dropdownMenuIds = [
    'editSuffixDropdownMenu',
    'editSexDropdownMenu',
    'editPrivilegeDropdownMenu',
    'editCivilStatusMenu',
    'editReligionMenu'
];

// Loop through the array and set up the listener for each dropdown
dropdownMenuIds.forEach(id => setupDropdownHandler(id));


// Corrected event listener using your declared variable
editBhwTrigger.addEventListener('click', function() {
    // Check if bhwData exists and is not empty before proceeding
    if (bhwData) {
        populateEditForm(bhwData); 
        validateEditForm();
        editBhwModal.show();
        console.log(defBhwData);
    } else {
        console.error('BHW data is not available.');
        // Optionally, show an error message to the user
    }
});

editBhwCloseButton.addEventListener('click', function() {
    editBhwModal.hide();
});