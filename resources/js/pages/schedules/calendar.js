// --- 1. GET HTML REFERENCES ---
const currentMonthEl = document.getElementById('currentMonth');
const calendarDatesEl = document.getElementById('calendarDates');
const prevMonthBtn = document.getElementById('prevMonthBtn');
const nextMonthBtn = document.getElementById('nextMonthBtn');
const scheduleListBody = document.getElementById('schedule-list-body');
const scheduleDateHeader = document.getElementById('schedule-date-header');

const currentActivityDetails = document.getElementById('current-activity-details');
const noActivityMessage = document.getElementById('no-activity-message');

const viewActivity = document.getElementById('view-activity');
const viewDate = document.getElementById('view-date');
const viewTime = document.getElementById('view-time');
const viewVenue = document.getElementById('view-venue');
const viewProgram = document.getElementById('view-program');
const viewBhws = document.getElementById('view-bhws');


// --- 2. DEFINE STATE ---
let currentDate = new Date();
let selectedDate = new Date(); // Defaults to highlighting today's date

/**
 * Displays the "no schedule" message and hides the details view.
 */
function displayNoScheduleView() {
    currentActivityDetails.classList.add('hidden');
    noActivityMessage.classList.remove('hidden');
}

/**
 * Populates the details view with schedule info and displays it.
 * @param {string} scheduleId - The ID of the schedule to view.
 */
function handleViewSchedule(scheduleId) {
    const schedule = window.scheds.find(s => s.id == scheduleId);

    if (schedule) {
        // NOTE: Assumes your server-side query has joined and added
        // 'health_program_name' and 'bhw_name' to the schedule object.
        viewActivity.textContent = schedule.activity || 'N/A';
        viewDate.textContent = new Date(schedule.date + 'T00:00:00').toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        viewTime.textContent = formatTime(schedule.time);
        viewVenue.textContent = schedule.venue || 'N/A';
        viewProgram.textContent = schedule.health_program_name || 'N/A';
        viewBhws.textContent = schedule.bhw_name || 'N/A';

        // Show the details view and hide the empty message
        currentActivityDetails.classList.remove('hidden');
        noActivityMessage.classList.add('hidden');
    } else {
        // If for some reason a schedule isn't found, show the empty state
        displayNoScheduleView();
    }
}


/**
 * Handles the click event for the 'Edit' button.
 * @param {string} scheduleId - The ID of the schedule to edit.
 */
function handleEditSchedule(scheduleId) {
    const schedule = window.scheds.find(s => s.id == scheduleId);
    if (schedule) {
        console.log("Edit clicked:", schedule);
        // You can later add code here to show an edit form.
    }
}

/**
 * Handles the click event for the 'Delete' button.
 * @param {string} scheduleId - The ID of the schedule to delete.
 */
function handleDeleteSchedule(scheduleId) {
    const schedule = window.scheds.find(s => s.id == scheduleId);
    if (schedule) {
        console.log("Delete clicked:", schedule);
        // You can later add code here to show a confirmation modal.
    }
}
// --- 3. PROCESS DATABASE DATA ---
// Assumes 'window.scheds' is defined by your server and now uses the 'date' key.
const scheduleData = {};
if (window.scheds && Array.isArray(window.scheds)) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    window.scheds.forEach(schedule => {
        // ✨ UPDATED: Using 'schedule.date' to match your table column.
        const scheduleDateStr = schedule.date; 
        if (!scheduleDateStr) return;

        const scheduleDate = new Date(scheduleDateStr + 'T00:00:00');

        if (scheduleDate < today) {
            scheduleData[scheduleDateStr] = 'completed';
        } else {
            scheduleData[scheduleDateStr] = 'scheduled';
        }
    });
}

scheduleListBody.addEventListener('click', (event) => {
    const button = event.target.closest('button'); // Find the button that was clicked

    if (!button) return; // Exit if the click was not on a button

    const scheduleId = button.dataset.scheduleId; // Get the schedule ID from the button's data attribute

    // Check which button was clicked by its class and call the correct function
    if (button.classList.contains('js-view-schedule-btn')) {
        handleViewSchedule(scheduleId);
    } else if (button.classList.contains('js-edit-schedule-btn')) {
        handleEditSchedule(scheduleId);
    } else if (button.classList.contains('js-delete-schedule-btn')) {
        handleDeleteSchedule(scheduleId);
    }
});

/**
 * Updates the schedule list UI with a given set of schedules for a specific date.
 * @param {Array} schedules - An array of schedule objects for the day.
 * @param {Date} date - The date object for which to display schedules.
 */
