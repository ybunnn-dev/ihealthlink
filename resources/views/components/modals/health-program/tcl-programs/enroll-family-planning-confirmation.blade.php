<div id="enroll-family-planning-confirmation-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t p-6 pb-2 shrink-0 text-center">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font">
                    Confirm Family Planning
                </h3>
                <p class="text-sm text-normal_font mt-1">
                    Review details for "<strong id="fp-resident-name-confirm" class="text-main_font"></strong>"
                </p>
            </div>
            
            <div class="p-6 overflow-y-auto min-h-0">
                <ul class="space-y-3 text-gray-600 list-inside bg-gray-50 p-4 rounded-lg border border-gray-100 text-sm">
                    <li class="flex justify-between items-center border-b border-gray-200 pb-2 last:border-0 last:pb-0">
                        <span class="font-medium text-gray-800">Type of Client:</span>
                        <span id="fp-client-type-confirm" class="font-semibold text-main_font text-right"></span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-200 pb-2 last:border-0 last:pb-0">
                        <span class="font-medium text-gray-800">Source:</span>
                        <span id="fp-source-confirm" class="font-semibold text-main_font text-right"></span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-200 pb-2 last:border-0 last:pb-0">
                        <span class="font-medium text-gray-800">Previous Method:</span>
                        <span id="fp-previous-method-confirm" class="font-semibold text-main_font text-right"></span>
                    </li>
                </ul>
                <div class="flex items-center justify-center pt-4 mt-2">
                    <input id="confirm-fp-enrollment-checkbox" type="checkbox" value="" class="w-5 h-5 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue cursor-pointer">
                    <label for="confirm-fp-enrollment-checkbox" class="ms-2 text-sm font-medium text-gray-900 cursor-pointer select-none">I confirm the details above are correct.</label>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b gap-3 p-6 shrink-0">
                <button id="enroll-fp-confirmation-cancel-btn" type="button" class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">Cancel</button>
                <button id="enroll-fp-confirmation-proceed-btn" type="button" class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors" disabled>Confirm & Proceed</button>
            </div>
        </div>
    </div>
</div>