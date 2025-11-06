const searchInput = document.getElementById('search-residents');
const sortOptions = document.querySelectorAll('.sort-option');
const dateOptions = document.querySelectorAll('.date-option');
const tableBody = document.getElementById('residents-table-body');
const paginationContainer = document.getElementById('pagination-container');
const loadingIndicator = document.getElementById('loading-indicator');
const sortLabel = document.getElementById('sort-label');
const dateLabel = document.getElementById('date-label');

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

// Debounced search
function debounceSearch() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        currentFilters.search = searchInput.value;
        currentFilters.page = 1;
        fetchResidents();
    }, 500);
}

// Fetch residents with filters
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
            
            if (data.enrolledResidents) {
                renderTable(data.enrolledResidents);
                renderPagination(data);
                
                // Update stats
                document.getElementById('total-enrolled').textContent = data.totalEnrolled;
                document.getElementById('total-completed').textContent = data.completed;
                document.getElementById('total-overdue').textContent = data.overdue;
            }
        })
        .catch(error => {
            console.error('Error fetching residents:', error);
            loadingIndicator.classList.add('hidden');
        });
}

// Render table
function renderTable(residents) {
    if (residents.length === 0) {
        tableBody.innerHTML = `
            <tr class="border-b bg-f7 text-normal_font">
                <td colspan="5" class="text-center py-10">
                    <p class="mt-5 text-lg font-medium text-gray-700">No Enrolled Residents Found</p>
                    <p class="mt-2 text-sm text-gray-500">Try adjusting your filters or search term.</p>
                </td>
            </tr>
        `;
        return;
    }

    tableBody.innerHTML = residents.map(enrollment => `
        <tr class="bg-white border-b text-normal_font hover:bg-gray-50 cursor-pointer" onclick="window.location='/midwife/enrolled-resident/${enrollment.id}'">
            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                ${enrollment.resident_id}
            </th>
            <td class="px-6 py-4">
                ${enrollment.resident_name}
            </td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 font-semibold text-xs rounded-full ${enrollment.status_color}">
                    ${enrollment.status_text}
                </span>
            </td>
            <td class="px-6 py-4">
                ${enrollment.date_enrolled}
            </td>
            <td class="px-6 py-4">
                ${enrollment.next_schedule}
            </td>
        </tr>
    `).join('');
}

// Render pagination
function renderPagination(data) {
    let html = '';
    
    if (data.totalPages > 1) {
        html = '<div class="flex justify-between items-center"><div class="text-sm text-gray-600">Page ' + data.currentPage + ' of ' + data.totalPages + '</div><div class="flex gap-1">';
        
        if (data.currentPage > 1) {
            html += '<a href="#" data-page="1" class="page-link px-3 py-2 border rounded hover:bg-gray-100">First</a>';
            html += '<a href="#" data-page="' + (data.currentPage - 1) + '" class="page-link px-3 py-2 border rounded hover:bg-gray-100">Prev</a>';
        }
        
        for (let i = Math.max(1, data.currentPage - 2); i <= Math.min(data.totalPages, data.currentPage + 2); i++) {
            const active = i === data.currentPage ? 'bg-mainblue text-white' : 'border text-gray-700 hover:bg-gray-100';
            html += '<a href="#" data-page="' + i + '" class="page-link px-3 py-2 rounded ' + active + '">' + i + '</a>';
        }
        
        if (data.currentPage < data.totalPages) {
            html += '<a href="#" data-page="' + (data.currentPage + 1) + '" class="page-link px-3 py-2 border rounded hover:bg-gray-100">Next</a>';
            html += '<a href="#" data-page="' + data.totalPages + '" class="page-link px-3 py-2 border rounded hover:bg-gray-100">Last</a>';
        }
        
        html += '</div></div>';
    }
    
    paginationContainer.innerHTML = html;
    
    // Attach listeners
    document.querySelectorAll('.page-link').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            currentFilters.page = parseInt(link.dataset.page);
            fetchResidents();
        });
    });
}

// Sort options
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

// Date filter options
dateOptions.forEach(option => {
    option.addEventListener('click', (e) => {
        e.preventDefault();
        currentFilters.date_filter = option.dataset.filter;
        currentFilters.page = 1;
        
        if (option.dataset.filter === 'custom') {
            const modal = document.getElementById('filter-date-modal');
            if (modal) new Modal(modal).show();
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

// Custom date filter event
window.addEventListener('apply-custom-date-filter', (event) => {
    currentFilters.from_date = event.detail.fromDate;
    currentFilters.to_date = event.detail.toDate;
    dateLabel.textContent = `${event.detail.fromDate} to ${event.detail.toDate}`;
    currentFilters.page = 1;
    fetchResidents();
});

// Search input
searchInput.addEventListener('input', debounceSearch);

// Initial load
fetchResidents();
