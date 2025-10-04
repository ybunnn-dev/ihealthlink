@section('title', 'Health Programs | #134')
@section('page-id', 'spec-enrolled')
<script>
    window.enrolledResident = @json($enrolledResident)
</script>
<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
             <a href="{{ route('midwife.health-program') }}">
                    <div class="flex items-center space-x-2 mb-3"> <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span class="font-semibold">Return</span>
                    </div>
                </a>

            <!-- START: Corrected Layout Structure -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-3 mb-4">
                
                <!-- Left Column Wrapper -->
                <div class="xl:col-span-1 flex flex-col gap-3">
                    <!-- Profile Card -->
                    <div class="bg-f7 rounded-lg flex flex-col items-center justify-center p-4"> 
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

                    <!-- Buttons -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 slg2:grid-cols-2 xl:grid-cols-1 gap-3"> 
                        <button id="update-bmi" type="button" class="max-h-20 w-full h-full text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3 py-4">
                            Update Health Record
                        </button>
                        <button id="track-consultation" type="button" class="max-h-20 w-full h-full text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3 py-4">
                            Track Progress
                        </button>
                        @if($enrolledResident->program->category === 'maternal_health_tcl')
                            <button id="update-maternal" type="button" class="max-h-20 w-full h-full text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3 py-4">
                                Update Maternal Record
                            </button>
                        @elseif($enrolledResident->program->category === 'child_healthcare_tcl')
                            <button id="update-child" type="button" class="max-h-20 w-full h-full text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3 py-4">
                                Update Child Immunization
                            </button>
                        @elseif($enrolledResident->program->category === 'philpen')
                            <button id="update-philpen" type="button" class="max-h-20 w-full h-full text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3 py-4">
                                Update PhilPen Record
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Right Column Wrapper -->
                <div class="xl:col-span-2 flex flex-col gap-6">
                    <!-- Resident Info Card -->
                    <div class="bg-f7 rounded-lg px-6 sm:px-10 lg:px-12 py-8">
                        <div class="flex items-center gap-2 mb-6">
                            <svg class="w-6 h-6 text-maingreen" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 11.75C12.4142 11.75 12.75 12.0858 12.75 12.5V13.25H13.5C13.9142 13.25 14.25 13.5858 14.25 14C14.25 14.4142 13.9142 14.75 13.5 14.75H12.75V15.5C12.75 15.9142 12.4142 16.25 12 16.25C11.5858 16.25 11.25 15.9142 11.25 15.5V14.75H10.5C10.0858 14.75 9.75 14.4142 9.75 14C9.75 13.5858 10.0858 13.25 10.5 13.25H11.25V12.5C11.25 12.0858 11.5858 11.75 12 11.75Z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M11.948 1.25C11.0495 1.24997 10.3003 1.24995 9.70552 1.32991C9.07773 1.41432 8.51093 1.59999 8.05546 2.05546C7.59999 2.51093 7.41432 3.07773 7.32991 3.70552C7.24995 4.3003 7.24997 5.04952 7.25 5.948L7.25 6.02572C5.22882 6.09185 4.01511 6.32803 3.17157 7.17158C2 8.34315 2 10.2288 2 14C2 17.7712 2 19.6569 3.17157 20.8284C4.34314 22 6.22876 22 9.99998 22H14C17.7712 22 19.6569 22 20.8284 20.8284C22 19.6569 22 17.7712 22 14C22 10.2288 22 8.34315 20.8284 7.17158C19.9849 6.32803 18.7712 6.09185 16.75 6.02572L16.75 5.94801C16.75 5.04954 16.7501 4.3003 16.6701 3.70552C16.5857 3.07773 16.4 2.51093 15.9445 2.05546C15.4891 1.59999 14.9223 1.41432 14.2945 1.32991C13.6997 1.24995 12.9505 1.24997 12.052 1.25H11.948ZM15.25 6.00189V6C15.25 5.03599 15.2484 4.38843 15.1835 3.9054C15.1214 3.44393 15.0142 3.24644 14.8839 3.11612C14.7536 2.9858 14.5561 2.87858 14.0946 2.81654C13.6116 2.7516 12.964 2.75 12 2.75C11.036 2.75 10.3884 2.7516 9.90539 2.81654C9.44393 2.87858 9.24643 2.9858 9.11612 3.11612C8.9858 3.24644 8.87858 3.44393 8.81654 3.9054C8.75159 4.38843 8.75 5.03599 8.75 6V6.00189C9.14203 6 9.55807 6 10 6H14C14.4419 6 14.858 6 15.25 6.00189ZM16 14C16 16.2091 14.2091 18 12 18C9.79086 18 8 16.2091 8 14C8 11.7909 9.79086 10 12 10C14.2091 10 16 11.7909 16 14Z" fill="currentColor"></path></g></svg>
                            <h2 class="text-xl font-semibold text-main_font">{{ $enrolledResident->program->name }}</h2>
                        </div>
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
                                <p class="text-normal_font">{{ $birthdate->format('F d, Y') }} ({{ $age }} Years old)</p>
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
                                <p class="font-semibold text-main_font">WEIGHT:</p>
                                <p class="text-normal_font">{{ $enrolledResident->resident->basicHealthRecord->weight ? $enrolledResident->resident->basicHealthRecord->weight : 'N\A' }} KG</p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">HEIGHT:</p>
                                <p class="text-normal_font">{{ $enrolledResident->resident->basicHealthRecord->height ? $enrolledResident->resident->basicHealthRecord->height : 'N\A'}} CM</p>
                            </div>
                           <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                                <p class="font-semibold text-main_font">BMI:</p>
                                @php
                                    $weight = $enrolledResident->resident->basicHealthRecord->weight ?? 0; // kg
                                    $heightCm = $enrolledResident->resident->basicHealthRecord->height ?? 0; // cm
                                    $heightM = $heightCm / 100;
                                    $bmi = $heightM > 0 ? $weight / ($heightM * $heightM) : 0;
                                    if ($bmi == 0) { $category = 'N/A'; } elseif ($bmi < 18.5) { $category = 'Underweight'; } elseif ($bmi < 25) { $category = 'Normal'; } elseif ($bmi < 30) { $category = 'Overweight'; } else { $category = 'Obese'; }
                                @endphp
                                <p class="text-normal_font">
                                    {{ number_format($bmi, 1) }}
                                    <span class="ml-2 font-semibold text-gray-600">({{ $category }})</span>
                                </p>
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
            </div>
            <!-- Activities and Follow-Up Table -->
                    <div class="bg-white rounded-xl overflow-hidden p-6">
                        <h2 class="text-2xl font-semibold text-main_font mb-4">Activities and Follow-Up</h2>
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-main_font">
                                <thead class="text-xs text-main_font uppercase bg-col_tab_h">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">ACTIVITY</th>
                                        <th scope="col" class="px-6 py-3">DATE COMPLETED</th>
                                        <th scope="col" class="px-6 py-3">STATUS</th>
                                        <th scope="col" class="px-6 py-3">EXPECTED SCHEDULE</th>
                                        <th scope="col" class="px-6 py-3">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrolledResident->consultations as $consultation)
                                        @php
                                            $consultationDate = null;
                                            if($consultation->consultation_date){
                                                $today = \Carbon\Carbon::now('Asia/Manila')->startOfDay();
                                                $consultationDate = \Carbon\Carbon::parse($consultation->consultation_date);
                                                $statusText = '';
                                                $statusColorClass = '';
                                                if ($consultation->status === 'completed') { $statusText = 'Completed'; $statusColorClass = 'bg-green-100 text-green-800'; } 
                                                elseif ($consultation->status === 'pending') {
                                                    if ($consultationDate->lt($today)) { $statusText = 'Late'; $statusColorClass = 'bg-red-100 text-red-800'; } 
                                                    else { $statusText = 'Ongoing'; $statusColorClass = 'bg-blue-100 text-blue-800'; }
                                                }
                                            }
                                        @endphp
                                        <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">{{ $consultation->consultation_title }}</th>
                                            <td class="px-6 py-4">{{ $consultation->status === 'completed' ? $consultation->updated_at->format('M d, Y') : '--' }}</td>
                                            <td class="px-6 py-4"><span class="px-2 py-1 font-semibold text-xs rounded-full {{ $statusColorClass }}">{{ $statusText }}</span></td>
                                            <td class="px-6 py-4">{{ $consultationDate ? $consultationDate->format('M d, Y') : '--' }}</td>
                                            <td class="px-6 py-4"><button class="bg-mainblue text-white px-3 py-1 rounded-md text-xs font-semibold">UPDATE</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

        </div>
    </div>
    <div id="program_type_content" class="hidden">{{ $enrolledResident->program->category }}</div>
    @if($enrolledResident->program->category === 'maternal_health_tcl')
        @include('components.modals.health-program.tcl-programs.update-maternity-record')
    @endif
</x-app-layout>
