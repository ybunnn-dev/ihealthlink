
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

const addResidentModalEl = document.getElementById('add-resident-modal');

// --- Section 1: Name ---
const residentFirstName = document.getElementById('residentFirstName');
const residentLastName = document.getElementById('residentLastName');
const residentMiddleName = document.getElementById('residentMiddleName');
const suffix = document.getElementById('suffix');

// --- Section 2: Contact & Demographics ---
const residentContactNo = document.getElementById('residentContactNo');
const residentSex = document.getElementById('residentSex');
const residentBirthdate = document.getElementById('residentBirthdate');
const residentAge = document.getElementById('residentAge');

// --- Section 3: Household & Family ---
const familyIdHolder = document.getElementById('familyIdHolder');
const chooseFamilyBtn = document.getElementById('familyDropdown'); // This is the 'Choose Family' button
const familyIdStorage = document.getElementById('familyIdStorage'); // Hidden div for the selected family's ID

// --- Section 4: Address & Residency ---
const completeAddress = document.getElementById('completeAddress');

// --- Section 5: Socio-Economic Status ---
const civilStatus = document.getElementById('civilStatus');
const religion = document.getElementById('religion');
const ethnicity = document.getElementById('ethnicity');
const employmentStatus = document.getElementById('employmentStatus');

// --- Section 6: Special Statuses & Emergency Contact ---
const pwdStatus = document.getElementById('pwdStatus');
const pwdIdInput = document.getElementById('pwdIdInput');
const indigenousStatus = document.getElementById('indigenousStatus');
const soloParentStatus = document.getElementById('soloParentStatus');
const philhealthStatus = document.getElementById('philhealthStatus');
const emergencyContactNo = document.getElementById('emergencyContactNo');
const educAttainment = document.getElementById('educationAttainment');
const philhealthNo = document.getElementById('philHealthNo');
let isPurokFilterPopulated = false;


const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

const confirmResidentModalEl = document.getElementById('confirm-add-resident-modal');
const residentFullNameConfirm = document.getElementById('confirm-resident-full-name');


const confirmResidentCheckbox = document.getElementById('confirm-resident-checkbox');
const cancelConfirm = document.getElementById('cancel-add-resident-confirm');
const confirmAddResidentSubmitBtn = document.getElementById('confirm-resident-proceed-button');
const openAddResidentBtn = document.getElementById('openAddResidentModal');


let currentResidentPayload = null;

let chosenFamily = null;
let familiesData = [];
// --- Main Modal Element ---
const chooseFamilyModalEl = document.getElementById('chooseFamilyModal');

// --- Updated Element Variables ---
const familySearchInput = document.getElementById('family-search');
const purokFilterSelect = document.getElementById('purokFilterSelect'); // REPLACED
const familyCardContainer = document.getElementById('familyCardContainer'); // REPLACED

// --- Action Buttons (Remain the same) ---
const cancelChooseFamilyBtn = document.getElementById('cancelChooseFamily');
const confirmChooseFamilyBtn = document.getElementById('confirmChooseFamilyBtn');


const confirmResidentModal = new Modal(confirmResidentModalEl, createModalOptions(confirmResidentModalEl));
const addResidentModal = new Modal(addResidentModalEl, createModalOptions(addResidentModalEl));
const chooseFamilyModal = new Modal(chooseFamilyModalEl, createModalOptions(chooseFamilyModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

const cancelButton = document.getElementById('cancel-button-add-resident');
const addResidentButton = document.getElementById('add-resident-button');

openAddResidentBtn.addEventListener('click', function () {
    addResidentModal.show();
});

cancelButton.addEventListener('click', function () {
    addResidentModal.hide();
});

let debounceTimer;

// Define the Tailwind classes for a selected card
const selectionClasses = ['border-blue-500', 'bg-blue-50', 'ring-2', 'ring-blue-200'];

// --- Main function to fetch data from the server ---
function fetchAndRenderFamilies() {
    const searchQuery = familySearchInput.value;
    const purokId = purokFilterSelect.value;
    const url = new URL('/barangay/resident/families/get', window.location.origin);
    if (searchQuery) url.searchParams.append('search', searchQuery);
    if (purokId) url.searchParams.append('purok_id', purokId);

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, {
        method: 'GET',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    })
        .then(response => response.ok ? response.json() : Promise.reject('Failed to fetch'))
        .then(data => {
            familiesData = data.families; // Update our local data cache
            populatePurokFilter(data.puroks);
            populateFamilyCards(data.families);
        })
        .catch(error => {
            console.error('Fetch error:', error);
            familyCardContainer.innerHTML = `<p class="text-center text-red-500 p-4">Error loading families.</p>`;
        });
}

// --- UI Population Functions ---
function populatePurokFilter(puroks) {
    if (isPurokFilterPopulated) return;
    purokFilterSelect.innerHTML = '<option selected value="">All Puroks</option>';
    puroks.forEach(purok => {
        const option = document.createElement('option');
        option.value = purok.id;
        option.textContent = purok.name;
        purokFilterSelect.appendChild(option);
    });
    isPurokFilterPopulated = true;
}

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
        const familyHeadName = family.head ? `${family.head.firstName} ${family.head.lastName}` : 'Not Assigned';
        const memberCount = family.residents?.length || 0; // Use residents array length for count
        const purokName = family.household?.purok?.name || 'N/A';
        return `
            <div class="family-card flex items-center p-3 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100" data-family-id="${family.id}">
                <div class="flex justify-between w-full pointer-events-none">
                    <div><p class="font-semibold text-main_font">${familyIdFormatted}</p><p class="text-xs text-gray-500"><span>${purokName}</span></p></div>
                    <div class="flex items-center text-xs text-gray-600"><span class="bg-gray-200 px-2 py-1 rounded-full">${memberCount} Members</span></div>
                </div>
            </div>`;
    }).join('');
    familyCardContainer.innerHTML = cardsHTML;
}

