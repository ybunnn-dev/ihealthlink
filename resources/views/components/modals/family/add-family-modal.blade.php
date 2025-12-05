<div id="add-family-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Card: py-6 mobile, py-10 desktop -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-6 md:py-10 px-6 transition-transform duration-300 ease-out scale-95">
            
            <!-- Header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-6 text-center">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font">
                    Add Family
                </h3>
                <p class="text-sm text-normal_font mt-1">Please enter family details to proceed.</p>
            </div>
            
            <div class="p-0 md:p-5 space-y-4">
                <!-- Grid: 1 col on mobile, 2 cols on md+ -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                   <div class="col-span-1">
                        <label for="selectHouseholdButton" class="block mb-1 text-sm font-semibold text-main_font">HOUSEHOLD</label>
                        <!-- Removed the added SVG here -->
                        <button id="selectHouseholdButton" type="button" class="w-full text-normal_font bg-white border border-gray-300 rounded-lg text-base px-3 py-3 text-left inline-flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors">
                           Select Household
                        </button>
                    </div>

                    <div class="col-span-1 relative">
                        <label for="is4psButton" class="block mb-1 text-sm font-semibold text-main_font">4PS MEMBER</label>
                        <button id="is4psButton" data-dropdown-toggle="4psDropdownMenu" class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg text-base px-3 py-3 text-left inline-flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors" type="button">
                            <span id="is4psButtonText">Select</span>
                             <svg class="w-2.5 h-2.5 ms-3 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="4psDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1 border border-gray-100">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="is4psButton">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Yes">Yes</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-span-1 relative">
                        <label for="isIndigentButton" class="block mb-1 text-sm font-semibold text-main_font">INDIGENT</label>
                        <button id="isIndigentButton" data-dropdown-toggle="indigentDropdownMenu" class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg text-base px-3 py-3 text-left inline-flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors" type="button">
                            <span id="isIndigentButtonText">Select</span>
                            <svg class="w-2.5 h-2.5 ms-3 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="indigentDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1 border border-gray-100">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="isIndigentButton">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Yes">Yes</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-span-1 relative">
                        <label for="isIwasGutom" class="block mb-1 text-sm font-semibold text-main_font uppercase">WALANG GUTOM PROGRAM</label>
                        <button id="isIwasGutom" data-dropdown-toggle="isIwasGutomMenu" class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg text-base px-3 py-3 text-left inline-flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors" type="button">
                            <span id="isIwasGutomButtonText">Select</span>
                            <svg class="w-2.5 h-2.5 ms-3 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="isIwasGutomMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1 border border-gray-100">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="isIwasGutom">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Yes">Enrolled</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer: Stacked buttons mobile, side-by-side desktop -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6 mt-6">
                <button id="cancelAddFamilyButton" data-modal-hide="add-family-modal" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-colors">
                    Cancel
                </button>
                <button 
                    id="proceedAddFamilyButton" 
                    type="button" 
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                    disabled>
                    Add Family
                </button>            
            </div>
        </div>
    </div>
</div>
@include('components.modals.family.choose-household-modal')
@include('components.modals.family.add-family-confirmation')

