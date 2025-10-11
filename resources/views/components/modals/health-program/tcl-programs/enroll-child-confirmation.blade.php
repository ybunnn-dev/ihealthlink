<div id="enroll-child-confirmation-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm py-10 px-6">
            <!-- Modal header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-4 text-center">
                <h3 class="text-xl font-semibold text-main_font">
                    Confirm Child Enrollment
                </h3>
                <p class="text-sm text-normal_font mt-1">
                    Please review the details below before proceeding.
                </p>
            </div>
            
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 text-sm">
                <ul class="space-y-2 text-gray-600 list-inside">
                    <li class="flex justify-between items-center">
                        <span class="font-medium text-gray-800">Child's Name:</span>
                        <span id="child-name-confirm" class="font-semibold text-main_font"></span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="font-medium text-gray-800">Mother's Name:</span>
                        <span id="child-mother-name-confirm" class="font-semibold text-main_font"></span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="font-medium text-gray-800">Birth Weight (kg):</span>
                        <span id="child-birth-weight-confirm" class="font-semibold text-main_font"></span>
                    </li>
                </ul>
                <div class="flex items-center justify-center pt-4 border-t border-gray-200 mt-4">
                    <input id="confirm-child-enrollment-checkbox" type="checkbox" value="" class="w-4 h-4 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue">
                    <label for="confirm-child-enrollment-checkbox" class="ms-2 text-sm font-medium text-gray-900">I confirm the details above are correct.</label>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex items-center justify-end border-t border-gray-200 rounded-b gap-3 pt-6 px-6">
                <button id="enroll-child-confirmation-cancel-btn" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="enroll-child-confirmation-proceed-btn" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>Confirm & Proceed</button>
            </div>
        </div>
    </div>
</div>
