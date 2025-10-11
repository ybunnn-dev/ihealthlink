const enrollOpen = document.getElementById('openEnrollChildHealthcareModalBtn');
const enrollChildModalEl = document.getElementById('enroll-child-modal');
let isPurokFilterPopulated = false;
const childModalTitle = document.getElementById('child-modal-title');
const childModalSubtitle = document.getElementById('child-modal-subtitle');
const selectedHighlightClasses = ['bg-sky-100', 'dark:bg-sky-800', 'border-sky-500'];

let chosenChildName = null;
let chosenMotherName = null;
let selectedResidentId = null;
let selectedMotherId = null;
const healthProgramId = parseInt(document.getElementById('hpdata').textContent.trim());
// Step Containers
const childStep1 = document.getElementById('child-step-1');
const childStep2 = document.getElementById('child-step-2');
const childStep3 = document.getElementById('child-step-3');
const steps = [childStep1, childStep2, childStep3];

// Footer Navigation Buttons
const childCancelBtn = document.getElementById('childCancelBtn');
const childBackBtn = document.getElementById('childBackBtn');
const childNextBtn = document.getElementById('childNextBtn');
const childFinishBtn = document.getElementById('childFinishBtn');

const enrollChildSearchInput = document.getElementById('enrollChildResidentSearchInput');
const enrollChildPurokFilter = document.getElementById('enrollChildResidentPurokFilter');
const enrollChildScanQrBtn = document.getElementById('enroll-child-scan-qr');
const enrollChildListContainer = document.getElementById('enrollChildResidentListContainer');

// Search and Filter Elements for the "Select Mother" component
const selectMotherSearchInput = document.getElementById('selectMotherResidentSearchInput');
const selectMotherPurokFilter = document.getElementById('selectMotherResidentPurokFilter');
const selectMotherScanQrBtn = document.getElementById('select-mother-scan-qr');
const selectMotherListContainer = document.getElementById('selectMotherResidentListContainer');

const selectedChildNameInput = document.getElementById('child_name');
const selectedMotherNameInput = document.getElementById('mother_name');
const birthWeightInput = document.getElementById('birth_weight');

const enrollChildConfirmationModalEl = document.getElementById('enroll-child-confirmation-modal');
const childNameConfirm = document.getElementById('child-name-confirm');
const childMotherNameConfirm = document.getElementById('child-mother-name-confirm');
const childBirthWeightConfirm = document.getElementById('child-birth-weight-confirm');
const confirmChildEnrollmentCheckbox = document.getElementById('confirm-child-enrollment-checkbox');
const enrollChildConfirmationCancelBtn = document.getElementById('enroll-child-confirmation-cancel-btn');
const enrollChildConfirmationProceedBtn = document.getElementById('enroll-child-confirmation-proceed-btn');


let currentData = null;
let currentMothers = null;

const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const enrollChildModal = new Modal(enrollChildModalEl, modalOptions);
const enrollChildConfirmationModal = new Modal(enrollChildConfirmationModalEl, modalOptions);

// State Management
let currentStep = 1;

function resetModalState(searchInput, purokFilter) {
    // 1. Reset inputs
    searchInput.value = '';
    purokFilter.selectedIndex = 0; // Reset to "Filter by Purok"

    // 2. Clear the selected resident ID
    selectedResidentId = null;

    // 3. Show a loading state in the resident list
    enrollResidentListContainer.innerHTML = `<p class="text-center text-gray-500 p-4">Loading residents...</p>`;
}

function populatePurokFilter(puroks) {
    if (isPurokFilterPopulated || !puroks) return;

    puroks.forEach(purok => {
        const option = document.createElement('option');
        option.value = purok.id;
        option.textContent = purok.name;

        selectMotherPurokFilter.appendChild(option);

        // Clone the node for the second select
        enrollChildPurokFilter.appendChild(option.cloneNode(true));
    });

    isPurokFilterPopulated = true;
}

