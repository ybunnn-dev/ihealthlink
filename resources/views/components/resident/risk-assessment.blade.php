@props(['riskassessment'])

@if ($riskassessment)
    <h1 class="text-sub_blue text-xl font-semibold mt-4 mb-2">Risk Assessment</h1>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
        {{-- Blood Sugar Card --}}
        <div class="bg-white rounded-xl py-8 px-6 sm:px-10 xl:px-12">
            <h2 class="text-xl font-semibold text-main_font mb-4">Blood Sugar</h2>
            <div class="grid grid-cols-1 slg2:grid-cols-2 gap-x-12 gap-y-6 text-xs">
                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">FBS RESULT:</p>
                    <p class="text-normal_font">{{ $riskassessment->fbs_result ?? '--' }}</p>
                </div>

                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">POLYDIPSIA:</p>
                    <p class="text-normal_font">{{ ($riskassessment->polydipsia ?? false) ? 'Yes' : 'No' }}</p>
                </div>

                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">RBS RESULT:</p>
                    <p class="text-normal_font">{{ $riskassessment->rbs_result ?? '--' }}</p>
                </div>

                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">POLYURIA:</p>
                    <p class="text-normal_font">{{ ($riskassessment->polyuria ?? false) ? 'Yes' : 'No' }}</p>
                </div>

                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">POLYPHAGIA:</p>
                    <p class="text-normal_font">{{ ($riskassessment->polyphagia ?? false) ? 'Yes' : 'No' }}</p>
                </div>
                
                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">DATE TAKEN:</p>
                    <p class="text-normal_font">
                        @if($riskassessment->blood_sugar_date_taken)
                            {{ \Carbon\Carbon::parse($riskassessment->blood_sugar_date_taken)->format('F j, Y') }}
                        @else
                            --
                        @endif
                    </p>
                </div>
            </div>
        </div>
        {{-- Lipid Profile Card --}}
        <div class="bg-white rounded-xl py-8 px-6 sm:px-10 xl:px-12">
            <h2 class="text-xl font-semibold text-main_font mb-4">Lipid Profile</h2>
            <div class="grid grid-cols-1 slg2:grid-cols-2 gap-x-12 gap-y-6 text-xs">
                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">CHOLESTEROL:</p>
                    <p class="text-normal_font">{{ $riskassessment->total_cholesterol ?? '--' }}</p>
                </div>

                 <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">TRIGLYCERIDE:</p>
                    <p class="text-normal_font">{{ $riskassessment->triglyceride ?? '--' }}</p>
                </div>

                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">HDL:</p>
                    <p class="text-normal_font">{{ $riskassessment->hdl ?? '--' }}</p>
                </div>

                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">LDL:</p>
                    <p class="text-normal_font">{{ $riskassessment->ldl ?? '--' }}</p>
                </div>

                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">VLDL:</p>
                    <p class="text-normal_font">{{ $riskassessment->vldl ?? '--' }}</p>
                </div>
                
                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">DATE TAKEN:</p>
                    <p class="text-normal_font">
                        @if($riskassessment->lipid_profile_date_taken)
                            {{ \Carbon\Carbon::parse($riskassessment->lipid_profile_date_taken)->format('F j, Y') }}
                        @else
                            --
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mt-3">
        {{-- Urinalysis Card --}}
        <div class="bg-white rounded-xl py-8 px-6 sm:px-10 xl:px-12">
            <h2 class="text-xl font-semibold text-main_font mb-4">Urinalysis</h2>
            <div class="grid grid-cols-1 gap-y-4 text-xs">
                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">PROTEIN:</p>
                    <p class="text-normal_font">{{ $riskassessment->protein ?? '--' }}</p>
                </div>

                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">KETONES:</p>
                    <p class="text-normal_font">{{ $riskassessment->ketones ?? '--' }}</p>
                </div>

                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">DATE TAKEN:</p>
                    <p class="text-normal_font">
                        @if($riskassessment->urinalysis_date_taken)
                            {{ \Carbon\Carbon::parse($riskassessment->urinalysis_date_taken)->format('F j, Y') }}
                        @else
                            --
                        @endif
                    </p>
                </div>
            </div>
        </div>
        {{-- COPD Card --}}
        <div class="bg-white rounded-xl py-8 px-6 sm:px-10 xl:px-12">
            <h2 class="text-xl font-semibold text-main_font mb-4">Chronic Obstructive Pulmonary Disease</h2>
            <div class="grid grid-cols-1 gap-y-4 text-xs">
                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">BREATHLESSNESS:</p>
                    <p class="text-normal_font">{{ ($riskassessment->breathlessness ?? false) ? 'Yes' : 'No' }}</p>
                </div>

                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">CHRONIC COUGH:</p>
                    <p class="text-normal_font">{{ ($riskassessment->chronic_cough ?? false) ? 'Yes' : 'No' }}</p>
                </div>

                <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">SPUTUM (MUCOUS) PRODUCTION:</p>
                    <p class="text-normal_font">{{ ($riskassessment->sputum_production ?? false) ? 'Yes' : 'No' }}</p>
                </div>

                 <div class="grid grid-rows-2 md:grid-cols-2 md:grid-rows-1">
                    <p class="font-semibold text-main_font">WHEEZING:</p>
                    <p class="text-normal_font">{{ ($riskassessment->wheezing ?? false) ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>
    </div>
@else
    <p class="text-normal_font text-center mt-4">No risk assessment data available.</p>
@endif