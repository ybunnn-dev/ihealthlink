document.addEventListener('DOMContentLoaded', () => {
    const formSteps = document.querySelectorAll('.form-step');
    const progressSteps = document.querySelectorAll('ol li');

    const prevButton = document.getElementById('prev-button');
    const nextButton = document.getElementById('next-button');
    const addButton = document.getElementById('add-resident-button');
    const skipButton = document.getElementById('skip-button');
    const cancelButton = document.getElementById('cancel-button');

    let currentStep = 0;

    function updateUI(direction) {
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
        newFormStep.classList.remove('translate-x-0');

        // Allow the transition to happen before showing the next step fully
        setTimeout(() => {
            currentStep = newStepIndex;

            // Hide the old step after it has transitioned out
            currentFormStep.classList.add('hidden');
            currentFormStep.classList.remove('-translate-x-full', 'translate-x-full');

            // Position the new step to its final state
            newFormStep.classList.add('translate-x-0');
            newFormStep.classList.remove(direction === 'next' ? 'translate-x-full' : '-translate-x-full');

            // Update all other UI elements as before
            progressSteps.forEach(step => {
                step.classList.remove('text-blue-600', 'dark:text-blue-500');
                step.classList.remove('after:border-blue-600', 'after:dark:border-blue-500');
                const numSpan = step.querySelector('span:first-child span');
                if (numSpan) {
                    numSpan.classList.remove('bg-nav_active', 'text-mainblue');
                    numSpan.classList.add('bg-gray-100', 'text-main_font');
                }
                const labelSpan = step.querySelector('.text-start');
                if (labelSpan) {
                    labelSpan.classList.add('hidden');
                }
            });

            for (let i = 0; i <= currentStep; i++) {
                const step = progressSteps[i];
                step.classList.add('text-blue-600', 'dark:text-blue-500');
                const numSpan = step.querySelector('span:first-child span');
                if (numSpan) {
                    numSpan.classList.remove('bg-gray-100', 'text-gray-500');
                    numSpan.classList.add('bg-nav_active', 'text-mainblue');
                }
                if (i < currentStep) {
                     step.classList.add('after:border-blue-600', 'after:dark:border-blue-500');
                }
            }
            
            const currentLabel = progressSteps[currentStep].querySelector('.text-start');
            if (currentLabel) {
                currentLabel.classList.remove('hidden');
            }

            prevButton.style.display = currentStep === 0 ? 'none' : 'block';
            cancelButton.style.display = currentStep > 0 ? 'none' : 'block';
            nextButton.style.display = currentStep === formSteps.length - 1 ? 'none' : 'block';
            skipButton.style.display = currentStep === formSteps.length - 1 ? 'none' : 'block';
            addButton.style.display = currentStep === formSteps.length - 1 ? 'block' : 'none';
        }, 500); // Wait for the transition to finish (500ms)
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

    // Initial setup
    function initialSetup() {
        formSteps.forEach(step => step.classList.add('hidden', 'translate-x-full'));
        formSteps[currentStep].classList.remove('hidden', 'translate-x-full');

        progressSteps.forEach(step => {
            const labelSpan = step.querySelector('.text-start');
            if (labelSpan) {
                labelSpan.classList.add('hidden');
            }
        });
        
        const initialLabel = progressSteps[currentStep].querySelector('.text-start');
        if (initialLabel) {
            initialLabel.classList.remove('hidden');
        }
    }
    initialSetup();
});