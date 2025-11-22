@section('title', 'Logs')
@section('page-id', 'brgy-logs')
<x-app-layout>
    <div class="py-12 px-5" x-data="{ 
        showPrivacy: localStorage.getItem('showPrivacy') ? JSON.parse(localStorage.getItem('showPrivacy')) : false
    }">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Logs</h1>
            <div class="bg-f7 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
                        <div class="pb-6 w-full">
                            <div class="grid grid-cols-1 slg2:grid-cols-8 xl:grid-cols-12 gap-4 w-full items-end">
                                
                                <div class="w-full col-span-1 slg2:col-span-8 xl:col-span-5">
                                    <label for="search-logs" class="mb-2 text-sm font-medium text-main_font">Search by name or activity?</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="search" 
                                            id="search-logs" 
                                            x-bind:disabled="!showPrivacy" 
                                            x-bind:title="!showPrivacy ? 'Enable privacy view to use search' : ''" 
                                            class="disabled:bg-gray-200 block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                                            placeholder="Search..."/>
                                    </div>
                                </div>

                                <div class="col-span-1 slg2:col-span-2 xl:col-span-2">
                                    <label for="moduleDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by Module</label>
                                    <button 
                                        id="moduleDropdown" 
                                        data-dropdown-toggle="moduleDropdownMenu" 
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''" 
                                        class="disabled:bg-gray-200 w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" 
                                        type="button">
                                        <span class="truncate" id="module-label">All Modules</span>
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="col-span-1 slg2:col-span-2 xl:col-span-2">
                                    <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label>
                                    <button 
                                        id="dateDropdown" 
                                        data-dropdown-toggle="dateDropdownMenu" 
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''" 
                                        class="disabled:bg-gray-200 w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" 
                                        type="button">
                                        <span class="truncate" id="date-label">Latest</span>
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="col-span-1 slg2:col-span-2 xl:col-span-2">
                                    <label for="dateFilterDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by Date</label>
                                    <button 
                                        id="dateFilterDropdown" 
                                        data-dropdown-toggle="dateFilterDropdownMenu" 
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''" 
                                        class="disabled:bg-gray-200 w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" 
                                        type="button">
                                        <span class="truncate" id="date-filter-label">All Time</span>
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </div>

                                <div class="col-span-1 slg2:col-span-2 xl:col-span-1">
                                    <x-hide-button />
                                </div>
                            </div>
                        </div>

                        <!-- Module Dropdown Menu -->
                        <div id="moduleDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <li><a href="#" data-module-id="" class="module-option block px-4 py-2 hover:bg-gray-100">All Modules</a></li>
                                @forelse($modules as $module)
                                    <li><a href="#" data-module-id="{{ $module->id }}" class="module-option block px-4 py-2 hover:bg-gray-100">{{ $module->module_name }}</a></li>
                                @empty
                                    <li><a href="#" class="block px-4 py-2 text-gray-400">No modules available</a></li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Date Dropdown Menu -->
                        <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <li><a href="#" data-sort="desc" class="date-option block px-4 py-2 hover:bg-gray-100">Latest First</a></li>
                                <li><a href="#" data-sort="asc" class="date-option block px-4 py-2 hover:bg-gray-100">Oldest First</a></li>
                            </ul>
                        </div>

                        <div id="loading-indicator" class="hidden text-center py-10">
                            <svg class="animate-spin h-8 w-8 text-mainblue mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <!-- Date Filter Dropdown Menu -->
                        <div id="dateFilterDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <li><a href="#" data-filter="all" class="date-filter-option block px-4 py-2 hover:bg-gray-100">All Time</a></li>
                                <li><a href="#" data-filter="last_week" class="date-filter-option block px-4 py-2 hover:bg-gray-100">Last Week</a></li>
                                <li><a href="#" data-filter="last_year" class="date-filter-option block px-4 py-2 hover:bg-gray-100">Last Year</a></li>
                                <li><a href="#" data-filter="custom" class="date-filter-option block px-4 py-2 hover:bg-gray-100">Custom Range</a></li>
                            </ul>
                        </div>


                        <div class="relative overflow-x-auto rounded-lg">
                            <table class="w-full text-sm text-left text-main_font">
                                <thead class="text-xs text-main_font uppercase bg-col_tab_h">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">LOG #</th>
                                        <th scope="col" class="px-6 py-3">NAME</th>
                                        <th scope="col" class="px-6 py-3">ROLE</th>
                                        <th scope="col" class="px-6 py-3">ACTIVITY</th>
                                        <th scope="col" class="px-6 py-3">DATE & TIME</th>
                                        <th scope="col" class="px-6 py-3">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody id="log-table-body">
                                    @include('components.logs.log-table-rows')
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6" id="pagination-container">
                            @include('components.logs.log-pagination')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modals.logs.bhs-logs')
    @include('components.modals.reports.filter-date')
</x-app-layout>
