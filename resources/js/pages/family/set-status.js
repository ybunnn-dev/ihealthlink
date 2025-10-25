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

// --- Element Variables (Modal 1: Set Status) ---
const setStatTrigger = document.getElementById('set-stat-btn');
const setStatusModalEl = document.getElementById('set-status-modal');
const statusButton = document.getElementById('statusButton');
const statusButtonText = document.getElementById('statusButtonText');
const statusDropdownMenu = document.getElementById('statusDropdownMenu');
const cancelSetStatusButton = document.getElementById('cancelSetStatusButton');
const submitSetStatusButton = document.getElementById('submitSetStatusButton');

// --- Element Variables (Modal 2: Confirm) ---
const confirmSetStatusModalEl = document.getElementById('confirm-set-status-modal');
const newStatusNameConfirmEl = document.getElementById('new-status-name-confirm');
const confirmSetStatusCheckbox = document.getElementById('confirm-set-status-checkbox');
const confirmSetStatusCancelBtn = document.getElementById('confirm-set-status-cancel');
const confirmSetStatusSubmitBtn = document.getElementById('confirm-set-status-submit');

// --- Modal Initialization ---
const setStatusModal = new Modal(setStatusModalEl, modalOptions);
const confirmSetStatusModal = new Modal(confirmSetStatusModalEl, modalOptions);

// --- State Variables ---
let originalStatus = null;
let newStatus = null;

// --- Helper Functions ---

/**
 * Capitalizes the first letter of a string.
 * @param {string} s - The input string.
 * @returns {string} - The capitalized string.
 */
const capitalize = (s) => s.charAt(0).toUpperCase() + s.slice(1);

/**
 * Resets the confirmation modal.
 */
function resetConfirmModal() {
    confirmSetStatusCheckbox.checked = false;
    confirmSetStatusSubmitBtn.disabled = true;
    newStatusNameConfirmEl.textContent = '[Status]';
}

/**
 * Resets the status modal and state.
 */
function resetStatusModal() {
    originalStatus = null;
    newStatus = null;
    submitSetStatusButton.disabled = true;
    
    statusButtonText.textContent = 'Select';
    statusButton.classList.add('text-gray-400');
    statusButton.classList.remove('text-main_font');
}

/**
 * Loads the family's current status into the modal.
 */
function loadStatusData() {
    originalStatus = family.status;
    newStatus = family.status;
    
    // Set button text and color
    statusButtonText.textContent = capitalize(family.status);
    statusButton.classList.remove('text-gray-400');
    statusButton.classList.add('text-main_font');
    
    // Disable submit button initially
    submitSetStatusButton.disabled = true;
}

// --- Event Listeners ---

// [Trigger] Open the Set Status modal
setStatTrigger.addEventListener('click', function() {
    loadStatusData();
    setStatusModal.show();
});

// [Modal 1] Cancel button
cancelSetStatusButton.addEventListener('click', function() {
    setStatusModal.hide();
    resetStatusModal();
});

// [Modal 1] Dropdown listener
statusDropdownMenu.addEventListener('click', function(e) {
    const target = e.target.closest('button[data-value]');
    if (!target) return;

    const selectedValue = target.dataset.value;
    
    // Update text and color
    statusButtonText.textContent = capitalize(selectedValue);
    statusButton.classList.remove('text-gray-400');
    statusButton.classList.add('text-main_font');
    
    // Update new state
    newStatus = selectedValue;
    
    // Enable button only if the status has changed
    submitSetStatusButton.disabled = (newStatus === originalStatus);
});

// [Modal 1] "Update Status" button (opens confirmation)
submitSetStatusButton.addEventListener('click', function() {
    // Populate confirmation modal
    newStatusNameConfirmEl.textContent = capitalize(newStatus);
    
    setStatusModal.hide();
    confirmSetStatusModal.show();
});

// [Modal 2] Cancel button (goes back)
confirmSetStatusCancelBtn.addEventListener('click', function() {
    confirmSetStatusModal.hide();
    resetConfirmModal();
    setStatusModal.show(); // Re-open the first modal
});

// [Modal 2] Checkbox logic
confirmSetStatusCheckbox.addEventListener('change', function() {
    confirmSetStatusSubmitBtn.disabled = !this.checked;
});

confirmSetStatusSubmitBtn.addEventListener('click', function() {
    // Create the final payload
    const payload = {
        family_id: family.id,
        status: newStatus
    };
    
    console.log('Final Payload to be sent:', payload);
    
    // Send the AJAX request
    fetch('/barangay/families/set-status', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            alert(`Family status updated successfully. ${data.data.affected_residents} resident(s) affected.`);
            
            // Hide and reset both modals
            confirmSetStatusModal.hide();
            resetConfirmModal();
            resetStatusModal();
            
            // Reload the page to reflect changes
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating the family status.');
    });
});