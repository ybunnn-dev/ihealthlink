// Main Modal Element
const addHealthProgramModalEl = document.getElementById('add-health-program-modal');

// --- Left Column Elements ---

// Input Fields
const programNameInput = document.getElementById('program-name');
const minAgeInput = document.getElementById('min-age');
const maxAgeInput = document.getElementById('max-age');

// Select (Dropdown) Fields
const programTypeSelect = document.getElementById('program-type');
const programModeSelect = document.getElementById('program-mode');

// --- Conditional Section for 'Continuous' Mode ---
const scheduleTypeSelect = document.getElementById('schedule-type');
const customIntervalInput = document.getElementById('custom-interval');
// You might also want the container for the custom interval to hide/show it
const customIntervalContainer = customIntervalInput.parentElement;


// --- Right Column Elements (for 'Fixed' Mode) ---

// You'll need the whole column container to hide/show it based on Program Mode
const fixedModeContainer = document.querySelector('.md\\:grid-cols-2 > .space-y-4:last-child');

// Input Fields
const scheduleNameInput = document.getElementById('schedule-name');
const scheduleIntervalInput = document.getElementById('schedule-interval');

// Button
const addScheduleBtn = fixedModeContainer.querySelector('button');

// Display Area
const scheduleDisplayArea = fixedModeContainer.querySelector('.border-dashed');


// --- Modal Footer Buttons ---
const cancelBtn = document.getElementById('cancel-add-health-program');
const submitBtn = document.getElementById('add-health-program-submit');

const openAddHpButton = document.getElementById('page-add-healthProgram-button');

const addHealthProgramModal = new Modal(addHealthProgramModalEl);

openAddHpButton.addEventListener('click', function(){
    addHealthProgramModal.show();
});

cancelBtn.addEventListener('click', function(){
    addHealthProgramModal.hide();
});