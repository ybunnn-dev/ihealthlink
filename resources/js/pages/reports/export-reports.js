
const exportBtn = document.getElementById('export-button');



exportBtn.addEventListener('click', function () {
    window.open('/barangay/reports/print-pdf', '_blank');
});