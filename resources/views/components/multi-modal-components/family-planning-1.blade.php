  <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">

    <div class="md:col-span-3">
        <label for="enrollFPResidentSearchInput" class="sr-only">Search Resident</label>
        <input type="text" id="enrollFPResidentSearchInput" class="border text-sm border-gray-300 text-gray-700 rounded-lg p-2.5 w-full" placeholder="Search resident by name...">
    </div>

    <div class="flex items-center gap-2 md:col-span-2">
       <div class="relative w-full">
            <input type="hidden" id="enrollFPResidentPurokFilter">

            <!-- Trigger Button -->
            <button id="enrollFPResidentPurokFilter_button"
                data-dropdown-toggle="enrollFPResidentPurokFilter_dropdown"
                type="button"
                class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 text-left flex justify-between items-center">
                <span id="enrollFPResidentPurokFilter_label">Filter by Purok</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="enrollFPResidentPurokFilter_dropdown"
                class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full max-h-60 overflow-y-auto border border-gray-300">
                <ul id="enrollFPResidentPurokFilter_options" class="py-2 text-sm text-gray-700">
                    <!-- Options populated by JS -->
                    <!-- Example static option: -->
                    <!-- <li><button type="button" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Purok 1</button></li> -->
                </ul>
            </div>
        </div>
       
    </div>
</div>

<div id="enrollFPResidentListContainer" class="space-y-3 h-[30vh] overflow-y-auto border rounded-lg p-3">
</div>