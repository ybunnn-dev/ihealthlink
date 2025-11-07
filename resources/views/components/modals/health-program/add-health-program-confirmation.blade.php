<div id="confirm-add-program-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm px-8 transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t pt-8 pb-4 border-b">
                <h3 class="text-xl font-semibold text-main_font">
                    Confirm New Health Program
                </h3>
                <p class="text-sm text-normal_font">
                    Please review the program details below before proceeding.
                </p>
            </div>
                
            <div>
                <div id="program-info-review" class="max-h-[40vh] overflow-y-auto custom-scrollbar pr-4 rounded-md bg-bg_col p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 mb-6">
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Program Name</label>
                            <span id="review-program-name" class="text-base text-gray-800 font-medium"></span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Age Range</label>
                            <span id="review-age-range" class="text-base text-gray-800 font-medium"></span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Program Type</label>
                            <span id="review-program-type" class="text-base text-gray-800 font-medium"></span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Program Mode</label>
                            <span id="review-program-mode" class="text-base text-gray-800 font-medium"></span>
                        </div>
                    </div>

                    <div id="review-schedule-details" class="space-y-4">
                    </div>
                </div>
            </div>

            <div class="px-6 md:px-7 pb-4">
                <div class="flex items-center justify-center bg-gray-50 p-3 rounded-lg">
                    <input id="confirm-program-checkbox" type="checkbox" value="" class="w-4 h-4 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue">
                    <label for="confirm-program-checkbox" class="ms-2 text-sm font-medium text-gray-800">I have reviewed the program details and confirm they are correct.</label>
                </div>
            </div>

            <div class="flex items-center justify-end border-t border-gray-200 gap-3 p-6">
                <button id="cancel-add-program-confirm" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="confirm-program-proceed-button" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>Confirm & Proceed</button>
            </div>
        </div>
    </div>
</div>