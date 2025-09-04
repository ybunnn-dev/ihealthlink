<div class="col-span-1">

    <script>
         window.initialPurokData = @json($puroks);
    </script>
    
    <h2 class="text-2xl font-semibold text-main_font mt-4 mb-4">Puroks in Brgy. {{ $barangay->name }}</h2>

    <div class="bg-white p-6 rounded-xl">
        <div class="flex flex-col slg2:flex-row slg2:items-end gap-4 mb-4">
             <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
                <label for="purok-search" class="mb-2 text-sm font-medium text-main_font">Search Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="purok-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search...">
                </div>
            </div>

            <div class="w-full xs:w-48">
                <label for="purokDateDropdown" class="mb-2 text-sm font-medium text-main_font">Filter By Date</label>
                <button id="purokDateDropdown" data-dropdown-toggle="purokDateDropdownMenu" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                    All Date
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <div id="purokDateDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg w-44">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="purokDateDropdown">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100" data-value="all">All Date</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100" data-value="last_week">Last Week</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100" data-value="last_month">Last Month</a></li>
                    </ul>
                </div>
            </div>

            <div class="w-full sm:w-40 pt-5 sm:pt-0">
                <button type="button" id="page-add-purok-button" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3">Add Purok</button>
            </div>
        </div>

        <div class="relative overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-left text-main_font">
                <thead class="text-xs text-main_font uppercase bg-col_tab_h text-center">
                    <tr>
                        <th scope="col" class="px-6 py-3">PUROK ID</th>
                        <th scope="col" class="px-6 py-3">NAME</th>
                        <th scope="col" class="px-6 py-3">NO. OF HOUSEHOLDS</th>
                        <th scope="col" class="px-6 py-3">NO. OF RESIDENTS</th>
                        <th scope="col" class="px-6 py-3">DATE ADDED</th>
                        <th scope="col" class="px-6 py-3">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="text-center" id="purok-table-body">
                    @forelse ($puroks as $purok)
                        <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $purok->id }}
                            </th>
                            <td class="px-6 py-4">{{ $purok->name }}</td>
                            <td class="px-6 py-4">{{ $purok->households_count }}</td>
                            <td class="px-6 py-4">{{ $purok->residents_count }}</td>
                            <td class="px-6 py-4">{{ $purok->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center space-x-4">
                                    {{-- MODIFIED EDIT BUTTON --}}
                                    <button type="button" 
                                            class="js-edit-purok-btn text-mainblue hover:text-blue-900" 
                                            data-purok-id="{{ $purok->id }}" 
                                            title="Edit Purok">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    {{-- MODIFIED DELETE BUTTON --}}
                                    <button type="button" 
                                            class="js-delete-purok-btn text-red1 hover:text-red-900" 
                                            data-purok-id="{{ $purok->id }}" 
                                            title="Delete Purok">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b bg-f7 text-normal_font text-center cursor-pointer hover:bg-gray-100">
                            {{-- This cell will span all 6 columns of your table --}}
                            <td colspan="6">
                                <div class="text-center py-10">
                                    <img src="{{ asset('images/illustrations/empty.png') }}" alt="No barangays found" class="mx-auto w-64">
                                    <p class="mt-5 text-lg font-medium text-gray-700">
                                        {{ $message ?? "Oops! You haven't added any barangay yet." }}
                                    </p>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Click the "Add Barangay" button to get started.
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
@include('components.modals.barangay.add-purok-modal')
@include('components.modals.barangay.edit-purok-modal')
@include('components.modals.barangay.remove-purok')