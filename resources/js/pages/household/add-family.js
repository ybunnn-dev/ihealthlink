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

const isIwasGutomButton = document.getElementById('isIwasGutom');
const isIwasGutomButtonText = document.getElementById('isIwasGutomButtonText');
const isIwasGutomMenu = document.getElementById('isIwasGutomMenu');

const cancelAddFamilyButton = document.getElementById('cancelAddFamilyButton');
const proceedAddFamilyButton = document.getElementById('proceedAddFamilyButton');

// The main confirmation modal element
const confirmAddFamilyModalEl = document.getElementById('confirm-add-family-modal');
const confirmFamilyCheckbox = document.getElementById('confirm-family-checkbox');
const confirmAddFamilyCancelBtn = document.getElementById('confirm-add-family-cancel');
const confirmAddFamilySubmitBtn = document.getElementById('confirm-add-family-submit');

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const selectedHH = document.getElementById('selectHouseholdButton');

const household = window.household;
console.log(household);

const purokFilterDropdownButton = document.getElementById('purokFilterDropdownButton');
const purokFilterDropdownMenu = document.getElementById('purokFilterDropdownMenu')

const addFamilyTriggerBtn = document.getElementById('add-family-trigger');

const addFamilyModal = new Modal(addFamilyModalEl, modalOptions);
const confirmAddFamilyModal = new Modal(confirmAddFamilyModalEl, modalOptions);
const successModal = new Modal(successModalEl, modalOptions);


// NEW: Completed validation function
function validateForm() {
    const is4psSelected = is4psButtonText.textContent !== 'Select';
    const isIndigentSelected = isIndigentButtonText.textContent !== 'Select';
    const isIwasGutomSelected = isIwasGutomButtonText.textContent !== 'Select';

    // If both dropdowns have a value, enable the button. Otherwise, disable it.
    if (is4psSelected && isIndigentSelected && isIwasGutomSelected) {
        proceedAddFamilyButton.disabled = false;
    } else {
        proceedAddFamilyButton.disabled = true;
    }
}

proceedAddFamilyButton.addEventListener('click', function(){
    event.preventDefault();

    addFamilyModal.hide();
    confirmAddFamilyModal.show();
});


addFamilyTriggerBtn.addEventListener('click', function() {    
    // CHANGED: Ensure the button is disabled when the modal opens
    proceedAddFamilyButton.disabled = true; 
    selectedHH.textContent = `Household #${household.id}`;
    addFamilyModal.show();
});

cancelAddFamilyButton.addEventListener('click', function() {
    selectFamilyHeadButton.textContent = "Select Household Head";
    isIndigentButtonText.textContent = "Select";
    is4psButtonText.textContent = "Select";

    // CHANGED: Ensure the button is disabled when the form is reset
    proceedAddFamilyButton.disabled = true; 

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
setupDropdownValueUpdater(isIwasGutomButton, isIwasGutomMenu, isIwasGutomButtonText);

confirmFamilyCheckbox.addEventListener('change', function(){
    confirmAddFamilySubmitBtn.disabled = !this.checked;
});

confirmAddFamilySubmitBtn.addEventListener('click', function () {
    const addFamilyPayload = {
        household_id: household.id,
        familyHeadId: null,
        is4ps: is4psButtonText.textContent,
        isIndigent: isIndigentButtonText.textContent,
        isIwasGutom: isIwasGutomButtonText.textContent
    };
    
    confirmAddFamilySubmitBtn.disabled = true;

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
            alert('Family has been added successfully!');
            window.location.reload();
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});

