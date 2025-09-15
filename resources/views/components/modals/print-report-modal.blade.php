<div id="print-report-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-gray-900/50">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-800 py-8 px-10">
            <div class="flex flex-col items-center justify-center rounded-t mb-6  border-b border-gray-200 rounded-b dark:border-gray-600 pb-6">
                <h3 class="text-xl font-semibold text-main_font dark:text-white">
                    Export Data
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Enter resident details to continue</p>
            </div>

            <div class="max-h-[70vh] overflow-y-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-10">

                    <div class="md:col-span-2 flex flex-col h-full">
                        <div class="flex-grow flex items-center justify-center border-2 border-dashed rounded-lg h-96 md:h-full dark:border-gray-600">
                             <span class="text-gray-400">Preview Section</span>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <button type="button" class="p-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                &lt;
                            </button>
                             <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Page 1</span>
                            <button type="button" class="p-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                &gt;
                            </button>
                        </div>
                    </div>

                    <div class="md:col-span-3 space-y-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-main_font dark:text-white">Export As:</label>
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <input id="pdf-radio" type="radio" value="pdf" name="export_as" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="pdf-radio" class="ms-2 text-sm font-medium text-main_font dark:text-gray-300">PDF</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="csv-radio" type="radio" value="csv" name="export_as" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="csv-radio" class="ms-2 text-sm font-medium text-main_font dark:text-gray-300">CSV</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="excel-radio" type="radio" value="excel" name="export_as" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="excel-radio" class="ms-2 text-sm font-medium text-main_font dark:text-gray-300">EXCEL</label>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="coverage" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Coverage</label>
                                <select id="coverage" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option>Year 2022</option>
                                    <option>Year 2023</option>
                                    <option>Year 2024</option>
                                </select>
                            </div>
                             <div>
                                <label for="report-source" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Report Source</label>
                                <input type="text" id="report-source" placeholder="Choose..." class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="from-date" class="block mb-2 text-sm font-medium text-main_font dark:text-white">From</label>
                                <input type="date" id="from-date" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                             <div>
                                <label for="to-date" class="block mb-2 text-sm font-medium text-main_font dark:text-white">To</label>
                                <input type="date" id="to-date" class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                        </div>

                        <div>
                            <label for="color-selection" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Color Selection</label>
                            <div id="color-selection" class="grid w-full h-auto grid-cols-8 gap-3 p-4 bg-gray-50 border border-gray-300 rounded-lg md:grid-cols-10 place-items-center dark:bg-gray-700 dark:border-gray-600">
                                
                                <button aria-label="Select color slate" class="w-8 h-8 transition-transform transform bg-slate-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color stone" class="w-8 h-8 transition-transform transform bg-stone-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-stone-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color red" class="w-8 h-8 transition-transform transform bg-red-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color orange" class="w-8 h-8 transition-transform transform bg-orange-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color amber" class="w-8 h-8 transition-transform transform bg-amber-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color yellow" class="w-8 h-8 transition-transform transform bg-yellow-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color lime" class="w-8 h-8 transition-transform transform bg-lime-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color green" class="w-8 h-8 transition-transform transform bg-green-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color emerald" class="w-8 h-8 transition-transform transform bg-emerald-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color teal" class="w-8 h-8 transition-transform transform bg-teal-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color cyan" class="w-8 h-8 transition-transform transform bg-cyan-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color sky" class="w-8 h-8 transition-transform transform bg-sky-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color blue" class="w-8 h-8 transition-transform transform bg-blue-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color indigo" class="w-8 h-8 transition-transform transform bg-indigo-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color violet" class="w-8 h-8 transition-transform transform bg-violet-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color purple" class="w-8 h-8 transition-transform transform bg-purple-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color fuchsia" class="w-8 h-8 transition-transform transform bg-fuchsia-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color pink" class="w-8 h-8 transition-transform transform bg-pink-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color rose" class="w-8 h-8 transition-transform transform bg-rose-300 rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                                <button aria-label="Select color white" class="w-8 h-8 transition-transform transform bg-white border rounded-full cursor-pointer hover:scale-110 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:focus:ring-offset-gray-700"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end border-t border-gray-200 rounded-b dark:border-gray-600 gap-3 pt-6 mt-6">
                <button id="cancel-button" data-modal-hide="print-report-modal" type="button" class="py-2.5 px-5 text-sm font-medium text-main_font focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                <button id="export-button" type="button" class="text-white bg-mainblue hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Export</button>
            </div>
        </div>
    </div>
</div>