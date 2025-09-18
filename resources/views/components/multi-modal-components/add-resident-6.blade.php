<div class="grid grid-cols-1 gap-6">
    <div class="grid grid-cols-7 items-center">
        <p class="col-span-1 font-semibold text-main_font">Blood Sugar</p>
        <hr class="col-span-6 border-t border-t-[0.5px] border-main_font">
    </div>
    <div class="grid grid-cols-1 slg:grid-cols-3 gap-4">
        <div class="grid grid-cols-1 relative mb-3">
            <label for="fbsResultInput" class="text-sm font-medium text-main_font col-span-1">FBS Result</label>
            <input type="text" id="fbsResultInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
        <div class="grid grid-cols-1 relative mb-3">
            <label for="rbsResultInput" class="text-sm font-medium text-main_font col-span-1">RBS Result</label>
            <input type="text" id="rbsResultInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
        <div class="flex flex-col col-span-1">
            <label for="bloodSugarDate" class="text-sm text-main_font font-medium">Date Taken</label> 
            <div class="relative max-w-sm">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                    </svg>
                </div>
                <input datepicker id="bloodSugarDate" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full ps-10 p-2.5" placeholder="Select date">
            </div>
        </div>
    </div>
    <p class="col-span-1 text-sm text-main_font">Check if DM clinical symptoms are present</p>
    <div class="grid grid-cols-1 slg:grid-cols-3 gap-6 col-span-1 mb-3">
        <div class="flex items-center mb-6 col-span-1">
            <input id="polyphagiaCheckbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
            <label for="polyphagiaCheckbox" class="ms-2 text-sm font-medium text-normal_font">Polyphagia</label>
        </div>
        <div class="flex items-center mb-6 col-span-1">
            <input id="polydipsiaCheckbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
            <label for="polydipsiaCheckbox" class="ms-2 text-sm font-medium text-normal_font">Polydipsia</label>
        </div>
        <div class="flex items-center mb-6 col-span-1">
            <input id="polyuriaCheckbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
            <label for="polyuriaCheckbox" class="ms-2 text-sm font-medium text-normal_font">Polyuria</label>
        </div>
    </div>

    <div class="grid grid-cols-7 items-center">
        <p class="col-span-1 font-semibold text-main_font">Lipid Profile</p>
        <hr class="col-span-6 border-t border-t-[0.5px] border-main_font">
    </div>
    <div class="grid grid-cols-1 slg:grid-cols-3 gap-4">
        <div class="grid grid-cols-1 relative mb-3">
            <label for="totalCholesterolInput" class="text-sm font-medium text-main_font col-span-1">Total Cholesterol</label>
            <input type="text" id="totalCholesterolInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
        <div class="grid grid-cols-1 relative mb-3">
            <label for="hdlInput" class="text-sm font-medium text-main_font col-span-1">HDL</label>
            <input type="text" id="hdlInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
        <div class="grid grid-cols-1 relative mb-3">
            <label for="ldlInput" class="text-sm font-medium text-main_font col-span-1">LDL</label>
            <input type="text" id="ldlInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
    </div>
    <div class="grid grid-cols-1 slg:grid-cols-3 gap-4 mb-3">
        <div class="grid grid-cols-1 relative mb-3">
            <label for="vldlInput" class="text-sm font-medium text-main_font col-span-1">VLDL</label>
            <input type="text" id="vldlInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
        <div class="grid grid-cols-1 relative mb-3">
            <label for="triglycerideInput" class="text-sm font-medium text-main_font col-span-1">Triglyceride</label>
            <input type="text" id="triglycerideInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
        <div class="flex flex-col col-span-1">
            <label for="lipidDate" class="text-sm text-main_font font-medium">Date Taken</label> 
            <div class="relative max-w-sm">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                    </svg>
                </div>
                <input datepicker id="lipidDate" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full ps-10 p-2.5" placeholder="Select date">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-7 items-center">
        <p class="col-span-1 font-semibold text-main_font">Urinalysis</p>
        <hr class="col-span-6 border-t border-t-[0.5px] border-main_font">
    </div>
    <div class="grid grid-cols-1 slg:grid-cols-3 gap-4 mb-3">
        <div class="grid grid-cols-1 relative mb-3">
            <label for="proteinInput" class="text-sm font-medium text-main_font col-span-1">Protein</label>
            <input type="text" id="proteinInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
        <div class="grid grid-cols-1 relative mb-3">
            <label for="ketonesInput" class="text-sm font-medium text-main_font col-span-1">Ketones</label>
            <input type="text" id="ketonesInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
        </div>
        <div class="flex flex-col col-span-1">
            <label for="urinalysisDate" class="text-sm text-main_font font-medium">Date Taken</label> 
            <div class="relative max-w-sm">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                    </svg>
                </div>
                <input datepicker id="urinalysisDate" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full ps-10 p-2.5" placeholder="Select date">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-7 items-center">
        <p class="col-span-1 font-semibold text-main_font">COPD</p>
        <hr class="col-span-6 border-t border-t-[0.5px] border-main_font">
    </div>
    <div class="grid grid-cols-1 slg:grid-cols-3 gap-3">
        <div class="grid grid-cols-1 gap-3 col-span-1">
            <div class="flex items-center mb-6">
                <input id="breathlessnessCheckbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                <label for="breathlessnessCheckbox" class="ms-2 text-sm font-medium text-normal_font">Breathlessness</label>
            </div>
            <div class="flex items-center mb-6">
                <input id="chronicCoughCheckbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                <label for="chronicCoughCheckbox" class="ms-2 text-sm font-medium text-normal_font">Chronic Cough</label>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-3 col-span-1">
            <div class="flex items-center mb-6">
                <input id="sputumCheckbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                <label for="sputumCheckbox" class="ms-2 text-sm font-medium text-normal_font">Sputum (Mucous) Production</label>
            </div>
            <div class="flex items-center mb-6">
                <input id="wheezingCheckbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                <label for="wheezingCheckbox" class="ms-2 text-sm font-medium text-normal_font">Wheezing</label>
            </div>
        </div>
    </div>
</div>