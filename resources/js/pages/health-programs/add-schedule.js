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
            
            // Handle dark mode modal content
            const modalContent = modalEl.querySelector('.relative.bg-white, .relative.dark\\:bg-gray-700, .relative.dark\\:bg-gray-800');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    },
    onHide: () => {
        modalEl.classList.add('opacity-0');
        modalEl.classList.remove('opacity-100');
        
        // Handle dark mode modal content
        const modalContent = modalEl.querySelector('.relative.bg-white, .relative.dark\\:bg-gray-700, .relative.dark\\:bg-gray-800');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
    }
});

// ====================================================================
// GET ELEMENTS
// ====================================================================

// --- Add Schedule Modal ---
const addScheduleModalEl = document.getElementById('add-schedule-modal');
const addScheduleForm = document.getElementById('add-schedule-form');
const addScheduleTitle = document.getElementById('add-schedule-title');
const addScheduleIntervals = document.getElementById('add-schedule-intervals');
const addSchedulePosition = document.getElementById('add-schedule-position');
const cancelAddScheduleBtn = document.getElementById('cancel-add-schedule');
const addScheduleSubmitBtn = document.getElementById('add-schedule-submit');

// --- Confirm Add Schedule Modal ---
const confirmAddScheduleModalEl = document.getElementById('confirm-add-schedule-modal');
const scheduleTitleToConfirm = document.getElementById('schedule-title-to-confirm');
const confirmScheduleCheckbox = document.getElementById('confirm-schedule-checkbox');
const confirmScheduleProceedBtn = document.getElementById('confirm-schedule-proceed-button');
const cancelAddScheduleConfirmBtn = document.getElementById('cancel-confirm-sched');

// --- Success Modal (as per your example structure) ---
const successModalEl = document.getElementById('success-modal');
const successMessageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

// ====================================================================
// CREATE MODAL INSTANCES
// ====================================================================
const addScheduleModal = new Modal(addScheduleModalEl, createModalOptions(addScheduleModalEl));
const confirmAddScheduleModal = new Modal(confirmAddScheduleModalEl, createModalOptions(confirmAddScheduleModalEl));
const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

const addSchedBtn = document.getElementById('page-add-field-button');



addSchedBtn.addEventListener('click', function(){
    addScheduleModal.show();
});

cancelAddScheduleBtn.addEventListener('click', function(){
    addScheduleModal.hide();
});