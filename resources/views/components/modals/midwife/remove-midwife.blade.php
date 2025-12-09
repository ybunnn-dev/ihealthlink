<div id="remove-midwife-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm py-6 md:py-10 px-6 transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t mb-4 text-center">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font">
                    Remove Midwife
                </h3>
                <p id="remove-midwife-msg" class="text-sm text-normal_font mt-2">
                    Are you sure you want to remove midwife "<strong id="midwife-name-to-remove" class="text-main_font"></strong>"? This action cannot be undone.
                </p>
            </div>
            
            <div class="p-4 md:p-5">
                <div class="flex items-center justify-center">
                    <input id="remove-midwife-checkbox" type="checkbox" value="" class="w-5 h-5 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 focus:ring-2 cursor-pointer">
                    <label for="remove-midwife-checkbox" class="ms-2 text-sm font-medium text-gray-900 cursor-pointer select-none">I understand this action is permanent.</label>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b gap-3 pt-6 px-6">
                <button id="close-remove-midwife-modal" data-modal-hide="remove-midwife-modal" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-colors">
                    Cancel
                </button>
                <button id="remove-midwife-button" type="button" 
                    class="w-full sm:w-auto text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors" disabled>
                    Remove Midwife
                </button>
            </div>
        </div>
    </div>
</div>