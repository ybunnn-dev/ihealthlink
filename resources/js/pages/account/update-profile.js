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

// Profile Update Modal Elements
const confirmProfileModal = document.getElementById('confirm-update-profile-modal');
const confirmProfileCheckbox = document.getElementById('confirm-profile-checkbox');
const confirmProfileBtn = document.getElementById('confirm-profile-btn');
const cancelProfileBtn = document.getElementById('cancel-profile-update');
const showProfileModalBtn = document.getElementById('show-profile-update-modal-btn');

const confirmProfileUpdate = new Modal(confirmProfileModal, createModalOptions(confirmProfileModal));

// Show modal when Save button is clicked
showProfileModalBtn.addEventListener('click', (e) => {
    e.preventDefault();
    confirmProfileUpdate.show();
});

// Enable confirm button only when checkbox is checked
confirmProfileCheckbox.addEventListener('change', (e) => {
    confirmProfileBtn.disabled = !e.target.checked;
});

// When confirm button is clicked, submit via Livewire
confirmProfileBtn.addEventListener('click', () => {
    if (confirmProfileCheckbox.checked) {
        const livewireComponent = showProfileModalBtn.closest('[wire\\:id]');
        if (livewireComponent) {
            Livewire.find(livewireComponent.getAttribute('wire:id')).call('updateProfileInformation');
        }
        confirmProfileUpdate.hide();
        confirmProfileCheckbox.checked = false;
        confirmProfileBtn.disabled = true;
    }
});

// Cancel button closes modal and resets
cancelProfileBtn.addEventListener('click', () => {
    confirmProfileUpdate.hide();
    confirmProfileCheckbox.checked = false;
    confirmProfileBtn.disabled = true;
});