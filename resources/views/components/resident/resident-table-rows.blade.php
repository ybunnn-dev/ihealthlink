@forelse ($residents as $resident)
    @php
        // Birthdate is auto-decrypted by the model
        try {
            $birthdate = \Illuminate\Support\Carbon::parse($resident->birthdate);
            $age = $birthdate->age;
        } catch (\Exception $e) {
            $age = 0;
        }
        
        $ageGroup = 'Infant';
        if ($age >= 60) { $ageGroup = 'Senior'; } 
        elseif ($age >= 18) { $ageGroup = 'Adult'; } 
        elseif ($age >= 13) { $ageGroup = 'Teen'; } 
        elseif ($age >= 2) { $ageGroup = 'Child'; }
        
        // Names are auto-decrypted by the model
        $fullName = trim($resident->firstName . ' ' . ($resident->middleName ?? '') . ' ' . $resident->lastName);
        $purokName = $resident->family->household->purok->name ?? 'N/A';
        $residentId = 'R-' . str_pad($resident->id, 3, '0', STR_PAD_LEFT);
    @endphp

    <tr class="bg-white border-b bg-f7 text-normal_font hover:bg-gray-100 cursor-pointer" 
        onclick="window.location='{{ route('midwife.spec-resident', ['resident' => $resident->id]) }}'">
        
        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
            <span x-show="showPrivacy">{{ $residentId }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($residentId)) }}</span>
        </th>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $fullName }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($fullName)) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $purokName }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($purokName)) }}</span>
        </td>

        <td class="px-6 py-4 capitalize">
            <span x-show="showPrivacy">{{ $resident->sex }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($resident->sex)) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $age }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen((string)$age)) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $ageGroup }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($ageGroup)) }}</span>
        </td>
    </tr>
@empty
    <tr class="bg-white border-b">
        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
            <div class="text-center py-10">
                <img src="{{ asset('images/illustrations/empty.png') }}" alt="No residents found" class="mx-auto w-64">
                <p class="mt-5 text-lg font-medium text-gray-700">
                    @if(request('search') || request('purok_id') || request('age_group'))
                        No residents found matching your criteria.
                    @else
                        No residents found.
                    @endif
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    @if(request('search') || request('purok_id') || request('age_group'))
                        Try adjusting your search or filters.
                    @else
                        Click the "Add Resident" button to get started.
                    @endif
                </p>
            </div>
        </td>
    </tr>
@endforelse
