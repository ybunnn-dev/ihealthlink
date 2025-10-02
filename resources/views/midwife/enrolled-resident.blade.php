@section('title', 'Health Programs | #134')
<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
             <a href="{{ route('midwife.health-program') }}">
                    <div class="flex items-center space-x-2 mb-3"> <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span class="font-semibold">Return</span>
                    </div>
                </a>
             <div class="grid grid-cols-1 xl:grid-cols-3 gap-3 mb-4 h-full">
                    <!-- Left Column (Profile + Scheduled Activity) -->
                    <div class="flex flex-col gap-2 col-span-1 h-full">
                        <!-- Profile Card -->
                        <div class="h-full bg-f7 rounded-lg flex flex-col items-center justify-center p-4"> 
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> 
                                    <path opacity="0.4" d="M12.1207 12.78C12.0507 12.77 11.9607 12.77 11.8807 12.78C10.1207 12.72 8.7207 11.28 8.7207 9.50998C8.7207 7.69998 10.1807 6.22998 12.0007 6.22998C13.8107 6.22998 15.2807 7.69998 15.2807 9.50998C15.2707 11.28 13.8807 12.72 12.1207 12.78Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path opacity="0.34" d="M18.7398 19.3801C16.9598 21.0101 14.5998 22.0001 11.9998 22.0001C9.39977 22.0001 7.03977 21.0101 5.25977 19.3801C5.35977 18.4401 5.95977 17.5201 7.02977 16.8001C9.76977 14.9801 14.2498 14.9801 16.9698 16.8001C18.0398 17.5201 18.6398 18.4401 18.7398 19.3801Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#566A7F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                                </g>
                            </svg>
                            <p class="text-main_font font-bold mt-4 text-xl">{{ $enrolledResident->resident->firstName }} {{ $enrolledResident->resident->lastName }}</p> 
                            <p class="text-main_font font-semibold" style="cursor: pointer" onclick="window.location='{{ route('midwife.spec-resident', ['resident' => $enrolledResident->resident->id]) }}'"><u>Resident #{{ $enrolledResident->resident->id }}</u></p> 
                        </div>
                    </div>

                    <!-- Right Column (Resident Info) -->
                 <div class="col-span-1 xl:col-span-2 h-full bg-f7 rounded-lg px-6 sm:px-10 lg:px-12 py-8">
                    <!-- Header -->
                    <div class="flex items-center gap-2 mb-6">
                        <h2 class="text-xl font-semibold text-main_font">Resident Info</h2>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 gap-y-4 text-xs">
                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">FIRST NAME:</p>
                            <p class="text-normal_font">{{ $enrolledResident->resident->firstName }}</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">LAST NAME:</p>
                            <p class="text-normal_font">{{ $enrolledResident->resident->lastName }}</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">MIDDLE NAME:</p>
                            <p class="text-normal_font">{{ $enrolledResident->resident->middleName }}</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">SUFFIX:</p>
                            <p class="text-normal_font">{{ $enrolledResident->resident->suffix ? $enrolledResident->resident->suffix : 'N/A' }}</p>
                        </div>

                        @php
                            $birthdate = \Carbon\Carbon::parse($enrolledResident->resident->birthdate);
                            $age = $birthdate->age; // auto-calculates from current date
                        @endphp

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">BIRTHDATE:</p>
                            <p class="text-normal_font">
                                {{ $birthdate->format('F d, Y') }} ({{ $age }} Years old)
                            </p>
                            </div>
                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">FAMILY #:</p>
                            <p class="text-normal_font">FAM-{{ str_pad($enrolledResident->resident->family->id, 3, '0', STR_PAD_LEFT) }}</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">SOCIO-ECONOMIC STATUS:</p>
                            <p class="text-normal_font">{{ $enrolledResident->resident->family->household->is_indigent === 1 ? 'NHTS' : 'Non-NHTS' }}</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">ADDRESS:</p>
                            <p class="text-normal_font">Household {{ $enrolledResident->resident->family->household->id }}, {{ $enrolledResident->resident->family->household->purok->name }}, {{ $enrolledResident->resident->family->household->purok->barangay->name }}, Daraga, Albay</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">STATUS:</p>
                            <p class="text-normal_font">{{ ucfirst($enrolledResident->status) }}</p>
                        </div>

                        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                            <p class="font-semibold text-main_font">ENROLLMENT DATE:</p>
                            <p class="text-normal_font">{{ $enrolledResident->created_at->format('F d, Y') }}</p>
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
                                <th scope="col" class="px-6 py-3">EXPECTED SCHEDULE</th>
                                <th scope="col" class="px-6 py-3">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrolledResident->consultations as $consultation)
                                @php
                                    $today = \Carbon\Carbon::now('Asia/Manila')->startOfDay();
                                    $consultationDate = \Carbon\Carbon::parse($consultation->consultation_date);

                                    $statusText = '';
                                    $statusColorClass = '';

                                    if ($consultation->status === 'completed') {
                                        $statusText = 'Completed';
                                        $statusColorClass = 'bg-green-100 text-green-800';
                                    } elseif ($consultation->status === 'pending') {
                                        if ($consultationDate->lt($today)) {
                                            $statusText = 'Late';
                                            $statusColorClass = 'bg-red-100 text-red-800';
                                        } else {
                                            $statusText = 'Ongoing';
                                            $statusColorClass = 'bg-blue-100 text-blue-800';
                                        }
                                    }
                                @endphp

                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    {{-- Consultation Title --}}
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                                        {{ $consultation->consultation_title }}
                                    </th>

                                    {{-- Completed Date (if applicable) --}}
                                    <td class="px-6 py-4">
                                        {{ $consultation->status === 'completed' ? $consultation->updated_at->format('M d, Y') : '--' }}
                                    </td>

                                    {{-- Placeholder (replace with actual if needed) --}}
                                    <td class="px-6 py-4">--</td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 font-semibold text-xs rounded-full {{ $statusColorClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>

                                    {{-- Consultation Date --}}
                                    <td class="px-6 py-4">
                                        {{ $consultationDate->format('M d, Y') }}
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <button
                                            class="bg-mainblue text-white px-3 py-1 rounded-md text-xs font-semibold 
                                            {{ $consultationDate->gt(now()) ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $consultationDate->gt(now()) ? 'disabled' : '' }}
                                        >
                                            UPDATE
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
