// --- Modal and Element References ---
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

const viewModalElement = document.getElementById('view-consultation-modal');


const viewModal = new Modal(viewModalElement, createModalOptions(viewModalElement));

// Header elements
const consultationTitleEl = document.getElementById('view-consultation-title');
const consultationScheduleEl = document.getElementById('view-consultation-schedule');

const closeView = document.getElementById('close-view-consultation');

// Top info elements
const statusEl = document.getElementById('view-consultation-status');
const completedEl = document.getElementById('view-consultation-completed');
const updatedByEl = document.getElementById('view-consultation-updated-by');

// Vitals section elements
const weightEl = document.getElementById('view-weight');
const heightEl = document.getElementById('view-height');
const tempEl = document.getElementById('view-temperature');
const bpEl = document.getElementById('view-bp');
const prEl = document.getElementById('view-pr');
const rrEl = document.getElementById('view-rr');
const birthweightEl = document.getElementById('view-birthweight');
const philhealthEl = document.getElementById('view-philhealth');
const fatherNameEl = document.getElementById('view-father-name');
const motherNameEl = document.getElementById('view-mother-name');

// Lower section elements in Vitals Tab
const complaintEl = document.getElementById('view-chief-complaint');
const treatmentEl = document.getElementById('view-treatment');

// Medicine list element
const medicineListEl = document.getElementById('view-medicine-list');

// --- Helper Functions ---
const formatDate = (dateString) => {
    if (!dateString) return '—';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
};

const getStatusInfo = (consultation) => {
    let statusText = 'Unknown';
    let statusColorClass = 'bg-gray-100 text-gray-800'; // Default color

    if (!consultation || !consultation.status) {
        return { statusText, statusColorClass };
    }

    const today = new Date();
    today.setHours(0, 0, 0, 0); // Set to start of day for accurate comparison

    const consultationDate = new Date(consultation.consultation_date);

    if (consultation.status === 'completed') {
        statusText = 'Completed';
        statusColorClass = 'bg-green-100 text-green-800';
    } else if (consultation.status === 'pending') {
        if (consultationDate < today) {
            statusText = 'Late';
            statusColorClass = 'bg-red-100 text-red-800';
        } else {
            statusText = 'Ongoing';
            statusColorClass = 'bg-blue-100 text-blue-800';
        }
    } else {
        // Fallback for any other statuses
        statusText = consultation.status;
    }

    return { statusText, statusColorClass };
};

const populateModal = (data) => {
    const { consultation_data, medicine_distributions, updated_by } = data;
    console.log(data);
    
    // Populate header
    consultationTitleEl.textContent = data.consultation_title || 'Consultation Details';
    consultationScheduleEl.textContent = `Scheduled for: ${formatDate(data.consultation_date)}`;

    // Populate top info
    const { statusText, statusColorClass } = getStatusInfo(data);
    statusEl.innerHTML = `<span class="px-2 py-1 font-semibold text-xs rounded-full ${statusColorClass}">${statusText}</span>`;

    completedEl.textContent = formatDate(data.updated_at);
    updatedByEl.textContent = updated_by ? updated_by.full_name : 'N/A';

    // Populate vitals if data exists
    if (consultation_data) {
        weightEl.textContent = consultation_data.weight ? `${consultation_data.weight} kg` : '—';
        heightEl.textContent = consultation_data.height ? `${consultation_data.height} cm` : '—';
        tempEl.textContent = consultation_data.temperature ? `${consultation_data.temperature} °C` : '—';
        bpEl.textContent = (consultation_data.bp_systolic && consultation_data.bp_diastolic) ? `${consultation_data.bp_systolic}/${consultation_data.bp_diastolic} mmHg` : '—';
        prEl.textContent = consultation_data.pr ? `${consultation_data.pr} bpm` : '—';
        rrEl.textContent = consultation_data.rr ? `${consultation_data.rr} cpm` : '—';
        birthweightEl.textContent = consultation_data.birthweight ? `${consultation_data.birthweight} g` : '—';
        philhealthEl.textContent = consultation_data.is_philhealth ? 'Yes' : 'No';
        fatherNameEl.textContent = consultation_data.father_name || '—';
        motherNameEl.textContent = consultation_data.mother_name || '—';
        complaintEl.textContent = consultation_data.chief_complaint || 'No complaint recorded.';
        treatmentEl.textContent = consultation_data.treatment || 'No treatment plan recorded.';
    }

    // Populate medicines
    medicineListEl.innerHTML = ''; // Clear previous list
    if (medicine_distributions && medicine_distributions.length > 0) {
        medicine_distributions.forEach(med => {
            // Safely access nested medicine information
            if (med.medicine) {
                const medicineInfo = med.medicine;
                const medCard = document.createElement('div');
                medCard.className = 'p-3 bg-white rounded-lg border border-gray-200';
                medCard.innerHTML = `
                        <p class="font-semibold text-main_font truncate" title="${medicineInfo.medicine_name}">
                            ${medicineInfo.medicine_name}
                        </p>
                        <div class="flex justify-between items-center text-gray-500 mt-1">
                            <span class="text-xs">${medicineInfo.form}</span>
                            <span class="font-bold text-main_font text-xs">x${med.quantity}</span>
                        </div>
                    `;
                medicineListEl.appendChild(medCard);
            }
        });
    } else {
        // If no medicines, show a placeholder message
        const placeholder = document.createElement('p');
        placeholder.className = 'text-sm text-gray-500 col-span-1 md:col-span-3';
        placeholder.textContent = 'No medicines were distributed for this consultation.';
        medicineListEl.appendChild(placeholder);
    }
};


// --- Event Listener ---
document.body.addEventListener('click', async (event) => {
    const viewButton = event.target.closest('.js-view-consultation-btn');
    if (viewButton) {
        const consultationId = viewButton.dataset.consultationId;
        if (!consultationId) return;

        try {
            viewModal.show();
            consultationTitleEl.textContent = 'Loading...';
            consultationScheduleEl.textContent = ''; 

            const response = await fetch(`/barangay/consultation/${consultationId}`);
            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();
            populateModal(data.consultation_data);

        } catch (error) {
            console.error('Failed to fetch consultation details:', error);
            alert('Could not load consultation details. Please try again.');
            viewModal.hide();
        }
    }
});

closeView.addEventListener('click', function(){
    viewModal.hide();
});