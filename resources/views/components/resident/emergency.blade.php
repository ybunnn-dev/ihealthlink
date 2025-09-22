@props(['emergencyindicator'])

<div class="bg-white rounded-xl py-8 px-6 sm:px-10 xl:px-12">
    <h2 class="text-xl font-semibold text-main_font mb-4">Emergency Indicators</h2>
    @if ($emergencyindicator)
        <div class="grid grid-cols-1 slg2:grid-cols-2 gap-x-12 gap-y-4 text-xs">
            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">CHEST PAIN:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->chest_pain ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">BREATHING DIFFICULTY:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->difficulty_in_breathing ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">LOSS OF CONSCIOUSNESS:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->loss_of_consciousness ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">NUMBNESS OF ARM:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->numbness_of_arm ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">ACT OF SELF-HARM<br>OR SUICIDE:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->act_of_self_harm_or_suicide ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">AGITATED OR AGGRESSIVE<br>BEHAVIOR:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->agitated_or_aggressive_behavior ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">SEVERE INJURIES:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->severe_injuries ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">SLURRED SPEECH:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->slurred_speech ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">FACIAL ASSYMETRY:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->facial_asymmetry ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">CHEST RETRACTIONS:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->chest_retractions ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">SEIZURE OR CONVULSION:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->seizure_or_convulsion ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">EYE INJURY:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->eye_injury ?? false) ? 'Yes' : 'No' }}</p>
            </div>

            <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                <p class="font-semibold text-main_font">DISORIENTED AS TO TIME,<br>PLACE, OR PERSON:</p>
                <p class="text-normal_font">{{ ($emergencyindicator->disoriented_as_to_time_place_or_person ?? false) ? 'Yes' : 'No' }}</p>
            </div>
        </div>
    @else
        <p class="text-normal_font text-center">No emergency indicator data available.</p>
    @endif
</div>