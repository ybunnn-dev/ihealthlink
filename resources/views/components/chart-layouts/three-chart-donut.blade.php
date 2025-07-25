<!-- resources/views/components/chart-layouts/three-chart-donut.blade.php -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-3 mb-3">
    @foreach ([
        ['title' => $title1, 'id' => $id1],
        ['title' => $title2, 'id' => $id2],
        ['title' => $title3, 'id' => $id3],
    ] as $chart)
        <div class="bg-white rounded-xl p-8 px-10 shadow-sm h-70 col-span-1">
            <h3 class="text-lg font-semibold text-main_font mb-4">{{ $chart['title'] }}</h3>
            <div class="flex items-center justify-center h-[80%]">
                <canvas id="{{ $chart['id'] }}" class="w-full h-full"></canvas>
            </div>
        </div>
    @endforeach
</div>
