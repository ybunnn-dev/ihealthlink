// Main Modal Element
const updateChildCareModalEl = document.getElementById('update-child-care-modal');

const enrolledResident = window.enrolledResident;
const enrolledResidentId = window.enrolledResident.id;
const enrollmentDate = window.enrolledResident.created_at;
const resident = window.enrolledResident.resident;
const family = resident.family;
const mother = window.enrolledResident.child_healthcare.mother;
const childCare = window.enrolledResident.child_healthcare;
const childConsultations = window.enrolledResident.consultations;

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
const motherTetanusSelect = document.getElementById('mother-tetanus');

// C. Newborn (0-28 days old)
const birthWeight = document.getElementById('birth-weight');
const birthWeightStatus = document.getElementById('birth-weight-status');
const initiatedBreastfeeding = document.getElementById('initiated-breastfeeding');
const bcgDate = document.getElementById('bcg-date');
const hepaBDate = document.getElementById('hepa-b-bd-date');

// D. 1-3 Months Old
const ageInMonthsD = document.getElementById('age-in-months-d');
const lengthCmD = document.getElementById('length-cm');
const lengthDDate = document.getElementById('length-date');
const weightKgD = document.getElementById('weight-kg-d');
const weightDateD = document.getElementById('weight-date-d');
const statusD = document.getElementById('status-d');
const lbwIron1mo = document.getElementById('lbw-iron-1mo');
const lbwIron2mo = document.getElementById('lbw-iron-2mo');
const lbwIron3mo = document.getElementById('lbw-iron-3mo');

// --- 1.5 Months Elements ---
const ebfSelect1_5Months = document.getElementById('ebf_select_1_5_months');
const ebfDate1_5Months = document.getElementById('ebf_date_1_5_months');
const ebfSelect2_5Months = document.getElementById('ebf_select_2_5_months');
const ebfDate2_5Months = document.getElementById('ebf_date_2_5_months');
const ebfSelect3_5Months = document.getElementById('ebf_select_3_5_months');
const ebfDate3_5Months = document.getElementById('ebf_date_3_5_months');
const ebfSelect4_5Months = document.getElementById('ebf_select_4_5_months');
const ebfDate4_5Months = document.getElementById('ebf_date_4_5_months');

// E. 6-11 Months Old
const ageInMonthsE = document.getElementById('age-in-months-e');
const weightKgE = document.getElementById('weight-kg-e');
const lengthCmE = document.getElementById('length-cm-e');
const lengthEDate = document.getElementById('length-date-e');
const weightDateE = document.getElementById('weight-date-e');
const statusE = document.getElementById('status-e');
const ebf6mo = document.getElementById('ebf-6mo');
const ebf6mo_date_stopped = document.getElementById('ebf-6mo-date');
const compFeeding = document.getElementById('comp-feeding');
const vitADate = document.getElementById('vit-a-date');
const mnpDate = document.getElementById('mnp-date');
const mmr1Date = document.getElementById('mmr1-date');

// DPT-HiB-HepB Inputs
const dptHibHepb1 = document.getElementById('dpt-hib-hepb-1');
const dptHibHepb2 = document.getElementById('dpt-hib-hepb-2');
const dptHibHepb3 = document.getElementById('dpt-hib-hepb-3');

// OPV Inputs
const opv1 = document.getElementById('opv-1');
const opv2 = document.getElementById('opv-2');
const opv3 = document.getElementById('opv-3');

// PCV Inputs
const pcv1 = document.getElementById('pcv-1');
const pcv2 = document.getElementById('pcv-2');
const pcv3 = document.getElementById('pcv-3');

// IPV Input
const ipv = document.getElementById('ipv');

// F. 12 Months
const ageInMonthsF = document.getElementById('age-in-months-f');
const heightCmF = document.getElementById('length-cm-f');
const heightDateF = document.getElementById('length-date-f');
const weightKgF = document.getElementById('weight-kg-f');
const weightDateF = document.getElementById('weight-date-f');
const statusF = document.getElementById('status-f');
const mmr2Date = document.getElementById('mmr2-date');
const ficDate = document.getElementById('fic-date');

// G. Final Status & Remarks
const cicDate = document.getElementById('cic-date');
const childRemarks = document.getElementById('child-remarks');

