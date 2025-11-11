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

/* --- Elements --- */
const removeScheduleModalEl = document.getElementById('confirm-remove-schedule-modal');
const cancelRemoveScheduleButton = document.getElementById('cancel-remove-schedule-button');
const confirmRemoveScheduleButton = document.getElementById('confirm-remove-schedule-button');
const scheduleDetailsDisplay = document.getElementById('remove-schedule-details-display');
const confirmRemoveScheduleCheckbox = document.getElementById('confirm-remove-schedule-checkbox');

// Success Modal
const successModalEl = document.getElementById('success-modal');
const successMessageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

const fields = window.program.program_fields;

/* --- Initialize Modals --- */
const modalOptions = createModalOptions(removeScheduleModalEl);
const removeScheduleModal = new Modal(removeScheduleModalEl, modalOptions);

const successModalOptions = createModalOptions(successModalEl);
const successModal = new Modal(successModalEl, successModalOptions);

/* --- Functions --- */
function showRemoveScheduleModal(scheduleId, scheduleTitle) {
    if (scheduleDetailsDisplay) {
        scheduleDetailsDisplay.textContent = scheduleTitle;
    }

    if (confirmRemoveScheduleButton) {
        confirmRemoveScheduleButton.setAttribute('data-schedule-id', scheduleId);
    }

    if (confirmRemoveScheduleCheckbox) {
        confirmRemoveScheduleCheckbox.checked = false;
    }
    if (confirmRemoveScheduleButton) {
        confirmRemoveScheduleButton.disabled = true;
    }
    
    removeScheduleModal.show();
}

/* --- Event Listeners --- */

// Enable/disable confirm button based on checkbox
if (confirmRemoveScheduleCheckbox && confirmRemoveScheduleButton) {
    confirmRemoveScheduleCheckbox.addEventListener('change', () => {
        confirmRemoveScheduleButton.disabled = !confirmRemoveScheduleCheckbox.checked;
    });
}

// Cancel button
if (cancelRemoveScheduleButton) {
    cancelRemoveScheduleButton.addEventListener('click', () => {
        removeScheduleModal.hide();
    });
}

// Confirm remove schedule
if (confirmRemoveScheduleButton) {
    confirmRemoveScheduleButton.addEventListener('click', async () => {
        const scheduleIdToDelete = confirmRemoveScheduleButton.getAttribute('data-schedule-id');

        if (scheduleIdToDelete) {
            console.log(`User confirmed removal of schedule ID: ${scheduleIdToDelete}`);
            
            try {
                const response = await fetch(`/mho/health-program/schedule/remove/${scheduleIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    removeScheduleModal.hide();
                    
                    // Show success modal
                    successMessageHeader.textContent = 'Schedule Removed';
                    successMessage.textContent = data.message || 'Schedule removed successfully';
                    successModal.show();
                } else {
                    alert('Error: ' + data.message);
                }
                
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to remove schedule');
            }
        } else {
            console.error('Could not find schedule ID to delete.');
        }
    });
}

// Close success modal and reload page
if (closeSuccessModalButton) {
    closeSuccessModalButton.addEventListener('click', () => {
        successModal.hide();
        window.location.reload();
    });
}

// Delete buttons in table
const deleteButtons = document.querySelectorAll('.delete-schedule-btn');

deleteButtons.forEach(button => {
    button.addEventListener('click', () => {
        const scheduleId = button.getAttribute('data-schedule-id');
        const field = fields.find(f => f.id == scheduleId);
        
        let scheduleTitle = 'this schedule';
        
        if (field) {
            scheduleTitle = field.title;
        } else {
            console.error('Could not find field data for ID:', scheduleId);
        }
        
        showRemoveScheduleModal(scheduleId, scheduleTitle);
    });
});