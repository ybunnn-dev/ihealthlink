// Get modal DOM elements
const modalMember = document.getElementById('existing-member-modal');
const modalFamilyHead = document.getElementById('existing-family-head-modal');
const modalHouseholdHead = document.getElementById('existing-household-head-modal');
const modalNew = document.getElementById('new-resident-modal');

const cancelAddHousehold = document.getElementById('cancel-add-household');
const proceedAddHousehold = document.getElementById('proceed-add-household');

const confirmAddHouseholdModalEl = document.getElementById('confirm-add-household-modal');
const addHouseholdModalEl = document.getElementById('add-household-modal');

const findHouseholdTrigger = document.getElementById('selectHouseholdHeadBtn');

const purokDropdownBtn = document.getElementById('purokSelect');

const allPuroks = window.puroks;

const waterSourceDropdownButton = document.getElementById('waterSourceSelect');

const openAddHouseholdBtn = document.getElementById('open-add-household');
const confirmAddHouseholdCancel = document.getElementById('confirm-add-household-cancel');
const confirmAddHouseholdSubmit = document.getElementById('confirm-add-household-submit');
const confirmAddHouseholdCheckbox = document.getElementById('confirm-household-checkbox');


const sanitaryDropdownBtn = document.getElementById('sanitarySelect');
const wasteDisposalDropdownBtn = document.getElementById('wasteDisposalSelect');

const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const addHouseholdModal = new Modal(addHouseholdModalEl, modalOptions);
const confirmAddHouseholdModal = new Modal(confirmAddHouseholdModalEl, modalOptions);


let createdHouseholdId = null;

// Initialize buttons as disabled
proceedAddHousehold.disabled = true;
confirmAddHouseholdSubmit.disabled = true;

function validateForms() {
    const isPurokSelected = purokDropdownBtn.value.trim() !== '';
    const isWaterSourceSelected = waterSourceDropdownButton.value.trim() !== '';
    const isSanitaryMenuSlected = sanitaryDropdownBtn.value.trim() !== '';
    const isWasteDisposalSelected = wasteDisposalDropdownBtn.value.trim() !== '';

    proceedAddHousehold.disabled = !(isPurokSelected && isWaterSourceSelected && isSanitaryMenuSlected && isWasteDisposalSelected);
}

document.querySelectorAll('#chooseSanitaryMenu button').forEach(btn => {
    btn.addEventListener('click', () => {
        // Update the main button's text to show the selection
        sanitaryDropdownBtn.childNodes[0].textContent = btn.textContent.trim();

        // Store the selected value (1 or 2) in the hidden input
        sanitaryInput.value = btn.dataset.value;

        // Re-run validation if you include this field
        validateForms(); 
    });
});

function populatePurokList(puroks) {
    // Clear existing options, but keep the initial "Select" option if it exists
    // We assume the first option is the disabled placeholder.
    while (purokSelect.options.length > 1) {
        purokSelect.remove(1);
    }
    
    // Ensure the 'Select' option is selected initially
    purokSelect.value = ""; 

    puroks.forEach(purok => {
        const option = document.createElement('option');
        
        // The text displayed in the dropdown
        option.textContent = purok.name; 
        
        // The value submitted with the form (the ID)
        option.value = purok.id; // Purok ID is stored in the value
        
        purokSelect.appendChild(option);
    });
}

function handlePurokSelection() {
    const selectedPurokId = purokSelect.value;
    const selectedPurokName = purokSelect.options[purokSelect.selectedIndex].text;
    if (selectedPurokId) {
        console.log(`Selected Purok: ${selectedPurokName}, ID: ${selectedPurokId}`);
        validateForms();
    } else {
        console.log("Purok selection cleared.");
    }
}

function initializePurokDropdown() {
    populatePurokList(allPuroks); 
    purokSelect.addEventListener('change', handlePurokSelection);
}

const dropdowns = [
    waterSourceDropdownButton,
    sanitaryDropdownBtn,
    wasteDisposalDropdownBtn,
];

// Loop through each dropdown and add the 'change' event listener
dropdowns.forEach(dropdown => {
    dropdown.addEventListener('change', validateForms);
});

cancelAddHousehold.addEventListener('click', function () {
    addHouseholdModal.hide();
});

proceedAddHousehold.addEventListener('click', function () {
    // Hide the initial modal
    addHouseholdModal.hide();
    confirmAddHouseholdModal.show();
});

confirmAddHouseholdCheckbox.addEventListener('change', function(){
    confirmAddHouseholdSubmit.disabled = !this.checked;
});

confirmAddHouseholdSubmit.addEventListener('click', function(){
    const householdPayload = {
        purok_id: parseInt(purokDropdownBtn.value.trim(), 10),
        water_source: waterSourceDropdownButton.value.trim(),
        waste_disposal: wasteDisposalDropdownBtn.value.trim(),
        sanitary: sanitaryDropdownBtn.value.trim(),
    };
    confirmAddHouseholdCancel.disabled = true;
    confirmAddHouseholdSubmit.disabled = true;
    console.log('Sending payload:', householdPayload);

    fetch('/barangays/households/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(householdPayload)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Backend response:', data);
        if(data.result === 'success'){
            console.log(data);
           alert('Household has been successfully added');
           window.location.href = `/barangays/households/${data.household.id}`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

openAddHouseholdBtn.addEventListener('click', function () {
    initializePurokDropdown();
    addHouseholdModal.show();
});

confirmAddHouseholdCancel.addEventListener('click', function(){
    confirmAddHouseholdModal.hide();
    addHouseholdModal.show();
});