function updateScheduleList(schedules, date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    scheduleDateHeader.textContent = date.toLocaleDateString('en-US', options);

    if (schedules && schedules.length > 0) {
        const rowsHtml = schedules.map(schedule => {
            // ✨ NEW: Check if the schedule is completed
            const isCompleted = scheduleData[schedule.date] === 'completed';

            return `
                <tr class="bg-f7 border-b text-normal_font" data-schedule-id="${schedule.id}">
                    <td id="activity-${schedule.id}" class="px-6 py-3 truncate" title="${schedule.activity}">${schedule.activity}</td>
                    <td id="time-${schedule.id}" class="px-6 py-3">${formatTime(schedule.time)}</td>
                    <td id="venue-${schedule.id}" class="px-6 py-3">${schedule.venue}</td>
                    <td class="px-6 py-3 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center space-x-2">
                            <button type="button" class="js-view-schedule-btn text-gray-500 hover:text-gray-800" data-schedule-id="${schedule.id}" title="View Schedule">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                            </button>
                            
                            <button type="button" 
                                    class="js-edit-schedule-btn text-mainblue hover:text-blue-900 ${isCompleted ? 'opacity-50 cursor-not-allowed' : ''}" 
                                    data-schedule-id="${schedule.id}" 
                                    title="Edit Schedule"
                                    ${isCompleted ? 'disabled' : ''}>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                            </button>
                            
                            <button type="button" 
                                    class="js-delete-schedule-btn text-red-500 hover:text-red-700 ${isCompleted ? 'opacity-50 cursor-not-allowed' : ''}" 
                                    data-schedule-id="${schedule.id}" 
                                    title="Delete Schedule"
                                    ${isCompleted ? 'disabled' : ''}>
                               <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
        scheduleListBody.innerHTML = rowsHtml;
    } else {
        scheduleListBody.innerHTML = `<tr class="bg-white">
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                                <div class="text-center py-10">
                                                    <img src="${emptyStateImageUrl}" alt="No barangays found" class="mx-auto w-20">
                                                    <p class="mt-5 text-lg font-medium text-gray-700">
                                                        No activities here.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    `;
    }
}

function formatTime(timeString) {
    if (!timeString) return '';
    const [hour, minute] = timeString.split(':');
    const hourInt = parseInt(hour, 10);
    const ampm = hourInt >= 12 ? 'PM' : 'AM';
    const convertedHour = hourInt % 12 || 12;
    return `${convertedHour}:${minute} ${ampm}`;
}

// --- 4. THE MAIN RENDER FUNCTION ---
const renderCalendar = () => {
    calendarDatesEl.innerHTML = ''; 

    const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
    const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    currentMonthEl.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

    for (let i = 0; i < firstDayOfMonth; i++) {
        calendarDatesEl.appendChild(document.createElement('div'));
    }

    for (let i = 1; i <= daysInMonth; i++) {
        const dateButton = document.createElement('button');
        dateButton.classList.add('p-2', 'transition', 'ease-in-out', 'duration-150', 'text-gray-800');
        dateButton.textContent = i;
        dateButton.type = 'button';

        const thisDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), i);
        
        // --- EVENT LISTENER WITH NEW LOGIC ---
        dateButton.addEventListener('click', () => {
            // Update the calendar highlight and re-render
            selectedDate = thisDate;
            renderCalendar(); 
            
            // Format the clicked date to match the database format 'YYYY-MM-DD'
            const year = thisDate.getFullYear();
            const month = String(thisDate.getMonth() + 1).padStart(2, '0');
            const day = String(thisDate.getDate()).padStart(2, '0');
            const clickedDateStr = `${year}-${month}-${day}`;
            
            // Filter schedules for the clicked day
            const schedulesForDay = window.scheds.filter(schedule => schedule.date === clickedDateStr);
            
            // ✨ Call the dedicated function to update the schedule list UI
            updateScheduleList(schedulesForDay, thisDate);

            if (schedulesForDay.length > 0) {
                // If there are schedules, view the first one by default
                handleViewSchedule(schedulesForDay[0].id);
            } else {
                // If there are no schedules, show the empty message
                displayNoScheduleView();
            }
        });

        const isSelected = selectedDate && thisDate.toDateString() === selectedDate.toDateString();
        const month = String(currentDate.getMonth() + 1).padStart(2, '0');
        const day = String(i).padStart(2, '0');
        const dateKey = `${currentDate.getFullYear()}-${month}-${day}`;
        const eventStatus = scheduleData[dateKey];

        if (isSelected) {
            dateButton.classList.add('bg-blue-500', 'text-white', 'rounded-full', 'font-bold');
            dateButton.classList.remove('text-gray-800');
        } else if (eventStatus === 'scheduled') {
            dateButton.classList.add('bg-blue-200', 'text-blue-800', 'rounded-full');
            dateButton.classList.remove('text-gray-800');
        } else if (eventStatus === 'completed') {
            dateButton.classList.add('bg-blue-100', 'text-blue-800', 'rounded-full');
            dateButton.classList.remove('text-gray-800');
        } else {
            dateButton.classList.add('hover:bg-gray-200', 'rounded-full');
        }

        calendarDatesEl.appendChild(dateButton);
    }
};

// --- 5. ATTACH EVENT LISTENERS & INITIAL RENDER ---
prevMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});


renderCalendar();


const today = new Date(); // Get today's date
const year = today.getFullYear();
const month = String(today.getMonth() + 1).padStart(2, '0');
const day = String(today.getDate()).padStart(2, '0');
const todayStr = `${year}-${month}-${day}`;

// Filter the master list for today's schedules
const schedulesForToday = window.scheds.filter(schedule => schedule.date === todayStr);

// Call your update function to populate the table with today's data
updateScheduleList(schedulesForToday, today);

if (schedulesForToday.length > 0) {
    // If there are schedules for today, view the first one
    handleViewSchedule(schedulesForToday[0].id);
} else {
    // Otherwise, show the empty message
    displayNoScheduleView();
}