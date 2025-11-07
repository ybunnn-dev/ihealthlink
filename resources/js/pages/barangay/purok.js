// ====================================================================
// GET HTML ELEMENTS
// ====================================================================
const addPurokModalEl = document.getElementById('add-purok-modal');
const confirmPurokModalEl = document.getElementById('confirm-add-purok-modal');
const mainTriggerBtn = document.getElementById('page-add-purok-button');

const purokNameInput = document.getElementById('purok-name-input');
const openPurokConfirmBtn = document.getElementById('open-purok-confirmation-modal-button');
const confirmPurokCheckbox = document.getElementById('confirm-purok-checkbox');
const confirmProceedPurokBtn = document.getElementById('confirm-proceed-purok-button');
const cancelConfirmBtn = confirmPurokModalEl.querySelector('[data-modal-hide="confirm-add-purok-modal"]');
const purokPageContainer = document.getElementById('purok-page-container');
const currentBarangayId = purokPageContainer.dataset.barangayId;
const cancelAddPurok = document.getElementById('cancel-add-purok');

// Success Modal Elements
const successModalEl = document.getElementById('success-modal');
const successMessageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

// ====================================================================
// MODAL OPTIONS WITH FADE ANIMATIONS
// ====================================================================
const addPurokModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            addPurokModalEl.classList.remove('opacity-0');
            addPurokModalEl.classList.add('opacity-100');
            
            const modalContent = addPurokModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        addPurokModalEl.classList.add('opacity-0');
        addPurokModalEl.classList.remove('opacity-100');
        
        const modalContent = addPurokModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

const confirmPurokModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            confirmPurokModalEl.classList.remove('opacity-0');
            confirmPurokModalEl.classList.add('opacity-100');
            
            const modalContent = confirmPurokModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        confirmPurokModalEl.classList.add('opacity-0');
        confirmPurokModalEl.classList.remove('opacity-100');
        
        const modalContent = confirmPurokModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

const successModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            successModalEl.classList.remove('opacity-0');
            successModalEl.classList.add('opacity-100');
            
            const modalContent = successModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        successModalEl.classList.add('opacity-0');
        successModalEl.classList.remove('opacity-100');
        
        const modalContent = successModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

// ====================================================================
// CREATE MODAL INSTANCES
// ====================================================================
const addPurokModal = new Modal(addPurokModalEl, addPurokModalOptions);
const confirmPurokModal = new Modal(confirmPurokModalEl, confirmPurokModalOptions);
const successModal = new Modal(successModalEl, successModalOptions);

// ====================================================================
// EVENT LISTENERS
// ====================================================================
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
            this.disabled = false;
            this.textContent = 'Confirm & Proceed';
        } else {
            // Hide confirmation modal and show success modal
            confirmPurokModal.hide();
            successMessageHeader.textContent = 'Purok Added';
            successMessage.textContent = `Purok "${purokNameToInsert}" has been successfully added.`;
            successModal.show();

            // Reload after showing success modal
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        }

    } catch (error) {
        console.error('Submission Error:', error);
        alert('An error occurred while saving the purok. Please check the console.');
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

if (cancelAddPurok) {
    cancelAddPurok.addEventListener('click', function(){
        purokNameInput.value = '';
        addPurokModal.hide();
    });
}

// Success modal close handler
if (closeSuccessModalButton) {
    closeSuccessModalButton.addEventListener('click', function() {
        successModal.hide();
    });
}
