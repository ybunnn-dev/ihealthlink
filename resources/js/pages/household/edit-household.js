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

const editHouseholdModalEl = document.getElementById('edit-household-modal');

// The hidden input to store the ID
const editHouseholdId = document.getElementById('editHouseholdId');
const editWaterSourceSelect = document.getElementById('editWaterSourceSelect');
const editWasteDisposalSelect = document.getElementById('editWasteDisposalSelect');
const editSanitarySelect = document.getElementById('editSanitarySelect');

// The modal's buttons
const cancelEditHouseholdBtn = document.getElementById('cancel-edit-household');
const proceedEditHouseholdBtn = document.getElementById('proceed-edit-household');

// The modal element itself
const confirmEditHouseholdModalEl = document.getElementById('confirm-edit-household-modal');

// The confirmation checkbox
const confirmEditHouseholdCheckbox = document.getElementById('confirm-edit-household-checkbox');

// The modal's buttons
const confirmEditHouseholdCancelBtn = document.getElementById('confirm-edit-household-cancel');
const confirmEditHouseholdSubmitBtn = document.getElementById('confirm-edit-household-submit');

const household = window.household;

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');


const editHouseholdModal = new Modal(editHouseholdModalEl, createModalOptions(editHouseholdModalEl));
const confirmEditHouseholdModal = new Modal(confirmEditHouseholdModalEl, createModalOptions(confirmEditHouseholdModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

const editHouseholdTrigger = document.getElementById('edit-household-btn');

// Store original values
let originalValues = {};

// Function to populate form with household data
function populateHouseholdForm() {
    editHouseholdId.value = household.id;
    editWaterSourceSelect.value = household.water_source || '';
    editWasteDisposalSelect.value = household.waste_disposal || '';
    editSanitarySelect.value = household.sanitary_toilet || '';
    
    // Store original values for comparison
    originalValues = {
        water_source: household.water_source || '',
        waste_disposal: household.waste_disposal || '',
        sanitary_toilet: household.sanitary_toilet || ''
    };
    
    // Initial button state check
    validateForm();
}

// Function to check if form has changes and is valid
function validateForm() {
    const currentValues = {
        water_source: editWaterSourceSelect.value,
        waste_disposal: editWasteDisposalSelect.value,
        sanitary_toilet: editSanitarySelect.value
    };
    
    // Check if any field is empty
    const hasEmptyFields = Object.values(currentValues).some(value => value === '');
    
    // Check if any value has changed
    const hasChanges = Object.keys(currentValues).some(
        key => currentValues[key] !== originalValues[key]
    );
    
    // Disable button if there are empty fields OR no changes
    proceedEditHouseholdBtn.disabled = hasEmptyFields || !hasChanges;
}

// Add event listeners to all select fields
[editWaterSourceSelect, editWasteDisposalSelect, editSanitarySelect].forEach(select => {
    select.addEventListener('change', validateForm);
});

editHouseholdTrigger.addEventListener('click', function() {
    console.log(household);
    populateHouseholdForm();
    editHouseholdModal.show();
});

cancelEditHouseholdBtn.addEventListener('click', function() {
    editHouseholdModal.hide();
});

confirmEditHouseholdCheckbox.addEventListener('change', function() {
    console.log('Checkbox changed:', this.checked);
    confirmEditHouseholdSubmitBtn.disabled = !this.checked;
});

// Proceed button click handler - moves from edit modal to confirmation modal
proceedEditHouseholdBtn.addEventListener('click', function() {
    if (!proceedEditHouseholdBtn.disabled) {
        editHouseholdModal.hide();
        
        // Reset checkbox and disable submit button when opening confirmation modal
        confirmEditHouseholdCheckbox.checked = false;
        confirmEditHouseholdSubmitBtn.disabled = true;
        
        confirmEditHouseholdModal.show();
    }
});

// Cancel button in confirmation modal
confirmEditHouseholdCancelBtn.addEventListener('click', function() {
    confirmEditHouseholdModal.hide();
    editHouseholdModal.show(); // Go back to edit modal
});

confirmEditHouseholdSubmitBtn.addEventListener('click', function() {
    if (!confirmEditHouseholdSubmitBtn.disabled) {
        // Disable both buttons and change submit button text
        confirmEditHouseholdCancelBtn.disabled = true;
        confirmEditHouseholdSubmitBtn.disabled = true;
        
        // Store original text and change to "Saving..."
        const originalButtonText = confirmEditHouseholdSubmitBtn.textContent;
        confirmEditHouseholdSubmitBtn.textContent = 'Saving...';

        // Prepare form data
        const formData = {
            household_id: household.id,
            purok_id: household.purok_id,
            water_source: editWaterSourceSelect.value,
            sanitary: editSanitarySelect.value,
            waste_disposal: editWasteDisposalSelect.value
        };
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Send AJAX request
        fetch('/barangay/household/update', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                // Success - close confirmation modal
                confirmEditHouseholdModal.hide();
                
                // Update the household object in window
                window.household = data.household;
                
                // Update success modal content
                successMesageHeader.textContent = 'Success!';
                successMessage.textContent = data.message;
                
                // Show success modal
                successModal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the household.');
            
            // Re-enable buttons and restore original text on error
            confirmEditHouseholdCancelBtn.disabled = false;
            confirmEditHouseholdSubmitBtn.disabled = false;
            confirmEditHouseholdSubmitBtn.textContent = originalButtonText;
        });
    }
});

// Add event listener for success modal close button
closeSuccessModalButton.addEventListener('click', function() {
    successModal.hide();
    
    // Reload the page to show updated data
    location.reload();
});
