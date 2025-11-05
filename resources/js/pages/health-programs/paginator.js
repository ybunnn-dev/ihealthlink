console.log('check debug print');
console.log('Page body classes:', document.body.className);

let searchTimeout;
let currentFilters = {
    search: '',
    sort_by: 'name',
    date_filter: 'all'
};

function fetchHealthPrograms(page = 1) {
    console.log('🔍 Fetching health programs with filters:', currentFilters, 'Page:', page);
    
    const params = new URLSearchParams();
    if (currentFilters.search) params.append('search', currentFilters.search);
    if (currentFilters.sort_by && currentFilters.sort_by !== 'name') params.append('sort_by', currentFilters.sort_by);
    if (currentFilters.date_filter && currentFilters.date_filter !== 'all') params.append('date_filter', currentFilters.date_filter);
    if (page) params.append('page', page);

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const headers = {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
    };
    
    if (csrfToken) {
        headers['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
    }

    console.log('📤 Fetch URL:', `/mho/health-programs?${params.toString()}`);

    fetch(`/mho/health-programs?${params.toString()}`, {
        headers: headers
    })
    .then(response => {
        console.log('📥 Response Status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('✅ Success response:', data);
        if (data.html) {
            const tableWrapper = document.querySelector('div.relative.overflow-x-auto');
            if (tableWrapper) {
                tableWrapper.innerHTML = data.html;
            }
            
            const paginationDiv = document.getElementById('pagination-links');
            if (paginationDiv) {
                paginationDiv.innerHTML = data.pagination;
            }
            
            attachPaginationListeners();
        } else {
            console.error('❌ No HTML in response:', data);
        }
    })
    .catch(error => {
        console.error('❌ Fetch Error:', error);
    });
}

function attachPaginationListeners() {
    const paginationContainer = document.getElementById('pagination-links');
    if (paginationContainer) {
        const paginationLinks = paginationContainer.querySelectorAll('a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page') || 1;
                console.log('📖 Pagination clicked - Page:', page);
                fetchHealthPrograms(page);
            });
        });
    }
}

// Use setTimeout to ensure DOM is ready
setTimeout(() => {
    console.log('✅ Health Programs Paginator initializing (setTimeout)');

    // Search input listener
    const searchInput = document.getElementById('default-search');
    console.log('Search input found:', searchInput ? 'YES' : 'NO');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            console.log('🔤 Search input changed:', this.value);
            clearTimeout(searchTimeout);
            currentFilters.search = this.value;

            searchTimeout = setTimeout(function () {
                console.log('⏱️ Search timeout fired');
                fetchHealthPrograms();
            }, 500);
        });
    }

    // Sort by dropdown
    const sortMenuItems = document.querySelectorAll('#sortByDropdownBrgyMenu a');
    console.log('Sort menu items found:', sortMenuItems.length);
    
    sortMenuItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const value = this.dataset.value;
            console.log('🔀 Sort selected:', value);
            currentFilters.sort_by = value;

            const text = this.textContent;
            const sortButton = document.getElementById('sortByDropdownBrgy');
            if (sortButton) {
                sortButton.innerHTML = text + ' <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>';
            }

            fetchHealthPrograms();
        });
    });

    // Date filter dropdown
    const dateMenuItems = document.querySelectorAll('#dateDropdownMenu a');
    console.log('Date menu items found:', dateMenuItems.length);
    
    dateMenuItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const value = this.dataset.value;
            console.log('📅 Date filter selected:', value);
            currentFilters.date_filter = value;

            const text = this.textContent;
            const dateButton = document.getElementById('dateDropdown');
            if (dateButton) {
                dateButton.innerHTML = text + ' <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/></svg>';
            }

            fetchHealthPrograms();
        });
    });

    // Initial pagination listener setup
    attachPaginationListeners();
}, 500);