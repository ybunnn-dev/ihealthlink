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
const cancelConfirmButton = document.getElementById('close-confirm-add-midwife');
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

// Helper function to get dropdown value
const getDropdownValue = (elementId) => {
    const element = document.getElementById(elementId);
    const span = element.querySelector('span');
    const text = span ? span.textContent.trim() : element.textContent.trim();
    return text.startsWith('Select') ? null : text;
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

// Close main modal button
document.getElementById('close-add-mw').addEventListener('click', function(){
    resetForm(); // Reset form first
    addMidwifeModal.hide();
});

// Confirmation checkbox
confirmCheckbox.addEventListener('change', function() {
    proceedButton.disabled = !this.checked;
});

// Proceed button: submit data to server
proceedButton.addEventListener('click', async function() {
    // 1. Provide immediate UI feedback
    const originalButtonText = proceedButton.innerHTML;
    proceedButton.innerHTML = `
        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
        </svg>
        Saving...
    `;
    proceedButton.disabled = true;
    cancelConfirmButton.disabled = true;
   
    const midwifeFullName = `${midwifePayload.firstName} ${midwifePayload.middleName || ''} ${midwifePayload.lastName}${midwifePayload.suffix ? ' ' + midwifePayload.suffix : ''}`.replace(/\s+/g, ' ').trim();

    try {
        const response = await fetch('/mho/midwife/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(midwifePayload)
        });

        const data = await response.json();

        // Handle success
        if (response.ok) {
            confirmModal.hide(); 
            successMesageHeader.textContent = "Midwife Created";
            successMessage.textContent = midwifeFullName + " has been added as a Midwife";
            successModal.show();
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
            window.location.reload();
        }
        // Handle other errors - reload page
        else {
            console.error('Server Error:', data);
            alert('Error: ' + (data.message || 'An error occurred. The page will reload.'));
            window.location.reload();
        }

    } catch (error) {
        console.error('Fetch Error:', error);
        alert('Network error occurred. The page will reload.');
        window.location.reload();
    } finally {
        // Only restore button state if we haven't reloaded
        // (This will only execute on success since errors reload the page)
        proceedButton.innerHTML = originalButtonText;
        proceedButton.disabled = false;
        cancelConfirmButton.disabled = false;
    }
});

// Cancel confirmation: go back to main modal
cancelConfirmButton.addEventListener('click', function() {
    confirmModal.hide();
    setTimeout(() => {
        addMidwifeModal.show();
    }, 300);
});

// Open modal button
document.getElementById('add-midwife-button').addEventListener('click', function(){
    addMidwifeModal.show();
});

// Success modal close: redirect
closeSuccessModalButton.addEventListener('click', function(){
    window.location.href = '/mho/midwives';
});
