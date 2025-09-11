// --- Main Elements ---
const addBhwModalEl = document.getElementById('add-bhw-modal');
const addBhwForm = document.getElementById('addBhwForm');

// --- Input Fields ---
const firstNameInput = document.getElementById('bhwFirstName');
const lastNameInput = document.getElementById('bhwLastName');
const middleNameInput = document.getElementById('bhwMiddleName');
const birthdateInput = document.getElementById('bhwBirthdate');
const ageInput = document.getElementById('bhwAge');
const emailInput = document.getElementById('bhwEmail');
const contactNoInput = document.getElementById('bhwContactNo');

// --- Dropdown Buttons and Menus ---
const suffixDropdownButton = document.getElementById('suffixDropdownButton');
const suffixDropdownMenu = document.getElementById('suffixDropdownMenu');
const sexDropdownButton = document.getElementById('sexDropdownButton');
const sexDropdownMenu = document.getElementById('sexDropdownMenu');
const privilegeDropdownButton = document.getElementById('privilegeDropdownButton');
const privilegeDropdownMenu = document.getElementById('privilegeDropdownMenu');
const civilStatusDropdownButton = document.getElementById('civilStatusDropdownButton');
const civilStatusMenu = document.getElementById('civilStatusMenu');
const religionDropdownButton = document.getElementById('religionDropdownButton');
const religionMenu = document.getElementById('religionMenu');

// --- Footer Action Buttons ---
const addBhwCloseButton = document.getElementById('addBhwCloseButton');
const addBhwSubmitButton = document.getElementById('addBhwSubmitButton');

const addBhwConfirmModalEl = document.getElementById('confirm-add-bhw-modal');
const bhwNameToConfirm = document.getElementById('bhw-name-to-confirm');
const confirmBhwCheckbox = document.getElementById('confirm-bhw-checkbox');

// The final confirmation button that is initially disabled
const confirmProceedButton = document.getElementById('confirm-proceed-button');
const cancelConfirmAddBhwButton = document.getElementById('confirm-add-bhw-cancel');

// --- Modal Initialization (Using Flowbite's JS API) ---
const addBhwModal = new Modal(addBhwModalEl);
const addBhwConfirmModal = new Modal(addBhwConfirmModalEl);

const openModalBtn = document.getElementById('open-add-bhw-modal');

// =================================================================
// OPTIMIZED FORM VALIDATION
// =================================================================

// Define all fields that are REQUIRED. Suffix is excluded.
const requiredFields = new Map([
  [firstNameInput, 'input'],
  [lastNameInput, 'input'],
  [middleNameInput, 'input'],
  [birthdateInput, 'input'],
  [ageInput, 'input'],
  [emailInput, 'input'],
  [contactNoInput, 'input'],
  [sexDropdownButton, 'dropdown'],
  [privilegeDropdownButton, 'dropdown'],
  [civilStatusDropdownButton, 'dropdown'],
  [religionDropdownButton, 'dropdown']
]);

// Cache validation state for better performance
let fieldValidationCache = new Map();

// Debounce function to prevent excessive validation calls
const debounce = (func, wait) => {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
};

// Check if a single field is valid
const isFieldValid = (field, fieldType) => {
  if (fieldType === 'dropdown') {
    return field.dataset.selectedValue && field.dataset.selectedValue.trim() !== '';
  } else {
    return field.value.trim() !== '';
  }
};

// Optimized validation function
const validateForm = () => {
  let isFormValid = true;
  
  // Check each required field
  for (const [field, fieldType] of requiredFields) {
    const isValid = isFieldValid(field, fieldType);
    fieldValidationCache.set(field, isValid);
    
    if (!isValid) {
      isFormValid = false;
      // Don't break - we want to cache all field states
    }
  }
  
  // Update submit button state
  addBhwSubmitButton.disabled = !isFormValid;
  
  // Optional: Add visual feedback
  addBhwSubmitButton.classList.toggle('opacity-50', !isFormValid);
  addBhwSubmitButton.classList.toggle('cursor-not-allowed', !isFormValid);
};

