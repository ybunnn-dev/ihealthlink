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


const family = window.family; // Added this based on your payload

// --- Element Variables (Modal 1: Search) ---
const addResidentModalEl = document.getElementById('addResidentModal');
const residentSearchInput = document.getElementById('resident-search');
const residentAgeGroupFilter = document.getElementById('resident-age-group-filter');
const residentCardContainer = document.getElementById('residentCardContainer');
const cancelAddResidentBtn = document.getElementById('cancelAddResident');
const confirmAddResidentBtn = document.getElementById('confirmAddResidentBtn'); // This is the "Next" button
const addExTrigger = document.getElementById('add-ex');

// --- Element Variables (Modal 2: Confirm) ---
const confirmAddResidentModalEl = document.getElementById('confirm-add-existing-resident-modal');
const confirmAddResidentCancelBtn = document.getElementById('confirm-add-existing-resident-cancel');
const confirmAddResidentSubmitBtn = document.getElementById('confirm-add-existing-resident-submit'); // This is the *final* submit
const confirmAddResidentCheckbox = document.getElementById('confirm-add-existing-resident-checkbox');
const selectedResidentNameConfirmEl = document.getElementById('selected-existing-resident-name-confirm');

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');


const addResidentModal = new Modal(addResidentModalEl, createModalOptions(addResidentModalEl));
const confirmAddResidentModal = new Modal(confirmAddResidentModalEl, createModalOptions(confirmAddResidentModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

// --- State Variables ---
let selectedResident = null; // Store the full object (id, name, etc.)
let residentSearchResult = []; // Store the last search results
const selectedCardClasses = ['border-blue-500', 'ring-2', 'ring-blue-200'];

// --- Helper Functions ---

/**
 * Gets the CSRF token from the meta tag.
 */
function getCsrfToken() {
    const token = document.querySelector('meta[name="csrf-token"]');
    if (!token) console.error('CSRF token meta tag not found!');
    return token ? token.getAttribute('content') : '';
}

/**
 * Calculates age from a birthdate string.
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
        return 'N/A';
    }
}

/**
 * Debounce function to limit API calls.
 */
function debounce(func, delay = 300) {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(this, args);
        }, delay);
    };
}

/**
 * Resets the search modal.
 */
function resetAddResidentModal() {
    residentSearchInput.value = '';
    residentAgeGroupFilter.value = 'All age group';
    residentCardContainer.innerHTML = '';
    selectedResident = null;
    residentSearchResult = [];
    confirmAddResidentBtn.disabled = true;
}

/**
 * Resets the confirmation modal.
 */
function resetConfirmAddResidentModal() {
    confirmAddResidentCheckbox.checked = false;
    confirmAddResidentSubmitBtn.disabled = true;
    confirmAddResidentSubmitBtn.innerHTML = 'Confirm & Add';
    selectedResidentNameConfirmEl.textContent = '[Resident Name]';
}

// --- Core API and UI Functions ---

/**
 * Generates the HTML for a single resident card.
 */
function createResidentCardHTML(resident) {
    const age = calculateAge(resident.birthdate);
    const residentName = `${resident.firstName} ${resident.middleName} ${resident.lastName}`;
    const purok = resident.family?.household?.purok?.name || 'N/A';
    const barangay = resident.family.household.purok.barangay.name;

    return `
        <button type="button" 
                data-resident-id="${resident.id}" 
                class="resident-selection-card flex items-center p-3 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 focus:outline-none">
            <div class="flex justify-between w-full text-left">
                <div>
                    <p class="font-semibold text-main_font">${residentName}</p>
                    <p class="text-xs text-gray-500">
                        <span>ID: ${resident.id}</span>
                        <span class="mx-1.5">&middot;</span>
                        <span>${purok}, ${barangay}</span>
                    </p>
                </div>
                <div class="flex items-center text-xs text-gray-600">
                    <span class="bg-gray-200 px-2 py-1 rounded-full">Age: ${age}</span>
                </div>
            </div>
        </button>
    `;
}

/**
 * Fetches residents from the API.
 */
