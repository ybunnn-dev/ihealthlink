@php
    // Get the ncdRiskFactor object for easier access and add a null check.
    $basicHR = $resident->basicHealthRecord ?? null;
    $bmi = 'N/A';
    $bmiClassification = 'Not Available';

    // Check if ncd data and necessary values exist to prevent errors.
    if ($basicHR && is_numeric($basicHR->weight) && is_numeric($basicHR->height) && $basicHR->height > 0) {
        // Convert height from cm to meters for the calculation.
        $heightInMeters = $basicHR->height / 100;
        
        // Calculate BMI and round to one decimal place.
        $bmi = round($basicHR->weight / ($heightInMeters * $heightInMeters), 1);

        // Determine the classification based on the BMI value.
        if ($bmi < 18.5) {
            $bmiClassification = 'Underweight';
        } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
            $bmiClassification = 'Normal';
        } elseif ($bmi >= 25 && $bmi <= 29.9) {
            $bmiClassification = 'Overweight';
        } else {
            $bmiClassification = 'Obese';
        }
    }
@endphp

<div class="bg-white rounded-xl py-8 px-6 sm:px-10 xl:px-12">
    <h2 class="text-xl font-semibold text-main_font mb-4">Basic Health Information</h2>
    <div class="grid grid-cols-1 slg2:grid-cols-2 gap-x-12 gap-y-4 text-xs">
        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
            <p class="font-semibold text-main_font">STATUS:</p>
            <p class="text-normal_font">{{ ucfirst($basicHR->status) }}</p>
        </div>

        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
            <p class="font-semibold text-main_font">WAIST CIRCUMFERENCE:</p>
            <p class="text-normal_font">{{ $basicHR->waist_circumference ?? 'N/A' }} cm</p>
        </div>

        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
            <p class="font-semibold text-main_font">HEIGHT:</p>
            <p class="text-normal_font">{{ $basicHR->height ?? 'N/A' }} cm</p>
        </div>

        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
            <p class="font-semibold text-main_font">WEIGHT:</p>
            <p class="text-normal_font">{{ $basicHR->weight ?? 'N/A' }} kg</p>
        </div>

        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
            <p class="font-semibold text-main_font">BMI:</p>
            {{-- This now displays the calculated values from the @php block --}}
            <p class="text-normal_font">{{ $bmi }} ({{ $bmiClassification }})</p>
        </div>

        <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
            <p class="font-semibold text-main_font">BLOOD PRESSURE:</p>
            <p class="text-normal_font">
                {{ ($basicHR->systolic_pressure ?? 'N/A') . '/' . ($basicHR->diastolic_pressure ?? 'N/A') }} mmHg
            </p>
        </div>
    </div>
</div>