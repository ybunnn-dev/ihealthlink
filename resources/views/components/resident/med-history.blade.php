@props(['medicalhistory'])

<div class="bg-white rounded-xl py-8 px-6 sm:px-10 xl:px-12">
    <h2 class="text-xl font-semibold text-main_font mb-4">Medical History</h2>
    @if ($medicalhistory)
        <div class="grid grid-cols-1 slg2:grid-cols-2 gap-x-12 gap-y-4 text-xs">
            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">HYPERTENSION:</p>
                <p class="text-normal_font">{{ ($medicalhistory->hypertension ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">HEART DISEASE:</p>
                <p class="text-normal_font">{{ ($medicalhistory->heart_diseases ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">COPD:</p>
                <p class="text-normal_font">{{ ($medicalhistory->copd ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">KIDNEY DISORDERS:</p>
                <p class="text-normal_font">{{ ($medicalhistory->kidney_disorders ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">VISION PROBLEMS:</p>
                <p class="text-normal_font">{{ ($medicalhistory->vision_problems ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">DIABETES:</p>
                <p class="text-normal_font">{{ ($medicalhistory->diabetes ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">CANCER:</p>
                <p class="text-normal_font">{{ ($medicalhistory->cancer ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">ASTHMA:</p>
                <p class="text-normal_font">{{ ($medicalhistory->asthma ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">ALLERGIES:</p>
                <p class="text-normal_font">{{ ($medicalhistory->allergies ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">SURGICAL HISTORY:</p>
                <p class="text-normal_font">{{ ($medicalhistory->surgical_history ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">THYROID DISORDERS:</p>
                <p class="text-normal_font">{{ ($medicalhistory->thyroid_disorders ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">
                    MENTAL, NEUROLOGICAL,<br class="hidden sm:inline"> AND SUBSTANCE ABUSE DISORDERS:
                </p>
                <p class="text-normal_font">{{ ($medicalhistory->mental_neuro_substance_disorders ?? false) ? 'Yes' : 'No' }}</p>
            </div>
        </div>
    @else
        <p class="text-normal_font text-center">No medical history data available.</p>
    @endif
</div>