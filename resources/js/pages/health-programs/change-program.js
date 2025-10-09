// --- Modal & UI Element Variables ---
const switchProgramModalEl = document.getElementById('switchProgramModal');
const openSwitchProgramBtn = document.getElementById('open-change-program');
const switchProgramModal = new Modal(switchProgramModalEl);
const searchInput = document.getElementById('default-search');

// CORRECTED: Use the specific ID for the container
const programTypeSelect = document.getElementById('programTypeSelect'); // Added the select element
const programsSection = document.getElementById('programs-section'); 
const closeButton = document.getElementById('close-change-program');
const changeProgramButton = document.getElementById('change-program-btn');

// The main container for the confirmation modal
const confirmSwitchModalEl = document.getElementById('confirm-switch-program-modal');
const programNameToConfirmEl = document.getElementById('program-name-to-confirm');
const confirmSwitchCheckbox = document.getElementById('confirm-switch-checkbox');
const confirmSwitchCancelBtn = document.getElementById('confirm-switch-cancel-button');
const confirmSwitchProceedBtn = document.getElementById('confirm-switch-proceed-button');

const confirmSwitchModal = new Modal(confirmSwitchModalEl);
const defProgramID = window.currentProgram;

let selectedProgramName = null;
let selectedProgramId = null;

function debounce(func, delay = 300) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
}
function toTitleCase(str) {
    return str.replace(/\w\S*/g, (txt) => {
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}

// --- Function to Render Program Cards (Updated to use the correct element) ---
function renderPrograms(programs) {
    // 1. Check if the fetched data is empty
    if (!programs || programs.length === 0) {
        programsSection.innerHTML = `
            <div class="flex flex-col items-center justify-center h-full p-4 text-center">
                <img src="${emptyImageUrl}" alt="No fields found" class="mx-auto w-32">
                <p class="text-gray-600 font-medium">No Programs Found</p>
                <p class="text-sm text-gray-500">Try adjusting your search or filter.</p>
            </div>
        `;
        return;
    }
    console.log(defProgramID);
    const filteredPrograms = programs.filter(program => program.id !== defProgramID);

    // 2b. If nothing remains after filtering
    if (filteredPrograms.length === 0) {
        programsSection.innerHTML = `
            <div class="flex flex-col items-center justify-center h-full p-4 text-center">
                <img src="${emptyImageUrl}" alt="No fields found" class="mx-auto w-32">
                <p class="text-gray-600 font-medium">No Other Programs Found</p>
                <p class="text-sm text-gray-500">You are already on the only available program.</p>
            </div>
        `;
        return;
    }

    // 3. Map the program data to HTML card strings
    const programCardsHTML = filteredPrograms.map(program => {
        const category = program.category ?? 'Not Specified';
        const enrolledCount = program.enrolled_residents_count;

        return `
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md hover:border-blue-400 transition-all duration-200 cursor-pointer" data-program-id="${program.id}">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="font-bold text-main_font">${program.name}</h3>
                    <span class="bg-gray-100 text-gray-700 text-xs font-mono px-2 py-0.5 rounded-full">ID: ${program.id}</span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs text-gray-500">Enrolled</p>
                        <p class="font-semibold text-gray-800">${enrolledCount}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Program Type</p>
                        <p class="font-semibold text-gray-800">${toTitleCase(category)}</p>
                    </div>
                </div>
            </div>
        `;
    }).join('');

    // 3. Insert the generated HTML into the specific 'programs-section' div
    programsSection.innerHTML = `
        <div class="grid grid-cols-1 gap-4 p-2">
            ${programCardsHTML}
        </div>
    `;
}

// --- Consolidated Data Fetching Function ---
function fetchAndRenderPrograms() {
    const searchTerm = searchInput.value.trim();
    const programType = programTypeSelect.value;

    const params = new URLSearchParams();
    
    // Add parameters only if they have a value
    if (searchTerm) {
        params.append('search', searchTerm);
    }
    if (programType && programType !== 'Select a type') {
        params.append('category', programType); // Assuming the API parameter is 'category'
    }

    console.log(`Fetching with params: ${params.toString()}`);

    fetch(`/barangay/health-program/fetch?${params.toString()}`)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            renderPrograms(data);
        })
        .catch(error => {
            console.error("Error fetching programs:", error);
            programsSection.innerHTML = `<p class="p-4 text-red-600">Failed to load programs. Please try again.</p>`;
        });
}

// 1. When the modal is opened, reset state and fetch the initial list
openSwitchProgramBtn.addEventListener('click', function () {
    // Reset state every time the modal opens
    selectedProgramId = null;
    searchInput.value = '';
    programTypeSelect.selectedIndex = 0;
    
    // Disable the confirm button until a selection is made
    changeProgramButton.disabled = true;
    changeProgramButton.classList.add('opacity-50', 'cursor-not-allowed');

    fetchAndRenderPrograms();
    switchProgramModal.show();
});

// 2. When the select dropdown value changes, fetch new data
programTypeSelect.addEventListener('change', fetchAndRenderPrograms);

// 3. When the user types in the search input, fetch new data after a short delay
searchInput.addEventListener('input', debounce(fetchAndRenderPrograms, 400));

programsSection.addEventListener('click', function(event) {
    const clickedCard = event.target.closest('[data-program-id]');

    if (!clickedCard) {
        return; // Click was not on a card
    }

    const programId = clickedCard.dataset.programId;
    
    if (selectedProgramId === programId) {
        // **CASE 1: The clicked card is already selected (DESELECT IT)**
        clickedCard.classList.remove('border-blue-500', 'ring-2', 'ring-blue-300');
        
        // Reset both ID and Name
        selectedProgramId = null;
        selectedProgramName = null;
        
        changeProgramButton.disabled = true;
        changeProgramButton.classList.add('opacity-50', 'cursor-not-allowed');

    } else {
        // **CASE 2: A new card is selected (SELECT IT)**
        const allCards = programsSection.querySelectorAll('[data-program-id]');
        allCards.forEach(card => {
            card.classList.remove('border-blue-500', 'ring-2', 'ring-blue-300');
        });

        clickedCard.classList.add('border-blue-500', 'ring-2', 'ring-blue-300');
        
        const programNameElement = clickedCard.querySelector('h3');

        // Store both the ID and the Name
        selectedProgramId = programId;
        selectedProgramName = programNameElement ? programNameElement.textContent.trim() : ''; // Get name from h3
        
        changeProgramButton.disabled = false;
        changeProgramButton.classList.remove('opacity-50', 'cursor-not-allowed');

        console.log(`Selected Program ID: ${selectedProgramId}`);
        console.log(`Selected Program Name: ${selectedProgramName}`); // Log the name
    }
});

// 5. Add functionality to the "Change Program" button
changeProgramButton.addEventListener('click', function() {
    switchProgramModal.hide();
    programNameToConfirmEl.textContent = selectedProgramName;
    confirmSwitchModal.show();
});

confirmSwitchCheckbox.addEventListener('click', function(){
    confirmSwitchProceedBtn.disabled = !this.checked;
});

confirmSwitchCancelBtn.addEventListener('click', function(){
    confirmSwitchModal.hide();
    switchProgramModal.show();
});

closeButton.addEventListener('click', function(){
    switchProgramModal.hide();
});


confirmSwitchProceedBtn.addEventListener('click', function() {
    const programId = selectedProgramId; // you already have this variable
    window.location.href = `/barangay/health-programs/${programId}`;
});
