@section('title', 'Health Programs')
@section('page-id', 'health-program-brgy')
<x-app-layout>
    <div class="py-12 px-5" x-data="{ showPrivacy: false }">
        <script>
            const emptyImageUrl = "{{ asset('images/illustrations/empty.png') }}";
            window.currentProgram = @json($healthProgram->id);
        </script>
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Health Programs</h1>
            <div class="grid grid-cols-1 lg2:grid-cols-5 gap-3">
                <div class="bg-white rounded-xl p-6 px-10 mb-3 col-span-1 lg2:col-span-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-x-3">
                            <svg class="w-10 h-10 text-maingreen"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 11.75C12.4142 11.75 12.75 12.0858 12.75 12.5V13.25H13.5C13.9142 13.25 14.25 13.5858 14.25 14C14.25 14.4142 13.9142 14.75 13.5 14.75H12.75V15.5C12.75 15.9142 12.4142 16.25 12 16.25C11.5858 16.25 11.25 15.9142 11.25 15.5V14.75H10.5C10.0858 14.75 9.75 14.4142 9.75 14C9.75 13.5858 10.0858 13.25 10.5 13.25H11.25V12.5C11.25 12.0858 11.5858 11.75 12 11.75Z" fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.948 1.25C11.0495 1.24997 10.3003 1.24995 9.70552 1.32991C9.07773 1.41432 8.51093 1.59999 8.05546 2.05546C7.59999 2.51093 7.41432 3.07773 7.32991 3.70552C7.24995 4.3003 7.24997 5.04952 7.25 5.948L7.25 6.02572C5.22882 6.09185 4.01511 6.32803 3.17157 7.17158C2 8.34315 2 10.2288 2 14C2 17.7712 2 19.6569 3.17157 20.8284C4.34314 22 6.22876 22 9.99998 22H14C17.7712 22 19.6569 22 20.8284 20.8284C22 19.6569 22 17.7712 22 14C22 10.2288 22 8.34315 20.8284 7.17158C19.9849 6.32803 18.7712 6.09185 16.75 6.02572L16.75 5.94801C16.75 5.04954 16.7501 4.3003 16.6701 3.70552C16.5857 3.07773 16.4 2.51093 15.9445 2.05546C15.4891 1.59999 14.9223 1.41432 14.2945 1.32991C13.6997 1.24995 12.9505 1.24997 12.052 1.25H11.948ZM15.25 6.00189V6C15.25 5.03599 15.2484 4.38843 15.1835 3.9054C15.1214 3.44393 15.0142 3.24644 14.8839 3.11612C14.7536 2.9858 14.5561 2.87858 14.0946 2.81654C13.6116 2.7516 12.964 2.75 12 2.75C11.036 2.75 10.3884 2.7516 9.90539 2.81654C9.44393 2.87858 9.24643 2.9858 9.11612 3.11612C8.9858 3.24644 8.87858 3.44393 8.81654 3.9054C8.75159 4.38843 8.75 5.03599 8.75 6V6.00189C9.14203 6 9.55807 6 10 6H14C14.4419 6 14.858 6 15.25 6.00189ZM16 14C16 16.2091 14.2091 18 12 18C9.79086 18 8 16.2091 8 14C8 11.7909 9.79086 10 12 10C14.2091 10 16 11.7909 16 14Z" fill="currentColor"></path>
                                </g>
                            </svg>

                            <div>
                                <h1 class="text-2xl font-semibold text-main_font whitespace-normal break-words">
                                {{ $healthProgram->name }}
                                </h1>
                                <p class="text-xs text-normal_font">Current Health Program</p>
                            </div>
                        </div>
                        <!-- Shared Alpine scope: wraps everything -->
                        <div class="relative flex flex-col items-center group">

                            <!-- SVG Trigger -->
                            <button id="open-change-program" class="focus:outline-none">
                                <svg class="h-5 w-5 text-main_font" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 52 52" enable-background="new 0 0 52 52" xml:space="preserve">
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M20,37.5c0-0.8-0.7-1.5-1.5-1.5h-15C2.7,36,2,36.7,2,37.5v11C2,49.3,2.7,50,3.5,50h15c0.8,0,1.5-0.7,1.5-1.5V37.5z"></path>
                                        <path d="M8.1,22H3.2c-1,0-1.5,0.9-0.9,1.4l8,8.3c0.4,0.3,1,0.3,1.4,0l8-8.3c0.6-0.6,0.1-1.4-0.9-1.4h-4.7c0-5,4.9-10,9.9-10V6C15,6,8.1,13,8.1,22z"></path>
                                        <path d="M41.8,20.3c-0.4-0.3-1-0.3-1.4,0l-8,8.3c-0.6,0.6-0.1,1.4,0.9,1.4h4.8c0,6-4.1,10-10.1,10v6c9,0,16.1-7,16.1-16H49c1,0,1.5-0.9,0.9-1.4L41.8,20.3z"></path>
                                        <path d="M50,3.5C50,2.7,49.3,2,48.5,2h-15C32.7,2,32,2.7,32,3.5v11c0,0.8,0.7,1.5,1.5,1.5h15c0.8,0,1.5-0.7,1.5-1.5V3.5z"></path>
                                    </g>
                                </svg>
                            </button>

                            <!-- Tooltip bubble -->
                            <div class="absolute top-full mt-2 px-3 py-1 text-center text-xs text-white bg-gray-700 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10">
                                <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 rotate-45 bg-gray-700"></div>
                                Switch Program
                            </div>

                            <!-- Modal -->
                            @include('components.modals.health-program.programs-modal')
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden p-6 mb-3 col-span-1">
                    <div class="grid grid-cols-[auto_1fr] gap-x-4 items-center">
                        <svg class="w-10 h-10 text-blue2" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8 3.5C8 4.88071 6.88071 6 5.5 6C4.11929 6 3 4.88071 3 3.5C3 2.11929 4.11929 1 5.5 1C6.88071 1 8 2.11929 8 3.5Z" fill="currentColor"></path> <path d="M3 8C1.34315 8 0 9.34315 0 11V15H8V8H3Z" fill="currentColor"></path> <path d="M13 8H10V15H16V11C16 9.34315 14.6569 8 13 8Z" fill="currentColor"></path> <path d="M12 6C13.1046 6 14 5.10457 14 4C14 2.89543 13.1046 2 12 2C10.8954 2 10 2.89543 10 4C10 5.10457 10.8954 6 12 6Z" fill="currentColor"></path> </g></svg>
                        <div class="min-w-0">
                            <h1 class="text-2xl font-semibold -mb-1 break-words whitespace-normal text-main_font">{{ $totalEnrolled }}</h1>
                            <p class="text-xs text-normal_font">Total Enrolled</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden p-6 mb-3 col-span-1">
                    <div class="grid grid-cols-[auto_1fr] gap-x-4 items-center">
                        <svg  class="w-10 h-10 text-indigo1" fill="currentColor" viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title></title> <g> <path d="M58.3945,32.1563,42.9961,50.625l-5.3906-6.4629a5.995,5.995,0,1,0-9.211,7.6758l9.9961,12a5.9914,5.9914,0,0,0,9.211.0059l20.0039-24a5.9988,5.9988,0,1,0-9.211-7.6875Z"></path> <path d="M48,0A48,48,0,1,0,96,48,48.0512,48.0512,0,0,0,48,0Zm0,84A36,36,0,1,1,84,48,36.0393,36.0393,0,0,1,48,84Z"></path> </g> </g></svg>
                        <div class="min-w-0">
                            <h1 class="text-2xl font-semibold -mb-1 break-words whitespace-normal text-main_font">{{ $completed }}</h1>
                            <p class="text-xs text-normal_font">Completed</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl overflow-hidden p-6 mb-3 col-span-1">
                    <div class="grid grid-cols-[auto_1fr] gap-x-4 items-center">
                        <svg class="w-10 h-10 items-center text-red1" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools --> <title>ic_fluent_calendar_overdue_24_filled</title> <desc>Created with Sketch.</desc> <g id="🔍-System-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="ic_fluent_calendar_overdue_24_filled" fill="currentColor" fill-rule="nonzero"> <path d="M17.5,12 C20.5376,12 23,14.4624 23,17.5 C23,20.5376 20.5376,23 17.5,23 C14.4624,23 12,20.5376 12,17.5 C12,14.4624 14.4624,12 17.5,12 Z M17.5,19.875 C17.1548,19.875 16.875,20.1548 16.875,20.5 C16.875,20.8452 17.1548,21.125 17.5,21.125 C17.8452,21.125 18.125,20.8452 18.125,20.5 C18.125,20.1548 17.8452,19.875 17.5,19.875 Z M21,8.5 L21,12.0218 C19.9897,11.375 18.7886,11 17.5,11 C13.9101,11 11,13.9101 11,17.5 C11,18.6894769 11.3195266,19.8043976 11.8774103,20.7635139 L12.0218,21 L6.25,21 C4.51696414,21 3.10075377,19.6435215 3.00514477,17.9344215 L3,17.75 L3,8.5 L21,8.5 Z M17.5,14 C17.2545778,14 17.0504,14.1769086 17.0080571,14.4101355 L17,14.5 L17,18.5 C17,18.7761 17.2239,19 17.5,19 C17.7454222,19 17.9496,18.8230914 17.9919429,18.5898645 L18,18.5 L18,14.5 C18,14.2239 17.7761,14 17.5,14 Z M17.75,3 C19.4830069,3 20.8992442,4.35645051 20.9948551,6.06557565 L21,6.25 L21,7 L3,7 L3,6.25 C3,4.51696414 4.35645051,3.10075377 6.06557565,3.00514477 L6.25,3 L17.75,3 Z" id="currentColor"> </path> </g> </g> </g></svg>
                        <div class="min-w-0">
                            <h1 class="text-2xl font-semibold -mb-1 break-words whitespace-normal text-main_font">{{ $overdue }}</h1>
                            <p class="text-xs text-normal_font">Overdue</p>
                        </div>
                    </div>
                </div>
                
            </div>
            {{-- 3rd Row: Search, Filters, and Table (No change) --}}
            <div class="bg-white rounded-xl overflow-hidden  p-6 mb-3">
                <div class="grid grid-rows-1 gap-1">
                    <div class="pb-6">
                        <div class="flex flex-col slg2:flex-row slg2:items-end gap-4">
                            <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
                                <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for residents</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                        </svg>
                                    </div>
                                    <input type="search" 
                                    x-bind:disabled="!showPrivacy" 
                                    x-bind:title="!showPrivacy ? 'Enable privacy view to use search' : ''"
                                    id="default-search" class="block w-full p-2 ps-10 disabled:bg-gray-200 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                                </div>
                            </div>
                            <div class="flex flex-col xs:flex-row gap-4 slg2:items-end flex-none">
                                <div class="w-full xs:w-48">
                                    <label for="filterDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by</label>
                                    <button id="filterDropdown" 
                                     x-bind:disabled="!showPrivacy" 
                                    x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''"
                                    data-dropdown-toggle="filterDropdownMenu" class="w-full disabled:bg-gray-200 text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        Alphabetical
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="w-full xs:w-40 pt-5 xs:pt-0">
                                    @if ($healthProgram->category === 'maternal_health_tcl')
                                        
                                        {{-- Show only the Maternity button --}}
                                        <button type="button" id="openEnrollMaternityModalBtn" class="w-full h-[2.375rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" ...>
                                                {{-- SVG paths for maternity icon --}}
                                                <path d="M19,20a1,1,0,0,1-1-1V18H17a1,1,0,0,1,0-2h1V15a1,1,0,0,1,2,0v1h1a1,1,0,0,1,0,2H20v1A1,1,0,0,1,19,20Z"></path>
                                                <path d="M15,17a4,4,0,0,1,2.63-3.74,6,6,0,0,0-2.31-1.11,6,6,0,1,0-8.64,0A6,6,0,0,0,2,18v1a1,1,0,0,0,.29.71C2.53,19.94,4.77,22,11,22a17.17,17.17,0,0,0,6.88-1.18A4,4,0,0,1,15,17Z"></path>
                                            </svg>
                                            Enroll Resident
                                        </button>

                                    @elseif ($healthProgram->category === 'child_healthcare_tcl')

                                        {{-- Show only the Child Healthcare button --}}
                                        <button type="button" id="openEnrollChildHealthcareModalBtn" class="w-full h-[2.375rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" ...>
                                                {{-- SVG paths for child healthcare icon --}}
                                                <path d="M19,20a1,1,0,0,1-1-1V18H17a1,1,0,0,1,0-2h1V15a1,1,0,0,1,2,0v1h1a1,1,0,0,1,0,2H20v1A1,1,0,0,1,19,20Z"></path>
                                                <path d="M15,17a4,4,0,0,1,2.63-3.74,6,6,0,0,0-2.31-1.11,6,6,0,1,0-8.64,0A6,6,0,0,0,2,18v1a1,1,0,0,0,.29.71C2.53,19.94,4.77,22,11,22a17.17,17.17,0,0,0,6.88-1.18A4,4,0,0,1,15,17Z"></path>
                                            </svg>
                                            Enroll Resident
                                        </button>
                                    @elseif ($healthProgram->category === 'family_planning_tcl')

                                        {{-- Show only the Child Healthcare button --}}
                                        <button type="button" id="openEnrollChildHealthcareModalBtn" class="w-full h-[2.375rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" ...>
                                                {{-- SVG paths for child healthcare icon --}}
                                                <path d="M19,20a1,1,0,0,1-1-1V18H17a1,1,0,0,1,0-2h1V15a1,1,0,0,1,2,0v1h1a1,1,0,0,1,0,2H20v1A1,1,0,0,1,19,20Z"></path>
                                                <path d="M15,17a4,4,0,0,1,2.63-3.74,6,6,0,0,0-2.31-1.11,6,6,0,1,0-8.64,0A6,6,0,0,0,2,18v1a1,1,0,0,0,.29.71C2.53,19.94,4.77,22,11,22a17.17,17.17,0,0,0,6.88-1.18A4,4,0,0,1,15,17Z"></path>
                                            </svg>
                                            Enroll Resident
                                        </button>
                                    @else
                                        {{-- Show the default enroll button for all other cases --}}
                                        <button type="button" id="openEnrollModalBtn" class="w-full h-[2.375rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" ...>
                                                {{-- SVG paths for general enroll icon --}}
                                                <path d="M19,20a1,1,0,0,1-1-1V18H17a1,1,0,0,1,0-2h1V15a1,1,0,0,1,2,0v1h1a1,1,0,0,1,0,2H20v1A1,1,0,0,1,19,20Z"></path>
                                                <path d="M15,17a4,4,0,0,1,2.63-3.74,6,6,0,0,0-2.31-1.11,6,6,0,1,0-8.64,0A6,6,0,0,0,2,18v1a1,1,0,0,0,.29.71C2.53,19.94,4.77,22,11,22a17.17,17.17,0,0,0,6.88-1.18A4,4,0,0,1,15,17Z"></path>
                                            </svg>
                                            Enroll Resident
                                        </button>
                                        
                                    @endif
                                </div>
                                <div class="w-full xs:w-40 pt-5 xs:pt-0">
                                    <button id="find-enrolled-qr" type="button" 
                                    x-bind:disabled="!showPrivacy" 
                                    x-bind:title="!showPrivacy ? 'Enable privacy view to use qr scanner' : ''"
                                    class="w-full h-[2.375rem] text-mainblue bg-white border border-mainblue disabled:hover-none disabled:bg-gray-200 hover:bg-gray-200 font-medium rounded-lg text-sm px-3 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5 text-mainblue" fill="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5249 2H16.5932C17.477 1.99999 18.1897 1.99999 18.7635 2.05454C19.3552 2.1108 19.8707 2.22996 20.3343 2.51405C20.8037 2.80168 21.1983 3.19632 21.486 3.6657C21.77 4.12929 21.8892 4.64482 21.9455 5.23653C22 5.8103 22 6.52304 22 7.40683V7.47517C22 8.05587 22 8.54048 21.9626 8.9341C21.9235 9.34559 21.8386 9.72907 21.623 10.0808C21.4121 10.425 21.1227 10.7144 20.7785 10.9254C20.4267 11.1409 20.0433 11.2258 19.6318 11.2649C19.2382 11.3024 18.7535 11.3023 18.1728 11.3023L17.0679 11.3023C16.2321 11.3024 15.5352 11.3024 14.9819 11.228C14.3979 11.1495 13.8706 10.9768 13.4469 10.5531C13.0232 10.1294 12.8505 9.60212 12.772 9.01812C12.6976 8.46484 12.6976 7.76789 12.6977 6.93209L12.6977 5.82725C12.6977 5.24654 12.6976 4.76185 12.7351 4.36823C12.7742 3.95674 12.8591 3.57325 13.0746 3.22152C13.2856 2.87731 13.575 2.5879 13.9192 2.37697C14.2709 2.16142 14.6544 2.07653 15.0659 2.0374C15.4595 1.99998 15.9442 1.99999 16.5249 2ZM17.3488 7.81395C16.8694 7.81395 16.6297 7.81395 16.4604 7.69385C16.4007 7.65148 16.3485 7.59933 16.3061 7.5396C16.186 7.37034 16.186 7.13061 16.186 6.65117C16.186 6.17173 16.186 5.93199 16.3061 5.76273C16.3485 5.703 16.4007 5.65085 16.4604 5.60847C16.6297 5.48837 16.8694 5.48837 17.3488 5.48837C17.8283 5.48837 18.068 5.48837 18.2373 5.60847C18.297 5.65085 18.3491 5.703 18.3915 5.76273C18.5116 5.93199 18.5116 6.17171 18.5116 6.65116C18.5116 7.13061 18.5116 7.37034 18.3915 7.5396C18.3491 7.59933 18.297 7.65148 18.2373 7.69385C18.068 7.81395 17.8283 7.81395 17.3488 7.81395Z" fill="currentColor"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0808 2.37697C9.72907 2.16142 9.34559 2.07653 8.9341 2.0374C8.54047 1.99998 8.05583 1.99999 7.4751 2H7.40684C6.52307 1.99999 5.81029 1.99999 5.23653 2.05454C4.64482 2.1108 4.12929 2.22996 3.6657 2.51405C3.19632 2.80168 2.80168 3.19632 2.51405 3.6657C2.22996 4.12929 2.1108 4.64482 2.05454 5.23653C1.99999 5.81029 1.99999 6.52302 2 7.40679V7.47506C1.99999 8.05579 1.99998 8.54047 2.0374 8.9341C2.07653 9.34559 2.16142 9.72907 2.37697 10.0808C2.5879 10.425 2.87731 10.7144 3.22152 10.9254C3.57325 11.1409 3.95674 11.2258 4.36823 11.2649C4.76183 11.3024 5.24643 11.3023 5.82711 11.3023L6.93209 11.3023C7.76787 11.3024 8.46484 11.3024 9.01812 11.228C9.60212 11.1495 10.1294 10.9768 10.5531 10.5531C10.9768 10.1294 11.1495 9.60212 11.228 9.01812C11.3024 8.46484 11.3024 7.7679 11.3023 6.93212L11.3023 5.82726C11.3023 5.24658 11.3024 4.76183 11.2649 4.36823C11.2258 3.95674 11.1409 3.57325 10.9254 3.22152C10.7144 2.87731 10.425 2.5879 10.0808 2.37697ZM5.76273 7.69385C5.93199 7.81395 6.17171 7.81395 6.65116 7.81395C7.13061 7.81395 7.37034 7.81395 7.5396 7.69385C7.59933 7.65148 7.65148 7.59933 7.69385 7.5396C7.81395 7.37034 7.81395 7.13061 7.81395 6.65116C7.81395 6.17171 7.81395 5.93199 7.69385 5.76273C7.65148 5.703 7.59933 5.65085 7.5396 5.60847C7.37034 5.48837 7.13061 5.48837 6.65116 5.48837C6.17171 5.48837 5.93199 5.48837 5.76273 5.60847C5.703 5.65085 5.65085 5.703 5.60847 5.76273C5.48837 5.93199 5.48837 6.17171 5.48837 6.65116C5.48837 7.13061 5.48837 7.37034 5.60847 7.5396C5.65085 7.59933 5.703 7.65148 5.76273 7.69385Z" fill="currentColor"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M9.01812 12.772C9.60212 12.8505 10.1294 13.0232 10.5531 13.4469C10.9768 13.8706 11.1495 14.3979 11.228 14.9819C11.3024 15.5352 11.3024 16.2321 11.3023 17.0679L11.3023 18.1728C11.3023 18.7535 11.3024 19.2382 11.2649 19.6318C11.2258 20.0433 11.1409 20.4267 10.9254 20.7785C10.7144 21.1227 10.425 21.4121 10.0808 21.623C9.72907 21.8386 9.34559 21.9235 8.9341 21.9626C8.54048 22 8.05577 22 7.47507 22H7.40683C6.52304 22 5.8103 22 5.23653 21.9455C4.64482 21.8892 4.12929 21.77 3.6657 21.486C3.19632 21.1983 2.80168 20.8037 2.51405 20.3343C2.22996 19.8707 2.1108 19.3552 2.05454 18.7635C1.99999 18.1897 1.99999 17.477 2 16.5932V16.5249C1.99999 15.9442 1.99998 15.4595 2.0374 15.0659C2.07653 14.6544 2.16142 14.2709 2.37697 13.9192C2.5879 13.575 2.87731 13.2856 3.22152 13.0746C3.57325 12.8591 3.95674 12.7742 4.36823 12.7351C4.76184 12.6976 5.24648 12.6977 5.82717 12.6977L6.93209 12.6977C7.76789 12.6976 8.46484 12.6976 9.01812 12.772ZM6.65116 18.5116C6.17171 18.5116 5.93199 18.5116 5.76273 18.3915C5.703 18.3491 5.65085 18.297 5.60847 18.2373C5.48837 18.068 5.48837 17.8283 5.48837 17.3488C5.48837 16.8694 5.48837 16.6297 5.60847 16.4604C5.65085 16.4007 5.703 16.3485 5.76273 16.3061C5.93199 16.186 6.17171 16.186 6.65115 16.186C7.13059 16.186 7.37034 16.186 7.5396 16.3061C7.59933 16.3485 7.65148 16.4007 7.69385 16.4604C7.81395 16.6297 7.81395 16.8694 7.81395 17.3488C7.81395 17.8283 7.81395 18.068 7.69385 18.2373C7.65148 18.297 7.59933 18.3491 7.5396 18.3915C7.37034 18.5116 7.13061 18.5116 6.65116 18.5116Z" fill="currentColor"></path> <path d="M12.6977 16.6155V16.6512H14.093C14.093 15.9834 14.0939 15.5351 14.1286 15.1933C14.1622 14.8632 14.2216 14.7107 14.289 14.6098C14.3738 14.4828 14.4828 14.3738 14.6098 14.289C14.7107 14.2216 14.8632 14.1622 15.1933 14.1286C15.5351 14.0939 15.9834 14.093 16.6512 14.093H18.5116V12.6977H16.6155C15.9926 12.6977 15.4729 12.6976 15.0521 12.7404C14.6117 12.7853 14.203 12.8827 13.8346 13.1288C13.5553 13.3154 13.3154 13.5553 13.1288 13.8346C12.8827 14.203 12.7853 14.6117 12.7404 15.0521C12.6976 15.4729 12.6977 15.9926 12.6977 16.6155Z" fill="currentColor"></path> <path d="M22 18.5351V18.5116H20.6046C20.6046 18.9546 20.6043 19.2519 20.5886 19.4821C20.5733 19.706 20.5459 19.8151 20.5161 19.8868C20.3981 20.1718 20.1718 20.3981 19.8868 20.5161C19.8151 20.5459 19.706 20.5733 19.4821 20.5886C19.2519 20.6043 18.9546 20.6046 18.5116 20.6046H16.6512V22H18.5351C18.9486 22 19.2937 22 19.5771 21.9807C19.8721 21.9606 20.1507 21.9172 20.4208 21.8053C21.0476 21.5456 21.5456 21.0476 21.8053 20.4208C21.9172 20.1507 21.9606 19.8721 21.9807 19.5771C22 19.2937 22 18.9486 22 18.5351Z" fill="currentColor"></path> <path d="M14.093 21.3023C14.093 21.6876 13.7807 22 13.3953 22C13.01 22 12.6977 21.6876 12.6977 21.3023V18.5116H14.093V21.3023Z" fill="currentColor"></path> <path d="M21.3023 12.6977C20.917 12.6977 20.6046 13.01 20.6046 13.3953V16.6512H22V13.3953C22 13.01 21.6876 12.6977 21.3023 12.6977Z" fill="currentColor"></path> <path d="M16.0761 16.6173C16 16.8011 16 17.0341 16 17.5C16 17.9659 16 18.1989 16.0761 18.3827C16.1776 18.6277 16.3723 18.8224 16.6173 18.9239C16.8011 19 17.0341 19 17.5 19C17.9659 19 18.1989 19 18.3827 18.9239C18.6277 18.8224 18.8224 18.6277 18.9239 18.3827C19 18.1989 19 17.9659 19 17.5C19 17.0341 19 16.8011 18.9239 16.6173C18.8224 16.3723 18.6277 16.1776 18.3827 16.0761C18.1989 16 17.9659 16 17.5 16C17.0341 16 16.8011 16 16.6173 16.0761C16.3723 16.1776 16.1776 16.3723 16.0761 16.6173Z" fill="currentColor"></path> </g></svg>
                                        Scan QR Code
                                    </button>                                   
                                </div>
                                <x-hide-button />
                            </div>
                        </div>
                    </div>
                    <div id="filterDropdownMenu"
                     class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                        <ul class="py-2 text-sm text-gray-700">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Alphabetical</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Most Enrolled</a></li>
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Least Enrolled</a></li>
                        </ul>
                    </div>
                    <div class="relative overflow-x-auto  rounded-lg">
                       <table class="w-full text-sm text-left text-main_font">
                            <thead class="text-xs text-main_font uppercase bg-col_tab_h">
                                <tr>
                                    <th scope="col" class="px-6 py-3">RESIDENT ID</th>
                                    <th scope="col" class="px-6 py-3">NAME</th>
                                    <th scope="col" class="px-6 py-3">STATUS</th>
                                    <th scope="col" class="px-6 py-3">DATE ENROLLED</th>
                                    <th scope="col" class="px-6 py-3">NEXT SCHEDULE</th>
                                </tr>
                            </thead>
                            <tbody id="enrolled-residents-tbody">
                                @forelse($enrolledResidents as $enrollment)
                                    @php
                                        // Prepare variables for display and masking
                                        $info = $enrollment->getNextConsultationAttribute($enrollment->id);
                                        $residentIdString = (string)$enrollment->resident->id;
                                        $residentName = $enrollment->resident->firstName . ' ' . $enrollment->resident->lastName;
                                        $statusText = $info['status'];
                                        $statusColor = $info['color'];
                                        $dateEnrolled = \Carbon\Carbon::parse($enrollment->created_at)->format('M d, Y');
                                        $nextSchedule = $info['date'];
                                    @endphp

                                    <tr class="bg-white border-b text-normal_font hover:bg-gray-50 cursor-pointer" 
                                        onclick="window.location='{{ route('midwife.enrolled-resident', $enrollment->id) }}'">
                                        
                                        {{-- RESIDENT ID --}}
                                        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap ">
                                            <span x-show="showPrivacy">{{ $residentIdString }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($residentIdString)) }}</span>
                                        </th>

                                        {{-- NAME --}}
                                        <td class="px-6 py-4 ">
                                            <span x-show="showPrivacy">{{ $residentName }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($residentName)) }}</span>
                                        </td>
                                        
                                        {{-- STATUS --}}
                                        <td class="px-6 py-4">
                                            <span x-show="showPrivacy">
                                                <span class="px-2 py-1 font-semibold text-xs rounded-full {{ $statusColor }}">
                                                    {{ $statusText }}
                                                </span>
                                            </span>
                                            <span x-show="!showPrivacy" class="">
                                                {{ str_repeat('*', strlen($statusText)) }}
                                            </span>
                                        </td>

                                        {{-- DATE ENROLLED --}}
                                        <td class="px-6 py-4 ">
                                            <span x-show="showPrivacy">{{ $dateEnrolled }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($dateEnrolled)) }}</span>
                                        </td>

                                        {{-- NEXT SCHEDULE --}}
                                        <td class="px-6 py-4 ">
                                            <span x-show="showPrivacy">{{ $nextSchedule }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($nextSchedule)) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                <tr class="border-b bg-f7 text-normal_font">
                                    <td colspan="5">
                                        <div class="text-center py-10">
                                            <img src="{{ asset('images/illustrations/empty.png') }}" alt="No fields found" class="mx-auto w-64">
                                            <p class="mt-5 text-lg font-medium text-gray-700">
                                                No Enrolled Residents Yet.
                                            </p>
                                            <p class="mt-2 text-sm text-gray-500">
                                                Click the "Enroll Resident" button to get started.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="program_type_content" class="hidden">{{ $healthProgram->category }}</div>
    <div class="hidden" id="hpdata">{{ $healthProgram->id }}</div>
    @include('components.modals.health-program.enroll-resident-modal')
    @include('components.modals.qr-scanner')
    @include('components.modals.health-program.tcl-programs.enroll-maternity')
    @include('components.modals.health-program.tcl-programs.enroll-family-planning')
    @vite('resources/js/modals/qr-scanner.js')
</x-app-layout>

