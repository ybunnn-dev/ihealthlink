@section('page-id', 'spec-med')
@section('title', $medicine->medicine_name)
<x-app-layout>
    <script>
         window.medicineData = @json($medicine);
    </script>
    <div class="py-12 px-5">
        
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('midwife.medicines') }}">
                    <div class="flex items-center space-x-2"> 
                        <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span class="font-semibold">Return</span>
                    </div>
                </a>
                
                <div class="grid grid-cols-1 slg:grid-cols-3 gap-3">
                    <div class="grid grid-rows-5 col-span-1 gap-3">
                        <div class="w-full h-full bg-f7 rounded-lg flex flex-col items-center justify-center p-4 row-span-4"> 
                            <svg class="flex-shrink-0 w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font mb-3"
                                version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                                <g>
                                    <path d="M358.359,23.406C358.359,10.484,347.875,0,334.953,0H177.047c-12.922,0-23.406,10.484-23.406,23.406v50.234 h204.719V23.406z"></path>
                                    <path d="M371.188,162.453c-20.766-10.391-27.703-34.641-27.703-55.422c0-1.344,0-3.328,0-5.875 c0-0.938,0-1.813,0-2.938H168.516c0,1.125,0,2,0,2.938c0,0.313,0,1.969,0,5.875c0,20.781-6.938,45.031-27.703,55.422 c-24.813,12.391-35.219,30.859-35.219,74.969c0,15.734,0,162.766,0,187.969c0,42.516,29.922,86.609,89.781,86.609h121.25 c59.859,0,89.781-44.094,89.781-86.609c0-25.203,0-172.234,0-187.969C406.406,193.313,396,174.844,371.188,162.453z M357.156,406.719H154.844V241.547h202.313V406.719z"></path>
                                    <polygon points="238.688,386.922 273.297,386.922 273.297,345.828 314.375,345.828 314.375,311.25 273.297,311.25 273.297,270.156 238.688,270.156 238.688,311.25 197.625,311.25 197.625,345.828 238.688,345.828 "></polygon>
                                </g>
                            </svg>
                            <p class="text-main_font font-bold">{{ $medicine->medicine_name }}</p>
                            <p class="text-main_font font-medium">Medicine #{{ $medicine->id }}</p>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 w-full px-0 pb-0 row-span-1 gap-3"> 
                            <button id="edit-med-btn" 
                                    type="button" 
                                    class="edit-medicine-btn col-span-1 px-5 py-3 text-sm font-medium rounded-lg focus:outline-none focus:ring-4 
                                        text-white bg-mainblue border border-mainblue
                                        {{ $medicine->default_status == 1 
                                             ? 'opacity-50 cursor-not-allowed' 
                                            : 'opacity-100 hover:bg-blue-50 focus:ring-300' }}"
                                    data-id="{{ $medicine->id }}"
                                    {{ $medicine->default_status == 1 ? 'disabled' : '' }}>
                                Edit
                            </button>   

                            @include('components.modals.medicine.edit-medicine-modal')       
                                        
                            <button id="remove-med-btn" 
                                    type="button" 
                                    class="remove-medicine-btn col-span-1 px-5 py-3 text-sm font-medium rounded-lg focus:outline-none focus:ring-4 
                                            text-mainblue bg-white border border-mainblue 
                                        {{ $medicine->default_status == 1 
                                            ? 'opacity-50 cursor-not-allowed' 
                                            : 'opacity-100 hover:bg-blue-50 focus:ring-300' }}"
                                    {{ $medicine->default_status == 1 ? 'disabled' : '' }}>
                                Remove
                            </button>
                            
                            @include('components.modals.medicine.remove-medicine')
                        </div>
                    </div>
                    <div class="flex-grow h-full bg-f7 rounded-lg p-12 col-span-1 slg:col-span-2">
                        <h2 class="text-xl font-semibold text-main_font mb-6">Medicine Info</h2>
                        <div class="grid grid-cols-[auto_1fr] gap-x-12 gap-y-3 text-normal_font text-sm">
                            <p class="font-medium">MEDICINE NAME:</p>
                            <p>{{ $medicine->medicine_name }}</p>

                            <p class="font-medium">GENERIC NAME:</p>
                            <p>{{ $medicine->generic_name ?? 'N/A' }}</p>

                            <p class="font-medium">CATEGORY:</p>
                            <p>{{ $medicine->category_display }}</p>

                            <p class="font-medium">FORM:</p>
                            <p>{{ $medicine->form }}</p>

                            <p class="font-medium">DESCRIPTION:</p>
                            <p>{{ $medicine->description ?? 'No description available' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-f7 rounded-xl overflow-hidden">
                    <div class="p-8 pt-10">
                        <div class="grid grid-rows-1 gap-1">
                            <h1 class="text-2xl font-semibold text-sub_blue mb-3">Medicine Inventory</h1>
                            <div class="pb-6">
                                <!-- Flex container -->
                                <div class="flex flex-col slg2:flex-row slg2:items-end gap-4">
                                    <div class="w-full xs:w-40 pt-5 xs:pt-0">
                                        <button type="button" id="add-batch-tigger" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3" >+   Add Batch</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Dropdown menus -->
                            <div id="statusDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Expired</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Near Expiration</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Good</a></li>
                            </ul>
                            </div>

                            <div id="dateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Week</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Last Year</a></li>
                            </ul>
                        </div>
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                                <thead class="text-xs text-main_font uppercase text-center">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            BATCH ID
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            QUANTITY RECEIVED
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            REMAINING
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            DATE ADDED
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            EXPIRY DATE
                                        </th>
                                    
                                        <th scope="col" class="px-6 py-3">
                                            STATUS
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($inventories as $inventory)
                                        <tr class="bg-white border-b text-normal_font text-center">
                                            <td class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                                {{ $inventory->id }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $inventory->quantity_received }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $inventory->stock }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $inventory->date_received->format('F j, Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $inventory->expiry_date->format('F j, Y') }}
                                            </td>
                                            <td class="px-6 py-4 bg-f7">
                                                @if($inventory->is_expired)
                                                    <span class="bg-red-100 border-1 border-red-500 text-red-800 text-xs font-medium px-2 py-1 rounded-full w-32 text-center inline-block">
                                                        Expired
                                                    </span>
                                                @elseif($inventory->is_expiring_soon)
                                                    <span class="bg-yellow-100 border-1 border-yellow-500 text-yellow-800 text-xs font-medium px-2 py-1 rounded-full w-32 text-center inline-block">
                                                        Near Expiration
                                                    </span>
                                                @else
                                                    <span class="bg-green-100 border-1 border-green-500 text-green-800 text-xs font-medium px-2 py-1 rounded-full w-32 text-center inline-block">
                                                        Good
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="border-b bg-f7 text-normal_font text-center cursor-pointer hover:bg-gray-100">
                                            {{-- This cell will span all 6 columns of your table --}}
                                            <td colspan="7">
                                                <div class="text-center py-10">
                                                    <img src="{{ asset('images/illustrations/empty.png') }}" alt="No barangays found" class="mx-auto w-64">
                                                    <p class="mt-5 text-lg font-medium text-gray-700">
                                                        {{ $message ?? "Oops! You haven't added any barangay yet." }}
                                                    </p>
                                                    <p class="mt-2 text-sm text-gray-500">
                                                        Click the "Add Medicine" button to get started.
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
        @include('components.modals.medicine.confirm-batch')
        @include('components.modals.medicine.add-medicine-batch')
    
</x-app-layout>