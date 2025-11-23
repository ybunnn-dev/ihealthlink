@section('title', 'FAQs')
@section('page-id', 'faqs')
<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">FAQs</h1>
            
            <div class="bg-f7 rounded-xl overflow-hidden" 
                x-data="faqFilter('{{ route('mho.faq') }}')" 
                x-init="init()">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
                        <div class="pb-6 w-full">
                            {{-- Grid Container --}}
                            <div class="grid grid-cols-1 slg2:grid-cols-7 xl:grid-cols-9 gap-4 w-full items-end">
                                
                                {{-- 1. Search Bar --}}
                                {{-- Full width on SLG2 (Row 1), shares row on XL --}}
                                <div class="w-full col-span-1 slg2:col-span-7 xl:col-span-5">
                                    <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search FAQs</label>
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
                                            class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                                            placeholder="Search questions, answers, or categories..."/>
                                    </div>
                                </div>

                                {{-- 2. Module Filter Dropdown --}}
                                {{-- Takes 4/7 cols on SLG2 (Row 2), 2/9 cols on XL (Row 1) --}}
                                <div class="col-span-1 slg2:col-span-4 xl:col-span-2 relative">
                                    <label for="moduleDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by Module</label>
                                    <button 
                                        id="moduleDropdown" 
                                        data-dropdown-toggle="moduleDropdownMenu" 
                                        class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" 
                                        type="button">
                                        <span x-text="moduleLabel"></span>
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                    <div id="moduleDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-48 dark:bg-gray-700">
                                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="moduleDropdown">
                                            <li>
                                                <a href="#" @click.prevent="selectModule('', 'All Modules')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">All Modules</a>
                                            </li>
                                            @foreach($modules as $module)
                                                <li>
                                                    <a href="#" @click.prevent="selectModule('{{ $module->id }}', '{{ $module->module_name }}')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $module->module_name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                {{-- 3. Add FAQ Button --}}
                                {{-- Takes 3/7 cols on SLG2 (Row 2), 2/9 cols on XL (Row 1) --}}
                                <div class="col-span-1 slg2:col-span-1 xl:col-span-1">
                                    <button type="button" 
                                            id="add-faq-btn" 
                                            class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3 transition-colors">
                                        Add FAQ
                                    </button>
                                </div>

                            </div>
                        </div>
                        <!-- Loading indicator -->
                        <div x-show="loading" class="text-center py-10">
                            <svg class="animate-spin h-8 w-8 mx-auto text-mainblue" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        <!-- FAQ List -->
                        <div id="faq-list" x-show="!loading">
                            @include('components.faq.faq-list', ['faqs' => $faqs])
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6" id="pagination-links">
                            {{ $faqs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modals.faq.create-faq')
    @include('components.modals.faq.edit-faq')
    @include('components.modals.faq.delete-faq')
</x-app-layout>
