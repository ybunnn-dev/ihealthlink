    // --- 1. Element Selectors & State ---
    const searchInput = document.getElementById('purok-search');
    const dateFilterMenu = document.getElementById('purokDateDropdownMenu');
    const tableBody = document.getElementById('purok-table-body');
    const paginationContainer = document.getElementById('purok-pagination-links');
    const dateFilterButton = document.getElementById('purokDateDropdown');

    // Get the current barangay ID (make sure your container has this)
    const container = document.getElementById('purok-page-container');
    const barangayId = container.dataset.barangayId;

    let searchQuery = '';
    let dateFilter = 'all'; // Default date filter

    // --- 2. Core Functions ---
    const debounce = (func, delay = 300) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    };

    const fetchPuroks = async (page = 1) => {
        const params = new URLSearchParams({
            search: searchQuery,
            date_filter: dateFilter,
            page: page
        });
        
        const url = `/mho/barangays/${barangayId}/puroks/search?${params.toString()}`;

        try {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-10">Loading...</td></tr>`;
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!response.ok) throw new Error('Network response was not ok');
            
            const apiResponse = await response.json();
            
            renderTable(apiResponse.data);
            renderPagination(apiResponse);

        } catch (error) {
            console.error('Fetch error:', error);
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-10 text-red-500">Failed to load data.</td></tr>`;
        }
    };

    const renderTable = (puroks) => {
        // This function remains the same as the previous example
        tableBody.innerHTML = '';
        if (puroks.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-10">No puroks found.</td></tr>`;
            return;
        }
        let tableHtml = '';
        puroks.forEach(purok => {
             const createdAt = new Date(purok.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
             tableHtml += `
                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">${purok.id}</th>
                    <td class="px-6 py-4">${purok.name}</td>
                    <td class="px-6 py-4">${purok.households_count || 'N/A'}</td>
                    <td class="px-6 py-4">${purok.residents_count || 'N/A'}</td>
                    <td class="px-6 py-4">${createdAt}</td>
                    <td class="px-6 py-4 align-middle">
                        <div class="flex items-center space-x-4">
                            </div>
                    </td>
                </tr>`;
        });
        tableBody.innerHTML = tableHtml;
    };

    const renderPagination = (apiResponse) => {
        // This function also remains the same
        const links = apiResponse.links;
        paginationContainer.innerHTML = '';
        if (!links || links.length <= 3) return;
        let paginationHtml = '<nav class="flex items-center justify-between"><div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center"><div class="flex gap-1">';
        links.forEach(link => {
            if (link.url) {
                let label = link.label.replace('&laquo;', 'Prev').replace('&raquo;', 'Next');
                let activeClass = link.active ? 'bg-mainblue text-white' : 'bg-white text-gray-500 hover:bg-gray-50';
                paginationHtml += `<a href="${link.url}" class="${activeClass} relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md">${label}</a>`;
            }
        });
        paginationHtml += '</div></div></nav>';
        paginationContainer.innerHTML = paginationHtml;
    };
    
    // --- 3. Event Listeners ---
    searchInput.addEventListener('input', debounce(e => {
        searchQuery = e.target.value;
        fetchPuroks(1);
    }, 300));

    dateFilterMenu.addEventListener('click', e => {
        e.preventDefault();
        const link = e.target.closest('a');
        if (!link) return;
        dateFilter = link.getAttribute('data-value');
        dateFilterButton.firstChild.nodeValue = `${link.textContent.trim()} `;
        fetchPuroks(1);
    });

    paginationContainer.addEventListener('click', e => {
        e.preventDefault();
        const link = e.target.closest('a');
        if (!link || !link.href) return;
        const url = new URL(link.href);
        const page = url.searchParams.get('page');
        if (page) fetchPuroks(page);
    });

    // --- Initial Load ---
    fetchPuroks();