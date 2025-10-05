@section('page-id', 'reports')
@section('title', 'Reports')
<x-app-layout>
    <div class="py-12 px-5">
        <script>
            // Expose PHP variables to JS
            window.residents = @json($residents);
            window.families = @json($families);
            window.households = @json($households);
            // Per purok data
            window.residentsPerPurok = @json($residentsPerPurok);
            window.householdsPerPurok = @json($householdsPerPurok);
            window.familiesPerPurok = @json($familiesPerPurok);
            window.families4PsPerPurok = @json($families4PsPerPurok);
            window.familiesIndigentPerPurok = @json($familiesIndigentPerPurok);

            //  Age group data
            window.ageGroups = @json($ageGroups);
            window.maleData = @json($maleData);
            window.femaleData = @json($femaleData);

            window.malesPerPurok = @json($malesPerPurok);
            window.femalesPerPurok = @json($femalesPerPurok);

            window.pwdsPerPurok = @json($pwdsPerPurok);
            window.nonPwdsPerPurok = @json($nonPwdsPerPurok);

            window.waterSource = @json($waterSource);
            window.wasteDisposal = @json($wasteDisposal);
            window.sanitaryData = @json($sanitaryData);
            window.programId = @json($programId);
        </script>
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <!-- Title -->
            <h1 class="text-3xl font-semibold text-sub_blue mb-3">Reports</h1>
            <!-- Upper Card -->
            <div class="bg-white rounded-xl overflow-hidden p-6 mb-3">
                <div class="grid grid-cols-1 lg2:grid-cols-7 xl:items-end gap-4">
                    <div class="col-span-1 lg:col-span-3">
                        <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for Reports</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" id="default-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search..."/>
                        </div>
                    </div>
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
            <div class="mb-3">
                <x-reports-tab></x-reports-tab>
            </div>
           <div>
                <x-report-blades.demographical-data 
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
                />
            </div>
        </div>
    </div>
</x-app-layout>
@include('components.modals.print-report-modal')







