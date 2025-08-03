<div id="qr-scanner-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black/50">
    
    <div class="relative w-full max-w-lg p-4">
        <div class="bg-white rounded-lg shadow-sm dark:bg-gray-700 py-10 px-6">
            <div class="flex flex-col items-center justify-center mb-6 relative">
                <h3 class="text-xl font-semibold text-main_font">Scan QR Code</h3>
                <p class="text-sm text-normal_font">Position the QR code in the frame to scan.</p>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <div id="reader" class="w-full h-auto rounded-lg overflow-hidden"></div>
                <p id="qr-status" class="text-sm text-center text-normal_font mt-4">Scanning...</p>
            </div>
            <div class="flex items-center border-t border-gray-200 dark:border-gray-600 gap-3 justify-end pt-6 px-6">
                <button id="cancel-qr-scan" type="button"
                    class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
