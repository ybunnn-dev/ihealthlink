<div id="addResidentModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t pt-6 px-6 mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Add Existing Resident
                </h3>
                <p class="text-sm text-normal_font">Search for a resident to add to this family.</p>
            </div>

            <div class="p-4 md:p-5 space-y-4 h-[60vh] flex flex-col">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label for="resident-search" class="sr-only">Search for resident</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="resident-search" class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search by ID or Name...">
                        </div>
                    </div>
                    <div>
                        <select id="resident-age-group-filter" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 w-full text-sm">
                            <option selected value="All age group">All age group</option>
                            <option value="Infant (0-1)">Infant (0-1)</option>
                            <option value="Child (2-12)">Child (2-12)</option>
                            <option value="Teen (13-17)">Teen (13-17)</option>
                            <option value="Adult (18-59)">Adult (18-59)</option>
                            <option value="Senior (60+)">Senior (60+)</option>
                        </select>
                    </div>
                </div>

                <div id="residentCardContainer" class="space-y-2 flex-grow overflow-y-auto border rounded-lg p-3">
                    
                    <button type="button" 
                            data-resident-id="RES-101" 
                            class="resident-selection-card flex items-center p-3 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 focus:outline-none">
                        <div class="flex justify-between w-full text-left">
                            <div>
                                <p class="font-semibold text-main_font">Jose Rizal</p>
                                <p class="text-xs text-gray-500">
                                    <span>ID: RES-101</span>
                                    <span class="mx-1.5">&middot;</span>
                                    <span>Purok 1</span>
                                </p>
                            </div>
                            <div class="flex items-center text-xs text-gray-600">
                                <span class="bg-gray-200 px-2 py-1 rounded-full">Age: 30</span>
                            </div>
                        </div>
                    </button>

                    </div>
            </div>

            <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button id="cancelAddResident" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Close</button>
                <button id="confirmAddResidentBtn" disabled type="button" class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center ms-3 disabled:opacity-50">Add Resident</button>
            </div>

        </div>
    </div>
</div>
@include('components.modals.family.add-existing-resident-confirmation')