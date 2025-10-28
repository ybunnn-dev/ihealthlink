// --- Modal and Form Element Variables ---

// We'll select these inside the setup function to ensure they exist
let createFaqModal, createFaqModalEl, createFaqForm, saveFaqBtn;
let confirmAddFaqModal, confirmAddFaqModalEl, confirmFaqCheckbox, confirmFaqCancelBtn, confirmFaqProceedBtn;
const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};
// --- Main Setup Function ---

// --- Create FAQ Modal ---
createFaqModalEl = document.getElementById('create-faq-modal');
createFaqForm = document.getElementById('create-faq-form');
saveFaqBtn = document.getElementById('saveFaqBtn');

// --- Confirm Add FAQ Modal ---
confirmAddFaqModalEl = document.getElementById('confirm-add-faq-modal');
confirmFaqCheckbox = document.getElementById('confirm-faq-checkbox');
confirmFaqCancelBtn = document.getElementById('confirm-add-faq-cancel');
confirmFaqProceedBtn = document.getElementById('confirm-faq-proceed-button');


createFaqModal = new Modal(createFaqModalEl, modalOptions);
confirmAddFaqModal = new Modal(confirmAddFaqModalEl, modalOptions);



const createFaqTrigger = document.getElementById('add-faq-btn')
// Listen for the "Save" click on the create modal

saveFaqBtn.addEventListener('click', (e) => {
    e.preventDefault(); // Stop the form from submitting

    // Optional: Add form validation
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


function setupFaqEventListeners() {

    // === Select Modal & Form Elements ===



    // === Event Delegation (from your code) ===
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

        const addBtn = e.target.closest('#add-faq-btn');
        if (addBtn) {
            e.preventDefault();
            handleAddFaq();
        }
    });


    // Checkbox to enable proceed button
    if (confirmFaqCheckbox) {
        confirmFaqCheckbox.addEventListener('change', () => {
            confirmFaqProceedBtn.disabled = !confirmFaqCheckbox.checked;
        });
    }

    // Cancel button in confirm modal
    if (confirmFaqCancelBtn) {
        confirmFaqCancelBtn.addEventListener('click', () => {
            confirmAddFaqModal.hide();
            // Optional: Show the create modal again if they just want to edit
            // createFaqModal.show(); 
        });
    }

    // Proceed button (final submission)
    if (confirmFaqProceedBtn) {
        confirmFaqProceedBtn.addEventListener('click', () => {
            console.log('Submitting Create FAQ form...');

            // This is where you ACTUALLY submit the form.
            // You can use AJAX/fetch() or a standard form submit.
            // Example: createFaqForm.submit();

            // For AJAX (fetch), you'd do something like:
            // submitFaqForm(new FormData(createFaqForm));

            // After submission logic:
            confirmAddFaqModal.hide();
            createFaqForm.reset();

            console.log('Form submitted (simulation).');
            // TODO: Show a success toast/alert
        });
    }
}

// --- Handler Functions (Updated) ---

function handleAddFaq() {
    console.log('Add new FAQ clicked');
    // Reset form before showing
    if (createFaqForm) createFaqForm.reset();

    // Show the modal
    if (createFaqModal) createFaqModal.show();
}

function handleEditFaq(faqId) {
    console.log('Edit FAQ ID:', faqId);
    // TODO: Open edit modal with FAQ data
}

function handleDeleteFaq(faqId) {
    console.log('Delete FAQ ID:', faqId);
    // TODO: Show delete confirmation dialog and delete FAQ
}

// --- Initialize ---
// Run the setup function when the DOM is ready
setupFaqEventListeners();

// Export functions if you need to use them elsewhere (if this is a module)
// export { handleEditFaq, handleDeleteFaq, handleAddFaq };