// The main "remove BHW" modal element
const removeBhwModalEl = document.getElementById('remove-bhw-modal');
const removeBhwName = document.getElementById('remove-bhw-name');
const removeBhwCheckbox = document.getElementById('remove-bhw-checkbox');
const cancelRemoveBhwButton = document.getElementById('cancel-remove-bhw');
const removeBhwButton = document.getElementById('remove-bhw-btn');

const removeBhwTrigger = document.getElementById('open-remove-bhw');
const removeBhwModal = new Modal(removeBhwModalEl);

const bhwData = window.bhwData;

removeBhwTrigger.addEventListener('click', function(){
    removeBhwName.textContent = bhwData.name;
    removeBhwModal.show();
});

removeBhwCheckbox.addEventListener('change', function(){
    removeBhwButton.disabled = !this.checked;
});

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');
const successModal = new Modal(successModalEl);

removeBhwButton.addEventListener('click', function(){
    event.preventDefault();
    const bhwId = bhwData.users.id;
    const bhwName = bhwData.name;

    console.log(bhwId);

     fetch(`/barangay/bhw/${bhwId}/remove`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(bhwId)
    })
    .then(response => response.json())
    .then(data => {
        removeBhwModal.hide();
        successMesageHeader.textContent = "BHW Removed";
        successMessage.textContent = bhwName +" has been removed";
        successModal.show();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

closeSuccessModalButton.addEventListener('click', function(){
    window.location.href = '/midwife/bhws';
})
cancelRemoveBhwButton.addEventListener('click',function(){
    removeBhwModal.hide();
});