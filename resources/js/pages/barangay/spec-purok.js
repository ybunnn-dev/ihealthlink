// = an==================================================================
// SETUP: Get elements (will be null if they don't exist on the page)
// ====================================================================
const tableBody = document.getElementById('purok-table-body');

// Edit Modal Elements
const editPurokModalEl = document.getElementById('edit-purok-modal');
const purokNameInput = document.getElementById('edit-purok-name-input');
const saveButton = document.getElementById('save-purok-changes-btn');
const cancelEdit = document.getElementById('cancel-edit-purok')

// Edit Confirmation Modal Elements
const confirmEditModalEl = document.getElementById('confirm-edit-purok-modal');
const oldPurokNameDisplay = document.getElementById('old-purok-name-display');
const newPurokNameDisplay = document.getElementById('new-purok-name-display');
const confirmCheckbox = document.getElementById('confirm-edit-purok-checkbox');
const confirmProceedButton = document.getElementById('confirm-proceed-edit-button');
const cancelEditConfirm = document.getElementById('cancel-edit-confirm');

const removePurokModalEl = document.getElementById('remove-purok-modal');
const purokNameToRemove = document.getElementById('purok-name-to-remove');
const removePurokCheckbox = document.getElementById('remove-purok-checkbox');
const confirmRemovePurokButton = document.getElementById('confirm-remove-purok-button');
const cancelRemove = document.getElementById('cancel-remove');
// ====================================================================
// MAIN LOGIC: Only run if the main table exists on the page
// ====================================================================
if (tableBody) {
    if (editPurokModalEl && confirmEditModalEl) {
        // Initialize modals ONCE and store them
        const editModal = new Modal(editPurokModalEl);
        const confirmEditModal = new Modal(confirmEditModalEl);
        
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
            editModal.hide(); // This will now work correctly
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

            console.log(`reparing to EDIT Purok ID: ${purokId}`, payload);

            fetch(`/mho/puroks/${purokId}`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                },
                credentials: "same-origin", // important so cookies/session are sent
                body: JSON.stringify(payload),
            })
            .then(res => res.json())
            .then(data => {
                console.log("✅ Backend Response:", data);
                confirmEditModal.hide();
                alert(`Edit simulated for Purok ID ${purokId}: ${newName}`);
                window.location.reload();
            })
            .catch(err => console.error("❌ Error:", err));
        });

        // --- MAIN TABLE LISTENER for triggering modals ---
        tableBody.addEventListener('click', function(event) {
            // Handle Edit Button Click
            const editButton = event.target.closest('.js-edit-purok-btn');
            if (editButton) {
                const purokId = editButton.dataset.purokId;
                const purokToEdit = window.initialPurokData.find(p => p.id == purokId);
                if (purokToEdit) {
                    // DO NOT create a new modal here.
                    // const editModal = new Modal(editPurokModalEl);
                    purokNameInput.value = purokToEdit.name;
                    purokNameInput.setAttribute('data-original-name', purokToEdit.name);
                    saveButton.setAttribute('data-purok-id', purokId);
                    saveButton.disabled = true;
                    // Just SHOW the existing one.
                    editModal.show();
                }
            }
        });
    }
        // --- (NEW) REMOVE FLOW ---
    if (removePurokModalEl) {
        const removeModal = new Modal(removePurokModalEl);

        // Listener for the remove confirmation checkbox
        removePurokCheckbox.addEventListener('change', function() {
            confirmRemovePurokButton.disabled = !this.checked;
        });

        confirmRemovePurokButton.addEventListener('click', function() {
            const purokId = this.dataset.purokId;

            console.log(`🗑️ Preparing to REMOVE Purok ID: ${purokId}`);

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
                removeModal.hide();
                alert(`Purok ID ${purokId} has been removed (simulated).`);
                window.location.reload();
            })
            .catch(err => console.error("❌ Error:", err));
        });
        
        cancelRemove.addEventListener('click', function(e){
            e.preventDefault();
            removeModal.hide(); // This will now work correctly
        });

        tableBody.addEventListener('click', function(event) {
            // (NEW) Handle Remove Button Click
            const deleteButton = event.target.closest('.js-delete-purok-btn');
            if (deleteButton && removePurokModalEl) {
                //const removeModal = new Modal(removePurokModalEl);
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
}
