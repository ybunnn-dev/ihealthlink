<div id="switchHouseholdModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <!-- 
            Responsive Card: 
            - Removed fixed 'h-[85vh]' in favor of 'max-h-[85vh]' for better adaptability.
            - Adjusted padding: px-4 on mobile, px-8 on desktop.
        -->
        <div class="relative bg-white rounded-lg shadow-xl flex flex-col max-h-[85vh] py-6 px-4 md:py-8 md:px-8 transition-transform duration-300 ease-out scale-95">
             
             <!-- Header -->
             <div class="flex items-center justify-center rounded-t mb-4 md:mb-6 shrink-0">
                <div class="text-center w-full">
                    <h3 class="text-xl md:text-2xl font-semibold text-main_font">
                        Switch Household
                    </h3>
                    <p class="text-sm text-normal_font mt-1">
                        To continue, please select the household you wish to transfer to.
                    </p>
                </div>
            </div>
            
            <!-- Body Content (Scrollable) -->
            <div class="space-y-4 flex flex-col min-h-0 flex-grow">
                
                <!-- Search & Filter Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4 shrink-0">
                    <div class="md:col-span-2">
                        <label for="household-search" class="sr-only">Search for household</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <!-- Increased padding (p-3) for touch -->
                            <input type="search" id="household-search" class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search by ID or Head...">
                        </div>
                    </div>
                    <div>
                        <!-- Increased padding (py-3) for touch -->
                        <button id="purokFilterDropdownButton" data-dropdown-toggle="purokFilterDropdownMenu" class="w-full text-main_font bg-gray-50 font-medium border border-gray-300 rounded-lg text-sm px-4 py-3 text-center inline-flex items-center justify-between hover:bg-gray-100 transition-colors" type="button">
                            All Puroks
                            <svg class="w-2.5 h-2.5 ms-3" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="purokFilterDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full md:w-44 border border-gray-100">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="purokFilterDropdownButton">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All Puroks</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 1</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 2</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="householdCardContainer" class="space-y-2 flex-grow overflow-y-auto border border-gray-200 rounded-lg p-2 md:p-3 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                 
                </div>
            </div>
            
            <!-- Footer: Stacked buttons mobile, side-by-side desktop -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end pt-6 gap-3 shrink-0">
                <button id="cancelChooseHousehold" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-colors">
                    Close
                </button>
                <button id="choosenHouseholdBtn" disabled type="button" 
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm">
                    Change Household
                </button>
            </div>
        </div>
    </div>
</div>