/* eslint-disable no-undef, no-unused-vars */

// --- Initial Data ---
const family = window.family;
console.log('Original Family Data:', family);

// --- Modal Options ---
const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

// --- Element Variables (Modal 1: Edit) ---
const editFamilyModalEl = document.getElementById('edit-family-modal');
const is4psButtonEdit = document.getElementById('is4psButtonEdit');
const is4psButtonTextEdit = document.getElementById('is4psButtonTextEdit');
const psDropdownMenuEdit = document.getElementById('4psDropdownMenuEdit');
const isIndigentButtonEdit = document.getElementById('isIndigentButtonEdit');
const isIndigentButtonTextEdit = document.getElementById('isIndigentButtonTextEdit');
const indigentDropdownMenuEdit = document.getElementById('indigentDropdownMenuEdit');
const isIwasGutomEdit = document.getElementById('isIwasGutomEdit');
const isIwasGutomButtonTextEdit = document.getElementById('isIwasGutomButtonTextEdit');
const isIwasGutomMenuEdit = document.getElementById('isIwasGutomMenuEdit');
const cancelEditFamilyButton = document.getElementById('cancelEditFamilyButton');
const submitEditFamilyButton = document.getElementById('submitEditFamilyButton');
const editFamTrigger = document.getElementById('edit-fam-btn');

// --- Element Variables (Modal 2: Confirm) ---
const confirmEditFamilyModalEl = document.getElementById('confirm-edit-family-modal');
const confirmEditFamilyCheckbox = document.getElementById('confirm-edit-family-checkbox');
const confirmEditFamilyCancelBtn = document.getElementById('confirm-edit-family-cancel');
const confirmEditFamilySubmitBtn = document.getElementById('confirm-edit-family-submit');

// --- Modal Initialization ---
const editFamilyModal = new Modal(editFamilyModalEl, modalOptions);
const confirmEditFamilyModal = new Modal(confirmEditFamilyModalEl, modalOptions);

// --- State Variables ---
let originalFamilyState = {};
let currentFamilyState = {};

// --- Helper Functions ---
const boolToYesNo = (val) => val ? 'Yes' : 'No';
const yesNoToBool = (val) => val === 'Yes' ? 1 : 0;
const boolToEnrolled = (val) => val ? 'Enrolled' : 'No';
const enrolledToBool = (val) => val === 'Enrolled' ? 1 : 0;

/**
 * Checks for changes and enables/disables the submit button.
 */
function checkFormChanges() {
    const hasChanged = 
        originalFamilyState.is_4ps !== currentFamilyState.is_4ps ||
        originalFamilyState.is_indigent !== currentFamilyState.is_indigent ||
        originalFamilyState.is_iwas_gutom !== currentFamilyState.is_iwas_gutom;
    
    // Enable button only if changes have been made
    submitEditFamilyButton.disabled = !hasChanged;
}

/**
 * Resets the confirmation modal to its default state.
 */
function resetConfirmModal() {
    confirmEditFamilyCheckbox.checked = false;
    confirmEditFamilySubmitBtn.disabled = true;
}

/**
 * Resets the edit modal and all state variables.
 */
function resetEditModal() {
    originalFamilyState = {};
    currentFamilyState = {};
    submitEditFamilyButton.disabled = true;
    
    // Reset button text to placeholders
    is4psButtonTextEdit.textContent = 'Select';
    isIndigentButtonTextEdit.textContent = 'Select';
    isIwasGutomButtonTextEdit.textContent = 'Select';
    
    // Reset text color to gray
    [is4psButtonTextEdit, isIndigentButtonTextEdit, isIwasGutomButtonTextEdit].forEach(el => {
        el.parentElement.classList.add('text-gray-400');
        el.parentElement.classList.remove('text-main_font');
    });
}

/**
 * Loads the current family data into the form and state variables.
 */
