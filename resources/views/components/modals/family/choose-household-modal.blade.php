<div id="switchHouseholdModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg flex flex-col h-[85vh] py-4 px-12 transition-transform duration-300 ease-out scale-95">
             <div class="flex items-center justify-center rounded-t mb-6">
                <div class="text-center w-full">
                    <h3 class="text-xl font-semibold text-main_font">
                        Switch Household
                    </h3>
                    <p class="text-sm text-normal_font mt-1">
                        To continue, please select the household you wish to transfer to.
                    </p>
                </div>
            </div>
            
            <div class="p-4 md:p-5 space-y-4 h-[60vh] flex flex-col">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <label for="household-search" class="sr-only">Search for household</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="household-search" class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search by ID or Head...">
                        </div>
                    </div>
                    <div>
                        <button id="purokFilterDropdownButton" data-dropdown-toggle="purokFilterDropdownMenu" class="w-full text-main_font bg-gray-50 font-medium border border-gray-300 rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center justify-between" type="button">
                            All Puroks
                            <svg class="w-2.5 h-2.5 ms-3" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="purokFilterDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="purokFilterDropdownButton">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All Puroks</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 1</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 2</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="householdCardContainer" class="space-y-2 flex-grow overflow-y-auto border rounded-lg p-3">
                    <!-- Household cards will be dynamically inserted here -->
                </div>
            </div>
            
            <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button id="cancelChooseHousehold" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Close</button>
                <button id="choosenHouseholdBtn" disabled type="button" class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center ms-3 disabled:opacity-50">Change Household</button>
            </div>
        </div>
    </div>
</div>