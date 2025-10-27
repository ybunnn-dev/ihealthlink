<div id="edit-resident-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-8 max-w-full">
            <div class="flex flex-col items-center justify-center rounded-t mb-3px-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Edit Resident
                </h3>
                <p class="text-sm text-normal_font -mt-1">Update resident details below</p>
            </div>
            <div class="p-4 md:p-5 space-y-4 h-[70vh] overflow-y-auto w-full">
                   <div class="grid grid-cols-1 slg:grid-cols-4 col-span-1 gap-4 mb-4">
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="residentFirstName" class="text-sm font-medium text-main_font">FIRST NAME<span class="text-red-500 ml-1">*</span></label>
                            <input type="text" id="residentFirstName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="residentLastName" class="text-sm font-medium text-main_font">LAST NAME<span class="text-red-500 ml-1">*</span></label>
                            <input type="text" id="residentLastName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="residentMiddleName" class="text-sm font-medium text-main_font">MIDDLE NAME<span class="text-red-500 ml-1">*</span></label>
                            <input type="text" id="residentMiddleName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                        <div class="flex flex-col col-span-1 relative gap-1">
                            <label for="suffix" class="text-sm font-medium text-main_font">SUFFIX</label>
                            <select id="suffix" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="" selected>Select</option>
                                <option value="Jr.">Jr.</option>
                                <option value="Sr.">Sr.</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 slg:grid-cols-4 col-span-1 gap-4 mb-4">
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="residentContactNo" class="text-sm font-medium text-main_font">CONTACT NO.<span class="text-red-500 ml-1">*</span></label>
                            <input type="text" id="residentContactNo" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                        <div class="flex flex-col col-span-1 relative gap-1">
                            <label for="residentSex" class="text-sm font-medium text-main_font">SEX<span class="text-red-500 ml-1">*</span></label>
                             <select id="residentSex" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="" selected>Select Sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="flex flex-col col-span-1 gap-1">
                            <label for="residentBirthdate" class="text-sm text-main_font font-medium">BIRTHDATE<span class="text-red-500 ml-1">*</span></label>
                            <input type="date" id="residentBirthdate" class="border border-gray-300 text-gray-700 rounded-lg p-2 w-full">
                        </div>
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="residentAge" class="text-sm font-medium text-main_font">AGE</label>
                            <input type="text" id="residentAge" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100" disabled>
                        </div>
                        
                    </div>
                   
                    <div class="grid grid-cols-1 slg:grid-cols-4 col-span-1 gap-4 mb-4">
                        <div class="flex flex-col col-span-1 relative gap-1">
                            <label for="residentStatus" class="text-sm font-medium text-main_font">STATUS<span class="text-red-500 ml-1">*</span></label>
                            <select id="residentStatus" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="active" selected>Active</option>
                                <option value="deceased">Deceased</option>
                                <option value="moved">Moved</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 gap-1 relative col-span-1 slg:col-span-3">
                            <label for="completeAddress" class="text-sm font-medium text-main_font">COMPLETE ADDRESS</label>
                            <input type="text" id="completeAddress" disabled class="border bg-gray-100 border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 slg:grid-cols-3 col-span-1 gap-4 mb-4">
                        <div class="flex flex-col col-span-1 relative">
                            <label for="civilStatus" class="text-sm font-medium text-main_font">CIVIL STATUS<span class="text-red-500 ml-1">*</span></label>
                            <select id="civilStatus" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="" selected>Select Civil Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Separated">Separated</option>
                            </select>
                        </div>
                        <div class="flex flex-col col-span-1 relative">
                            <label for="religion" class="text-sm font-medium text-main_font">RELIGION<span class="text-red-500 ml-1">*</span></label>
                            <select id="religion" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="" selected>Select Religion</option>
                                <option value="Roman Catholic">Roman Catholic</option>
                                <option value="Protestant">Protestant</option>
                                <option value="Islam">Islam</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="flex flex-col col-span-1 relative">
                            <label for="ethnicity" class="text-sm font-medium text-main_font">ETHNICITY<span class="text-red-500 ml-1">*</span></label>
                            <select id="ethnicity" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="" selected>Select Ethnicity</option>
                                <option value="Tagalog">Tagalog</option>
                                <option value="Cebuano">Cebuano</option>
                                <option value="Ilocano">Ilocano</option>
                                <option value="Hiligaynon/Ilonggo">Hiligaynon/Ilonggo</option>
                                <option value="Bicolano">Bicolano</option>
                                <option value="Waray">Waray</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                    </div>

                    <div class="grid grid-cols-1 slg:grid-cols-3 col-span-1 gap-4 mb-4">
                        <div class="flex flex-col col-span-1 relative">
                            <label for="educationAttainment" class="text-sm font-medium text-main_font">
                                EDUCATIONAL ATTAINMENT<span class="text-red-500 ml-1">*</span>
                            </label>
                            <select id="educationAttainment" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="" selected>Select Attainment</option>
                                <option value="Early Childhood Education">Early Childhood Education</option>
                                <option value="Primary Education">Primary Education</option>
                                <option value="Lower Secondary Education">Lower Secondary Education</option>
                                <option value="Upper Secondary Education">Upper Secondary Education</option>
                                <option value="Bachelor Level Education or Equivalent">Bachelor Level Education or Equivalent</option>
                                <option value="Master Level Education or Equivalent">Master Level Education or Equivalent</option>
                                <option value="Doctoral Level Education or Equivalent">Doctoral Level Education or Equivalent</option>
                            </select>
                        </div>

                        <div class="flex flex-col col-span-1 relative">
                            <label for="employmentStatus" class="text-sm font-medium text-main_font">EMPLOYMENT STATUS<span class="text-red-500 ml-1">*</span></label>
                            <select id="employmentStatus" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="" selected>Select Status</option>
                                <option value="Employed">Employed</option>
                                <option value="Unemployed">Unemployed</option>
                                <option value="Self-Employed">Self-Employed</option>
                                <option value="Retired">Retired</option>
                                <option value="Student">Student</option>
                                <option value="Overseas Filipino Worker">Overseas Filipino Worker</option>
                            </select>
                        </div>
                        <div class="flex flex-col col-span-1 relative">
                            <label for="pwdStatus" class="text-sm font-medium text-main_font">PWD<span class="text-red-500 ml-1">*</span></label>
                             <select id="pwdStatus" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="" selected>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="pwdIdInput" class="text-sm font-medium text-main_font">PWD ID</label>
                            <input type="text" id="pwdIdInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                        <div class="flex flex-col col-span-1 relative">
                            <label for="indigenousStatus" class="text-sm font-medium text-main_font">INDIGENOUS<span class="text-red-500 ml-1">*</span></label>
                             <select id="indigenousStatus" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="" selected>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="flex flex-col col-span-1 relative">
                            <label for="soloParentStatus" class="text-sm font-medium text-main_font">SOLO PARENT<span class="text-red-500 ml-1">*</span></label>
                             <select id="soloParentStatus" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="" selected>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                         <div class="flex flex-col col-span-1 relative">
                            <label for="philhealthStatus" class="text-sm font-medium text-main_font">PHILHEALTH<span class="text-red-500 ml-1">*</span></label>
                             <select id="philhealthStatus" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                <option value="" selected>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="philHealthNo" class="text-sm font-medium text-main_font">PHILHEALTH NO.</label>
                            <input type="text" id="philHealthNo" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                        <div class="grid grid-cols-1 gap-1 relative col-span-1">
                            <label for="emergencyContactNo" class="text-sm font-medium text-main_font">EMERGENCY NO.</label>
                            <input type="text" id="emergencyContactNo" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                    </div>
            </div>

        <div class="flex flex-col slg:flex-row items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-10">
    
            <div class="flex w-full slg:w-auto">
                <button id="cancel-button-edit-resident" data-modal-hide="edit-resident-modal" type="button" class="w-full slg:w-auto py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
            </div>

            <div class="flex w-full slg:w-auto">
                <button id="update-resident-button" disabled type="button" class="w-full slg:w-[10rem] disabled:opacity-50 text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save Changes</button>
            </div>

        </div>

        </div>
    </div>
</div>
@include('components.modals.resident.edit-resident-confirmation')