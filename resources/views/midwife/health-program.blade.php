<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Health Programs</h1>

            {{-- 1st Row: Program Filter Buttons --}}
            <div class="bg-white rounded-xl overflow-hidden shadow-md p-4 mb-6"> {{-- Changed p-6 to p-4 to decrease height --}}
                <div class="flex flex-wrap justify-between items-center"> {{-- Added justify-between for even spacing --}}
                    
                   <button type="button" class="relative text-sub_blue font-bold pb-1 group">All Programs<span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[100%] h-1 bg-sub_blue rounded-full"></span></button>
                    <button type="button" class="text-main_font font-medium hover:border-b-2 ">Prenatal</button>
                    <button type="button" class="text-main_font font-medium hover:border-b-2 ">Polio Vaccine</button>
                    <button type="button" class="text-main_font font-medium hover:border-b-2 ">Anti Measles</button>
                    <button type="button" class="text-main_font font-medium hover:border-b-2 ">Family Planning</button>
                    <button type="button" class="text-main_font font-medium hover:border-b-2 ">Senior Citizen</button>
                    <button type="button" class="text-main_font font-medium hover:border-b-2 ">Tuberculosis</button>
                </div>
            </div>

            {{-- 2nd Row: Summary Statistics (No change) --}}
            <div class="bg-white rounded-xl overflow-hidden shadow-md p-6 mb-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div>
                        <p class="text-gray-600 text-sm">Total Enrolled:</p>
                        <p class="text-2xl font-bold text-main_font">2,000</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Ongoing:</p>
                        <p class="text-2xl font-bold text-main_font">100</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Completed:</p>
                        <p class="text-2xl font-bold text-main_font">1,885</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Overdue:</p>
                        <p class="text-2xl font-bold text-main_font">25</p>
                    </div>
                </div>
            </div>

            {{-- 3rd Row: Search, Filters, and Table (No change) --}}
            <div class="bg-white rounded-xl overflow-hidden shadow-md p-6 mb-6">
                <div class="grid grid-rows-1 gap-1">
                    <div class="pb-6">
                        <div class="flex flex-col slg2:flex-row slg2:items-end gap-4">
                            <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
                                <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for health programs?</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                                </div>
                            </div>
                            <div class="flex flex-col xs:flex-row gap-4 slg2:items-end flex-none">
                                <div class="w-full xs:w-48">
                                    <label for="filterDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by</label>
                                    <button id="filterDropdown" data-dropdown-toggle="filterDropdownMenu" class="w-full text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        Alphabetical
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="w-full xs:w-48">
                                    <label for="targetPopulationDropdown" class="mb-2 text-sm font-medium text-main_font">Filter Target Population</label>
                                    <button id="targetPopulationDropdown" data-dropdown-toggle="targetPopulationDropdownMenu" class="w-full text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        All
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="w-full xs:w-40 pt-5 xs:pt-0">
                                    <button type="button" class="w-full h-[2.375rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3">Enroll Resident</button>
                                </div>
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
                    <div id="targetPopulationDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                        <ul class="py-2 text-sm text-gray-700">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Children</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Adolescent</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Adults</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Elderly</a></li>
                        </ul>
                    </div>
                    <div class="relative overflow-x-auto shadow-md rounded-lg">
                        <table class="w-full text-sm text-left text-main_font">
                            <thead class="text-xs text-main_font uppercase bg-col_tab_h">
                                <tr>
                                    <th scope="col" class="px-6 py-3">PROGRAM ID</th>
                                    <th scope="col" class="px-6 py-3">PROGRAM NAME</th>
                                    <th scope="col" class="px-6 py-3">ENROLLED</th>
                                    <th scope="col" class="px-6 py-3">CATEGORY</th>
                                    <th scope="col" class="px-6 py-3">TARGET POPULATION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">121</th>
                                    <td class="px-6 py-4">Anti Tetanus</td>
                                    <td class="px-6 py-4">200</td>
                                    <td class="px-6 py-4">Vaccination</td>
                                    <td class="px-6 py-4">All Population</td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">122</th>
                                    <td class="px-6 py-4">National Immunization</td>
                                    <td class="px-6 py-4">11</td>
                                    <td class="px-6 py-4">Vaccination</td>
                                    <td class="px-6 py-4">Adolescent</td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">123</th>
                                    <td class="px-6 py-4">Tuberculosis Control</td>
                                    <td class="px-6 py-4">23</td>
                                    <td class="px-6 py-4">Gen Consultation</td>
                                    <td class="px-6 py-4">All Population</td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">124</th>
                                    <td class="px-6 py-4">HIV/AIDS and STI Prevention</td>
                                    <td class="px-6 py-4">199</td>
                                    <td class="px-6 py-4">Vaccination</td>
                                    <td class="px-6 py-4">Adults</td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">125</th>
                                    <td class="px-6 py-4">Deworming</td>
                                    <td class="px-6 py-4">200</td>
                                    <td class="px-6 py-4">Child Health</td>
                                    <td class="px-6 py-4">Children</td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">126</th>
                                    <td class="px-6 py-4">Family Planning</td>
                                    <td class="px-6 py-4">1</td>
                                    <td class="px-6 py-4">Family Planning</td>
                                    <td class="px-6 py-4">Adults</td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">127</th>
                                    <td class="px-6 py-4">Mental Health</td>
                                    <td class="px-6 py-4">1</td>
                                    <td class="px-6 py-4">Gen Consultation</td>
                                    <td class="px-6 py-4">All Population</td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">128</th>
                                    <td class="px-6 py-4">Libreng Tuli</td>
                                    <td class="px-6 py-4">1</td>
                                    <td class="px-6 py-4">Child Health</td>
                                    <td class="px-6 py-4">Elderly</td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">129</th>
                                    <td class="px-6 py-4">Vasectomy</td>
                                    <td class="px-6 py-4">1</td>
                                    <td class="px-6 py-4">Vaccination</td>
                                    <td class="px-6 py-4">Adult</td>
                                </tr>
                                <tr class="bg-white text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">130</th>
                                    <td class="px-6 py-4">Nutritional Support</td>
                                    <td class="px-6 py-4">1</td>
                                    <td class="px-6 py-4">Vaccination</td>
                                    <td class="px-6 py-4">Children</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>