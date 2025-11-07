// ====================================================================
// MODAL OPTIONS WITH FADE ANIMATIONS
// ====================================================================
const createModalOptions = (modalEl) => ({
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
    onShow: () => {
        setTimeout(() => {
            modalEl.classList.remove('opacity-0');
            modalEl.classList.add('opacity-100');
            
            const modalContent = modalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        modalEl.classList.add('opacity-0');
        modalEl.classList.remove('opacity-100');
        
        const modalContent = modalEl.querySelector('.relative.bg-white');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
});

// ====================================================================
// GET ELEMENTS
// ====================================================================
const editHealthProgramModalEl = document.getElementById('edit-health-program-modal');
const confirmEditProgramModalEl = document.getElementById('confirm-edit-program-modal');

const editProgramName = document.getElementById('edit-program-name');
const editMinAge = document.getElementById('edit-min-age');
const editMaxAge = document.getElementById('edit-max-age');
const editProgramType = document.getElementById('edit-program-type');

const cancelEditHealthProgramBtn = document.getElementById('cancel-edit-health-program');
const editHealthProgramSubmitBtn = document.getElementById('edit-health-program-submit');

const cancelEditProgramConfirmBtn = document.getElementById('cancel-edit-program-confirm');
const confirmEditProceedBtn = document.getElementById('confirm-edit-proceed-button');
const confirmEditCheckbox = document.getElementById('confirm-edit-program-checkbox');

const openModal = document.getElementById('edit-program-button');
const program = window.program;

// ====================================================================
// CREATE MODAL INSTANCES
// ====================================================================
const editHealthProgramModal = new Modal(editHealthProgramModalEl, createModalOptions(editHealthProgramModalEl));
const confirmEditProgramModal = new Modal(confirmEditProgramModalEl, createModalOptions(confirmEditProgramModalEl));

// ====================================================================
// AUTOFILL FORM WITH 4 FIELDS ONLY
// ====================================================================
function autofillEditForm(programData) {
    editProgramName.value = programData.name || '';
    editMinAge.value = programData.age_min || '';
    editMaxAge.value = programData.age_max || '';
    editProgramType.value = programData.category || '';
}

// ====================================================================
// EVENT LISTENERS
// ====================================================================
openModal.addEventListener('click', function() {
    if (program && typeof program === 'object') {
        autofillEditForm(program);
        editHealthProgramModal.show();
    } else {
        console.error('Program data not available:', program);
    }
});

cancelEditHealthProgramBtn.addEventListener('click', function() {
    editHealthProgramModal.hide();
});

editHealthProgramSubmitBtn.addEventListener('click', function(event) {
    event.preventDefault();
    
    const programName = editProgramName.value.trim();
    const minAge = editMinAge.value;
    const maxAge = editMaxAge.value;
    const programType = editProgramType.value;
    
    // Validation
    if (!programName || !minAge || !maxAge || !programType) {
        alert('Please fill in all required fields.');
        return;
    }
    
    // Reset confirmation checkbox and disable button
    confirmEditCheckbox.checked = false;
    confirmEditProceedBtn.disabled = true;
    
    // Transition to confirmation modal
    editHealthProgramModal.hide();
    confirmEditProgramModal.show();
});

confirmEditCheckbox.addEventListener('change', function() {
    confirmEditProceedBtn.disabled = !this.checked;
});

cancelEditProgramConfirmBtn.addEventListener('click', function() {
    confirmEditProgramModal.hide();
    editHealthProgramModal.show();
});

confirmEditProceedBtn.addEventListener('click', function() {
    const programName = editProgramName.value.trim();
    const minAge = editMinAge.value;
    const maxAge = editMaxAge.value;
    const programType = editProgramType.value;
    
    const payload = {
        name: programName,
        age_min: minAge,
        age_max: maxAge,
        category: programType
    };
    
    console.log('Sending payload:', payload);
    
    // TODO: Send to backend
    // fetch(`/barangay/health-programs/${program.id}`, {
    //     method: 'PUT',
    //     headers: {
    //         'Content-Type': 'application/json',
    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    //     },
    //     body: JSON.stringify(payload)
    // })
});
