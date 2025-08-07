<div class="grid grid-cols-1 gap-6 items-start">
    <div class="grid grid-cols-1 slg:grid-cols-5 gap-4">
        <div class="flex flex-col col-span-1 relative">
            <label for="tobaccoDropdown" class="text-sm font-medium text-main_font">Tobacco Use</label>
            <button id="tobaccoDropdown" data-dropdown-toggle="tobaccoDropdownMenu"
                class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                type="button">
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <div id="tobaccoDropdownMenu"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="tobaccoDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="1">Yes</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="2">No</button></li>

                </ul>
            </div>
        </div>

         <div class="flex flex-col col-span-1 relative">
            <label for="alcoholDropdown" class="text-sm font-medium text-main_font">Alcohol Intake</label>
            <button id="alcoholDropdown" data-dropdown-toggle="alcoholDropdownMenu"
                class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                type="button">
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <div id="alcoholDropdownMenu"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="alcoholDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="1">Yes</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="2">No</button></li>

                </ul>
            </div>
        </div>

        <div class="flex flex-col col-span-1 relative">
            <label for="alcoholNumDropdown" class="text-sm font-medium text-main_font">No. of Drinks Last Year</label>
            <button id="alcoholNumDropdown" data-dropdown-toggle="alcoholNumDropdownMenu"
                class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                type="button">
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <div id="alcoholNumDropdownMenu"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="alcoholNumDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="1">1-5 times a month</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="2">2-3 times a week</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="2">more than 5 times a week</button></li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col col-span-1 relative">
            <label for="caffieneDropdown" class="text-sm font-medium text-main_font">Caffiene Intake</label>
            <button id="caffieneDropdown" data-dropdown-toggle="caffieneDropdownMenu"
                class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                type="button">
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <div id="caffieneDropdownMenu"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="caffieneDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="1">Yes</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="2">No</button></li>

                </ul>
            </div>
        </div>
        <div class="grid grid-cols-1 relative mb-3">
            <label for="addResPhysAct" class="text-sm font-medium text-main_font col-span-1">Hrs of Activity (Weekly)</label>
            <input type="text" id="addResPhysAct" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
    </div>
    <div class="grid grid-cols-1 slg:grid-cols-5 gap-4">
        <div class="grid grid-cols-1 relative mb-3 col-span-1">
            <label for="addResWeight" class="text-sm font-medium text-main_font">Weight</label>
            <input type="text" id="addResWeight" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
        <div class="grid grid-cols-1 relative mb-3 col-span-1">
            <label for="addResHeight" class="text-sm font-medium text-main_font">Height</label>
            <input type="text" id="addResHeight" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
        <div class="grid grid-cols-1 relative mb-3">
            <label for="addResBMI" class="text-sm font-medium text-main_font col-span-1">BMI</label>
            <input type="text" id="addResBMI" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100" disabled>
        </div>
        <div class="grid grid-cols-1 relative mb-3">
            <label for="addResBMI" class="text-sm font-medium text-main_font col-span-1">BMI</label>
            <input type="text" id="addResBMI" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100" disabled>
        </div>
        <div class="grid grid-cols-1 relative mb-3">
            <label for="addResBMI" class="text-sm font-medium text-main_font col-span-1">BMI</label>
            <input type="text" id="addResBMI" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100" disabled>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-3 col-span-1">
        <div class="flex items-center mb-3">
            <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="default-checkbox" class="ms-2 text-sm font-medium text-normal_font">High Fat and High Salt Food Intake (e.g. processed/fast food such as instant noodles, burgers, fries) Weekly</label>
        </div>
    </div> 

    <div class="grid grid-cols-1 gap-3 col-span-1">
        <div class="flex items-center mb-6">
            <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="default-checkbox" class="ms-2 text-sm font-medium text-normal_font">Street Foods (e.g. isaw, barbecue, live, chicken skin) Weekly</label>
        </div>
    </div>

     <div class="grid grid-cols-1 gap-3 col-span-1">
        <div class="flex items-center mb-6">
            <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="default-checkbox" class="ms-2 text-sm font-medium text-normal_font">High Sugar Foods (e.g. chocolates, cakes, pastries, softdrinks) Weekly</label>
        </div>
    </div>
</div>

