<div id="edit-family-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Card: py-6 mobile, py-10 desktop -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-6 md:py-10 px-6 transition-transform duration-300 ease-out scale-95">
            
            <!-- Header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-6 text-center">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font">
                    Edit Family
                </h3>
                <p class="text-sm text-normal_font mt-1">Update the family's details.</p>
            </div>
            
            <div class="p-0 md:p-5 space-y-4">
                <!-- Grid: 1 col mobile, 2 cols desktop -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- 4PS Member: Spans 2 columns on desktop -->
                    <div class="col-span-1 md:col-span-2 relative">
                        <label for="is4psButtonEdit" class="block mb-1 text-sm font-semibold text-main_font">4PS MEMBER</label>
                        <button id="is4psButtonEdit" data-dropdown-toggle="4psDropdownMenuEdit" class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg text-base px-3 py-3 text-left inline-flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors" type="button">
                            <span id="is4psButtonTextEdit">Select</span>
                             <svg class="w-2.5 h-2.5 ms-3 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="4psDropdownMenuEdit" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1 border border-gray-100">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="is4psButtonEdit">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Yes">Yes</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Indigent -->
                    <div class="col-span-1 relative">
                        <label for="isIndigentButtonEdit" class="block mb-1 text-sm font-semibold text-main_font">INDIGENT</label>
                        <button id="isIndigentButtonEdit" data-dropdown-toggle="indigentDropdownMenuEdit" class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg text-base px-3 py-3 text-left inline-flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors" type="button">
                            <span id="isIndigentButtonTextEdit">Select</span>
                            <svg class="w-2.5 h-2.5 ms-3 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="indigentDropdownMenuEdit" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1 border border-gray-100">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="isIndigentButtonEdit">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Yes">Yes</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Iwas Gutom -->
                    <div class="col-span-1 relative">
                        <label for="isIwasGutomEdit" class="block mb-1 text-sm font-semibold text-main_font uppercase">Iwas Gutom Program</label>
                        <button id="isIwasGutomEdit" data-dropdown-toggle="isIwasGutomMenuEdit" class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg text-base px-3 py-3 text-left inline-flex items-center justify-between hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors" type="button">
                            <span id="isIwasGutomButtonTextEdit">Select</span>
                            <svg class="w-2.5 h-2.5 ms-3 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="isIwasGutomMenuEdit" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1 border border-gray-100">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="isIwasGutomEdit">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Enrolled">Enrolled</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer: Stacked buttons mobile, side-by-side desktop -->
            <div class="flex flex-col-reverse sm:flex-row items-center border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 justify-end pt-6 mt-6 px-6">
                <button id="cancelEditFamilyButton" data-modal-hide="edit-family-modal" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-colors">
                    Cancel
                </button>
                <button 
                    id="submitEditFamilyButton" 
                    type="button" 
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    Update Family
                </button>            
            </div>
        </div>
    </div>
</div>
@include('components.modals.family.edit-family-confirmation')