 <div id="confirm-add-resident-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm px-8">
            <!-- Modal header -->
            <div class="flex flex-col items-center justify-center rounded-t pt-8 pb-4 border-b">
                <h3 class="text-xl font-semibold text-main_font">
                    Confirm New Resident
                </h3>
                <p class="text-sm text-normal_font">
                    Please review the details below before proceeding.
                </p>
            </div>
                
            <!-- Modal body with scrollable content -->
            <div>
                <div id="resident-info-review" class="max-h-[40vh] overflow-y-auto custom-scrollbar pr-4 rounded-md bg-bg_col p-6">
                    <div class="mb-3 flex items-center gap-3">
                        <p class="text-main_font font-semibold text-lg flex-none">Basic Information</p>
                        <hr class="border border-main_font flex-1">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                        <!-- Dynamically populated content will go here -->
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Full Name</label>
                            <span id="review-full-name" class="text-base text-gray-800 font-medium">Juan Dela Cruz Jr.</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Birthdate & Age</label>
                            <span id="review-birthdate-age" class="text-base text-gray-800 font-medium">1990-01-15 (35)</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Sex</label>
                            <span id="review-sex" class="text-base text-gray-800 font-medium">Male</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Contact No.</label>
                            <span id="review-contact" class="text-base text-gray-800 font-medium">09123456789</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Civil Status</label>
                            <span id="review-civil-status" class="text-base text-gray-800 font-medium">Married</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Religion</label>
                            <span id="review-religion" class="text-base text-gray-800 font-medium">Roman Catholic</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Household & Purok</label>
                            <span id="review-household" class="text-base text-gray-800 font-medium">HH-001 / Purok 1</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Relationship to Head</label>
                            <span id="review-relationship" class="text-base text-gray-800 font-medium">Head</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Employment Status</label>
                            <span id="review-employment" class="text-base text-gray-800 font-medium">Employed</span>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs font-semibold text-gray-500 uppercase">Is a PWD?</label>
                            <span id="review-pwd" class="text-base text-gray-800 font-medium">No</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Checkbox -->
            <div class="px-6 md:px-7 pb-4">
                <div class="flex items-center justify-center bg-gray-50 p-3 rounded-lg">
                    <input id="confirm-resident-checkbox" type="checkbox" value="" class="w-4 h-4 text-mainblue bg-gray-100 border-gray-300 rounded focus:ring-mainblue">
                    <label for="confirm-resident-checkbox" class="ms-2 text-sm font-medium text-gray-800">I have reviewed all the information and confirm it is correct.</label>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex items-center justify-end border-t border-gray-200 gap-3 p-6">
                <button id="cancel-add-resident-confirm" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Cancel</button>
                <button id="confirm-resident-proceed-button" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>Confirm & Proceed</button>
            </div>
        </div>
    </div>
</div>
@include('components.modals.resident.choose-family')