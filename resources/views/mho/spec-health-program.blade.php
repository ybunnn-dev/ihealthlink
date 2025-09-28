@section('page-id', 'spec-hp')
@section('title', $healthProgram->name)
<x-app-layout>
     <script>
    
    </script>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('mho.health-programs') }}">
                    <div class="flex items-center space-x-2"> <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span class="font-semibold">Return</span>
                    </div>
                </a>

               
                <div class="grid grid-cols-1 slg:grid-cols-3 gap-3 h-96">
                   
                    <div class="flex flex-col col-span-1">
                        
                        <div class="bg-white rounded-lg flex flex-col items-center justify-center p-4 flex-grow mb-4">
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font"

                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 11.75C12.4142 11.75 12.75 12.0858 12.75 12.5V13.25H13.5C13.9142 13.25 14.25 13.5858 14.25 14C14.25 14.4142 13.9142 14.75 13.5 14.75H12.75V15.5C12.75 15.9142 12.4142 16.25 12 16.25C11.5858 16.25 11.25 15.9142 11.25 15.5V14.75H10.5C10.0858 14.75 9.75 14.4142 9.75 14C9.75 13.5858 10.0858 13.25 10.5 13.25H11.25V12.5C11.25 12.0858 11.5858 11.75 12 11.75Z" fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.948 1.25C11.0495 1.24997 10.3003 1.24995 9.70552 1.32991C9.07773 1.41432 8.51093 1.59999 8.05546 2.05546C7.59999 2.51093 7.41432 3.07773 7.32991 3.70552C7.24995 4.3003 7.24997 5.04952 7.25 5.948L7.25 6.02572C5.22882 6.09185 4.01511 6.32803 3.17157 7.17158C2 8.34315 2 10.2288 2 14C2 17.7712 2 19.6569 3.17157 20.8284C4.34314 22 6.22876 22 9.99998 22H14C17.7712 22 19.6569 22 20.8284 20.8284C22 19.6569 22 17.7712 22 14C22 10.2288 22 8.34315 20.8284 7.17158C19.9849 6.32803 18.7712 6.09185 16.75 6.02572L16.75 5.94801C16.75 5.04954 16.7501 4.3003 16.6701 3.70552C16.5857 3.07773 16.4 2.51093 15.9445 2.05546C15.4891 1.59999 14.9223 1.41432 14.2945 1.32991C13.6997 1.24995 12.9505 1.24997 12.052 1.25H11.948ZM15.25 6.00189V6C15.25 5.03599 15.2484 4.38843 15.1835 3.9054C15.1214 3.44393 15.0142 3.24644 14.8839 3.11612C14.7536 2.9858 14.5561 2.87858 14.0946 2.81654C13.6116 2.7516 12.964 2.75 12 2.75C11.036 2.75 10.3884 2.7516 9.90539 2.81654C9.44393 2.87858 9.24643 2.9858 9.11612 3.11612C8.9858 3.24644 8.87858 3.44393 8.81654 3.9054C8.75159 4.38843 8.75 5.03599 8.75 6V6.00189C9.14203 6 9.55807 6 10 6H14C14.4419 6 14.858 6 15.25 6.00189ZM16 14C16 16.2091 14.2091 18 12 18C9.79086 18 8 16.2091 8 14C8 11.7909 9.79086 10 12 10C14.2091 10 16 11.7909 16 14Z" fill="currentColor"></path>
                                </g>
                            </svg>
                             <h1 class="text-main_font font-bold mt-3 text-xl">{{ $healthProgram->name }}</h1>
                            <p class="text-normal_font font-bold">Program #{{ $healthProgram->id }}</p> 
                        </div>

                        
                        <div class="grid grid-cols-1 slg:grid-cols-2 gap-3 w-full">
                            <button id="edit-brgy-button" type="button" class="flex-1 px-5 py-3 text-sm font-medium text-white bg-mainblue rounded-lg hover:bg-blue-700 col-span-1">Edit</button>
                            <button id="remove-brgy-button" type="button" class="flex-1 px-5 py-3 text-sm font-medium text-mainblue bg-white border border-mainblue rounded-lg hover:bg-blue-50 col-span-1">Remove</button>
                        </div>
                    </div>

                    
                    <div class="flex-grow bg-white rounded-lg p-12 col-span-2">
                        <div class="flex items-center space-x-2 mb-4">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="#578FCA" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C7.45 14 4 15.8 4 18V20H20V18C20 15.8 16.55 14 12 14Z"></path>
                            </svg>
                            <h2 class="text-xl font-semibold text-main_font">Program Info</h2>
                        </div>
                        <div class="grid grid-cols-1 gap-y-4 text-xs">
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">NAME:</p>
                                <p class="text-normal_font">{{ $healthProgram->name }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">PROGRAM TYPE:</p>
                                <p class="text-normal_font">{{ $healthProgram->category ? ucfirst($healthProgram->category) : 'N/A' }}</p>
                            </div>

                             <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">NO. OF ENROLLED:</p>
                                <p class="text-normal_font">{{ number_format($healthProgram->residents_count ?? $healthProgram->residents_count) }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">RANGE OF AGE:</p>
                                <p class="text-normal_font">{{ $healthProgram->age_min ? $healthProgram->age_min : 'Undefined'}} - {{ $healthProgram->age_max ? $healthProgram->age_max : 'Undefined' }} years old</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">NO. OF CONSULTATIONS:</p>
                                <p class="text-normal_font">
                                    @switch($healthProgram->program_mode)
                                        @case('fixed')
                                            {{ $healthProgram->total_fields }}
                                            @break

                                        @case('continuous')
                                            Continuous
                                            @break

                                        @case('custom')
                                            {{ $healthProgram->total_fields }} (Custom)
                                            @break

                                        @default
                                            Unknown
                                    @endswitch
                                </p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">DATE ADDED:</p>
                                <p class="text-normal_font">{{ $healthProgram->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                 <x-healthProgram.fields :programfields="$healthProgram->programFields" :name="$healthProgram->name" />
            </div>
        </div>
    </div>
    
    </div>
   
</x-app-layout>