// Debounced version for input events
const debouncedValidateForm = debounce(validateForm, 150);

// Quick validation for immediate feedback (dropdowns, date changes)
const quickValidateForm = validateForm;

/**
 * Calculates age based on a direct Date object.
 */
const calculateAndSetAge = (birthDate) => {
  if (!ageInput) return;

  if (!birthDate || isNaN(birthDate.getTime())) {
    ageInput.value = '';
    return;
  }

  const today = new Date();
  let age = today.getFullYear() - birthDate.getFullYear();
  const monthDifference = today.getMonth() - birthDate.getMonth();

  if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }

  ageInput.value = age >= 0 ? age : '';
};

// =================================================================
// EVENT LISTENERS SETUP
// =================================================================

// Birthdate event listener
if (birthdateInput) {
  birthdateInput.addEventListener('changeDate', (event) => {
    const selectedDate = event.detail.date;
    calculateAndSetAge(selectedDate);
    quickValidateForm(); // Immediate validation for date changes
  });
}

// Input field event listeners with debouncing
const textInputs = [firstNameInput, lastNameInput, middleNameInput, emailInput, contactNoInput];

textInputs.forEach(input => {
  if (input) {
    // Use 'input' event for real-time feedback (debounced)
    input.addEventListener('input', debouncedValidateForm);
    
    // Use 'blur' event for immediate validation when field loses focus
    input.addEventListener('blur', quickValidateForm);
  }
});

// =================================================================
// DROPDOWN FUNCTIONALITY
// =================================================================

const setupDropdown = (buttonEl, menuEl) => {
  const buttonTextEl = buttonEl.querySelector('span');
  const placeholderText = buttonTextEl.textContent;

  menuEl.addEventListener('click', (event) => {
    const clickedLi = event.target.closest('li');
    if (!clickedLi) return;

    event.preventDefault();

    const selectedValue = clickedLi.dataset.value;
    const selectedText = clickedLi.textContent;
    
    if (selectedValue === '') {
      buttonTextEl.textContent = placeholderText;
      delete buttonEl.dataset.selectedValue;
    } else {
      buttonTextEl.textContent = selectedText;
      buttonEl.dataset.selectedValue = selectedValue;
    }

    // Immediate validation for dropdown changes
    quickValidateForm();
  });
};

// Initialize all dropdowns
setupDropdown(suffixDropdownButton, suffixDropdownMenu);
setupDropdown(sexDropdownButton, sexDropdownMenu);
setupDropdown(privilegeDropdownButton, privilegeDropdownMenu);
setupDropdown(civilStatusDropdownButton, civilStatusMenu);
setupDropdown(religionDropdownButton, religionMenu);

// =================================================================
// FORM SUBMISSION AND MODAL CONTROLS
// =================================================================

// Modal controls
openModalBtn.addEventListener('click', () => {
  addBhwModal.show();
  // Run validation when modal opens
  setTimeout(quickValidateForm, 100); // Small delay to ensure modal is fully rendered
});

addBhwCloseButton.addEventListener('click', () => {
  addBhwModal.hide();
});

// Remove the conflicting submit button event listener
// The form submission is now handled by the form's submit event

// =================================================================
// INITIALIZATION
// =================================================================
// Optional: Reset form when modal is hidden
addBhwModalEl.addEventListener('hidden.bs.modal', () => {
  addBhwForm.reset();
  
  // Reset all dropdown selections
  [suffixDropdownButton, sexDropdownButton, privilegeDropdownButton, 
   civilStatusDropdownButton, religionDropdownButton].forEach(button => {
    const buttonTextEl = button.querySelector('span');
    const placeholderText = buttonTextEl.getAttribute('data-placeholder') || buttonTextEl.textContent;
    buttonTextEl.textContent = placeholderText;
    delete button.dataset.selectedValue;
  });
  
  // Clear validation cache
  fieldValidationCache.clear();
  
  // Reset button state
  addBhwSubmitButton.disabled = true;
  addBhwSubmitButton.classList.add('opacity-50', 'cursor-not-allowed');
});

