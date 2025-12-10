<div id="add-health-program-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-5xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-800 py-8 px-10 transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t mb-6 border-b border-gray-200 dark:border-gray-600 pb-6">
                <h3 class="text-xl font-semibold text-main_font dark:text-white">
                    Add Health Program
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Add Health Program Details to continue</p>
            </div>

            <form class="p-4 md:p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                    <div class="space-y-4">
                        <div>
                            <label for="program-name" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Name</label>
                            <input type="text" id="program-name" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter program name" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="min-age" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Min Age</label>
                                <input type="number" id="min-age" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g., 18">
                            </div>
                            <div>
                                <label for="max-age" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Max Age</label>
                                <input type="number" id="max-age" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g., 65">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="program-type" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Program Type</label>
                                <select id="program-type" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected>Choose a program type</option>
                                    <option value="vaccination_drive">Vaccination Drive</option>
                                    <option value="senior_citizen">Senior Citizen</option>
                                    <option value="general_consultation">General Consultation</option>
                                </select>
                            </div>
                            <div>
                                <label for="program-mode" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Program Mode</label>
                                <select id="program-mode" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected >Choose a mode</option>
                                    <option value="fixed">Fixed</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4"> 
                            <div>
                                <label for="schedule-type" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Schedule Type</label>
                                <select id="schedule-type" disabled class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-bg_col">
                                    <option selected value="reset">Choose a schedule</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="annually">Annually</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                             <div>
                                <label for="number-of-fields" class="block mb-2 text-sm font-medium text-main_font dark:text-white">No. of Fields</label>
                                <input type="text" id="number-of-fields" disabled placeholder="e.g., '4'" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-bg_col">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="custom-interval" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Interval (Days)</label>
                                <input type="number" id="custom-interval" disabled placeholder="e.g., '3 days'" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-bg_col">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="schedule-name" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Schedule Name</label>
                            <input type="text" disabled  id="schedule-name" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-bg_col" placeholder="e.g., '1st Dose'">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="schedule-interval" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Interval (Days)</label>
                                <input type="number" disabled id="schedule-interval" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-bg_col" placeholder="e.g., 6">
                            </div>
                        </div>
                        <button id="add-sched-btn" type="button" disabled class="w-full text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-mainblue dark:focus:ring-blue-800 disabled:opacity-50 disabled:cursor-not-allowed">Add Schedule</button>
                        
                        <div class="border-2 border-dashed rounded-lg h-44 overflow-y-auto p-4 dark:border-gray-600">
                            <div class="flex items-center justify-center h-full">
                                <p class="text-gray-400">Added schedules will appear here</p>
                            </div>
                            
                        </div>
                        <button id="clear-sched" class="w-full text-sm text-normal_font"><u>Clear Schedules</u></button>
                    </div>
                </div>
                
                <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-gray-200 dark:border-gray-600">
                    <button id="cancel-add-health-program" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                    <button id="add-health-program-submit" disabled type="submit" class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-mainblue dark:focus:ring-blue-800 disabled:opacity-50 disabled:cursor-not-allowed">
                        Add Health Program
                    </button>                
                </div>
            </form>
        </div>
    </div>
</div>
@include('components.modals.health-program.add-health-program-confirmation')