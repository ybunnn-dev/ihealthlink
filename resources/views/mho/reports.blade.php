@section('page-id', 'reports')
@section('title', 'Reports')
<x-app-layout>
    <div class="py-12 px-5">
        <script>
            // Basic counts
            window.residents = @json($residents);
            window.families = @json($families);
            window.households = @json($households);
            
            // Age group data (municipality-wide)
            window.ageGroups = @json($ageGroups);
            window.maleData = @json($maleData);
            window.femaleData = @json($femaleData);
            
            // Per barangay data
            window.barangays = @json($barangays);
            window.householdsPerBarangay = @json($householdsPerBarangay);
            window.familiesPerBarangay = @json($familiesPerBarangay);
            window.families4PsPerBarangay = @json($families4PsPerBarangay);
            window.familiesIndigentPerBarangay = @json($familiesIndigentPerBarangay);
            
            // Per barangay detailed statistics
            window.residentsPerBarangay = @json($residentsPerBarangay);
            window.malesPerBarangay = @json($malesPerBarangay);
            window.femalesPerBarangay = @json($femalesPerBarangay);
            window.pwdsPerBarangay = @json($pwdsPerBarangay);
            window.nonPwdsPerBarangay = @json($nonPwdsPerBarangay);
            window.malePwdsPerBarangay = @json($malePwdsPerBarangay);
            window.femalePwdsPerBarangay = @json($femalePwdsPerBarangay);
            window.wraPerBarangay = @json($wraPerBarangay);
            window.ageGroupMalePerBarangay = @json($ageGroupMalePerBarangay);
            window.ageGroupFemalePerBarangay = @json($ageGroupFemalePerBarangay);
            window.malePerAgePerBarangay = @json($malePerAgePerBarangay);
            window.femalePerAgePerBarangay = @json($femalePerAgePerBarangay);
            window.pregnantPerBarangay = @json($pregnantPerBarangay);
            window.lactatingPerBarangay = @json($lactatingPerBarangay);
            
            // Municipality-wide statistics
            window.seniors = @json($seniors);
            window.wra = @json($wra);
            window.wasteDisposal = @json($wasteDisposal);
            window.waterSource = @json($waterSource);
            window.sanitaryData = @json($sanitaryData);
            
            // Health program statistics
            window.pregnantWomen = @json($pregnantWomen);
            window.teenPregnancies = @json($teenPregnancies);
            window.totalLactating = @json($totalLactating);
            window.primis = @json($primis);
            window.multiPara = @json($multiPara);
            window.pregnancyOthers = @json($pregnancyOthers);
            
            window.familyPlanningEnrollees = @json($familyPlanningEnrollees);
            window.familyPlanningMethods = @json($familyPlanningMethods);
            
            window.totalChildrenEnrolled = @json($totalChildrenEnrolled);
            window.ficCount = @json($ficCount);
            window.cicCount = @json($cicCount);
            window.childrenWithWeightHeight = @json($childrenWithWeightHeight);
            window.normalWeight = @json($normalWeight);
            window.underweight = @json($underweight);
            window.severelyUnderweight = @json($severelyUnderweight);
            window.overweight = @json($overweight);
            window.obese = @json($obese);
        </script>
        
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <!-- Title -->
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Reports</h1>
            
            <!-- Upper Card -->
            <div class="bg-white rounded-xl overflow-hidden p-6 mb-3">
                <div class="grid grid-cols-1 lg2:grid-cols-7 xl:items-end gap-4">
                    <div class="grid grid-cols-1 slg2:grid-cols-3 items-end col-span-1 lg:col-span-3 gap-3"> 
                        <div class="w-full col-span-1">
                            <button id="filterDate" class="w-full text-mainblue bg-[#F7F7F7] focus:outline-none font-medium border border-mainblue rounded-lg hover:border-white hover:bg-nav_active text-sm px-4 py-2 inline-flex items-center justify-center h-[2.375rem]" type="button">
                                Filter Date
                            </button>
                        </div>
                        
                        <div class="w-full col-span-1">
                            <button id="clearFilter" class="w-full text-white bg-mainblue focus:outline-none font-medium border border-mainblue rounded-lg hover:border-white hover:bg-nav_active text-sm px-4 py-2 inline-flex items-center justify-center h-[2.375rem] transition-opacity" type="button">
                                Clear Filters
                            </button>
                        </div>

                        <div class="w-full col-span-1">
                            <button type="button" data-modal-target="print-report-modal" data-modal-toggle="print-report-modal" class="w-full h-[2.37rem] text-white bg-maingreen hover:bg-blue-700 font-medium rounded-lg text-sm">Export</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <x-report-blades.mho-reports 
                :residents="$residents"
                :households="$households"
                :families="$families"
                :ageGroups="$ageGroups"
                :maleData="$maleData"
                :femaleData="$femaleData"
                :barangays="$barangays"
                :householdsPerBarangay="$householdsPerBarangay"
                :familiesPerBarangay="$familiesPerBarangay"
                :families4PsPerBarangay="$families4PsPerBarangay"
                :familiesIndigentPerBarangay="$familiesIndigentPerBarangay"
                :residentsPerBarangay="$residentsPerBarangay"
                :malesPerBarangay="$malesPerBarangay"
                :femalesPerBarangay="$femalesPerBarangay"
                :pwdsPerBarangay="$pwdsPerBarangay"
                :nonPwdsPerBarangay="$nonPwdsPerBarangay"
                :malePwdsPerBarangay="$malePwdsPerBarangay"
                :femalePwdsPerBarangay="$femalePwdsPerBarangay"
                :wraPerBarangay="$wraPerBarangay"
                :ageGroupMalePerBarangay="$ageGroupMalePerBarangay"
                :ageGroupFemalePerBarangay="$ageGroupFemalePerBarangay"
                :malePerAgePerBarangay="$malePerAgePerBarangay"
                :femalePerAgePerBarangay="$femalePerAgePerBarangay"
                :pregnantPerBarangay="$pregnantPerBarangay"
                :lactatingPerBarangay="$lactatingPerBarangay"
                :seniors="$seniors"
                :wra="$wra"
                :wasteDisposal="$wasteDisposal"
                :waterSource="$waterSource"
                :sanitaryData="$sanitaryData"
                :pregnantWomen="$pregnantWomen"
                :teenPregnancies="$teenPregnancies"
                :totalLactating="$totalLactating"
                :primis="$primis"
                :multiPara="$multiPara"
                :pregnancyOthers="$pregnancyOthers"
                :familyPlanningEnrollees="$familyPlanningEnrollees"
                :familyPlanningMethods="$familyPlanningMethods"
                :totalChildrenEnrolled="$totalChildrenEnrolled"
                :ficCount="$ficCount"
                :cicCount="$cicCount"
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
</x-app-layout>
@include('components.modals.print-report-modal')
@include('components.modals.reports.filter-date')
