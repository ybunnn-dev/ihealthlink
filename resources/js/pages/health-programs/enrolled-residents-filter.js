const searchInput = document.getElementById('search-residents');
const sortOptions = document.querySelectorAll('.sort-option');
const dateOptions = document.querySelectorAll('.date-option');
const tableBody = document.getElementById('residents-table-body');
const paginationContainer = document.getElementById('pagination-container');
const loadingIndicator = document.getElementById('loading-indicator');
const sortLabel = document.getElementById('sort-label');
const dateLabel = document.getElementById('date-label');

// Modal elements
const filterDateModal = document.getElementById('filter-date-modal');
const filterFromDate = document.getElementById('filterFromDate');
const filterToDate = document.getElementById('filterToDate');
const applyFilterDateBtn = document.getElementById('apply-filter-date');
const cancelFilterDateBtn = document.getElementById('cancel-filter-date');

let searchTimeout;
let currentFilters = {
    search: '',
    sort_by: 'name',
    sort_order: 'asc',
    date_filter: 'all',
    from_date: '',
    to_date: '',
    page: 1
};

const healthProgramId = window.currentProgram;
let modalInstance;

function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        currentFilters.search = searchInput.value;
        currentFilters.page = 1;
        fetchResidents();
    }, 500);
}

function fetchResidents() {
    const params = new URLSearchParams();
    if (currentFilters.search) params.append('search', currentFilters.search);
    params.append('sort_by', currentFilters.sort_by);
    params.append('sort_order', currentFilters.sort_order);
    params.append('date_filter', currentFilters.date_filter);
    params.append('page', currentFilters.page);
    if (currentFilters.from_date) params.append('from_date', currentFilters.from_date);
    if (currentFilters.to_date) params.append('to_date', currentFilters.to_date);

    loadingIndicator.classList.remove('hidden');

    fetch(`/barangay/health-programs/${healthProgramId}?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            loadingIndicator.classList.add('hidden');
            if (data.status === 'success') {
                tableBody.innerHTML = data.html;
                paginationContainer.innerHTML = data.pagination;
                
                Alpine.initTree(tableBody);
                Alpine.initTree(paginationContainer);
                
                attachPaginationListeners();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loadingIndicator.classList.add('hidden');
        });
}

function attachPaginationListeners() {
    // Change from '.page-link' to 'a[href*="page="]'
    document.querySelectorAll('a[href*="page="]').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const url = new URL(link.href);
            currentFilters.page = url.searchParams.get('page') || 1;
            fetchResidents();
        });
    });
}


sortOptions.forEach(option => {
    option.addEventListener('click', (e) => {
        e.preventDefault();
        currentFilters.sort_by = option.dataset.sort;
        currentFilters.sort_order = option.dataset.order;
        currentFilters.page = 1;
        
        const labels = {
            'name_asc': 'Name (A-Z)',
            'name_desc': 'Name (Z-A)',
            'age_asc': 'Age (Youngest)',
            'age_desc': 'Age (Oldest)'
        };
        sortLabel.textContent = labels[`${currentFilters.sort_by}_${currentFilters.sort_order}`];
        
        fetchResidents();
    });
});

dateOptions.forEach(option => {
    option.addEventListener('click', (e) => {
        e.preventDefault();
        currentFilters.date_filter = option.dataset.filter;
        currentFilters.page = 1;
        
        if (option.dataset.filter === 'custom') {
            if (!modalInstance) {
                modalInstance = new Modal(filterDateModal);
            }
            modalInstance.show();
        } else {
            const labels = {
                'all': 'All Time',
                'last_week': 'Last Week',
                'last_month': 'Last Month',
                'last_year': 'Last Year'
            };
            dateLabel.textContent = labels[option.dataset.filter];
            fetchResidents();
        }
    });
});

// Apply custom date filter
applyFilterDateBtn.addEventListener('click', () => {
    const fromDate = filterFromDate.value;
    const toDate = filterToDate.value;
    
    if (!fromDate || !toDate) {
        alert('Please select both from and to dates');
        return;
    }
    
    if (new Date(fromDate) > new Date(toDate)) {
        alert('From date cannot be after to date');
        return;
    }
    
    currentFilters.from_date = fromDate;
    currentFilters.to_date = toDate;
    currentFilters.date_filter = 'custom';
    currentFilters.page = 1;
    
    dateLabel.textContent = `${fromDate} to ${toDate}`;
    
    modalInstance.hide();
    
    fetchResidents();
});

// Cancel custom date filter
cancelFilterDateBtn.addEventListener('click', () => {
    filterFromDate.value = '';
    filterToDate.value = '';
    
    modalInstance.hide();
});

searchInput.addEventListener('input', debounceSearch);

fetchResidents();
