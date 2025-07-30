<div
    x-show="showModal"
    x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-6 py-10"
    @click.self="showModal = false"
>
<!-- Modal Box -->
<div class="bg-white rounded-xl shadow-lg w-full max-w-6xl h-[85vh] mx-auto px-6 lg:px-10 py-10 flex flex-col">
  
  <!-- Grid container: head + filter/search + scrollable table + footer -->
  <div class="grid grid-rows-[auto_auto_1fr_auto] gap-3 h-full">
    
    <!-- Header -->
    <div>
      <h3 class="text-2xl font-semibold text-main_font text-center">Switch Program</h3>
      <p class="text-xs text-normal_font text-center mb-5">To continue, please select the health program you wish to transfer to.</p>
      <hr class="border-gray-200 border-t-[0.05rem] mb-5 mt-2">
    </div>

    <!-- Search & Filter Section -->
    <div class="flex flex-col slg2:flex-row slg2:items-end gap-4 mb-3">
      <!-- Search -->
      <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
        <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for residents</label>
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <!-- Icon -->
            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
          </div>
          <input type="search" id="default-search"
            class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Search..." />
        </div>
      </div>

      <!-- Filter -->
      <div class="w-full xs:w-48">
        <label for="filterDropdown" class="mb-2 text-sm font-medium text-main_font">Filter by</label>
            <button id="filterDropdown" data-dropdown-toggle="filterDropdownMenu"
            class="w-full text-main_font bg-[#F7F7F7] font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]"
            type="button">
            Alphabetical
            <svg class="w-2.5 h-2.5 ms-3" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
            </button>
        </div>
        <div class="w-full xs:w-48">
        <label for="filterDropdown" class="mb-2 text-sm font-medium text-main_font">Program Type</label>
            <button id="filterDropdown" data-dropdown-toggle="filterDropdownMenu"
            class="w-full text-main_font bg-[#F7F7F7] font-medium border border-navboard rounded-lg text-sm px-4 py-2 text-center inline-flex items-center justify-between h-[2.375rem]"
            type="button">
            Alphabetical
            <svg class="w-2.5 h-2.5 ms-3" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
            </svg>
            </button>
        </div>
    </div>

    <!-- Scrollable Table -->
    <div class="overflow-y-auto">
      <table class="w-full text-sm text-left text-main_font">
        <thead class="text-xs text-main_font uppercase bg-col_tab_h">
          <tr>
            <th class="px-6 py-3">PROGRAM ID</th>
            <th class="px-6 py-3">PROGRAM NAME</th>
            <th class="px-6 py-3">ENROLLED RESIDENTS</th>
            <th class="px-6 py-3">PROGRAM TYPE</th>
          </tr>
        </thead>
        <tbody>
          <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">121</th>
                                    <td class="px-6 py-4">Anti Tetanus</td>
                                    <td class="px-6 py-4">200</td>
                                    <td class="px-6 py-4">Vaccination</td>
                                    
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">122</th>
                                    <td class="px-6 py-4">National Immunization</td>
                                    <td class="px-6 py-4">11</td>
                                    <td class="px-6 py-4">Vaccination</td>
                                    
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">123</th>
                                    <td class="px-6 py-4">Tuberculosis Control</td>
                                    <td class="px-6 py-4">23</td>
                                    <td class="px-6 py-4">Gen Consultation</td>
                                    
                                </tr>
                                <tr class="bg-white border-b text-normal_font hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">124</th>
                                    <td class="px-6 py-4">HIV/AIDS and STI Prevention</td>
                                    <td class="px-6 py-4">199</td>
                                    <td class="px-6 py-4">Vaccination</td>
                                </tr>
        </tbody>
      </table>
    </div>

    <!-- Buttons (footer) -->
    <div class="flex justify-end items-end pt-4">
      <div class="grid grid-cols-1 slg:grid-cols-5 gap-3 w-full max-w-xs">
        <button @click="showModal = false"
          class="bg-transparent font-semibold text-mainblue border border-mainblue px-4 py-2 rounded-lg hover:bg-gray-200 transition col-span-1 slg:col-span-2 w-full">
          Close
        </button>
        <button
          class="bg-mainblue font-semibold text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition col-span-1 slg:col-span-3 w-full">
          Change Program
        </button>
      </div>
    </div>

  </div>
</div>

</div>
