<div id="enroll-maternity-confirmation-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 transition-transform duration-300 ease-out scale-95">
            <!-- Modal header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-4 text-center">
                <h3 class="text-xl font-semibold text-main_font">
                    Confirm Maternity Enrollment
                </h3>
                <p class="text-sm text-normal_font mt-1">
                    Please review the details for "<strong id="maternity-resident-name-confirm" class="text-main_font"></strong>" before proceeding.
                </p>
            </div>
            
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 text-sm">
                <ul class="space-y-2 text-gray-600 list-inside dark:text-gray-400">
                    <li class="flex justify-between items-center">
                        <span class="font-medium text-gray-800">Last Menstrual Period (LMP):</span>
                        <span id="maternity-lmp-confirm" class="font-semibold text-main_font">YYYY-MM-DD</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="font-medium text-gray-800">Expected Date of Confinement (EDC):</span>
                        <span id="maternity-edc-confirm" class="font-semibold text-main_font">YYYY-MM-DD</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="font-medium text-gray-800">Gravida:</span>
                        <span id="maternity-gravida-confirm" class="font-semibold text-main_font">0</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="font-medium text-gray-800">Para:</span>
                        <span id="maternity-para-confirm" class="font-semibold text-main_font">0</span>
                    </li>
                </ul>
                <div class="flex items-center justify-center pt-4 border-t border-gray-200 mt-4">
                    <input id="confirm-maternity-enrollment-checkbox" type="checkbox" value="" class="w-4 h-4 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue">
                    <label for="confirm-maternity-enrollment-checkbox" class="ms-2 text-sm font-medium text-gray-900">I confirm the details above are correct.</label>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6">
                <button id="enroll-maternity-confirmation-cancel-btn" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="enroll-maternity-confirmation-proceed-btn" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>Confirm & Proceed</button>
            </div>
        </div>
    </div>
</div>