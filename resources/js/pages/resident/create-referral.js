// Main Modal Element
const createReferralModalEl = document.getElementById('create-referral-modal');

const referredTo = document.getElementById('referred-to').textContent;
const resident = window.resident;

console.log(resident);
// Referral Information Section
const referredDate = document.getElementById('referred-date');
const referredTime = document.getElementById('referred-time');
const referredFrom = document.getElementById('referred-from');
const referralNeeds = document.getElementById('referral-needs');

// Patient Information Section
const patientName = document.getElementById('patient-name');
const patientBirthdate = document.getElementById('patient-birthdate');
const patientAge = document.getElementById('patient-age');
const patientAddress = document.getElementById('patient-address');
const patientSex = document.getElementById('patient-sex');
const civilStatus = document.getElementById('civil-status');
const fatherName = document.getElementById('father-name');
const motherName = document.getElementById('mother-name');

// Vital Signs & Measurements Section
const height = document.getElementById('height');
const weight = document.getElementById('weight');
const temperature = document.getElementById('temperature');
const bpSystolic = document.getElementById('bp-systolic');
const bpDiastolic = document.getElementById('bp-diastolic');
const pulseRate = document.getElementById('pulse-rate');
const respRate = document.getElementById('resp-rate');

// For Female Patients Section
const isPregnant = document.getElementById('is-pregnant');
const fpMethod = document.getElementById('fp-method');
const lmpDate = document.getElementById('lmp-date');
const eddDate = document.getElementById('edd-date');
const gravida = document.getElementById('gravida');
const para = document.getElementById('para');
const aog = document.getElementById('aog');

// For Infants Section
const infantBirthWeight = document.getElementById('infant-birth-weight');

// Medical Details Section
const chiefComplaint = document.getElementById('chief-complaint');
const medicineTaken = document.getElementById('medicine-taken');
const managementDone = document.getElementById('management-done');

// Modal Footer Buttons
const cancelReferralBtn = document.getElementById('cancel-referral-btn');
const printReferralBtn = document.getElementById('print-referral-btn');

const openCreateReferral = document.getElementById('create-referral-open');

const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};


const createReferralModal = new Modal(createReferralModalEl, modalOptions);

openCreateReferral.addEventListener('click',function(){
    const { firstName, middleName, lastName, suffix } = resident;

    const fullName = [
        firstName,
        middleName ? middleName : null,
        lastName,
        suffix ? suffix : null
    ].filter(Boolean).join(' ');

    patientName.value = fullName;
    patientBirthdate.value = resident.birthdate;

    const birthDate = new Date(resident.birthdate);
    const today = new Date();

    // Compute age in years
    let ageYears = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        ageYears--;
    }

    // If age is less than 1 year, compute months instead
    if (ageYears < 1) {
        let months = (today.getFullYear() - birthDate.getFullYear()) * 12 + (today.getMonth() - birthDate.getMonth());
        if (today.getDate() < birthDate.getDate()) months--;
        patientAge.value = `${months} month${months !== 1 ? 's' : ''} old`;
    } else {
        patientAge.value = `${ageYears} year${ageYears !== 1 ? 's' : ''} old`;
    }

    createReferralModal.show();
});

cancelReferralBtn.addEventListener('click',function(){
    createReferralModal.hide();
});