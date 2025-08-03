// QR Scanner Logic
document.addEventListener("DOMContentLoaded", function () {
    const addFamilyModal = document.getElementById('add-family-modal');
    const qrScannerModal = document.getElementById('qr-scanner-modal');
    const scanQrButton = document.getElementById('scan-qr-button');
    const cancelScanButton = document.getElementById('cancel-qr-scan');
    const closeScannerButton = qrScannerModal?.querySelector('[data-modal-hide="qr-scanner-modal"]');
    const qrReaderContainer = document.getElementById('reader');
    const qrStatus = document.getElementById('qr-status');
    const householdHeadInput = document.getElementById('enterHouseholdHead');

    let html5QrcodeScanner;

    function openQrScannerModal() {
        qrScannerModal?.classList.remove('hidden');
        qrStatus.textContent = 'Scanning...';

        html5QrcodeScanner = new Html5Qrcode('reader');

        html5QrcodeScanner.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            (decodedText) => {
                qrStatus.textContent = `Found: ${decodedText}`;
                householdHeadInput.value = decodedText;
                stopQrScanner();
                addFamilyModal?.classList.remove('hidden');
            },
            (errorMessage) => { }
        ).catch(err => {
            console.error("Failed to start scanner: ", err);
            qrStatus.textContent = 'Failed to start camera.';
        });
    }

    function stopQrScanner() {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                qrScannerModal?.classList.add('hidden');
                addFamilyModal?.classList.remove('hidden');
            }).catch(err => {
                console.error("Error stopping scanner: ", err);
            });
        } else {
            qrScannerModal?.classList.add('hidden');
            addFamilyModal?.classList.remove('hidden');
        }
    }

    scanQrButton?.addEventListener('click', openQrScannerModal);
    cancelScanButton?.addEventListener('click', stopQrScanner);
    closeScannerButton?.addEventListener('click', stopQrScanner);
});
