@section('title', 'BHWs')
 @section('page-id', 'bhw')
<x-app-layout>
    <div class="py-12 px-5" x-data="{ showPrivacy: false }">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">BHWs</h1>
            <div class="bg-f7 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-rows-1">
                        <div>
                            <!-- Flex container -->
                            <div class="grid grid-cols-1 slg2:grid-cols-7 gap-3">
                                <!-- Search bar -->
                                <div class="col-span-1 slg2:col-span-3">
                                    <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search</label> 
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                        </div>
                                        <input type="search" 
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use search' : ''"
                                        id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 disabled:bg-gray-200 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                                    </div>
                                </div>
                                
                                <div class="col-span-1">
                                    <label for="filterBy" class="mb-2 text-sm font-medium text-main_font">Filter By</label>
                                    <button id="filterBy" data-dropdown-toggle="purokDropdownMenu"
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''"
                                        class="w-full text-main_font bg-f7 focus:outline-none font-medium  disabled:bg-gray-200 border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        Alphabetical
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="m1 1 4 4 4-4" />
                                        </svg>
                                    </button>
                                </div>

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
                           
                                    <!-- Date Filter -->
                                <div class="col-span-1">
                                    <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label> 
                                    <button id="dateDropdown" 
                                     x-bind:disabled="!showPrivacy" 
                                    x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''"
                                    data-dropdown-toggle="dateDropdownMenu" class="w-full text-main_font disabled:bg-gray-200 bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        Date
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </div>
                                    
                                    <!-- Add BHW Button -->
                                <div class="col-span-1">
                                    <label class="mb-2 text-sm font-medium text-main_font">&nbsp;</label> <!-- Spacer for alignment -->
                                    <button id="open-add-bhw-modal" type="button" class="w-full h-[2.375rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path id="secondary" d="M19,20a1,1,0,0,1-1-1V18H17a1,1,0,0,1,0-2h1V15a1,1,0,0,1,2,0v1h1a1,1,0,0,1,0,2H20v1A1,1,0,0,1,19,20Z" style="fill: currentColor;"></path>
                                                <path id="primary" d="M15,17a4,4,0,0,1,2.63-3.74,6,6,0,0,0-2.31-1.11,6,6,0,1,0-8.64,0A6,6,0,0,0,2,18v1a1,1,0,0,0,.29.71C2.53,19.94,4.77,22,11,22a17.17,17.17,0,0,0,6.88-1.18A4,4,0,0,1,15,17Z" style="fill: currentColor;"></path>
                                            </g>
                                        </svg>
                                        Add BHW
                                    </button>
                                </div>
                                <div class="col-span-1">
                                    <label class="mb-2 text-sm font-medium text-main_font">&nbsp;</label>
                                    <div class="h-[2.375rem] flex items-center">
                                        <x-hide-button />
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
                    <div class="relative overflow-x-auto py-6">
                        <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                            <thead class="text-xs text-main_font uppercase">
                                <tr>
                                    <th scope="col" class="px-6 py-3">BHW No.</th>
                                    <th scope="col" class="px-6 py-3">BHWs Name</th>
                                    <th scope="col" class="px-6 py-3">Assigned Purok</th>
                                    <th scope="col" class="px-6 py-3">Date Added</th>
                                    <th scope="col" class="px-6 py-3">Date Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bhws as $bhw)
                                      @php
                                            // Prepare variables for display and masking
                                            $bhwIdString = (string)$bhw->id;
                                            $bhwFullName = $bhw->user->firstName . ' ' . $bhw->user->middleName . ' ' . $bhw->user->lastName;
                                            $placeholderText = 'N/A';
                                            $dateCreated = $bhw->created_at->format('M d, Y');
                                            $dateUpdated = $bhw->updated_at->format('M d, Y');
                                        @endphp

                                        {{-- We'll need to create this route later for the BHW profile page --}}
                                        <tr class="bg-white border-b bg-f7 text-normal_font hover:bg-gray-50 cursor-pointer" 
                                            onclick="window.location='{{ route('midwife.bhws.show', $bhw->id) }}'">
                                            
                                            <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap ">
                                                <span x-show="showPrivacy">{{ $bhwIdString }}</span>
                                                <span x-show="!showPrivacy">{{ str_repeat('*', strlen($bhwIdString)) }}</span>
                                            </th>

                                            <td class="px-6 py-4 "> 
                                                <span x-show="showPrivacy">{{ $bhwFullName }}</span>
                                                <span x-show="!showPrivacy">{{ str_repeat('*', strlen($bhwFullName)) }}</span>
                                            </td>

                                            <td class="px-6 py-4 ">
                                                <span x-show="showPrivacy">{{ $placeholderText }}</span>
                                                <span x-show="!showPrivacy">{{ str_repeat('*', strlen($placeholderText)) }}</span>
                                            </td>

                                            <td class="px-6 py-4 ">
                                                <span x-show="showPrivacy">{{ $dateCreated }}</span>
                                                <span x-show="!showPrivacy">{{ str_repeat('*', strlen($dateCreated)) }}</span>
                                            </td>

                                            <td class="px-6 py-4 ">
                                                <span x-show="showPrivacy">{{ $dateUpdated }}</span>
                                                <span x-show="!showPrivacy">{{ str_repeat('*', strlen($dateUpdated)) }}</span>
                                            </td>
                                        </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            No Barangay Health Workers found for your assigned barangay.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modals.bhw.add-bhw-modal')
</x-app-layout>