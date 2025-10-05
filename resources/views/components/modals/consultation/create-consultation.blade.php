<div id="create-consultation-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6">
            <!-- Modal header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 id="consultation-modal-title" class="text-xl font-semibold text-main_font">
                    Create New Consultation
                </h3>
                <p id="consultation-modal-subtitle" class="text-sm text-normal_font">Fill in the details below</p>
            </div>
            
            <!-- Modal body -->
            <div class="p-4 md:p-5 max-h-[60vh] overflow-auto">
                <form class="space-y-6" action="#">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                        
                        <!-- Consultation Date -->
                        <div>
                            <label for="consultation_date" class="block mb-2 text-sm font-medium text-gray-900">Consultation Date</label>
                            <input type="date" name="consultation_date" id="consultation_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- Father's Name -->
                        <div>
                            <label for="father_name" class="block mb-2 text-sm font-medium text-gray-900">Father's Name</label>
                            <input type="text" name="father_name" id="father_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Juan Dela Cruz">
                        </div>

                        <!-- Mother's Name -->
                        <div>
                            <label for="mother_name" class="block mb-2 text-sm font-medium text-gray-900">Mother's Name</label>
                            <input type="text" name="mother_name" id="mother_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Maria Dela Cruz">
                        </div>
                        
                        <!-- Chief Complaint -->
                        <div class="md:col-span-2">
                            <label for="chief_complaint" class="block mb-2 text-sm font-medium text-gray-900">Chief Complaint</label>
                            <textarea id="chief_complaint" name="chief_complaint" rows="2" class="resize-none block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Describe the main issue..."></textarea>
                        </div>
                        
                        <!-- Treatment -->
                        <div class="md:col-span-2">
                            <label for="treatment" class="block mb-2 text-sm font-medium text-gray-900">Treatment / Prescription</label>
                            <textarea id="treatment" name="treatment" rows="2" class="block p-2.5 w-full text-sm resize-none text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter treatment details..."></textarea>
                        </div>

                        <hr class="md:col-span-2 my-2"/>

                        <!-- Vital Signs Section -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-4 md:col-span-2">
                            <div>
                                <label for="weight" class="block mb-2 text-sm font-medium text-gray-900">Weight (kg)</label>
                                <input type="number" step="0.1" name="weight" id="weight" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="5.5">
                            </div>
                            <div>
                                <label for="height" class="block mb-2 text-sm font-medium text-gray-900">Height (cm)</label>
                                <input type="number" step="0.1" name="height" id="height" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="50">
                            </div>
                            <div>
                                <label for="temperature" class="block mb-2 text-sm font-medium text-gray-900">Temp (°C)</label>
                                <input type="number" step="0.1" name="temperature" id="temperature" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="37.5">
                            </div>
                            <div>
                                <label for="pr" class="block mb-2 text-sm font-medium text-gray-900">Pulse Rate</label>
                                <input type="number" name="pr" id="pr" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="80">
                            </div>
                             <div>
                                <label for="rr" class="block mb-2 text-sm font-medium text-gray-900">Resp. Rate</label>
                                <input type="number" name="rr" id="rr" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="20">
                            </div>
                            <div>
                                <label for="birthweight" class="block mb-2 text-sm font-medium text-gray-900">Birth Weight (kg)</label>
                                <input type="number" step="0.1" name="birthweight" id="birthweight" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="3.2">
                            </div>
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-medium text-gray-900">Blood Pressure</label>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="bp_systolic" id="bp_systolic" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="120">
                                    <span class="text-gray-500">/</span>
                                    <input type="number" name="bp_diastolic" id="bp_diastolic" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="80">
                                </div>
                            </div>
                        </div>

                        <hr class="md:col-span-2 my-2"/>

                        <!-- PhilHealth Member Checkbox -->
                        <div class="flex items-center">
                            <input id="is_philhealth" name="is_philhealth" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="is_philhealth" class="ms-2 text-sm font-medium text-gray-900">PhilHealth Member</label>
                        </div>
                        
                        <!-- Distribute Medicine Button -->
                        <div class="flex justify-end">
                            <button id="distributeMedicineBtn" type="button" class="text-white bg-maingreen hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Distribute Medicine</button>
                        </div>
                    </div>
                </form>
            </div>
             <!-- Modal footer -->
             <div class="flex items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6">
                <button id="consultationCancelBtn" data-modal-hide="create-consultation-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="saveConsultationBtn" type="submit" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50">Save Consultation</button>
            </div>
        </div>
    </div>
</div>
