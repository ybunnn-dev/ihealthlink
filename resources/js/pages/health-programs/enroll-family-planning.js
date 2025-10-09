// --- Part 1: Search and Filter Elements (from previous context) ---
const enrollFPResidentSearchInput = document.getElementById('enrollFPResidentSearchInput');
const enrollFPResidentPurokFilter = document.getElementById('enrollFPResidentPurokFilter');
const enrollFPScanQRButton = document.getElementById('enroll-fp-scan-qr');
const enrollFPResidentListContainer = document.getElementById('enrollFPResidentListContainer');
let isPurokFilterPopulated = false;
// --- Part 2: Form Field Elements (from previous context) ---
const fpResidentNameInput = document.getElementById('fp_resident_name');
const fpClientTypeSelect = document.getElementById('fp_client_type');
const fpSourceSelect = document.getElementById('fp_source');
const fpPreviousMethodSelect = document.getElementById('fp_previous_method');

let selectedResidentId = null;
let chosenResidentName = null;

const selectedHighlightClasses = ['bg-sky-100', 'dark:bg-sky-800', 'border-sky-500'];
// --- Family Planning Modal Wrapper ---
const enrollFamilyPlanningModalEl = document.getElementById('enroll-family-planning-modal');

const healthProgramId = parseInt(document.getElementById('hpdata').textContent.trim(), 10);
// --- Modal Header Elements ---
const fpModalTitle = document.getElementById('fp-modal-title');
const fpModalSubtitle = document.getElementById('fp-modal-subtitle');

// --- Modal Step Containers ---
const fpStep1 = document.getElementById('fp-step-1');
const fpStep2 = document.getElementById('fp-step-2');
const fpSteps = [fpStep1, fpStep2];

// --- Modal Footer Buttons ---
const fpCancelBtn = document.getElementById('fpCancelBtn');
const fpBackBtn = document.getElementById('fpBackBtn');
const fpNextBtn = document.getElementById('fpNextBtn');

// --- Button to open the modal ---
const openEnrollFpModalBtn = document.getElementById('openEnrollFpModalBtn');

// === Modal Initialization ===
const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};
const enrollFamilyPlanningModal = new Modal(enrollFamilyPlanningModalEl, modalOptions);

// === Multi-Step Logic ===
let fpCurrentStep = 0; // 0-based index
const fpTotalSteps = fpSteps.length;


// === Validation Logic ===
const validateDropdowns = () => {
    // --- DIAGNOSTIC LOGS: See the actual values ---
    console.log("--- Checking Dropdown Values ---");
    console.log("Client Type Value:", `'${fpClientTypeSelect.value}'`);
    console.log("Source Value:", `'${fpSourceSelect.value}'`);
    console.log("Previous Method Value:", `'${fpPreviousMethodSelect.value}'`);
    console.log("-----------------------------");
    // --- END DIAGNOSTIC ---

    const isClientTypeValid = fpClientTypeSelect.value.trim() !== "";
    const isSourceValid = fpSourceSelect.value.trim() !== "";
    const isPreviousMethodValid = fpPreviousMethodSelect.value.trim() !== "";

    if (isClientTypeValid && isSourceValid && isPreviousMethodValid) {
        console.log('Validation successful: All dropdowns have a selected value.');
        return true;
    } else {
        console.log('Validation failed: One or more dropdowns are missing a selection.');
        if (!isClientTypeValid) {
            console.log('- Client Type is not selected.');
        }
        if (!isSourceValid) {
            console.log('- Source is not selected.');
        }
        if (!isPreviousMethodValid) {
            console.log('- Previous Method is not selected.');
        }
        return false;
    }
};

function populatePurokFilter(puroks) {
    if (isPurokFilterPopulated || !puroks) return; // Exit if already populated or no puroks

    puroks.forEach(purok => {
        const option = document.createElement('option');
        option.value = purok.id;
        option.textContent = purok.name; // Assuming 'purok_name' from your backend
        enrollFPResidentPurokFilter.appendChild(option);
    });

    isPurokFilterPopulated = true; // Set flag to true after populating
}

function resetModalState() {
    // 1. Reset inputs
    enrollFPResidentSearchInput.value = '';
    enrollFPResidentPurokFilter.selectedIndex = 0; // Reset to "Filter by Purok"

    // 2. Clear the selected resident ID
    selectedResidentId = null;

    // 3. Show a loading state in the resident list
    enrollFPResidentListContainer.innerHTML = `<p class="text-center text-gray-500 p-4">Loading residents...</p>`;
}


