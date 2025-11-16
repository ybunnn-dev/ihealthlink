<div id="view-log-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full transition-opacity duration-400 ease-out opacity-0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm py-10 px-6 transition-transform duration-300 ease-out scale-95">
            <!-- Modal header -->
            <div class="flex flex-col items-center justify-center rounded-t mb-6 text-center">
                <h3 class="text-xl font-semibold text-main_font">
                    Activity Log Details
                </h3>
                <p class="text-sm text-normal_font">Detailed information about the recorded activity.</p>
            </div>
            
            <!-- Modal body -->
            <div class="px-4 md:px-5 space-y-6">
                <!-- Log Info Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="font-semibold text-main_font mb-2">User</p>
                        <p id="view-log-user" class="text-normal_font">—</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="font-semibold text-main_font mb-2">Role</p>
                        <p id="view-log-role" class="text-normal_font capitalize">—</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg col-span-1 md:col-span-2">
                        <p class="font-semibold text-main_font mb-2">Date & Time of Activity</p>
                        <p id="view-log-datetime" class="text-normal_font">—</p>
                    </div>
                </div>

                <!-- Activity Description Section -->
                <div class="text-sm">
                    <strong class="font-medium text-main_font">Activity Description</strong>
                    <p id="view-log-activity" class="mt-2 text-normal_font bg-gray-50 p-3 rounded-md min-h-[6rem]"></p>
                </div>
            </div>
             <!-- Modal footer -->
             <div class="flex items-center justify-end border-t border-gray-200 rounded-b mt-6 pt-6 px-6">
                <button id="close-view-log-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100">Close</button>
            </div>
        </div>
    </div>
</div>
