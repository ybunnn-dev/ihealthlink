@forelse($families as $family)
    @php
        $familyIdString = (string)$family->id;
        $memNum = (string)$family->active_residents_count;
        $purokName = $family->household->purok->name ?? 'N/A';
        $is4psText = $family->is_4ps ? 'Yes' : 'No';
        $isIndigentText = $family->is_indigent ? 'Yes' : 'No';
        $dateAdded = $family->created_at->format('M d, Y');
        $dateUpdated = $family->updated_at->format('M d, Y');
    @endphp
    
    <tr class="bg-white border-b bg-f7 text-normal_font cursor-pointer hover:bg-gray-100"
        onclick="window.location='{{ route('midwife.cur-fam', ['family' => $family->id, 'return' => url()->current()]) }}'">
        
        
        <th scope="row" class="pl-6 py-4 font-medium text-normal_font whitespace-nowrap">
            <span x-show="showPrivacy">{{ $familyIdString }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($familyIdString)) }}</span>
        </th>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $memNum }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($memNum)) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $purokName }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($purokName)) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">
                @if($family->is_4ps)
                    <span class="inline-block px-4 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                        {{ $is4psText }}
                    </span>
                @else
                    <span class="inline-block px-4 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">
                        {{ $is4psText }}
                    </span>
                @endif
            </span>
            <span x-show="!showPrivacy">
                {{ str_repeat('*', strlen($is4psText)) }}
            </span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">
                @if($family->is_indigent)
                    <span class="inline-block px-4 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                        {{ $isIndigentText }}
                    </span>
                @else
                    <span class="inline-block px-4 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">
                        {{ $isIndigentText }}
                    </span>
                @endif
            </span>
            <span x-show="!showPrivacy">
                {{ str_repeat('*', strlen($isIndigentText)) }}
            </span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $dateAdded }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($dateAdded)) }}</span>
        </td>
        
        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $dateUpdated }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($dateUpdated)) }}</span>
        </td>
    </tr>
@empty
    <tr class="bg-white border-b">
        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
            <div class="text-center py-10">
                <img src="{{ asset('images/illustrations/empty.png') }}" alt="No families found" class="mx-auto w-64">
                <p class="mt-5 text-lg font-medium text-gray-700">
                    @if(request('search') || request('purok_id') || request('date_sort'))
                        No families found matching your criteria.
                    @else
                        Oops! You haven't added any family yet.
                    @endif
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    @if(request('search') || request('purok_id') || request('date_sort'))
                        Try adjusting your search or filters.
                    @else
                        Click the "Add Family" button to get started.
                    @endif
                </p>
            </div>
        </td>
    </tr>
@endforelse