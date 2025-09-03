
    // --- 1. Get HTML elements ---
    const addBarangayModalEl = document.getElementById('add-barangay-modal');
    const confirmModalEl = document.getElementById('confirm-add-barangay-modal');
    const mainTriggerBtn = document.getElementById('page-add-barangay-button');

    // --- 2. Create Flowbite Modal Instances (without the generic onHide option) ---
    const addBarangayModal = new Modal(addBarangayModalEl);
    const confirmModal = new Modal(confirmModalEl);


    // --- 3. Add Event Listener to Open the First Modal ---
    mainTriggerBtn.addEventListener('click', function() {
        addBarangayModal.show();
    });


    // --- 4. Get other elements ---
    const barangayNameInput = document.getElementById('barangay-name-input');
    const openConfirmBtn = document.getElementById('open-confirmation-modal-button');
    const confirmCheckbox = document.getElementById('confirm-barangay-checkbox');
    const confirmProceedBtn = document.getElementById('confirm-proceed-button');
    // **Get the cancel button from the confirmation modal**
    const cancelConfirmBtn = confirmModalEl.querySelector('[data-modal-hide="confirm-add-barangay-modal"]');


    // --- 5. Open the confirmation modal ---
    openConfirmBtn.addEventListener('click', function () {
        const barangayName = barangayNameInput.value.trim();
        if (barangayName === '') {
            alert('Please enter a barangay name.');
            return;
        }
        const namePlaceholder = document.getElementById('barangay-name-to-confirm');
        namePlaceholder.textContent = barangayName;

        addBarangayModal.hide();
        confirmModal.show();
    });


    // --- 6. Handle checkbox logic ---
    confirmCheckbox.addEventListener('change', function () {
        confirmProceedBtn.disabled = !this.checked;
    });


    // --- 7. Handle the final confirmation ---
    confirmProceedBtn.addEventListener('click', async function () {
        const barangayNameToInsert = barangayNameInput.value.trim();
        this.disabled = true;
        this.textContent = 'Saving...';

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const response = await fetch('/add-brgy', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    name: barangayNameToInsert
                })
            });

            // ** Call .json() ONCE and store the result in a variable **
            const result = await response.json();

            // ** Now, use the 'result' variable everywhere below **

            if (!response.ok) {
                // Use 'result' to get error messages
                if (response.status === 422) {
                    const errors = Object.values(result.errors).map(e => e.join('\n')).join('\n');
                    alert('Validation Error:\n' + errors);
                } else {
                    throw new Error(result.message || 'An unknown error occurred.');
                }
            } else {
                // --- ON SUCCESS ---
                // Use the SAME 'result' to get success data
                const newBarangayId = result.barangay.id;
                
                alert(result.message);

                // Create a URL-friendly slug from the name
                const barangaySlug = barangayNameToInsert.toLowerCase().replace(/\s+/g, '-');

                // Construct the final URL with both ID and name slug
                const finalUrl = `/mho/barangays/${newBarangayId}/${barangaySlug}`;

                // Redirect to the new URL
                window.location.href = finalUrl;
            }

        } catch (error) {
            console.error('Submission Error:', error);
            alert('An error occurred while saving the barangay. Please check the console.');
            // Reset button state even on error
            this.disabled = false;
            this.textContent = 'Confirm & Proceed';
        }
        // The 'finally' block is removed because we now handle the button reset
        // in the success (redirect) and error (catch) blocks individually.
    });

    // --- 8. (NEW) Handle cancellation of the confirmation ---
    if (cancelConfirmBtn) {
        cancelConfirmBtn.addEventListener('click', function() {
            // When cancel is clicked, explicitly hide the confirmation
            // modal and show the "Add Barangay" modal again.
            confirmModal.hide();
            addBarangayModal.show();
        });
    }

   