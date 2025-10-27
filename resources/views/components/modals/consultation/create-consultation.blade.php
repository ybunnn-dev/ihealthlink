<div id="create-consultation-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-normal_font py-10 px-6">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 id="consultation-modal-title" class="text-xl font-semibold text-main_font">
                    Create New Consultation
                </h3>
                <p id="consultation-modal-subtitle" class="text-sm text-normal_font">Fill in the details below</p>
            </div>
            
            <div class="p-4 md:p-5 max-h-[60vh] overflow-auto">
                <form class="space-y-6" action="#">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                        
                        <div>
                            <label for="consultation_date" class="block mb-2 text-sm font-medium text-main_font">Consultation Date</label>
                            <input type="date" name="consultation_date" id="consultation_date" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <div>
                            <label for="is_pregnant" class="block mb-2 text-sm font-medium text-main_font">Is Pregnant?</label>
                            <select id="is_pregnant" name="is_pregnant" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                        <div>
                            <label for="is_lactating" class="block mb-2 text-sm font-medium text-main_font">Is Lactating?</label>
                            <select id="is_lactating" name="is_lactating" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="chief_complaint" class="block mb-2 text-sm font-medium text-main_font">Chief Complaint</label>
                            <textarea id="chief_complaint" name="chief_complaint" rows="2" class="resize-none block p-2.5 w-full text-sm text-main_font bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Describe the main issue..."></textarea>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="treatment" class="block mb-2 text-sm font-medium text-main_font">Treatment / Prescription</label>
                            <textarea id="treatment" name="treatment" rows="2" class="block p-2.5 w-full text-sm resize-none text-main_font bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter treatment details..."></textarea>
                        </div>

                        <hr class="md:col-span-2 my-2"/>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-4 md:col-span-2">
                            <div>
                                <label for="weight" class="block mb-2 text-sm font-medium text-main_font">Weight (kg)</label>
                                <input type="number" step="0.1" name="weight" id="weight" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                            <div>
                                <label for="height" class="block mb-2 text-sm font-medium text-main_font">Height (cm)</label>
                                <input type="number" step="0.1" name="height" id="height" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                            <div>
                                <label for="temperature" class="block mb-2 text-sm font-medium text-main_font">Temp (°C)</label>
                                <input type="number" step="0.1" name="temperature" id="temperature" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                            <div>
                                <label for="pr" class="block mb-2 text-sm font-medium text-main_font">Pulse Rate</label>
                                <input type="number" name="pr" id="pr" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                             <div>
                                <label for="rr" class="block mb-2 text-sm font-medium text-main_font">Resp. Rate</label>
                                <input type="number" name="rr" id="rr" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-medium text-main_font">Blood Pressure</label>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="bp_systolic" id="bp_systolic" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <span class="text-gray-500">/</span>
                                    <input type="number" name="bp_diastolic" id="bp_diastolic" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                            </div>
                        </div>

                        <hr class="md:col-span-2 my-2"/>
                        <div class="flex justify-start">
                            <button id="distributeMedicineBtn" type="button" class="text-white bg-maingreen hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Distribute Medicine</button>
                        </div>
                    </div>
                </form>
            </div>
             <div class="flex items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6">
                <button id="consultationCancelBtn" data-modal-hide="create-consultation-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="saveConsultationBtn" type="submit" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save Consultation</button>
            </div>
        </div>
    </div>
</div>
@include('components.modals.consultation.create-consultation-confirmation')