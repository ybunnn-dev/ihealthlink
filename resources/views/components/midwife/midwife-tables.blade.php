{{-- resources/views/components/midwife/midwife-table.blade.php --}}

@props(['midwives'])

<div class="relative overflow-x-auto">
    {{-- ID ADDED for the main table --}}
    <table id="midwives-table" class="w-full text-sm text-left text-main_font bg-col_tab_h">
        <thead class="text-xs text-main_font uppercase text-start">
            <tr>
                <th scope="col" class="px-6 py-3 text-start">
                    Midwife No.
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                    Midwife Name
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                    Assigned Barangay
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                    Date Added
                </th>
                <th scope="col" class="px-6 py-3 text-start">
                    Date Updated
                </th>
            </tr>
        </thead>
        
        {{-- ID ADDED for the table body --}}
        <tbody id="midwives-table-body">
            @foreach($midwives as $m)
                {{-- DYNAMIC ID ADDED for each row --}}
                <tr id="midwife-row-{{ $m['midwife_no'] }}"
                    class="bg-white border-b bg-f7 text-normal_font text-start cursor-pointer hover:bg-gray-100" 
                    onclick="window.location='{{ route('mho.midwife.show', ['name' => \Illuminate\Support\Str::slug($m['name']), 'm_id' => $m['midwife_no']]) }}'"
                    > 
                    {{-- DYNAMIC IDs ADDED for each cell --}}
                    <th id="midwife-no-{{ $m['midwife_no'] }}" scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap text-start">
                        {{ $m['midwife_no'] }}
                    </th>
                    <td id="midwife-name-{{ $m['midwife_no'] }}" class="px-6 py-4">
                        {{ $m['name'] }}
                    </td>
                    <td id="midwife-barangay-{{ $m['midwife_no'] }}" class="px-6 py-4">
                        {{ $m['barangay'] }}
                    </td>
                    <td id="midwife-date-added-{{ $m['midwife_no'] }}" class="px-6 py-4">
                        {{ $m['date_added'] }}
                    </td>
                    <td id="midwife-date-updated-{{ $m['midwife_no'] }}" class="px-6 py-4">
                        {{ $m['date_updated'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>