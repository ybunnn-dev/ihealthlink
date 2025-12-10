// --- Global State ---
let midwifePayload = {}; // Holds the form data for the confirmation step

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

// --- Element Selection (Main Form) ---
const availableBarangay = window.emptyBarangay || [];
const submitButton = document.getElementById('addMidwifeSubmitBtn');
const birthdateInput = document.getElementById('midwifeBdate');
const ageInput = document.getElementById('midwifeAge');

// Success modal elements
const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

const textInputs = [
    document.getElementById('midwifeFirstName'),
    document.getElementById('midwifeLastName'),
    document.getElementById('midwifeMiddleName'),
    document.getElementById('contactNo'),
    document.getElementById('midwifeEmail'),
];

const requiredDropdowns = [
    document.getElementById('sexDropdown'),
    document.getElementById('civilStatusDropdown'),
    document.getElementById('religionDropdown'),
    document.getElementById('barangayDropdown')
];

const allDropdowns = [...requiredDropdowns, document.getElementById('prefixDropdown')];

// --- Modal Management with Flowbite ---
const addMidwifeModalEl = document.getElementById('add-midwife-modal');
const confirmModalEl = document.getElementById('confirm-add-midwife-modal');

// Create Flowbite Modal instances
const addMidwifeModal = new Modal(addMidwifeModalEl, createModalOptions(addMidwifeModalEl));
const confirmModal = new Modal(confirmModalEl, createModalOptions(confirmModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

const confirmCheckbox = document.getElementById('confirm-midwife-checkbox');
const proceedButton = document.getElementById('confirm-add-midwife-btn');
const midwifeNameSpan = document.getElementById('midwife-name-to-confirm');

// --- Setup & Helper Functions ---

// Setup Age Input
ageInput.disabled = true;
ageInput.classList.add('bg-gray-100');

// Populate Barangay Dropdown
const populateBarangayDropdown = () => {
    const menu = document.getElementById('barangayDropdownMenu');
    if (!menu) return;
    const list = menu.querySelector('ul');
    if (!list) return;
    list.innerHTML = '';
    if (availableBarangay.length > 0) {
        availableBarangay.forEach(barangay => {
            const listItem = document.createElement('li');
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = barangay.name;
            button.dataset.id = barangay.id;
            button.className = 'w-full text-left px-4 py-2 hover:bg-gray-100';
            listItem.appendChild(button);
            list.appendChild(listItem);
        });
    } else {
        const listItem = document.createElement('li');
        listItem.textContent = 'No available barangays';
        listItem.className = 'px-4 py-2 text-sm text-gray-500';
        list.appendChild(listItem);
    }
};

// Validation
const validateForm = () => {
    const allInputsFilled = [...textInputs, birthdateInput, ageInput].every(input => input.value.trim() !== '');
    const allDropdownsSelected = requiredDropdowns.every(button => {
        const span = button.querySelector('span');
        const text = span ? span.textContent.trim() : button.textContent.trim();
        return !text.startsWith('Select');
    });
    submitButton.disabled = !(allInputsFilled && allDropdownsSelected);
};

// Age Calculation
const calculateAndSetAge = () => {
    const birthDateString = birthdateInput.value;
    if (!birthDateString) {
        ageInput.value = '';
        validateForm();
        return;
    }
    const birthDate = new Date(birthDateString);
    const today = new Date();
    if (isNaN(birthDate.getTime()) || birthDate > today) {
        ageInput.value = '';
        validateForm();
        return;
    }
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDifference = today.getMonth() - birthDate.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    ageInput.value = age;
    validateForm();
};

// Dropdown Setup
const setupDropdown = (button) => {
    const menuId = button.getAttribute('data-dropdown-toggle');
    const menu = document.getElementById(menuId);
    if (!menu) return;
    
    const options = menu.querySelectorAll('ul li a, ul li button');
    
    options.forEach(option => {
        option.addEventListener('click', (e) => {
            e.preventDefault();
            
            const span = button.querySelector('span');
            if (span) {
                span.textContent = option.textContent.trim();
            }
            
            if (option.dataset.id) {
                button.dataset.selectedId = option.dataset.id;
            }
            validateForm();
        });
    });
};

// --- Event Listeners & Initializations ---

populateBarangayDropdown();

[...textInputs, birthdateInput].forEach(input => {
    input.addEventListener('input', validateForm);
});

birthdateInput.addEventListener('changeDate', calculateAndSetAge);

allDropdowns.forEach(setupDropdown);
validateForm();

// --- Form Submission Logic ---

const getDropdownValue = (elementId) => {
    const element = document.getElementById(elementId);
    const span = element.querySelector('span');
    const text = span ? span.textContent.trim() : element.textContent.trim();
    return text.startsWith('Select') ? null : text;
};

// Submit button: hide main modal and show confirmation modal
submitButton.addEventListener('click', function(event) {
    event.preventDefault();
    
    // Build the payload
    midwifePayload = {
        firstName: document.getElementById('midwifeFirstName').value.trim(),
        lastName: document.getElementById('midwifeLastName').value.trim(),
        middleName: document.getElementById('midwifeMiddleName').value.trim() || null,
        suffix: getDropdownValue('prefixDropdown') || null,
        birthdate: birthdateInput.value.trim(),
        age: ageInput.value.trim(),
        sex: getDropdownValue('sexDropdown'),
        civilStatus: getDropdownValue('civilStatusDropdown'),
        religion: getDropdownValue('religionDropdown'),
        contactNo: document.getElementById('contactNo').value.trim(),
        barangayId: document.getElementById('barangayDropdown').dataset.selectedId,
        email: document.getElementById('midwifeEmail').value.trim(),
    };
    
    // Prepare confirmation modal
    const fullName = `${midwifePayload.firstName} ${midwifePayload.lastName}`;
    midwifeNameSpan.textContent = fullName;
    
    // Reset confirmation state
    confirmCheckbox.checked = false;
    proceedButton.disabled = true;
    
    // Switch modals using Flowbite
    addMidwifeModal.hide();
    setTimeout(() => {
        confirmModal.show();
    }, 300);
});

document.getElementById('close-add-mw').addEventListener('click', function(){
    resetForm(); // Reset form first
    addMidwifeModal.hide();
});

// Confirmation checkbox
confirmCheckbox.addEventListener('change', function() {
    proceedButton.disabled = !this.checked;
});

async function submitMidwifeData(payload) {
    // Disable button and show loading state
    proceedButton.disabled = true;
    const originalText = proceedButton.textContent;
    proceedButton.textContent = 'Saving...';
    
    try {
        const response = await fetch('/mho/add-midwife', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (response.ok) {
            // Update success message
            successMesageHeader.textContent = 'Midwife Added';
            successMessage.textContent = `${payload.firstName ?? ''} ${payload.middleName ?? ''} ${payload.lastName ?? ''}${payload.suffix ? ' ' + payload.suffix : ''} has been added`;
            
            // Hide confirmation modal and show success modal
            confirmModal.hide();
            setTimeout(() => {
                successModal.show();
            }, 300);
        } 
        // Handle validation errors (422)
        else if (response.status === 422) {
            let errorMessages = [];
            
            if (data.errors) {
                for (const [field, messages] of Object.entries(data.errors)) {
                    errorMessages.push(...messages);
                }
            }
            
            const errorText = errorMessages.length > 0 
                ? errorMessages.join('\n') 
                : (data.message || 'Validation failed');
            
            alert('Validation Error:\n\n' + errorText);
            
            // Re-enable button so user can fix and retry
            proceedButton.disabled = false;
            proceedButton.textContent = originalText;
        }
        // Handle other server errors
        else {
            alert('Error: ' + (data.message || 'Failed to add midwife. The page will reload.'));
            window.location.reload();
        }
    } catch (error) {
        console.error('Network error:', error);
        alert('Network error occurred. The page will reload.');
        window.location.reload();
    }
}


// Proceed button: submit data
proceedButton.addEventListener('click', function() {
    submitMidwifeData(midwifePayload);
});

// Cancel confirmation: go back to main modal
const cancelConfirmButton = document.getElementById('close-confirm-add-midwife');

cancelConfirmButton.addEventListener('click', function() {
    confirmModal.hide();
        
    addMidwifeModal.show();
});


document.getElementById('add-midwife-button').addEventListener('click', function(){
    addMidwifeModal.show();
});
// Reset form function
const resetForm = () => {
    [...textInputs, birthdateInput, ageInput].forEach(input => {
        input.value = '';
    });
    
    allDropdowns.forEach(button => {
        const span = button.querySelector('span');
        const defaultText = button.id === 'prefixDropdown' ? 'Select' : 
                           button.id === 'sexDropdown' ? 'Select Sex' :
                           button.id === 'civilStatusDropdown' ? 'Select Status' :
                           button.id === 'religionDropdown' ? 'Select Religion' :
                           button.id === 'barangayDropdown' ? 'Select Barangay' : 'Select';
        if (span) {
            span.textContent = defaultText;
        }
        delete button.dataset.selectedId;
    });
    
    validateForm();
};

// Success modal close: redirect
closeSuccessModalButton.addEventListener('click', function(){
    window.location.href = '/mho/midwives';
});
