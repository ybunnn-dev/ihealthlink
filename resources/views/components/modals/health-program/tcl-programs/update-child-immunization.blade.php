<div id="update-child-care-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-8">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Child Immunization & Nutrition Details
                </h3>
                <p class="text-sm text-normal_font -mt-1">Review and update child care information below</p>
            </div>

            <div class="space-y-4 h-[70vh] overflow-y-auto w-full pr-4 mb-3">
                <form action="#" class="grid grid-cols-1 slg2:grid-cols-4 gap-x-6 gap-y-4">
                    
                    <div class="slg2:col-span-4 font-semibold text-lg border-b pb-2 mb-2 text-normal_font">Basic Information</div>
                    
                    <div class="slg2:col-span-2">
                        <label for="child-reg-date" class="block mb-2 text-sm font-medium text-main_font">Date of Registration</label>
                        <input type="date" id="child-reg-date" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                     <div class="slg2:col-span-2">
                        <label for="child-birth-date" class="block mb-2 text-sm font-medium text-main_font">Date of Birth</label>
                        <input type="date" id="child-birth-date" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                     <div>
                        <label for="child-family-no" class="block mb-2 text-sm font-medium text-main_font">Family #</label>
                        <input type="text" id="child-family-no" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                     <div>
                        <label for="child-ses" class="block mb-2 text-sm font-medium text-main_font">Social Economic Status</label>
                        <select id="child-ses" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected>Choose status</option>
                            <option value="nhts">NHTS</option>
                            <option value="non-nhts">Non-NHTS</option>
                        </select>
                    </div>
                     <div class="slg2:col-span-2">
                        <label for="mother-full-name" class="block mb-2 text-sm font-medium text-main_font">Complete Name of Mother</label>
                        <input type="text" id="mother-full-name" disabled class="bg-gray-100  border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                     <div class="slg2:col-span-3">
                        <label for="child-full-name" class="block mb-2 text-sm font-medium text-main_font">Full Name of Child</label>
                        <input type="text" id="child-full-name" disabled class="bg-gray-100  border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>
                     <div>
                        <label for="child-sex" class="block mb-2 text-sm font-medium text-main_font">Sex</label>
                        <select id="child-sex" disabled class="bg-gray-100  border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected>Choose Sex</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                  
                    <div class="slg2:col-span-4">
                        <label for="child-address" class="block mb-2 text-sm font-medium text-main_font">Complete Address</label>
                        <input type="text" id="child-address" disabled class="bg-gray-100  border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <fieldset class="slg2:col-span-4 grid grid-cols-1 slg:grid-cols-4 border p-4 rounded-lg mt-4">
                        <legend class="text-md font-semibold text-main_font px-2">Child Protection at Birth</legend>
                        <div class="slg:col-span-2">
                            <label for="mother-tetanus" class="block mb-2 text-sm font-medium text-main_font">Mother's Immunization Status</label>
                            <select id="mother-tetanus" disabled class="bg-gray-100  border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="tt2/td2">TT2/TD2 given a month prior to delivery</option>
                                <option value="tt3/td3-tt5/td5 or tt1/td1-tt5/td5">TT3/TD3 - TT5/TD5 or TT1/TD1 - TT5/TD5</option>
                                <option value="no anti-tetanus data">No Anti-tetanus Data</option>
                            </select>
                        </div>
                    </fieldset>
                    
                    <div class="slg2:col-span-4 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">Newborn (0-28 days old)</div>
                    <div class="slg2:col-span-2">
                        <label for="birth-weight" class="block mb-2 text-sm font-medium text-main_font">Birth Weight (kg)</label>
                        <input type="number" id="birth-weight" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5" placeholder="e.g., 3.1">
                    </div>
                    <div class="slg2:col-span-2">
                        <label for="birth-weight-status" class="block mb-2 text-sm font-medium text-main_font">Birth Weight Status</label>
                        <select id="birth-weight-status" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            <option selected>Select status</option>
                            <option value="low">Low (< 2,500 grams)</option>
                            <option value="normal">Normal (>= 2,500 grams)</option>
                            <option value="unknown">Unknown</option>
                        </select>
                    </div>
                    <div class="slg2:col-span-4">
                        <label for="initiated-breastfeeding" class="block mb-2 text-sm font-medium text-main_font">Initiated Breastfeeding immediately after birth (within 90 mins)</label>
                        <input type="date" id="initiated-breastfeeding" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <fieldset class="slg2:col-span-4 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Immunizations</legend>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="bcg-date" class="block mb-2 text-sm font-medium text-main_font">BCG (Date Given)</label>
                                <input type="date" id="bcg-date" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            </div>
                            <div>
                                <label for="hepa-b-bd-date" class="block mb-2 text-sm font-medium text-main_font">Hepa B - Birth Dose (Date Given)</label>
                                <input type="date" id="hepa-b-bd-date" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            </div>
                        </div>
                    </fieldset>

                    <div class="slg2:col-span-4 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">1-3 Months Old</div>
                     <fieldset class="slg2:col-span-4 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Nutritional Assessment & Supplementation</legend>
                        <div class="grid grid-cols-1 md:grid-cols-2 slg2:grid-cols-3 gap-4">
                             <div>
                                <label for="age-in-months-d" class="block mb-2 text-sm font-medium text-main_font">Age in Months</label>
                                <input type="text" id="age-in-months-d" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                            <div>
                                <label for="length-cm" class="block mb-2 text-sm font-medium text-main_font">Length (cm) / Date Taken</label>
                                <div class="flex gap-2">
                                    <input type="number" id="length-cm" disabled class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg" placeholder="cm">
                                    <input type="date" id="length-date" disabled class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg text-main_font">
                                </div>
                            </div>
                             <div>
                                <label for="weight-kg-d" class="block mb-2 text-sm font-medium text-main_font">Weight (kg) / Date Taken</label>
                                <div class="flex gap-2">
                                    <input type="number" id="weight-kg-d" disabled class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg" placeholder="kg">
                                    <input type="date" id="weight-date-d" disabled class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg text-main_font">
                                </div>
                            </div>
                            <div>
                                <label for="status-d" class="block mb-2 text-sm font-medium text-main_font">Status</label>
                                <select id="status-d" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                                    <option selected>Select status</option>
                                    <option value="stunted">Stunted</option>
                                    <option value="wasted-mam">Wasted-MAM</option>
                                    <option value="wasted-sam">Wasted-SAM</option>
                                    <option value="overweight">Obese/Overweight</option>
                                    <option value="normal">Normal</option>
                                </select>
                            </div>
                        </div>
                         <div class="mt-6">
                             <h4 class="text-sm font-semibold text-main_font mb-2">Low Birth Weight Given Iron</h4>
                             <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                 <div>
                                    <label for="lbw-iron-1mo" class="block mb-2 text-xs font-medium text-main_font">1st Month (Date)</label>
                                    <input type="date" id="lbw-iron-1mo" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                                 </div>
                                 <div>
                                    <label for="lbw-iron-2mo" class="block mb-2 text-xs font-medium text-main_font">2nd Month (Date)</label>
                                    <input type="date" id="lbw-iron-2mo" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                                 </div>
                                 <div>
                                    <label for="lbw-iron-3mo" class="block mb-2 text-xs font-medium text-main_font">3rd Month (Date)</label>
                                    <input type="date" id="lbw-iron-3mo" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                                 </div>
                             </div>
                         </div>
                    </fieldset>
                    
                    <fieldset class="slg2:col-span-4 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Immunizations (1-3 mos)</legend>
                        <div class="grid grid-cols-1 md:grid-cols-2 slg2:grid-cols-4 gap-4">
                            <div class="space-y-2">
                                <label for="dpt-hib-hepb-1" class="block text-sm font-medium text-main_font">DPT-HiB-HepB</label>
                                <input type="date" id="dpt-hib-hepb-1" title="1st Dose (1.5 mos)" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" placeholder="1st dose" disabled>
                                <input type="date" id="dpt-hib-hepb-2" title="2nd Dose (2.5 mos)" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" placeholder="2nd dose" disabled>
                                <input type="date" id="dpt-hib-hepb-3" title="3rd Dose (3.5 mos)" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" placeholder="3rd dose" disabled>
                            </div>

                            <div class="space-y-2">
                                <label for="opv-1" class="block text-sm font-medium text-main_font">OPV</label>
                                <input type="date" id="opv-1" title="1st Dose (1.5 mos)" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" placeholder="1st dose" disabled>
                                <input type="date" id="opv-2" title="2nd Dose (2.5 mos)" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" placeholder="2nd dose" disabled>
                                <input type="date" id="opv-3" title="3rd Dose (3.5 mos)" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" placeholder="3rd dose" disabled>
                            </div>

                            <div class="space-y-2">
                                <label for="pcv-1" class="block text-sm font-medium text-main_font">PCV</label>
                                <input type="date" id="pcv-1" title="1st Dose (1.5 mos)" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" placeholder="1st dose" disabled>
                                <input type="date" id="pcv-2" title="2nd Dose (2.5 mos)" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" placeholder="2nd dose" disabled>
                                <input type="date" id="pcv-3" title="3rd Dose (3.5 mos)" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" placeholder="3rd dose" disabled>
                            </div>

                            <div class="space-y-2">
                                <label for="ipv" class="block text-sm font-medium text-main_font">IPV (3.5 mos)</label>
                                <input type="date" id="ipv" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                        </div>
                    </fieldset>
                    
                     <fieldset class="slg2:col-span-4 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Exclusive Breastfeeding</legend>
                        <div class="grid grid-cols-1 sm:grid-cols-2 slg2:grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-main_font">1.5 Months</label>
                                <div class="flex gap-2">
                                    <select id="ebf_select_1_5_months" class="bg-white border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg">
                                        <option value="">Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                    <input type="date" id="ebf_date_1_5_months" class="bg-white border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg text-main_font">
                                </div>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-main_font">3.5 Months</label>
                                <div class="flex gap-2">
                                    <select id="ebf_select_3_5_months" class="bg-white border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg">
                                        <option value="">Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                    <input type="date" id="ebf_date_3_5_months" class="bg-white border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg text-main_font">
                                </div>
                            </div>
                             <div>
                                <label class="block mb-2 text-sm font-medium text-main_font">2.5 Months</label>
                                <div class="flex gap-2">
                                    <select id="ebf_select_2_5_months" class="bg-white border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg">
                                        <option value="">Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                    <input type="date" id="ebf_date_2_5_months" class="bg-white border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg text-main_font">
                                </div>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-main_font">4-5 Months</label>
                                <div class="flex gap-2">
                                    <select id="ebf_select_4_5_months" class="bg-white border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg">
                                        <option value="">Select</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                    <input type="date" id="ebf_date_4_5_months" class="bg-white border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg text-main_font">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    
                    <div class="slg2:col-span-4 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">6-11 Months Old</div>
                        <fieldset class="slg2:col-span-4 border p-4 rounded-lg">
                            <legend class="text-md font-semibold text-main_font px-2">Nutritional Assessment</legend>
                            <div class="grid grid-cols-1 md:grid-cols-2 slg2:grid-cols-3 gap-4">
                                <div>
                                    <label for="age-in-months-e" class="block mb-2 text-sm font-medium text-main_font">Age in Months</label>
                                    <input type="text" id="age-in-months-e" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                                </div>
                                <div>
                                    <label for="length-cm-e" class="block mb-2 text-sm font-medium text-main_font">Length (cm) / Date Taken</label>
                                    <div class="flex gap-2">
                                        <input type="number" id="length-cm-e" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg cursor-not-allowed" placeholder="cm" disabled>
                                        <input type="date" id="length-date-e" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg text-main_font cursor-not-allowed" disabled>
                                    </div>
                                </div>
                                <div>
                                    <label for="weight-kg-e" class="block mb-2 text-sm font-medium text-main_font">Weight (kg) / Date Taken</label>
                                    <div class="flex gap-2">
                                        <input type="number" id="weight-kg-e" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg cursor-not-allowed" placeholder="kg" disabled>
                                        <input type="date" id="weight-date-e" class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg text-main_font cursor-not-allowed" disabled>
                                    </div>
                                </div>
                                <div>
                                    <label for="status-e" class="block mb-2 text-sm font-medium text-main_font">Status</label>
                                    <select id="status-e" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                                        <option selected>Select status</option>
                                        <option value="stunted">Stunted</option>
                                        <option value="wasted-mam">Wasted-MAM</option>
                                        <option value="wasted-sam">Wasted-SAM</option>
                                        <option value="overweight">Obese/Overweight</option>
                                        <option value="normal">Normal</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                     <div class="slg2:col-span-4 grid grid-cols-1 slg:grid-cols-2 gap-4">
                        <div>
                             <label for="ebf-6mo" class="block mb-2 text-sm font-medium text-main_font">Exclusively Breastfed up to 6 months</label>
                             <div>
                                <select id="ebf-6mo" class="bg-white border text-main_font border-gray-300 text-sm w-full p-2.5 rounded-lg">
                                    <option value="">Select</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="ebf-6mo" class="block mb-2 text-sm font-medium text-main_font">If no, type the date when breasfeeding stopped</label>
                            <input type="date" id="ebf-6mo-date" class="bg-white border border-gray-300 text-sm w-full p-2.5 rounded-lg text-main_font">
                        </div>
                        <div>
                             <label for="comp-feeding" class="block mb-2 text-sm font-medium text-main_font">Intro. of Complementary Feeding (at 6 mos)</label>
                             <div class="flex gap-2">
                                 <select id="comp-feeding" class="bg-white border text-main_font border-gray-300 text-sm w-full p-2.5 rounded-lg">
                                     <option value ="" selected>Choose</option>
                                     <option value="yes-continue-breastfeed">Yes, w/ continuous Breastfeeding</option>
                                     <option value="yes-no-breastfeed">Yes, no longer breastfeeding</option>
                                     <option value="no">No</option>
                                 </select>
                            </div>
                        </div>
                     </div>
                     <fieldset class="slg2:col-span-4 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Supplementation & Immunization</legend>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="vit-a-date" class="block mb-2 text-sm font-medium text-main_font">Vitamin A (Date Given)</label>
                                <input type="date" id="vit-a-date" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            </div>
                            <div>
                                <label for="mnp-date" class="block mb-2 text-sm font-medium text-main_font">MNP (Date Given)</label>
                                <input type="date" id="mnp-date" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            </div>
                            <div>
                                <label for="mmr1-date" class="block mb-2 text-sm font-medium text-main_font">MMR Dose 1 (at 9 mos) (Date Given)</label>
                                <input type="date" id="mmr1-date" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                            </div>
                        </div>
                    </fieldset>

                    <div class="slg2:col-span-4 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">12 Months Old</div>
                    <fieldset class="slg2:col-span-4 border p-4 rounded-lg">
                        <legend class="text-md font-semibold text-main_font px-2">Nutritional Assessment</legend>
                        <div class="grid grid-cols-1 md:grid-cols-2 slg2:grid-cols-3 gap-4">
                             <div>
                                <label for="age-in-months-f" class="block mb-2 text-sm font-medium text-main_font">Age in Months</label>
                                <input type="text" id="age-in-months-f" class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" disabled>
                            </div>
                            <div>
                                <label for="length-cm-f" class="block mb-2 text-sm font-medium text-main_font">Length (cm) / Date Taken</label>
                                <div class="flex gap-2">
                                    <input type="number" id="length-cm-f" disabled class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg" placeholder="cm">
                                    <input type="date" id="length-date-f" disabled class="bg-gray-100 border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg text-main_font">
                                </div>
                            </div>
                            <div>
                                <label for="weight-kg-f" class="block mb-2 text-sm font-medium text-main_font">Weight (kg) / Date Taken</label>
                                <div class="flex gap-2">
                                    <input type="number" id="weight-kg-f" disabled class="bg-gray-100  border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg" placeholder="kg">
                                    <input type="date" id="weight-date-f" disabled class="bg-gray-100  border border-gray-300 text-sm w-1/2 p-2.5 rounded-lg text-main_font">
                                </div>
                            </div>
                            <div>
                                <label for="status-f" class="block mb-2 text-sm font-medium text-main_font">Status</label>
                                <select id="status-f" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                                    <option selected>Select status</option>
                                    <option value="stunted">Stunted</option>
                                    <option value="wasted-mam">Wasted-MAM</option>
                                    <option value="wasted-sam">Wasted-SAM</option>
                                    <option value="overweight">Obese/Overweight</option>
                                    <option value="normal">Normal</option>
                                </select>
                            </div>
                        </div>
                     </fieldset>
                  
                     <div class="slg2:col-span-2 gap-3">
                        <label for="mmr2-date" class="block mb-2 text-sm font-medium text-main_font">MMR Dose 2 (Date Given)</label>
                         <input type="date" id="mmr2-date" disabled class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">

                    </div>
                    <div class="slg2:col-span-2  gap-3">
                         <label for="fic-date" class="block mb-2 text-sm font-medium text-main_font">FIC (Fully Immunized Child) Date</label>
                         <input type="date" id="fic-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="slg2:col-span-4 font-semibold text-lg border-b pb-2 mb-2 text-normal_font mt-4">Final Status & Remarks</div>
                     <div class="slg2:col-span-2">
                         <label for="cic-date" class="block mb-2 text-sm font-medium text-main_font">CIC (Completely Immunized Child) Date</label>
                         <input type="date" id="cic-date" class="bg-white border border-gray-300 text-main_font text-sm rounded-lg block w-full p-2.5">
                    </div>
                     <div class="slg2:col-span-4">
                       <label for="child-remarks" class="block mb-2 text-sm font-medium text-main_font">Remarks</label>
                       <textarea id="child-remarks" rows="3" class="resize-none block p-2.5 w-full text-sm text-main_font bg-white rounded-lg border border-gray-300"></textarea>
                    </div>

                </form>
            </div>
            
            <div class="flex items-center justify-between border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-4 mb-3">
                <button id="cancel-update-child-care" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancel</button>
                <div class="flex items-center gap-3">
                    <button id="print-child-care-btn" type="button" class="text-white bg-maingreen hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full sm:w-auto">Print Details</button>
                    <button id="update-child-care-btn" type="button" class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full sm:w-auto">Update Details</button>
                </div>
            </div>

        </div>
    </div>
</div>
@include('components.modals.health-program.tcl-programs.update-child-confirmation')
@include('components.modals.health-program.tcl-programs.print-child-confirmation')