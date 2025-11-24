<div class="px-4 md:px-8 bg-white rounded-lg">
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-4 mb-4">
        
        <div class="col-span-1 sm:col-span-2 lg:col-span-2">
            <label for="residentFirstName" class="block mb-1 text-sm font-medium text-main_font">FIRST NAME</label>
            <input type="text" id="residentFirstName" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-gray-100 cursor-not-allowed text-sm" disabled>
        </div>

        <div class="col-span-1 sm:col-span-2 lg:col-span-2">
            <label for="residentLastName" class="block mb-1 text-sm font-medium text-main_font">LAST NAME</label>
            <input type="text" id="residentLastName" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-gray-100 cursor-not-allowed text-sm" disabled>
        </div>

        <div class="col-span-1 sm:col-span-2 lg:col-span-2">
            <label for="residentMiddleName" class="block mb-1 text-sm font-medium text-main_font">MIDDLE NAME</label>
            <input type="text" id="residentMiddleName" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-gray-100 cursor-not-allowed text-sm" disabled>
        </div>

        <div class="col-span-1 sm:col-span-1 lg:col-span-1 relative">
            <label for="suffixDropdown" class="block mb-1 text-sm font-medium text-main_font">SUFFIX</label>
            <button id="suffixDropdown" data-dropdown-toggle="suffixDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-sm p-2.5 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                
            </button>
            <div id="suffixDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="suffixDropdown"></ul>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-4 mb-4">
        
        <div class="col-span-1 sm:col-span-2 lg:col-span-2">
            <label for="residentContactNo" class="block mb-1 text-sm font-medium text-main_font">CONTACT NO.</label>
            <input type="text" id="residentContactNo" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-gray-100 cursor-not-allowed text-sm" disabled>
        </div>

        <div class="col-span-1 sm:col-span-1 lg:col-span-2 relative">
            <label for="residentSexDropdown" class="block mb-1 text-sm font-medium text-main_font">SEX</label>
            <button id="residentSexDropdown" data-dropdown-toggle="residentSexDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-sm p-2.5 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                <span class="truncate">Select Sex</span>
                <svg class="w-2.5 h-2.5 ms-3 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="residentSexDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                 <ul class="py-2 text-sm text-gray-700" aria-labelledby="residentSexDropdown"></ul>
            </div>
        </div>

        <div class="col-span-1 sm:col-span-1 lg:col-span-2">
            <label for="residentBirthdate" class="block mb-1 text-sm text-main_font font-medium">BIRTHDATE</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input datepicker id="residentBirthdate" type="text" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 cursor-not-allowed" placeholder="Select date" disabled>
            </div>
        </div>

        <div class="col-span-1 sm:col-span-1 lg:col-span-1">
            <label for="residentAge" class="block mb-1 text-sm font-medium text-main_font">AGE</label>
            <input type="text" id="residentAge" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-gray-100 cursor-not-allowed text-sm" disabled>
        </div>
    </div>

    <div class="mb-4">
        <label for="completeAddress" class="block mb-1 text-sm font-medium text-main_font">PATIENT'S ADDRESS</label>
        <input type="text" id="completeAddress" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-gray-100 cursor-not-allowed text-sm" disabled>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        
        <div class="relative">
            <label for="civilStatusDropdown" class="block mb-1 text-sm font-medium text-main_font">CIVIL STATUS</label>
            <button id="civilStatusDropdown" data-dropdown-toggle="civilStatusDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-sm p-2.5 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                <span class="truncate">Select Status</span>
                <svg class="w-2.5 h-2.5 ms-3 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="civilStatusDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                 <ul class="py-2 text-sm text-gray-700" aria-labelledby="civilStatusDropdown"></ul>
            </div>
        </div>

        <div class="relative">
            <label for="religionDropdown" class="block mb-1 text-sm font-medium text-main_font">RELIGION</label>
            <button id="religionDropdown" data-dropdown-toggle="religionDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-sm p-2.5 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
               
            </button>
            <div id="religionDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                 <ul class="py-2 text-sm text-gray-700" aria-labelledby="religionDropdown"></ul>
            </div>
        </div>

        <div class="relative">
            <label for="ethnicityDropdown" class="block mb-1 text-sm font-medium text-main_font">ETHNICITY</label>
            <button id="ethnicityDropdown" data-dropdown-toggle="ethnicityDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-sm p-2.5 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                
            </button>
            <div id="ethnicityDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                 <ul class="py-2 text-sm text-gray-700 max-h-48 overflow-y-auto" aria-labelledby="ethnicityDropdown"></ul>
            </div>
        </div>

        <div class="relative">
            <label for="employmentStatusDropdown" class="block mb-1 text-sm font-medium text-main_font">EMPLOYMENT STATUS</label>
            <button id="employmentStatusDropdown" data-dropdown-toggle="employmentStatusDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-sm p-2.5 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
              
            </button>
            <div id="employmentStatusDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                 <ul class="py-2 text-sm text-gray-700" aria-labelledby="employmentStatusDropdown"></ul>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        
        <div class="relative">
            <label for="pwdStatusDropdown" class="block mb-1 text-sm font-medium text-main_font">PERSON WITH DISABILITY</label>
            <button id="pwdStatusDropdown" data-dropdown-toggle="pwdStatusDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-sm p-2.5 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                
            </button>
            <div id="pwdStatusDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                 <ul class="py-2 text-sm text-gray-700" aria-labelledby="pwdStatusDropdown"></ul>
            </div>
        </div>

        <div>
            <label for="pwdIdInput" class="block mb-1 text-sm font-medium text-main_font">PWD ID (IF APPLICABLE)</label>
            <input type="text" id="pwdIdInput" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-gray-100 cursor-not-allowed text-sm" disabled>
        </div>

        <div class="relative">
            <label for="indigenousStatusDropdown" class="block mb-1 text-sm font-medium text-main_font">INDIGENOUS PEOPLE</label>
            <button id="indigenousStatusDropdown" data-dropdown-toggle="indigenousStatusDropdownMenu" class="w-full text-gray-400 bg-gray-100 font-medium border border-gray-300 rounded-lg text-sm p-2.5 text-center inline-flex items-center justify-between cursor-not-allowed" type="button" disabled>
                
            </button>
            <div id="indigenousStatusDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                 <ul class="py-2 text-sm text-gray-700" aria-labelledby="indigenousStatusDropdown"></ul>
            </div>
        </div>

        <div>
            <label for="philHealthNo" class="block mb-1 text-sm font-medium text-main_font">PHILHEALTH #</label>
            <input type="text" id="philHealthNo" class="w-full border border-gray-300 text-gray-400 bg-gray-100 rounded-lg p-2.5 text-sm" disabled>
        </div>
    </div>
</div>