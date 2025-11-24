<div id="add-philpen-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0">
                <h3 class="text-xl font-semibold text-main_font">
                    Create PhilPEN Consultation
                </h3>
                <p class="text-sm text-normal_font mt-1 text-center">Please select the consultation date to proceed.</p>
            </div>
            
            <div class="flex-grow overflow-y-auto p-6 min-h-0">
                <div class="grid grid-cols-1 gap-3">
                    <div class="flex flex-col gap-2">
                        <label for="consultationDateInput" class="text-sm font-medium text-main_font">CONSULTATION DATE</label>
                        <input type="date" id="consultationDateInput" name="consultation_date" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-3 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 p-6 shrink-0">
                <button id="cancel-add-philpen" type="button" class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-colors">Cancel</button>
                <button id="proceed-add-philpen" disabled type="button" 
                        class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 
                               disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    Create Consultation
                </button>
            </div>
        </div>
    </div>
</div>
@include('components.modals.health-program.tcl-programs.new-philpen-confirm')