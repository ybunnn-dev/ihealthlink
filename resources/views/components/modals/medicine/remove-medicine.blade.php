<div id="confirm-delete-medicine-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0 text-center">
                <h3 class="text-xl font-semibold text-main_font">
                    Remove Medicine
                </h3>
                <p class="text-sm text-normal_font mt-1">
                    Are you sure you want to permanently delete "<strong id="delete-medicine-name-to-confirm" class="text-main_font"></strong>"? This action cannot be undone.
                </p>
            </div>
            
            <div class="flex-grow overflow-y-auto p-6 min-h-0">
                <div class="flex items-center justify-center bg-red-50 p-4 rounded-lg border border-red-100">
                    <input id="delete-medicine-checkbox" type="checkbox" value="" class="w-5 h-5 text-red-600 bg-white border-gray-300 rounded focus:ring-red-500 cursor-pointer">
                    <label for="delete-medicine-checkbox" class="ms-3 text-sm font-medium text-red-900 cursor-pointer select-none">I understand this action is permanent.</label>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b gap-3 p-6 shrink-0">
                <button id="cancel-delete-medicine" data-modal-hide="confirm-delete-medicine-modal" type="button" class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">Cancel</button>
                <button id="confirm-delete-medicine-btn" type="button" class="w-full sm:w-auto text-white bg-red-600 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors" disabled>Confirm & Remove</button>
            </div>
        </div>
    </div>
</div>