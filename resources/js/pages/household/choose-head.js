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

// --- Your Data (from window) ---
const families = window.families;
const household = window.household;

// --- Modal Initialization (Modal 1: Choose Head) ---
const chooseHeadModalEl = document.getElementById('chooseHeadModal');
const confirmAssignHeadModalEl = document.getElementById('confirm-assign-head-modal');

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

const chooseHeadModal = new Modal(chooseHeadModalEl, createModalOptions(chooseHeadModalEl));
const confirmAssignHeadModal = new Modal(confirmAssignHeadModalEl, createModalOptions(confirmAssignHeadModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

// --- Element Variables (Modal 1) ---
const headCardContainer = document.getElementById('headCardContainer');
const cancelChooseHeadBtn = document.getElementById('cancelChooseHead');
const confirmChooseHeadBtn = document.getElementById('confirmChooseHeadBtn');
const chooseHeadTrigger = document.getElementById('change-head-btn');

// --- Element Variables (Modal 2) ---
const confirmAssignHeadCancelBtn = document.getElementById('confirm-assign-head-cancel');
const confirmAssignHeadSubmitBtn = document.getElementById('confirm-assign-head-submit');
const confirmAssignHeadCheckbox = document.getElementById('confirm-assign-head-checkbox');
const newHeadNameConfirmEl = document.getElementById('new-head-name-confirm');

// --- State Variables ---
let selectedHeadId = null;
let allHouseholdResidents = [];
const selectedClasses = ['border-blue-500', 'ring-2', 'ring-blue-200'];


function getCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    if (!token) {
        console.error('CSRF token meta tag not found!');
    }
    return token ? token.getAttribute('content') : '';
}

/**
 * Calculates age from a birthdate string (handles YYYY-MM-DD and MM/DD/YYYY).
 */
function calculateAge(birthdateString) {
    if (!birthdateString) return 'N/A';
    let birthDate;
    try {
        if (birthdateString.includes('/')) {
            const [month, day, year] = birthdateString.split('/');
            birthDate = new Date(`${year}-${month}-${day}`);
        } else {
            birthDate = new Date(birthdateString);
        }
        if (isNaN(birthDate.getTime())) return 'N/A';
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    } catch (e) {
        console.error("Could not parse age:", birthdateString, e);
        return 'N/A';
    }
}

/**
 * Generates the HTML for a single resident choice card.
 */
function createResidentCardHTML(resident, currentHeadId) {
    const isCurrentHead = resident.id === currentHeadId;
    const selectedState = isCurrentHead ? selectedClasses.join(' ') : '';
    const age = calculateAge(resident.birthdate);
    const residentName = `${resident.firstName} ${resident.lastName}`;

    return `
        <button type="button" 
                data-resident-id="${resident.id}" 
                class="resident-selection-card flex items-center p-3 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 focus:outline-none ${selectedState}">
            <div class="flex justify-between w-full text-left">
                <div>
                    <p class="font-semibold text-main_font">${residentName}</p>
                    <p class="text-xs text-gray-500">
                        <span>ID: ${resident.id}</span>
                    </p>
                </div>
                <div class.flex items-center text-xs text-gray-600">
                    <span class="bg-gray-200 px-2 py-1 rounded-full">Age: ${age}</span>
                </div>
            </div>
        </button>
    `;
}

/**
 * Clears and repopulates the modal list with residents.
 */
function loadHouseholdMembers(residentsArray, currentHeadId) {
    headCardContainer.innerHTML = '';
    if (!residentsArray || residentsArray.length === 0) {
        headCardContainer.innerHTML = '<p class="text-center text-gray-500">No residents found in this household.</p>';
        return;
    }
    residentsArray.forEach(resident => {
        const cardHTML = createResidentCardHTML(resident, currentHeadId);
        headCardContainer.insertAdjacentHTML('beforeend', cardHTML);
    });
    selectedHeadId = currentHeadId;
    confirmChooseHeadBtn.disabled = false;
}

/**
 * Resets the selection modal to its default, unselected state.
 */
function resetSelectionModal() {
    selectedHeadId = null;
    confirmChooseHeadBtn.disabled = true;
    headCardContainer.innerHTML = '';
}

function resetConfirmModal() {
    confirmAssignHeadCheckbox.checked = false;
    confirmAssignHeadSubmitBtn.disabled = true;
    confirmAssignHeadSubmitBtn.innerHTML = 'Confirm & Assign';
    newHeadNameConfirmEl.textContent = '[Resident Name]';
}


chooseHeadTrigger.addEventListener('click', function() {
    allHouseholdResidents = families.flatMap(family => family.residents);
    const currentHeadId = household ? household.head_id : null;
    if (currentHeadId === null) {
        console.warn('household.head_id is not available. Cannot pre-select head.');
    }
    loadHouseholdMembers(allHouseholdResidents, currentHeadId);
    chooseHeadModal.show();
});

cancelChooseHeadBtn.addEventListener('click', function() {
    resetSelectionModal();
    chooseHeadModal.hide();
});

headCardContainer.addEventListener('click', function(event) {
    const clickedCard = event.target.closest('.resident-selection-card');
    if (!clickedCard) return;
    const allCards = headCardContainer.querySelectorAll('.resident-selection-card');
    allCards.forEach(c => c.classList.remove(...selectedClasses));
    clickedCard.classList.add(...selectedClasses);
    selectedHeadId = parseInt(clickedCard.dataset.residentId, 10);
    confirmChooseHeadBtn.disabled = false;
});

confirmChooseHeadBtn.addEventListener('click', function() {
    if (!selectedHeadId) return;
    const currentHeadId = household ? household.head_id : null;

    if (selectedHeadId === currentHeadId) {
        console.log('No change. Head is still:', selectedHeadId);
        resetSelectionModal();
        chooseHeadModal.hide();
        return;
    }

    const selectedResident = allHouseholdResidents.find(r => r.id === selectedHeadId);
    const residentName = selectedResident ? `${selectedResident.firstName} ${selectedResident.lastName}` : 'This resident';

    newHeadNameConfirmEl.textContent = residentName;
    chooseHeadModal.hide();
    confirmAssignHeadModal.show();
});

// [Modal 2] Cancel button (goes back to selection modal)
confirmAssignHeadCancelBtn.addEventListener('click', function() {
    confirmAssignHeadModal.hide();
    resetConfirmModal();
    chooseHeadModal.show();
});

// [Modal 2] Checkbox logic
confirmAssignHeadCheckbox.addEventListener('change', function() {
    confirmAssignHeadSubmitBtn.disabled = !this.checked;
});

confirmAssignHeadSubmitBtn.addEventListener('click', async function() {
    // Disable both buttons
    confirmAssignHeadCancelBtn.disabled = true;
    this.disabled = true;
    
    // Change button to loading state with spinner
    this.innerHTML = `
        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0492C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
        </svg>
        Saving...
    `;

    const payload = {
        household_id: household.id,
        head_id: selectedHeadId,
    };

    try {
        const response = await fetch('/barangay/household-head/set', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (!response.ok) {
            // If server returns an error (4xx, 5xx), throw it
            throw new Error(data.message || 'An unknown server error occurred.');
        }

        // --- Success ---
        console.log('Success:', data);
        
        // Hide confirmation modal
        confirmAssignHeadModal.hide();
        
        // Update success modal content
        successMesageHeader.textContent = 'Success!';
        successMessage.textContent = data.message || 'Household head updated successfully!';
        
        // Show success modal
        successModal.show();
        
        // Reset modals
        resetConfirmModal();
        resetSelectionModal();

    } catch (error) {
        // --- Error ---
        console.error('Error:', error);
        alert('Error: ' + error.message);

        // Re-enable both buttons and reset the submit button text
        confirmAssignHeadCancelBtn.disabled = false;
        this.disabled = false;
        this.innerHTML = 'Confirm & Assign';
    }
});

// Add event listener for success modal close button to reload page
closeSuccessModalButton.addEventListener('click', function() {
    successModal.hide();
    window.location.reload(); // Reload to show the new head in the UI
});
