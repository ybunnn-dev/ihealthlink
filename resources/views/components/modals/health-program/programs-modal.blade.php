<div id="switchProgramModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-xl shadow-lg w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0">
                <h3 class="text-xl md:text-2xl font-semibold text-main_font text-center">Switch Program</h3>
                <p class="text-sm text-normal_font text-center mt-1">To continue, please select the health program you wish to transfer to.</p>
            </div>
            <div class="p-6 flex flex-col gap-4 flex-grow min-h-0">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 shrink-0">
                    <div class="md:col-span-2">
                        <label for="default-search" class="block mb-2 text-sm font-medium text-main_font">Search for residents</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="default-search"
                                class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search..." />
                        </div>
                    </div> 
                    <div>
                        <label for="programTypeSelect" class="block mb-2 text-sm font-medium text-main_font">Program Type</label>
                        <select id="programTypeSelect"
                            class="block w-full text-main_font bg-[#F7F7F7] border border-gray-300 rounded-lg text-sm p-2.5 focus:ring-blue-500 focus:border-blue-500">
                            <option selected>Select a type</option>
                            <option value="philpen_tcl">Philpen</option>
                            <option value="child_healthcare_tcl">Child Healthcare</option>
                            <option value="vaccination_drive">Vaccination Drive</option>
                            <option value="senior_citizen">Senior Citizen</option>
                            <option value="maternal_health_tcl">Maternal Healthcare</option>
                            <option value="general_consultation">General Consultation</option>
                        </select>
                    </div>
                </div>
                <div id="programs-section" class="flex-grow overflow-y-auto bg-bg_col rounded-md scrollbar-thin border border-dashed border-gray-400 p-3">
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Dynamic Content Goes Here -->
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row items-center justify-end border-t border-gray-200 p-6 shrink-0 gap-3">
                <button type="button" id="close-change-program"
                    class="w-full sm:w-auto py-2.5 px-5 text-sm font-semibold text-mainblue border border-mainblue rounded-lg hover:bg-gray-50 transition-colors focus:ring-4 focus:ring-gray-100">
                    Close
                </button>
                <button type="button" id="change-program-btn"
                    class="w-full sm:w-auto py-2.5 px-5 text-sm font-semibold text-white bg-mainblue rounded-lg hover:bg-blue-700 transition-colors focus:ring-4 focus:ring-blue-300 shadow-sm">
                    Change Program
                </button>
            </div>

        </div> 
    </div> 
</div>
@include('components.modals.health-program.program-confirmation')