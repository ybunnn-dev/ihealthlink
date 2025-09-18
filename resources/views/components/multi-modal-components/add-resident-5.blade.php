<div class="grid grid-cols-1 gap-6 items-start">

    <div class="grid grid-cols-1 slg:grid-cols-5 gap-4">
        <div class="flex flex-col col-span-1 relative">
            <label for="tobaccoDropdown" class="text-sm font-medium text-main_font">Tobacco Use</label>
            <button id="tobaccoDropdown" data-dropdown-toggle="tobaccoDropdownMenu" class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="tobaccoDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="tobaccoDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="1">Yes</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="2">No</button></li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col col-span-1 relative">
            <label for="alcoholDropdown" class="text-sm font-medium text-main_font">Alcohol Intake</label>
            <button id="alcoholDropdown" data-dropdown-toggle="alcoholDropdownMenu" class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="alcoholDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="alcoholDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="1">Yes</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="2">No</button></li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col col-span-1 relative">
            <label for="alcoholNumDropdown" class="text-sm font-medium text-main_font">No. of Drinks Last Year</label>
            <button id="alcoholNumDropdown" data-dropdown-toggle="alcoholNumDropdownMenu" class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="alcoholNumDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="alcoholNumDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="1">1-5 times a month</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="2">2-3 times a week</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="3">more than 5 times a week</button></li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col col-span-1 relative">
            <label for="caffeineDropdown" class="text-sm font-medium text-main_font">Caffeine Intake</label>
            <button id="caffeineDropdown" data-dropdown-toggle="caffeineDropdownMenu" class="w-full text-gray-400 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <div id="caffeineDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="caffeineDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="1">Yes</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100" data-value="2">No</button></li>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 relative mb-3">
            <label for="physicalActivityInput" class="text-sm font-medium text-main_font col-span-1">Hrs of Activity (Weekly)</label>
            <input type="text" id="physicalActivityInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
    </div>

    <div class="grid grid-cols-1 slg:grid-cols-5 gap-4">
        <div class="grid grid-cols-1 relative mb-3 col-span-1">
            <label for="weightInput" class="text-sm font-medium text-main_font">Weight</label>
            <input type="text" id="weightInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>

        <div class="grid grid-cols-1 relative mb-3 col-span-1">
            <label for="heightInput" class="text-sm font-medium text-main_font">Height</label>
            <input type="text" id="heightInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>

        <div class="grid grid-cols-1 relative mb-3">
            <label for="bmiInput" class="text-sm font-medium text-main_font col-span-1">BMI</label>
            <input type="text" id="bmiInput" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100" disabled>
        </div>

        <div class="grid grid-cols-1 relative mb-3">
            <label for="waistCircumferenceInput" class="text-sm font-medium text-main_font col-span-1">Waist Circumference</label>
            <input type="text" id="waistCircumferenceInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
        
        <div class="grid grid-cols-1 relative mb-3">
            <label class="text-sm font-medium text-main_font col-span-1">Blood Pressure (mmHg)</label>
            <div class="flex items-center space-x-2">
                <input type="number" id="systolicInput" placeholder="Systolic" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2 text-center">
                <span class="text-gray-500 font-bold">/</span>
                <input type="number" id="diastolicInput" placeholder="Diastolic" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2 text-center">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 col-span-1">
        <div class="flex items-center mb-3 gap-2">
            <input id="highFatFoodCheckbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500">
            <label for="highFatFoodCheckbox" class="ms-2 text-sm font-medium text-normal_font">High Fat and High Salt Food Intake (e.g. processed/fast food such as instant noodles, burgers, fries) Weekly</label>
        </div>
    </div> 
    <div class="grid grid-cols-1 gap-4 col-span-1">
        <div class="flex items-center mb-6 gap-2">
            <input id="streetFoodCheckbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500">
            <label for="streetFoodCheckbox" class="ms-2 text-sm font-medium text-normal_font">Street Foods (e.g. isaw, barbecue, live, chicken skin) Weekly</label>
        </div>
    </div>
     <div class="grid grid-cols-1 gap-4 col-span-1">
        <div class="flex items-center mb-6 gap-2">
            <input id="highSugarFoodCheckbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500">
            <label for="highSugarFoodCheckbox" class="ms-2 text-sm font-medium text-normal_font">High Sugar Foods (e.g. chocolates, cakes, pastries, softdrinks) Weekly</label>
        </div>
    </div>
</div>