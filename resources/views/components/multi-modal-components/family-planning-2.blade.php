<div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-1">
    
    <div class="md:col-span-2">
      <label for="fp_resident_name" class="block mb-2 text-sm font-medium text-main_font">Selected Resident</label>
      <input type="text" name="fp_resident_name" id="fp_resident_name" 
             class="bg-gray-100 border border-gray-300 text-main_font text-sm rounded-lg block w-full p-3 cursor-not-allowed" 
             placeholder="Resident's full name" disabled readonly value="">
    </div>

    <div>
      <label for="fp_client_type_button" class="block mb-2 text-sm font-medium text-main_font">Type of Client <span class="text-red-500">*</span></label>
      <input type="hidden" id="fp_client_type">
      <button id="fp_client_type_button" data-dropdown-toggle="fp_client_type_dropdown" data-dropdown-placement="bottom-start" type="button"
        class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 text-left flex justify-between items-center">
        <span id="fp_client_type_label">Choose a type</span>
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
      </button>
      <div id="fp_client_type_dropdown" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-xl w-auto border border-gray-200">
        <ul class="py-2 text-sm text-gray-700" id="fp_client_type_options">
          <li><button type="button" data-value="new_acceptor" class="block w-full text-left px-4 py-2 hover:bg-gray-100">New Acceptor</button></li>
          <li><button type="button" data-value="current_user" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Current User</button></li>
          <li><button type="button" data-value="other_acceptor" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Other Acceptor</button></li>
          <li><button type="button" data-value="changing_method" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Changing Method</button></li>
          <li><button type="button" data-value="changing_clinic" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Changing Clinic</button></li>
          <li><button type="button" data-value="restarter" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Restarter</button></li>
        </ul>
      </div>
    </div>

    <div>
      <label for="fp_source_button" class="block mb-2 text-sm font-medium text-main_font">Source <span class="text-red-500">*</span></label>
      <input type="hidden" id="fp_source">
      <button id="fp_source_button" data-dropdown-toggle="fp_source_dropdown" data-dropdown-placement="bottom-start" type="button"
        class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 text-left flex justify-between items-center">
        <span id="fp_source_label">Choose a source</span>
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
      </button>
      <div id="fp_source_dropdown" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-xl w-auto border border-gray-200">
        <ul class="py-2 text-sm text-gray-700" id="fp_source_options">
          <li><button type="button" data-value="public" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Public</button></li>
          <li><button type="button" data-value="private" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Private</button></li>
        </ul>
      </div>
    </div>

    <div class="md:col-span-2">
      <label for="fp_previous_method_button" class="block mb-2 text-sm font-medium text-main_font">Previous Method Used <span class="text-red-500">*</span></label>
      <input type="hidden" id="fp_previous_method">
      <button id="fp_previous_method_button" data-dropdown-toggle="fp_previous_method_dropdown" data-dropdown-placement="bottom-start" type="button"
        class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3 text-left flex justify-between items-center">
        <span id="fp_previous_method_label">Choose a previous method if any</span>
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
      </button>
      <div id="fp_previous_method_dropdown" class="z-20 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-xl w-auto border border-gray-200 max-h-60 overflow-y-auto">
        <ul class="py-2 text-sm text-gray-700" id="fp_previous_method_options">
          <li><button type="button" data-value="btl" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Female Sterilization (BTL)</button></li>
          <li><button type="button" data-value="nsv" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Male Sterilization (NSV)</button></li>
          <li><button type="button" data-value="condom" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Condom</button></li>
          <li><button type="button" data-value="pills_pop" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Pills - Progestin-Only Pills (POP)</button></li>
          <li><button type="button" data-value="pills_coc" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Pills - Combined Oral Contraceptives (COC)</button></li>
          <li><button type="button" data-value="injection" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Injection (DMPA or CIC)</button></li>
          <li><button type="button" data-value="implant" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Implant</button></li>
          <li><button type="button" data-value="iud_interval" class="block w-full text-left px-4 py-2 hover:bg-gray-100">IUD - Interval</button></li>
          <li><button type="button" data-value="iud_postpartum" class="block w-full text-left px-4 py-2 hover:bg-gray-100">IUD - Postpartum</button></li>
        </ul>
      </div>
    </div>
</div>