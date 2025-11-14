<div id="chooseHeadModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-xl max-h-full"> 
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t pt-6 px-6 mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Choose Household Head
                </h3>
                <p class="text-sm text-normal_font">Please select the resident who will be the head of this household.</p>
            </div>

            <div class="p-4 md:p-5 space-y-4">
                <div id="headCardContainer" class="space-y-2 overflow-y-auto border rounded-lg p-3 max-h-[50vh]">
                    <button type="button" 
                            data-resident-id="RES-001" 
                            class="resident-selection-card flex items-center p-3 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 focus:outline-none">
                        <div class="flex justify-between w-full text-left">
                            <div>
                                <p class="font-semibold text-main_font">Juan Dela Cruz</p>
                                <p class="text-xs text-gray-500">
                                    <span>ID: RES-001</span>
                                </p>
                            </div>
                            <div class="flex items-center text-xs text-gray-600">
                                <span class="bg-gray-200 px-2 py-1 rounded-full">Age: 42</span>
                            </div>
                        </div>
                    </button>

                    <button type="button" 
                            data-resident-id="RES-002" 
                            class="resident-selection-card flex items-center p-3 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 focus:outline-none">
                        <div class="flex justify-between w-full text-left">
                            <div>
                                <p class="font-semibold text-main_font">Maria Dela Cruz</p>
                                <p class="text-xs text-gray-500">
                                    <span>ID: RES-002</span>
                                </p>
                            </div>
                            <div class="flex items-center text-xs text-gray-600">
                                <span class="bg-gray-200 px-2 py-1 rounded-full">Age: 35</span>
                            </div>
                        </div>
                    </button>

                    <button type="button" 
                            data-resident-id="RES-004" 
                            class="resident-selection-card flex items-center p-3 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 focus:outline-none">
                        <div class="flex justify-between w-full text-left">
                            <div>
                                <p class="font-semibold text-main_font">Junior Dela Cruz</p>
                                <p class="text-xs text-gray-500">
                                    <span>ID: RES-004</span>
                                </p>
                            </div>
                            <div class="flex items-center text-xs text-gray-600">
                                <span class="bg-gray-200 px-2 py-1 rounded-full">Age: 12</span>
                            </div>
                        </div>
                    </button>

                </div>
            </div>

            <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button id="cancelChooseHead" data-modal-hide="chooseHeadModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Close</button>
                <button id="confirmChooseHeadBtn" disabled type="button" class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center ms-3 disabled:opacity-50">Assign</button>
            </div>

        </div>
    </div>
</div>
@include('components.modals.household.confirm-head')