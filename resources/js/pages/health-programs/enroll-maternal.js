// Main modal container
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

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

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
const weightInput = document.getElementById('initialWeight');
const heightInput = document.getElementById('initialHeight');

const confirmMaternityModalEl = document.getElementById('enroll-maternity-confirmation-modal');

// Detail display elements
const confirmResidentName = document.getElementById('maternity-resident-name-confirm');
const confirmLmp = document.getElementById('maternity-lmp-confirm');
const confirmEdc = document.getElementById('maternity-edc-confirm');
const confirmGravida = document.getElementById('maternity-gravida-confirm');
const confirmPara = document.getElementById('maternity-para-confirm');

// Action elements
const confirmCheckbox = document.getElementById('confirm-maternity-enrollment-checkbox');
const confirmCancelBtn = document.getElementById('enroll-maternity-confirmation-cancel-btn');
const confirmProceedBtn = document.getElementById('enroll-maternity-confirmation-proceed-btn');

const maternityModal = new Modal(maternityModalEl, createModalOptions(maternityModalEl));
const confirmMaternityModal = new Modal(confirmMaternityModalEl, createModalOptions(confirmMaternityModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

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

function formatDate(dateStr) {
    if (!dateStr) return "";
    const date = new Date(dateStr);
    return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric"
    });
}

maternityCancelBtn.addEventListener('click', function(){
    paraInput.value = '';
    gravidaInput.value = '';
    edcInput.value = '';
    lmpInput.value = '';
    heightInput.value = '';
    weightInput.value = '';
    maternityModal.hide();
});

maternityNextBtn.addEventListener('click', () => {
    if (currentStep < totalSteps - 1) {
        goToStep(currentStep + 1);
        maternityResidentNameInput.value = chosenResidentName;
        maternityNextBtn.disabled = true;
    } else {
        maternityModal.hide();
        confirmResidentName.textContent = chosenResidentName;
        confirmLmp.textContent = formatDate(lmpInput.value.trim());
        confirmEdc.textContent = formatDate(edcInput.value.trim());
        confirmGravida.textContent = gravidaInput.value.trim();
        confirmPara.textContent = paraInput.value.trim();
        confirmMaternityModal.show();
    }
});


