<div id="select-bhw-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-semibold text-main_font">
                    Select Assigned BHWs
                </h3>
            </div>
            
            <div id="bhw-list-container" class="p-4 md:p-5 space-y-3 max-h-96 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                
                <label for="bhw-1" class="flex items-center w-full p-4 text-left bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 has-[:checked]:bg-blue-50 has-[:checked]:border-mainblue">
                    <input id="bhw-1" name="assigned_bhws" type="checkbox" value="1" class="w-5 h-5 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue focus:ring-2">
                    <span class="ms-3 text-sm font-medium text-gray-900">Maria Dela Cruz</span>
                </label>
                
                <label for="bhw-2" class="flex items-center w-full p-4 text-left bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 has-[:checked]:bg-blue-50 has-[:checked]:border-mainblue">
                    <input id="bhw-2" name="assigned_bhws" type="checkbox" value="2" class="w-5 h-5 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue focus:ring-2">
                    <span class="ms-3 text-sm font-medium text-gray-900">Juan Santos</span>
                </label>
                
                <label for="bhw-3" class="flex items-center w-full p-4 text-left bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 has-[:checked]:bg-blue-50 has-[:checked]:border-mainblue">
                    <input id="bhw-3" name="assigned_bhws" type="checkbox" value="3" class="w-5 h-5 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue focus:ring-2">
                    <span class="ms-3 text-sm font-medium text-gray-900">Theresa Reyes</span>
                </label>
                
                <label for="bhw-4" class="flex items-center w-full p-4 text-left bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100 has-[:checked]:bg-blue-50 has-[:checked]:border-mainblue">
                    <input id="bhw-4" name="assigned_bhws" type="checkbox" value="4" class="w-5 h-5 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue focus:ring-2">
                    <span class="ms-3 text-sm font-medium text-gray-900">Pedro Penduko</span>
                </label>
            
            </div>
            
            <div class="flex items-center justify-end gap-3 p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button id="cancel-bhw-selection" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="proceed-with-bhw" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Proceed</button>
            </div>
        </div>
    </div>
</div>