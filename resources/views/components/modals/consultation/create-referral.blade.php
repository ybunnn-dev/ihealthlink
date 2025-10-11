<div id="create-referral-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-8">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Create Patient Referral
                </h3>
                <p class="text-sm text-normal_font -mt-1">Fill out the referral details below</p>
            </div>

            <div class="space-y-4 h-[70vh] overflow-y-auto w-full pr-4 mb-3">
                <form action="#" class="grid grid-cols-1 slg2:grid-cols-4 gap-x-6 gap-y-4">
                    
                    <div class="slg2:col-span-4 font-semibold text-lg border-b pb-2 text-normal_font">Referral Information</div>

                    <div class="slg2:col-span-4 bg-blue-50 p-3 rounded-lg text-center">
                        <p class="text-sm font-medium text-blue-800" id="referred-to">Referred to: Municipal Health Office of Municipal Health Office Daraga, Albay</p>
                    </div>
                    
                    <div>
                        <label for="referred-date" class="block mb-2 text-sm font-medium text-main_font">Referred Date</label>
                        <input type="date" id="referred-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div>
                        <label for="referred-time" class="block mb-2 text-sm font-medium text-main_font">Referred Time</label>
                        <input type="time" id="referred-time" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div class="slg2:col-span-2">
                        <label for="referred-from" class="block mb-2 text-sm font-medium text-main_font">Referred From (Facility Address)</label>
                        <input type="text" id="referred-from" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div class="slg2:col-span-4">
                        <label for="referral-needs" class="block mb-2 text-sm font-medium text-main_font">Referral Needs</label>
                        <select id="referral-needs" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected>Choose a reason</option>
                            <option value="checkup">Check-up</option>
                            <option value="dental">Dental</option>
                            <option value="meds">Maintenance Meds</option>
                            <option value="lab">Laboratory</option>
                            <option value="hygiene">Total Hygiene Clinic</option>
                            <option value="others">Others</option>
                        </select>
                    </div>

                    <div class="slg2:col-span-4 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">Patient Information</div>
                    
                    <div class="slg2:col-span-2">
                        <label for="patient-name" class="block mb-2 text-sm font-medium text-main_font">Name of Patient</label>
                        <input type="text" id="patient-name" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <div>
                        <label for="patient-birthdate" class="block mb-2 text-sm font-medium text-main_font">Birthdate</label>
                        <input type="date" id="patient-birthdate" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <div>
                        <label for="patient-age" class="block mb-2 text-sm font-medium text-main_font">Age</label>
                        <input type="text" id="patient-age" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                    </div>
                    <div class="slg2:col-span-4">
                        <label for="patient-address" class="block mb-2 text-sm font-medium text-main_font">Complete Address</label>
                        <input type="text" id="patient-address" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <div>
                        <label for="patient-sex" class="block mb-2 text-sm font-medium text-main_font">Sex</label>
                        <select id="patient-sex" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            <option selected>Choose Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                     <div>
                        <label for="civil-status" class="block mb-2 text-sm font-medium text-main_font">Civil Status</label>
                        <select id="civil-status" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            <option selected>Choose Status</option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="widowed">Widowed</option>
                            <option value="separated">Separated</option>
                        </select>
                    </div>
                    <div class="slg2:col-span-2"></div>
                    <div class="slg2:col-span-2">
                        <label for="father-name" class="block mb-2 text-sm font-medium text-main_font">Father's Name</label>
                        <input type="text" id="father-name" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <div class="slg2:col-span-2">
                        <label for="mother-name" class="block mb-2 text-sm font-medium text-main_font">Mother's Name</label>
                        <input type="text" id="mother-name" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="slg2:col-span-4 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">Vital Signs & Measurements</div>
                    <div>
                        <label for="height" class="block mb-2 text-sm font-medium text-main_font">Height (cm)</label>
                        <input type="number" id="height" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5" placeholder="e.g., 160">
                    </div>
                    <div>
                        <label for="weight" class="block mb-2 text-sm font-medium text-main_font">Weight (kg)</label>
                        <input type="number" id="weight" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5" placeholder="e.g., 55">
                    </div>
                    <div>
                        <label for="temperature" class="block mb-2 text-sm font-medium text-main_font">Temp (°C)</label>
                        <input type="number" id="temperature" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5" placeholder="e.g., 36.5">
                    </div>
                    <div class="flex gap-2">
                        <div>
                             <label for="bp-systolic" class="block mb-2 text-sm font-medium text-main_font">BP Sys</label>
                             <input type="number" id="bp-systolic" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5" placeholder="120">
                        </div>
                         <div>
                             <label for="bp-diastolic" class="block mb-2 text-sm font-medium text-main_font">BP Dia</label>
                             <input type="number" id="bp-diastolic" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5" placeholder="80">
                        </div>
                    </div>
                    <div>
                        <label for="pulse-rate" class="block mb-2 text-sm font-medium text-main_font">Pulse Rate (bpm)</label>
                        <input type="number" id="pulse-rate" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5" placeholder="e.g., 70">
                    </div>
                     <div>
                        <label for="resp-rate" class="block mb-2 text-sm font-medium text-main_font">Resp. Rate (rpm)</label>
                        <input type="number" id="resp-rate" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5" placeholder="e.g., 18">
                    </div>

                    <fieldset class="slg2:col-span-4 border p-4 rounded-lg mt-4">
                        <legend class="text-md font-semibold text-main_font px-2">For Female Patients (18+)</legend>
                        <div class="grid grid-cols-1 sm:grid-cols-2 slg2:grid-cols-4 gap-4">
                            <div>
                                <label for="is-pregnant" class="block mb-2 text-sm font-medium text-main_font">Is Pregnant?</label>
                                <select id="is-pregnant" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                                    <option value="no" selected>No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                            <div class="slg2:col-span-3">
                                <label for="fp-method" class="block mb-2 text-sm font-medium text-main_font">Family Planning Method</label>
                                <input type="text" id="fp-method" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            </div>
                            <div>
                                <label for="lmp-date" class="block mb-2 text-sm font-medium text-main_font">LMP</label>
                                <input type="date" id="lmp-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            </div>
                             <div>
                                <label for="edd-date" class="block mb-2 text-sm font-medium text-main_font">EDD</label>
                                <input type="date" id="edd-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            </div>
                             <div>
                                <label for="gravida" class="block mb-2 text-sm font-medium text-main_font">Gravida</label>
                                <input type="text" id="gravida" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            </div>
                             <div>
                                <label for="para" class="block mb-2 text-sm font-medium text-main_font">Para</label>
                                <input type="text" id="para" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            </div>
                              <div>
                                <label for="aog" class="block mb-2 text-sm font-medium text-main_font">AOG</label>
                                <input type="text" id="aog" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="slg2:col-span-4 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">For Infants</legend>
                        <div>
                            <label for="infant-birth-weight" class="block mb-2 text-sm font-medium text-main_font">Birth Weight (kg)</label>
                            <input type="number" id="infant-birth-weight" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5" placeholder="e.g., 3.1">
                        </div>
                    </fieldset>

                    <div class="slg2:col-span-4 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">Medical Details</div>
                    <div class="slg2:col-span-4">
                       <label for="chief-complaint" class="block mb-2 text-sm font-medium text-main_font">Chief Complaint</label>
                       <textarea id="chief-complaint" rows="3" class="resize-none block p-2.5 w-full text-sm text-main_font bg-white rounded-lg border border-gray-300"></textarea>
                    </div>
                    <div class="slg2:col-span-4">
                       <label for="medicine-taken" class="block mb-2 text-sm font-medium text-main_font">Medicine already taken by patient</label>
                       <textarea id="medicine-taken" rows="3" class="resize-none block p-2.5 w-full text-sm text-main_font bg-white rounded-lg border border-gray-300"></textarea>
                    </div>
                    <div class="slg2:col-span-4">
                       <label for="management-done" class="block mb-2 text-sm font-medium text-main_font">Management Done</label>
                       <textarea id="management-done" rows="3" class="resize-none block p-2.5 w-full text-sm text-main_font bg-white rounded-lg border border-gray-300"></textarea>
                    </div>

                </form>
            </div>
            
            <div class="flex items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-4">
                <button id="cancel-referral-btn" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancel</button>
                <div class="flex items-center gap-3">
                    <button id="print-referral-btn" type="button" class="text-white bg-maingreen hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full sm:w-auto">Print Referral</button>

                </div>
            </div>

        </div>
    </div>
</div>