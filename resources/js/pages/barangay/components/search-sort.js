const searchInput = document.getElementById('default-search');
const sortByMenu = document.getElementById('sortByDropdownBrgyMenu');
const dateFilterMenu = document.getElementById('dateDropdownMenu');
const tableBody = document.getElementById('barangay-table-body');
const paginationContainer = document.getElementById('pagination-links');
const sortByButton = document.querySelector('#sortByDropdownBrgy');

let searchQuery = '', sortBy = 'alpha_asc', dateFilter = ''; 

const debounce = (func, delay = 300) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
};
const fetchBarangays = async (page = 1) => {
    const params = new URLSearchParams({
        search: searchQuery,
        filter: sortBy,
        sort_date: dateFilter,
        page: page
    });
    
    const url = `/mho/barangays?${params.toString()}`;
    history.pushState(null, '', url);

    try {
        tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-10">Loading...</td></tr>`;
        const response = await fetch(url, { 
            headers: { 
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            } 
        });
        
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        
        renderTable(data.data);
        paginationContainer.innerHTML = data.pagination;  // ✅ Just insert HTML
        attachPaginationHandlers();  // ✅ Re-attach click handlers

    } catch (error) {
        console.error('Fetch error:', error);
        tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-10 text-red-500">Failed to load data.</td></tr>`;
    }
};

// ✅ Add this function to handle pagination clicks
function attachPaginationHandlers() {
    document.querySelectorAll('#pagination-links a').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const url = new URL(this.href);
            const page = url.searchParams.get('page') || 1;
            fetchBarangays(page);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
}


const renderTable = (barangays) => {
    tableBody.innerHTML = '';

    if (barangays.length === 0) {
        tableBody.innerHTML = `
            <tr class="border-b bg-f7 text-normal_font text-center">
                <td colspan="6">
                    <div class="text-center py-10">
                        <img src="${emptyStateImageUrl}" alt="No barangays found" class="mx-auto w-64">
                        <p class="mt-5 text-lg font-medium text-gray-700">
                            No Barangays Found
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
    barangays.forEach(barangay => {
        const residentsCount = barangay.residents_count.toLocaleString('en-US');
        const createdAt = new Date(barangay.created_at).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
        const updatedAt = new Date(barangay.updated_at).toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
        const slug = barangay.name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        const showUrl = `/mho/barangays/${barangay.id}/${slug}`;

        tableHtml += `
            <tr class="bg-white border-b bg-f7 text-normal_font text-start cursor-pointer hover:bg-gray-100" onclick="window.location='${showUrl}'">
                <th scope="row" class="px-6 py-4 font-medium text-start text-normal_font whitespace-nowrap">${barangay.id}</th>
                <td class="px-6 py-4">${barangay.name}</td>
                <td class="px-6 py-4">${barangay.puroks_count}</td>
                <td class="px-6 py-4">${residentsCount}</td>
                <td class="px-6 py-4">${createdAt}</td>
                <td class="px-6 py-4">${updatedAt}</td>
            </tr>
        `;
    });

    tableBody.innerHTML = tableHtml;
};

const renderPagination = (links) => {
    paginationContainer.innerHTML = '';
    if (!links || links.length <= 3) return;

    let paginationHtml = '<nav class="flex items-center justify-between"><div class="flex-1 flex justify-between sm:hidden">';
    const prevLink = links[0];
    const nextLink = links[links.length - 1];
    paginationHtml += `<a href="${prevLink.url || '#'}" class="${!prevLink.url ? 'pointer-events-none opacity-50' : ''} relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">${prevLink.label}</a>`;
    paginationHtml += `<a href="${nextLink.url || '#'}" class="${!nextLink.url ? 'pointer-events-none opacity-50' : ''} ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">${nextLink.label}</a>`;
    paginationHtml += '</div><div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"><div class="flex gap-1">';

    links.forEach(link => {
        let label = link.label.replace('&laquo;', '').replace('&raquo;', '').trim();
        if(label === 'Previous' || label === 'Next') return;
        let activeClass = link.active ? 'bg-mainblue text-white' : 'bg-white text-gray-500 hover:bg-gray-50';
        let disabledClass = !link.url ? 'pointer-events-none opacity-50' : '';
        paginationHtml += `<a href="${link.url || '#'}" class="${activeClass} ${disabledClass} relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md">${label}</a>`;
    });
    
    paginationHtml += '</div></div></nav>';
    paginationContainer.innerHTML = paginationHtml;
};

// --- Event Listeners ---
searchInput.addEventListener('input', debounce(e => { searchQuery = e.target.value; fetchBarangays(1); }));
sortByMenu.addEventListener('click', e => {
    e.preventDefault();
    const link = e.target.closest('a');
    if (!link) return;
    sortBy = link.getAttribute('data-value');
    sortByButton.firstChild.nodeValue = `${link.textContent.trim()} `;
    fetchBarangays(1);
});
dateFilterMenu.addEventListener('click', e => {
    e.preventDefault();
    const link = e.target.closest('a');
    if (!link) return;
    dateFilter = link.getAttribute('data-value');
    fetchBarangays(1);
});
paginationContainer.addEventListener('click', e => {
    e.preventDefault();
    const link = e.target.closest('a');
    if (!link || !link.href) return;
    const url = new URL(link.href);
    const page = url.searchParams.get('page');
    if (page) fetchBarangays(page);
});
