@props(['programfields', 'name'])

<div class="col-span-1">
    <div class="flex justify-between items-center mt-4 mb-4">
        <h2 class="text-2xl font-semibold text-main_font">Fields for {{ $name }}</h2>
        <div class="w-full sm:w-40">
             <button type="button" id="page-add-field-button" class="w-full h-[2.375rem] text-f7 bg-mainblue hover:text-mainblue hover:bg-nav_active font-medium rounded-lg text-sm px-3">Add Field</button>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl">
        <div class="relative overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-left text-main_font">
                <thead class="text-xs text-main_font uppercase bg-col_tab_h">
                    <tr>
                        <th scope="col" class="px-6 py-3">Order</th>
                        <th scope="col" class="px-6 py-3">Title</th>
                        <th scope="col" class="px-6 py-3">Interval</th>
                        <th scope="col" class="px-6 py-3">Extension</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($programfields as $field)
                        <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $field->order }}</td>
                            <td class="px-6 py-4">{{ $field->title }}</td>
                            <td class="px-6 py-4">{{ $field->interval_days }} Days</td>
                            <td class="px-6 py-4">{{ $field->extension_days }} Days</td>
                            <td class="px-6 py-4">
                                {{-- Example of displaying status with a badge --}}
                                <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $field->status === 'active' ? 'text-green-700 bg-green-100' : 'text-gray-700 bg-gray-100' }}">
                                    {{ ucfirst($field->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-start items-start space-x-4">
                                    <!-- View Button -->
                                    <button type="button" 
                                            class="js-view-field-btn text-gray-500 hover:text-gray-800" 
                                            data-field-id="{{ $field->id }}" 
                                            title="View Field">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                          <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                          <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <!-- Update Button -->
                                    <button type="button" 
                                            class="js-update-field-btn text-mainblue hover:text-blue-900" 
                                            data-field-id="{{ $field->id }}" 
                                            title="Update Field">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b bg-f7 text-normal_font">
                            <td colspan="6"> <!-- Changed colspan to 6 to match new header columns -->
                                <div class="text-center py-10">
                                    <img src="{{ asset('images/illustrations/empty.png') }}" alt="No fields found" class="w-64 mx-auto"> <!-- Centered the image -->
                                    <p class="mt-5 text-lg font-medium text-gray-700">
                                        No Program Fields Added Yet.
                                    </p>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Click the "Add Field" button to get started.
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
