<div id="enroll-maternity-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 id="maternity-modal-title" class="text-xl font-semibold text-main_font">
                    Enroll in Maternity Program
                </h3>
                <p id="maternity-modal-subtitle" class="text-sm text-normal_font">Step 1: Select a Resident</p>
            </div>
            
            <div class="p-4 md:p-5 space-y-4">
                
                <div id="maternity-step-1">
                    @include('components.multi-modal-components.enroll-maternity-1')
                </div>

                <div id="maternity-step-2" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="lmp" class="block mb-2 text-sm font-medium text-gray-900">Last Menstrual Period (LMP)</label>
                            <input type="date" name="lmp" id="lmp" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div>
                            <label for="edc" class="block mb-2 text-sm font-medium text-gray-900">Estimated Date of Confinement (EDC)</label>
                            <input type="date" name="edc" id="edc" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                         <div class="md:col-span-2">
                            <label for="notes" class="block mb-2 text-sm font-medium text-gray-900">Additional Notes</label>
                            <textarea id="notes" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write any relevant notes here..."></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex items-center border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 justify-end pt-6 px-6">
                <button id="maternityCancelBtn" data-modal-hide="enroll-maternity-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="maternityBackBtn" type="button" class="hidden py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Back</button>
                <button id="maternityNextBtn" disabled type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50">Next</button>
            </div>
        </div>
    </div>
</div>