@section('page-id', 'health-programs')
<x-app-layout>
    @section('title', 'Health Programs')
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <!-- Title -->
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Health Programs</h1>

            <div class="bg-f7 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
                        <div class="pb-6 w-full">
                            
                            <div class="grid grid-cols-1 slg2:grid-cols-8 xl:grid-cols-10 gap-4 w-full items-end">
                                
                                <!-- Search Bar -->
                                <div class="w-full col-span-1 slg2:col-span-7 xl:col-span-3">
                                    <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for health program?</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                                    </div>
                                </div>

                                <!-- Sort By Dropdown -->
                                <div class="col-span-1 slg2:col-span-2 relative">
                                    <label for="sortByDropdownBrgy" class="mb-2 text-sm font-medium text-main_font">Sort By</label>
                                    <button id="sortByDropdownBrgy" data-dropdown-toggle="sortByDropdownBrgyMenu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        Name
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <div id="sortByDropdownBrgyMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                        <ul class="py-2 text-sm text-normal_font" aria-labelledby="sortByDropdownBrgy">
                                            <li><a href="#" data-value="all" class="block px-4 py-2 hover:bg-gray-100">All</a></li>
                                            <li><a href="#" data-value="name" class="block px-4 py-2 hover:bg-gray-100">Name</a></li>
                                            <li><a href="#" data-value="residents_count" class="block px-4 py-2 hover:bg-gray-100">Enrolled Count</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Date Added Dropdown -->
                                <div class="col-span-1 slg2:col-span-2 relative">
                                    <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Date Added</label>
                                    <button id="dateDropdown" data-dropdown-toggle="dateDropdownMenu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        All Date
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dateDropdown">
                                            <li><a href="#" data-value="all" class="block px-4 py-2 hover:bg-gray-100">All Date</a></li>
                                            <li><a href="#" data-value="week" class="block px-4 py-2 hover:bg-gray-100">Last Week</a></li>
                                            <li><a href="#" data-value="month" class="block px-4 py-2 hover:bg-gray-100">Last Month</a></li>
                                            <li><a href="#" data-value="year" class="block px-4 py-2 hover:bg-gray-100">Last Year</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Add Program Button -->
                                <div class="col-span-1 slg2:col-span-3 xl:col-span-2">
                                    <button type="button" id="page-add-healthProgram-button" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3 flex items-center justify-center">
                                        Add Program
                                    </button>
                                </div>

                            </div>
                        </div>

                        {{-- Include the table component --}}
                        <x-health-program.table :healthPrograms="$healthPrograms" />

                        {{-- PAGINATION LINKS --}}
                        <div class="mt-4" id="pagination-links">
                            {{ $healthPrograms->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modals.health-program.add-health-program')
</x-app-layout>
