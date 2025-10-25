import './bootstrap';
import Alpine from 'alpinejs';
import sideMenu from './components/side-menu-bhc.js';
import notificationHandler from './notification.js';

import 'flowbite';
import 'flowbite-datepicker';


document.addEventListener('DOMContentLoaded', () => {
  const bodyClass = document.body.classList;

  // Only load charts on the reports page
  if (bodyClass.contains('reports')) {
    import('./pages/reports/export-reports.js');
    import('./charts/per-purok-pie.js');
    import('./charts/age-group-bar.js');
    import('./charts/families-4ps.js');
    import('./charts/small-donuts.js');
    import('./charts/radar.js');
    //import('./resident.js');

  } else if (bodyClass.contains('brgy-reports')) {
    import('./pages/reports/filter-date.js');
    import('./pages/reports/export-reports.js');
    import('./charts/per-purok-pie.js');
    import('./charts/age-group-bar.js');
    import('./charts/families-4ps.js');
    import('./charts/small-donuts.js');
    import('./charts/radar.js');
  }
  else if (bodyClass.contains('dashboard')) {

    import('./charts/dash-health-programs.js');

  } else if (bodyClass.contains('barangay')) {
    import('./pages/barangay/barangay.js');
    import('./pages/barangay/components/search-sort.js');

  } else if (bodyClass.contains('spec-brgy')) {
    import('./pages/barangay/spec-barangay.js');
    import('./pages/barangay/purok.js');
    import('./pages/barangay/spec-purok.js');
    import('./pages/barangay/components/purok-sort.js');

  } else if (bodyClass.contains('midwives')) {
    import('./pages/midwife/add-midwife.js');
    import('./pages/midwife/components/search-sort.js');

  } else if (bodyClass.contains('spec-midwife')) {
    import('./pages/midwife/edit-midwife.js');
    import('./pages/midwife/remove-midwife.js');

  } else if (bodyClass.contains('health-programs')) {
    import('./pages/health-programs/add-health-program.js');

  } else if (bodyClass.contains('medicines')) {

    import('./pages/medicines/add-medicine.js');

  } else if (bodyClass.contains('spec-med')) {
    import('./pages/medicines/edit-medicine.js');
    import('./pages/medicines/remove-medicine.js');

  } else if (bodyClass.contains('sched')) {
    import('./pages/schedules/tab-switch.js');
    import('./pages/schedules/add-schedule.js');
    import('./pages/schedules/edit-schedule.js');
    import('./pages/schedules/remove-schedule.js');
    import('./pages/schedules/calendar.js');
    // Dynamically import your modal script and then call the function
    import('./pages/schedules/edit-daily-activity.js').then(module => {
      module.initDailyActivityModal();
    });

  } else if (bodyClass.contains('bhw')) {
    import('./pages/bhw/add-bhw.js');
  }
  else if (bodyClass.contains('spec-bhw')) {
    import('./pages/bhw/edit-bhw.js');
    import('./pages/bhw/remove-bhw.js');
  }
  else if (bodyClass.contains('households')) {
    import('./pages/household/add-household.js');
  }
  else if (bodyClass.contains('spec-household')) {
    import('./pages/household/choose-head.js');
    import('./pages/household/edit-household.js');
    import('./pages/household/add-family.js');
    import('./pages/household/add-existing-fam.js');
  }
  else if (bodyClass.contains('spec-resident')) {
    import('./pages/resident/create-referral.js');
    import('./pages/resident/spec-resident.js');

  } else if (bodyClass.contains('residents')) {
    import('./pages/resident/add-resident');
  }
  else if (bodyClass.contains('family')) {
    
  }else if(bodyClass.contains('spec-family')){
    import('./pages/family/add-existing.js');
    import('./pages/family/add-resident.js');
    import('./pages/family/edit-family.js');
    import('./pages/family/set-status.js');
  }
  else if (bodyClass.contains('health-programs')) {
    import('./pages/health-programs/add-health-program.js');

  }
  else if (bodyClass.contains('health-program-brgy')) {
    import('./pages/health-programs/change-program.js');

    const programTypeDefine = document.getElementById('program_type_content').textContent;

    if (programTypeDefine === 'maternal_health_tcl') {
      import('./pages/health-programs/enroll-maternal.js');
    } else if (programTypeDefine === 'child_healthcare_tcl') {
      import('./pages/health-programs/enroll-child.js');
    } else if (programTypeDefine === 'family_planning_tcl') {
      import('./pages/health-programs/enroll-family-planning.js');
    } else if (programTypeDefine === 'philpen_tcl') {
      import('./pages/health-programs/create-philpen-consultation.js');
    }
    else {
      import('./pages/health-programs/enroll-resident.js');
    }
  }
  else if (bodyClass.contains('spec-enrolled')) {
    const programTypeDefine = document.getElementById('program_type_content').textContent;

    if (programTypeDefine === 'maternal_health_tcl') {
      import('./pages/health-programs/update-maternity.js');
      import('./pages/health-programs/view-consultation.js');
      import('./pages/health-programs/update-consultation.js');
    } else if (programTypeDefine === 'child_healthcare_tcl') {
      console.log('hello');
      import('./pages/health-programs/update-child-care.js');
      import('./pages/health-programs/view-consultation.js');
      import('./pages/health-programs/update-consultation.js');
    } else if (programTypeDefine === 'family_planning_tcl') {
      import('./pages/health-programs/update-family-planning.js');
      import('./pages/health-programs/view-consultation.js');
      import('./pages/health-programs/update-consultation.js');
    }
    else if (programTypeDefine === 'philpen_tcl') {
      import('./pages/health-programs/philpen.js');
      console.log('hello 2');
    } else {
      import('./pages/health-programs/view-consultation.js');
      import('./pages/health-programs/update-consultation.js');
    }
  }
  else if (bodyClass.contains('brgy-logs')) {
    import('./pages/logs/brgy-logs.js');
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
  Alpine.data('notificationHandler', notificationHandler);
});

Alpine.start();