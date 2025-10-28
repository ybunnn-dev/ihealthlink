// --- Main Modal Container ---
const createPhilpenRecordModalEl = document.getElementById('create-philpen-record-modal');

const residentData = window.enrolledResident.resident;
console.log(residentData);
// --- Progress Bar Step Indicators ---
const stepProgress1 = document.getElementById('step-progress-1');
const stepProgress2 = document.getElementById('step-progress-2');
const stepProgress3 = document.getElementById('step-progress-3');
const stepProgress4 = document.getElementById('step-progress-4');
const stepProgress5 = document.getElementById('step-progress-5');
const stepProgress6 = document.getElementById('step-progress-6');
const stepProgress7 = document.getElementById('step-progress-7');
const progressSteps = [stepProgress1, stepProgress2, stepProgress3, stepProgress4, stepProgress5, stepProgress6, stepProgress7];

// --- Form Step Content Divs ---
const step1 = document.getElementById('step-1');
const step2 = document.getElementById('step-2');
const step3 = document.getElementById('step-3');
const step4 = document.getElementById('step-4');
const step5 = document.getElementById('step-5');
const step6 = document.getElementById('step-6');
const step7 = document.getElementById('step-7');
const formSteps = [step1, step2, step3, step4, step5, step6,step7];

// --- Navigation Buttons ---
const cancelPhilpenButton = document.getElementById('cancel-philpen-button');
const prevPhilpenButton = document.getElementById('prev-philpen-button');
const skipPhilpenButton = document.getElementById('skip-philpen-button');
const nextPhilpenButton = document.getElementById('next-philpen-button');
const createPhilpenRecordButton = document.getElementById('create-philpen-record-button');

// Patient's Information
const residentFirstName = document.getElementById('residentFirstName');
const residentLastName = document.getElementById('residentLastName');
const residentMiddleName = document.getElementById('residentMiddleName');
const suffixDropdown = document.getElementById('suffixDropdown');
const suffixDropdownMenu = document.getElementById('suffixDropdownMenu');
const residentContactNo = document.getElementById('residentContactNo');
const residentSexDropdown = document.getElementById('residentSexDropdown');
const residentSexDropdownMenu = document.getElementById('residentSexDropdownMenu');
const residentBirthdate = document.getElementById('residentBirthdate');
const residentAge = document.getElementById('residentAge');
const completeAddress = document.getElementById('completeAddress');
const civilStatusDropdown = document.getElementById('civilStatusDropdown');
const civilStatusDropdownMenu = document.getElementById('civilStatusDropdownMenu');
const religionDropdown = document.getElementById('religionDropdown');
const religionDropdownMenu = document.getElementById('religionDropdownMenu');
const ethnicityDropdown = document.getElementById('ethnicityDropdown');
const ethnicityDropdownMenu = document.getElementById('ethnicityDropdownMenu');
const employmentStatusDropdown = document.getElementById('employmentStatusDropdown');
const employmentStatusDropdownMenu = document.getElementById('employmentStatusDropdownMenu');
const pwdStatusDropdown = document.getElementById('pwdStatusDropdown');
const pwdStatusDropdownMenu = document.getElementById('pwdStatusDropdownMenu');
const pwdIdInput = document.getElementById('pwdIdInput');
const indigenousStatusDropdown = document.getElementById('indigenousStatusDropdown');
const indigenousStatusDropdownMenu = document.getElementById('indigenousStatusDropdownMenu');
const philHealthNo = document.getElementById('philHealthNo');

//assess for redflags
const chestPainCheckbox = document.getElementById('checkbox-chest-pain');
const breathingDifficultyCheckbox = document.getElementById('checkbox-breathing-difficulty');
const lossOfConsciousnessCheckbox = document.getElementById('checkbox-loss-of-consciousness');
const numbArmCheckbox = document.getElementById('checkbox-numb-arm');
const selfHarmCheckbox = document.getElementById('checkbox-self-harm');
const aggressiveBehaviorCheckbox = document.getElementById('checkbox-aggressive-behavior');
const severeInjuriesCheckbox = document.getElementById('checkbox-severe-injuries');
const slurredSpeechCheckbox = document.getElementById('checkbox-slurred-speech');
const facialAsymmetryCheckbox = document.getElementById('checkbox-facial-asymmetry');
const chestRetractionsCheckbox = document.getElementById('checkbox-chest-retractions');
const seizureCheckbox = document.getElementById('checkbox-seizure');
const disorientedCheckbox = document.getElementById('checkbox-disoriented');
const eyeInjuryCheckbox = document.getElementById('checkbox-eye-injury');


