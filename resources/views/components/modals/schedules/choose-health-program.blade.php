<div id="select-program-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-semibold text-main_font">
                    Select a Health Program
                </h3>
            </div>
            
            <div id="program-list-container" class="p-4 md:p-5 space-y-3 max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                
                <button type="button" class="program-choice-btn w-full p-4 text-left bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-mainblue" data-program-id="1">
                    <span class="text-sm font-medium text-gray-900">Immunization</span>
                </button>
                
                <button type="button" class="program-choice-btn w-full p-4 text-left bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-mainblue" data-program-id="2">
                    <span class="text-sm font-medium text-gray-900">Maternal & Child Care</span>
                </button>
                
                <button type="button" class="program-choice-btn w-full p-4 text-left bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-mainblue" data-program-id="3">
                    <span class="text-sm font-medium text-gray-900">Family Planning</span>
                </button>
                
                <button type="button" class="program-choice-btn w-full p-4 text-left bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-mainblue" data-program-id="4">
                    <span class="text-sm font-medium text-gray-900">Nutrition Program</span>
                </button>
            
            </div>
            
            <div class="flex items-center justify-end gap-3 p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button id="hide-hp" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="proceed-btn" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Proceed</button>
            </div>
        </div>
    </div>
</div>