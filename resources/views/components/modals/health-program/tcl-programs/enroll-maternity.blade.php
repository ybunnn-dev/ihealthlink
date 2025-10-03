<div id="enroll-maternity-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 id="maternity-modal-title" class="text-xl font-semibold text-main_font">
                    Enroll in Maternity Program
                </h3>
                <p id="maternity-modal-subtitle" class="text-sm text-normal_font">Step 1: Select a Resident</p>
            </div>
            
            <div class="p-4 md:p-5 flex flex-nowrap w-full h-[50vh] overflow-x-hidden">
                
                <div id="maternity-step-1" class="transition-transform duration-500 ease-in-out w-full flex-shrink-0">
                    @include('components.multi-modal-components.enroll-maternity-1')
                </div>

                <div id="maternity-step-2" class="transition-transform duration-500 ease-in-out w-full flex-shrink-0 hidden">
                    @include('components.multi-modal-components.enroll-maternity-2')
                </div>

            </div>
             <div class="flex items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6">
                <!-- Left side: Cancel + Previous -->
                <div class="flex gap-3">
                    <button id="maternityCancelBtn" data-modal-hide="enroll-maternity-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                    <button id="maternityBackBtn" type="button" class="hidden py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Previous</button>
                </div>
                <div class="flex gap-3">
                    <button id="maternityNextBtn" disabled type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>