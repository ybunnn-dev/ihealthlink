<div class="flex flex-col h-full">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4 shrink-0 px-1">

        <div class="md:col-span-3">
            <label for="enrollFPResidentSearchInput" class="sr-only">Search Resident</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="enrollFPResidentSearchInput" class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 ps-10" placeholder="Search resident name...">
            </div>
        </div>

        <div class="flex items-center gap-2 md:col-span-2">
           <div class="relative w-full">
                <input type="hidden" id="enrollFPResidentPurokFilter">

                <button id="enrollFPResidentPurokFilter_button"
                    data-dropdown-toggle="enrollFPResidentPurokFilter_dropdown"
                    type="button"
                    class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 text-left flex justify-between items-center">
                    <span id="enrollFPResidentPurokFilter_label">Filter by Purok</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="enrollFPResidentPurokFilter_dropdown"
                    class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-xl w-full max-h-60 overflow-y-auto border border-gray-200">
                    <ul id="enrollFPResidentPurokFilter_options" class="py-2 text-sm text-gray-700">
                        </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="enrollFPResidentListContainer" class="flex-grow overflow-y-auto border border-gray-200 rounded-lg p-3 space-y-3 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
        <div class="text-center text-gray-400 py-10 italic">Search to find a resident...</div>
    </div>
</div>