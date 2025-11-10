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
                                    <button type="button" 
                                            class="edit-schedule-btn text-mainblue hover:text-blue-900" 
                                            data-schedule-id="{{ $field->id }}" 
                                            title="Edit Field">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <button type="button" 
                                            class="delete-schedule-btn text-red-600 hover:text-red-900" 
                                            data-schedule-id="{{ $field->id }}" 
                                            title="Delete Field">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm3 4a1 1 0 10-2 0v2a1 1 0 102 0v-2z" clip-rule="evenD" />
                                        </svg>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b bg-f7 text-normal_font">
                            <td colspan="6"> <div class="text-center py-10">
                                    <img src="{{ asset('images/illustrations/empty.png') }}" alt="No fields found" class="w-64 mx-auto">
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