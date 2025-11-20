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

const confirmPasswordModal = document.getElementById('confirm-update-password-modal');
const confirmPasswordCheckbox = document.getElementById('confirm-password-checkbox');
const confirmPasswordBtn = document.getElementById('confirm-password-btn');
const cancelPasswordBtn = document.getElementById('cancel-change-pass');
const showPasswordModalBtn = document.getElementById('show-password-modal-btn');

const confirmPassword = new Modal(confirmPasswordModal, createModalOptions(confirmPasswordModal));

// Show modal when Save button is clicked
showPasswordModalBtn.addEventListener('click', (e) => {
    e.preventDefault();
    confirmPassword.show();
});

// Enable confirm button only when checkbox is checked
confirmPasswordCheckbox.addEventListener('change', (e) => {
    confirmPasswordBtn.disabled = !e.target.checked;
});

// When confirm button is clicked, submit the form via Livewire
confirmPasswordBtn.addEventListener('click', () => {
    if (confirmPasswordCheckbox.checked) {
        Livewire.find(showPasswordModalBtn.closest('[wire\\:id]').getAttribute('wire:id')).call('updatePassword');
        confirmPassword.hide();
        confirmPasswordCheckbox.checked = false;
    }
});

// Cancel button closes modal
cancelPasswordBtn.addEventListener('click', () => {
    confirmPassword.hide();
    confirmPasswordCheckbox.checked = false;
});
