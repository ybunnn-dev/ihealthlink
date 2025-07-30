<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('mho.barangays') }}">
                    <div class="flex items-center space-x-2"> <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span>Return</span>
                    </div>
                </a>

                {{-- The main flex container --}}
                <div class="flex space-x-4 h-96">
                    {{-- Left div: Profile Image, Name, and Buttons --}}
                    {{-- This container now holds two sub-divs: one for content with BG, one for buttons without BG --}}
                    <div class="w-1/3 flex flex-col">
                        {{-- Div for Profile Image and Name/Resident Number with BG color and rounded corners --}}
                        <div class="bg-[#F7F7F7] rounded-lg flex flex-col items-center justify-center p-4 flex-grow mb-4"> {{-- Added mb-4 for space below --}}
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44"
                                viewBox="0 0 24 24" fill="#A0A0A0" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg>
                            <p class="text-main_font font-bold mt-2">BRGY. TAGAS</p>
                        </div>

                        {{-- Buttons section: Now a separate div, taking full width and no background --}}
                        <div class="flex space-x-3 w-full px-0 pb-0"> {{-- Removed px and pb as they are no longer needed on this container --}}
                            {{-- Increased py- for taller buttons --}}
                            <button type="button" class="flex-1 px-5 py-3 text-sm font-medium text-white bg-mainblue rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">Edit</button>
                            <button type="button" class="flex-1 px-5 py-3 text-sm font-medium text-mainblue bg-white border border-mainblue rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-blue-300">Remove</button>
                        </div>
                    </div>

                    {{-- Right div: Barangay INFO --}}
                    <div class="flex-grow bg-[#F7F7F7] rounded-lg p-12">
                        <div class="flex items-center space-x-2 mb-4">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="#578FCA" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C7.45 14 4 15.8 4 18V20H20V18C20 15.8 16.55 14 12 14Z"></path>
                            </svg>
                            <h2 class="text-xl font-semibold text-main_font">Barangay Info</h2>
                        </div>
                        
                        <div class="grid grid-cols-[auto_1fr] gap-x-12 gap-y-3 text-normal_font text-sm">
                            <p class="font-medium">NAME:</p>
                            <p>TAGAS</p>
                            <p class="font-medium">ZIP CODE:</p>
                            <p>4501</p>
                            <p class="font-medium">NO. OF PUROKS:</p>
                            <p>10</p>
                            <p class="font-medium">NO. OF RESIDENTS:</p>
                            <p>N/A</p>
                            <p class="font-medium">NO. OF HOUSEHOLDS:</p>
                            <p>N/A</p>
                            <p class="font-medium">NO. OF FAMILIES:</p>
                            <p>N/A</p>
                            <p class="font-medium">ASSIGNED MIDWIDE:</p>
                            <p>RON PETER MORTEGA</p>
                            <p class="font-medium">DATE ADDED:</p>
                            <p>FEB 04, 2025</p>


                            <div class="col-span-2 my-4"></div>
                        </div>
                    </div>
                </div>

                {{-- purok table label --}}
                <h2 class="text-2xl font-semibold text-main_font mt-8 mb-4">Puroks</h2>

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

                        <!-- Add purok Button -->
                        <div class="w-full sm:w-40 pt-5 sm:pt-0">
                            <button type="button" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3">Add Purok</button>
                        </div>

                    </div>

                    <div class="relative overflow-x-auto shadow-md rounded-lg">
                        <table class="w-full text-sm text-left text-main_font">
                            <thead class="text-xs text-main_font uppercase bg-col_tab_h text-center">
                                <tr>
                                    <th scope="col" class="px-6 py-3">PUROK ID</th>
                                    <th scope="col" class="px-6 py-3">NAME</th>
                                    <th scope="col" class="px-6 py-3">NO. OF HOUSEHOLDS</th>
                                    <th scope="col" class="px-6 py-3">NO. OF RESIDENTS</th>
                                    <th scope="col" class="px-6 py-3">DATE ADDED</th>
                                    <th scope="col" class="px-6 py-3">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">121</th>
                                    <td class="px-6 py-4">PUROK 1</td>
                                    <td class="px-6 py-4">15</td>
                                    <td class="px-6 py-4">50</td>
                                    <td class="px-6 py-4">Feb 10, 2025</td>
                                    <td class="px-6 py-4">
                                        <button class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</button>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">121</th>
                                    <td class="px-6 py-4">PUROK 1</td>
                                    <td class="px-6 py-4">15</td>
                                    <td class="px-6 py-4">50</td>
                                    <td class="px-6 py-4">Feb 10, 2025</td>
                                    <td class="px-6 py-4">
                                        <button class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</button>
                                    </td>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">121</th>
                                    <td class="px-6 py-4">PUROK 1</td>
                                    <td class="px-6 py-4">15</td>
                                    <td class="px-6 py-4">50</td>
                                    <td class="px-6 py-4">Feb 10, 2025</td>
                                    <td class="px-6 py-4">
                                        <button class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</button>
                                    </td>
                                </tr>
                                <tr class="bg-white text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">121</th>
                                    <td class="px-6 py-4">PUROK 1</td>
                                    <td class="px-6 py-4">15</td>
                                    <td class="px-6 py-4">50</td>
                                    <td class="px-6 py-4">Feb 10, 2025</td>
                                    <td class="px-6 py-4">
                                        <button class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</button>
                                    </td>
                                </tr>
                                <tr class="bg-white text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">121</th>
                                    <td class="px-6 py-4">PUROK 1</td>
                                    <td class="px-6 py-4">15</td>
                                    <td class="px-6 py-4">50</td>
                                    <td class="px-6 py-4">Feb 10, 2025</td>
                                    <td class="px-6 py-4">
                                        <button class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</button>
                                    </td>
                                </tr>
                                <tr class="bg-white text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">121</th>
                                    <td class="px-6 py-4">PUROK 1</td>
                                    <td class="px-6 py-4">15</td>
                                    <td class="px-6 py-4">50</td>
                                    <td class="px-6 py-4">Feb 10, 2025</td>
                                    <td class="px-6 py-4">
                                        <button class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>