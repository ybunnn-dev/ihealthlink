<div id="confirm-update-profile-modal" 
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full opacity-0 transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow transform transition-transform duration-300 scale-95">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900">
                    Confirm Profile Update
                </h3>
            </div>
            
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <p class="text-sm text-gray-500 mb-4">
                    You are about to update your profile information. This will change your account details in the system.
                </p>
                
                <!-- Confirmation Checkbox -->
                <div class="flex items-start mb-5">
                    <div class="flex items-center h-5">
                        <input id="confirm-profile-checkbox" 
                               type="checkbox" 
                               class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300" 
                               required>
                    </div>
                    <label for="confirm-profile-checkbox" class="ms-2 text-sm font-medium text-gray-900">
                        I have verified that the information above is correct and wish to proceed with the update.
                    </label>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b gap-2">
                <button id="cancel-profile-update" 
                        type="button" 
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                    Cancel
                </button>
                <button id="confirm-profile-btn" 
                        type="button" 
                        disabled
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed">
                    Update Profile
                </button>
            </div>
        </div>
    </div>
</div>