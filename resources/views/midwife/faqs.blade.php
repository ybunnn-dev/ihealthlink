<x-app-layout>
    <div class="py-12 px-5"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                {{-- Return Button --}}
                <a href="{{ route('midwife.dashboard') }}" >
                    <div class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 transition-colors duration-200">
                        <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path>
                            </g>
                        </svg>
                        <span>Return</span>
                    </div>
                </a>

                {{-- iHealthLink e-Tanong Section --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <div class="flex flex-col items-center justify-center">
                        {{-- Blue Heart with iHealthLink --}}
                        <div class="flex items-center px-1 gap-2">
                            <svg class="w-16 h-16 text-mainblue flex-shrink-0" viewBox="0 0 90 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M51.9356 40.3515L53.3692 43.9599L55.1231 40.496L58.2998 34.2206L60.3291 39.4364L60.7637 40.5517H81.9961L63.7647 57.5917C60.6229 60.528 56.8727 62.5495 52.8945 63.6601C44.0894 66.5725 33.8877 64.7375 26.8428 58.1532L8.01173 40.5517H39.8457L40.3545 39.6923L47.126 28.2489L51.9356 40.3515ZM7.32619 6.84755C17.0951 -2.28239 32.9335 -2.28265 42.7022 6.84755L45.0029 8.99892L47.2969 6.85537C57.0658 -2.27458 72.9042 -2.27483 82.6729 6.85537C91.4744 15.0821 92.3439 27.9135 85.2842 37.0517H63.1572L60.1406 29.2987L58.7197 25.6454L56.9492 29.1425L53.7539 35.4511L49.0635 23.6435L47.7471 20.33L45.9307 23.3983L37.8496 37.0517H4.71974C-2.34671 27.9128 -1.47841 15.0767 7.32619 6.84755ZM74.001 4.60244C72.8714 3.94228 71.4536 3.98197 70.3828 4.704C68.3681 6.06262 68.5602 9.01338 70.7383 10.1659L71.6865 10.6679C71.895 10.7782 72.0928 10.9067 72.2783 11.0507L72.9492 11.5712C75.03 13.1867 76.5836 15.3508 77.4180 17.7958L77.9024 19.2138C77.9673 19.4041 78.0145 19.5998 78.0449 19.7977L78.1113 20.2284C78.4751 22.6001 81.2939 23.7962 83.3125 22.4354C84.3704 21.7221 84.8944 20.4725 84.6533 19.2372L84.1406 16.6142C84.0465 16.1322 83.9036 15.6595 83.7129 15.204L83.2529 14.1044C82.2107 11.6147 80.5883 9.38565 78.5137 7.59267L77.8135 6.98818C77.4382 6.66391 77.0330 6.37349 76.6026 6.12197L74.0010 4.60244Z" fill="currentColor"/>
                            </svg>
                            <div class="flex items-center">
                                <span class="text-maingreen font-semibold whitespace-nowrap text-4xl lg:text-3xl transition-transform duration-300"
                                    :class="{ 'scale-x-0 opacity-0': !open }">
                                    iHealth
                                </span>
                                <span class="text-mainblue font-semibold whitespace-nowrap text-4xl lg:text-3xl transition-transform duration-300"
                                    :class="{ 'scale-x-0 opacity-0': !open }">
                                    Link
                                </span>
                            </div>
                        </div>
                        {{-- negative top margin to bring it closer --}}
                        <span class="text-3xl font-semibold text-sub_blue -mt-4">e-Tanong</span>
                        <p class="text-xs font-medium text-darkblue mt-4 max-w-md md:whitespace-nowrap">
                            Looking for answers? e-Tanong helps you navigate healthcare information easily.
                        </p>

                        {{-- Search bar --}}
                        <div class="w-full max-w-xl mt-8">
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                            </div>
                        </div>

                        {{-- FAQ Items --}}
                        <div class="w-full max-w-3xl mt-8 space-y-4">
                            <div class="bg-f7 p-4 rounded-lg shadow-sm flex justify-between items-center cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                                <span class="text-sub_blue">How can I update the health status or program participation of a resident?</span>
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <div class="bg-f7 p-4 rounded-lg shadow-sm flex justify-between items-center cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                                <span class="text-sub_blue">What if I entered incorrect data — is there a way to edit or request changes?</span>
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <div class="bg-f7 p-4 rounded-lg shadow-sm flex justify-between items-center cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                                <span class="text-sub_blue">What information is required when adding a new household or resident?</span>
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <div class="bg-f7 p-4 rounded-lg shadow-sm flex justify-between items-center cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                                <span class="text-sub_blue">How can I identify if a resident qualifies for specific health programs (e.g., TB, nutrition)?</span>
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <div class="bg-f7 p-4 rounded-lg shadow-sm flex justify-between items-center cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                                <span class="text-sub_blue">What reports should BHWs submit regularly, and how often?</span>
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
