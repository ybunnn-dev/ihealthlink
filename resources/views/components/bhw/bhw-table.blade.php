@forelse ($bhws as $bhw)
    @php
        $bhwIdString = (string)$bhw->id;
        $bhwFullName = trim($bhw->user->firstName . ' ' . $bhw->user->middleName . ' ' . $bhw->user->lastName);
        
        // Safely calculate age from encrypted birthdate
        $age = 'N/A';
        try {
            if ($bhw->user->birthdate) {
                $birthdate = \Carbon\Carbon::parse($bhw->user->birthdate);
                $age = $birthdate->age;
            }
        } catch (\Exception $e) {
            $age = 'N/A';
        }
        
        $roleId = $bhw->user->role_id;
        $privilege = $roleId == 4 ? 'Web Access' : ($roleId == 3 ? 'Regular BHW' : 'N/A');
        $dateCreated = $bhw->created_at->format('M d, Y');
        $dateUpdated = $bhw->updated_at->format('M d, Y');
    @endphp

    <tr class="bg-white border-b bg-f7 text-normal_font hover:bg-gray-100 cursor-pointer" 
        onclick="window.location='{{ route('midwife.bhws.show', $bhw->id)}}'">
        
        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
            <span x-show="showPrivacy">{{ $bhwIdString }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($bhwIdString)) }}</span>
        </th>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $bhwFullName }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($bhwFullName)) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $privilege }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($privilege)) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">
                @if (is_numeric($age))
                    {{ $age }} years old
                @else
                    {{ $age }}
                @endif
            </span>
            <span x-show="!showPrivacy">{{ str_repeat('*', 12) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $dateCreated }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($dateCreated)) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $dateUpdated }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($dateUpdated)) }}</span>
        </td>
    </tr>
@empty
    <tr class="bg-white border-b">
        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
            <div class="text-center py-10">
                <img src="{{ asset('images/illustrations/empty.png') }}" alt="No BHWs found" class="mx-auto w-64">
                <p class="mt-5 text-lg font-medium text-gray-700">
                    @if(request('search') || request('sort_by') || request('sort_date'))
                        No BHWs found matching your criteria.
                    @else
                        No Barangay Health Workers found.
                    @endif
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    @if(request('search') || request('sort_by') || request('sort_date'))
                        Try adjusting your search or filters.
                    @else
                        Click the "Add BHW" button to get started.
                    @endif
                </p>
            </div>
        </td>
    </tr>
@endforelse
