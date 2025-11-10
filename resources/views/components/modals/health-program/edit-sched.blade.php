<div id="edit-schedule-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-800 py-8 px-10 transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t mb-6 border-b border-gray-200 dark:border-gray-600 pb-6">
                <h3 class="text-xl font-semibold text-main_font dark:text-white">
                    Edit Schedule
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update the schedule details</p>
            </div>

            <form id="edit-schedule-form" class="p-4 md:p-5">
                <input type="hidden" id="edit-schedule-id" name="schedule_id">

                <div class="space-y-4">
                    
                    <div>
                        <label for="edit-schedule-title" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Schedule Title</label>
                        <input type="text" id="edit-schedule-title" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter schedule title" required>
                    </div>

                    <div>
                        <label for="edit-schedule-intervals" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Intervals (in days)</label>
                        <input type="number" id="edit-schedule-intervals" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g., 30" required>
                    </div>

                    <div>
                        <label for="edit-schedule-position" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Position After</label>
                        <select id="edit-schedule-position" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="">Choose a position</option>
                            <option value="start">At the very beginning</option>
                            
                            {{-- This logic remains the same --}}
                            @if($healthProgram->programFields)
                                @foreach($healthProgram->programFields as $field)
                                    <option value="{{ $field->id }}">After {{ $field->title }}</option>
                                @endforeach
                            @endif

                        </select>
                    </div>

                </div>
                
                <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-gray-200 dark:border-gray-600">
                    <button id="cancel-edit-schedule" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Cancel
                    </button>
                    <button id="edit-schedule-submit" type="submit" class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 disabled:opacity-50">
                        Save Changes
                    </button>                
                </div>
            </form>

        </div>
    </div>
</div>
@include('components.modals.health-program.edit-sched-confirm')