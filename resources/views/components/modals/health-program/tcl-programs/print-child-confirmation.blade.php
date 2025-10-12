<div id="confirm-print-child-care-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm py-10 px-6">
            <div class="flex flex-col items-center justify-center rounded-t mb-6 text-center">
                <h3 class="text-xl font-semibold text-main_font">
                    Confirm PDF Generation
                </h3>
                <p class="text-sm text-normal_font mt-1">
                    This will generate a PDF document for "<strong id="print-cc-resident-name-to-confirm" class="text-main_font"></strong>". Do you want to proceed?
                </p>
            </div>
            <!-- Checkbox section added -->
            <div class="p-4 md:p-5">
                <div class="flex items-center justify-center">
                    <input id="confirm-print-cc-checkbox" type="checkbox" value="" class="w-4 h-4 text-maingreen bg-gray-100 border-gray-300 rounded focus:ring-maingreen">
                    <label for="confirm-print-cc-checkbox" class="ms-2 text-sm font-medium text-gray-900">I confirm the details are ready for printing.</label>
                </div>
            </div>
            <div class="flex items-center justify-end border-t border-gray-200 rounded-b gap-3 pt-6 px-6">
                <button id="cancel-confirm-print-cc" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <!-- Button is now disabled by default -->
                <button id="confirm-print-cc-btn" type="button" class="text-white bg-maingreen hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>Proceed & Print</button>
            </div>
        </div>
    </div>
</div>
