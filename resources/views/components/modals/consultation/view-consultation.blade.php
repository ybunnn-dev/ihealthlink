<div id="view-consultation-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl dark:bg-normal_font w-full flex flex-col max-h-[90vh] transition-transform duration-300 ease-out scale-95">
            <div class="flex flex-col items-center justify-center rounded-t p-6 border-b border-gray-200 shrink-0 dark:border-gray-700">
                <h3 id="view-consultation-title" class="text-xl md:text-2xl font-semibold text-main_font">
                    Consultation Details
                </h3>
                <p id="view-consultation-schedule" class="text-sm text-normal_font mt-1">Scheduled for: --</p>
            </div>
            <div class="p-6 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                
                <!-- Top Info Section (Stacks on mobile, 3 cols on desktop) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm mb-6">
                    <div class="p-3 bg-gray-50 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                        <p class="font-semibold text-main_font mb-1 dark:text-white">Status</p>
                        <p id="view-consultation-status" class="text-normal_font capitalize dark:text-gray-300">—</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                        <p class="font-semibold text-main_font mb-1 dark:text-white">Date Completed</p>
                        <p id="view-consultation-completed" class="text-normal_font dark:text-gray-300">—</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg dark:bg-gray-700 dark:text-gray-200">
                        <p class="font-semibold text-main_font mb-1 dark:text-white">Updated By</p>
                        <p id="view-consultation-updated-by" class="text-normal_font dark:text-gray-300">—</p>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li class="me-2 flex-grow sm:flex-grow-0" role="presentation">
                            <button class="inline-block w-full sm:w-auto p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 focus:outline-none" id="vitals-tab" data-tabs-target="#vitals" type="button" role="tab" aria-controls="vitals" aria-selected="true">Vitals & Information</button>
                        </li>
                        <li class="me-2 flex-grow sm:flex-grow-0" role="presentation">
                            <button class="inline-block w-full sm:w-auto p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 focus:outline-none" id="medicines-tab" data-tabs-target="#medicines" type="button" role="tab" aria-controls="medicines" aria-selected="false">Medicines Distributed</button>
                        </li>
                    </ul>
                </div>
                <div id="myTabContent">
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-700 space-y-6" id="vitals" role="tabpanel" aria-labelledby="vitals-tab">
                       <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-4 text-sm dark:text-gray-200">
                            <div><strong class="font-medium text-main_font dark:text-white block mb-1">Weight:</strong> <span id="view-weight" class="text-normal_font dark:text-gray-300"></span></div>
                            <div><strong class="font-medium text-main_font dark:text-white block mb-1">Height:</strong> <span id="view-height" class="text-normal_font dark:text-gray-300"></span></div>
                            <div><strong class="font-medium text-main_font dark:text-white block mb-1">Temperature:</strong> <span id="view-temperature" class="text-normal_font dark:text-gray-300"></span></div>
                            <div><strong class="font-medium text-main_font dark:text-white block mb-1">Blood Pressure:</strong> <span id="view-bp" class="text-normal_font dark:text-gray-300"></span></div>
                            <div><strong class="font-medium text-main_font dark:text-white block mb-1">Pulse Rate:</strong> <span id="view-pr" class="text-normal_font dark:text-gray-300"></span></div>
                            <div><strong class="font-medium text-main_font dark:text-white block mb-1">Respiratory Rate:</strong> <span id="view-rr" class="text-normal_font dark:text-gray-300"></span></div>
                            <div><strong class="font-medium text-main_font dark:text-white block mb-1">Birthweight:</strong> <span id="view-birthweight" class="text-normal_font dark:text-gray-300"></span></div>
                            <div><strong class="font-medium text-main_font dark:text-white block mb-1">PhilHealth:</strong> <span id="view-philhealth" class="text-normal_font dark:text-gray-300"></span></div>
                            
                            <!-- Parents span wider on larger screens -->
                            <div class="col-span-1 sm:col-span-2 md:col-span-3 pt-2 border-t border-gray-200 dark:border-gray-600 mt-2"></div>
                            
                            <div class="col-span-1 sm:col-span-2 md:col-span-1"><strong class="font-medium text-main_font dark:text-white block mb-1">Father's Name:</strong> <span id="view-father-name" class="text-normal_font dark:text-gray-300"></span></div>
                            <div class="col-span-1 sm:col-span-2 md:col-span-1"><strong class="font-medium text-main_font dark:text-white block mb-1">Mother's Name:</strong> <span id="view-mother-name" class="text-normal_font dark:text-gray-300"></span></div>
                       </div>
                       
                       <hr class="border-gray-200 dark:border-gray-600"/>
                       
                       <!-- Notes Section -->
                       <div class="space-y-4 text-sm">
                            <div>
                                <strong class="font-medium text-main_font dark:text-white block mb-2">Chief Complaint</strong>
                                <p id="view-chief-complaint" class="text-normal_font bg-white p-4 rounded-md border border-gray-200 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200 min-h-[4rem]"></p>
                            </div>
                            <div>
                                <strong class="font-medium text-main_font dark:text-white block mb-2">Treatment / Plan</strong>
                                <p id="view-treatment" class="text-normal_font bg-white p-4 rounded-md border border-gray-200 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200 min-h-[4rem]"></p>
                            </div>
                       </div>
                    </div>
                    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-700" id="medicines" role="tabpanel" aria-labelledby="medicines-tab">
                        <div id="view-medicine-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            <div class="col-span-full text-center text-gray-500 py-4 italic" id="no-medicines-placeholder">No medicines recorded for this consultation.</div>
                        </div>
                    </div>
                </div>
            </div>

             <!-- Footer (Fixed) -->
             <div class="flex items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 p-6 shrink-0">
                <button id="close-view-consultation" type="button" 
                    class="w-full sm:w-auto py-3 px-6 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>