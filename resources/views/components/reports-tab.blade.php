<div class="relative bg-white rounded-xl p-3 px-8 group overflow-x-auto scrollbar-hide scroll-smooth pt-5">
    <!-- Left Scroll Button -->
    <button onclick="scrollReports(-200)"
        class="text-xl absolute left-2 top-0 bottom-0 w-8 justify-center items-center text-gray-600 bg-white/90 hover:bg-white z-10 hidden group-hover:flex">
        &lt;
    </button>

    <!-- Right Scroll Button -->
    <button onclick="scrollReports(200)"
        class="text-xl absolute right-2 top-0 bottom-0 w-8 justify-center items-center text-gray-600 bg-white/90 hover:bg-white z-10 hidden group-hover:flex">
        &gt;
    </button>

    <!-- Scrollable Report Tabs -->
    <div id="reportsScroll" class="flex space-x-6 overflow-x-auto scrollbar-hide scroll-smooth">
        @php
            $reports = [
                'All Programs',
                'Prenatal',
                'Polio Vaccine',
                'Anti Measles',
                'Family Planning',
                'Senior Citizen',
                'Tuberculosis',
                'Deworming',
                'Nutrition Program',
                'COVID-19 Vaccine',
                'Maternal Care',
                'Child Health',
                'Immunization',
                'Hypertension'
            ];
            $activeReport = 'Polio Vaccine'; // Example active
        @endphp

        @foreach($reports as $report)
        <div class="flex flex-col items-center cursor-pointer flex-shrink-0">
            <span class="font-medium {{ $report === $activeReport ? 'text-sub_blue font-semibold' : 'text-gray-500 font-medium' }} text-sm">
                {{ $report }}
            </span>
            <div class="h-1 w-full mt-1 {{ $report === $activeReport ? 'bg-sub_blue' : 'bg-transparent' }}"></div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function scrollReports(offset) {
        const container = document.getElementById('reportsScroll');
        container.scrollBy({ left: offset, behavior: 'smooth' });
    }
</script>
