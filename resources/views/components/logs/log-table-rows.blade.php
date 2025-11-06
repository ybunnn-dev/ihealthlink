@forelse($logs as $log)
    <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
            <span x-show="showPrivacy">{{ $log->id }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', strlen((string)$log->id)) }}</span>
        </th>
        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ ($log->user->firstName ?? '') . ' ' . ($log->user->lastName ?? 'N/A') }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', 15) }}</span>
        </td>
        <td class="px-6 py-4 capitalize">
            <span x-show="showPrivacy">{{ $log->user->role->name ?? 'BHW' }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', 5) }}</span>
        </td>
        <td class="px-6 py-4">
            <span x-show="showPrivacy" class="truncate max-w-20 slg2:max-w-30 xl3:max-w-80" title="{{ $log->activity }}">
                {{ $log->activity }}
            </span>
            <span x-show="!showPrivacy">{{ str_repeat('*', 20) }}</span>
        </td>
        <td class="px-6 py-4">
            <span x-show="showPrivacy">{{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y - h:i A') }}</span>
            <span x-show="!showPrivacy">{{ str_repeat('*', 20) }}</span>
        </td>
        <td class="px-6 py-4">
            <button data-id="{{ $log->id }}" class="text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-1 view-log-btn">
                View
            </button>
        </td>
    </tr>
@empty
    <tr class="bg-white border-b">
        <td colspan="6" class="px-6 py-12 text-center text-normal_font">
            <div class="text-center">
                <img src="{{ asset('images/illustrations/empty.png') }}" alt="No logs found" class="mx-auto w-64">
                <p class="mt-5 text-lg font-medium text-gray-700">No activity logs found</p>
                <p class="mt-2 text-sm text-gray-500">Activity logs will appear here when actions are performed.</p>
            </div>
        </td>
    </tr>
@endforelse
