@section('title', 'Family | #'.$family->id)
@section('page-id', 'spec-family')
<x-app-layout>
    <script>
        window.family = @json($family);
    </script>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ request('return', route('midwife.households')) }}">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"/>
                        </svg>
                        <span class="font-semibold">Return</span>
                    </div>
                </a>
                    
                <div class="grid grid-cols-1 slg:grid-cols-3 gap-4">
                    <div class="col-span-1 flex flex-col gap-3">
                        <div class="h-80 bg-f7 rounded-lg flex flex-col items-center justify-center p-4"> 
                            <svg class="flex-shrink-0
                                    w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="currentColor">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:currentColor} </style> 
                                    <g> 
                                        <path class="st0" d="M78.641,118.933c22.88,0,41.416-18.551,41.416-41.414c0-22.887-18.536-41.423-41.416-41.423 c-22.887,0-41.422,18.536-41.422,41.423C37.218,100.382,55.754,118.933,78.641,118.933z"></path> 
                                        <path class="st0" d="M255.706,228.73v0.062c0.101,0,0.194-0.031,0.294-0.031c0.101,0,0.194,0.031,0.294,0.031v-0.062 c15.562-0.317,28.082-12.976,28.082-28.601c0-15.648-12.52-28.299-28.082-28.616v-0.063c-0.101,0-0.194,0.031-0.294,0.031 c-0.1,0-0.193-0.031-0.294-0.031v0.063c-15.563,0.317-28.082,12.968-28.082,28.616C227.623,215.754,240.143,228.413,255.706,228.73 z"></path> 
                                        <path class="st0" d="M433.359,118.933c22.887,0,41.423-18.551,41.423-41.414c0-22.887-18.536-41.423-41.423-41.423 c-22.88,0-41.416,18.536-41.416,41.423C391.944,100.382,410.48,118.933,433.359,118.933z"></path> 
                                        <path class="st0" d="M470.097,138.553h-36.312h-18.404c-21.106,0-40.432,11.831-50.033,30.622l-33.494,97.967 c-1.154,2.246-3.298,3.84-5.792,4.282c-2.493,0.442-5.048-0.309-6.914-2.036l-20.836-18.04c-6.233-5.769-14.408-8.973-22.902-8.973 H256h-19.41c-8.494,0-16.669,3.204-22.902,8.973l-20.835,18.04c-1.866,1.727-4.421,2.478-6.914,2.036 c-2.492-0.442-4.637-2.036-5.791-4.282l-33.495-97.967c-9.6-18.791-28.926-30.622-50.032-30.622H78.215H41.902 C21.834,138.553,0,160.387,0,180.464v139.211c0,10.034,8.13,18.171,18.164,18.171c4.939,0,0,0,12.682,0l6.906,118.725 c0,10.676,8.664,19.332,19.34,19.332c4.506,0,12.814,0,21.122,0c8.308,0,16.616,0,21.122,0c10.676,0,19.34-8.656,19.34-19.332 l6.906-118.725l-0.085-84.766c0-1.339,0.914-2.493,2.222-2.818c1.309-0.31,2.648,0.309,3.26,1.502l26.572,65.401 c3.206,6.256,9.152,10.654,16.074,11.885c6.922,1.231,14.022-0.844,19.186-5.613l25.426-18.729 c0.852-0.782,2.083-0.984,3.136-0.542c1.061,0.473,1.743,1.518,1.743,2.663l0.093,73.508l4.777,82.187 c0,7.387,6.001,13.379,13.395,13.379c3.113,0,8.865,0,14.618,0c5.753,0,11.506,0,14.618,0c7.394,0,13.394-5.992,13.394-13.379 l4.778-82.187l0.093-73.508c0-1.146,0.681-2.19,1.742-2.663c1.053-0.442,2.284-0.24,3.136,0.542l25.427,18.729 c5.164,4.769,12.264,6.844,19.186,5.613c6.922-1.231,12.868-5.629,16.073-11.885l26.573-65.401 c0.611-1.192,1.951-1.812,3.259-1.502c1.309,0.325,2.222,1.478,2.222,2.818l-0.085,84.766l6.906,118.725 c0,10.676,8.664,19.332,19.341,19.332c4.507,0,12.814,0,21.122,0c8.308,0,16.616,0,21.121,0c10.677,0,19.342-8.656,19.342-19.332 l6.906-118.725c12.682,0,7.742,0,12.682,0c10.034,0,18.164-8.137,18.164-18.171V180.464 C512,160.387,490.166,138.553,470.097,138.553z"></path> 
                                    </g> 
                                </g>
                            </svg>
                            <p class="text-main_font font-bold mt-2">Family #{{ $family->id }}</p> 
                        </div>
                        
                        <!-- Buttons Container -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 w-full px-0 pb-0 gap-3"> 
                            <button id="edit-fam-btn" 
                                    type="button" 
                                    class="edit-household col-span-1 px-5 py-3 text-sm font-medium text-white bg-mainblue rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300"
                                >
                                Edit
                            </button>   
                                            
                            <button id="set-stat-btn" 
                                    type="button" 
                                    class=" col-span-1 px-5 py-3 text-sm font-medium text-mainblue bg-white border border-mainblue rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-300">
                                Set Status
                            </button>
                        </div>
                    </div>
                    <div class="flex-grow h-full bg-f7 rounded-lg px-12 py-8 col-span-2">
                        <h2 class="text-xl font-semibold text-main_font mb-6">Family Info</h2>
                        <div class="grid grid-cols-[auto_1fr] gap-x-24 gap-y-3 text-xs">
                            <p class="font-semibold text-main_font">PUROK NO.</p>
                            <p class="text-normal_font">{{ $purok->name }}</p>

                            <p class="font-semibold text-main_font">NUMBER OF RESIDENTS:</p>
                            <p class="text-normal_font">{{ $residentCount }}</p>

                            <p class="font-semibold text-main_font">HOUSEHOLD NUMBER:</p>
                            <a href="{{ route('midwife.spec-household', $family->household_id) }}"><u><p class="text-normal_font">Household #{{ $family->household_id }}</p></u></a>

                            <p class="font-semibold text-main_font">4PS MEMBER:</p>
                            <p class="text-normal_font">{{ $family->is_4ps ? 'Yes' : 'No' }}</p>

                            <p class="font-semibold text-main_font">INDIGENT:</p>
                            <p class="text-normal_font">{{ $family->is_indigent ? 'Yes' : 'No' }}</p>

                            <p class="font-semibold text-main_font">WALANG GUTOM PROGRAM:</p>
                            <p class="text-normal_font">{{ $family->is_iwas_gutom ? 'Enrolled' : 'Not Enrolled' }}</p>

                            <p class="font-semibold text-main_font">DATE ADDED:</p>
                            <p class="text-normal_font">{{ $family->created_at->format('F d, Y') }}</p>

                            <p class="font-semibold text-main_font">DATE UPDATED:</p>
                            <p class="text-normal_font">{{ $family->updated_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="bg-f7 rounded-xl overflow-hidden col-span-2">
                        <div class="p-4 md:p-8 md:pt-10">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                                <h1 class="text-2xl font-semibold text-sub_blue">Family Members</h1>
                                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">  
                                    <button id="add-ex" type="button" 
                                        class="w-full sm:w-auto h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-5 flex items-center justify-center transition-colors">
                                        Transfer Resident
                                    </button>
                                    <button id="add-new" type="button" 
                                        class="w-full sm:w-auto h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-5 flex items-center justify-center transition-colors">
                                        Add Member
                                    </button>
                                </div>
                            </div>

                            <div class="relative overflow-x-auto rounded-lg">
                                <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                                    <thead class="text-xs text-main_font uppercase">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                RESIDENT #
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                NAME
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                AGE
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                STATUS
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                ACTION
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                        @forelse($family->residents as $resident)
                                            @php
                                                // Parse dates safely
                                                $birthdate = \Carbon\Carbon::parse($resident->birthdate);
                                                $now = \Carbon\Carbon::now();

                                                // Force integer age values
                                                $years = (int) floor($birthdate->diffInYears($now, false));
                                                $totalMonths = (int) floor($birthdate->diffInMonths($now, false));
                                                $months = $totalMonths % 12;
                                                $days = (int) floor($birthdate->diffInDays($now, false));
                                            @endphp
                                            <tr class="bg-white border-b bg-f7 text-normal_font">
                                                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                                                {{ $resident->id }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ $resident->firstName }} {{ $resident->middleName }} {{ $resident->lastName }} {{ $resident->suffix ? $resident->suffix : '' }} 
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if ($years >= 1)
                                                        {{ $years }} year{{ $years > 1 ? 's' : '' }}
                                                    @elseif ($months >= 1)
                                                        {{ $months }} month{{ $months > 1 ? 's' : '' }}
                                                    @elseif ($days < 30)
                                                        Newborn
                                                    @else
                                                        0 months
                                                    @endif

                                                </td>
                                                <td class="px-6 py-4 bg-f7">
                                                    @if($resident->status === 'active')
                                                        <span class="bg-green-100 border-1 border-green-500 text-green-800 text-xs font-medium px-2 py-1 rounded-full w-32 text-center inline-block">
                                                            Active
                                                        </span>
                                                    @elseif($resident->status === 'deceased')
                                                        <span class="bg-yellow-100 border-1 border-yellow-500 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full w-32 text-center inline-block">
                                                            Deceased
                                                        </span>
                                                    @else
                                                        <span class="bg-yellow-100 border-1 border-yellow-500 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full w-32 text-center inline-block">
                                                            Migrated
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4">
                                                    <button
                                                        onclick="window.location='{{ route('midwife.spec-resident', ['resident' => $resident->id, 'return' => url()->current()]) }}'"
                                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">
                                                        View
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="bg-white border-b">
                                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                                    <div class="text-center py-10">
                                                        <img src="{{ asset('images/illustrations/empty.png') }}" alt="No barangays found" class="mx-auto w-64">
                                                        <p class="mt-5 text-lg font-medium text-gray-700">
                                                            {{ $message ?? "Oops! You haven't added any family member yet." }}
                                                        </p>
                                                        <p class="mt-2 text-sm text-gray-500">
                                                            Click the "Add Family" button to get started.
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
        </div>
        @include('components.modals.family.add-existing-resident')
        @include('components.modals.resident.add-resident-modal')
        @include('components.modals.family.edit-family')
        @include('components.modals.family.set-status')
</x-app-layout>