// --- Event Listeners ---

// Initial fetch when the modal is opened
chooseFamilyBtn.addEventListener('click', () => {
    fetchAndRenderFamilies();
    addResidentModal.hide();
    chooseFamilyModal.show();
});

// Debounced search input
familySearchInput.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(fetchAndRenderFamilies, 300);
});

// Filter change
purokFilterSelect.addEventListener('change', fetchAndRenderFamilies);

// Card selection
familyCardContainer.addEventListener('click', (event) => {
    const clickedCard = event.target.closest('.family-card');
    if (!clickedCard) return;
    const isAlreadySelected = clickedCard.classList.contains('border-blue-500');
    const currentlySelected = familyCardContainer.querySelector('.border-blue-500');
    if (currentlySelected) currentlySelected.classList.remove(...selectionClasses);
    if (!isAlreadySelected) {
        clickedCard.classList.add(...selectionClasses);
        const chosenFamilyId = parseInt(clickedCard.dataset.familyId, 10);
        chosenFamily = familiesData.find(family => family.id === chosenFamilyId);
    } else {
        chosenFamily = null;
    }
    confirmChooseFamilyBtn.disabled = !chosenFamily;
});

// Modal action buttons
confirmChooseFamilyBtn.addEventListener('click', () => {
    if (chosenFamily) {
        const familyHeadName = chosenFamily.head ? `${chosenFamily.head.firstName} ${chosenFamily.head.lastName}` : `FAM-${String(chosenFamily.id).padStart(3, '0')}`;
        familyIdStorage.textContent = chosenFamily.id;
        familyIdStorage.dispatchEvent(new Event('change', { bubbles: true }));
        completeAddress.value = `HH-${chosenFamily.household.id}, ${chosenFamily.purok.name}, ${chosenFamily.purok.barangay.name}, Daraga, Albay`;
        chooseFamilyModal.hide();
        addResidentModal.show();
    }
});

cancelChooseFamilyBtn.addEventListener('click', () => {
    chooseFamilyBtn.textContent = "Choose Family..."
    familyIdStorage.textContent = '';
    chosenFamily = null;
    chooseFamilyModal.hide();
    addResidentModal.show();
});

// --- Array of fields requiring validation (Suffix is excluded) ---
const fieldsToValidate = [
    residentFirstName, residentLastName, residentMiddleName, residentBirthdate,
    educAttainment, residentSex, civilStatus, religion,
    ethnicity, employmentStatus, pwdStatus, indigenousStatus, soloParentStatus, philhealthStatus
];

// --- 1. Age Calculation Logic ---
const calculateAge = () => {
    const birthdateValue = residentBirthdate.value;
    if (birthdateValue) {
        const birthDate = new Date(birthdateValue);
        const today = new Date();

        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDifference = today.getMonth() - birthDate.getMonth();
        const dayDifference = today.getDate() - birthDate.getDate();

        // If the birthday hasn't occurred yet this year, subtract one year
        if (monthDifference < 0 || (monthDifference === 0 && dayDifference < 0)) {
            age--;
        }
        residentAge.value = age >= 0 ? age : ''; // Display age or clear if invalid date
    } else {
        residentAge.value = ''; // Clear age if birthdate is empty
    }
};

// --- 2. Form Validation Logic ---
const validateForm = () => {
    // Check standard inputs and selects
    const allStandardFieldsValid = fieldsToValidate.every(field => field.value.trim() !== '');

    // Validate contact number format (11 digits, starts with 09)
    // Check if a family has been selected
    const isFamilySelected = familyIdStorage.textContent.trim() !== '';

    return allStandardFieldsValid && isFamilySelected;
};

