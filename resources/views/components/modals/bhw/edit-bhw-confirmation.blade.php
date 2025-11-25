<div id="confirm-edit-bhw-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700 transition-transform duration-300 ease-out scale-95 flex flex-col">
            
            <div class="p-6 text-center">
                <h3 class="mb-2 text-xl font-bold text-main_font">
                    Confirm Changes
                </h3>
                <p class="text-gray-500 text-sm">
                    Are you sure you want to save the changes for "<strong id="edit-bhw-name-to-confirm" class="text-main_font font-bold"></strong>"?
                </p>

                <div class="flex items-center justify-center mt-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
                    <input id="confirm-edit-bhw-checkbox" type="checkbox" value="" class="w-4 h-4 text-mainblue bg-white border-gray-300 rounded focus:ring-mainblue cursor-pointer">
                    <label for="confirm-edit-bhw-checkbox" class="ms-2 text-sm font-medium text-main_font cursor-pointer select-none">I confirm the changes are correct.</label>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end px-6 py-4 bg-gray-50 rounded-b-lg border-t border-gray-100 gap-3">
                <button id="confirm-edit-bhw-cancel" type="button" class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 transition-colors">
                    Cancel
                </button>
                <button id="confirm-edit-proceed-button" type="button" class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 disabled:bg-gray-300 disabled:cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors shadow-sm" disabled>
                    Confirm & Save
                </button>
            </div>
        </div>
    </div>
</div>