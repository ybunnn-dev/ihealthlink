export function initDailyActivityModal() {
    // ===== CONFIGURATION =====
    const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    const activityIcons = window.activityIcons || [];
    
    // ===== STATE =====
    let originalActivityState = null;
    let newlySelectedIconId = null;
    let updatedActivityPayload = null;

    // ===== DOM ELEMENTS =====
    const elements = {
        // Modals
        editModal: document.getElementById('edit-daily-activity-modal'),
        confirmModal: document.getElementById('confirm-edit-activity-modal'),
        successModal: document.getElementById('success-modal'),
        
        // Edit Modal Elements
        activityNameInput: document.getElementById('activityName'),
        activityDayInput: document.getElementById('activityDay'),
        saveButton: document.getElementById('save-daily-activity-button'),
        cancelEditButton: document.getElementById('cancel-edit-activity-button'),
        
        // Confirm Modal Elements
        changeSummary: document.getElementById('activity-change-summary'),
        confirmCheckbox: document.getElementById('confirm-activity-checkbox'),
        confirmButton: document.getElementById('confirm-edit-activity-btn'),
        cancelConfirmButton: document.getElementById('cancel-confirm-edit-activity'),
        
        // Success Modal Elements
        successHeader: document.getElementById('success-msg-head'),
        successMessage: document.getElementById('success-message'),
        closeSuccessButton: document.getElementById('close-success-modal-button')
    };

    // ===== MODAL OPTIONS =====
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

    // ===== MODAL INSTANCES =====
    const modals = {
        edit: new Modal(elements.editModal, createModalOptions(elements.editModal)),
        confirm: new Modal(elements.confirmModal, createModalOptions(elements.confirmModal)),
        success: new Modal(elements.successModal, createModalOptions(elements.successModal))
    };

    // ===== UTILITY FUNCTIONS =====
    function validateForm() {
        const currentName = elements.activityNameInput.value.trim();
        const hasNameChanged = currentName !== originalActivityState.name && currentName !== '';
        const hasIconChanged = newlySelectedIconId != originalActivityState.iconId;
        elements.saveButton.disabled = !(hasNameChanged || hasIconChanged);
    }

    function highlightSelectedIcon(iconId) {
        // Remove highlight from all icons
        activityIcons.forEach(icon => {
            const iconBtn = document.getElementById(`icon-button-${icon.id}`);
            if (iconBtn) {
                iconBtn.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
            }
        });
        
        // Highlight selected icon
        const activeIconButton = document.getElementById(`icon-button-${iconId}`);
        if (activeIconButton) {
            activeIconButton.classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
        }
    }

    function populateEditModal(activityData) {
        originalActivityState = {
            id: activityData.id,
            name: activityData.name,
            day: activityData.day,
            iconId: activityData.iconId
        };
        
        newlySelectedIconId = originalActivityState.iconId;
        elements.activityNameInput.value = originalActivityState.name;
        elements.activityDayInput.value = `${originalActivityState.day} Schedule`;
        elements.saveButton.disabled = true;
        
        highlightSelectedIcon(originalActivityState.iconId);
    }

    function showConfirmationModal() {
        const newName = elements.activityNameInput.value.trim();
        
        elements.changeSummary.innerHTML = `You are updating <strong>${originalActivityState.day}'s</strong> activity from "<strong>${originalActivityState.name}</strong>" to "<strong>${newName}</strong>".`;
        
        updatedActivityPayload = {
            id: originalActivityState.id,
            newName: newName,
            day: originalActivityState.day,
            icon_id: newlySelectedIconId
        };
        
        elements.confirmCheckbox.checked = false;
        elements.confirmButton.disabled = true;
        
        modals.edit.hide();
        modals.confirm.show();
    }

    async function submitActivityUpdate() {
        const originalButtonText = elements.confirmButton.textContent;
        
        // Disable buttons and show loading state
        elements.confirmButton.disabled = true;
        elements.cancelConfirmButton.disabled = true;
        elements.confirmButton.textContent = 'Saving...';
        
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const response = await fetch('/daily-activity/update', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(updatedActivityPayload)
            });
            
            const data = await response.json();
            
            if (data.result === 'success') {
                modals.confirm.hide();
                elements.successHeader.textContent = 'Day Activity Updated';
                elements.successMessage.textContent = 'Scheduled activity for the chosen day has been updated';
                modals.success.show();
            } else {
                alert(data.message || 'Failed to update activity.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to update activity. Please check your connection.');
        } finally {
            // Re-enable buttons and restore text
            elements.confirmButton.disabled = false;
            elements.cancelConfirmButton.disabled = false;
            elements.confirmButton.textContent = originalButtonText;
        }
    }


    // ===== EVENT LISTENERS =====
    
    // Day buttons - Open edit modal
    days.forEach(day => {
        const button = document.getElementById(`manage-button-${day}`);
        if (button) {
            button.addEventListener('click', () => {
                populateEditModal({
                    id: button.dataset.activityId,
                    name: button.dataset.activityName,
                    day: button.dataset.activityDay,
                    iconId: button.dataset.activityIconId
                });
                modals.edit.show();
            });
        }
    });

    // Icon selection
    activityIcons.forEach(icon => {
        const iconButton = document.getElementById(`icon-button-${icon.id}`);
        if (iconButton) {
            iconButton.addEventListener('click', function() {
                newlySelectedIconId = this.value;
                highlightSelectedIcon(newlySelectedIconId);
                validateForm();
            });
        }
    });

    // Activity name input
    elements.activityNameInput.addEventListener('input', validateForm);

    // Save button - Show confirmation modal
    elements.saveButton.addEventListener('click', showConfirmationModal);

    // Cancel edit modal
    elements.cancelEditButton.addEventListener('click', () => {
        modals.edit.hide();
    });

    // Cancel confirmation modal - Return to edit
    elements.cancelConfirmButton.addEventListener('click', () => {
        modals.confirm.hide();
        modals.edit.show();
    });

    // Confirm checkbox - Enable/disable confirm button
    elements.confirmCheckbox.addEventListener('change', function() {
        elements.confirmButton.disabled = !this.checked;
    });

    // Confirm button - Submit update
    elements.confirmButton.addEventListener('click', submitActivityUpdate);

    // Close success modal - Reload page
    elements.closeSuccessButton.addEventListener('click', () => {
        modals.success.hide();
        window.location.reload();
    });
}
