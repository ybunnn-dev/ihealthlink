<div id="distribute-medicine-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-800 py-8 px-10 transition-transform duration-300 ease-out scale-95">
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
                        </div>
                        <!-- Quantity Input -->
                       <div>
                            <div class="grid grid-cols-1 slg:grid-cols-5 gap-4 items-end">
                                <!-- This now spans 3 of 4 columns on large screens -->
                                <div class="col-span-1 slg:col-span-3">
                                    <label for="medicine-quantity" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Quantity <span id="insufficient-indicator" class="text-red-500 hidden">Insufficient Stock</span></label>
                                    <input type="number" id="medicine-quantity" min="1" placeholder="Enter quantity..." disabled class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white disabled:bg-gray-200">
                                </div>
                                <!-- This button takes the remaining column -->
                                <button id="append-medicine" type="button" disabled class="col-span-1 slg:col-span-2 h-[2.625rem] text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50">Add Medicine</button>
                            </div>
                        </div>
                    </div>
                    <!-- Left Column: Chosen Medicine -->
                    <div class="md:col-span-3 flex flex-col">
                        <h4 class="text-lg font-medium text-main_font mb-4">Selected Medicines</h4>
                        <div id="chosen-medicine-list" class="relative flex-grow border bg-gray-50 min-h-[40vh] rounded-lg overflow-y-auto scrollbar-thin dark:border-gray-600 dark:bg-gray-700 p-3 space-y-2">
                            
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
                <button id="distribute-button" type="button" disabled class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50">Proceed</button>
            </div>
        </div>
    </div>
</div>
