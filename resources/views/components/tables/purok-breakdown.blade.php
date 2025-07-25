<div class="bg-white rounded-xl p-6 px-10 shadow-sm mb-3 overflow-x-auto">
    <h3 class="text-lg font-semibold text-main_font mb-4">{{ $title }}</h3>
    <table class="min-w-full divide-y divide-gray-100 text-sm text-center text-normal_font">
        <thead class="bg-gray-100 text-main_font">
            <tr>
                <th class="px-6 py-3 text-left font-semibold">Category</th>
                @foreach ($headers as $header)
                    <th class="px-6 py-3 {{ $loop->last ? 'font-semibold' : '' }}">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach ($rows as $row)
                <tr>
                    <td class="px-6 py-4 text-left font-semibold text-main_font">{{ $row['label'] }}</td>
                    @foreach ($row['values'] as $value)
                        <td class="px-6 py-4 {{ $loop->last ? 'font-semibold' : '' }}">{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
