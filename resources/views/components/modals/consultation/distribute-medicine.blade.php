<div id="distribute-medicine-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-800 w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0 dark:border-gray-600">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font dark:text-white">
                    Distribute Medicine
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Select medicines and specify the quantity</p>
            </div>
            <div class="p-6 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                    <div class="space-y-4">
                        <!-- Search Bar -->
                        <div>
                            <label for="medicine-search" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Search Medicine</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>                          
                                <input type="search" id="medicine-search" placeholder="Search by name..." class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 ps-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                            </div>
                        </div>

                        <!-- Medicine List Area -->
                        <div id="medicine-list-container" class="border rounded-lg h-64 md:h-[40vh] overflow-y-auto scrollbar-thin p-3 space-y-2 dark:border-gray-600 bg-gray-50 dark:bg-gray-700">
                            <!-- Dynamic Items go here -->
                        </div>

                        <!-- Quantity & Add Button -->
                        <div class="pt-2">
                            <label for="medicine-quantity" class="block mb-2 text-sm font-medium text-main_font dark:text-white">
                                Quantity <span id="insufficient-indicator" class="text-red-500 text-xs ml-2 hidden">(Insufficient Stock)</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div class="sm:col-span-2">
                                    <input type="number" id="medicine-quantity" min="1" placeholder="Qty" disabled class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white disabled:bg-gray-200">
                                </div>
                                <button id="append-medicine" type="button" disabled class="w-full sm:w-auto h-full text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center justify-center">
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col h-full">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-lg font-medium text-main_font dark:text-white">Selected Medicines</h4>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full" id="selected-count">0 items</span>
                        </div>

                        <div id="chosen-medicine-list" class="relative border bg-gray-50 h-64 lg:h-auto lg:flex-grow rounded-lg overflow-y-auto scrollbar-thin dark:border-gray-600 dark:bg-gray-700 p-3 space-y-2">
                            <div id="chosen-medicine-placeholder" class="flex flex-col items-center justify-center w-full h-full text-gray-400 text-sm">
                                <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                No medicines selected
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 p-6 shrink-0">
                <button id="cancel-distribute-button" data-modal-hide="distribute-medicine-modal" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </button>
                <button id="distribute-button" type="button" disabled 
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    Proceed
                </button>
            </div>
        </div>
    </div>
</div>