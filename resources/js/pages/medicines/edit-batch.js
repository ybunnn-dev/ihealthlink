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

const editBatchModal = document.getElementById('edit-batch-modal');
const batches = window.batches;

console.log(batches);

// --- Form & Inputs ---
const editBatchForm = document.getElementById('edit-batch-form');
const editBatchIdInput = document.getElementById('edit_batch_id'); // Hidden input for ID
const editExpiryDateInput = document.getElementById('editExpiryDate'); // The date picker

// --- Buttons ---
const closeEditBatchBtn = document.getElementById('close-edit-batch'); // Cancel button
const updateBatchBtn = document.getElementById('update-batch-btn');   // Save Changes button


/* =========================================
   CONFIRM EDIT BATCH MODAL ELEMENTS
   ========================================= */
const confirmEditBatchModal = document.getElementById('confirm-edit-batch-modal');
// Dynamic Text Elements
const editBatchMedicineNameDisplay = document.getElementById('edit-batch-medicine-name-to-confirm');
const editBatchNewExpiryDisplay = document.getElementById('edit-batch-new-expiry-to-confirm');
// Interaction Elements
const confirmEditBatchCheckbox = document.getElementById('confirm-edit-batch-checkbox');
const cancelEditBatchBtn = document.getElementById('cancel-confirm-edit-batch');
const finalEditBatchBtn = document.getElementById('final-confirm-edit-batch-btn');


//success modal elements
const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');


/* =========================================
   EDIT BATCH FUNCTIONALITY
========================================= */

// Initialize modals
const editBatchModalInstance = new Modal(editBatchModal, createModalOptions(editBatchModal));
const confirmEditBatchModalInstance = new Modal(confirmEditBatchModal, createModalOptions(confirmEditBatchModal));
const successModalInstance = new Modal(successModalEl, createModalOptions(successModalEl));

// Store the medicine name globally for confirmation display
let currentMedicineName = '';

// 1. Open Edit Modal when Edit button clicked
document.addEventListener('click', function(e) {
    if (e.target.closest('.js-edit-inventory-expiry-btn')) {
        const btn = e.target.closest('.js-edit-inventory-expiry-btn');
        const inventoryId = btn.dataset.inventoryId;
        const currentExpiry = btn.dataset.currentExpiry;
        const medicineName = btn.dataset.medicineName || 'this medicine'; // Add this to your button
        
        // Populate form
        editBatchIdInput.value = inventoryId;
        editExpiryDateInput.value = currentExpiry;
        currentMedicineName = medicineName;
        
        // Open modal
        editBatchModalInstance.show();
    }
});

// 2. Close Edit Modal (Cancel button)
closeEditBatchBtn.addEventListener('click', () => {
    editBatchForm.reset();
    editBatchModalInstance.hide();
});

// 3. When "Save Changes" clicked, open confirmation modal
updateBatchBtn.addEventListener('click', (e) => {
    e.preventDefault();
    
    const newExpiryDate = editExpiryDateInput.value;
    
    if (!newExpiryDate) {
        alert('Please select an expiry date');
        return;
    }
    
    // Format date for display (e.g., "January 10, 2026")
    const formattedDate = new Date(newExpiryDate).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    editBatchNewExpiryDisplay.textContent = formattedDate;
    
    // Reset checkbox
    confirmEditBatchCheckbox.checked = false;
    finalEditBatchBtn.disabled = true;
    
    // Hide edit modal, show confirmation
    editBatchModalInstance.hide();
    setTimeout(() => {
        confirmEditBatchModalInstance.show();
    }, 300);
});

// 4. Enable/disable confirm button based on checkbox
confirmEditBatchCheckbox.addEventListener('change', () => {
    finalEditBatchBtn.disabled = !confirmEditBatchCheckbox.checked;
});

// 5. Cancel confirmation
cancelEditBatchBtn.addEventListener('click', () => {
    confirmEditBatchModalInstance.hide();
    setTimeout(() => {
        editBatchModalInstance.show();
    }, 300);
});

//6. Send Medicine Batch
finalEditBatchBtn.addEventListener('click', async () => {
    const batchId = editBatchIdInput.value;
    const newExpiryDate = editExpiryDateInput.value;

    // Disable and show loading state
    finalEditBatchBtn.disabled = true;
    const originalText = finalEditBatchBtn.textContent;
    finalEditBatchBtn.textContent = 'Updating...';

    try {
        const response = await fetch(`/inventory/${batchId}/update-expiry`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                expiry_date: newExpiryDate
            })
        });

        const data = await response.json();

        if (response.ok) {
            // Keep it disabled; flow proceeds to success modal
            confirmEditBatchModalInstance.hide();

            setTimeout(() => {
                successMesageHeader.textContent = 'Expiry Date Updated';
                successMessage.textContent = data.message || 'The batch expiry date has been successfully updated.';
                successModalInstance.show();
            }, 300);
        } else {
            // Revert button on failure
            finalEditBatchBtn.disabled = false;
            finalEditBatchBtn.textContent = originalText;
            alert(data.message || 'Failed to update expiry date');
        }

    } catch (error) {
        console.error('Error:', error);
        // Revert button on error
        finalEditBatchBtn.disabled = false;
        finalEditBatchBtn.textContent = originalText;
        alert('An error occurred while updating the expiry date');
    }
});


// 7. Close success modal and reload page
closeSuccessModalButton.addEventListener('click', () => {
    successModalInstance.hide();
    setTimeout(() => {
        location.reload();
    }, 300);
});
