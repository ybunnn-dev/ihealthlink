// Get references to the HTML elements
const currentMonthEl = document.getElementById('currentMonth');
const calendarDatesEl = document.getElementById('calendarDates');
const prevMonthBtn = document.getElementById('prevMonthBtn');
const nextMonthBtn = document.getElementById('nextMonthBtn');

// Initialize the current date to a specific month for demonstration
let currentDate = new Date(); // Or let currentDate = new Date('2025-05-01');

const renderCalendar = () => {
    // Clear the existing dates
    calendarDatesEl.innerHTML = '';

    // Get the first day of the month and total number of days
    const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
    const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

    // Update the month and year display
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    currentMonthEl.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

    // Add empty divs to align the first day
    for (let i = 0; i < firstDayOfMonth; i++) {
        const emptyDiv = document.createElement('div');
        emptyDiv.classList.add('p-2');
        calendarDatesEl.appendChild(emptyDiv);
    }

    // Generate date divs for the entire month
    for (let i = 1; i <= daysInMonth; i++) {
        const dateDiv = document.createElement('div');
        dateDiv.classList.add('p-2');
        dateDiv.textContent = i;
        
        // Example: Highlight a specific date (e.g., the 15th) and other dates with events
        if (i === 15) {
            dateDiv.classList.add('bg-blue-500', 'text-white', 'rounded-full');
        } else if (i === 16 || i === 27) {
            dateDiv.classList.add('bg-blue-200', 'text-blue-800', 'rounded-full');
        } else if (i === 17 || i === 18 || i === 27) {
            // Apply similar styling as your static example
            dateDiv.classList.add('bg-blue-100', 'text-blue-800', 'rounded-full');
        }

        calendarDatesEl.appendChild(dateDiv);
    }
};

// Event listeners for the navigation buttons
prevMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

// Initial render of the calendar
renderCalendar();