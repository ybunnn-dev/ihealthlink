<div id="enroll-child-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <!-- 
            Responsive Card:
            1. flex flex-col: Essential for sticky header/footer + variable body height.
            2. max-h-[90vh]: Ensures modal fits in viewport.
        -->
        <div class="relative bg-white rounded-lg shadow-xl w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <!-- Modal header (Fixed) -->
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0">
                <h3 id="child-modal-title" class="text-xl md:text-2xl font-semibold text-main_font">
                    Enroll Child in Program
                </h3>
                <p id="child-modal-subtitle" class="text-sm text-gray-600 mt-1">Step 1: Select Parent or Guardian</p>
            </div>
            
            <!-- 
               Modal body (Slider Track)
               1. flex-grow / min-h-0: Takes up remaining vertical space.
               2. flex-nowrap: Keeps steps in a horizontal row.
               3. overflow-x-hidden: Hides steps that are slid out of view.
            -->
            <div class="flex flex-nowrap w-full flex-grow min-h-0 overflow-x-hidden relative" id="child-steps-container">
                
                <!-- Step 1: Select Child -->
                <!-- Added h-full and overflow-y-auto so the inner content scrolls independently -->
                <div id="child-step-1" class="transition-transform duration-500 ease-in-out w-full flex-shrink-0 h-full overflow-y-auto p-6">
                    @include('components.multi-modal-components.enroll-child-1')
                </div>

                <!-- Step 2: Select Mother -->
                <!-- Restored 'hidden' class as requested by original code structure -->
                <div id="child-step-2" class="transition-transform duration-500 ease-in-out w-full flex-shrink-0 h-full overflow-y-auto p-6 hidden">
                    @include('components.multi-modal-components.enroll-child-2')
                </div>

                <!-- Step 3: Review and Confirm -->
                <!-- Restored 'hidden' class -->
                <div id="child-step-3" class="transition-transform duration-500 ease-in-out w-full flex-shrink-0 h-full overflow-y-auto p-6 hidden">
                    @include('components.multi-modal-components.enroll-child-3')
                </div>

            </div>

            <!-- Modal footer (Fixed) -->
             <div class="flex items-center justify-between border-t border-gray-200 rounded-b gap-3 p-6 shrink-0">
                <!-- Left side: Cancel + Previous -->
                <div class="flex gap-3">
                    <button id="childCancelBtn" data-modal-hide="enroll-child-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 transition-colors">Cancel</button>
                    <button id="childBackBtn" type="button" class="hidden py-2.5 px-5 text-sm font-medium text-main_font bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 transition-colors">Previous</button>
                </div>
                <!-- Right side: Next + Enroll -->
                <div class="flex gap-3">
                    <button id="childNextBtn" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 transition-colors">Next</button>
                    <button id="childFinishBtn" type="button" class="hidden text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 transition-colors">Enroll</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.modals.health-program.tcl-programs.enroll-child-confirmation')