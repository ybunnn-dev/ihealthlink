<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">BHWs</h1>
            <div class="bg-f7 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
                        <div class="pb-6">
                            <!-- Flex container -->
                            <div class="flex flex-col slg2:flex-row slg2:items-end gap-4">
                                <!-- Search bar -->
                                <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
                                <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search</label> 
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                    </div>
                                    <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                                </div>
                                </div>
                                
                                <!-- Filters and button container -->
                               <!-- Filter Dropdown -->
                                <div class="flex flex-col xs:flex-row gap-4 slg2:items-end flex-none">
                                    <div class="w-full xs:w-48">
                                        <label for="purokDropdown" class="mb-2 text-sm font-medium text-main_font">Filter By</label>
                                        <button id="purokDropdown" data-dropdown-toggle="purokDropdownMenu"
                                            class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                            Alphabetical
                                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="m1 1 4 4 4-4" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown menu -->
                                        <div id="purokDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="purokDropdown">
                                                <li>
                                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Alphabetical</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Age Ascending</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Age Descending</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                    
                                    <!-- Date Filter -->
                                    <div class="w-full xs:w-48">
                                        <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label> 
                                        <button id="dateDropdown" data-dropdown-toggle="dateDropdownMenu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        Date
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Add Household Button -->
                                    <div class="w-full xs:w-40 pt-5 xs:pt-0">
                                        <button type="button" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3">Add BHW</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Dropdown menus -->
                        <div id="purokDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Option 1</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Option 2</a></li>
                        </ul>
                        </div>

                        <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Week</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Year</a></li>
                        </ul>
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                            <thead class="text-xs text-main_font uppercase text-center">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        BHW No.
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        BHWs Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Assigned Purok
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date Added
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date Updated
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b bg-f7 text-normal_font text-center">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                        121
                                    </th>
                                    <td class="px-6 py-4">
                                        Jose P. Manalo
                                    </td>
                                    <td class="px-6 py-4">
                                        Purok 3
                                    </td>
                                    <td class="px-6 py-4">
                                        Feb 10, 2025
                                    </td>
                                    <td class="px-6 py-4">
                                        Feb 10, 2025
                                    </td>
                                </tr>
                                <tr class="bg-white border-b bg-f7 text-normal_font text-center">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                        122
                                    </th>
                                    <td class="px-6 py-4">
                                        Wally P. Bayola
                                    </td>
                                    <td class="px-6 py-4">
                                        Purok 5
                                    </td>
                                    <td class="px-6 py-4">
                                        Feb 11, 2025
                                    </td>
                                    <td class="px-6 py-4">
                                        Feb 14, 2025
                                    </td>
                                </tr>
                                <tr class="bg-white border-b bg-f7 text-normal_font text-center">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                        123
                                    </th>       
                                    <td class="px-6 py-4">
                                        Paulo P. Ballesteros
                                    </td>             
                                    <td class="px-6 py-4">
                                        Purok 7
                                    </td>
                                    <td class="px-6 py-4">
                                        Feb 9, 2025
                                    </td>
                                    <td class="px-6 py-4">
                                        Feb 12, 2025
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>