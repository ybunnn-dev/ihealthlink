<div class="grid grid-cols-1 gap-6 items-start bg-white max-w-6xl mx-auto">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
        <div class="flex flex-col relative border p-4 rounded-lg">
            <label for="tobaccoStatusSelect" class="text-sm font-medium text-main_font mb-1">Tobacco Use <span class="text-red-500">*</span></label>
            <select id="tobaccoStatusSelect" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2.5">
                <option value="">Select Status</option>
                <option value="never used">Never used</option>
                <option value="exposed secondhand">Exposed to second-hand smoke</option>
                <option value="former more 1 yr">Former user (stopped > 1 yr)</option>
                <option value="current or less than 1 year">Current user or stopped &lt; 1 yr</option>
            </select>
        </div>
        <div class="flex flex-col relative border p-4 rounded-lg justify-center">
                <label for="caffeineDropdown" class="text-sm font-medium text-main_font mb-1">Caffeine Intake <span class="text-red-500">*</span></label>
                <select id="caffeineDropdown" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2.5">
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                </select>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-1 gap-4">
        <fieldset class="border p-4 rounded-lg lg:col-span-2">
            <legend class="text-sm font-medium text-main_font px-2">Alcohol Consumption</legend>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div class="flex flex-col relative">
                    <label for="alcoholIntakeDropdown" class="text-sm font-medium text-main_font mb-1">Drank alcohol last 12 mos? <span class="text-red-500">*</span></label>
                    <select id="alcoholIntakeDropdown" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2.5">
                        <option value="">Select</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                 <div class="flex flex-col relative">
                    <label for="alcoholNumDropdown" class="text-sm font-medium text-main_font mb-1">If yes, how often? <span class="text-red-500">*</span></label>
                    <select id="alcoholNumDropdown" disabled class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2.5">
                        <option value="" selected>Select Frequency</option>
                        <option value="1-3">1-3 standard drinks</option>
                        <option value="4">4 standard drinks</option>
                        <option value="5">5 standard drinks</option>
                    </select>
                </div>
            </div>
        </fieldset>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <fieldset class="border p-4 rounded-lg flex items-center">
            <div class="flex flex-col relative w-full">
                <label for="nutritionDropdown" class="text-sm font-medium text-main_font mb-1">Eats high-fat, high-salt, street, or high-sugar foods weekly? <span class="text-red-500">*</span></label>
                <select id="nutritionDropdown" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2.5">
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </fieldset>
        <fieldset class="border p-4 rounded-lg flex items-center">
            <div class="flex flex-col relative w-full">
                <label for="physicalActivityDropdown" class="text-sm font-medium text-main_font mb-1">Does moderate physical activity for ≥ 2.5 hours a week? <span class="text-red-500">*</span></label>
                <select id="physicalActivityDropdown" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2.5">
                    <option value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </fieldset>
    </div>

    <fieldset class="border p-4 rounded-lg">
        <legend class="text-sm font-medium text-main_font px-2">Health Measurements</legend>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 pt-2">
            <div class="grid grid-cols-1 gap-1">
                <label for="weightInput" class="text-sm font-medium text-main_font">Weight (kg) <span class="text-red-500">*</span></label>
                <input type="text" id="weightInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
            </div>
            <div class="grid grid-cols-1 gap-1">
                <label for="heightInput" class="text-sm font-medium text-main_font">Height (cm) <span class="text-red-500">*</span></label>
                <input type="text" id="heightInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
            </div>
            <div class="grid grid-cols-1 gap-1">
                <label for="bmiInput" class="text-sm font-medium text-main_font">BMI <span class="text-red-500">*</span></label>
                <input type="text" id="bmiInput" class="border border-gray-300 text-gray-700 rounded-lg p-2 bg-gray-100" disabled>
            </div>
            <div class="grid grid-cols-1 gap-1">
                <label for="waistCircumferenceInput" class="text-sm font-medium text-main_font">Waist (cm) <span class="text-red-500">*</span></label>
                <input type="text" id="waistCircumferenceInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
            </div>
            <div class="grid grid-cols-1 gap-1">
                <label class="text-sm font-medium text-main_font">Blood Pressure <span class="text-red-500">*</span></label>
                <div class="flex items-center space-x-2">
                    <input type="number" id="systolicInput" placeholder="Systolic" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2 text-center">
                    <span class="text-gray-500 font-bold">/</span>
                    <input type="number" id="diastolicInput" placeholder="Diastolic" class="w-full border border-gray-300 text-gray-700 rounded-lg p-2 text-center">
                </div>
            </div>
        </div>
    </fieldset>

</div>