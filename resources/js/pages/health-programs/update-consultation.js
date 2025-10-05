// --- Existing Element Variables ---

// Main Modal Elements
const createConsultationModalEl = document.getElementById('create-consultation-modal');
const consultationModalTitle = document.getElementById('consultation-modal-title');
const consultationModalSubtitle = document.getElementById('consultation-modal-subtitle');

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

// Buttons
const distributeMedicineBtn = document.getElementById('distributeMedicineBtn');
const consultationCancelBtn = document.getElementById('consultationCancelBtn');
const saveConsultationBtn = document.getElementById('saveConsultationBtn');

// Main Modal Element
const distributeMedicineModalEl = document.getElementById('distribute-medicine-modal');

const distributeMedicineModal = new Modal(distributeMedicineModalEl);
// Left Column: Chosen Medicine
const chosenMedicineList = document.getElementById('chosen-medicine-list');
const chosenMedicinePlaceholder = document.getElementById('chosen-medicine-placeholder');

// Right Column: Medicine List & Quantity
const medicineSearch = document.getElementById('medicine-search');
const medicineListContainer = document.getElementById('medicine-list-container');
const medicineQuantity = document.getElementById('medicine-quantity');

// Modal Footer Buttons
const cancelDistributeButton = document.getElementById('cancel-distribute-button');
const distributeButton = document.getElementById('distribute-button');

// --- New Logic to Trigger the Modal ---
const createConsultationModal = new Modal(createConsultationModalEl);

// 1. Select all the update buttons from the table
const updateButtons = document.querySelectorAll('.js-update-consultation-btn');

// 2. Add a click event listener to each button
updateButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Get the specific consultation ID from the button's data attribute
        const consultationId = button.dataset.consultationId;
        
        console.log('Opening modal to update consultation ID:', consultationId);

        // TODO: Here you would typically fetch the existing data for this consultation
        // using the 'consultationId' and populate the form fields before showing the modal.
        // For example:
        // fetch(`/api/consultations/${consultationId}`)
        //     .then(response => response.json())
        //     .then(data => {
        //         // Populate your form fields
        //         fatherName.value = data.father_name;
        //         // ...etc.
        //     });

       createConsultationModal.show();
    });
});


distributeMedicineBtn.addEventListener('click', function(){
    createConsultationModal.hide();
    distributeMedicineModal.show();
});

cancelDistributeButton.addEventListener('click', function(){
    createConsultationModal.show();
    distributeMedicineModal.hide();
});