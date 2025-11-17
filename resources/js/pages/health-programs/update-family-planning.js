// ===== CONFIGURATION =====
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

// ===== STATE =====
const enrolledResident = window.enrolledResident;
const resident = enrolledResident.resident;
const fpRecord = enrolledResident.fam_plan_record;
let payload = null;

// ===== DOM ELEMENTS =====
const elements = {
    // Modal Elements
    updateFpModal: document.getElementById('update-family-planning-modal'),
    confirmModal: document.getElementById('confirm-update-family-planning-modal'),
    successModal: document.getElementById('success-modal'),
    
    // Form Inputs
    residentNameInput: document.getElementById('fp_update_resident_name'),
    clientTypeSelect: document.getElementById('fp_update_client_type'),
    sourceSelect: document.getElementById('fp_update_source'),
    currentMethodSelect: document.getElementById('fp_update_current_method'),
    dropoutCheckbox: document.getElementById('fp_dropout_checkbox'),
    dropoutDateInput: document.getElementById('fp_dropout_date'),
    dropoutReasonSelect: document.getElementById('fp_dropout_reason'),
    dropoutDetailsContainer: document.getElementById('dropout_details'),
    
    // Buttons
    openUpdateBtn: document.getElementById('update-record'),
    updateCancelBtn: document.getElementById('cancel-update-fp'),
    proceedUpdateBtn: document.getElementById('proceed-update-fp'),
    cancelConfirmBtn: document.getElementById('cancel-confirm-update-fp'),
    confirmUpdateBtn: document.getElementById('confirm-update-fp-btn'),
    confirmCheckbox: document.getElementById('confirm-update-fp-checkbox'),
    
    // Confirmation Display
    residentNameToConfirm: document.getElementById('update-fp-resident-name-to-confirm'),
    
    // Success Modal Elements
    successHeader: document.getElementById('success-msg-head'),
    successMessage: document.getElementById('success-message'),
    closeSuccessBtn: document.getElementById('close-success-modal-button')
};

// ===== MODAL INSTANCES =====
const modals = {
    updateFp: new Modal(elements.updateFpModal, createModalOptions(elements.updateFpModal)),
    confirm: new Modal(elements.confirmModal, createModalOptions(elements.confirmModal)),
    success: new Modal(elements.successModal, createModalOptions(elements.successModal))
};

// ===== UTILITY FUNCTIONS =====
function getFullName(resident) {
    const { firstName, middleName, lastName, suffix } = resident;
    return [firstName, middleName, lastName, suffix]
        .filter(name => name && name.trim() !== '')
        .join(' ');
}

function populateFormFields() {
    const fullName = getFullName(resident);
    elements.residentNameInput.value = fullName;
    elements.clientTypeSelect.value = fpRecord.client_type || "";
    elements.sourceSelect.value = fpRecord.source || "";
    elements.currentMethodSelect.value = fpRecord.previous_method || "";
    
    // Handle dropout fields
    if (fpRecord.dropout_date || fpRecord.dropout_reason) {
        elements.dropoutDateInput.value = fpRecord.dropout_date || "";
        elements.dropoutReasonSelect.value = fpRecord.dropout_reason || "";
    } else {
        elements.dropoutDateInput.value = "";
        elements.dropoutReasonSelect.value = "";
    }
}

function createPayload() {
    return {
        enrolled_resident_id: enrolledResident.id,
        client_type: elements.clientTypeSelect.value,
        source: elements.sourceSelect.value,
        previous_method: elements.currentMethodSelect.value,
        dropout_date: elements.dropoutDateInput.value || null,
        dropout_reason: elements.dropoutReasonSelect.value || null
    };
}

function showConfirmationModal() {
    payload = createPayload();
    console.log("Form Data Payload:", payload);
    
    const fullName = getFullName(resident);
    elements.residentNameToConfirm.textContent = fullName;
    
    elements.confirmCheckbox.checked = false;
    elements.confirmUpdateBtn.disabled = true;
    
    modals.updateFp.hide();
    modals.confirm.show();
}

async function submitUpdate() {
    const originalButtonText = elements.confirmUpdateBtn.textContent;
    
    // Disable buttons and show loading state
    elements.confirmUpdateBtn.disabled = true;
    elements.cancelConfirmBtn.disabled = true;
    elements.confirmUpdateBtn.textContent = 'Saving...';
    
    try {
        const response = await fetch(`/barangay/health-program/fam-plan/update/${payload.enrolled_resident_id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        });
        
        const data = await response.json();
        console.log('Response from backend:', data);
        
        if (data.result === 'success') {
            modals.confirm.hide();
            elements.successHeader.textContent = 'Update Successful';
            elements.successMessage.textContent = 'Family planning record has been successfully updated.';
            modals.success.show();
        } else {
            alert(data.message || 'Failed to update family planning record.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update record. Please check your connection.');
    } finally {
        // Re-enable buttons and restore text
        elements.confirmUpdateBtn.disabled = false;
        elements.cancelConfirmBtn.disabled = false;
        elements.confirmUpdateBtn.textContent = originalButtonText;
    }
}

// ===== EVENT LISTENERS =====

// Open update modal
elements.openUpdateBtn.addEventListener('click', () => {
    populateFormFields();
    modals.updateFp.show();
});

// Cancel update modal
elements.updateCancelBtn.addEventListener('click', () => {
    payload = null;
    modals.updateFp.hide();
});

// Proceed to confirmation
elements.proceedUpdateBtn.addEventListener('click', showConfirmationModal);

// Cancel confirmation - return to update modal
elements.cancelConfirmBtn.addEventListener('click', () => {
    modals.confirm.hide();
    modals.updateFp.show();
});

// Confirm checkbox toggle
elements.confirmCheckbox.addEventListener('change', function() {
    elements.confirmUpdateBtn.disabled = !this.checked;
});

// Submit update
elements.confirmUpdateBtn.addEventListener('click', submitUpdate);

// Close success modal - reload page
elements.closeSuccessBtn.addEventListener('click', () => {
    modals.success.hide();
    window.location.reload();
});
