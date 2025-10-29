const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

// --- Create FAQ Modal ---
const createFaqModalEl = document.getElementById('create-faq-modal');
const createFaqForm = document.getElementById('create-faq-form');
const cancelCreate = document.getElementById('faqCancelBtn');
const saveFaqBtn = document.getElementById('saveFaqBtn');

// --- Confirm Add FAQ Modal ---
const confirmAddFaqModalEl = document.getElementById('confirm-add-faq-modal');
const confirmFaqCheckbox = document.getElementById('confirm-faq-checkbox');
const confirmFaqCancelBtn = document.getElementById('confirm-add-faq-cancel');
const confirmFaqProceedBtn = document.getElementById('confirm-faq-proceed-button');

const createFaqModal = new Modal(createFaqModalEl, modalOptions);
const confirmAddFaqModal = new Modal(confirmAddFaqModalEl, modalOptions);

const createFaqTrigger = document.getElementById('add-faq-btn');

// Disable save button by default
saveFaqBtn.disabled = true;

// Function to check form validity and update button state
function updateSaveButtonState() {
    saveFaqBtn.disabled = !createFaqForm.checkValidity();
}

// Add input event listeners to all form fields for real-time validation
const formInputs = createFaqForm.querySelectorAll('input, textarea, select');
formInputs.forEach(input => {
    input.addEventListener('input', updateSaveButtonState);
    input.addEventListener('change', updateSaveButtonState);
});

createFaqTrigger.addEventListener('click', function(){
    createFaqModal.show();
    // Check initial state when modal opens
    updateSaveButtonState();
});

saveFaqBtn.addEventListener('click', (e) => {
    e.preventDefault();

    // Double-check form validity
    if (!createFaqForm.checkValidity()) {
        createFaqForm.reportValidity();
        return;
    }

    // Hide create modal, show confirm modal
    createFaqModal.hide();
    confirmAddFaqModal.show();

    // Reset confirmation modal state
    confirmFaqCheckbox.checked = false;
    confirmFaqProceedBtn.disabled = true;
});

confirmFaqCheckbox.addEventListener('change', () => {
    confirmFaqProceedBtn.disabled = !confirmFaqCheckbox.checked;
});

confirmFaqCancelBtn.addEventListener('click', () => {
    confirmAddFaqModal.hide();
    createFaqModal.show(); 
});

confirmFaqProceedBtn.addEventListener('click', () => {
    console.log('Submitting Create FAQ form...');

    // Create FormData object from the form
    const formData = new FormData(createFaqForm);
    
    // Convert FormData to JSON object
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });

    // Submit the form via AJAX
    fetch('/mho/faq/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            confirmAddFaqModal.hide();
            createFaqForm.reset();
            
            // Re-disable the save button after reset
            saveFaqBtn.disabled = true;

            alert('FAQ created successfully:', data.faq);
            // TODO: Show a success toast/alert
            location.reload(); // Or dynamically add the new FAQ to the list
        } else {
            alert('Failed to create FAQ:', data.message);
            confirmAddFaqModal.hide();
            location.reload(); // Or update the DOM dynamically
        }
    })
    .catch(error => {
        alert('Error creating FAQ:', error);
        confirmAddFaqModal.hide();
        // TODO: Show error toast
        location.reload(); // Or update the DOM dynamically
    });
});

cancelCreate.addEventListener('click', function(){
    createFaqForm.reset();
    createFaqModal.hide();
    // Re-disable the save button after reset
    saveFaqBtn.disabled = true;
});