addBhwSubmitButton.addEventListener('click', function(){
  event.preventDefault();

  validateForm();
  
  if (!addBhwSubmitButton.disabled) {

    const bhwFullName =
      firstNameInput.value.trim() + " " +
      middleNameInput.value.trim() + " " +
      lastNameInput.value.trim() +
      (suffixDropdownButton.dataset.selectedValue ? " " + suffixDropdownButton.dataset.selectedValue : "");
    
    bhwNameToConfirm.textContent = bhwFullName;
    
    addBhwModal.hide();
    addBhwConfirmModal.show();
  }
  
});

confirmBhwCheckbox.addEventListener('change', function(){
  confirmProceedButton.disabled = !this.checked;
});

const successModalEl = document.getElementById('success-modal');
const successMesageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

const successModal = new Modal(successModalEl);

confirmProceedButton.addEventListener('click', async function() {
    // 1. Provide immediate UI feedback
    const originalButtonText = confirmProceedButton.innerHTML;
    confirmProceedButton.innerHTML = `
        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
        </svg>
        Saving...
    `;
    confirmProceedButton.disabled = true;
    cancelConfirmAddBhwButton.disabled = true;
    const bhwFullName =
      firstNameInput.value.trim() + " " +
      middleNameInput.value.trim() + " " +
      lastNameInput.value.trim() +
      (suffixDropdownButton.dataset.selectedValue ? " " + suffixDropdownButton.dataset.selectedValue : "");

    try {
        const formData = {
            firstName: firstNameInput.value.trim(),
            lastName: lastNameInput.value.trim(),
            middleName: middleNameInput.value.trim(),
            suffix: suffixDropdownButton.dataset.selectedValue || '',
            birthdate: birthdateInput.value,
            age: ageInput.value,
            sex: sexDropdownButton.dataset.selectedValue,
            email: emailInput.value.trim(),
            contactNo: contactNoInput.value.trim(),
            privilege: parseInt(privilegeDropdownButton.dataset.selectedValue, 10),
            civilStatus: civilStatusDropdownButton.dataset.selectedValue,
            religion: religionDropdownButton.dataset.selectedValue
        };

        const response = await fetch('/barangay/bhw/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json', // Good practice to accept JSON
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (!response.ok) {
            // Handle server-side errors (e.g., validation)
            console.error('Server Error:', data);
            // Example: Show an error toast with the message from the server
            // toast.error(data.message || 'Failed to add BHW.');
            throw new Error(data.message || 'An error occurred.');
        }

        // 3. Handle success
        console.log('Success:', data);
        // Example: Show a success toast, close the modal, and refresh the data table
        // toast.success('BHW added successfully!');
        addBhwConfirmModal.hide(); 
        successMesageHeader.textContent = "BHW Created";
        successMessage.textContent = bhwFullName + "has been added as Barangay Health Worker";
        successModal.show();
        // location.reload(); // Or update the table via JS

    } catch (error) {
        // 4. Handle network errors or errors thrown from the response check
        console.error('Fetch Error:', error);
        // Example: Show a generic error toast
        // toast.error('An unexpected error occurred. Please try again.');

    } finally {
        // 5. Always restore the button to its original state
        confirmProceedButton.innerHTML = originalButtonText;
        confirmProceedButton.disabled = false;
        cancelConfirmAddBhwButton.disabled = false;
    }
});

cancelConfirmAddBhwButton.addEventListener('click',function(){
  addBhwConfirmModal.hide();
  addBhwModal.show();
});

closeSuccessModalButton.addEventListener('click', function(){
  window.location.reload();
});

validateForm();