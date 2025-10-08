// --- Existing Element Variables ---

// Main Modal Elements
const createConsultationModalEl = document.getElementById('create-consultation-modal');
const consultationModalTitle = document.getElementById('consultation-modal-title');
const consultationModalSubtitle = document.getElementById('consultation-modal-subtitle');
let currentConsultationId = null;
// Form Input Fields
const consultationDate = document.getElementById('consultation_date');
const fatherName = document.getElementById('father_name');
const motherName = document.getElementById('mother_name');
const chiefComplaint = document.getElementById('chief_complaint');
const treatment = document.getElementById('treatment');
const weight = document.getElementById('weight');
const height = document.getElementById('height');
const temperature = document.getElementById('temperature');
const pr = document.getElementById('pr');
const rr = document.getElementById('rr');
const birthweight = document.getElementById('birthweight');
const bpSystolic = document.getElementById('bp_systolic');
const bpDiastolic = document.getElementById('bp_diastolic');
const isPhilhealth = document.getElementById('is_philhealth'); 

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');


const successModal = new Modal(successModalEl, {backdrop: 'static',closable: true,});

let currentConsultation = null;

let payload = null;

const insufficientIndicator = document.getElementById('insufficient-indicator');
let distributedMedicines = [];
let medicineInventory = null;

let prevDistributed = [];
let prevInventory = null;

const appendMedicineBtn = document.getElementById('append-medicine');
// Buttons
const distributeMedicineBtn = document.getElementById('distributeMedicineBtn');
const consultationCancelBtn = document.getElementById('consultationCancelBtn');
const saveConsultationBtn = document.getElementById('saveConsultationBtn');

// Main Modal Element
const distributeMedicineModalEl = document.getElementById('distribute-medicine-modal');

const distributeMedicineModal = new Modal(distributeMedicineModalEl, {backdrop: 'static',closable: true,});

const chosenMedicineList = document.getElementById('chosen-medicine-list');
const chosenMedicinePlaceholder = document.getElementById('chosen-medicine-placeholder');

// Right Column: Medicine List & Quantity
const medicineSearch = document.getElementById('medicine-search');
const medicineListContainer = document.getElementById('medicine-list-container');
const medicineQuantity = document.getElementById('medicine-quantity');

let clickedMedicine = null;
let chosenMedicine = null;

// Modal Footer Buttons
const cancelDistributeButton = document.getElementById('cancel-distribute-button');
const distributeButton = document.getElementById('distribute-button');

// --- New Logic to Trigger the Modal ---
const createConsultationModal = new Modal(createConsultationModalEl, {backdrop: 'static',closable: true,});

// 1. Select all the update buttons from the table
const updateButtons = document.querySelectorAll('.js-update-consultation-btn');
// --- Consultation Confirmation Modal Elements ---

const confirmAddConsultationModalEl = document.getElementById('confirm-add-consultation-modal');
const patientNameToConfirm = document.getElementById('patient-name-to-confirm');
const consultationDateToConfirm = document.getElementById('consultation-date-to-confirm');
const confirmConsultationCheckbox = document.getElementById('confirm-consultation-checkbox');
const confirmAddConsultationCancelBtn = document.getElementById('confirm-add-consultation-cancel');
const confirmConsultationProceedBtn = document.getElementById('confirm-consultation-proceed-button');

const confirmAddConsultationModal = new Modal(confirmAddConsultationModalEl, {backdrop: 'static',closable: true,});

function renderMedicineList() {
    // Clear any existing content
    medicineListContainer.innerHTML = '';

    // If there's no inventory, show a message
    if (!medicineInventory || medicineInventory.length === 0) {
        medicineListContainer.innerHTML = '<p class="text-center text-gray-500 dark:text-gray-400">No medicines available.</p>';
        return;
    }

    // Create and append a card for each medicine
    medicineInventory.forEach(medicine => {
        // Determine stock color: green for available, red for zero
        const stockColor = medicine.remaining_stock > 0 ? 'text-green-600' : 'text-red-600';
        
        const medicineCardHTML = `
            <div class="medicine-card p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer" data-medicine-id="${medicine.id}">
                <p class="font-semibold text-main_font dark:text-white pointer-events-none">${medicine.medicine_name}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 pointer-events-none">
                    ${medicine.form} - <span class="font-medium ${stockColor}">${medicine.remaining_stock} in stock</span>
                </p>
            </div>
        `;
        medicineListContainer.insertAdjacentHTML('beforeend', medicineCardHTML);
    });
}

