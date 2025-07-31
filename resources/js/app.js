import './bootstrap';
import Alpine from 'alpinejs';
import sideMenu from './components/side-menu-bhc.js';
import './charts/dash-health-programs.js';
import './charts/per-purok-pie.js';
import './charts/age-group-bar.js';
import './charts/families-4ps.js';
import './charts/small-donuts.js';
import './charts/radar.js';
import './resident.js';
import 'flowbite';
import 'flowbite-datepicker';

document.addEventListener('DOMContentLoaded', () => {
  document.addEventListener('show.datepicker', () => {
    setTimeout(() => {
      document.querySelectorAll('.datepicker').forEach(picker => {
        picker.classList.remove('dark');
        // Optional: force white background just in case
        picker.style.backgroundColor = 'white';
        picker.style.color = 'black';
      });
    }, 10); // Wait briefly for Flowbite to finish rendering
  });
});


document.addEventListener('alpine:init', () => {
    // Register your Alpine data components
    Alpine.data('sideMenu', sideMenu); 
});
//window.Alpine = Alpine
Alpine.start()

