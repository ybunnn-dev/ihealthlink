<div class="px-8 bg-white rounded-lg">
    <!-- Row 1: Name and Suffix -->
    <div class="grid grid-cols-1 slg:grid-cols-7 col-span-1 gap-4 mb-4">
        <div class="grid grid-cols-1 gap-1 relative col-span-2">
            <label for="residentFirstName" class="text-sm font-medium text-main_font">FIRST NAME</label>
            <input type="text" id="residentFirstName" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100 cursor-not-allowed" disabled>
        </div>
        <div class="grid grid-cols-1 gap-1 relative col-span-2">
            <label for="residentLastName" class="text-sm font-medium text-main_font">LAST NAME</label>
            <input type="text" id="residentLastName" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100 cursor-not-allowed" disabled>
        </div>
        <div class="grid grid-cols-1 gap-1 relative col-span-2">
            <label for="residentMiddleName" class="text-sm font-medium text-main_font">MIDDLE NAME</label>
            <input type="text" id="residentMiddleName" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100 cursor-not-allowed" disabled>
        </div>
        <div class="flex flex-col col-span-1 relative">
            <label for="suffixDropdown" class="text-sm font-medium text-main_font">SUFFIX</label>
            <button id="suffixDropdown" data-dropdown-toggle="suffixDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="suffixDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="suffixDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Jr.">Jr.</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Sr.">Sr.</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="II">II</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="III">III</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="IV">IV</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Select">Select</button></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Row 2: Contact, Sex, Birthdate, Age -->
    <div class="grid grid-cols-1 slg:grid-cols-7 col-span-1 gap-4 mb-4">
        <div class="grid grid-cols-1 gap-1 relative col-span-2">
            <label for="residentContactNo" class="text-sm font-medium text-main_font">CONTACT NO.</label>
            <input type="text" id="residentContactNo" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100 cursor-not-allowed" disabled>
        </div>
        <div class="flex flex-col col-span-2 relative">
            <label for="residentSexDropdown" class="text-sm font-medium text-main_font">SEX</label>
            <button id="residentSexDropdown" data-dropdown-toggle="residentSexDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                Select Sex
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="residentSexDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="residentSexDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Male">Male</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Female">Female</button></li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col col-span-2">
            <label for="residentBirthdate" class="text-sm text-main_font font-medium">BIRTHDATE</label>
            <div class="relative max-w-sm">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input datepicker id="residentBirthdate" type="text" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 cursor-not-allowed" placeholder="Select date" disabled>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-1 relative col-span-1">
            <label for="residentAge" class="text-sm font-medium text-main_font">AGE</label>
            <input type="text" id="residentAge" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100 cursor-not-allowed" disabled>
        </div>
    </div>

    <!-- Row 3: Address -->
    <div class="grid grid-cols-1 col-span-1 gap-4 mb-4">
        <div class="grid grid-cols-1 gap-1 relative col-span-2">
            <label for="completeAddress" class="text-sm font-medium text-main_font">PATIENT'S ADDRESS</label>
            <input type="text" id="completeAddress" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100 cursor-not-allowed" disabled>
        </div>
    </div>

    <!-- Row 4: Civil Status, Religion, Ethnicity, Employment -->
    <div class="grid grid-cols-1 slg:grid-cols-4 col-span-1 gap-4 mb-4">
        <div class="flex flex-col col-span-1 relative">
            <label for="civilStatusDropdown" class="text-sm font-medium text-main_font">CIVIL STATUS</label>
            <button id="civilStatusDropdown" data-dropdown-toggle="civilStatusDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                Select Civil Status
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="civilStatusDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="civilStatusDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Single">Single</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Married">Married</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Widowed">Widowed</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Separated">Separated</button></li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col col-span-1 relative">
            <label for="religionDropdown" class="text-sm font-medium text-main_font">RELIGION</label>
            <button id="religionDropdown" data-dropdown-toggle="religionDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                Select Religion
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="religionDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="religionDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Roman Catholic">Roman Catholic</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Protestant">Protestant</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Islam">Islam</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Other">Other</button></li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col col-span-1 relative">
            <label for="ethnicityDropdown" class="text-sm font-medium text-main_font">ETHNICITY</label>
            <button id="ethnicityDropdown" data-dropdown-toggle="ethnicityDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                Select Ethnicity
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="ethnicityDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700 max-h-48 overflow-y-auto" aria-labelledby="ethnicityDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Tagalog">Tagalog</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Cebuano">Cebuano</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Ilocano">Ilocano</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Hiligaynon/Ilonggo">Hiligaynon/Ilonggo</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Bicolano">Bicolano</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Waray">Waray</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Other">Other</button></li>
                </ul>
            </div>
        </div>
        <div class="flex flex-col col-span-1 relative">
            <label for="employmentStatusDropdown" class="text-sm font-medium text-main_font">EMPLOYMENT STATUS</label>
            <button id="employmentStatusDropdown" data-dropdown-toggle="employmentStatusDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                Select Status
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="employmentStatusDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="employmentStatusDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Employed">Employed</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Unemployed">Unemployed</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Self-Employed">Self-Employed</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Retired">Retired</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Student">Student</button></li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Row 5: PWD, Indigenous, PhilHealth -->
    <div class="grid grid-cols-1 slg:grid-cols-4 col-span-1 gap-4 mb-4">
        <div class="flex flex-col col-span-1 relative">
            <label for="pwdStatusDropdown" class="text-sm font-medium text-main_font">PERSON WITH DISABILITY</label>
            <button id="pwdStatusDropdown" data-dropdown-toggle="pwdStatusDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="pwdStatusDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="pwdStatusDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Yes">Yes</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                </ul>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-1 relative col-span-1">
            <label for="pwdIdInput" class="text-sm font-medium text-main_font">PWD ID (IF APPLICABLE)</label>
            <input type="text" id="pwdIdInput" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100 cursor-not-allowed" disabled>
        </div>
        <div class="flex flex-col col-span-1 relative">
            <label for="indigenousStatusDropdown" class="text-sm font-medium text-main_font">INDIGENOUS PEOPLE</label>
            <button id="indigenousStatusDropdown" data-dropdown-toggle="indigenousStatusDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="indigenousStatusDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="indigenousStatusDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="Yes">Yes</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="No">No</button></li>
                </ul>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-1 relative col-span-1">
            <label for="philHealthNo" class="text-sm font-medium text-main_font">PHILHEALTH #</label>
            <input type="text" id="philHealthNo" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
    </div>
</div>
