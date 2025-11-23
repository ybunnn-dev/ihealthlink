<div class="flex flex-col h-full">
    <!-- Filter Section -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4 shrink-0 px-1">
        <!-- Search Input (Spans 3 cols on desktop) -->
        <div class="md:col-span-3">
            <label for="selectMotherResidentSearchInput" class="sr-only">Search for Mother</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="selectMotherResidentSearchInput" class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 ps-10" placeholder="Search for mother's name...">
            </div>
        </div>

        <!-- Filter (Spans 2 cols on desktop) - QR Button Removed -->
        <div class="md:col-span-2">
            <select id="selectMotherResidentPurokFilter" class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                <option value="" selected>Filter by Purok</option>
                <!-- Add purok options here -->
            </select>
        </div>
    </div>

    <!-- Container for the filtered list of residents -->
    <div id="selectMotherResidentListContainer" class="flex-grow overflow-y-auto border border-gray-200 rounded-lg p-3 space-y-3 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
        <!-- Mother items will be dynamically inserted here -->
        <div class="text-center text-gray-400 py-10 italic">Search to find mother...</div>
    </div>
</div>