<div id="create-referral-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700 w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <!-- Header (Fixed) -->
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0 dark:border-gray-600">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font dark:text-white">
                    Create Patient Referral
                </h3>
                <p class="text-sm text-normal_font mt-1 dark:text-gray-400">Fill out the referral details below</p>
            </div>

            <!-- Body (Scrollable) -->
            <div class="p-6 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                <form id="referralForm" action="#" class="space-y-6">
                    
                    <!-- SECTION 1: Referral Information -->
                    <div>
                        <div class="font-semibold text-lg border-b pb-2 text-main_font mb-4 dark:text-white">Referral Information</div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-1 md:col-span-2 lg:col-span-4 bg-blue-50 p-3 rounded-lg text-start border border-blue-100">
                                <p class="text-sm font-medium text-blue-800">Referred to: <span id="referred-to" class="font-bold">Municipal Health Office of Daraga, Albay</span></p>
                            </div>
                            
                            <div class="col-span-1">
                                <label for="referred-date" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Referred Date</label>
                                <input type="date" id="referred-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                            </div>
                            <div class="col-span-1">
                                <label for="referred-time" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Referred Time</label>
                                <input type="time" id="referred-time" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                            </div>
                             <div class="col-span-1">
                                <label for="purokSelect" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Referred From</label>
                                <select id="purokSelect" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <option value="" selected>Select Purok</option>
                                </select>
                            </div>
                            
                            <div class="col-span-1">
                                <label for="referred-from" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Barangay</label>
                                <input type="text" id="referred-from" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white cursor-not-allowed">
                                <span id="formatted-time" hidden style="margin-left: 8px; font-weight: 500;"></span>
                            </div>
                            <div class="col-span-1 md:col-span-2 lg:col-span-4">
                                <label for="referral-needs" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Referral Needs</label>
                                <select id="referral-needs" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <option value="" selected>Choose a reason</option>
                                    <option value="checkup">Check-up</option>
                                    <option value="dental">Dental</option>
                                    <option value="meds">Maintenance Meds</option>
                                    <option value="lab">Laboratory</option>
                                    <option value="hygiene">Total Hygiene Clinic</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: Patient Information -->
                    <div>
                        <div class="font-semibold text-lg border-b pb-2 text-main_font mb-4 mt-2 dark:text-white">Patient Information</div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-1 md:col-span-2">
                                <label for="patient-name" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Name of Patient</label>
                                <input type="text" id="patient-name" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white cursor-not-allowed">
                            </div>
                            <div class="col-span-1">
                                <label for="patient-birthdate" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Birthdate</label>
                                <input type="date" id="patient-birthdate" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white cursor-not-allowed">
                            </div>
                            <div class="col-span-1">
                                <label for="patient-age" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Age</label>
                                <input type="text" id="patient-age" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed dark:bg-gray-600 dark:border-gray-500 dark:text-white" disabled>
                            </div>
                            <div class="col-span-1 md:col-span-2 lg:col-span-4">
                                <label for="patient-address" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Complete Address</label>
                                <input type="text" id="patient-address" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white cursor-not-allowed">
                            </div>
                            <div class="col-span-1">
                                <label for="patient-sex" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Sex</label>
                                <select id="patient-sex" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white cursor-not-allowed">
                                    <option value="" selected>Choose Sex</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                             <div class="col-span-1">
                                <label for="civil-status" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Civil Status</label>
                                <select id="civil-status" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white cursor-not-allowed">
                                    <option value="" selected>Choose Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="widowed">Widowed</option>
                                    <option value="separated">Separated</option>
                                </select>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label for="father-name" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Father's Name</label>
                                <input type="text" id="father-name" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label for="mother-name" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Mother's Name</label>
                                <input type="text" id="mother-name" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: Vitals -->
                    <div>
                        <div class="font-semibold text-lg border-b pb-2 text-main_font mb-4 mt-2 dark:text-white">Vital Signs & Measurements</div>
                        
                        <!-- Use grid-cols-2 on mobile to keep short inputs side-by-side -->
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                            <div class="col-span-1">
                                <label for="referral-height" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Height (cm)</label>
                                <input type="number" id="referral-height" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="160">
                            </div>
                            <div class="col-span-1">
                                <label for="referral-weight" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Weight (kg)</label>
                                <input type="number" id="referral-weight" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="55">
                            </div>
                            <div class="col-span-1">
                                <label for="referral-temperature" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Temp (°C)</label>
                                <input type="number" id="referral-temperature" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="36.5">
                            </div>
                            <div class="col-span-1">
                                <label for="referral-pulse-rate" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Pulse (bpm)</label>
                                <input type="number" id="referral-pulse-rate" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="70">
                            </div>
                            <div class="col-span-1">
                                <label for="referral-resp-rate" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Resp (rpm)</label>
                                <input type="number" id="referral-resp-rate" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="18">
                            </div>
                            <!-- BP Spans 1 col on desktop (if wide enough) or 2 cols on mobile/tablet -->
                            <div class="col-span-2 md:col-span-1 flex gap-2 items-end">
                                <div class="w-1/2">
                                    <label for="referral-bp-systolic" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Sys</label>
                                    <input type="number" id="referral-bp-systolic" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="120">
                                </div>
                                <div class="w-1/2">
                                    <label for="referral-bp-diastolic" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Dia</label>
                                    <input type="number" id="referral-bp-diastolic" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="80">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: Female Patients -->
                    <fieldset class="border border-gray-200 p-4 rounded-lg dark:border-gray-600">
                        <legend class="text-md font-semibold text-main_font px-2 dark:text-white">For Female Patients (18+)</legend>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-1">
                                <label for="is-pregnant" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Is Pregnant?</label>
                                <select id="is-pregnant" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <option value="" selected>Select</option>
                                    <option value="no" >No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                            <div class="col-span-1 sm:col-span-2 lg:col-span-3">
                                <label for="fp-method" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Family Planning Method</label>
                                <input type="text" id="fp-method" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                            </div>
                            <div class="col-span-1">
                                <label for="lmp-date" class="block mb-2 text-sm font-medium text-main_font dark:text-white">LMP</label>
                                <input type="date" id="lmp-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                            </div>
                             <div class="col-span-1">
                                <label for="edd-date" class="block mb-2 text-sm font-medium text-main_font dark:text-white">EDD</label>
                                <input type="date" id="edd-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                            </div>
                             <div class="col-span-1">
                                <label for="gravida" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Gravida</label>
                                <input type="text" id="gravida" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                            </div>
                             <div class="col-span-1">
                                <label for="para" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Para</label>
                                <input type="text" id="para" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                            </div>
                              <div class="col-span-1">
                                <label for="aog" class="block mb-2 text-sm font-medium text-main_font dark:text-white">AOG</label>
                                <input type="text" id="aog" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                            </div>
                        </div>
                    </fieldset>

                    <!-- SECTION 5: Infants -->
                    <fieldset class="border border-gray-200 p-4 rounded-lg dark:border-gray-600">
                        <legend class="text-md font-semibold text-main_font px-2 dark:text-white">For Infants</legend>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-1">
                                <label for="infant-birth-weight" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Birth Weight (kg)</label>
                                <input type="number" id="infant-birth-weight" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="e.g., 3.1">
                            </div>
                        </div>
                    </fieldset>

                    <!-- SECTION 6: Medical Details -->
                    <div>
                        <div class="font-semibold text-lg border-b pb-2 text-main_font mb-4 mt-2 dark:text-white">Medical Details</div>
                        <div class="space-y-4">
                            <div>
                               <label for="chief-complaint" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Chief Complaint</label>
                               <textarea id="chief-complaint" rows="3" class="resize-none block p-2.5 w-full text-sm text-main_font bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:placeholder-gray-400"></textarea>
                            </div>
                            <div>
                               <label for="medicine-taken" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Medicine already taken by patient</label>
                               <textarea id="medicine-taken" rows="3" class="resize-none block p-2.5 w-full text-sm text-main_font bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:placeholder-gray-400"></textarea>
                            </div>
                            <div>
                               <label for="management-done" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Management Done</label>
                               <textarea id="management-done" rows="3" class="resize-none block p-2.5 w-full text-sm text-main_font bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:placeholder-gray-400"></textarea>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="flex flex-col-reverse sm:flex-row items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-4 p-6 shrink-0">
                <button id="cancel-referral-btn" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </button>
                <div class="flex flex-col-reverse sm:flex-row gap-3 w-full sm:w-auto">
                    <button id="print-referral-btn" type="button" 
                        class="w-full sm:w-auto text-white bg-maingreen hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center transition-colors">
                        Print Referral
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@include('components.modals.consultation.create-referral-confirm')