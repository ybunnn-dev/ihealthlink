<div id="edit-medicine-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700 w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0 text-center">
                <h3 class="text-xl font-semibold text-main_font">
                    Edit Medicine
                </h3>
                <p class="text-sm text-normal_font mt-1">Please update the medicine details to proceed.</p>
            </div>

            <div class="flex-grow overflow-y-auto p-6 min-h-0">
                <form id="edit-medicine-form">
                    @csrf
                    <input type="hidden" id="edit-medicine-id" name="medicine_id">

                    <div class="grid grid-cols-1 gap-4">

                        <div class="flex flex-col gap-1">
                            <label for="edit-medicine-name" class="text-sm font-medium text-main_font">MEDICINE NAME</label>
                            <input type="text" name="medicine_name" id="edit-medicine-name" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="edit-generic-name" class="text-sm font-medium text-main_font">GENERIC NAME</label>
                            <input type="text" name="generic_name" id="edit-generic-name" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="flex flex-col gap-1 relative">
                            <label for="edit-category-dropdown-btn" class="text-sm font-medium text-main_font">CATEGORY</label>
                            
                            <button id="edit-category-dropdown-btn" data-dropdown-toggle="edit-category-dropdown-menu" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2.5 text-center inline-flex items-center justify-between" type="button">
                                <span id="edit-category-selected-text">Select Category</span>
                                <svg class="w-2.5 h-2.5 ms-3 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            
                            <input type="hidden" name="category" id="edit-category-value">
                            
                            <div id="edit-category-dropdown-menu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-full absolute top-full mt-1 max-h-48 overflow-y-auto border border-gray-100">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="edit-category-dropdown-btn">
                                    <li><button type="button" data-value="" class="w-full text-left px-4 py-2 hover:bg-gray-100">Select Category</button></li>
                                    <li><button type="button" data-value="Medical Supplies" class="w-full text-left px-4 py-2 hover:bg-gray-100">Regular Medicine</button></li>
                                    <li><button type="button" data-value="Deworming Tablet" class="w-full text-left px-4 py-2 hover:bg-gray-100">Deworming Tablet</button></li>
                                     <li><button type="button" data-value="Iron With Folic Acid" class="w-full text-left px-4 py-2 hover:bg-gray-100">Iron with Folic Acid</button></li>
                                    <li><button type="button" data-value="Iron sulfate With Folic Acid" class="w-full text-left px-4 py-2 hover:bg-gray-100">Iron sulfate with Folic Acid</button></li>
                                     <li><button type="button" data-value="Vitamin A" class="w-full text-left px-4 py-2 hover:bg-gray-100">Vitamin A</button></li>
                                    <li><button type="button" data-value="Calium Carbonate" class="w-full text-left px-4 py-2 hover:bg-gray-100">Calcium Carbonate</button></li>
                                    <li><button type="button" data-value="Iodine" class="w-full text-left px-4 py-2 hover:bg-gray-100">Iodine Capsule</button></li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1 relative">
                            <label for="edit-form-dropdown-btn" class="text-sm font-medium text-main_font">FORM</label>
                            
                            <button id="edit-form-dropdown-btn" data-dropdown-toggle="edit-form-dropdown-menu" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2.5 text-center inline-flex items-center justify-between" type="button">
                                <span id="edit-form-selected-text">Select Form</span>
                                <svg class="w-2.5 h-2.5 ms-3 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            
                            <input type="hidden" name="form" id="edit-form-value">
                            
                            <div id="edit-form-dropdown-menu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-full absolute top-full mt-1 border border-gray-100">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="edit-form-dropdown-btn">
                                    <li><button type="button" data-value="" class="w-full text-left px-4 py-2 hover:bg-gray-100">Select Form</button></li>
                                    <li><button type="button" data-value="Tablet" class="w-full text-left px-4 py-2 hover:bg-gray-100">Tablet</button></li>
                                    <li><button type="button" data-value="Capsule" class="w-full text-left px-4 py-2 hover:bg-gray-100">Capsule</button></li>
                                    <li><button type="button" data-value="Syrup" class="w-full text-left px-4 py-2 hover:bg-gray-100">Syrup</button></li>
                                    <li><button type="button" data-value="Vaccine" class="w-full text-left px-4 py-2 hover:bg-gray-100">Vaccine</button></li>
                                    <li><button type="button" data-value="Non-Medicine" class="w-full text-left px-4 py-2 hover:bg-gray-100">Non-Medicine</button></li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="edit-medicine-description" class="text-sm font-medium text-main_font">DESCRIPTION</label>
                            <textarea name="description" id="edit-medicine-description" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 resize-none h-32 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>

                    </div>
                    </form>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b gap-3 p-6 shrink-0">
                <button id="cancel-edit-medicine-btn" data-modal-hide="edit-medicine-modal" type="button" class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 transition-colors">Cancel</button>
                <button id="update-medicine-submit-btn" type="submit" form="edit-medicine-form" class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    Update Medicine
                </button>
            </div>
        </div>
    </div>
</div>
@include('components.modals.medicine.edit-medicine-confirmation')