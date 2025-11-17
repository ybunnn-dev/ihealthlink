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


const removeActivityModalEl = document.getElementById('remove-activity-modal');

// The <strong> tag where the activity's name will be displayed.
const removeActivityName = document.getElementById('remove-activity-name');

// The checkbox the user must check to enable the remove button.
const removeActivityCheckbox = document.getElementById('remove-activity-checkbox');

// The main "Remove Activity" button.
const removeActivityBtn = document.getElementById('remove-activity-btn');

// The "Cancel" button.
const cancelRemoveActivityBtn = document.getElementById('cancel-remove-activity');

const removeActivityModal = new Modal(removeActivityModalEl, createModalOptions(removeActivityModalEl));
let scheduleToRemove = null;

export function handleDeleteSchedule(scheduleId) {
    const schedule = window.scheds.find(s => s.id == scheduleId);
    if (schedule) {
        console.log("Delete clicked:", schedule);

        scheduleToRemove = schedule;
        removeActivityName.textContent = schedule.activity;
        removeActivityModal.show();
    }
}

removeActivityCheckbox .addEventListener('change', function(){
    removeActivityBtn.disabled = !this.checked;
});

cancelRemoveActivityBtn.addEventListener('click', function(){
    scheduleToRemove = null;
    removeActivityModal.hide();
});

const successSchedModalEl = document.getElementById('success-modal');
const successSchedMesageHeader = document.getElementById('success-msg-head');
const successSchedMessage = document.getElementById('success-message');
const closeSuccessSchedModalButton = document.getElementById('close-success-modal-button');
const successSchedModal = new Modal(successSchedModalEl, createModalOptions(successSchedModalEl));

removeActivityBtn.addEventListener('click', function() {
    if (!scheduleToRemove) return;

    const scheduleId = scheduleToRemove.id;

    fetch(`/barangay/schedule/delete/${scheduleId}`, {
        method: 'PUT', // or POST depending on your route
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({}) // no extra data needed for soft delete
    })
    .then(response => response.json())
    .then(data => {
        console.log("Soft delete response:", data);

        // Optionally remove the schedule from the UI or mark it inactive
        removeActivityModal.hide();
        if(data.success){
            successSchedMesageHeader.textContent = "Schedule Removed";
            successSchedMessage.textContent = "Schedule has been successfully removed";
            successSchedModal.show();
        }
    })
    .catch(error => {
        console.error("Error deleting schedule:", error);
    });
});

closeSuccessSchedModalButton.addEventListener('click', function(){
    window.location.reload();
});