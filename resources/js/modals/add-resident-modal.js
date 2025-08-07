document.addEventListener('DOMContentLoaded', () => {
    // Select all the form steps and progress indicator items
    const formSteps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('ol li');

    // Select the navigation buttons
    const cancelButton = document.getElementById('cancel-button');
    const prevButton = document.getElementById('prev-button');
    const nextButton = document.getElementById('next-button');
    const addButton = document.getElementById('add-resident-button');
    const skipButton = document.getElementById('skip-button');

    // Initialize the current step
    let currentStep = 0;

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
        skipButton.style.display = currentStep === formSteps.length - 1 ? 'none' : 'block';
        addButton.style.display = currentStep === formSteps.length - 1 ? 'block' : 'none';
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

    skipButton.addEventListener('click', () => {
        if (currentStep < formSteps.length - 1) {
            updateUI('next');
        }
    });

    // Initial setup: Call applyStyling() to set the correct state on page load.
    applyStyling();
});