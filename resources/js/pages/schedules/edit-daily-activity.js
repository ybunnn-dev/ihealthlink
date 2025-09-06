/**
 * Sets up event listeners and state management for the "Edit Daily Activity" modal.
 */
export function initDailyActivityModal() {
    // This variable will hold the original state of the activity being edited.
    // It's accessible by all event listeners within this function.
    let newlySelectedIconId = null;
    let originalActivityState = null;
    let updatedActivityPayload = null;
    const editModalElement = document.getElementById('edit-daily-activity-modal');
    const confirmModalElement = document.getElementById('confirm-edit-activity-modal');

    // --- Select Elements from the DOM ---
    const activityNameInput = document.getElementById('activityName');
    const activityDayInput = document.getElementById('activityDay');
    const saveButton = document.getElementById('save-daily-activity-button');
    const iconPickerContainer = document.querySelector('.icon-picker-button').parentElement;

    const cancelEditModal = document.getElementById('cancel-edit-activity-button');

    const changeSummary = document.getElementById('activity-change-summary');
    const confirmCheckbox = document.getElementById('confirm-activity-checkbox');
    const finalConfirmButton = document.getElementById('confirm-edit-activity-btn');
    const cancelConfirmButton = document.getElementById('cancel-confirm-edit-activity');

    // --- Listener #1: Open Modal and Set Initial State ---
    // This listens for clicks on the "Manage" buttons to open the modal.
    const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    const activityIcons = window.activityIcons || []; 
    // --- Loop through each day to find and attach a listener to its button ---
    days.forEach(day => {
        const buttonId = `manage-button-${day}`;
        const button = document.getElementById(buttonId);

        // If the button for this day exists on the page, attach the listener
        if (button) {
            button.addEventListener('click', function() {
                // The logic from here is the same, but it's specific to this button
                const editModal = new Modal(editModalElement);
                console.log(activityIcons);
                if(editModal){
                    editModal.show();
                }
                // 1. Store the data from this specific button
                originalActivityState = {
                    id: button.dataset.activityId,
                    name: button.dataset.activityName,
                    day: button.dataset.activityDay,
                    iconId: button.dataset.activityIconId, // Get the current icon ID
                };
                newlySelectedIconId = originalActivityState.iconId;
                console.log(newlySelectedIconId);
                // 2. Populate the modal's input fields
                if (activityNameInput && activityDayInput) {
                    activityNameInput.value = originalActivityState.name;
                    activityDayInput.value = originalActivityState.day + ' Schedule';
                }
                
                activityIcons.forEach(icon => {
                    const iconBtn = document.getElementById(`icon-button-${icon.id}`);
                    if (iconBtn) {
                        iconBtn.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
                    }
                });

                // Now, highlight the specific active one
                const activeIconButton = document.getElementById(`icon-button-${originalActivityState.iconId}`); // Now this will find the correct ID
                if (activeIconButton) {
                    activeIconButton.classList.add('ring-2', 'ring-blue-500', 'border-blue-500');
                }
                // 3. Disable the save button by default
                if (saveButton) {
                    saveButton.disabled = true;
                }
            });
        }
    });

    // This loop attaches a working listener to each icon button
    activityIcons.forEach(icon => {
        const iconButton = document.getElementById(`icon-button-${icon.id}`);
        if (iconButton) {
            iconButton.addEventListener('click', function() {
                // Store the ID of the clicked icon
                newlySelectedIconId = this.value;
                console.log(newlySelectedIconId);
                // Reset all other buttons first
                activityIcons.forEach(innerIcon => {
                    const btnToReset = document.getElementById(`icon-button-${innerIcon.id}`);
                    if(btnToReset) btnToReset.classList.remove('ring-2', 'ring-blue-500', 'border-blue-500');
                });

                // Highlight the clicked button
                this.classList.add('ring-2', 'ring-blue-500', 'border-blue-500');

                // --- FIX ADDED HERE ---
                // Check if the new icon is different from the original and enable the save button.
                const hasIconChanged = newlySelectedIconId != originalActivityState.iconId;
                const hasNameChanged = activityNameInput.value.trim() !== originalActivityState.name && activityNameInput.value.trim() !== '';

                if (saveButton) {
                    saveButton.disabled = !(hasIconChanged || hasNameChanged);
                }
            });
        }
    });
    // --- Listener #2: Detect Changes in the Input ---
    // This listens for typing in the activity name field to enable/disable the save button.
    activityNameInput.addEventListener('input', function() {
        // Trim whitespace from the current input value for accurate comparison.
        const currentName = activityNameInput.value.trim();

        // Check if the current name is different from the original and is not empty.
        const hasChanged = currentName !== originalActivityState.name && currentName !== '';

        // Enable the button if there's a valid change, otherwise disable it.
        saveButton.disabled = !hasChanged;
    });

     

    saveButton.addEventListener('click', function() {
        const newName = activityNameInput.value.trim();
        
        // Prepare summary and payload
        if(changeSummary) {
            changeSummary.innerHTML = `You are updating <strong>${originalActivityState.day}'s</strong> activity from "<strong>${originalActivityState.name}</strong>" to "<strong>${newName}</strong>".`;
        } else {
            console.warn('changeSummary element not found');
        }
        updatedActivityPayload = { 
            id: originalActivityState.id, 
            newName: newName,
            day: originalActivityState.day,
            icon_id: newlySelectedIconId,
        };


        // Reset and show the confirmation modal
        confirmCheckbox.checked = false;
        finalConfirmButton.disabled = true;

        const editModal = new Modal(editModalElement);
        const confirmModal = new Modal(confirmModalElement);

        if(editModal && confirmModal){
            editModal.hide();
            confirmModal.show();
        }
    });
    
    cancelConfirmButton.addEventListener('click', function(){
        const editModal = new Modal(editModalElement);
        const confirmModal = new Modal(confirmModalElement);

        if(editModal && confirmModal){
            confirmModal.hide();
            editModal.show();
        }
    });

    cancelEditModal.addEventListener('click', function(){
        const editModal = new Modal(editModalElement);

        if(editModal){
            editModal.hide();
        }
    });

    confirmCheckbox.addEventListener('change', function() {
        finalConfirmButton.disabled = !this.checked;
    });

    const successDailyModalEl = document.getElementById('success-modal');
    const successDailyMesageHeader = document.getElementById('success-msg-head');
    const successDailyMessage = document.getElementById('success-message');
    const closeSuccessDailyModalButton = document.getElementById('close-success-modal-button');

    finalConfirmButton.addEventListener('click', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        console.log(updatedActivityPayload);

        fetch('/daily-activity/update', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken 
            },
            body: JSON.stringify(updatedActivityPayload)
        })
        .then(response => response.json())
        .then(data => {
            if(data.result == 'success'){
                const confirmEditDaily = new Modal(confirmModalElement);
                const successDaily = new Modal(successDailyModalEl);

                if(confirmEditDaily && successDaily){
                    confirmEditDaily.hide();
                    successDailyMesageHeader.textContent = 'Day Activity Updated';
                    successDailyMessage.textContent = 'Scheduled activity for the chosen day has been updated';
                    successDaily.show();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    closeSuccessDailyModalButton.addEventListener('click', function(){
        window.location.reload();
    });

}