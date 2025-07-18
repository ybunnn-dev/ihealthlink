document.addEventListener('DOMContentLoaded', function() {
    // Get references to the tab elements
    const healthProgramsTab = document.getElementById('healthProgramsTab');
    const philpenDataTab = document.getElementById('philpenDataTab');

    // Get references to the content areas (the whole cards this time)
    const healthProgramsCard = document.getElementById('healthProgramsCard');
    const philpenDataContent = document.getElementById('philpenDataContent');

    /**
        * Activates the specified tab and displays its content,
        * while deactivating and hiding other tabs and their content.
        * @param {string} tabToActivate - The ID of the tab to activate ('healthPrograms' or 'philpenData').
    */
    function activateTab(tabToActivate) {
        // --- Deactivate all tabs visually ---
        // Health Programs Tab
        healthProgramsTab.querySelector('span').classList.remove('text-sub_blue');
        healthProgramsTab.querySelector('span').classList.add('text-gray-500');
        healthProgramsTab.querySelector('div').classList.remove('bg-sub_blue');
        healthProgramsTab.querySelector('div').classList.add('bg-transparent');

        // PhilPen Data Tab
        philpenDataTab.querySelector('span').classList.remove('text-sub_blue');
        philpenDataTab.querySelector('span').classList.add('text-gray-500');
        philpenDataTab.querySelector('div').classList.remove('bg-sub_blue');
        philpenDataTab.querySelector('div').classList.add('bg-transparent');

        // --- Hide all content sections initially ---
        healthProgramsCard.classList.add('hidden'); // Hide the entire Health Programs card
        philpenDataContent.classList.add('hidden'); // Hide the PhilPen Data content

        // --- Activate the selected tab and show its content ---
        if (tabToActivate === 'healthPrograms') {
            healthProgramsTab.querySelector('span').classList.add('text-sub_blue');
            healthProgramsTab.querySelector('span').classList.remove('text-gray-500');
            healthProgramsTab.querySelector('div').classList.add('bg-sub_blue');
            healthProgramsTab.querySelector('div').classList.remove('bg-transparent');
            healthProgramsCard.classList.remove('hidden'); // Show the entire Health Programs card
        } else if (tabToActivate === 'philpenData') {
            philpenDataTab.querySelector('span').classList.add('text-sub_blue');
            philpenDataTab.querySelector('span').classList.remove('text-gray-500');
            philpenDataTab.querySelector('div').classList.add('bg-sub_blue');
            philpenDataTab.querySelector('div').classList.remove('bg-transparent');
            philpenDataContent.classList.remove('hidden'); // Show the PhilPen Data content
        }
    }
    // --- Add click event listeners to the tabs ---
    healthProgramsTab.addEventListener('click', function() {
        activateTab('healthPrograms');
    });

    philpenDataTab.addEventListener('click', function() {
        activateTab('philpenData');
    });

    // --- Set the initial active tab when the page loads ---
    // By default, 'Health Programs' will be active and visible, showing its card.
    activateTab('healthPrograms');
});