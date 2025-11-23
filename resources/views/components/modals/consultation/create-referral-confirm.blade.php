<div id="confirm-create-referral-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-6 md:py-10 px-6 transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t mb-6 text-center">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font dark:text-white">
                    Confirm Referral Creation
                </h3>
                <p class="text-sm text-normal_font mt-2 dark:text-gray-400">
                    Are you sure you want to create this referral for "<strong id="create-referral-resident-name-confirm" class="text-main_font font-semibold dark:text-white"></strong>"?
                </p>
            </div>
            <div class="p-4 md:p-5">
                <div class="flex items-center justify-center">
                    <input id="confirm-create-referral-checkbox" type="checkbox" value="" class="w-5 h-5 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 cursor-pointer">
                    <label for="confirm-create-referral-checkbox" class="ms-2 text-sm font-medium text-main_font dark:text-gray-300 cursor-pointer select-none">I have verified the referral details before proceeding.</label>
                </div>
            </div>
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6 mt-4">
                <button id="cancel-confirm-create-referral" data-modal-hide="confirm-create-referral-modal" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </button>
                <button id="confirm-create-referral-btn" type="button" 
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors" disabled>
                    Confirm & Create
                </button>
            </div>
        </div>
    </div>
</div>