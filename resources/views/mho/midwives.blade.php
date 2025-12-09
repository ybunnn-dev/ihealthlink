@section('page-id', 'midwives')
@section('title', 'Midwives')

<x-app-layout>
    <div class="py-12 px-5" x-data="{ showPrivacy: false }">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Midwives</h1>
            <div class="bg-f7 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
                        <div class="pb-6 w-full">
                            <div class="grid grid-cols-1 slg2:grid-cols-7 gap-3">
                                <!-- Search bar -->
                                <div class="col-span-1 slg2:col-span-3">
                                    <label for="midwife-search-input" class="mb-2 text-sm font-medium text-main_font">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="search" 
                                            id="midwife-search-input"
                                            x-bind:disabled="!showPrivacy" 
                                            x-bind:title="!showPrivacy ? 'Enable privacy view to use search' : ''"
                                            class="block w-full p-2 ps-10 text-sm text-gray-900 disabled:bg-gray-200 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                                            placeholder="Search by name..."/>
                                    </div>
                                </div>

                                <!-- Filter By -->
                                <div class="col-span-1">
                                    <label for="midwife-filter-button" class="mb-2 text-sm font-medium text-main_font">Filter By</label>
                                    <button id="midwife-filter-button" 
                                        data-dropdown-toggle="midwife-filter-menu"
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''"
                                        class="w-full text-main_font bg-f7 focus:outline-none font-medium disabled:bg-gray-200 border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        Alphabetical
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                        </svg>
                                    </button>
                                    <div id="midwife-filter-menu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="midwife-filter-button">
                                            <li><a href="#" id="filter-alphabetical" class="block px-4 py-2 hover:bg-gray-100">By Name</a></li>
                                            <li><a href="#" id="filter-age-asc" class="block px-4 py-2 hover:bg-gray-100">Age Ascending</a></li>
                                            <li><a href="#" id="filter-age-desc" class="block px-4 py-2 hover:bg-gray-100">Age Descending</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Sort By Date -->
                                <div class="col-span-1">
                                    <label for="midwife-sort-button" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label>
                                    <button id="midwife-sort-button" 
                                        data-dropdown-toggle="midwife-sort-menu"
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''"
                                        class="w-full text-main_font bg-f7 focus:outline-none font-medium disabled:bg-gray-200 border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        Date
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <div id="midwife-sort-menu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                        <ul class="py-2 text-sm text-gray-700">
                                            <li><a href="#" id="no-sort" class="block px-4 py-2 hover:bg-gray-100">All Time</a></li>
                                            <li><a href="#" id="sort-last-week" class="block px-4 py-2 hover:bg-gray-100">Last Week</a></li>
                                            <li><a href="#" id="sort-last-month" class="block px-4 py-2 hover:bg-gray-100">Last Month</a></li>
                                            <li><a href="#" id="sort-last-year" class="block px-4 py-2 hover:bg-gray-100">Last Year</a></li>
                                            <li><a href="#" id="sort-custom" class="block px-4 py-2 hover:bg-gray-100">Custom Date</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Add Midwife Button -->
                                <div class="col-span-1">
                                    <label class="mb-2 text-sm font-medium text-main_font">&nbsp;</label>
                                    <button
                                        id="add-midwife-button"
                                        type="button"
                                        data-modal-target="add-midwife-modal"
                                        data-modal-toggle="add-midwife-modal"
                                        class="w-full h-[2.375rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19,20a1,1,0,0,1-1-1V18H17a1,1,0,0,1,0-2h1V15a1,1,0,0,1,2,0v1h1a1,1,0,0,1,0,2H20v1A1,1,0,0,1,19,20Z" style="fill: currentColor;"/>
                                            <path d="M15,17a4,4,0,0,1,2.63-3.74,6,6,0,0,0-2.31-1.11,6,6,0,1,0-8.64,0A6,6,0,0,0,2,18v1a1,1,0,0,0,.29.71C2.53,19.94,4.77,22,11,22a17.17,17.17,0,0,0,6.88-1.18A4,4,0,0,1,15,17Z" style="fill: currentColor;"/>
                                        </svg>
                                        Add Midwife
                                    </button>
                                </div>

                                <!-- Hide Button -->
                                <div class="col-span-1">
                                    <label class="mb-2 text-sm font-medium text-main_font">&nbsp;</label>
                                    <div class="h-[2.375rem] flex items-center">
                                        <x-hide-button />
                                    </div>
                                </div>
                            </div>
                        </div>
                                                
                        <x-midwife.midwife-tables :midwives="$midwives" />
                       <div id="midwives-pagination-links" class="mt-4">
                            {{ $midwives->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const emptyStateImageUrl = "{{ asset('images/illustrations/not-found.png') }}";
    </script>
    @include('components.modals.midwife.add-midwife')
</x-app-layout>
