// Resident List Filtering and Pagination
const searchInput = document.getElementById('default-search');
const purokDropdownButton = document.getElementById('purokDropdown');
const ageGroupDropdownButton = document.getElementById('ageGroupDropdown');
const purokDropdownItems = document.querySelectorAll('#purokDropdownMenu li');
const ageGroupDropdownItems = document.querySelectorAll('#ageGroupDropdownMenu li');
const tableBody = document.getElementById('resident-table-body');
const paginationContainer = document.getElementById('resident-pagination-container');
const loadingIndicator = document.getElementById('resident-loading-indicator');

let searchTimeout;
let currentFilters = {
    search: '',
    purok_id: '',
    age_group: '',
    page: 1
};

// Privacy state (mirrors Alpine)
let privacyEnabled = false;

// Function to apply privacy state to table rows
function applyPrivacyState() {
    const showElements = tableBody.querySelectorAll('[data-privacy="show"]');
    const hideElements = tableBody.querySelectorAll('[data-privacy="hide"]');
    
    showElements.forEach(el => {
        el.style.display = privacyEnabled ? '' : 'none';
    });
    
    hideElements.forEach(el => {
        el.style.display = privacyEnabled ? 'none' : '';
    });
}

// Listen for privacy toggle changes from Alpine
document.addEventListener('alpine:initialized', () => {
    // Watch for changes in Alpine store
    Alpine.effect(() => {
        privacyEnabled = Alpine.store('privacy').show;
        applyPrivacyState();
    });
});

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
        fetchResidents();
    }, 500);
}

// Fetch residents via AJAX
function fetchResidents() {
    toggleLoading(true);
    
    const params = new URLSearchParams();
    if (currentFilters.search) params.append('search', currentFilters.search);
    if (currentFilters.purok_id) params.append('purok_id', currentFilters.purok_id);
    if (currentFilters.age_group && currentFilters.age_group !== 'All Age Groups') {
        params.append('age_group', currentFilters.age_group);
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

    fetch(`/barangay/residents/load?${params.toString()}`, {
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
            paginationContainer.innerHTML = data.pagination;
            applyPrivacyState(); // Apply privacy state to new content
            attachPaginationListeners();
        } else {
            console.error('Error:', data.message);
        }
    })
    .catch(error => {
        console.error('Error fetching residents:', error);
        tableBody.innerHTML = `
            <tr class="bg-white border-b">
                <td colspan="6" class="px-6 py-4 text-center text-red-500">
                    Error loading residents. Please try again.
                </td>
            </tr>
        `;
    })
    .finally(() => {
        toggleLoading(false);
    });
}

// Rest of your code...

// Attach event listeners to pagination links
function attachPaginationListeners() {
    const paginationLinks = paginationContainer.querySelectorAll('a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            currentFilters.page = url.searchParams.get('page') || 1;
            fetchResidents();
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
            
            fetchResidents();
        });
    });
}

// Age group filter listeners
if (ageGroupDropdownItems) {
    ageGroupDropdownItems.forEach(item => {
        item.addEventListener('click', function() {
            const ageGroup = this.dataset.ageGroup;
            const ageGroupName = this.dataset.ageGroupName || 'All Age Groups';
            
            // Store the full age group string (e.g., "Infant (0-1)")
            currentFilters.age_group = ageGroupName;
            currentFilters.page = 1;
            
            const buttonTextNode = ageGroupDropdownButton.childNodes[0];
            buttonTextNode.textContent = ageGroupName + ' ';
            
            fetchResidents();
        });
    });
}

// Initial pagination listener setup
if (paginationContainer) {
    attachPaginationListeners();
}
