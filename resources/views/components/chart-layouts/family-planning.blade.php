<div class="grid grid-cols-span-1 xl:grid-cols-6 gap-3 mb-3">
    <div class="flex flex-col gap-3 gap-3 col-span-2">
        <div class="bg-white rounded-xl shadow-sm px-6 py-8">
            <div class="flex items-center justify-center xl:justify-start gap-8 xl:gap-8 pl-4">
                <svg class="text-wood_or w-12 h-12" fill="currentColor" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 98.666 98.666" xml:space="preserve">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier"> 
                        <g> 
                            <g> 
                                <circle cx="49.332" cy="53.557" r="10.297"></circle> 
                                <path d="M53.7,64.556h-8.737c-7.269,0-13.183,5.916-13.183,13.184v10.688l0.027,0.166l0.735,0.229 c6.937,2.168,12.965,2.892,17.927,2.892c9.688,0,15.303-2.764,15.65-2.938l0.688-0.351l0.071,0.002V77.739 C66.883,70.472,60.971,64.556,53.7,64.556z"></path> 
                                <circle cx="28.312" cy="23.563" r="16.611"></circle> 
                                <path d="M70.35,40.174c9.174,0,16.609-7.44,16.609-16.613c0-9.17-7.438-16.609-16.609-16.609c-9.176,0-16.61,7.437-16.61,16.609 S61.174,40.174,70.35,40.174z"></path> 
                                <path d="M41.258,62.936c-2.637-2.274-4.314-5.632-4.314-9.378c0-4.594,2.519-8.604,6.243-10.743 c-2.425-0.965-5.061-1.511-7.826-1.511H21.266C9.54,41.303,0,50.847,0,62.571v17.241l0.043,0.269L1.23,80.45 c10.982,3.432,20.542,4.613,28.458,4.656v-7.367C29.688,70.595,34.623,64.599,41.258,62.936z"></path> 
                                <path d="M77.398,41.303H63.305c-2.765,0-5.398,0.546-7.824,1.511c3.727,2.139,6.246,6.147,6.246,10.743 c0,3.744-1.678,7.102-4.313,9.376c2.656,0.661,5.101,2.02,7.088,4.008c2.888,2.89,4.479,6.726,4.478,10.8v7.365 c7.916-0.043,17.477-1.225,28.457-4.656l1.187-0.369l0.044-0.269V62.571C98.664,50.847,89.124,41.303,77.398,41.303z"></path> 
                            </g> 
                        </g> 
                    </g>
                </svg>
                <div class="flex flex-col">
                    <h1 class="text-wood_or text-lg slg3:text-xl xl3:text-3xl font-bold mt-2">5,201</h1>
                    <p class="text-wood_or text-xs -mt-1 slg3:text-fluid-xxs xl:text-xs 2xl:text-xs">Family Planning</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 px-10 h-80">
            <h3 class="text-lg font-semibold text-main_font">Enrolled v Non-Enrolled</h3>
            <div class="flex items-center justify-center h-full">
                <canvas id="famPlan" class="w-full h-full"></canvas>
            </div>
        </div>
         <div class="bg-white rounded-xl shadow-sm p-6 h-96 overflow-y-auto">
            <h3 class="text-lg font-semibold text-main_font mb-4">Method Breakdown</h3>

            <table class="min-w-full text-sm text-left text-gray-700 rounded">
                <thead class="text-xs text-gray-500 uppercase border-b bg-gray-100">
                    <tr>
                        <th class="py-2 px-4">Method</th>
                        <th class="py-2 px-4">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="py-2 px-4">Pills</td>
                        <td class="py-2 px-4">12</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-4">IUD</td>
                        <td class="py-2 px-4">8</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-4">Condom</td>
                        <td class="py-2 px-4">15</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-4">Implant</td>
                        <td class="py-2 px-4">5</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-2 px-4">Injection</td>
                        <td class="py-2 px-4">10</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-4">Natural</td>
                        <td class="py-2 px-4">6</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 col-span-1 xl:col-span-4">
        <h3 class="text-lg font-semibold text-main_font mb-4">Family Planning Methods</h3>
        <canvas id="radarChart" class="w-full h-full"></canvas>
    </div>
</div>
