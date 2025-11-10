// ====================================================================
// GLOBAL DATA (from your example)
// ====================================================================

// Note: You can remove these lines if you are populating
// the dropdown with Blade, as we discussed.
const programFields = window.program.program_fields;
const programId = window.program.id;

console.log('Program Fields:', programFields);

// ====================================================================
// MODAL OPTIONS WITH FADE ANIMATIONS
// ====================================================================
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

// ====================================================================
// GET ELEMENTS
// ====================================================================

// --- Add Schedule Modal ---
const addScheduleModalEl = document.getElementById('add-schedule-modal');
const addScheduleForm = document.getElementById('add-schedule-form');
const addScheduleTitle = document.getElementById('add-schedule-title');
const addScheduleIntervals = document.getElementById('add-schedule-intervals');
const addSchedulePosition = document.getElementById('add-schedule-position');
const cancelAddScheduleBtn = document.getElementById('cancel-add-schedule');
const addScheduleSubmitBtn = document.getElementById('add-schedule-submit');
const addSchedBtn = document.getElementById('page-add-field-button'); // Main "Add" button on page

// --- Confirm Add Schedule Modal ---
const confirmAddScheduleModalEl = document.getElementById('confirm-add-schedule-modal');
const scheduleTitleToConfirm = document.getElementById('schedule-title-to-confirm');
const confirmScheduleCheckbox = document.getElementById('confirm-schedule-checkbox');
const confirmScheduleProceedBtn = document.getElementById('confirm-schedule-proceed-button');
const cancelAddScheduleConfirmBtn = document.getElementById('cancel-confirm-sched');

// --- Edit Schedule Modal ---
const editScheduleModalEl = document.getElementById('edit-schedule-modal');
const editScheduleForm = document.getElementById('edit-schedule-form');
const editScheduleIdInput = document.getElementById('edit-schedule-id'); // Hidden input
const editScheduleTitle = document.getElementById('edit-schedule-title');
const editScheduleIntervals = document.getElementById('edit-schedule-intervals');
const editSchedulePosition = document.getElementById('edit-schedule-position');
const cancelEditScheduleBtn = document.getElementById('cancel-edit-schedule');
const editScheduleSubmitBtn = document.getElementById('edit-schedule-submit');

// --- Confirm Edit Schedule Modal ---
const confirmEditScheduleModalEl = document.getElementById('confirm-edit-schedule-modal');
const editScheduleTitleToConfirm = document.getElementById('edit-schedule-title-to-confirm');
const confirmEditScheduleCheckbox = document.getElementById('confirm-edit-schedule-checkbox');
const confirmEditScheduleProceedBtn = document.getElementById('confirm-edit-schedule-proceed-button');
const cancelEditScheduleConfirmBtn = document.getElementById('cancel-confirm-edit-sched');

// --- Success Modal (as per your example structure) ---
const successModalEl = document.getElementById('success-modal');
const successMessageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

