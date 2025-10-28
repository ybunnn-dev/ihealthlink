/*
 * PhilPEN Modal Controller
 * Handles view and confirmation modals with proper state management
 */

// ========================
// MODAL ELEMENTS & SETUP
// ========================

const $viewModalElement = document.getElementById('view-philpen-modal');
const $confirmModalElement = document.getElementById('confirm-philpen-action-modal');
const confirmCheckbox = document.getElementById('confirm-philpen-action-checkbox');
const confirmSubmitButton = document.getElementById('confirm-philpen-action-submit');
const confirmMessage = document.getElementById('confirm-philpen-action-message');

// Validate required elements
if (!$viewModalElement) {
    console.error('View PhilPEN Modal element (#view-philpen-modal) not found!');
}
if (!$confirmModalElement) {
    console.error('Confirm PhilPEN Action Modal element (#confirm-philpen-action-modal) not found!');
}

// Create Flowbite Modal Instances
const viewPhilpenModal = $viewModalElement ? new Modal($viewModalElement, {
    placement: 'center-center',
    backdrop: 'static',
    closable: true
}) : null;

const confirmPhilpenActionModal = $confirmModalElement ? new Modal($confirmModalElement, {
    placement: 'center-center',
    backdrop: 'static',
    closable: true
}) : null;

// ========================
// STATE MANAGEMENT
// ========================

let currentConsultationId = null;

// ========================
// HELPER FUNCTIONS
// ========================

/**
 * Sets text content for an element by ID.
 * Shows fallback if value is null or undefined, but shows 0 if value is 0.
 */
function setText(id, value, fallback = '---') {
    const el = document.getElementById(id);
    if (el) {
        el.textContent = (value === null || value === undefined) ? fallback : value;
    }
}

/**
 * Formats 1/0 or true/false to "Yes" or "No".
 */
function formatBool(value) {
    return (value === 1 || value === true) ? 'Yes' : 'No';
}

/**
 * Formats a date string. Shows fallback if date is null.
 */
function formatDate(dateString, fallback = '---') {
    if (!dateString) return fallback;
    try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return fallback;
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    } catch (error) {
        console.error("Error formatting date:", dateString, error);
        return dateString;
    }
}

/**
 * Populates a <ul> with a list of all items and their Yes/No status.
 */
function populateList(listId, dataObject, labels) {
    const ul = document.getElementById(listId);
    if (!ul) return;

    ul.innerHTML = '';

    if (!dataObject || typeof dataObject !== 'object') {
        const li = document.createElement('li');
        li.textContent = 'No data recorded for this section.';
        li.className = 'text-gray-500 italic';
        ul.appendChild(li);
        return;
    }

    let itemsAdded = 0;
    for (const key in labels) {
        const li = document.createElement('li');
        const value = dataObject.hasOwnProperty(key) ? dataObject[key] : null;
        const formattedValue = formatBool(value);

        li.innerHTML = `<span class="text-gray-500">${labels[key]}:</span> <span class="font-semibold text-gray-900">${formattedValue}</span>`;
        ul.appendChild(li);
        itemsAdded++;
    }

    if (itemsAdded === 0) {
        const li = document.createElement('li');
        li.textContent = 'No applicable items found for this section.';
        li.className = 'text-gray-500 italic';
        ul.appendChild(li);
    }
}

/**
 * Safely hide a modal if it exists and is currently shown
 */
function safeHideModal(modal) {
    if (modal && modal.isVisible && typeof modal.isVisible === 'function' && modal.isVisible()) {
        modal.hide();
    } else if (modal && typeof modal.hide === 'function') {
        modal.hide();
    }
}

/**
 * Show a modal and ensure other modals are hidden
 */
function showModalExclusive(modalToShow, modalToHide) {
    if (modalToHide) {
        safeHideModal(modalToHide);
    }
    if (modalToShow) {
        // Small delay to ensure previous modal is hidden
        setTimeout(() => {
            modalToShow.show();
        }, 100);
    }
}

// ========================
// DATA POPULATION
// ========================

