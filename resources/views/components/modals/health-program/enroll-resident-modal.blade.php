<div id="enroll-resident-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Enroll Resident
                </h3>
                <p class="text-sm text-normal_font">Please select a resident to proceed.</p>
            </div>
            <div class="p-4 md:p-5 space-y-4 h-[60vh]">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4">
                    <div class="md:col-span-3">
                        <label for="enrollResidentSearchInput" class="sr-only">Search Resident</label>
                        <input type="text" id="enrollResidentSearchInput" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 w-full" placeholder="Search resident name...">
                    </div>
                    <div class="flex items-center gap-2 md:col-span-2">
                         <select id="enrollResidentPurokFilter" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 w-full">
                            <option selected>Filter by Purok</option>
                        </select>
                       
                    </div>
                </div>
                
                <div id="enrollResidentListContainer" class="space-y-3 h-[40vh] overflow-y-auto border rounded-lg p-3">
                    
                </div>
            </div>
            <div class="flex items-center border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 justify-end pt-6 px-6">
                <button id="enrollResidentCancelBtn" data-modal-hide="enroll-resident-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                <button id="enrollResidentProceedBtn" disabled type="button" class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:opacity-50">Enroll Resident</button>
            </div>
        </div>
    </div>
</div>
@include('components.modals.health-program.enroll-resident-confirmation')