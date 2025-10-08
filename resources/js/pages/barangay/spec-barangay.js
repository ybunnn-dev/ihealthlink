
    // --- 1. Get HTML elements ---
    const editBarangayModalEl = document.getElementById('edit-barangay-modal');
    const confirmEditModalEl = document.getElementById('confirm-edit-barangay-modal');
    const removeModalEl = document.getElementById('remove-barangay-modal');
    const mainTriggerBtn = document.getElementById('edit-brgy-button');
    const removeTrigger = document.getElementById('remove-brgy-button');

    // --- 2. Create Flowbite Modal Instances (without the generic onHide option) ---
    const editBarangayModal = new Modal(editBarangayModalEl);
    const confirmEditModal = new Modal(confirmEditModalEl);
    const removeModal = new Modal(removeModalEl);
    
    // --- 4. Get other elements ---
    
    const barangayNameInput = document.getElementById('barangay-name-input');
    const openConfirmBtn = document.getElementById('open-confirmation-modal-button');
    const confirmCheckbox = document.getElementById('confirm-barangay-checkbox');
    const removeCheckBox = document.getElementById('remove-barangay-checkbox');
    const confirmProceedBtn = document.getElementById('confirm-proceed-button');
    const brgyName = window.brgy_name || [];
    const cancelConfirmBtn = confirmEditModalEl.querySelector('[data-modal-hide="confirm-edit-barangay-modal"]');
    const cancelEdit = document.getElementById('cancel-edit-barangay');
    const cancelRemove = document.getElementById('remove-cancel');
    const proceedRemove = document.getElementById('confirm-remove-button');

    console.log(brgyName);
    
    // --- 3. Add Event Listener to Open the First Modal ---
    mainTriggerBtn.addEventListener('click', function() {
        barangayNameInput.value = brgyName;
        editBarangayModal.show();
    });

    removeTrigger.addEventListener('click', function(){
        document.getElementById('barangay-name-to-remove').textContent = brgyName;
        removeModal.show();
    });

    cancelRemove.addEventListener('click', function(){
        removeModal.hide();
    });
    // --- 5. Open the confirmation modal ---
    openConfirmBtn.addEventListener('click', function () {
        const barangayName = barangayNameInput.value.trim();
        if (barangayName === '') {
            alert('Please enter a barangay name.');
            return;
        }
        const namePlaceholder = document.getElementById('barangay-name-to-confirm');
        namePlaceholder.textContent = barangayName;

        editBarangayModal.hide();
        confirmEditModal.show();
    });


    // --- 6. Handle checkbox logic ---
    confirmCheckbox.addEventListener('change', function () {
        confirmProceedBtn.disabled = !this.checked;
    });

    removeCheckBox.addEventListener('change', function () {
        proceedRemove.disabled = !this.checked;
    });



    // --- 7. Handle the final confirmation ---
    proceedRemove.addEventListener('click', async function(){
        const barangayId = this.getAttribute('data-id'); 

        this.disabled = true;
        this.textContent = 'Deactivating...';

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch(`/barangays/${barangayId}/deactivate`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Failed to deactivate barangay.');
            }

            window.location.href = '/mho/barangays';

        } catch (error) {
            console.error('Deactivate Error:', error);
            alert('An error occurred while deactivating the barangay.');
            this.disabled = false;
            this.textContent = 'Confirm Remove';
        }
    });



    confirmProceedBtn.addEventListener('click', async function () {
        const barangayId = this.getAttribute('data-id'); // put data-id="{{ $barangay->id }}" on your button
        const barangayNameToInsert = barangayNameInput.value.trim();

        this.disabled = true;
        this.textContent = 'Saving...';

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch(`/barangays/${barangayId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    name: barangayNameToInsert
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
            } else {
                window.location.reload();
            }

        } catch (error) {
            console.error('Submission Error:', error);
            alert('An error occurred while saving the barangay. Please check the console.');
            this.disabled = false;
            this.textContent = 'Confirm & Proceed';
        }
    });

    // --- 8. (NEW) Handle cancellation of the confirmation ---
    if (cancelConfirmBtn) {
        cancelConfirmBtn.addEventListener('click', function() {
            // When cancel is clicked, explicitly hide the confirmation
            // modal and show the "Add Barangay" modal again.
            confirmEditModal.hide();
            editBarangayModal.show();
        });
    }

    if(cancelEdit){
        cancelEdit.addEventListener('click', function(){
            barangayNameInput.value = brgyName;
            editBarangayModal.hide();
        });
    }
    

   