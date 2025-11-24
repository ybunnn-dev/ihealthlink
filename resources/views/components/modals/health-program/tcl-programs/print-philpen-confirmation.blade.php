<div id="confirm-philpen-action-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" 
     class="hidden fixed inset-0 z-[60] flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
     
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-main_font w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <!-- Header (Fixed) -->
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0 text-center">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">
                    Confirm Action
                </h3>
                <p id="confirm-philpen-action-message" class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Are you sure you want to proceed with this action?
                </p>
            </div>
            
            <div class="flex-grow overflow-y-auto p-6 min-h-0">
                <div class="flex items-center justify-center bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-100 dark:border-gray-600">
                    <input id="confirm-philpen-action-checkbox" type="checkbox" value="" class="w-5 h-5 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                    <label for="confirm-philpen-action-checkbox" class="ms-3 text-sm font-medium text-main_font dark:text-gray-300 cursor-pointer select-none">I have reviewed the details.</label>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 p-6 shrink-0">
                
                <button id="close-confirm" type="button" class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-mainblue transition-colors">
                    Cancel
                </button>
                
                <button id="confirm-philpen-action-submit" type="button" class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors" disabled>
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>