const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

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

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

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
    // Disable button and show loading state
    confirmFaqProceedBtn.disabled = true;
    const originalButtonText = confirmFaqProceedBtn.textContent;
    confirmFaqProceedBtn.textContent = 'Saving...';

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
            // Hide confirmation modal
            confirmAddFaqModal.hide();
            
            // Reset form and button state
            createFaqForm.reset();
            saveFaqBtn.disabled = true;
            
            // Set success modal message
            successMesageHeader.textContent = 'Success!';
            successMessage.textContent = 'FAQ created successfully.';
            
            // Show success modal
            successModal.show();
            
        } else {
            // Show error alert
            alert('Failed to create FAQ: ' + (data.message || 'Unknown error'));
            
            // Reset button state
            confirmFaqProceedBtn.disabled = false;
            confirmFaqProceedBtn.textContent = originalButtonText;
            
            confirmAddFaqModal.hide();
        }
    })
    .catch(error => {
        // Show error alert
        alert('Error creating FAQ: ' + error.message);
        
        // Reset button state
        confirmFaqProceedBtn.disabled = false;
        confirmFaqProceedBtn.textContent = originalButtonText;
        
        confirmAddFaqModal.hide();
    });
});

// Success modal close handler
closeSuccessModalButton.addEventListener('click', () => {
    successModal.hide();
    
    // Reset confirm button state
    confirmFaqProceedBtn.disabled = true;
    confirmFaqProceedBtn.textContent = 'Proceed';
    
    // Reload page or update DOM
    location.reload();
});