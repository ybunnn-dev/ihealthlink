<script>
    // This script passes the available barangay data from your Laravel backend to the frontend.
    window.emptyBarangay = @json($emptyBrgy);
</script>

<div id="add-midwife-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-normal_font w-full flex flex-col max-h-[90vh]">
            
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-100 shrink-0">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font text-center">
                    Add Midwife
                </h3>
                <p class="text-sm text-gray-500 text-center mt-1">Please enter the Midwife's details.</p>
            </div>

            <div class="p-6 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 pb-24">
                <form id="add-midwife-form" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label for="midwifeFirstName" class="block mb-2 text-sm font-medium text-main_font">First Name</label>
                            <input type="text" id="midwifeFirstName" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="flex flex-col">
                            <label for="midwifeLastName" class="block mb-2 text-sm font-medium text-main_font">Last Name</label>
                            <input type="text" id="midwifeLastName" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex flex-col md:col-span-2">
                            <label for="midwifeMiddleName" class="block mb-2 text-sm font-medium text-main_font">Middle Name</label>
                            <input type="text" id="midwifeMiddleName" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="flex flex-col relative md:col-span-1">
                            <label for="prefixDropdown" class="block mb-2 text-sm font-medium text-main_font">Suffix</label>
                            <button id="prefixDropdown" data-dropdown-toggle="prefixDropdownMenu" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 flex justify-between items-center" type="button">
                                <span class="truncate">Select</span> 
                                <svg class="w-2.5 h-2.5 ms-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="prefixDropdownMenu" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="prefixDropdown">
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Jr.</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Sr.</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">I</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">II</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">III</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                            <label for="midwifeEmail" class="block mb-2 text-sm font-medium text-main_font">Email Address</label>
                            <input type="email" id="midwifeEmail" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <div class="flex flex-col">
                            <label for="contactNo" class="block mb-2 text-sm font-medium text-main_font">Contact No.</label>
                            <input type="text" id="contactNo" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>

                    <div class="flex flex-col relative">
                        <label for="barangayDropdown" class="block mb-2 text-sm font-medium text-main_font">Barangay</label>
                        <button id="barangayDropdown" data-dropdown-toggle="barangayDropdownMenu" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 flex justify-between items-center" type="button">
                            <span class="truncate">Select Barangay</span> 
                            <svg class="w-2.5 h-2.5 ms-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="barangayDropdownMenu" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full max-h-60 overflow-y-auto absolute top-full mt-1">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="barangayDropdown">
                                </ul>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        
                        <div class="flex flex-col">
                            <label for="midwifeBdate" class="block mb-2 text-sm font-medium text-main_font">Birthdate</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input datepicker id="midwifeBdate" type="text" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select">
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label for="midwifeAge" class="block mb-2 text-sm font-medium text-main_font">Age</label>
                            <input type="text" id="midwifeAge" class="bg-gray-200 border border-gray-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" readonly>
                        </div>

                        <div class="flex flex-col relative">
                            <label for="sexDropdown" class="block mb-2 text-sm font-medium text-main_font">Sex</label>
                            <button id="sexDropdown" data-dropdown-toggle="sexDropdownMenu" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 flex justify-between items-center" type="button">
                                <span class="truncate">Select Sex</span> 
                                <svg class="w-2.5 h-2.5 ms-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="sexDropdownMenu" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700">
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Male</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Female</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col relative">
                            <label for="civilStatusDropdown" class="block mb-2 text-sm font-medium text-main_font">Civil Status</label>
                            <button id="civilStatusDropdown" data-dropdown-toggle="civilStatusMenu" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 flex justify-between items-center" type="button">
                                <span class="truncate">Select Status</span> 
                                <svg class="w-2.5 h-2.5 ms-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="civilStatusMenu" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700">
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Single</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Married</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Widowed</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Separated</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex flex-col relative">
                            <label for="religionDropdown" class="block mb-2 text-sm font-medium text-main_font">Religion</label>
                            <button id="religionDropdown" data-dropdown-toggle="religionMenu" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 flex justify-between items-center" type="button">
                                <span class="truncate">Select Religion</span> 
                                <svg class="w-2.5 h-2.5 ms-3 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="religionMenu" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700">
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Roman Catholic</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Iglesia ni Cristo</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Christian</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Muslim</a></li>
                                    <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Others</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 rounded-b gap-3 p-6 shrink-0 bg-white">
                <button type="button" id="close-add-mw"
                    class="w-full sm:w-auto py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-colors">
                    Close
                </button>
                <button type="button" form="add-midwife-form" id="addMidwifeSubmitBtn" disabled
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-800 disabled:bg-gray-400 disabled:cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                    Add Midwife
                </button>
            </div>

        </div>
    </div>
</div>
@include('components.modals.midwife.add-midwife-confirmation')