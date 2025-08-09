<!-- Main modal -->
<div id="change-language-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 max-w-full">
            <!-- Modal header -->
            <div class="flex  flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Change Language
                </h3>
                <p class="text-xs text-normal_font">Please choose your prefered language.</p>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div class="flex flex-col col-span-1 relative">
                    <button id="langDropDown" data-dropdown-toggle="langDropDownMenu"
                        class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                        type="button">
                        Select
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div id="langDropDownMenu"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="langDropDownMenu">
                        <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Filipino</button></li>
                        <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">English</button></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center  rounded-b dark:border-gray-600 gap-3 justify-end pt-6 px-6">
                <button data-modal-hide="change-language-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                <button id="change-language" type="button" class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirm</button>
            </div>
        </div>
    </div>
</div>