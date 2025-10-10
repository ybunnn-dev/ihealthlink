<div id="create-philpen-record-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-8 max-w-full">
            <div class="flex flex-col items-center justify-center rounded-t mb-3px-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Create PhilPEN Record
                </h3>
                <p class="text-sm text-normal_font -mt-1">Enter patient details to continue</p>
            </div>
            <div class="p-4 md:p-5 space-y-4 max-h-[70vh] overflow-y-auto w-full">
                <div class="grid grid-cols-1 gap-3 w-full">
                    <ol class="flex items-center w-full text-xs font-medium text-center text-gray-500 dark:text-gray-400 sm:text-xs mb-6 border-b border-gray-200 pb-6">
                        <li id="step-progress-1" class="flex md:w-full items-center after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 gap-3">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                <span class="me-2 p-4 rounded-md text-center text-mainblue">1</span>
                            </span>
                            <span class="block text-start">Resident's Information</span>
                        </li>
                        <li id="step-progress-2" class="flex md:w-full gap-3 items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                <span class="me-2 p-4 rounded-md">2</span>
                            </span>
                            <span class="hidden text-start">Risk Factor Assessment</span>
                        </li>
                        <li id="step-progress-3" class="flex md:w-full gap-3 items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                <span class="me-2 p-4 rounded-md">3</span>
                            </span>
                            <span class="hidden text-start">Medical & Family History</span>
                        </li>
                        <li id="step-progress-4" class="flex md:w-full gap-3 items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                <span class="me-2 p-4 rounded-md">4</span>
                            </span>
                            <span class="hidden text-start">Physical Examination</span>
                        </li>
                        <li id="step-progress-5" class="flex md:w-full gap-3 items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                <span class="me-2 p-4 rounded-md">5</span>
                            </span>
                            <span class="hidden text-start">Counseling & Plan</span>
                        </li>
                       <li id="step-progress-6" class="flex md:w-full gap-3 items-center">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                <span class="me-2 p-4 rounded-md">6</span>
                            </span>
                            <span class="hidden text-start">Summary & Confirmation</span>
                        </li>
                    </ol>

                    <div class="flex flex-nowrap w-full overflow-hidden">
                        <div id="step-1" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0">
                            <!-- Content for Step 1 -->
                        </div>
                        <div id="step-2" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 hidden">
                           <!-- Content for Step 2 -->
                        </div>
                        <div id="step-3" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 hidden">
                           <!-- Content for Step 3 -->
                        </div>
                        <div id="step-4" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 hidden">
                            <!-- Content for Step 4 -->
                        </div>
                        <div id="step-5" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 hidden">
                           <!-- Content for Step 5 -->
                        </div>
                        <div id="step-6" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 hidden">
                            <!-- Content for Step 6 -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-10">
                <!-- Left side: Cancel + Previous -->
                <div class="flex gap-3">
                    <button id="cancel-philpen-button" data-modal-hide="create-philpen-record-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>

                    <button id="prev-philpen-button" type="button" class="hidden py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Previous</button>
                </div>

                <!-- Right side: Skip, Next, Create Record -->
                <div class="flex gap-3">
                    <button id="skip-philpen-button" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Skip</button>

                    <button id="next-philpen-button" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full slg:w-[9rem]">Next</button>

                    <button id="create-philpen-record-button" type="button" class="hidden text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full slg:w-[9rem]">Create Record</button>
                </div>
            </div>

        </div>
    </div>
</div>
