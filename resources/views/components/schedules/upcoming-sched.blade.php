@props(['upcomingActivities'])

@php
    // Filter to only show today and future schedules
    $filteredActivities = $upcomingActivities->filter(function($activity) {
        return \Carbon\Carbon::parse($activity->date)->isToday() || 
               \Carbon\Carbon::parse($activity->date)->isFuture();
    });
@endphp

<div class="bg-white rounded-xl p-6 md:col-span-1">
    <h2 class="text-xl font-semibold text-main_font mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Upcoming Schedules
    </h2>
    
    <ul class="space-y-2 max-h-72 overflow-y-auto scrollbar-thin scrollbar-gray-200 scrollbar-track-gray-100 scrollbar-hide-arrows pr-2">
        @forelse ($filteredActivities as $activity)
            <li class="bg-bg_col rounded-lg p-3 flex items-start">
                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 text-gray-500 mr-3 mt-0.5" fill="currentColor">
                    <g>
                        <path d="M2 2h16v4H2V2zm0 10V8h4v4H2zm6-2V8h4v2H8zm6 3V8h4v5h-4zm-6 5v-6h4v6H8zm-6 0v-4h4v4H2zm12 0v-3h4v3h-4z"></path>
                    </g>
                </svg>
                <div class="flex-grow">
                    <div class="text-sm font-semibold">{{ $activity->activity }}</div>
                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($activity->date)->format('F j, Y') }}</div>
                </div>
            </li>
        @empty
            <li class="p-3 text-center text-sm text-gray-500">
                No upcoming schedules.
            </li>
        @endforelse
    </ul>
</div>
