// --- Element Selection ---
const availableBarangay = window.emptyBarangay || [];
const submitButton = document.getElementById('addMidwifeSubmitBtn');
const birthdateInput = document.getElementById('midwifeBdate');
const ageInput = document.getElementById('midwifeAge');

const textInputs = [
    document.getElementById('midwifeFirstName'),
    document.getElementById('midwifeLastName'),
    document.getElementById('contactNo')
];

const dropdownButtons = [
    document.getElementById('sexDropdown'),
    document.getElementById('civilStatusDropdown'),
    document.getElementById('religionDropdown'),
    document.getElementById('barangayDropdown')
];

const allDropdowns = [...dropdownButtons, document.getElementById('prefixDropdown')];

// --- Setup Age Input ---
ageInput.disabled = true;
ageInput.classList.add('bg-gray-100');

// --- Populate Barangay Dropdown ---
const populateBarangayDropdown = () => {
    const menu = document.getElementById('barangayDropdownMenu');
    if (!menu) return;
    
    const list = menu.querySelector('ul');
    if (!list) return;
    
    list.innerHTML = '';
    
    if (availableBarangay.length > 0) {
        availableBarangay.forEach(barangay => {
            const listItem = document.createElement('li');
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = barangay.name;
            button.dataset.id = barangay.id;
            button.className = 'w-full text-left px-4 py-2 hover:bg-gray-100';
            listItem.appendChild(button);
            list.appendChild(listItem);
        });
    } else {
        const listItem = document.createElement('li');
        listItem.textContent = 'No available barangays';
        listItem.className = 'px-4 py-2 text-sm text-gray-500';
        list.appendChild(listItem);
    }
};

// --- Validation ---
const validateForm = () => {
    const allInputsFilled = textInputs.every(input => input.value.trim() !== '') && 
                           birthdateInput.value.trim() !== '';
    
    const allDropdownsSelected = dropdownButtons.every(button => {
        return !button.textContent.trim().startsWith('Select');
    });
    
    submitButton.disabled = !(allInputsFilled && allDropdownsSelected);
};

// --- Age Calculation ---
const calculateAndSetAge = () => {
    const birthDateString = birthdateInput.value;
    
    if (!birthDateString) {
        ageInput.value = '';
        validateForm();
        return;
    }
    
    const birthDate = new Date(birthDateString);
    const today = new Date();
    
    if (isNaN(birthDate.getTime()) || birthDate > today) {
        ageInput.value = '';
        validateForm();
        return;
    }
    
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDifference = today.getMonth() - birthDate.getMonth();
    
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    
    ageInput.value = age;
    validateForm();
};

// --- Dropdown Setup ---
const setupDropdown = (button) => {
    const menuId = button.getAttribute('data-dropdown-toggle');
    const menu = document.getElementById(menuId);
    if (!menu) return;
    
    const options = menu.querySelectorAll('ul li button');
    options.forEach(option => {
        option.addEventListener('click', () => {
            button.textContent = option.textContent.trim();
            if (option.dataset.id) {
                button.dataset.selectedId = option.dataset.id;
            }
            validateForm();
        });
    });
};

// --- Event Listeners ---
populateBarangayDropdown();

textInputs.forEach(input => {
    input.addEventListener('input', validateForm);
});

// Multiple event listeners for birthdate to support different datepicker types
birthdateInput.addEventListener('change', calculateAndSetAge);
birthdateInput.addEventListener('input', calculateAndSetAge);
birthdateInput.addEventListener('changeDate', calculateAndSetAge); // Bootstrap datepicker

allDropdowns.forEach(setupDropdown);

// --- Form Submission ---
const getDropdownValue = (elementId) => {
    const element = document.getElementById(elementId);
    const text = element.textContent.trim();
    return text.startsWith('Select') ? null : text;
};

submitButton.addEventListener('click', function(event) {
    event.preventDefault();
    
    const payload = {
        firstName: document.getElementById('midwifeFirstName').value.trim(),
        lastName: document.getElementById('midwifeLastName').value.trim(),
        middleName: document.getElementById('midwifeMiddleName').value.trim() || null,
        suffix: getDropdownValue('prefixDropdown'),
        birthdate: birthdateInput.value.trim(),
        age: ageInput.value.trim(),
        sex: getDropdownValue('sexDropdown'),
        civilStatus: getDropdownValue('civilStatusDropdown'),
        religion: getDropdownValue('religionDropdown'),
        contactNo: document.getElementById('contactNo').value.trim(),
        barangayId: document.getElementById('barangayDropdown').dataset.selectedId || null
    };
    console.table(payload);
});

// Initial validation
validateForm();