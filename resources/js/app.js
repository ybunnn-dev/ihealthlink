import './bootstrap';
import Alpine from 'alpinejs';
import sideMenu from './components/side-menu-bhc.js';
import './charts/dash-health-programs.js';
import './charts/per-purok-pie.js';
import './charts/age-group-bar.js';
import './charts/families-4ps.js';
import './charts/small-donuts.js';
import './resident.js';

document.addEventListener('alpine:init', () => {
    // Register your Alpine data components
    Alpine.data('sideMenu', sideMenu); 
});
//window.Alpine = Alpine
Alpine.start()