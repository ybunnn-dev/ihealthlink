@forelse($medicines as $medicine)
    <tr class="bg-white border-b bg-f7 text-normal_font cursor-pointer hover:bg-gray-100" 
        onclick="window.location='{{ route('midwife.medicines.show', $medicine->id) }}'">
        <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
            {{ $medicine->id }}
        </th>
        <td class="px-6 py-4">
            {{ $medicine->medicine_name }}
        </td>
        <td class="px-6 py-4">
            {{ $medicine->remaining_stock }}
        </td>
        <td class="px-6 py-4">
            {{ $medicine->category }}
        </td>
        <td class="px-6 py-4">
            {{ $medicine->form }}
        </td>
        <td class="px-6 py-4">
            {{ $medicine->updated_at->format('M d, Y') }}
        </td>
    </tr>
@empty
    <tr class="border-b bg-f7 text-normal_font text-center">
        <td colspan="6">
            <div class="text-center py-10">
                <img src="{{ asset('images/illustrations/empty.png') }}" alt="No medicines found" class="mx-auto w-64">
                <p class="mt-5 text-lg font-medium text-gray-700">
                    No medicines found.
                </p>
                <p class="mt-2 text-sm text-gray-500">
                    Try adjusting your filters or add a new medicine.
                </p>
            </div>
        </td>
    </tr>
@endforelse
