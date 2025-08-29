@section('page-id', 'dashboard')
<x-app-layout>
    @section('title', 'Barangays')
    <div class="py-12 px-5">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Barangays</h1>
            <div class="bg-f7 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-rows-1 gap-1">
                        <div class="pb-6">
                            <div class="flex flex-col slg2:flex-row slg2:flex-nowrap items-end gap-4">
                                <div class="w-full slg2:flex-grow slg2:max-w-md">
                                    <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for barangay?</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row flex-wrap gap-4 items-end slg2:flex-shrink-0">
                                    <div class="w-full sm:w-48">
                                        <label for="categoryDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by</label>
                                        <button id="categoryDropdown" data-dropdown-toggle="categoryDropdownMenu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        Alphabetical
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                        </button>
                                    </div>

                                    <div class="w-full sm:w-48">
                                        <label for="dateDropdown" class="mb-2 text-sm font-medium text-main_font">Sort By Date</label>
                                        <button id="dateDropdown" data-dropdown-toggle="dateDropdownMenu" class="w-full text-main_font bg-f7 focus:outline-none font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]" type="button">
                                        All Date
                                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                        </svg>
                                        </button>
                                    </div>

                                    <div class="w-full sm:w-40 pt-5 sm:pt-0">
                                        <button type="button" id="page-add-barangay-button" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3">Add Barangay</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
                                <thead class="text-xs text-main_font uppercase text-center" >
                                    <tr>
                                        <th scope="col" class="px-6 py-3">BARANGAY #</th>
                                        <th scope="col" class="px-6 py-3">NAME</th>
                                        <th scope="col" class="px-6 py-3">NO. OF PUROK</th>
                                        <th scope="col" class="px-6 py-3">NO. OF RESIDENTS</th>
                                        <th scope="col" class="px-6 py-3">DATE ADDED</th>
                                        <th scope="col" class="px-6 py-3">DATE UPDATED</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($barangays as $barangay)
                                            <tr class="bg-white border-b bg-f7 text-normal_font text-center cursor-pointer hover:bg-gray-100" 
                                                    onclick="window.location='{{ route('mho.barangays.show', ['barangay' => $barangay->id, 'name' => Str::slug($barangay->name)]) }}'"
                                                >                                            
                                            <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                                                {{ $barangay->id }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $barangay->name }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{-- Make sure this matches your controller variable --}}
                                                {{ $barangay->puroks_count ?? $barangay->number_of_puroks }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{-- Make sure this matches your controller variable --}}
                                                {{ number_format($barangay->residents_count ?? $barangay->number_of_residents) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $barangay->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $barangay->updated_at->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        {{-- This is the corrected empty state --}}
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
            </div>
        </div>
    </div>
    @include('components.modals.add-barangay-modal')
</x-app-layout>