// Modal Container
const editResidentModalEl = document.getElementById('edit-resident-modal');

// The modal element itself
const confirmEditModalEl = document.getElementById('confirm-edit-resident-modal');
const confirmEditResidentName = document.getElementById('confirm-edit-resident-full-name');
const confirmEditCheckbox = document.getElementById('confirm-edit-resident-checkbox');
const cancelEditConfirmBtn = document.getElementById('cancel-edit-resident-confirm');
const proceedEditBtn = document.getElementById('confirm-edit-resident-proceed-button');

// --- Resident Info Fields ---
const residentFirstName = document.getElementById('residentFirstName');
const residentLastName = document.getElementById('residentLastName');
const residentMiddleName = document.getElementById('residentMiddleName');
const suffix = document.getElementById('suffix');
const residentContactNo = document.getElementById('residentContactNo');
const residentSex = document.getElementById('residentSex');
const residentBirthdate = document.getElementById('residentBirthdate');
const residentAge = document.getElementById('residentAge');

// --- Status & Address ---
const residentStatus = document.getElementById('residentStatus');
const completeAddress = document.getElementById('completeAddress');

// --- Demographic Fields ---
const civilStatus = document.getElementById('civilStatus');
const religion = document.getElementById('religion');
const ethnicity = document.getElementById('ethnicity');

// --- Other Status Fields ---
const educationAttainment = document.getElementById('educationAttainment');
const employmentStatus = document.getElementById('employmentStatus');
const pwdStatus = document.getElementById('pwdStatus');
const pwdIdInput = document.getElementById('pwdIdInput');
const indigenousStatus = document.getElementById('indigenousStatus');
const soloParentStatus = document.getElementById('soloParentStatus');
const philhealthStatus = document.getElementById('philhealthStatus');
const philHealthNo = document.getElementById('philHealthNo');
const emergencyContactNo = document.getElementById('emergencyContactNo');

// --- Modal Footer Buttons ---
const cancelEditResidentBtn = document.getElementById('cancel-button-edit-resident');
const updateResidentBtn = document.getElementById('update-resident-button');

const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const resident = window.resident;

const confirmEditModal = new Modal(confirmEditModalEl, modalOptions);
const editResidentModal = new Modal(editResidentModalEl, modalOptions);

const editTrigger = document.getElementById('edit-resident-trigger');

// --- [NEW] Store original form data ---
let originalData = {};

// --- [NEW] Lists of elements for validation ---
const requiredElements = [
    residentFirstName, residentLastName, residentMiddleName, residentContactNo,
    residentSex, residentBirthdate, residentStatus, civilStatus, religion,
    ethnicity, educationAttainment, employmentStatus, pwdStatus,
    indigenousStatus, soloParentStatus, philhealthStatus
];
const allFormElements = [
    residentFirstName, residentLastName, residentMiddleName, suffix,
    residentContactNo, residentSex, residentBirthdate, residentStatus,
    civilStatus, religion, ethnicity, educationAttainment,
    employmentStatus, pwdStatus, pwdIdInput, indigenousStatus,
    soloParentStatus, philhealthStatus, philHealthNo, emergencyContactNo
];

// --- Helper Functions ---
function calculateAge(birthdateString) {
    if (!birthdateString) return '';
    try {
        const birthdate = new Date(birthdateString);
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        const m = today.getMonth() - birthdate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }
        return age;
    } catch (e) {
        return '';
    }
}

function capitalizeFirstLetter(string) {
    if (!string) return '';
    return string.charAt(0).toUpperCase() + string.slice(1);
}

// --- [NEW] Gets all current values from the form ---
function getFormData() {
    return {
        residentFirstName: residentFirstName.value,
        residentLastName: residentLastName.value,
        residentMiddleName: residentMiddleName.value,
        suffix: suffix.value,
        residentContactNo: residentContactNo.value,
        residentSex: residentSex.value,
        residentBirthdate: residentBirthdate.value,
        residentStatus: residentStatus.value,
        civilStatus: civilStatus.value,
        religion: religion.value,
        ethnicity: ethnicity.value,
        educationAttainment: educationAttainment.value,
        employmentStatus: employmentStatus.value,
        pwdStatus: pwdStatus.value,
        pwdIdInput: pwdIdInput.value,
        indigenousStatus: indigenousStatus.value,
        soloParentStatus: soloParentStatus.value,
        philhealthStatus: philhealthStatus.value,
        philHealthNo: philHealthNo.value,
        emergencyContactNo: emergencyContactNo.value,
    };
}

// --- [NEW] Main validation function ---
function validateForm() {
    const currentData = getFormData();

    // 1. Check if any required fields are empty
    const hasEmptyRequiredFields = requiredElements.some(el => el.value.trim() === '');
    if (hasEmptyRequiredFields) {
        updateResidentBtn.disabled = true;
        return;
    }

    // 2. Check if any data has changed from the original
    let hasChanges = false;
    for (const key in currentData) {
        // Use != instead of !== to allow type coercion (e.g., null != "")
        if (currentData[key] != originalData[key]) {
            hasChanges = true;
            break;
        }
    }
    
    // Enable button only if all required fields are filled AND changes were made
    updateResidentBtn.disabled = !hasChanges;
}

