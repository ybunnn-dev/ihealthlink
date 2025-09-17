<div id="add-family-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Add Family
                </h3>
                <p class="text-sm text-normal_font">Please enter family details to proceed.</p>
            </div>
            
            <div class="p-4 md:p-5">
                <div class="grid grid-cols-1 slg:grid-cols-2 gap-x-4 gap-y-6">

                   <div class="grid grid-cols-1 gap-1">
                        <label for="selectHouseholdButton" class="text-sm font-medium text-main_font">HOUSEHOLD</label>
                        <button id="selectHouseholdButton" type="button" class="w-full text-normal_font bg-white border border-gray-300 rounded-lg p-2 text-left inline-flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300">
                           Select Household
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-1">
                        <label for="selectFamilyHeadButton" class="text-sm font-medium text-main_font">FAMILY HEAD</label>
                        <button id="selectFamilyHeadButton" type="button" class="w-full text-normal_font bg-white border border-gray-300 rounded-lg p-2 text-left inline-flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Select Household Head
                        </button>
                    </div>

                    <div class="grid grid-cols-1 gap-1 relative">
                        <label for="is4psButton" class="text-sm font-medium text-main_font">4PS MEMBER</label>
                        <button id="is4psButton" data-dropdown-toggle="4psDropdownMenu" class="w-full  text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                            <span id="is4psButtonText">Select</span>
                             <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="4psDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="is4psButton">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Yes">Yes</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                            </ul>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-1 relative">
                        <label for="isIndigentButton" class="text-sm font-medium text-main_font">INDIGENT</label>
                        <button id="isIndigentButton" data-dropdown-toggle="indigentDropdownMenu" class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                            <span id="isIndigentButtonText">Select</span>
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="indigentDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="isIndigentButton">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Yes">Yes</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex items-center border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 justify-end pt-6 mt-4 px-6">
                <button id="cancelAddFamilyButton" data-modal-hide="add-family-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button 
                    id="proceedAddFamilyButton" 
                    type="button" 
                    class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    Add Family
                </button>            
            </div>
        </div>
    </div>
</div>
@include('components.modals.family.choose-household-modal')
@include('components.modals.family.add-family-confirmation')
@include('components.modals.qr-scanner')
@vite('resources/js/modals/qr-scanner.js')