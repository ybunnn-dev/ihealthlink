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

const editActivityModalEl = document.getElementById('edit-activity-modal');
const confirmEditScheduleModalEl = document.getElementById('confirm-edit-schedule-modal');
const confirmEditScheCheckbox = document.getElementById('confirm-edit-schedule-checkbox');
const cancelConfirmEditScheduleBtn = document.getElementById('cancel-confirm-edit-schedule');
const confirmEditScheduleBtn = document.getElementById('confirm-edit-schedule-btn');
const editActivityId = document.getElementById('editActivityId');
const editActivityNameInput = document.getElementById('editActivityNameInput');
const editActivityDate = document.getElementById('editActivityDate');
const editActivityTime = document.getElementById('editActivityTime');
const editActivityVenue = document.getElementById('editActivityVenue');



const cancelEditActivityBtn = document.getElementById('cancel-edit-activity-btn');
const editActivitySubmitBtn = document.getElementById('edit-activity-submit-btn');
const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

const successModal = new Modal(successModalEl, createModalOptions(successModalEl));
const editActivityModal = new Modal(editActivityModalEl, createModalOptions(editActivityModalEl));
const confirmEditModal = new Modal(confirmEditScheduleModalEl, createModalOptions(confirmEditScheduleModalEl));


let defPayload = null;

let passPayload = null;


export function handleEditSchedule(scheduleId) {
    editActivitySubmitBtn.disabled = true;

    const schedule = window.scheds.find(s => s.id == scheduleId);
    if (!schedule) return;

    // Reformat date: "2025-09-12" -> "09/12/2025"
    let formattedDate = "";
    if (schedule.date) {
        const [year, month, day] = schedule.date.split("-");
        formattedDate = `${month.padStart(2, "0")}/${day.padStart(2, "0")}/${year}`;
    }

    // Build payload
    defPayload = {
        activity_id: schedule.id,
        activity_name: schedule.activity,
        activity_date: formattedDate,
        activity_time: schedule.time,
        activity_venue: schedule.venue,
    };
    // Fill form inputs
    editActivityNameInput.value = defPayload.activity_name;
    editActivityDate.value      = defPayload.activity_date;
    editActivityTime.value      = defPayload.activity_time;
    editActivityVenue.value     = defPayload.activity_venue;
   
    editActivityModal.show();
}

function validateInputs() {
    // Get current, trimmed values from the form
    const currentActivity = editActivityNameInput.value.trim();
    const currentDate = editActivityDate.value.trim();
    const currentTime = editActivityTime.value.trim();
    const currentVenue = editActivityVenue.value.trim();

    // Condition 1: Check if all four required fields are filled
    const areFieldsFilled = currentActivity && currentDate && currentTime && currentVenue;

    // Condition 2: Check if at least one value has changed from the original
    const hasChanged = 
        currentActivity !== defPayload.activity_name ||
        currentDate     !== defPayload.activity_date ||
        currentTime     !== defPayload.activity_time ||
        currentVenue    !== defPayload.activity_venue;
    // Enable the button ONLY if both conditions are true. Otherwise, disable it.
    editActivitySubmitBtn.disabled = !(areFieldsFilled && hasChanged);
}

editActivityNameInput.addEventListener('input', validateInputs);
editActivityDate.addEventListener('input', validateInputs);
editActivityTime.addEventListener('input', validateInputs);
editActivityVenue.addEventListener('input', validateInputs);


cancelEditActivityBtn.addEventListener('click', function(){
    defPayload = null;
    editActivityModal.hide();
});

editActivitySubmitBtn.addEventListener('click', function(){
    event.preventDefault();

    passPayload = {
        id: defPayload.activity_id,
        activity: editActivityNameInput.value.trim(),
        date: editActivityDate.value.trim(),
        time: editActivityTime.value.trim(),
        venue: editActivityVenue.value.trim(),
    }

    console.log("Payload to send:", passPayload);

    editActivityModal.hide();
    confirmEditModal.show();
});

cancelConfirmEditScheduleBtn.addEventListener('click', function(){
    confirmEditModal.hide();
    editActivityModal.show();
});

confirmEditScheCheckbox.addEventListener('change', function(){
    confirmEditScheduleBtn.disabled = !this.checked;
});


confirmEditScheduleBtn.addEventListener('click', function() {
    const url = `/barangay/schedule/edit/${passPayload.id}`;

    // Disable buttons
    confirmEditScheduleBtn.disabled = true;
    cancelConfirmEditScheduleBtn.disabled = true;

    // Change confirm button text
    const originalText = confirmEditScheduleBtn.textContent;
    confirmEditScheduleBtn.textContent = 'Saving...';

    fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(passPayload)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Controller response:", data);
        
        if(data.success){
            confirmEditModal.hide();
            
            successMesageHeader.textContent = 'Success!';
            successMessage.textContent = 'Schedule has been successfully updated.';
            successModal.show();

            closeSuccessModalButton.addEventListener('click', function() {
                successModal.hide();
                window.location.reload();
            }, { once: true });
        } else {
            confirmEditModal.hide();
            successMesageHeader.textContent = 'Error!';
            successMessage.textContent = data.message || 'Failed to update schedule.';
            successModal.show();
        }
    })
    .catch(error => {
        console.error("Error sending update request:", error);
        
        confirmEditModal.hide();
        successMesageHeader.textContent = 'Error!';
        successMessage.textContent = 'Failed to update schedule. Please check your connection.';
        successModal.show();
    })
    .finally(() => {
        // Re-enable buttons & restore text if needed
        confirmEditScheduleBtn.disabled = false;
        cancelConfirmEditScheduleBtn.disabled = false;
        confirmEditScheduleBtn.textContent = originalText;
    });
});