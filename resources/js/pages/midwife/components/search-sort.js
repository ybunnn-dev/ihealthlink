const searchInput = document.getElementById('midwife-search-input');
const filterMenu = document.getElementById('midwife-filter-menu');
const sortMenu = document.getElementById('midwife-sort-menu');
const tableBody = document.getElementById('midwives-table-body');
const paginationContainer = document.getElementById('midwives-pagination-links');
const filterButton = document.getElementById('midwife-filter-button');
const sortButton = document.getElementById('midwife-sort-button');

let searchQuery = '', filterBy = 'filter-alphabetical', dateFilter = '';

const debounce = (func, delay = 300) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
};

const fetchMidwives = async (page = 1) => {
    const params = new URLSearchParams({
        search: searchQuery,
        filter_by: filterBy,
        date_filter: dateFilter,
        page: page
    });
    
    const url = `/mho/midwives?${params.toString()}`;
    history.pushState(null, '', url);

    try {
        tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-10">Loading...</td></tr>`;
        
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error('Network response was not ok');
        
        const apiResponse = await response.json();
        
        renderTable(apiResponse.data);
        renderPagination(apiResponse.links);

    } catch (error) {
        console.error('Fetch error:', error);
        tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-10 text-red-500">Failed to load data.</td></tr>`;
    }
};

const renderTable = (midwives) => {
    tableBody.innerHTML = '';

    if (midwives.length === 0) {
        tableBody.innerHTML = `
            <tr class="border-b bg-f7 text-normal_font text-center">
                <td colspan="5">
                    <div class="text-center py-10">
                        <img src="${emptyStateImageUrl}" alt="No midwives found" class="mx-auto w-64">
                        <p class="mt-5 text-lg font-medium text-gray-700">No Midwives Found</p>
                        <p class="mt-2 text-sm text-gray-500">Your search or filter returned no results.</p>
                    </div>
                </td>
            </tr>`;
        return;
    }

    let tableHtml = '';
    midwives.forEach(midwife => {
        const createdAt = new Date(midwife.created_at).toLocaleDateString('en-US', { 
            month: 'short', day: '2-digit', year: 'numeric' 
        });
        const updatedAt = new Date(midwife.updated_at).toLocaleDateString('en-US', { 
            month: 'short', day: '2-digit', year: 'numeric' 
        });

        const fullName = [
            midwife.user?.firstName,
            midwife.user?.middleName,
            midwife.user?.lastName,
            midwife.user?.suffix
        ].filter(Boolean).join(' ');

        const slug = fullName.toLowerCase().replace(/\s+/g, '-').replace(/[^\w-]+/g, '');
        const showUrl = `/mho/midwife/${slug}/${midwife.id}`;

        tableHtml += `
            <tr id="midwife-row-${midwife.id}" 
                class="bg-white border-b bg-f7 text-normal_font text-start cursor-pointer hover:bg-gray-100" 
                onclick="window.location='${showUrl}'">
                <th scope="row" class="px-6 py-4 font-medium text-start text-normal_font whitespace-nowrap">${midwife.id}</th>
                <td class="px-6 py-4">${fullName}</td>
                <td class="px-6 py-4">${midwife.barangay?.name || 'N/A'}</td>
                <td class="px-6 py-4">${createdAt}</td>
                <td class="px-6 py-4">${updatedAt}</td>
            </tr>
        `;
    });

    tableBody.innerHTML = tableHtml;
};

const renderPagination = (linksHtml) => {
    if (!paginationContainer) return;
    paginationContainer.innerHTML = linksHtml || '';
    
    // Reattach click handlers for pagination links
    paginationContainer.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const url = new URL(link.href);
            const page = url.searchParams.get('page');
            if (page) fetchMidwives(page);
        });
    });
};

// Event Listeners
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
        filterBy = link.getAttribute('id');
        filterButton.textContent = `${link.textContent.trim()} `;
        fetchMidwives(1);
    });
}

if (sortMenu) {
    sortMenu.addEventListener('click', e => {
        e.preventDefault();
        const link = e.target.closest('a');
        if (!link) return;
        dateFilter = link.getAttribute('id').replace('sort-', '').replace('no-sort', '');
        sortButton.textContent = `${link.textContent.trim()} `;
        fetchMidwives(1);
    });
}
