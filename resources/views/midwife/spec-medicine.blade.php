<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('midwife.medicines') }}">
                    <div class="flex items-center space-x-2"> <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span>Return</span>
                    </div>
                </a>
                <div class="flex space-x-4">
                    <div class="w-1/3 h-80 bg-f7 rounded-lg flex flex-col items-center justify-center p-4"> 
                        <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font"
                            version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                            <g>
                                <path d="M358.359,23.406C358.359,10.484,347.875,0,334.953,0H177.047c-12.922,0-23.406,10.484-23.406,23.406v50.234 h204.719V23.406z"></path>
                                <path d="M371.188,162.453c-20.766-10.391-27.703-34.641-27.703-55.422c0-1.344,0-3.328,0-5.875 c0-0.938,0-1.813,0-2.938H168.516c0,1.125,0,2,0,2.938c0,0.313,0,1.969,0,5.875c0,20.781-6.938,45.031-27.703,55.422 c-24.813,12.391-35.219,30.859-35.219,74.969c0,15.734,0,162.766,0,187.969c0,42.516,29.922,86.609,89.781,86.609h121.25 c59.859,0,89.781-44.094,89.781-86.609c0-25.203,0-172.234,0-187.969C406.406,193.313,396,174.844,371.188,162.453z M357.156,406.719H154.844V241.547h202.313V406.719z"></path>
                                <polygon points="238.688,386.922 273.297,386.922 273.297,345.828 314.375,345.828 314.375,311.25 273.297,311.25 273.297,270.156 238.688,270.156 238.688,311.25 197.625,311.25 197.625,345.828 238.688,345.828 "></polygon>
                            </g>
                        </svg>
                        <p class="text-main_font font-bold mt-2">Alaxan FR</p>
                        <p class="text-main_font font-medium mt-2">Medicine  #13356</p>
                    </div>
                    <div class="flex-grow h-80 bg-f7 rounded-lg p-12">
                        <h2 class="text-xl font-semibold text-main_font mb-6">Medicine Info</h2> 
                        <div class="grid grid-cols-[auto_1fr] gap-x-12 gap-y-3 text-normal_font text-sm"> 
                            <p class="font-medium">Medicine Name:</p>
                            <p>Alaxan FR</p>

                            <p class="font-medium">Generic Name:</p>
                            <p>Ibuprofen + Paracetamol</p>

                            <p class="font-medium">Category:</p>
                            <p>Pain Killer</p>

                            <p class="font-medium">FORM:</p>
                            <p>Tablet</p>

                            <p class="font-medium">DESCRIPTION:</p>
                            <p>Alaxan is a combination of Ibuprofen (200mg) and Paracetamol (325mg) used to relieve mild to moderate pain such as headache, body pain, muscle aches, joint pain, and fever. </p>
                        </div>
                    </div>
                </div>

                <div class="bg-f7 rounded-xl overflow-hidden">
                    <div class="p-8 pt-10">
                        <div class="grid grid-rows-1 gap-1">
                            <h1 class="text-2xl font-semibold text-sub_blue mb-3">Inventory</h1>
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
                                    
                                    <!-- Date Filter -->
                                    <div class="w-full sm:w-48">
                                        <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label> 
                                        <button id="dateDropdown" data-dropdown-toggle="dateDropdownMenu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        Date
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                        </button>
                                    </div>

                                    <!-- Add Medicine Button -->
                                    <div class="w-full xs:w-40 pt-5 xs:pt-0">
                                        <button type="button" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3">Add medicines</button>
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
                                <thead class="text-xs text-main_font uppercase text-center" >
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            MEDICINE #
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            MEDICINE NAME
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            TOTAL QUANTITY
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            CATEGORY
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            FORM
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            DATE UPDATED
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white border-b bg-f7 text-normal_font text-center" onclick="window.location='{{ route('midwife.medicines-view') }}'">
                                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                            121
                                        </th>
                                        <td class="px-6 py-4">
                                            Alaxan
                                        </td>
                                        <td class="px-6 py-4">
                                            1
                                        </td>
                                        <td class="px-6 py-4">
                                            Pain Killer
                                        </td>
                                        <td class="px-6 py-4">
                                            Capsule
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
                                            Biogesic
                                        </td>
                                        <td class="px-6 py-4">
                                            1
                                        </td>
                                        <td class="px-6 py-4">
                                            Pain Killer
                                        </td>
                                        <td class="px-6 py-4">
                                            Capsule
                                        </td>
                                        <td class="px-6 py-4">
                                            Feb 10, 2025
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b bg-f7 text-normal_font text-center">
                                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                            123
                                        </th>
                                        <td class="px-6 py-4">
                                            Amoxicillin
                                        </td>
                                        <td class="px-6 py-4">
                                            1
                                        </td>
                                        <td class="px-6 py-4">
                                            Pain Killer
                                        </td>
                                        <td class="px-6 py-4">
                                            Capsule
                                        </td>
                                        <td class="px-6 py-4">
                                            Feb 10, 2025
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