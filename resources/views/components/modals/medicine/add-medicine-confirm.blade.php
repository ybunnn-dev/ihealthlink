<div id="confirm-add-medicine-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0 text-center">
                <h3 class="text-xl font-semibold text-main_font">
                    Confirm New Medicine
                </h3>
                <p class="text-sm text-normal_font mt-1">
                    Are you sure you want to add "<strong id="medicine-name-to-confirm" class="text-main_font"></strong>"?
                </p>
            </div>
            
            <div class="flex-grow overflow-y-auto p-6 min-h-0">
                <div class="flex items-center justify-center bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <input id="confirm-medicine-checkbox" type="checkbox" value="" class="w-5 h-5 text-mainblue bg-white border-gray-300 rounded focus:ring-mainblue cursor-pointer">
                    <label for="confirm-medicine-checkbox" class="ms-3 text-sm font-medium text-gray-900 cursor-pointer select-none">I have reviewed the medicine details.</label>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b gap-3 p-6 shrink-0">
                <button id="cancel-confirm-add-medicine" data-modal-hide="confirm-add-medicine-modal" type="button" class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">Cancel</button>
                <button id="confirm-add-medicine-btn" type="button" class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors" disabled>Confirm & Add</button>
            </div>
        </div>
    </div>
</div>