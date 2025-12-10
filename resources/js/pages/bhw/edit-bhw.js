const bhwData = window.bhwData;
const editBhwModalEl = document.getElementById('edit-bhw-modal');
const editBhwForm = document.getElementById('editBhwForm');

// Input elements
const editBhwIdInput = document.getElementById('editBhwId');
const editBhwFirstNameInput = document.getElementById('editBhwFirstName');
const editBhwLastNameInput = document.getElementById('editBhwLastName');
const editBhwMiddleNameInput = document.getElementById('editBhwMiddleName');
const editBhwSuffixSelect = document.getElementById('editBhwSuffix');
const editBhwBirthdateInput = document.getElementById('editBhwBirthdate');
const editBhwAgeInput = document.getElementById('editBhwAge');
const editBhwSexSelect = document.getElementById('editBhwSex');
const editBhwPrivilegeSelect = document.getElementById('editBhwPrivilege');
const editBhwCivilStatusSelect = document.getElementById('editBhwCivilStatus');
const editBhwReligionSelect = document.getElementById('editBhwReligion');
const editBhwEmailInput = document.getElementById('editBhwEmail');
const editBhwContactNoInput = document.getElementById('editBhwContactNo');

let defBhwData = null;

// Button elements
const editBhwCloseButton = document.getElementById('editBhwCloseButton');
const editBhwTrigger = document.getElementById('open-edit-bhw');
const editBhwSubmitButton = document.getElementById('editBhwSubmitButton');

// Confirmation modal elements
const confirmEditBhwModalEl = document.getElementById('confirm-edit-bhw-modal');
const editBhwNameToConfirm = document.getElementById('edit-bhw-name-to-confirm');
const confirmEditBhwCheckbox = document.getElementById('confirm-edit-bhw-checkbox');
const confirmEditBhwCancelButton = document.getElementById('confirm-edit-bhw-cancel');
const confirmEditProceedButton = document.getElementById('confirm-edit-proceed-button');

// Success modal elements
const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

// Initialize modals
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