// ====================================================================
// CREATE MODAL INSTANCES
// ====================================================================
const addScheduleModal = new Modal(addScheduleModalEl, createModalOptions(addScheduleModalEl));
const confirmAddScheduleModal = new Modal(confirmAddScheduleModalEl, createModalOptions(confirmAddScheduleModalEl));
const editScheduleModal = new Modal(editScheduleModalEl, createModalOptions(editScheduleModalEl));
const confirmEditScheduleModal = new Modal(confirmEditScheduleModalEl, createModalOptions(confirmEditScheduleModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

// ====================================================================
// FORM VALIDATION
// ====================================================================

/**
 * Validates the ADD schedule form and enables/disables the submit button.
 * This checks that all fields are filled.
 */
function validateAddScheduleForm() {
    const title = addScheduleTitle.value.trim();
    const intervals = addScheduleIntervals.value.trim();
    const position = addSchedulePosition.value;

    if (title && intervals && position) {
        addScheduleSubmitBtn.disabled = false;
    } else {
        addScheduleSubmitBtn.disabled = true;
    }
}

/**
 * Validates the EDIT schedule form and enables/disables the submit button.
 * This checks that all fields are filled.
 */
function validateEditScheduleForm() {
    const title = editScheduleTitle.value.trim();
    const intervals = editScheduleIntervals.value.trim();
    const position = editSchedulePosition.value;

    if (title && intervals && position) {
        editScheduleSubmitBtn.disabled = false;
    } else {
        editScheduleSubmitBtn.disabled = true;
    }
}

// Add event listeners to check validation on input
addScheduleTitle.addEventListener('input', validateAddScheduleForm);
addScheduleIntervals.addEventListener('input', validateAddScheduleForm);
addSchedulePosition.addEventListener('change', validateAddScheduleForm);

editScheduleTitle.addEventListener('input', validateEditScheduleForm);
editScheduleIntervals.addEventListener('input', validateEditScheduleForm);
editSchedulePosition.addEventListener('change', validateEditScheduleForm);

// ====================================================================
// EVENT LISTENERS (ADD SCHEDULE)
// ====================================================================

addSchedBtn.addEventListener('click', function(){
    addScheduleForm.reset();
    validateAddScheduleForm(); 
    addScheduleModal.show();
});

cancelAddScheduleBtn.addEventListener('click', function(){
    addScheduleModal.hide();
    addScheduleForm.reset();
    validateAddScheduleForm();
});

addScheduleSubmitBtn.addEventListener('click', function(event){
    event.preventDefault(); // Prevent form from submitting normally
    
    // Pass title to confirmation modal
    scheduleTitleToConfirm.textContent = addScheduleTitle.value.trim();
    // Reset confirmation checkbox
    confirmScheduleCheckbox.checked = false;
    confirmScheduleProceedBtn.disabled = true;

    addScheduleModal.hide();
    confirmAddScheduleModal.show();
});

confirmScheduleCheckbox.addEventListener('change', function(){
    confirmScheduleProceedBtn.disabled = !this.checked;
});

cancelAddScheduleConfirmBtn.addEventListener('click', function(){
    confirmAddScheduleModal.hide();
    addScheduleModal.show(); // Go back to the add modal
});

// You would also have a listener for confirmScheduleProceedBtn
// to actually send the data to your backend (e.g., using fetch)

// ====================================================================
// EVENT LISTENERS (EDIT SCHEDULE)
// ====================================================================

/**
 * MASTER LISTENER for all 'Edit' buttons on the page.
 * Assumes your edit buttons have a class of '.edit-schedule-btn'
 * and a data attribute 'data-schedule-id' with the schedule's ID.
 * * Example Button HTML:
 * <button type="button" class="edit-schedule-btn" data-schedule-id="110">
 * Edit
 * </button>
 */
document.body.addEventListener('click', function(event) {
    const editBtn = event.target.closest('.edit-schedule-btn');
    if (editBtn) {
        const scheduleIdToEdit = editBtn.dataset.scheduleId;
        
        // 1. Find the schedule data from your global array
        const fieldToEdit = programFields.find(f => f.id == scheduleIdToEdit);
        if (!fieldToEdit) {
            console.error('Schedule not found:', scheduleIdToEdit);
            return;
        }

        // 2. Find the "position after" value
        // Sort fields by 'order' to ensure correct positioning
        const sortedFields = [...programFields].sort((a, b) => a.order - b.order);
        let positionValue = 'start'; // Default to "start"
        const currentIndex = sortedFields.findIndex(f => f.id == scheduleIdToEdit);
        
        if (currentIndex > 0) {
            positionValue = sortedFields[currentIndex - 1].id; // Get ID of the item it comes *after*
        }

        // 3. Dynamically filter the "Position After" dropdown
        // This hides the schedule you are currently editing from its own "Position After" list
        const positionOptions = editSchedulePosition.querySelectorAll('option');
        positionOptions.forEach(option => {
            // Show all options first (to reset from previous edits)
            option.style.display = 'block'; 
            // Hide the option that matches the schedule being edited
            if (option.value == scheduleIdToEdit) {
                option.style.display = 'none';
            }
        });

        // 4. Populate the edit form
        editScheduleIdInput.value = fieldToEdit.id;
        editScheduleTitle.value = fieldToEdit.title;
        editScheduleIntervals.value = fieldToEdit.interval_days;
        editSchedulePosition.value = positionValue; // Set the dropdown

        // 5. Validate form and show modal
        validateEditScheduleForm();
        editScheduleModal.show();
    }
});

// --- Listeners for the Edit Modal buttons ---

cancelEditScheduleBtn.addEventListener('click', function(){
    editScheduleModal.hide();
    editScheduleForm.reset(); // Don't need to reset, data will be repopulated
    validateEditScheduleForm();
});

editScheduleSubmitBtn.addEventListener('click', function(event){
    event.preventDefault(); // Prevent form from submitting normally
    
    // Pass title to confirmation modal
    editScheduleTitleToConfirm.textContent = editScheduleTitle.value.trim();
    // Reset confirmation checkbox
    confirmEditScheduleCheckbox.checked = false;
    confirmEditScheduleProceedBtn.disabled = true;

    editScheduleModal.hide();
    confirmEditScheduleModal.show();
});

confirmEditScheduleCheckbox.addEventListener('change', function(){
    confirmEditScheduleProceedBtn.disabled = !this.checked;
});

cancelEditScheduleConfirmBtn.addEventListener('click', function(){
    confirmEditScheduleModal.hide();
    editScheduleModal.show(); // Go back to the edit modal
});

confirmEditScheduleProceedBtn.addEventListener('click', function() {
    // Disable both buttons immediately
    confirmEditScheduleProceedBtn.disabled = true;
    cancelEditScheduleConfirmBtn.disabled = true;
    
    // Change button text to "Updating..."
    const originalText = confirmEditScheduleProceedBtn.textContent;
    confirmEditScheduleProceedBtn.textContent = 'Updating...';

    // Construct the payload from the EDIT form elements
    const payload = {
        schedule_id: editScheduleIdInput.value, // The ID of the schedule to update
        program_id: programId, // Assuming program_id is still relevant
        title: editScheduleTitle.value.trim(),
        interval: editScheduleIntervals.value.trim(),
        position: editSchedulePosition.value.trim(),
    };

    // Log for debugging
    console.log('Sending update payload:', payload);

    // Send via POST to your update route
    fetch('/mho/health-programs/schedule/update', {
        method: 'POST', // Or 'PUT'/'PATCH' if your route is set up for it
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
    })
    .then(response => {
        if (!response.ok) {
            // Handle HTTP errors (e.g., 404, 500)
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        // Update success modal text for "Edit"
        successMessageHeader.textContent = "Update Schedule";
        successMessage.textContent = data.message;
        
        // Hide the EDIT confirm modal
        confirmEditScheduleModal.hide();
        successModal.show();

        // IMPORTANT: You'll likely need to reload the page or 
        // dynamically update the UI here to show the changes.
        // For simplicity, a reload is easiest:
        // location.reload(); 
    })
    .catch(error => {
        console.error('Error updating schedule:', error);
        
        // Re-enable buttons and restore text on error
        confirmEditScheduleProceedBtn.disabled = false;
        cancelEditScheduleConfirmBtn.disabled = false;
        confirmEditScheduleProceedBtn.textContent = originalText;

        // Optionally show an error modal
        alert('Failed to update schedule. Please try again.');
        window.location.reload();
    })
    .finally(() => {
        // This block runs whether the fetch succeeded or failed
        // Reset button state *unless* it's a success (where modal closes)
        // In the success case, we don't need to re-enable, but
        // in the error case, we do. The .catch() already handles the error case.
        // If we want to re-enable on success *after* success modal,
        // we'd handle it in the success modal's 'close' button.
    });
});