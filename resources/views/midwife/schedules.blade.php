<x-app-layout>
    @section('title', 'Schedules')
    @section('page-id', 'sched')
    <div class="py-12 px-5">
        <script>
            window.activityIcons= @json($activityIcons);
        </script>
        
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-3">
                <h1 class="text-3xl font-semibold text-sub_blue mb-3 col-span-full">Schedules</h1>
                <x-schedules.sched-tab />
                <div id="scheduledContent" class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <x-schedules.schedule-calendar />

                    <!-- Current Date Schedule Card -->
                    <x-schedules.current-date-schedules />
                    <!-- Upcoming Schedules Card -->
                    <div class="bg-white rounded-xl p-6 md:col-span-1">
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
                    <div class="bg-white rounded-xl py-6 px-10 md:col-span-2">
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
                <x-schedules.day-schedule-cards :dailyActivities="$dailyActivities" :activityIcons="$activityIcons" />
            </div>
        </div>
    </div>
    @include('components.modals.add-activity-modal')
</x-app-layout>
