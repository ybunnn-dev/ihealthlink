<div id="update-maternity-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-8 transition-transform duration-300 ease-out scale-95">
            <!-- Modal header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Update Maternity Details
                </h3>
                <p class="text-sm text-normal_font -mt-1">Review and update maternity information below</p>
            </div>

            <!-- Modal body -->
            <div class="space-y-4 h-[70vh] overflow-y-auto w-full pr-4 mb-3">
                <form action="#" class="grid grid-cols-1 slg2:grid-cols-3 gap-x-6 gap-y-4">
                    
                    <!-- Basic Information Section -->
                    <div class="slg2:col-span-3 font-semibold text-lg border-b pb-2 mb-2 text-normal_font">Basic Information</div>
                    
                    <div>
                        <label for="date-of-reg" class="block mb-2 text-sm font-medium text-main_font">Date of Registration</label>
                        <input type="date" id="date-of-reg" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label for="family-no" class="block mb-2 text-sm font-medium text-main_font">Family #</label>
                        <input type="text" id="family-no" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label for="resident-name" class="block mb-2 text-sm font-medium text-main_font">Resident Name</label>
                        <input type="text" id="resident-name" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" disabled>
                    </div>
                     <div class="slg2:col-span-2">
                        <label for="address" class="block mb-2 text-sm font-medium text-main_font">Address</label>
                        <input type="text" id="address" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" disabled>
                    </div>
                     <div>
                        <label for="ses" class="block mb-2 text-sm font-medium text-main_font">Social Economic Status</label>
                        <select id="ses" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" disabled>
                            <option selected>Choose status</option>
                            <option value="yes">NHTS</option>
                            <option value="no">Non-NHTS</option>
                        </select>
                    </div>
                     <div>
                        <label for="age" class="block mb-2 text-sm font-medium text-main_font">Age</label>
                        <input type="number" id="age" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label for="lmp" class="block mb-2 text-sm font-medium text-main_font">LMP</label>
                        <input type="date" id="lmp" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label for="g-p" class="block mb-2 text-sm font-medium text-main_font">GRAVIDA-PARA</label>
                        <input type="text" id="g-p" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" disabled>
                    </div>
                    <div>
                        <label for="edc" class="block mb-2 text-sm font-medium text-main_font">EDC</label>
                        <input type="date" id="edc" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed" disabled>
                    </div>

                    <!-- Prenatal Checkups -->
                    <fieldset class="slg2:col-span-3 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Dates of Prenatal Checkups</legend>
                        <div class="grid grid-cols-1 sm:grid-cols-2 slg2:grid-cols-4 gap-4 mt-2">
                             <div>
                                <label for="prenatal-1st" class="block mb-2 text-sm font-medium text-main_font">1st Tri</label>
                                <input type="date" id="prenatal-1st" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                            <div>
                                <label for="prenatal-2nd" class="block mb-2 text-sm font-medium text-main_font">2nd Tri</label>
                                <input type="date" id="prenatal-2nd" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                            <div>
                                <label for="prenatal-3rd-1" class="block mb-2 text-sm font-medium text-main_font">3rd Tri (1)</label>
                                <input type="date" id="prenatal-3rd-1" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                            <div>
                                <label for="prenatal-3rd-2" class="block mb-2 text-sm font-medium text-main_font">3rd Tri (2)</label>
                                <input type="date" id="prenatal-3rd-2" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Health Status Section -->
                    <div class="slg2:col-span-3 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">Health Status & Supplementation</div>

                    <fieldset class="slg2:col-span-3 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Immunization Status</legend>
                        <div class="grid grid-cols-2 sm:grid-cols-3 slg2:grid-cols-5 gap-4 mt-2">
                            <!-- Repeat for TD1 to TD5 -->
                            <div>
                                <label for="td1" class="block mb-2 text-sm font-medium text-main_font">TD1/TT1</label>
                                <input type="date" id="td1" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                            <div>
                                <label for="td2" class="block mb-2 text-sm font-medium text-main_font">TD2/TT2</label>
                                <input type="date" id="td2" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                             <div>
                                <label for="td3" class="block mb-2 text-sm font-medium text-main_font">TD3/TT3</label>
                                <input type="date" id="td3" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                             <div>
                                <label for="td4" class="block mb-2 text-sm font-medium text-main_font">TD4/TT4</label>
                                <input type="date" id="td4" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                             <div>
                                <label for="td5" class="block mb-2 text-sm font-medium text-main_font">TD5/TT5</label>
                                <input type="date" id="td5" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                        </div>
                        <p id="no-tetanus" class="text-red-500 hidden text-xs text-center mt-3">Resident has no anti-tetanus data</p>
                    </fieldset>

                    <fieldset class="slg2:col-span-3 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Micronutrient Supplementation</legend>
                        <div class="grid grid-cols-1 slg2:grid-cols-2 gap-6 mt-2">
                            <!-- Iron Sulfate -->
                            <div class="space-y-4 border-r pr-6">
                                <h4 class="font-medium text-main_font">Iron Sulfate</h4>
                                <!-- 4 visits -->
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="text-sm text-main_font">1st Visit Amount/Date</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="iron-sulfate-amount-1" class="bg-gray-100 text-sm w-1/2 p-2 rounded-lg cursor-not-allowed border-gray-300" disabled><input type="date" id="iron-sulfate-date-1" class="bg-gray-100 border-gray-300 text-sm w-1/2 p-2 rounded-lg cursor-not-allowed text-main_font" disabled>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="text-sm text-main_font">2nd Visit Amount/Date</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="iron-sulfate-amount-2" class="bg-gray-100 text-sm w-1/2 p-2 rounded-lg cursor-not-allowed border-gray-300" disabled><input type="date" id="iron-sulfate-date-2" class="bg-gray-100 border-gray-300 text-sm w-1/2 p-2 rounded-lg cursor-not-allowed text-main_font" disabled>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="text-sm text-main_font">3rd Visit Amount/Date</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="iron-sulfate-amount-3" class="bg-gray-100 text-sm w-1/2 p-2 rounded-lg cursor-not-allowed border-gray-300" disabled><input type="date" id="iron-sulfate-date-3" class="bg-gray-100 border-gray-300 text-sm w-1/2 p-2 rounded-lg cursor-not-allowed text-main_font" disabled>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="text-sm text-main_font">4th Visit Amount/Date</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="iron-sulfate-amount-4" class="bg-gray-100 text-sm w-1/2 p-2 rounded-lg cursor-not-allowed border-gray-300" disabled><input type="date" id="iron-sulfate-date-4" class="bg-gray-100 border-gray-300 text-sm w-1/2 p-2 rounded-lg cursor-not-allowed text-main_font" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- Calcium / Iodine -->
                             <div class="space-y-4">
                                <h4 class="font-medium text-main_font">Calcium Carbonate</h4>
                                <div class="grid grid-cols-2 gap-2 text-main_font">
                                    <label class="text-sm">2nd Visit Amount/Date</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="calcium-carbonate-amount-2" class="border bg-gray-100 border-gray-300 text-sm w-1/2 p-2 rounded-lg" disabled><input type="date" id="calcium-carbonate-date-2" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 rounded-lg text-main_font" disabled>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-main_font">
                                    <label class="text-sm">3rd Visit Amount/Date</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="calcium-carbonate-amount-3" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 rounded-lg" disabled><input type="date" id="calcium-carbonate-date-3" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 text-main_font rounded-lg" disabled>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-main_font">
                                    <label class="text-sm">4th Visit Amount/Date</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="calcium-carbonate-amount-4" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 rounded-lg" disabled><input type="date" id="calcium-carbonate-date-4" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 text-main_font rounded-lg" disabled>
                                    </div>
                                </div>
                                <h4 class="font-medium pt-4 text-main_font">Iodine Capsule</h4>
                                <div class="grid grid-cols-2 gap-2 text-main_font">
                                    <label class="text-sm">1st Visit Amount/Date</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="iodine-capsule-amount-1" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 rounded-lg" disabled><input type="date" id="iodine-capsule-date-1" class="bg-gray-100 border border-gray-300 text-main_font text-sm w-1/2 p-2 rounded-lg" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    
                    <div>
                        <label for="fim-status" class="block mb-2 text-sm font-medium text-main_font">FULLY IMMUNED STATUS</label>
                        <select id="fim-status" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            <option selected>Choose status</option>
                            <option value="fully-immuned">Fully Immuned</option>
                            <option value="partially-immuned">Paritally Immuned</option>
                            <option value="no-data">No Immunization Data</option>
                        </select>
                    </div>

                     <div>
                        <label for="deworming" class="block mb-2 text-sm font-medium text-main_font">Deworming Tablet (Date Given)</label>
                        <input type="date" id="deworming" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                    </div>
                     <div>
                        <label for="bmi" class="block mb-2 text-sm font-medium text-main_font">Nutritional Assessment (BMI)</label>
                        <input type="text" id="bmi" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                    </div>

                    <!-- Screening Section -->
                    <div class="slg2:col-span-3 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">Screening</div>

                    <fieldset class="slg2:col-span-3 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Infectious Disease Surveillance</legend>
                        <div class="grid grid-cols-1 slg2:grid-cols-3 gap-4 mt-2">
                           <!-- Syphilis -->
                           <div>
                                <label class="block mb-2 text-sm font-medium text-main_font">Syphilis Screening</label>
                                <div class="flex gap-2">
                                    <input type="date" id="syphilis-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                    <select id="syphilis-result" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                        <option>Result</option>
                                        <option value="postive">Positive</option>
                                        <option value="negative">Negative</option>
                                    </select>
                                </div>
                           </div>
                           <!-- Hepatitis B -->
                           <div>
                                <label class="block mb-2 text-sm font-medium text-main_font">Hepatitis B Screening</label>
                                <div class="flex gap-2">
                                    <input type="date" id="hepatitis-b-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                    <select id="hepatitis-b-result" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                        <option>Result</option>
                                        <option value="postive">Positive</option>
                                        <option value="negative">Negative</option>
                                    </select>
                                </div>
                           </div>
                           <!-- HIV -->
                           <div>
                                <label class="block mb-2 text-sm font-medium text-main_font">HIV Screening</label>
                                <div class="flex gap-2">
                                    <input type="date" id="hiv-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                    <select id="hiv-result" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                        <option>Result</option>
                                        <option value="postive">Positive</option>
                                        <option value="negative">Negative</option>
                                    </select>
                                </div>
                           </div>
                        </div>
                    </fieldset>
                    
                    <fieldset class="slg2:col-span-3 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Laboratory Screening</legend>
                        <div class="grid grid-cols-1 slg2:grid-cols-2 gap-6 mt-2">
                           <!-- Gestational Diabetes -->
                           <div>
                                <label class="block mb-2 text-sm font-medium text-main_font">Gestational Diabetes</label>
                                <div class="flex gap-2">
                                    <input type="date" id="gestational-diabetes-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                    <select id="gestational-diabetes-result" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                        <option>Result</option>
                                        <option value="postive">Positive</option>
                                        <option value="negative">Negative</option>
                                    </select>
                                </div>
                           </div>
                           <!-- CBC/Hgb&Hct -->
                           <div>
                                <label class="block mb-2 text-sm font-medium text-main_font">CBC/Hgb&Hct Count</label>
                                <div class="flex gap-2">
                                    <input type="date" id="cbc-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                    <select id="cbc-result" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                        <option>Result</option>
                                        <option value="with anemia">With Anemia</option>
                                        <option value="without anemia">Without Anemia</option>
                                    </select>
                                    <select id="cbc-given-iron" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                        <option>Given Iron?</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                           </div>
                        </div>
                    </fieldset>

                    <!-- Outcome Section -->
                    <div class="slg2:col-span-3 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">Pregnancy Outcome</div>
                    <div>
                        <label for="date-terminated" class="block mb-2 text-sm font-medium text-main_font">Date Terminated</label>
                        <input type="date" id="date-terminated" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                    <div>
                        <label for="outcome" class="block mb-2 text-sm font-medium text-main_font">Outcome</label>
                        <select id="outcome" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected>Choose Outcome</option>
                            <option value="Full Term">Full-Term</option>
                            <option value="Pre-Term">Pre-Term</option>
                            <option value="Fatal Death">Fetal Death</option>
                            <option value="Abortion">Abortion</option>
                            <option value="Miscarriage">Miscarriage</option>
                        </select>
                    </div>
                     <div>
                        <label for="sex" class="block mb-2 text-sm font-medium text-main_font">Sex</label>
                        <select id="sex" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected>Choose Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div>
                        <label for="type-of-delivery" class="block mb-2 text-sm font-medium text-main_font">Type of Delivery</label>
                        <select id="type-of-delivery" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected>Choose Type</option>
                            <option>Cesarean Section</option>
                            <option>Vaginal Delivery</option>
                        </select>
                    </div>
                    <div>
                        <label for="birth-weight" class="block mb-2 text-sm font-medium text-main_font">Birth Weight (grams)</label>
                        <input type="number" id="birth-weight" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="e.g., 3400">
                    </div>

                    <!-- Post-Delivery Information -->
                    <div class="slg2:col-span-3 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">Post-Delivery Information</div>

                    <fieldset class="slg2:col-span-3 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Place of Delivery</legend>
                        <div class="grid grid-cols-1 slg2:grid-cols-3 gap-4 mt-2">
                           <div>
                               <label for="health-facility-type" class="block mb-2 text-sm font-medium text-main_font">Health Facility Type</label>
                               <select id="health-facility-type" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                   <option selected>Select Type</option>
                                   <option value="BHS">BHS</option>
                                   <option value="RHU">RHU</option>
                                   <option value="MHC">MHC</option>
                                   <option value="Lying-in">Lying-in</option>
                                   <option value="Hospital">Hospital</option>
                                   <option value="Birthing Homes">Birthing Homes</option>
                                   <option value="DOH Licensed Ambulance">DOH Licensed Ambulance</option>
                                   <option value="Home">Home</option>
                                   <option value="Others">Others</option>
                               </select>
                           </div>
                           <div>
                               <label for="bemmonc-cemonc-capable" class="block mb-2 text-sm font-medium text-main_font">BEmONC/CEmONC Capable</label>
                               <select id="bemmonc-cemonc-capable" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                   <option selected>Select</option>
                                   <option value="yes">Yes</option>
                                   <option value="no">No</option>
                               </select>
                           </div>
                           <div>
                               <label for="facility-ownership" class="block mb-2 text-sm font-medium text-main_font">Ownership</label>
                               <select id="facility-ownership" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                   <option selected>Select</option>
                                   <option value="Public">Public</option>
                                   <option value="Private">Private</option>
                               </select>
                           </div>
                           <div class="slg2:col-span-2">
                               <label for="birth-attendant" class="block mb-2 text-sm font-medium text-main_font">Birth Attendant</label>
                               <select id="birth-attendant" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                                   <option selected>Select Attendant</option>
                                   <option value="Doctor">Doctor</option>
                                   <option value="Nurse">Nurse</option>
                                   <option value="Midwife">Midwife</option>
                                   <option value="Hilot">Hilot</option>
                                   <option value="Others">Others</option>
                               </select>
                           </div>
                           <div class="slg2:col-span-3">
                               <label for="delivery-remarks" class="block mb-2 text-sm font-medium text-main_font">Remarks</label>
                               <textarea id="delivery-remarks" rows="2" class="block p-2.5 w-full text-sm text-main_font bg-white rounded-lg border border-gray-300 resize-none"></textarea>
                           </div>
                        </div>
                    </fieldset>
                    
                    <div class="slg2:col-span-3 grid grid-cols-1 slg2:grid-cols-2 gap-4">
                        <div>
                             <label for="delivery-date" class="block mb-2 text-sm font-medium text-main_font">Date of Delivery</label>
                             <input type="date" id="delivery-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                        </div>
                        <div>
                             <label for="delivery-time" class="block mb-2 text-sm font-medium text-main_font">Time of Delivery</label>
                             <input type="time" id="delivery-time" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                        </div>
                    </div>
                    
                    <fieldset class="slg2:col-span-3 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Post Partum Checkups</legend>
                        <div class="grid grid-cols-1 slg2:grid-cols-2 gap-4 mt-2">
                           <div>
                                <label for="postpartum-checkup-24h" class="block mb-2 text-sm font-medium text-main_font">Within 24 hours (Date)</label>
                                <input type="date" disabled id="postpartum-checkup-24h" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                           </div>
                           <div>
                                <label for="postpartum-checkup-7d" class="block mb-2 text-sm font-medium text-main_font">Within 7 days (Date)</label>
                                <input type="date" id="postpartum-checkup-7d" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg w-full p-2.5">
                           </div>
                        </div>
                    </fieldset>
                    
                    <fieldset class="slg2:col-span-3 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Postpartum Micronutrient Supplementation</legend>
                        <div class="grid grid-cols-1 slg2:grid-cols-2 gap-6 mt-2 text-main_font">
                            <div class="space-y-4">
                                <h4 class="font-medium">Iron with Folic Acid</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="text-sm">1st Month Amount/Date</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="postpartum-iron-amount-1" disabled class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 rounded-lg"><input type="date" disabled id="postpartum-iron-date-1" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 rounded-lg">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="text-sm">2nd Month Amount/Date</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="postpartum-iron-amount-2" disabled class="bg-white border border-gray-300 text-sm w-1/2 p-2 rounded-lg"><input type="date" id="postpartum-iron-date-2" disabled class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 rounded-lg">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="text-sm">3rd Month Amount/Date</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="postpartum-iron-amount-3" disabled class="bg-white border border-gray-300 text-sm w-1/2 p-2 rounded-lg"><input type="date" id="postpartum-iron-date-3" disabled class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 rounded-lg">
                                    </div>
                                </div>
                            </div>
                             <div class="space-y-4">
                                <h4 class="font-medium">Vitamin A</h4>
                                 <div class="grid grid-cols-2 gap-2">
                                    <label class="text-sm">Amount / Date Given</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="postpartum-vitamin-a-amount" disabled class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 rounded-lg"><input type="date" disabled id="postpartum-vitamin-a-date" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2 rounded-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    
                    <div class="slg2:col-span-3">
                       <label for="general-remarks" class="block mb-2 text-sm font-medium text-main_font">General Remarks</label>
                       <textarea id="general-remarks" rows="3" class="resize-none block p-2.5 w-full text-sm text-main_font bg-white rounded-lg border border-gray-300"></textarea>
                    </div>
                </form>
            </div>
            
            <!-- Modal footer -->
          <div class="flex items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-4 mb-3">
            <button id="cancel-update-maternity" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancel</button>

            <div class="flex items-center gap-3">
                <button id="print-maternity-btn" type="button" class="text-white bg-maingreen hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full sm:w-auto">Print Details</button>
                <button id="update-maternity-btn" type="button" class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full sm:w-auto">Update Details</button>
            </div>
        </div>

        </div>
    </div>
</div>
@include('components.modals.health-program.tcl-programs.update-maternity-confirmation');