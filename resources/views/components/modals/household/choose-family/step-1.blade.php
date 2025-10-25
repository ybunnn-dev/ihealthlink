<div id="step-1" 
     class="modal-step [grid-area:1/1] w-full transition-transform duration-500 ease-in-out" 
     data-step="1">
    <div class="flex flex-col items-center justify-center rounded-t mb-6">
        <h3 class="text-xl font-semibold text-main_font">
            Choose Family
        </h3>
        <p class="text-sm text-normal_font">Please select the family this resident belongs to.</p>
    </div>

    <div class="p-4 md:p-5 space-y-4 h-[60vh] flex flex-col">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="md:col-span-2">
                <label for="family-search" class="sr-only">Search for family</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="family-search" class="block w-full p-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search by ID or Head...">
                </div>
            </div>
            <div>
                <select id="purokFilterSelect" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 w-full text-sm">
                    <option selected value="">All Puroks</option>
                    <option value="Purok 1">Purok 1</option>
                    <option value="Purok 2">Purok 2</option>
                    <option value="Purok 3">Purok 3</option>
                </select>
            </div>
        </div>

        <div id="familyCardContainer" class="space-y-2 flex-grow overflow-y-auto border rounded-lg p-3">
            
            <label for="family-radio-1" class="flex items-center p-3 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 has-[:checked]:border-blue-500 has-[:checked]:ring-2 has-[:checked]:ring-blue-200">
                <input id="family-radio-1" type="radio" value="FAM-001" name="family-selection" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                <div class="flex justify-between w-full ml-4">
                    <div>
                        <p class="font-semibold text-main_font">Juan Dela Cruz</p>
                        <p class="text-xs text-gray-500">
                            <span>ID: FAM-001</span>
                            <span class="mx-1.5">&middot;</span>
                            <span>Purok 1</span>
                        </p>
                    </div>
                    <div class="flex items-center text-xs text-gray-600">
                        <span class="bg-gray-200 px-2 py-1 rounded-full">5 Members</span>
                    </div>
                </div>
            </label>

            <label for="family-radio-2" class="flex items-center p-3 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 has-[:checked]:border-blue-500 has-[:checked]:ring-2 has-[:checked]:ring-blue-200">
                <input id="family-radio-2" type="radio" value="FAM-002" name="family-selection" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                <div class="flex justify-between w-full ml-4">
                    <div>
                        <p class="font-semibold text-main_font">Maria Santos</p>
                        <p class="text-xs text-gray-500">
                            <span>ID: FAM-002</span>
                            <span class="mx-1.5">&middot;</span>
                            <span>Purok 2</span>
                        </p>
                    </div>
                    <div class="flex items-center text-xs text-gray-600">
                        <span class="bg-gray-200 px-2 py-1 rounded-full">3 Members</span>
                    </div>
                </div>
            </label>

            <label for="family-radio-3" class="flex items-center p-3 w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 has-[:checked]:border-blue-500 has-[:checked]:ring-2 has-[:checked]:ring-blue-200">
                <input id="family-radio-3" type="radio" value="FAM-003" name="family-selection" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                <div class="flex justify-between w-full ml-4">
                    <div>
                        <p class="font-semibold text-main_font">Pedro Penduko</p>
                        <p class="text-xs text-gray-500">
                            <span>ID: FAM-003</span>
                            <span class="mx-1.5">&middot;</span>
                            <span>Purok 1</span>
                        </p>
                    </div>
                    <div class="flex items-center text-xs text-gray-600">
                        <span class="bg-gray-200 px-2 py-1 rounded-full">8 Members</span>
                    </div>
                </div>
            </label>

        </div>
    </div>

    <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
        <button id="cancelChooseFamily" data-modal-hide="chooseFamilyModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Close</button>
        <button id="confirmChooseFamilyBtn" disabled type="button" class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center ms-3 disabled:opacity-50">Next</button>
    </div>
</div>
