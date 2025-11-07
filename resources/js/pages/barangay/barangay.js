
// --- 1. Get HTML elements ---
const addBarangayModalEl = document.getElementById('add-barangay-modal');
const confirmModalEl = document.getElementById('confirm-add-barangay-modal');
const mainTriggerBtn = document.getElementById('page-add-barangay-button');
const closeAdd = document.getElementById('cancel-add-brgy');

//success modal elements
const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

let finalUrl;
let barangaySlug;

const addBarangayModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            addBarangayModalEl.classList.remove('opacity-0');
            addBarangayModalEl.classList.add('opacity-100');
            
            const modalContent = addBarangayModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        addBarangayModalEl.classList.add('opacity-0');
        addBarangayModalEl.classList.remove('opacity-100');
        
        const modalContent = addBarangayModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

const confirmModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            confirmModalEl.classList.remove('opacity-0');
            confirmModalEl.classList.add('opacity-100');
            
            const modalContent = confirmModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        confirmModalEl.classList.add('opacity-0');
        confirmModalEl.classList.remove('opacity-100');
        
        const modalContent = confirmModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

const successModalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            successModalEl.classList.remove('opacity-0');
            successModalEl.classList.add('opacity-100');
            
            const modalContent = successModalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        successModalEl.classList.add('opacity-0');
        successModalEl.classList.remove('opacity-100');
        
        const modalContent = successModalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
};

// --- 3. Create Flowbite Modal Instances with their own options ---
const addBarangayModal = new Modal(addBarangayModalEl, addBarangayModalOptions);
const confirmModal = new Modal(confirmModalEl, confirmModalOptions);
const successModal = new Modal(successModalEl, successModalOptions);


// --- 3. Add Event Listener to Open the First Modal ---
mainTriggerBtn.addEventListener('click', function () {
    addBarangayModal.show();

});

closeAdd.addEventListener('click', function(){
    addBarangayModal.hide();
});

// --- 4. Get other elements ---
const barangayNameInput = document.getElementById('barangay-name-input');
const openConfirmBtn = document.getElementById('open-confirmation-modal-button');
const confirmCheckbox = document.getElementById('confirm-barangay-checkbox');
const confirmProceedBtn = document.getElementById('confirm-proceed-button');
// **Get the cancel button from the confirmation modal**
const cancelConfirmBtn = confirmModalEl.querySelector('[data-modal-hide="confirm-add-barangay-modal"]');


// --- 5. Open the confirmation modal ---
openConfirmBtn.addEventListener('click', function () {
    const barangayName = barangayNameInput.value.trim();
    if (barangayName === '') {
        alert('Please enter a barangay name.');
        return;
    }
    const namePlaceholder = document.getElementById('barangay-name-to-confirm');
    namePlaceholder.textContent = barangayName;

    addBarangayModal.hide();
    confirmModal.show();
});


// --- 6. Handle checkbox logic ---
confirmCheckbox.addEventListener('change', function () {
    confirmProceedBtn.disabled = !this.checked;
});


// --- 7. Handle the final confirmation ---
confirmProceedBtn.addEventListener('click', async function () {
    const barangayNameToInsert = barangayNameInput.value.trim();
    this.disabled = true;
    this.textContent = 'Saving...';

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const response = await fetch('/add-brgy', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                name: barangayNameToInsert
            })
        });

        // ** Call .json() ONCE and store the result in a variable **
        const result = await response.json();

        // ** Now, use the 'result' variable everywhere below **

        if (!response.ok) {
            // Use 'result' to get error messages
            if (response.status === 422) {
                const errors = Object.values(result.errors).map(e => e.join('\n')).join('\n');
                alert('Validation Error:\n' + errors);
            } else {
                throw new Error(result.message || 'An unknown error occurred.');
            }
        } else {
            // --- ON SUCCESS ---
            // Use the SAME 'result' to get success data
            const newBarangayId = result.barangay.id;

            confirmModal.hide();
            successMesageHeader.textContent = "Success";
            successMessage.textContent = result.message;
            successModal.show();
            // Create a URL-friendly slug from the name
            barangaySlug = barangayNameToInsert.toLowerCase().replace(/\s+/g, '-');

            // Construct the final URL with both ID and name slug
            finalUrl = `/mho/barangays/${newBarangayId}/${barangaySlug}`;
            // Redirect to the new URL
            
        }

    } catch (error) {
        console.error('Submission Error:', error);
        alert('An error occurred while saving the barangay. Please check the console.');
        // Reset button state even on error
        this.disabled = false;
        this.textContent = 'Confirm & Proceed';
    }
    // The 'finally' block is removed because we now handle the button reset
    // in the success (redirect) and error (catch) blocks individually.
});

closeSuccessModalButton.addEventListener('click', function(){
    window.location.href = finalUrl;
})
// --- 8. (NEW) Handle cancellation of the confirmation ---
if (cancelConfirmBtn) {
    cancelConfirmBtn.addEventListener('click', function () {
        // When cancel is clicked, explicitly hide the confirmation
        // modal and show the "Add Barangay" modal again.
        confirmModal.hide();
        addBarangayModal.show();
    });
}

