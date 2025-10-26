<div id="add-household-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 max-w-[90%]">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Add Household
                </h3>
                <p class="text-sm text-normal_font">Please enter household details to proceed.</p>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <div class="grid grid-cols-1 gap-3">
                    <div class="grid grid-cols-1 col-span-1 gap-3">
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="purokSelect" class="text-sm font-medium text-main_font">PUROK/SITIO</label>
                            <select id="purokSelect" name="purok_id" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2">
                                <option value="" disabled>Select</option>
                                </select>
                        </div>
                        
                    </div>
        
                    <div class="grid grid-cols-1 slg2:grid-cols-1 col-span-1 gap-3">
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="waterSourceSelect" class="text-sm font-medium text-main_font">WATER SOURCE</label>
                            <select id="waterSourceSelect" name="water_source" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2">
                                <option value="">Select</option>
                                <option value="Pumpwell">Pumpwell</option>
                                <option value="Open Well">Open Well</option>
                                <option value="Purified">Purified Water</option>
                                <option value="Tap">Tap Water</option>
                            </select>
                        </div>

                    </div>
                    
                    <div class="grid grid-cols-1 slg2:grid-cols-2 col-span-1 gap-3">
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="wasteDisposalSelect" class="text-sm font-medium text-main_font">WASTE DISPOSAL</label>
                            <select id="wasteDisposalSelect" name="waste_disposal" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 ">
                                <option value="">Select</option>
                                <option value="Collected">Garbage Collection</option>
                                <option value="Burial">Burial</option>
                                <option value="Burning">Burning</option>
                                <option value="Composting">Composting</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="sanitarySelect" class="text-sm font-medium text-main_font">SANITARY TOILET</label>
                            <select id="sanitarySelect" name="sanitary_toilet" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 ">
                                <option value="">Select</option>
                                <option value="with_sanitary_toilet">With Sanitary Toilet</option>
                                <option value="with_unsanitary_toilet">With Unsanitary Toilet</option>
                                <option value="without_toilet">Without Toilet</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 justify-end pt-6 px-6">
                <button id="cancel-add-household" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                <button id="proceed-add-household" type="button" 
                        class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 
                               disabled:opacity-50 disabled:cursor-not-allowed">
                    Add Household
                </button>
            </div>
        </div>
    </div>
</div>

@include('components.modals.household.add-household-confirmation')