pdfjsLib.GlobalWorkerOptions.workerSrc =
"https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
// --- 1. ELEMENT SELECTORS ---
const exportBtn = document.getElementById('export-button');
const allRadioButtons = document.querySelectorAll('input[name="export_as"]');
const pdfRadio = document.getElementById('pdf-radio');

// Viewer elements
const viewerContainer = document.getElementById('viewer-container');
const previewPlaceholder = document.getElementById('preview-placeholder');

// Pagination elements
const pdfViewer = document.getElementById('pdf-viewer');

// All other form inputs
const allFilterInputs = [
    document.getElementById('report-source'),
    document.getElementById('from-date'),
    document.getElementById('to-date')
];


let pdfDoc = null;
let currentPageNum = 1;
let pageIsRendering = false;
let pageNumIsPending = null;
const renderScale = 1.5;

// --- 3. PDF RENDERING LOGIC ---

/**
 * Renders a specific page of the loaded PDF onto the canvas.
 */
const renderPage = num => {
    pageIsRendering = true;
    // Get page
    pdfDoc.getPage(num).then(page => {
        // Set the canvas size to match the PDF page size
        const viewport = page.getViewport({ scale: renderScale });
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        // Render the page
        const renderContext = { canvasContext: ctx, viewport: viewport };
        page.render(renderContext).promise.then(() => {
            pageIsRendering = false;
            // If another page was requested while this one was rendering, render it now
            if (pageNumIsPending !== null) {
                renderPage(pageNumIsPending);
                pageNumIsPending = null;
            }
        });
        // Update page indicator
        pageNumSpan.textContent = num;
    });
};


/**
 * Fetches and loads the PDF document from the server.
 */
const updatePdfPreview = () => {
    if (!pdfRadio.checked) return;

    // Get all current form values
    const reportSource = parseInt(document.getElementById('report-source').value);
    const fromDate = document.getElementById('from-date').value;
    const toDate = document.getElementById('to-date').value;

    // Build the URL for the preview route
    const baseUrl = '/reports/preview-community-report';
    const queryParams = new URLSearchParams({
         startDate: fromDate, endDate: toDate
    }).toString();
    const fullUrl = `${baseUrl}?${queryParams}`;

    console.log('Loading PDF from:', fullUrl);

    previewPlaceholder.innerHTML = '<span class="text-gray-400">Loading preview...</span>';

    pdfjsLib.getDocument(fullUrl).promise.then(pdf => {
        pdfDoc = pdf;

        // Clear old canvases
        pdfViewer.innerHTML = '';

        previewPlaceholder.classList.add('hidden');
        pdfViewer.classList.remove('hidden');

        // Render all pages
        for (let i = 1; i <= pdfDoc.numPages; i++) {
            pdfDoc.getPage(i).then(page => {
                const containerWidth = pdfViewer.clientWidth; // available width
                const viewport = page.getViewport({ scale: 1 }); // base viewport (scale=1)

                // Calculate scale so page width fits container width
                const scale = containerWidth / viewport.width;
                const scaledViewport = page.getViewport({ scale });

                // Create canvas for each page
                const pageCanvas = document.createElement('canvas');
                pageCanvas.classList.add('mb-4', 'shadow', 'border', 'rounded-md', 'bg-white');
                const ctx = pageCanvas.getContext('2d');

                // Apply scaled size
                pageCanvas.height = scaledViewport.height;
                pageCanvas.width = scaledViewport.width;

                // Append canvas
                pdfViewer.appendChild(pageCanvas);

                // Render page into canvas
                page.render({ canvasContext: ctx, viewport: scaledViewport });
            });
        }

    }).catch(err => {
        console.error("Error loading PDF:", err);
        previewPlaceholder.classList.remove('hidden');
        previewPlaceholder.innerHTML = '<span class="text-red-400">Failed to load preview.</span>';
    });
};
// --- 4. EVENT LISTENERS ---

// Listen for changes on the "Export As" radio buttons
allRadioButtons.forEach(radio => {
    radio.addEventListener('change', event => {
        if (event.target.value === 'pdf') {
            updatePdfPreview();
        } else {
            // If CSV or Excel, hide the viewer and show the placeholder
            pdfViewer.innerHTML = '';
            previewPlaceholder.innerHTML = '<span class="text-gray-400">Preview is only available for PDF</span>';
            previewPlaceholder.classList.remove('hidden');
            canvas.classList.add('hidden');
            paginationControls.classList.add('hidden');
            pdfDoc = null; // Clear the loaded PDF
        }
    });
});

// Listen for changes on filters to auto-update the preview
allFilterInputs.forEach(input => input.addEventListener('change', updatePdfPreview));

// Final Export button logic
exportBtn.addEventListener('click', () => {
    const selectedFormat = document.querySelector('input[name="export_as"]:checked')?.value;
    if (!selectedFormat) {
        alert('Please select an export format.');
        return;
    }

    const reportSource = document.getElementById('report-source').value;
    const fromDate = document.getElementById('from-date').value;
    const toDate = document.getElementById('to-date').value;

    let baseUrl = '';
    switch (selectedFormat) {
        case 'pdf': baseUrl = '/barangay/reports/community-report-pdf'; break;
        case 'csv': baseUrl = '/barangay/reports/export-csv'; break;
        case 'excel': baseUrl = '/barangay/reports/export-excel'; break;
    }

    const queryParams = new URLSearchParams({
        startDate: fromDate, endDate: toDate
    }).toString();

    window.open(`${baseUrl}?${queryParams}`, '_blank');

});
