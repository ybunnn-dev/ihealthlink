// --- Part 1: Search and Filter Elements (from previous context) ---
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


const enrollFPResidentSearchInput = document.getElementById('enrollFPResidentSearchInput');
const enrollFPResidentPurokFilter = document.getElementById('enrollFPResidentPurokFilter');
const enrollFPScanQRButton = document.getElementById('enroll-fp-scan-qr');
const enrollFPResidentListContainer = document.getElementById('enrollFPResidentListContainer');
let isPurokFilterPopulated = false;
const fpClientTypeInput = document.getElementById('fp_client_type');
const fpSourceInput = document.getElementById('fp_source');
const fpPreviousMethodInput = document.getElementById('fp_previous_method');
const fpClientTypeButton = document.getElementById('fp_client_type_button');
const fpSourceButton = document.getElementById('fp_source_button');
const fpPreviousMethodButton = document.getElementById('fp_previous_method_button');
const fpResidentNameInput = document.getElementById('fp_resident_name');
let selectedResidentId = null;
let chosenResidentName = null;
const selectedHighlightClasses = ['bg-sky-100', 'dark:bg-sky-800', 'border-sky-500'];
const enrollFamilyPlanningModalEl = document.getElementById('enroll-family-planning-modal');
const healthProgramId = parseInt(document.getElementById('hpdata').textContent.trim(), 10);
const fpModalTitle = document.getElementById('fp-modal-title');
const fpModalSubtitle = document.getElementById('fp-modal-subtitle');
const fpStep1 = document.getElementById('fp-step-1');
const fpStep2 = document.getElementById('fp-step-2');
const fpSteps = [fpStep1, fpStep2];
const fpCancelBtn = document.getElementById('fpCancelBtn');
const fpBackBtn = document.getElementById('fpBackBtn');
const fpNextBtn = document.getElementById('fpNextBtn');
const enrollFamilyConfirmationModalEl = document.getElementById('enroll-family-planning-confirmation-modal');
const residentNameToConfirm = document.getElementById('fp-resident-name-confirm');
const clientTypeConfirm = document.getElementById('fp-client-type-confirm');
const sourceConfirm = document.getElementById('fp-source-confirm');
const previousMethodConfirm = document.getElementById('fp-previous-method-confirm');
const confirmCheckbox = document.getElementById('confirm-fp-enrollment-checkbox');
const cancelConfirmBtn = document.getElementById('enroll-fp-confirmation-cancel-btn');
const proceedConfirmBtn = document.getElementById('enroll-fp-confirmation-proceed-btn');
const openEnrollFpModalBtn = document.getElementById('openEnrollFpModalBtn');
const fpClientTypeLabel = document.getElementById('fp_client_type_label');
const fpClientTypeDropdown = document.getElementById('fp_client_type_dropdown');
const fpClientTypeOptions = document.getElementById('fp_client_type_options');
const fpSourceLabel = document.getElementById('fp_source_label');
const fpSourceDropdown = document.getElementById('fp_source_dropdown');
const fpSourceOptions = document.getElementById('fp_source_options');
const fpPreviousMethodLabel = document.getElementById('fp_previous_method_label');
const fpPreviousMethodDropdown = document.getElementById('fp_previous_method_dropdown');
const fpPreviousMethodOptions = document.getElementById('fp_previous_method_options');
const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');



const enrollFamilyPlanningModal = new Modal(enrollFamilyPlanningModalEl, createModalOptions(enrollFamilyPlanningModalEl));
const enrollFamilyPlanningConfirmationModal = new Modal(enrollFamilyConfirmationModalEl, createModalOptions(enrollFamilyConfirmationModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));
// === Multi-Step Logic ===
let fpCurrentStep = 0; // 0-based index
const fpTotalSteps = fpSteps.length;


