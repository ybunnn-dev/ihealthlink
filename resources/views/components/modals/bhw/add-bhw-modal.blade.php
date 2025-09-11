<div id="add-bhw-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full px-6 py-10">
  <div class="bg-white rounded-xl shadow-lg mx-auto px-6 lg:px-12 py-10 flex flex-col relative">

    <form id="addBhwForm" class="grid grid-rows-[auto_1fr_auto] gap-3 h-full">

      <div>
        <h3 class="text-2xl font-semibold text-main_font text-center">Add BHW</h3>
        <p class="text-xs text-gray-500 text-center mb-3">Please enter BHW details.</p>
      </div>

      <div class="grid grid-cols-1 gap-y-4 w-full max-w-lg justify-center">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="flex flex-col">
            <label for="bhwFirstName" class="text-sm text-main_font font-medium">FIRST NAME</label>
            <input type="text" id="bhwFirstName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
          </div>
          <div class="flex flex-col">
            <label for="bhwLastName" class="text-sm text-main_font font-medium">LAST NAME</label>
            <input type="text" id="bhwLastName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="flex flex-col">
            <label for="bhwMiddleName" class="text-sm text-main_font font-medium">MIDDLE NAME</label>
            <input type="text" id="bhwMiddleName" class="border border-gray-300 text-gray-700 rounded-lg p-2">
          </div>
          <div class="flex flex-col relative">
            <label for="suffixDropdownButton" class="text-sm font-medium text-main_font">SUFFIX</label>
            <button id="suffixDropdownButton" data-dropdown-toggle="suffixDropdownMenu" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
              <span>Select Suffix</span> 
              <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <div id="suffixDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
              <ul class="py-2 text-sm text-gray-700" aria-labelledby="suffixDropdownButton">
                <li data-value=""><a href="#" class="block px-4 py-2 text-gray-500 hover:bg-gray-100">Clear Selection</a></li>
                <li data-value="Jr."><a href="#" class="block px-4 py-2 hover:bg-gray-100">Jr.</a></li>
                <li data-value="Sr."><a href="#" class="block px-4 py-2 hover:bg-gray-100">Sr.</a></li>
                <li data-value="III"><a href="#" class="block px-4 py-2 hover:bg-gray-100">III</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="flex flex-col">
            <label for="bhwBirthdate" class="text-sm text-main_font font-medium">BIRTHDATE</label>
            <div class="relative max-w-sm">
              <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                </svg>
              </div>
              <input datepicker id="bhwBirthdate" type="text" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date">
            </div>
          </div>
          <div class="flex flex-col">
            <label for="bhwAge" class="text-sm text-main_font font-medium">AGE</label>
            <input type="text" id="bhwAge" class="border border-gray-300 text-gray-700 rounded-lg p-2" readonly>
          </div>
          <div class="flex flex-col relative">
            <label for="sexDropdownButton" class="text-sm font-medium text-main_font">SEX</label>
            <button id="sexDropdownButton" data-dropdown-toggle="sexDropdownMenu" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
              <span>Select Sex</span> 
              <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <div id="sexDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
              <ul class="py-2 text-sm text-gray-700" aria-labelledby="sexDropdownButton">
                <li data-value=""><a href="#" class="block px-4 py-2 text-gray-500 hover:bg-gray-100">Clear Selection</a></li>
                <li data-value="Male"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Male</a></li>
                <li data-value="Female"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Female</a></li>
              </ul>
            </div>
          </div>
          <div class="flex flex-col relative">
            <label for="privilegeDropdownButton" class="text-sm font-medium text-main_font">Privilege</label>
            <button id="privilegeDropdownButton" data-dropdown-toggle="privilegeDropdownMenu" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
              <span>Select Sex</span> 
              <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <div id="privilegeDropdownMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
              <ul class="py-2 text-sm text-gray-700" aria-labelledby="privilegeDropdownButton">
                <li data-value=""><a href="#" class="block px-4 py-2 text-gray-500 hover:bg-gray-100">Clear Selection</a></li>
                <li data-value="3"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Regular Access</a></li>
                <li data-value="4"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Web Access</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="flex flex-col relative">
            <label for="civilStatusDropdownButton" class="text-sm font-medium text-main_font">CIVIL STATUS</label>
            <button id="civilStatusDropdownButton" data-dropdown-toggle="civilStatusMenu" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
              <span>Select Civil Status</span> 
              <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <div id="civilStatusMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
              <ul class="py-2 text-sm text-gray-700" aria-labelledby="civilStatusDropdownButton">
                <li data-value=""><a href="#" class="block px-4 py-2 text-gray-500 hover:bg-gray-100">Clear Selection</a></li>
                <li data-value="Single"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Single</a></li>
                <li data-value="Married"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Married</a></li>
                <li data-value="Widowed"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Widowed</a></li>
                <li data-value="Separated"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Separated</a></li>
              </ul>
            </div>
          </div>
          <div class="flex flex-col relative">
            <label for="religionDropdownButton" class="text-sm font-medium text-main_font">RELIGION</label>
            <button id="religionDropdownButton" data-dropdown-toggle="religionMenu" class="w-full text-main_font bg-white focus:outline-none font-medium border border-gray-300 rounded-lg text-md p-2 text-center inline-flex items-center justify-between" type="button">
              <span>Select Religion</span> 
              <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <div id="religionMenu" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full absolute top-full mt-1">
              <ul class="py-2 text-sm text-gray-700" aria-labelledby="religionDropdownButton">
                <li data-value=""><a href="#" class="block px-4 py-2 text-gray-500 hover:bg-gray-100">Clear Selection</a></li>
                <li data-value="Roman Catholic"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Roman Catholic</a></li>
                <li data-value="Iglesia ni Cristo"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Iglesia ni Cristo</a></li>
                <li data-value="Born Again Christian"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Born Again</a></li>
                <li data-value="Islam"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Islam</a></li>
                <li data-value="Others"><a href="#" class="block px-4 py-2 hover:bg-gray-100">Others</a></li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="flex flex-col">
            <label for="bhwEmail" class="text-sm text-main_font font-medium">EMAIL ADDRESS</label>
            <input type="email" id="bhwEmail" class="border border-gray-300 text-gray-700 rounded-lg p-2">
          </div>
          <div class="flex flex-col">
            <label for="bhwContactNo" class="text-sm text-main_font font-medium">CONTACT NO.</label>
            <input type="tel" id="bhwContactNo" class="border border-gray-300 text-gray-700 rounded-lg p-2">
          </div>
        </div>
      </div>

      <div class="flex justify-end items-end pt-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3 w-full max-w-xs">
          <button id="addBhwCloseButton" type="button" data-modal-hide="add-bhw-modal" class="bg-transparent font-semibold text-mainblue border border-mainblue px-4 py-2 rounded-lg hover:bg-gray-200 transition col-span-1 md:col-span-2 w-full">
            Close
          </button>
          <button 
              id="addBhwSubmitButton" 
              type="submit" 
              form="addBhwForm" 
              class="bg-mainblue hover:bg-blue-800 disabled:bg-gray-400 disabled:cursor-not-allowed font-semibold text-white px-4 py-2 rounded-lg transition col-span-1 md:col-span-3 w-full"
              disabled>
              Add BHW
          </button>
        </div>
      </div>

    </form>
  </div>
</div>
@include('components.modals.bhw.add-bhw-confirmation')