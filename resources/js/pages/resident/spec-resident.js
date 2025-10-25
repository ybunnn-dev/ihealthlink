
const medRecTab = document.getElementById('medRecTab');
const consultHistoryTab = document.getElementById('consultHistoryTab');


const medRecContent = document.getElementById('medRecContent');
const consultHistory = document.getElementById('consultationHistory');

/**
    * Activates the specified tab and displays its content,
    * while deactivating and hiding other tabs and their content.
    * @param {string} tabToActivate - The ID of the tab to activate ('healthPrograms' or 'medRec').
*/
function activateTab(tabToActivate) {

    // PhilPen Data Tab
    medRecTab.querySelector('span').classList.remove('text-sub_blue');
    medRecTab.querySelector('span').classList.add('text-gray-500');
    medRecTab.querySelector('div').classList.remove('bg-sub_blue');
    medRecTab.querySelector('div').classList.add('bg-transparent');

    consultHistoryTab.querySelector('span').classList.remove('text-sub_blue');
    consultHistoryTab.querySelector('span').classList.add('text-gray-500');
    consultHistoryTab.querySelector('div').classList.remove('bg-sub_blue');
    consultHistoryTab.querySelector('div').classList.add('bg-transparent');

    medRecContent.classList.add('hidden'); // Hide the PhilPen Data content
    consultHistory.classList.add('hidden');

    if (tabToActivate === 'medRec') {
        medRecTab.querySelector('span').classList.add('text-sub_blue');
        medRecTab.querySelector('span').classList.remove('text-gray-500');
        medRecTab.querySelector('div').classList.add('bg-sub_blue');
        medRecTab.querySelector('div').classList.remove('bg-transparent');
        medRecContent.classList.remove('hidden'); // Show the PhilPen Data content
    } else {
        consultHistoryTab.querySelector('span').classList.add('text-sub_blue');
        consultHistoryTab.querySelector('span').classList.remove('text-gray-500');
        consultHistoryTab.querySelector('div').classList.add('bg-sub_blue');
        consultHistoryTab.querySelector('div').classList.remove('bg-transparent');
        consultHistory.classList.remove('hidden'); // Show the PhilPen Data content
    }
}

medRecTab.addEventListener('click', function () {
    activateTab('medRec');
});

consultHistoryTab.addEventListener('click', function () {
    activateTab('consultHistoryTab');
});
// --- Set the initial active tab when the page loads ---
// By default, 'Health Programs' will be active and visible, showing its card.
activateTab('medRec');
