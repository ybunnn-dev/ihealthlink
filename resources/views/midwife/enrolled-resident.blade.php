@section('title', 'Health Programs | #134')
<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Health Programs</h1>
             <div class="grid grid-cols-1 xl:grid-cols-3 gap-3 mb-4">
                    <!-- Left Column (Profile + Scheduled Activity) -->
                    <div class="flex flex-col gap-2 col-span-1">
                        <!-- Profile Card -->
                        <div class="h-80 bg-f7 rounded-lg flex flex-col items-center justify-center p-4"> 
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <path opacity="0.4" d="M12.1207 12.78C12.0507 12.77 11.9607 12.77 11.8807 12.78C10.1207 12.72 8.7207 11.28 8.7207 9.50998C8.7207 7.69998 10.1807 6.22998 12.0007 6.22998C13.8107 6.22998 15.2807 7.69998 15.2807 9.50998C15.2707 11.28 13.8807 12.72 12.1207 12.78Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path opacity="0.34" d="M18.7398 19.3801C16.9598 21.0101 14.5998 22.0001 11.9998 22.0001C9.39977 22.0001 7.03977 21.0101 5.25977 19.3801C5.35977 18.4401 5.95977 17.5201 7.02977 16.8001C9.76977 14.9801 14.2498 14.9801 16.9698 16.8001C18.0398 17.5201 18.6398 18.4401 18.7398 19.3801Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                </g>
                            </svg>
                            <p class="text-main_font font-bold mt-4 text-xl">Ron Peter Mortega</p> 
                            <p class="text-main_font font-semibold">Household #144</p> 
                        </div>
                    </div>

                    <!-- Right Column (Resident Info) -->
                 <div class="col-span-1 xl:col-span-2 h-98 bg-f7 rounded-lg px-6 sm:px-10 lg:px-12 py-8">
                    <!-- Header -->
                    <div class="flex items-center gap-2 mb-6">
                        <h2 class="text-xl font-semibold text-main_font">Resident Info</h2>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 gap-y-4 text-sm">
                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">STATUS:</p>
                            <p class="text-normal_font">Ron Peter</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">ENROLLMENT DATE:</p>
                            <p class="text-normal_font">Mortega</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">COMPLETION DATE:</p>
                            <p class="text-normal_font">Jazareno</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">NEXT ACTIVITY:</p>
                            <p class="text-normal_font">III</p>
                         </div>
                    </div>
                </div>
            </div>

            {{-- Original 4th Row: Activities and Follow-Up Table (now 5th row visually) --}}
            <div class="bg-white rounded-xl overflow-hidden p-6 mb-6">
                <h2 class="text-2xl font-semibold text-main_font mb-4">Activities and Follow-Up</h2>
                <div class="relative overflow-x-auto rounded-lg">
                    <table class="w-full text-sm text-left text-main_font">
                        <thead class="text-xs text-main_font uppercase bg-col_tab_h">
                            <tr>
                                <th scope="col" class="px-6 py-3">ACTIVITY</th>
                                <th scope="col" class="px-6 py-3">DATE COMPLETED</th>
                                <th scope="col" class="px-6 py-3">MEDICINE GIVEN</th>
                                <th scope="col" class="px-6 py-3">STATUS</th>
                                <th scope="col" class="px-6 py-3">NEXT SCHEDULE</th>
                                <th scope="col" class="px-6 py-3">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">2nd Dose</th>
                                <td class="px-6 py-4">Feb 10, 2025</td>
                                <td class="px-6 py-4">--</td>
                                <td class="px-6 py-4">Ongoing</td>
                                <td class="px-6 py-4">Feb 15, 2025</td>
                                <td class="px-6 py-4">
                                    <button class="bg-mainblue text-white px-3 py-1 rounded-md text-xs">UPDATE</button>
                                </td>
                            </tr>
                            <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">3rd Dose</th>
                                <td class="px-6 py-4">Feb 10, 2025</td>
                                <td class="px-6 py-4">--</td>
                                <td class="px-6 py-4">Ongoing</td>
                                <td class="px-6 py-4">Feb 30, 2025</td>
                                <td class="px-6 py-4">
                                    <button class="bg-mainblue text-white px-3 py-1 rounded-md text-xs">UPDATE</button>
                                </td>
                            </tr>
                            <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">1st Dose</th>
                                <td class="px-6 py-4">Feb 10, 2025</td>
                                <td class="px-6 py-4">Anti-Polio Vaccine</td>
                                <td class="px-6 py-4">Completed</td>
                                <td class="px-6 py-4">Feb 12, 2025</td>
                                <td class="px-6 py-4">
                                    <button class="bg-mainblue text-white px-3 py-1 rounded-md text-xs">UPDATE</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
