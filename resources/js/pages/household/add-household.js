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

const purokDropdownBtn = document.getElementById('purokDropdownBtn');
const purokIdInput = document.getElementById('purokIdInput');
const purokMenu = document.getElementById('choosePurokMenu');
const purokList = purokMenu.querySelector('ul');
const allPuroks = window.puroks;

const waterSourceDropdownButton = document.getElementById('chooseWaterSource');
const waterSourceDropdownMenu = document.getElementById('chooseWaterSourceMenu');
const waterSourceInput = document.getElementById('waterSourceInput');

const openAddHouseholdBtn = document.getElementById('open-add-household');
const confirmAddHouseholdCancel = document.getElementById('confirm-add-household-cancel');
const confirmAddHouseholdSubmit = document.getElementById('confirm-add-household-submit');
const confirmAddHouseholdCheckbox = document.getElementById('confirm-household-checkbox');


const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');


const sanitaryDropdownBtn = document.getElementById('chooseSanitaryBtn');
const sanitaryInput = document.getElementById('sanitaryInput');

const successModal = new Modal(successModalEl);
const addHouseholdModal = new Modal(addHouseholdModalEl);
const confirmAddHouseholdModal = new Modal(confirmAddHouseholdModalEl);

// Initialize buttons as disabled
proceedAddHousehold.disabled = true;
confirmAddHouseholdSubmit.disabled = true;

// --- MODIFICATION 1: Implement the validation function ---
function validateForms() {
    const isPurokSelected = purokIdInput.value.trim() !== '';
    const isWaterSourceSelected = waterSourceInput.value.trim() !== '';
    const isSanitaryMenuSlected = sanitaryInput.value.trim() !== '';
    // Enable the 'Proceed' button ONLY if both are selected.
    proceedAddHousehold.disabled = !(isPurokSelected && isWaterSourceSelected && isSanitaryMenuSlected);
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
    purokList.innerHTML = '';

    puroks.forEach(purok => {
        const listItem = document.createElement('li');
        const button = document.createElement('button');

        button.type = 'button';
        button.textContent = purok.name;
        button.dataset.purokId = purok.id;
        button.className = 'w-full text-left px-4 py-2 hover:bg-gray-100';

        listItem.appendChild(button);
        purokList.appendChild(listItem);
    });
}


function handlePurokSelection(event) {
    if (event.target.tagName !== 'BUTTON') {
        return;
    }

    const selectedButton = event.target;
    const selectedPurokName = selectedButton.textContent;
    const selectedPurokId = selectedButton.dataset.purokId;

    purokDropdownBtn.textContent = selectedPurokName;
    purokIdInput.value = selectedPurokId;

    purokMenu.classList.add('hidden');

    console.log(`Selected Purok: ${selectedPurokName}, ID: ${selectedPurokId}`);
    
    // --- MODIFICATION 2: Call validation after selecting a Purok ---
    validateForms();
}

function initializePurokDropdown() {
    if (!allPuroks || !purokList) {
        console.error('Purok data or list element not found.');
        return;
    }

    populatePurokList(allPuroks);
    purokList.addEventListener('click', handlePurokSelection);
}

// --- MODIFICATION 3: Call validation after selecting a Water Source ---
document.querySelectorAll('#chooseWaterSourceMenu button').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('chooseWaterSourceBtn').childNodes[0].textContent = btn.textContent;
        waterSourceInput.value = btn.dataset.value;

        // Call the validation function here as well
        validateForms();
    });
});

initializePurokDropdown();

cancelAddHousehold.addEventListener('click', function () {
    addHouseholdModal.hide();
});

proceedAddHousehold.addEventListener('click', function () {
    addHouseholdModal.hide();
    confirmAddHouseholdModal.show();
});

confirmAddHouseholdCheckbox.addEventListener('change', function(){
    confirmAddHouseholdSubmit.disabled = !this.checked;
});

confirmAddHouseholdSubmit.addEventListener('click', function(){
    const householdPayload = {
        purok_id: parseInt(purokIdInput.value.trim(), 10),
        water_source: waterSourceInput.value.trim(),
        sanitary: parseInt(sanitaryInput.value.trim())
    };

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
            confirmAddHouseholdModal.hide();
            successMesageHeader.textContent = "Household Added";
            successMessage.textContent = "Household has been successfully added";
            successModal.show();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

closeSuccessModalButton.addEventListener('click', function(){
    window.location.reload();
});

openAddHouseholdBtn.addEventListener('click', function () {
    addHouseholdModal.show();
});

findHouseholdTrigger.addEventListener('click', function () {
    addHouseholdModal.hide();
});

// Function to show a modal (adds Tailwind classes)
/*
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) { // Add a safety check
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

// Function to hide a modal (used by "Close" buttons)
// The id parameter should be the string ID of the modal to close.
function closeModal(id) {
    // If the modal being closed is NOT the main 'add-household-modal',
    // reopen the main one. This ensures the parent modal returns after a child closes.
    if (id !== 'add-household-modal') {
        openModal('add-household-modal');
    }

    const modal = document.getElementById(id);
    if (modal) { // Add a check to prevent the error if the ID is invalid
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}
*/

/*
// Proceed button logic
document.getElementById('proceed-add-household').addEventListener('click', function () {
    const enteredName = document.getElementById('selectHouseholdHeadBtn').textContent.trim();

    // Pass the string ID to closeModal, NOT the DOM element
    closeModal('add-household-modal');

    if (!enteredName) {
        alert("Please enter the household head's name.");
        return;
    }

    switch (enteredName.toLowerCase()) {
        case 'juan dela cruz':
            openModal('existing-member-modal');
            break;
        case 'maria clara':
            openModal('existing-family-head-modal');
            break;
        case 'pedro penduko':
            openModal('existing-household-head-modal');
            break;
        default:
            openModal('new-resident-modal');
    }
});



// Add event listeners for the "Close" buttons in your child modals
// This is crucial for the `closeModal` function to work as intended
// with your child modals. Without this, they will never be closed
// and the parent modal will not return.
document.getElementById('close-existing-member').addEventListener('click', function () {
    closeModal('existing-member-modal');
});
*/
