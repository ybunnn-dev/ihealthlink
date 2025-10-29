const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

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

const deleteFaqModal = new Modal(confirmDeleteFaqModal, modalOptions);
const confirmEditFaqModal = new Modal(confirmEditFaqModalEl, modalOptions);
const editFaqModal = new Modal(editFaqModalEl, modalOptions);

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
            console.error('Failed to fetch FAQ:', data.message);
            // TODO: Show error toast
        }
    })
    .catch(error => {
        console.error('Error fetching FAQ:', error);
        // TODO: Show error toast
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

    const formData = new FormData(editFaqForm);
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
            confirmEditFaqModal.hide();
            editFaqForm.reset();
            alert('FAQ updated successfully');
            // TODO: Show success toast and refresh FAQ list
            location.reload(); // Or update the DOM dynamically
        } else {
            alert('Failed to update FAQ:', data.message);
            // TODO: Show error toast
            location.reload(); // Or update the DOM dynamically
        }
    })
    .catch(error => {
        alert('Error updating FAQ:', error);
        location.reload(); // Or update the DOM dynamically
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

confirmDeleteFaqProceedButton.addEventListener('click', () => {
    console.log('Deactivating FAQ ID:', currentDeleteFaqId);

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
            deleteFaqModal.hide();
            alert('FAQ deactivated successfully');
            // TODO: Show success toast and refresh FAQ list
            location.reload(); // Or update the DOM dynamically
        } else {
            alert('Failed to deactivate FAQ:', data.message);
            location.reload(); // Or update the DOM dynamically
        }
    })
    .catch(error => {
        alert('Error deactivating FAQ:', error);
        location.reload(); // Or update the DOM dynamically
    });
});

// Initialize
setupFaqEventListeners();
