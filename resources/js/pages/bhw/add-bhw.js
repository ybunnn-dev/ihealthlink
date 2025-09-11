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

confirmProceedButton.addEventListener('click', function() {
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
        privilege: privilegeDropdownButton.dataset.selectedValue,
        civilStatus: civilStatusDropdownButton.dataset.selectedValue,
        religion: religionDropdownButton.dataset.selectedValue
    };

    console.log('Form Data:', formData);

    fetch('/barangay/bhw/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Server Response:', data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

cancelConfirmAddBhwButton.addEventListener('click',function(){
  addBhwConfirmModal.hide();
  addBhwModal.show();
});

validateForm();