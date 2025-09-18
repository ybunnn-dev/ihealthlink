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
const familyIdHolder = document.getElementById('familyIdHolder'); // Hidden div to store selected family ID
const familyDropdown = document.getElementById('familyDropdown');
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

//form 3 input fields
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

//form 4 input fields
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



// Select all the form steps and progress indicator items
const formSteps = document.querySelectorAll('.form-step');
const progressSteps = document.querySelectorAll('ol li');

// Select the navigation buttons
const cancelButton = document.getElementById('cancel-button-add-resident');
const prevButton = document.getElementById('prev-button');
const nextButton = document.getElementById('next-button');
const addResidentButtonSubmit = document.getElementById('add-resident-button');

// Initialize the current step
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

const cancelConfirm = document.getElementById('cancel-add-resident-confirm');
const openAddResidentBtn = document.getElementById('openAddResidentModal');

const confirmResidentModal = new Modal(confirmResidentModalEl);
const addResidentModal = new Modal(addResidentModalEl);

openAddResidentBtn.addEventListener('click', function(){
    addResidentModal.show();
});

cancelButton.addEventListener('click', function(){
    addResidentModal.hide();
});
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

// A separate function to handle all UI styling updates
function applyStyling() {
    // Hide all form steps and labels
    formSteps.forEach(step => step.classList.add('hidden'));
    progressSteps.forEach(step => {
        const labelSpan = step.querySelector('.text-start');
        if (labelSpan) {
            labelSpan.classList.add('hidden');
        }
    });

    // Show the current form step
    formSteps[currentStep].classList.remove('hidden');

    // Update progress bar styles for completed and current steps
    progressSteps.forEach((step, index) => {
        // Reset all progress step styles
        step.classList.remove('text-blue-600', 'dark:text-blue-500', 'after:border-blue-600', 'after:dark:border-blue-500');
        const numSpan = step.querySelector('span:first-child span');
        if (numSpan) {
            numSpan.classList.remove('bg-nav_active', 'text-mainblue');
            numSpan.classList.add('bg-gray-100', 'text-main_font');
        }

        if (index <= currentStep) {
            // Apply active styles to steps up to the current one
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

    // Show ONLY the label for the active step
    const currentLabel = progressSteps[currentStep].querySelector('.text-start');
    if (currentLabel) {
        currentLabel.classList.remove('hidden');
    }

    // Manage button visibility
    prevButton.style.display = currentStep === 0 ? 'none' : 'block';
    cancelButton.style.display = currentStep > 0 ? 'none' : 'block';
    nextButton.style.display = currentStep === formSteps.length - 1 ? 'none' : 'block';
    addResidentButtonSubmit.style.display = currentStep === formSteps.length - 1 ? 'block' : 'none';
}


// Event listeners
nextButton.addEventListener('click', () => {
    if (currentStep < formSteps.length - 1) {
        updateUI('next');
    }
});

prevButton.addEventListener('click', () => {
    if (currentStep > 0) {
        updateUI('prev');
    }
});

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

// An array of all dropdown buttons that need validation
const dropdownsToMonitor = [
    residentSexDropdown,
    familyDropdown,
    civilStatusDropdown,
    religionDropdown,
    ethnicityDropdown,
    employmentStatusDropdown,
    pwdStatusDropdown,
    indigenousStatusDropdown
];

// Attach the validation logic to each required dropdown
dropdownsToMonitor.forEach(setupDropdownValidation);

function calculateAge(birthdateString) {
    // If the input is empty, return an empty string to clear the age field
    if (!birthdateString) {
        return '';
    }

    const today = new Date();
    const birthDate = new Date(birthdateString);

    // Check for an invalid date (e.g., user types "abc")
    if (isNaN(birthDate.getTime())) {
        return '';
    }

    // Check if the selected date is in the future
    if (birthDate > today) {
        // You can also show an error message here if you prefer
        return 0;
    }

    // Calculate the initial age difference in years
    let age = today.getFullYear() - birthDate.getFullYear();

    // Adjust the age if the birthday hasn't occurred yet this year
    const monthDifference = today.getMonth() - birthDate.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    return age;
}

// --- Event Listener ---
// This listens for the 'changeDate' event from the Flowbite datepicker.
// It will trigger the calculation whenever a date is selected.
residentBirthdate.addEventListener('changeDate', (event) => {
    // Get the selected date from the input's value
    const birthdateValue = residentBirthdate.value;

    // Calculate the age using the helper function
    const age = calculateAge(birthdateValue);

    // Update the 'Age' input field with the result
    residentAge.value = age;
});


addResidentButtonSubmit.addEventListener('click', function() {
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
    
    
    // --- 3. HIDE THE CURRENT MODAL AND SHOW THE CONFIRMATION MODAL ---
    
    addResidentModal.hide(); // Hide the form modal
    confirmResidentModal.show(); // Show the now-populated confirmation modal
});

cancelConfirm.addEventListener('click', function(){
    confirmResidentModal.hide();
    addResidentModal.show();
});

// Initial setup: Call applyStyling() to set the correct state on page load.
updateButtonState();
applyStyling();
