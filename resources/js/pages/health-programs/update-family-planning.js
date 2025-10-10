const updateFamilyPlanningModaEl = document.getElementById('update-family-planning-modal');
const enrolledResident = window.enrolledResident;
const resident = window.enrolledResident.resident;
const fpRecord = window.enrolledResident.fam_plan_record;
const residentNameInput = document.getElementById('fp_update_resident_name');
const clientTypeSelect = document.getElementById('fp_update_client_type');
const sourceSelect = document.getElementById('fp_update_source');
const currentMethodSelect = document.getElementById('fp_update_current_method');
const dropoutCheckbox = document.getElementById('fp_dropout_checkbox');
const dropoutDetailsContainer = document.getElementById('dropout_details');
const dropoutDateInput = document.getElementById('fp_dropout_date');
const dropoutReasonSelect = document.getElementById('fp_dropout_reason');
const confirmUpdateFpModalEl = document.getElementById('confirm-update-family-planning-modal');
const residentNameToConfirm = document.getElementById('update-fp-resident-name-to-confirm');
const confirmUpdateFpCheckbox = document.getElementById('confirm-update-fp-checkbox');
const cancelConfirmUpdateFpBtn = document.getElementById('cancel-confirm-update-fp');
const confirmUpdateFpBtn = document.getElementById('confirm-update-fp-btn');
const updateCancel = document.getElementById('cancel-update-fp');
const proceedUpdate = document.getElementById('proceed-update-fp');

let payload = null;
const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};


const updateFamilyPlanningModal = new Modal(updateFamilyPlanningModaEl, modalOptions);
const updateFpConfirmationModal = new Modal(confirmUpdateFpModalEl, modalOptions);

const openUpdateFamilyBtn = document.getElementById('update-record');

openUpdateFamilyBtn.addEventListener('click', function () {

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
        dropoutDateInput.value = fpRecord.dropout_date;
        dropoutReasonSelect.value = fpRecord.dropout_reason || "";
    } else { 
        dropoutDateInput.value = "";
        dropoutReasonSelect.value = "";
    }

    // 4. Show the modal
    updateFamilyPlanningModal.show();
});

updateCancel.addEventListener('click', function () {
    payload = null;
    updateFamilyPlanningModal.hide();
});

proceedUpdate.addEventListener('click', function() {

    // Construct the payload with values from the form
    payload = {
        enrolled_resident_id: enrolledResident.id,
        client_type: clientTypeSelect.value,
        source: sourceSelect.value,
        previous_method: currentMethodSelect.value, // The field is for current method, but key matches your data structure
        dropout_date:dropoutDateInput.value ? dropoutDateInput.value : null,
        dropout_reason: dropoutReasonSelect.value ? dropoutReasonSelect.value : null,
    };

    // Log the payload to the console to verify
    console.log("Form Data Payload:", payload);

   
    const { firstName, middleName, lastName, suffix } = resident;
    const fullName = [firstName, middleName, lastName, suffix]
        .filter(name => name && name.trim() !== '')
        .join(' ');
    residentNameInput.value = fullName
    
    updateFamilyPlanningModal.hide();
    residentNameToConfirm.textContent = fullName;
    updateFpConfirmationModal.show();
});

cancelConfirmUpdateFpBtn.addEventListener('click',function(){
    updateFpConfirmationModal.hide();
    updateFamilyPlanningModal.show();
});

confirmUpdateFpCheckbox.addEventListener('change',function(){
    confirmUpdateFpBtn.disabled = !this.checked;
});

confirmUpdateFpBtn.addEventListener('click', function () {
    fetch(`/barangay/health-program/fam-plan/update/${payload.enrolled_resident_id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response from backend:', data);
        if(data.result === 'success'){
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});