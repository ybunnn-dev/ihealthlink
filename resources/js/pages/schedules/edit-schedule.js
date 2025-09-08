const editActivityModalEl = document.getElementById('edit-activity-modal');
const editActivityForm = document.getElementById('edit-activity-form');
const confirmEditScheduleModalEl = document.getElementById('confirm-edit-schedule-modal');
const editScheduleActivityToConfirm = document.getElementById('edit-schedule-activity-to-confirm');
const editScheduleDateToConfirm = document.getElementById('edit-schedule-date-to-confirm');
const editScheduleTimeToConfirm = document.getElementById('edit-schedule-time-to-confirm');
const editScheduleVenueToConfirm = document.getElementById('edit-schedule-venue-to-confirm');
const confirmEditScheCheckbox = document.getElementById('confirm-edit-schedule-checkbox');
const cancelConfirmEditScheduleBtn = document.getElementById('cancel-confirm-edit-schedule');
const confirmEditScheduleBtn = document.getElementById('confirm-edit-schedule-btn');
const editActivityId = document.getElementById('editActivityId');
const editActivityNameInput = document.getElementById('editActivityNameInput');
const editActivityDate = document.getElementById('editActivityDate');
const editActivityTime = document.getElementById('editActivityTime');
const editActivityVenue = document.getElementById('editActivityVenue');
const proceedWithBhwBtn = document.getElementById('proceed-with-bhw');
const bhwListContainer = document.getElementById('bhw-list-container');
const editHealthProgramButton = document.getElementById('editHealthProgramButton');
const editHealthProgramId = document.getElementById('editHealthProgramId');
const editBhwButton = document.getElementById('editBhwButton');
const editAssignedBhwId = document.getElementById('editAssignedBhwId');
const bhwStorage = document.getElementById('bhw-storage');
const cancelEditActivityBtn = document.getElementById('cancel-edit-activity-btn');
const editActivitySubmitBtn = document.getElementById('edit-activity-submit-btn');
const programListContainer = document.getElementById('program-list-container');
const programStorage = document.getElementById('program-storage');
const selectProgramModalEl = document.getElementById('select-program-modal');
const selectBhwModalEl = document.getElementById('select-bhw-modal');
const hideHealthProgramBtn = document.getElementById('hide-hp');
const cancelBhwSelectionBtn = document.getElementById('cancel-bhw-selection');

const proceedBtn = document.getElementById('proceed-btn');
const selectProgramModal = new Modal(selectProgramModalEl);
const editActivityModal = new Modal(editActivityModalEl);
const selectBhwModal = new Modal(selectBhwModalEl);
const confirmEditModal = new Modal(confirmEditScheduleModalEl);

let selectedProgramName = null;
let defBHWs = null;
let defProgramId = null;
let defProgramName = null;
let selectedProgramId = null;
let defPayload = null;
let bhwNames = null;
let passPayload = null;
let bhwsAssigned = null;

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
        program: schedule.health_program?.name || '',
        bhws: (schedule.assigned_b_h_ws || []).map(bhw => ({
            id: bhw.id,                     // the assigned BHW id
            name: bhw.name                   // full name
        }))
    };
    // Fill form inputs
    editActivityNameInput.value = defPayload.activity_name;
    editActivityDate.value      = defPayload.activity_date;
    editActivityTime.value      = defPayload.activity_time;
    editActivityVenue.value     = defPayload.activity_venue;
    
    selectedProgramId = schedule.health_program_id;
    defProgramId = schedule.health_program_id;
    defProgramName = schedule.health_program?.name || '';
    defBHWs = defPayload.bhws;
    bhwsAssigned = defBHWs;

    bhwNames = (schedule.assigned_b_h_ws || [])
                    .map(bhw => bhw.name)
                    .join(", ");

    editHealthProgramButton.textContent = defPayload.program == ''? 'Select Health Program...' : defPayload.program;
    editBhwButton.textContent = bhwNames ? bhwNames : 'Select BHWs...';

    if (typeof editBhwsInput !== "undefined") {
        editBhwsInput.value = defPayload.bhws;
    }

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

editBhwButton.addEventListener('click', function () {
    bhwStorage.dataset.dataSelectedBhw = "edit";
    fetch('/barangay/get-bhws')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success && Array.isArray(data.data)) {
                // Success! Call the helper function to populate the modal
                console.log(data.data);
                populateBhwModal(bhwListContainer, data.data);
                console.log(data);
                // Now show the modal
                editActivityModal.hide();
                selectBhwModal.show();

            } else {
                alert(data.message || "Failed to load BHWs: Invalid data format");
            }
        })
        .catch(error => {
            console.error("Error fetching BHWs:", error);
            // Also update the UI to show an error
            bhwListContainer.innerHTML = '<p class="text-center text-red-500">Could not load BHWs. Please try again.</p>';
            editActivityModal.hide();
            selectBhwModal.show();
        });
});

