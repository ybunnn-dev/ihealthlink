{{-- resources/views/components/midwife/midwife-table.blade.php --}}

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
                @endphp
                
                <tr id="midwife-row-{{ $id }}"
                    class="bg-white border-b bg-f7 text-normal_font text-start cursor-pointer hover:bg-gray-100" 
                    onclick="window.location='/mho/midwife/{{ $slug }}/{{ $id }}'">
                    <th id="midwife-no-{{ $id }}" scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap text-start">
                        {{ $id }}
                    </th>
                    <td id="midwife-name-{{ $id }}" class="px-6 py-4">{{ $name }}</td>
                    <td id="midwife-barangay-{{ $id }}" class="px-6 py-4">{{ $barangay }}</td>
                    <td id="midwife-date-added-{{ $id }}" class="px-6 py-4">{{ $dateAdded }}</td>
                    <td id="midwife-date-updated-{{ $id }}" class="px-6 py-4">{{ $dateUpdated }}</td>
                </tr>
            @empty
                <tr class="bg-white border-b">
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No midwives found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>