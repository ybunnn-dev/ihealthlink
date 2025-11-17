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

const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};
// --- INITIALIZE MODAL OBJECTS ONCE ---
const addActivityModal = new Modal(addActivityModalEl, modalOptions);
const confirmAddSchedulModal = new Modal(confirmAddSchedulModalEl, modalOptions);

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



const successSchedModalEl = document.getElementById('success-modal');
const successSchedMesageHeader = document.getElementById('success-msg-head');
const successSchedMessage = document.getElementById('success-message');
const closeSuccessSchedModalButton = document.getElementById('close-success-modal-button');

const successSchedModal = new Modal(successSchedModalEl);

confirmAddScheduleBtn.addEventListener('click', function() {
    const addSchedPayload = {
        activity: activityNameInput.value.trim(),
        date: activityDateInput.value.trim(),
        time: activityTimeInput.value.trim(), // changed to correct input
        venue: activityVenueInput.value.trim(),
    };

    console.log("Sending payload:", addSchedPayload);

    fetch('/barangay/add-sched', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Laravel CSRF
        },
        body: JSON.stringify(addSchedPayload)
    })
    .then(res => res.json())
    .then(data => {
        console.log("Response from backend:", data);
        if(data.result == 'success'){
            alert('Scheduled activity has been successfully added.');
            window.location.reload();
        }
    })
    .catch(err => {
        console.error("Error sending schedule:", err);
    });
});
validateAddActivityForms();