// The main modal element
const programName = window.program.name;
const programId = window.program.id;

const removeProgramModalEl = document.getElementById('confirm-remove-program-modal');

// Buttons
const cancelRemoveProgramButton = document.getElementById('cancel-remove-program-button');
const confirmRemoveProgramButton = document.getElementById('confirm-remove-program-button');

const programNameDisplay = document.getElementById('remove-program-name-display');
const confirmRemoveCheckbox = document.getElementById('confirm-remove-checkbox');

const openRemove = document.getElementById('remove-program-button');

// --- Success Modal ---
const successModalEl = document.getElementById('success-modal');
const successMessageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

/* --- Modal Options Function --- */
const createModalOptions = (modalEl) => ({
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            modalEl.classList.remove('opacity-0');
            modalEl.classList.add('opacity-100');
            
            const modalContent = modalEl.querySelector('.relative.bg-white, .relative.dark\\:bg-gray-700, .relative.dark\\:bg-gray-800');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        modalEl.classList.add('opacity-0');
        modalEl.classList.remove('opacity-100');
        
        const modalContent = modalEl.querySelector('.relative.bg-white, .relative.dark\\:bg-gray-700, .relative.dark\\:bg-gray-800');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
});

/* --- Initialize Modals --- */
const modalOptions = createModalOptions(removeProgramModalEl);
const removeProgramModal = new Modal(removeProgramModalEl, modalOptions);

const successModalOptions = createModalOptions(successModalEl);
const successModal = new Modal(successModalEl, successModalOptions);

/* --- Confirm Remove Button Click --- */
if (confirmRemoveProgramButton) {
    confirmRemoveProgramButton.addEventListener('click', async () => {
        console.log(`User confirmed removal of: ${programNameDisplay.textContent}`);
        
        try {
            const response = await fetch(`/mho/health-program/delete/${programId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                removeProgramModal.hide();
                
                // Show success modal
                successMessageHeader.textContent = 'Program Removed';
                successMessage.textContent = data.message || 'Health program removed successfully';
                successModal.show();
            } else {
                alert('Error: ' + data.message);
            }
            
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to remove program');
        }
    });
}

/* --- Enable/Disable Confirm Button Based on Checkbox --- */
if (confirmRemoveCheckbox && confirmRemoveProgramButton) {
    confirmRemoveCheckbox.addEventListener('change', () => {
        confirmRemoveProgramButton.disabled = !confirmRemoveCheckbox.checked;
    });
}

/* --- Cancel Remove Button --- */
if (cancelRemoveProgramButton) {
    cancelRemoveProgramButton.addEventListener('click', () => {
        removeProgramModal.hide();
    });
}

/* --- Open Remove Modal --- */
openRemove.addEventListener('click', function(){
    programNameDisplay.textContent = programName;
    confirmRemoveCheckbox.checked = false;
    confirmRemoveProgramButton.disabled = true;
    removeProgramModal.show();
});

/* --- Close Success Modal and Redirect --- */
if (closeSuccessModalButton) {
    closeSuccessModalButton.addEventListener('click', () => {
        successModal.hide();
        // Redirect after modal hides
        window.location.href = '/mho/health-programs';
    });
}
