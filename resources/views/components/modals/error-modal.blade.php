<div id="error-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm py-6 md:py-10 px-6 transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center text-center">
                <div class="relative w-20 h-20 md:w-24 md:h-24 mb-4 md:mb-6">
                    <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <path fill="#EF4444" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm127.552 596.352-100.224-100.224-100.224 100.224a38.4 38.4 0 1 1-54.336-54.336l100.224-100.224-100.224-100.224a38.4 38.4 0 1 1 54.336-54.336l100.224 100.224 100.224-100.224a38.4 38.4 0 1 1 54.336 54.336l-100.224 100.224 100.224 100.224a38.4 38.4 0 1 1-54.336 54.336z"></path>
                    </svg>
                </div>

                <h3 id="error-msg-head" class="text-xl md:text-2xl font-semibold text-gray-800">
                    Operation Failed
                </h3>
                <p id="error-message" class="text-sm text-gray-600 mt-2 mb-6">
                    Something went wrong. Please try again later.
                </p>
            </div>
            
            <div class="flex items-center justify-center w-full">
                <button id="close-error-modal-button" data-modal-hide="error-modal" type="button" 
                    class="w-full sm:w-auto text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-base px-8 py-3 text-center transition-colors shadow-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>