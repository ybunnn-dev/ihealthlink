@props(['ncd'])

<div class="bg-white rounded-xl py-8 px-6 sm:px-10 xl:px-12">
    <h2 class="text-xl font-semibold text-main_font mb-4">NCD Risk Factors</h2>
    @if ($ncd)
        <div class="grid grid-cols-1 slg2:grid-cols-2 gap-x-12 gap-y-6 text-xs">
            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">TOBACCO USE:</p>
                <p class="text-normal_font">{{ ($ncd->tobacco_use ?? 0) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">STREET FOODS WEEKLY:</p>
                <p class="text-normal_font">{{ ($ncd->street_foods_intake ?? 0) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">ALCOHOL INTAKE:</p>
                <p class="text-normal_font">{{ ($ncd->alcohol_intake ?? 0) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">HIGH FAT & HIGH SALT FOOD INTAKE WEEKLY:</p>
                <p class="text-normal_font">{{ ($ncd->high_fat_high_salt_food_intake ?? 0) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">NUMBER OF DRINKS LAST YEAR:</p>
                <p class="text-normal_font">{{ $ncd->number_of_drinks_last_year ?? 'N/A' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">HRS OF PHYSICAL ACTIVITY WEEKLY:</p>
                <p class="text-normal_font">{{ $ncd->hours_of_activity_weekly ?? 'N/A' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">CAFFEINE INTAKE:</p>
                <p class="text-normal_font">{{ ($ncd->caffeine_intake ?? 0) ? 'Yes' : 'No' }}</p>
            </div>

        </div>
    @else
        <p class="text-normal_font text-center">No NCD risk factor data available.</p>
    @endif
</div>