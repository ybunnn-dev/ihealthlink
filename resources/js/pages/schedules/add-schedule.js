// --- Modal Elements ---
const addActivityModalEl = document.getElementById('add-activity-modal');
const selectProgramModalEl = document.getElementById('select-program-modal');
const selectBhwModalEl = document.getElementById('select-bhw-modal');
const confirmAddSchedulModalEl = document.getElementById('confirm-add-schedule-modal');


// --- INITIALIZE MODAL OBJECTS ONCE ---
const addActivityModal = new Modal(addActivityModalEl);
const selectProgramModal = new Modal(selectProgramModalEl);
const selectBhwModal = new Modal(selectBhwModalEl); 
const confirmAddSchedulModal = new Modal(confirmAddSchedulModalEl);

// --- Buttons ---
const addActivityBtn = document.getElementById('add-activity-btn');
const healthProgramButton = document.getElementById('healthProgramButton');
const cancelActivityBtn = document.getElementById('cancel-activity-btn');
const proceedBtn = document.getElementById('proceed-btn');

const scheduleActivityEl = document.getElementById('schedule-activity-to-confirm');
const scheduleDateEl = document.getElementById('schedule-date-to-confirm');
const scheduleTimeEl = document.getElementById('schedule-time-to-confirm');
const scheduleVenueEl = document.getElementById('schedule-venue-to-confirm');

const confirmScheduleCheckbox = document.getElementById('confirm-schedule-checkbox');
const confirmAddScheduleBtn = document.getElementById('confirm-add-schedule-btn');
const cancelConfirmAddScheduleBtn = document.getElementById('cancel-confirm-add-schedule');

const bhwButton = document.getElementById('bhwButton');
const hideHealthProgramBtn = document.getElementById('hide-hp');
const bhwListContainer = document.getElementById('bhw-list-container');
const bhwRadioButtons = document.querySelectorAll('input[name="assigned_bhw"]');

// --- BHW Action Buttons ---
const cancelBhwSelectionBtn = document.getElementById('cancel-bhw-selection');
const proceedWithBhwBtn = document.getElementById('proceed-with-bhw');

// --- Health Program Modal Elements ---
const programChoiceBtns = document.querySelectorAll('.program-choice-btn');

// --- Add Activity Form Inputs ---
const activityNameInput = document.getElementById('activityNameInput');
const activityDateInput = document.getElementById('activityDate');
const activityTimeInput = document.getElementById('activityTime');
const activityVenueInput = document.getElementById('activityVenue');
const addActivitySubmitBtn = document.getElementById('add-activity-submit-btn');

let bhwsAssigned = [];

let selectedProgramId = null; // Variable to store the selected program ID
let selectedProgramName = null;
const programListContainer = document.getElementById('program-list-container');


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


function populateProgramModal(programs, currentSelectedId = null) {
    // 1. Clear any old static buttons
    programListContainer.innerHTML = '';

    // 2. Handle case where no programs are found
    if (programs.length === 0) {
        programListContainer.innerHTML = '<p class="text-center text-gray-500">No health programs found.</p>';
        return;
    }

    // 3. Loop through the data and create a button for each program
    programs.forEach(program => {
        // Check if this program is the currently selected one
        const isSelected = program.id.toString() === currentSelectedId;
        const selectedClasses = isSelected ? 'bg-blue-50 border-mainblue' : 'bg-gray-50 border-gray-200';

        const programButtonHtml = `
            <button 
                type="button" 
                class="program-choice-btn w-full p-4 text-left rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-mainblue ${selectedClasses}" 
                data-program-id="${program.id}"
                data-program-name="${program.name}">
                <span class="text-sm font-medium text-gray-900">${program.name}</span>
            </button>
        `;
        programListContainer.insertAdjacentHTML('beforeend', programButtonHtml);
    });
}
// --- FETCH and POPULATE the MODAL ---
healthProgramButton.addEventListener('click', function() {
    fetch('/barangay/fetch/health-programs')
        .then(response => response.json())
        .then(data => {
            if (data.success && Array.isArray(data.data)) {
                // Call our new function to build the buttons
                populateProgramModal(data.data, selectedProgramId);
            }
            
            addActivityModal.hide();
            selectProgramModal.show();
        })
        .catch(error => {
            console.error("Error fetching health programs:", error);
        });
});

programListContainer.addEventListener('click', (event) => {
    // Find the button that was clicked on, even if the user clicked the <span> inside it
    const clickedButton = event.target.closest('.program-choice-btn');

    // If a button was not clicked, do nothing
    if (!clickedButton) {
        return;
    }

    // Get all buttons currently in the container
    const allButtons = programListContainer.querySelectorAll('.program-choice-btn');

    // Remove 'selected' style from all buttons
    allButtons.forEach(btn => {
        btn.classList.remove('bg-blue-50', 'border-mainblue');
        btn.classList.add('bg-gray-50', 'border-gray-200');
    });

    // Add 'selected' style to the one that was clicked
    clickedButton.classList.add('bg-blue-50', 'border-mainblue');
    
    // Store the selected program's data
    selectedProgramId = clickedButton.dataset.programId;
    selectedProgramName = clickedButton.dataset.programName;
});

// The "Proceed" button listener can stay the same
proceedBtn.addEventListener('click', () => {
    if (selectedProgramId) {
        console.log("Proceeding with Health Program ID:", selectedProgramId);
        console.log("Proceeding with Health Program Name:", selectedProgramName);
        
        // Your logic here...
        healthProgramButton.textContent = selectedProgramName; // Update the main form button text
        selectProgramModal.hide();
        addActivityModal.show();

    } else {
        alert("Please select a health program to proceed.");
    }
});

// **NEW** Add this listener for your main button
addActivityBtn.addEventListener('click', function() {
    addActivityModal.show();
});

