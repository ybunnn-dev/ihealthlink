@props(['midwives'])

<div class="relative overflow-x-auto">
    <table id="midwives-table" class="w-full text-sm text-left text-main_font bg-col_tab_h">
        <thead class="text-xs text-main_font uppercase text-start">
            <tr>
                <th scope="col" class="px-6 py-3 text-start">Midwife No.</th>
                <th scope="col" class="px-6 py-3 text-start">Midwife Name</th>
                <th scope="col" class="px-6 py-3 text-start">Assigned Barangay</th>
                <th scope="col" class="px-6 py-3 text-start">Date Added</th>
                <th scope="col" class="px-6 py-3 text-start">Date Updated</th>
            </tr>
        </thead>
        
        <tbody id="midwives-table-body">
            @forelse($midwives as $m)
                @php
                    // Handle both array (initial load) and object (AJAX) formats
                    $id = is_array($m) ? $m['midwife_no'] : $m->id;
                    $name = is_array($m) ? $m['name'] : (implode(' ', array_filter([
                        $m->user?->firstName,
                        $m->user?->middleName,
                        $m->user?->lastName,
                        $m->user?->suffix
                    ])));
                    $barangay = is_array($m) ? $m['barangay'] : $m->barangay?->name;
                    $dateAdded = is_array($m) ? $m['date_added'] : $m->created_at?->format('M d, Y');
                    $dateUpdated = is_array($m) ? $m['date_updated'] : $m->updated_at?->format('M d, Y');
                    $slug = \Illuminate\Support\Str::slug($name);
                    
                    // Convert to strings for length calculation
                    $idString = (string)$id;
                @endphp
                
                <tr id="midwife-row-{{ $id }}"
                    class="bg-white border-b bg-f7 text-normal_font text-start cursor-pointer hover:bg-gray-100" 
                    onclick="window.location='/mho/midwife/{{ $slug }}/{{ $id }}'">
                    
                    <th id="midwife-no-{{ $id }}" scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap text-start">
                        <span x-show="showPrivacy">{{ $idString }}</span>
                        <span x-show="!showPrivacy">{{ str_repeat('*', strlen($idString)) }}</span>
                    </th>
                    
                    <td id="midwife-name-{{ $id }}" class="px-6 py-4">
                        <span x-show="showPrivacy">{{ $name }}</span>
                        <span x-show="!showPrivacy">{{ str_repeat('*', strlen($name)) }}</span>
                    </td>
                    
                    <td id="midwife-barangay-{{ $id }}" class="px-6 py-4">
                        <span x-show="showPrivacy">{{ $barangay }}</span>
                        <span x-show="!showPrivacy">{{ str_repeat('*', strlen($barangay)) }}</span>
                    </td>
                    
                    <td id="midwife-date-added-{{ $id }}" class="px-6 py-4">
                        <span x-show="showPrivacy">{{ $dateAdded }}</span>
                        <span x-show="!showPrivacy">{{ str_repeat('*', strlen($dateAdded)) }}</span>
                    </td>
                    
                    <td id="midwife-date-updated-{{ $id }}" class="px-6 py-4">
                        <span x-show="showPrivacy">{{ $dateUpdated }}</span>
                        <span x-show="!showPrivacy">{{ str_repeat('*', strlen($dateUpdated)) }}</span>
                    </td>
                </tr>
            @empty
                <tr class="bg-white border-b">
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        <div class="py-10 text-center">
                            <img src="{{ asset('images/illustrations/empty.png') }}" alt="No midwives found" class="mx-auto w-64">
                            <p class="mt-5 text-lg font-medium text-gray-700">
                                @if(request('search') || request('sort_by') || request('sort_date'))
                                    No midwives found matching your criteria.
                                @elseif(request('search'))
                                    No midwives found matching "{{ request('search') }}".
                                @else
                                    No midwives found.
                                @endif
                            </p>
                            <p class="mt-2 text-sm text-gray-500">
                                @if(request('search') || request('sort_by') || request('sort_date'))
                                    Try adjusting your search or filters.
                                @else
                                    Get started by adding a new midwife to the system.
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
