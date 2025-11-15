<div id="edit-family-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Edit Family
                </h3>
                <p class="text-sm text-normal_font">Update the family's details.</p>
            </div>
            
            <div class="p-4 md:p-5">
                <div class="grid grid-cols-1 slg:grid-cols-2 gap-x-4 gap-y-6">

                    <div class="grid grid-cols-1 gap-1 col-span-2 relative">
                        <label for="is4psButtonEdit" class="text-sm font-medium text-main_font">4PS MEMBER</label>
                        <button id="is4psButtonEdit" data-dropdown-toggle="4psDropdownMenuEdit" class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                            <span id="is4psButtonTextEdit">Select</span>
                             <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="4psDropdownMenuEdit" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="is4psButtonEdit">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Yes">Yes</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                            </ul>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-1 col-span-1 relative">
                        <label for="isIndigentButtonEdit" class="text-sm font-medium text-main_font">INDIGENT</label>
                        <button id="isIndigentButtonEdit" data-dropdown-toggle="indigentDropdownMenuEdit" class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                            <span id="isIndigentButtonTextEdit">Select</span>
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="indigentDropdownMenuEdit" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="isIndigentButtonEdit">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Yes">Yes</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                            </ul>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 col-span-1 gap-1 relative">
                        <label for="isIwasGutomEdit" class="text-sm font-medium text-main_font uppercase">Iwas Gutom Program</label>
                        <button id="isIwasGutomEdit" data-dropdown-toggle="isIwasGutomMenuEdit" class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                            <span id="isIwasGutomButtonTextEdit">Select</span>
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="isIwasGutomMenuEdit" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="isIwasGutomEdit">
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Enrolled">Enrolled</button></li>
                                <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 justify-end pt-6 mt-4 px-6">
                <button id="cancelEditFamilyButton" data-modal-hide="edit-family-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button 
                    id="submitEditFamilyButton" 
                    type="button" 
                    class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed">
                    Update Family
                </button>            
            </div>
        </div>
    </div>
</div>
@include('components.modals.family.edit-family-confirmation')