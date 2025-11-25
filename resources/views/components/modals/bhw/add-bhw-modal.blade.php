<div id="add-bhw-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-normal_font w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-100 shrink-0">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font text-center">
                    Add BHW
                </h3>
                <p class="text-sm text-gray-500 text-center mt-1">Please enter the Barangay Health Worker's details.</p>
            </div>

            <div class="p-6 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 pb-24">
                <form id="addBhwForm" class="space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label for="bhwFirstName" class="block mb-2 text-sm font-medium text-main_font">First Name</label>
                            <input type="text" id="bhwFirstName" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="flex flex-col">
                            <label for="bhwLastName" class="block mb-2 text-sm font-medium text-main_font">Last Name</label>
                            <input type="text" id="bhwLastName" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex flex-col md:col-span-2">
                            <label for="bhwMiddleName" class="block mb-2 text-sm font-medium text-main_font">Middle Name</label>
                            <input type="text" id="bhwMiddleName" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="flex flex-col relative md:col-span-1">
                            <label for="suffixDropdownButton" class="block mb-2 text-sm font-medium text-main_font">Suffix</label>
                            <button id="suffixDropdownButton" data-dropdown-toggle="suffixDropdownMenu" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 flex justify-between items-center" type="button">
                                <span class="truncate">Select</span> 
                                <svg class="w-2.5 h-2.5 ms-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="suffixDropdownMenu" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="suffixDropdownButton">
                                    <li data-value=""><a href="#" class="block px-4 py-2 hover:bg-gray-100">None</a></li>
                                    <li data-value="Jr."><a href="#" class="block px-4 py-2 hover:bg-gray-100">Jr.</a></li>
                                    <li data-value="Sr."><a href="#" class="block px-4 py-2 hover:bg-gray-100">Sr.</a></li>
                                    <li data-value="III"><a href="#" class="block px-4 py-2 hover:bg-gray-100">III</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        
                        <div class="col-span-2 md:col-span-1 flex flex-col">
                            <label for="bhwBirthdate" class="block mb-2 text-sm font-medium text-main_font">Birthdate</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input datepicker id="bhwBirthdate" type="text" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select">
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label for="bhwAge" class="block mb-2 text-sm font-medium text-main_font">Age</label>
                            <input type="text" id="bhwAge" class="bg-gray-200 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" readonly>
                        </div>

                        <div class="flex flex-col relative">
                            <label for="sexDropdownButton" class="block mb-2 text-sm font-medium text-main_font">Sex</label>
                            <button id="sexDropdownButton" data-dropdown-toggle="sexDropdownMenu" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 flex justify-between items-center" type="button">
                                <span class="truncate">Select</span> 
                                <svg class="w-2.5 h-2.5 ms-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="sexDropdownMenu" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700">
                                    <li data-value="Male"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Male</a></li>
                                    <li data-value="Female"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Female</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex flex-col relative">
                            <label for="privilegeDropdownButton" class="block mb-2 text-sm font-medium text-main_font">Privilege</label>
                            <button id="privilegeDropdownButton" data-dropdown-toggle="privilegeDropdownMenu" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 flex justify-between items-center" type="button">
                                <span class="truncate">Select</span> 
                                <svg class="w-2.5 h-2.5 ms-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="privilegeDropdownMenu" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700">
                                    <li data-value="3"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Regular</a></li>
                                    <li data-value="4"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Web Access</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col relative">
                            <label for="civilStatusDropdownButton" class="block mb-2 text-sm font-medium text-main_font">Civil Status</label>
                            <button id="civilStatusDropdownButton" data-dropdown-toggle="civilStatusMenu" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 flex justify-between items-center" type="button">
                                <span class="truncate">Select Status</span> 
                                <svg class="w-2.5 h-2.5 ms-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="civilStatusMenu" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700">
                                    <li data-value="Single"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Single</a></li>
                                    <li data-value="Married"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Married</a></li>
                                    <li data-value="Widowed"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Widowed</a></li>
                                    <li data-value="Separated"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Separated</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex flex-col relative">
                            <label for="religionDropdownButton" class="block mb-2 text-sm font-medium text-main_font">Religion</label>
                            <button id="religionDropdownButton" data-dropdown-toggle="religionMenu" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 flex justify-between items-center" type="button">
                                <span class="truncate">Select Religion</span> 
                                <svg class="w-2.5 h-2.5 ms-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="religionMenu" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700">
                                    <li data-value="Roman Catholic"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Roman Catholic</a></li>
                                    <li data-value="Iglesia ni Cristo"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Iglesia ni Cristo</a></li>
                                    <li data-value="Islam"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Islam</a></li>
                                    <li data-value="Others"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Others</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label for="bhwEmail" class="block mb-2 text-sm font-medium text-main_font">Email Address</label>
                            <input type="email" id="bhwEmail" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="flex flex-col">
                            <label for="bhwContactNo" class="block mb-2 text-sm font-medium text-main_font">Contact No.</label>
                            <input type="tel" id="bhwContactNo" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b gap-3 p-6 shrink-0 bg-white">
                <button id="addBhwCloseButton" type="button" data-modal-hide="add-bhw-modal" 
                    class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-colors">
                    Close
                </button>
                <button id="addBhwSubmitButton" type="submit" form="addBhwForm" 
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 disabled:bg-gray-400 disabled:cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors" disabled>
                    Add BHW
                </button>
            </div>

        </div>
    </div>
</div>
@include('components.modals.bhw.add-bhw-confirmation')