// The main modal element
const filterDateModalEl = document.getElementById('filter-date-modal');

// The date input fields
const fromDateInput = document.getElementById('filterFromDate');
const toDateInput = document.getElementById('filterToDate');

// The action buttons
const cancelFilterDateButton = document.getElementById('cancel-filter-date');
const applyFilterDateButton = document.getElementById('apply-filter-date');

const filterDateTrigger = document.getElementById('filterDate');

const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};

const filterDateModal = new Modal(filterDateModalEl, modalOptions);


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
    const baseUrl = '/mho/reports';

    // 5. Hide the modal and redirect the page
    filterDateModal.hide();
    window.location.href = `${baseUrl}?${params.toString()}`;
});