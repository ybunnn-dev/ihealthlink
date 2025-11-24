<div class="flex flex-col h-full">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-4 shrink-0 px-1">
        <div class="md:col-span-3">
            <label for="enrollFemaleResidentSearchInput" class="sr-only">Search Resident</label>
            <input type="text" id="enrollFemaleResidentSearchInput" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg p-3 w-full text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Search resident name...">
        </div>
        <div class="flex items-center gap-2 md:col-span-2">
            <select id="enrollFemaleResidentPurokFilter" class="bg-gray-50 border border-gray-300 text-gray-700 rounded-lg p-3 w-full text-sm focus:ring-blue-500 focus:border-blue-500">
                <option selected>Filter by Purok</option>
            </select>
        </div>
    </div>
    
    <div id="enrollFemaleResidentListContainer" class="flex-grow overflow-y-auto border border-gray-200 rounded-lg p-3 space-y-3 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
        </div>
</div>