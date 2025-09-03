@section('page-id', 'spec-brgy')
@section('title', 'Brgy. ' . $barangay->name)

<x-app-layout>
     <script>
         window.brgy_name = @json($barangay->name);
    </script>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('mho.barangays') }}">
                    <div class="flex items-center space-x-2"> <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span class="font-semibold">Return</span>
                    </div>
                </a>

               
                <div class="grid grid-cols-1 slg:grid-cols-3 gap-3 h-96">
                   
                    <div class="flex flex-col col-span-1">
                        
                        <div class="bg-white rounded-lg flex flex-col items-center justify-center p-4 flex-grow mb-4">
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44"
                                viewBox="0 0 24 24" fill="#A0A0A0" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10"></circle>
                            </svg>
                             <h1 class="text-main_font font-bold mt-3 text-xl">Brgy. {{ $barangay->name }}</h1>
                            <p class="text-normal_font font-bold">Brgy #{{ $barangay->id }}</p> 
                        </div>

                        
                        <div class="grid grid-cols-1 slg: grid-cols-2 gap-3 w-full">
                            <button id="edit-brgy-button" type="button" class="flex-1 px-5 py-3 text-sm font-medium text-white bg-mainblue rounded-lg hover:bg-blue-700 col-span-1">Edit</button>
                            <button id="remove-brgy-button" type="button" class="flex-1 px-5 py-3 text-sm font-medium text-mainblue bg-white border border-mainblue rounded-lg hover:bg-blue-50 col-span-1">Remove</button>
                        </div>
                    </div>

                    
                    <div class="flex-grow bg-white rounded-lg p-12 col-span-2">
                        <div class="flex items-center space-x-2 mb-4">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="#578FCA" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12ZM12 14C7.45 14 4 15.8 4 18V20H20V18C20 15.8 16.55 14 12 14Z"></path>
                            </svg>
                            <h2 class="text-xl font-semibold text-main_font">Barangay Info</h2>
                        </div>
                        <div class="grid grid-cols-1 gap-y-4 text-xs">
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">NAME:</p>
                                <p class="text-normal_font">{{ $barangay->name }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">NO. OF PUROKS:</p>
                                <p class="text-normal_font">{{ $barangay->puroks->count() }}</p>
                            </div>

                             <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">NO. OF RESIDENTS:</p>
                                <p class="text-normal_font">{{ number_format($barangay->residents_count) }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">NO. OF HOUSEHOLDS:</p>
                                <p class="text-normal_font">{{ number_format($barangay->households_count) }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">NO. OF FAMILIES:</p>
                                <p class="text-normal_font">{{ number_format($barangay->families_count) }}</p>
                            </div>
                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">ASSIGNED MIDWIFE:</p>
                                <p class="text-normal_font">{{ $barangay->assigned_midwife }}</p>
                            </div>

                            <div class="grid grid-rows-2 md:grid-cols-3 md:grid-rows-1">
                                <p class="font-semibold text-main_font">DATE ADDED:</p>
                                <p class="text-normal_font">{{ $barangay->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <x-barangay.purok-table :puroks="$barangay->puroks" :barangay="$barangay"/>
            </div>
        </div>
    </div>
    <div id="purok-page-container" data-barangay-id="{{ $barangay->id }}">
    </div>
    @include('components.modals.barangay.edit-barangay-modal')
    @include('components.modals.barangay.remove-barangay-modal')
</x-app-layout>