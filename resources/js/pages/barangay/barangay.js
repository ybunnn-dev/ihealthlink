
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
                const finalUrl = `/mho/barangays/${newBarangayId}-${barangaySlug}`;

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

    // --- DOM Elements ---
    //Search Changes
    const searchInput = document.getElementById('default-search');
    const sortByMenu = document.getElementById('sortByDropdownBrgyMenu');
    const dateFilterMenu = document.getElementById('dateDropdownMenu');
    const tableBody = document.getElementById('barangay-table-body');
    const sortByButton = document.querySelector('#sortByDropdownBrgy');

    // --- State Management (Simplified) ---
    let searchQuery = '';
    let sortBy = 'name'; // Default sort is 'name'
    let dateFilter = 'all';
    // REMOVED: sortOrder is no longer needed

    const debounce = (func, delay = 300) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    };

    const fetchBarangays = async (page = 1) => {
        // SIMPLIFIED: The params no longer include sort_order
        const params = new URLSearchParams({
            search: searchQuery,
            sort_by: sortBy,
            date_filter: dateFilter,
            page: page
        });
        
        const url = `/mho/barangays/search?${params.toString()}`;
        history.pushState(null, '', `/mho/barangays?${params.toString()}`);

        try {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-10">Loading...</td></tr>`;
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();
            tableBody.innerHTML = data.table_html;
            
            const paginationContainer = document.getElementById('pagination-links');
            if (paginationContainer) {
                paginationContainer.innerHTML = data.pagination_html;
            }
        } catch (error) {
            console.error('Fetch error:', error);
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-10 text-red-500">Failed to load data.</td></tr>`;
        }
    };

    // --- Event Listeners ---

    // 1. Search Input
    searchInput.addEventListener('input', debounce((e) => {
        searchQuery = e.target.value;
        fetchBarangays(1);
    }));

    // 2. Sort By Dropdown (Simplified)
    sortByMenu.addEventListener('click', (e) => {
        e.preventDefault();
        const link = e.target.closest('a');
        if (!link) return;
        
        // It now only gets the column name to sort by
        sortBy = link.getAttribute('data-value');
        
        // Updates the button text to the selected option
        sortByButton.firstChild.nodeValue = `${link.textContent.trim()} `;
        fetchBarangays(1);
    });

    // 3. Date Filter Dropdown
    dateFilterMenu.addEventListener('click', (e) => {
        e.preventDefault();
        const link = e.target.closest('a');
        if (!link) return;
        dateFilter = link.getAttribute('data-value');
        fetchBarangays(1);
    });

    // 4. Pagination Links (Robust version)
    document.body.addEventListener('click', (e) => {
        const link = e.target.closest('#pagination-links a');
        if (!link) return;
        e.preventDefault();
        if (link.parentElement.classList.contains('disabled')) return;
        const url = new URL(link.href);
        const page = url.searchParams.get('page');
        if (page) fetchBarangays(page);
    });

