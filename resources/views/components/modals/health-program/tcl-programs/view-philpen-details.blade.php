<div id="view-philpen-modal" tabindex="-1" aria-hidden="true" 
     class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden w-full h-full bg-gray-900 bg-opacity-50">
    
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm py-10 px-8">
            
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    PhilPEN Consultation Details
                </h3>
                 <button type-="button" 
                        data-modal-hide="view-philpen-modal"
                        class="absolute top-4 right-4 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            
            <div class="space-y-6 h-[70vh] overflow-y-auto w-full pr-4 mb-3">
                
                <div class="p-4 border rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">1. Resident Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                        <div>
                            <span class="text-gray-500">Name:</span>
                            <span id="view-philpen-name" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Birthdate:</span>
                            <span id="view-philpen-birthdate" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Sex:</span>
                            <span id="view-philpen-sex" class="font-semibold text-gray-900 capitalize"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Address:</span>
                            <span id="view-philpen-address" class="font-semibold text-gray-900"></span>
                        </div>
                        <div class="md:col-span-2">
                            <span class="text-gray-500">Consultation Title:</span>
                            <span id="view-philpen-consultation-title" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Consultation Date:</span>
                            <span id="view-philpen-consultation-date" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Status:</span>
                            <span id="view-philpen-status" class="font-semibold text-gray-900 capitalize"></span>
                        </div>
                    </div>
                </div>

                <div class="p-4 border rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">2. Red Flags (Health Signs)</h4>
                    <ul id="view-philpen-health-signs" class="list-disc list-inside space-y-1 text-sm text-gray-700">
                        </ul>
                </div>

                <div class="p-4 border rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">3. Medical History</h4>
                    <ul id="view-philpen-medical-history" class="list-disc list-inside space-y-1 text-sm text-gray-700">
                        </ul>
                </div>

                <div class="p-4 border rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">4. Family History</h4>
                    <ul id="view-philpen-family-history" class="list-disc list-inside space-y-1 text-sm text-gray-700">
                        </ul>
                </div>

                <div class="p-4 border rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">5. NCD Risk Factors</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                        <div>
                            <span class="text-gray-500">Tobacco Use:</span>
                            <span id="view-ncd-tobacco" class="font-semibold text-gray-900 capitalize"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Alcohol Intake:</span>
                            <span id="view-ncd-alcohol" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Drinks Last Year:</span>
                            <span id="view-ncd-drinks" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Weight:</span>
                            <span id="view-ncd-weight" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Height:</span>
                            <span id="view-ncd-height" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Waist Circumference:</span>
                            <span id="view-ncd-waist" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Blood Pressure:</span>
                            <span id="view-ncd-bp" class="font-semibold text-gray-900"></span>
                        </div>
                    </div>
                </div>

                <div class="p-4 border rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">6. Risk Assessment</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                        <div>
                            <span class="text-gray-500">Polyphagia:</span>
                            <span id="view-risk-polyphagia" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Polydipsia:</span>
                            <span id="view-risk-polydipsia" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Polyuria:</span>
                            <span id="view-risk-polyuria" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Breathlessness:</span>
                            <span id="view-risk-breathlessness" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Chronic Cough:</span>
                            <span id="view-risk-cough" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Sputum Production:</span>
                            <span id="view-risk-sputum" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Wheezing:</span>
                            <span id="view-risk-wheezing" class="font-semibold text-gray-900"></span>
                        </div>
                        <div class="md:col-span-2 pt-2">
                            <h5 class="font-semibold text-gray-700 mb-1">Lab Results</h5>
                        </div>
                        <div>
                            <span class="text-gray-500">FBS Result:</span>
                            <span id="view-risk-fbs" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">RBS Result:</span>
                            <span id="view-risk-rbs" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Total Cholesterol:</span>
                            <span id="view-risk-cholesterol" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">HDL:</span>
                            <span id="view-risk-hdl" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">LDL:</span>
                            <span id="view-risk-ldl" class="font-semibold text-gray-900"></span>
                        </div>
                    </div>
                </div>

                <div class="p-4 border rounded-lg">
                    <h4 class="text-lg font-semibold text-gray-800 mb-3">7. Management</h4>
                    <div class="grid grid-cols-1 gap-y-2 text-sm">
                        <div>
                            <span class="text-gray-500">Lifestyle Modification:</span>
                            <span id="view-mgmt-lifestyle" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Anti-Hypertensive:</span>
                            <span id="view-mgmt-anti-hypertensive" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Insulin:</span>
                            <span id="view-mgmt-insulin" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Follow-up Date:</span>
                            <span id="view-mgmt-follow-up" class="font-semibold text-gray-900"></span>
                        </div>
                        <div>
                            <span class="text-gray-500">Remarks:</span>
                            <p id="view-mgmt-remarks" class="font-semibold text-gray-900 whitespace-pre-wrap"></p>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="flex items-center justify-between border-t border-gray-200 rounded-b gap-3 pt-6 px-4 mt-3">
                <button id="close-philpen" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                    Cancel
                </button>

                <div class="flex items-center gap-3">
                    <button id="print-philpen-btn" type="button" class="text-white bg-maingreen hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full sm:w-auto">
                        Print Details
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@include('components.modals.health-program.tcl-programs.print-philpen-confirmation');