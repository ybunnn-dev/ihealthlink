// Get modal DOM elements
// The modal container itself
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

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

const sanitaryDropdownBtn = document.getElementById('sanitarySelect');
const wasteDisposalDropdownBtn = document.getElementById('wasteDisposalSelect');


const addHouseholdModal = new Modal(addHouseholdModalEl, createModalOptions(addHouseholdModalEl));
const confirmAddHouseholdModal = new Modal(confirmAddHouseholdModalEl, createModalOptions(confirmAddHouseholdModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

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
    
    // Disable both buttons
    confirmAddHouseholdCancel.disabled = true;
    confirmAddHouseholdSubmit.disabled = true;
    
    // Store original button text and change to "Saving..."
    const originalButtonText = confirmAddHouseholdSubmit.textContent;
    confirmAddHouseholdSubmit.textContent = 'Saving...';
    
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
            
            // Hide the confirmation modal
            confirmAddHouseholdModal.hide();
            
            // Update success modal content
            successMesageHeader.textContent = 'Success!';
            successMessage.textContent = 'Household has been successfully added';
            
            // Show success modal
            successModal.show();
            
            // Store the household ID for navigation after closing modal
            createdHouseholdId = data.household.id;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Re-enable buttons and restore original text on error
        confirmAddHouseholdCancel.disabled = false;
        confirmAddHouseholdSubmit.disabled = false;
        confirmAddHouseholdSubmit.textContent = originalButtonText;
    });
});

closeSuccessModalButton.addEventListener('click', function() {
    successModal.hide();
    
    // Navigate to the household detail page after closing the modal
    if (createdHouseholdId) {
        window.location.href = `/barangays/households/${createdHouseholdId}`;
    }
});

openAddHouseholdBtn.addEventListener('click', function () {
    initializePurokDropdown();
    addHouseholdModal.show();
});

confirmAddHouseholdCancel.addEventListener('click', function(){
    confirmAddHouseholdModal.hide();
    addHouseholdModal.show();
});
