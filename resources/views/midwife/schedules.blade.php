<x-app-layout>
    @section('title', 'Schedules')
    @section('page-id', 'sched')
    <div class="py-12 px-5">
        <script>
            window.activityIcons= @json($activityIcons);
            window.scheds=@json($schedules);
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
                    <x-schedules.upcoming-sched :upcomingActivities="$schedules" />

                    <!-- Current Activity Card -->
                    <div class="bg-white rounded-xl py-6 px-10 md:col-span-2">
                        <h2 class="text-xl font-semibold text-main_font mb-6">Current Activity</h2>

                        <div id="current-activity-details" class="grid grid-cols-1 gap-y-3 text-sm max-w-[70%]">
                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                                <p class="font-semibold text-main_font">ACTIVITY:</p>
                                <p id="view-activity" class="text-normal_font"></p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                                <p class="font-semibold text-main_font">DATE:</p>
                                <p id="view-date" class="text-normal_font"></p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                                <p class="font-semibold text-main_font">TIME:</p>
                                <p id="view-time" class="text-normal_font"></p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                                <p class="font-semibold text-main_font">VENUE:</p>
                                <p id="view-venue" class="text-normal_font"></p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                                <p class="font-semibold text-main_font">HEALTH PROGRAM:</p>
                                <p id="view-program" class="text-normal_font"></p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1 md:gap-x-2">
                                <p class="font-semibold text-main_font">ASSIGNED BHW(s):</p>
                                <p id="view-bhws" class="text-normal_font"></p>
                            </div>
                        </div>

                        <div id="no-activity-message" class="hidden text-center py-8">
                            <p class="text-gray-500">Woohoo! You have no schedule for this date.</p>
                        </div>
                    </div>
                </div>
                <x-schedules.day-schedule-cards :dailyActivities="$dailyActivities" :activityIcons="$activityIcons" />
            </div>
        </div>
    </div>
     <script>
        const emptyStateImageUrl = "{{ asset('images/illustrations/empty.png') }}";
    </script>
    @include('components.modals.add-activity-modal')
</x-app-layout>
