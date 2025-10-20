<x-app-layout>
    @section('title', 'Households')
    @section('page-id', 'households')
    <div class="py-12 px-6" x-data="{ showPrivacy: false }">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Households and Residents</h1>
            <script>
                const household = @json($households);

                window.puroks = @json($puroks);
            </script>
            <div class="mb-3">
                <x-resident-module-nav></x-resident-module-nav>
            </div>

            <div class="bg-f7 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
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
                                    <input type="search" 
                                    x-bind:disabled="!showPrivacy" 
                                    x-bind:title="!showPrivacy ? 'Enable privacy view to use search' : ''"
                                    id="default-search" class="disabled:bg-gray-200 block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                                </div>
                                </div>
                                
                                <!-- Filters and button container -->
                                <div class="flex flex-col xs:flex-row gap-4 slg2:items-end flex-none">
                                    <!-- Purok Filter -->
                                    <div class="w-full xs:w-48">
                                        <label for="purokDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by Purok</label> 
                                        <button id="purokDropdown"
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''" 
                                        data-dropdown-toggle="purokDropdownMenu" class="disabled:bg-gray-200 w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        All Purok
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Date Filter -->
                                    <div class="w-full xs:w-48">
                                        <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label> 
                                        <button id="dateDropdown" 
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''"
                                        data-dropdown-toggle="dateDropdownMenu" class="disabled:bg-gray-200 w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        Date
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Add Household Button -->
                                    <div class="w-full xs:w-40 pt-5 xs:pt-0">
                                        <button type="button" id="open-add-household" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3">Add Households</button>       
                                    </div>
                                    <x-hide-button />
                                    @include('components.modals.household.add-household-modal')
                                    @include('components.modals.existing-member-modal')
                                    @include('components.modals.existing-family-head-modal')
                                    @include('components.modals.household.existing-household-head-modal')
                                    @include('components.modals.new-resident-modal')
                                </div>
                            </div>
                        </div>
                        <!-- Dropdown menus -->
                        <div id="purokDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-normal_font">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 1</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 2</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 3</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 4</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 5</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 6</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 7</a></li>
                        </ul>
                        </div>

                        <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-normal_font">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Week</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Month</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Year</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Custom</a></li>
                        </ul>
                    </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                            <thead class="text-xs text-main_font uppercase">
                                <tr>
                                    <th scope="col" class="pl-6 py-3">
                                        Household #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Household Head
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Purok
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date Added
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date Updated
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($households as $household)
                                    @php
                                        // Prepare the variables for easier use inside the template
                                        $householdIdString = str_pad($household->id, 3, '0', STR_PAD_LEFT);

                                        if ($household->head) {
                                            $head = $household->head;
                                            $middle = !empty($head->middleName) ? ' ' . strtoupper($head->middleName[0]) . '.' : ''; // Use middle initial
                                            $suffix = !empty($head->suffix) ? ' ' . $head->suffix : '';
                                            $householdHead = "{$head->firstName}{$middle} {$head->lastName}{$suffix}";
                                        } else {
                                            $householdHead = 'N/A';
                                        }

                                        $purokName = $household->purok->name ?? 'No Purok';
                                        $dateAdded = $household->created_at->format('M d, Y');
                                        $dateUpdated = $household->updated_at->format('M d, Y');
                                    @endphp
                                    <tr class="bg-white border-b bg-f7 text-normal_font hover:bg-gray-100 cursor-pointer"
                                        onclick="window.location='{{ route('midwife.spec-household', $household->id) }}'">

                                        {{-- Household # (ID) is now also conditional --}}
                                        <th scope="row" class="pl-6 py-4 font-medium text-normal_font whitespace-nowrap ">
                                            <span x-show="showPrivacy">{{ $householdIdString }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($householdIdString)) }}</span>
                                        </th>

                                        {{-- Household Head (Conditional) --}}
                                        <td class="px-6 py-4 ">
                                            <span x-show="showPrivacy">{{ $householdHead }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($householdHead)) }}</span>
                                        </td>

                                        {{-- Purok Name (Conditional) --}}
                                        <td class="px-6 py-4 ">
                                            <span x-show="showPrivacy">{{ $purokName }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($purokName)) }}</span>
                                        </td>

                                        {{-- Date Added (Conditional) --}}
                                        <td class="px-6 py-4 ">
                                            <span x-show="showPrivacy">{{ $dateAdded }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($dateAdded)) }}</span>
                                        </td>

                                        {{-- Date Updated (Conditional) --}}
                                        <td class="px-6 py-4 ">
                                            <span x-show="showPrivacy">{{ $dateUpdated }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($dateUpdated)) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- This row will be displayed if the $households collection is empty --}}
                                    <tr class="bg-white border-b">
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            <div class="text-center py-10">
                                                <img src="{{ asset('images/illustrations/empty.png') }}" alt="No barangays found" class="mx-auto w-64">
                                                <p class="mt-5 text-lg font-medium text-gray-700">
                                                    {{ $message ?? "Oops! You haven't added any household yet." }}
                                                </p>
                                                <p class="mt-2 text-sm text-gray-500">
                                                    Click the "Add Household" button to get started.
                                                </p>
                                            </div>
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
</x-app-layout>