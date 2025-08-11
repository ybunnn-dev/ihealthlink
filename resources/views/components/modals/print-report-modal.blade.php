<div id="print-report-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-8 max-w-full">
            <div class="flex flex-col items-center justify-center rounded-t mb-3px-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Export Data
                </h3>
                <p class="text-sm text-normal_font -mt-1">Enter resident details to continue</p>
            </div>
            <div class="p-4 md:p-5 space-y-4 max-h-[70vh] overflow-y-auto w-full">
                <div class="grid grid-cols-1 gap-3 w-full">

                </div>
            </div>

            <div class="flex items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-10">

                <!-- Right side: Skip, Next, Add Resident -->
                <div class="flex gap-3">
                    <button id="cancel-button" data-modal-hide="print-report-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                    <button id="add-resident-button" type="button" class="hidden text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full slg:w-[9rem]">Add Resident</button>
                </div>
            </div>

        </div>
    </div>
</div>