//medical history
const hypertensionCheckbox = document.getElementById('medical-history-hypertension');
const heartDiseasesCheckbox = document.getElementById('medical-history-heart-diseases');
const copdCheckbox = document.getElementById('medical-history-copd');
const surgicalHistoryCheckbox = document.getElementById('medical-history-surgical');
const allergiesCheckbox = document.getElementById('medical-history-allergies');
const diabetesCheckbox = document.getElementById('medical-history-diabetes');
const cancerCheckbox = document.getElementById('medical-history-cancer');
const asthmaCheckbox = document.getElementById('medical-history-asthma');
const kidneyDisordersCheckbox = document.getElementById('medical-history-kidney-disorders');
const visionProblemsCheckbox = document.getElementById('medical-history-vision-problems');
const thyroidDisordersCheckbox = document.getElementById('medical-history-thyroid-disorders');
const mentalDisordersCheckbox = document.getElementById('medical-history-mental-disorders');

//family history
const familyHypertensionCheckbox = document.getElementById('family-history-hypertension');
const familyHeartDiseasesCheckbox = document.getElementById('family-history-heart-diseases');
const familyCopdCheckbox = document.getElementById('family-history-copd');
const familyTuberculosisCheckbox = document.getElementById('family-history-tuberculosis');
const familyStrokeCheckbox = document.getElementById('family-history-stroke');
const familyDiabetesCheckbox = document.getElementById('family-history-diabetes');
const familyCancerCheckbox = document.getElementById('family-history-cancer');
const familyAsthmaCheckbox = document.getElementById('family-history-asthma');
const familyKidneyDisordersCheckbox = document.getElementById('family-history-kidney-disorders');
const familyCoronaryDiseaseCheckbox = document.getElementById('family-history-coronary-disease');
const familyMentalDisordersCheckbox = document.getElementById('family-history-mental-disorders');

//NCD Risk Factors
const tobaccoStatusSelect = document.getElementById('tobaccoStatusSelect');
const alcoholIntakeDropdown = document.getElementById('alcoholIntakeDropdown');
const alcoholNumDropdown = document.getElementById('alcoholNumDropdown');
const caffeineDropdown = document.getElementById('caffeineDropdown');
const nutritionDropdown = document.getElementById('nutritionDropdown');
const physicalActivityDropdown = document.getElementById('physicalActivityDropdown');
const weightInput = document.getElementById('weightInput');
const heightInput = document.getElementById('heightInput');
const bmiInput = document.getElementById('bmiInput');
const waistCircumferenceInput = document.getElementById('waistCircumferenceInput');
const systolicInput = document.getElementById('systolicInput');
const diastolicInput = document.getElementById('diastolicInput');

//Risk assessment section
const fbsResultInput = document.getElementById('fbsResultInput');
const rbsResultInput = document.getElementById('rbsResultInput');
const bloodSugarDate = document.getElementById('bloodSugarDate');
const polyphagiaCheckbox = document.getElementById('polyphagiaCheckbox');
const polydipsiaCheckbox = document.getElementById('polydipsiaCheckbox');
const polyuriaCheckbox = document.getElementById('polyuriaCheckbox');

// --- Lipid Profile ---
const totalCholesterolInput = document.getElementById('totalCholesterolInput');
const hdlInput = document.getElementById('hdlInput');
const ldlInput = document.getElementById('ldlInput');
const vldlInput = document.getElementById('vldlInput');
const triglycerideInput = document.getElementById('triglycerideInput');
const lipidDate = document.getElementById('lipidDate');

// --- Urinalysis ---
const proteinInput = document.getElementById('proteinInput');
const ketonesInput = document.getElementById('ketonesInput');
const urinalysisDate = document.getElementById('urinalysisDate');

// --- COPD Symptoms ---
const breathlessnessCheckbox = document.getElementById('breathlessnessCheckbox');
const chronicCoughCheckbox = document.getElementById('chronicCoughCheckbox');
const sputumCheckbox = document.getElementById('sputumCheckbox');
const wheezingCheckbox = document.getElementById('wheezingCheckbox');


// --- Management Section ---
const lifestyleModificationSelect = document.getElementById('lifestyleModificationSelect');
const antiHypertensiveSelect = document.getElementById('antiHypertensiveSelect');
const oralHypoglycemicSelect = document.getElementById('oralHypoglycemicSelect');
const followUpDate = document.getElementById('followUpDate');
const remarksTextarea = document.getElementById('remarksTextarea');

