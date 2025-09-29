// Main modal container
const enrollResidentModalEl = document.getElementById('enroll-resident-modal');

// Search and filter controls
const enrollResidentSearchInput = document.getElementById('enrollResidentSearchInput');
const enrollResidentPurokFilter = document.getElementById('enrollResidentPurokFilter');
const enrollResidentScanQRBtn = document.getElementById('enrollResidentScanQRBtn');

// Resident list and cards
const enrollResidentListContainer = document.getElementById('enrollResidentListContainer');
const residentCards = document.querySelectorAll('.resident-card'); // This will be a NodeList of all resident card divs

// Modal footer buttons
const enrollResidentCancelBtn = document.getElementById('enrollResidentCancelBtn');
const enrollResidentProceedBtn = document.getElementById('enrollResidentProceedBtn');

const selectedHighlightClasses = ['bg-sky-100', 'dark:bg-sky-800', 'border-sky-500'];

let selectedResidentId = null;

export const enrollResidentModal = new Modal(enrollResidentModalEl);

const openEnrollModalBtn = document.getElementById('openEnrollModalBtn');

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
    } else {
        selectedResidentId = null;
    }

    console.log('Selected Resident ID:', selectedResidentId);
});

function fetchResidents(payload = { search: '', purok_id: '' }) {
    const params = new URLSearchParams();
    if (payload.search) params.append('search', payload.search);
    if (payload.purok_id) params.append('purok_id', payload.purok_id);

    const url = `/barangay/resident/enroll?${params.toString()}`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
    })
    .then(async response => {
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        const data = await response.json();
        return data.residents;
    })
    .then(residents => {
        // Call the render function with the fetched data
        renderResidents(residents);
    })
    .catch(error => {
        console.error('There was a problem fetching residents:', error);
        enrollResidentListContainer.innerHTML = `<p class="text-center text-red-500 p-4">Failed to load residents.</p>`;
    });
}
// Call it when opening the modal
openEnrollModalBtn.addEventListener('click', function () {
    enrollResidentModal.show();
    fetchResidents({ search: null, purok_id: null });
});

enrollResidentCancelBtn.addEventListener('click', function(){
    enrollResidentModal.hide();
});