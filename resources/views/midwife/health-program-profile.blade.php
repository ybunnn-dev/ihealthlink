<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Health Programs</h1>

            {{-- 1st Row: Program Filter Buttons --}}
            <div class="bg-white rounded-xl overflow-hidden shadow-md p-4 mb-6">
                <div class="flex flex-wrap justify-between items-center">
                   <button type="button" class="text-main_font font-medium hover:border-b-2">All Programs</button>
                    <button type="button" class="text-main_font font-medium hover:border-b-2">Prenatal</button>
                    <button type="button" class="relative text-sub_blue font-bold pb-1 group">Polio Vaccine<span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[100%] h-1 bg-sub_blue rounded-full"></span></button>
                    <button type="button" class="text-main_font font-medium hover:border-b-2">Anti Measles</button>
                    <button type="button" class="text-main_font font-medium hover:border-b-2">Family Planning</button>
                    <button type="button" class="text-main_font font-medium hover:border-b-2">Senior Citizen</button>
                    <button type="button" class="text-main_font font-medium hover:border-b-2">Tuberculosis</button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-6">
                {{-- The main flex container with reduced height --}}
                <div class="flex space-x-4 h-80"> {{-- Changed h-96 to h-80 to decrease height --}}
                    {{-- Left div: Profile Image, Name, and Resident Number --}}
                    <div class="w-1/3 flex flex-col h-full">
                        {{-- Div for Profile Image and Name/Resident Number with BG color and rounded corners --}}
                        <div class="bg-[#F7F7F7] rounded-lg flex flex-col items-center justify-center p-8 flex-grow">
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <circle cx="12" cy="7" r="3" fill="currentColor"></circle>
                                <path d="M12 10c-3.69 0-7 2-7 5s3.31 5 7 5 7-2 7-5-3.31-5-7-5z" fill="currentColor"></path>
                            </svg>
                            <p class="text-main_font font-bold mt-2">Ron Peter Mortega</p>
                            <p class="text-normal_font">Resident # 13356</p>
                        </div>
                    </div>
                    <div class="flex-grow bg-[#F7F7F7] rounded-lg p-8 h-full flex flex-col justify-center">
                        <div class="grid grid-cols-[auto_1fr] gap-x-12 gap-y-3 text-normal_font text-sm">
                            <p class="font-medium">FIRST NAME:</p>
                            <p>RON</p>
                            <p class="font-medium">LAST NAME:</p>
                            <p>Mortega</p>
                            <p class="font-medium">MIDDLE NAME:</p>
                            <p>PETER</p>
                            <p class="font-medium">SUFFIX:</p>
                            <p>N/A</p>
                            <p class="font-medium">BIRTH DATE:</p>
                            <p>March 17, 2024</p>
                            <p class="font-medium">CONTACT NUMBER:</p>
                            <p>09789622025</p>

                            <div class="col-span-2 my-4"></div>

                            <p class="font-medium">HOUSEHOLD NO.:</p>
                            <p>#23455</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl overflow-hidden shadow-md p-6 mb-6 flex justify-between items-center text-center md:text-left">
                <div>
                    <p class="text-gray-600 text-sm">ENROLLMENT DATE:</p>
                    <p class="text-xl font-bold text-main_font">Feb. 10, 2025</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">STATUS:</p>
                    <p class="text-xl font-bold text-main_font">Ongoing</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">COMPLETION DATE:</p>
                    <p class="text-xl font-bold text-main_font">TBD</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">NEXT ACTIVITY:</p>
                    <p class="text-xl font-bold text-main_font">2nd Dose</p>
                </div>
            </div>

            {{-- Original 4th Row: Activities and Follow-Up Table (now 5th row visually) --}}
            <div class="bg-white rounded-xl overflow-hidden shadow-md p-6 mb-6">
                <h2 class="text-2xl font-semibold text-main_font mb-4">Activities and Follow-Up</h2>
                <div class="relative overflow-x-auto shadow-md rounded-lg">
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
