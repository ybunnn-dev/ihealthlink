<div class="bg-white rounded-xl p-6 md:col-span-1">
    <div class="flex items-center justify-between mb-4">
        <button id="prevMonthBtn" class="text-gray-500 hover:text-gray-700">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <div id="currentMonth" class="text-lg font-semibold text-gray-900">May 2025</div>
        <button id="nextMonthBtn" class="text-gray-500 hover:text-gray-700">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>
    <div class="grid grid-cols-7 gap-2 text-center text-xs p-4 bg-bg_col rounded-lg">
        <div class="text-gray-500 font-medium">Sun</div>
        <div class="text-gray-500 font-medium">Mon</div>
        <div class="text-gray-500 font-medium">Tue</div>
        <div class="text-gray-500 font-medium">Wed</div>
        <div class="text-gray-500 font-medium">Thu</div>
        <div class="text-gray-500 font-medium">Fri</div>
        <div class="text-gray-500 font-medium">Sat</div>
        <div id="calendarDates" class="contents"></div>
    </div>
</div>