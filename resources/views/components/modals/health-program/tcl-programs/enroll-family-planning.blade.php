<div id="enroll-family-planning-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0">
                <h3 id="fp-modal-title" class="text-xl md:text-2xl font-semibold text-main_font">
                    Enroll in Family Planning
                </h3>
                <p id="fp-modal-subtitle" class="text-sm text-gray-600 mt-1">Step 1: Select a Resident</p>
            </div>
            
            <div class="flex flex-nowrap w-full flex-grow min-h-0 overflow-x-hidden relative" id="fp-steps-container">
                
                <div id="fp-step-1" class="transition-transform duration-500 ease-in-out w-full flex-shrink-0 h-full overflow-y-auto p-6">
                    @include('components.multi-modal-components.family-planning-1')
                </div>

                <div id="fp-step-2" class="transition-transform duration-500 ease-in-out w-full flex-shrink-0 h-full overflow-y-auto p-6 hidden">
                    @include('components.multi-modal-components.family-planning-2')
                </div>

            </div>

             <div class="flex flex-col-reverse sm:flex-row items-center justify-between border-t border-gray-200 rounded-b gap-4 p-6 shrink-0">
    
                <div class="flex flex-col-reverse sm:flex-row gap-3 w-full sm:w-auto">
                    
                    <button id="fpCancelBtn" data-modal-hide="enroll-family-planning-modal" type="button" 
                        class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 transition-colors">
                        Cancel
                    </button>
                    
                    <button id="fpBackBtn" type="button" 
                        class="hidden w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-main_font bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 transition-colors">
                        Previous
                    </button>
                </div>

                <div class="flex w-full sm:w-auto">
                    <button id="fpNextBtn" disabled type="button" 
                        class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 transition-colors">
                        Next
                    </button>
                </div>
                
            </div>
        </div>
    </div>
</div>
@include('components.modals.health-program.tcl-programs.enroll-family-planning-confirmation')