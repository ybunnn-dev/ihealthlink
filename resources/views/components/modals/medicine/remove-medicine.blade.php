<div id="confirm-delete-medicine-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm py-10 px-6">
            <div class="flex flex-col items-center justify-center rounded-t mb-6 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500">
                    Confirm Deletion
                </h3>
                <p class="text-sm text-normal_font mt-1">
                    Are you sure you want to permanently delete "<strong id="delete-medicine-name-to-confirm" class="text-main_font"></strong>"? This action cannot be undone.
                </p>
            </div>
            <div class="flex items-center justify-center gap-3 pt-6">
                <button id="cancel-delete-medicine" data-modal-hide="confirm-delete-medicine-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">No, cancel</button>
                <button id="confirm-delete-medicine-btn" type="button" class="text-white bg-red-600 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Yes, I'm sure</button>
            </div>
        </div>
    </div>
</div>