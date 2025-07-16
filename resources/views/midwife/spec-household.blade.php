<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('midwife.households') }}">
                    <div class="flex items-center space-x-2"> <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span>Return</span>
                    </div>
                </a>
                <div class="flex space-x-4">
                    <div class="w-1/3 h-80 bg-f7 rounded-lg flex flex-col items-center justify-center p-4"> 
                        <svg class="flex-shrink-0
                                    w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font"

                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M22 21.2488H21V9.97875C21 9.35875 20.72 8.77875 20.23 8.39875L19 7.43875L18.98 4.98875C18.98 4.43875 18.53 3.99875 17.98 3.99875H14.57L13.23 2.95875C12.51 2.38875 11.49 2.38875 10.77 2.95875L3.77 8.39875C3.28 8.77875 3 9.35875 3 9.96875L2.95 21.2488H2C1.59 21.2488 1.25 21.5888 1.25 21.9988C1.25 22.4088 1.59 22.7488 2 22.7488H22C22.41 22.7488 22.75 22.4088 22.75 21.9988C22.75 21.5888 22.41 21.2488 22 21.2488ZM6.5 12.7487V11.2487C6.5 10.6987 6.95 10.2487 7.5 10.2487H9.5C10.05 10.2487 10.5 10.6987 10.5 11.2487V12.7487C10.5 13.2987 10.05 13.7487 9.5 13.7487H7.5C6.95 13.7487 6.5 13.2987 6.5 12.7487ZM14.5 21.2488H9.5V18.4987C9.5 17.6687 10.17 16.9987 11 16.9987H13C13.83 16.9987 14.5 17.6687 14.5 18.4987V21.2488ZM17.5 12.7487C17.5 13.2987 17.05 13.7487 16.5 13.7487H14.5C13.95 13.7487 13.5 13.2987 13.5 12.7487V11.2487C13.5 10.6987 13.95 10.2487 14.5 10.2487H16.5C17.05 10.2487 17.5 10.6987 17.5 11.2487V12.7487Z" fill="currentColor"></path>
                            </g>
                        </svg>
                        <p class="text-main_font font-bold mt-2">Household #144</p> 
                    </div>
                    <div class="flex-grow h-80 bg-f7 rounded-lg p-12">
                        <h2 class="text-xl font-semibold text-main_font mb-6">Household Info</h2> 
                        <div class="grid grid-cols-[auto_1fr] gap-x-12 gap-y-3 text-normal_font text-sm"> 
                            <p class="font-medium">PUROK NO.</p>
                            <p>1</p>

                            <p class="font-medium">NUMBER OF HOUSEHOLDS:</p>
                            <p>Manok</p>

                            <p class="font-medium">HOUSEHOLD HEAD:</p>
                            <p>Mortega</p>

                            <p class="font-medium">DATE ADDED:</p>
                            <p>March 17, 2024</p>

                            <p class="font-medium">DATE UPDATED:</p>
                            <p>March 17, 2025</p>
                        </div>
                    </div>
                </div>

                <div class="bg-f7 rounded-xl overflow-hidden">
                    <div class="p-8 pt-10">
                        <div class="grid grid-rows-1 gap-1">
                            <h1 class="text-2xl font-semibold text-sub_blue mb-3">Household Members</h1>
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
                                    <!-- Add Household Button -->
                                    <div class="w-full xs:w-40 pt-5 xs:pt-0">
                                        <button type="button" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3">Add Households</button>
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
                                <thead class="text-xs text-main_font uppercase">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Product name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Color
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Category
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Price
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white border-b bg-f7 text-normal_font" onclick="window.location='{{ route('midwife.spechouse') }}'">
                                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                            Apple MacBook Pro 17"
                                        </th>
                                        <td class="px-6 py-4">
                                            Silver
                                        </td>
                                        <td class="px-6 py-4">
                                            Laptop
                                        </td>
                                        <td class="px-6 py-4">
                                            $2999
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b bg-f7 text-normal_font">
                                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                            Apple MacBook Pro 17"
                                        </th>
                                        <td class="px-6 py-4">
                                            Silver
                                        </td>
                                        <td class="px-6 py-4">
                                            Laptop
                                        </td>
                                        <td class="px-6 py-4">
                                            $2999
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b bg-f7 text-normal_font">
                                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                            Apple MacBook Pro 17"
                                        </th>
                                        <td class="px-6 py-4">
                                            Silver
                                        </td>
                                        <td class="px-6 py-4">
                                            Laptop
                                        </td>
                                        <td class="px-6 py-4">
                                            $2999
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