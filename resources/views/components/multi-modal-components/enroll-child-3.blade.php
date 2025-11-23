<div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-1">
        
    <div class="md:col-span-2">
        <label for="child_name" class="block mb-2 text-sm font-medium text-main_font">Selected Child</label>
        <input type="text" name="child_name" id="child_name" 
               class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-3 cursor-not-allowed" 
               placeholder="Child's full name will appear here" disabled readonly>
    </div>

    <div class="md:col-span-2">
        <label for="mother_name" class="block mb-2 text-sm font-medium text-main_font">Selected Mother</label>
        <input type="text" name="mother_name" id="mother_name" 
            class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-3 cursor-not-allowed" 
            placeholder="Mother's full name will appear here" disabled readonly>
    </div>

    <div class="md:col-span-2">
        <label for="birth_weight" class="block mb-2 text-sm font-medium text-main_font">Birth Weight (kg) <span class="text-red-500">*</span></label>
        <input type="number" name="birth_weight" id="birth_weight" min="0" step="0.1"
            class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" 
            placeholder="e.g., 3.2">
    </div>

</div>