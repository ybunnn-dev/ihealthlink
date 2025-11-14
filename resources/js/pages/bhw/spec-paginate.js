export function activityLogData() {
    return {
        loading: false,
        search: '',
        dateFilter: '',
        showPrivacy: true, // Add this for privacy toggle
        
        init() {
            // Attach handlers to initial pagination links on page load
            this.$nextTick(() => {
                this.attachPaginationHandlers();
            });
        },
        
        async fetchLogs(page = 1) {
            this.loading = true;
            
            const bhw = window.bhwData;
            const id = bhw.id;
            
            const params = new URLSearchParams({
                page: page,
                search: this.search,
                date_filter: this.dateFilter,
            });
            
            try {
                const response = await fetch(`/barangay/bhws/${id}?${params}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update the table content
                    document.getElementById('activity-log-table-container').innerHTML = data.html;
                    
                    // Update pagination
                    const paginationContainer = document.getElementById('pagination-container');
                    if (data.pagination.links) {
                        paginationContainer.innerHTML = data.pagination.links;
                        paginationContainer.style.display = 'block';
                        
                        // Re-attach handlers after updating pagination
                        this.$nextTick(() => {
                            this.attachPaginationHandlers();
                        });
                    } else {
                        paginationContainer.style.display = 'none';
                    }
                }
            } catch (error) {
                console.error('Error fetching logs:', error);
            } finally {
                this.loading = false;
            }
        },
        
        attachPaginationHandlers() {
            const paginationLinks = document.querySelectorAll('#pagination-container a');
            if (paginationLinks.length === 0) return;
            
            paginationLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const url = new URL(link.href);
                    const page = url.searchParams.get('page') || 1;
                    this.fetchLogs(page);
                });
            });
        }
    }
}
