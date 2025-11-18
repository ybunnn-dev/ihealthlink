// Midwife Activity Log Handler
const modal = document.getElementById('filter-date-modal');
const modalz = new Modal(modal);

class MidwifeActivityLog {
    constructor() {
        this.loading = false;
        this.search = '';
        this.dateFilter = '';
        this.fromDate = '';
        this.toDate = '';
        this.midwifeId = window.midwifeData.midwife_id;
        this.midwifeName = window.midwifeData.firstName;

        this.init();
    }

    init() {
        this.attachEventListeners();
        this.attachPaginationHandlers();
    }

    attachEventListeners() {
        // Search input with debounce
        const searchInput = document.getElementById('activity-search');
        if (searchInput) {
            let debounceTimer;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    this.search = e.target.value;
                    this.fetchLogs(1);
                }, 500);
            });
        }

        // Date filter dropdown
        const dateFilter = document.getElementById('dateFilter');
        if (dateFilter) {
            dateFilter.addEventListener('change', (e) => {
                this.dateFilter = e.target.value;

                if (this.dateFilter === 'custom') {
                    this.showCustomDateModal();
                } else {
                    this.fromDate = '';
                    this.toDate = '';
                    this.fetchLogs(1);
                }
            });
        }

        // Custom date modal buttons
        const applyBtn = document.getElementById('apply-filter-date');
        const cancelBtn = document.getElementById('cancel-filter-date');

        if (applyBtn) {
            applyBtn.addEventListener('click', () => {
                this.applyCustomDateFilter();
            });
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => {
                this.cancelCustomDateFilter();
            });
        }
    }

    showCustomDateModal() {
        modalz.show();
    }

    hideCustomDateModal() {
        modalz.hide();
    }

    applyCustomDateFilter() {
        const fromDate = document.getElementById('filterFromDate').value;
        const toDate = document.getElementById('filterToDate').value;

        if (!fromDate || !toDate) {
            alert('Please select both from and to dates.');
            return;
        }

        this.fromDate = fromDate;
        this.toDate = toDate;
        this.hideCustomDateModal();
        this.fetchLogs(1);
    }

    cancelCustomDateFilter() {
        document.getElementById('filterFromDate').value = '';
        document.getElementById('filterToDate').value = '';
        document.getElementById('dateFilter').value = '';
        this.dateFilter = '';
        this.fromDate = '';
        this.toDate = '';
        this.hideCustomDateModal();
        this.fetchLogs(1);
    }

    async fetchLogs(page = 1) {
        if (this.loading) return;

        this.loading = true;
        this.showLoading();

        const params = new URLSearchParams({
            page: page,
            search: this.search,
            date_filter: this.dateFilter,
        });

        if (this.dateFilter === 'custom' && this.fromDate && this.toDate) {
            params.set('from_date', this.fromDate);
            params.set('to_date', this.toDate);
        }

        const url = `/mho/midwife/${this.midwifeName}/${this.midwifeId}?${params.toString()}`;

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            const data = await response.json();

            if (data.success) {
                // Update table
                document.getElementById('activity-log-table-container').innerHTML = data.html;

                // Update pagination
                const paginationContainer = document.getElementById('pagination-container');
                if (data.pagination.links) {
                    paginationContainer.innerHTML = data.pagination.links;
                    paginationContainer.style.display = 'block';
                    this.attachPaginationHandlers();
                } else {
                    paginationContainer.style.display = 'none';
                }
            }
        } catch (error) {
            console.error('Error fetching activity logs:', error);
        } finally {
            this.loading = false;
            this.hideLoading();
        }
    }

    attachPaginationHandlers() {
        const paginationLinks = document.querySelectorAll('#pagination-container a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const url = new URL(link.href);
                const page = url.searchParams.get('page') || 1;
                this.fetchLogs(page);
            });
        });
    }

    showLoading() {
        const spinner = document.getElementById('loading-spinner');
        const tableContainer = document.getElementById('activity-log-table-container');
        const paginationContainer = document.getElementById('pagination-container');

        if (spinner) spinner.classList.remove('hidden');
        if (tableContainer) tableContainer.style.opacity = '0.5';
        if (paginationContainer) paginationContainer.style.opacity = '0.5';
    }

    hideLoading() {
        const spinner = document.getElementById('loading-spinner');
        const tableContainer = document.getElementById('activity-log-table-container');
        const paginationContainer = document.getElementById('pagination-container');

        if (spinner) spinner.classList.add('hidden');
        if (tableContainer) tableContainer.style.opacity = '1';
        if (paginationContainer) paginationContainer.style.opacity = '1';
    }
}

// Initialize when script loads (no DOMContentLoaded)
new MidwifeActivityLog();
