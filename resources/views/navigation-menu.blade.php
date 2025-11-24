<nav x-data="{ open: false }" class="bg-f7 border-b border-gray-200">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-1">
        <div class="flex justify-between h-16">
            
             <!-- Logo section (hidden on mobile) -->
            <div class="flex items-center hidden xl:flex">
                <div class="flex items-center gap-1"> 
                    <svg class="w-7 text-mainblue flex-shrink-0" viewBox="0 0 90 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M51.9356 40.3515L53.3692 43.9599L55.1231 40.496L58.2998 34.2206L60.3291 39.4364L60.7637 40.5517H81.9961L63.7647 57.5917C60.6229 60.528 56.8727 62.5495 52.8945 63.6601C44.0894 66.5725 33.8877 64.7375 26.8428 58.1532L8.01173 40.5517H39.8457L40.3545 39.6923L47.126 28.2489L51.9356 40.3515ZM7.32619 6.84755C17.0951 -2.28239 32.9335 -2.28265 42.7022 6.84755L45.0029 8.99892L47.2969 6.85537C57.0658 -2.27458 72.9042 -2.27483 82.6729 6.85537C91.4744 15.0821 92.3439 27.9135 85.2842 37.0517H63.1572L60.1406 29.2987L58.7197 25.6454L56.9492 29.1425L53.7539 35.4511L49.0635 23.6435L47.7471 20.33L45.9307 23.3983L37.8496 37.0517H4.71974C-2.34671 27.9128 -1.47841 15.0767 7.32619 6.84755ZM74.001 4.60244C72.8714 3.94228 71.4536 3.98197 70.3828 4.704C68.3681 6.06262 68.5602 9.01338 70.7383 10.1659L71.6865 10.6679C71.895 10.7782 72.0928 10.9067 72.2783 11.0507L72.9492 11.5712C75.03 13.1867 76.5836 15.3508 77.4180 17.7958L77.9024 19.2138C77.9673 19.4041 78.0145 19.5998 78.0449 19.7977L78.1113 20.2284C78.4751 22.6001 81.2939 23.7962 83.3125 22.4354C84.3704 21.7221 84.8944 20.4725 84.6533 19.2372L84.1406 16.6142C84.0465 16.1322 83.9036 15.6595 83.7129 15.204L83.2529 14.1044C82.2107 11.6147 80.5883 9.38565 78.5137 7.59267L77.8135 6.98818C77.4382 6.66391 77.0330 6.37349 76.6026 6.12197L74.0010 4.60244Z" fill="currentColor"/>
                    </svg>
                    <div class="flex items-center">
                        <span class="text-maingreen font-semibold whitespace-nowrap text-2xl transition-transform duration-300">
                            iHealth
                        </span>
                        <span class="text-mainblue font-semibold whitespace-nowrap text-2xl transition-transform duration-300">
                            Link
                        </span>
                    </div>
                </div>
            </div>

            <!-- the burger - UPDATED -->
            <div class="-me-2 flex items-center xl:hidden">
                <button @click="$store.sidebar.toggle()" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': $store.sidebar.open, 'inline-flex': !$store.sidebar.open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !$store.sidebar.open, 'inline-flex': $store.sidebar.open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- the burger -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hidden xl:flex">
                    <svg 
                        version="1.1" 
                        xmlns="http://www.w3.org/2000/svg" 
                        viewBox="0 0 612 612" 
                        class="w-6 h-6 text-main_font" 
                        fill="currentColor" 
                    >
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier"> 
                        <g> <g> <g> <g> <g> <path d="M479.808,326.519c-73.02,0-132.228,59.227-132.228,132.229c0,72.983,59.208,132.174,132.228,132.174 c72.984,0,132.192-59.19,132.192-132.174C612,385.745,552.792,326.519,479.808,326.519z M488.292,556.469v-11.415 c0-4.722-3.808-8.538-8.484-8.538c-4.722,0-8.521,3.826-8.521,8.538v11.415c-47.341-4.07-85.158-41.896-89.229-89.229h11.451 c4.677,0,8.502-3.809,8.502-8.484c0-4.758-3.825-8.521-8.502-8.521h-11.451c4.07-47.351,41.896-85.14,89.229-89.229v11.433 c0,4.704,3.809,8.521,8.521,8.521c4.677,0,8.484-3.826,8.484-8.521v-11.433c47.359,4.089,85.177,41.878,89.229,89.229h-11.451 c-4.703,0-8.502,3.771-8.502,8.521c0,4.686,3.808,8.484,8.502,8.484h11.451C573.478,514.572,535.651,552.389,488.292,556.469z"></path> </g> </g> </g> <g> <g> <g> <path d="M529.066,445.966h-30.671c-4.089-5.897-10.881-9.813-18.588-9.813c-0.117,0-0.244,0.036-0.38,0.036l-27.948-39.346 c-4.07-5.726-12.048-7.055-17.792-3.003c-5.726,4.089-7.101,12.084-3.003,17.828l27.967,39.363 c-0.859,2.415-1.41,4.984-1.41,7.725c0,12.464,10.085,22.549,22.566,22.549c7.707,0,14.535-3.88,18.588-9.796h30.671 c7.037,0,12.763-5.688,12.763-12.744C541.829,451.674,536.104,445.966,529.066,445.966z"></path> </g> </g> </g> <g> <g> <g> <path d="M127.245,195.593c23.137,0,41.86-18.741,41.86-41.851V62.93c0-23.119-18.723-41.851-41.86-41.851 c-23.119,0-41.833,18.732-41.833,41.851v90.821C85.412,176.852,104.125,195.593,127.245,195.593z"></path> </g> </g> </g> <g> <g> <g> <path d="M383.578,195.593c23.138,0,41.86-18.741,41.86-41.851V62.93c0-23.119-18.723-41.851-41.86-41.851 c-23.101,0-41.832,18.732-41.832,41.851v90.821C341.736,176.852,360.478,195.593,383.578,195.593z"></path> </g> </g> </g> <g> <g> <g> <path d="M183.957,311.793c0-11.948-9.66-21.626-21.636-21.626h-40.105c-11.948,0-21.653,9.678-21.653,21.626v40.088 c0,11.966,9.705,21.672,21.653,21.672h40.105c11.966,0,21.636-9.706,21.636-21.672V311.793z"></path> </g> </g> </g> <g> <g> <g> <path d="M297.127,311.82c0-11.948-9.687-21.617-21.608-21.617h-40.124c-11.948,0-21.618,9.669-21.618,21.617v40.097 c0,11.93,9.669,21.636,21.618,21.636h40.124c11.93,0,21.608-9.706,21.608-21.636V311.82z"></path> </g> </g> </g> <g> <g> <g> <path d="M348.548,290.167c-11.967,0-21.654,9.678-21.654,21.626v40.088c0,10.826,8.068,19.365,18.416,20.984 c15.864-24.711,38.332-44.719,64.934-57.653v-3.419c0-11.948-9.669-21.626-21.636-21.626H348.548z"></path> </g> </g> </g> <g> <g> <g> <path d="M122.225,398.833c-11.948,0-21.654,9.669-21.654,21.617v40.105c0,11.948,9.706,21.617,21.654,21.617h40.124 c11.948,0,21.608-9.669,21.608-21.617V420.45c0-11.948-9.66-21.617-21.608-21.617H122.225z"></path> </g> </g> </g> <g> <g> <g> <path d="M275.473,398.851h-40.087c-11.948,0-21.617,9.688-21.617,21.636v40.069c0,11.948,9.669,21.617,21.617,21.617h40.087 c11.93,0,21.618-9.669,21.618-21.617v-40.069C297.091,408.538,287.403,398.851,275.473,398.851z"></path> </g> </g> </g> <g> <g> <g> <path d="M333.939,523.59H130.474c-35.022,0-63.523-28.5-63.523-63.486V247.592h376.958v55.608 c11.551-2.659,23.518-4.215,35.899-4.215c10.619,0,20.984,1.095,31.033,3.094V102.204h-60.293v51.538 c0,36.921-30.021,66.951-66.97,66.951c-36.93,0-66.95-30.029-66.95-66.951v-51.538H194.213v51.538 c0,36.921-30.039,66.951-66.969,66.951c-36.913,0-66.951-30.029-66.951-66.951v-51.538H0v357.891 c0,72.034,58.412,130.474,130.474,130.474h249.885c2.967,0,5.897-0.244,8.81-0.435 C365.163,573.545,345.987,550.525,333.939,523.59z"></path> </g> </g> </g> </g> </g> </g></svg>
                    
                    <span id="currentDateTime" class="text-xs font-medium text-main_font"></span>
                </div>

                <div class="ms-3 relative" x-data="notificationHandler">
                    <x-dropdown align="right" width="80">
                        <x-slot name="trigger">
                            <button class="relative inline-flex items-center p-2 text-gray-400 bg-white hover:text-gray-500 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <span x-show="unreadCount > 0" 
                                    x-text="unreadCount" 
                                    class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                </span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-full max-w-2xl">
                                <div class="flex items-center justify-between px-4 py-2 text-xs text-gray-400 border-b border-gray-200">
                                    <span>{{ __('Notifications') }}</span>
                                    <button @click="markAllRead()" 
                                            x-show="unreadCount > 0" 
                                            class="text-blue-600 hover:text-blue-500 text-xs">
                                        Mark all read
                                    </button>
                                </div>

                                <div class="max-h-96 overflow-y-auto">
                                    <template x-for="notification in notifications" :key="notification.id">
                                        <a :href="'#'" 
                                        @click="markAsRead(notification.id)"
                                        class="flex items-start py-3 px-4 hover:bg-gray-50 border-b border-gray-100"
                                        :class="{ 'bg-blue-50': !notification.is_read }">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900" x-text="notification.subject"></p>
                                                <p class="text-xs text-gray-500 mt-1" x-text="notification.message"></p>
                                                <p class="text-xs text-gray-400 mt-1" x-text="formatTime(notification.created_at)"></p>
                                            </div>
                                            <span x-show="!notification.is_read" class="ml-2 w-2 h-2 bg-blue-600 rounded-full"></span>
                                        </a>
                                    </template>

                                    <div x-show="notifications.length === 0" class="px-4 py-8 text-center text-gray-500 text-sm">
                                        No notifications yet
                                    </div>
                                </div>

                                <div class="border-t border-gray-200"></div>
                            </div> 
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                  
                                </button>
                            @else
                               <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex flex-col items-start px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        <div class="flex items-center gap-3">
                                            <svg class="justify-start size-9 rounded-full object-cover" 
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path opacity="0.4" d="M12.1207 12.78C12.0507 12.77 11.9607 12.77 11.8807 12.78C10.1207 12.72 8.7207 11.28 8.7207 9.50998C8.7207 7.69998 10.1807 6.22998 12.0007 6.22998C13.8107 6.22998 15.2807 7.69998 15.2807 9.50998C15.2707 11.28 13.8807 12.72 12.1207 12.78Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path opacity="0.34" d="M18.7398 19.3801C16.9598 21.0101 14.5998 22.0001 11.9998 22.0001C9.39977 22.0001 7.03977 21.0101 5.25977 19.3801C5.35977 18.4401 5.95977 17.5201 7.02977 16.8001C9.76977 14.9801 14.2498 14.9801 16.9698 16.8001C18.0398 17.5201 18.6398 18.4401 18.7398 19.3801Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </g>
                                            </svg>
                                            <div class="flex flex-col items-start justify-start hidden xl:flex">
                                                <div class="flex items-center gap-6">
                                                    <p class="font-semibold text-main_font">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</p>
                                                    <svg class="ms-2 -me-0.5 size-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                    </svg>
                                                </div>
                                                <span class="text-xs font-normal mt-0.5 text-normal_font">{{ $barangayName }}</span>
                                            </div>
                                        </div>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- User Info Section - NEW -->
                            <div class="px-4 py-3 border-b border-gray-200">
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ $barangayName }}
                                </p>
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}" class="flex flex-cols-2 items-center gap-2">
                                <svg class="text-main_font w-4 h-4" fill="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M14.2788 2.15224C13.9085 2 13.439 2 12.5 2C11.561 2 11.0915 2 10.7212 2.15224C10.2274 2.35523 9.83509 2.74458 9.63056 3.23463C9.53719 3.45834 9.50065 3.7185 9.48635 4.09799C9.46534 4.65568 9.17716 5.17189 8.69017 5.45093C8.20318 5.72996 7.60864 5.71954 7.11149 5.45876C6.77318 5.2813 6.52789 5.18262 6.28599 5.15102C5.75609 5.08178 5.22018 5.22429 4.79616 5.5472C4.47814 5.78938 4.24339 6.1929 3.7739 6.99993C3.30441 7.80697 3.06967 8.21048 3.01735 8.60491C2.94758 9.1308 3.09118 9.66266 3.41655 10.0835C3.56506 10.2756 3.77377 10.437 4.0977 10.639C4.57391 10.936 4.88032 11.4419 4.88029 12C4.88026 12.5581 4.57386 13.0639 4.0977 13.3608C3.77372 13.5629 3.56497 13.7244 3.41645 13.9165C3.09108 14.3373 2.94749 14.8691 3.01725 15.395C3.06957 15.7894 3.30432 16.193 3.7738 17C4.24329 17.807 4.47804 18.2106 4.79606 18.4527C5.22008 18.7756 5.75599 18.9181 6.28589 18.8489C6.52778 18.8173 6.77305 18.7186 7.11133 18.5412C7.60852 18.2804 8.2031 18.27 8.69012 18.549C9.17714 18.8281 9.46533 19.3443 9.48635 19.9021C9.50065 20.2815 9.53719 20.5417 9.63056 20.7654C9.83509 21.2554 10.2274 21.6448 10.7212 21.8478C11.0915 22 11.561 22 12.5 22C13.439 22 13.9085 22 14.2788 21.8478C14.7726 21.6448 15.1649 21.2554 15.3694 20.7654C15.4628 20.5417 15.4994 20.2815 15.5137 19.902C15.5347 19.3443 15.8228 18.8281 16.3098 18.549C16.7968 18.2699 17.3914 18.2804 17.8886 18.5412C18.2269 18.7186 18.4721 18.8172 18.714 18.8488C19.2439 18.9181 19.7798 18.7756 20.2038 18.4527C20.5219 18.2105 20.7566 17.807 21.2261 16.9999C21.6956 16.1929 21.9303 15.7894 21.9827 15.395C22.0524 14.8691 21.9088 14.3372 21.5835 13.9164C21.4349 13.7243 21.2262 13.5628 20.9022 13.3608C20.4261 13.0639 20.1197 12.558 20.1197 11.9999C20.1197 11.4418 20.4261 10.9361 20.9022 10.6392C21.2263 10.4371 21.435 10.2757 21.5836 10.0835C21.9089 9.66273 22.0525 9.13087 21.9828 8.60497C21.9304 8.21055 21.6957 7.80703 21.2262 7C20.7567 6.19297 20.522 5.78945 20.2039 5.54727C19.7799 5.22436 19.244 5.08185 18.7141 5.15109C18.4722 5.18269 18.2269 5.28136 17.8887 5.4588C17.3915 5.71959 16.7969 5.73002 16.3099 5.45096C15.8229 5.17191 15.5347 4.65566 15.5136 4.09794C15.4993 3.71848 15.4628 3.45833 15.3694 3.23463C15.1649 2.74458 14.7726 2.35523 14.2788 2.15224ZM12.5 15C14.1695 15 15.5228 13.6569 15.5228 12C15.5228 10.3431 14.1695 9 12.5 9C10.8305 9 9.47716 10.3431 9.47716 12C9.47716 13.6569 10.8305 15 12.5 15Z" fill="currentColor"></path> </g></svg>
                                {{ __('Account') }}
                            </x-dropdown-link>
                                
                            <x-dropdown-link href="{{ route('midwife.faqs') }}" class="flex flex-cols-2 items-center gap-2">
                                <svg  class="text-main_font w-4 h-4" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="currentColor" d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm23.744 191.488c-52.096 0-92.928 14.784-123.2 44.352-30.976 29.568-45.76 70.4-45.76 122.496h80.256c0-29.568 5.632-52.8 17.6-68.992 13.376-19.712 35.2-28.864 66.176-28.864 23.936 0 42.944 6.336 56.32 19.712 12.672 13.376 19.712 31.68 19.712 54.912 0 17.6-6.336 34.496-19.008 49.984l-8.448 9.856c-45.76 40.832-73.216 70.4-82.368 89.408-9.856 19.008-14.08 42.24-14.08 68.992v9.856h80.96v-9.856c0-16.896 3.52-31.68 10.56-45.76 6.336-12.672 15.488-24.64 28.16-35.2 33.792-29.568 54.208-48.576 60.544-55.616 16.896-22.528 26.048-51.392 26.048-86.592 0-42.944-14.08-76.736-42.24-101.376-28.16-25.344-65.472-37.312-111.232-37.312zm-12.672 406.208a54.272 54.272 0 0 0-38.72 14.784 49.408 49.408 0 0 0-15.488 38.016c0 15.488 4.928 28.16 15.488 38.016A54.848 54.848 0 0 0 523.072 768c15.488 0 28.16-4.928 38.72-14.784a51.52 51.52 0 0 0 16.192-38.72 51.968 51.968 0 0 0-15.488-38.016 55.936 55.936 0 0 0-39.424-14.784z"></path></g></svg>
                                {{ __('FAQs') }}
                            </x-dropdown-link>

                            <div class="border-t border-gray-200"></div>

                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();" class="flex flex-cols-2 items-center gap-2">
                                         <svg  class="text-main_font w-4 h-4" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M19 23H11C10.4477 23 10 22.5523 10 22C10 21.4477 10.4477 21 11 21H19C19.5523 21 20 20.5523 20 20V4C20 3.44772 19.5523 3 19 3L11 3C10.4477 3 10 2.55229 10 2C10 1.44772 10.4477 1 11 1L19 1C20.6569 1 22 2.34315 22 4V20C22 21.6569 20.6569 23 19 23Z" fill="currentColor"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M2.48861 13.3099C1.83712 12.5581 1.83712 11.4419 2.48862 10.6902L6.66532 5.87088C7.87786 4.47179 10.1767 5.32933 10.1767 7.18074L10.1767 9.00001H16.1767C17.2813 9.00001 18.1767 9.89544 18.1767 11V13C18.1767 14.1046 17.2813 15 16.1767 15L10.1767 15V16.8193C10.1767 18.6707 7.87786 19.5282 6.66532 18.1291L2.48861 13.3099ZM4.5676 11.3451C4.24185 11.7209 4.24185 12.2791 4.5676 12.6549L8.1767 16.8193V14.5C8.1767 13.6716 8.84827 13 9.6767 13L16.1767 13V11L9.6767 11C8.84827 11 8.1767 10.3284 8.1767 9.50001L8.1767 7.18074L4.5676 11.3451Z" fill="currentColor"></path> </g></svg>
                                    {{ __('Sign Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>
<script>
  function updateDateTime() {
    const now = new Date();
    const options = { 
      weekday: 'long', 
      day: '2-digit', 
      month: '2-digit', 
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
      hour12: true
    };
    document.getElementById('currentDateTime').textContent = now.toLocaleDateString('en-US', options);
  }

  // Initial call
  updateDateTime();
  
  // Update every second
  setInterval(updateDateTime, 1000);

</script>