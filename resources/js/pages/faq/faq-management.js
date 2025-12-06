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

// --- Elements ---
const editFaqModalEl = document.getElementById('edit-faq-modal');
const editFaqForm = document.getElementById('edit-faq-form');
const editFaqId = document.getElementById('edit_faq_id');
const editModuleId = document.getElementById('edit_module_id');
const editCategory = document.getElementById('edit_category');
const editQuestion = document.getElementById('edit_question');
const editContent = document.getElementById('edit_content');
const editFaqCancelBtn = document.getElementById('editFaqCancelBtn');
const updateFaqBtn = document.getElementById('updateFaqBtn');
const confirmEditFaqModalEl = document.getElementById('confirm-edit-faq-modal');
const confirmEditFaqCheckbox = document.getElementById('confirm-edit-faq-checkbox');
const confirmEditFaqCancel = document.getElementById('confirm-edit-faq-cancel');
const confirmEditFaqProceedButton = document.getElementById('confirm-edit-faq-proceed-button');
const confirmDeleteFaqModal = document.getElementById('confirm-delete-faq-modal');
const confirmDeleteFaqCheckbox = document.getElementById('confirm-delete-faq-checkbox');
const confirmDeleteFaqCancel = document.getElementById('confirm-delete-faq-cancel');
const confirmDeleteFaqProceedButton = document.getElementById('confirm-delete-faq-proceed-button');

// Success Modal Elements
const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

const deleteFaqModal = new Modal(confirmDeleteFaqModal, modalOptions);
const confirmEditFaqModal = new Modal(confirmEditFaqModalEl, modalOptions);
const editFaqModal = new Modal(editFaqModalEl, modalOptions);
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

// Store original form values
let originalFormData = {};
let currentDeleteFaqId = null;

// Function to capture original form values
function storeOriginalFormData() {
    originalFormData = {
        module_id: editModuleId.value,
        category: editCategory.value,
        question: editQuestion.value,
        content: editContent.value
    };
}

// Function to check if form has changes and is valid
function checkFormState() {
    // Check if all required fields are filled
    const isValid = editFaqForm.checkValidity();
    
    // Check if any field has changed
    const hasChanges = 
        editModuleId.value !== originalFormData.module_id ||
        editCategory.value !== originalFormData.category ||
        editQuestion.value !== originalFormData.question ||
        editContent.value !== originalFormData.content;
    
    // Enable button only if form is valid AND has changes
    updateFaqBtn.disabled = !(isValid && hasChanges);
}

// Add event listeners to form fields for real-time validation
const editFormInputs = editFaqForm.querySelectorAll('input, textarea, select');
editFormInputs.forEach(input => {
    input.addEventListener('input', checkFormState);
    input.addEventListener('change', checkFormState);
});

function setupFaqEventListeners() {
    document.addEventListener('click', function (e) {
        const editBtn = e.target.closest('.js-edit-faq-btn');
        if (editBtn) {
            e.preventDefault();
            const faqId = editBtn.getAttribute('data-faq-id');
            handleEditFaq(faqId);
        }

        const deleteBtn = e.target.closest('.js-delete-faq-btn');
        if (deleteBtn) {
            e.preventDefault();
            const faqId = deleteBtn.getAttribute('data-faq-id');
            handleDeleteFaq(faqId);
        }
    });
}

