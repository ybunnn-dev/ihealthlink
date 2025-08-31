
// The complete, unfiltered list of puroks from the server
const allPuroks = window.initialPurokData || [];

// DOM element references
const searchInput = document.getElementById('purok-search');
const dateFilterMenu = document.getElementById('purokDateDropdownMenu');
const dateFilterButton = document.getElementById('purokDateDropdown');
const tableBody = document.getElementById('purok-table-body');
// NOTE: Add your modal logic here if needed for 'page-add-purok-button'

// Application state
let searchQuery = '';
let dateFilter = 'all';


// --- 2. Core Logic ---

/**
 * The main rendering function. It filters the data and updates the table.
 */
const render = () => {
    let processedData = allPuroks;
    console.log(processedData);
    // Apply search filter (case-insensitive)
    if (searchQuery) {
        const lowerCaseQuery = searchQuery.toLowerCase();
        processedData = processedData.filter(purok =>
            purok.name.toLowerCase().includes(lowerCaseQuery)
        );
    }

    // Apply date filter
    if (dateFilter !== 'all') {
        const now = new Date();
        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

        processedData = processedData.filter(purok => {
            const purokDate = new Date(purok.created_at);
            const diffTime = today - purokDate;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (dateFilter === 'last_week') {
                return diffDays > 0 && diffDays <= 7;
            }
            if (dateFilter === 'last_month') {
                return diffDays > 0 && diffDays <= 30;
            }
            return true;
        });
    }

    
    // Update the DOM with all filtered results
    renderTable(processedData);
};


// --- 3. Rendering Function ---

/**
 * Renders the HTML for the table body.
 * @param {Array} puroks - The array of puroks to display.
 */
const renderTable = (puroks) => {
    tableBody.innerHTML = ''; // Clear previous results

    if (puroks.length === 0) {
        const emptyRow = `
            <tr class="border-b">
                <td colspan="6" class="text-center py-10">
                    <p class="font-medium text-gray-700">No puroks found matching your criteria.</p>
                    <p class="text-sm text-gray-500">Try adjusting your search or filters.</p>
                </td>
            </tr>`;
        tableBody.innerHTML = emptyRow;
        return;
    }

    let tableHtml = '';
    puroks.forEach(purok => {
        // Safely format the date
        const createdAt = new Date(purok.created_at).toLocaleDateString('en-US', {
            month: 'short', day: 'numeric', year: 'numeric'
        });

        tableHtml += `
            <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">${purok.id}</th>
                <td class="px-6 py-4">${purok.name}</td>
                <td class="px-6 py-4">${purok.households_count}</td>
                <td class="px-6 py-4">${purok.residents_count}</td>
                <td class="px-6 py-4">${createdAt}</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center items-center space-x-4">
                        <a href="#" title="View Purok" class="text-maingreen hover:text-green-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="#" title="Edit Purok" class="text-mainblue hover:text-blue-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                        </a>
                        <button type="button" title="Delete Purok" class="text-red1 hover:text-red-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    tableBody.innerHTML = tableHtml;
};


// --- 4. Utility Function ---

/**
 * Delays function execution to prevent rapid firing (e.g., on keyup).
 */
const debounce = (func, delay = 300) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), delay);
    };
};


// --- 5. Event Handlers ---

searchInput.addEventListener('input', debounce(e => {
    searchQuery = e.target.value;
    render();
}));

dateFilterMenu.addEventListener('click', e => {
    e.preventDefault();
    const link = e.target.closest('a');
    if (!link) return;

    dateFilter = link.dataset.value;
    dateFilterButton.firstChild.nodeValue = `${link.textContent.trim()} `;
    render();
});

