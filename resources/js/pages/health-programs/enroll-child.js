const enrollOpen = document.getElementById('openEnrollChildHealthcareModalBtn');

// Main modal container
const enrollChildModalEl = document.getElementById('enroll-child-modal');

// Modal Header Elements
const childModalTitle = document.getElementById('child-modal-title');
const childModalSubtitle = document.getElementById('child-modal-subtitle');

// Step Containers
const childStep1 = document.getElementById('child-step-1');
const childStep2 = document.getElementById('child-step-2');
const childStep3 = document.getElementById('child-step-3');
const steps = [childStep1, childStep2, childStep3];

// Footer Navigation Buttons
const childCancelBtn = document.getElementById('childCancelBtn');
const childBackBtn = document.getElementById('childBackBtn');
const childNextBtn = document.getElementById('childNextBtn');
const childFinishBtn = document.getElementById('childFinishBtn');


const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const enrollChildModal = new Modal(enrollChildModalEl, modalOptions);

// State Management
let currentStep = 1;

// --- IMPORTANT ---
// Remove the 'hidden' class from all steps when the modal is first initialized.
// This allows them to exist in the layout for the transition effect.
steps.forEach(step => {
    // Check if the step exists before trying to modify its class list
    if (step) {
        step.classList.remove('hidden');
    }
});


// Function to update the UI based on the current step
const updateStepUI = () => {
    // Update titles
    if (currentStep === 1) {
        childModalSubtitle.textContent = "Step 1: Select Parent or Guardian";
    } else if (currentStep === 2) {
        childModalSubtitle.textContent = "Step 2: Child's Information";
    } else {
        childModalSubtitle.textContent = "Step 3: Review and Confirm";
    }

    // --- SLIDING TRANSITION LOGIC ---
    // Apply the transform to each step. The CSS 'transition-transform' class will animate the slide.
    steps.forEach((step) => {
        if (step) {
            step.style.transform = `translateX(-${(currentStep - 1) * 100}%)`;
        }
    });

    // Handle button visibility
    childBackBtn.classList.toggle('hidden', currentStep === 1);
    childNextBtn.classList.toggle('hidden', currentStep === 3);
    childFinishBtn.classList.toggle('hidden', currentStep !== 3);
};

// Event Listeners for Navigation
childNextBtn.addEventListener('click', () => {
    if (currentStep < 3) {
        currentStep++;
        updateStepUI();
        childCancelBtn.classList.add('hidden');
    }
});

childBackBtn.addEventListener('click', () => {
    if (currentStep > 1) {
        currentStep--;
        updateStepUI();
        if(currentStep === 1){
            childCancelBtn.classList.remove('hidden');
        }
    }
});

// Function to reset the modal to its initial state
const resetModal = () => {
    currentStep = 1;
    updateStepUI();
    childCancelBtn.classList.remove('hidden'); // Ensure cancel is visible on reset
    // TODO: Add logic here to clear any form fields from step 1, 2, or 3.
    enrollChildModal.hide();
};


enrollOpen.addEventListener('click',function(){
    enrollChildModal.show();
    // Re-run the UI update in case the initial state is needed.
    updateStepUI();
});

// Also reset when the cancel button is clicked
childCancelBtn.addEventListener('click', resetModal);

// Initialize the modal view when the script loads
updateStepUI();
