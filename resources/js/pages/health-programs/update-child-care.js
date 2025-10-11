// Main Modal Element
const updateChildCareModalEl = document.getElementById('update-child-care-modal');

const enrolledResident = window.enrolledResident;
const enrolledResidentId = window.enrolledResident.id;
const enrollmentDate = window.enrolledResident.created_at;
const resident = window.enrolledResident.resident;
const family = resident.family;


console.log(enrollmentDate);

// A. Basic Information Section
const childRegDate = document.getElementById('child-reg-date');
const childBirthDate = document.getElementById('child-birth-date');
const childFamilyNo = document.getElementById('child-family-no');
const childSes = document.getElementById('child-ses');
const childFullName = document.getElementById('child-full-name');
const childSex = document.getElementById('child-sex');
const motherFullName = document.getElementById('mother-full-name');
const childAddress = document.getElementById('child-address');

// B. Child Protection at Birth (Radio Buttons)
const tetanusStatusTT2 = document.getElementById('tt2-td2');
const tetanusStatusTT3_5 = document.getElementById('tt3-tt5');
const tetanusStatusTT1_5 = document.getElementById('tt1-tt5');

// C. Newborn (0-28 days old)
const birthWeight = document.getElementById('birth-weight');
const birthWeightStatus = document.getElementById('birth-weight-status');
const initiatedBreastfeeding = document.getElementById('initiated-breastfeeding');
const bcgDate = document.getElementById('bcg-date');
const hepaBDate = document.getElementById('hepa-b-bd-date');

// D. 1-3 Months Old
const ageInMonthsD = document.getElementById('age-in-months-d');
const lengthCm = document.getElementById('length-cm');
const lengthDate = document.getElementById('length-date');
const weightKgD = document.getElementById('weight-kg-d');
const weightDateD = document.getElementById('weight-date-d');
const statusD = document.getElementById('status-d');
const lbwIron1mo = document.getElementById('lbw-iron-1mo');
const lbwIron2mo = document.getElementById('lbw-iron-2mo');
const lbwIron3mo = document.getElementById('lbw-iron-3mo');
// Note: Immunization and breastfeeding inputs in this section would need IDs to be selected this way.

// E. 6-11 Months Old
const ageInMonthsE = document.getElementById('age-in-months-e');
const weightKgE = document.getElementById('weight-kg-e');
const weightDateE = document.getElementById('weight-date-e');
const statusE = document.getElementById('status-e');
const ebf6mo = document.getElementById('ebf-6mo');
const compFeeding = document.getElementById('comp-feeding');
const vitADate = document.getElementById('vit-a-date');
const mnpDate = document.getElementById('mnp-date');
const mmr1Date = document.getElementById('mmr1-date');

// F. 12 Months
const ageInMonthsF = document.getElementById('age-in-months-f');
const weightKgF = document.getElementById('weight-kg-f');
const weightDateF = document.getElementById('weight-date-f');
const statusF = document.getElementById('status-f');
const ficDate = document.getElementById('fic-date');

// G. Final Status & Remarks
const cicDate = document.getElementById('cic-date');
const childRemarks = document.getElementById('child-remarks');

// Modal Footer Buttons
const cancelBtn = document.getElementById('cancel-update-child-care');
const printBtn = document.getElementById('print-child-care-btn');
const updateBtn = document.getElementById('update-child-care-btn');


const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const updateChildCareModal = new Modal(updateChildCareModalEl, modalOptions);
const openUpdateChildCareBtn = document.getElementById('update-record');


openUpdateChildCareBtn.addEventListener('click',function(){
    updateChildCareModal.show();

    childRegDate.value = enrollmentDate;
    childBirthDate.value = resident.birthdate;
    childFamilyNo.value = family.id;
    childRegDate.value = new Date(enrollmentDate).toISOString().slice(0, 10)
    childSes.value = family.is_indigient === 1 ? 'nhts' : 'non-nhts';
    /*const childFullName
    const childSex
    const motherFullName
    const childAddress*/
});