// Family List Filtering and Pagination
const searchInput = document.getElementById('default-search');
const purokDropdownButton = document.getElementById('purokDropdown');
const dateDropdownButton = document.getElementById('dateDropdown');
const purokDropdownItems = document.querySelectorAll('#purokDropdownMenu li');
const dateDropdownItems = document.querySelectorAll('#dateDropdownMenu li');
const tableBody = document.getElementById('family-table-body');
const paginationContainer = document.getElementById('family-pagination-container');
const loadingIndicator = document.getElementById('family-loading-indicator');

let searchTimeout;
let currentFilters = {
    search: '',
    purok_id: '',
    date_sort: '',
    page: 1
};

// Show/hide loading indicator
function toggleLoading(show) {
    if (show) {
        loadingIndicator.classList.remove('hidden');
        tableBody.style.opacity = '0.5';
    } else {
        loadingIndicator.classList.add('hidden');
        tableBody.style.opacity = '1';
    }
}

// Debounced search function
function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        currentFilters.search = searchInput.value;
        currentFilters.page = 1;
        fetchFamilies();
    }, 500);
}

// Fetch families via AJAX
function fetchFamilies() {
    toggleLoading(true);
    
    const params = new URLSearchParams();
    if (currentFilters.search) params.append('search', currentFilters.search);
    if (currentFilters.purok_id) params.append('purok_id', currentFilters.purok_id);
    if (currentFilters.date_sort && currentFilters.date_sort !== 'Date') {
        params.append('date_sort', currentFilters.date_sort);
    }
    if (currentFilters.page) params.append('page', currentFilters.page);

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const headers = {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
    };
    
    if (csrfToken) {
        headers['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
    }

    fetch(`${window.location.pathname}?${params.toString()}`, {
        headers: headers
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            tableBody.innerHTML = data.html;
            Alpine.initTree(tableBody);
            paginationContainer.innerHTML = data.pagination;
            attachPaginationListeners();
        } else {
            console.error('Error:', data.message);
        }
    })
    .catch(error => {
        console.error('Error fetching families:', error);
        tableBody.innerHTML = `
            <tr class="bg-white border-b">
                <td colspan="7" class="px-6 py-4 text-center text-red-500">
                    Error loading families. Please try again.
                </td>
            </tr>
        `;
    })
    .finally(() => {
        toggleLoading(false);
    });
}

// Attach event listeners to pagination links
function attachPaginationListeners() {
    const paginationLinks = paginationContainer.querySelectorAll('a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            currentFilters.page = url.searchParams.get('page') || 1;
            fetchFamilies();
        });
    });
}

// Search input listener
if (searchInput) {
    searchInput.addEventListener('input', debounceSearch);
}

// Purok filter listeners
if (purokDropdownItems) {
    purokDropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            const purokId = this.dataset.purokId;
            const purokName = this.dataset.purokName || 'All Purok';
            
            currentFilters.purok_id = purokId;
            currentFilters.page = 1;
            
            const buttonTextNode = purokDropdownButton.childNodes[0];
            buttonTextNode.textContent = purokName + ' ';
            
            fetchFamilies();
        });
    });
}

// Date filter listeners
if (dateDropdownItems) {
    dateDropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            const dateSort = this.dataset.dateSort;
            const dateSortName = this.dataset.dateSortName || 'Date';
            
            currentFilters.date_sort = dateSort;
            currentFilters.page = 1;
            
            const buttonTextNode = dateDropdownButton.childNodes[0];
            buttonTextNode.textContent = dateSortName + ' ';
            
            fetchFamilies();
        });
    });
}

// Initial pagination listener setup
if (paginationContainer) {
    attachPaginationListeners();
}
