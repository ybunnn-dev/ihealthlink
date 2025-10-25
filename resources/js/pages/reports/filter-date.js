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