        // --- 1. GET HTML REFERENCES ---
        const currentMonthEl = document.getElementById('currentMonth');
        const calendarDatesEl = document.getElementById('calendarDates');
        const prevMonthBtn = document.getElementById('prevMonthBtn');
        const nextMonthBtn = document.getElementById('nextMonthBtn');

        // --- 2. DEFINE STATE AND DUMMY DATA ---
        
        // This tracks the month/year the calendar is displaying.
        let currentDate = new Date();
        
        // This tracks the specific day the user has clicked.
        // Initialize to today's date to highlight it on first load.
        let selectedDate = new Date();

        // Dummy data for events. Keys are in 'YYYY-MM-DD' format.
        const events = {
            '2025-09-02': 'completed',
            '2025-09-04': 'completed',
            '2025-09-10': 'scheduled',
            '2025-09-18': 'scheduled',
            '2025-10-15': 'scheduled',
        };

        // --- 3. THE MAIN RENDER FUNCTION ---
        const renderCalendar = () => {
            calendarDatesEl.innerHTML = ''; // Clear previous dates

            const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
            const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            currentMonthEl.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

            // Add empty divs for alignment
            for (let i = 0; i < firstDayOfMonth; i++) {
                const emptyDiv = document.createElement('div');
                calendarDatesEl.appendChild(emptyDiv);
            }

            // Generate date buttons
            for (let i = 1; i <= daysInMonth; i++) {
                const dateButton = document.createElement('button');
                dateButton.classList.add('p-2', 'transition', 'ease-in-out', 'duration-150', 'text-gray-800');
                dateButton.textContent = i;
                dateButton.type = 'button';

                const thisDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), i);

                // Update selectedDate and re-render on click
                dateButton.addEventListener('click', () => {
                    selectedDate = thisDate;
                    renderCalendar(); 
                });

                // --- Styling Logic ---
                const isSelected = selectedDate && thisDate.toDateString() === selectedDate.toDateString();
                
                const month = String(currentDate.getMonth() + 1).padStart(2, '0');
                const day = String(i).padStart(2, '0');
                const dateKey = `${currentDate.getFullYear()}-${month}-${day}`;
                const eventStatus = events[dateKey];

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

        // --- 4. ATTACH EVENT LISTENERS FOR NAVIGATION ---
        prevMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        nextMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        // --- 5. INITIAL RENDER ---
        renderCalendar();