function populatePhilpenModal(data) {
    const resident = data?.enrolled_resident?.resident;
    const purok = resident?.family?.household?.purok;
    const barangay = purok?.barangay;

    const ncd = data?.ncd_risk_factor || {};
    const risk = data?.risk_assessment || {};
    const mgmt = data?.philpen_management || {};
    const healthSigns = data?.health_signs || {};
    const medicalHistory = data?.medical_history || {};
    const familyHistory = data?.family_history || {};

    // Section 1: Resident Details
    const middleName = resident?.middleName ? ` ${resident.middleName}` : '';
    const lastName = resident?.lastName || 'N/A';
    const firstName = resident?.firstName || '';
    setText('view-philpen-name', `${lastName}${lastName !== 'N/A' ? ', ' : ''}${firstName}${middleName}`);
    setText('view-philpen-birthdate', formatDate(resident?.birthdate));
    setText('view-philpen-sex', resident?.sex);
    setText('view-philpen-address', (purok?.name && barangay?.name) ? `${purok.name}, ${barangay.name}` : '---');
    setText('view-philpen-consultation-title', data?.consultation_title);
    setText('view-philpen-consultation-date', formatDate(data?.consultation_date));
    setText('view-philpen-status', data?.status);

    // Section 2: Red Flags (Health Signs)
    const healthSignLabels = {
        chest_pain: 'Chest Pain',
        difficulty_in_breathing: 'Difficulty in Breathing',
        loss_of_consciousness: 'Loss of Consciousness',
        slurred_speech: 'Slurred Speech',
        facial_asymmetry: 'Facial Asymmetry',
        numbness_of_arm: 'Weakness/Numbness on arm/left side',
        disoriented_as_to_time_place_or_person: 'Disoriented',
        chest_retractions: 'Chest Retractions',
        seizure_or_convulsion: 'Seizure or Convulsion',
        act_of_self_harm_or_suicide: 'Act of Self Harm/Suicide',
        agitated_or_aggressive_behavior: 'Agitated/Aggressive Behavior',
        eye_injury: 'Eye Injury',
        severe_injuries: 'Severe Injuries'
    };
    populateList('view-philpen-health-signs', healthSigns, healthSignLabels);

    // Section 3: Medical History
    const medicalHistoryLabels = {
        hypertension: 'Hypertension',
        heart_diseases: 'Heart Diseases',
        diabetes: 'Diabetes',
        cancer: 'Cancer',
        copd: 'COPD',
        asthma: 'Asthma',
        allergies: 'Allergies',
        mental_neuro_substance_disorders: 'Mental/Neuro/Substance Disorders',
        vision_problems: 'Vision Problems',
        surgical_history: 'Previous Surgical History',
        thyroid_disorders: 'Thyroid Disorders',
        kidney_disorders: 'Kidney Disorders'
    };
    populateList('view-philpen-medical-history', medicalHistory, medicalHistoryLabels);

    // Section 4: Family History
    const familyHistoryLabels = {
        hypertension: 'Hypertension',
        heart_diseases: 'Heart Disease',
        stroke: 'Stroke',
        diabetes_mellitus: 'Diabetes Mellitus',
        asthma: 'Asthma',
        cancer: 'Cancer',
        kidney_disorders: 'Kidney Disorders',
        copd: 'COPD',
        tuberculosis_last_five_years: 'Family members having TB (last 5 years)',
        premature_coronary_or_vascular_disease: '1st degree relative with premature coronary/vascular disease',
        mental_neurological_substance_abuse_disorders: 'Mental/Neurological/Substance Abuse Disorders'
    };
    populateList('view-philpen-family-history', familyHistory, familyHistoryLabels);

    // Section 5: NCD Risk Factors
    setText('view-ncd-tobacco', ncd.tobacco_use);
    setText('view-ncd-alcohol', formatBool(ncd.alcohol_intake));
    setText('view-ncd-drinks', ncd.number_of_drinks_last_year);
    setText('view-ncd-weight', ncd.weight ? `${ncd.weight} kg` : '---');
    setText('view-ncd-height', ncd.height ? `${ncd.height} cm` : '---');
    setText('view-ncd-waist', ncd.waist_circumference ? `${ncd.waist_circumference} cm` : '---');
    setText('view-ncd-bp', (ncd.systolic_pressure && ncd.diastolic_pressure) ? `${ncd.systolic_pressure} / ${ncd.diastolic_pressure} mmHg` : '---');

    // Section 6: Risk Assessment
    setText('view-risk-polyphagia', formatBool(risk.polyphagia));
    setText('view-risk-polydipsia', formatBool(risk.polydipsia));
    setText('view-risk-polyuria', formatBool(risk.polyuria));
    setText('view-risk-breathlessness', formatBool(risk.breathlessness));
    setText('view-risk-cough', formatBool(risk.chronic_cough));
    setText('view-risk-sputum', formatBool(risk.sputum_production));
    setText('view-risk-wheezing', formatBool(risk.wheezing));
    setText('view-risk-fbs', risk.fbs_result);
    setText('view-risk-rbs', risk.rbs_result);
    setText('view-risk-cholesterol', risk.total_cholesterol);
    setText('view-risk-hdl', risk.hdl);
    setText('view-risk-ldl', risk.ldl);

    // Section 7: Management
    setText('view-mgmt-lifestyle', formatBool(mgmt.is_lifestyle_modification));
    setText('view-mgmt-anti-hypertensive', formatBool(mgmt.is_anti_hypertensive));
    setText('view-mgmt-insulin', formatBool(mgmt.is_insulin));
    setText('view-mgmt-follow-up', formatDate(mgmt.follow_up_date));
    setText('view-mgmt-remarks', mgmt.remarks);
}

