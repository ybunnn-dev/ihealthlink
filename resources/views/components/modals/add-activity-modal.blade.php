<!-- Main modal -->
<div id="add-activity-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 max-w-full">
            <!-- Modal header -->
            <div class="flex  flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Add Activity
                </h3>
                <p class="text-sm text-normal_font">Please enter activity details to proceed.</p>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div class="grid grid-cols-1 gap-3">
                    <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                        <label for="enterActivity" class="text-sm font-medium text-main_font">ACTIVITY</label>
                        <input type="text" id="enterActivity" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                    </div>
                    <div class="grid grid-cols-1 slg:grid-cols-2 gap-3">
                        <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                            <label for="expiryDate" class="text-sm font-medium text-main_font">DATE</label>
                            <div class="relative max-w-sm w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input datepicker type="text" id="expiryDate" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 pl-10 block w-full" placeholder="Select date">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                            <label for="time" class="block text-sm font-medium text-main_font">SELECT TIME</label>
                            <div class="relative max-w-sm w-full">
                                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <input type="time" id="time" class="bg-white border leading-none border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pl-4" min="09:00" max="18:00" value="00:00" required />
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                        <label for="enterVenue" class="text-sm font-medium text-main_font">VENUE</label>
                        <input type="text" id="enterVenue" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                    </div>
                    <div class="grid grid-cols-1 slg:grid-cols-2 gap-3">
                        <div class="flex flex-col col-span-1 relative">
                            <label for="healthProgramDropdownButton" class="text-sm font-medium text-main_font">HEALTH PROGRAM</label>
                            <button id="healthProgramDropdownButton" data-dropdown-toggle="healthProgramDropdownMenu"
                                class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                                type="button">
                                Select Program
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="healthProgramDropdownMenu"
                                class="z-10 hidden bg-f7 divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="healthProgramDropdownButton">
                                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Immunization</button></li>
                                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Family Planning</button></li>
                                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Maternal & Child Care</button></li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex flex-col col-span-1 relative">
                            <label for="bhwDropdownButton" class="block text-sm font-medium text-main_font">ASSIGNED BHW</label>
                            <button id="bhwDropdownButton" data-dropdown-toggle="bhwDropdownMenu"
                                class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                                type="button">
                                Select BHW
                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="bhwDropdownMenu"
                                class="z-10 hidden bg-f7 divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="bhwDropdownButton">
                                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Maria Santos</button></li>
                                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Juan Dela Cruz</button></li>
                                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Nora Aunor</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 justify-end pt-6 px-6">
                <button data-modal-hide="add-activity-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                <button id="proceed-add-household" type="button" class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Household</button>
            </div>
        </div>
    </div>
</div>