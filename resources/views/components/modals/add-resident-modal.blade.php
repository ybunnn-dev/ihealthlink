<!-- Main modal -->
<div id="add-resident-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 max-w-full">
            <!-- Modal header -->
            <div class="flex  flex-col items-center justify-center rounded-t mb-3 border-b border-gray-200 pb-6 px-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Add Resident
                </h3>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4 max-h-xl">
                <div class="grid grid-cols-1 gap-3">
                    <ol class="flex items-center w-full text-xs font-medium text-center text-gray-500 dark:text-gray-400 sm:text-xs mb-6">
                        <li class="flex md:w-full items-center text-blue-600 dark:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                <span class="me-2 bg-nav_active p-4">1</span>
                                <span class="">Resident's Information</span>
                            </span>
                        </li>
                        <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                <span class="me-2 bg-gray-100 p-4">2</span>
                                <span class="hidden">Assess for Emergency Indicators</span>
                            </span>
                            </li>
                        <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                <span class="me-2 bg-gray-100 p-4">3</span>
                                <span class="hidden">Assess for Emergency Indicators</span>
                            </span>
                        </li>
                        <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                <span class="me-2 bg-gray-100 p-4">4</span>
                                <span class="hidden">Assess for Emergency Indicators</span>
                            </span>
                        </li>
                        <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                <span class="me-2 bg-gray-100 p-4">5</span>
                                <span class="hidden">Assess for Emergency Indicators</span>
                            </span>
                        </li>
                        <li class="flex items-center">
                            <span class="me-2 bg-gray-100 p-4">6</span>
                            <span class="hidden">Assess for Emergency Indicators</span>
                        </li>
                    </ol>
                    <div><x-multi-modal-components.add-resident-1></x-multi-modal-components.add-resident-1></div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6">
                <button data-modal-hide="add-resident-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>

                <div class="flex gap-3">
                    <button type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Skip</button>
                    <button id="proceed-enroll-resident-next" type="button" class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full slg:w-[9rem]">Next</button>
                    <button id="proceed-enroll-resident-add" type="button" class="hidden text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full slg:w-[9rem]">Add Resident</button>
                </div>
            </div>
        </div>
    </div>
</div>
