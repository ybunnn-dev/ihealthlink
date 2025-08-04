<div
    x-show="showBHW"
    x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-6 py-10"
    @click.self="showBHW = false"
>
  <!-- Modal Box -->
  <div class="bg-white rounded-xl shadow-lg mx-auto px-6 lg:px-12 py-10 flex flex-col">
    
    <!-- Grid container: head + filter/search + scrollable table + footer -->
    <div class="grid grid-rows-[auto_auto_1fr_auto] gap-3 h-full">
      
      <!-- Header -->
      <div>
        <h3 class="text-2xl font-semibold text-main_font text-center">Add BHW</h3>
        <p class="text-xs text-normal_font text-center mb-3">Please enter BHW details.</p>
      </div>
      <div class="grid grid-cols-1 gap-3 w-full max-w-lg justify-center">
          <div class="grid grid-cols-1 slg:grid-cols-2 col-span-1 gap-4">
              <div class="flex flex-col col-span-1">
                <label class="text-sm text-main_font font-medium">FIRST NAME</label>
                <input type="text" id="fName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
              </div>
             <div class="flex flex-col col-span-1">
                <label class="text-sm text-main_font font-medium">LAST NAME</label>
                <input type="text" id="fName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
              </div>
          </div>
          <div class="grid grid-cols-1 slg:grid-cols-2 col-span-1 gap-4">
            <!-- Middle Name Input -->
            <div class="flex flex-col col-span-1">
              <label class="text-sm text-main_font font-medium">MIDDLE NAME</label>
              <input type="text" id="middleName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
            </div>

            <!-- Prefix Dropdown -->
            <div class="flex flex-col col-span-1 relative">
              <label for="prefixDropdown" class="text-sm font-medium text-main_font">SUFFIX</label>
              <button id="prefixDropdown" data-dropdown-toggle="prefixDropdownMenu"
                class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                type="button">
                Select Prefix
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
                </svg>
              </button>

              <!-- Dropdown menu -->
              <div id="prefixDropdownMenu"
                class="z-10 hidden bg-f7 divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="prefixDropdown">
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Mr.</button></li>
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Mrs.</button></li>
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Ms.</button></li>
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Dr.</button></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-1 slg:grid-cols-2 col-span-1 gap-4">
            <!-- Middle Name Input -->
            <div class="flex flex-col col-span-1">
              <label class="text-sm text-main_font font-medium">BIRTHDATE</label> 
              <div class="relative max-w-sm">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                  <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                  </svg>
                </div>
                <input datepicker id="bhwBdate" data-date-picker-theme="light" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date">
              </div>
            </div>
            <div class="grid grid-cols-1 slg:grid-cols-3 gap-4">
              <!-- Sex Dropdown -->
              <div class="flex flex-col col-span-1">
                <label class="text-sm text-main_font font-medium">AGE</label>
                <input type="text" id="middleName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
              </div>
              <div class="flex flex-col col-span-2 relative">
                <label for="sexDropdown" class="text-sm font-medium text-main_font">SEX</label>
                <button id="sexDropdown" data-dropdown-toggle="sexDropdownMenu"
                  class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                  type="button">
                  Select Sex
                  <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 1 4 4 4-4" />
                  </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="sexDropdownMenu"
                  class="z-10 hidden bg-f7 divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                  <ul class="py-2 text-sm text-gray-700" aria-labelledby="prefixDropdown">
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Male</button></li>
                    <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Female</button></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-1 slg:grid-cols-2 col-span-1 gap-4">
            <!-- Civil Status Dropdown -->
            <div class="flex flex-col col-span-1 relative">
              <label for="civilStatusDropdown" class="text-sm font-medium text-main_font">CIVIL STATUS</label>
              <button id="civilStatusDropdown" data-dropdown-toggle="civilStatusMenu"
                class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                type="button">
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
                </svg>
              </button>
              <div id="civilStatusMenu"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="civilStatusDropdown">
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Single</button></li>
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Married</button></li>
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Widowed</button></li>
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Separated</button></li>
                </ul>
              </div>
            </div>

            <!-- Religion Dropdown -->
            <div class="flex flex-col col-span-1 relative">
              <label for="religionDropdown" class="text-sm font-medium text-main_font">RELIGION</label>
              <button id="religionDropdown" data-dropdown-toggle="religionMenu"
                class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between"
                type="button">
                Select
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
                </svg>
              </button>

              <div id="religionMenu"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="religionDropdown">
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Roman Catholic</button></li>
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Iglesia ni Cristo</button></li>
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Christian</button></li>
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Muslim</button></li>
                  <li><button type="button" class="w-full text-left px-4 py-2 hover:bg-gray-100">Others</button></li>
                </ul>
              </div>
            </div>
            
          </div>
          <div class="grid grid-cols-1 slg:grid-cols-3 col-span-1 gap-4">
            <div class="flex flex-col col-span-1">
              <label class="text-sm text-main_font font-medium">HOUSEHOLD NO.</label>
              <input type="text" id="houseNo" class="border border-gray-300 text-gray-700 rounded-lg p-2">
            </div>
            <div class="flex flex-col col-span-1">
              <label class="text-sm text-main_font font-medium">PUROK NO.</label>
              <input type="text" id="purokNo" class="border border-gray-300 text-gray-700 rounded-lg p-2">
            </div>
            <div class="flex flex-col col-span-1">
              <label class="text-sm text-main_font font-medium">CONTACT NO.</label>
              <input type="text" id="contactNo" class="border border-gray-300 text-gray-700 rounded-lg p-2">
            </div>
          </div>
        </div>
      </div>
      <!-- Buttons (footer) -->
      <div class="flex justify-end items-end pt-4">
        <div class="grid grid-cols-1 slg:grid-cols-5 gap-3 w-full max-w-xs">
          <button @click="showBHW = false"
            class="bg-transparent font-semibold text-mainblue border border-mainblue px-4 py-2 rounded-lg hover:bg-gray-200 transition col-span-1 slg:col-span-2 w-full">
            Close
          </button>
          <button
            class="bg-mainblue font-semibold text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition col-span-1 slg:col-span-3 w-full">
            Add BHW
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
