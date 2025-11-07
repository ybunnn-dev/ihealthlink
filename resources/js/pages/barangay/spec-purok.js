// ====================================================================
// SETUP: Get elements (will be null if they don't exist on the page)
// ====================================================================
const tableBody = document.getElementById('purok-table-body');

// Edit Modal Elements
const editPurokModalEl = document.getElementById('edit-purok-modal');
const purokNameInput = document.getElementById('edit-purok-name-input');
const saveButton = document.getElementById('save-purok-changes-btn');
const cancelEdit = document.getElementById('cancel-edit-purok');

// Edit Confirmation Modal Elements
const confirmEditModalEl = document.getElementById('confirm-edit-purok-modal');
const oldPurokNameDisplay = document.getElementById('old-purok-name-display');
const newPurokNameDisplay = document.getElementById('new-purok-name-display');
const confirmCheckbox = document.getElementById('confirm-edit-purok-checkbox');
const confirmProceedButton = document.getElementById('confirm-proceed-edit-button');
const cancelEditConfirm = document.getElementById('cancel-edit-confirm');

// Remove Modal Elements
const removePurokModalEl = document.getElementById('remove-purok-modal');
const purokNameToRemove = document.getElementById('purok-name-to-remove');
const removePurokCheckbox = document.getElementById('remove-purok-checkbox');
const confirmRemovePurokButton = document.getElementById('confirm-remove-purok-button');
const cancelRemove = document.getElementById('cancel-remove');

// Success Modal Elements
const successModalEl = document.getElementById('success-modal');
const successMessageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

// ====================================================================
// MODAL OPTIONS: Create separate options for each modal with fade animations
// ====================================================================
const editPurokModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            editPurokModalEl.classList.remove('opacity-0');
            editPurokModalEl.classList.add('opacity-100');
            
            const modalContent = editPurokModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        editPurokModalEl.classList.add('opacity-0');
        editPurokModalEl.classList.remove('opacity-100');
        
        const modalContent = editPurokModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

const confirmEditModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            confirmEditModalEl.classList.remove('opacity-0');
            confirmEditModalEl.classList.add('opacity-100');
            
            const modalContent = confirmEditModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        confirmEditModalEl.classList.add('opacity-0');
        confirmEditModalEl.classList.remove('opacity-100');
        
        const modalContent = confirmEditModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

const removePurokModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            removePurokModalEl.classList.remove('opacity-0');
            removePurokModalEl.classList.add('opacity-100');
            
            const modalContent = removePurokModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        removePurokModalEl.classList.add('opacity-0');
        removePurokModalEl.classList.remove('opacity-100');
        
        const modalContent = removePurokModalEl.querySelector('.relative.bg-white');
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
// MAIN LOGIC: Only run if the main table exists on the page
// ====================================================================
if (tableBody) {
    if (editPurokModalEl && confirmEditModalEl) {
        // Initialize modals ONCE with their options
        const editModal = new Modal(editPurokModalEl, editPurokModalOptions);
        const confirmEditModal = new Modal(confirmEditModalEl, confirmEditModalOptions);
        const successModal = new Modal(successModalEl, successModalOptions);
        
        // Listener to enable/disable Save button
        purokNameInput.addEventListener('input', function(event) {
            const originalName = event.target.getAttribute('data-original-name');
            const currentValue = event.target.value.trim();
            saveButton.disabled = (currentValue === '' || currentValue === originalName);
        });

        // Listener for the "Save Changes" button
        saveButton.addEventListener('click', function() {
            const purokId = this.dataset.purokId;
            const newName = purokNameInput.value.trim();
            const originalName = purokNameInput.dataset.originalName;
            
            oldPurokNameDisplay.textContent = originalName;
            newPurokNameDisplay.textContent = newName;
            confirmProceedButton.setAttribute('data-purok-id', purokId);
            confirmProceedButton.setAttribute('data-new-name', newName);
            confirmCheckbox.checked = false;
            confirmProceedButton.disabled = true;
            editModal.hide();
            confirmEditModal.show();
        });

        // Listener for the first modal's cancel button
        cancelEdit.addEventListener('click', function(e){
            e.preventDefault();
            editModal.hide();
        });

        // Listener for the second modal's cancel button
        cancelEditConfirm.addEventListener('click', function(){
            confirmEditModal.hide();
            editModal.show();
        });

        // Listener for the confirmation checkbox
        confirmCheckbox.addEventListener('change', function() {
            confirmProceedButton.disabled = !this.checked;
        });

        // Listener for the final "Confirm & Proceed" edit button
        confirmProceedButton.addEventListener('click', function() {
            const purokId = this.dataset.purokId;
            const newName = this.dataset.newName;
            const payload = { name: newName };

            console.log(`Preparing to EDIT Purok ID: ${purokId}`, payload);

            this.disabled = true;
            this.textContent = 'Saving...';

            fetch(`/mho/puroks/${purokId}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                credentials: "same-origin",
                body: JSON.stringify(payload),
            })
            .then(res => res.json())
            .then(data => {
                console.log("✅ Backend Response:", data);
                
                // Hide confirmation modal and show success modal
                confirmEditModal.hide();
                successMessageHeader.textContent = 'Purok Updated';
                successMessage.textContent = `Purok has been successfully updated to "${newName}".`;
                successModal.show();

                // Reload after showing success modal
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            })
            .catch(err => {
                console.error("❌ Error:", err);
                alert('An error occurred while updating the purok.');
                this.disabled = false;
                this.textContent = 'Confirm & Proceed';
            });
        });

        // --- MAIN TABLE LISTENER for triggering modals ---
        tableBody.addEventListener('click', function(event) {
            // Handle Edit Button Click
            const editButton = event.target.closest('.js-edit-purok-btn');
            if (editButton) {
                const purokId = editButton.dataset.purokId;
                const purokToEdit = window.initialPurokData.find(p => p.id == purokId);
                if (purokToEdit) {
                    purokNameInput.value = purokToEdit.name;
                    purokNameInput.setAttribute('data-original-name', purokToEdit.name);
                    saveButton.setAttribute('data-purok-id', purokId);
                    saveButton.disabled = true;
                    editModal.show();
                }
            }
        });
    }
    
    // --- REMOVE FLOW ---
    if (removePurokModalEl) {
        const removeModal = new Modal(removePurokModalEl, removePurokModalOptions);
        const successModal = new Modal(successModalEl, successModalOptions);

        // Listener for the remove confirmation checkbox
        removePurokCheckbox.addEventListener('change', function() {
            confirmRemovePurokButton.disabled = !this.checked;
        });

        confirmRemovePurokButton.addEventListener('click', function() {
            const purokId = this.dataset.purokId;

            console.log(`🗑️ Preparing to REMOVE Purok ID: ${purokId}`);

            this.disabled = true;
            this.textContent = 'Removing...';

            fetch(`/mho/puroks/remove/${purokId}`, {
                method: "PUT",
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                credentials: "same-origin",
            })
            .then(res => res.json())
            .then(data => {
                console.log("✅ Backend Response:", data);
                
                // Hide remove modal and show success modal
                removeModal.hide();
                successMessageHeader.textContent = 'Purok Removed';
                successMessage.textContent = 'The purok has been successfully removed.';
                successModal.show();

                // Reload after showing success modal
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            })
            .catch(err => {
                console.error("❌ Error:", err);
                alert('An error occurred while removing the purok.');
                this.disabled = false;
                this.textContent = 'Confirm Remove';
            });
        });
        
        cancelRemove.addEventListener('click', function(e){
            e.preventDefault();
            removeModal.hide();
        });

        tableBody.addEventListener('click', function(event) {
            // Handle Remove Button Click
            const deleteButton = event.target.closest('.js-delete-purok-btn');
            if (deleteButton && removePurokModalEl) {
                const purokId = deleteButton.dataset.purokId;
                const purokToRemove = window.initialPurokData.find(p => p.id == purokId);

                if (purokToRemove) {
                    purokNameToRemove.textContent = purokToRemove.name;
                    confirmRemovePurokButton.setAttribute('data-purok-id', purokId);
                    removePurokCheckbox.checked = false;
                    confirmRemovePurokButton.disabled = true;
                    removeModal.show();
                }
            }
        });
    }
    
    // --- SUCCESS MODAL CLOSE HANDLER ---
    if (closeSuccessModalButton) {
        closeSuccessModalButton.addEventListener('click', function() {
            const successModal = new Modal(successModalEl, successModalOptions);
            successModal.hide();
        });
    }
}
