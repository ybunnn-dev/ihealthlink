<div class="p-6 pt-6">
    <div class="grid grid-rows-1 gap-1">
        <div class="pb-6">
            <div class="flex flex-col slg2:flex-row slg2:items-end gap-4">
                {{-- Date Filter Dropdown --}}
                <div class="w-full slg2:w-48">
                    <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label> 
                    <button id="dateDropdown" 
                        data-dropdown-toggle="dateDropdownMenu" 
                        class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" 
                        type="button">
                        <span id="dateDropdownText">All Time</span>
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    
                    {{-- Dropdown Menu --}}
                    <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-normal_font">
                            <li data-date-filter="" data-date-name="All Time" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                All Time
                            </li>
                            <li data-date-filter="Last Week" data-date-name="Last Week" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                Last Week
                            </li>
                            <li data-date-filter="Month" data-date-name="This Month" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                This Month
                            </li>
                            <li data-date-filter="Last Year" data-date-name="Last Year" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                Last Year
                            </li>
                            <li id="customDateTrigger" class="cursor-pointer px-4 py-2 hover:bg-gray-100 border-t border-gray-200">
                                Custom Range
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Active Filter Display --}}
                <div id="activeFilterDisplay" class="text-sm text-normal_font hidden">
                    <span id="activeFilterText"></span>
                    <button id="clearFilter" class="ml-2 text-red-500 hover:text-red-700">Clear</button>
                </div>

                {{-- Loading Indicator --}}
                <div id="loadingIndicator" class="hidden">
                    <span class="text-sm text-gray-500">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Container --}}
    <div id="consultationTableContainer">
        <x-resident.consultation-history-table :history="$history" />
    </div>
</div>
