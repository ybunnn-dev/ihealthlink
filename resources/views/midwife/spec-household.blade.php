@section('title', 'Households | #134')
<x-app-layout>
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4">
                <a href="{{ route('midwife.households') }}">
                    <div class="flex items-center space-x-2"> <svg class="w-5 h-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 1H4L0 5L4 9H5V6H11C12.6569 6 14 7.34315 14 9C14 10.6569 12.6569 12 11 12H4V14H11C13.7614 14 16 11.7614 16 9C16 6.23858 13.7614 4 11 4H5V1Z" fill="#323643"></path> </g></svg>
                        <span class="font-semibold">Return</span>
                    </div>
                </a>
                <div class="grid grid-cols-1 slg:grid-cols-3 gap-4">
                    <div class="cols-span-1 grid grid-rows-6 gap-3">
                        <div class="row-span-5 h-80 bg-f7 rounded-lg flex flex-col items-center justify-center p-4"> 
                            <svg class="flex-shrink-0
                                        w-32 h-32 lg:w-40 lg:h-40 xl2:w-44 xl2:h-44 text-main_font"

                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M22 21.2488H21V9.97875C21 9.35875 20.72 8.77875 20.23 8.39875L19 7.43875L18.98 4.98875C18.98 4.43875 18.53 3.99875 17.98 3.99875H14.57L13.23 2.95875C12.51 2.38875 11.49 2.38875 10.77 2.95875L3.77 8.39875C3.28 8.77875 3 9.35875 3 9.96875L2.95 21.2488H2C1.59 21.2488 1.25 21.5888 1.25 21.9988C1.25 22.4088 1.59 22.7488 2 22.7488H22C22.41 22.7488 22.75 22.4088 22.75 21.9988C22.75 21.5888 22.41 21.2488 22 21.2488ZM6.5 12.7487V11.2487C6.5 10.6987 6.95 10.2487 7.5 10.2487H9.5C10.05 10.2487 10.5 10.6987 10.5 11.2487V12.7487C10.5 13.2987 10.05 13.7487 9.5 13.7487H7.5C6.95 13.7487 6.5 13.2987 6.5 12.7487ZM14.5 21.2488H9.5V18.4987C9.5 17.6687 10.17 16.9987 11 16.9987H13C13.83 16.9987 14.5 17.6687 14.5 18.4987V21.2488ZM17.5 12.7487C17.5 13.2987 17.05 13.7487 16.5 13.7487H14.5C13.95 13.7487 13.5 13.2987 13.5 12.7487V11.2487C13.5 10.6987 13.95 10.2487 14.5 10.2487H16.5C17.05 10.2487 17.5 10.6987 17.5 11.2487V12.7487Z" fill="currentColor"></path>
                                </g>
                            </svg>
                            <p class="text-main_font font-bold mt-2">Household #144</p> 
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 w-full px-0 pb-0 row-span-1 gap-3"> 
                            <button id="edit-med-btn" 
                                    type="button" 
                                    class="edit-medicine-btn col-span-1 px-5 py-3 text-sm font-medium text-white bg-mainblue rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300"
                                >
                                Edit
                            </button>   
                                            
                            <button id="remove-med-btn" 
                                    type="button" 
                                    class="remove-medicine-btn col-span-1 px-5 py-3 text-sm font-medium text-mainblue bg-white border border-mainblue rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-300">
                                Remove
                            </button>
                        </div>
                    </div>
                    <div class="flex-grow h-full bg-f7 rounded-lg px-12 py-8 col-span-2">
                        <h2 class="text-xl font-semibold text-main_font mb-6">Household Info</h2>
                        <div class="grid grid-cols-[auto_1fr] gap-x-24 gap-y-3 text-xs">
                            <p class="font-semibold text-main_font">SITIO/PUROK:</p>
                            <p class="text-normal_font">{{ $purok->name }}</p>

                            <p class="font-semibold text-main_font">NUMBER OF FAMILIES:</p>
                            <p class="text-normal_font">6</p>

                            <p class="font-semibold text-main_font">HOUSEHOLD HEAD:</p>
                            <p class="text-normal_font">Ron Peter Mortega</p>

                            <p class="font-semibold text-main_font">SOURCE OF WATER:</p>
                            <p class="text-normal_font">{{ $household->water_source }}</p>

                            <p class="font-semibold text-main_font">HAVE A TOILET:</p>
                            <p class="text-normal_font">{{ $household->has_toilet == 1 ? 'Yes' : 'No' }}</p>

                            <p class="font-semibold text-main_font">DATE ADDED:</p>
                                <p class="text-normal_font">
                                    {{ $household->created_at->format('F d, Y, h:i A') }}
                                </p>

                                <p class="font-semibold text-main_font">DATE UPDATED:</p>
                                <p class="text-normal_font">
                                    {{ $household->updated_at->format('F d, Y, h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="bg-f7 rounded-xl overflow-hidden col-span-2">
                        <div class="p-8 pt-10">
                            <div class="grid grid-cols-2 gap-1 mb-6 items-center">
                                <h1 class="text-2xl font-semibold text-sub_blue">Families</h1>
                                <!-- Flex container -->
                                <div class="flex flex-col slg2:flex-row slg2:items-end gap-4 justify-end">  
                                    <!-- Add Household Button -->
                                    <div class="w-full xs:w-40 pt-5 xs:pt-0">
                                        <button type="button" class="w-full h-[2rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3">Add Family</button>
                                    </div>
                                </div>
                            </div>
                            <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                                    <thead class="text-xs text-main_font uppercase">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                FAMILY #
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                FAMILY HEAD
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                4PS MEMBER
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                INDIGENT
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                ACTION
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b bg-f7 text-normal_font">
                                            <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                                                001
                                            </th>
                                            <td class="px-6 py-4">
                                                Ron Peter Mortega
                                            </td>
                                            <td class="px-6 py-4">
                                                Yes
                                            </td>
                                            <td class="px-6 py-4">
                                                Yes
                                            </td>
                                            <td class="px-6 py-4">
                                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">
                                                    View
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('components.modals.add-family-modal')
</x-app-layout>