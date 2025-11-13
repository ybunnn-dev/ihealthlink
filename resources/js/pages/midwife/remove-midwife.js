const midwifeToRemove = window.midwifeData;

const removeMidwifeModal = document.getElementById('remove-midwife-modal');
const midwifeNameToRemove = document.getElementById('midwife-name-to-remove');
const removeMidwifeCheckbox = document.getElementById('remove-midwife-checkbox');
const closeRemoveMidwifeModalBtn = document.getElementById('close-remove-midwife-modal');
const removeMidwifeBtn = document.getElementById('remove-midwife-button');
const openRemoveMidwifeModal = document.getElementById('remove-midwife-btn');
const removeMidwifeMsg = document.getElementById('remove-midwife-msg');


const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');



// --- Modal Options Factory ---
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

const successModal = new Modal(successModalEl, createModalOptions(successModalEl));
const removeMidwife = new Modal(removeMidwifeModal, createModalOptions(removeMidwifeModal));

openRemoveMidwifeModal.addEventListener('click', function () {

    if (removeMidwife) {
        // Dynamically set the midwife name in the modal
        const midwifeNameElement = removeMidwifeModal.querySelector('#midwife-name-to-remove');
        if (midwifeNameElement && midwifeToRemove) {
            midwifeNameElement.textContent = midwifeToRemove.fullName; // update with actual name
        }

        // Show the modal
        removeMidwife.show();
    }
});

closeRemoveMidwifeModalBtn.addEventListener('click', function(){
    const removeMidwife = new Modal(removeMidwifeModal);

    if(removeMidwife){
        removeMidwife.hide();
    }
});


removeMidwifeCheckbox.addEventListener('change', function() {
    // Enable the button if the checkbox is checked, disable it if not.
    removeMidwifeBtn.disabled = !this.checked;
});

removeMidwifeBtn.addEventListener('click', async function() {
    if (!midwifeToRemove || !midwifeToRemove.user_id) return;

    try {
        const response = await fetch(`/mho/midwife/${midwifeToRemove.user_id}/remove`, {
            method: 'PUT', // still a PUT, not DELETE
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ user_id: midwifeToRemove.user_id })
        });

        const result = await response.json();
        console.log('Backend response:', result);

        // Optional: reload or close modal on success
        if (result.status === 'success') {
            

            if(successModal && removeMidwife){
                successMesageHeader.textContent = 'Midwife Removed';
                successMessage.textContent = `${midwifeNameToRemove.fullName} has been removed`;
                removeMidwife.hide();
                successModal.show();
            }
        }

    } catch (err) {
        console.error('Error sending remove request:', err);
    }
});


closeSuccessModalButton.addEventListener('click', function(){
    window.location.href = '/mho/midwives';
});