function handleEditFaq(faqId) {
    console.log('Edit FAQ ID:', faqId);
    
    // Fetch FAQ details from Laravel backend
    fetch(`/faqs/${faqId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const faq = data.faq;
            
            // Populate form fields
            editFaqId.value = faq.id;
            editModuleId.value = faq.module_id;
            editCategory.value = faq.category;
            editQuestion.value = faq.question;
            editContent.value = faq.content;
            
            // Store original values for comparison
            storeOriginalFormData();
            
            // Disable update button initially (no changes yet)
            updateFaqBtn.disabled = true;
            
            // Show modal
            editFaqModal.show();
        } else {
            alert('Failed to fetch FAQ: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        alert('Error fetching FAQ: ' + error.message);
    });
}

function handleDeleteFaq(faqId) {
    console.log('Delete FAQ ID:', faqId);
    currentDeleteFaqId = faqId;
    
    // Reset confirmation modal state
    confirmDeleteFaqCheckbox.checked = false;
    confirmDeleteFaqProceedButton.disabled = true;
    
    // Show delete confirmation modal
    deleteFaqModal.show();
}

// Edit FAQ Cancel Button
editFaqCancelBtn.addEventListener('click', () => {
    editFaqModal.hide();
    editFaqForm.reset();
});

// Update FAQ Button
updateFaqBtn.addEventListener('click', (e) => {
    e.preventDefault();

    // Double-check form validity
    if (!editFaqForm.checkValidity()) {
        editFaqForm.reportValidity();
        return;
    }

    // Hide edit modal, show confirm modal
    editFaqModal.hide();
    confirmEditFaqModal.show();

    // Reset confirmation modal state
    confirmEditFaqCheckbox.checked = false;
    confirmEditFaqProceedButton.disabled = true;
});

// Confirm Edit FAQ Checkbox
confirmEditFaqCheckbox.addEventListener('change', () => {
    confirmEditFaqProceedButton.disabled = !confirmEditFaqCheckbox.checked;
});

// Confirm Edit FAQ Cancel
confirmEditFaqCancel.addEventListener('click', () => {
    confirmEditFaqModal.hide();
    editFaqModal.show();
});

// Confirm Edit FAQ Proceed
confirmEditFaqProceedButton.addEventListener('click', () => {
    console.log('Updating FAQ...');

    // Disable button and show loading state
    confirmEditFaqProceedButton.disabled = true;
    const originalEditButtonText = confirmEditFaqProceedButton.textContent;
    confirmEditFaqProceedButton.textContent = 'Saving...';

    const faqId = editFaqId.value;

    // Submit update via AJAX
    fetch(`/faqs/${faqId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            module_id: editModuleId.value,
            category: editCategory.value,
            question: editQuestion.value,
            content: editContent.value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hide confirmation modal
            confirmEditFaqModal.hide();
            
            // Reset form
            editFaqForm.reset();
            
            // Set success modal message
            successMesageHeader.textContent = 'Success!';
            successMessage.textContent = 'FAQ updated successfully.';
            
            // Show success modal
            successModal.show();
            
        } else {
            // Show error alert
            alert('Failed to update FAQ: ' + (data.message || 'Unknown error'));
            
            // Reset button state
            confirmEditFaqProceedButton.disabled = false;
            confirmEditFaqProceedButton.textContent = originalEditButtonText;
            
            confirmEditFaqModal.hide();
        }
    })
    .catch(error => {
        // Show error alert
        alert('Error updating FAQ: ' + error.message);
        
        // Reset button state
        confirmEditFaqProceedButton.disabled = false;
        confirmEditFaqProceedButton.textContent = originalEditButtonText;
        
        confirmEditFaqModal.hide();
    });
});

// Confirm Delete FAQ Checkbox
confirmDeleteFaqCheckbox.addEventListener('change', () => {
    confirmDeleteFaqProceedButton.disabled = !confirmDeleteFaqCheckbox.checked;
});

// Confirm Delete FAQ Cancel
confirmDeleteFaqCancel.addEventListener('click', () => {
    deleteFaqModal.hide();
    currentDeleteFaqId = null;
});

// Confirm Delete FAQ Proceed
confirmDeleteFaqProceedButton.addEventListener('click', () => {
    console.log('Deactivating FAQ ID:', currentDeleteFaqId);

    // Disable button and show loading state
    confirmDeleteFaqProceedButton.disabled = true;
    const originalDeleteButtonText = confirmDeleteFaqProceedButton.textContent;
    confirmDeleteFaqProceedButton.textContent = 'Deleting...';

    fetch(`/faqs/${currentDeleteFaqId}/deactivate`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Hide delete modal
            deleteFaqModal.hide();
            
            // Reset delete ID
            currentDeleteFaqId = null;
            
            // Set success modal message
            successMesageHeader.textContent = 'Success!';
            successMessage.textContent = 'FAQ deactivated successfully.';
            
            // Show success modal
            successModal.show();
            
        } else {
            // Show error alert
            alert('Failed to deactivate FAQ: ' + (data.message || 'Unknown error'));
            
            // Reset button state
            confirmDeleteFaqProceedButton.disabled = false;
            confirmDeleteFaqProceedButton.textContent = originalDeleteButtonText;
            
            deleteFaqModal.hide();
            currentDeleteFaqId = null;
        }
    })
    .catch(error => {
        // Show error alert
        alert('Error deactivating FAQ: ' + error.message);
        
        // Reset button state
        confirmDeleteFaqProceedButton.disabled = false;
        confirmDeleteFaqProceedButton.textContent = originalDeleteButtonText;
        
        deleteFaqModal.hide();
        currentDeleteFaqId = null;
    });
});

// Success modal close handler (shared for all success scenarios)
closeSuccessModalButton.addEventListener('click', () => {
    successModal.hide();
    
    // Reset both confirm buttons to their default states
    confirmEditFaqProceedButton.disabled = true;
    confirmEditFaqProceedButton.textContent = 'Proceed';
    confirmDeleteFaqProceedButton.disabled = true;
    confirmDeleteFaqProceedButton.textContent = 'Proceed';
    
    // Reload page to reflect changes
    location.reload();
});

// Initialize
setupFaqEventListeners();