// --- 3. Handler to Enable/Disable Submit Button ---
const handleFormChange = () => {
    if (validateForm()) {
        addResidentButton.disabled = false;
    } else {
        addResidentButton.disabled = true;
    }
};

// --- 4. Attach All Event Listeners ---

// Initial state check
handleFormChange();

// Listener for the birthdate field to auto-calculate age
residentBirthdate.addEventListener('input', calculateAge);

// Listeners for all fields that trigger validation
fieldsToValidate.forEach(field => {
    field.addEventListener('input', handleFormChange);
    field.addEventListener('change', handleFormChange);
});

// Separate listener for the contact number field
residentContactNo.addEventListener('input', handleFormChange);

// MutationObserver to watch for programmatic changes to familyIdStorage
const observer = new MutationObserver(() => {
    handleFormChange();
});
observer.observe(familyIdStorage, { childList: true, characterData: true, subtree: true });


addResidentButton.addEventListener('click', function () {
    // This payload object gathers all the values from your form fields
    currentResidentPayload = {
        // Section 1: Name
        first_name: residentFirstName.value.trim(),
        last_name: residentLastName.value.trim(),
        middle_name: residentMiddleName.value.trim(),
        suffix: suffix.value,

        // Section 2: Contact & Demographics
        contact_no: residentContactNo.value.trim(),
        sex: residentSex.value,
        birthdate: residentBirthdate.value,
        age: residentAge.value,

        // Section 3: Household & Family
        family_id: familyIdStorage.textContent.trim(), // Get ID from the hidden div

        philhealth_no: philhealthNo.value.trim(),

        educational_attainment: educAttainment.value,
        // Section 5: Socio-Economic Status
        civil_status: civilStatus.value,
        religion: religion.value,
        ethnicity: ethnicity.value,
        employment_status: employmentStatus.value,

        // Section 6: Special Statuses & Emergency Contact
        is_pwd: pwdStatus.value === 'Yes' ? 1 : 0,
        pwd_id: pwdIdInput.value.trim(),
        is_indigenous: indigenousStatus.value === 'Yes' ? 1 : 0,
        is_solo_parent: soloParentStatus.value === 'Yes' ? 1 : 0,
        is_philhealth_member: philhealthStatus.value === 'Yes' ? 1 : 0,
        emergency_contact_no: emergencyContactNo.value.trim()
    };

    // You can now see the complete payload in your browser's console
    console.log("Resident Data Payload:", currentResidentPayload);
    residentFullNameConfirm.textContent =
        [residentFirstName.value, residentMiddleName.value, residentLastName.value, suffix.value]
            .map(name => name?.trim())
            .filter(Boolean)
            .join(' ');
    addResidentModal.hide();

    confirmResidentModal.show();

});


cancelConfirm.addEventListener('click', function () {
    confirmResidentModal.hide();
    addResidentModal.show();
});

confirmResidentCheckbox.addEventListener('change', function () {
    confirmAddResidentSubmitBtn.disabled = !this.checked;
});

confirmAddResidentSubmitBtn.addEventListener('click', function () {
    // Disable buttons and show loading state
    confirmAddResidentSubmitBtn.disabled = true;
    cancelConfirm.disabled = true;
    confirmResidentCheckbox.disabled = true;

    const originalButtonText = confirmAddResidentSubmitBtn.textContent;
    confirmAddResidentSubmitBtn.textContent = 'Saving...';

    fetch('/barangay/resident/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(currentResidentPayload)
    })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) {
                // Laravel returned a 422 or other error
                console.error('Validation failed:', data.errors);

                // Re-enable buttons on error
                confirmAddResidentSubmitBtn.disabled = false;
                cancelConfirm.disabled = false;
                confirmResidentCheckbox.disabled = false;
                confirmAddResidentSubmitBtn.textContent = originalButtonText;
                return;
            }
            console.log('Response from backend:', data);

            if (data.status === 'success') {
                console.log(data);

                // Close confirmation modal
                confirmResidentModal.hide();

                // Show success modal
                successMesageHeader.textContent = 'Resident Added Successfully';
                successMessage.textContent = 'The resident has been added to the system.';
                successModal.show();

                // Store resident ID for redirect
                const residentId = data.data.id;


            }
        })
        .catch(err => {
            console.error('Error:', err);

            // Re-enable buttons on network error
            confirmAddResidentSubmitBtn.disabled = false;
            cancelConfirm.disabled = false;
            confirmResidentCheckbox.disabled = false;
            confirmAddResidentSubmitBtn.textContent = originalButtonText;
        });
});
// Redirect when success modal is closed
closeSuccessModalButton.addEventListener('click', function () {
    successModal.hide();
    window.location.href = `/barangay/residents/${residentId}`;
});