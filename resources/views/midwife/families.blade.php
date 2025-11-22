<x-app-layout>
    @section('title', 'Families')
    @section('page-id', 'family')
    
    <script>
        // This is needed for your purok filter dropdown
        window.puroks = @json($puroks);
    </script>

    <div class="py-12 px-6">
            <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8" x-data="{ showPrivacy: JSON.parse(localStorage.getItem('showPrivacy') || 'false') }">            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Household and Residents</h1>

            <div class="mb-3">
                <x-resident-module-nav></x-resident-module-nav>
            </div>

            <div class="bg-f7 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
                        <div class="pb-6 w-full">
                            <div class="grid grid-cols-1 slg2:grid-cols-7 xl:grid-cols-9 gap-4 w-full items-end">
                                
                                <div class="w-full col-span-1 slg2:col-span-9 xl:col-span-3">
                                    <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search</label> 
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="search" 
                                            :disabled="!showPrivacy" 
                                            :title="!showPrivacy ? 'Enable privacy view to use search' : ''"
                                            id="default-search" 
                                            class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 disabled:bg-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                                            placeholder="Search families, members, or purok..."/>
                                    </div>
                                </div>
                                
                                <div class="col-span-1 slg2:col-span-2">
                                    <label for="purokDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by Purok</label> 
                                    <button id="purokDropdown" 
                                        :disabled="!showPrivacy" 
                                        :title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''" 
                                        data-dropdown-toggle="purokDropdownMenu" 
                                        class="w-full text-main_font bg-f7 disabled:bg-gray-200 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" 
                                        type="button">
                                        All Purok
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="col-span-1 slg2:col-span-2">
                                    <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label> 
                                    <button id="dateDropdown" 
                                        :disabled="!showPrivacy" 
                                        :title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''" 
                                        data-dropdown-toggle="dateDropdownMenu" 
                                        class="w-full text-main_font bg-f7 disabled:bg-gray-200 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" 
                                        type="button">
                                        Date
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="col-span-1 slg2:col-span-3 xl:col-span-2 grid grid-cols-4 gap-2">
                                    <button id="add-family-trigger" type="button" class="col-span-3 h-[2.375rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path id="secondary" d="M19,20a1,1,0,0,1-1-1V18H17a1,1,0,0,1,0-2h1V15a1,1,0,0,1,2,0v1h1a1,1,0,0,1,0,2H20v1A1,1,0,0,1,19,20Z" style="fill: currentColor;"></path>
                                                <path id="primary" d="M15,17a4,4,0,0,1,2.63-3.74,6,6,0,0,0-2.31-1.11,6,6,0,1,0-8.64,0A6,6,0,0,0,2,18v1a1,1,0,0,0,.29.71C2.53,19.94,4.77,22,11,22a17.17,17.17,0,0,0,6.88-1.18A4,4,0,0,1,15,17Z" style="fill: currentColor;"></path>
                                            </g>
                                        </svg>
                                        Add Family
                                    </button>
                                    <div class="col-span-1">
                                        <x-hide-button />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="purokDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-normal_font">
                                <li data-purok-id="" data-purok-name="" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                    All Puroks
                                </li>
                                @foreach ($puroks as $purok)
                                    <li data-purok-id="{{ $purok->id }}" data-purok-name="{{ $purok->name }}" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                        {{ $purok->name }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-normal_font">
                                <li data-date-sort="" data-date-sort-name="Date" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                    All Time
                                </li>
                                <li data-date-sort="Last Week" data-date-sort-name="Last Week" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                    Last Week
                                </li>
                                <li data-date-sort="Month" data-date-sort-name="Month" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                    Month
                                </li>
                                <li data-date-sort="Last Year" data-date-sort-name="Last Year" class="cursor-pointer px-4 py-2 hover:bg-gray-100">
                                    Last Year
                                </li>
                            </ul>
                        </div>

                        <div id="family-loading-indicator" class="hidden text-center py-4">
                            <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm text-gray-500">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Loading...
                            </div>
                        </div>

                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                                <thead class="text-xs text-main_font uppercase">
                                    <tr>
                                        <th scope="col" class="pl-6 py-3">Family #</th>
                                        <th scope="col" class="px-6 py-3">Members</th>
                                        <th scope="col" class="px-6 py-3">Purok</th>
                                        <th scope="col" class="px-6 py-3">4PS Member</th>
                                        <th scope="col" class="px-6 py-3">Indigent</th>
                                        <th scope="col" class="px-6 py-3">Date Added</th>
                                        <th scope="col" class="px-6 py-3">Date Updated</th>
                                    </tr>
                                </thead>
                                <tbody id="family-table-body">
                                    @include('components.family.table-rows')
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 text-main_font" id="family-pagination-container">
                        @include('components.family.pagination')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modals.family.add-family-modal')
</x-app-layout>