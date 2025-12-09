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

const confirmDeleteBatchModal = document.getElementById('confirm-delete-batch-modal');
// Dynamic Text Elements
const deleteBatchMedicineNameDisplay = document.getElementById('delete-batch-medicine-name');
const deleteBatchExpiryDisplay = document.getElementById('delete-batch-expiry-display');
const deleteBatchQuantityDisplay = document.getElementById('delete-batch-quantity-display');
// Interaction Elements
const confirmDeleteBatchCheckbox = document.getElementById('delete-batch-checkbox');
const cancelDeleteBatchBtn = document.getElementById('cancel-confirm-delete-batch');
const finalDeleteBatchBtn = document.getElementById('final-confirm-delete-batch-btn');


const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

/* =========================================
   DELETE BATCH FUNCTIONALITY (Set to Inactive)
========================================= */

const confirmDeleteBatchModalInstance = new Modal(confirmDeleteBatchModal, createModalOptions(confirmDeleteBatchModal));
const successModalInstance = new Modal(successModalEl, createModalOptions(successModalEl));

// Store current batch info
let currentBatchInfo = {
    id: null,
    medicineName: '',
    expiryDate: '',
    quantity: 0
};

// 1. Open Delete Confirmation Modal when Delete button clicked
document.addEventListener('click', function(e) {
    if (e.target.closest('.js-delete-inventory-btn')) {
        const btn = e.target.closest('.js-delete-inventory-btn');
        
        // Check if button is disabled
        if (btn.disabled) {
            return;
        }
        
        const inventoryId = btn.dataset.inventoryId;
        const medicineName = btn.dataset.medicineName || 'this medicine';
        const expiryDate = btn.dataset.expiryDate || 'N/A';
        const quantity = btn.dataset.quantity || '0';
        
        // Store batch info
        currentBatchInfo = {
            id: inventoryId,
            medicineName: medicineName,
            expiryDate: expiryDate,
            quantity: quantity
        };
        
        // Format expiry date for display
        const formattedDate = new Date(expiryDate).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        
        // Reset checkbox and disable button
        confirmDeleteBatchCheckbox.checked = false;
        finalDeleteBatchBtn.disabled = true;
        
        // Show confirmation modal
        confirmDeleteBatchModalInstance.show();
    }
});

// 2. Enable/disable confirm button based on checkbox
confirmDeleteBatchCheckbox.addEventListener('change', () => {
    finalDeleteBatchBtn.disabled = !confirmDeleteBatchCheckbox.checked;
});

// 3. Cancel deletion
cancelDeleteBatchBtn.addEventListener('click', () => {
    confirmDeleteBatchModalInstance.hide();
});

// 4. Final confirmation - set status to inactive via AJAX
finalDeleteBatchBtn.addEventListener('click', async () => {
    const batchId = currentBatchInfo.id;
    
    // Disable and show loading state
    finalDeleteBatchBtn.disabled = true;
    const originalText = finalDeleteBatchBtn.textContent;
    finalDeleteBatchBtn.textContent = 'Deactivating...';
    
    try {
        const response = await fetch(`/inventory/${batchId}/deactivate`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (response.ok) {
            // Keep it disabled; flow proceeds to success modal
            confirmDeleteBatchModalInstance.hide();
            
            // Show success modal
            setTimeout(() => {
                successMesageHeader.textContent = 'Batch Deactivated';
                successMessage.textContent = data.message || 'The batch has been successfully deactivated.';
                successModalInstance.show();
            }, 300);
            
        } else {
            // Revert button on failure
            finalDeleteBatchBtn.disabled = false;
            finalDeleteBatchBtn.textContent = originalText;
            alert(data.message || 'Failed to deactivate batch');
        }
        
    } catch (error) {
        console.error('Error:', error);
        // Revert button on error
        finalDeleteBatchBtn.disabled = false;
        finalDeleteBatchBtn.textContent = originalText;
        alert('An error occurred while deactivating the batch');
    }
});
