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


//
let currentConsultationId = null;
let currentStep = 0;


const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const createPhilpenRecordModal = new Modal(createPhilpenRecordModalEl, modalOptions);
const updateButtons = document.querySelectorAll('.js-update-consultation-btn');


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
});

physicalActivityDropdown.addEventListener('change', function () {
    const value = this.value;

    if (value === '0') {
        alert('Please give the patient a lifestyle modification advice using the Healthy Lifestyle Module as a guide.');
    }
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
});

tobaccoStatusSelect.addEventListener('change', function () {
    const value = this.value.trim().toLowerCase();

    if (value && value !== 'never used' && value !== 'select status') {
        alert('Reminder: Please follow the tobacco cessation protocol.');
    }
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


applyStyling();


/*
const addResidentModalEl = document.getElementById('add-resident-modal');
//form 1 inputs
// --- Row 1: Name ---
const residentFirstName = document.getElementById('residentFirstName');
const residentLastName = document.getElementById('residentLastName');
const residentMiddleName = document.getElementById('residentMiddleName');
const suffixDropdown = document.getElementById('suffixDropdown');

// --- Row 2: Contact Info & Demographics ---
const residentContactNo = document.getElementById('residentContactNo');
const residentSexDropdown = document.getElementById('residentSexDropdown');
const residentBirthdate = document.getElementById('residentBirthdate');
const residentAge = document.getElementById('residentAge');

// --- Row 3: Household Info ---

const chooseFamilyBtn = document.getElementById('familyDropdown');
const relationshipToHead = document.getElementById('relationshipToHead');
const householdIdDisplay = document.getElementById('householdIdDisplay'); // Disabled display field
const purokDisplay = document.getElementById('purokDisplay'); // Disabled display field

// --- Row 4: Other Demographics ---
const civilStatusDropdown = document.getElementById('civilStatusDropdown');
const religionDropdown = document.getElementById('religionDropdown');
const ethnicityDropdown = document.getElementById('ethnicityDropdown');
const employmentStatusDropdown = document.getElementById('employmentStatusDropdown');

// --- Row 5: Special Status ---
const pwdStatusDropdown = document.getElementById('pwdStatusDropdown');
const pwdIdInput = document.getElementById('pwdIdInput');
const indigenousStatusDropdown = document.getElementById('indigenousStatusDropdown');
const emergencyContactNo = document.getElementById('emergencyContactNo');

//form 2 input fields



//form 5 input fields
const tobaccoDropdown = document.getElementById('tobaccoDropdown');
const alcoholDropdown = document.getElementById('alcoholDropdown');
const alcoholNumDropdown = document.getElementById('alcoholNumDropdown');
const caffeineDropdown = document.getElementById('caffeineDropdown');
const physicalActivityInput = document.getElementById('physicalActivityInput');
const weightInput = document.getElementById('weightInput');
const heightInput = document.getElementById('heightInput');
const bmiInput = document.getElementById('bmiInput');
const waistCircumferenceInput = document.getElementById('waistCircumferenceInput');
const systolicInput = document.getElementById('systolicInput');
const diastolicInput = document.getElementById('diastolicInput');
const highFatFoodCheckbox = document.getElementById('highFatFoodCheckbox');
const streetFoodCheckbox = document.getElementById('streetFoodCheckbox');
const highSugarFoodCheckbox = document.getElementById('highSugarFoodCheckbox');


//form 6 inputs
// --- Blood Sugar Elements ---
const fbsResultInput = document.getElementById('fbsResultInput');
const rbsResultInput = document.getElementById('rbsResultInput');
const bloodSugarDate = document.getElementById('bloodSugarDate');
const polyphagiaCheckbox = document.getElementById('polyphagiaCheckbox');
const polydipsiaCheckbox = document.getElementById('polydipsiaCheckbox');
const polyuriaCheckbox = document.getElementById('polyuriaCheckbox');

// --- Lipid Profile Elements ---
const totalCholesterolInput = document.getElementById('totalCholesterolInput');
const hdlInput = document.getElementById('hdlInput');
const ldlInput = document.getElementById('ldlInput');
const vldlInput = document.getElementById('vldlInput');
const triglycerideInput = document.getElementById('triglycerideInput');
const lipidDate = document.getElementById('lipidDate');

// --- Urinalysis Elements ---
const proteinInput = document.getElementById('proteinInput');
const ketonesInput = document.getElementById('ketonesInput');
const urinalysisDate = document.getElementById('urinalysisDate');

// --- COPD Elements ---
const breathlessnessCheckbox = document.getElementById('breathlessnessCheckbox');
const chronicCoughCheckbox = document.getElementById('chronicCoughCheckbox');
const sputumCheckbox = document.getElementById('sputumCheckbox');
const wheezingCheckbox = document.getElementById('wheezingCheckbox');


const familyIdStorage = document.getElementById('familyIdStorage');


const formSteps = document.querySelectorAll('.form-step');
const progressSteps = document.querySelectorAll('ol li');
const cancelButton = document.getElementById('cancel-button-add-resident');
const prevButton = document.getElementById('prev-button');
const nextButton = document.getElementById('next-button');
const addResidentButtonSubmit = document.getElementById('add-resident-button');
let currentStep = 0;
const confirmResidentModalEl = document.getElementById('confirm-add-resident-modal');
const residentInfoReviewContainer = document.getElementById('resident-info-review');
const reviewFullName = document.getElementById('review-full-name');
const reviewBirthdateAge = document.getElementById('review-birthdate-age');
const reviewSex = document.getElementById('review-sex');
const reviewContact = document.getElementById('review-contact');
const reviewCivilStatus = document.getElementById('review-civil-status');
const reviewReligion = document.getElementById('review-religion');
const reviewHousehold = document.getElementById('review-household');
const reviewRelationship = document.getElementById('review-relationship');
const reviewEmployment = document.getElementById('review-employment');
const reviewPwd = document.getElementById('review-pwd');
const confirmResidentCheckbox = document.getElementById('confirm-resident-checkbox');
const cancelConfirm = document.getElementById('cancel-add-resident-confirm');
const confirmAddResidentSubmitBtn = document.getElementById('confirm-resident-proceed-button');
const openAddResidentBtn = document.getElementById('openAddResidentModal');

const confirmResidentModal = new Modal(confirmResidentModalEl,{backdrop: 'static',closable: true,});
const addResidentModal = new Modal(addResidentModalEl,{backdrop: 'static',closable: true,});



// A function to update the UI based on the current step
function updateUI(direction) {
    // First, handle the transition out of the current form step
    const previousStepIndex = currentStep;
    const newStepIndex = currentStep + (direction === 'next' ? 1 : -1);

    const currentFormStep = formSteps[previousStepIndex];
    const newFormStep = formSteps[newStepIndex];

    // Animate the current step out
    currentFormStep.classList.add(direction === 'next' ? '-translate-x-full' : 'translate-x-full');
    currentFormStep.classList.remove('translate-x-0');

    // Animate the new step in
    newFormStep.classList.remove('hidden');
    newFormStep.classList.add(direction === 'next' ? 'translate-x-full' : '-translate-x-full');

    // Wait for the transition to finish
    setTimeout(() => {
        currentStep = newStepIndex;

        // Hide the old step after it has transitioned out
        currentFormStep.classList.add('hidden');
        currentFormStep.classList.remove('-translate-x-full', 'translate-x-full');

        // Position the new step to its final state
        newFormStep.classList.remove(direction === 'next' ? 'translate-x-full' : '-translate-x-full');

        // Reapply styling for all elements from scratch to ensure consistency
        applyStyling();

    }, 500); // The duration of the CSS transition
}


function validateForm() {
    // --- CHECK ALL REQUIRED TEXT INPUTS ---
    // Use .trim() to ensure fields with only spaces are considered empty.
    const areTextInputsValid =
        residentFirstName.value.trim() !== '' &&
        residentLastName.value.trim() !== '' &&
        residentContactNo.value.trim() !== '' && // Included as per your instructions
        relationshipToHead.value.trim() !== ''; // Included as per your instructions

    // --- CHECK DATE PICKER ---
    const isBirthdateValid = residentBirthdate.value.trim() !== '';

    // --- CHECK ALL REQUIRED DROPDOWNS ---
    // Checks if the button's text is different from its default placeholder.
    const areDropdownsValid =
        residentSexDropdown.textContent.trim() !== 'Select Sex' &&
        //(familyDropdown ? familyDropdown.textContent.trim() !== 'Choose Family' : true) && // Check if exists first
        civilStatusDropdown.textContent.trim() !== 'Select Civil Status' &&
        religionDropdown.textContent.trim() !== 'Select Religion' &&
        (ethnicityDropdown ? ethnicityDropdown.textContent.trim() !== 'Select Ethnicity' : true) && // Check if exists first
        employmentStatusDropdown.textContent.trim() !== 'Select Employment Status' &&
        (pwdStatusDropdown ? pwdStatusDropdown.textContent.trim() !== 'Select' : true) && // Check if exists first
        (indigenousStatusDropdown ? indigenousStatusDropdown.textContent.trim() !== 'Select' : true); // Check if exists first

    console.log(areTextInputsValid, isBirthdateValid, areDropdownsValid);
    // Return true only if all checks pass
    return areTextInputsValid && isBirthdateValid && areDropdownsValid;
}

function updateButtonState() {
    if (validateForm()) {
        // If the form is valid, enable the button and remove disabled styles
        nextButton.disabled = false;
        nextButton.classList.remove('opacity-50', 'cursor-not-allowed');
    } else {
        // If the form is invalid, disable the button and add disabled styles
        nextButton.disabled = true;
        nextButton.classList.add('opacity-50', 'cursor-not-allowed');
    }
}

// --- 3. EVENT LISTENERS ---

// An array of all text/date inputs that need to be checked
const fieldsToMonitor = [
    residentFirstName,
    residentLastName,
    residentMiddleName,
    residentContactNo,
    residentBirthdate,
    relationshipToHead
];

// Attach an 'input' listener to each field. It fires every time the user types.
fieldsToMonitor.forEach(field => {
    if (field) { // Check if the element exists on the page
        field.addEventListener('input', updateButtonState);
    }
});

// Helper function to handle validation for Flowbite's custom dropdowns
function setupDropdownValidation(buttonElement) {
    if (!buttonElement) return; // Skip if the button doesn't exist

    // The menu is the next element after the button in your HTML
    const menuElement = buttonElement.nextElementSibling;
    if (!menuElement) return;

    const options = menuElement.querySelectorAll('button[data-value]');
    options.forEach(option => {
        option.addEventListener('click', () => {
            // Update the main button's text with the selected value
            buttonElement.childNodes[0].nodeValue = option.dataset.value + ' ';

            // Use a short timeout to ensure the DOM updates before we re-validate
            setTimeout(updateButtonState, 50);
        });
    });
}



addResidentButtonSubmit.addEventListener('click', function () {
    // --- 1. GATHER DATA FROM THE FORM ---

    // Construct the full name, handling optional middle name and suffix
    let fullName = residentLastName.value.trim() + ', ' + residentFirstName.value.trim();
    if (residentMiddleName.value.trim()) {
        fullName += ' ' + residentMiddleName.value.trim();
    }
    if (suffixDropdown.textContent.trim() !== 'Select') {
        fullName += ' ' + suffixDropdown.textContent.trim();
    }

    // Combine birthdate and age
    const birthdateAndAge = `${residentBirthdate.value} (${residentAge.value})`;

    // Get values from other fields
    const sex = residentSexDropdown.textContent.trim();
    const contact = residentContactNo.value.trim();
    const civilStatus = civilStatusDropdown.textContent.trim();
    const religion = religionDropdown.textContent.trim();
    const household = `${householdIdDisplay.value} / ${purokDisplay.value}`;
    const relationship = relationshipToHead.value.trim();
    const employment = employmentStatusDropdown.textContent.trim();
    const pwdStatus = pwdStatusDropdown.textContent.trim();


    // --- 2. POPULATE THE CONFIRMATION MODAL ---

    // Update the review section
    reviewFullName.textContent = fullName;
    reviewBirthdateAge.textContent = birthdateAndAge;
    reviewSex.textContent = sex;
    reviewContact.textContent = contact;
    reviewCivilStatus.textContent = civilStatus;
    reviewReligion.textContent = religion;
    reviewHousehold.textContent = household;
    reviewRelationship.textContent = relationship;
    reviewEmployment.textContent = employment;
    reviewPwd.textContent = pwdStatus;


    currentResidentPayload = {
        firstName: residentFirstName.value.trim(),
        lastName: residentLastName.value.trim(),
        middleName: residentMiddleName.value.trim() ? residentMiddleName.value.trim() : null,
        suffix: suffixDropdown.textContent.trim() !== "Select" ? suffixDropdown.textContent.trim() : null,
        contactNo: residentContactNo.value.trim(),
        birthDate: residentBirthdate.value.trim(),
        sex: residentSexDropdown.textContent.trim(),
        familyId: chosenFamily.id,
        familyRelationship: relationshipToHead.value.trim(),
        civilStatus: civilStatus,
        religion: religion,
        ethnicity: ethnicityDropdown.textContent.trim(),
        employmentStatus: employment,
        isPWD: pwdStatusDropdown.textContent === "Yes" ? true : false,
        pwdIdInput: pwdIdInput.value.trim(),
        isIndegenous: indigenousStatusDropdown.textContent === "Yes" ? true : false,
        emergencyContactNo: emergencyContactNo.value.trim(),

        redFlags: {
            hasChestPain: chestPainCheckbox.checked,
            hasBreathingDifficulty: breathingDifficultyCheckbox.checked,
            hasLossOfConsciousness: lossOfConsciousnessCheckbox.checked,
            hasNumbArm: numbArmCheckbox.checked,
            hasSelfHarm: selfHarmCheckbox.checked,
            hasAggressiveBehavior: aggressiveBehaviorCheckbox.checked,
            hasSevereInjuries: severeInjuriesCheckbox.checked,
            hasSlurredSpeech: slurredSpeechCheckbox.checked,
            hasFacialAsymmetry: facialAsymmetryCheckbox.checked,
            hasChestRetractions: chestRetractionsCheckbox.checked,
            hasSeizure: seizureCheckbox.checked,
            isDisoriented: disorientedCheckbox.checked,
            hasEyeInjury: eyeInjuryCheckbox.checked
        },

        medHistory: {
            hasHypertension: hypertensionCheckbox.checked,
            hasHeartDiseases: heartDiseasesCheckbox.checked,
            hasCopd: copdCheckbox.checked,
            hasSurgicalHistory: surgicalHistoryCheckbox.checked,
            hasAllergies: allergiesCheckbox.checked,
            hasDiabetes: diabetesCheckbox.checked,
            hasCancer: cancerCheckbox.checked,
            hasAsthma: asthmaCheckbox.checked,
            hasKidneyDisorders: kidneyDisordersCheckbox.checked,
            hasVisionProblems: visionProblemsCheckbox.checked,
            hasThyroidDisorders: thyroidDisordersCheckbox.checked,
            hasMentalDisorders: mentalDisordersCheckbox.checked
        },

        familyHistory: {
            hasHypertension: familyHypertensionCheckbox.checked,
            hasHeartDiseases: familyHeartDiseasesCheckbox.checked,
            hasCopd: familyCopdCheckbox.checked,
            hasTuberculosis: familyTuberculosisCheckbox.checked,
            hasStroke: familyStrokeCheckbox.checked,
            hasDiabetes: familyDiabetesCheckbox.checked,
            hasCancer: familyCancerCheckbox.checked,
            hasAsthma: familyAsthmaCheckbox.checked,
            hasKidneyDisorders: familyKidneyDisordersCheckbox.checked,
            hasCoronaryDisease: familyCoronaryDiseaseCheckbox.checked,
            hasMentalDisorders: familyMentalDisordersCheckbox.checked
        },


       ncd_factors: {
            tobaccoUse: tobaccoDropdown.textContent.trim() ? tobaccoDropdown.textContent.trim() : null,
            alcoholConsumption: alcoholDropdown.textContent.trim() ? alcoholDropdown.textContent.trim() : null,
            alcoholFrequency: alcoholNumDropdown.textContent.trim() ? alcoholNumDropdown.textContent.trim() : null,
            caffeineIntake: caffeineDropdown.textContent.trim() ? caffeineDropdown.textContent.trim() : null,
            physicalActivity: physicalActivityInput.value.trim() ? physicalActivityInput.value.trim() : null,
            weightKg: weightInput.value.trim() ? weightInput.value.trim() : null,
            heightCm: heightInput.value.trim() ? heightInput.value.trim() : null,
            bmi: bmiInput.value.trim() ? bmiInput.value.trim() : null,
            waistCircumferenceCm: waistCircumferenceInput.value.trim() ? waistCircumferenceInput.value.trim() : null,
            bpSystolic: systolicInput.value.trim() ? systolicInput.value.trim() : null,
            bpDiastolic: diastolicInput.value.trim() ? diastolicInput.value.trim() : null,
            eatsHighFatFood: highFatFoodCheckbox.checked,
            eatsStreetFood: streetFoodCheckbox.checked,
            eatsHighSugarFood: highSugarFoodCheckbox.checked
        },

        risk_assessment: {
            bloodSugar: {
                fbsResult: fbsResultInput.value.trim() ? fbsResultInput.value.trim() : null,
                rbsResult: rbsResultInput.value.trim() ? rbsResultInput.value.trim() : null,
                dateTaken: bloodSugarDate.value.trim() ? bloodSugarDate.value.trim() : null,
                hasPolyphagia: polyphagiaCheckbox.checked,
                hasPolydipsia: polydipsiaCheckbox.checked,
                hasPolyuria: polyuriaCheckbox.checked
            },
            lipidProfile: {
                totalCholesterol: totalCholesterolInput.value.trim() ? totalCholesterolInput.value.trim() : null,
                hdl: hdlInput.value.trim() ? hdlInput.value.trim() : null,
                ldl: ldlInput.value.trim() ? ldlInput.value.trim() : null,
                vldl: vldlInput.value.trim() ? vldlInput.value.trim() : null,
                triglyceride: triglycerideInput.value.trim() ? triglycerideInput.value.trim() : null,
                dateTaken: lipidDate.value.trim() ? lipidDate.value.trim() : null
            },
            urinalysis: {
                protein: proteinInput.value.trim() ? proteinInput.value.trim() : null,
                ketones: ketonesInput.value.trim() ? ketonesInput.value.trim() : null,
                dateTaken: urinalysisDate.value.trim() ? urinalysisDate.value.trim() : null
            },
            copdAssessment: {
                hasBreathlessness: breathlessnessCheckbox.checked,
                hasChronicCough: chronicCoughCheckbox.checked,
                hasSputum: sputumCheckbox.checked,
                hasWheezing: wheezingCheckbox.checked
            }
        }
    };

    console.log(currentResidentPayload);
    // --- 3. HIDE THE CURRENT MODAL AND SHOW THE CONFIRMATION MODAL ---

    addResidentModal.hide(); // Hide the form modal
    confirmResidentModal.show(); // Show the now-populated confirmation modal
});

cancelConfirm.addEventListener('click', function () {
    confirmResidentModal.hide();
    addResidentModal.show();
});

confirmResidentCheckbox.addEventListener('change', function () {
    confirmAddResidentSubmitBtn.disabled = !this.checked;
});

confirmAddResidentSubmitBtn.addEventListener('click', function () {
    fetch('/barangay/resident/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(currentResidentPayload)
    })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) {
                // Laravel returned a 422 or other error
                console.error('Validation failed:', data.errors);
                return;
            }
            console.log('Response from backend:', data);

            if(data.status === 'success'){
                let fullName = residentLastName.value.trim() + ', ' + residentFirstName.value.trim();
                if (residentMiddleName.value.trim()) {
                    fullName += ' ' + residentMiddleName.value.trim();
                }
                if (suffixDropdown.textContent.trim() !== 'Select') {
                    fullName += ' ' + suffixDropdown.textContent.trim();
                }

                confirmResidentModal.hide();
                successMesageHeader.textContent = "Resident Added";
                successMessage.textContent = fullName + " has been addded.";
                successModal.show();
            }
        })
        .catch(err => console.error('Error:', err));
});

closeSuccessModalButton.addEventListener('click', function(){
    window.location.reload();
});


*/