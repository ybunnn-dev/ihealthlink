export function medicineFilter(indexRoute) {
    return {
        loading: false,
        filters: {
            search: '',
            category: '',
            name_sort: 'asc',
            date_sort: ''
        },
        categoryLabel: 'All',
        nameSortLabel: 'Ascending',
        dateSortLabel: 'None',
        indexRoute: indexRoute,

        init() {
            this.setupPaginationListener();
        },

        selectCategory(value, label) {
            this.filters.category = value;
            this.categoryLabel = label;
            this.fetchResults();
        },

        selectNameSort(value, label) {
            this.filters.name_sort = value;
            this.nameSortLabel = label;
            this.fetchResults();
        },

        selectDateSort(value, label) {
            this.filters.date_sort = value;
            this.dateSortLabel = label;
            this.fetchResults();
        },

        fetchResults(page = 1) {
            this.loading = true;

            const params = new URLSearchParams({
                ...this.filters,
                page: page
            });

            for (let [key, value] of params.entries()) {
                if (!value) params.delete(key);
            }

            fetch(`${this.indexRoute}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('medicine-table-body').innerHTML = data.html;
                document.getElementById('pagination-links').innerHTML = data.pagination;
                this.setupPaginationListener();
                this.loading = false;
            })
            .catch(error => {
                console.error('Error:', error);
                this.loading = false;
            });
        },

        setupPaginationListener() {
            const paginationLinks = document.querySelectorAll('#pagination-links a');
            paginationLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const url = new URL(link.href);
                    const page = url.searchParams.get('page') || 1;
                    this.fetchResults(page);
                });
            });
        }
    }
}
