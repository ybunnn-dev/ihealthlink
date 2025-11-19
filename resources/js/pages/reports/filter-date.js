// The main modal element
const filterDateModalEl = document.getElementById('filter-date-modal');

// The date input fields
const fromDateInput = document.getElementById('filterFromDate');
const toDateInput = document.getElementById('filterToDate');

// The action buttons
const cancelFilterDateButton = document.getElementById('cancel-filter-date');
const applyFilterDateButton = document.getElementById('apply-filter-date');

const filterDateTrigger = document.getElementById('filterDate');
const clearFilterButton = document.getElementById('clearFilter');

const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const filterDateModal = new Modal(filterDateModalEl, modalOptions);

// Function to update clear filter button state
function updateClearFilterButton() {
    const hasParams = new URLSearchParams(window.location.search).toString() !== '';
    
    clearFilterButton.disabled = !hasParams;
    
    if (!hasParams) {
        clearFilterButton.classList.add('opacity-50', 'cursor-not-allowed');
        clearFilterButton.classList.remove('hover:bg-nav_active');
    } else {
        clearFilterButton.classList.remove('opacity-50', 'cursor-not-allowed');
        clearFilterButton.classList.add('hover:bg-nav_active');
    }
}

// Run on page load
updateClearFilterButton();

filterDateTrigger.addEventListener('click', function(){
    filterDateModal.show();
});

cancelFilterDateButton.addEventListener('click',function(){
    filterDateModal.hide();
});

applyFilterDateButton.addEventListener('click', function() {
    // 1. Get the values from the date inputs
    const startDate = fromDateInput.value;
    const endDate = toDateInput.value;

    // Optional: Add validation
    if (!startDate || !endDate) {
        alert('Please select both a start and end date.');
        return; 
    }

    // 2. Get the current URL's query parameters
    // This safely preserves other filters, like 'program_id'
    const params = new URLSearchParams(window.location.search);

    // 3. Set the new date parameters
    params.set('start_date', startDate);
    params.set('end_date', endDate);

    // 4. Get the base URL from your Laravel route
    // IMPORTANT: This line must be in a Blade file to work
    const baseUrl = '/barangay/reports';

    // 5. Hide the modal and redirect the page
    filterDateModal.hide();
    window.location.href = `${baseUrl}?${params.toString()}`;
});

// Clear filter functionality
clearFilterButton.addEventListener('click', function() {
    const baseUrl = '/barangay/reports';
    window.location.href = baseUrl;
});