enrollChildListContainer.addEventListener('click', (event) => {
    const clickedCard = event.target.closest('.resident-card');
    if (!clickedCard) return;

    // Find the card that is currently selected (if any)
    const previouslySelected = enrollChildListContainer.querySelector('.border-sky-500');

    // Always remove the highlight from the previously selected card first
    if (previouslySelected) {
        previouslySelected.classList.remove(...selectedHighlightClasses);
    }

    if (previouslySelected !== clickedCard) {
        clickedCard.classList.add(...selectedHighlightClasses);

        // Store the ID of the new selection
        selectedResidentId = clickedCard.dataset.residentId;
        
        const nameElement = clickedCard.querySelector('p.font-semibold');
        chosenChildName = nameElement ? nameElement.textContent.trim() : '';

        childNextBtn.disabled = false;
    } else {
        selectedResidentId = null;
        childNextBtn.disabled = true;
    }

    console.log('Selected Resident ID:', selectedResidentId);
});

function renderResidents(residents, container) {
    // Clear the existing list first
    container.innerHTML = '';

    if (!residents || residents.length === 0) {
        container.innerHTML = `<p class="text-center text-gray-500 p-4">No residents found.</p>`;
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
        container.insertAdjacentHTML('beforeend', residentCardHTML);
    });
}

enrollChildPurokFilter.addEventListener('change', function(){
    enrollChildSearchInput.value = '';
    fetchResidents({search:'', purok_id: this.value});
    chosenChildName = null;
    selectedChildId = null;
    childNextBtn.disabled = true;
});

enrollChildSearchInput.addEventListener('change', function(){
    enrollChildPurokFilter.value = '';
    fetchResidents({search: this.value, purok_id:''});
    childNextBtn.disabled = true;
    chosenChildName = null;
    selectedChildId = null;
});

selectMotherPurokFilter.addEventListener('input', function(){
    fetchMother({search:'', purok_id: this.value});
    chosenMotherName = null;
    selectedMotherId = null;
    childNextBtn.disabled = true;
});

selectMotherSearchInput.addEventListener('input',function(){
    fetchMother({search: this.value, purok_id:''});
    chosenMotherName = null;
    selectedMotherId = null;
    childNextBtn.disabled = true;
});

selectMotherListContainer.addEventListener('click', (event) => {
    const clickedCard = event.target.closest('.resident-card');
    if (!clickedCard) return;

    // Find the card that is currently selected (if any)
    const previouslySelected = selectMotherListContainer.querySelector('.border-sky-500');

    // Always remove the highlight from the previously selected card first
    if (previouslySelected) {
        previouslySelected.classList.remove(...selectedHighlightClasses);
    }

    if (previouslySelected !== clickedCard) {
        clickedCard.classList.add(...selectedHighlightClasses);

        // Store the ID of the new selection
        selectedMotherId = clickedCard.dataset.residentId;
        
        const nameElement = clickedCard.querySelector('p.font-semibold');
        chosenMotherName = nameElement ? nameElement.textContent.trim() : '';

        childNextBtn.disabled = false;
        //maternityNextBtn.disabled = false;
    } else {
        selectedMotherId = null;
        childNextBtn.disabled = true;
        //maternityNextBtn.disabled = true;
    }

    console.log('Selected Resident ID:', selectedMotherId);
});

function fetchMother(payload = { search: '', purok_id: '' }) {
    const params = new URLSearchParams();
    if (payload.search) params.append('search', payload.search);
    if (payload.purok_id) params.append('purok_id', payload.purok_id);

    const url = `/barangay/get/mother?${params.toString()}&healthProgramId=${healthProgramId}`;

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
        console.log(data);
        renderResidents(data.residents, selectMotherListContainer);
    })
    .catch(error => {
        console.error('There was a problem fetching residents:', error);
        selectMotherListContainer.innerHTML = `<p class="text-center text-red-500 p-4">Failed to load residents.</p>`;
    });
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
        renderResidents(data.residents, enrollChildListContainer);
    })
    .catch(error => {
        console.error('There was a problem fetching residents:', error);
        enrollChildListContainer.innerHTML = `<p class="text-center text-red-500 p-4">Failed to load residents.</p>`;
    });
}


