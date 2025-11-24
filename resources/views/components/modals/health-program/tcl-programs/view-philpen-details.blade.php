<div id="view-philpen-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex items-center justify-between rounded-t p-6 border-b border-gray-200 shrink-0">
                <div>
                    <h3 class="text-xl font-bold text-main_font">
                        PhilPEN Consultation Details
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">View complete patient record</p>
                </div>
                <button type="button" 
                        data-modal-hide="view-philpen-modal"
                        class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            
            <div class="flex-grow overflow-y-auto p-6 min-h-0 space-y-6 bg-white">
                
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">1</span>
                        <h4 class="font-semibold text-gray-800">Resident Details</h4>
                    </div>
                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Name</span>
                            <span id="view-philpen-name" class="text-base font-semibold text-gray-900 mt-0.5"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Birthdate</span>
                            <span id="view-philpen-birthdate" class="text-base font-semibold text-gray-900 mt-0.5"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Sex</span>
                            <span id="view-philpen-sex" class="text-base font-semibold text-gray-900 mt-0.5 capitalize"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Status</span>
                            <span id="view-philpen-status" class="text-base font-semibold text-gray-900 mt-0.5 capitalize"></span>
                        </div>
                        <div class="md:col-span-2 flex flex-col">
                            <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Address</span>
                            <span id="view-philpen-address" class="text-base font-semibold text-gray-900 mt-0.5"></span>
                        </div>
                        <div class="md:col-span-2 border-t border-gray-100 pt-3 mt-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Consultation Title</span>
                                <span id="view-philpen-consultation-title" class="text-base font-semibold text-mainblue mt-0.5"></span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-gray-500 uppercase tracking-wide">Consultation Date</span>
                                <span id="view-philpen-consultation-date" class="text-base font-semibold text-gray-900 mt-0.5"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-red-100 text-red-600 text-xs font-bold">2</span>
                        <h4 class="font-semibold text-gray-800">Red Flags (Health Signs)</h4>
                    </div>
                    <div class="p-4">
                        <ul id="view-philpen-health-signs" class="list-disc list-inside space-y-1 text-sm text-gray-700 marker:text-red-500">
                            </ul>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">3</span>
                        <h4 class="font-semibold text-gray-800">Medical History</h4>
                    </div>
                    <div class="p-4">
                        <ul id="view-philpen-medical-history" class="list-disc list-inside space-y-1 text-sm text-gray-700 marker:text-indigo-500">
                             </ul>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-purple-100 text-purple-600 text-xs font-bold">4</span>
                        <h4 class="font-semibold text-gray-800">Family History</h4>
                    </div>
                    <div class="p-4">
                        <ul id="view-philpen-family-history" class="list-disc list-inside space-y-1 text-sm text-gray-700 marker:text-purple-500">
                             </ul>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-orange-100 text-orange-600 text-xs font-bold">5</span>
                        <h4 class="font-semibold text-gray-800">NCD Risk Factors</h4>
                    </div>
                    <div class="p-4 grid grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-4 text-sm">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase">Tobacco Use</span>
                            <span id="view-ncd-tobacco" class="font-medium text-gray-900 capitalize"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase">Alcohol Intake</span>
                            <span id="view-ncd-alcohol" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase">Drinks/Year</span>
                            <span id="view-ncd-drinks" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="col-span-2 md:col-span-3 border-t border-gray-100 my-1"></div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase">Weight</span>
                            <span id="view-ncd-weight" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase">Height</span>
                            <span id="view-ncd-height" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase">Waist Circ.</span>
                            <span id="view-ncd-waist" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex flex-col md:col-span-3">
                            <span class="text-xs text-gray-500 uppercase">Blood Pressure</span>
                            <span id="view-ncd-bp" class="font-medium text-gray-900"></span>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100 text-yellow-600 text-xs font-bold">6</span>
                        <h4 class="font-semibold text-gray-800">Risk Assessment & Labs</h4>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-4 text-sm mb-4">
                            <div class="flex flex-col"><span class="text-xs text-gray-500">Polyphagia</span><span id="view-risk-polyphagia" class="font-medium text-gray-900"></span></div>
                            <div class="flex flex-col"><span class="text-xs text-gray-500">Polydipsia</span><span id="view-risk-polydipsia" class="font-medium text-gray-900"></span></div>
                            <div class="flex flex-col"><span class="text-xs text-gray-500">Polyuria</span><span id="view-risk-polyuria" class="font-medium text-gray-900"></span></div>
                            <div class="flex flex-col"><span class="text-xs text-gray-500">Wheezing</span><span id="view-risk-wheezing" class="font-medium text-gray-900"></span></div>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-4 text-sm mb-4">
                            <div class="flex flex-col"><span class="text-xs text-gray-500">Breathless</span><span id="view-risk-breathlessness" class="font-medium text-gray-900"></span></div>
                            <div class="flex flex-col"><span class="text-xs text-gray-500">Cough</span><span id="view-risk-cough" class="font-medium text-gray-900"></span></div>
                            <div class="flex flex-col"><span class="text-xs text-gray-500">Sputum</span><span id="view-risk-sputum" class="font-medium text-gray-900"></span></div>
                        </div>
                        
                        <div class="border-t border-gray-100 pt-3">
                            <h5 class="text-xs font-bold text-gray-500 uppercase mb-3">Laboratory Results</h5>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-4 text-sm">
                                <div class="flex flex-col"><span class="text-xs text-gray-500">FBS</span><span id="view-risk-fbs" class="font-medium text-gray-900"></span></div>
                                <div class="flex flex-col"><span class="text-xs text-gray-500">RBS</span><span id="view-risk-rbs" class="font-medium text-gray-900"></span></div>
                                <div class="flex flex-col"><span class="text-xs text-gray-500">Cholesterol</span><span id="view-risk-cholesterol" class="font-medium text-gray-900"></span></div>
                                <div class="flex flex-col"><span class="text-xs text-gray-500">HDL</span><span id="view-risk-hdl" class="font-medium text-gray-900"></span></div>
                                <div class="flex flex-col"><span class="text-xs text-gray-500">LDL</span><span id="view-risk-ldl" class="font-medium text-gray-900"></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-green-100 text-green-600 text-xs font-bold">7</span>
                        <h4 class="font-semibold text-gray-800">Management</h4>
                    </div>
                    <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase">Lifestyle Modification</span>
                            <span id="view-mgmt-lifestyle" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase">Follow-up Date</span>
                            <span id="view-mgmt-follow-up" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase">Anti-Hypertensive</span>
                            <span id="view-mgmt-anti-hypertensive" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-500 uppercase">Oral Hypoglycemic/Insulin</span>
                            <span id="view-mgmt-insulin" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="md:col-span-2 bg-yellow-50 p-3 rounded border border-yellow-100">
                            <span class="text-xs font-bold text-yellow-700 uppercase block mb-1">Remarks</span>
                            <p id="view-mgmt-remarks" class="text-gray-800 whitespace-pre-wrap text-sm leading-relaxed"></p>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b gap-3 p-6 shrink-0 bg-gray-50">
                <button id="close-philpen" data-modal-hide="view-philpen-modal" type="button" class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 transition-colors">
                    Close
                </button>

                <button id="print-philpen-btn" type="button" class="w-full sm:w-auto text-white bg-maingreen hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center justify-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Details
                </button>
            </div>

        </div>
    </div>
</div>
@include('components.modals.health-program.tcl-programs.print-philpen-confirmation')