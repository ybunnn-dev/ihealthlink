const residentId = window.resident?.id;
const baseUrl = window.location.pathname;
const tableContainer = document.getElementById('consultationTableContainer');
const loadingIndicator = document.getElementById('loadingIndicator');
const activeFilterDisplay = document.getElementById('activeFilterDisplay');
const activeFilterText = document.getElementById('activeFilterText');
const dateDropdownText = document.getElementById('dateDropdownText');

let currentFilters = {
    date_filter: '',
    from_date: '',
    to_date: ''
};

// Get CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Initialize Flowbite Modal
const modalElement = document.getElementById('filter-date-modal');
const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const filterDateModal = new Modal(modalElement, modalOptions);

// Fetch consultations via AJAX
function fetchConsultations(page = 1) {
    loadingIndicator.classList.remove('hidden');

    const params = new URLSearchParams({
        page: page,
        ...currentFilters
    });

    // Remove empty params
    for (let [key, value] of params.entries()) {
        if (!value) params.delete(key);
    }

    const url = `${baseUrl}?${params.toString()}`;

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Update table content
                tableContainer.innerHTML = data.html;

                // IMPORTANT: Re-attach pagination listeners AFTER content is updated
                attachPaginationListeners();

                // Update URL without reload
                window.history.pushState({}, '', url);

                console.log('Consultations loaded:', data.pagination);
            }
        })
        .catch(error => {
            console.error('Error fetching consultations:', error);
            alert('Error loading consultations. Please try again.');
        })
        .finally(() => {
            loadingIndicator.classList.add('hidden');
        });
}

// Attach event listeners to pagination links (CRITICAL FUNCTION)
function attachPaginationListeners() {
    // Use event delegation on the container instead of individual links
    const paginationContainer = tableContainer.querySelector('#pagination-links');

    if (paginationContainer) {
        // Remove old listeners if any by cloning the node
        const newPaginationContainer = paginationContainer.cloneNode(true);
        paginationContainer.parentNode.replaceChild(newPaginationContainer, paginationContainer);

        // Add single event listener on container (event delegation)
        newPaginationContainer.addEventListener('click', function (e) {
            // Check if clicked element is a pagination link
            const link = e.target.closest('a');

            if (link && link.href) {
                e.preventDefault();
                e.stopPropagation();

                // Extract page number from URL
                const url = new URL(link.href);
                const page = url.searchParams.get('page') || 1;

                console.log('Pagination clicked, loading page:', page);

                // Fetch new page
                fetchConsultations(page);
            }
        });

        console.log('Pagination listeners attached');
    }
}

// Handle date filter dropdown
const dateFilterItems = document.querySelectorAll('#dateDropdownMenu li[data-date-filter]');

dateFilterItems.forEach(item => {
    item.addEventListener('click', function () {
        const filterValue = this.getAttribute('data-date-filter');
        const filterName = this.getAttribute('data-date-name');

        currentFilters.date_filter = filterValue;
        currentFilters.from_date = '';
        currentFilters.to_date = '';

        dateDropdownText.textContent = filterName;

        if (filterValue) {
            activeFilterDisplay.classList.remove('hidden');
            activeFilterText.textContent = `Filter: ${filterName}`;
        } else {
            activeFilterDisplay.classList.add('hidden');
        }

        fetchConsultations(1);
    });
});

// Handle custom date range trigger
const customDateTrigger = document.getElementById('customDateTrigger');
if (customDateTrigger) {
    customDateTrigger.addEventListener('click', function () {
        filterDateModal.show();
    });
}

// Handle apply custom date filter
const applyFilterBtn = document.getElementById('apply-filter-date');
if (applyFilterBtn) {
    applyFilterBtn.addEventListener('click', function () {
        const fromDate = document.getElementById('filterFromDate').value;
        const toDate = document.getElementById('filterToDate').value;

        if (!fromDate || !toDate) {
            alert('Please select both from and to dates');
            return;
        }

        if (new Date(fromDate) > new Date(toDate)) {
            alert('From date must be before To date');
            return;
        }

        currentFilters.date_filter = '';
        currentFilters.from_date = fromDate;
        currentFilters.to_date = toDate;

        const fromFormatted = new Date(fromDate).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
        const toFormatted = new Date(toDate).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });

        dateDropdownText.textContent = 'Custom Range';
        activeFilterDisplay.classList.remove('hidden');
        activeFilterText.textContent = `From: ${fromFormatted} To: ${toFormatted}`;

        filterDateModal.hide();

        document.getElementById('filterFromDate').value = '';
        document.getElementById('filterToDate').value = '';

        fetchConsultations(1);
    });
}

// Handle cancel button
const cancelFilterBtn = document.getElementById('cancel-filter-date');
if (cancelFilterBtn) {
    cancelFilterBtn.addEventListener('click', function () {
        document.getElementById('filterFromDate').value = '';
        document.getElementById('filterToDate').value = '';
        filterDateModal.hide();
    });
}

// Handle clear filter
const clearFilterBtn = document.getElementById('clearFilter');
if (clearFilterBtn) {
    clearFilterBtn.addEventListener('click', function () {
        currentFilters = {
            date_filter: '',
            from_date: '',
            to_date: ''
        };

        dateDropdownText.textContent = 'All Time';
        activeFilterDisplay.classList.add('hidden');

        document.getElementById('filterFromDate').value = '';
        document.getElementById('filterToDate').value = '';

        fetchConsultations(1);
    });
}

// Initial attachment of pagination listeners
attachPaginationListeners();