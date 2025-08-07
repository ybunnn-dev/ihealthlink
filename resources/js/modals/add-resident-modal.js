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

    // Initialize the current step. Your HTML starts at step 6, which is index 5.
    let currentStep = 0;

    // A function to update the UI based on the current step
    function updateUI() {
        // Hide all form steps and reset progress bar styles
        formSteps.forEach(step => step.classList.add('hidden'));
        progressSteps.forEach(step => {
            step.classList.remove('text-blue-600', 'dark:text-blue-500');
            step.classList.remove('after:border-blue-600', 'after:dark:border-blue-500');
            const span = step.querySelector('span:first-child');
            span.classList.remove('bg-nav_active', 'text-white');
            span.classList.add('bg-gray-100', 'text-gray-500');
        });

        // Show the current step
        formSteps[currentStep].classList.remove('hidden');

        // Update progress bar to reflect the current and completed steps
        for (let i = 0; i <= currentStep; i++) {
            const step = progressSteps[i];
            step.classList.add('text-blue-600', 'dark:text-blue-500');
            const span = step.querySelector('span:first-child');
            span.classList.remove('bg-gray-100', 'text-gray-500');
            span.classList.add('bg-nav_active', 'text-white');

            if (i < currentStep) {
                 step.classList.add('after:border-blue-600', 'after:dark:border-blue-500');
            }
        }

        // Manage button visibility
        prevButton.style.display = currentStep === 0 ? 'none' : 'block';
        cancelButton.style.display = currentStep > 0 ? 'none' : 'block';
        nextButton.style.display = currentStep === formSteps.length - 1 ? 'none' : 'block';
        skipButton.style.display = currentStep === formSteps.length - 1 ? 'none' : 'block';
        addButton.style.display = currentStep === formSteps.length - 1 ? 'block' : 'none';
    }

    // Event listeners for navigation buttons
    nextButton.addEventListener('click', () => {
        if (currentStep < formSteps.length - 1) {
            currentStep++;
            updateUI();
        }
    });

    prevButton.addEventListener('click', () => {
        if (currentStep > 0) {
            currentStep--;
            updateUI();
        }
    });

    skipButton.addEventListener('click', () => {
        if (currentStep < formSteps.length - 1) {
            currentStep++;
            updateUI();
        }
    });

    // Initial call to set up the UI when the page loads
    updateUI();
});