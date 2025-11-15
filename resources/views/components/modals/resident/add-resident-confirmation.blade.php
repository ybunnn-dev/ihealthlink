<div id="confirm-add-resident-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm px-8 transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t pt-8 pb-4">
                <h3 class="text-xl font-semibold text-main_font">
                    Confirm New Resident
                </h3>
                
            </div>
            
            <div class="py-6 space-y-4">
                <p class="text-sm text-normal_font text-center">
                    Are you sure you want to add "<span id="confirm-resident-full-name"></span>".
                </p>
                <div class="flex items-center justify-center bg-gray-50 p-3 rounded-lg">
                    <input id="confirm-resident-checkbox" type="checkbox" value="" class="w-4 h-4 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue">
                    <label for="confirm-resident-checkbox" class="ms-2 text-sm font-medium text-gray-800">I confirm this is the correct resident to add.</label>
                </div>
            </div>

            <div class="flex items-center justify-end border-t border-gray-200 gap-3 p-6">
                <button id="cancel-add-resident-confirm" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="confirm-resident-proceed-button" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>Confirm & Proceed</button>
            </div>
        </div>
    </div>
</div>