maternityBackBtn.addEventListener('click', () => {
    if (currentStep > 0) {
        goToStep(currentStep - 1);
        maternityNextBtn.disabled = false;
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
    const previouslySelected = residentListContainer.querySelector('.border-sky-500');

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
    if (isPurokFilterPopulated || !puroks) return;

    console.log(puroks);
    puroks.forEach(purok => {
        const option = document.createElement('option');
        option.value = purok.id;
        option.textContent = purok.name;
        purokFilterSelect.appendChild(option);
    });

    isPurokFilterPopulated = true;
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

function fetchResidents(payload) {
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

        renderResidents(data.residents);
    })
    .catch(error => {
        console.error('There was a problem fetching residents:', error);
        residentListContainer.innerHTML = `<p class="text-center text-red-500 p-4">Failed to load residents.</p>`;
    });
}

openMaternityModalBtn.addEventListener('click', function(){
    const payload = { search: null, purok_id: null };
    resetModalState();
    fetchResidents(payload); 
    maternityModal.show();
});

// Listen for input in the search field
residentSearchInput.addEventListener('keyup', (event) => {
    const searchQuery = event.target.value;
    fetchResidents({ search: searchQuery, purok_id: null });
});

// Listen for changes in the purok filter
purokFilterSelect.addEventListener('change', (event) => {
    const purokId = event.target.value;
    fetchResidents({ search: null, purok_id: purokId });
});

function validateForm() {
    const areTextInputsValid =
    lmpInput.value.trim() !== "" && 
    paraInput.value.trim() !== "" &&
    gravidaInput.value.trim() !== ""&&
    weightInput.value.trim() !== "" &&
    heightInput.value.trim() !== "";

    console.log(areTextInputsValid);

    return areTextInputsValid;
}

function updateButtonState() {
    if (validateForm()) {
        // If the form is valid, enable the button and remove disabled styles
        maternityNextBtn.disabled = false;
    } else {
        // If the form is invalid, disable the button and add disabled styles
        maternityNextBtn.disabled = true;
    }
}

paraInput.addEventListener('input', function(){
    validateForm();
    updateButtonState()
});

heightInput.addEventListener('input', function(){
    validateForm();
    updateButtonState()
});

weightInput.addEventListener('input', function(){
    validateForm();
    updateButtonState()
});

gravidaInput.addEventListener('input', function(){
    validateForm();
    updateButtonState()
});

lmpInput.addEventListener('change', function () {
    if (!lmpInput.value) return;

    let lmpDate = new Date(lmpInput.value);

    // Apply Naegele’s Rule
    let edcDate = new Date(lmpDate);
    edcDate.setFullYear(edcDate.getFullYear() + 1);
    edcDate.setMonth(edcDate.getMonth() - 3);
    edcDate.setDate(edcDate.getDate() + 7);

    // Format to YYYY-MM-DD (for input type="date")
    let yyyy = edcDate.getFullYear();
    let mm = String(edcDate.getMonth() + 1).padStart(2, '0');
    let dd = String(edcDate.getDate()).padStart(2, '0');

    edcInput.value = `${yyyy}-${mm}-${dd}`;

    validateForm();
    updateButtonState()
});


confirmCheckbox.addEventListener('change', function(){
    confirmProceedBtn.disabled = !this.checked;
});

confirmCancelBtn.addEventListener('click', function(){
    confirmMaternityModal.hide(); 
    maternityModal.show();
});

confirmProceedBtn.addEventListener('click', function() {
    // Disable buttons during submission
    confirmProceedBtn.disabled = true;
    confirmCancelBtn.disabled = true; // Add if you have a cancel button
    
    const originalButtonText = confirmProceedBtn.textContent;
    confirmProceedBtn.textContent = 'Enrolling...';
    
    const payload = {
        health_program_id: parseInt(healthProgramId, 10),
        resident_id: parseInt(selectedResidentId, 10),
        last_menstrual_period: lmpInput.value,
        expected_date_of_confinement: edcInput.value,
        gravida: parseInt(gravidaInput.value, 10),
        para: parseInt(paraInput.value, 10),
        initial_weight: parseFloat(weightInput.value), // Fixed: was missing .value
        initial_height: parseFloat(heightInput.value)  // Fixed: was missing .value
    };

    console.log('Payload:', payload);

    const url = `/barangay/health-program/maternity/enroll`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('Failed to enroll in maternity program');
        }
        return res.json();
    })
    .then(data => {
        console.log('Success:', data);
        
        // Store enrolled resident ID if available
        const enrolledResidentId = data.data?.id || data.enrolled_resident_id;
        
        // Hide confirmation modal (make sure you have this modal instance)
        confirmMaternityModal.hide(); // Update with your actual confirmation modal variable
        
        // Show success modal
        successMesageHeader.textContent = 'Maternity Enrollment Successful';
        successMessage.textContent = data.message || 'Resident has been successfully enrolled in the maternity program.';
        successModal.show();
        
        // Redirect when success modal closes
        closeSuccessModalButton.addEventListener('click', function() {
            successModal.hide();
            if (enrolledResidentId) {
                window.location.href = `/barangay/health-programs/enrolled/resident/${enrolledResidentId}`;
            } else {
                window.location.reload();
            }
        }, { once: true });
    })
    .catch(err => {
        console.error('Error:', err);
        
        // Re-enable buttons on error
        confirmProceedBtn.disabled = false;
        confirmCancelBtn.disabled = false;
        confirmProceedBtn.textContent = originalButtonText;
        
        // Show error message
        alert('Error: ' + err.message);
    });
});
