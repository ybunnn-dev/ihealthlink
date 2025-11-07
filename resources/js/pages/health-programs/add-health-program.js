// Main Modal Element
const addHealthProgramModalEl = document.getElementById('add-health-program-modal');
const programNameInput = document.getElementById('program-name');
const minAgeInput = document.getElementById('min-age');
const maxAgeInput = document.getElementById('max-age');
const programTypeSelect = document.getElementById('program-type');
const programModeSelect = document.getElementById('program-mode');
const scheduleTypeSelect = document.getElementById('schedule-type');
const customIntervalInput = document.getElementById('custom-interval');
const customIntervalContainer = customIntervalInput.parentElement;
const fixedModeContainer = document.querySelector('.md\\:grid-cols-2 > .space-y-4:last-child');
const scheduleNameInput = document.getElementById('schedule-name');
const scheduleIntervalInput = document.getElementById('schedule-interval');
const addScheduleBtn = document.getElementById('add-sched-btn');
const scheduleDisplayArea = fixedModeContainer.querySelector('.border-dashed');
const clearSchedBtn = document.getElementById('clear-sched');
const cancelBtn = document.getElementById('cancel-add-health-program');
const submitBtn = document.getElementById('add-health-program-submit');
const openAddHpButton = document.getElementById('page-add-healthProgram-button');
const fieldNum = document.getElementById('number-of-fields');
// --- Modal & Containers ---
const confirmProgramModalEl = document.getElementById('confirm-add-program-modal');
const programInfoReviewDiv = document.getElementById('program-info-review');
const reviewScheduleDetailsDiv = document.getElementById('review-schedule-details');
const reviewProgramNameSpan = document.getElementById('review-program-name');
const reviewAgeRangeSpan = document.getElementById('review-age-range');
const reviewProgramTypeSpan = document.getElementById('review-program-type');
const reviewProgramModeSpan = document.getElementById('review-program-mode');
const confirmProgramCheckbox = document.getElementById('confirm-program-checkbox');
const cancelAddProgramBtn = document.getElementById('cancel-add-program-confirm');
const confirmProgramProceedBtn = document.getElementById('confirm-program-proceed-button');

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

let createdProgramId = null;
let fixedScheds = [];
let finalPayload = [];

const trashIcon = `<svg class="w-4 h-4 text-red1 hover:text-red-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>`;

// ====================================================================
// MODAL OPTIONS WITH FADE ANIMATIONS
// ====================================================================
const addHealthProgramModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            addHealthProgramModalEl.classList.remove('opacity-0');
            addHealthProgramModalEl.classList.add('opacity-100');
            
            const modalContent = addHealthProgramModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        addHealthProgramModalEl.classList.add('opacity-0');
        addHealthProgramModalEl.classList.remove('opacity-100');
        
        const modalContent = addHealthProgramModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

const confirmHealthProgramModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            confirmProgramModalEl.classList.remove('opacity-0');
            confirmProgramModalEl.classList.add('opacity-100');
            
            const modalContent = confirmProgramModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        confirmProgramModalEl.classList.add('opacity-0');
        confirmProgramModalEl.classList.remove('opacity-100');
        
        const modalContent = confirmProgramModalEl.querySelector('.relative.bg-white');
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
// CREATE MODAL INSTANCES WITH OPTIONS
// ====================================================================
const addHealthProgramModal = new Modal(addHealthProgramModalEl, addHealthProgramModalOptions);
const confirmHealthProgramModal = new Modal(confirmProgramModalEl, confirmHealthProgramModalOptions);
const successModal = new Modal(successModalEl, successModalOptions);

