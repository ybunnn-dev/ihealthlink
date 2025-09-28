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

let fixedScheds = [];

const trashIcon = `<svg class="w-4 h-4 text-red1 hover:text-red-500 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>`;

const addHealthProgramModal = new Modal(addHealthProgramModalEl);

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
    if (selectedMode === 'continuous') {
        scheduleTypeSelect.disabled = false;
        scheduleNameInput.disabled = true;
        scheduleNameInput.value = null;
        scheduleIntervalInput.disabled = true;
        scheduleIntervalInput.value = null;

    } else if (selectedMode === 'fixed') {
        // show fixed-related inputs
        scheduleTypeSelect.disabled = true;
        customIntervalInput.disabled = true
        scheduleTypeSelect.value = 'reset';
        customIntervalInput.value = null;

        scheduleNameInput.disabled = false;
        scheduleIntervalInput.value = 0;

        console.log('vakla');
    }
});

scheduleTypeSelect.addEventListener('change', function(){
     const selectSched = scheduleTypeSelect.value;

     if(selectSched === 'custom'){
       
     }else{
        
     }

     switch(selectSched){
        case 'weekly':
            customIntervalInput.disabled = true
            customIntervalInput.value = 7;
            break;
        case 'monthly':
            customIntervalInput.disabled = true
            customIntervalInput.value = 30;
            break;
        case 'annually':
            customIntervalInput.disabled = true
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

clearSchedBtn.addEventListener('click', function(){
    console.log('nigga');
});


function checkCustomFields() {
    // Get the trimmed values from the input fields.
    const nameValue = scheduleNameInput.value.trim();
    const intervalValue = scheduleIntervalInput.value.trim();

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
                    <p class="text-sm text-gray-500 dark:text-gray-400">${sched.intervalDays} Days Interval</p>
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
        sched.position = index + 1; // Assign new position based on array order (1, 2, 3...)
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
});

checkCustomFields();
