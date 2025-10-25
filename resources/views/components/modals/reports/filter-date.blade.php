<div id="filter-date-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 max-w-[90%]">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Filter by Date
                </h3>
                <p class="text-sm text-normal_font">Please select a date range to filter results.</p>
            </div>

            <div class="p-4 md:p-5 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="grid grid-cols-1 gap-1 relative col-span-1">
                        <label for="filterFromDate" class="text-sm font-medium text-main_font">FROM DATE</label>
                        <input type="date" id="filterFromDate" name="from_date" 
                               class="w-full text-main_font bg-white dark:bg-gray-600 dark:border-gray-500 dark:text-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2">
                    </div>

                    <div class="grid grid-cols-1 gap-1 relative col-span-1">
                        <label for="filterToDate" class="text-sm font-medium text-main_font">TO DATE</label>
                         <input type="date" id="filterToDate" name="to_date" 
                                class="w-full text-main_font bg-white dark:bg-gray-600 dark:border-gray-500 dark:text-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2">
                    </div>
                </div>
            </div>

            <div class="flex items-center border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 justify-end pt-6 px-6">
                <button id="cancel-filter-date" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                <button id="apply-filter-date" type="button" 
                        class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 
                               disabled:opacity-50 disabled:cursor-not-allowed">
                    Apply Filter
                </button>
            </div>
        </div>
    </div>
</div>