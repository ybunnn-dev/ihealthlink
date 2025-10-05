<div id="distribute-medicine-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-ful">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-800 py-8 px-10">
            <!-- Modal Header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-6 border-b border-gray-200 pb-6 dark:border-gray-600">
                <h3 class="text-xl font-semibold text-main_font dark:text-white">
                    Distribute Medicine
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Select medicines and specify the quantity</p>
            </div>

            <!-- Modal Body -->
            <div class="max-h-[70vh] px-4 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-8">

                    <!-- Right Column: Medicine List & Quantity -->
                    <div class="md:col-span-3 space-y-4">
                        <!-- Search Bar -->
                        <div>
                            <label for="medicine-search" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Search Medicine</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>                          
                                <input type="search" id="medicine-search" placeholder="Search by name..." class="cols-span-1 slg:col-span-3 bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ps-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>
                        </div>

                        <!-- Scrollable Medicine List -->
                        <div id="medicine-list-container" class="border rounded-lg h-[35vh] overflow-y-auto scrollbar-thin p-3 space-y-2 dark:border-gray-600">
                           <!-- Medicine Card Example -->
                            <div class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                <p class="font-semibold text-main_font dark:text-white">Amoxicillin 250mg</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Capsule - <span class="font-medium text-green-600">150 in stock</span></p>
                            </div>
                            <div class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                <p class="font-semibold text-main_font dark:text-white">Mefenamic Acid 500mg</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tablet - <span class="font-medium text-green-600">75 in stock</span></p>
                            </div>
                             <div class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer bg-blue-100 dark:bg-blue-900/50 border border-blue-400">
                                <p class="font-semibold text-main_font dark:text-white">Paracetamol 500mg</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tablet - <span class="font-medium text-green-600">200 in stock</span></p>
                            </div>
                             <!-- Add more medicine cards here -->
                        </div>

                        <!-- Quantity Input -->
                       <div>
                            <div class="grid grid-cols-1 slg:grid-cols-5 gap-4 items-end">
                                <!-- This now spans 3 of 4 columns on large screens -->
                                <div class="col-span-1 slg:col-span-3">
                                    <label for="medicine-quantity" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Quantity</label>
                                    <input type="number" id="medicine-quantity" min="1" placeholder="Enter quantity..." class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                </div>
                                <!-- This button takes the remaining column -->
                                <button id="append-medicine" type="button" class="col-span-1 slg:col-span-2 h-[2.625rem] text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add Medicine</button>
                            </div>
                        </div>
                    </div>
                    <!-- Left Column: Chosen Medicine -->
                    <div class="md:col-span-3 flex flex-col">
                        <h4 class="text-lg font-medium text-main_font mb-4">Selected Medicines</h4>
                        <div id="chosen-medicine-list" class="relative flex-grow border bg-gray-50 min-h-[40vh] rounded-lg overflow-y-auto scrollbar-thin dark:border-gray-600 dark:bg-gray-700 p-3 space-y-2">
                            
                            <!-- Example of a chosen medicine item -->
                            <div class="flex items-center justify-between bg-white dark:bg-gray-800 p-3 rounded-lg shadow-sm">
                                <div>
                                    <p class="font-semibold text-main_font dark:text-white">Paracetamol 500mg</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Tablet</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="font-bold text-main_font dark:text-white">x 10</span>
                                    <button title="Remove" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- End of example item -->

                             <!-- Placeholder for when the list is empty -->
                            <div id="chosen-medicine-placeholder" class="hidden items-center justify-center w-full h-full">
                                <span class="text-gray-400">No medicines selected</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 mt-6">
                <button id="cancel-distribute-button" data-modal-hide="distribute-medicine-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                <button id="distribute-button" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Distribute</button>
            </div>
        </div>
    </div>
</div>