const residentNameToUpdate = document.getElementById('update-cc-resident-name-to-confirm');
const updateConfirmCheckbox = document.getElementById('confirm-update-cc-checkbox');
const cancelUpdateBtn = document.getElementById('cancel-confirm-update-cc');
const confirmUpdateBtn = document.getElementById('confirm-update-cc-btn');
const residentNameToPrint = document.getElementById('print-cc-resident-name-to-confirm');
const cancelPrintBtn = document.getElementById('cancel-confirm-print-cc');
const confirmPrintCheckbox = document.getElementById('confirm-print-cc-checkbox');
const confirmPrintBtn = document.getElementById('confirm-print-cc-btn');
const confirmUpdateChildCareModalEl = document.getElementById('confirm-update-child-care-modal');
const confirmPrintChildCareModalEl = document.getElementById('confirm-print-child-care-modal');

// Modal Footer Buttons
const cancelBtn = document.getElementById('cancel-update-child-care');
const printBtn = document.getElementById('print-child-care-btn');
const updateBtn = document.getElementById('update-child-care-btn');


const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

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

const updateChildCareModal = new Modal(updateChildCareModalEl, createModalOptions(updateChildCareModalEl));
const confirmPrintChildCareModal = new Modal(confirmPrintChildCareModalEl, createModalOptions(confirmPrintChildCareModalEl));
const confirmUpdateChildCareModal = new Modal(confirmUpdateChildCareModalEl, createModalOptions(confirmUpdateChildCareModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

const openUpdateChildCareBtn = document.getElementById('update-record');

function checkMotherImmunization(mother) {
    let status = "no anti-tetanus data";

    const antiTetanusData = window.enrolledResident.child_healthcare.mother.anti_tetanus_enrollment;

    if (antiTetanusData && Array.isArray(antiTetanusData .consultations)) {
        const consultations = antiTetanusData.consultations;

        let tt1Completed = false;
        let tt2Completed = false;
        let tt3Completed = false;
        let tt4Completed = false;
        let tt5Completed = false;

        console.log("---- Checking Mother's Consultations ----");
        consultations.forEach((c, index) => {
            const title = c?.consultation_title?.trim()?.toUpperCase() || "(no title)";
            const stat = c?.status || "(no status)";
          

            if (stat === "completed") {
                if (title === "TT1/TD1") tt1Completed = true;
                else if (title === "TT2/TD2") tt2Completed = true;
                else if (title === "TT3/TD3") tt3Completed = true;
                else if (title === "TT4/TD4") tt4Completed = true;
                else if (title === "TT5/TD5") tt5Completed = true;
            }
        });

        // Determine status based on completed stages
        // Check TT3-TT5 first (highest level)
        if (tt3Completed || tt4Completed || tt5Completed) {
            status = "tt3/td3-tt5/td5 or tt1/td1-tt5/td5";
        } 
        // Only if TT2 is completed (TT1 alone is not enough)
        else if (tt2Completed) {
            status = "tt2/td2";
        }
        // If only TT1 or none completed, stays as "no anti-tetanus data"
    } else {
        console.log("No consultations found or anti_tetanus_enrollment missing.");
    }
    motherTetanusSelect.value = status;
}

function getConsultationByTitle(consultations, title) {
    if (!Array.isArray(consultations)) {
        console.error("Error: The provided data is not an array.");
        return undefined;
    }
    return consultations.find(consultation => consultation.consultation_title === title);
}

function getMedicineDistribution(consultation, category) {
    if (!consultation.medicine_distributions || !Array.isArray(consultation.medicine_distributions)) {
        return null;
    }

    // Find the medicine distribution by category
    const distribution = consultation.medicine_distributions.find(md =>
        md.medicine && md.medicine.category === category
    );

    // Return formatted date (YYYY-MM-DD) or empty if not found
    return distribution && distribution.created_at
        ? new Date(distribution.created_at).toISOString().slice(0, 10)
        : null;
}

function setExclusiveBreastfeedFields(childCare, index, selectElement, dateElement) {
    const statusKey = `is_exclusive_breastfeed_${index}`;
    const dateKey = `exclusive_breastfeed_date_${index}`;
    let status;
    let rawDate;
    if(index !== 6){
        status = childCare[statusKey];
        rawDate = childCare[dateKey];
    }else{
        status = childCare['is_exclusive_breastfeed_6mos'];
        rawDate = childCare['stopped_exclusive_breastfeed_date'];
    }
 
    // Handle yes/no value
    if (status !== null && status !== undefined) {
        selectElement.value = status === 1 ? 'yes' : 'no';
    } else {
        selectElement.value = '';
    }

    // Handle date value and format it
    if (rawDate) {
        const formattedDate = new Date(rawDate).toISOString().slice(0, 10); // YYYY-MM-DD
        dateElement.value = formattedDate;
    } else {
        dateElement.value = '';
    }
}

function formatDateForInput(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return isNaN(date.getTime()) ? '' : date.toISOString().slice(0, 10);
}

openUpdateChildCareBtn.addEventListener('click',function(){
    updateChildCareModal.show();

    childRegDate.value = enrollmentDate;
    childBirthDate.value = resident.birthdate;
    childFamilyNo.value = family.id;
    childRegDate.value = new Date(enrollmentDate).toISOString().slice(0, 10)
    childSes.value = family.is_indigient === 1 ? 'nhts' : 'non-nhts';
    childFullName.value = 'male';

    // Build full name safely
    const { firstName, middleName, lastName, suffix } = resident;

    const fullName = [
        firstName,
        middleName ? middleName : null,
        lastName,
        suffix ? suffix : null
    ].filter(Boolean).join(' ');

    const fullNameMother = [
        mother.firstName,
        mother.middleName ? mother.middleName : null,
        mother.lastName,
        mother.suffix ? mother.suffix : null
    ].filter(Boolean).join(' ');

    childFullName.value = fullName;
    childSex.value = resident.sex;
    motherFullName.value = fullNameMother;
    childAddress.value = `${resident.family.household.purok.name}, ${resident.family.household.purok.barangay.name}, Daraga, Albay`;

    checkMotherImmunization();
    console.log(childCare);
    birthWeight.value = childCare.birth_weight;

    birthWeightStatus.value = childCare.birth_weight < 2.5 ? 'low' : 'normal';
    console.log(childCare.initiated_breast_feed);
    
    initiatedBreastfeeding.value = formatDateForInput(childCare.initiated_breast_feed);

    ageInMonthsD.value = '1';
    
    //and use it here
    const firstConsultation = getConsultationByTitle(childConsultations, 'Within 28 Days Old');
    const secondConsultation = getConsultationByTitle(childConsultations, '1 1/2 Months');
    const thirdConsultation = getConsultationByTitle(childConsultations, '2 1/2 Months');
    const fourthConsultation = getConsultationByTitle(childConsultations, '3 1/2 Months');
    const fifthConsultation = getConsultationByTitle(childConsultations, '4 Months');
    const sixthConsultation = getConsultationByTitle(childConsultations, '5 Months');
    const seventhConsultation = getConsultationByTitle(childConsultations, '6 Months');
    const eighthConsultation = getConsultationByTitle(childConsultations, '7 Months');
    const ninthConsultation = getConsultationByTitle(childConsultations, '9 Months');
    const tenthConsultation = getConsultationByTitle(childConsultations, '12 Months');


    if (firstConsultation && firstConsultation.consultation_data) {
        const data = firstConsultation.consultation_data;
        const consultationDate = new Date(firstConsultation.consultation_date).toISOString().slice(0, 10);

        // Populate the nutrition fields using the found data
        lengthCmD.value = data.height !== null ? data.height : ''; // Use height for length
        lengthDDate.value = consultationDate;
        
        weightKgD.value = data.weight !== null ? data.weight : ''; // Use weight
        weightDateD.value = consultationDate;

        // --- Automatically determine status based on weight and height ---
        if (data.weight && data.height) {
            const heightMeters = data.height / 100;
            const bmi = data.weight / (heightMeters * heightMeters);
            let status = 'normal'; // default

            if (bmi < 14) status = 'wasted-sam';
            else if (bmi >= 14 && bmi < 15) status = 'wasted-mam';
            else if (bmi >= 15 && bmi < 17) status = 'normal';
            else if (bmi >= 17 && bmi < 19) status = 'overweight';
            else if (bmi >= 19) status = 'stunted'; // optional fallback if height is low for age

            statusD.value = status;
            console.log(`Child BMI: ${bmi.toFixed(2)}, Status: ${status}`);
        } else {
            statusD.value = 'Select status';
            console.warn('Incomplete data: weight or height missing.');
        }

    } else {
        console.warn(`No data found for consultation titled: "${targetTitle}"`);
        lengthCmD.value = '';
        lengthDDate.value = '';
        weightKgD.value = '';
        weightDateD.value = '';
        statusD.value = 'Select status';
    }

    bcgDate.value = getMedicineDistribution(firstConsultation, 'bcg');
    hepaBDate.value = getMedicineDistribution(firstConsultation, 'hepa-b-bd');
    lbwIron1mo.value = getMedicineDistribution(secondConsultation, 'iron');
    lbwIron2mo.value = getMedicineDistribution(thirdConsultation, 'iron');
    lbwIron3mo.value = getMedicineDistribution(fourthConsultation, 'iron');
    dptHibHepb1.value = getMedicineDistribution(secondConsultation, 'dpt-hepb-hib');
    pcv1.value = getMedicineDistribution(secondConsultation, 'pcv');
    opv1.value = getMedicineDistribution(secondConsultation, 'opv');
    dptHibHepb2.value = getMedicineDistribution(thirdConsultation, 'dpt-hepb-hib');
    pcv2.value = getMedicineDistribution(thirdConsultation, 'pcv');
    opv2.value = getMedicineDistribution(thirdConsultation, 'opv');
    dptHibHepb3.value = getMedicineDistribution(fourthConsultation, 'dpt-hepb-hib');
    opv3.value = getMedicineDistribution(fourthConsultation, 'opv');
    pcv3.value = getMedicineDistribution(fourthConsultation, 'pcv');
    ipv.value = getMedicineDistribution(fourthConsultation, 'ipv');
    
    setExclusiveBreastfeedFields(childCare, 1, ebfSelect1_5Months, ebfDate1_5Months);
    setExclusiveBreastfeedFields(childCare, 2, ebfSelect2_5Months, ebfDate2_5Months);
    setExclusiveBreastfeedFields(childCare, 3, ebfSelect3_5Months, ebfDate3_5Months);
    setExclusiveBreastfeedFields(childCare, 4, ebfSelect4_5Months, ebfDate4_5Months);
    setExclusiveBreastfeedFields(childCare, 6, ebf6mo, ebf6mo_date_stopped);

    compFeeding.value = childCare.complementary_feeding_status || '';


    if (seventhConsultation && seventhConsultation.consultation_data) {
        const data = seventhConsultation.consultation_data;
        const consultationDate = new Date(seventhConsultation.consultation_date).toISOString().slice(0, 10);

        ageInMonthsE.value = '6'; // since this is the 7th month
        // Populate the nutrition fields using the found data
        lengthCmE.value = data.height !== null ? data.height : ''; // Use height for length
        weightKgE.value = data.weight !== null ? data.weight : ''; // Use weight
        weightDateE.value = consultationDate;
        lengthEDate.value = consultationDate;
        // --- Automatically determine status based on weight and height ---
        if (data.weight && data.height) {
            const heightMeters = data.height / 100;
            const bmi = data.weight / (heightMeters * heightMeters);
            let status = 'normal'; // default

            if (bmi < 14) status = 'wasted-sam';
            else if (bmi >= 14 && bmi < 15) status = 'wasted-mam';
            else if (bmi >= 15 && bmi < 17) status = 'normal';
            else if (bmi >= 17 && bmi < 19) status = 'overweight';
            else if (bmi >= 19) status = 'stunted'; // optional fallback if height is low for age

            statusE.value = status;
            console.log(`Child BMI: ${bmi.toFixed(2)}, Status: ${status}`);
        } else {
            statusE.value = 'Select status';
            console.warn('Incomplete data: weight or height missing.');
        }

    } else {
        console.warn('No data found for consultation titled: "7 Months"');
        lengthCmE.value = '';
        lengthEDate.value = '';
        weightKgE.value = '';
        weightDateE.value = '';
        statusE.value = 'Select status';
    }

    let vitA = getMedicineDistribution(seventhConsultation, 'vit-a');
    if (!vitA) {
        vitA = getMedicineDistribution(eighthConsultation, 'vit-a');
    }

    vitADate.value = vitA || '';

    let mnp = getMedicineDistribution(seventhConsultation, 'mnp');
    if (!mnp) {
        mnp = getMedicineDistribution(eighthConsultation, 'mnp');
    }
   

    mnpDate.value = mnp || '';

    mmr1Date.value = getMedicineDistribution(ninthConsultation, 'mmr');
    mmr2Date.value = getMedicineDistribution(tenthConsultation, 'mmr');

    if (tenthConsultation && tenthConsultation.consultation_data) {
        const data = tenthConsultation.consultation_data;
        const consultationDate = new Date(tenthConsultation.consultation_date).toISOString().slice(0, 10);

        ageInMonthsF.value = '12';

        // Populate the nutrition fields using the found data
        heightCmF.value = data.height !== null ? data.height : '';
        heightDateF.value = consultationDate;

        weightKgF.value = data.weight !== null ? data.weight : '';
        weightDateF.value = consultationDate;

        // --- Automatically determine status based on weight and height ---
        if (data.weight && data.height) {
            const heightMeters = data.height / 100;
            const bmi = data.weight / (heightMeters * heightMeters);
            let status = 'normal'; // default

            if (bmi < 14) status = 'wasted-sam';
            else if (bmi >= 14 && bmi < 15) status = 'wasted-mam';
            else if (bmi >= 15 && bmi < 17) status = 'normal';
            else if (bmi >= 17 && bmi < 19) status = 'overweight';
            else if (bmi >= 19) status = 'stunted';

            statusF.value = status;
            console.log(`Child BMI: ${bmi.toFixed(2)}, Status: ${status}`);
        } else {
            statusF.value = 'Select status';
            console.warn('Incomplete data: weight or height missing.');
        }

    } else {
        console.warn(`No data found for tenth consultation`);
        heightCmF.value = '';
        heightDateF.value = '';
        weightKgF.value = '';
        weightDateF.value = '';
        statusF.value = 'Select status';
    }

    ficDate.value = formatDateForInput(childCare.fic_date);
    cicDate.value = formatDateForInput(childCare.cic_date);
    childRemarks.value = childCare.remarks;

});

cancelBtn.addEventListener('click',function(){
    updateChildCareModal.hide();
});


function getChildHealthPayload() {
    const payload = {
        importantIds:{
            enrolled_resident_id: enrolledResidentId,
            child_care_id: childCare.id
        },
        basicInfo: {
            registrationDate: childRegDate.value,
            birthDate: childBirthDate.value,
            familyNumber: childFamilyNo.value,
            ses: childSes.value,
            fullName: childFullName.value,
            sex: childSex.value,
            motherFullName: motherFullName.value,
            address: childAddress.value,
        },
        atBirth: {
            motherTetanusStatus: motherTetanusSelect.value,
            birthWeightKg: birthWeight.value,
            birthWeightStatus: birthWeightStatus.value,
            initiatedBreastfeeding: initiatedBreastfeeding.value,
        },
        immunizations: {
            bcgDate: bcgDate.value,
            hepaBDate: hepaBDate.value,
            dptHibHepb: {
                dose1: dptHibHepb1.value,
                dose2: dptHibHepb2.value,
                dose3: dptHibHepb3.value
            },
            opv: {
                dose1: opv1.value,
                dose2: opv2.value,
                dose3: opv3.value
            },
            pcv: {
                dose1: pcv1.value,
                dose2: pcv2.value,
                dose3: pcv3.value
            },
            ipvDate: ipv.value,
            mmr1Date: mmr1Date.value,
            mmr2Date: mmr2Date.value,
            ficDate: ficDate.value, // Fully Immunized Child
            cicDate: cicDate.value, // Child Immunization Completed
        },
        nutrition: {
            exclusiveBreastfeeding: {
                at1_5months: { status: ebfSelect1_5Months.value, date: ebfDate1_5Months.value },
                at2_5months: { status: ebfSelect2_5Months.value, date: ebfDate2_5Months.value },
                at3_5months: { status: ebfSelect3_5Months.value, date: ebfDate3_5Months.value },
                at4_5months: { status: ebfSelect4_5Months.value, date: ebfDate4_5Months.value },
                statusAt6Months: ebf6mo.value,
                dateStopped: ebf6mo_date_stopped.value,
            },
            supplements: {
                vitADate: vitADate.value,
                mnpDate: mnpDate.value,
                lbwIron: {
                    month1: lbwIron1mo.value,
                    month2: lbwIron2mo.value,
                    month3: lbwIron3mo.value,
                }
            },
            complementaryFeedingStarted: compFeeding.value,
        },
        assessments: {
            oneToThreeMonths: {
                ageInMonths: ageInMonthsD.value,
                lengthCm: lengthCmD.value,
                lengthDate: lengthDDate.value,
                weightKg: weightKgD.value,
                weightDate: weightDateD.value,
                status: statusD.value,
            },
            sixToElevenMonths: {
                ageInMonths: ageInMonthsE.value,
                lengthCm: lengthCmE.value,
                lengthDate: lengthEDate.value,
                weightKg: weightKgE.value,
                weightDate: weightDateE.value,
                status: statusE.value,
            },
            twelveMonths: {
                ageInMonths: ageInMonthsF.value,
                heightCm: heightCmF.value,
                heightDate: heightDateF.value,
                weightKg: weightKgF.value,
                weightDate: weightDateF.value,
                status: statusF.value,
            }
        },
        remarks: childRemarks.value
    };

    return payload;
}

updateConfirmCheckbox.addEventListener('click',function(){
    confirmUpdateBtn.disabled = !this.checked;
});

cancelUpdateBtn.addEventListener('click',function(){
    confirmUpdateChildCareModal.hide();
    updateChildCareModal.show();
});

cancelPrintBtn.addEventListener('click',function(){
    confirmPrintChildCareModal.hide();
    updateChildCareModal.show();
});

confirmPrintCheckbox.addEventListener('click',function(){
    confirmPrintBtn.disabled = !this.checked;
});

async function submitChildHealthUpdate() {
    const originalButtonText = confirmUpdateBtn.textContent;
    
    // Get form data
    const formDataPayload = getChildHealthPayload();
    console.log("Collected Form Payload:", formDataPayload);
    
    // Disable buttons and show loading state
    confirmUpdateBtn.disabled = true;
    cancelUpdateBtn.disabled = true;
    confirmUpdateBtn.textContent = 'Saving...';
    
    try {
        const response = await fetch('/barangay/health-program/update-child-record', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formDataPayload)
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            confirmUpdateChildCareModal.hide();
            successMesageHeader.textContent = 'Update Successful';
            successMessage.textContent = data.message || 'Child health record has been successfully updated.';
            successModal.show();
        } else {
            alert(data.message || 'An error occurred while updating.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update record. Please check your connection.');
    } finally {
        // Re-enable buttons and restore text
        confirmUpdateBtn.disabled = false;
        cancelUpdateBtn.disabled = false;
        confirmUpdateBtn.textContent = originalButtonText;
    }
}

// ===== EVENT LISTENER =====
confirmUpdateBtn.addEventListener('click', submitChildHealthUpdate);

// Close success modal and reload
closeSuccessModalButton.addEventListener('click', () => {
    successModal.hide();
    window.location.reload();
});

confirmPrintBtn.addEventListener('click',function(){
    // Get the payload using the function from the previous step
    const formDataPayload = getChildHealthPayload();
    confirmPrintBtn.disabled = true;
    // Use the Fetch API to send the data to your Laravel backend
    fetch("/export/child-care-record", { // Using Blade's route helper
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Important for CSRF protection
        },
        body: JSON.stringify(formDataPayload)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.blob(); // Get the response as a binary object (the PDF)
    })
    .then(blob => {
        // Create a URL for the blob
        const url = window.URL.createObjectURL(blob);
        // Create a temporary link to trigger the download
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        // The filename is set on the backend, but you can suggest one here
        a.download = `child-care-record.pdf`; 
        document.body.appendChild(a);
        a.click();
        // Clean up
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while generating the PDF.');
        window.location.reload();
    });
    window.location.reload();
});

updateBtn.addEventListener('click', function() {
    updateChildCareModal.hide();
    residentNameToUpdate.textContent = childFullName.value.trim();
    confirmUpdateChildCareModal.show();
});

printBtn.addEventListener('click', function() {
    updateChildCareModal.hide();
    residentNameToPrint.textContent = childFullName.value.trim();
    confirmPrintChildCareModal.show();
});