// Listener for the cancel button inside the "Add Activity" modal
cancelActivityBtn.addEventListener('click', function() {
    addActivityModal.hide();
});

// Listener to open the "Select Program" modal
healthProgramButton.addEventListener('click', function() {
    fetch('/barangay/fetch/health-programs')
        .then(response => response.json())
        .then(data => {
            console.log("Health Programs:", data);

            // Hide the "Add Activity" modal
            addActivityModal.hide();

            // Show the "Select Program" modal
            selectProgramModal.show();
        })
        .catch(error => {
            console.error("Error fetching health programs:", error);
        });
});

hideHealthProgramBtn.addEventListener('click', function(){
    selectedProgramId =  null;
    healthProgramButton.textContent = 'Select Health Program...'
    selectProgramModal.hide();
    addActivityModal.show();
});

// Listener for the "Proceed" button inside the "Select Program" modal
proceedBtn.addEventListener('click', function() {
    // Add your logic here for what happens when a program is chosen
    selectProgramModal.hide();
    addActivityModal.show(); // Re-opens the main modal
});


function populateBhwModal(container, allBhws, selectedBhws = []) { // Default to empty array
    container.innerHTML = '';
    selectedBhws = bhwsAssigned;
    if (allBhws.length === 0) {
        container.innerHTML = '<p class="text-center text-gray-500">No BHWs found.</p>';
        return;
    }

    // 💡 Create a Set of selected IDs for a super-fast lookup.
    const selectedBhwIds = new Set(selectedBhws.map(bhw => bhw.id));

    allBhws.forEach(bhw => {
        // Check if the current BHW's ID is in our Set of selected IDs.
        const isChecked = selectedBhwIds.has(bhw.id.toString()) ? 'checked' : '';
        
        const bhwCardHtml = `
            <label for="bhw-${bhw.id}" class="flex items-center w-full p-4 text-left bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 has-[:checked]:bg-blue-50 has-[:checked]:border-mainblue">
                <input 
                    id="bhw-${bhw.id}" 
                    name="assigned_bhws" 
                    type="checkbox" 
                    value="${bhw.id}" 
                    data-name="${bhw.name}" 
                    class="w-5 h-5 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue focus:ring-2"
                    ${isChecked}> 
                <span class="ms-3 text-sm font-medium text-gray-900">${bhw.name}</span>
            </label>
        `;
        container.insertAdjacentHTML('beforeend', bhwCardHtml);
    });
}

bhwButton.addEventListener('click', function () {
    fetch('/barangay/get-bhws')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && Array.isArray(data.data)) {
                // ✅ Success! Call the helper function to populate the modal
                populateBhwModal(bhwListContainer, data.data);
                console.log(data);
                // Now show the modal
                addActivityModal.hide();
                selectBhwModal.show();

            } else {
                alert(data.message || "Failed to load BHWs: Invalid data format");
            }
        })
        .catch(error => {
            console.error("Error fetching BHWs:", error);
            // Also update the UI to show an error
            bhwListContainer.innerHTML = '<p class="text-center text-red-500">Could not load BHWs. Please try again.</p>';
            addActivityModal.hide();
            selectBhwModal.show();
        });
});

cancelBhwSelectionBtn.addEventListener('click', function(){
    selectBhwModal.hide();
    addActivityModal.show();
});

proceedWithBhwBtn.addEventListener('click', function() {
    const checkedCheckboxes = document.querySelectorAll('#bhw-list-container input[name="assigned_bhws"]:checked');

    const selectedBhwData = Array.from(checkedCheckboxes).map(checkbox => {
        return {
            id: checkbox.value,
            name: checkbox.dataset.name
        };
    });

    if (selectedBhwData.length > 0) {
        console.log('Chosen BHWs:', selectedBhwData);

        // --- START: Logic to update the button text ---

        // 1. Get an array of just the full names.
        const names = selectedBhwData.map(bhw => bhw.name);
        
        // 2. Join the names into a single string.
        let buttonText = names.join(', ');

        // 3. Initially, set the button's text to the full string.
        bhwButton.textContent = buttonText;

        // 4. Check if the text overflows the button's visible area.
        if (bhwButton.scrollWidth > bhwButton.clientWidth) {
            // Shorten the text until it fits
            while (bhwButton.scrollWidth > bhwButton.clientWidth && names.length > 0) {
                names.pop(); // Remove the last name from the array
                bhwButton.textContent = names.join(', ') + '...';
            }
        }
        
        // --- END: Logic to update the button text ---

        // Store the complete data in your variable for later use
        bhwsAssigned = selectedBhwData;
        
        // Hide the current modal and show the previous one
        selectBhwModal.hide();
        addActivityModal.show();

    } else {
        console.log('No BHWs were chosen.');
        // If nothing is chosen, you might want to reset the button text
        bhwButton.textContent = 'Select BHW...';
        bhwsAssigned = []; // Clear the variable

        selectBhwModal.hide();
        addActivityModal.show();
    }
});

addActivitySubmitBtn.addEventListener('click', function(){
    event.preventDefault(); 

    scheduleActivityEl.textContent = activityNameInput.value;
    scheduleDateEl.textContent = activityDateInput.value;
    scheduleTimeEl.textContent = activityTimeInput.value;
    scheduleVenueEl.textContent = activityVenueInput.value;

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
    const addSchedPayload = {
        activity: activityNameInput.value.trim(),
        date: activityDateInput.value.trim(),
        time: activityTimeInput.value.trim(), // changed to correct input
        venue: activityVenueInput.value.trim(),
        health_program_id: selectedProgramId,
        bhws: bhwsAssigned,
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
    })
    .catch(err => {
        console.error("Error sending schedule:", err);
    });
});

validateAddActivityForms();