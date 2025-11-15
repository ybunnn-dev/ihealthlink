<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4 px-3">
    <div class="md:col-span-3">
        <label for="enrollChildResidentSearchInput" class="sr-only">Search Resident</label>
        <input type="text" id="enrollChildResidentSearchInput" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 w-full" placeholder="Search resident name...">
    </div>

    <div class="flex items-center gap-2 md:col-span-2">
        <select id="enrollChildResidentPurokFilter" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 w-full">
            <option value="" selected>Filter by Purok</option>
        </select>
 
    </div>
</div>

<div id="enrollChildResidentListContainer" class="space-y-3 h-full max-h-80 overflow-y-auto border rounded-lg p-3">
</div>