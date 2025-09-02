@section('page-id', 'spec-midwife')
@section('title', 'Peter')
<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-rows gap-4">
                 <a href="{{ route('mho.midwives') }}">
                    <div class="flex items-center space-x-2"> <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span class="font-semibold">Return</span>
                    </div>
                </a>
                <div class="grid grid-cols-1 slg:grid-cols-3 h-96 gap-3 mb-4">
                    <div class="w-full flex flex-col col-span-1">
                        {{-- Div for Profile Image and Name/Resident Number with BG color and rounded corners --}}
                        <div class="bg-[#F7F7F7] rounded-lg flex flex-col items-center justify-center p-4 flex-grow mb-4"> {{-- Added mb-4 for space below --}}
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <path opacity="0.4" d="M12.1207 12.78C12.0507 12.77 11.9607 12.77 11.8807 12.78C10.1207 12.72 8.7207 11.28 8.7207 9.50998C8.7207 7.69998 10.1807 6.22998 12.0007 6.22998C13.8107 6.22998 15.2807 7.69998 15.2807 9.50998C15.2707 11.28 13.8807 12.72 12.1207 12.78Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path opacity="0.34" d="M18.7398 19.3801C16.9598 21.0101 14.5998 22.0001 11.9998 22.0001C9.39977 22.0001 7.03977 21.0101 5.25977 19.3801C5.35977 18.4401 5.95977 17.5201 7.02977 16.8001C9.76977 14.9801 14.2498 14.9801 16.9698 16.8001C18.0398 17.5201 18.6398 18.4401 18.7398 19.3801Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                </g>
                            </svg>
                            <p class="text-main_font font-bold mt-2">
                                {{ $midwife['firstName'] }}
                                {{ $midwife['middleName'] ? strtoupper(substr($midwife['middleName'], 0, 1)) . '.' : '' }}
                                {{ $midwife['lastName'] }}
                                {{ $midwife['suffix'] ? $midwife['suffix'] : '' }}
                            </p>

                            <p class="text-normal_font">Midwife #{{ $midwife['midwife_id'] }}</p>
                        </div>

                        {{-- Buttons section: Now a separate div, taking full width and no background --}}
                        <div class="flex space-x-3 w-full px-0 pb-0"> {{-- Removed px and pb as they are no longer needed on this container --}}
                            {{-- Increased py- for taller buttons --}}
                            <button type="button" class="flex-1 px-5 py-3 text-sm font-medium text-white bg-mainblue rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">Edit</button>
                            <button type="button" class="flex-1 px-5 py-3 text-sm font-medium text-mainblue bg-white border border-mainblue rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-blue-300">Remove</button>
                        </div>
                    </div>

                    {{-- Right div: BHW INFO --}}
                    <div class="flex-grow bg-white rounded-lg p-12 col-span-1 slg:col-span-2">
                        <div class="flex items-center space-x-2 mb-4">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="#578FCA" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C7.45 14 4 15.8 4 18V20H20V18C20 15.8 16.55 14 12 14Z"></path>
                            </svg>
                            <h2 class="text-xl font-semibold text-main_font">Midwife Info</h2>
                        </div>
                        <div class="grid grid-cols-1 gap-y-4 text-xs">
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">FIRST NAME:</p>
                                <p class="text-normal_font">{{ $midwife['firstName'] }}</p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">LAST NAME:</p>
                                <p class="text-normal_font">{{ $midwife['lastName'] }}</p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">MIDDLE NAME:</p>
                                <p class="text-normal_font">{{ $midwife['middleName'] ?? 'N/A' }}</p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">SUFFIX:</p>
                                <p class="text-normal_font">{{ $midwife['suffix'] ?? 'N/A' }}</p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">BIRTHDATE:</p>
                                <p class="text-normal_font">{{ $midwife['birthdate'] }}</p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">CONTACT NO.:</p>
                                <p class="text-normal_font">{{ $midwife['contact_no'] }}</p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">ASSIGNED BRGY:</p>
                                <p class="text-normal_font">{{ $midwife['barangay_name'] }}</p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">DATE ASSIGNED:</p>
                                <p class="text-normal_font">{{ $midwife['date_added'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- "Ron's Activity Log" label --}}
                <h2 class="text-2xl font-semibold text-main_font mt-8 mb-4">{{ $midwife['firstName'] }}'s Activity Log</h2>

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