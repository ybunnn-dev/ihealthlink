@section('page-id', 'brgy-reports')
@section('title', 'Reports')
<x-app-layout>
    <div class="py-12 px-5">
        <script>
            // Basic counts
            window.residents = @json($residents);
            window.families = @json($families);
            window.households = @json($households);
            
            // Per purok demographic data
            window.residentsPerPurok = @json($residentsPerPurok);
            window.householdsPerPurok = @json($householdsPerPurok);
            window.familiesPerPurok = @json($familiesPerPurok);
            window.families4PsPerPurok = @json($families4PsPerPurok);
            window.familiesIndigentPerPurok = @json($familiesIndigentPerPurok);
            
            // Gender per purok
            window.malesPerPurok = @json($malesPerPurok);
            window.femalesPerPurok = @json($femalesPerPurok);
            
            // PWD data per purok
            window.pwdsPerPurok = @json($pwdsPerPurok);
            window.nonPwdsPerPurok = @json($nonPwdsPerPurok);
            window.malePwdsPerPurok = @json($malePwdsPerPurok);
            window.femalePwdsPerPurok = @json($femalePwdsPerPurok);
            
            // Age group data (barangay-wide)
            window.ageGroups = @json($ageGroups);
            window.maleData = @json($maleData);
            window.femaleData = @json($femaleData);
            
            // Age group data per purok
            window.ageGroupMalePerPurok = @json($ageGroupMalePerPurok);
            window.ageGroupFemalePerPurok = @json($ageGroupFemalePerPurok);
            window.maleAgePerPurok = @json($maleAgePerPurok);
            window.femaleAgePerPurok = @json($femaleAgePerPurok);
            
            // Sanitary data
            window.waterSource = @json($waterSource);
            window.wasteDisposal = @json($wasteDisposal);
            window.sanitaryData = @json($sanitaryData);
            
            // Women's health data per purok
            window.wraPerPurok = @json($wraPerPurok);
            window.pregnantPerPurok = @json($pregnantPerPurok);
            window.lactatingPerPurok = @json($lactatingPerPurok);
            
            // Women's health data (barangay-wide)
            window.wra = @json($wra);
            window.pregnantWomen = @json($pregnantWomen);
            window.teenPregnancies = @json($teenPregnancies);
            window.totalLactating = @json($totalLactating);
             
            window.primis = @json($primis);
            window.multiPara = @json($multiPara);
            window.pregnancyOthers = @json($pregnancyOthers);
 
            
            // Family planning data
            window.familyPlanningMethods = @json($familyPlanningMethods);
            window.totalFamilyPlanningEnrollees = @json($totalFamilyPlanningEnrollees);
            
            // Child healthcare data
            window.totalChildrenEnrolled = @json($totalChildrenEnrolled);
            window.ficCount = @json($ficCount);
            window.cicCount = @json($cicCount);
            window.childrenWithWeightHeight = @json($childrenWithWeightHeight);
            window.normalWeight = @json($normalWeight);
            window.underweight = @json($underweight);
            window.severelyUnderweight = @json($severelyUnderweight);
            window.overweight = @json($overweight);
            window.obese = @json($obese);
            
            // Senior citizens data
            window.seniors = @json($seniors);
            
            // Purok list
            window.puroks = @json($puroks);
            
        </script>

        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <!-- Title -->
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Reports</h1>
            <!-- Upper Card -->
            <div class="bg-white rounded-xl overflow-hidden p-6 mb-3">
                <div class="grid grid-cols-1 lg2:grid-cols-7 xl:items-end gap-4">
                   <div class="grid grid-cols-1 slg2:grid-cols-2 items-end col-span-1 lg:col-span-2 gap-3"> 
                        <div class="w-full col-span-1" >
                            <button id="filterDate" class="w-full text-mainblue bg-[#F7F7F7] focus:outline-none font-medium border border-mainblue rounded-lg hover:border-white hover:bg-nav_active text-sm px-4 py-2 inline-flex items-center justify-center h-[2.375rem]" type="button">
                                Filter Date
                            </button>
                        </div>

                        <div class="w-full col-span-1">
                            <button type="button" data-modal-target="print-report-modal" data-modal-toggle="print-report-modal" class="w-full h-[2.37rem] text-white bg-mainblue hover:bg-blue-700 font-medium rounded-lg text-sm">Export</button>
                        </div>
                        
                    </div>
                </div>
            </div>
           <div>
                <x-report-blades.demographical-data 
                    :puroks="$puroks"
                    :residents="$residents"
                    :households="$households"
                    :families="$families"
                    :residents-per-purok="$residentsPerPurok"
                    :households-per-purok="$householdsPerPurok"
                    :families-per-purok="$familiesPerPurok"
                    :families4-ps-per-purok="$families4PsPerPurok"
                    :families-indigent-per-purok="$familiesIndigentPerPurok"
                    :age-groups="$ageGroups"
                    :male-data="$maleData"
                    :female-data="$femaleData"
                    :males-per-purok="$malesPerPurok"
                    :females-per-purok="$femalesPerPurok"
                    :pwds-per-purok="$pwdsPerPurok"
                    :non-pwds-per-purok="$nonPwdsPerPurok"
                    :male-pwds-per-purok="$malePwdsPerPurok"
                    :female-pwds-per-purok="$femalePwdsPerPurok"
                    :waste-disposal="$wasteDisposal"
                    :water-source="$waterSource"
                    :sanitary-data="$sanitaryData"
                    :wra-per-purok="$wraPerPurok"
                    :pregnant-per-purok="$pregnantPerPurok"
                    :lactating-per-purok="$lactatingPerPurok"
                    :family-planning-enrollees="$totalFamilyPlanningEnrollees"
                    :family-planning-methods="$familyPlanningMethods"
                    :child-weight-height="$childrenWithWeightHeight"
                    :total-children-enrolled="$totalChildrenEnrolled"
                    :normal-weight="$normalWeight"
                    :underweight="$underweight"
                    :severely-underweight="$severelyUnderweight"
                    :overweight="$overweight"
                    :obese="$obese"
                />
            </div>
        </div>
    </div>
</x-app-layout>
@include('components.modals.print-report-modal')
@include('components.modals.reports.filter-date')







