<div class="bg-white rounded-xl py-6 px-10 cols-span-1 md:col-span-2">
    <div class="flex items-center justify-between flex-wrap gap-3 mb-3">
        <h2 id="schedule-date-header" class="text-xl font-semibold text-main_font flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            </h2>
        <button id="add-activity-btn" class="w-32 h-[2rem] bg-mainblue rounded-md text-xs font-semibold text-f7 px-6">Add Activity</button>
    </div>

    <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
        <thead>
            <tr>
                <th class="px-6 py-2 w-5/12">Activity</th>
                <th class="px-6 py-2 w-2/12">Time</th>
                <th class="px-6 py-2 w-3/12">Venue</th>
                <th class="px-6 py-2 w-3/12 text-center">Actions</th>
            </tr>
        </thead>

        <tbody id="schedule-list-body">
            <tr class="bg-f7 border-b text-normal_font" data-schedule-id="{schedule.id}">
                <td id="activity-{schedule.id}" class="px-6 py-3">{schedule.activity}</td>
                <td id="time-{schedule.id}" class="px-6 py-3">{schedule.time}</td>
                <td id="venue-{schedule.id}" class="px-6 py-3">{schedule.venue}</td>
                <td class="px-6 py-3 text-center">
                    <button class="text-blue-500 hover:underline text-xs mr-3" data-action="edit" data-schedule-id="{schedule.id}">Edit</button>
                    <button class="text-red-500 hover:underline text-xs" data-action="delete" data-schedule-id="{schedule.id}">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@include('components.modals.schedules.edit-activity-modal')
@include('components.modals.schedules.remove-activity-modal')