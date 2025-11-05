<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-main_font bg-col_tab_h">
        <thead class="text-xs text-main_font uppercase text-start">
            <tr class="text-start">
                <th scope="col" class="px-6 py-3 text-start">Program #</th>
                <th scope="col" class="px-6 py-3 text-start">NAME</th>
                <th scope="col" class="px-6 py-3 text-start">Age Range</th>
                <th scope="col" class="px-6 py-3 text-start">No. of Enrolled</th>
                <th scope="col" class="px-6 py-3 text-start">DATE ADDED</th>
                <th scope="col" class="px-6 py-3 text-start">DATE UPDATED</th>
            </tr>
        </thead>
        <tbody id="healthProgram-table-body">
            @forelse ($healthPrograms as $healthProgram)
                <tr class="bg-white border-b bg-f7 text-normal_font text-start cursor-pointer hover:bg-gray-100" 
                    onclick="window.location='{{ route('mho.spec-hprog', ['healthProgram' => $healthProgram->id]) }}'">                                            
                    <th scope="row" class="px-6 py-4 font-medium text-start text-normal_font whitespace-nowrap">
                        {{ $healthProgram->id }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $healthProgram->name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $healthProgram->age_min ? $healthProgram->age_min : 'Undefined'}} - {{ $healthProgram->age_max ? $healthProgram->age_max : 'Undefined' }}
                    </td>
                    <td class="px-6 py-4">
                        {{ number_format($healthProgram->enrolled_residents_count ?? 0) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $healthProgram->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $healthProgram->updated_at->format('M d, Y') }}
                    </td>
                </tr>
            @empty
                <tr class="border-b bg-f7 text-normal_font text-center">
                    <td colspan="6">
                        <div class="text-center py-10">
                            <img src="{{ asset('images/illustrations/empty.png') }}" alt="No health programs found" class="mx-auto w-64">
                            <p class="mt-5 text-lg font-medium text-gray-700">
                                Oops! No health programs found.
                            </p>
                            <p class="mt-2 text-sm text-gray-500">
                                Try adjusting your filters or search term.
                            </p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
