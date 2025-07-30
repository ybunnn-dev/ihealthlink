<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <div class="flex space-x-4 h-96">
                    <div class="w-1/3 flex flex-col">
                        {{-- Div for Profile Image and Name/Resident Number with BG color and rounded corners --}}
                        <div class="bg-[#F7F7F7] rounded-lg flex flex-col items-center justify-center p-4 flex-grow mb-4"> {{-- Added mb-4 for space below --}}
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <circle cx="12" cy="7" r="3" fill="currentColor"></circle>
                                <path d="M12 10c-3.69 0-7 2-7 5s3.31 5 7 5 7-2 7-5-3.31-5-7-5z" fill="currentColor"></path>
                            </svg>
                            <p class="text-main_font font-bold mt-2">Ron Peter Mortega</p>
                            <p class="text-normal_font">Midwife # 13356</p>
                        </div>

                        {{-- Buttons section: Now a separate div, taking full width and no background --}}
                        <div class="flex space-x-3 w-full px-0 pb-0"> {{-- Removed px and pb as they are no longer needed on this container --}}
                            {{-- Increased py- for taller buttons --}}
                            <button type="button" class="flex-1 px-5 py-3 text-sm font-medium text-white bg-mainblue rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">Edit</button>
                            <button type="button" class="flex-1 px-5 py-3 text-sm font-medium text-mainblue bg-white border border-mainblue rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-blue-300">Remove</button>
                        </div>
                    </div>

                    {{-- Right div: BHW INFO --}}
                    <div class="flex-grow bg-[#F7F7F7] rounded-lg p-12">
                        <h2 class="text-xl font-semibold text-main_font mb-6">MIDWIFE INFO</h2>
                        <div class="grid grid-cols-[auto_1fr] gap-x-12 gap-y-3 text-normal_font text-sm">
                            <p class="font-medium">FIRST NAME:</p>
                            <p>RON</p>
                            <p class="font-medium">LAST NAME:</p>
                            <p>Mortega</p>
                            <p class="font-medium">MIDDLE NAME:</p>
                            <p>PETER</p>
                            <p class="font-medium">SUFFIX:</p>
                            <p>N/A</p>
                            <p class="font-medium">BIRTH DATE:</p>
                            <p>March 17, 2024</p>
                            <p class="font-medium">CONTACT NUMBER:</p>
                            <p>09789622025</p>
                            <p class="font-medium">ASSIGNED BARANGGAY:</p>
                            <p>Brgy. Tagas</p>
                            <p class="font-medium">DATE ASSIGNED:</p>
                            <p>July 24, 2024</p>
                        </div>
                    </div>
                </div>

                {{-- "Ron's Activity Log" label --}}
                <h2 class="text-2xl font-semibold text-main_font mt-8 mb-4">Ron's Activity Log</h2>

                <div class="bg-white p-6 rounded-xl shadow">
                    <div class="flex flex-col slg2:flex-row slg2:items-end gap-4 mb-4">
                        <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
                            <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search Name?</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search...">
                            </div>
                        </div>

                        <div class="w-full xs:w-48">
                            <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label>
                            <button id="dateDropdown" data-dropdown-toggle="dateDropdownMenu" class="w-full text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-gray-300 rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                All Date
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dateDropdown">
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All Date</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Week</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Month</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="relative overflow-x-auto shadow-md rounded-lg">
                        <table class="w-full text-sm text-left text-main_font">
                            <thead class="text-xs text-main_font uppercase bg-col_tab_h">
                                <tr>
                                    <th scope="col" class="px-6 py-3">LOG ID</th>
                                    <th scope="col" class="px-6 py-3">NAME</th>
                                    <th scope="col" class="px-6 py-3">ROLE</th>
                                    <th scope="col" class="px-6 py-3">ACTIVITY</th>
                                    <th scope="col" class="px-6 py-3">DATE & TIME UPDATED</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">121</th>
                                    <td class="px-6 py-4">Ron Peter Mortega</td>
                                    <td class="px-6 py-4">MIDWIFE</td>
                                    <td class="px-6 py-4">Add Medicine</td>
                                    <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">122</th>
                                    <td class="px-6 py-4">Ron Peter Mortega</td>
                                    <td class="px-6 py-4">MIDWIFE</td>
                                    <td class="px-6 py-4">Add Medicine</td>
                                    <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">123</th>
                                    <td class="px-6 py-4">Ron Peter Mortega</td>
                                    <td class="px-6 py-4">MIDWIFE</td>
                                    <td class="px-6 py-4">Update Resident</td>
                                    <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                                </tr>
                                <tr class="bg-white text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">124</th>
                                    <td class="px-6 py-4">Ron Peter Mortega</td>
                                    <td class="px-6 py-4">MIDWIFE</td>
                                    <td class="px-6 py-4">Add Resident</td>
                                    <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                                </tr>
                                <tr class="bg-white text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">125</th>
                                    <td class="px-6 py-4">Ron Peter Mortega</td>
                                    <td class="px-6 py-4">MIDWIFE</td>
                                    <td class="px-6 py-4">Add Resident</td>
                                    <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                                </tr>
                                <tr class="bg-white text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">126</th>
                                    <td class="px-6 py-4">Ron Peter Mortega</td>
                                    <td class="px-6 py-4">MIDWIFE</td>
                                    <td class="px-6 py-4">Add Medicine</td>
                                    <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>