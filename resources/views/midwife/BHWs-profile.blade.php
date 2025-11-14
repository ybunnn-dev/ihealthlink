@section('title', 'BHWs | #' .$personnel->user->id)
@section('page-id', 'spec-bhw')
<x-app-layout>
    <script>
        window.bhwData = @json($personnel);
    </script>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('midwife.bhws') }}">
                    <div class="flex items-center space-x-2"> 
                        <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span class="font-semibold">Return</span>
                    </div>
                </a>
                
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-3">
                    <!-- Left Column (Profile + Buttons) -->
                    <div class="grid grid-rows-6 gap-2 col-span-1">
                        <!-- Profile Card -->
                        <div class="bg-f7 rounded-lg flex flex-col items-center justify-center p-4 row-span-5"> 
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <path opacity="0.4" d="M12.1207 12.78C12.0507 12.77 11.9607 12.77 11.8807 12.78C10.1207 12.72 8.7207 11.28 8.7207 9.50998C8.7207 7.69998 10.1807 6.22998 12.0007 6.22998C13.8107 6.22998 15.2807 7.69998 15.2807 9.50998C15.2707 11.28 13.8807 12.72 12.1207 12.78Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path opacity="0.34" d="M18.7398 19.3801C16.9598 21.0101 14.5998 22.0001 11.9998 22.0001C9.39977 22.0001 7.03977 21.0101 5.25977 19.3801C5.35977 18.4401 5.95977 17.5201 7.02977 16.8001C9.76977 14.9801 14.2498 14.9801 16.9698 16.8001C18.0398 17.5201 18.6398 18.4401 18.7398 19.3801Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                </g>
                            </svg>
                            <p class="text-main_font font-bold mt-4 text-xl">{{ $personnel->name }}</p> 
                            <p class="text-main_font font-semibold">BHW #{{ $personnel->id }}</p> 
                        </div>

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 w-full px-0 pb-0 row-span-1 gap-3">
                            <button id="open-edit-bhw" type="button" class="col-span-1 px-5 py-3 text-sm font-medium text-white bg-mainblue rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300">Edit</button>
                            <button id="open-remove-bhw" type="button" class="col-span-1 px-5 py-3 text-sm font-medium text-mainblue bg-white border border-mainblue rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-300">Remove</button>
                        </div>
                    </div>

                    <!-- Right Column (BHW Info) -->
                    <div class="col-span-1 xl:col-span-2 h-full bg-f7 rounded-lg px-6 sm:px-10 lg:px-12 py-8">
                        <div class="flex items-center gap-2 mb-6">
                            <h2 class="text-xl font-semibold text-main_font">BHW Info</h2>
                        </div>

                        <div class="grid grid-cols-1 gap-y-4 text-xs">
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">FIRST NAME:</p>
                                <p class="text-normal_font">{{ $personnel->user->firstName }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">LAST NAME:</p>
                                <p class="text-normal_font">{{ $personnel->user->lastName }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">MIDDLE NAME:</p>
                                <p class="text-normal_font">{{ $personnel->user->middleName ?? 'N/A' }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">SUFFIX:</p>
                                <p class="text-normal_font">{{ $personnel->user->suffix ?? 'N/A' }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">BIRTHDATE:</p>
                                <p class="text-normal_font">{{ \Carbon\Carbon::parse($personnel->user->birthdate)->format('F d, Y') }} ({{ \Carbon\Carbon::parse($personnel->user->birthdate)->age }} Years old)</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">ADDRESS:</p>
                                <p class="text-normal_font">Brgy. {{ $personnel->barangay->name }}, Daraga, Albay</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">SEX:</p>
                                <p class="text-normal_font">{{ $personnel->user->sex }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">MOBILE NUMBER:</p>
                                <p class="text-normal_font">{{ $personnel->user->contact_no ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Activity Log Section --}}
                <h2 class="text-2xl font-semibold text-main_font mt-8">{{ $personnel->name }} Activity Log</h2>

               <div class="bg-white p-6 rounded-xl" 
                    x-data="activityLogData()">
                    
                    {{-- Search and Filter --}}
                    <div class="flex flex-col slg2:flex-row slg2:items-end gap-4 mb-4">
                        <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
                            <label for="activity-search" class="mb-2 text-sm font-medium text-main_font">Search Activity</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="search" 
                                    id="activity-search"
                                    x-model="search" 
                                    @input.debounce.500ms="fetchLogs(1)"
                                    class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" 
                                    placeholder="Search activity...">
                            </div>
                        </div>

                        <div class="w-full xs:w-48">
                            <label for="dateFilter" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label>
                            <select x-model="dateFilter" 
                                    @change="fetchLogs(1)"
                                    id="dateFilter"
                                    class="w-full text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-gray-300 rounded-lg text-sm px-4 py-2 h-[2.375rem]">
                                <option value="">All Date</option>
                                <option value="last_week">Last Week</option>
                                <option value="last_month">Last Month</option>
                            </select>
                        </div>
                    </div>

                    {{-- Loading State --}}
                    <div x-show="loading" class="flex justify-center items-center py-12">
                        <svg class="animate-spin h-10 w-10 text-mainblue" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>

                    {{-- Table --}}
                    <div id="activity-log-table-container" x-show="!loading">
                        @include('components.bhw.activity-log-table', ['logs' => $logs, 'personnel' => $personnel])
                    </div>

                    {{-- Pagination --}}
                    <div id="pagination-container" class="mt-4" x-show="!loading">
                        {{ $logs->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('components.modals.bhw.edit-bhw-modal')
    @include('components.modals.bhw.remove-bhw')
</x-app-layout>