// --- PhilPEN Update Confirmation Modal Elements ---

const confirmUpdatePhilpenModalEl = document.getElementById('confirm-update-philpen-modal');
const residentNameToConfirm = document.getElementById('update-philpen-resident-name-confirm');
const confirmUpdateCheckbox = document.getElementById('confirm-update-philpen-checkbox');
const cancelConfirmUpdateBtn = document.getElementById('cancel-confirm-update-philpen');
const confirmUpdatePhilpenBtn = document.getElementById('confirm-update-philpen-btn');

//
let currentConsultationId = null;
let currentStep = 0;


const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const createPhilpenRecordModal = new Modal(createPhilpenRecordModalEl, modalOptions);
const confirmUpdatePhilpenModal = new Modal(confirmUpdatePhilpenModalEl,modalOptions);
const updateButtons = document.querySelectorAll('.js-update-consultation-btn');


const today = new Date().toISOString().split('T')[0];

// Set it as the input's value
followUpDate.value = today;

function validateNCDForm() {
    const validationResults = {
        tobaccoStatus: tobaccoStatusSelect.value !== '',
        alcoholIntake: alcoholIntakeDropdown.value !== '',
        nutrition: nutritionDropdown.value !== '',
        physicalActivity: physicalActivityDropdown.value !== '',
        weight: weightInput.value.trim() !== '',
        height: heightInput.value.trim() !== '',
        waistCircumference: waistCircumferenceInput.value.trim() !== '',
        systolicBP: systolicInput.value.trim() !== '',
        diastolicBP: diastolicInput.value.trim() !== ''
    };

    const allFieldsValid = Object.values(validationResults).every(isValid => isValid);

    nextPhilpenButton.disabled = !allFieldsValid;

    return allFieldsValid;
}

// --- Helper Functions ---
function setDropdownValue(buttonElement, textValue) {
    if (!buttonElement || !textValue) return;

    const textNode = Array.from(buttonElement.childNodes).find(node => node.nodeType === Node.TEXT_NODE);
    if (textNode) {
        const capitalizedValue = String(textValue).charAt(0).toUpperCase() + String(textValue).slice(1);
        textNode.nodeValue = ` ${capitalizedValue} `;
    }
}

function populateResidentInfo(residentData) {
    residentFirstName.value = residentData.firstName || '';
    residentLastName.value = residentData.lastName || '';
    residentMiddleName.value = residentData.middleName || '';
    residentContactNo.value = residentData.contact_no || '';
    residentBirthdate.value = residentData.birthdate || '';
    pwdIdInput.value = residentData.pwd_id || '';

    if (residentData.birthdate) {
        const birthDate = new Date(residentData.birthdate);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
        residentAge.value = age;
    } else {
        residentAge.value = '';
    }

    if (residentData.family?.household?.purok?.barangay) {
        completeAddress.value = `${residentData.family.household.purok.name}, ${residentData.family.household.purok.barangay.name}`;
    } else {
        completeAddress.value = 'Address not available';
    }

    setDropdownValue(suffixDropdown, residentData.suffix || 'Select');
    setDropdownValue(residentSexDropdown, residentData.sex || 'Select Sex');
    setDropdownValue(civilStatusDropdown, residentData.civil_status || 'Select Civil Status');
    setDropdownValue(religionDropdown, residentData.religion || 'Select Religion');
    setDropdownValue(ethnicityDropdown, residentData.ethnicity || 'Select Ethnicity');
    setDropdownValue(employmentStatusDropdown, residentData.employment_status || 'Select Status');
    setDropdownValue(pwdStatusDropdown, residentData.is_pwd ? 'Yes' : 'No');
    setDropdownValue(indigenousStatusDropdown, residentData.is_indigenous ? 'Yes' : 'No');
}


nutritionDropdown.addEventListener('change', function () {
    const value = this.value;

    if (value === '1') {
        alert('Please give a lifestyle modification advice using the Nutrition Practice Guidelines for Health Professionals in the Primary Care Screening.');
    }
    validateNCDForm();
});

function calculateBMI() {
    const weight = parseFloat(weightInput.value);
    const height = parseFloat(heightInput.value);

    // Ensure valid inputs
    if (weight > 0 && height > 0) {
        const heightInMeters = height / 100; // assuming height is in cm
        const bmi = weight / (heightInMeters * heightInMeters);
        bmiInput.value = bmi.toFixed(2); // display 2 decimal places
    } else {
        bmiInput.value = ''; // clear BMI if invalid
    }
}

