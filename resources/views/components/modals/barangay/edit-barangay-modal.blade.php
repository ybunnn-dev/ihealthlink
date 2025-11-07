<div id="edit-barangay-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Edit Barangay
                </h3>
                <p class="text-sm text-normal_font">Please enter new barangay name to proceed.</p>
            </div>
            <div class="p-4 md:p-5">
                <div class="grid grid-cols-1 gap-1">
                    {{-- Changed label and input ID for clarity --}}
                    <label for="barangay-name-input" class="text-sm font-medium text-main_font">BARANGAY NAME</label>
                    <input type="text" id="barangay-name-input" class="border border-gray-300 text-gray-700 rounded-lg p-2" placeholder="e.g., San Jose">
                </div>
            </div>
            <div class="flex items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6">
                <button id="cancel-edit-barangay" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                {{-- Changed button ID for clarity --}}
                <button id="open-confirmation-modal-button" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Edit Barangay</button>
            </div>
        </div>
    </div>
</div>
@include('components.modals.barangay.edit-barangay-confirmation')