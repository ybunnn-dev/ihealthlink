<script>
    // This script passes the available barangay data from your Laravel backend to the frontend.
    window.emptyBarangay = @json($emptyBrgy);
</script>

<div id="add-midwife-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative">
            <div class="bg-white rounded-xl shadow-lg mx-auto px-6 lg:px-12 py-10 flex flex-col">
                <div class="grid grid-rows-[auto_auto_1fr_auto] gap-3 h-full">
                    <div>
                        <h3 class="text-2xl font-semibold text-main_font text-center">Add Midwife</h3>
                        <p class="text-xs text-normal_font text-center mb-3">Please enter Midwife details.</p>
                    </div>
                    <div class="grid grid-cols-1 gap-3 w-full max-w-lg justify-center mx-auto">
                        <div class="grid grid-cols-1 slg:grid-cols-2 col-span-1 gap-4">
                            <div class="flex flex-col col-span-1">
                                <label class="text-sm text-main_font font-medium">FIRST NAME</label>
                                <input type="text" id="midwifeFirstName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                            </div>
                            <div class="flex flex-col col-span-1">
                                <label class="text-sm text-main_font font-medium">LAST NAME</label>
                                <input type="text" id="midwifeLastName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 slg:grid-cols-2 col-span-1 gap-4">
                            <div class="flex flex-col col-span-1">
                                <label class="text-sm text-main_font font-medium">MIDDLE NAME</label>
                                <input type="text" id="midwifeMiddleName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                            </div>
                            <div class="flex flex-col col-span-1 relative">
                                <label for="prefixDropdown" class="text-sm font-medium text-main_font">SUFFIX</label>
                                <button id="prefixDropdown" data-dropdown-toggle="prefixDropdownMenu" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                                    Select Prefix
                                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>
                                </button>
                                <div id="prefixDropdownMenu" class="z-10 hidden bg-f7 divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="prefixDropdown">
                                        <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Jr.</button></li>
                                        <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Sr.</button></li>
                                        <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">I</button></li>
                                        <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">II</button></li>
                                        <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">III</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 slg:grid-cols-2 col-span-1 gap-4">
                            <div class="flex flex-col col-span-1">
                                <label class="text-sm text-main_font font-medium">CONTACT NO.</label>
                                <input type="text" id="contactNo" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                            </div>
                            <div class="flex flex-col col-span-1">
                                <label class="text-sm text-main_font font-medium">EMAIL ADDRESS</label>
                                <input type="email" id="midwifeEmail" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                            </div>
                        </div>
                         <div class="flex flex-col col-span-1 relative">
                            <label for="barangayDropdown" class="text-sm font-medium text-main_font">BARANGAY</label>
                            <button id="barangayDropdown" data-dropdown-toggle="barangayDropdownMenu"
                                class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                                type="button">
                                Select Barangay
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="barangayDropdownMenu"
                                class="z-10 hidden bg-f7 divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="barangayDropdown">
                                    </ul>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 slg:grid-cols-2 col-span-1 gap-4">
                            <div class="flex flex-col col-span-1">
                                <label class="text-sm text-main_font font-medium">BIRTHDATE</label>
                                <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" /></svg>
                                    </div>
                                    <input datepicker id="midwifeBdate" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 slg:grid-cols-3 gap-4">
                                <div class="flex flex-col col-span-1">
                                    <label class="text-sm text-main_font font-medium">AGE</label>
                                    <input type="text" id="midwifeAge" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                                </div>
                                <div class="flex flex-col col-span-2 relative">
                                    <label for="sexDropdown" class="text-sm font-medium text-main_font">SEX</label>
                                    <button id="sexDropdown" data-dropdown-toggle="sexDropdownMenu" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                                        Select Sex
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>
                                    </button>
                                    <div id="sexDropdownMenu" class="z-10 hidden bg-f7 divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="sexDropdown">
                                            <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Male</button></li>
                                            <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Female</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 slg:grid-cols-2 col-span-1 gap-4">
                            <div class="flex flex-col col-span-1 relative">
                                <label for="civilStatusDropdown" class="text-sm font-medium text-main_font">CIVIL STATUS</label>
                                <button id="civilStatusDropdown" data-dropdown-toggle="civilStatusMenu" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                                    Select
                                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>
                                </button>
                                <div id="civilStatusMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="civilStatusDropdown">
                                        <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Single</button></li>
                                        <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Married</button></li>
                                        <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Widowed</button></li>
                                        <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Separated</button></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex flex-col col-span-1 relative">
                                <label for="religionDropdown" class="text-sm font-medium text-main_font">RELIGION</label>
                                <button id="religionDropdown" data-dropdown-toggle="religionMenu" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                                    Select
                                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" /></svg>
                                </button>
                                <div id="religionMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="religionDropdown">
                                         <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Roman Catholic</button></li>
                                         <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Iglesia ni Cristo</button></li>
                                         <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Christian</button></li>
                                         <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Muslim</button></li>
                                         <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Others</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end items-end pt-4">
                        <div class="grid grid-cols-1 slg:grid-cols-5 gap-3 w-full max-w-xs">
                            <button type="button" data-modal-hide="add-midwife-modal" class="bg-transparent font-semibold text-mainblue border border-mainblue px-4 py-2 rounded-lg hover:bg-gray-200 transition col-span-1 slg:col-span-2 w-full">
                                Close
                            </button>
                            <button
                                type="submit"
                                id="addMidwifeSubmitBtn"
                                disabled
                                class="bg-mainblue font-semibold text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition col-span-1 slg:col-span-3 w-full disabled:opacity-50 disabled:cursor-not-allowed">
                                Add Midwife
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.modals.midwife.add-midwife-confirmation')