waistCircumferenceInput.addEventListener('input',validateNCDForm);
systolicInput.addEventListener('input',validateNCDForm);
diastolicInput.addEventListener('input',validateNCDForm);
alcoholNumDropdown.addEventListener('change',validateNCDForm);
caffeineDropdown.addEventListener('change',validateNCDForm);

// Add listeners
weightInput.addEventListener('input', function(){
    validateNCDForm();
    calculateBMI()
});
heightInput.addEventListener('input', function(){
    validateNCDForm();
    calculateBMI()
});


alcoholIntakeDropdown.addEventListener('change', function () {
    const intakeValue = this.value;

    if (intakeValue === '2') {
        // No alcohol intake
        alcoholNumDropdown.disabled = true;
        alcoholNumDropdown.value = 'Select Frequency';
        alert('Great! Please congratulate the patient — they are at lower risk.');
    } 
    else if (intakeValue === '1') {
        // Yes, enable frequency selection
        alcoholNumDropdown.disabled = false;
    } 
    else {
        // Reset for "Select"
        alcoholNumDropdown.disabled = true;
        alcoholNumDropdown.value = 'Select Frequency';
    }
     validateNCDForm();
});

physicalActivityDropdown.addEventListener('change', function () {
    const value = this.value;

    if (value === '0') {
        alert('Please give the patient a lifestyle modification advice using the Healthy Lifestyle Module as a guide.');
    }
    validateNCDForm();
});

alcoholNumDropdown.addEventListener('change', function () {
    const frequencyValue = this.value;
    const patientSex = residentData.sex;
    // Only check when enabled and a valid selection is made
    if (!alcoholNumDropdown.disabled && frequencyValue) {
        if (patientSex === 'female' && (frequencyValue === '4' || frequencyValue === '5')) {
            alert('Advise the patient: They are in a higher-risk category for harmful alcohol use.');
        } 
        else if (patientSex === 'male' && (frequencyValue === '5')) {
            alert('Advise the patient: They are in a higher-risk category for harmful alcohol use.');
        }
    }
     validateNCDForm();
});

tobaccoStatusSelect.addEventListener('change', function () {
    const value = this.value.trim().toLowerCase();

    if (value && value !== 'never used' && value !== 'select status') {
        alert('Reminder: Please follow the tobacco cessation protocol.');
    }
     validateNCDForm();
});

function goToStep(stepIndex) {
    const currentStepEl = formSteps[currentStep];
    const targetStepEl = formSteps[stepIndex];
    const direction = stepIndex > currentStep ? 1 : -1; // 1 for next, -1 for prev

    // Position the target step off-screen
    targetStepEl.classList.remove('hidden');
    targetStepEl.style.transform = `translateX(${direction * 100}%)`;

    // Animate the steps
    requestAnimationFrame(() => {
        // Slide the current step out
        currentStepEl.style.transform = `translateX(${-direction * 100}%)`;
        // Slide the target step in
        targetStepEl.style.transform = 'translateX(0%)';
    });

    // After animation, hide the old step and clean up transforms
    setTimeout(() => {
        currentStepEl.classList.add('hidden');
        currentStepEl.style.transform = ''; // Reset transform
    }, 500); // This duration should match your CSS transition duration

    currentStep = stepIndex;
}

function applyStyling() {
    // This function now only handles the progress bar and buttons.
    // The showing/hiding of steps is handled by goToStep.

    // Hide all labels first
    progressSteps.forEach(step => {
        const labelSpan = step.querySelector('.text-start');
        if (labelSpan) labelSpan.classList.add('hidden');
    });

    // Update progress bar styles
    progressSteps.forEach((step, index) => {
        step.classList.remove('text-blue-600', 'dark:text-blue-500', 'after:border-blue-600', 'after:dark:border-blue-500');
        const numSpan = step.querySelector('span:first-child span');
        if (numSpan) {
            numSpan.classList.remove('bg-nav_active', 'text-mainblue');
            numSpan.classList.add('bg-gray-100', 'text-main_font');
        }

        if (index <= currentStep) {
            step.classList.add('text-blue-600', 'dark:text-blue-500');
            if (numSpan) {
                numSpan.classList.remove('bg-gray-100', 'text-main_font');
                numSpan.classList.add('bg-nav_active', 'text-mainblue');
            }
            if (index < currentStep) {
                step.classList.add('after:border-blue-600', 'after:dark:border-blue-500');
            }
        }
    });
    
    // Show the label for the active step
    const currentLabel = progressSteps[currentStep].querySelector('.text-start');
    if (currentLabel) currentLabel.classList.remove('hidden');

    // Manage button visibility
    prevPhilpenButton.style.display = currentStep === 0 ? 'none' : 'block';
    cancelPhilpenButton.style.display = currentStep > 0 ? 'none' : 'block';
    nextPhilpenButton.style.display = currentStep === formSteps.length - 1 ? 'none' : 'block';
    createPhilpenRecordButton.style.display = currentStep === formSteps.length - 1 ? 'block' : 'none';
}

