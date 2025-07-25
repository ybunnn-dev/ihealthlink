<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Title -->
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Reports</h1>
            <!-- Upper Card -->
            <div class="bg-white rounded-xl overflow-hidden p-6 mb-3">
                <div class="grid grid-cols-1 xl:grid-cols-5 xl:items-end gap-4">
                    <div class="col-span-1 xl:col-span-2">
                        <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for Reports</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 slg2:grid-cols-2 lg3:grid-cols-4 gap-4 items-end col-span-1 xl:col-span-3">
                        <div class="col-span-1">
                            <label for="filterDropdown" class="mb-2 text-sm font-medium text-main_font">Report Type</label>
                            <button id="filterDropdown" data-dropdown-toggle="filterDropdownMenu" class="w-full text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                Alphabetical
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                        </div>
                        <div class="col-span-1">
                            <label for="filterDropdown" class="mb-2 text-sm font-medium text-main_font">Date</label>
                            <button id="filterDropdown" data-dropdown-toggle="filterDropdownMenu" class="w-full text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                Alphabetical
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                        </div>

                        <div class="col-span-1">
                            <label for="targetPopulationDropdown" class="mb-2 text-sm font-medium text-main_font">Purok</label>
                            <button id="targetPopulationDropdown" data-dropdown-toggle="targetPopulationDropdownMenu" class="w-full text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                All
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                        </div>

                        <div class="col-span-1">
                            <button type="button" class="w-3/4 h-[2rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3">Export</button>
                        </div>
                    </div>
                </div>
                 <div id="filterDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                    <ul class="py-2 text-sm text-gray-700">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Alphabetical</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Most Enrolled</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Least Enrolled</a></li>
                    </ul>
                </div>
                <div id="filterDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                    <ul class="py-2 text-sm text-gray-700">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Alphabetical</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Most Enrolled</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Least Enrolled</a></li>
                    </ul>
                </div>
                <div id="targetPopulationDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                    <ul class="py-2 text-sm text-gray-700">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Children</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Adolescent</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Adults</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Elderly</a></li>
                    </ul>
                </div>
            </div>
            <div class="mb-3">
                <x-reports-tab></x-reports-tab>
            </div>
            <div>
                <x-report-blades.demographical-data></x-report-blades.demographical-data>
            </div>
        </div>
    </div>
</x-app-layout>







