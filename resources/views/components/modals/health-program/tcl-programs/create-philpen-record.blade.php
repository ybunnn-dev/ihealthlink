<div id="create-philpen-record-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700 w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 pb-2 border-b border-gray-100 shrink-0">
                <h3 class="text-xl font-semibold text-main_font">
                    Create PhilPEN Record
                </h3>
                <p class="text-sm text-normal_font mt-1">Enter patient details to continue</p>
            </div>

            <div class="w-full px-6 py-4 border-b border-gray-200 shrink-0 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-200">
                 <ol class="flex items-center w-full text-xs font-medium text-center text-gray-500 dark:text-gray-400 sm:text-xs min-w-[600px] md:min-w-0">
                    <li id="step-progress-1" class="flex md:w-full items-center after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 gap-3">
                        <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                            <span class="me-2 p-4 rounded-md text-center text-mainblue">1</span>
                        </span>
                        <span class="block text-start">Resident's Information</span>
                    </li>
                    <li id="step-progress-2" class="flex md:w-full gap-3 items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                        <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                            <span class="me-2 p-4 rounded-md">2</span>
                        </span>
                        <span class="hidden text-start">Risk Factor Assessment</span>
                    </li>
                    <li id="step-progress-3" class="flex md:w-full gap-3 items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                        <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                            <span class="me-2 p-4 rounded-md">3</span>
                        </span>
                        <span class="hidden text-start">Medical History</span>
                    </li>
                    <li id="step-progress-4" class="flex md:w-full gap-3 items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                        <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                            <span class="me-2 p-4 rounded-md">4</span>
                        </span>
                        <span class="hidden text-start">Family History</span>
                    </li>
                    <li id="step-progress-5" class="flex md:w-full gap-3 items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                        <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                            <span class="me-2 p-4 rounded-md">5</span>
                        </span>
                        <span class="hidden text-start">NCD Risk Factors</span>
                    </li>
                   <li id="step-progress-6" class="flex md:w-full gap-3 items-center">
                        <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                            <span class="me-2 p-4 rounded-md">6</span>
                        </span>
                        <span class="hidden text-start">Risk Screening</span>
                    </li>
                     <li id="step-progress-7" class="flex md:w-full gap-3 items-center">
                        <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                            <span class="me-2 p-4 rounded-md">7</span>
                        </span>
                        <span class="hidden text-start">Management</span>
                    </li>
                </ol>
            </div>

            <div class="flex flex-nowrap w-full flex-grow min-h-0 overflow-x-hidden relative scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                
                <div id="step-1" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 h-full overflow-y-auto p-6 ">
                    <x-multi-modal-components.add-resident-1></x-multi-modal-components.add-resident-1>
                </div>

                <div id="step-2" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 h-full overflow-y-auto p-6 hidden">
                   <x-multi-modal-components.add-resident-2></x-multi-modal-components.add-resident-2>
                </div>

                <div id="step-3" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 h-full overflow-y-auto p-6 hidden">
                   <x-multi-modal-components.add-resident-3></x-multi-modal-components.add-resident-3>
                </div>

                <div id="step-4" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 h-full overflow-y-auto p-6 hidden">
                    <x-multi-modal-components.add-resident-4></x-multi-modal-components.add-resident-4>
                </div>

                <div id="step-5" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 h-full overflow-y-auto p-6 hidden">
                   <x-multi-modal-components.add-resident-5></x-multi-modal-components.add-resident-5>
                </div>

                <div id="step-6" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 h-full overflow-y-auto p-6 hidden">
                    <x-multi-modal-components.add-resident-6></x-multi-modal-components.add-resident-6>
                </div>

                <div id="step-7" class="form-step transition-transform duration-500 ease-in-out transform translate-x-0 w-full flex-shrink-0 h-full overflow-y-auto p-6 hidden">
                    <x-multi-modal-components.add-resident-7></x-multi-modal-components.add-resident-7>
                </div>

            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-4 p-6 shrink-0">
                <div class="flex flex-col-reverse sm:flex-row gap-3 w-full sm:w-auto">
                    <button id="cancel-philpen-button" data-modal-hide="create-philpen-record-modal" type="button" class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">Cancel</button>

                    <button id="prev-philpen-button" type="button" class="hidden w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">Previous</button>
                </div>

                <div class="flex w-full sm:w-auto gap-3">
                    <button id="next-philpen-button" type="button" class="w-full sm:w-auto sm:min-w-[9rem] text-white disabled:opacity-50 disabled:pointer-events-none bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">Next</button>

                    <button id="create-philpen-record-button" type="button" class="hidden w-full sm:w-auto sm:min-w-[9rem] text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">Create Record</button>
                </div>
            </div>

        </div>
    </div>
</div>

@include('components.modals.health-program.tcl-programs.create-philpen-confirmation')