// Main modal container
const enrollResidentModalEl = document.getElementById('enroll-resident-modal');

// Search and filter controls
const enrollResidentSearchInput = document.getElementById('enrollResidentSearchInput');
const enrollResidentPurokFilter = document.getElementById('enrollResidentPurokFilter');

let isPurokFilterPopulated = false;
// Resident list and cards
const enrollResidentListContainer = document.getElementById('enrollResidentListContainer');
const residentCards = document.querySelectorAll('.resident-card'); // This will be a NodeList of all resident card divs

const healthProgramId = parseInt(document.getElementById('hpdata').textContent.trim(), 10);
// Modal footer buttons
const enrollResidentCancelBtn = document.getElementById('enrollResidentCancelBtn');
const enrollResidentProceedBtn = document.getElementById('enrollResidentProceedBtn');

const selectedHighlightClasses = ['bg-sky-100', 'dark:bg-sky-800', 'border-sky-500'];

let selectedResidentId = null;
// The main modal container element
const enrollResidentConfirmationModalEl = document.getElementById('enroll-resident-confirmation-modal');

// The <strong> tag where the resident's name will be displayed
const residentNameToConfirmEl = document.getElementById('resident-name-to-confirm');

// The confirmation checkbox
const confirmEnrollmentCheckbox = document.getElementById('confirm-enrollment-checkbox');

// The "Cancel" button in the footer
const enrollResidentConfirmationCancelBtn = document.getElementById('enroll-resident-confirmation-cancel-btn');

// The "Confirm & Proceed" button, which is disabled by default
const enrollResidentConfirmationProceedBtn = document.getElementById('enroll-resident-confirmation-proceed-btn');

let chosenResidentName = null;

const enrollResidentConfirmation = new Modal(enrollResidentConfirmationModalEl);
export const enrollResidentModal = new Modal(enrollResidentModalEl);

const openEnrollModalBtn = document.getElementById('openEnrollModalBtn');

function populatePurokFilter(puroks) {
    if (isPurokFilterPopulated || !puroks) return; // Exit if already populated or no puroks

    puroks.forEach(purok => {
        const option = document.createElement('option');
        option.value = purok.id;
        option.textContent = purok.name; // Assuming 'purok_name' from your backend
        enrollResidentPurokFilter.appendChild(option);
    });

    isPurokFilterPopulated = true; // Set flag to true after populating
}

function resetModalState() {
    // 1. Reset inputs
    enrollResidentSearchInput.value = '';
    enrollResidentPurokFilter.selectedIndex = 0; // Reset to "Filter by Purok"

    // 2. Clear the selected resident ID
    selectedResidentId = null;

    // 3. Show a loading state in the resident list
    enrollResidentListContainer.innerHTML = `<p class="text-center text-gray-500 p-4">Loading residents...</p>`;
}

function renderResidents(residents) {
    // Clear the existing list first
    enrollResidentListContainer.innerHTML = '';

    if (!residents || residents.length === 0) {
        enrollResidentListContainer.innerHTML = `<p class="text-center text-gray-500 p-4">No residents found.</p>`;
        return;
    }
    
    // Create a card for each resident and add it to the container
    residents.forEach(resident => {
        const residentCardHTML = `
            <div class="resident-card p-4 border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer" data-resident-id="${resident.id}" tabindex="0">
                <p class="font-semibold text-main_font pointer-events-none">${resident.firstName} ${resident.middleName} ${resident.lastName}</p>
                <p class="text-sm text-normal_font pointer-events-none">${resident.purok.name}</p>
            </div>
        `;
        enrollResidentListContainer.insertAdjacentHTML('beforeend', residentCardHTML);
    });
}

enrollResidentListContainer.addEventListener('click', (event) => {
    const clickedCard = event.target.closest('.resident-card');
    if (!clickedCard) return;

    // Find the card that is currently selected (if any)
    const previouslySelected = enrollResidentListContainer.querySelector('.border-sky-500');

    // Always remove the highlight from the previously selected card first
    if (previouslySelected) {
        previouslySelected.classList.remove(...selectedHighlightClasses);
    }

    if (previouslySelected !== clickedCard) {
        clickedCard.classList.add(...selectedHighlightClasses);

        // Store the ID of the new selection
        selectedResidentId = clickedCard.dataset.residentId;
        
        const nameElement = clickedCard.querySelector('p.font-semibold');
        chosenResidentName = nameElement ? nameElement.textContent.trim() : '';

        enrollResidentProceedBtn.disabled = false;
    } else {
        selectedResidentId = null;
        enrollResidentProceedBtn.disabled = true;
    }

    console.log('Selected Resident ID:', selectedResidentId);
});

function fetchResidents(payload = { search: '', purok_id: '' }) {
    const params = new URLSearchParams();
    if (payload.search) params.append('search', payload.search);
    if (payload.purok_id) params.append('purok_id', payload.purok_id);

    const url = `/barangay/resident/enroll?${params.toString()}&healthProgramId=${healthProgramId}`;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, { 
        method: 'GET', // Explicitly state the method
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json' 
        }
     })
    .then(async response => {
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        return await response.json(); // Return the full JSON object
    })
    .then(data => {
        // Populate the purok filter (will only run once)
        populatePurokFilter(data.puroks);

        // Render the resident cards
        renderResidents(data.residents);
    })
    .catch(error => {
        console.error('There was a problem fetching residents:', error);
        enrollResidentListContainer.innerHTML = `<p class="text-center text-red-500 p-4">Failed to load residents.</p>`;
    });
}

// Example: When the main button to open the modal is clicked
openEnrollModalBtn.addEventListener('click', function () {
    enrollResidentModal.show();
    resetModalState();  // Reset the state first
    fetchResidents();   // Then fetch the initial, unfiltered data
});

// Listen for input in the search field
enrollResidentSearchInput.addEventListener('keyup', (event) => {
    const searchQuery = event.target.value;
    fetchResidents({ search: searchQuery, purok_id: null });
});

// Listen for changes in the purok filter
enrollResidentPurokFilter.addEventListener('change', (event) => {
    const purokId = event.target.value;
    fetchResidents({ search: null, purok_id: purokId });
});


enrollResidentCancelBtn.addEventListener('click', function(){
    enrollResidentModal.hide();
    enrollResidentProceedBtn.disabled = true;
});

enrollResidentProceedBtn.addEventListener('click', function(){
    enrollResidentModal.hide();
    residentNameToConfirmEl.textContent = chosenResidentName;
    enrollResidentConfirmation.show();
});

confirmEnrollmentCheckbox.addEventListener('change', function(){
    enrollResidentConfirmationProceedBtn.disabled = !this.checked;
});

enrollResidentConfirmationCancelBtn.addEventListener('click', function(){
    enrollResidentConfirmation.hide();
    enrollResidentModal.show();
});

enrollResidentConfirmationProceedBtn.addEventListener('click', function() {
    const url = `/barangay/health-program/${healthProgramId}/enroll/${selectedResidentId}`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({}) // can send additional payload if needed later
    })
    .then(res => res.json())
    .then(data => console.log(data))
    .catch(err => console.error(err));
});