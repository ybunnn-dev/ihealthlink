<div id="addResidentModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-6 md:py-10 px-6 transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t mb-6 text-center">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font">
                    Add Existing Resident
                </h3>
                <p class="text-sm text-normal_font mt-1">Search for a resident to add to this family.</p>
            </div>

            <div class="p-0 md:p-5 space-y-4 h-[60vh] flex flex-col">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4 mb-2 shrink-0">
                    <div class="md:col-span-2">
                        <label for="resident-search" class="sr-only">Search for resident</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="resident-search" class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search by ID or Name...">
                        </div>
                    </div>
                    <div>
                        <select id="resident-age-group-filter" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 text-sm">
                            <option selected value="All age group">All age group</option>
                            <option value="Infant (0-1)">Infant (0-1)</option>
                            <option value="Child (2-12)">Child (2-12)</option>
                            <option value="Teen (13-17)">Teen (13-17)</option>
                            <option value="Adult (18-59)">Adult (18-59)</option>
                            <option value="Senior (60+)">Senior (60+)</option>
                        </select>
                    </div>
                </div>

                <!-- Scrollable List -->
                <div id="residentCardContainer" class="space-y-3 flex-grow overflow-y-auto border border-gray-200 rounded-lg p-2 md:p-3 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    
                    <!-- Card Item -->
                    <button type="button" 
                            data-resident-id="RES-101" 
                            class="resident-selection-card group flex items-center p-4 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-400 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all">
                        <div class="flex justify-between w-full text-left items-center">
                            <div>
                                <p class="text-base font-semibold text-main_font group-hover:text-blue-700 transition-colors">Jose Rizal</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span>ID: RES-101</span>
                                    <span class="mx-1.5">&middot;</span>
                                    <span>Purok 1</span>
                                </p>
                            </div>
                            <div class="flex items-center text-xs font-medium text-gray-600">
                                <span class="bg-gray-100 px-2.5 py-1 rounded-full border border-gray-200">Age: 30</span>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6 mt-4">
                <button id="cancelAddResident" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-colors">
                    Close
                </button>
                <button id="confirmAddResidentBtn" disabled type="button" 
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm">
                    Add Resident
                </button>
            </div>

        </div>
    </div>
</div>
@include('components.modals.family.add-existing-resident-confirmation')