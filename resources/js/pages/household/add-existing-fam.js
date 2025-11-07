// ============================================================================
// MULTI-STEP FAMILY MODAL - FIXED (Div-based selection)
// ============================================================================
const confirmTransferFamilyModalEl = document.getElementById('confirm-transfer-family-modal');
const household = window.household;
// Interactive elements inside the modal
const confirmTransferCheckbox = document.getElementById('confirm-transfer-checkbox');
const confirmTransferFamilyCancelBtn = document.getElementById('confirm-transfer-family-cancel');
const confirmTransferFamilySubmitBtn = document.getElementById('confirm-transfer-family-submit');

const confirmTransferFamilyModal = new Modal(confirmTransferFamilyModalEl, {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
});

let currentStep = 0; // 0-based index
const totalSteps = 2;

// Get step elements
const step1 = document.querySelector('[data-step="1"]');
const step2 = document.querySelector('[data-step="2"]');
const modalSteps = [step1, step2];

/**
 * FIXED: Uses a small setTimeout(10) to force a browser repaint.
 * This ensures the "off-screen" state is set *before*
 * the "on-screen" animation starts, making the slide reliable.
 */
const goToStep = (stepIndex) => {
    if (stepIndex < 0 || stepIndex >= totalSteps || !modalSteps[stepIndex] || !modalSteps[currentStep]) return;

    const direction = stepIndex > currentStep ? 'next' : 'prev';
    const currentStepEl = modalSteps[currentStep];
    const targetStepEl = modalSteps[stepIndex];

    // 1. Prepare the target step (set it off-screen)
    targetStepEl.classList.add(direction === 'next' ? 'translate-x-full' : '-translate-x-full');
    targetStepEl.classList.remove('hidden');

    // 2. Use a tiny setTimeout to force a repaint.
    setTimeout(() => {
        // Animate current step out
        currentStepEl.classList.add(direction === 'next' ? '-translate-x-full' : 'translate-x-full');
        // Animate target step in
        targetStepEl.classList.remove('translate-x-full', '-translate-x-full');
    }, 10); // 10ms is enough

    // 3. Hide the old step after animation completes
    setTimeout(() => {
        currentStepEl.classList.add('hidden');
        currentStepEl.classList.remove('-translate-x-full', 'translate-x-full'); // Cleanup
    }, 510); // 500ms duration + 10ms buffer

    currentStep = stepIndex;
    updateButtonsAndText();
};

const updateButtonsAndText = () => {
    const backBtn = document.getElementById('backToStep1Btn');
    if (backBtn) {
        backBtn.classList.toggle('hidden', currentStep === 0);
    }
};

const resetModalSteps = () => {
    currentStep = 0;
    modalSteps.forEach((step, index) => {
        if (!step) return;
        step.classList.remove('translate-x-full', '-translate-x-full');
        if (index === 0) {
            step.classList.remove('hidden');
        } else {
            step.classList.add('hidden');
        }
    });
    updateButtonsAndText();
};


// ============================================================================
// STEP 1: FAMILY SELECTION LOGIC
// ============================================================================

const chooseFamilyModalEl = document.getElementById('chooseFamilyModal');
const chooseFamilyModal = new Modal(chooseFamilyModalEl, {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
});

const familySearchInput = document.getElementById('family-search');
const familyCardContainer = document.getElementById('familyCardContainer');
const cancelChooseFamilyBtn = document.getElementById('cancelChooseFamily');
const confirmChooseFamilyBtn = document.getElementById('confirmChooseFamilyBtn'); // Step 1 Button

let chosenFamily = null;
let familiesData = [];
let debounceTimer;

/**
 * ADDED: The CSS classes to toggle for selection
 */
const selectionClasses = ['border-blue-500', 'bg-blue-50', 'ring-2', 'ring-blue-200'];


function fetchAndRenderFamilies() {
    const searchQuery = familySearchInput.value;
    const url = new URL('/barangay/resident/families/find', window.location.origin);
    
    if (searchQuery) url.searchParams.append('search', searchQuery);
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, {
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    })
    .then(response => response.ok ? response.json() : Promise.reject('Failed to fetch'))
    .then(data => {
        familiesData = data.families;
        populateFamilyCards(data.families);
    })
    .catch(error => {
        console.error('Fetch error:', error);
        familyCardContainer.innerHTML = `<p class="text-center text-red-500 p-4">Error loading families.</p>`;
    });
}


/**
 * REWRITTEN: Generates clickable <div>s instead of <label>s.
 * We add 'data-family-id' to the div itself.
 */
function populateFamilyCards(families) {
    familyCardContainer.innerHTML = '';
    chosenFamily = null;
    confirmChooseFamilyBtn.disabled = true;

    if (families.length === 0) {
        familyCardContainer.innerHTML = `<p class="text-center text-gray-500 p-4">No families match your criteria.</p>`;
        return;
    }

    const cardsHTML = families.map(family => {
        const familyIdFormatted = `FAM-${String(family.id).padStart(3, '0')}`;
        const familyHeadName = family.head 
            ? `${family.head.firstName} ${family.head.lastName}` 
            : 'Not Assigned';
        const memberCount = family.residents?.length || 0;

        
        return `
            <div class="family-card flex items-center p-3 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100" data-family-id="${family.id}">
                <div class="flex justify-between w-full pointer-events-none">
                    <div>
                        <p class="font-semibold text-main_font">${familyHeadName}</p>
                        <p class="text-xs text-gray-500">
                            <span>ID: ${familyIdFormatted}</span>
                            <span class="mx-1.5">&middot;</span>
                            
                        </p>
                    </div>
                    <div class="flex items-center text-xs text-gray-600">
                        <span class="bg-gray-200 px-2 py-1 rounded-full">${memberCount} Members</span>
                    </div>
                </div>
            </div>`;
    }).join('');
    
    familyCardContainer.innerHTML = cardsHTML;
}

