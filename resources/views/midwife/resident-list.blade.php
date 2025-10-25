@section('title', 'Residents')
@section('page-id', 'residents')
<x-app-layout>
    <div class="py-12 px-5" x-data="{ showPrivacy: false }">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Households and Residents</h1>
            
            <div class="mb-3">
                <x-resident-module-nav></x-resident-module-nav>
            </div>
            <div class="bg-f7 rounded-xl overflow-none h-full w-full">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1 w-full">
                        <div class="pb-6 w-full">
                            <div class="grid grid-cols-1 slg2:grid-cols-7 xl:grid-cols-9 gap-4 w-full items-end">
                                <div class="w-full cols-span-1 slg2:col-span-9 xl:col-span-3">
                                    <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for Residents?</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="search" id="default-search" 
                                            x-bind:disabled="!showPrivacy" 
                                            x-bind:title="!showPrivacy ? 'Enable privacy view to use search' : ''"
                                            class="block disabled:bg-gray-200 w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search by name or resident #"/>
                                    </div>
                                </div>

                                    <div class="col-span-1 slg2:col-span-2">
                                        <label for="purokDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by Purok</label>
                                        <button id="purokDropdown" 
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''"
                                        data-dropdown-toggle="purokDropdownMenu" class="w-full disabled:bg-gray-200 text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        All Purok
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                        </button>
                                    </div>

                                    <div class="col-span-1 slg2:col-span-2">
                                        <label for="ageGroupDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by Age Group</label>
                                        <button id="ageGroupDropdown" 
                                        x-bind:disabled="!showPrivacy" 
                                        x-bind:title="!showPrivacy ? 'Enable privacy view to use dropdown' : ''"
                                        data-dropdown-toggle="ageGroupDropdownMenu" class="w-full text-main_font bg-f7 disabled:bg-gray-200 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        All Age Groups
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                        </button>
                                    </div>

                                    <div class="col-span-1 slg2:col-span-3 xl:col-span-2 grid grid-cols-2 md:grid-cols-4">
                                        <button type="button" id="openAddResidentModal" class="col-span-3 h-[2.375rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-3 flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path id="secondary" d="M19,20a1,1,0,0,1-1-1V18H17a1,1,0,0,1,0-2h1V15a1,1,0,0,1,2,0v1h1a1,1,0,0,1,0,2H20v1A1,1,0,0,1,19,20Z" style="fill: currentColor;"></path>
                                                    <path id="primary" d="M15,17a4,4,0,0,1,2.63-3.74,6,6,0,0,0-2.31-1.11,6,6,0,1,0-8.64,0A6,6,0,0,0,2,18v1a1,1,0,0,0,.29.71C2.53,19.94,4.77,22,11,22a17.17,17.17,0,0,0,6.88-1.18A4,4,0,0,1,15,17Z" style="fill: currentColor;"></path>
                                                </g>
                                            </svg>
                                            Add Resident
                                        </button> 
                                        <div class="col-span-1">
                                            <x-hide-button />  
                                        </div>                               
                                    </div>
                                    
                            </div>
                        </div>
                        <div id="purokDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg w-44 shadow">
                            <ul class="py-2 text-sm text-normal_font">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All Purok</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 1</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 2</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 3</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Purok 4</a></li>
                            </ul>
                        </div>

                        <div id="ageGroupDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                            <ul class="py-2 text-sm text-normal_font">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">All Age Groups</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Infant (0-1)</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Child (2-12)</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Teen (13-17)</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Adult (18-59)</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Senior (60+)</a></li>
                            </ul>
                        </div>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                            <thead class="text-xs text-main_font uppercase">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Resident #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Purok
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Sex
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Age
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Age Group
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($residents as $resident)
                                    @php
                                        $birthdate = \Illuminate\Support\Carbon::parse($resident->birthdate);
                                        $age = $birthdate->age;
                                        $ageGroup = 'Infant';
                                        if ($age >= 60) { $ageGroup = 'Senior'; } 
                                        elseif ($age >= 18) { $ageGroup = 'Adult'; } 
                                        elseif ($age >= 13) { $ageGroup = 'Teen'; } 
                                        elseif ($age >= 2) { $ageGroup = 'Child'; }
                                        $fullName = $resident->firstName . ' ' . $resident->middleName . ' ' . $resident->lastName;
                                        $purokName = $resident->family->household->purok->name ?? 'N/A';
                                    @endphp

                                    <tr class="bg-white border-b bg-f7 text-normal_font" onclick="window.location='{{ route('midwife.spec-resident', ['resident' => $resident->id]) }}'">
                                        <!-- Resident # is always visible -->
                                        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                            <span x-show="showPrivacy">R-{{ str_pad($resident->id, 3, '0', STR_PAD_LEFT) }}</span>
                                            <span x-show="!showPrivacy">{{ 'R-' . str_repeat('*', strlen(str_pad($resident->id, 3, '0', STR_PAD_LEFT))) }}</span>
                                        </th>
                                        <!-- Name (Conditional) -->
                                        <td class="px-6 py-4 ">
                                            <span x-show="showPrivacy">{{ $fullName }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($fullName)) }}</span>
                                        </td>

                                        <!-- Purok (Conditional) -->
                                        <td class="px-6 py-4 ">
                                            <span x-show="showPrivacy">{{ $purokName }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($purokName)) }}</span>
                                        </td>

                                        <!-- Sex (Conditional) -->
                                        <td class="px-6 py-4 capitalize ">
                                            <span x-show="showPrivacy">{{ $resident->sex }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($resident->sex)) }}</span>
                                        </td>

                                        <!-- Age (Conditional) -->
                                        <td class="px-6 py-4 ">
                                            <span x-show="showPrivacy">{{ $age }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen((string)$age)) }}</span>
                                        </td>

                                        <!-- Age Group (Conditional) -->
                                        <td class="px-6 py-4 ">
                                            <span x-show="showPrivacy">{{ $ageGroup }}</span>
                                            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($ageGroup)) }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No residents found.
                                        </td>
                                    </tr>
                                @endforelse
                        </tbody>
                        </table>
                    </div>
                     
                </div>
                <div class="mt-6 text-main_font">
                        {{ $residents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.modals.resident.add-resident-modal')
    @include('components.modals.qr-scanner')
    @vite('resources/js/modals/qr-scanner.js')
</x-app-layout>