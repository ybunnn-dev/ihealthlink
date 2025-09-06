@php
    // This color map is still used for days that have an activity.
    $dayColorMap = [
        'monday'    => '#279EFF', // mainblue
        'tuesday'   => '#328E6E', // maingreen
        'wednesday' => '#D50B8B', // col_pink
        'thursday'  => '#854836', // col_brown
        'friday'    => '#252F6C', // sub_blue
        'saturday'  => '#EA5B6F', // red1
        'sunday'    => '#799EFF', // indigo1
    ];
    // Default color for active days not in the map
    $defaultColor = '#697A8D'; // normal_font
@endphp

<div id="dailyContent" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 slg2:grid-cols-4 col-span-full gap-5">
    @foreach ($dailyActivities as $activity)
        <div class="bg-white rounded-xl p-6 flex flex-col items-center text-center space-y-4">

            @if ($activity->activities == 'No Activity')
                {{-- 1. Display your specified gray icon for "No Activity" --}}
                <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_iconCarrier">
                        <path d="M5 15C4.06 15 3.19 15.33 2.5 15.88C1.58 16.61 1 17.74 1 19C1 21.21 2.79 23 5 23C6.01 23 6.93 22.62 7.64 22C8.47 21.27 9 20.2 9 19C9 16.79 7.21 15 5 15ZM6 19.25C6 19.51 5.86 19.76 5.64 19.89L4.39 20.64C4.27 20.72 4.13 20.75 4 20.75C3.75 20.75 3.5 20.62 3.36 20.39C3.15 20.03 3.26 19.57 3.62 19.36L4.51 18.83V17.75C4.5 17.34 4.84 17 5.25 17C5.66 17 6 17.34 6 17.75V19.25Z" fill="#999999"></path>
                        <path d="M14.85 3.95078V7.75078H13.35V3.95078C13.35 3.68078 13.11 3.55078 12.95 3.55078C12.9 3.55078 12.85 3.56078 12.8 3.58078L4.87 6.57078C4.34 6.77078 4 7.27078 4 7.84078V8.51078C3.09 9.19078 2.5 10.2808 2.5 11.5108V7.84078C2.5 6.65078 3.23 5.59078 4.34 5.17078L12.28 2.17078C12.5 2.09078 12.73 2.05078 12.95 2.05078C13.95 2.05078 14.85 2.86078 14.85 3.95078Z" fill="#999999"></path>
                        <path d="M21.5007 14.5V15.5C21.5007 15.77 21.2907 15.99 21.0107 16H19.5507C19.0207 16 18.5407 15.61 18.5007 15.09C18.4707 14.78 18.5907 14.49 18.7907 14.29C18.9707 14.1 19.2207 14 19.4907 14H21.0007C21.2907 14.01 21.5007 14.23 21.5007 14.5Z" fill="#999999"></path>
                        <path d="M19.48 12.95H20.5C21.05 12.95 21.5 12.5 21.5 11.95V11.51C21.5 9.44 19.81 7.75 17.74 7.75H6.26C5.41 7.75 4.63 8.03 4 8.51C3.09 9.19 2.5 10.28 2.5 11.51V13.29C2.5 13.67 2.9 13.91 3.26 13.79C3.82 13.6 4.41 13.5 5 13.5C8.03 13.5 10.5 15.97 10.5 19C10.5 19.72 10.31 20.51 10.01 21.21C9.85 21.57 10.1 22 10.49 22H17.74C19.81 22 21.5 20.31 21.5 18.24V18.05C21.5 17.5 21.05 17.05 20.5 17.05H19.63C18.67 17.05 17.75 16.46 17.5 15.53C17.3 14.77 17.54 14.03 18.04 13.55C18.41 13.17 18.92 12.95 19.48 12.95ZM14 12.75H9C8.59 12.75 8.25 12.41 8.25 12C8.25 11.59 8.59 11.25 9 11.25H14C14.41 11.25 14.75 11.59 14.75 12C14.75 12.41 14.41 12.75 14 12.75Z" fill="#999999"></path>
                    </g>
                </svg>

                <div>
                    <p class="text-gray-500 font-semibold">{{ $activity->activities }}</p>
                    <p class="text-gray-400 font-bold text-xl">{{ $activity->day }} Schedule</p>
                </div>
                
                <button 
                    data-activity-id="{{ $activity->id }}" 
                    data-activity-name="{{ $activity->activities }}" 
                    data-activity-day="{{ $activity->day }}"
                    data-modal-target="edit-daily-activity-modal" 
                    data-modal-toggle="edit-daily-activity-modal"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 edit-daily-activity-button">
                    Manage
                </button>

            @else
                {{-- This is the original logic for days WITH an activity --}}
                @php
                    $activityColor = $dayColorMap[strtolower($activity->day)] ?? $defaultColor;
                @endphp
                <svg class="w-10 h-10" style="color: {{ $activityColor }}" viewBox="0 0 48 48" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    {!! $activity->icon->path ?? '' !!}
                </svg>
                <div>
                    <p class="text-gray-500 font-semibold">{{ $activity->activities }}</p>
                    <p class="font-bold text-xl" style="color: {{ $activityColor }}">{{ $activity->day }} Schedule</p>
                </div>
                <button 
                    data-activity-id="{{ $activity->id }}" 
                    data-activity-name="{{ $activity->activities }}" 
                    data-activity-day="{{ $activity->day }}"
                    data-modal-target="edit-daily-activity-modal" 
                    data-modal-toggle="edit-daily-activity-modal"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 edit-daily-activity-button">
                    Manage
                </button>
            @endif

        </div>
    @endforeach
</div>

@include('components.modals.schedules.daily-activity-modal')