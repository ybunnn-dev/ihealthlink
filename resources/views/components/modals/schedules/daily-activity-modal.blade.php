<div id="edit-daily-activity-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 max-w-full">
            <div class="flex flex-col items-center justify-center rounded-t mb-3">
                <h3 class="text-xl font-semibold text-main_font">
                    Edit Daily Activity
                </h3>
                <p class="text-sm text-normal_font -mt-1">Update the activity details below</p>
            </div>
            
            <div class="p-4 md:p-5 space-y-4 max-h-[70vh] overflow-y-auto w-full">
                <div class="grid grid-cols-1 gap-4 w-full">

                    <div>
                        <label for="activityName" class="block mb-2 text-sm font-medium text-main_font">ACTIVITY</label>
                        <input type="text" id="activityName" name="activity_name" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Regular Consultation" required>
                    </div>

                    <div>
                        <label for="activityDay" class="block mb-2 text-sm font-medium text-main_font">DAY</label>
                        <input type="text" id="activityDay" name="activity_day" class="border border-gray-300 text-gray-700 text-sm rounded-lg block w-full p-2.5 bg-gray-100 cursor-not-allowed" placeholder="Monday Schedule" disabled>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-main_font">CHOOSE ICON</label>
                        <div class="h-48 overflow-y-auto border border-gray-300 rounded-lg p-4">
                            <div class="grid grid-cols-1 slg:grid-cols-3 gap-2">
                               @foreach ($activityIcons as $icon)
                                    @continue($icon->id === 1)
                                    <button 
                                        id="icon-button-{{ $icon->id }}"
                                        type="button" 
                                        value="{{ $icon->id }}" 
                                        class="icon-picker-button p-2 border rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200"
                                        aria-label="Select icon {{ $icon->id }}">
                                        
                                        <svg class="w-10 h-10 mx-auto text-[#999999]" fill="currentColor" viewBox="{{ $icon->viewbox ?? '0 0 48 48' }}"  xmlns="http://www.w3.org/2000/svg">
                                            {{-- Render the raw SVG path data from the database --}}
                                            {!! $icon->path !!}
                                        </svg>
                                    </button>
                                @endforeach                           
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-4">
                <button id="cancel-edit-activity-button" data-modal-hide="edit-daily-activity-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button 
                    id="save-daily-activity-button" 
                    type="button" 
                    class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:bg-gray-400 disabled:cursor-not-allowed">
                    Save Changes
                </button>            
            </div>
        </div>
    </div>
</div>
@include('components.modals.schedules.confirm-edit-daily-activity')