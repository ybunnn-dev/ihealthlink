const addPurokModalEl = document.getElementById('add-purok-modal');
const confirmPurokModalEl = document.getElementById('confirm-add-purok-modal');
const mainTriggerBtn = document.getElementById('page-add-purok-button');

const addPurokModal = new Modal(addPurokModalEl);
const confirmPurokModal = new Modal(confirmPurokModalEl);

const purokNameInput = document.getElementById('purok-name-input');
const openPurokConfirmBtn = document.getElementById('open-purok-confirmation-modal-button');
const confirmPurokCheckbox = document.getElementById('confirm-purok-checkbox');
const confirmProceedPurokBtn = document.getElementById('confirm-proceed-purok-button');
const cancelConfirmBtn = confirmPurokModalEl.querySelector('[data-modal-hide="confirm-add-purok-modal"]');
const purokPageContainer = document.getElementById('purok-page-container');
const currentBarangayId = purokPageContainer.dataset.barangayId;

mainTriggerBtn.addEventListener('click', function() {
    addPurokModal.show();
});



openPurokConfirmBtn.addEventListener('click', function () {
    const purokName = purokNameInput.value.trim();
    if (purokName === '') {
        alert('Please enter a purok name.');
        return;
    }
    const purokNamePlaceholder = document.getElementById('purok-name-to-confirm');
    purokNamePlaceholder.textContent = purokName;

    addPurokModal.hide();
    confirmPurokModal.show();    
});


confirmPurokCheckbox.addEventListener('change', function () {
    confirmProceedPurokBtn.disabled = !this.checked;
});


confirmProceedPurokBtn.addEventListener('click', async function () {
    // Correctly get the purok name from the purok input
    const purokNameToInsert = purokNameInput.value.trim();
    this.disabled = true;
    this.textContent = 'Saving...';

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch('/add-purok', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                // Send the purok name
                name: purokNameToInsert,
                barangay_id: currentBarangayId 
            })
        });

        const result = await response.json();

        if (!response.ok) {
            if (response.status === 422) {
                const errors = Object.values(result.errors).map(e => e.join('\n')).join('\n');
                alert('Validation Error:\n' + errors);
            } else {
                throw new Error(result.message || 'An unknown error occurred.');
            }
        } else {
            // --- ON SUCCESS ---
            alert(result.message);

            // Redirect to the new URL
            window.location.reload();
        }

    } catch (error) {
        console.error('Submission Error:', error);
        alert('An error occurred while saving the purok. Please check the console.');
    } finally {
        // Re-enable the button in case of a validation error or other non-redirecting issue
        this.disabled = false;
        this.textContent = 'Confirm & Proceed';
    }
});

if (cancelConfirmBtn) {
    cancelConfirmBtn.addEventListener('click', function() {
        confirmPurokModal.hide();
        addPurokModal.show();
    });
}