steps.forEach(step => {
    // Check if the step exists before trying to modify its class list
    if (step) {
        step.classList.remove('hidden');
    }
});

birthWeightInput.addEventListener('input',function(){
    childFinishBtn.disabled = this.value === '';
});

childFinishBtn.addEventListener('click', function(){
    enrollChildModal.hide();
    childBirthWeightConfirm.textContent = birthWeightInput.value.trim();
    childMotherNameConfirm.textContent = chosenMotherName;
    childNameConfirm.textContent = chosenChildName;
    enrollChildConfirmationModal.show();
});

// Function to update the UI based on the current step
const updateStepUI = () => {
    // Update titles
    if (currentStep === 1) {
        childModalSubtitle.textContent = "Step 1: Select Parent or Guardian";
    } else if (currentStep === 2) {
        childModalSubtitle.textContent = "Step 2: Child's Information";
    } else {
        childModalSubtitle.textContent = "Step 3: Review and Confirm";

        selectedChildNameInput.value = chosenChildName;
        selectedMotherNameInput.value = chosenMotherName;
        if(birthWeightInput.value === ''){
            childFinishBtn.disabled = true;
        }else{
            childFinishBtn.disabled = false;
        }
    }

    // --- SLIDING TRANSITION LOGIC ---
    // Apply the transform to each step. The CSS 'transition-transform' class will animate the slide.
    steps.forEach((step) => {
        if (step) {
            step.style.transform = `translateX(-${(currentStep - 1) * 100}%)`;
        }
    });

    // Handle button visibility
    childBackBtn.classList.toggle('hidden', currentStep === 1);
    childNextBtn.classList.toggle('hidden', currentStep === 3);
    childFinishBtn.classList.toggle('hidden', currentStep !== 3);
};

// Event Listeners for Navigation
childNextBtn.addEventListener('click', () => {
    if (currentStep < 3) {
        currentStep++;
        updateStepUI();
        if(selectedMotherId === null){
            childNextBtn.disabled = true;
        }
        if(currentStep === 2 && selectedMotherId === null){
             fetchMother({ search: '', purok_id: '' });
        }
        childCancelBtn.classList.add('hidden');
    }
});

childBackBtn.addEventListener('click', () => {
    if (currentStep > 1) {
        currentStep--;
        updateStepUI();
        childNextBtn.disabled = false;
        if(currentStep === 1){
            childCancelBtn.classList.remove('hidden');
        }
    }
});

// Function to reset the modal to its initial state
const resetModal = () => {
    currentStep = 1;
    updateStepUI();
    childCancelBtn.classList.remove('hidden'); // Ensure cancel is visible on reset
    // TODO: Add logic here to clear any form fields from step 1, 2, or 3.
    enrollChildModal.hide();
};


enrollOpen.addEventListener('click',function(){
    enrollChildModal.show();
    updateStepUI();
    fetchResidents();  
    resetModalState(enrollChildSearchInput, enrollChildPurokFilter);  
});

// Also reset when the cancel button is clicked
childCancelBtn.addEventListener('click', resetModal);

enrollChildConfirmationCancelBtn.addEventListener('click',function(){
    enrollChildConfirmationModal.hide();
    enrollChildModal.show();
});

confirmChildEnrollmentCheckbox.addEventListener('change',function(){
    enrollChildConfirmationProceedBtn.disabled = !this.checked;
});

enrollChildConfirmationProceedBtn.addEventListener('click', function() {
    const payload = {
        resident_id: parseInt(selectedResidentId),
        mother_id: parseInt(selectedMotherId),
        birthWeight: parseFloat(birthWeightInput.value.trim()),
        program_id: healthProgramId
    };

    console.log(payload);

    fetch('/barangay/health-program/child-healthcare/enroll', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Okay');
        } else {
            alert('Error: ' + data.message);
            location.reload();
        }
    })
    .catch(error => {
        alert('Request failed: ' + error.message);
        location.reload();
    });
});

// Initialize the modal view when the script loads
updateStepUI();