function loadFamilyData() {
    // 1. Store original state
    originalFamilyState = {
        is_4ps: family.is_4ps,
        is_indigent: family.is_indigent,
        is_iwas_gutom: family.is_iwas_gutom,
    };
    
    // 2. Set current state to match
    currentFamilyState = { ...originalFamilyState };
    
    // 3. Update button text to reflect current data
    is4psButtonTextEdit.textContent = boolToYesNo(family.is_4ps);
    isIndigentButtonTextEdit.textContent = boolToYesNo(family.is_indigent);
    isIwasGutomButtonTextEdit.textContent = boolToEnrolled(family.is_iwas_gutom);
    
    // 4. Update text color to show a value is set
    [is4psButtonTextEdit, isIndigentButtonTextEdit, isIwasGutomButtonTextEdit].forEach(el => {
        el.parentElement.classList.remove('text-gray-400');
        el.parentElement.classList.add('text-main_font');
    });

    // 5. Ensure submit button is disabled initially
    submitEditFamilyButton.disabled = true;
}

function handleDropdownClick(textEl, stateKey, value, converter) {
    // Update button text
    textEl.textContent = value;
    textEl.parentElement.classList.remove('text-gray-400');
    textEl.parentElement.classList.add('text-main_font');

    // Update current state
    currentFamilyState[stateKey] = converter(value);
    
    // Check if form has changed
    checkFormChanges();
}

// --- Event Listeners Setup ---

// [Trigger] Open the Edit modal
editFamTrigger.addEventListener('click', function() {
    loadFamilyData(); // Load data from window.family
    editFamilyModal.show();
});

// [Modal 1] Cancel button
cancelEditFamilyButton.addEventListener('click', function() {
    editFamilyModal.hide();
    resetEditModal();
});

// [Modal 1] Dropdown listeners using event delegation
psDropdownMenuEdit.addEventListener('click', function(e) {
    const target = e.target.closest('button[data-value]');
    if (!target) return;
    handleDropdownClick(is4psButtonTextEdit, 'is_4ps', target.dataset.value, yesNoToBool);
});

indigentDropdownMenuEdit.addEventListener('click', function(e) {
    const target = e.target.closest('button[data-value]');
    if (!target) return;
    handleDropdownClick(isIndigentButtonTextEdit, 'is_indigent', target.dataset.value, yesNoToBool);
});

isIwasGutomMenuEdit.addEventListener('click', function(e) {
    const target = e.target.closest('button[data-value]');
    if (!target) return;
    handleDropdownClick(isIwasGutomButtonTextEdit, 'is_iwas_gutom', target.dataset.value, enrolledToBool);
});

// [Modal 1] "Update Family" button (opens confirmation modal)
submitEditFamilyButton.addEventListener('click', function() {
    editFamilyModal.hide();
    confirmEditFamilyModal.show();
});

// [Modal 2] Cancel button (goes back to edit modal)
confirmEditFamilyCancelBtn.addEventListener('click', function() {
    confirmEditFamilyModal.hide();
    resetConfirmModal();
    editFamilyModal.show(); // Re-open the edit modal
});

// [Modal 2] Checkbox logic
confirmEditFamilyCheckbox.addEventListener('change', function() {
    confirmEditFamilySubmitBtn.disabled = !this.checked;
});

/* eslint-disable no-undef, no-unused-vars */

// [Modal 2] "Confirm & Save" button (FINAL SUBMIT)
confirmEditFamilySubmitBtn.addEventListener('click', async function() {
    // 'this' refers to the button
    this.disabled = true;
    this.innerHTML = `
        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0492C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
        </svg>
        Updating...
    `;

    // The payload only needs the fields that are being updated.
    const payload = { ...currentFamilyState };
    
    console.log('Final Payload to be sent:', payload);

    try {
        const response = await fetch(`/barangay/family/update/${family.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // Get the token directly from the meta tag
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (!response.ok) {
            // Handle server-side errors
            throw new Error(data.message || 'An unknown server error occurred.');
        }

        // --- Success ---
        console.log('Success:', data);
        alert(data.message || 'Family details updated successfully!');
        
        // Hide modals and reload the page to see the change
        confirmEditFamilyModal.hide();
        resetConfirmModal(); // Assumes this function exists
        resetEditModal(); // Assumes this function exists
        window.location.reload(); // Reload to show the new data

    } catch (error) {
        // --- Error ---
        console.error('Error updating family:', error);
        alert('Error: ' + error.message);

        // Reset the button so the user can try again
        this.disabled = false;
        this.innerHTML = 'Confirm & Save';
    }
});