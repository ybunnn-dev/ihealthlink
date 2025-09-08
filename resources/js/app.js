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
    import('./pages/barangay/spec-barangay.js');
    import('./pages/barangay/purok.js');
    import('./pages/barangay/spec-purok.js');
    import('./pages/barangay/components/purok-sort.js');
    
  }else if(bodyClass.contains('midwives')){
    import('./pages/midwife/add-midwife.js');
    import('./pages/midwife/components/search-sort.js');

  }else if(bodyClass.contains('spec-midwife')){
    import('./pages/midwife/edit-midwife.js');
    import('./pages/midwife/remove-midwife.js');

  }else if(bodyClass.contains('health-programs')){
    import('./pages/health-programs/add-health-program.js');

  }else if(bodyClass.contains('medicines')){

    import('./pages/medicines/add-medicine.js');

  }else if(bodyClass.contains('spec-med')){
    import('./pages/medicines/edit-medicine.js');
    import('./pages/medicines/remove-medicine.js');

  }else if(bodyClass.contains('sched')){
    import('./pages/schedules/tab-switch.js');
    import('./pages/schedules/calendar.js');
    import('./pages/schedules/add-schedule.js');
    import('./pages/schedules/edit-activity-modal.js');
     // Dynamically import your modal script and then call the function
    import('./pages/schedules/edit-daily-activity.js').then(module => {
        module.initDailyActivityModal();
    });
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