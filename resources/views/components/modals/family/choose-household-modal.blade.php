<div id="switchHouseholdModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg flex flex-col h-[85vh] py-4 px-12">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t mb-4">
                <div class="text-center w-full">
                    <h3 class="text-2xl font-semibold text-main_font">
                        Switch Household
                    </h3>
                    <p class="text-sm text-normal_font mt-1">
                        To continue, please select the household you wish to transfer to.
                    </p>
                </div>
            </div>
            <div class="space-y-4 flex-grow flex flex-col overflow-hidden">
                <div class="flex flex-col slg2:flex-row slg2:items-end gap-4">
                    <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
                        <label for="household-search" class="mb-2 text-sm font-medium text-main_font">Search for household</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="household-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search by ID or Head..." />
                        </div>
                    </div>

                    <div class="w-full xs:w-48">
                        <label for="purokFilterDropdownButton" class="mb-2 text-sm font-medium text-main_font">Filter by Purok</label>
                        <button id="purokFilterDropdownButton" data-dropdown-toggle="purokFilterDropdownMenu" class="w-full text-main_font bg-gray-50 font-medium border border-gray-300 rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between" type="button">
                            All Puroks
                            <svg class="w-2.5 h-2.5 ms-3" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="purokFilterDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="purokFilterDropdownButton">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 1</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 2</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-x-auto sm:rounded-lg flex-grow overflow-y-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-main_font uppercase bg-col_tab_h sticky top-0">
                            <tr>
                                <th scope="col" class="p-4">
                                    </th>
                                <th scope="col" class="px-6 py-3">Household ID</th>
                                <th scope="col" class="px-6 py-3">Household Head</th>
                                <th scope="col" class="px-6 py-3">Members</th>
                                <th scope="col" class="px-6 py-3">Purok</th>
                            </tr>
                        </thead>
                        <tbody id="switchHHTableBody">
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="checkbox-table-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">HH-001</th>
                                <td class="px-6 py-4">Juan Dela Cruz</td>
                                <td class="px-6 py-4">5</td>
                                <td class="px-6 py-4">Purok 1</td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-2" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="checkbox-table-2" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">HH-002</th>
                                <td class="px-6 py-4">Maria Santos</td>
                                <td class="px-6 py-4">3</td>
                                <td class="px-6 py-4">Purok 2</td>
                            </tr>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-3" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="checkbox-table-3" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">HH-003</th>
                                <td class="px-6 py-4">Pedro Penduko</td>
                                <td class="px-6 py-4">8</td>
                                <td class="px-6 py-4">Purok 1</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button id="cancelChooseHousehold" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Close</button>
                <button type="button" class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center ms-3">Change Household</button>
            </div>
        </div>
    </div>
</div>