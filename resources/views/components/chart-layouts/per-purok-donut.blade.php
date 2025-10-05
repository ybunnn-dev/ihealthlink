<div class="bg-white rounded-xl p-10 pr-10 shadow-sm overflow-x-auto">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ $title }}</h3>
    <div class="flex items-center gap-10 px-6 pr-10">
        <div class="flex-shrink-0 w-32 h-32 xl2:w-48 xl2:h-48">
            <canvas id="{{ $chartId }}"></canvas>
        </div>
        <div class="flex-1 space-y-2 pr-10">
            <div id="{{ $legendId }}" class="text-sm"></div>
        </div>
    </div>
</div>
