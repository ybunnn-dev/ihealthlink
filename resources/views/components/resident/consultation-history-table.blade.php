<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
        <thead class="text-xs text-main_font uppercase">
            <tr>
                <th scope="col" class="px-6 py-3">CONSULTATION TYPE</th>
                <th scope="col" class="px-6 py-3">DATE</th>
                <th scope="col" class="px-6 py-3">LAST UPDATED</th>
                <th scope="col" class="px-6 py-3">STATUS</th>
                <th scope="col" class="px-6 py-3">ACTION</th>
            </tr>
        </thead>
        <tbody>
            @forelse($history as $consultation)
                <tr class="bg-white border-b bg-f7 text-normal_font">
                    <td class="px-6 py-4">{{ $consultation->consultation_title ?? 'General Consultation' }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($consultation->consultation_date)->format('M d, Y') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($consultation->updated_at)->format('M d, Y g:i A') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            @if($consultation->status === 'completed') bg-green-100 text-green-800
                            @elseif($consultation->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($consultation->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs">View</button>
                    </td>
                </tr>
            @empty
                <tr class="bg-white border-b">
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        <img src="{{ asset('images/illustrations/empty.png') }}" alt="No residents found" class="mx-auto w-64">
                        <p class="mt-5 text-lg font-medium text-gray-700">
                                No residents found.
                        </p>
                        <p class="mt-2 text-sm text-gray-500">
                            Try adjusting your search or filters.
                            
                        </p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination Links --}}
@if($history->hasPages())
    <div class="mt-4" id="pagination-links">
        {{ $history->links() }}
    </div>
@endif
