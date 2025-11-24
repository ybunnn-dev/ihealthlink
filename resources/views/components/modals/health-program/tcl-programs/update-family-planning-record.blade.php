<div id="update-family-planning-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0">
                <h3 class="text-xl font-semibold text-main_font">
                    Update Family Planning Record
                </h3>
            </div>
            
            <div class="flex-grow overflow-y-auto p-6 min-h-0">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    
                    <div class="md:col-span-2">
                        <label for="fp_update_resident_name" class="block mb-2 text-sm font-medium text-main_font">Selected Resident</label>
                        <input type="text" name="fp_update_resident_name" id="fp_update_resident_name" 
                            class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-3 cursor-not-allowed" 
                            placeholder="Resident's full name" disabled readonly>
                    </div>

                    <div>
                        <label for="fp_update_client_type" class="block mb-2 text-sm font-medium text-main_font">Type of Client <span class="text-red-500">*</span></label>
                        <select id="fp_update_client_type" name="fp_update_client_type" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            <option value="">Choose a type</option>
                            <option value="new_acceptor">New Acceptor</option>
                            <option value="current_user">Current User</option>
                            <option value="other_acceptor">Other Acceptor</option>
                            <option value="changing_method">Changing Method</option>
                            <option value="changing_clinic">Changing Clinic</option>
                            <option value="restarter">Restarter</option>
                        </select>
                    </div>

                    <div>
                        <label for="fp_update_source" class="block mb-2 text-sm font-medium text-main_font">Source<span class="text-red-500">*</span></label>
                        <select id="fp_update_source" name="fp_update_source" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            <option value="">Choose a source</option>
                            <option value="public" selected>Public</option>
                            <option value="private">Private</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="fp_update_current_method" class="block mb-2 text-sm font-medium text-main_font">Current Method Used<span class="text-red-500">*</span></label>
                        <select id="fp_update_current_method" name="fp_update_current_method" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            <option value="">Choose a method</option>
                            <option value="btl">Female Sterilization (BTL)</option>
                            <option value="nsv">Male Sterilization (NSV)</option>
                            <option value="condom">Condom</option>
                            <option value="pills_pop">Pills - Progestin-Only Pills (POP)</option>
                            <option value="pills_coc">Pills - Combined Oral Contraceptives (COC)</option>
                            <option value="injection">Injection (DMPA or CIC)</option>
                            <option value="implant">Implant</option>
                            <option value="iud_interval">IUD - Interval</option>
                            <option value="iud_postpartum">IUD - Postpartum</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 border-t border-gray-200 pt-6 mt-2">
                        <div id="dropout_details" class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <div>
                                <label for="fp_dropout_date" class="block mb-2 text-sm font-medium text-main_font">Date of Dropout</label>
                                <input type="date" name="fp_dropout_date" id="fp_dropout_date" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            </div>

                            <div class="md:col-span-2">
                                <label for="fp_dropout_reason" class="block mb-2 text-sm font-medium text-main_font">Reason for Dropping Out</label>
                                <select id="fp_dropout_reason" name="fp_dropout_reason" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                                    <option value="">Choose a reason</option>
                                    <option value="pregnant">Pregnant</option>
                                    <option value="desire_pregnant">Desire to become pregnant</option>
                                    <option value="medical_complications">Medical complications</option>
                                    <option value="fear_side_effects">Fear of side effects</option>
                                    <option value="changed_clinic">Changed clinic</option>
                                    <option value="husband_disapproves">Husband disapproves</option>
                                    <option value="menopause">Menopause</option>
                                    <option value="moved_residence">Moved residence</option>
                                    <option value="failed_supply">Failed to get supply</option>
                                    <option value="change_method">Change method</option>
                                    <option value="hysterectomy">Underwent hysterectomy</option>
                                    <option value="bso">Underwent Bilateral salpingo-oophorectomy</option>
                                    <option value="no_commodity">No FP commodity</option>
                                    <option value="unknown">Unknown</option>
                                    <option value="age_out">Age out of BTL</option>
                                    <option value="menstruation">Mother has menstruation or not amenorrheic within 6 months</option>
                                    <option value="not_breastfeeding">No longer practicing fully exclusive breastfeeding</option>
                                    <option value="baby_over_6_months">Baby is more than six months old</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
             <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 p-6 shrink-0">
                <button id="cancel-update-fp" type="button" class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">Cancel</button>
                <button id="proceed-update-fp" type="button" class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-3 text-center transition-colors">Save Changes</button>
            </div>
        </div>
    </div>
</div>

@include('components.modals.health-program.tcl-programs.update-family-planning-confirmation')