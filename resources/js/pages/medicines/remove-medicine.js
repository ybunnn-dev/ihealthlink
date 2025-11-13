// The delete confirmation modal container
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


const confirmDeleteMedicineModal = document.getElementById('confirm-delete-medicine-modal');
const deleteMedicineData = window.medicineData;
// The strong tag to display the name of the medicine to be deleted
const deleteMedicineNameToConfirm = document.getElementById('delete-medicine-name-to-confirm');

// The final "Yes, I'm sure" button to confirm deletion
const confirmDeleteMedicineBtn = document.getElementById('confirm-delete-medicine-btn');
const confirmDeleteMedicineCheckbox = document.getElementById('delete-medicine-checkbox');

// The "No, cancel" button inside the deletion modal
const cancelDeleteMedicineBtn = document.getElementById('cancel-delete-medicine');


const successDelModalEl = document.getElementById('success-modal');
const successDelMesageHeader = document.getElementById('success-msg-head');
const successDelMessage = document.getElementById('success-message');
const closeSuccessDelMedModalButton = document.getElementById('close-success-modal-button');

const removeBtn = document.getElementById('remove-med-btn');

const confirmDeleteMedicine = new Modal(confirmDeleteMedicineModal, createModalOptions(confirmDeleteMedicineModal));
const successDelMedModal = new Modal(successDelModalEl, createModalOptions(successDelModalEl));

removeBtn.addEventListener('click', function () {
    deleteMedicineNameToConfirm.textContent = deleteMedicineData.medicine_name;
    confirmDeleteMedicine.show();
});

confirmDeleteMedicineCheckbox.addEventListener('change', function () {
    confirmDeleteMedicineBtn.disabled = !this.checked;
});

confirmDeleteMedicineBtn.addEventListener('click', function () {
    const medicineId = deleteMedicineData.id;

    fetch(`/midwife/medicine/delete=${medicineId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Laravel CSRF
        },
        body: JSON.stringify({
            id: medicineId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.result == 'success') {

                if (confirmDeleteMedicineModal && successDelMedModal) {
                    confirmDeleteMedicine.hide();
                    successDelMesageHeader.textContent = 'Medicine Updated';
                    successDelMessage.textContent = 'Midwife details has been updated';
                    successDelMedModal.show();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

closeSuccessDelMedModalButton.addEventListener('click', function () {
    window.location.href = '/midwife/medicines';
});

cancelDeleteMedicineBtn.addEventListener('click', function(){
    confirmDeleteMedicine.hide();
});