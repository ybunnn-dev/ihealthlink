// The main "remove BHW" modal element
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


const removeBhwModalEl = document.getElementById('remove-bhw-modal');
const removeBhwName = document.getElementById('remove-bhw-name');
const removeBhwCheckbox = document.getElementById('remove-bhw-checkbox');
const cancelRemoveBhwButton = document.getElementById('cancel-remove-bhw');
const removeBhwButton = document.getElementById('remove-bhw-btn');

const removeBhwTrigger = document.getElementById('open-remove-bhw');
const removeBhwModal = new Modal(removeBhwModalEl, createModalOptions(removeBhwModalEl));

const bhwData = window.bhwData;

console.log(bhwData);

removeBhwTrigger.addEventListener('click', function(){
    removeBhwName.textContent = `${bhwData.user.firstName} ${bhwData.user.middleName} ${bhwData.user.lsastName}`;
    removeBhwModal.show();
});

removeBhwCheckbox.addEventListener('change', function(){
    removeBhwButton.disabled = !this.checked;
});

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

removeBhwButton.addEventListener('click', function(){
    event.preventDefault();
    const bhwId = bhwData.user.id;
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
    window.location.href = '/barangay/bhws';
})
cancelRemoveBhwButton.addEventListener('click',function(){
    removeBhwModal.hide();
});