function validateForm() {
    // --- Rule 1: Check baseline fields that are always required ---
    if (!programNameInput.value.trim() || !minAgeInput.value || !maxAgeInput.value || !programTypeSelect.value) {
        return false; // Invalid if any of the first four fields are empty
    }

    const mode = programModeSelect.value;
    
    // --- Rule 1 (cont.): Check that a mode has been selected ---
    if (!mode || mode === 'reset') {
        return false;
    }

    // --- Conditional Rules based on Program Mode ---
    switch (mode) {
        case 'fixed':
            // Rule 2: For 'fixed' mode, these fields must not be empty
            if (!scheduleTypeSelect.value || !fieldNum.value || !customIntervalInput.value) {
                return false;
            }
            break;

        case 'continuous':
            if (!scheduleTypeSelect.value || !customIntervalInput.value.trim()) {
                return false;
            }
            break;

        case 'custom':
            // Rule 4: For 'custom' mode, the schedule list cannot be empty
            if (fixedScheds.length === 0) {
                return false;
            }
            break;
            
        default:
             // If mode is somehow something else, consider it invalid
             return false;
    }

    // If all checks passed, the form is valid
    return true;
}


function handleFormChanges() {
    // The submit button is disabled if the form is NOT valid.
    submitBtn.disabled = !validateForm();
}

const fieldsToWatch = [
    programNameInput, minAgeInput, maxAgeInput, 
    fieldNum, customIntervalInput
];

// Listen for typing in text/number fields
fieldsToWatch.forEach(field => {
    field.addEventListener('input', handleFormChanges);
});

// Listen for changes in dropdowns
const selectsToWatch = [programTypeSelect, programModeSelect, scheduleTypeSelect];
selectsToWatch.forEach(select => {
    select.addEventListener('change', handleFormChanges);
});


openAddHpButton.addEventListener('click', function(){
    addHealthProgramModal.show();
});

cancelBtn.addEventListener('click', function(){
    addHealthProgramModal.hide();
});


programModeSelect.addEventListener('change', function () {
    const selectedMode = programModeSelect.value;
    console.log('Selected Program Mode:', selectedMode);

    // Example: toggle UI based on mode
    if (selectedMode === 'fixed') {
        scheduleTypeSelect.disabled = false;
        scheduleNameInput.disabled = true;
        scheduleNameInput.value = null;
        scheduleIntervalInput.disabled = true;
        scheduleIntervalInput.value = null;
        fieldNum.disabled = false;
    } 
    else if (selectedMode === 'continuous') {
        scheduleTypeSelect.disabled = false;
        scheduleNameInput.disabled = true;
        scheduleNameInput.value = null;
        scheduleIntervalInput.disabled = true;
        scheduleIntervalInput.value = null;
        fieldNum.disabled = true;
        fieldNum.value = null;

    } else if (selectedMode === 'custom') {
        // show fixed-related inputs
        scheduleTypeSelect.disabled = true;
        customIntervalInput.disabled = true
        scheduleTypeSelect.value = 'reset';
        customIntervalInput.value = null;
        scheduleNameInput.disabled = false;
        scheduleIntervalInput.value = 0;
        fieldNum.disabled = true;
        fieldNum.value = null; 
        customExtension.disabled = false;
    }
});

scheduleTypeSelect.addEventListener('change', function(){
     const selectSched = scheduleTypeSelect.value;

     if(selectSched === 'custom'){
       
     }else{
        
     }

     switch(selectSched){
        case 'weekly':
            customIntervalInput.disabled = true;
            customIntervalInput.value = 7;
            break;
        case 'monthly':
            customIntervalInput.disabled = true;
            customIntervalInput.value = 30;
            break;
        case 'annually':
            customIntervalInput.disabled = true;
            customIntervalInput.value = 365;
            break;
        case 'custom':
             customIntervalInput.disabled = false; 
             break;
        default:
            customIntervalInput.disabled = true
            customIntervalInput.value = null;
            break;
     }
});

function checkCustomFields() {
    // Get the trimmed values from the input fields.
    const nameValue = scheduleNameInput.value.trim();
    const intervalValue = scheduleIntervalInput.value.trim()
    
    addScheduleBtn.disabled = !(nameValue && intervalValue);
}

// --- Event Listeners ---
scheduleNameInput.addEventListener('input', checkCustomFields);
scheduleIntervalInput.addEventListener('input', checkCustomFields);

