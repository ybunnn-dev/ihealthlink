// QR Scanner Logic
document.addEventListener("DOMContentLoaded", function () {
    const enrollResidentModal = document.getElementById('enroll-resident-modal');
    const qrScannerModal = document.getElementById('qr-scanner-modal');

    // Correct variable name
    let currentModal = 'non-modal'; 

    const findEnrolledQrButton = document.getElementById('find-enrolled-qr');
    const enrollScanQrButton = document.getElementById('enroll-scan-qr');

    const cancelScanButton = document.getElementById('cancel-qr-scan');
    const closeScannerButton = qrScannerModal?.querySelector('[data-modal-hide="qr-scanner-modal"]');
    const qrStatus = document.getElementById('qr-status');
    const householdHeadInput = document.getElementById('enterHouseholdHead');

    let html5QrcodeScanner;
    let isScanning = false; // Add a state flag

    function openQrScannerModal(moduleName) {
        if (moduleName === 'enrollment') {
            enrollResidentModal?.classList.add('hidden');
            // Correct variable name
            currentModal = 'enrollment';
        }

        qrScannerModal?.classList.remove('hidden');
        qrStatus.textContent = `Scanning for: ${moduleName}`;

        if (html5QrcodeScanner && isScanning) {
            html5QrcodeScanner.stop().catch(err => console.warn("Scanner already running, force stopping:", err));
        }

        html5QrcodeScanner = new Html5Qrcode('reader');
        isScanning = true; // Set flag to true when starting

        html5QrcodeScanner.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            (decodedText) => {
                console.log(`Scan completed for module: ${moduleName}`);
                qrStatus.textContent = `Found: ${decodedText}`;

                switch (moduleName) {
                    case 'find-enrolled':
                        console.log(`Found enrolled resident with ID: ${decodedText}`);
                        break;
                    case 'enrollment':
                        householdHeadInput.value = decodedText;
                        enrollResidentModal?.classList.remove('hidden');
                        break;
                }

                stopQrScanner();
            },
            (errorMessage) => { }
        ).catch(err => {
            console.error("Failed to start scanner: ", err);
            qrStatus.textContent = 'Failed to start camera. Please ensure camera access is granted.';
            isScanning = false; // Reset flag on failure to start
            qrScannerModal?.classList.add('hidden');
            // This line may be problematic if the calling context is not a modal. 
            // Consider removing or making conditional if it breaks other modules.
            enrollResidentModal?.classList.remove('hidden'); 
        });
    }

    function stopQrScanner() {
        if (html5QrcodeScanner && isScanning) { // Check the flag before attempting to stop
            html5QrcodeScanner.stop().then(() => {
                qrScannerModal?.classList.add('hidden');
                
                // Correct variable name
                switch(currentModal){ 
                    case 'enrollment':
                        enrollResidentModal?.classList.remove('hidden');
                        currentModal = 'non-modal';
                        break;
                    default:
                        console.log('No modal to open.');
                        currentModal = 'non-modal';
                        break;
                }
                isScanning = false; // Reset the flag after successful stop
            }).catch(err => {
                console.error("Error stopping scanner: ", err);
                isScanning = false; // Also reset on error
            });
        } else {
            // If scanner is not running, just hide the modal and reset state
            qrScannerModal?.classList.add('hidden');
            isScanning = false;
        }
    }

    function enrollScan() {
        openQrScannerModal('enrollment');
    }

    function enrolledScan() {
        openQrScannerModal('find-enrolled');
    }

    findEnrolledQrButton?.addEventListener('click', enrolledScan);
    enrollScanQrButton?.addEventListener('click', enrollScan);
    cancelScanButton?.addEventListener('click', stopQrScanner);
    closeScannerButton?.addEventListener('click', stopQrScanner);
});