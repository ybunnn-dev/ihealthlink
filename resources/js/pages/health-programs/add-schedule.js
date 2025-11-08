// ====================================================================
// MODAL OPTIONS WITH FADE ANIMATIONS
// ====================================================================

// Note: You can remove these lines if you are populating
// the dropdown with Blade, as we discussed.
const programFields = window.program.program_fields;
const programId = window.program.id;

console.log(programFields);

const createModalOptions = (modalEl) => ({
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            modalEl.classList.remove('opacity-0');
            modalEl.classList.add('opacity-100');
            
            // Handle dark mode modal content
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
        
        // Handle dark mode modal content
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

// --- Confirm Add Schedule Modal ---
const confirmAddScheduleModalEl = document.getElementById('confirm-add-schedule-modal');
const scheduleTitleToConfirm = document.getElementById('schedule-title-to-confirm');
const confirmScheduleCheckbox = document.getElementById('confirm-schedule-checkbox');
const confirmScheduleProceedBtn = document.getElementById('confirm-schedule-proceed-button');
const cancelAddScheduleConfirmBtn = document.getElementById('cancel-confirm-sched');

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
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

const addSchedBtn = document.getElementById('page-add-field-button');

// ====================================================================
// FORM VALIDATION
// ====================================================================

/**
 * Validates the add schedule form and enables/disables the submit button.
 */
function validateAddScheduleForm() {
    const title = addScheduleTitle.value.trim();
    const intervals = addScheduleIntervals.value.trim();
    const position = addSchedulePosition.value; // No trim needed for select

    if (title && intervals && position) {
        addScheduleSubmitBtn.disabled = false;
    } else {
        addScheduleSubmitBtn.disabled = true;
    }
}

// Add event listeners to check validation on input
addScheduleTitle.addEventListener('input', validateAddScheduleForm);
addScheduleIntervals.addEventListener('input', validateAddScheduleForm);
addSchedulePosition.addEventListener('change', validateAddScheduleForm);

// ====================================================================
// EVENT LISTENERS
// ====================================================================

addSchedBtn.addEventListener('click', function(){
    // Reset the form and validation state every time the modal is opened
    addScheduleForm.reset();
    validateAddScheduleForm(); 
    addScheduleModal.show();
});

cancelAddScheduleBtn.addEventListener('click', function(){
    addScheduleModal.hide();
    // Also reset form and validation on cancel
    addScheduleForm.reset();
    validateAddScheduleForm();
});

addScheduleSubmitBtn.addEventListener('click', function(){
    event.preventDefault();

    addScheduleModal.hide();
    confirmAddScheduleModal.show();
});

confirmScheduleCheckbox.addEventListener('change', function(){
    confirmScheduleProceedBtn.disabled = !this.checked;
});

cancelAddScheduleConfirmBtn.addEventListener('click', function(){
    confirmAddScheduleModal.hide();
    addScheduleModal.show();
});

confirmScheduleProceedBtn.addEventListener('click', function() {
    // Disable both buttons immediately
    confirmScheduleProceedBtn.disabled = true;
    cancelAddScheduleConfirmBtn.disabled = true;
    
    // Change button text to "Saving..."
    const originalText = confirmScheduleProceedBtn.textContent;
    confirmScheduleProceedBtn.textContent = 'Saving...';

    const payload = {
        program_id: programId,
        title: addScheduleTitle.value.trim(),
        interval: addScheduleIntervals.value.trim(),
        position: addSchedulePosition.value.trim(),
    };

    // Log for debugging
    console.log('Sending payload:', payload);

    // Send via POST to your controller route
    fetch('/mho/health-program/schedule/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        successMessageHeader.textContent = "Add Schedule";
        successMessage.textContent = data.message;
        confirmAddScheduleModal.hide();
        successModal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Re-enable buttons and restore text on error
        confirmScheduleProceedBtn.disabled = false;
        cancelAddScheduleConfirmBtn.disabled = false;
        confirmScheduleProceedBtn.textContent = originalText;
    });
});