export default () => ({
    open: true,
    activeItem: 'dashboard',
    showMenu: false,

    init() {
        // Load cached sidebar state
        const cachedOpen = localStorage.getItem('sidebarOpen');
        if (cachedOpen !== null) {
            this.open = cachedOpen === 'true';
        }

        // Load active item
        const cachedActive = localStorage.getItem('activeSidebarItem');
        if (cachedActive) {
            this.activeItem = cachedActive;
        } else {
            this.determineActiveItemFromUrl();
        }

        window.addEventListener('popstate', () => {
            this.determineActiveItemFromUrl();
        });
    },

    determineActiveItemFromUrl() {
        const path = window.location.pathname;
        
        if (path.includes('/dashboard')) this.activeItem = 'dashboard';
        else if (path.includes('/residents')) this.activeItem = 'residents';
        else if (path.includes('/health-programs')) this.activeItem = 'health-programs';
        else if (path.includes('/medicines')) this.activeItem = 'medicines';
        else if (path.includes('/reports')) this.activeItem = 'reports';
        else if (path.includes('/schedules')) this.activeItem = 'schedules';
        else if (path.includes('/bhws')) this.activeItem = 'bhws';
        else if (path.includes('/logs')) this.activeItem = 'logs';
        else if (path.includes('/faqs')) this.activeItem = 'faqs';
        else if (path.includes('/barangays')) this.activeItem = 'barangays';
        else if (path.includes('/midwife')) this.activeItem = 'midwife';
        else this.activeItem = 'dashboard';
        
        localStorage.setItem('activeSidebarItem', this.activeItem);
    },

    toggleSidebar() {
        this.open = !this.open;
        localStorage.setItem('sidebarOpen', this.open.toString());
    },

    setActive(item) {
        this.activeItem = item;
        localStorage.setItem('activeSidebarItem', item);
    }
});