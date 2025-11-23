<div id="confirm-add-family-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Card: py-6 mobile, py-10 desktop -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-6 md:py-10 px-6 transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t mb-4 text-center">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font">
                    Confirm New Family Member
                </h3>
                <p class="text-sm text-normal_font mt-1">
                    Are you sure you want to add this person to the household?
                </p>
            </div>
            
            <div class="p-4 md:p-5">
                <div class="flex items-center justify-center">
                    <!-- Checkbox: Increased size for touch targets (w-5 h-5) -->
                    <input id="confirm-family-checkbox" type="checkbox" value="" class="w-5 h-5 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue focus:ring-2 cursor-pointer">
                    <label for="confirm-family-checkbox" class="ms-2 text-sm font-medium text-gray-900 cursor-pointer select-none">I have reviewed the family member's details.</label>
                </div>
            </div>
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6">
                <button id="confirm-add-family-cancel" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </button>
                <button id="confirm-add-family-submit" type="button" 
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors" disabled>
                    Confirm & Proceed
                </button>
            </div>
        </div>
    </div>
</div>