async function fetchResidents() {
    const search = residentSearchInput.value;
    const ageGroup = residentAgeGroupFilter.value;

    residentCardContainer.innerHTML = '<p class="text-center text-gray-500 p-4">Loading...</p>';
    selectedResident = null;
    confirmAddResidentBtn.disabled = true;

    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (ageGroup && ageGroup !== 'All age group') params.append('age_group', ageGroup);

    try {
        const response = await fetch(`/barangay/residents/get/all?${params.toString()}`, {
            method: 'GET',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() }
        });

        if (!response.ok) throw new Error('Network response was not ok');
        
        const result = await response.json();

        if (result.success && result.data.length > 0) {
            residentSearchResult = result.data; // Store results
            residentCardContainer.innerHTML = '';
            residentSearchResult.forEach(resident => {
                const cardHTML = createResidentCardHTML(resident);
                residentCardContainer.insertAdjacentHTML('beforeend', cardHTML);
            });
        } else {
            residentSearchResult = [];
            residentCardContainer.innerHTML = '<p class="text-center text-gray-500 p-4">No residents found.</p>';
        }

    } catch (error) {
        console.error('Error fetching residents:', error);
        residentCardContainer.innerHTML = '<p class="text-center text-red-500 p-4">Failed to load residents. Please try again.</p>';
    }
}

// --- Event Listeners ---

// [Trigger] Show the search modal
addExTrigger.addEventListener('click', function() {
    resetAddResidentModal();
    resetConfirmAddResidentModal();
    addResidentModal.show();
    fetchResidents(); // Load initial list
});

// [Close] Hide the search modal
cancelAddResidentBtn.addEventListener('click', function() {
    addResidentModal.hide();
    resetAddResidentModal();
});

// [Filter] Search input
residentSearchInput.addEventListener('keyup', debounce(fetchResidents, 300));

// [Filter] Age group select
residentAgeGroupFilter.addEventListener('change', fetchResidents);

// [Selection] Click on a resident card
residentCardContainer.addEventListener('click', function(event) {
    const clickedCard = event.target.closest('.resident-selection-card');
    if (!clickedCard) return;

    const allCards = residentCardContainer.querySelectorAll('.resident-selection-card');
    allCards.forEach(c => c.classList.remove(...selectedCardClasses));
    clickedCard.classList.add(...selectedCardClasses);

    const residentId = parseInt(clickedCard.dataset.residentId, 10);
    selectedResident = residentSearchResult.find(r => r.id === residentId);
    
    confirmAddResidentBtn.disabled = false;
});

// [Modal 1 Submit] "Add Resident" button (now acts as "Next")
confirmAddResidentBtn.addEventListener('click', function() {
    if (selectedResident) {
        const residentName = `${selectedResident.firstName} ${selectedResident.lastName}`;
        selectedResidentNameConfirmEl.textContent = residentName;
        addResidentModal.hide();
        confirmAddResidentModal.show();
    }
});

// [Modal 2 Cancel] "Cancel" button (goes back to search)
confirmAddResidentCancelBtn.addEventListener('click', function() {
    confirmAddResidentModal.hide();
    resetConfirmAddResidentModal();
    addResidentModal.show();
});

// [Modal 2 Checkbox] Enable/disable submit
confirmAddResidentCheckbox.addEventListener('change', function() {
    confirmAddResidentSubmitBtn.disabled = !this.checked;
});

confirmAddResidentSubmitBtn.addEventListener('click', async function() {
    if (!selectedResident) return;

    // Disable both buttons
    confirmAddResidentCancelBtn.disabled = true;
    this.disabled = true;
    
    // Set loading state
    this.innerHTML = `
        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0492C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
        </svg>
        Saving...
    `;
    
    const payload = {
        resident_id: selectedResident.id,
        family_id: family.id,
    };

    console.log('Final confirmation to add Resident:', payload);

    try {
        const response = await fetch('/barangay/resident/transfer', {
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
            // Handle server-side errors (e.g., validation)
            throw new Error(data.message || 'An unknown server error occurred.');
        }

        // --- Success ---
        console.log('Success:', data);
        
        // Hide confirmation modal
        confirmAddResidentModal.hide();
        
        // Update success modal content
        successMesageHeader.textContent = 'Success!';
        successMessage.textContent = data.message || 'Resident added to family successfully!';
        
        // Show success modal
        successModal.show();
        
        // Reset modals
        resetAddResidentModal();
        resetConfirmAddResidentModal();

    } catch (error) {
        // --- Error ---
        console.error('Error:', error);
        alert('Error: ' + error.message);

        // Re-enable both buttons and reset HTML
        confirmAddResidentCancelBtn.disabled = false;
        this.disabled = false;
        this.innerHTML = 'Confirm & Add';
    }
});

// Add event listener for success modal close button to reload page
closeSuccessModalButton.addEventListener('click', function() {
    successModal.hide();
    window.location.reload();
});
