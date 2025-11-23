{{-- Your original view file, e.g., midwives.blade.php --}}

@section('page-id', 'midwives')
@section('title', 'Midwives')

<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Midwives</h1>
            <div class="bg-f7 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
                        <div class="pb-6 w-full">
                            {{-- Grid Container --}}
                            <div class="grid grid-cols-1 slg2:grid-cols-7 xl:grid-cols-9 gap-4 w-full items-end">
                                
                                {{-- 1. Search Input --}}
                                {{-- Takes full width on SLG2 (Row 1), takes 3/9 cols on XL (Row 1) --}}
                                <div class="w-full col-span-1 slg2:col-span-7 xl:col-span-3">
                                    <label for="midwife-search-input" class="mb-2 text-sm font-medium text-main_font">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="search" id="midwife-search-input" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                                    </div>
                                </div>

                                {{-- 2. Filter Dropdown --}}
                                {{-- Takes 2 cols --}}
                                <div class="col-span-1 slg2:col-span-2 relative">
                                    <label for="midwife-filter-button" class="mb-2 text-sm font-medium text-main_font">Filter By</label>
                                    <button id="midwife-filter-button" data-dropdown-toggle="midwife-filter-menu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
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

                                {{-- 3. Sort Dropdown --}}
                                {{-- Takes 2 cols --}}
                                <div class="col-span-1 slg2:col-span-2 relative">
                                    <label for="midwife-sort-button" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label>
                                    <button id="midwife-sort-button" data-dropdown-toggle="midwife-sort-menu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
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

                                <div class="col-span-1 slg2:col-span-2 xl:col-span-2">
                                    <button
                                        id="add-midwife-button"
                                        type="button"
                                        data-modal-target="add-midwife-modal"
                                        data-modal-toggle="add-midwife-modal"
                                        class="w-full h-[2.375rem] text-f7 slg2:max-w-32 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3 flex items-center justify-center">
                                        Add Midwife
                                    </button>
                                </div>
                            </div>
                        </div>
                                                
                        <x-midwife.midwife-tables :midwives="$midwives" />
                        <div id="midwives-pagination-links" class="mt-4">
                            {{-- Pagination will be rendered here by JavaScript --}}
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