<!-- Step 2: Maternity Details (Initially Hidden) -->
<div id="maternity-step-2">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <!-- Resident's Name (Disabled) -->
        <div class="md:col-span-2">
            <label for="maternity_resident_name" class="block mb-2 text-sm font-medium text-main_font">Selected Resident</label>
            <input type="text" name="maternity_resident_name" id="maternity_resident_name" 
                   class="border border-gray-300 text-main_font text-sm rounded-lg bg-gray-50 block w-full p-2.5 cursor-not-allowed" 
                   placeholder="Resident's full name will appear here" disabled readonly>
        </div>

        <!-- Last Menstrual Period (LMP) -->
        <div>
            <label for="last_menstrual_period" class="block mb-2 text-sm font-medium text-main_font">Last Menstrual Period (LMP)</label>
            <input type="date" name="last_menstrual_period" id="last_menstrual_period" 
                   class="border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>

        <!-- Expected Date of Confinement (EDC) -->
        <div>
            <label for="expected_date_of_confinement" class="block mb-2 text-sm font-medium text-main_font">Expected Date of Confinement (EDC)</label>
            <input type="date" name="expected_date_of_confinement" id="expected_date_of_confinement" 
                   class="border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>

        <!-- Gravida -->
        <div>
            <label for="gravida" class="block mb-2 text-sm font-medium text-main_font">Gravida</label>
            <input type="number" name="gravida" id="gravida" min="0" 
                class="border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                placeholder="e.g., 2 (total pregnancies)">
        </div>

        <!-- Para -->
        <div>
            <label for="para" class="block mb-2 text-sm font-medium text-main_font">Para</label>
            <input type="number" name="para" id="para" min="0"
                   class="border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                   placeholder="e.g., 1 (pregnancies reaching viability)">
        </div>
        
    </div>
</div>