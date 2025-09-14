// The main modal element
const addFamilyModalEl = document.getElementById('add-family-modal');

// Button to trigger household selection
const selectHouseholdButton = document.getElementById('selectHouseholdButton');
const selectFamilyHeadButton = document.getElementById('selectFamilyHeadButton');

const is4psButton = document.getElementById('is4psButton');
const is4psButtonText = document.getElementById('is4psButtonText');
const psDropdownMenu = document.getElementById('4psDropdownMenu');

const isIndigentButton = document.getElementById('isIndigentButton');
const isIndigentButtonText = document.getElementById('isIndigentButtonText');
const indigentDropdownMenu = document.getElementById('indigentDropdownMenu');

const cancelAddFamilyButton = document.getElementById('cancelAddFamilyButton');
const proceedAddHouseholdButton = document.getElementById('proceedAddHouseholdButton');

// The main confirmation modal element
const confirmAddFamilyModalEl = document.getElementById('confirm-add-family-modal');
const confirmFamilyCheckbox = document.getElementById('confirm-family-checkbox');
const confirmAddFamilyCancelBtn = document.getElementById('confirm-add-family-cancel');
const confirmAddFamilySubmitBtn = document.getElementById('confirm-add-family-submit');

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');


const addFamilyTriggerBtn = document.getElementById('add-family-trigger');

const addFamilyModal = new Modal(addFamilyModalEl);
const confirmAddFamilyModal = new Modal(confirmAddFamilyModalEl);
const successModal = new Modal(successModalEl);

let household = window.household;
let householdHead;

// NEW: Completed validation function
function validateForm() {
    const is4psSelected = is4psButtonText.textContent !== 'Select';
    const isIndigentSelected = isIndigentButtonText.textContent !== 'Select';

    // If both dropdowns have a value, enable the button. Otherwise, disable it.
    if (is4psSelected && isIndigentSelected) {
        proceedAddHouseholdButton.disabled = false;
    } else {
        proceedAddHouseholdButton.disabled = true;
    }
}

proceedAddHouseholdButton.addEventListener('click', function(){
    event.preventDefault();

    addFamilyModal.hide();
    confirmAddFamilyModal.show();
});


addFamilyTriggerBtn.addEventListener('click', function() {
    selectHouseholdButton.style.backgroundColor = "#EBEBEB";
    selectHouseholdButton.disabled = true;
    selectHouseholdButton.textContent = "Household #" + household.id;
    
    // CHANGED: Ensure the button is disabled when the modal opens
    proceedAddHouseholdButton.disabled = true; 

    addFamilyModal.show();
});

cancelAddFamilyButton.addEventListener('click', function() {
    householdHead = null;
    selectFamilyHeadButton.textContent = "Select Household Head";
    isIndigentButtonText.textContent = "Select";
    is4psButtonText.textContent = "Select";

    // CHANGED: Ensure the button is disabled when the form is reset
    proceedAddHouseholdButton.disabled = true; 

    addFamilyModal.hide();
});

function setupDropdownValueUpdater(buttonEl, menuEl, textEl) {
    const optionButtons = menuEl.querySelectorAll('button');

    optionButtons.forEach(option => {
        option.addEventListener('click', () => {
            const selectedValue = option.getAttribute('data-value');
            textEl.textContent = selectedValue;
            textEl.classList.remove('text-gray-400');
            textEl.classList.add('text-normal_font');
            buttonEl.click();
            
            // CHANGED: Call the validation function every time a value changes
            validateForm();
        });
    });
}

setupDropdownValueUpdater(is4psButton, psDropdownMenu, is4psButtonText);
setupDropdownValueUpdater(isIndigentButton, indigentDropdownMenu, isIndigentButtonText);

confirmFamilyCheckbox.addEventListener('change', function(){
    confirmAddFamilySubmitBtn.disabled = !this.checked;
});

confirmAddFamilySubmitBtn.addEventListener('click', function () {
    const addFamilyPayload = {
        household_id: household.id,
        familyHeadId: null,
        is4ps: is4psButtonText.textContent,
        isIndigent: isIndigentButtonText.textContent
    };

    fetch('/barangays/families/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(addFamilyPayload)
    })
    .then(response => response.json())
    .then(data => {
        //console.log("Server response:", data);
        if(data.status === 'success'){
            confirmAddFamilyModal.hide();
            successMesageHeader.textContent = "Family Added";
            successMessage.textContent = "Family has been succussfully added to the household";
            successModal.show();
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});

closeSuccessModalButton.addEventListener('click', function(){
    window.location.reload();
});