// --- Event Listeners ---

// Update age field when birthdate changes
residentBirthdate.addEventListener('change', () => {
    residentAge.value = calculateAge(residentBirthdate.value);
});

// [NEW] Add listeners to all form fields to check for changes
allFormElements.forEach(element => {
    element.addEventListener('input', validateForm); // For text inputs
    element.addEventListener('change', validateForm); // For selects and date
});

// --- Modal Open/Close ---

editTrigger.addEventListener('click', function(){
    
    // Autofill Logic
    residentFirstName.value = resident.firstName ?? '';
    residentLastName.value = resident.lastName ?? '';
    residentMiddleName.value = resident.middleName ?? '';
    suffix.value = resident.suffix ?? '';
    residentContactNo.value = resident.contact_no ?? '';
    residentSex.value = capitalizeFirstLetter(resident.sex);
    residentBirthdate.value = resident.birthdate;
    residentAge.value = calculateAge(resident.birthdate);

    residentStatus.value = resident.status;

    civilStatus.value = capitalizeFirstLetter(resident.civil_status);
    religion.value = resident.religion;
    ethnicity.value = resident.ethnicity;
    
    educationAttainment.value = resident.educational_attainment;
    employmentStatus.value = capitalizeFirstLetter(resident.employment_status);
    
    pwdStatus.value = resident.is_pwd ? 'Yes' : 'No';
    indigenousStatus.value = resident.is_indigenous ? 'Yes' : 'No';
    soloParentStatus.value = resident.if_solo_parent ? 'Yes' : 'No';
    philhealthStatus.value = resident.if_philhealth ? 'Yes' : 'No';

    pwdIdInput.value = resident.pwd_id ?? '';
    philHealthNo.value = resident.philhealth_no ?? '';
    emergencyContactNo.value = resident.emergencyContactNo ?? '';

    // [MODIFIED] Store the initial data and disable the button
    originalData = getFormData();
    updateResidentBtn.disabled = true;

    editResidentModal.show();
});

cancelEditResidentBtn.addEventListener('click',function(){
    editResidentModal.hide();
});

updateResidentBtn.addEventListener('click', function(){
    editResidentModal.hide();
    confirmEditResidentName.textContent = `${residentFirstName.value} ${residentMiddleName.value} ${residentLastName.value}`;
    confirmEditModal.show();
});

confirmEditCheckbox.addEventListener('change', function(){
    proceedEditBtn.disabled = !this.checked;
})

cancelEditConfirmBtn.addEventListener('click', function(){
    confirmEditCheckbox.checked = false;
    confirmEditModal.hide();
    editResidentModal.show();
});


proceedEditBtn.addEventListener('click', async function(){
    proceedEditBtn.disabled = true;
    proceedEditBtn.textContent = 'Updating...';
    
    // Helper function to convert empty strings to null for optional fields
    const nullIfEmpty = (value) => {
        return value.trim() === '' ? null : value;
    };

    const payload = {
        id: resident.id,
        first_name: residentFirstName.value,
        last_name: residentLastName.value,
        middle_name: residentMiddleName.value,
        suffix: nullIfEmpty(suffix.value),
        contact_no: residentContactNo.value,
        sex: residentSex.value.toLowerCase(),
        birthdate: residentBirthdate.value,
        status: residentStatus.value,
        civil_status: civilStatus.value.toLowerCase(),
        religion: religion.value,
        ethnicity: ethnicity.value,
        educational_attainment: educationAttainment.value,
        employment_status: employmentStatus.value.toLowerCase(),
        is_pwd: pwdStatus.value === 'Yes' ? 1 : 0,
        pwd_id: nullIfEmpty(pwdIdInput.value),
        is_indigenous: indigenousStatus.value === 'Yes' ? 1 : 0,
        if_solo_parent: soloParentStatus.value === 'Yes' ? 1 : 0,
        if_philhealth: philhealthStatus.value === 'Yes' ? 1 : 0,
        philhealth_no: nullIfEmpty(philHealthNo.value),
        emergency_contact_no: nullIfEmpty(emergencyContactNo.value)
    };

    console.log('📤 Sending payload:', payload);

    try {
        const response = await fetch('/barangay/resident/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
        });

        const responseText = await response.text();
        console.log('📥 Raw response:', responseText);

        let data;
        try {
            data = JSON.parse(responseText);
        } catch (e) {
            console.error('❌ Response is not JSON:', responseText.substring(0, 500));
            throw new Error('Server returned an error. Check console.');
        }

        if (!response.ok) {
            throw new Error(data.message || data.error || 'Failed to update resident');
        }

        console.log('✅ Success:', data);

        // Show success message
        alert('Resident updated successfully!');
        
        // Optionally reload or redirect
        window.location.reload();

    } catch (error) {
        console.error('❌ Error:', error);
        alert('Error: ' + error.message);
        
        proceedEditBtn.disabled = false;
        proceedEditBtn.textContent = 'Proceed';
    }
});
