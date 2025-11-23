<div id="step-2" 
     class="modal-step hidden [grid-area:1/1] w-full transition-transform duration-500 ease-in-out" 
     data-step="2">
    
    <!-- Header -->
    <div class="flex flex-col items-center justify-center rounded-t mb-6 text-center">
        <h3 class="text-xl md:text-2xl font-semibold text-main_font">
            Confirm Family Selection
        </h3>
        <p class="text-sm text-normal_font mt-1">Review the family details and members below.</p>
    </div>

    <!-- Body -->
    <div class="p-0 md:p-5 space-y-4 h-[60vh] flex flex-col">
        <!-- Family Header Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-600 text-xs uppercase tracking-wide">Family ID</p>
                    <p id="step2-family-id" class="font-semibold text-main_font truncate">-</p>
                </div>
                <div>
                    <p class="text-gray-600 text-xs uppercase tracking-wide">Household ID</p>
                    <p id="step2-household-id" class="font-semibold text-main_font truncate">-</p>
                </div>
                <div>
                    <p class="text-gray-600 text-xs uppercase tracking-wide">Purok</p>
                    <p id="step2-purok" class="font-semibold text-main_font truncate">-</p>
                </div>
                <div>
                    <p class="text-gray-600 text-xs uppercase tracking-wide">Barangay</p>
                    <p id="step2-barangay" class="font-semibold text-main_font truncate">-</p>
                </div>
            </div>
        </div>

        <!-- Family Members List -->
        <div class="flex-grow overflow-y-auto border border-gray-200 rounded-lg">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 sticky top-0 z-10">
                <h4 class="font-semibold text-sm text-main_font flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Family Members
                    <span id="step2-member-count" class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full text-xs border border-gray-300">0</span>
                </h4>
            </div>
            
            <div id="step2-residents-container" class="divide-y divide-gray-100">
                <!-- Residents will be populated here -->
            </div>
        </div>
    </div>

    <!-- Footer with complex layout for mobile -->
    <div class="flex flex-col-reverse sm:flex-row items-center justify-between p-4 md:p-5 border-t border-gray-200 rounded-b mt-4 gap-3">
        
        <!-- 'Back' button is at bottom on mobile, left on desktop -->
        <button id="backToStep1Btn" type="button" 
            class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back
            </span>
        </button>
        
        <!-- Action Group: Cancel & Confirm -->
        <div class="flex flex-col-reverse sm:flex-row gap-3 w-full sm:w-auto">
            <button id="cancelStep2Btn" type="button" 
                class="w-full sm:w-auto py-3 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">
                Cancel
            </button>
            <button id="confirmStep2Btn" type="button" 
                class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-3 text-center shadow-sm transition-colors">
                Confirm
            </button>
        </div>
    </div>
</div>