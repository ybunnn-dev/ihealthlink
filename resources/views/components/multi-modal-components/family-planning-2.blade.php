<div id="family-planning-step-2">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <div class="md:col-span-2">
            <label for="fp_resident_name" class="block mb-2 text-sm font-medium text-main_font">Selected Resident</label>
            <input type="text" name="fp_resident_name" id="fp_resident_name" 
                   class="border border-gray-300 text-main_font text-sm rounded-lg bg-gray-50 block w-full p-2.5 cursor-not-allowed" 
                   placeholder="Resident's full name will appear here" disabled readonly>
        </div>

        <div>
            <label for="fp_client_type" class="block mb-2 text-sm font-medium text-main_font">Type of Client <span class="text-red-500">*</span></label>
            <select id="fp_client_type" name="fp_client_type" class="border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Choose a type</option>
                <option value="new_acceptor">New Acceptor</option>
                <option value="current_user">Current User</option>
                <option value="other_acceptor">Other Acceptor</option>
                <option value="changing_method">Changing Method</option>
                <option value="changing_clinic">Changing Clinic</option>
                <option value="restarter">Restarter</option>
            </select>
        </div>

        <div>
            <label for="fp_source" class="block mb-2 text-sm font-medium text-main_font">Source<span class="text-red-500">*</span></label>
            <select id="fp_source" name="fp_source" class="border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Choose a source</option>
                <option value="public">Public</option>
                <option value="private">Private</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <label for="fp_previous_method" class="block mb-2 text-sm font-medium text-main_font">Previous Method Used (i even tried doing this but this won't show)<span class="text-red-500">*</span></label>
            <select id="fp_previous_method" name="fp_previous_method" class="border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">Choose a previous method if any</option>
                <option value="btl">Female Sterilization (BTL)</option>
                <option value="nsv">Male Sterilization (NSV)</option>
                <option value="condom">Condom</option>
                <option value="pills_pop">Pills - Progestin-Only Pills (POP)</option>
                <option value="pills_coc">Pills - Combined Oral Contraceptives (COC)</option>
                <option value="injection">Injection (DMPA or CIC)</option>
                <option value="implant">Implant</option>
                <option value="iud_interval">IUD - Interval</option>
                <option value="iud_postpartum">IUD - Postpartum</option>
            </select>
        </div>
    </div>
</div>