function populatePurokFilter(puroks) {
    if (isPurokFilterPopulated || !puroks) return;

    const optionsContainer = document.getElementById('enrollFPResidentPurokFilter_options');
    const label = document.getElementById('enrollFPResidentPurokFilter_label');
    const hiddenInput = document.getElementById('enrollFPResidentPurokFilter');

    optionsContainer.innerHTML = ''; // Clear existing options

    // --- "All" Option (Filter by Purok) ---
    const allOption = document.createElement('li');
    allOption.innerHTML = `
        <button type="button" 
            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" 
            data-value="">
            Filter by Purok
        </button>
    `;
    optionsContainer.appendChild(allOption);

    // --- Add each purok from the data ---
    puroks.forEach(purok => {
        const purokOption = document.createElement('li');
        purokOption.innerHTML = `
            <button type="button" 
                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                data-value="${purok.id}">
                ${purok.name}
            </button>
        `;
        optionsContainer.appendChild(purokOption);
    });

    // --- Handle selection ---
    optionsContainer.addEventListener('click', (event) => {
        const button = event.target.closest('button[data-value]');
        if (!button) return;

        const selectedValue = button.dataset.value;
        const selectedText = button.textContent.trim();

        label.textContent = selectedText;
        hiddenInput.value = selectedValue;

        // Optionally trigger a filtering function here
        // filterResidentsByPurok(selectedValue);
    });

    isPurokFilterPopulated = true;
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
        // This assumes 'fpCurrentStep', 'fpTotalSteps', 'fpGoToStep' are defined elsewhere
        if (fpCurrentStep < fpTotalSteps - 1) { 
            fpNextBtn.disabled = true;
            fpGoToStep(fpCurrentStep + 1);
        } else {
            // This is the final step, handle the form submission
            console.log('Final step reached. Populating confirmation modal...');

            // --- CORRECTED CODE ---
            // Get the text from the label spans of the custom dropdowns.
            // This also assumes 'residentNameConfirm', 'clientTypeConfirm', 'sourceConfirm', 
            // and 'previousMethodConfirm' are defined element variables for your confirmation modal.

            residentNameToConfirm.textContent = fpResidentNameInput.value;
            clientTypeConfirm.textContent = fpClientTypeLabel.textContent;
            sourceConfirm.textContent = fpSourceLabel.textContent;
            previousMethodConfirm.textContent = fpPreviousMethodLabel.textContent;
            
            // --- End of corrected code ---

            // Now, show the modal
            // This assumes 'enrollFamilyPlanningModal' and 'enrollFamilyPlanningConfirmationModal' are defined
            enrollFamilyPlanningModal.hide();
            enrollFamilyPlanningConfirmationModal.show();
        }
    });
}

confirmCheckbox.addEventListener('change', function () {
    proceedConfirmBtn.disabled = !this.checked;
});

cancelConfirmBtn.addEventListener('click', function () {
    enrollFamilyPlanningConfirmationModal.hide();
    enrollFamilyPlanningModal.show();
});


// Close dropdowns when clicking outside
document.addEventListener('click', () => {
    document.querySelectorAll('.custom-dropdown-options').forEach(el => el.classList.add('hidden'));
});

// === Validation Logic (Updated for custom dropdowns) ===
const validateDropdowns = () => {
    const isClientTypeValid = fpClientTypeInput.value.trim() !== "";
    const isSourceValid = fpSourceInput.value.trim() !== "";
    const isPreviousMethodValid = fpPreviousMethodInput.value.trim() !== "";

    const allValid = isClientTypeValid && isSourceValid && isPreviousMethodValid;

    if (fpNextBtn) {
        fpNextBtn.disabled = !allValid;
    }
    return allValid;
};

// === Event Listeners for Modal Flow ===
openEnrollFpModalBtn.addEventListener('click', () => {
    fpNextBtn.disabled = true;
    enrollFamilyPlanningModal.show();
});

function resetEnrollmentForm() {
    // --- Reset Step 1: Resident Search ---
    if (enrollFPResidentSearchInput) enrollFPResidentSearchInput.value = '';
    
    // Reset Purok Filter Custom Dropdown
    const purokButton = document.getElementById('enrollFPResidentPurokFilter_button');
    if (purokButton) purokButton.querySelector('span').textContent = 'Filter by Purok';
    if (enrollFPResidentPurokFilter) enrollFPResidentPurokFilter.value = '';

    // Clear resident list and remove selection
    if (enrollFPResidentListContainer) {
        enrollFPResidentListContainer.innerHTML = '<p class="text-center text-gray-500 p-4">Search for a resident to begin.</p>';
    }
    selectedResidentId = null;
    chosenResidentName = null;

    // --- Reset Step 2: Form Details ---
    if (fpResidentNameInput) fpResidentNameInput.value = '';
    
    // Reset Client Type Custom Dropdown
    if (fpClientTypeLabel) fpClientTypeLabel.textContent = 'Choose a type';
    if (fpClientTypeInput) fpClientTypeInput.value = '';
    
    // Reset Source Custom Dropdown
    if (fpSourceLabel) fpSourceLabel.textContent = 'Choose a source';
    if (fpSourceInput) fpSourceInput.value = '';

    // Reset Previous Method Custom Dropdown
    if (fpPreviousMethodLabel) fpPreviousMethodLabel.textContent = 'Choose a previous method if any';
    if (fpPreviousMethodInput) fpPreviousMethodInput.value = '';

    fpNextBtn.disabled = true; // Disable the 'Next' button
}


