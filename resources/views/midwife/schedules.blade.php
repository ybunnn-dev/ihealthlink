<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <h1 class="text-3xl font-semibold text-sub_blue mb-3 col-span-full">Schedules</h1>

                <!-- Calendar Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 md:col-span-1">
                    <div class="flex items-center justify-between mb-4">
                        <button class="text-gray-500 hover:text-gray-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <div class="text-lg font-semibold text-gray-900">May 2025</div>
                        <button class="text-gray-500 hover:text-gray-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-7 gap-2 text-center text-xs p-4 bg-bg_col rounded-lg">
                        <div class="text-gray-500 font-medium">Sun</div>
                        <div class="text-gray-500 font-medium">Mon</div>
                        <div class="text-gray-500 font-medium">Tue</div>
                        <div class="text-gray-500 font-medium">Wed</div>
                        <div class="text-gray-500 font-medium">Thu</div>
                        <div class="text-gray-500 font-medium">Fri</div>
                        <div class="text-gray-500 font-medium">Sat</div>

                        <div class="p-2"></div>
                        <div class="p-2"></div>
                        <div class="p-2"></div>
                        <div class="p-2">1</div>
                        <div class="p-2">2</div>
                        <div class="p-2">3</div>
                        <div class="p-2">4</div>

                        <div class="p-2">5</div>
                        <div class="p-2">6</div>
                        <div class="p-2">7</div>
                        <div class="p-2">8</div>
                        <div class="p-2">9</div>
                        <div class="p-2">10</div>
                        <div class="p-2">11</div>

                        <div class="p-2">12</div>
                        <div class="p-2">13</div>
                        <div class="p-2">14</div>
                        <div class="p-2 bg-blue-500 text-white rounded-full">15</div> <div class="p-2 bg-blue-200 text-blue-800 rounded-full">16</div> <div class="p-2 bg-blue-100 text-blue-800 rounded-full">17</div> <div class="p-2 bg-blue-100 text-blue-800 rounded-full">18</div> <div class="p-2">19</div>
                        <div class="p-2">20</div>
                        <div class="p-2">21</div>
                        <div class="p-2">22</div>
                        <div class="p-2">23</div>
                        <div class="p-2">24</div>
                        <div class="p-2">25</div>

                        <div class="p-2">26</div>
                        <div class="p-2 bg-blue-100 text-blue-800 rounded-full">27</div> <div class="p-2">28</div>
                        <div class="p-2">29</div>
                        <div class="p-2">30</div>
                        <div class="p-2">31</div>
                    </div>
                </div>

                <!-- Current Date Schedule Card -->
                <div class="bg-white rounded-xl shadow-sm py-6 px-10 md:col-span-2">
                    <!-- Header -->
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-3">
                        <h2 class="text-xl font-semibold text-main_font flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            May 16, 2025
                        </h2>
                        <button class="w-32 h-6 bg-mainblue rounded-md text-xs font-semibold text-f7 px-6">Add Activity</button>
                    </div>

                    <!-- Table -->
                    <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                        <thead class="text-xs text-main_font uppercase">
                            <tr>
                                <th class="px-6 py-2">Activity</th>
                                <th class="px-6 py-2">Time</th>
                                <th class="px-6 py-2">Venue</th>
                                <th class="px-6 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-f7 border-b text-normal_font">
                                <td class="px-6 py-3">Purok 1 Vaccination</td>
                                <td class="px-6 py-3">8:00 AM</td>
                                <td class="px-6 py-3">Purok 1</td>
                                <td class="px-6 py-3 text-center">
                                    <button class="text-blue-500 hover:underline text-xs mr-3">Edit</button>
                                    <button class="text-red-500 hover:underline text-xs">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Upcoming Schedules Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 md:col-span-1">
                    <h2 class="text-xl font-semibold text-main_font mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Upcoming Schedules
                    </h2>
                     <ul class="space-y-2">
                        <li class="bg-bg_col rounded-lg p-3 flex items-start">
                            <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 text-gray-500 mr-3 mt-0.5" fill="currentColor">
                                <g>
                                    <path d="M2 2h16v4H2V2zm0 10V8h4v4H2zm6-2V8h4v2H8zm6 3V8h4v5h-4zm-6 5v-6h4v6H8zm-6 0v-4h4v4H2zm12 0v-3h4v3h-4z"></path>
                                </g>
                            </svg>
                            <div class="flex-grow">
                                <div class="text-sm font-semibold">Purok 1 Vaccination</div>
                                <div class="text-xs text-gray-500">May 5, 2025</div>
                            </div>
                        </li>

                        <li class="bg-bg_col rounded-lg p-3 flex items-start">
                            <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 text-gray-500 mr-3 mt-0.5" fill="currentColor">
                                <g>
                                    <path d="M2 2h16v4H2V2zm0 10V8h4v4H2zm6-2V8h4v2H8zm6 3V8h4v5h-4zm-6 5v-6h4v6H8zm-6 0v-4h4v4H2zm12 0v-3h4v3h-4z"></path>
                                </g>
                            </svg>
                            <div class="flex-grow">
                                <div class="text-sm font-semibold">Profiling</div>
                                <div class="text-xs text-gray-500">May 6, 2025</div>
                            </div>
                        </li>

                        <li class="bg-bg_col rounded-lg p-3 flex items-start">
                            <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 text-gray-500 mr-3 mt-0.5" fill="currentColor">
                                <g>
                                    <path d="M2 2h16v4H2V2zm0 10V8h4v4H2zm6-2V8h4v2H8zm6 3V8h4v5h-4zm-6 5v-6h4v6H8zm-6 0v-4h4v4H2zm12 0v-3h4v3h-4z"></path>
                                </g>
                            </svg>
                            <div class="flex-grow">
                                <div class="text-sm font-semibold">Meeting</div>
                                <div class="text-xs text-gray-500">May 5, 2025</div>
                            </div>
                        </li>

                        <li class="bg-bg_col rounded-lg p-3 flex items-start">
                            <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 text-gray-500 mr-3 mt-0.5" fill="currentColor">
                                <g>
                                    <path d="M2 2h16v4H2V2zm0 10V8h4v4H2zm6-2V8h4v2H8zm6 3V8h4v5h-4zm-6 5v-6h4v6H8zm-6 0v-4h4v4H2zm12 0v-3h4v3h-4z"></path>
                                </g>
                            </svg>
                            <div class="flex-grow">
                                <div class="text-sm font-semibold">Deworming</div>
                                <div class="text-xs text-gray-500">May 6, 2025</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Current Activity Card -->
                <div class="bg-white rounded-xl shadow-sm py-6 px-10 md:col-span-2">
                    <h2 class="text-xl font-semibold text-main_font mb-6">Current Activity</h2>
                    <div class="grid grid-cols-1 gap-y-3 text-sm max-w-[70%]">
                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                            <p class="font-semibold text-main_font">ACTIVITY:</p>
                            <p class="text-normal_font">Deworming at Purok 1</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                            <p class="font-semibold text-main_font">DATE:</p>
                            <p class="text-normal_font">May 16, 2025</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                            <p class="font-semibold text-main_font">TIME:</p>
                            <p class="text-normal_font">8:00 AM</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                            <p class="font-semibold text-main_font">VENUE:</p>
                            <p class="text-normal_font">Purok 1</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                            <p class="font-semibold text-main_font">HEALTH PROGRAM:</p>
                            <p class="text-normal_font">Deworming</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                            <p class="font-semibold text-main_font">ASSIGNED BHW(s):</p>
                            <p class="text-normal_font">Ron Peter Mortega</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/app.js')
    @endpush
</x-app-layout>
