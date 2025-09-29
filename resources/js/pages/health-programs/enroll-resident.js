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


export const enrollResidentModal = new Modal(enrollResidentModalEl);

const openEnrollModalBtn = document.getElementById('openEnrollModalBtn');

// Function to fetch residents with optional payload
function fetchResidents(payload = { search: null, purok_id: null }) {
    const url = '/barangay/resident/enroll'; // your fixed endpoint
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        // Send payload as query parameters for GET
    })
    .then(async response => {
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        const data = await response.json();
        return data.residents;
    })
    .then(residents => {
        console.log('Successfully fetched residents:', residents);
        // Optionally render resident cards here
    })
    .catch(error => {
        console.error('There was a problem fetching residents:', error);
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