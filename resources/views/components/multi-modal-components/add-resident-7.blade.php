<div class="grid grid-cols-1 gap-6 bg-white max-w-6xl mx-auto">

    <!-- Lifestyle Modification -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
        <div class="flex flex-col">
            <label for="lifestyleModificationSelect" class="text-sm font-medium text-main_font mb-1">Lifestyle Modification</label>
            <select id="lifestyleModificationSelect" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2.5">
                <option value="">Select</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>
    </div>
    
    <!-- Medications Fieldset -->
    <fieldset class="border p-4 rounded-lg">
        <legend class="text-sm font-medium text-main_font px-2">Medications</legend>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
            <div class="flex flex-col">
                <label for="antiHypertensiveSelect" class="text-sm font-medium text-main_font mb-1">a. Anti-hypertensive</label>
                <select id="antiHypertensiveSelect" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2.5">
                    <option value="">Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label for="oralHypoglycemicSelect" class="text-sm font-medium text-main_font mb-1">b. Oral Hypoglycemic Agents/Insulin</label>
                <select id="oralHypoglycemicSelect" class="w-full text-gray-700 bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm p-2.5">
                    <option value="">Select</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
        </div>
    </fieldset>

    <!-- Follow-up and Remarks -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex flex-col">
            <label for="followUpDate" class="text-sm font-medium text-main_font mb-1">Date of Follow-up</label>
            <input type="date" id="followUpDate" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 bg-gray-100" disabled>
        </div>
        <div class="flex flex-col md:col-span-2">
            <label for="remarksTextarea" class="text-sm font-medium text-main_font mb-1">Remarks</label>
            <textarea id="remarksTextarea" rows="4" class="w-full border resize-none border-gray-300 text-gray-700 rounded-lg p-2.5"></textarea>
        </div>
    </div>

</div>