function updateScheduleSection() {
    scheduleDisplayArea.innerHTML = '';

    if (fixedScheds.length === 0) {
        // ... (your empty state code is fine)
        scheduleDisplayArea.innerHTML = `
            <div class="flex items-center justify-center h-full">
                <p class="text-gray-400">Added schedules will appear here</p>
            </div>
        `;
        return;
    }

    fixedScheds.forEach(sched => {
        const scheduleItemHTML = `
            <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-3 rounded-lg mb-2" data-position="${sched.position}">
                <div>
                    <p class="font-semibold text-gray-800 dark:text-white">${sched.schedTitle}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">${sched.intervalDays} Days Interval</p
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex flex-col">
                       <button type="button" class="delete-sched-btn"> ${trashIcon} </button>
                    </div>
                </div>
            </div>
        `;
        scheduleDisplayArea.innerHTML += scheduleItemHTML;
    });
}


clearSchedBtn.addEventListener('click', function(){
    event.preventDefault();
    fixedScheds = [];
    updateScheduleSection();

});


scheduleDisplayArea.addEventListener('click', function (event) {
    const deleteButton = event.target.closest('.delete-sched-btn');
    if (!deleteButton) {
        return;
    }
    
    const scheduleItem = deleteButton.closest('[data-position]');
    const positionToDelete = parseInt(scheduleItem.dataset.position, 10);

    // 1. Remove the item
    let filteredScheds = fixedScheds.filter(sched => sched.position !== positionToDelete);

    // 2. (Optional) Re-index the remaining items
    fixedScheds = filteredScheds.map((sched, index) => {
        sched.position = index + 1; 
        return sched;
    });

    // 3. Re-render the updated list
    updateScheduleSection();
});
// This function remains unchanged, as requested.
addScheduleBtn.addEventListener('click', function () {
    let currentPosition;
    if (fixedScheds.length === 0) {
        currentPosition = 1;
    } else {
        const lastSched = fixedScheds[fixedScheds.length - 1];
        currentPosition = lastSched.position + 1;
    }

    const fixedSched = {
        schedTitle: scheduleNameInput.value.trim(),
        intervalDays: parseInt(scheduleIntervalInput.value, 10) || 0,
        position: currentPosition,
    };
    
    scheduleNameInput.value = '';
    scheduleIntervalInput.value = '';
    
    scheduleIntervalInput.disabled = false;

    addScheduleBtn.disabled = true;

    fixedScheds.push(fixedSched);

    updateScheduleSection(); // Renders the list without the interval

    handleFormChanges(); // <-- ADD THIS LINE
});

