
const searchInput = document.getElementById('default-search');
const purokDropdownButton = document.getElementById('purokDropdown');
const purokDropdownItems = document.querySelectorAll('#purokDropdownMenu li');
const tableBody = document.querySelector('tbody');
const paginationContainer = document.querySelector('.mt-6.text-main_font');

let searchTimeout;
let currentFilters = {
    search: '',
    purok_id: '',
    page: 1
};

// Debounced search function
function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        currentFilters.search = searchInput.value;
        currentFilters.page = 1; // Reset to page 1 on new search
        fetchHouseholds();
    }, 500); // 500ms delay
}

function fetchHouseholds() {
    const params = new URLSearchParams();
    if (currentFilters.search) params.append('search', currentFilters.search);
    if (currentFilters.purok_id) params.append('purok_id', currentFilters.purok_id);
    if (currentFilters.page) params.append('page', currentFilters.page);

    fetch(`/barangay/households?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Replace table and pagination
                tableBody.innerHTML = data.html;
                paginationContainer.innerHTML = data.pagination;

                // Re-initialize Alpine inside the replaced HTML
                if (window.Alpine) {
                    Alpine.flushAndStopDeferringMutations?.();
                    Alpine.initTree(tableBody);
                }

                attachPaginationListeners();
            }
        })
        .catch(error => console.error('Error fetching households:', error));
}


// Attach event listeners to pagination links
function attachPaginationListeners() {
    const paginationLinks = paginationContainer.querySelectorAll('a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const url = new URL(this.href);
            currentFilters.page = url.searchParams.get('page') || 1;
            fetchHouseholds();
        });
    });
}

// Search input listener
searchInput.addEventListener('input', debounceSearch);

// Purok filter listeners
purokDropdownItems.forEach(item => {
    item.addEventListener('click', function () {
        const purokId = this.dataset.purokId;
        const purokName = this.dataset.purokName || 'All Purok';

        currentFilters.purok_id = purokId;
        currentFilters.page = 1; // Reset to page 1 on filter change

        // Update button text
        purokDropdownButton.childNodes[0].textContent = purokName + ' ';

        fetchHouseholds();
    });
});

// Initial pagination listener setup
attachPaginationListeners();


