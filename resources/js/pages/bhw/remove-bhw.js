// The main "remove BHW" modal element
const removeBhwModalEl = document.getElementById('remove-bhw-modal');

// The <strong> element where the BHW's name is displayed
const removeBhwName = document.getElementById('remove-bhw-name');

// The checkbox that must be ticked to enable the remove button
const removeBhwCheckbox = document.getElementById('remove-bhw-checkbox');

// The "Cancel" button
const cancelRemoveBhwButton = document.getElementById('cancel-remove-bhw');

// The final "Remove BHW" button
const removeBhwButton = document.getElementById('remove-bhw-btn');

const removeBhwTrigger = document.getElementById('open-remove-bhw');
const removeBhwModal = new Modal(removeBhwModalEl);

removeBhwTrigger.addEventListener('click', function(){
    removeBhwModal.show();
});

cancelRemoveBhwButton.addEventListener('click',function(){
    removeBhwModal.hide();
});