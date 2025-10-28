export function faqFilter(indexRoute) {
    return {
        loading: false,
        filters: {
            search: '',
            module: ''
        },
        moduleLabel: 'All Modules',

        init() {
            this.setupPaginationListener();
        },

        selectModule(value, label) {
            this.filters.module = value;
            this.moduleLabel = label;
            this.fetchResults();
        },

        fetchResults(page = 1) {
            this.loading = true;

            const params = new URLSearchParams({
                ...this.filters,
                page: page
            });

            // Remove empty parameters
            for (let [key, value] of params.entries()) {
                if (!value) params.delete(key);
            }

            fetch(`${indexRoute}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('faq-list').innerHTML = data.html;
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
                    
                    // Scroll to top smoothly
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
        }
    }
}
