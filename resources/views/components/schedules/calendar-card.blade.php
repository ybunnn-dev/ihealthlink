<div class="bg-white rounded-xl py-6 px-10 md:col-span-2">
                    <!-- Header -->
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-3">
                        <h2 class="text-xl font-semibold text-main_font flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            May 16, 2025
                        </h2>
                        <button class="w-32 h-[2rem] bg-mainblue rounded-md text-xs font-semibold text-f7 px-6" data-modal-target="add-activity-modal" data-modal-toggle="add-activity-modal">Add Activity</button>
                    </div>

                    <!-- Table -->
                    <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                        <thead class="text-xs text-main_font uppercase">
                            <tr>
                                <th class="px-6 py-2">Activity</th>
                                <th class="px-6 py-2">Time</th>
                                <th class="px-6 py-2">Venue</th>
                                <th class="px-6 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-f7 border-b text-normal_font">
                                <td class="px-6 py-3">Purok 1 Vaccination</td>
                                <td class="px-6 py-3">8:00 AM</td>
                                <td class="px-6 py-3">Purok 1</td>
                                <td class="px-6 py-3 text-center">
                                    <button class="text-blue-500 hover:underline text-xs mr-3">Edit</button>
                                    <button class="text-red-500 hover:underline text-xs">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>