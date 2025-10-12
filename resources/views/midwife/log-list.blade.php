@section('title', 'Logs')
<x-app-layout>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            console.log(@json($activityLogs));
        });
    </script>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Logs</h1>
            <div class="bg-f7 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
                        <div class="pb-6">
                            <div class="flex flex-col slg2:flex-row slg2:flex-nowrap items-end gap-4">
                                <div class="w-full slg2:flex-grow slg2:max-w-md">
                                    <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search name?</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row flex-wrap gap-4 items-end slg2:flex-shrink-0">
                                    <div class="w-full sm:w-48">
                                        <label for="categoryDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by</label>
                                        <button id="categoryDropdown" data-dropdown-toggle="categoryDropdownMenu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                            Admin
                                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="w-full sm:w-48">
                                        <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label>
                                        <button id="dateDropdown" data-dropdown-toggle="dateDropdownMenu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                            Date
                                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="categoryDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Option 1</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Option 2</a></li>
                            </ul>
                        </div>

                        <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Week</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Year</a></li>
                            </ul>
                        </div>
                        <div class="relative overflow-x-auto rounded-lg">
                            <table class="w-full text-sm text-left text-main_font">
                                <thead class="text-xs text-main_font uppercase text-center bg-col_tab_h">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">LOG #</th>
                                        <th scope="col" class="px-6 py-3">NAME</th>
                                        <th scope="col" class="px-6 py-3">ROLE</th>
                                        <th scope="col" class="px-6 py-3">ACTIVITY</th>
                                        <th scope="col" class="px-6 py-3">DATE & TIME UPDATED</th>
                                        <th scope="col" class="px-6 py-3">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($activityLogs as $log)
                                        <tr class="bg-white border-b text-normal_font text-center hover:bg-gray-50">
                                            <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                                {{-- Use loop's iteration to number logs and fix the missing 'id' property error --}}
                                                {{ $log->id ?? '' }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{-- Construct full name from the nested user object --}}
                                                @if(isset($log->user))
                                                    {{ ($log->user->firstName ?? '') . ' ' . ($log->user->lastName ?? 'N/A') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 capitalize">
                                                {{-- Use a sensible default for role based on the controller's logic --}}
                                                {{ $log->user->role->name ?? 'BHW' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{-- Responsive truncation for the activity description --}}
                                                <div class="truncate max-w-20 slg2:max-w-30 xl3:max-w-80 mx-auto" title="{{ $log->activity }}">
                                                    {{ $log->activity }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{-- Parse the date string with Carbon before formatting for display --}}
                                                {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y - h:i A') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{-- Placeholder link for viewing log details --}}
                                                <a href="#" class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        {{-- This row will display if $activityLogs is empty --}}
                                        <tr class="bg-white border-b">
                                            <td colspan="6" class="px-6 py-12 text-center text-normal_font">
                                                No activity logs found for BHWs in this barangay.
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
    </div>
</x-app-layout>

