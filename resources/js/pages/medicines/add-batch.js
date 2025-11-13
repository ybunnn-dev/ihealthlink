// resources/js/pages/medicines/add-batch.js

// --- Modal Options Factory ---
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

const openAddBatch = document.getElementById('add-batch-tigger');
const closeAddBatch = document.getElementById('close-add-batch');
const submitBatch = document.getElementById('submit-batch');

// --- Modal Element References ---
const addBatchModalEl = document.getElementById('add-batch-modal');
const confirmAddBatchModalEl = document.getElementById('confirm-add-batch-modal');
const successModalEl = document.getElementById('success-modal');

// --- Initialize Modal Instances ---
const addBatchModal = new Modal(addBatchModalEl, createModalOptions(addBatchModalEl));
const confirmAddBatchModal = new Modal(confirmAddBatchModalEl, createModalOptions(confirmAddBatchModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

// --- Medicine Data ---
const medicineData = window.medicineData;

// --- Form Elements ---
const addBatchForm = document.querySelector('#add-batch-modal form');
const expiryDateInput = document.getElementById('expiryDate');
const quantityInput = document.getElementById('quantity_received');
const dateAddedInput = document.querySelector('input[name="date_received"]');

// --- Confirmation Modal Elements ---
const medicineNameToConfirm = document.getElementById('batch-medicine-name-to-confirm');
const quantityToConfirm = document.getElementById('batch-quantity-to-confirm');
const expiryToConfirm = document.getElementById('batch-expiry-to-confirm');
const confirmBatchCheckbox = document.getElementById('confirm-batch-checkbox');
const cancelAddBatchButton = document.getElementById('cancel-confirm-add-batch');
const confirmAddBatchButton = document.getElementById('confirm-add-batch-btn');

// --- Success Modal Elements ---
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

// --- State Management ---
let batchPayload = null;

// --- Form Submit Handler (Intercept submission) ---
submitBatch.addEventListener('click', function(event) {
    event.preventDefault();
    
    // Validate form
    if (!expiryDateInput.value || !quantityInput.value) {
        alert('Please fill in all required fields.');
        return;
    }
    
    // Create payload
    batchPayload = {
        medicine_id: medicineData.id,
        date_received: dateAddedInput.value,
        expiry_date: expiryDateInput.value,
        quantity_received: parseInt(quantityInput.value)
    };
    
    // Populate confirmation modal
    medicineNameToConfirm.textContent = medicineData.medicine_name;
    quantityToConfirm.textContent = batchPayload.quantity_received;
    expiryToConfirm.textContent = batchPayload.expiry_date;
    
    // Show confirmation modal with a slight delay after hiding
    addBatchModal.hide();
    console.log(confirmAddBatchModal);
    confirmAddBatchModal.show();

});

// --- Confirmation Checkbox Handler ---
confirmBatchCheckbox.addEventListener('change', function() {
    confirmAddBatchButton.disabled = !this.checked;
});

// --- Confirm Add Batch Handler ---
confirmAddBatchButton.addEventListener('click', function() {
    if (!batchPayload) return;
    
    console.log('Final payload to submit:', batchPayload);
    
    // Save original button text
    const originalButtonText = confirmAddBatchButton.textContent;
    
    // Disable both buttons and show loading state
    confirmAddBatchButton.disabled = true;
    cancelAddBatchButton.disabled = true;
    confirmAddBatchButton.textContent = 'Saving...';
    
    fetch(`/midwife/medicines/${medicineData.id}/inventory`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(batchPayload)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Server response:', data);

        // Wait 2 seconds before showing success or error
        setTimeout(() => {
            if (data.result === 'success') {
                confirmAddBatchModal.hide();
                successMesageHeader.textContent = 'Batch Added';
                successMessage.textContent = 'Medicine batch has been added successfully';
                successModal.show();
                
                // Reset form
                addBatchForm.reset();
                confirmBatchCheckbox.checked = false;
                batchPayload = null;
                
                // Reset button states
                confirmAddBatchButton.textContent = originalButtonText;
                confirmAddBatchButton.disabled = false;
                cancelAddBatchButton.disabled = false;
            } else {
                // Handle error case
                alert('Error: ' + (data.message || 'Failed to add batch'));
                
                // Re-enable buttons on error
                confirmAddBatchButton.textContent = originalButtonText;
                confirmAddBatchButton.disabled = false;
                cancelAddBatchButton.disabled = false;
            }
        }, 2000);
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Wait 2 seconds before showing error
        setTimeout(() => {
            alert('An error occurred while adding the batch. Please try again.');
            
            // Re-enable buttons on error
            confirmAddBatchButton.textContent = originalButtonText;
            confirmAddBatchButton.disabled = false;
            cancelAddBatchButton.disabled = false;
        }, 2000);
    });
});

// --- Cancel Confirmation Handler ---
cancelAddBatchButton.addEventListener('click', function() {
    confirmAddBatchModal.hide();
    addBatchModal.show();
    
    confirmBatchCheckbox.checked = false;
    confirmAddBatchButton.disabled = true;
});

// --- Success Modal Close Handler ---
closeSuccessModalButton.addEventListener('click', function() {
    window.location.href = `/barangay/medicines/${medicineData.id}`;
});


closeAddBatch.addEventListener('click', function(){
    expiryDateInput.value = '';
    quantityInput.value = '';
    addBatchModal.hide();
});

openAddBatch.addEventListener('click', function(){
    addBatchModal.show();
    console.log(addBatchModal);
});

