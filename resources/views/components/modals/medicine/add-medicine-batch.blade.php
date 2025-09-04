<!-- Main modal -->
<div id="add-batch-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 max-w-full">
            <!-- Modal header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    New Batch
                </h3>
                <p class="text-sm text-normal_font">Please enter batch details to proceed.</p>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <form method="POST" action="{{ route('midwife.medicines.inventory.store', $medicine->id) }}">
                    @csrf

                    <!-- DATE ADDED (auto-filled, disabled for user but still pass via hidden input) -->
                    <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                        <label for="dateAdded" class="text-sm font-medium text-main_font">DATE ADDED</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input type="text" id="dateAdded" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 pl-10 block w-full bg-gray-100 cursor-not-allowed" value="{{ now()->toDateString() }}" disabled>
                            <input type="hidden" name="date_received" value="{{ now()->toDateString() }}">
                        </div>
                    </div>

                    <!-- EXPIRY DATE -->
                    <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                        <label for="expiryDate" class="text-sm font-medium text-main_font">EXPIRY DATE</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input datepicker type="text" id="expiryDate" name="expiry_date" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 pl-10 block w-full" placeholder="Select date" required>
                        </div>
                    </div>

                    <!-- QUANTITY -->
                    <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                        <label for="quantity_received" class="text-sm font-medium text-main_font">QUANTITY</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a8 8 0 1 0 8 8 8.01 8.01 0 0 0-8-8Zm1 11H9v-2h2Zm0-4H9V5h2Z"/>
                                </svg>
                            </div>
                            <input type="number" id="quantity_received" name="quantity_received" min="1" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 pl-10 block w-full" placeholder="Enter quantity" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex items-center rounded-b gap-3 justify-end pt-3 px-6">
                        <button data-modal-hide="add-batch-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                        <button type="submit" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Add Medicine</button>
                    </div>
                </form>
        </div>
    </div>
</div>