{{-- This Activity Log section is now correctly separated and will appear below the section above --}}
<div>
    <h2 class="text-2xl font-semibold text-main_font mt-8 mb-4">{{ $midwife['firstName'] }}'s Activity Log</h2>

    <div class="bg-white p-6 rounded-xl">
        <div class="flex flex-col slg2:flex-row slg2:items-end gap-4 mb-4">
            <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
                <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search Name?</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search...">
                </div>
            </div>

            <div class="w-full xs:w-48">
                <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label>
                <button id="dateDropdown" data-dropdown-toggle="dateDropdownMenu" class="w-full text-main_font bg-[#F7F7F7] focus:outline-none font-medium border border-gray-300 rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                    All Date
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dateDropdown">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All Date</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Week</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Month</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-left text-main_font">
                <thead class="text-xs text-main_font uppercase bg-col_tab_h">
                    <tr>
                        <th scope="col" class="px-6 py-3">LOG ID</th>
                        <th scope="col" class="px-6 py-3">NAME</th>
                        <th scope="col" class="px-6 py-3">ROLE</th>
                        <th scope="col" class="px-6 py-3">ACTIVITY</th>
                        <th scope="col" class="px-6 py-3">DATE & TIME UPDATED</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">121</th>
                        <td class="px-6 py-4">Ron Peter Mortega</td>
                        <td class="px-6 py-4">MIDWIFE</td>
                        <td class="px-6 py-4">Add Medicine</td>
                        <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                    </tr>
                    <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">122</th>
                        <td class="px-6 py-4">Ron Peter Mortega</td>
                        <td class="px-6 py-4">MIDWIFE</td>
                        <td class="px-6 py-4">Add Medicine</td>
                        <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                    </tr>
                    <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">123</th>
                        <td class="px-6 py-4">Ron Peter Mortega</td>
                        <td class="px-6 py-4">MIDWIFE</td>
                        <td class="px-6 py-4">Update Resident</td>
                        <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                    </tr>
                    <tr class="bg-white text-normal_font hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">124</th>
                        <td class="px-6 py-4">Ron Peter Mortega</td>
                        <td class="px-6 py-4">MIDWIFE</td>
                        <td class="px-6 py-4">Add Resident</td>
                        <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                    </tr>
                    <tr class="bg-white text-normal_font hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">125</th>
                        <td class="px-6 py-4">Ron Peter Mortega</td>
                        <td class="px-6 py-4">MIDWIFE</td>
                        <td class="px-6 py-4">Add Resident</td>
                        <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                    </tr>
                    <tr class="bg-white text-normal_font hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">126</th>
                        <td class="px-6 py-4">Ron Peter Mortega</td>
                        <td class="px-6 py-4">MIDWIFE</td>
                        <td class="px-6 py-4">Add Medicine</td>
                        <td class="px-6 py-4">Feb 10, 2025 - 10:00 AM</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>