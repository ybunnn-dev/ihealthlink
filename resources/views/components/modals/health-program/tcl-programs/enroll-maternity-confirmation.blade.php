<div id="enroll-maternity-confirmation-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0 text-center">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font">
                    Confirm Maternity Enrollment
                </h3>
                <p class="text-sm text-normal_font mt-1">
                    Please review the details for "<strong id="maternity-resident-name-confirm" class="text-main_font"></strong>" before proceeding.
                </p>
            </div>
            
            <div class="flex-grow overflow-y-auto p-6 min-h-0 text-sm">
                <ul class="space-y-3 text-gray-600 list-inside bg-gray-50 p-4 rounded-lg border border-gray-100">
                    <li class="flex justify-between items-center border-b border-gray-200 pb-2 last:border-0 last:pb-0">
                        <span class="font-medium text-gray-800">Last Menstrual Period (LMP):</span>
                        <span id="maternity-lmp-confirm" class="font-semibold text-main_font text-right">YYYY-MM-DD</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-200 pb-2 last:border-0 last:pb-0">
                        <span class="font-medium text-gray-800">Expected Date of Confinement (EDC):</span>
                        <span id="maternity-edc-confirm" class="font-semibold text-main_font text-right">YYYY-MM-DD</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-200 pb-2 last:border-0 last:pb-0">
                        <span class="font-medium text-gray-800">Gravida:</span>
                        <span id="maternity-gravida-confirm" class="font-semibold text-main_font text-right">0</span>
                    </li>
                    <li class="flex justify-between items-center border-b border-gray-200 pb-2 last:border-0 last:pb-0">
                        <span class="font-medium text-gray-800">Para:</span>
                        <span id="maternity-para-confirm" class="font-semibold text-main_font text-right">0</span>
                    </li>
                </ul>
                <div class="flex items-center justify-center pt-4 mt-2">
                    <input id="confirm-maternity-enrollment-checkbox" type="checkbox" value="" class="w-5 h-5 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue cursor-pointer">
                    <label for="confirm-maternity-enrollment-checkbox" class="ms-2 text-sm font-medium text-gray-900 cursor-pointer select-none">I confirm the details above are correct.</label>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b gap-3 p-6 shrink-0">
                <button id="enroll-maternity-confirmation-cancel-btn" type="button" class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">Cancel</button>
                <button id="enroll-maternity-confirmation-proceed-btn" type="button" class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors" disabled>Confirm & Proceed</button>
            </div>
        </div>
    </div>
</div>