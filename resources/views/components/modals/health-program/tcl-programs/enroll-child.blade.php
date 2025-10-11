<div id="enroll-child-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm py-10 px-6">
            <!-- Modal header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-6 text-center">
                <h3 id="child-modal-title" class="text-xl font-semibold text-main_font">
                    Enroll Child in Program
                </h3>
                <p id="child-modal-subtitle" class="text-sm text-gray-600">Step 1: Select Parent or Guardian</p>
            </div>
            
            <!-- Modal body with sliding steps -->
            <div class="flex flex-nowrap w-full h-[50vh] overflow-x-hidden">
                
                <!-- Step 1: Select Parent/Guardian -->
                <div id="child-step-1" class="transition-transform duration-500 ease-in-out w-full flex-shrink-0">
                    {{-- This view should contain a searchable list of residents to act as the parent/guardian --}}
                    @include('components.multi-modal-components.enroll-child-1')
                </div>

                <!-- Step 2: Child's Information -->
                <div id="child-step-2" class="transition-transform duration-500 ease-in-out w-full flex-shrink-0 hidden">
                    {{-- This view should contain the form for the child's details (name, DOB, etc.) --}}
                    @include('components.multi-modal-components.enroll-child-2')
                </div>

                <!-- Step 3: Review and Confirm -->
                <div id="child-step-3" class="transition-transform duration-500 ease-in-out w-full flex-shrink-0 hidden">
                    {{-- This view should show a summary of the details for final confirmation --}}
                    @include('components.multi-modal-components.enroll-child-3')
                </div>

            </div>

            <!-- Modal footer with navigation -->
             <div class="flex items-center justify-between border-t border-gray-200 rounded-b gap-3 pt-6 px-6">
                <!-- Left side: Cancel + Previous -->
                <div class="flex gap-3">
                    <button id="childCancelBtn" data-modal-hide="enroll-child-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                    <button id="childBackBtn" type="button" class="hidden py-2.5 px-5 text-sm font-medium text-main_font bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Previous</button>
                </div>
                <!-- Right side: Next + Finish -->
                <div class="flex gap-3">
                    <button id="childNextBtn" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50">Next</button>
                    <button id="childFinishBtn" type="button" class="hidden text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50">Enroll</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.modals.health-program.tcl-programs.enroll-child-confirmation')