function renderDistributedList() {
    // Clear only the medicine items, not the placeholder
    chosenMedicineList.querySelectorAll('.distributed-medicine-item').forEach(item => item.remove());

    if (distributedMedicines.length === 0) {
        // Show the placeholder if the list is empty
        chosenMedicinePlaceholder.classList.remove('hidden');
        chosenMedicinePlaceholder.classList.add('flex');
    } else {
        // Hide the placeholder and render the items
        chosenMedicinePlaceholder.classList.add('hidden');
        chosenMedicinePlaceholder.classList.remove('flex');

        distributedMedicines.forEach(medicine => {
            const medicineItemHTML = `
                <div class="distributed-medicine-item flex items-center justify-between bg-white dark:bg-gray-800 p-3 rounded-lg shadow-sm">
                    <div>
                        <p class="font-semibold text-main_font dark:text-white">${medicine.medicine_name}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">${medicine.form}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="font-bold text-main_font dark:text-white">x ${medicine.quantity}</span>
                        
                        <!-- The remove button now has a class and a data attribute -->
                        <button title="Remove" class="remove-medicine-btn text-red-500 hover:text-red-700" data-medicine-id="${medicine.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            chosenMedicineList.insertAdjacentHTML('beforeend', medicineItemHTML);
        });
    }
}


function removeDistributedMedicine(medicineId) {
    // Find the index of the medicine to remove from our distributed list
    const indexToRemove = distributedMedicines.findIndex(med => med.id == medicineId);

    if (indexToRemove === -1) {
        console.error("Error: Could not find the medicine to remove.");
        return;
    }

    // Get the item we are about to remove to access its quantity
    const itemToRemove = distributedMedicines[indexToRemove];

    // Find the corresponding medicine in the main inventory
    const originalInventoryItem = medicineInventory.find(med => med.id == medicineId);

    if (originalInventoryItem) {
        // Add the quantity back to the main inventory stock
        originalInventoryItem.remaining_stock += itemToRemove.quantity;
    }

    // Remove the item from the distributedMedicines array
    distributedMedicines.splice(indexToRemove, 1);

    // Re-render both lists to reflect the change
    renderDistributedList(); 
    renderMedicineList();    
}

chosenMedicineList.addEventListener('click', function (event) {
    // Check if the clicked element is a remove button
    const removeButton = event.target.closest('.remove-medicine-btn');

    // If the click was not on a remove button, do nothing.
    if (!removeButton) {
        return;
    }

    // Get the ID of the medicine from the button's data attribute
    const medicineId = removeButton.dataset.medicineId;

    // Call our function to handle the removal logic
    removeDistributedMedicine(medicineId);
});


medicineListContainer.addEventListener('click', (event) => {
    // Find the actual card that was clicked on
    const clickedCard = event.target.closest('.medicine-card');

    // If the click was not on a card, do nothing
    if (!clickedCard) {
        return;
    }

    // Define highlight classes (using your nav_blue concept)
    const highlightClasses = ['bg-blue-100', 'dark:bg-blue-900/50', 'border', 'border-blue-400'];

    // If there was a previously selected medicine, remove its highlight
    if (clickedMedicine) {
        clickedMedicine.classList.remove(...highlightClasses);
    }

    // If the user clicks the same card again, deselect it
    if (clickedMedicine === clickedCard) {
        clickedMedicine = null;
        medicineQuantity.disabled = true;
    } else {
        clickedCard.classList.add(...highlightClasses);
        clickedMedicine = clickedCard;
        chosenMedicine = clickedCard.dataset.medicineId;
        medicineQuantity.disabled = false;
    }

    console.log(clickedMedicine.dataset.medicineId);

});

medicineQuantity.addEventListener('input', function() {
    // make sure something is selected
    if (!chosenMedicine) return;

    // find the selected medicine in the inventory
    const currentMedicine = medicineInventory.find(
        medicine => medicine.id == chosenMedicine
    );

    // parse user input safely
    const inputQty = parseInt(medicineQuantity.value) || 0;

    // make sure elements exist
    if (!currentMedicine || !insufficientIndicator) return;

    // check if input exceeds stock
    if (inputQty > currentMedicine.remaining_stock) {
        insufficientIndicator.classList.remove('hidden');
        appendMedicineBtn.disabled = true; // optional, to prevent proceeding
    } else {
        // check if input is empty or non-numerical
        if (
            medicineQuantity.value.trim() === '' || 
            isNaN(medicineQuantity.value)
        ) {
            insufficientIndicator.classList.add('hidden');
            appendMedicineBtn.disabled = true; // disable until valid input
        } else {
            insufficientIndicator.classList.add('hidden');
            appendMedicineBtn.disabled = false;
        }
    }

});

appendMedicineBtn.addEventListener('click', function () {
    const quantity = parseInt(medicineQuantity.value);

    // find the chosen medicine in the inventory
    const selected = medicineInventory.find(med => med.id == chosenMedicine);

    if (!selected) {
        console.error('No medicine selected!');
        return;
    }

    // prevent distribution if insufficient stock
    if (quantity > selected.remaining_stock) {
        insufficientIndicator.classList.remove('hidden');
        return;
    }

    // decrease the stock in the inventory
    selected.remaining_stock -= quantity;

    // push to distributed list
    distributedMedicines.push({
        id: selected.id,
        medicine_name: selected.medicine_name,
        quantity: quantity,
        form: selected.form,
    });

    // re-render your medicine list to reflect updated stock
    renderMedicineList();
    renderDistributedList();

    // optionally clear input fields
    medicineQuantity.value = '';
    insufficientIndicator.classList.add('hidden');
    appendMedicineBtn.disabled = true;

    medicineQuantity.disabled = true;
    chosenMedicine = null;

    distributeButton.disabled = false;
});

updateButtons.forEach(button => {
    button.addEventListener('click', async () => {
        const consultationId = button.dataset.consultationId;
        currentConsultationId = consultationId;
        consultationModalTitle.textContent = 'Update Consultation';
        try {
            const response = await fetch(`/barangay/consultation/${consultationId}`);
            if (!response.ok) throw new Error('Failed to fetch consultation data');

            const data = await response.json();
            console.log('Fetched consultation:', data);

            // CORRECTED LINE: Access the nested object
            const consultation = data.consultation_data.consultation_data;
            
            // Assign the entire object to your state variable
            currentConsultation = consultation;

            if (consultation) {
                // This part will now work correctly
                fatherName.value = consultation.father_name || '';
                motherName.value = consultation.mother_name || '';
                chiefComplaint.value = consultation.chief_complaint || '';
                treatment.value = consultation.treatment || '';
                weight.value = consultation.weight || '';
                height.value = consultation.height || '';
                temperature.value = consultation.temperature || '';
                pr.value = consultation.pr || '';
                rr.value = consultation.rr || '';
                birthweight.value = consultation.birthweight || '';
                bpSystolic.value = consultation.bp_systolic || '';
                bpDiastolic.value = consultation.bp_diastolic || '';
                
                // Since `is_philhealth` is a boolean (false), you can assign it directly
                isPhilhealth.checked = consultation.is_philhealth;
            }
            
            createConsultationModal.show();
        } catch (error) {
            console.error('Error fetching consultation:', error);
            alert('Failed to load consultation data.');
        }
    });
});
distributeMedicineBtn.addEventListener('click', function() {
    if (!medicineInventory && !prevInventory) {
        fetch('/barangay/get-medicines')
            .then(response => {
                if (!response.ok) throw new Error('Failed to fetch medicines');
                return response.json();
            })
            .then(data => {
                medicineInventory = data;

                createConsultationModal.hide();
                distributeMedicineModal.show();

                renderMedicineList();
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        if(prevDistributed){
            medicineInventory = structuredClone(prevInventory);
            distributedMedicines = structuredClone(prevDistributed);

            console.log('vakla');
        }
        createConsultationModal.hide();
        distributeMedicineModal.show();
        
        console.log(prevDistributed);
        renderMedicineList();
        renderDistributedList();
    }
});

cancelDistributeButton.addEventListener('click', function(){
    createConsultationModal.show();
    distributeMedicineModal.hide();
    medicineQuantity.disabled = true;
    appendMedicineBtn.disabled = true;
    medicineInventory = null;
    distributedMedicines = [];
});

distributeButton.addEventListener('click', function(){
    prevInventory = structuredClone(medicineInventory);
    prevDistributed = structuredClone(distributedMedicines);

    distributeMedicineModal.hide();
    createConsultationModal.show();

});

consultationCancelBtn.addEventListener('click', function(){
    payload = null;
    medicineInventory = null;
    distributedMedicines = [];
    createConsultationModal.hide();
});


saveConsultationBtn.addEventListener('click', function(event) {
    event.preventDefault(); // prevent form submission
    console.log('vakla');

    // Prepare the payload
    payload = {
        consultation_id: currentConsultationId,
        consultation_date: consultationDate.value || null,
        father_name: fatherName.value || '',
        mother_name: motherName.value || '',
        chief_complaint: chiefComplaint.value || '',
        treatment: treatment.value || '',
        weight: parseInt(weight.value) || '',
        height: parseInt(height.value) || '',
        temperature: parseInt(temperature.value) || '',
        pr: parseInt(pr.value) || '',
        rr: parseInt(rr.value) || '',
        birthweight: parseInt(birthweight.value) || '',
        bp_systolic: parseInt(bpSystolic.value) || '',
        bp_diastolic: parseInt(bpDiastolic.value) || '',
        is_philhealth: parseInt(isPhilhealth.checked) ? 1 : 0,
        distributed_medicines: distributedMedicines 
    };

    console.log('Payload ready for submission:', payload);

    createConsultationModal.hide();
    confirmAddConsultationModal.show();
});

confirmConsultationCheckbox.addEventListener('change', function(){
    confirmConsultationProceedBtn.disabled = !this.checked;
});

confirmConsultationProceedBtn.addEventListener('click', async function() {
    console.log(payload); // optional for debugging

    try {
        const response = await fetch('/barangay/consultation/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        });

        if (!response.ok) throw new Error('Failed to submit consultation');

        const data = await response.json();
        console.log('Server response:', data);

        successMesageHeader.textContent = "Consultation Updated";
        successMessage.textContent = "You have succeessfully updated consultation";
        confirmAddConsultationModal.hide();
        successModal.show();

    } catch (error) {
        console.error('Error submitting consultation:', error);
    }
});

confirmAddConsultationCancelBtn.addEventListener('click', function(){
    confirmAddConsultationModal.hide();
    createConsultationModal.show();
});

closeSuccessModalButton.addEventListener('click', function(){
    window.location.reload();
});