const editBhwModal = new Modal(editBhwModalEl, createModalOptions(editBhwModalEl));
const confirmEditBhw = new Modal(confirmEditBhwModalEl, createModalOptions(confirmEditBhwModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

function calculateAge(birthdateString) {
    if (!birthdateString) return '';
    const birthDate = new Date(birthdateString);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDifference = today.getMonth() - birthDate.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

function validateEditForm() {
    if (!defBhwData || !bhwData) {
        editBhwSubmitButton.disabled = true;
        return;
    }

    // Check if all required fields are filled
    const requiredInputs = [
        editBhwFirstNameInput,
        editBhwLastNameInput,
        editBhwMiddleNameInput,
        editBhwBirthdateInput,
        editBhwEmailInput,
        editBhwContactNoInput
    ];

    const requiredSelects = [
        editBhwSexSelect,
        editBhwPrivilegeSelect,
        editBhwCivilStatusSelect,
        editBhwReligionSelect
    ];

    const allFieldsFilled = 
        requiredInputs.every(input => input.value.trim() !== '') &&
        requiredSelects.every(select => select.value !== '');

    // Check if at least one change was made
    const isChanged = 
        editBhwFirstNameInput.value !== (defBhwData.firstName || '') ||
        editBhwLastNameInput.value !== (defBhwData.lastName || '') ||
        editBhwMiddleNameInput.value !== (defBhwData.middleName || '') ||
        editBhwSuffixSelect.value !== (defBhwData.suffix || '') ||
        editBhwBirthdateInput.value !== (defBhwData.birthdate || '') ||
        editBhwSexSelect.value !== (defBhwData.sex || '') ||
        editBhwCivilStatusSelect.value !== (defBhwData.civil_status || '') ||
        editBhwReligionSelect.value !== (defBhwData.religion || '') ||
        editBhwEmailInput.value !== (defBhwData.email || '') ||
        editBhwContactNoInput.value !== (defBhwData.contact_no || '') ||
        parseInt(editBhwPrivilegeSelect.value) !== bhwData.role_id;

    editBhwSubmitButton.disabled = !(allFieldsFilled && isChanged);
}

function populateEditForm(bhwData) {
    const userData = bhwData.user;
    defBhwData = bhwData.user;

    editBhwIdInput.value = bhwData.id;
    editBhwFirstNameInput.value = userData.firstName || '';
    editBhwLastNameInput.value = userData.lastName || '';
    editBhwMiddleNameInput.value = userData.middleName || '';
    editBhwSuffixSelect.value = userData.suffix || '';
    editBhwBirthdateInput.value = userData.birthdate || '';
    editBhwAgeInput.value = calculateAge(userData.birthdate);
    editBhwSexSelect.value = userData.sex || '';
    editBhwCivilStatusSelect.value = userData.civil_status || '';
    editBhwReligionSelect.value = userData.religion || '';
    editBhwEmailInput.value = userData.email || '';
    editBhwContactNoInput.value = userData.contact_no || '';
    editBhwPrivilegeSelect.value = bhwData.role_id || '';
}

// Attach event listeners for validation
const allInputs = [
    editBhwFirstNameInput,
    editBhwLastNameInput,
    editBhwMiddleNameInput,
    editBhwBirthdateInput,
    editBhwEmailInput,
    editBhwContactNoInput
];

const allSelects = [
    editBhwSuffixSelect,
    editBhwSexSelect,
    editBhwPrivilegeSelect,
    editBhwCivilStatusSelect,
    editBhwReligionSelect
];

allInputs.forEach(input => input.addEventListener('input', validateEditForm));
allSelects.forEach(select => select.addEventListener('change', validateEditForm));

// Open edit modal
editBhwTrigger.addEventListener('click', function() {
    if (bhwData) {
        populateEditForm(bhwData); 
        validateEditForm();
        editBhwModal.show();
    } else {
        console.error('BHW data is not available.');
    }
});

// Submit form
editBhwSubmitButton.addEventListener('click', function(event){
    event.preventDefault();
    editBhwModal.hide();
    editBhwNameToConfirm.textContent = `${bhwData.user.firstName} ${bhwData.user.middleName} ${bhwData.user.lastName}`;
    confirmEditBhw.show();
});

// Confirmation checkbox
confirmEditBhwCheckbox.addEventListener('change', function(){
    confirmEditProceedButton.disabled = !this.checked;
});

// Cancel confirmation
confirmEditBhwCancelButton.addEventListener('click', function(){
    confirmEditBhwCheckbox.checked = false;
    confirmEditProceedButton.disabled = true;
    confirmEditBhw.hide();
    editBhwModal.show();
});

// Proceed with update
confirmEditProceedButton.addEventListener('click', function(event){
    event.preventDefault();
    
    const payLoad = {
        id: bhwData.user.id,
        firstName: editBhwFirstNameInput.value,
        lastName: editBhwLastNameInput.value,
        middleName: editBhwMiddleNameInput.value,
        suffix: editBhwSuffixSelect.value || '',
        birthdate: editBhwBirthdateInput.value,
        sex: editBhwSexSelect.value,
        civil_status: editBhwCivilStatusSelect.value,
        religion: editBhwReligionSelect.value,
        email: editBhwEmailInput.value,
        contact_no: editBhwContactNoInput.value,
        role_id: parseInt(editBhwPrivilegeSelect.value, 10)
    };

    const originalButtonText = confirmEditProceedButton.textContent;
    confirmEditProceedButton.disabled = true;
    confirmEditBhwCancelButton.disabled = true;
    confirmEditProceedButton.textContent = 'Updating...';

    fetch(`/barangay/bhw/${payLoad.id}/edit`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payLoad)
    })
    .then(response => response.json())
    .then(data => {
        confirmEditBhw.hide();
        successMesageHeader.textContent = "Edit Success";
        successMessage.textContent = "BHW has been successfully updated";
        successModal.show();
    })
    .catch(error => {
        console.error('Error:', error);
        confirmEditBhw.hide();
        alert("Failed to update BHW. Please try again.");
        window.location.reload();
    })
    .finally(() => {
        confirmEditProceedButton.disabled = false;
        confirmEditBhwCancelButton.disabled = false;
        confirmEditProceedButton.textContent = originalButtonText;
        confirmEditBhwCheckbox.checked = false;
    });
});

closeSuccessModalButton.addEventListener('click', function(){
    window.location.reload();
});

editBhwCloseButton.addEventListener('click', function() {
    editBhwModal.hide();
});
