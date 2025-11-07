<div id="edit-health-program-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-800 py-8 px-10 transition-transform duration-300 ease-out scale-95">
            
            <!-- Header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-6 border-b border-gray-200 dark:border-gray-600 pb-6">
                <h3 class="text-xl font-semibold text-main_font dark:text-white">
                    Edit Health Program
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update Health Program Details</p>
            </div>

            <!-- Form -->
            <form id="edit-health-program-form" class="p-4 md:p-5">
                <div class="space-y-4">
                    
                    <!-- Program Name -->
                    <div>
                        <label for="edit-program-name" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Program Name</label>
                        <input type="text" id="edit-program-name" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter program name" required>
                    </div>

                    <!-- Age Range -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="edit-min-age" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Min Age</label>
                            <input type="number" id="edit-min-age" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g., 0" required>
                        </div>
                        <div>
                            <label for="edit-max-age" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Max Age</label>
                            <input type="number" id="edit-max-age" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g., 65" required>
                        </div>
                    </div>

                    <!-- Program Type -->
                    <div>
                        <label for="edit-program-type" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Program Type</label>
                        <select id="edit-program-type" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="">Choose a program type</option>
                            <option value="vaccination_drive">Vaccination Drive</option>
                            <option value="senior_citizen">Senior Citizen</option>
                            <option value="general_consultation">General Consultation</option>
                            <option value="child_healthcare_tcl">Child Healthcare</option>
                        </select>
                    </div>

                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-6 mt-6 border-t border-gray-200 dark:border-gray-600">
                    <button id="cancel-edit-health-program" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Cancel
                    </button>
                    <button id="edit-health-program-submit" type="submit" class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-mainblue dark:focus:ring-blue-800">
                        Save Changes
                    </button>                
                </div>
            </form>

        </div>
    </div>
</div>

@include('components.modals.health-program.edit-program-confirm')