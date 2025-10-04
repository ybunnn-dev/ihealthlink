// Main Modal Element
const updateMaternityModalEl = document.getElementById('update-maternity-modal');

const currentResident = window.enrolledResident.resident;
const basicMaternalRecord = window.enrolledResident.maternityRecord;

const enrolledResident = window.enrolledResident;

console.log(enrolledResident);
// --- Form Element Variables ---

// Basic Information Section
const dateOfRegistrationInput = document.getElementById('date-of-reg');
const familyNumberInput = document.getElementById('family-no');
const residentNameInput = document.getElementById('resident-name');
const addressInput = document.getElementById('address');
const socialEconomicStatusSelect = document.getElementById('ses');
const ageInput = document.getElementById('age');
const lmpInput = document.getElementById('lmp');
const edcInput = document.getElementById('edc');
const gpInput = document.getElementById('g-p');

// Prenatal Checkups Section
const prenatalFirstTriInput = document.getElementById('prenatal-1st');
const prenatalSecondTriInput = document.getElementById('prenatal-2nd');
const prenatalThirdTri1Input = document.getElementById('prenatal-3rd-1');
const prenatalThirdTri2Input = document.getElementById('prenatal-3rd-2');

// Immunization Status Section
const td1Input = document.getElementById('td1');
const td2Input = document.getElementById('td2');
const td3Input = document.getElementById('td3');
const td4Input = document.getElementById('td4');
const td5Input = document.getElementById('td5');

// Micronutrient Supplementation
// Iron Sulfate
const ironSulfateAmount1 = document.getElementById('iron-sulfate-amount-1');
const ironSulfateDate1 = document.getElementById('iron-sulfate-date-1');
const ironSulfateAmount2 = document.getElementById('iron-sulfate-amount-2');
const ironSulfateDate2 = document.getElementById('iron-sulfate-date-2');
const ironSulfateAmount3 = document.getElementById('iron-sulfate-amount-3');
const ironSulfateDate3 = document.getElementById('iron-sulfate-date-3');
const ironSulfateAmount4 = document.getElementById('iron-sulfate-amount-4');
const ironSulfateDate4 = document.getElementById('iron-sulfate-date-4');
// Calcium Carbonate
const calciumCarbonateAmount2 = document.getElementById('calcium-carbonate-amount-2');
const calciumCarbonateDate2 = document.getElementById('calcium-carbonate-date-2');
const calciumCarbonateAmount3 = document.getElementById('calcium-carbonate-amount-3');
const calciumCarbonateDate3 = document.getElementById('calcium-carbonate-date-3');
const calciumCarbonateAmount4 = document.getElementById('calcium-carbonate-amount-4');
const calciumCarbonateDate4 = document.getElementById('calcium-carbonate-date-4');
// Iodine Capsule
const iodineCapsuleAmount1 = document.getElementById('iodine-capsule-amount-1');
const iodineCapsuleDate1 = document.getElementById('iodine-capsule-date-1');

// Health Status & Supplementation Section
const fimStatusSelect = document.getElementById('fim-status');
const dewormingDateInput = document.getElementById('deworming');
const bmiInput = document.getElementById('bmi');

// Infectious Disease Surveillance
const syphilisDateInput = document.getElementById('syphilis-date');
const syphilisResultSelect = document.getElementById('syphilis-result');
const hepatitisBDateInput = document.getElementById('hepatitis-b-date');
const hepatitisBResultSelect = document.getElementById('hepatitis-b-result');
const hivDateInput = document.getElementById('hiv-date');
const hivResultSelect = document.getElementById('hiv-result');

// Laboratory Screening
const gestationalDiabetesDateInput = document.getElementById('gestational-diabetes-date');
const gestationalDiabetesResultSelect = document.getElementById('gestational-diabetes-result');
const cbcDateInput = document.getElementById('cbc-date');
const cbcResultSelect = document.getElementById('cbc-result');
const cbcGivenIronSelect = document.getElementById('cbc-given-iron');

