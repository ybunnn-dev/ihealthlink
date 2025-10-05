<div id="print-report-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-gray-900/50">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-800 py-8 px-10">
            <div class="flex flex-col items-center justify-center rounded-t mb-6  border-b border-gray-200 rounded-b dark:border-gray-600 pb-6">
                <h3 class="text-xl font-semibold text-main_font dark:text-white">
                    Export Data
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Enter resident details to continue</p>
            </div>

            <div class="max-h-[90vh] px-4">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-10">

                    <div class="md:col-span-3 flex flex-col">
                        <div id="preview-container" class="relative flex-grow border-2 min-h-0 h-[60vh] border-dashed rounded-lg overflow-y-auto overflow-x-hidden scrollbar-thin dark:border-gray-600">
                            <div id="preview-placeholder" class="flex items-center justify-center w-full h-full">
                                <span class="text-gray-400">Select PDF to preview report</span>
                            </div>
                            <div id="pdf-viewer" class="hidden flex flex-col items-center"></div>
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

                        <div class="grid grid-cols-1 gap-4">
                             <div>
                                <label for="report-source" class="block mb-2 text-sm font-medium text-main_font dark:text-white">Report Source</label>
                                <input type="text" disabled id="report-source" placeholder="Choose..." class="bg-gray-50 border border-gray-300 text-main_font text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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