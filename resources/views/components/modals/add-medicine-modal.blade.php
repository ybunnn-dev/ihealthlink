<!-- Main modal -->
<div id="add-medicine-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 max-w-[90%]">
            <!-- Modal header -->
            <div class="flex  flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Add Medicine
                </h3>
                <p class="text-sm text-normal_font">Please enter medicine details to proceed.</p>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div class="grid grid-cols-1 gap-3">
                    <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                        <label for="enterHouseholdHead" class="text-sm font-medium text-main_font">MEDICINE NAME</label>
                        <input type="text" id="enterHouseholdHead" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                    </div>
                    <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                        <label for="enterHouseholdHead" class="text-sm font-medium text-main_font">GENERIC NAME</label>
                        <input type="text" id="enterHouseholdHead" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                    </div>
                    <div class="grid grid-cols-1 slg:grid-cols-2 gap-3">
                        <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3 col-span-1">
                            <label for="enterHouseholdHead" class="text-sm font-medium text-main_font">CATEGORY</label>
                            <input type="text" id="enterHouseholdHead" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                        <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3 col-span-1">
                            <label for="enterHouseholdHead" class="text-sm font-medium text-main_font">FORM</label>
                            <input type="text" id="enterHouseholdHead" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                    </div>
                   <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                        <label for="medDes" class="text-sm font-medium text-main_font">DESCRIPTION</label>
                        <textarea id="medDes" class="border border-gray-300 text-gray-700 rounded-lg p-2 resize-none"></textarea>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center rounded-b gap-3 justify-end pt-6 px-6">
                <button data-modal-hide="add-medicine-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                <button id="proceed-add-household" type="button" class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Medicine</button>
            </div>
        </div>
    </div>
</div>

