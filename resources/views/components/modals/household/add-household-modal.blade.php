<div id="add-household-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-300 ease-out hidden opacity-0 p-4">
    
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto transform transition-all scale-100">
        
        <!-- Header -->
        <div class="flex flex-col items-center justify-center pt-6 px-6 pb-2 text-center">
            <h3 class="text-xl md:text-2xl font-bold text-main_font">
                Add Household
            </h3>
            <p class="text-sm text-normal_font mt-1">Please enter household details to proceed.</p>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 gap-4">
                
                <!-- Purok -->
                <div class="col-span-1">
                    <label for="purokSelect" class="block mb-1 text-sm font-semibold text-main_font">PUROK/SITIO</label>
                    <div class="relative">
                        <select id="purokSelect" name="purok_id" class="w-full text-main_font bg-gray-50 border border-gray-300 rounded-lg text-base px-3 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none appearance-none">
                            <option value="" disabled selected>Select location</option>
       
                        </select>
                       
                    </div>
                </div>
    
                <!-- Water Source -->
                <div class="col-span-1">
                    <label for="waterSourceSelect" class="block mb-1 text-sm font-semibold text-main_font">WATER SOURCE</label>
                    <div class="relative">
                        <select id="waterSourceSelect" name="water_source" class="w-full text-main_font bg-gray-50 border border-gray-300 rounded-lg text-base px-3 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none appearance-none">
                            <option value="">Select source</option>
                            <option value="Pumpwell">Pumpwell</option>
                            <option value="Open Well">Open Well</option>
                            <option value="Purified">Purified Water</option>
                            <option value="Tap">Tap Water</option>
                        </select>
                      
                    </div>
                </div>
                
                <!-- Split Row: Waste & Sanitary -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Waste Disposal -->
                    <div>
                        <label for="wasteDisposalSelect" class="block mb-1 text-sm font-semibold text-main_font">WASTE DISPOSAL</label>
                        <div class="relative">
                            <select id="wasteDisposalSelect" name="waste_disposal" class="w-full text-main_font bg-gray-50 border border-gray-300 rounded-lg text-base px-3 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none appearance-none">
                                <option value="">Select type</option>
                                <option value="Collected">Garbage Collection</option>
                                <option value="Burial">Burial</option>
                                <option value="Burning">Burning</option>
                                <option value="Composting">Composting</option>
                            </select>
                           
                        </div>
                    </div>

                    <!-- Sanitary Toilet -->
                    <div>
                        <label for="sanitarySelect" class="block mb-1 text-sm font-semibold text-main_font">SANITARY TOILET</label>
                        <div class="relative">
                            <select id="sanitarySelect" name="sanitary_toilet" class="w-full text-main_font bg-gray-50 border border-gray-300 rounded-lg text-base px-3 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none appearance-none">
                                <option value="">Select status</option>
                                <option value="with_sanitary_toilet">With Sanitary Toilet</option>
                                <option value="with_unsanitary_toilet">With Unsanitary Toilet</option>
                                <option value="without_toilet">Without Toilet</option>
                            </select>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer / Buttons -->
        <div class="flex flex-col-reverse sm:flex-row items-center border-t border-gray-200 dark:border-gray-600 gap-3 justify-end p-6 bg-gray-50 rounded-b-xl">
            <button id="cancel-add-household" type="button" 
                class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-700 focus:outline-none bg-white rounded-lg border border-gray-300 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-colors">
                Cancel
            </button>
            
            <button id="proceed-add-household" type="button" 
                class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 
                       disabled:opacity-50 disabled:cursor-not-allowed shadow-sm transition-colors">
                Add Household
            </button>
        </div>
    </div>
</div>
@include('components.modals.household.add-household-confirmation')