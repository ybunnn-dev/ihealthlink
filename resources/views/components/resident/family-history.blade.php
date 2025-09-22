@props(['famhistory'])

<div class="bg-white rounded-xl py-8 px-6 sm:px-10 xl:px-12">
    <h2 class="text-xl font-semibold text-main_font mb-4">Family History</h2>
    @if ($famhistory)
        <div class="grid grid-cols-1 slg2:grid-cols-2 gap-x-12 gap-y-4 text-xs">
            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">HYPERTENSION:</p>
                <p class="text-normal_font">{{ ($famhistory->hypertension ?? 0) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">HEART DISEASE:</p>
                <p class="text-normal_font">{{ ($famhistory->heart_diseases ?? 0) ? 'Yes' : 'No' }}</p>
            </div>
            
            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">STROKE:</p>
                <p class="text-normal_font">{{ ($famhistory->stroke ?? 0) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">DIABETES MELLITUS:</p>
                <p class="text-normal_font">{{ ($famhistory->diabetes_mellitus ?? 0) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">CANCER:</p>
                <p class="text-normal_font">{{ ($famhistory->cancer ?? 0) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">ASTHMA:</p>
                <p class="text-normal_font">{{ ($famhistory->asthma ?? 0) ? 'Yes' : 'No' }}</p>
            </div>
            
            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">COPD:</p>
                <p class="text-normal_font">{{ ($famhistory->copd ?? 0) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">KIDNEY DISORDERS:</p>
                <p class="text-normal_font">{{ ($famhistory->kidney_disorders ?? 0) ? 'Yes' : 'No' }}</p>
            </div>
            
            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">TUBERCULOSIS (LAST 5 YRS):</p>
                <p class="text-normal_font">{{ ($famhistory->tuberculosis_last_five_years ?? 0) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">
                    MENTAL, NEUROLOGICAL,<br class="hidden sm:inline"> AND SUBSTANCE ABUSE DISORDERS:
                </p>
                <p class="text-normal_font">{{ ($famhistory->mental_neurological_substance_abuse_disorders ?? 0) ? 'Yes' : 'No' }}</p>
            </div>
        </div>
    @else
        <p class="text-normal_font text-center">No family history data available.</p>
    @endif
</div>