function updateUI(direction) {
    const nextStep = direction === 'next' ? currentStep + 1 : currentStep - 1;
    if (nextStep >= 0 && nextStep < formSteps.length) {
        goToStep(nextStep); // Animate the step change
        applyStyling();     // Update the progress bar and buttons
        console.log(currentStep);
        if(currentStep === 4){
            validateNCDForm();
        }else{
            nextPhilpenButton.disabled = false;
        }
    }
}

// --- Event Listeners ---
updateButtons.forEach(button => {
    button.addEventListener('click', async () => {
        const consultationId = button.dataset.consultationId;
        currentConsultationId = consultationId;
        
        // Reset to the first step visually without animation
        formSteps.forEach((step, index) => {
            step.classList.toggle('hidden', index !== 0);
            step.style.transform = '';
        });
        currentStep = 0; 

        populateResidentInfo(residentData);
        applyStyling(); // Apply styling for the initial state
        createPhilpenRecordModal.show();
    });
});

nextPhilpenButton.addEventListener('click', () => updateUI('next'));
prevPhilpenButton.addEventListener('click', () => updateUI('prev'));

// Set the initial state when the script loads by hiding all but the first step
formSteps.forEach((step, index) => {
    step.classList.toggle('hidden', index !== 0);
});

// --- Red Flag Checkbox Listeners ---
const redFlagCheckboxes = [
    chestPainCheckbox, breathingDifficultyCheckbox, lossOfConsciousnessCheckbox,
    numbArmCheckbox, selfHarmCheckbox, aggressiveBehaviorCheckbox,
    severeInjuriesCheckbox, slurredSpeechCheckbox, facialAsymmetryCheckbox,
    chestRetractionsCheckbox, seizureCheckbox, disorientedCheckbox, eyeInjuryCheckbox
];

redFlagCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            alert('Please refer the patient immediately to a physician for further management or referral to the next level of care.');
        }
    });
});

