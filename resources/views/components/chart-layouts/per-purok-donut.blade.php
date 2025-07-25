<div class="bg-white rounded-xl p-10 shadow-sm">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ $title }}</h3>
    <div class="flex items-center gap-10 px-6">
        <div class="flex-shrink-0 w-64 h-64">
            <canvas id="{{ $chartId }}"></canvas>
        </div>
        <div class="flex-1 space-y-2">
            <div id="{{ $legendId }}" class="text-sm"></div>
        </div>
    </div>
</div>
