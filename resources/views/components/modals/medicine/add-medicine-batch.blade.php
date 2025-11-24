<div id="add-batch-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700 w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0 text-center">
                <h3 class="text-xl font-semibold text-main_font">
                    New Batch
                </h3>
                <p class="text-sm text-normal_font mt-1">Please enter batch details to proceed.</p>
            </div>

            <div class="flex-grow overflow-y-auto p-6 min-h-0">
                <form id="add-batch-form">
                    @csrf
                    
                    <div class="space-y-4">
                        <div class="flex flex-col gap-1">
                            <label for="dateAdded" class="text-sm font-medium text-main_font">DATE ADDED</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input type="text" id="dateAdded" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 pl-10 block w-full bg-gray-100 cursor-not-allowed" value="{{ now()->toDateString() }}" disabled>
                                <input type="hidden" name="date_received" value="{{ now()->toDateString() }}">
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="expiryDate" class="text-sm font-medium text-main_font">EXPIRY DATE</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input datepicker type="text" id="expiryDate" name="expiry_date" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 pl-10 block w-full focus:ring-blue-500 focus:border-blue-500" placeholder="Select date" required>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="quantity_received" class="text-sm font-medium text-main_font">QUANTITY</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2a8 8 0 1 0 8 8 8.01 8.01 0 0 0-8-8Zm1 11H9v-2h2Zm0-4H9V5h2Z"/>
                                    </svg>
                                </div>
                                <input type="number" id="quantity_received" name="quantity_received" min="1" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 pl-10 block w-full focus:ring-blue-500 focus:border-blue-500" placeholder="Enter quantity" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b gap-3 p-6 shrink-0">
                <button id="close-add-batch" type="button" class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">Cancel</button>
                <button id="submit-batch" type="button" class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">Add Batch</button>
            </div>
        </div>
    </div>
</div>