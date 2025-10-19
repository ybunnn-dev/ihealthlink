const addPhilpenModalEl = document.getElementById('add-philpen-modal');
const consultationDateInput = document.getElementById('consultationDateInput');
const cancelAddPhilpenBtn = document.getElementById('cancel-add-philpen');
const proceedAddPhilpenBtn = document.getElementById('proceed-add-philpen');
const confirmCreatePhilpenModalEl = document.getElementById('confirm-create-philpen-modal');
const pendingConsultationCountSpan = document.getElementById('pending-consultation-count');
const confirmCreatePhilpenCheckbox = document.getElementById('confirm-create-philpen-checkbox');
const cancelConfirmCreatePhilpenBtn = document.getElementById('cancel-confirm-create-philpen');
const confirmCreatePhilpenBtn = document.getElementById('confirm-create-philpen-btn');

const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

let currentCount = null;

const triggerPhilpen = document.getElementById('createNewPhilpen');
const addPhilpenModal = new Modal(addPhilpenModalEl, modalOptions);
const confirmCreatePhilpenModal = new Modal(confirmCreatePhilpenModalEl, modalOptions);

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
    confirmCreatePhilpenBtn.disabled = true;
    cancelConfirmCreatePhilpenBtn.disabled = true;

    if (!scheduledDate) {
        alert('Please select a consultation date first.');
        return;
    }

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
            alert('Consultation successfully scheduled.');
            window.location.reload();
        } else {
            alert('Error: ' + (data.message || 'Something went wrong.'));
            window.location.reload();
        }

    } catch (error) {
        console.error('Error creating schedule:', error);
    }
});