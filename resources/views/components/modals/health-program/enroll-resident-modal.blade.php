<div id="enroll-resident-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700 w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0 dark:border-gray-600">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font dark:text-white">
                    Enroll Resident
                </h3>
                <p class="text-sm text-normal_font mt-1 dark:text-gray-400">Please select a resident to proceed.</p>
            </div>
            <div class="p-6 flex flex-col gap-4 flex-grow min-h-0">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 shrink-0">
                    <div class="md:col-span-3">
                        <label for="enrollResidentSearchInput" class="sr-only">Search Resident</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" id="enrollResidentSearchInput" class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 ps-10 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:placeholder-gray-400" placeholder="Search resident name...">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                         <select id="enrollResidentPurokFilter" class="bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                            <option selected>Filter by Purok</option>
                        </select>
                    </div>
                </div>
                
                <div id="enrollResidentListContainer" class="flex-grow overflow-y-auto border border-gray-200 rounded-lg p-3 space-y-3 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 dark:border-gray-600 dark:bg-gray-800">
                  
                </div>
            </div>
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 p-6 shrink-0">
                <button id="enrollResidentCancelBtn" data-modal-hide="enroll-resident-modal" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </button>
                <button id="enrollResidentProceedBtn" disabled type="button" 
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    Enroll Resident
                </button>
            </div>
        </div>
    </div>
</div>
@include('components.modals.health-program.enroll-resident-confirmation')