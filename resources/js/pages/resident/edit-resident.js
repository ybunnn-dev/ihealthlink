// Modal Container
const editResidentModalEl = document.getElementById('edit-resident-modal');

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

const editResident = new Modal(editResidentModalEl, modalOptions);

