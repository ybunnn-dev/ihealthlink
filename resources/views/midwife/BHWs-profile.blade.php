@section('title', 'BHWs | #' .$bhw->user->id)
 @section('page-id', 'spec-bhw')
<x-app-layout>
    <script>
        window.bhwData = @json($bhw);
    </script>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('midwife.bhws') }}">
                    <div class="flex items-center space-x-2"> 
                        <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span class="font-semibold">Return</span>
                    </div>
                </a>
                 <div class="grid grid-cols-1 xl:grid-cols-3 gap-3">
                    <!-- Left Column (Profile + Scheduled Activity) -->
                    <div class="grid grid-rows-6 gap-2 col-span-1">
                        <!-- Profile Card -->
                        <div class="bg-f7 rounded-lg flex flex-col items-center justify-center p-4 row-span-5"> 
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <path opacity="0.4" d="M12.1207 12.78C12.0507 12.77 11.9607 12.77 11.8807 12.78C10.1207 12.72 8.7207 11.28 8.7207 9.50998C8.7207 7.69998 10.1807 6.22998 12.0007 6.22998C13.8107 6.22998 15.2807 7.69998 15.2807 9.50998C15.2707 11.28 13.8807 12.72 12.1207 12.78Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path opacity="0.34" d="M18.7398 19.3801C16.9598 21.0101 14.5998 22.0001 11.9998 22.0001C9.39977 22.0001 7.03977 21.0101 5.25977 19.3801C5.35977 18.4401 5.95977 17.5201 7.02977 16.8001C9.76977 14.9801 14.2498 14.9801 16.9698 16.8001C18.0398 17.5201 18.6398 18.4401 18.7398 19.3801Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                </g>
                            </svg>
                            <p class="text-main_font font-bold mt-4 text-xl">{{ $bhw->name }}</p> 
                            <p class="text-main_font font-semibold">BHW #{{ $bhw->id }}</p> 
                        </div>

                        <!-- Scheduled Activity Card -->
                         <div class="grid grid-cols-1 lg:grid-cols-2 w-full px-0 pb-0 row-span-1 gap-3"> {{-- Removed px and pb as they are no longer needed on this container --}}
                            {{-- Increased py- for taller buttons --}}
                            <button id="open-edit-bhw" type="button" class="col-span-1 px-5 py-3 text-sm font-medium text-white bg-mainblue rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">Edit</button>
                            <button id="open-remove-bhw" type="button" class="col-span-1 px-5 py-3 text-sm font-medium text-mainblue bg-white border border-mainblue rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-300">Remove</button>
                        </div>
                    </div>

                    <!-- Right Column (Resident Info) -->
                    <div class="col-span-1 xl:col-span-2 h-full bg-f7 rounded-lg px-6 sm:px-10 lg:px-12 py-8">
                        <!-- Header -->
                        <div class="flex items-center gap-2 mb-6">
                            <h2 class="text-xl font-semibold text-main_font">BHW Info</h2>
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-1 gap-y-4 text-xs">
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">FIRST NAME:</p>
                                <p class="text-normal_font">{{ $bhw->user->firstName }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">LAST NAME:</p>
                                <p class="text-normal_font">{{ $bhw->user->lastName }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">MIDDLE NAME:</p>
                                <p class="text-normal_font">{{ $bhw->user->middleName ?? 'N/A' }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">SUFFIX:</p>
                                <p class="text-normal_font">{{ $bhw->user->suffix ?? 'N/A' }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">BIRTHDATE:</p>
                                {{-- Using Carbon for easy date formatting and age calculation --}}
                                <p class="text-normal_font">{{ \Carbon\Carbon::parse($bhw->user->birthdate)->format('F d, Y') }} ({{ \Carbon\Carbon::parse($bhw->user->birthdate)->age }} Years old)</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">ADDRESS:</p>
                                <p class="text-normal_font">Brgy. {{ $bhw->barangays->name }}, Daraga, Albay</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">SEX:</p>
                                <p class="text-normal_font">{{ $bhw->user->sex }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">MOBILE NUMBER:</p>
                                <p class="text-normal_font">{{ $bhw->user->contact_no ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- "bhw Activity Log" label --}}
                <h2 class="text-2xl font-semibold text-main_font mt-8">{{ $bhw->name }} Activity Log</h2>

                <div class="bg-white p-6 rounded-xl">
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
                            <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg w-44">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dateDropdown">
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All Date</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Week</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Month</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="relative overflow-x-auto rounded-lg">
                        <table class="w-full text-sm text-left text-main_font">
                            <thead class="text-xs text-main_font uppercase bg-col_tab_h text-center">
                                <tr>
                                    <th scope="col" class="px-6 py-3">LOG ID</th>
                                    <th scope="col" class="px-6 py-3">NAME</th>
                                    <th scope="col" class="px-6 py-3">ROLE</th>
                                    <th scope="col" class="px-6 py-3">ACTIVITY</th>
                                    <th scope="col" class="px-6 py-3">DATE & TIME UPDATED</th>
                                    <th scope="col" class="px-6 py-3">ACTION</th>
                                </tr>
                            </thead>
                            <tbody> {{-- Removed text-center from tbody --}}
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap text-center">121</th>
                                    <td class="px-6 py-4 text-center">Ron Peter Mortega</td>
                                    <td class="px-6 py-4 text-center">BHW</td>
                                    <td class="px-6 py-4 text-center">Add Medicine</td>
                                    <td class="px-6 py-4 text-center">Feb 10, 2025 - 10:00 AM</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</button>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap text-center">122</th>
                                    <td class="px-6 py-4 text-center">Ron Peter Mortega</td>
                                    <td class="px-6 py-4 text-center">BHW</td>
                                    <td class="px-6 py-4 text-center">Add Medicine</td>
                                    <td class="px-6 py-4 text-center">Feb 10, 2025 - 10:00 AM</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</button>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap text-center">123</th>
                                    <td class="px-6 py-4 text-center">Ron Peter Mortega</td>
                                    <td class="px-6 py-4 text-center">BHW</td>
                                    <td class="px-6 py-4 text-center">Update Resident</td>
                                    <td class="px-6 py-4 text-center">Feb 10, 2025 - 10:00 AM</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</button>
                                    </td>
                                </tr>
                                <tr class="bg-white text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap text-center">124</th>
                                    <td class="px-6 py-4 text-center">Ron Peter Mortega</td>
                                    <td class="px-6 py-4 text-center">BHW</td>
                                    <td class="px-6 py-4 text-center">Add Resident</td>
                                    <td class="px-6 py-4 text-center">Feb 10, 2025 - 10:00 AM</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</button>
                                    </td>
                                </tr>
                                <tr class="bg-white text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap text-center">125</th>
                                    <td class="px-6 py-4 text-center">Ron Peter Mortega</td>
                                    <td class="px-6 py-4 text-center">BHW</td>
                                    <td class="px-6 py-4 text-center">Add Resident</td>
                                    <td class="px-6 py-4 text-center">Feb 10, 2025 - 10:00 AM</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</button>
                                    </td>
                                </tr>
                                <tr class="bg-white text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap text-center">126</th>
                                    <td class="px-6 py-4 text-center">Ron Peter Mortega</td>
                                    <td class="px-6 py-4 text-center">BHW</td>
                                    <td class="px-6 py-4 text-center">Add Medicine</td>
                                    <td class="px-6 py-4 text-center">Feb 10, 2025 - 10:00 AM</td>
                                    <td class="px-6 py-4 text-center">
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
    @include('components.modals.bhw.edit-bhw-modal')
    @include('components.modals.bhw.remove-bhw')
</x-app-layout>