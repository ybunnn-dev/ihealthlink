const searchInput = document.getElementById('search-logs');
const dateOptions = document.querySelectorAll('.date-option');
const dateFilterOptions = document.querySelectorAll('.date-filter-option');
const moduleOptions = document.querySelectorAll('.module-option');
const tableBody = document.getElementById('log-table-body');
const paginationContainer = document.getElementById('pagination-container');
const loadingIndicator = document.getElementById('loading-indicator');
const dateLabel = document.getElementById('date-label');
const dateFilterLabel = document.getElementById('date-filter-label');
const moduleLabel = document.getElementById('module-label');

// Modal elements
const filterDateModal = document.getElementById('filter-date-modal');
const filterFromDate = document.getElementById('filterFromDate');
const filterToDate = document.getElementById('filterToDate');
const applyFilterDateBtn = document.getElementById('apply-filter-date');
const cancelFilterDateBtn = document.getElementById('cancel-filter-date');

let searchTimeout;
let currentFilters = {
    search: '',
    module_id: '',
    date_filter: 'all',
    from_date: '',
    to_date: '',
    sort_date: 'desc',
    page: 1
};

let modalInstance;

function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        currentFilters.search = searchInput.value;
        currentFilters.page = 1;
        fetchLogs();
    }, 500);
}


function attachViewButtonListeners() {
    const viewButtons = document.querySelectorAll('.view-log-btn');
    let viewLogModal; // Store modal instance
    
    viewButtons.forEach(button => {
        button.addEventListener('click', async function (event) {
            event.preventDefault();
            const logId = this.dataset.id;
            const url = `/barangay/logs/${logId}`;

            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const logData = await response.json();

                // Get modal elements
                const logUserEl = document.getElementById('view-log-user');
                const logRoleEl = document.getElementById('view-log-role');
                const logDateTimeEl = document.getElementById('view-log-datetime');
                const logActivityEl = document.getElementById('view-log-activity');
                const closeLogModalBtn = document.getElementById('close-view-log-modal');
                const viewLogModalElement = document.getElementById('view-log-modal');

                if (logData && logData.user) {
                    const fullName = `${logData.user.firstName || ''} ${logData.user.middleName || ''} ${logData.user.lastName || ''}`.trim();
                    logUserEl.textContent = fullName || 'N/A';

                    let role = 'Unknown';
                    if (logData.user.role_id === 2) {
                        role = 'Midwife';
                    } else if (logData.user.role_id === 3) {
                        role = 'BHW';
                    } else if (logData.user.role_id === 4) {
                        role = 'BHW Web';
                    }
                    logRoleEl.textContent = role;
                }

                const eventDate = new Date(logData.created_at);
                logDateTimeEl.textContent = eventDate.toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });

                logActivityEl.textContent = logData.activity || 'No activity description provided.';

                // Create modal instance only once
                if (!viewLogModal) {
                    const modalOptions = {
                        placement: 'center',
                        backdrop: 'static', // Changed from 'dynamic' to prevent clicking backdrop
                        closable: false // Changed to false to prevent closing by backdrop
                    };
                    viewLogModal = new Modal(viewLogModalElement, modalOptions);
                    
                    // Add close button listener only once
                    closeLogModalBtn.addEventListener('click', () => {
                        viewLogModal.hide();
                    });
                }

                viewLogModal.show();

            } catch (error) {
                console.error('Failed to fetch or display log details:', error);
            }
        });
    });
}

function fetchLogs() {
    const params = new URLSearchParams();
    if (currentFilters.search) params.append('search', currentFilters.search);
    if (currentFilters.module_id) params.append('module_id', currentFilters.module_id);
    if (currentFilters.date_filter) params.append('date_filter', currentFilters.date_filter);
    if (currentFilters.from_date) params.append('from_date', currentFilters.from_date);
    if (currentFilters.to_date) params.append('to_date', currentFilters.to_date);
    params.append('sort_date', currentFilters.sort_date);
    params.append('page', currentFilters.page);

    loadingIndicator.classList.remove('hidden');

    fetch(`/barangay/logs?${params.toString()}`, {
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
                
                // Re-initialize Alpine
                if (window.Alpine) {
                    Alpine.flushAndStopDeferringMutations?.();
                    Alpine.initTree(tableBody);
                }
                
                attachPaginationListeners();
                attachViewButtonListeners(); // Add this line
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loadingIndicator.classList.add('hidden');
        });
}

function attachPaginationListeners() {
    const paginationLinks = paginationContainer.querySelectorAll('a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const url = new URL(link.href);
            currentFilters.page = url.searchParams.get('page') || 1;
            fetchLogs();
        });
    });
}

moduleOptions.forEach(option => {
    option.addEventListener('click', (e) => {
        e.preventDefault();
        currentFilters.module_id = option.dataset.moduleId;
        currentFilters.page = 1;
        
        moduleLabel.textContent = option.textContent.trim();
        
        fetchLogs();
    });
});

dateOptions.forEach(option => {
    option.addEventListener('click', (e) => {
        e.preventDefault();
        currentFilters.sort_date = option.dataset.sort;
        currentFilters.page = 1;
        
        dateLabel.textContent = option.dataset.sort === 'desc' ? 'Latest' : 'Oldest';
        
        fetchLogs();
    });
});

dateFilterOptions.forEach(option => {
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
                'last_year': 'Last Year'
            };
            dateFilterLabel.textContent = labels[option.dataset.filter];
            fetchLogs();
        }
    });
});

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
    
    dateFilterLabel.textContent = `${fromDate} to ${toDate}`;
    
    modalInstance.hide();
    
    fetchLogs();
});

cancelFilterDateBtn.addEventListener('click', () => {
    filterFromDate.value = '';
    filterToDate.value = '';
    
    modalInstance.hide();
});

searchInput.addEventListener('input', debounceSearch);

// Initial load
attachPaginationListeners();
attachViewButtonListeners();
fetchLogs();

