<div x-data="sideMenu()" class="relative">
    <!-- Backdrop overlay for mobile (only visible when sidebar is open) -->
    <div 
        x-show="$store.sidebar.open" 
        @click="$store.sidebar.close()"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 xl:hidden"
        style="display: none;">
    </div>

    <!-- Sidebar -->
    <div 
        :class="$store.sidebar.open ? 'translate-x-0' : '-translate-x-full' "
        class="fixed xl:relative xl:translate-x-0 inset-y-0 left-0 z-50 xl:z-0 w-60 border-r border-gray-200 bg-f7 text-white flex flex-col pt-5 min-h-0 transform transition-transform duration-300 ease-in-out xl:flex">
        <div class="flex items-center justify-between px-4 pb-3 xl:hidden">
    
        <div class="flex items-center gap-1"> 
            <svg class="w-6 text-mainblue flex-shrink-0" viewBox="0 0 90 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M51.9356 40.3515L53.3692 43.9599L55.1231 40.496L58.2998 34.2206L60.3291 39.4364L60.7637 40.5517H81.9961L63.7647 57.5917C60.6229 60.528 56.8727 62.5495 52.8945 63.6601C44.0894 66.5725 33.8877 64.7375 26.8428 58.1532L8.01173 40.5517H39.8457L40.3545 39.6923L47.126 28.2489L51.9356 40.3515ZM7.32619 6.84755C17.0951 -2.28239 32.9335 -2.28265 42.7022 6.84755L45.0029 8.99892L47.2969 6.85537C57.0658 -2.27458 72.9042 -2.27483 82.6729 6.85537C91.4744 15.0821 92.3439 27.9135 85.2842 37.0517H63.1572L60.1406 29.2987L58.7197 25.6454L56.9492 29.1425L53.7539 35.4511L49.0635 23.6435L47.7471 20.33L45.9307 23.3983L37.8496 37.0517H4.71974C-2.34671 27.9128 -1.47841 15.0767 7.32619 6.84755ZM74.001 4.60244C72.8714 3.94228 71.4536 3.98197 70.3828 4.704C68.3681 6.06262 68.5602 9.01338 70.7383 10.1659L71.6865 10.6679C71.895 10.7782 72.0928 10.9067 72.2783 11.0507L72.9492 11.5712C75.03 13.1867 76.5836 15.3508 77.4180 17.7958L77.9024 19.2138C77.9673 19.4041 78.0145 19.5998 78.0449 19.7977L78.1113 20.2284C78.4751 22.6001 81.2939 23.7962 83.3125 22.4354C84.3704 21.7221 84.8944 20.4725 84.6533 19.2372L84.1406 16.6142C84.0465 16.1322 83.9036 15.6595 83.7129 15.204L83.2529 14.1044C82.2107 11.6147 80.5883 9.38565 78.5137 7.59267L77.8135 6.98818C77.4382 6.66391 77.0330 6.37349 76.6026 6.12197L74.0010 4.60244Z" fill="currentColor"/>
            </svg>
            <div class="flex items-center">
                <span class="text-maingreen font-semibold whitespace-nowrap text-xl transition-transform duration-300">
                    iHealth
                </span>
                <span class="text-mainblue font-semibold whitespace-nowrap text-xl transition-transform duration-300">
                    Link
                </span>
            </div>
        </div>

        <button @click="$store.sidebar.close()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

        <!-- Navigation -->
        <ul class="flex-1 min-h-0 text-fluid-sm xl3:text-sm px-3 overflow-y-auto">

            <!-- Dashboard -->
            <li class="flex items-start group">
                <a href="{{ route('midwife.dashboard', ['barangay' => $barangayName]) }}"
                    class="flex items-center w-full py-3 pl-4 hover:bg-white/10 transition-colors rounded-lg"
                    :class="{
                        'bg-nav_active text-f7 font-semibold': activeItem === 'dashboard',
                        'text-mainblue': activeItem !== 'dashboard'
                    }"
                    @click="setActive('dashboard'); if (window.innerWidth < 1280) $store.sidebar.close()">
                    <svg class="flex-shrink-0 w-4 h-4"
                        :class="{
                            'text-mainblue': activeItem === 'dashboard',
                            'text-main_font': activeItem !== 'dashboard'
                        }"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13 12C13 11.4477 13.4477 11 14 11H19C19.5523 11 20 11.4477 20 12V19C20 19.5523 19.5523 20 19 20H14C13.4477 20 13 19.5523 13 19V12Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        <path
                            d="M4 5C4 4.44772 4.44772 4 5 4H9C9.55228 4 10 4.44772 10 5V12C10 12.5523 9.55228 13 9 13H5C4.44772 13 4 12.5523 4 12V5Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        <path
                            d="M4 17C4 16.4477 4.44772 16 5 16H9C9.55228 16 10 16.4477 10 17V19C10 19.5523 9.55228 20 9 20H5C4.44772 20 4 19.5523 4 19V17Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        <path
                            d="M13 5C13 4.44772 13.4477 4 14 4H19C19.5523 4 20 4.44772 20 5V7C20 7.55228 19.5523 8 19 8H14C13.4477 8 13 7.55228 13 7V5Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <span class="ml-3 whitespace-nowrap transition-all duration-200 text-fluid-sm"
                        :class="{
                            'font-semibold text-mainblue': activeItem === 'dashboard',
                            'text-main_font': activeItem !== 'dashboard'
                        }">
                        Dashboard
                    </span>
                </a>
            </li>

            <!-- Demographics -->
            <li class="flex items-center group">
                <a href="{{ route('midwife.households') }}"
                    class="flex items-center w-full py-3 pl-4 hover:bg-white/10 transition-colors rounded-lg"
                    :class="{
                        'bg-nav_active text-f7 font-semibold': activeItem === 'residents',
                        'text-mainblue': activeItem !== 'residents'
                    }"
                    @click="setActive('residents'); if (window.innerWidth < 1280) $store.sidebar.close()">
                    <svg class="flex-shrink-0 w-4 h-4"
                        :class="{
                            'text-mainblue': activeItem === 'residents',
                            'text-main_font': activeItem !== 'residents'
                        }"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M22 21.2488H21V9.97875C21 9.35875 20.72 8.77875 20.23 8.39875L19 7.43875L18.98 4.98875C18.98 4.43875 18.53 3.99875 17.98 3.99875H14.57L13.23 2.95875C12.51 2.38875 11.49 2.38875 10.77 2.95875L3.77 8.39875C3.28 8.77875 3 9.35875 3 9.96875L2.95 21.2488H2C1.59 21.2488 1.25 21.5888 1.25 21.9988C1.25 22.4088 1.59 22.7488 2 22.7488H22C22.41 22.7488 22.75 22.4088 22.75 21.9988C22.75 21.5888 22.41 21.2488 22 21.2488ZM6.5 12.7487V11.2487C6.5 10.6987 6.95 10.2487 7.5 10.2487H9.5C10.05 10.2487 10.5 10.6987 10.5 11.2487V12.7487C10.5 13.2987 10.05 13.7487 9.5 13.7487H7.5C6.95 13.7487 6.5 13.2987 6.5 12.7487ZM14.5 21.2488H9.5V18.4987C9.5 17.6687 10.17 16.9987 11 16.9987H13C13.83 16.9987 14.5 17.6687 14.5 18.4987V21.2488ZM17.5 12.7487C17.5 13.2987 17.05 13.7487 16.5 13.7487H14.5C13.95 13.7487 13.5 13.2987 13.5 12.7487V11.2487C13.5 10.6987 13.95 10.2487 14.5 10.2487H16.5C17.05 10.2487 17.5 10.6987 17.5 11.2487V12.7487Z"
                                fill="currentColor"></path>
                        </g>
                    </svg>
                    <span class="ml-3 whitespace-nowrap transition-all duration-200 text-main_font text-fluid-sm"
                        :class="{
                            'font-semibold text-mainblue': activeItem === 'residents'
                        }">
                        Demographics
                    </span>
                </a>
            </li>

            <!-- Health Programs -->
            <li class="flex items-center group">
                <a href="{{ route('midwife.health-program') }}"
                    class="flex items-center w-full py-3 pl-4 hover:bg-white/10 transition-colors rounded-lg"
                    :class="{
                        'bg-nav_active text-f7 font-semibold': activeItem === 'health-program',
                        'text-white': activeItem !== 'health-program'
                    }"
                    @click="setActive('health-program'); if (window.innerWidth < 1280) $store.sidebar.close()">
                    <svg class="flex-shrink-0 w-4 h-4"
                        :class="{
                            'text-mainblue': activeItem === 'health-program',
                            'text-main_font': activeItem !== 'health-program'
                        }"
                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M12 11.75C12.4142 11.75 12.75 12.0858 12.75 12.5V13.25H13.5C13.9142 13.25 14.25 13.5858 14.25 14C14.25 14.4142 13.9142 14.75 13.5 14.75H12.75V15.5C12.75 15.9142 12.4142 16.25 12 16.25C11.5858 16.25 11.25 15.9142 11.25 15.5V14.75H10.5C10.0858 14.75 9.75 14.4142 9.75 14C9.75 13.5858 10.0858 13.25 10.5 13.25H11.25V12.5C11.25 12.0858 11.5858 11.75 12 11.75Z"
                                fill="currentColor"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.948 1.25C11.0495 1.24997 10.3003 1.24995 9.70552 1.32991C9.07773 1.41432 8.51093 1.59999 8.05546 2.05546C7.59999 2.51093 7.41432 3.07773 7.32991 3.70552C7.24995 4.3003 7.24997 5.04952 7.25 5.948L7.25 6.02572C5.22882 6.09185 4.01511 6.32803 3.17157 7.17158C2 8.34315 2 10.2288 2 14C2 17.7712 2 19.6569 3.17157 20.8284C4.34314 22 6.22876 22 9.99998 22H14C17.7712 22 19.6569 22 20.8284 20.8284C22 19.6569 22 17.7712 22 14C22 10.2288 22 8.34315 20.8284 7.17158C19.9849 6.32803 18.7712 6.09185 16.75 6.02572L16.75 5.94801C16.75 5.04954 16.7501 4.3003 16.6701 3.70552C16.5857 3.07773 16.4 2.51093 15.9445 2.05546C15.4891 1.59999 14.9223 1.41432 14.2945 1.32991C13.6997 1.24995 12.9505 1.24997 12.052 1.25H11.948ZM15.25 6.00189V6C15.25 5.03599 15.2484 4.38843 15.1835 3.9054C15.1214 3.44393 15.0142 3.24644 14.8839 3.11612C14.7536 2.9858 14.5561 2.87858 14.0946 2.81654C13.6116 2.7516 12.964 2.75 12 2.75C11.036 2.75 10.3884 2.7516 9.90539 2.81654C9.44393 2.87858 9.24643 2.9858 9.11612 3.11612C8.9858 3.24644 8.87858 3.44393 8.81654 3.9054C8.75159 4.38843 8.75 5.03599 8.75 6V6.00189C9.14203 6 9.55807 6 10 6H14C14.4419 6 14.858 6 15.25 6.00189ZM16 14C16 16.2091 14.2091 18 12 18C9.79086 18 8 16.2091 8 14C8 11.7909 9.79086 10 12 10C14.2091 10 16 11.7909 16 14Z"
                                fill="currentColor"></path>
                        </g>
                    </svg>
                    <span class="ml-3 whitespace-nowrap transition-all duration-200 text-main_font text-fluid-sm"
                        :class="{
                            'font-semibold text-mainblue': activeItem === 'health-program'
                        }">
                        Health Programs
                    </span>
                </a>
            </li>

            <!-- Medicines -->
            <li class="flex items-center group">
                <a href="{{ route('midwife.medicines') }}"
                    class="flex items-center w-full py-3 pl-4 hover:bg-white/10 transition-colors rounded-lg"
                    :class="{
                        'bg-nav_active text-f7 font-semibold': activeItem === 'medicines',
                        'text-mainblue': activeItem !== 'medicines'
                    }"
                    @click="setActive('medicines'); if (window.innerWidth < 1280) $store.sidebar.close()">
                    <svg class="flex-shrink-0 w-4 h-4 lg:w-4"
                        :class="{
                            'text-mainblue': activeItem === 'medicines',
                            'text-main_font': activeItem !== 'medicines'
                        }"
                        version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512" fill="currentColor">
                        <g>
                            <path
                                d="M358.359,23.406C358.359,10.484,347.875,0,334.953,0H177.047c-12.922,0-23.406,10.484-23.406,23.406v50.234 h204.719V23.406z">
                            </path>
                            <path
                                d="M371.188,162.453c-20.766-10.391-27.703-34.641-27.703-55.422c0-1.344,0-3.328,0-5.875 c0-0.938,0-1.813,0-2.938H168.516c0,1.125,0,2,0,2.938c0,0.313,0,1.969,0,5.875c0,20.781-6.938,45.031-27.703,55.422 c-24.813,12.391-35.219,30.859-35.219,74.969c0,15.734,0,162.766,0,187.969c0,42.516,29.922,86.609,89.781,86.609h121.25 c59.859,0,89.781-44.094,89.781-86.609c0-25.203,0-172.234,0-187.969C406.406,193.313,396,174.844,371.188,162.453z M357.156,406.719H154.844V241.547h202.313V406.719z">
                            </path>
                            <polygon
                                points="238.688,386.922 273.297,386.922 273.297,345.828 314.375,345.828 314.375,311.25 273.297,311.25 273.297,270.156 238.688,270.156 238.688,311.25 197.625,311.25 197.625,345.828 238.688,345.828 ">
                            </polygon>
                        </g>
                    </svg>
                    <span class="ml-3 whitespace-nowrap transition-all duration-200 text-main_font text-fluid-sm"
                        :class="{
                            'font-semibold text-mainblue': activeItem === 'medicines'
                        }">
                        Medicines
                    </span>
                </a>
            </li>

            <!-- Reports -->
            <li class="flex items-center group">
                <a href="{{ route('midwife.reports') }}"
                    class="flex items-center w-full py-3 pl-4 hover:bg-white/10 transition-colors rounded-lg"
                    :class="{
                        'bg-nav_active text-f7 font-semibold': activeItem === 'reports',
                        'text-white': activeItem !== 'reports'
                    }"
                    @click="setActive('reports'); if (window.innerWidth < 1280) $store.sidebar.close()">
                    <svg class="flex-shrink-0 w-4 h-4"
                        :class="{
                            'text-mainblue': activeItem === 'reports',
                            'text-main_font': activeItem !== 'reports'
                        }"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 36 36">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <rect x="6.48" y="18" width="5.76" height="11.52" rx="1" ry="1">
                            </rect>
                            <rect x="15.12" y="6.48" width="5.76" height="23.04" rx="1" ry="1">
                            </rect>
                            <rect x="23.76" y="14.16" width="5.76" height="15.36" rx="1" ry="1">
                            </rect>
                        </g>
                    </svg>
                    <span class="ml-3 whitespace-nowrap transition-all duration-200 text-main_font text-fluid-sm"
                        :class="{
                            'font-semibold text-mainblue': activeItem === 'reports'
                        }">
                        Reports
                    </span>
                </a>
            </li>

            <!-- Schedules (Only for Midwife - role_id == 2) -->
            @auth
                @if (Auth::user()->role_id == 2)
                    <li class="flex items-center group">
                        <a href="{{ route('midwife.sched') }}"
                            class="flex items-center w-full py-3 pl-4 hover:bg-white/10 transition-colors rounded-lg"
                            :class="{
                                'bg-nav_active text-f7 font-semibold': activeItem === 'schedules',
                                'text-white': activeItem !== 'schedules'
                            }"
                            @click="setActive('schedules'); if (window.innerWidth < 1280) $store.sidebar.close()">
                            <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                class="flex-shrink-0 w-4 h-4"
                                :class="{
                                    'text-mainblue': activeItem === 'schedules',
                                    'text-main_font': activeItem !== 'schedules'
                                }"
                                fill="currentColor">
                                <path
                                    d="M2 2h16v4H2V2zm0 10V8h4v4H2zm6-2V8h4v2H8zm6 3V8h4v5h-4zm-6 5v-6h4v6H8zm-6 0v-4h4v4H2zm12 0v-3h4v3h-4z">
                                </path>
                            </svg>
                            <span class="ml-3 whitespace-nowrap transition-all duration-200 text-main_font text-fluid-sm"
                                :class="{
                                    'font-semibold text-mainblue': activeItem === 'schedules'
                                }">
                                Schedules
                            </span>
                        </a>
                    </li>
                @endif
            @endauth

            <!-- BHWs (Only for Midwife - role_id == 2) -->
            @auth
                @if (Auth::user()->role_id == 2)
                    <li class="flex items-center group">
                        <a href="{{ route('midwife.bhws') }}"
                            class="flex items-center w-full py-3 pl-4 hover:bg-white/10 transition-colors rounded-lg"
                            :class="{
                                'bg-nav_active text-f7 font-semibold': activeItem === 'bhws',
                                'text-white': activeItem !== 'bhws'
                            }"
                            @click="setActive('bhws'); if (window.innerWidth < 1280) $store.sidebar.close()">
                            <svg class="flex-shrink-0 w-4 h-4 lg:w-4 lg:h-4"
                                :class="{
                                    'text-mainblue': activeItem === 'bhws',
                                    'text-main_font': activeItem !== 'bhws'
                                }"
                                viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                role="img" fill="currentColor">
                                <path
                                    d="M40.067 20.573c0 4.557-3.699 8.25-8.26 8.25c-4.556 0-8.249-3.694-8.249-8.25s3.693-8.25 8.249-8.25c4.561 0 8.26 3.694 8.26 8.25z">
                                </path>
                                <path
                                    d="M31.82.524c-3.818 0-9.151 1.522-13.014 5.385l4.588 8.359a10.703 10.703 0 0 1 8.426-4.09c3.459 0 6.537 1.634 8.498 4.175l4.5-8.636C41.475 2.064 35.48.525 31.82.525zm3.4 6.138h-2.136v2.134h-2.566V6.662h-2.136V4.097h2.136V1.954h2.566v2.143h2.136v2.565z">
                                </path>
                                <path
                                    d="M20.966 43.651h2.113l-3.018 10.344h23.581l-3.004-10.344h2.115l3.023 10.344h6.939l-4.736-15.672c-.74-2.587-3.984-7.142-9.582-7.28l-12.87-.011c-5.725.028-9.037 4.672-9.786 7.29l-4.828 15.672h7.037l3.016-10.343z">
                                </path>
                                <path d="M.947 57.293h61.73v5.873H.947v-5.873z"></path>
                            </svg>
                            <span class="ml-3 whitespace-nowrap transition-all duration-200 text-main_font text-fluid-sm"
                                :class="{
                                    'font-semibold text-mainblue': activeItem === 'bhws'
                                }">
                                BHWs
                            </span>
                        </a>
                    </li>
                @endif
            @endauth

            <!-- Logs (Only for Midwife - role_id == 2) -->
            @auth
                @if (Auth::user()->role_id == 2)
                    <li class="flex items-center group">
                        <a href="{{ route('midwife.logs') }}"
                            class="flex items-center w-full py-3 pl-4 hover:bg-white/10 transition-colors rounded-lg"
                            :class="{
                                'bg-nav_active text-f7 font-semibold': activeItem === 'logs',
                                'text-mainblue': activeItem !== 'logs'
                            }"
                            @click="setActive('logs'); if (window.innerWidth < 1280) $store.sidebar.close()">
                            <svg class="flex-shrink-0 w-4 h-4 lg:w-4 lg:h-4"
                                :class="{
                                    'text-mainblue': activeItem === 'logs',
                                    'text-main_font': activeItem !== 'logs'
                                }"
                                fill="currentColor" viewBox="0 0 32 32">
                                <path
                                    d="M0 24q0 0.832 0.576 1.44t1.44 0.576h1.984q0 2.496 1.76 4.224t4.256 1.76h6.688q-2.144-1.504-3.456-4h-3.232q-0.832 0-1.44-0.576t-0.576-1.408v-20q0-0.832 0.576-1.408t1.44-0.608h16q0.8 0 1.408 0.608t0.576 1.408v7.232q2.496 1.312 4 3.456v-10.688q0-2.496-1.76-4.256t-4.224-1.76h-16q-2.496 0-4.256 1.76t-1.76 4.256h-1.984q-0.832 0-1.44 0.576t-0.576 1.408 0.576 1.44 1.44 0.576h1.984v4h-1.984q-0.832 0-1.44 0.576t-0.576 1.408 0.576 1.44 1.44 0.576h1.984v4h-1.984q-0.832 0-1.44 0.576t-0.576 1.408zM10.016 24h2.080q0-0.064-0.032-0.416t-0.064-0.576 0.064-0.544 0.032-0.448h-2.080v1.984zM10.016 20h2.464q0.288-1.088 0.768-1.984h-3.232v1.984zM10.016 16h4.576q0.992-1.216 2.112-1.984h-6.688v1.984zM10.016 12h16v-1.984h-16v1.984zM10.016 8h16v-1.984h-16v1.984zM14.016 23.008q0 1.824 0.704 3.488t1.92 2.88 2.88 1.92 3.488 0.704 3.488-0.704 2.88-1.92 1.92-2.88 0.704-3.488-0.704-3.488-1.92-2.88-2.88-1.92-3.488-0.704-3.488 0.704-2.88 1.92-1.92 2.88-0.704 3.488zM18.016 23.008q0-2.080 1.44-3.52t3.552-1.472 3.52 1.472 1.472 3.52q0 2.080-1.472 3.52t-3.52 1.472-3.552-1.472-1.44-3.52zM22.016 23.008q0 0.416 0.288 0.704t0.704 0.288h1.984q0.416 0 0.704-0.288t0.32-0.704-0.32-0.704-0.704-0.288h-0.992v-0.992q0-0.416-0.288-0.704t-0.704-0.32-0.704 0.32-0.288 0.704v1.984z">
                                </path>
                            </svg>
                            <span
                                class="ml-3 whitespace-nowrap transition-all duration-200 text-main_font text-fluid-sm rounded-lg"
                                :class="{
                                    'font-semibold text-mainblue': activeItem === 'logs'
                                }">
                                Logs
                            </span>
                        </a>
                    </li>
                @endif
            @endauth

        </ul>

    </div>
</div>

<script>
    function sideMenu() {
        return {
            activeItem: localStorage.getItem('activeMenuItem') || 'dashboard',
            
            setActive(item) {
                this.activeItem = item;
                localStorage.setItem('activeMenuItem', item);
            }
        }
    }
</script>
