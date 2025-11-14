<div id="confirm-edit-family-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-6 px-6 transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t mb-4 text-center">
                <h3 class="text-xl font-semibold text-main_font">
                    Confirm Family Update
                </h3>
                <p class="text-sm text-normal_font mt-2">
                    Are you sure you want to save the changes to this family's details?
                </p>
            </div>
            
            <div class="p-4 md:p-5">
                <div class="flex items-center justify-center">
                    <input id="confirm-edit-family-checkbox" type="checkbox" value="" class="w-4 h-4 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue">
                    <label for="confirm-edit-family-checkbox" class="ms-2 text-sm font-medium text-gray-900">I confirm the details are correct.</label>
                </div>
            </div>

            <div class="flex items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6">
                <button id="confirm-edit-family-cancel" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="confirm-edit-family-submit" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>Confirm & Save</button>
            </div>
        </div>
    </div>
</div>