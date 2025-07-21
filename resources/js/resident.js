document.addEventListener('DOMContentLoaded', function() {
    // Get references to the tab elements
    const healthProgramsTab = document.getElementById('healthProgramsTab');
    const medRecTab = document.getElementById('medRecTab');
    const consultHistoryTab = document.getElementById('consultHistoryTab');

    // Get references to the content areas (the whole cards this time)
    const healthProgramsCard = document.getElementById('healthProgramsCard');
    const medRecContent = document.getElementById('medRecContent');
    const consultHistory = document.getElementById('consultationHistory');

    /**
        * Activates the specified tab and displays its content,
        * while deactivating and hiding other tabs and their content.
        * @param {string} tabToActivate - The ID of the tab to activate ('healthPrograms' or 'medRec').
    */
    function activateTab(tabToActivate) {
        // --- Deactivate all tabs visually ---
        // Health Programs Tab
        healthProgramsTab.querySelector('span').classList.remove('text-sub_blue');
        healthProgramsTab.querySelector('span').classList.add('text-gray-500');
        healthProgramsTab.querySelector('div').classList.remove('bg-sub_blue');
        healthProgramsTab.querySelector('div').classList.add('bg-transparent');

        // PhilPen Data Tab
        medRecTab.querySelector('span').classList.remove('text-sub_blue');
        medRecTab.querySelector('span').classList.add('text-gray-500');
        medRecTab.querySelector('div').classList.remove('bg-sub_blue');
        medRecTab.querySelector('div').classList.add('bg-transparent');

        consultHistoryTab.querySelector('span').classList.remove('text-sub_blue');
        consultHistoryTab.querySelector('span').classList.add('text-gray-500');
        consultHistoryTab.querySelector('div').classList.remove('bg-sub_blue');
        consultHistoryTab.querySelector('div').classList.add('bg-transparent');

        // --- Hide all content sections initially ---
        healthProgramsCard.classList.add('hidden'); // Hide the entire Health Programs card
        medRecContent.classList.add('hidden'); // Hide the PhilPen Data content
        consultHistory.classList.add('hidden');

        // --- Activate the selected tab and show its content ---
        if (tabToActivate === 'healthPrograms') {
            healthProgramsTab.querySelector('span').classList.add('text-sub_blue');
            healthProgramsTab.querySelector('span').classList.remove('text-gray-500');
            healthProgramsTab.querySelector('div').classList.add('bg-sub_blue');
            healthProgramsTab.querySelector('div').classList.remove('bg-transparent');
            healthProgramsCard.classList.remove('hidden'); // Show the entire Health Programs card
        } else if (tabToActivate === 'medRec') {
            medRecTab.querySelector('span').classList.add('text-sub_blue');
            medRecTab.querySelector('span').classList.remove('text-gray-500');
            medRecTab.querySelector('div').classList.add('bg-sub_blue');
            medRecTab.querySelector('div').classList.remove('bg-transparent');
            medRecContent.classList.remove('hidden'); // Show the PhilPen Data content
        }else{
            consultHistoryTab.querySelector('span').classList.add('text-sub_blue');
            consultHistoryTab.querySelector('span').classList.remove('text-gray-500');
            consultHistoryTab.querySelector('div').classList.add('bg-sub_blue');
            consultHistoryTab.querySelector('div').classList.remove('bg-transparent');
            consultHistory.classList.remove('hidden'); // Show the PhilPen Data content
        }
    }
    // --- Add click event listeners to the tabs ---
    healthProgramsTab.addEventListener('click', function() {
        activateTab('healthPrograms');
    });

    medRecTab.addEventListener('click', function() {
        activateTab('medRec');
    });

    consultHistoryTab.addEventListener('click', function() {
        activateTab('consultHistoryTab');
    });
    // --- Set the initial active tab when the page loads ---
    // By default, 'Health Programs' will be active and visible, showing its card.
    activateTab('medRec');
});