proceedWithBhwBtn.addEventListener('click', function() {
    if(bhwStorage.dataset.dataSelectedBhw === "edit"){    
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
            editBhwButton.textContent = buttonText;

            // 4. Check if the text overflows the button's visible area.
            if (editBhwButton.scrollWidth > editBhwButton.clientWidth) {
                // Shorten the text until it fits
                while (editBhwButton.scrollWidth > editBhwButton.clientWidth && names.length > 0) {
                    names.pop(); // Remove the last name from the array
                    editBhwButton.textContent = names.join(', ') + '...';
                }
            }
            
            // Store the complete data in your variable for later use
            bhwsAssigned = selectedBhwData;
            
            // Hide the current modal and show the previous one
            selectBhwModal.hide();
            editActivityModal.show();

        } else {
            console.log('No BHWs were chosen.');
            // If nothing is chosen, you might want to reset the button text
            editBhwButton.textContent = 'Select BHW...';
            bhwsAssigned = []; // Clear the variable

            selectBhwModal.hide();
            editActivityModal.show();
        }
    }
});
cancelBhwSelectionBtn.addEventListener('click', function(){
    selectBhwModal.hide();

    if(bhwStorage.dataset.dataSelectedBhw === "edit"){
        bhwsAssigned = defBHWs;

        editBhwButton.textContent = bhwNames;

        // 4. Check if the text overflows the button's visible area.
        if (editBhwButton.scrollWidth > editBhwButton.clientWidth) {
            // Shorten the text until it fits
            while (editBhwButton.scrollWidth > editBhwButton.clientWidth && names.length > 0) {
                names.pop(); // Remove the last name from the array
                editBhwButton.textContent = names.join(', ') + '...';
                }
        }
        console.log('orig BHWs: ', bhwsAssigned);
        editActivityModal.show();
    }
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

function populateProgramModal(programs, currentSelectedId) {
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

// Listener to open the "Select Program" modal
editHealthProgramButton.addEventListener('click', function() {
    programStorage.dataset.selectedProgramId = "edit";

    fetch('/barangay/fetch/health-programs')
        .then(response => response.json())
        .then(data => {
            console.log("Health Programs:", data);
            if (data.success && Array.isArray(data.data)) {
                // Call our new function to build the buttons
                populateProgramModal(data.data, selectedProgramId);
            }
            // Hide the "Add Activity" modal
            editActivityModal.hide();

            // Show the "Select Program" modal
            selectProgramModal.show();
        })
        .catch(error => {
            console.error("Error fetching health programs:", error);
        });
});

proceedBtn.addEventListener('click', () => {
    if (selectedProgramId) {
        selectProgramModal.hide();
        // Your logic here...
        if(programStorage.dataset.selectedProgramId === "edit"){
            editHealthProgramButton.textContent = selectedProgramName; // Update the main form button text
            editActivityModal.show();
        }
    }
});

hideHealthProgramBtn.addEventListener('click', function(){
    if(programStorage.dataset.selectedProgramId === "edit"){
        selectedProgramId =  defProgramId;
        editHealthProgramButton.textContent = defProgramName == ''? 'Select Health Program...' : defProgramName;
        selectProgramModal.hide();
        editActivityModal.show();
    }
});

cancelEditActivityBtn.addEventListener('click', function(){
    selectedProgramId = null;
    defBHWs = null;
    selectedProgramName = null;
    defPayload = null;
    defProgramName = null;
    defProgramId = null;
    bhwNames = null;
    bhwsAssigned = null;

    editHealthProgramButton.textContent = 'Select Health Program';

    editActivityModal.hide();
});

editActivitySubmitBtn.addEventListener('click', function(){
    event.preventDefault();

    editScheduleActivityToConfirm.textContent = editActivityNameInput.value.trim();
    editScheduleDateToConfirm.textContent = editActivityDate.value.trim();
    editScheduleTimeToConfirm.textContent = editActivityTime.value.trim();
    editScheduleVenueToConfirm.textContent = editActivityVenue.value.trim();

    passPayload = {
        id: defPayload.activity_id,
        activity: editActivityNameInput.value.trim(),
        date: editActivityDate.value.trim(),
        time: editActivityTime.value.trim(),
        venue: editActivityVenue.value.trim(),
        health_program_id: selectedProgramId,
        bhws: bhwsAssigned,
    }

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

const successSchedModalEl = document.getElementById('success-modal');
const successSchedMesageHeader = document.getElementById('success-msg-head');
const successSchedMessage = document.getElementById('success-message');
const closeSuccessSchedModalButton = document.getElementById('close-success-modal-button');

const successSchedModal = new Modal(successSchedModalEl);

confirmEditScheduleBtn.addEventListener('click', function() {
    console.log("Payload to send:", passPayload);

    // Construct the URL using the schedule ID
    const url = `/barangay/schedule/edit/${passPayload.id}`;

    fetch(url, {
        method: 'PUT', // or 'POST' if your route expects POST
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
            successSchedMesageHeader.textContent = "Edit Schedule";
            successSchedMessage.textContent = "Schedule has been successfully updated";
            successSchedModal.show();
        }
    })
    .catch(error => {
        console.error("Error sending update request:", error);
    });
});
