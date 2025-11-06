@forelse($enrolledResidents as $enrollment)
    @php
        $info = $enrollment->getNextConsultationAttribute($enrollment->id);
        $residentId = 'R-' . str_pad($enrollment->resident->id, 3, '0', STR_PAD_LEFT);
        $fullName = trim($enrollment->resident->firstName . ' ' . ($enrollment->resident->middleName ?? '') . ' ' . $enrollment->resident->lastName);
    @endphp

    <tr class="bg-white border-b text-normal_font hover:bg-gray-50 cursor-pointer" 
        onclick="window.location='/barangay/health-programs/enrolled/resident/{{ $enrollment->id }}'">
        
        <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
            <span x-show="showPrivacy">{{ $residentId }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($residentId)) }}</span>
        </th>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $fullName }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen($fullName)) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy" class="px-2 py-1 font-semibold text-xs rounded-full {{ $info['color'] }}">
                {{ $info['status'] }}
            </span>
            <span x-show="!showPrivacy" class="px-2 py-1 font-semibold text-xs rounded-full bg-gray-200">
                ***
            </span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ \Carbon\Carbon::parse($enrollment->created_at)->format('M d, Y') }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', 11) }}</span>
        </td>

        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ $info['date'] }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', 10) }}</span>
        </td>
    </tr>
@empty
    <tr class="bg-white border-b">
        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
            <div class="text-center py-10">
                <img src="{{ asset('images/illustrations/empty.png') }}" alt="No residents found" class="mx-auto w-64">
                <p class="mt-5 text-lg font-medium text-gray-700">
                    @if(request('search') || request('sort_by') || request('date_filter'))
                        No residents found matching your criteria.
                    @else
                        No Enrolled Residents Found
                    @endif
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    @if(request('search') || request('sort_by') || request('date_filter'))
                        Try adjusting your search or filters.
                    @else
                        Start by enrolling residents to this health program.
                    @endif
                </p>
            </div>
        </td>
    </tr>
@endforelse
