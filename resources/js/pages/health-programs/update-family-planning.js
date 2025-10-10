const updateFamilyPlanningModaEl = document.getElementById('update-family-planning-modal');

const resident = window.enrolledResident.resident;
const fpRecord = window.enrolledResident.fam_plan_record;
// Input and Select Fields
const residentNameInput = document.getElementById('fp_update_resident_name');
const clientTypeSelect = document.getElementById('fp_update_client_type');
const sourceSelect = document.getElementById('fp_update_source');
const currentMethodSelect = document.getElementById('fp_update_current_method');

// Dropout Section Elements
const dropoutCheckbox = document.getElementById('fp_dropout_checkbox');
const dropoutDetailsContainer = document.getElementById('dropout_details');
const dropoutDateInput = document.getElementById('fp_dropout_date');
const dropoutReasonSelect = document.getElementById('fp_dropout_reason');

const updateCancel = document.getElementById('cancel-update-fp');
const proceedUpdate = document.getElementById('proceed-update-fp');
const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

console.log(fpRecord);

const updateFamilyPlanningModal = new Modal(updateFamilyPlanningModaEl, modalOptions);
const openUpdateFamilyBtn = document.getElementById('update-record');


openUpdateFamilyBtn.addEventListener('click', function () {
    // Check if enrolledResident data exists
    if (!window.enrolledResident) {
        console.error("Enrolled resident data is not available.");
        return;
    }

    // --- AUTO-FILL LOGIC ---

    // 1. Build and set resident's full name
    const { firstName, middleName, lastName, suffix } = resident;
    const fullName = [firstName, middleName, lastName, suffix]
        .filter(name => name && name.trim() !== '')
        .join(' ');
    residentNameInput.value = fullName;

    // 2. Set dropdown values
    clientTypeSelect.value = fpRecord.client_type || "";
    sourceSelect.value = fpRecord.source || "";
    // Assuming `previous_method` from data maps to the `current_method` field
    currentMethodSelect.value = fpRecord.previous_method || "";

    // 3. Handle Dropout Section
    if (fpRecord.dropout_date || fpRecord.dropout_reason) {
        dropoutCheckbox.checked = true;
        dropoutDateInput.value = fpRecord.dropout_date;
        dropoutReasonSelect.value = fpRecord.dropout_reason || "";
    } else {
        dropoutCheckbox.checked = false;
        dropoutDateInput.value = "";
        dropoutReasonSelect.value = "";
    }

    // 4. Show the modal
    updateFamilyPlanningModal.show();
});

updateCancel.addEventListener('click', function () {
    updateFamilyPlanningModal.hide();
});

proceedUpdate.addEventListener('click', function() {
    // Determine if the dropout checkbox is checked
    const isDropout = dropoutCheckbox.checked;

    // Construct the payload with values from the form
    const payload = {
        client_type: clientTypeSelect.value,
        source: sourceSelect.value,
        previous_method: currentMethodSelect.value, // The field is for current method, but key matches your data structure
        dropout_date: isDropout && dropoutDateInput.value ? dropoutDateInput.value : null,
        dropout_reason: isDropout && dropoutReasonSelect.value ? dropoutReasonSelect.value : null,
    };

    // Log the payload to the console to verify
    console.log("Form Data Payload:", payload);

    // You can add your API call or data handling logic here
    // For example:
    // updateUserRecord(payload); 
    
    updateFamilyPlanningModal.hide();
});