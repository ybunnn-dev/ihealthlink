const scheduledTab = document.getElementById('scheduledTab');
const dailyTab = document.getElementById('dailyTab');
const scheduledContent = document.getElementById('scheduledContent');
const dailyContent = document.getElementById('dailyContent');

function activateTab(activeTab, activeContent, inactiveTab, inactiveContent) {
    // Show/hide content
    activeContent.classList.remove('hidden');
    inactiveContent.classList.add('hidden');

    // Get elements for styling
    const activeSpan = activeTab.querySelector('span');
    const activeDiv = activeTab.querySelector('div');
    const inactiveSpan = inactiveTab.querySelector('span');
    const inactiveDiv = inactiveTab.querySelector('div');

    // Style the active tab
    activeSpan.classList.add('text-sub_blue');
    activeSpan.classList.remove('text-gray-500');
    activeDiv.classList.add('bg-sub_blue');
    activeDiv.classList.remove('bg-transparent');

    // Style the inactive tab
    inactiveSpan.classList.add('text-gray-500');
    inactiveSpan.classList.remove('text-sub_blue');
    inactiveDiv.classList.add('bg-transparent');
    inactiveDiv.classList.remove('bg-sub_blue');
}

scheduledTab.addEventListener('click', () => {
    activateTab(scheduledTab, scheduledContent, dailyTab, dailyContent);
});

dailyTab.addEventListener('click', () => {
    activateTab(dailyTab, dailyContent, scheduledTab, scheduledContent);
});