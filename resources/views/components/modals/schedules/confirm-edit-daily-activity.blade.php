<div id="confirm-edit-activity-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm py-10 px-6">
            <div class="flex flex-col items-center justify-center rounded-t mb-6 text-center">
                <h3 class="text-xl font-semibold text-main_font">
                    Confirm Activity Update
                </h3>
                <p class="text-sm text-normal_font mt-1">
                    Please review and confirm the changes below.
                </p>
            </div>
            
            <div class="text-center p-4 md:p-5">
                <p id="activity-change-summary" class="text-normal_font"></p>

                <div class="flex items-center justify-center mt-6">
                    <input id="confirm-activity-checkbox" type="checkbox" value="" class="w-4 h-4 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue">
                    <label for="confirm-activity-checkbox" class="ms-2 text-sm font-medium text-gray-900">I have reviewed the activity changes.</label>
                </div>
            </div>

            <div class="flex items-center justify-end border-t border-gray-200 rounded-b gap-3 pt-6 px-6">
                <button id="cancel-confirm-edit-activity" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="confirm-edit-activity-btn" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>Confirm & Save</button>
            </div>
        </div>
    </div>
</div>