function createPhilpenPayload() {
    const payload = {
        consultation: currentConsultationId,
        patientInformation: {
            firstName: residentFirstName.value.trim(),
            lastName: residentLastName.value.trim(),
            middleName: residentMiddleName.value.trim(),
            suffix: suffixDropdown.value,
            contactNo: residentContactNo.value.trim(),
            sex: residentSexDropdown.value,
            birthdate: residentBirthdate.value,
            age: residentAge.value,
            address: completeAddress.value,
            civilStatus: civilStatusDropdown.value,
            religion: religionDropdown.value,
            ethnicity: ethnicityDropdown.value,
            employmentStatus: employmentStatusDropdown.value,
            isPwd: pwdStatusDropdown.value,
            pwdId: pwdIdInput.value.trim(),
            isIndigenous: indigenousStatusDropdown.value,
            philHealthNo: philHealthNo.value.trim(),
        },
        redFlags: {
            chestPain: chestPainCheckbox.checked,
            breathingDifficulty: breathingDifficultyCheckbox.checked,
            lossOfConsciousness: lossOfConsciousnessCheckbox.checked,
            numbArm: numbArmCheckbox.checked,
            selfHarm: selfHarmCheckbox.checked,
            aggressiveBehavior: aggressiveBehaviorCheckbox.checked,
            severeInjuries: severeInjuriesCheckbox.checked,
            slurredSpeech: slurredSpeechCheckbox.checked,
            facialAsymmetry: facialAsymmetryCheckbox.checked,
            chestRetractions: chestRetractionsCheckbox.checked,
            seizure: seizureCheckbox.checked,
            disoriented: disorientedCheckbox.checked,
            eyeInjury: eyeInjuryCheckbox.checked,
        },
        medicalHistory: {
            hypertension: hypertensionCheckbox.checked,
            heartDiseases: heartDiseasesCheckbox.checked,
            copd: copdCheckbox.checked,
            surgicalHistory: surgicalHistoryCheckbox.checked,
            allergies: allergiesCheckbox.checked,
            diabetes: diabetesCheckbox.checked,
            cancer: cancerCheckbox.checked,
            asthma: asthmaCheckbox.checked,
            kidneyDisorders: kidneyDisordersCheckbox.checked,
            visionProblems: visionProblemsCheckbox.checked,
            thyroidDisorders: thyroidDisordersCheckbox.checked,
            mentalDisorders: mentalDisordersCheckbox.checked,
        },
        familyHistory: {
            hypertension: familyHypertensionCheckbox.checked,
            heartDiseases: familyHeartDiseasesCheckbox.checked,
            copd: familyCopdCheckbox.checked,
            tuberculosis: familyTuberculosisCheckbox.checked,
            stroke: familyStrokeCheckbox.checked,
            diabetes: familyDiabetesCheckbox.checked,
            cancer: familyCancerCheckbox.checked,
            asthma: familyAsthmaCheckbox.checked,
            kidneyDisorders: familyKidneyDisordersCheckbox.checked,
            coronaryDisease: familyCoronaryDiseaseCheckbox.checked,
            mentalDisorders: familyMentalDisordersCheckbox.checked,
        },
        ncdRiskFactors: {
            tobaccoStatus: tobaccoStatusSelect.value,
            alcoholIntake: alcoholIntakeDropdown.value,
            alcoholFrequency: alcoholNumDropdown.value,
            caffeineIntake: caffeineDropdown.value,
            nutrition: nutritionDropdown.value,
            physicalActivity: physicalActivityDropdown.value,
            weightKg: weightInput.value.trim(),
            heightCm: heightInput.value.trim(),
            bmi: bmiInput.value,
            waistCm: waistCircumferenceInput.value.trim(),
            systolicBp: systolicInput.value.trim(),
            diastolicBp: diastolicInput.value.trim(),
        },
        riskAssessment: {
            bloodSugar: {
                fbs: fbsResultInput.value.trim(),
                rbs: rbsResultInput.value.trim(),
                dateTaken: bloodSugarDate.value,
                symptoms: {
                    polyphagia: polyphagiaCheckbox.checked,
                    polydipsia: polydipsiaCheckbox.checked,
                    polyuria: polyuriaCheckbox.checked,
                },
            },
            lipidProfile: {
                totalCholesterol: totalCholesterolInput.value.trim(),
                hdl: hdlInput.value.trim(),
                ldl: ldlInput.value.trim(),
                vldl: vldlInput.value.trim(),
                triglyceride: triglycerideInput.value.trim(),
                dateTaken: lipidDate.value,
            },
            urinalysis: {
                protein: proteinInput.value.trim(),
                ketones: ketonesInput.value.trim(),
                dateTaken: urinalysisDate.value,
            },
            copdSymptoms: {
                breathlessness: breathlessnessCheckbox.checked,
                chronicCough: chronicCoughCheckbox.checked,
                sputumProduction: sputumCheckbox.checked,
                wheezing: wheezingCheckbox.checked,
            },
        },
        management: {
            lifestyleModification: lifestyleModificationSelect.value,
            medications: {
                antiHypertensive: antiHypertensiveSelect.value,
                oralHypoglycemic: oralHypoglycemicSelect.value,
            },
            followUpDate: followUpDate.value,
            remarks: remarksTextarea.value.trim(),
        },
    };

    return payload;
}
createPhilpenRecordButton.addEventListener('click', function() {
    
    // Build full name safely
    const { firstName, middleName, lastName, suffix } = residentData;

    const fullName = [
        firstName,
        middleName ? middleName : null,
        lastName,
        suffix ? suffix : null
    ].filter(Boolean).join(' ');

    residentNameToConfirm.textContent = fullName;

    createPhilpenRecordModal.hide();
    confirmUpdatePhilpenModal.show();

});

confirmUpdateCheckbox.addEventListener('change',function(){
    confirmUpdatePhilpenBtn.disabled = !this.checked;
});

confirmUpdatePhilpenBtn.addEventListener('click', function() {
    const payload = createPhilpenPayload();

    console.log('Payload before sending:', payload);

    fetch('/barangay/health-programs/philpen/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Server Response:', data);
        if(data.result === 'success'){
            alert('PhilPEN record has been successfully updated');
            window.location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
});

cancelConfirmUpdateBtn.addEventListener('click',function(){
    createPhilpenRecordModal.show();
    confirmUpdatePhilpenModal.hide();
});
cancelPhilpenButton.addEventListener('click',function(){
    createPhilpenRecordModal.hide();
});

applyStyling();


