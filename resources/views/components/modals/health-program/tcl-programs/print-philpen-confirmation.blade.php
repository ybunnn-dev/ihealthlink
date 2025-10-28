<div id="confirm-philpen-action-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" 
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[60] justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
     {{-- Increased z-index to z-[60] to appear above the view modal (z-50) --}}
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-main_font py-10 px-6">
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">
                    Confirm Action
                </h3>
                <p id="confirm-philpen-action-message" class="text-sm text-gray-500 dark:text-gray-400 mt-1 text-center">
                    Are you sure you want to proceed with this action?
                    {{-- JS can update this message if needed --}}
                </p>
                 </div>
            
            <div class="p-4 md:p-5">
                <div class="flex items-center justify-center">
                    <input id="confirm-philpen-action-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    <label for="confirm-philpen-action-checkbox" class="ms-2 text-sm font-medium text-main_font dark:text-gray-300">I have reviewed the details.</label>
                </div>
            </div>

            <div class="flex items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 px-6">
                {{-- This button uses data-modal-hide to automatically close this specific modal via Flowbite --}}
                <button id="close-confirm" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-mainblue">Cancel</button>
                
                <button id="confirm-philpen-action-submit" type="button" class="text-white bg-mainblue hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed" disabled>Confirm</button>
            </div>
        </div>
    </div>
</div>