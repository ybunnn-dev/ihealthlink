// --- Modal Elements ---
const addActivityModalEl = document.getElementById('add-activity-modal');
const confirmAddSchedulModalEl = document.getElementById('confirm-add-schedule-modal');

// The entire modal container, used to show or hide it.
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

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

// --- INITIALIZE MODAL OBJECTS ONCE ---
const addActivityModal = new Modal(addActivityModalEl, createModalOptions(addActivityModalEl));
const confirmAddSchedulModal = new Modal(confirmAddSchedulModalEl, createModalOptions(confirmAddSchedulModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));


// --- Buttons ---
const addActivityBtn = document.getElementById('add-activity-btn');
const cancelActivityBtn = document.getElementById('cancel-activity-btn');
const proceedBtn = document.getElementById('proceed-btn');

const scheduleActivityEl = document.getElementById('schedule-activity-to-confirm');
const scheduleDateEl = document.getElementById('schedule-date-to-confirm');
const scheduleTimeEl = document.getElementById('schedule-time-to-confirm');
const scheduleVenueEl = document.getElementById('schedule-venue-to-confirm');

const confirmScheduleCheckbox = document.getElementById('confirm-schedule-checkbox');
const confirmAddScheduleBtn = document.getElementById('confirm-add-schedule-btn');
const cancelConfirmAddScheduleBtn = document.getElementById('cancel-confirm-add-schedule');


// --- Add Activity Form Inputs ---
const activityNameInput = document.getElementById('activityNameInput');
const activityDateInput = document.getElementById('activityDate');
const activityTimeInput = document.getElementById('activityTime');
const activityVenueInput = document.getElementById('activityVenue');
const addActivitySubmitBtn = document.getElementById('add-activity-submit-btn');



const requiredInputs = [
    activityNameInput, 
    activityDateInput, 
    activityTimeInput, 
    activityVenueInput
];

function validateAddActivityForms() {
    // This console.log should now appear when you type
    console.log('Validation function is running...');
    
    const isFormValid = requiredInputs.every(input => input.value.trim() !== '');
    addActivitySubmitBtn.disabled = !isFormValid;
}

// --- 4. Attach event listeners ---
requiredInputs.forEach(input => {
    // Using 'input' is great for text, but 'change' is sometimes more reliable for date/time pickers
    input.addEventListener('input', validateAddActivityForms);
    input.addEventListener('change', validateAddActivityForms); 
});


// **NEW** Add this listener for your main button
addActivityBtn.addEventListener('click', function() {
    addActivityModal.show();
});

// Listener for the cancel button inside the "Add Activity" modal
cancelActivityBtn.addEventListener('click', function() {
    addActivityModal.hide();
});


addActivitySubmitBtn.addEventListener('click', function(){
    event.preventDefault(); 

    addActivityModal.hide();
    confirmAddSchedulModal.show();
});

confirmScheduleCheckbox.addEventListener('change', function() {
    // The button is enabled only if the checkbox is checked
    confirmAddScheduleBtn.disabled = !this.checked;
});

cancelConfirmAddScheduleBtn.addEventListener('click', function(){
    confirmAddSchedulModal.hide();
    addActivityModal.show();
});

confirmAddScheduleBtn.addEventListener('click', function() {
    // Store original button text
    const originalButtonText = confirmAddScheduleBtn.textContent;
    
    // Disable both buttons and change confirm button text
    confirmAddScheduleBtn.disabled = true;
    cancelConfirmAddScheduleBtn.disabled = true;
    confirmAddScheduleBtn.textContent = 'Saving...';
    
    const addSchedPayload = {
        activity: activityNameInput.value.trim(),
        date: activityDateInput.value.trim(),
        time: activityTimeInput.value.trim(),
        venue: activityVenueInput.value.trim(),
    };

    console.log("Sending payload:", addSchedPayload);

    fetch('/barangay/add-sched', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(addSchedPayload)
    })
    .then(res => res.json())
    .then(data => {
        console.log("Response from backend:", data);
        
        if(data.result == 'success'){
            // Hide the confirmation modal
            confirmAddSchedulModal.hide();
            
            // Update success modal content
            successMesageHeader.textContent = 'Success!';
            successMessage.textContent = 'Scheduled activity has been successfully added.';
            
            // Show the success modal
            successModal.show();
            
            // Reload after closing success modal
            closeSuccessModalButton.addEventListener('click', function() {
                successModal.hide();
                window.location.reload();
            }, { once: true });
        } else {
            // Handle error case
            confirmAddSchedulModal.hide();
            successMesageHeader.textContent = 'Error!';
            successMessage.textContent = data.message || 'Something went wrong. Please try again.';
            successModal.show();
        }
    })
    .catch(err => {
        console.error("Error sending schedule:", err);
        
        // Show error in success modal
        confirmAddSchedulModal.hide();
        successMesageHeader.textContent = 'Error!';
        successMessage.textContent = 'Failed to add schedule. Please check your connection.';
        successModal.show();
    })
    .finally(() => {
        // Re-enable buttons and restore text regardless of success or error
        confirmAddScheduleBtn.disabled = false;
        cancelConfirmAddScheduleBtn.disabled = false;
        confirmAddScheduleBtn.textContent = originalButtonText;
    });
});

// Close success modal button handler
closeSuccessModalButton.addEventListener('click', function() {
    successModal.hide();
});