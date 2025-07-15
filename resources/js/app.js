import './bootstrap';
import Alpine from 'alpinejs';
import sideMenu from './components/side-menu-bhc.js';
import './charts/dash-health-programs.js';

document.addEventListener('alpine:init', () => {
    // Register your Alpine data components
    Alpine.data('sideMenu', sideMenu); 
});
//window.Alpine = Alpine
Alpine.start()