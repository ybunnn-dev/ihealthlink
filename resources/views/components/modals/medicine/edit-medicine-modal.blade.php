<div id="edit-medicine-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 max-w-[90%]">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Edit Medicine
                </h3>
                <p class="text-sm text-normal_font">Please update the medicine details to proceed.</p>
            </div>
            <form id="edit-medicine-form">
                @csrf
                <input type="hidden" id="edit-medicine-id" name="medicine_id">

                <div class="p-4 md:p-5 space-y-4">
                    <div class="grid grid-cols-1 gap-3">

                        <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                            <label for="edit-medicine-name" class="text-sm font-medium text-main_font">MEDICINE NAME</label>
                            <input type="text" name="medicine_name" id="edit-medicine-name" class="border border-gray-300 text-gray-700 rounded-lg p-2" required>
                        </div>

                        <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                            <label for="edit-generic-name" class="text-sm font-medium text-main_font">GENERIC NAME</label>
                            <input type="text" name="generic_name" id="edit-generic-name" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>

                        <div class="flex flex-col col-span-1 relative">
                            <label for="edit-category-dropdown-btn" class="text-sm font-medium text-main_font">CATEGORY</label>
                            <button id="edit-category-dropdown-btn" data-dropdown-toggle="edit-category-dropdown-menu" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2 text-center inline-flex items-center justify-between" type="button">
                                <span id="edit-category-selected-text">Select Category</span>
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <input type="hidden" name="category" id="edit-category-value">
                            <div id="edit-category-dropdown-menu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="edit-category-dropdown-btn">
                                    <li><button type="button" data-value="Medicine" class="w-full text-left px-4 py-2 hover:bg-gray-100">Medicine</button></li>
                                    <li><button type="button" data-value="Medical Supplies" class="w-full text-left px-4 py-2 hover:bg-gray-100">Medical Supplies</button></li>
                                    <li><button type="button" data-value="Equipment" class="w-full text-left px-4 py-2 hover:bg-gray-100">Equipment</button></li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex flex-col col-span-1 relative">
                            <label for="edit-form-dropdown-btn" class="text-sm font-medium text-main_font">FORM</label>
                            <button id="edit-form-dropdown-btn" data-dropdown-toggle="edit-form-dropdown-menu" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2 text-center inline-flex items-center justify-between" type="button">
                                <span id="edit-form-selected-text">Select Form</span>
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <input type="hidden" name="form" id="edit-form-value">
                            <div id="edit-form-dropdown-menu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="edit-form-dropdown-btn">
                                    <li><button type="button" data-value="Tablet" class="w-full text-left px-4 py-2 hover:bg-gray-100">Tablet</button></li>
                                    <li><button type="button" data-value="Capsule" class="w-full text-left px-4 py-2 hover:bg-gray-100">Capsule</button></li>
                                    <li><button type="button" data-value="Syrup" class="w-full text-left px-4 py-2 hover:bg-gray-100">Syrup</button></li>
                                    <li><button type="button" data-value="Injection" class="w-full text-left px-4 py-2 hover:bg-gray-100">Injection</button></li>
                                </ul>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="edit-medicine-description" class="text-sm font-medium text-main_font">DESCRIPTION</label>
                            <textarea name="description" id="edit-medicine-description" class="border border-gray-300 text-gray-700 rounded-lg p-2 resize-none h-32"></textarea>
                        </div>

                    </div>
                </div>

                <div class="flex items-center rounded-b gap-3 justify-end pt-3 px-6">
                    <button id="cancel-edit-medicine-btn" data-modal-hide="edit-medicine-modal" type="button" class="py-2.5 px-5 text-sm font-medium border rounded-lg">Cancel</button>
                    <button id="update-medicine-submit-btn" type="submit" class="text-white bg-mainblue hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5 disabled:opacity-50 disabled:cursor-not-allowed">
                        Update Medicine
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('components.modals.medicine.edit-medicine-confirmation')