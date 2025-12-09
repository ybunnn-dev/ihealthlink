<div id="edit-batch-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700 w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0 text-center">
                <h3 class="text-xl font-semibold text-main_font">
                    Edit Batch
                </h3>
                <p class="text-sm text-normal_font mt-1">Update the batch expiration date.</p>
            </div>

            <div class="flex-grow overflow-y-auto p-6 min-h-0">
                <form id="edit-batch-form">
                    @csrf
                    @method('PUT') <input type="hidden" id="edit_batch_id" name="id">

                    <div class="space-y-4">
                       <div class="flex flex-col gap-1">
                            <label for="editExpiryDate" class="text-sm font-medium text-main_font">EXPIRY DATE</label>
                            <input
                                type="date"
                                id="editExpiryDate"
                                name="expiry_date"
                                class="border border-gray-300 text-gray-700 rounded-lg p-2.5 block w-full focus:ring-blue-500 focus:border-blue-500"
                                required
                            >
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b gap-3 p-6 shrink-0">
                <button id="close-edit-batch" type="button" class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">Cancel</button>
                <button id="update-batch-btn" type="button" class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">Save Changes</button>
            </div>
        </div>
    </div>
</div>
@include('components.modals.medicine.confirm-edit-batch')