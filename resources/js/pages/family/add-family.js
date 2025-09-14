// The main modal element
const addFamilyModalEl = document.getElementById('add-family-modal');

// Button to trigger household selection
const selectHouseholdButton = document.getElementById('selectHouseholdButton');
const selectFamilyHeadButton = document.getElementById('selectFamilyHeadButton');

const is4psButton = document.getElementById('is4psButton');
const is4psButtonText = document.getElementById('is4psButtonText');
const psDropdownMenu = document.getElementById('4psDropdownMenu');

const isIndigentButton = document.getElementById('isIndigentButton');
const isIndigentButtonText = document.getElementById('isIndigentButtonText');
const indigentDropdownMenu = document.getElementById('indigentDropdownMenu');

const cancelAddFamilyButton = document.getElementById('cancelAddFamilyButton');
const proceedAddHouseholdButton = document.getElementById('proceedAddHouseholdButton');

// The main confirmation modal element
const confirmAddFamilyModalEl = document.getElementById('confirm-add-family-modal');
const confirmFamilyCheckbox = document.getElementById('confirm-family-checkbox');
const confirmAddFamilyCancelBtn = document.getElementById('confirm-add-family-cancel');
const confirmAddFamilySubmitBtn = document.getElementById('confirm-add-family-submit');

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

const switchHouseholdModalEl = document.getElementById('switchHouseholdModal');

// The search input field
const householdSearchInput = document.getElementById('household-search');
const closeChooseHousehold = document.getElementById('cancelChooseHousehold');

const purokFilterDropdownButton = document.getElementById('purokFilterDropdownButton');
const purokFilterDropdownMenu = document.getElementById('purokFilterDropdownMenu')

const addFamilyTriggerBtn = document.getElementById('add-family-trigger');

const addFamilyModal = new Modal(addFamilyModalEl);
const confirmAddFamilyModal = new Modal(confirmAddFamilyModalEl);
const switchHouseholdModal = new Modal(switchHouseholdModalEl);
const successModal = new Modal(successModalEl);

const householdTableBody = document.getElementById('switchHHTableBody'); // Target for rendering rows

let household = window.household;
let householdHead;

const barangayName = window.barangay_name;
const barangayId = window.barangay_id;

// NEW: Completed validation function
function validateForm() {
    const is4psSelected = is4psButtonText.textContent !== 'Select';
    const isIndigentSelected = isIndigentButtonText.textContent !== 'Select';

    // If both dropdowns have a value, enable the button. Otherwise, disable it.
    if (is4psSelected && isIndigentSelected) {
        proceedAddHouseholdButton.disabled = false;
    } else {
        proceedAddHouseholdButton.disabled = true;
    }
}

proceedAddHouseholdButton.addEventListener('click', function(){
    event.preventDefault();

    addFamilyModal.hide();
    confirmAddFamilyModal.show();
});


addFamilyTriggerBtn.addEventListener('click', function() {    
    // CHANGED: Ensure the button is disabled when the modal opens
    proceedAddHouseholdButton.disabled = true; 

    addFamilyModal.show();
});

cancelAddFamilyButton.addEventListener('click', function() {
    householdHead = null;
    selectFamilyHeadButton.textContent = "Select Household Head";
    isIndigentButtonText.textContent = "Select";
    is4psButtonText.textContent = "Select";

    // CHANGED: Ensure the button is disabled when the form is reset
    proceedAddHouseholdButton.disabled = true; 

    addFamilyModal.hide();
});

function setupDropdownValueUpdater(buttonEl, menuEl, textEl) {
    const optionButtons = menuEl.querySelectorAll('button');

    optionButtons.forEach(option => {
        option.addEventListener('click', () => {
            const selectedValue = option.getAttribute('data-value');
            textEl.textContent = selectedValue;
            textEl.classList.remove('text-gray-400');
            textEl.classList.add('text-normal_font');
            buttonEl.click();
            
            // CHANGED: Call the validation function every time a value changes
            validateForm();
        });
    });
}

setupDropdownValueUpdater(is4psButton, psDropdownMenu, is4psButtonText);
setupDropdownValueUpdater(isIndigentButton, indigentDropdownMenu, isIndigentButtonText);

confirmFamilyCheckbox.addEventListener('change', function(){
    confirmAddFamilySubmitBtn.disabled = !this.checked;
});

confirmAddFamilySubmitBtn.addEventListener('click', function () {
    const addFamilyPayload = {
        household_id: household.id,
        familyHeadId: null,
        is4ps: is4psButtonText.textContent,
        isIndigent: isIndigentButtonText.textContent
    };

    fetch('/barangays/families/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(addFamilyPayload)
    })
    .then(response => response.json())
    .then(data => {
        //console.log("Server response:", data);
        if(data.status === 'success'){
            confirmAddFamilyModal.hide();
            successMesageHeader.textContent = "Family Added";
            successMessage.textContent = "Family has been succussfully added to the household";
            successModal.show();
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});

let debounceTimer;

function debounce(func, delay) {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(func, delay);
}

async function fetchHouseholds() {
    // 1. Get current values from search and filter
    const searchQuery = householdSearchInput.value.trim();
    const purokFilter = purokFilterDropdownButton.textContent.trim();

    // 2. Build query params
    const params = new URLSearchParams();
    if (searchQuery) {
        params.append('search', searchQuery);
    }
    if (purokFilter && purokFilter !== 'All Puroks') {
        params.append('purok', purokFilter);
    }

    // 3. Build full URL
    const url = `/barangay/households/get?${params.toString()}`;

    try {
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();

        console.log("Fetched households:", data.households);

        renderHouseholds(data.households);

    } catch (error) {
        console.error("Failed to fetch households:", error);
        householdTableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-4 text-red-500">
                    Failed to load data.
                </td>
            </tr>`;
    }
}

function renderHouseholds(households) {
    // 1. Clear the existing table body
    householdTableBody.innerHTML = '';

    // 2. Handle case where no households are found
    if (!households || households.length === 0) {
        householdTableBody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-gray-500">No households found.</td></tr>`;
        return;
    }

    // 3. Create and append a new row for each household
    households.forEach((household, index) => {
        const rowHTML = `
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input id="checkbox-table-${index}" type="checkbox" value="${household.id}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="checkbox-table-${index}" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    ${household.id}
                </th>
                <td class="px-6 py-4">${household.head_name}</td>
                <td class="px-6 py-4">${household.member_count}</td>
                <td class="px-6 py-4">${household.purok}</td>
            </tr>
        `;
        householdTableBody.insertAdjacentHTML('beforeend', rowHTML);
    });
}


closeSuccessModalButton.addEventListener('click', function(){
    window.location.reload();
});


// When the "Select Household" button is clicked
selectHouseholdButton.addEventListener('click', function() {
    addFamilyModal.hide();
    switchHouseholdModal.show();
    console.log(barangayId);
    fetchHouseholds(); // Fetch initial list of households
});

// When the user types in the search bar
householdSearchInput.addEventListener('input', () => {
    debounce(fetchHouseholds, 300); // Debounce to wait 300ms after user stops typing
});

// When a purok filter is selected from the dropdown
purokFilterDropdownMenu.addEventListener('click', (event) => {
    // Check if a filter link was clicked
    if (event.target.tagName === 'A') {
        const selectedPurok = event.target.textContent;
        purokFilterDropdownButton.textContent = selectedPurok; // Update button text
        fetchHouseholds(); // Re-fetch data with the new filter
    }
});

closeChooseHousehold.addEventListener('click', function(){
    switchHouseholdModal.hide();
    addFamilyModal.show();
});