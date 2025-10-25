// The main modal element
const chooseHeadModalEl = document.getElementById('chooseHeadModal');
const modalOptions = {
    placement: 'center-center',
    backdrop: 'static',
    closable: false,
};
// --- Inputs ---

// The search input field
const headSearchInput = document.getElementById('head-search');

// The purok filter dropdown
const purokFilterSelect = document.getElementById('purokFilterSelect');

// --- Content Area ---

// The container for the list of residents (radio buttons)
const headCardContainer = document.getElementById('headCardContainer');

// --- Footer Buttons ---

// The "Close" button
const cancelChooseHeadBtn = document.getElementById('cancelChooseHead');

// The "Confirm" button
const confirmChooseHeadBtn = document.getElementById('confirmChooseHeadBtn');

const chooseHeadTrigger = document.getElementById('change-head-btn');

const chooseHeadModal = new Modal(chooseHeadModalEl, modalOptions);


cancelChooseHeadBtn.addEventListener('click', function(){
    chooseHeadModal.hide();
});

chooseHeadTrigger.addEventListener('click', function(){
    chooseHeadModal.show();
});