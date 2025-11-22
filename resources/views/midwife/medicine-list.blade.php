@section('title', 'Medicines')
@section('page-id', 'medicines')
<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Medicines</h1>

            <div class="bg-f7 rounded-xl h-full max-h[80vh]" 
                x-data="medicineFilter('{{ route('midwife.medicines') }}')" 
                x-init="init()">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
                        <div class="pb-6 w-full">
                            <div class="grid grid-cols-1 slg2:grid-cols-8 xl:grid-cols-12 gap-4 w-full items-end">
                                
                                <div class="w-full col-span-1 slg2:col-span-8 xl:col-span-4">
                                    <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for a medicine?</label> 
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="search" 
                                            x-model="filters.search" 
                                            @input.debounce.500ms="fetchResults()"
                                            id="default-search" 
                                            class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-200" 
                                            placeholder="Search..."/>
                                    </div>
                                </div>
                                
                                <div class="col-span-1 slg2:col-span-2 xl:col-span-2">
                                    <label for="categoryDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by Category</label> 
                                    <button 
                                        id="categoryDropdown" 
                                        data-dropdown-toggle="categoryDropdownMenu" 
                                        class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" 
                                        type="button">
                                        <span class="truncate" x-text="categoryLabel"></span>
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <div id="categoryDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-48 dark:bg-gray-700">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="categoryDropdown">
                                            <li><a href="#" @click.prevent="selectCategory('', 'All')" class="block px-4 py-2 hover:bg-gray-100">All</a></li>
                                            <li><a href="#" @click.prevent="selectCategory('reg-med', 'Regular Medicine')" class="block px-4 py-2 hover:bg-gray-100">Regular Medicine</a></li>
                                            <li><a href="#" @click.prevent="selectCategory('deworming', 'Deworming Tablet')" class="block px-4 py-2 hover:bg-gray-100">Deworming Tablet</a></li>
                                            <li><a href="#" @click.prevent="selectCategory('iron-w-fa', 'Iron with Folic Acid')" class="block px-4 py-2 hover:bg-gray-100">Iron with Folic Acid</a></li>
                                            <li><a href="#" @click.prevent="selectCategory('iron', 'Iron')" class="block px-4 py-2 hover:bg-gray-100">Iron</a></li>
                                            <li><a href="#" @click.prevent="selectCategory('vit-a', 'Vitamin A')" class="block px-4 py-2 hover:bg-gray-100">Vitamin A</a></li>
                                            <li><a href="#" @click.prevent="selectCategory('cc', 'Calcium Carbonate')" class="block px-4 py-2 hover:bg-gray-100">Calcium Carbonate</a></li>
                                            <li><a href="#" @click.prevent="selectCategory('iodine', 'Iodine Capsule')" class="block px-4 py-2 hover:bg-gray-100">Iodine Capsule</a></li>
                                            <li><a href="#" @click.prevent="selectCategory('vaccine', 'Vaccine')" class="block px-4 py-2 hover:bg-gray-100">Vaccine</a></li>
                                            <li><a href="#" @click.prevent="selectCategory('bcg', 'BCG Vaccine')" class="block px-4 py-2 hover:bg-gray-100">BCG Vaccine</a></li>
                                            <li><a href="#" @click.prevent="selectCategory('dpt-hepb-hib', 'DPT-HepB-Hib Vaccine')" class="block px-4 py-2 hover:bg-gray-100">DPT-HepB-Hib Vaccine</a></li>
                                            <li><a href="#" @click.prevent="selectCategory('hepa-b-bd', 'Hepatitis B Birth Dose')" class="block px-4 py-2 hover:bg-gray-100">Hepatitis B Birth Dose</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-span-1 slg2:col-span-2 xl:col-span-2">
                                    <label for="nameDropdown" class="mb-2 text-sm font-medium text-main_font">Name</label> 
                                    <button 
                                        id="nameDropdown" 
                                        data-dropdown-toggle="nameDropdownMenu" 
                                        class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" 
                                        type="button">
                                        <span class="truncate" x-text="nameSortLabel"></span>
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <div id="nameDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-48 dark:bg-gray-700">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="nameDropdown">
                                            <li><a href="#" @click.prevent="selectNameSort('asc', 'Ascending')" class="block px-4 py-2 hover:bg-gray-100">Ascending</a></li>
                                            <li><a href="#" @click.prevent="selectNameSort('desc', 'Descending')" class="block px-4 py-2 hover:bg-gray-100">Descending</a></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="col-span-1 slg2:col-span-2 xl:col-span-2">
                                    <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label> 
                                    <button 
                                        id="dateDropdown" 
                                        data-dropdown-toggle="dateDropdownMenu" 
                                        class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" 
                                        type="button">
                                        <span class="truncate" x-text="dateSortLabel"></span>
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-48 dark:bg-gray-700">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dateDropdown">
                                            <li><a href="#" @click.prevent="selectDateSort('', 'None')" class="block px-4 py-2 hover:bg-gray-100">None</a></li>
                                            <li><a href="#" @click.prevent="selectDateSort('desc', 'Newest First')" class="block px-4 py-2 hover:bg-gray-100">Newest First</a></li>
                                            <li><a href="#" @click.prevent="selectDateSort('asc', 'Oldest First')" class="block px-4 py-2 hover:bg-gray-100">Oldest First</a></li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="col-span-1 slg2:col-span-2 xl:col-span-2 grid grid-cols-1 gap-2">
                                    <button id="add-med-btn" type="button" class="col-span-1 h-[2.375rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3 flex items-center justify-center gap-2">
                                        Add Medicines
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="relative overflow-x-auto" x-show="!loading">
                            <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                                <thead class="text-xs text-main_font uppercase">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">MEDICINE #</th>
                                        <th scope="col" class="px-6 py-3">MEDICINE NAME</th>
                                        <th scope="col" class="px-6 py-3">TOTAL QUANTITY</th>
                                        <th scope="col" class="px-6 py-3">CATEGORY</th>
                                        <th scope="col" class="px-6 py-3">FORM</th>
                                        <th scope="col" class="px-6 py-3">DATE UPDATED</th>
                                    </tr>
                                </thead>
                                <tbody id="medicine-table-body">
                                    @include('components.medicine.medicine-table', ['medicines' => $medicines])
                                </tbody>
                            </table>
                        </div>

                        <!-- Loading indicator -->
                        <div x-show="loading" class="text-center py-10">
                            <svg class="animate-spin h-8 w-8 mx-auto text-mainblue" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <div class="mt-6" id="pagination-links">
                            {{ $medicines->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@include('components.modals.medicine.add-medicine-modal')
