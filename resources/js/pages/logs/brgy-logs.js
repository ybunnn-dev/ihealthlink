// Prevent multiple executions
if (!window.viewLogModalInitialized) {
    window.viewLogModalInitialized = true;

    const createModalOptions = (modalEl) => ({
        placement: 'center-center',
        backdrop: 'static',
        closable: false,
        onShow: () => {
            setTimeout(() => {
                modalEl.classList.remove('opacity-0');
                modalEl.classList.add('opacity-100');
                
                const modalContent = modalEl.querySelector('.relative.bg-white');
                if (modalContent) {
                    modalContent.classList.remove('scale-95');
                    modalContent.classList.add('scale-100');
                }
            }, 10);
        },
        onHide: () => {
            modalEl.classList.add('opacity-0');
            modalEl.classList.remove('opacity-100');
            
            const modalContent = modalEl.querySelector('.relative.bg-white');
            if (modalContent) {
                modalContent.classList.add('scale-95');
                modalContent.classList.remove('scale-100');
            }
        }
    });

    const viewLogModalElement = document.getElementById('view-log-modal');
    const logUserEl = document.getElementById('view-log-user');
    const logRoleEl = document.getElementById('view-log-role');
    const logDateTimeEl = document.getElementById('view-log-datetime');
    const logActivityEl = document.getElementById('view-log-activity');
    const closeLogModalBtn = document.getElementById('close-view-log-modal');

    // Remove any existing modal backdrops first
    document.querySelectorAll('[modal-backdrop]').forEach(backdrop => {
        backdrop.remove();
    });

    // Create a new Flowbite modal instance
    const viewLogModal = new Modal(viewLogModalElement, createModalOptions(viewLogModalElement));

    // Add event listener to the close button
    closeLogModalBtn.addEventListener('click', () => {
        viewLogModal.hide();
    });

    // Use event delegation on the table body
    const tableBody = document.getElementById('log-table-body');

    if (tableBody) {
        tableBody.addEventListener('click', async function(event) {
            // Check if clicked element is a view button
            const button = event.target.closest('.view-log-btn');
            
            if (!button) return; // Not a view button, ignore
            
            event.preventDefault();
            console.log('Log ID:', button.dataset.id);
            
            const logId = button.dataset.id;
            const url = `/barangay/logs/${logId}`;

            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                console.log('Response status:', response.status);

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const logData = await response.json();

                console.log('Received logData:', logData);

                // Populate Modal with Fetched Data
                if (logData && logData.user) {
                    const fullName = `${logData.user.firstName || ''} ${logData.user.middleName || ''} ${logData.user.lastName || ''}`.trim();
                    logUserEl.textContent = fullName || 'N/A';

                    let role = 'Unknown';
                    if (logData.user.role_id === 2) {
                        role = 'Midwife';
                    } else if (logData.user.role_id === 3) {
                        role = 'BHW';
                    }
                    logRoleEl.textContent = role;
                }

                // USE THE FORMATTED DATE DIRECTLY
                logDateTimeEl.textContent = logData.created_at || 'N/A';

                // Set the activity description
                logActivityEl.textContent = logData.activity || 'No activity description provided.';

                // Show the populated modal
                viewLogModal.show();

            } catch (error) {
                console.error('Failed to fetch or display log details:', error);
            }
        });
    } else {
        console.error('Table body not found!');
    }
}
