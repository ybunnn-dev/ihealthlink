<div id="chooseHeadModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-xl max-h-full"> 
        <!-- Card: py-6 mobile, py-10 desktop -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-6 md:py-10 px-6 transition-transform duration-300 ease-out scale-95">
            
            <!-- Header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-6 text-center">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font">
                    Choose Household Head
                </h3>
                <p class="text-sm text-normal_font mt-1">Please select the resident who will be the head of this household.</p>
            </div>

            <!-- Body -->
            <div class="p-0 md:p-5 space-y-4">
                <div id="headCardContainer" class="space-y-3 overflow-y-auto border border-gray-200 rounded-lg p-3 max-h-[50vh]">
                    <!-- Card Item 1 -->
                    <button type="button" 
                            data-resident-id="RES-001" 
                            class="resident-selection-card group flex items-center p-4 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-400 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all">
                        <div class="flex justify-between w-full text-left items-center">
                            <div>
                                <p class="text-base font-semibold text-main_font group-hover:text-blue-700 transition-colors">Juan Dela Cruz</p>
                                <p class="text-xs text-gray-500 mt-0.5">ID: RES-001</p>
                            </div>
                            <div class="flex items-center text-xs font-medium text-gray-600">
                                <span class="bg-gray-100 px-2.5 py-1 rounded-full border border-gray-200">Age: 42</span>
                            </div>
                        </div>
                    </button>

                    <!-- Card Item 2 -->
                    <button type="button" 
                            data-resident-id="RES-002" 
                            class="resident-selection-card group flex items-center p-4 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-400 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all">
                        <div class="flex justify-between w-full text-left items-center">
                            <div>
                                <p class="text-base font-semibold text-main_font group-hover:text-blue-700 transition-colors">Maria Dela Cruz</p>
                                <p class="text-xs text-gray-500 mt-0.5">ID: RES-002</p>
                            </div>
                            <div class="flex items-center text-xs font-medium text-gray-600">
                                <span class="bg-gray-100 px-2.5 py-1 rounded-full border border-gray-200">Age: 35</span>
                            </div>
                        </div>
                    </button>

                    <!-- Card Item 3 -->
                    <button type="button" 
                            data-resident-id="RES-004" 
                            class="resident-selection-card group flex items-center p-4 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-400 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all">
                        <div class="flex justify-between w-full text-left items-center">
                            <div>
                                <p class="text-base font-semibold text-main_font group-hover:text-blue-700 transition-colors">Junior Dela Cruz</p>
                                <p class="text-xs text-gray-500 mt-0.5">ID: RES-004</p>
                            </div>
                            <div class="flex items-center text-xs font-medium text-gray-600">
                                <span class="bg-gray-100 px-2.5 py-1 rounded-full border border-gray-200">Age: 12</span>
                            </div>
                        </div>
                    </button>

                </div>
            </div>

            <!-- 
                Responsive Buttons:
                1. flex-col-reverse: Stacks Cancel below Assign on mobile.
                2. sm:flex-row: Side-by-side on desktop.
                3. w-full: Full width buttons on mobile.
            -->
            <div class="flex flex-col-reverse sm:flex-row items-center border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 justify-end pt-6 px-6 mt-4">
                <button id="cancelChooseHead" data-modal-hide="chooseHeadModal" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                    Close
                </button>
                <button id="confirmChooseHeadBtn" disabled type="button" 
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm">
                    Assign
                </button>
            </div>

        </div>
    </div>
</div>
@include('components.modals.household.confirm-head')