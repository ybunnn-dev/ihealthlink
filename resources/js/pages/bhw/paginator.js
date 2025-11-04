const searchInput = document.getElementById('default-search');
const filterByBtn = document.getElementById('filterBy');
const dateFilterBtn = document.getElementById('dateFilter');

let currentFilter = 'alphabetical';
let currentDateFilter = 'all';
let searchTimeout;

function fetchBHWs(page = 1) {
    const params = new URLSearchParams({
        search: searchInput.value,
        sort_by: currentFilter,
        sort_date: currentDateFilter,
        page: page
    });

    fetch(`/barangay/bhws/?${params}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('bhw-table-body').innerHTML = data.html;
                document.getElementById('bhw-pagination').innerHTML = data.pagination;

                attachPaginationHandlers();
            }
        })
        .catch(error => console.error('Error:', error));
}

function attachPaginationHandlers() {
    document.querySelectorAll('#bhw-pagination a').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            fetchBHWs(page);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
}

// Filter options
document.querySelectorAll('.filter-option').forEach(option => {
    option.addEventListener('click', function (e) {
        e.preventDefault();
        const filterValue = this.getAttribute('data-filter');
        currentFilter = filterValue;
        document.getElementById('filterByText').textContent = this.textContent;
        fetchBHWs();
    });
});

// Date filter options
document.querySelectorAll('.date-option').forEach(option => {
    option.addEventListener('click', function (e) {
        e.preventDefault();
        const dateValue = this.getAttribute('data-date');
        currentDateFilter = dateValue;
        document.getElementById('dateFilterText').textContent = this.textContent;
        fetchBHWs();
    });
});

// Search input
searchInput.addEventListener('input', function () {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => fetchBHWs(), 300);
});

attachPaginationHandlers();