// ========================
// CHECKBOX VALIDATION
// ========================

if (confirmCheckbox && confirmSubmitButton) {
    confirmCheckbox.addEventListener('change', function() {
        confirmSubmitButton.disabled = !this.checked;
    });
}

// ========================
// EVENT HANDLERS
// ========================

document.addEventListener('click', async function (event) {

    // --- Handle View Button Click ---
    const clickedViewButton = event.target.closest('.js-view-consultation-btn');
    if (clickedViewButton && viewPhilpenModal) {
        console.log('View Button clicked! Fetching data...');
        const consultationId = clickedViewButton.dataset.consultationId;
        currentConsultationId = null;

        try {
            const url = `/philpen/get/${consultationId}`;
            const response = await fetch(url);
            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

            const consultationData = await response.json();
            if (!consultationData || !consultationData.id) {
                throw new Error(`Invalid data received for consultation ID ${consultationId}`);
            }
            console.log('Successfully fetched data:', consultationData);

            populatePhilpenModal(consultationData);
            currentConsultationId = consultationData.id;

            // Show view modal (confirmation modal should already be hidden)
            viewPhilpenModal.show();

        } catch (error) {
            console.error('Could not fetch or process consultation data:', error);
            alert('Error loading consultation data. Please try again.');
            currentConsultationId = null;
        }
    }

    // --- Handle Print Button Click (Inside View Modal) ---
    const clickedPrintButton = event.target.closest('#print-philpen-btn');
    if (clickedPrintButton && confirmPhilpenActionModal) {
        console.log('Print Button clicked! Requesting confirmation...');
        
        if (currentConsultationId) {
            if (confirmMessage) {
                confirmMessage.textContent = 'Are you sure you want to generate the printable PhilPEN form?';
            }
            if (confirmCheckbox) confirmCheckbox.checked = false;
            if (confirmSubmitButton) confirmSubmitButton.disabled = true;

            // Hide view modal and show confirmation modal
            showModalExclusive(confirmPhilpenActionModal, viewPhilpenModal);

        } else {
            console.error('Cannot request print confirmation, consultation ID not available.');
            alert('Error: Consultation details not loaded. Cannot print.');
        }
    }

    // --- Handle Confirm Submit Button Click ---
    const clickedConfirmSubmit = event.target.closest('#confirm-philpen-action-submit');
    if (clickedConfirmSubmit && !confirmSubmitButton.disabled && confirmPhilpenActionModal) {
        console.log('Confirmation confirmed! Proceeding with print...');
        
        if (currentConsultationId) {
            const printUrl = `/philpen/print/${currentConsultationId}`;
            const printWindow = window.open(printUrl, '_blank');
            
            if (!printWindow || printWindow.closed || typeof printWindow.closed === 'undefined') {
                alert('Could not open print window. Please check your pop-up blocker settings.');
            }
        } else {
            console.error('Cannot print, consultation ID was lost.');
            alert('Error: Consultation ID missing. Cannot print.');
        }
        
        // Hide confirmation modal
        safeHideModal(confirmPhilpenActionModal);
    }

    // --- Handle Cancel Button in Confirmation Modal ---
    const clickedConfirmCancel = event.target.closest('#close-confirm');
    if (clickedConfirmCancel && confirmPhilpenActionModal) {
        console.log('Confirmation cancelled. Returning to view modal...');
        
        // Hide confirmation modal and show view modal again
        showModalExclusive(viewPhilpenModal, confirmPhilpenActionModal);
    }

    // --- Handle Close Button in View Modal ---
    const clickedViewClose = event.target.closest('#close-philpen');
    if (clickedViewClose && viewPhilpenModal) {
        console.log('View modal closed.');
        currentConsultationId = null;
        safeHideModal(viewPhilpenModal);
    }
});

// ========================
// KEYBOARD EVENT HANDLER
// ========================

document.addEventListener('keydown', function(event) {
    // Handle ESC key
    if (event.key === 'Escape') {
        // Priority: close confirmation modal first if open, then view modal
        if (confirmPhilpenActionModal && confirmPhilpenActionModal.isVisible && confirmPhilpenActionModal.isVisible()) {
            showModalExclusive(viewPhilpenModal, confirmPhilpenActionModal);
        } else if (viewPhilpenModal && viewPhilpenModal.isVisible && viewPhilpenModal.isVisible()) {
            currentConsultationId = null;
            safeHideModal(viewPhilpenModal);
        }
    }
});