function renderResidents(residents) {
    // Clear the existing list first
    enrollFPResidentListContainer.innerHTML = '';

    if (!residents || residents.length === 0) {
        enrollFPResidentListContainer.innerHTML = `<p class="text-center text-gray-500 p-4">No residents found.</p>`;
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
        enrollFPResidentListContainer.insertAdjacentHTML('beforeend', residentCardHTML);
    });
}

enrollFPResidentListContainer.addEventListener('click', (event) => {
    const clickedCard = event.target.closest('.resident-card');
    if (!clickedCard) return;

    // Find the card that is currently selected (if any)
    const previouslySelected = enrollFPResidentListContainer.querySelector('.border-sky-500');

    // Always remove the highlight from the previously selected card first
    if (previouslySelected) {
        previouslySelected.classList.remove(...selectedHighlightClasses);
    }

    if (previouslySelected !== clickedCard) {
        clickedCard.classList.add(...selectedHighlightClasses);

        // Store the ID of the new selection
        selectedResidentId = clickedCard.dataset.residentId;

        const nameElement = clickedCard.querySelector('p.font-semibold');
        console.log(nameElement.textContent);
        chosenResidentName = nameElement ? nameElement.textContent.trim() : '';
        fpResidentNameInput.value = chosenResidentName;
        fpNextBtn.disabled = false;
    } else {
        selectedResidentId = null;
        fpNextBtn.disabled.disabled = true;
    }

    console.log('Selected Resident ID:', selectedResidentId);
});

function fetchResidents(payload) {
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
            enrollFPResidentListContainer.innerHTML = `<p class="text-center text-red-500 p-4">Failed to load residents.</p>`;
        });
}

const fpGoToStep = (stepIndex) => {
    if (stepIndex < 0 || stepIndex >= fpTotalSteps) return;

    const direction = stepIndex > fpCurrentStep ? 'next' : 'prev';
    const currentStepEl = fpSteps[fpCurrentStep];
    const targetStepEl = fpSteps[stepIndex];

    // Prepare the target step for animation
    targetStepEl.classList.add(direction === 'next' ? 'translate-x-full' : '-translate-x-full');
    targetStepEl.classList.remove('hidden');

    // Animate steps
    requestAnimationFrame(() => {
        currentStepEl.classList.add(direction === 'next' ? '-translate-x-full' : 'translate-x-full');
        targetStepEl.classList.remove('translate-x-full', '-translate-x-full');
    });

    // Hide the old step after animation completes
    setTimeout(() => {
        currentStepEl.classList.add('hidden');
        currentStepEl.classList.remove('-translate-x-full', 'translate-x-full');
    }, 500); // Must match CSS transition duration

    fpCurrentStep = stepIndex;
    fpUpdateButtonsAndText();
};

const fpUpdateButtonsAndText = () => {
    // Toggle visibility of Back and Cancel buttons
    fpBackBtn.classList.toggle('hidden', fpCurrentStep === 0);
    fpCancelBtn.classList.toggle('hidden', fpCurrentStep > 0);

    // Update the text of the Next/Enroll button
    fpNextBtn.textContent = fpCurrentStep === fpTotalSteps - 1 ? 'Enroll' : 'Next';

    // Update the subtitle based on the current step
    if (fpCurrentStep === 0) {
        fpModalSubtitle.textContent = 'Step 1: Select a Resident';
    } else if (fpCurrentStep === 1) {
        fpModalSubtitle.textContent = 'Step 2: Enter Family Planning Details';
    }
};


fpClientTypeSelect.addEventListener('change', validateDropdowns);
fpSourceSelect.addEventListener('change', validateDropdowns);
fpPreviousMethodSelect.addEventListener('change', validateDropdowns);

// === Event Listeners ===
if (openEnrollFpModalBtn) {
    openEnrollFpModalBtn.addEventListener('click', function () {
        // Reset to the first step whenever the modal is opened
        fetchResidents({ search: '', purok_id: '' });
        enrollFamilyPlanningModal.show();
    });
}

if (fpCancelBtn) {
    fpCancelBtn.addEventListener('click', function () {
        enrollFamilyPlanningModal.hide();
    });
}

if (fpNextBtn) {
    fpNextBtn.addEventListener('click', () => {
        if (fpCurrentStep < fpTotalSteps - 1) {
            fpNextBtn.disabled = true;
            fpGoToStep(fpCurrentStep + 1);
        } else {
            // This is the final step, handle the form submission
            console.log('Enrollment form submitted!');
            // enrollFamilyPlanningModal.hide(); // Optionally hide modal on submission
        }
    });
}

if (fpBackBtn) {
    fpBackBtn.addEventListener('click', () => {
        if (fpCurrentStep > 0) {
            fpGoToStep(fpCurrentStep - 1);
        }
    });
}

// Initial setup on load
fpUpdateButtonsAndText();
