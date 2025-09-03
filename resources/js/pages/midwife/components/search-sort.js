// IDs now target the midwife search, filter, and table elements
const searchInput = document.getElementById('midwife-search-input');
const filterMenu = document.getElementById('midwife-filter-menu');
const sortMenu = document.getElementById('midwife-sort-menu');
const tableBody = document.getElementById('midwives-table-body');
const paginationContainer = document.getElementById('midwives-pagination-links'); // Make sure your HTML has this ID
const filterButton = document.getElementById('midwife-filter-button');
const sortButton = document.getElementById('midwife-sort-button');

// Default state variables
let searchQuery = '', filterBy = 'alphabetical', sortBy = 'newest';

const debounce = (func, delay = 300) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
};

/**
 * Fetches and displays a paginated list of midwives based on current filters.
 */
const fetchMidwives = async (page = 1) => {
    // URLSearchParams and endpoint are now for midwives
    const params = new URLSearchParams({
        search: searchQuery,
        filter_by: filterBy,
        sort_by: sortBy,
        page: page
    });
    
    const url = `/mho/midwives/search?${params.toString()}`;
    // Update browser history for a better user experience
    history.pushState(null, '', `/mho/midwives?${params.toString()}`);

    try {
        // Colspan updated for the midwife table (5 columns)
        tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-10">Loading...</td></tr>`;
        const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        if (!response.ok) throw new Error('Network response was not ok');
        
        const apiResponse = await response.json();
        
        renderTable(apiResponse.data);
        renderPagination(apiResponse.links);

    } catch (error) {
        console.error('Fetch error:', error);
        // Colspan updated
        tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-10 text-red-500">Failed to load data.</td></tr>`;
    }
};

/**
 * Renders the midwife table rows from the API data.
 */
const renderTable = (midwives) => {
    tableBody.innerHTML = '';

    if (midwives.length === 0) {
        // Empty state message and colspan are now for midwives
        tableBody.innerHTML = `
            <tr class="border-b bg-f7 text-normal_font text-center">
                <td colspan="5">
                    <div class="text-center py-10">
                        <img src="${emptyStateImageUrl}"  alt="No midwives found" class="mx-auto w-64">
                        <p class="mt-5 text-lg font-medium text-gray-700">
                            No Midwives Found
                        </p>
                        <p class="mt-2 text-sm text-gray-500">
                            Your search or filter returned no results.
                        </p>
                    </div>
                </td>
            </tr>`;
        return;
    }

    let tableHtml = '';
    // Looping through 'midwives' and using midwife data keys
    midwives.forEach(midwife => {
        // Format data for display
        const createdAt = new Date(midwife.created_at).toLocaleDateString('en-US', { 
            month: 'short', day: '2-digit', year: 'numeric' 
        });
        const updatedAt = new Date(midwife.updated_at).toLocaleDateString('en-US', { 
            month: 'short', day: '2-digit', year: 'numeric' 
        });

        // Build full name from related users
        const fullName = [
            midwife.users.firstName, 
            midwife.users.middleName, 
            midwife.users.lastName, 
            midwife.users.suffix
        ].filter(Boolean).join(' ');

        // Slugify the name for a clean URL
        const slug = fullName.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]+/g, '');

        // Use id instead of midwife_no since backend returns "id"
        const showUrl = `/mho/midwife/${slug}/${midwife.id}`;

        // HTML structure now matches the midwife table columns
        tableHtml += `
            <tr id="midwife-row-${midwife.id}" 
                class="bg-white border-b bg-f7 text-normal_font text-start cursor-pointer hover:bg-gray-100" 
                onclick="window.location='${showUrl}'">
                
                <th id="midwife-no-${midwife.id}" 
                    scope="row" 
                    class="px-6 py-4 font-medium text-start text-normal_font whitespace-nowrap">
                    ${midwife.id}
                </th>
                
                <td id="midwife-name-${midwife.id}" class="px-6 py-4">${fullName}</td>
                <td id="midwife-barangay-${midwife.id}" class="px-6 py-4">${midwife.barangays.name}</td>
                <td id="midwife-date-added-${midwife.id}" class="px-6 py-4">${createdAt}</td>
                <td id="midwife-date-updated-${midwife.id}" class="px-6 py-4">${updatedAt}</td>
            </tr>
        `;
    });

    tableBody.innerHTML = tableHtml;
};

/**
 * Renders pagination links. This function is generic and requires no major changes.
 */
const renderPagination = (links) => {
    if (!paginationContainer) return;
    paginationContainer.innerHTML = '';
    if (!links || links.length <= 3) return;

    let paginationHtml = '<nav aria-label="Pagination"><ul class="inline-flex items-center -space-x-px">';
    links.forEach(link => {
        if (!link.url) {
            paginationHtml += `<li><span class="cursor-not-allowed block px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg">${link.label}</span></li>`;
        } else {
            let activeClass = link.active ? 'z-10 text-blue-600 border-blue-300 bg-blue-50' : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700';
            paginationHtml += `<li><a href="${link.url}" data-page="${new URL(link.url).searchParams.get('page')}" class="px-3 py-2 leading-tight ${activeClass} border">${link.label}</a></li>`;
        }
    });
    paginationHtml += '</ul></nav>';
    paginationContainer.innerHTML = paginationHtml;
};

// --- Event Listeners ---
if (searchInput) {
    searchInput.addEventListener('input', debounce(e => {
        searchQuery = e.target.value;
        fetchMidwives(1);
    }));
}

if (filterMenu) {
    filterMenu.addEventListener('click', e => {
        e.preventDefault();
        const link = e.target.closest('a');
        if (!link) return;
        filterBy = link.getAttribute('id'); // e.g., 'filter-alphabetical'
        filterButton.firstChild.nodeValue = `${link.textContent.trim()} `; // Updates button text
        console.log(filterBy);
        fetchMidwives(1);
    });
}

if (sortMenu) {
    sortMenu.addEventListener('click', e => {
        e.preventDefault();
        const link = e.target.closest('a');
        if (!link) return;
        sortBy = link.getAttribute('id'); // e.g., 'sort-last-week'
        sortButton.firstChild.nodeValue = `${link.textContent.trim()}`;
        console.log(sortBy);
        fetchMidwives(1);
    });
}

if (paginationContainer) {
    paginationContainer.addEventListener('click', e => {
        e.preventDefault();
        const link = e.target.closest('a');
        if (!link || !link.dataset.page) return;
        fetchMidwives(link.dataset.page);
    });
}

// Initial fetch when the page loads
//fetchMidwives();