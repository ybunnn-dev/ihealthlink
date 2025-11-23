<div id="add-resident-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <!-- 
            Responsive Card Structure:
            1. flex flex-col: Allows header/footer to be fixed while body scrolls.
            2. max-h-[90vh]: Ensures it fits within the viewport.
        -->
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-gray-700 w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <!-- Header (Fixed) -->
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-100 shrink-0">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font">
                    Add Resident
                </h3>
                <p class="text-sm text-normal_font mt-1">Enter resident details to continue</p>
            </div>

            <!-- Body (Scrollable) -->
            <div class="p-6 space-y-6 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                
                <!-- ROW 1: Name Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="col-span-1">
                        <label for="residentFirstName" class="block mb-1 text-sm font-medium text-main_font">FIRST NAME<span class="text-red-500 ml-1">*</span></label>
                        <input type="text" id="residentFirstName" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500" placeholder="First Name">
                    </div>
                    <div class="col-span-1">
                        <label for="residentLastName" class="block mb-1 text-sm font-medium text-main_font">LAST NAME<span class="text-red-500 ml-1">*</span></label>
                        <input type="text" id="residentLastName" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500" placeholder="Last Name">
                    </div>
                    <div class="col-span-1">
                        <label for="residentMiddleName" class="block mb-1 text-sm font-medium text-main_font">MIDDLE NAME<span class="text-red-500 ml-1">*</span></label>
                        <input type="text" id="residentMiddleName" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500" placeholder="Middle Name">
                    </div>
                    <div class="col-span-1">
                        <label for="suffix" class="block mb-1 text-sm font-medium text-main_font">SUFFIX</label>
                        <select id="suffix" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="" selected>Select</option>
                            <option value="Jr.">Jr.</option>
                            <option value="Sr.">Sr.</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                        </select>
                    </div>
                </div>

                <!-- ROW 2: Demographics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="col-span-1">
                        <label for="residentContactNo" class="block mb-1 text-sm font-medium text-main_font">CONTACT NO.<span class="text-red-500 ml-1">*</span></label>
                        <input type="text" id="residentContactNo" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500" placeholder="0912...">
                    </div>
                    <div class="col-span-1">
                        <label for="residentSex" class="block mb-1 text-sm font-medium text-main_font">SEX<span class="text-red-500 ml-1">*</span></label>
                         <select id="residentSex" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="" selected>Select Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label for="residentBirthdate" class="block mb-1 text-sm text-main_font font-medium">BIRTHDATE<span class="text-red-500 ml-1">*</span></label>
                        <input type="date" id="residentBirthdate" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="col-span-1">
                        <label for="residentAge" class="block mb-1 text-sm font-medium text-main_font">AGE</label>
                        <input type="text" id="residentAge" class="w-full border border-gray-300 text-gray-500 rounded-lg p-2.5 bg-gray-100" disabled placeholder="Auto-calculated">
                    </div>
                </div>
               
                <!-- ROW 3: Address & Family -->
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                    <div id="familyIdHolder" class="hidden"></div>
                    
                    <!-- Family Dropdown -->
                    <div class="col-span-1 relative">
                        <label for="familyDropdown" class="block mb-1 text-sm font-medium text-main_font">FAMILY<span class="text-red-500 ml-1">*</span></label>
                        <button id="familyDropdown" class="w-full border text-start border-gray-300 text-gray-700 bg-white rounded-lg p-2.5 flex justify-between items-center focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <span>Choose Family ...</span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div id="familyIdStorage" class="hidden"></div>
                    </div>

                    <!-- Address (Spans 3 cols on desktop) -->
                    <div class="col-span-1 lg:col-span-3">
                        <label for="completeAddress" class="block mb-1 text-sm font-medium text-main_font">COMPLETE ADDRESS</label>
                        <input type="text" id="completeAddress" disabled class="w-full border bg-gray-100 border-gray-300 text-gray-500 rounded-lg p-2.5" placeholder="Auto-filled based on family">
                    </div>
                </div>

                <!-- ROW 4: Social Status -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <label for="civilStatus" class="block mb-1 text-sm font-medium text-main_font">CIVIL STATUS<span class="text-red-500 ml-1">*</span></label>
                        <select id="civilStatus" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="" selected>Select Civil Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label for="religion" class="block mb-1 text-sm font-medium text-main_font">RELIGION<span class="text-red-500 ml-1">*</span></label>
                        <select id="religion" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="" selected>Select Religion</option>
                            <option value="Roman Catholic">Roman Catholic</option>
                            <option value="Protestant">Protestant</option>
                            <option value="Islam">Islam</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label for="ethnicity" class="block mb-1 text-sm font-medium text-main_font">ETHNICITY<span class="text-red-500 ml-1">*</span></label>
                        <select id="ethnicity" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-white focus:ring-blue-500 focus:border-blue-500">
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

                <!-- ROW 5: Education & Employment & Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    
                    <div class="col-span-1">
                        <label for="educationAttainment" class="block mb-1 text-sm font-medium text-main_font">EDUCATIONAL ATTAINMENT<span class="text-red-500 ml-1">*</span></label>
                        <select id="educationAttainment" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-white focus:ring-blue-500 focus:border-blue-500">
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

                    <div class="col-span-1">
                        <label for="employmentStatus" class="block mb-1 text-sm font-medium text-main_font">EMPLOYMENT STATUS<span class="text-red-500 ml-1">*</span></label>
                        <select id="employmentStatus" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="" selected>Select Status</option>
                            <option value="Employed">Employed</option>
                            <option value="Unemployed">Unemployed</option>
                            <option value="Self-Employed">Self-Employed</option>
                            <option value="Retired">Retired</option>
                            <option value="Student">Student</option>
                            <option value="Overseas Filipino Worker">Overseas Filipino Worker</option>
                        </select>
                    </div>

                    <!-- PWD Group -->
                    <div class="col-span-1 grid grid-cols-2 gap-2">
                        <div>
                            <label for="pwdStatus" class="block mb-1 text-sm font-medium text-main_font">PWD<span class="text-red-500 ml-1">*</span></label>
                             <select id="pwdStatus" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="" selected>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div>
                            <label for="pwdIdInput" class="block mb-1 text-sm font-medium text-main_font">PWD ID</label>
                            <input type="text" id="pwdIdInput" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div class="col-span-1">
                        <label for="indigenousStatus" class="block mb-1 text-sm font-medium text-main_font">INDIGENOUS<span class="text-red-500 ml-1">*</span></label>
                         <select id="indigenousStatus" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="" selected>Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label for="soloParentStatus" class="block mb-1 text-sm font-medium text-main_font">SOLO PARENT<span class="text-red-500 ml-1">*</span></label>
                         <select id="soloParentStatus" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-white focus:ring-blue-500 focus:border-blue-500">
                            <option value="" selected>Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <!-- Philhealth Group -->
                     <div class="col-span-1 grid grid-cols-2 gap-2">
                        <div>
                            <label for="philhealthStatus" class="block mb-1 text-sm font-medium text-main_font">PHILHEALTH<span class="text-red-500 ml-1">*</span></label>
                             <select id="philhealthStatus" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-white focus:ring-blue-500 focus:border-blue-500">
                                <option value="" selected>Select</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div>
                            <label for="philHealthNo" class="block mb-1 text-sm font-medium text-main_font">PHILHEALTH NO.</label>
                            <input type="text" id="philHealthNo" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="col-span-1">
                        <label for="emergencyContactNo" class="block mb-1 text-sm font-medium text-main_font">EMERGENCY NO.</label>
                        <input type="text" id="emergencyContactNo" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Footer (Fixed) -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 p-6 shrink-0">
                <button id="cancel-button-add-resident" data-modal-hide="add-resident-modal" type="button" 
                    class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </button>

                <button id="add-resident-button" disabled type="button" 
                    class="w-full sm:w-auto min-w-[9rem] disabled:opacity-50 text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                    Add Resident
                </button>
            </div>

        </div>
    </div>
</div>
@include('components.modals.resident.add-resident-confirmation')
@include('components.modals.resident.choose-family')