if (fpCancelBtn) {
    fpCancelBtn.addEventListener('click', () => {
        resetEnrollmentForm(); // Reset the form first
        enrollFamilyPlanningModal.hide(); // Then hide the modal
    });
}

confirmCheckbox.addEventListener('change', function () { proceedConfirmBtn.disabled = !this.checked; });

cancelConfirmBtn.addEventListener('click', () => {
    enrollFamilyPlanningConfirmationModal.hide();
    enrollFamilyPlanningModal.show();
});

proceedConfirmBtn.addEventListener('click', function () {
    // Disable buttons during submission
    proceedConfirmBtn.disabled = true;
    // Add cancel button if you have one: proceedCancelBtn.disabled = true;
    
    const originalButtonText = proceedConfirmBtn.textContent;
    proceedConfirmBtn.textContent = 'Enrolling...';
    
    const payload = {
        resident_id: parseInt(selectedResidentId),
        client_type: fpClientTypeInput.value,
        previous_method: fpPreviousMethodInput.value,
        source: fpSourceInput.value,
        program_id: parseInt(healthProgramId)
    };

    console.log('Payload:', payload);
    
    fetch(`/barangay/health-program/enroll/${selectedResidentId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to enroll resident');
        }
        return response.json();
    })
    .then(data => {
        console.log('Server response:', data);
        
        if (data.result === 'success' || data.status === 'success') {
            // Store enrollment ID for redirect
            const enrollmentId = data.enrollment?.id || data.data?.id;
            
            // Hide confirmation modal (update with your actual modal variable)
            enrollFamilyPlanningConfirmationModal.hide(); // Update with your confirmation modal instance
            
            // Show success modal
            successMesageHeader.textContent = 'Enrollment Successful';
            successMessage.textContent = data.message || 'Resident has been successfully enrolled in the family planning program.';
            successModal.show();
            
            // Redirect when success modal closes
            closeSuccessModalButton.addEventListener('click', function() {
                successModal.hide();
                if (enrollmentId) {
                    window.location.href = `/barangay/health-programs/enrolled/resident/${enrollmentId}`;
                } else {
                    window.location.reload();
                }
            }, { once: true });
        } else {
            throw new Error(data.message || 'Enrollment failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Re-enable buttons on error
        proceedConfirmBtn.disabled = false;
        // proceedCancelBtn.disabled = false;
        proceedConfirmBtn.textContent = originalButtonText;
        
        // Show error message
        alert('Error: ' + error.message);
    });
});


if (fpBackBtn) {
    fpBackBtn.addEventListener('click', () => {
        if (fpCurrentStep > 0) {
            fpGoToStep(fpCurrentStep - 1);
            fpNextBtn.disabled = false;
        }
    });
}

function initializeResponsiveDropdown(optionsContainerId, hiddenInputId, buttonId, labelId, validationCallback) {
    const optionsContainer = document.getElementById(optionsContainerId);
    const hiddenInput = document.getElementById(hiddenInputId);
    const button = document.getElementById(buttonId);
    const label = document.getElementById(labelId);
    const dropdown = document.getElementById(button.getAttribute('data-dropdown-toggle'));

    if (!optionsContainer || !hiddenInput || !button || !label || !dropdown) {
        console.error('One or more dropdown elements are missing for', optionsContainerId);
        return;
    }

    // --- 1. Set Dropdown Width to Match Button ---
    const observer = new MutationObserver(() => {
        if (!dropdown.classList.contains('hidden')) {
            dropdown.style.width = `${button.offsetWidth}px`;
        }
    });
    observer.observe(dropdown, { attributes: true, attributeFilter: ['class'] });

    // --- 2. Handle Option Selection ---
    optionsContainer.addEventListener('click', (event) => {
        const target = event.target.closest('button');
        if (!target) return;

        // Update the hidden input's value and the button's text label
        hiddenInput.value = target.dataset.value;
        label.textContent = target.textContent;
        
        // Trigger the validation callback function
        if (validationCallback) {
            validationCallback();
        }
    });
}

// --- Apply the function to all three dropdowns, passing the validator ---
initializeResponsiveDropdown('fp_client_type_options', 'fp_client_type', 'fp_client_type_button', 'fp_client_type_label', validateDropdowns);
initializeResponsiveDropdown('fp_source_options', 'fp_source', 'fp_source_button', 'fp_source_label', validateDropdowns);
initializeResponsiveDropdown('fp_previous_method_options', 'fp_previous_method', 'fp_previous_method_button', 'fp_previous_method_label', validateDropdowns);

// Initial setup on load
fpUpdateButtonsAndText();
