<div id="switchProgramModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 flex justify-center items-center z-50 px-6 py-10 transition-opacity duration-400 ease-out opacity-0">

  <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl h-[85vh] mx-auto px-6 lg:px-10 py-10 flex flex-col transition-transform duration-300 ease-out scale-95">

    <div class="grid grid-rows-[auto_auto_1fr_auto] gap-3 h-full">

      <div>
        <h3 class="text-2xl font-semibold text-main_font text-center">Switch Program</h3>
        <p class="text-xs text-normal_font text-center mb-5">To continue, please select the health program you wish to transfer to.</p>
        <hr class="border-gray-200 border-t-[0.05rem] mb-5 mt-2">
      </div>

      <div class="flex flex-col slg2:flex-row slg2:items-end gap-4 mb-3">
        <div class="w-full slg2:w-64 slg2:flex-grow slg2:max-w-md">
          <label for="default-search" class="mb-2 text-sm font-medium text-main_font">Search for residents</label>
          <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
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
        <div class="w-full xs:w-48">
            <label for="programTypeSelect" class="mb-2 text-sm font-medium text-main_font">Program Type</label>
            <select id="programTypeSelect"
              class="block w-full text-main_font bg-[#F7F7F7] border border-navboard rounded-lg text-sm px-3 py-0 focus:ring-blue-500 focus:border-blue-500 h-[2.375rem]">
              
              <!-- Optional: Add a placeholder -->
              <option selected>Select a type</option>
              
              <option value="philpen_tcl">Philpen</option>
              <option value="child_healthcare_tcl">Child Healthcare</option>
              <option value="vaccination_drive">Vaccination Drive</option>
              <option value="senior_citizen">Senior Citizen</option>
              <option value="maternal_health_tcl">Maternal Healthcare</option>
              <option value="general_consultation">General Consultation</option>
            </select>
        </div>
      </div>

     <div id="programs-section" class="overflow-y-auto bg-bg_col rounded-md scrollbar-thin border border-dashed border-gray-400">
        <div class="grid grid-cols-1 gap-4 p-2">
 
  
 
          </div>
      </div>

      <div class="flex justify-end items-end pt-4">
        <div class="grid grid-cols-1 slg:grid-cols-5 gap-3 w-full max-w-xs">
          <button type="button" id="close-change-program"
            class="bg-transparent font-semibold text-mainblue border border-mainblue px-4 py-2 rounded-lg hover:bg-gray-200 transition col-span-1 slg:col-span-2 w-full">
            Close
          </button>
          <button type="button" id="change-program-btn"
            class="bg-mainblue font-semibold text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition col-span-1 slg:col-span-3 w-full">
            Change Program
          </button>
        </div>
      </div>
    </div> 
  </div> 
</div>
@include('components.modals.health-program.program-confirmation')