<div id="edit-activity-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6 max-w-full">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-main_font">
                    Edit Activity
                </h3>
                <p class="text-sm text-normal_font">Please update the activity details to proceed.</p>
            </div>
            
            <form id="edit-activity-form">
                <input type="hidden" id="editActivityId" name="activity_id">

                <div class="p-4 md:p-5 space-y-4">
                    <div class="grid grid-cols-1 gap-3">
                        <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                            <label for="editActivityNameInput" class="text-sm font-medium text-main_font">ACTIVITY</label>
                            <input type="text" id="editActivityNameInput" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                        <div class="grid grid-cols-1 slg:grid-cols-2 gap-3">
                            <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                                <label for="editActivityDate" class="text-sm font-medium text-main_font">DATE</label>
                                <div class="relative max-w-sm w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input datepicker type="text" id="editActivityDate" class="border border-gray-300 text-gray-700 rounded-lg p-2.5 pl-10 block w-full" placeholder="Select date">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                                <label for="editActivityTime" class="block text-sm font-medium text-main_font">SELECT TIME</label>
                                <div class="relative max-w-sm w-full">
                                    <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <input type="time" id="editActivityTime" class="bg-white border leading-none border-gray-300 text-gray-700 text-sm rounded-lg block w-full p-2.5 pl-4" required />
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 relative col-span-1 mb-3">
                            <label for="editActivityVenue" class="text-sm font-medium text-main_font">VENUE</label>
                             <input type="text" id="editActivityVenue" class="border border-gray-300 text-gray-700 rounded-lg p-2">
                        </div>
                                      
                    </div>
                </div>
                <div class="flex items-center border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 justify-end pt-6 px-6">
                    <button id="cancel-edit-activity-btn" data-modal-hide="edit-activity-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                    <button 
                        id="edit-activity-submit-btn" 
                        type="submit" 
                        class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:bg-blue-400 disabled:cursor-not-allowed">
                        Save Changes
                    </button>                
                </div>
            </form>
        </div>
    </div>
</div>
@include('components.modals.schedules.edit-activity-confirmation')