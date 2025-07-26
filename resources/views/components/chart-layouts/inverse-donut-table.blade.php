<div class="grid grid-cols-1 slg2:grid-cols-5 gap-3 mb-3">
     <div class="bg-white rounded-xl p-6 px-10 shadow-sm h-70 col-span-1 overflow-x-auto slg:col-span-2">
        <h3 class="text-lg font-semibold text-main_font mb-4">{{ $tableTitle }}</h3>
        <table class="min-w-full text-sm text-gray-700 border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                {{ $thead }}
            </thead>
            <tbody>
                {{ $tbody }}
            </tbody>
        </table>
    </div>
    <div class="bg-white rounded-xl p-8 px-10 shadow-sm h-80 col-span-1 slg:col-span-3">
        <h3 class="text-lg font-semibold text-main_font mb-4">{{ $chartTitle }}</h3>
        <div class="flex items-center justify-center h-[100%] pb-10">
            <canvas id="{{ $canvasId }}" class="w-full h-full"></canvas>
        </div>
    </div>
</div>