function openConfirmationModal(payload) {
    // --- 1. Populate the static "Program Details" section ---
    reviewProgramNameSpan.textContent = payload.program_name;
    reviewAgeRangeSpan.textContent = `${payload.min_age} - ${payload.max_age}`;
    
    // Get the display text from the dropdowns, not just the value
    reviewProgramTypeSpan.textContent = programTypeSelect.options[programTypeSelect.selectedIndex].text;
    reviewProgramModeSpan.textContent = programModeSelect.options[programModeSelect.selectedIndex].text;

    // --- 2. Clear and dynamically populate the "Schedule Details" section ---
    reviewScheduleDetailsDiv.innerHTML = ''; // Clear previous content

    switch (payload.program_mode) {
        case 'fixed':
            reviewScheduleDetailsDiv.innerHTML = `
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-500 uppercase">Schedule Type</label>
                        <span class="text-base text-gray-800 font-medium">${scheduleTypeSelect.options[scheduleTypeSelect.selectedIndex].text}</span>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-500 uppercase">Number of Fields</label>
                        <span class="text-base text-gray-800 font-medium">${payload.field_num}</span>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-500 uppercase">Interval</label>
                        <span class="text-base text-gray-800 font-medium">${payload.interval} Days</span>
                    </div>
                </div>
            `;
            break;

        case 'continuous':
            reviewScheduleDetailsDiv.innerHTML = `
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-500 uppercase">Schedule Type</label>
                        <span class="text-base text-gray-800 font-medium">${scheduleTypeSelect.options[scheduleTypeSelect.selectedIndex].text}</span>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-xs font-semibold text-gray-500 uppercase">Interval</label>
                        <span class="text-base text-gray-800 font-medium">${payload.interval} Days</span>
                    </div>
                </div>
            `;
            break;

        case 'custom':
            // Build a list of the custom schedules
            let scheduleListHTML = '<ul class="list-disc pl-5 space-y-2">';
            payload.fixedSched.forEach(sched => {
                scheduleListHTML += `<li><span class="font-semibold">${sched.schedTitle}</span>: ${sched.intervalDays} Days Interval</li>`;
            });
            scheduleListHTML += '</ul>';
            
            reviewScheduleDetailsDiv.innerHTML = `
                <div class="flex flex-col">
                    <label class="text-xs font-semibold text-gray-500 uppercase">Custom Schedules (${payload.field_num} total)</label>
                    <div class="text-base text-gray-800 font-medium mt-1">${scheduleListHTML}</div>
                </div>
            `;
            break;
    }
    addHealthProgramModal.hide();
    confirmHealthProgramModal.show();

    finalPayload = payload;
}


cancelAddProgramBtn.addEventListener('click', function(){
    confirmHealthProgramModal.hide();
    addHealthProgramModal.show();
    finalPayload = [];
});

confirmProgramCheckbox.addEventListener('change', function(){
    confirmProgramProceedBtn.disabled = !this.checked;
});


submitBtn.addEventListener('click', function(){
    event.preventDefault();
    let payload = [];

    if(programModeSelect.value === 'fixed'){
        payload = {
            program_name: programNameInput.value.trim(),
            min_age: parseInt(minAgeInput.value, 10),
            max_age: parseInt(maxAgeInput.value, 10),
            program_type: programTypeSelect.value, 
            program_mode: programModeSelect.value,
            schedType: scheduleTypeSelect.value,
            field_num: parseInt(fieldNum.value, 10), 
            interval: parseInt(customIntervalInput.value, 10)
        }

    }
    else if(programModeSelect.value === 'continuous'){
        payload = {
            program_name: programNameInput.value.trim(),
            min_age: parseInt(minAgeInput.value, 10),
            max_age: parseInt(maxAgeInput.value, 10),
            program_type: programTypeSelect.value,
            program_mode: programModeSelect.value,
            schedType: scheduleTypeSelect.value,
            field_num: null,
            interval: parseInt(customIntervalInput.value),
        }
    }
    else if(programModeSelect.value === 'custom'){
        payload = {
            program_name: programNameInput.value.trim(),
            min_age: parseInt(minAgeInput.value, 10),
            max_age: parseInt(maxAgeInput.value, 10),
            program_type: programTypeSelect.value,
            program_mode: programModeSelect.value,
            field_num: fixedScheds.length,
            fixedSched: fixedScheds
        }
    }
    openConfirmationModal(payload);
});


// FINAL trigger to backend
confirmProgramProceedBtn.addEventListener('click', function(){
    console.log("Sending payload to backend:", finalPayload);

    fetch('/barangay/health-programs/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(finalPayload)
    })
    .then(res => res.json())
    .then(data => {
        console.log("Backend response:", data);
        if(data.response === 'success'){
             createdProgramId = data.id; 
            confirmHealthProgramModal.hide();
            successMesageHeader.textContent = "Health Program Added";
            successMessage.textContent = "You have successfully created " + finalPayload.program_name + ".";
            successModal.show();
        }
    })
    .catch(err => console.error(" Error:", err));
});

closeSuccessModalButton.addEventListener('click', function(){
    if (createdProgramId) {
        window.location.href = `/mho/health-programs/${createdProgramId}`;
    }
});
checkCustomFields();
handleFormChanges(); 