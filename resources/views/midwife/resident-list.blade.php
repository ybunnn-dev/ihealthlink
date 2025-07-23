<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Households and Residents</h1>

            <div class="mb-3">
                <x-resident-module-nav></x-resident-module-nav>
            </div>

            <div class="bg-f7 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
                        <div class="pb-6">
                            <div class="flex flex-col slg2:flex-row slg2:items-end gap-4">
                                <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
                                    <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for Residents?</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search by name or resident #"/>
                                    </div>
                                </div>

                                <div class="flex flex-col xs:flex-row gap-4 slg2:items-end flex-none">
                                    <div class="w-full xs:w-48">
                                        <label for="purokDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by Purok</label>
                                        <button id="purokDropdown" data-dropdown-toggle="purokDropdownMenu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        All Purok
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                        </button>
                                    </div>

                                    <div class="w-full xs:w-48">
                                        <label for="ageGroupDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by Age Group</label>
                                        <button id="ageGroupDropdown" data-dropdown-toggle="ageGroupDropdownMenu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        All Age Groups
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                        </button>
                                    </div>

                                    <div class="w-full xs:w-40 pt-5 xs:pt-0">
                                        <button type="button" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3">Add Resident</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="purokDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg w-44 shadow">
                            <ul class="py-2 text-sm text-normal_font">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All Purok</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 1</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 2</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 3</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 4</a></li>
                            </ul>
                        </div>

                        <div id="ageGroupDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                            <ul class="py-2 text-sm text-normal_font">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All Age Groups</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Infant (0-1)</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Child (2-12)</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Teen (13-17)</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Adult (18-59)</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Senior (60+)</a></li>
                            </ul>
                        </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                            <thead class="text-xs text-main_font uppercase">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Resident #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Purok
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Sex
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Age
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Age Group
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b bg-f7 text-normal_font" onclick="window.location='{{ route('midwife.spec-resident') }}'">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                        R001
                                    </th>
                                    <td class="px-6 py-4">
                                        Juan Dela Cruz
                                    </td>
                                    <td class="px-6 py-4">
                                        Purok 1
                                    </td>
                                    <td class="px-6 py-4">
                                        Male
                                    </td>
                                    <td class="px-6 py-4">
                                        35
                                    </td>
                                    <td class="px-6 py-4">
                                        Adult
                                    </td>
                                </tr>
                                <tr class="bg-white border-b bg-f7 text-normal_font">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                        R002
                                    </th>
                                    <td class="px-6 py-4">
                                        Maria Clara
                                    </td>
                                    <td class="px-6 py-4">
                                        Purok 2
                                    </td>
                                    <td class="px-6 py-4">
                                        Female
                                    </td>
                                    <td class="px-6 py-4">
                                        28
                                    </td>
                                    <td class="px-6 py-4">
                                        Adult
                                    </td>
                                </tr>
                                <tr class="bg-white border-b bg-f7 text-normal_font">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                        R003
                                    </th>
                                    <td class="px-6 py-4">
                                        Pedro San Jose
                                    </td>
                                    <td class="px-6 py-4">
                                        Purok 1
                                    </td>
                                    <td class="px-6 py-4">
                                        Male
                                    </td>
                                    <td class="px-6 py-4">
                                        10
                                    </td>
                                    <td class="px-6 py-4">
                                        Child
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