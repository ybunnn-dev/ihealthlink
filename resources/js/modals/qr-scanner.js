// QR Scanner Logic
document.addEventListener("DOMContentLoaded", function () {
    const qrScannerModal = document.getElementById('qr-scanner-modal');
    const addHouseholdModal = document.getElementById('add-household-modal');
    const addFamilyModal = document.getElementById('add-family-modal');

    let currentModal = 'non-modal'; 

    const findEnrolledQrButton = document.getElementById('find-enrolled-qr');
    const findResidentQrButton = document.getElementById('find-resident-qr');
    const enrollScanQrButton = document.getElementById('c');
    const addHouseholdQr = document.getElementById('add-household-qr');
    const addFamilyQr = document.getElementById('add-family-qr');

    const cancelScanButton = document.getElementById('cancel-qr-scan');
    const closeScannerButton = qrScannerModal?.querySelector('[data-modal-hide="qr-scanner-modal"]');
    const qrStatus = document.getElementById('qr-status');

    const residentToEnrollInput = document.getElementById('enterResidentName');
    const householdHeadInput = document.getElementById('enterHouseholdHead');

    let html5QrcodeScanner;
    let isScanning = false; 

    function openQrScannerModal(moduleName) {
        // Correctly manage the state of the other modals
        switch(moduleName){
            case 'enrollment':
                currentModal = 'enrollment';
                //
                break;
            case 'find-household-head':
                currentModal = 'add-household-head';
                addHouseholdModal?.classList.add('hidden');
                addHouseholdModal?.setAttribute('aria-hidden', 'true');
                addHouseholdModal?.setAttribute('inert', ''); // This prevents focus from leaving the current modal
                break;
            case 'find-family-head':
                currentModal = 'add-family-head';
                addFamilyModal?.classList.add('hidden');
                addFamilyModal?.setAttribute('aria-hidden', 'true');
                addFamilyModal?.setAttribute('inert', '');
                break;
            default:
                console.log('non-modal');     
                break; 
        }

        qrScannerModal?.classList.remove('hidden');
        qrScannerModal?.removeAttribute('aria-hidden'); // The active modal must not be aria-hidden
        qrScannerModal?.removeAttribute('inert');

        qrStatus.textContent = `Scanning for: ${moduleName}`;

        if (html5QrcodeScanner && isScanning) {
            html5QrcodeScanner.stop().catch(err => console.warn("Scanner already running, force stopping:", err));
        }

        html5QrcodeScanner = new Html5Qrcode('reader');
        isScanning = true; 

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
                        residentToEnrollInput.value = decodedText;
                        break;
                    case 'find-household-head':
                        householdHeadInput.value = decodedText;
                        break;
                    case 'find-family-head':
                        familyHeadInput.value = decodedText;
                        break;
                    case 'find-resident':
                        console.log(decodedText);
                }

                stopQrScanner();
            },
            (errorMessage) => { }
        ).catch(err => {
            console.error("Failed to start scanner: ", err);
            qrStatus.textContent = 'Failed to start camera. Please ensure camera access is granted.';
            isScanning = false; 
            qrScannerModal?.classList.add('hidden');
            qrScannerModal?.setAttribute('aria-hidden', 'true');
            qrScannerModal?.setAttribute('inert', '');

            // Un-hide the original modal on error so the user isn't stuck
            switch(currentModal){
                case 'enrollment':
                    enrollResidentModal?.classList.remove('hidden');
                    enrollResidentModal?.removeAttribute('aria-hidden');
                    enrollResidentModal?.removeAttribute('inert');
                    break;
                case 'add-household-head':
                    addHouseholdModal?.classList.remove('hidden');
                    addHouseholdModal?.removeAttribute('aria-hidden');
                    addHouseholdModal?.removeAttribute('inert');
                    break;
            }
        });
    }

    function stopQrScanner() {
        if (html5QrcodeScanner && isScanning) {
            html5QrcodeScanner.stop().then(() => {
                qrScannerModal?.classList.add('hidden');
                qrScannerModal?.setAttribute('aria-hidden', 'true');
                qrScannerModal?.setAttribute('inert', '');
                
                switch(currentModal){ 
                    case 'enrollment':
                        enrollResidentModal?.classList.remove('hidden');
                        enrollResidentModal?.removeAttribute('aria-hidden');
                        enrollResidentModal?.removeAttribute('inert');
                        currentModal = 'non-modal';
                        break;
                    case 'add-household-head':
                        addHouseholdModal?.classList.remove('hidden');
                        addHouseholdModal?.removeAttribute('aria-hidden');
                        addHouseholdModal?.removeAttribute('inert');
                        currentModal = 'non-modal';
                        break;
                    case 'add-family-head':
                        addFamilyModal?.classList.remove('hidden');
                        addFamilyModal?.removeAttribute('aria-hidden');
                        addFamilyModal?.removeAttribute('inert');
                        currentModal = 'non-modal';
                        break;
                    default:
                        console.log('No modal to open.');
                        currentModal = 'non-modal';
                        break;
                }
                isScanning = false;
            }).catch(err => {
                console.error("Error stopping scanner: ", err);
                isScanning = false;
            });
        } else {
            qrScannerModal?.classList.add('hidden');
            qrScannerModal?.setAttribute('aria-hidden', 'true');
            isScanning = false;
        }
    }

    function enrollScan() {
        openQrScannerModal('enrollment');
    }

    function enrolledScan() {
        openQrScannerModal('find-enrolled');
    }
    
    function addHouseholdHeadQr(){
        openQrScannerModal('find-household-head');
    }
    function addFamilyHeadQr(){
        openQrScannerModal('find-family-head');
    }
    function findResident(){
        openQrScannerModal('find-resident');
    }

    findEnrolledQrButton?.addEventListener('click', enrolledScan);
    enrollScanQrButton?.addEventListener('click', enrollScan);
    cancelScanButton?.addEventListener('click', stopQrScanner);
    closeScannerButton?.addEventListener('click', stopQrScanner);
    addHouseholdQr?.addEventListener('click', addHouseholdHeadQr);
    addFamilyQr?.addEventListener('click', addFamilyHeadQr);
    findResidentQrButton?.addEventListener('click', findResident);
});