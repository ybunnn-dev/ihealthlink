@section('page-id', 'reports')
@section('title', 'Reports')
<x-app-layout>
    <div class="py-12 px-5">
          <script>
            // Basic counts
            window.residents = @json($residents);
            window.families = @json($families);
            window.households = @json($households);
                  
            // Age group data (barangay-wide)
            window.ageGroups = @json($ageGroups);
            window.maleData = @json($maleData);
            window.femaleData = @json($femaleData);
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
            <x-report-blades.mho-reports 
                :residents="$residents"
                :households="$households"
                :families="$families"
                :age-groups="$ageGroups"
            />
        
        </div>
    </div>
</x-app-layout>
