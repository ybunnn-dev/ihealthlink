@forelse ($households as $household)
    @php
        $householdIdString = str_pad($household->id, 3, '0', STR_PAD_LEFT);

        if ($household->head) {
            $head = $household->head;
            $middle = !empty($head->middleName) ? ' ' . strtoupper($head->middleName[0]) . '.' : '';
            $suffix = !empty($head->suffix) ? ' ' . $head->suffix : '';
            $householdHead = "{$head->firstName}{$middle} {$head->lastName}{$suffix}";
        } else {
            $householdHead = 'N/A';
        }

        $purokName = $household->purok->name ?? 'No Purok';
        $dateAdded = $household->created_at->format('M d, Y');
        $dateUpdated = $household->updated_at->format('M d, Y');
    @endphp
    <tr class="bg-white border-b bg-f7 text-normal_font hover:bg-gray-100 cursor-pointer"
        onclick="window.location='{{ route('midwife.spec-household', $household->id) }}'">

        <th scope="row" class="pl-6 py-4 font-medium text-normal_font whitespace-nowrap">
            <span x-show="showPrivacy">{{ $householdIdString }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($householdIdString)) }}</span>
        </th>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $householdHead }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($householdHead)) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $purokName }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($purokName)) }}</span>
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
        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
            <div class="text-center py-10">
                <img src="{{ asset('images/illustrations/empty.png') }}" alt="No households found" class="mx-auto w-64">
                <p class="mt-5 text-lg font-medium text-gray-700">
                    @if(request('search') || request('purok_id'))
                        No households found matching your criteria.
                    @else
                        Oops! You haven't added any household yet.
                    @endif
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    @if(request('search') || request('purok_id'))
                        Try adjusting your search or filters.
                    @else
                        Click the "Add Household" button to get started.
                    @endif
                </p>
            </div>
        </td>
    </tr>
@endforelse
