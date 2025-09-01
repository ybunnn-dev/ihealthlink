import './bootstrap';
import Alpine from 'alpinejs';
import sideMenu from './components/side-menu-bhc.js';

import 'flowbite';
import 'flowbite-datepicker';


document.addEventListener('DOMContentLoaded', () => {
  const bodyClass = document.body.classList;

  // Only load charts on the reports page
  if (bodyClass.contains('reports')) {
 
    import('./charts/per-purok-pie.js');
    import('./charts/age-group-bar.js');
    import('./charts/families-4ps.js');
    import('./charts/small-donuts.js');
    import('./charts/radar.js');
    import('./resident.js');
    
  } else if(bodyClass.contains('dashboard')){

    import('./charts/dash-health-programs.js');

  } else if(bodyClass.contains('barangay')){
    import('./pages/barangay/barangay.js');
    import('./pages/barangay/components/search-sort.js');

  } else if(bodyClass.contains('spec-brgy')){

    import('./pages/barangay/purok.js');
    import('./pages/barangay/components/purok-sort.js');
    
  }else if(bodyClass.contains('midwives')){
    import('./pages/midwife/add-midwife.js');
  }
  else {
    console.log('Not on reports page - charts not loaded');
  }

  // Datepicker styling fix
  document.addEventListener('show.datepicker', () => {
    setTimeout(() => {
      document.querySelectorAll('.datepicker').forEach(picker => {
        picker.classList.remove('dark');
        picker.style.backgroundColor = 'white';
        picker.style.color = 'black';
      });
    }, 10);
  });
});

// Initialize Alpine.js
document.addEventListener('alpine:init', () => {
  Alpine.data('sideMenu', sideMenu);
});

Alpine.start();