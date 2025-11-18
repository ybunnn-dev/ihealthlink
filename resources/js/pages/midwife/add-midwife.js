// --- Global State ---
let midwifePayload = {}; // NEW: Holds the form data for the confirmation step

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

//success modal elements
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

// --- NEW: Element Selection (Modal Management) ---
const addMidwifeModalEl = document.getElementById('add-midwife-modal');
const confirmModalEl = document.getElementById('confirm-add-midwife-modal');

// Manual modal functions - more reliable than Flowbite Modal class
const showModal = (modalEl) => {
    if (modalEl) {
        modalEl.classList.remove('hidden');
        modalEl.setAttribute('aria-hidden', 'false');
        modalEl.style.display = 'flex';
        document.body.classList.add('overflow-hidden');
    }
};

const hideModal = (modalEl) => {
    if (modalEl) {
        modalEl.classList.add('hidden');
        modalEl.setAttribute('aria-hidden', 'true');
        modalEl.style.display = 'none';
        document.body.classList.remove('overflow-hidden');
    }
};

const confirmCheckbox = document.getElementById('confirm-midwife-checkbox');
const proceedButton = document.getElementById('confirm-add-midwife-btn');
const midwifeNameSpan = document.getElementById('midwife-name-to-confirm');

// --- Setup & Helper Functions ---

// Setup Age Input
ageInput.disabled = true;
ageInput.classList.add('bg-gray-100');

const options = {
    // This prevents the modal from closing when the backdrop is clicked
    backdrop: 'static', 
};

// Populate Barangay Dropdown (This function is unchanged)
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

// Validation (This function is unchanged)
const validateForm = () => {
    const allInputsFilled = [...textInputs, birthdateInput, ageInput].every(input => input.value.trim() !== '');
    const allDropdownsSelected = requiredDropdowns.every(button => !button.textContent.trim().startsWith('Select'));
    submitButton.disabled = !(allInputsFilled && allDropdownsSelected);
};

// Age Calculation (This function is unchanged as you requested)
const calculateAndSetAge = () => {
    const birthDateString = birthdateInput.value;
    console.log('boto mo');
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

// Dropdown Setup (This function is unchanged)
const setupDropdown = (button) => {
    const menuId = button.getAttribute('data-dropdown-toggle');
    const menu = document.getElementById(menuId);
    if (!menu) return;
    const options = menu.querySelectorAll('ul li button');
    options.forEach(option => {
        option.addEventListener('click', () => {
            button.textContent = option.textContent.trim();
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
validateForm(); // Initial validation check


// --- Form Submission Logic ---

const getDropdownValue = (elementId) => {
    const element = document.getElementById(elementId);
    const text = element.textContent.trim();
    return text.startsWith('Select') ? null : text;
};

// MODIFIED: This button now temporarily closes the main modal and opens the confirmation modal
submitButton.addEventListener('click', function(event) {
    event.preventDefault();
    
    // 1. Build the payload and store it globally
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
    
    // 2. Prepare the confirmation modal
    const fullName = `${midwifePayload.firstName} ${midwifePayload.lastName}`;
    midwifeNameSpan.textContent = fullName;
    
    // Reset confirmation modal state for next use
    confirmCheckbox.checked = false;
    proceedButton.disabled = true;
    
    // 3. Hide the main modal and show the confirmation modal
    hideModal(addMidwifeModalEl);
    showModal(confirmModalEl);
});

// NEW: Event listeners for the confirmation modal
confirmCheckbox.addEventListener('change', function() {
    // Enable/disable the proceed button based on checkbox state
    proceedButton.disabled = !this.checked;
});

// Function to submit midwife data to the API
async function submitMidwifeData(payload) {
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
            console.log('Success:', data);
            
            const successModal = new Modal(successModalEl, createModalOptions(successModalEl));
            const confAddMidwifeModal = new Modal(createModalOptions(confirmModalEl));

            if(successModal && confAddMidwifeModal){
                successMesageHeader.textContent = 'Midwife Added';
                successMessage.textContent = `${payload.firstName ?? ''} ${payload.middleName ?? ''} ${payload.lastName ?? ''}${payload.suffix ? ' ' + payload.suffix : ''} has been added`;
                confAddMidwifeModal.hide();
                successModal.show();
            }
        } else {
            console.error('Error:', data);
            alert('Error adding midwife: ' + (data.message || 'Please check the form and try again.'));
        }
    } catch (error) {
        console.error('Network error:', error);
        alert('Network error. Please try again.');
    }
}

// Modified event listener for the proceed button
proceedButton.addEventListener('click', function() {
    // Submit the data to the API
    submitMidwifeData(midwifePayload);
    
    // Hide the confirmation modal
    hideModal(confirmModalEl);
});

// NEW: Handle cancel action in confirmation modal
const cancelConfirmButton = document.getElementById('close-confirm-add-midwife');
if (cancelConfirmButton) {
    cancelConfirmButton.addEventListener('click', function() {
        // When user cancels confirmation, hide confirmation modal and show main modal again
        hideModal(confirmModalEl);
        showModal(addMidwifeModalEl);
    });
}

// Optional: Function to reset the form (you can use this if needed)
const resetForm = () => {
    [...textInputs, birthdateInput, ageInput].forEach(input => {
        input.value = '';
    });
    
    allDropdowns.forEach(button => {
        const defaultText = button.id === 'prefixDropdown' ? 'Select Prefix' : 
                           button.id === 'sexDropdown' ? 'Select Sex' :
                           button.id === 'barangayDropdown' ? 'Select Barangay' : 'Select';
        button.textContent = defaultText;
        delete button.dataset.selectedId;
    });
    
    validateForm();
};


closeSuccessModalButton.addEventListener('click', function(){
    window.location.href = '/mho/midwives';
});