// ============================================================================
// EVENT LISTENERS
// ============================================================================

// --- Step 1 Listeners ---
familySearchInput.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(fetchAndRenderFamilies, 300);
});


/**
 * REWRITTEN: Listens for 'click' on the container and finds
 * the '.family-card' that was clicked. Manually toggles
 * the selection classes.
 */
familyCardContainer.addEventListener('click', (event) => {
    const clickedCard = event.target.closest('.family-card');
    if (!clickedCard) return;
    
    const isAlreadySelected = clickedCard.classList.contains('border-blue-500');
    const currentlySelected = familyCardContainer.querySelector('.border-blue-500');
    
    // Remove selection from the old card
    if (currentlySelected) {
        currentlySelected.classList.remove(...selectionClasses);
    }
    
    if (!isAlreadySelected) {
        // Select the new card
        clickedCard.classList.add(...selectionClasses);
        const chosenFamilyId = parseInt(clickedCard.dataset.familyId, 10);
        chosenFamily = familiesData.find(family => family.id === chosenFamilyId);
    } else {
        // Deselect the current card
        chosenFamily = null;
    }
    
    // Update button state
    confirmChooseFamilyBtn.disabled = !chosenFamily;
});

cancelChooseFamilyBtn.addEventListener('click', () => {
    chosenFamily = null;
    chooseFamilyModal.hide();
    setTimeout(resetModalSteps, 300); // Reset after hide animation
});

confirmChooseFamilyBtn.addEventListener('click', () => {
    if (chosenFamily) {
        populateStep2(chosenFamily);
        goToStep(1); // Go to step 2 (index 1)
    }
});

// --- Step 2 Listeners ---
document.getElementById('backToStep1Btn')?.addEventListener('click', () => {
    goToStep(0); // Go to step 1 (index 0)
});

document.getElementById('cancelStep2Btn')?.addEventListener('click', () => {
    chosenFamily = null;
    chooseFamilyModal.hide();
    setTimeout(resetModalSteps, 300); // Reset after hide animation
});

document.getElementById('confirmStep2Btn')?.addEventListener('click', () => {
    if (chosenFamily) {
        chooseFamilyModal.hide();
        confirmTransferFamilyModal.show();
    }
});


// ============================================================================
// STEP 2: POPULATION
// ============================================================================

// (This function is unchanged and correct)
function populateStep2(family) {
    const familyIdFormatted = `FAM-${String(family.id).padStart(3, '0')}`;
    const householdIdFormatted = `HH-${String(family.household?.id || family.household_id).padStart(3, '0')}`;
    
    document.getElementById('step2-family-id').textContent = familyIdFormatted;
    document.getElementById('step2-household-id').textContent = householdIdFormatted;
    document.getElementById('step2-purok').textContent = family.household?.purok?.name || 'N/A';
    document.getElementById('step2-barangay').textContent = family.household?.purok?.barangay?.name || 'N/A';
    document.getElementById('step2-member-count').textContent = family.residents?.length || 0;
    
    const residentsContainer = document.getElementById('step2-residents-container');
    residentsContainer.innerHTML = '';
    
    if (family.residents && family.residents.length > 0) {
        const residentsHTML = family.residents.map((resident, index) => {
            const fullName = [
                resident.firstName,
                resident.middleName,
                resident.lastName,
                resident.suffix
            ].filter(Boolean).join(' ');
            
            return `
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-sm font-semibold text-blue-600">${index + 1}</span>
                        </div>
                        <div class="flex-grow">
                            <p class="font-medium text-main_font">${fullName}</p>
                            <p class="text-xs text-gray-500">
                                ${resident.sex.charAt(0).toUpperCase() + resident.sex.slice(1)}
                            </p>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
        
        residentsContainer.innerHTML = residentsHTML;
    } else {
        residentsContainer.innerHTML = '<p class="text-center text-gray-500 p-4">No members found</p>';
    }
}

confirmTransferCheckbox.addEventListener('change', function(){
    confirmTransferFamilySubmitBtn.disabled = !this.checked;
});

confirmTransferFamilySubmitBtn.addEventListener('click', function () {

    const payload = {
        family_id: chosenFamily.id,
        household_id: household.id
    };

    fetch('/barangay/family/transfer', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response:', data);
        alert('Family has been successfuly added.');
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});


confirmTransferFamilyCancelBtn.addEventListener('click', function(){
    confirmTransferFamilyModal.hide();
    chooseFamilyModal.show();
});
// ============================================================================
// MODAL INITIALIZATION
// ============================================================================

const openChooseFamilyBtn = document.getElementById('add-existing-family-trigger');

if (openChooseFamilyBtn) {
    openChooseFamilyBtn.addEventListener('click', () => {
        resetModalSteps(); // Reset to step 0 and clean up classes
        confirmChooseFamilyBtn.disabled = true;
        fetchAndRenderFamilies(); // Fetch data when modal opens
        chooseFamilyModal.show();
    });
}