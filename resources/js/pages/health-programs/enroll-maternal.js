const openMaternityModalBtn = document.getElementById('openEnrollMaternityModalBtn');

const maternityModalEl = document.getElementById('enroll-maternity-modal');

const maternityModalTitle = document.getElementById('maternity-modal-title');
const maternityModalSubtitle = document.getElementById('maternity-modal-subtitle');

// Step containers
const maternityStep1 = document.getElementById('maternity-step-1');
const maternityStep2 = document.getElementById('maternity-step-2');

// Footer navigation buttons
const maternityCancelBtn = document.getElementById('maternityCancelBtn');
const maternityBackBtn = document.getElementById('maternityBackBtn');
const maternityNextBtn = document.getElementById('maternityNextBtn');

let selectedResidentId = null;

const healthProgramId = parseInt(document.getElementById('hpdata').textContent.trim(), 10);

let isPurokFilterPopulated = false;
// --- Step 1: Resident Selection Elements ---
const residentSearchInput = document.getElementById('enrollFemaleResidentSearchInput');
const purokFilterSelect = document.getElementById('enrollFemaleResidentPurokFilter');
const scanQrBtn = document.getElementById('enroll-maternal-scan-qr');
const residentListContainer = document.getElementById('enrollFemaleResidentListContainer');

const maternityResidentNameInput = document.getElementById('maternity_resident_name');
const lmpInput = document.getElementById('last_menstrual_period');
const edcInput = document.getElementById('expected_date_of_confinement');
const gravidaInput = document.getElementById('gravida');
const paraInput = document.getElementById('para');

const maternityModal = new Modal(maternityModalEl);

function renderResidents(residents) {
    // Clear the existing list first
    console.log(residents);
    residentListContainer.innerHTML = '';

    if (!residents || residents.length === 0) {
        residentListContainer.innerHTML = `<p class="text-center text-gray-500 p-4">No residents found.</p>`;
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
        residentListContainer.insertAdjacentHTML('beforeend', residentCardHTML);
    });
}

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
    residentSearchInput.value = '';
    purokFilterSelect.selectedIndex = 0; // Reset to "Filter by Purok"

    // 2. Clear the selected resident ID
    selectedResidentId = null;

    // 3. Show a loading state in the resident list
    residentListContainer.innerHTML = `<p class="text-center text-gray-500 p-4">Loading residents...</p>`;
}

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


openMaternityModalBtn.addEventListener('click', function(){
    resetModalState();
    fetchResidents(); 
    maternityModal.show();
});