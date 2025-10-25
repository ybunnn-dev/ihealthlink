<div id="set-status-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full"> <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Set Status
                </h3>
                <p class="text-sm text-normal_font">Please select the new status.</p>
            </div>
            
            <div class="p-4 md:p-5">
                <div class="grid grid-cols-1 gap-x-4 gap-y-6">

                    <div class="grid grid-cols-1 gap-1 relative">
                        <label for="statusButton" class="text-sm font-medium text-main_font uppercase">Status</label>
                        <button id="statusButton" data-dropdown-toggle="statusDropdownMenu" class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                            <span id="statusButtonText">Select</span>
                             <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="statusDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="statusButton">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="active">Active</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="inactive">Inactive</button></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex items-center border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 justify-end pt-6 mt-4 px-6">
                <button id="cancelSetStatusButton" data-modal-hide="set-status-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button 
                    id="submitSetStatusButton" 
                    type="button" 
                    class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    Update Status
                </button>            
            </div>
        </div>
    </div>
</div>
@include('components.modals.family.set-status-confirmation')