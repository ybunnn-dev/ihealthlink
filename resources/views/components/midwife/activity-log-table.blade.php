<div class="relative overflow-x-auto rounded-lg">
    <table class="w-full text-sm text-left text-main_font">
        <thead class="text-xs text-main_font uppercase bg-col_tab_h">
            <tr>
                <th scope="col" class="px-6 py-3">LOG ID</th>
                <th scope="col" class="px-6 py-3">NAME</th>
                <th scope="col" class="px-6 py-3">ACTIVITY</th>
                <th scope="col" class="px-6 py-3">DATE</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                @php
                    $logIdString = (string)$log->id;
                    $activityText = $log->activity;
                    $dateTime = $log->created_at->format('M d, Y');
                @endphp
                
                <tr class="bg-white border-b bg-f7 text-normal_font hover:bg-gray-100">
                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                        <span x-show="showPrivacy">{{ $logIdString }}</span>
                        <span x-show="!showPrivacy">{{ str_repeat('*', strlen($logIdString)) }}</span>
                    </th>
                    
                    <td class="px-6 py-4">
                        <span>{{ $midwife['firstName'] . ' ' . ($midwife['middleName'] ?? '') . ' ' . $midwife['lastName'] }}</span>
                    </td>
                    
                    <td class="px-6 py-4">
                        <span x-show="showPrivacy">{{ $activityText }}</span>
                        <span x-show="!showPrivacy">{{ str_repeat('*', min(strlen($activityText), 30)) }}</span>
                    </td>

                    <td class="px-6 py-4">
                        <span x-show="showPrivacy">{{ $dateTime }}</span>
                    </td>
                </tr>
            @empty
                <tr class="bg-white border-b">
                    <td colspan="4" class="px-6 py-4 text-gray-500">
                        {{-- Added 'text-center' to this div --}}
                        <div class="py-10 text-center">
                            <img src="{{ asset('images/illustrations/empty.png') }}" alt="No activity logs found" class="mx-auto w-64">
                            <p class="mt-5 text-lg font-medium text-gray-700">
                                @if(request('search') || request('date_filter'))
                                    No activity logs found matching your criteria.
                                @else
                                    No activity logs found.
                                @endif
                            </p>
                            <p class="mt-2 text-sm text-gray-500">
                                @if(request('search') || request('date_filter'))
                                    Try adjusting your search or filters.
                                @else
                                    This midwife hasn't performed any activities yet.
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
