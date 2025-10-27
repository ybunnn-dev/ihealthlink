@section('page-id', 'spec-resident')
@section('title', 'Residents | #' . $resident->id)
<x-app-layout>
    <div class="py-12 px-5">
       <script>
            window.resident = @json($resident);
       </script>
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols gap-3">
                <div class="grid grid-cols-2 items-center gap-3">
                    <a href="{{ request('return', route('midwife.residents')) }}">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643" />
                            </svg>
                            <span class="font-semibold">Return</span>
                        </div>
                    </a>
                    <div class="flex justify-end gap-3">
                        {{-- Buttons removed from here --}}
                    </div>
                </div>
                <div class="grid grid-cols-1 slg2:grid-cols-3 gap-3">
                    <div class="grid grid-rows-5 gap-2 col-span-1 h-full">
                        {{-- Removed h-80 to auto-fit content, added p-6 for padding --}}
                        <div class="bg-f7 rounded-lg flex flex-col items-center justify-center p-6 row-span-3"> 
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <path opacity="0.4" d="M12.1207 12.78C12.0507 12.77 11.9607 12.77 11.8807 12.78C10.1207 12.72 8.7207 11.28 8.7207 9.50998C8.7207 7.69998 10.1807 6.22998 12.0007 6.22998C13.8107 6.22998 15.2807 7.69998 15.2807 9.50998C15.2707 11.28 13.8807 12.72 12.1207 12.78Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path opacity="0.34" d="M18.7398 19.3801C16.9598 21.0101 14.5998 22.0001 11.9998 22.0001C9.39977 22.0001 7.03977 21.0101 5.25977 19.3801C5.35977 18.4401 5.95977 17.5201 7.02977 16.8001C9.76977 14.9801 14.2498 14.9801 16.9698 16.8001C18.0398 17.5201 18.6398 18.4401 18.7398 19.3801Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                </g>
                            </svg>
                            <p class="text-main_font font-bold mt-4 text-xl">
                                {{ $resident->firstName }} {{ $resident->middleName }} {{ $resident->lastName }}
                            </p>
                            <p class="text-main_font font-semibold">Resident #{{ $resident->id }}</p> 
                        </div>

                        <div class="flex flex-col gap-3 row-span-3 h-full">
                            {{-- Added placeholder href="#" for navigation links --}}
                            <button id="create-consult-trigger" class="w-full h-full text-center bg-mainblue hover:bg-sky-500 text-white font-semibold py-3 px-6 rounded-lg text-sm transition">
                                Create Consultation
                            </button>
                            {{-- Moved this button here and matched new style --}}
                            <button id="create-referral-open" class="w-full h-full bg-mainblue hover:bg-sky-500 text-white font-semibold py-3 px-6 rounded-lg text-sm transition">
                                Create Referral
                            </button>
                            {{-- Added placeholder href="#" for navigation links --}}
                            <button class="w-full text-center bg-mainblue h-full hover:bg-sky-500 text-white font-semibold py-3 px-6 rounded-lg text-sm transition">
                                Edit Resident
                            </button>
                        </div>
                          
                    </div>

                    <div class="col-span-1 slg2:col-span-2 h-full bg-f7 rounded-lg px-6 sm:px-10 lg:px-12 py-8">
                        <div class="flex items-center gap-2 mb-6">
                            <h2 class="text-xl font-semibold text-main_font">Resident Info</h2>
                        </div>

                        <div class="grid grid-cols-1 gap-y-4 text-xs">
                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">FIRST NAME:</p>
                                <p class="text-normal_font">{{ $resident->firstName }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">LAST NAME:</p>
                                <p class="text-normal_font">{{ $resident->lastName }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">MIDDLE NAME:</p>
                                <p class="text-normal_font">{{ $resident->middleName }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">SUFFIX:</p>
                                <p class="text-normal_font">{{ $resident->suffix != null ? $resident->suffix : 'N/A' }}</p>
                            </div>

                            @php
                                $birthdate = \Carbon\Carbon::parse($resident->birthdate);
                                $ageYears = $birthdate->age;
                                $ageMonths = round($birthdate->diffInMonths(now()));
                            @endphp

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">BIRTHDATE:</p>
                                <p class="text-normal_font">
                                    {{ $birthdate->format('F d, Y') }}
                                    (
                                    @if ($ageYears < 1)
                                        {{ $ageMonths }} {{ \Illuminate\Support\Str::plural('month', $ageMonths) }} old
                                    @else
                                        {{ $ageYears }} {{ \Illuminate\Support\Str::plural('year', $ageYears) }} old
                                    @endif
                                    )
                                </p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">AGE GROUP:</p>
                                <p class="text-normal_font">
                                    @if ($ageYears < 1)
                                        Infant
                                    @elseif ($ageYears < 13)
                                        Child
                                    @elseif ($ageYears < 20)
                                        Teenager
                                    @elseif ($ageYears < 60)
                                        Adult
                                    @else
                                        Senior
                                    @endif
                                </p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">SEX:</p>
                                <p class="text-normal_font">{{ ucfirst($resident->sex) }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">MOBILE NUMBER:</p>
                                <p class="text-normal_font">{{ $resident->contact_no }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">CIVIL STATUS:</p>
                                <p class="text-normal_font">{{ ucfirst($resident->civil_status) }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">RELIGION:</p>
                                <p class="text-normal_font">{{ $resident->religion }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">EMPLOYMENT STATUS:</p>
                                <p class="text-normal_font">{{ ucfirst($resident->employment_status) }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">PWD ID:</p>
                                <p class="text-normal_font">{{ $resident->pwd_id !== null ? $resident->pwd_id : 'Non-PWD' }} </p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">INDIGENOUS PEOPLE:</p>
                                <p class="text-normal_font">{{ $resident->is_indigenous ? 'Yes' : 'No' }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">ETHNICITY:</p>
                                <p class="text-normal_font">{{ $resident->ethnicity }}</p>
                            </div>
                        </div>
                    </div>
                </div>

               <div class="bg-white rounded-xl p-3 px-4 sm:px-6">
                    <div class="flex flex-wrap justify-between sm:justify-start gap-2 sm:gap-6 pt-2">
                        <div class="flex flex-col items-center flex-grow sm:flex-grow-0 cursor-pointer" id="medRecTab">
                            <span class="font-semibold text-gray-500 text-sm">Health Record</span>
                            <div class="h-1 w-full bg-transparent mt-1"></div>
                        </div>

                        <div class="flex flex-col items-center flex-grow sm:flex-grow-0 cursor-pointer" id="consultHistoryTab">
                            <span class="font-semibold text-gray-500 text-sm">Consultation History</span>
                            <div class="h-1 w-full bg-transparent mt-1"></div>
                        </div>
                    </div>
                </div>

                <div id="medRecContent" class="grid grid-col gap-3">
                    
                    <x-resident.health-info :resident="$resident" />
                 
                </div>
                <div id="consultationHistory" class="bg-f7 rounded-xl overflow-hidden">
                    <div class="p-6 pt-6">
                        <div class="grid grid-rows-1 gap-1">
                            <div class="pb-6">
                                <div class="flex flex-col slg2:flex-row slg2:items-end gap-4">
                                    <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
                                        <label for="default-search" class="mb-2 text-sm font-medium text-main_font mb-4">Search</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                                </svg>
                                            </div>
                                            <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                                <thead class="text-xs text-main_font uppercase">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">CONSULTATION TYPE</th>
                                        <th scope="col" class="px-6 py-3">DATE</th>
                                        <th scope="col" class="px-6 py-3">MEDICINE GIVEN</th>
                                        <th scope="col" class="px-6 py-3">FOLLOW UP</th>
                                        <th scope="col" class="px-6 py-3">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white border-b bg-f7 text-normal_font">
                                        <td class="px-6 py-4">General Consulation</td>
                                        <td class="px-6 py-4">June 1, 2024</td>
                                        <td class="px-6 py-4">N/A</td>
                                        <td class="px-6 py-4">N/A</td>
                                        <td class="px-6 py-4">
                                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">View</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('components.modals.consultation.create-referral')
        @include('components.modals.consultation.create-consultation')
        @include('components.modals.consultation.distribute-medicine')
</x-app-layout>