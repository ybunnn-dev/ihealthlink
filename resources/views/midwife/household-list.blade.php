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
                            <div class="grid grid-cols-1 md:grid-cols-2 slg:grid-cols-5 xl:grid-cols-6 xl3:grid-cols-7 gap-4 items-end">
                                
                                <div class="w-full md:col-span-1 slg:col-span-2 xl:col-span-3 xl3:col-span-4">
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
                                            id="default-search" 
                                            class="disabled:bg-gray-200 block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                                            placeholder="Search households, heads, or residents..."/>
                                    </div>
                                </div>
                                
                                <div class="w-full">
                                    <label for="purokDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by Purok</label> 
                                    <button id="purokDropdown"
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''" 
                                        data-dropdown-toggle="purokDropdownMenu" 
                                        class="disabled:bg-gray-200 w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" 
                                        type="button">
                                        All Purok
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <div class="w-full">
                                    <button type="button" id="open-add-household" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3">Add Households</button>       
                                </div>

                                <div class="w-full flex justify-start">
                                    <x-hide-button />
                                </div>

                                @include('components.modals.household.add-household-modal')
                                @include('components.modals.existing-member-modal')
                                @include('components.modals.existing-family-head-modal')
                                @include('components.modals.household.existing-household-head-modal')
                                @include('components.modals.new-resident-modal')
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
                    </div>

                    <div id="loading-indicator" class="hidden text-center py-4">
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
                            <tbody id="household-table-body">
                                @include('components.household.household-table-rows')
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 text-main_font" id="pagination-container">
                        @include('components.household.pagination')
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>