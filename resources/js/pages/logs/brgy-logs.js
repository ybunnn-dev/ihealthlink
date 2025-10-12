// --- Modal Element Setup ---
// Get the modal element
const viewLogModalElement = document.getElementById('view-log-modal');
// Get the elements inside the modal that will display the data
const logUserEl = document.getElementById('view-log-user');
const logRoleEl = document.getElementById('view-log-role');
const logDateTimeEl = document.getElementById('view-log-datetime');
const logActivityEl = document.getElementById('view-log-activity');
const closeLogModalBtn = document.getElementById('close-view-log-modal');

// Flowbite modal options
const modalOptions = {
    placement: 'center',
    backdrop: 'dynamic',
    closable: true,
};

// Create a new Flowbite modal instance
const viewLogModal = new Modal(viewLogModalElement, modalOptions);

// Add event listener to the close button
closeLogModalBtn.addEventListener('click', () => {
    viewLogModal.hide();
});

// --- Button Click Handling ---
// Select all "View" buttons
const viewButtons = document.querySelectorAll('.view-log-btn');

// Loop through each button
viewButtons.forEach(button => {
    button.addEventListener('click', async function (event) {
        event.preventDefault();
        const logId = this.dataset.id;
        const url = `/barangay/logs/${logId}`;

        try {
            // Fetch the data from the server
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const logData = await response.json();

            // --- Populate Modal with Fetched Data ---
            if (logData && logData.user) {
                // Construct the full name
                const fullName = `${logData.user.firstName || ''} ${logData.user.middleName || ''} ${logData.user.lastName || ''}`.trim();
                logUserEl.textContent = fullName || 'N/A';

                // Determine the role
                let role = 'Unknown';
                if (logData.user.role_id === 2) {
                    role = 'Midwife';
                } else if (logData.user.role_id === 3) {
                    role = 'BHW';
                }
                logRoleEl.textContent = role;
            }

            // Format the date and time
            const eventDate = new Date(logData.created_at);
            logDateTimeEl.textContent = eventDate.toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });

            // Set the activity description
            logActivityEl.textContent = logData.activity || 'No activity description provided.';

            // Show the populated modal
            viewLogModal.show();

        } catch (error) {
            console.error('Failed to fetch or display log details:', error);
        }
    });
});