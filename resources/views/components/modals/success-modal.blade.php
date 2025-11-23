<div id="success-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <!-- Card: py-6 mobile, py-10 desktop -->
        <div class="relative bg-white rounded-lg shadow-sm py-6 md:py-10 px-6 transition-transform duration-300 ease-out scale-95">
            
            <div class="flex flex-col items-center justify-center text-center">
                <!-- Icon: slightly smaller on mobile (w-20) -->
                <div class="relative w-20 h-20 md:w-24 md:h-24 mb-4 md:mb-6">
                    <svg viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" fill="#000000" class="w-full h-full">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier"><path fill="#7ADAA5" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm-55.808 536.384-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.272 38.272 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336L456.192 600.384z"></path></g>
                    </svg>
                </div>

                <!-- Heading: text-xl mobile, text-2xl desktop -->
                <h3 id="success-msg-head" class="text-xl md:text-2xl font-semibold text-main_font">
                    BHW has been created
                </h3>
                <p id="success-message" class="text-sm text-normal_font mt-2 mb-6">
                    Account details sent to BHWs personal email.
                </p>
            </div>
            
            <div class="flex items-center justify-center w-full">
                <!-- Button: Full width on mobile, auto on desktop -->
                <button id="close-success-modal-button" data-modal-hide="success-modal" type="button" 
                    class="w-full sm:w-auto text-white bg-mainblue hover:bg-blue-600 font-medium rounded-lg text-base px-8 py-3 text-center transition-colors shadow-sm">
                    Finish
                </button>
            </div>
        </div>
    </div>
</div>