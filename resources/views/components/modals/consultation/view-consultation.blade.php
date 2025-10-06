<!-- Main modal -->
<div id="view-consultation-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-normal_font py-10 px-6">
            <!-- Modal header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-6">
                <h3 id="view-consultation-title" class="text-xl font-semibold text-main_font">
                    Consultation Details
                </h3>
                <p id="view-consultation-schedule" class="text-sm text-normal_font">Scheduled for: --</p>
            </div>
            
            <!-- Modal body -->
            <div class="px-4 md:px-5 h-full max-h-[60vh] overflow-y-auto scrollbar-thin space-y-6">
                <!-- Top Info Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="font-semibold text-main_font mb-3">Status</p>
                        <p id="view-consultation-status" class="text-normal_font capitalize">—</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="font-semibold text-main_font mb-3">Date Completed</p>
                        <p id="view-consultation-completed" class="text-normal_font">—</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="font-semibold text-main_font mb-3">Updated By</p>
                        <p id="view-consultation-updated-by" class="text-normal_font">—</p>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="vitals-tab" data-tabs-target="#vitals" type="button" role="tab" aria-controls="vitals" aria-selected="true">Vitals & Information</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="medicines-tab" data-tabs-target="#medicines" type="button" role="tab" aria-controls="medicines" aria-selected="false">Medicines Distributed</button>
                        </li>
                    </ul>
                </div>
                <div id="myTabContent">
                    <!-- Vitals and Info Tab Content -->
                    <div class="hidden p-4 rounded-lg bg-gray-50 space-y-4" id="vitals" role="tabpanel" aria-labelledby="vitals-tab">
                       <div class="grid grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-3 text-sm">
                            <div><strong class="font-medium text-main_font">Weight:</strong> <span id="view-weight"></span></div>
                            <div><strong class="font-medium text-main_font">Height:</strong> <span id="view-height"></span></div>
                            <div><strong class="font-medium text-main_font">Temperature:</strong> <span id="view-temperature"></span></div>
                            <div><strong class="font-medium text-main_font">Blood Pressure:</strong> <span id="view-bp"></span></div>
                            <div><strong class="font-medium text-main_font">Pulse Rate:</strong> <span id="view-pr"></span></div>
                            <div><strong class="font-medium text-main_font">Respiratory Rate:</strong> <span id="view-rr"></span></div>
                            <div><strong class="font-medium text-main_font">Birthweight:</strong> <span id="view-birthweight"></span></div>
                            <div><strong class="font-medium text-main_font">PhilHealth:</strong> <span id="view-philhealth"></span></div>
                            <div class="col-span-2 md:col-span-3 pt-2"><strong class="font-medium text-main_font">Father's Name:</strong> <span id="view-father-name"></span></div>
                            <div class="col-span-2 md:col-span-3"><strong class="font-medium text-main_font">Mother's Name:</strong> <span id="view-mother-name"></span></div>
                       </div>
                       <hr class="border-gray-200"/>
                       <div class="space-y-3 text-sm">
                            <div>
                                <strong class="font-medium text-main_font">Chief Complaint</strong>
                                <p id="view-chief-complaint" class="mt-1 text-normal_font bg-white p-3 rounded-md min-h-[4rem]"></p>
                            </div>
                            <div>
                                <strong class="font-medium text-main_font">Treatment / Plan</strong>
                                <p id="view-treatment" class="mt-1 text-normal_font bg-white p-3 rounded-md min-h-[4rem]"></p>
                            </div>
                       </div>
                    </div>
                    <!-- Medicines Tab Content -->
                    <div class="hidden p-4 rounded-lg bg-gray-50" id="medicines" role="tabpanel" aria-labelledby="medicines-tab">
                        <div id="view-medicine-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            <!-- JS will populate this with cards -->
                        </div>
                    </div>
                </div>
            </div>
             <!-- Modal footer -->
             <div class="flex items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 pt-6 px-6">
                <button id="close-view-consultation" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Close</button>
            </div>
        </div>
    </div>
</div>

