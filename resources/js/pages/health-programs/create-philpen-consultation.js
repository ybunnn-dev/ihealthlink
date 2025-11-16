const addPhilpenModalEl = document.getElementById('add-philpen-modal');
const consultationDateInput = document.getElementById('consultationDateInput');
const cancelAddPhilpenBtn = document.getElementById('cancel-add-philpen');
const proceedAddPhilpenBtn = document.getElementById('proceed-add-philpen');
const confirmCreatePhilpenModalEl = document.getElementById('confirm-create-philpen-modal');
const pendingConsultationCountSpan = document.getElementById('pending-consultation-count');
const confirmCreatePhilpenCheckbox = document.getElementById('confirm-create-philpen-checkbox');
const cancelConfirmCreatePhilpenBtn = document.getElementById('cancel-confirm-create-philpen');
const confirmCreatePhilpenBtn = document.getElementById('confirm-create-philpen-btn');
const successModalEl = document.getElementById('success-modal');
const successMessageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

// --- Modal & UI Element Variables ---
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

let currentCount = null;

const triggerPhilpen = document.getElementById('createNewPhilpen');
const addPhilpenModal = new Modal(addPhilpenModalEl, createModalOptions(addPhilpenModalEl));
const confirmCreatePhilpenModal = new Modal(confirmCreatePhilpenModalEl, createModalOptions(confirmCreatePhilpenModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

triggerPhilpen.addEventListener('click',function(){
    addPhilpenModal.show();
});

cancelAddPhilpenBtn.addEventListener('click', function(){
    consultationDateInput.value = '';
    addPhilpenModal.hide();
});

consultationDateInput.addEventListener('input', function () {
    proceedAddPhilpenBtn.disabled = this.value === '';
});


async function getPendingConsultations() {
    // If already fetched before, skip the API call
    if (currentCount !== null) {
        console.log('Using cached count:', currentCount);
        pendingConsultationCountSpan.textContent = currentCount;
        return;
    }

    try {
        const response = await fetch('/barangay/philpen/count', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (data.status === 'success') {
            currentCount = data.pending_consultations_count;
            pendingConsultationCountSpan.textContent = currentCount;
            console.log('Fetched pending consultations:', currentCount);
        } else {
            console.warn('Error:', data.message);
        }

    } catch (error) {
        console.error('Error fetching pending consultations:', error);
    }
}

proceedAddPhilpenBtn.addEventListener('click',function(){
    addPhilpenModal.hide();
    getPendingConsultations();
    confirmCreatePhilpenModal.show();
});

confirmCreatePhilpenCheckbox.addEventListener('change',function(){
    confirmCreatePhilpenBtn.disabled = !this.checked;
});

confirmCreatePhilpenBtn.addEventListener('click', async function() {
    const scheduledDate = consultationDateInput.value;
    
    if (!scheduledDate) {
        alert('Please select a consultation date first.');
        return;
    }

    // Store original button text
    const originalButtonText = confirmCreatePhilpenBtn.textContent;
    
    // Disable both buttons and change text
    confirmCreatePhilpenBtn.disabled = true;
    cancelConfirmCreatePhilpenBtn.disabled = true;
    confirmCreatePhilpenBtn.textContent = 'Creating...';

    try {
        const response = await fetch('/barangay/philpen/consultation/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({ consultation_date: scheduledDate })
        });

        const data = await response.json();
        console.log('Server response:', data);

        if (data.status === 'success') {
            // Hide confirmation modal
            confirmCreatePhilpenModal.hide();
            
            // Set success modal content
            successMessageHeader.textContent = 'Success!';
            successMessage.textContent = 'Consultation successfully scheduled.';
            
            // Show success modal
            successModal.show();
            
            // Optional: Reload on success modal close
            closeSuccessModalButton.addEventListener('click', function() {
                successModal.hide();
                window.location.reload();
            });
        } else {
            // Hide confirmation modal
            confirmCreatePhilpenModal.hide();
            
            // Set error modal content
            successMessageHeader.textContent = 'Error';
            successMessage.textContent = data.message || 'Something went wrong.';
            
            // Show success modal (reusing for error)
            successModal.show();
            
            // Reload on modal close
            closeSuccessModalButton.addEventListener('click', function() {
                successModal.hide();
                window.location.reload();
            });
        }

    } catch (error) {
        console.error('Error creating schedule:', error);
        
        // Hide confirmation modal
        confirmCreatePhilpenModal.hide();
        
        // Set error modal content
        successMessageHeader.textContent = 'Error';
        successMessage.textContent = 'An error occurred while creating the schedule.';
        
        // Show success modal (reusing for error)
        successModal.show();
        
        // Reload on modal close
        closeSuccessModalButton.addEventListener('click', function() {
            successModal.hide();
            window.location.reload();
        });
    } finally {
        // Reset buttons (in case modal stays open)
        confirmCreatePhilpenBtn.disabled = false;
        cancelConfirmCreatePhilpenBtn.disabled = false;
        confirmCreatePhilpenBtn.textContent = originalButtonText;
        confirmCreatePhilpenCheckbox.checked = false;
    }
});

// Close success modal handler (if you want to close without reload)
cancelConfirmCreatePhilpenBtn.addEventListener('click', function() {
    consultationDateInput.value = '';
    confirmCreatePhilpenCheckbox.checked = false;
    confirmCreatePhilpenBtn.disabled = true;
    confirmCreatePhilpenModal.hide();
    addPhilpenModal.show();
});
