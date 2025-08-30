const addPurokModalEl = document.getElementById('add-purok-modal');
const confirmPurokModalEl = document.getElementById('confirm-add-purok-modal');
const mainTriggerBtn = document.getElementById('page-add-purok-button');

const addPurokModal = new Modal(addPurokModalEl);
const confirmPurokModal = new Modal(confirmPurokModalEl);


mainTriggerBtn.addEventListener('click', function() {
    addPurokModal.show();
});

const purokNameInput = document.getElementById('purok-name-input');
const openPurokConfirmBtn = document.getElementById('open-purok-confirmation-modal-button');
const confirmCheckbox = document.getElementById('confirm-purok-checkbox');
const confirmProceedBtn = document.getElementById('confirm-proceed-button');
// **Get the cancel button from the confirmation modal**
const cancelConfirmBtn = confirmPurokModalEl.querySelector('[data-modal-hide="confirm-add-purok-modal"]');


openPurokConfirmBtn.addEventListener('click', function () {
    const purokName = purokNameInput.value.trim();
    if (purokName === '') {
        alert('Please enter a purok name.');
        return;
    }
    const purokNamePlaceholder = document.getElementById('purok-name-to-confirm');
    purokNamePlaceholder.textContent = purokName;

    addPurokModal.hide();
    confirmPurokModal.show();    
});
