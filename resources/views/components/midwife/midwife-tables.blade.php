{{-- resources/views/components/midwife/midwife-table.blade.php --}}

@props(['midwives'])

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
        <thead class="text-xs text-main_font uppercase text-center">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Midwife No.
                </th>
                <th scope="col" class="px-6 py-3">
                    Midwife Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Assigned Barangay
                </th>
                <th scope="col" class="px-6 py-3">
                    Date Added
                </th>
                <th scope="col" class="px-6 py-3">
                    Date Updated
                </th>
            </tr>
        </thead>
        
        <tbody>
            @foreach($midwives as $m)
                <tr class="bg-white border-b bg-f7 text-normal_font text-center cursor-pointer hover:bg-gray-100">
                    <th scope="row" class="px-6 py-4 font-medium text-normal_font whitespace-nowrap">
                        {{ $m['midwife_no'] }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $m['name'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $m['barangay'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $m['date_added'] }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $m['date_updated'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>