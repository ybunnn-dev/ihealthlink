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
let chosenResidentName = null;

const healthProgramId = parseInt(document.getElementById('hpdata').textContent.trim(), 10);

const selectedHighlightClasses = ['bg-sky-100', 'dark:bg-sky-800', 'border-sky-500'];
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

// === Modal Elements ===
const steps = [
    document.getElementById('maternity-step-1'),
    document.getElementById('maternity-step-2')
];


let currentStep = 0; // Use 0-based index
const totalSteps = steps.length;

const goToStep = (stepIndex) => {
    const direction = stepIndex > currentStep ? 'next' : 'prev';
    const currentStepEl = steps[currentStep];
    const targetStepEl = steps[stepIndex];

    // --- Animate the target step IN ---
    targetStepEl.classList.add(direction === 'next' ? 'translate-x-full' : '-translate-x-full');
    // 2. Remove 'hidden' to make it part of the layout
    targetStepEl.classList.remove('hidden');

    // 3. This is the trick: Wait for the next browser paint cycle...
    requestAnimationFrame(() => {
        // 4. ...then remove the translate class to slide it into view.
        currentStepEl.classList.add(direction === 'next' ? '-translate-x-full' : 'translate-x-full');
        targetStepEl.classList.remove('translate-x-full', '-translate-x-full');
    });

    // --- Hide the old step AFTER the animation is done ---
    setTimeout(() => {
        currentStepEl.classList.add('hidden');
        currentStepEl.classList.remove('-translate-x-full', 'translate-x-full');
    }, 500); // This must match the CSS duration

    currentStep = stepIndex;
    updateButtonsAndText();
};

const updateButtonsAndText = () => {
    maternityBackBtn.classList.toggle('hidden', currentStep === 0);
    maternityCancelBtn.classList.toggle('hidden', currentStep > 0);
    maternityNextBtn.textContent = currentStep === totalSteps - 1 ? 'Enroll' : 'Next';

    if (currentStep === 0) {
        maternityModalSubtitle.textContent = 'Step 1: Select a Resident';
    } else if (currentStep === 1) {
        maternityModalSubtitle.textContent = 'Step 2: Enter Maternity Details';
    }
};

// Event Listeners
maternityNextBtn.addEventListener('click', () => {
    if (currentStep < totalSteps - 1) {
        goToStep(currentStep + 1);
        
        maternityNextBtn.disabled = true;
    } else {
        alert('Enrolling resident...');
    }
});

maternityBackBtn.addEventListener('click', () => {
    if (currentStep > 0) {
        goToStep(currentStep - 1);
    }
});

// Initialize
updateButtonsAndText();

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

residentListContainer.addEventListener('click', (event) => {
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

        maternityNextBtn.disabled = false;
    } else {
        selectedResidentId = null;
        maternityNextBtn.disabled = true;
    }

    console.log('Selected Resident ID:', selectedResidentId);
});


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

    const url = `/barangay/maternity/resident/enroll?${params.toString()}&healthProgramId=${healthProgramId}`;

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
        residentListContainer.innerHTML = `<p class="text-center text-red-500 p-4">Failed to load residents.</p>`;
    });
}

openMaternityModalBtn.addEventListener('click', function(){
    resetModalState();
    fetchResidents(); 
    maternityModal.show();
});

