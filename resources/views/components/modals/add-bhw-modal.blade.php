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
