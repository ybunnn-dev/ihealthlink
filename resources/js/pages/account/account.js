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

// ============================================
// PASSWORD UPDATE CONFIRMATION MODAL
// ============================================
const confirmPasswordModal = document.getElementById('confirm-update-password-modal');
const confirmPasswordCheckbox = document.getElementById('confirm-password-checkbox');
const confirmPasswordBtn = document.getElementById('confirm-password-btn');
const cancelPasswordBtn = document.getElementById('cancel-change-pass');
const showPasswordModalBtn = document.getElementById('show-password-modal-btn');

if (confirmPasswordModal && showPasswordModalBtn) {
    const confirmPassword = new Modal(confirmPasswordModal, createModalOptions(confirmPasswordModal));
    const passwordForm = showPasswordModalBtn.closest('form');
    
    const handlePasswordSubmit = (e) => {
        e.preventDefault();
        confirmPassword.show();
        return false;
    };

    if (passwordForm) {
        passwordForm.addEventListener('submit', handlePasswordSubmit);
    }

    showPasswordModalBtn.addEventListener('click', (e) => {
        e.preventDefault();
        confirmPassword.show();
    });

    confirmPasswordCheckbox.addEventListener('change', (e) => {
        confirmPasswordBtn.disabled = !e.target.checked;
    });

    confirmPasswordBtn.addEventListener('click', () => {
        if (confirmPasswordCheckbox.checked) {
            if (passwordForm) {
                const livewireElement = passwordForm.closest('[wire\\:id]');
                const livewireComponent = livewireElement ? Livewire.find(livewireElement.getAttribute('wire:id')) : null;
                
                if (livewireComponent) {
                    livewireComponent.call('updatePassword');
                } else {
                    console.error('Livewire component not found for password update');
                }
            }
            
            confirmPassword.hide();
            confirmPasswordCheckbox.checked = false;
            confirmPasswordBtn.disabled = true;
        }
    });

    cancelPasswordBtn.addEventListener('click', () => {
        confirmPassword.hide();
        confirmPasswordCheckbox.checked = false;
        confirmPasswordBtn.disabled = true;
    });
}

// ============================================
// PROFILE UPDATE CONFIRMATION MODAL
// ============================================
const confirmProfileModal = document.getElementById('confirm-update-profile-modal');
const confirmProfileCheckbox = document.getElementById('confirm-profile-checkbox');
const confirmProfileBtn = document.getElementById('confirm-profile-btn');
const cancelProfileBtn = document.getElementById('cancel-profile-update');
const showProfileModalBtn = document.getElementById('show-profile-update-modal-btn');

if (confirmProfileModal && showProfileModalBtn) {
    const confirmProfile = new Modal(confirmProfileModal, createModalOptions(confirmProfileModal));
    const profileForm = showProfileModalBtn.closest('form');
    
    const handleProfileSubmit = (e) => {
        e.preventDefault();
        confirmProfile.show();
        return false;
    };

    if (profileForm) {
        profileForm.addEventListener('submit', handleProfileSubmit);
    }

    showProfileModalBtn.addEventListener('click', (e) => {
        e.preventDefault();
        confirmProfile.show();
    });

    confirmProfileCheckbox.addEventListener('change', (e) => {
        confirmProfileBtn.disabled = !e.target.checked;
    });

    confirmProfileBtn.addEventListener('click', () => {
        if (confirmProfileCheckbox.checked) {
            if (profileForm) {
                const livewireElement = profileForm.closest('[wire\\:id]');
                const livewireComponent = livewireElement ? Livewire.find(livewireElement.getAttribute('wire:id')) : null;
                
                if (livewireComponent) {
                    livewireComponent.call('updateProfileInformation');
                } else {
                    console.error('Livewire component not found for profile update');
                }
            }
            
            confirmProfile.hide();
            confirmProfileCheckbox.checked = false;
            confirmProfileBtn.disabled = true;
        }
    });

    cancelProfileBtn.addEventListener('click', () => {
        confirmProfile.hide();
        confirmProfileCheckbox.checked = false;
        confirmProfileBtn.disabled = true;
    });
}

// ============================================
// SUCCESS MODAL (SHARED FOR BOTH)
// ============================================
const successModalEl = document.getElementById('success-modal');
const successMessageHeader = document.getElementById('success-msg-head');
const successMessage = document.getElementById('success-message');
const closeSuccessModalButton = document.getElementById('close-success-modal-button');

if (successModalEl) {
    const successModal = new Modal(successModalEl, createModalOptions(successModalEl));

    // Listen for Livewire 'saved' event
    document.addEventListener('livewire:init', () => {
        Livewire.on('saved', () => {
            // Determine which form was saved based on which modal was shown
            if (confirmPasswordModal && !confirmPasswordModal.classList.contains('hidden')) {
                successMessageHeader.textContent = 'Password Updated Successfully';
                successMessage.textContent = 'Your password has been updated successfully.';
            } else {
                successMessageHeader.textContent = 'Profile Updated Successfully';
                successMessage.textContent = 'Your profile information has been updated successfully.';
            }
            successModal.show();
        });
    });

    // Backup listener on window
    window.addEventListener('saved', () => {
        successMessageHeader.textContent = 'Update Successful';
        successMessage.textContent = 'Your changes have been saved successfully.';
        successModal.show();
    });

    if (closeSuccessModalButton) {
        closeSuccessModalButton.addEventListener('click', () => {
            successModal.hide();
            setTimeout(() => {
                location.reload();
            }, 300);
        });
    }
}