// Pregnancy Outcome Section
const dateTerminatedInput = document.getElementById('date-terminated');
const outcomeSelect = document.getElementById('outcome');
const sexSelect = document.getElementById('sex');
const typeOfDeliverySelect = document.getElementById('type-of-delivery');
const birthWeightInput = document.getElementById('birth-weight');


// Place of Delivery
const healthFacilityTypeSelect = document.getElementById('health-facility-type');
const bemmoncCemoncCapableSelect = document.getElementById('bemmonc-cemonc-capable');
const facilityOwnershipSelect = document.getElementById('facility-ownership');
const birthAttendantSelect = document.getElementById('birth-attendant');
const deliveryRemarksTextarea = document.getElementById('delivery-remarks');

// Date and Time of Delivery
const deliveryDateInput = document.getElementById('delivery-date');
const deliveryTimeInput = document.getElementById('delivery-time');

// Post Partum Checkups
const postpartumCheckup24hInput = document.getElementById('postpartum-checkup-24h');
const postpartumCheckup7dInput = document.getElementById('postpartum-checkup-7d');

// Postpartum Micronutrient Supplementation
const postpartumIronAmount1 = document.getElementById('postpartum-iron-amount-1');
const postpartumIronDate1 = document.getElementById('postpartum-iron-date-1');
const postpartumIronAmount2 = document.getElementById('postpartum-iron-amount-2');
const postpartumIronDate2 = document.getElementById('postpartum-iron-date-2');
const postpartumIronAmount3 = document.getElementById('postpartum-iron-amount-3');
const postpartumIronDate3 = document.getElementById('postpartum-iron-date-3');
const postpartumVitaminAAmount = document.getElementById('postpartum-vitamin-a-amount');
const postpartumVitaminADate = document.getElementById('postpartum-vitamin-a-date');

// General Remarks
const generalRemarksTextarea = document.getElementById('general-remarks');


const openUpdateMaternityModalBtn = document.getElementById('update-maternal');

const updateMaternityModal = new Modal(updateMaternityModalEl);

function getConsultationDate(title) {
    const consultation = enrolledResident.consultations.find(
        c => c.consultation_title === title
    );
    return consultation && consultation.consultation_date 
        ? consultation.consultation_date.split("T")[0] 
        : "";
}

openUpdateMaternityModalBtn.addEventListener('click', function(){
    const fullName = `${currentResident.firstName} ${currentResident.middleName} ${currentResident.lastName}`;
    const address =  `Household ${currentResident.family.household.id}, ${currentResident.family.household.purok.name}, ${currentResident.family.household.purok.barangay.name}`
    const createdAt = enrolledResident.created_at; // "2025-10-03T19:18:47.000000Z"
    const dateOnly = createdAt.split("T")[0];     // "2025-10-03"

    const birthdate = new Date(currentResident.birthdate + "T00:00:00"); // force ISO date
    const today = new Date();

    let age = today.getFullYear() - birthdate.getFullYear();
    const monthDiff = today.getMonth() - birthdate.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }

    console.log("Birthdate:", birthdate);
    console.log("Age:", age);

    
    dateOfRegistrationInput.value = dateOnly;
    residentNameInput.value = fullName;
    familyNumberInput.value = "#" + currentResident.family_id;
    addressInput.value = address;
    socialEconomicStatusSelect.value = currentResident.family.is_indigent === 1 ? "yes" : "no";
    ageInput.value = age;
    gpInput.value = `G${enrolledResident.maternal_record.gravida}P${enrolledResident.maternal_record.para}`;
    lmpInput.value = enrolledResident.maternal_record.last_menstrual_period.split("T")[0];
    edcInput.value = enrolledResident.maternal_record.expected_date_of_confinement.split("T")[0];
    prenatalFirstTriInput.value  = getConsultationDate("Trimester 1");
    prenatalSecondTriInput.value = getConsultationDate("Trimester 2");
    prenatalThirdTri1Input.value = getConsultationDate("Trimester 3 (1)");
    prenatalThirdTri2Input.value = getConsultationDate("Trimester 3 (2)");
    
    updateMaternityModal.show();
});
