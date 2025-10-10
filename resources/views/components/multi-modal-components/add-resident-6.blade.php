<div class="grid grid-cols-1 gap-6 max-w-6xl mx-auto">

    <!-- Blood Sugar Fieldset -->
    <fieldset class="border p-4 rounded-lg">
        <legend class="text-base font-semibold text-main_font px-2">Blood Sugar</legend>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
            <div class="flex flex-col">
                <label for="fbsResultInput" class="text-sm font-medium text-main_font mb-1">FBS Result</label>
                <input type="text" id="fbsResultInput" class="border border-gray-300 text-gray-700 rounded-lg p-2.5">
            </div>
            <div class="flex flex-col">
                <label for="rbsResultInput" class="text-sm font-medium text-main_font mb-1">RBS Result</label>
                <input type="text" id="rbsResultInput" class="border border-gray-300 text-gray-700 rounded-lg p-2.5">
            </div>
            <div class="flex flex-col">
                <label for="bloodSugarDate" class="text-sm text-main_font font-medium mb-1">Date Taken</label>
                <input id="bloodSugarDate" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            </div>
        </div>
        <div class="mt-6">
            <p class="col-span-1 text-sm text-main_font mb-3">Check if DM clinical symptoms are present</p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="flex items-center">
                    <input id="polyphagiaCheckbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                    <label for="polyphagiaCheckbox" class="ms-2 text-sm font-medium text-normal_font">Polyphagia</label>
                </div>
                <div class="flex items-center">
                    <input id="polydipsiaCheckbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                    <label for="polydipsiaCheckbox" class="ms-2 text-sm font-medium text-normal_font">Polydipsia</label>
                </div>
                <div class="flex items-center">
                    <input id="polyuriaCheckbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                    <label for="polyuriaCheckbox" class="ms-2 text-sm font-medium text-normal_font">Polyuria</label>
                </div>
            </div>
        </div>
    </fieldset>

    <!-- Lipid Profile Fieldset -->
    <fieldset class="border p-4 rounded-lg">
        <legend class="text-base font-semibold text-main_font px-2">Lipid Profile</legend>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
            <div class="flex flex-col">
                <label for="totalCholesterolInput" class="text-sm font-medium text-main_font mb-1">Total Cholesterol</label>
                <input type="text" id="totalCholesterolInput" class="border border-gray-300 text-gray-700 rounded-lg p-2.5">
            </div>
            <div class="flex flex-col">
                <label for="hdlInput" class="text-sm font-medium text-main_font mb-1">HDL</label>
                <input type="text" id="hdlInput" class="border border-gray-300 text-gray-700 rounded-lg p-2.5">
            </div>
            <div class="flex flex-col">
                <label for="ldlInput" class="text-sm font-medium text-main_font mb-1">LDL</label>
                <input type="text" id="ldlInput" class="border border-gray-300 text-gray-700 rounded-lg p-2.5">
            </div>
            <div class="flex flex-col">
                <label for="vldlInput" class="text-sm font-medium text-main_font mb-1">VLDL</label>
                <input type="text" id="vldlInput" class="border border-gray-300 text-gray-700 rounded-lg p-2.5">
            </div>
            <div class="flex flex-col">
                <label for="triglycerideInput" class="text-sm font-medium text-main_font mb-1">Triglyceride</label>
                <input type="text" id="triglycerideInput" class="border border-gray-300 text-gray-700 rounded-lg p-2.5">
            </div>
            <div class="flex flex-col">
                <label for="lipidDate" class="text-sm text-main_font font-medium mb-1">Date Taken</label>
                <input id="lipidDate" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            </div>
        </div>
    </fieldset>

    <!-- Urinalysis Fieldset -->
    <fieldset class="border p-4 rounded-lg">
        <legend class="text-base font-semibold text-main_font px-2">Urinalysis</legend>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
            <div class="flex flex-col">
                <label for="proteinInput" class="text-sm font-medium text-main_font mb-1">Protein</label>
                <input type="text" id="proteinInput" class="border border-gray-300 text-gray-700 rounded-lg p-2.5">
            </div>
            <div class="flex flex-col">
                <label for="ketonesInput" class="text-sm font-medium text-main_font mb-1">Ketones</label>
                <input type="text" id="ketonesInput" class="border border-gray-300 text-gray-700 rounded-lg p-2.5">
            </div>
            <div class="flex flex-col">
                <label for="urinalysisDate" class="text-sm text-main_font font-medium mb-1">Date Taken</label>
                <input id="urinalysisDate" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
            </div>
        </div>
    </fieldset>

    <!-- COPD Fieldset -->
    <fieldset class="border p-4 rounded-lg">
        <legend class="text-base font-semibold text-main_font px-2">COPD Symptoms</legend>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pt-4">
            <div class="flex items-center">
                <input id="breathlessnessCheckbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                <label for="breathlessnessCheckbox" class="ms-2 text-sm font-medium text-normal_font">Breathlessness</label>
            </div>
            <div class="flex items-center">
                <input id="chronicCoughCheckbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                <label for="chronicCoughCheckbox" class="ms-2 text-sm font-medium text-normal_font">Chronic Cough</label>
            </div>
            <div class="flex items-center">
                <input id="sputumCheckbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                <label for="sputumCheckbox" class="ms-2 text-sm font-medium text-normal_font">Sputum (Mucous) Production</label>
            </div>
            <div class="flex items-center">
                <input id="wheezingCheckbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm">
                <label for="wheezingCheckbox" class="ms-2 text-sm font-medium text-normal_font">Wheezing</label>
            </div>
        </div>
    </fieldset>

</div>
